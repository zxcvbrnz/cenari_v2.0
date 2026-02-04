<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pembayaran;
use Illuminate\Support\Facades\Log;

class PaymentCallbackController extends Controller
{
    public function callback(Request $request)
    {
        // 1. Validasi Signature Key (Sangat Bagus Anda Menambahkan Ini)
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

        // 2. Ambil Data (TAMBAHKAN ->first())
        $transaction = Pembayaran::where('order_id', $request->order_id)->first();

        if (!$transaction) {
            return response()->json(['message' => 'Transaction not found'], 404);
        }

        // 3. Logika Update Status
        $status = $request->transaction_status;

        if (in_array($status, ['settlement', 'capture'])) {
            $transaction->status = 'paid';
        } elseif (in_array($status, ['cancel', 'expire', 'deny'])) {
            $transaction->status = 'failed';
        } elseif ($status == 'pending') {
            $transaction->status = 'pending';
        }

        // 4. Simpan Perubahan
        $transaction->save();

        return response()->json(['message' => 'Webhook processed successfully'], 200);
    }
}
