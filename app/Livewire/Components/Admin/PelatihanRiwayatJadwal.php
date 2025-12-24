<?php

namespace App\Livewire\Components\Admin;

use App\Models\Absen;
use Livewire\Component;

class PelatihanRiwayatJadwal extends Component
{
    public $riwayatJadwal;

    public function mount(): void
    {
        $this->riwayatJadwal = Absen::select('id_group', 'nama_group', 'nama_instruktur', 'id_instruktur', 'waktu_mulai', 'keterangan')
            ->where('status', 2)
            ->whereNotNull('id_group')
            ->groupBy('id_group', 'nama_group', 'nama_instruktur', 'id_instruktur', 'waktu_mulai', 'keterangan')
            ->latest()
            ->get();
    }
}
