<?php

namespace App\Livewire\Layout;

use Livewire\Component;
use App\Models\Absen;
use Illuminate\Support\Facades\Auth;

class Sidebar extends Component
{
    public $role;
    public $isOpen = false;
    public $permohonan;

    public function mount(): void
    {
        $this->role = Auth::user()->role;

        $permohonanPrivate = Absen::where('status', 0)->where('id_group', null)->count();
        $permohonanGroup = Absen::select('id_group', 'id_instruktur', 'waktu_mulai', 'keterangan')
            ->where('status', 0)
            ->whereNotNull('id_group')
            ->groupBy('id_group', 'id_instruktur', 'waktu_mulai', 'keterangan')
            ->get()
            ->count();

        $this->permohonan = $permohonanPrivate + $permohonanGroup;
    }
    public function render()
    {
        return view('livewire.layout.sidebar');
    }
}
