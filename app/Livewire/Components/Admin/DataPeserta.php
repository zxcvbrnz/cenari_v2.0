<?php

namespace App\Livewire\Components\Admin;

use App\Models\Peserta;
use Livewire\Component;

class DataPeserta extends Component
{
    public $peserta;

    public function mount(): void
    {
        $this->peserta = Peserta::latest()->get();
    }
}
