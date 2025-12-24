<?php

namespace App\Livewire\Components\Instruktur;

use App\Models\Peserta;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class PesertaDidik extends Component
{
    public $peserta;

    public function mount(): void
    {
        $id = Auth::user()->id_instruktur;
        $this->peserta = Peserta::where('id_group', null)->where('id_instruktur', $id)->latest()->get();
    }
}