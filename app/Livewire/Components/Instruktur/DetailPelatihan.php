<?php

namespace App\Livewire\Components\Instruktur;

use App\Models\Group;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class DetailPelatihan extends Component
{
    public $id;
    public $peserta;
    public $group;
    public $mapel;
    public function mount($id): void
    {
        $this->group = Group::findOrFail($id);
        $this->peserta = $this->group->pesertas;
        $this->mapel = $this->group->mapels;
    }
}
