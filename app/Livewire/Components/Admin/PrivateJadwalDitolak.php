<?php

namespace App\Livewire\Components\Admin;

use App\Models\Absen;
use App\Models\Instruktur;
use Livewire\Component;
use Silvanix\Wablas\Message;

class PrivateJadwalDitolak extends Component
{
    public $jadwalDitolak;

    public function mount(): void
    {
        $this->jadwalDitolak =  Absen::where('status', 3)->where('id_group', null)->latest('updated_at')->get();
    }
}
