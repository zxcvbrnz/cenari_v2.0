<?php

namespace App\Livewire\Components\Peserta;

use Livewire\Component;
use App\Models\Materi;
use Illuminate\Support\Facades\Auth;

class DaftarMateri extends Component
{
    public $materi;

    public function mount()
    {
        $user = Auth::user();
        if ($user->peserta->id_group) {
            $id_mapel = $user->peserta->group->mapel->id;
        } else {
            $id_mapel = $user->peserta->id_mapel;
        }
        $this->materi = Materi::where('id_mapel', $id_mapel)->get();
    }
}
