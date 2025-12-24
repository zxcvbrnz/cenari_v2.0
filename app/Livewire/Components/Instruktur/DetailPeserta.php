<?php

namespace App\Livewire\Components\Instruktur;

use App\Models\Peserta;
use Livewire\Component;

class DetailPeserta extends Component
{
    public $id;
    public $data;
    public $riwayatAbsen;
    public $nilai;

    public function mount($id): void
    {
        $this->id = $id;
        $this->data = Peserta::findOrFail($id);
        $this->riwayatAbsen = $this->data->riwayatAbsensi;
        $this->nilai = '';
    }
}