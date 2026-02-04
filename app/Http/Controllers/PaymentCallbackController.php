<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Models\Pembayaran;
use Midtrans\Config;
use Midtrans\Notification;

class PaymentCallbackController extends Controller
{
    public function callback(Request $request)
    {
        $serverKey = env('MIDTRANS_SERVER_KEY');
        $signatureKey = hash(
            "sha512",
            $request->order_id .
                $request->status_code .
                $request->gross_amount .
                $serverKey
        );
        if ($signatureKey !== $request->signature_key) {
            return response()->json(['message' => 'Invalid signature key'], 403);
        }
        $transaction = Pembayaran::where('order_id', $request->order_id);
        if (!$transaction) {
            return response()->json(['message' => 'Transaction not found'], 404);
        }
        // Update status berdasarkan notifikasi
        if (in_array($request->transaction_status, ['settlement', 'capture'])) {
            $transaction->status = 'paid';
        } elseif (in_array($request->transaction_status, ['cancel', 'expire'])) {
            $transaction->status = 'failed';
        } elseif ($request->transaction_status == 'pending') {
            $transaction->status = 'pending';
        }
        $transaction->save();
        return response()->json(['message' => 'Webhook processed successfully'], 200);
    }
}
