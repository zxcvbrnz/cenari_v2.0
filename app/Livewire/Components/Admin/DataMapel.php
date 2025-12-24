<?php

namespace App\Livewire\Components\Admin;

use App\Models\Mapel;
use Livewire\Component;

class DataMapel extends Component
{
    public $mapels;
    public function mount(): void
    {
        $this->mapels = Mapel::all();
    }
}
