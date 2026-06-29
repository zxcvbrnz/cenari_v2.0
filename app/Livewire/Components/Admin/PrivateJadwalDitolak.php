<?php

namespace App\Livewire\Components\Admin;

use App\Models\Absen;
use App\Models\Instruktur;
use Livewire\Component;

class PrivateJadwalDitolak extends Component
{
    public $jadwalDitolak;

    public function mount(): void
    {
        $this->jadwalDitolak =  Absen::where('status', 3)->where('id_group', null)->latest('updated_at')->get();
    }
}