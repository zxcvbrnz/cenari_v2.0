<?php

namespace App\Livewire\Components\Instruktur;

use App\Models\InstrukturMapel;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ProgramIndex extends Component
{
    public $programs;

    public function mount(): void
    {
        $this->programs = Auth::user()->instruktur->instruktur_mapels;
    }
}
