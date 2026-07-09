<?php

namespace App\Livewire\Components\Peserta;

use Livewire\Component;
use Midtrans\Config;
use Midtrans\Snap;
use App\Models\Pembayaran as PembayaranModel;
use App\Models\Setting;

class Pembayaran extends Component
{
    public function bayar()
    {
        $peserta = auth()->user()->peserta;
        $harga = $peserta->mapel->harga;
        $totalTerbayar = $peserta->pembayaran->where('status', 'paid')->sum('jumlah_dibayar');
        $sisaTagihan = $harga - $totalTerbayar;

        if ($sisaTagihan <= 0) {
            $this->dispatch('alert-fail', message: 'Tagihan Anda sudah lunas.');
            return;
        }

        // 1. Konfigurasi Midtrans
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = env('MIDTRANS_IS_PRODUCTION', false);
        Config::$isSanitized = true;
        Config::$is3ds = true;

        // Buat Order ID unik
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
            // 2. Minta Snap Token TERLEBIH DAHULU
            $snapToken = Snap::getSnapToken($params);

            // 3. Jika berhasil dapat token, BARU simpan ke database dengan status pending
            $peserta->pembayaran()->create([
                'id_peserta'      => $peserta->id,
                'order_id'        => $orderId,
                'jumlah_dibayar'  => $sisaTagihan,
                'tanggal_dibayar' => now(),
                'deskripsi'       => 'Pelunasan Program',
                'status'          => 'pending',
            ]);

            // 4. Munculkan popup Midtrans di frontend
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
        $setting = Setting::findOrFail(2)->value;
        $totalTagihan = $riwayat->first()->total_bayar ?? ($peserta->mapel->harga ?? 0);

        return view('livewire.components.peserta.pembayaran', [
            'riwayat' => $riwayat,
            'harga' => $harga,
            'setting' => $setting,
            'totalTagihan' => $totalTagihan,

        ]);
    }
}
