<?php

namespace App\Livewire\Components\Admin;

use App\Models\Absen;
use Livewire\Component;

class PelatihanJadwalDitolak extends Component
{
    public $jadwalDitolak;

    public function mount(): void
    {
        $this->jadwalDitolak = Absen::select('id_group', 'nama_group', 'nama_instruktur', 'id_instruktur', 'waktu_mulai', 'keterangan')
            ->where('status', 3)
            ->whereNotNull('id_group')
            ->groupBy('id_group', 'nama_group', 'nama_instruktur', 'id_instruktur', 'waktu_mulai', 'keterangan')
            ->latest()
            ->get();
    }
}
