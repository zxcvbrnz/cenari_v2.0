<?php

namespace App\Livewire\Materi;

use App\Models\Materi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class MateriIndex extends Component
{
    public $materis;
    public $data;

    public function mount(): void
    {
        $this->data = Auth::user();
        if ($this->data->role === 'admin' || $this->data->role === 'instruktur') {
            $this->materis = Materi::latest()->get();
        } else {
            if ($this->data->peserta->id_group) {
                $id_mapel = $this->data->peserta->group->mapel->id;
            } else {
                $id_mapel = $this->data->peserta->id_mapel;
            }
            $this->materis = Materi::where('id_mapel', $id_mapel)->latest()->get();
        }
    }

    public function hapusMateri($id): void
    {
        $materi = Materi::findOrFail($id);
        if ($materi->file) {
            Storage::disk('public')->delete('files/' . $materi->file);
        }
        $materi->delete();

        if ($this->data->role === 'admin' || $this->data->role === 'instruktur') {
            $this->materis = Materi::latest()->get();
        } else {
            if ($this->data->peserta->id_group) {
                $id_mapel = $this->data->peserta->group->mapel->id;
            } else {
                $id_mapel = $this->data->peserta->id_mapel;
            }
            $this->materis = Materi::where('id_mapel', $id_mapel)->latest()->get();
        }
        $this->dispatch('alert-success-1', message: 'Berhasil menghapus materi');
    }
}
