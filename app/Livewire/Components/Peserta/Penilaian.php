<?php

namespace App\Livewire\Components\Peserta;

use App\Models\Sertifikat;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Penilaian extends Component
{
    public $sertifikat;

    public $nilai;

    public function mount(): void
    {
        $this->sertifikat = Auth::user()->peserta->sertifikat;
        $this->nilai = Auth::user()->peserta->nilai;
    }
}
