<?php

namespace App\Livewire\Components\Admin;

use App\Models\Group;
use Livewire\Component;

class Pelatihan extends Component
{
    public $pelatihan;
    public function mount(): void
    {
        $this->pelatihan = Group::latest()->get();
    }
}
