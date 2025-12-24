<?php

namespace App\Livewire\Components\Peserta;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class AnggotaPelatihan extends Component
{
    public $anggota;

    public function mount(): void
    {
        $this->anggota = Auth::user()->peserta->group->pesertas;
        
    }
    // public function mount(): void
    // {
    //     $this->anggota = Auth::user()->peserta->group->pesertas->orderBy('nama')->get();
    // }
}