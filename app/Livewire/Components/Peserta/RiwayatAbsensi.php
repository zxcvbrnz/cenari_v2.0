<?php

namespace App\Livewire\Components\Peserta;

use App\Models\Absen;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class RiwayatAbsensi extends Component
{
    public $absens;
    public $id;
    public function mount(): void
    {
        $data = Auth::user();
        $this->absens = $data->peserta->riwayatAbsensi;
    }
}