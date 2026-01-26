<?php

namespace App\Livewire;

use App\Models\Peserta;
use Livewire\Component;

class DetailDataCard extends Component
{
    public $peserta = []; // Inisialisasi sebagai array kosong agar tidak error di blade
    public $status;

    public function mount($status)
    {
        $this->status = $status;

        // Gunakan query builder dasar untuk menghindari pengulangan kode
        $query = Peserta::whereNull('id_group');

        if ($status == 'Baru') {
            $this->peserta = $query->whereDoesntHave('riwayatAbsensi')
                ->where('status', 'aktif')
                ->get();
        } elseif ($status == 'Aktif') {
            $this->peserta = $query->whereHas('riwayatAbsensi', function ($q) {
                $q->havingRaw('COUNT(*) > 0 AND COUNT(*) < 10');
            })
                ->where('status', 'aktif')
                ->whereHas('sertifikat', function ($q) {
                    $q->whereNull('link');
                })
                ->whereDoesntHave('nilai')
                ->get();
        } elseif ($status == 'Selesai') {
            // FIX: Tambahkan $this->peserta = ...
            $this->peserta = $query->where('status', 'aktif')
                ->whereHas('riwayatAbsensi', function ($q) {
                    $q->havingRaw('COUNT(*) >= 10'); // Lebih aman menggunakan >= 10
                })
                ->whereHas('sertifikat', function ($q) {
                    $q->whereNull('link');
                })
                ->whereHas('nilai')
                ->get();
        } elseif ($status == 'Belum Lunas') {
            $this->peserta = $query->whereIn('status_pembayaran', ['Belum Lunas', 'Belum Bayar'])
                ->get();
        } else {
            // Default jika status tidak dikenal
            $this->peserta = collect();
        }
    }

    public function render()
    {
        return view('livewire.detail-data-card');
    }
}