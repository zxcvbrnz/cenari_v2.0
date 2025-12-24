<?php

namespace App\Livewire\Components\Instruktur;

use App\Models\Group;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Pelatihan extends Component
{
    public $pelatihan;

    public function mount(): void
    {
        $id = Auth::user()->id_instruktur;
        $this->pelatihan = Group::where('id_instruktur', $id)->latest()->get();
    }
}