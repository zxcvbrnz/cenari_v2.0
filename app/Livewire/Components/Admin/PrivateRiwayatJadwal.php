<?php

namespace App\Livewire\Components\Admin;

use App\Models\Absen;
use Livewire\Component;

class PrivateRiwayatJadwal extends Component
{
    public $riwayatJadwal;

    public function mount(): void
    {
        $this->riwayatJadwal =  Absen::where('status', 2)->where('id_group', null)->latest('waktu_absen')->get();
    }
}
