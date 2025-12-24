<?php

namespace App\Livewire\Components\Peserta;

use Livewire\Component;
use App\Models\Materi;

class DetailMateri extends Component
{
    public $detailMateri;
    public function detailMateri($id)
    {
        $this->detailMateri = Materi::findOrFail($id);
    }
}
