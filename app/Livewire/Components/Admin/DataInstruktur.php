<?php

namespace App\Livewire\Components\Admin;

use App\Models\Instruktur;
use Livewire\Component;

class DataInstruktur extends Component
{
    public $instruktur;
    public function mount(): void
    {
        $this->instruktur = Instruktur::get();
    }
}
