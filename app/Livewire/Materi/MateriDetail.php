<?php

namespace App\Livewire\Materi;

use App\Models\Materi;
use Livewire\Component;

class MateriDetail extends Component
{
    public $materi;

    public function mount($id): void
    {
        $this->materi = Materi::findOrFail($id);
    }
}
