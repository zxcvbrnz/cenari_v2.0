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
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = env('MIDTRANS_IS_PRODUCTION', false);

        try {
            $notification = new Notification();
            $orderId = $notification->order_id;
            $status = $notification->transaction_status;

            // Cari berdasarkan order_id
            $pembayaran = Pembayaran::where('order_id', $orderId)->first();

            if (!$pembayaran) {
                return Response::json(['message' => 'Order tidak ditemukan'], 404);
            }

            // Logika Update Status
            $newStatus = match ($status) {
                'capture', 'settlement' => 'paid',
                'pending'              => 'pending',
                'deny', 'expire', 'cancel' => 'failed',
                default                => 'pending'
            };

            $pembayaran->update([
                'status' => $newStatus
            ]);

            return Response::json(['message' => 'Status Updated']);
        } catch (\Exception $e) {
            return Response::json(['error' => $e->getMessage()], 500);
        }
    }
}
