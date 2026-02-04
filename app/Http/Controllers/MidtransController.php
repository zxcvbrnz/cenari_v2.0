<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pembayaran;
use App\Models\Peserta;

class MidtransController extends Controller
{
    public function callback(Request $request)
    {
        $serverKey = env('MIDTRANS_SERVER_KEY');
        $hashed = hash("sha512", $request->order_id . $request->status_code . $request->gross_amount . $serverKey);

        if ($hashed == $request->signature_key) {
            if ($request->transaction_status == 'capture' || $request->transaction_status == 'settlement') {

                // Ambil ID peserta dari Order ID (format: PAY-timestamp-ID)
                $orderParts = explode('-', $request->order_id);
                $pesertaId = end($orderParts);

                // 2. Update status pembayaran di tabel peserta
                $peserta = Peserta::where(column: 'order_id', $request->order_id)->first();
                $totalHutang = 500000; // Sesuaikan
                $sudahBayar = Pembayaran::where('id_peserta', $pesertaId)->sum('jumlah_dibayar');

                if ($sudahBayar >= $totalHutang) {
                    $peserta->update(['status_pembayaran' => 'Lunas']);
                } else {
                    $peserta->update(['status_pembayaran' => 'Belum Lunas']);
                }
            }
        }
    }
}
