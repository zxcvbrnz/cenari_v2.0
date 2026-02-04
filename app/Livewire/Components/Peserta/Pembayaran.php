<?php

namespace App\Livewire\Components\Peserta;

use Livewire\Component;
use Midtrans\Config;
use Midtrans\Snap;
use App\Models\Pembayaran as PembayaranModel;

class Pembayaran extends Component
{
    public function bayar()
    {
        $peserta = auth()->user()->peserta;
        $harga = $peserta->mapel->harga;
        // Pastikan hanya menghitung yang sudah sukses/paid jika ingin sisa tagihan akurat
        $totalTerbayar = $peserta->pembayaran->where('status', 'paid')->sum('jumlah_dibayar');
        $sisaTagihan = $harga - $totalTerbayar;

        if ($sisaTagihan <= 0) {
            $this->dispatch('alert-fail', message: 'Tagihan Anda sudah lunas.');
            return;
        }

        // Konfigurasi Midtrans
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = env('MIDTRANS_IS_PRODUCTION', false);
        Config::$isSanitized = true;
        Config::$is3ds = true;

        $orderId = 'PAY-' . time() . '-' . $peserta->id;

        $params = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => (int) $sisaTagihan,
            ],
            'customer_details' => [
                'first_name' => auth()->user()->name,
                'email' => auth()->user()->email,
            ],
        ];

        try {
            $snapToken = Snap::getSnapToken($params);

            // CATAT ke riwayat pembayaran dengan status pending
            $peserta->pembayaran()->create([
                'id_peserta'       => auth()->user()->peserta->id,
                'order_id'       => $orderId,
                'jumlah_dibayar' => $sisaTagihan,
                'tanggal_dibayar' => now(),
                'deskripsi'      => '-',
                'status'      => 'pending',
            ]);

            // Livewire 3 menggunakan sintaks array untuk dispatch
            $this->dispatch('payWithMidtrans', snapToken: $snapToken);
        } catch (\Exception $e) {
            $this->dispatch('alert-fail', message: 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function render()
    {
        // Ambil riwayat terbaru
        $riwayat = auth()->user()->peserta->pembayaran()->orderBy('created_at', 'desc')->where('jumlah_dibayar', '!=', 0)->get();
        $harga = auth()->user()->peserta->mapel->harga;

        return view('livewire.components.peserta.pembayaran', [
            'riwayat' => $riwayat,
            'harga' => $harga
        ]);
    }
}
