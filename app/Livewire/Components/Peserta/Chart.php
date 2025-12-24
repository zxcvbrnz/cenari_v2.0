<?php

namespace App\Livewire\Components\Peserta;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Chart extends Component
{
    public $instruktur;
    public $jadwalKursus;

    public function mount(): void
    {
        $data = Auth::user();
        $id_group = $data->peserta->id_group;
        if ($id_group) {
            $this->instruktur = $data->peserta->group->instruktur;
            $this->jadwalKursus = $data->peserta->group->jadwalKursus;
        } else {
            $this->instruktur = $data->peserta->instruktur;
            $this->jadwalKursus = $data->peserta->jadwalKursus;
        }
    }
}