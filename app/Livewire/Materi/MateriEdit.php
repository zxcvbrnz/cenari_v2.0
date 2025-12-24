<?php

namespace App\Livewire\Materi;

use App\Models\Mapel;
use App\Models\Materi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Validate;

class MateriEdit extends Component
{
    use WithFileUploads;

    public $materi;
    
    public $mapels;
    
    public $id_mapel = null;
    
    public $judul = '';
    
    public $deskripsi = '';
    
    public $link = '';
    
    #[Validate('max:10240')] 
    public $file;
    
    public $fileOld;
    
    public $artikel;

    public function mount($id): void
    {
        $this->materi = Materi::findOrFail($id);
        $data = Auth::user();
        $this->mapels = $data->id_instruktur ? $data->instruktur->instruktur_mapels : Mapel::all();

        $this->id_mapel = $this->materi->id_mapel;
        $this->judul = $this->materi->judul;
        $this->deskripsi = $this->materi->deskripsi;
        $this->link = $this->materi->link;
        $this->artikel = $this->materi->artikel;
        $this->fileOld = $this->materi->file;
    }

    public function update(): void
    {
        if (auth()->user()->role === 'admin' || ($this->materi->id_instruktur && $this->materi->id_instruktur === auth()->user()->id_instruktur)) {
            $this->validate([
                'id_mapel' => ['required'],
                'judul' => ['required', 'string', 'max:255'],
                'deskripsi' => ['required', 'string', 'max:255'],
                'artikel' => ['required'],
                'link' => ['nullable', 'string', 'max:255'],
                'file' => ['nullable', 'max:10480'],
            ]);

            $fileName = $this->fileOld;
            if ($this->file && $this->file->getPathname()) {
                if ($this->fileOld) {
                    Storage::disk('public')->delete('files/' . $this->fileOld);
                }
                $fileName = $this->file->getClientOriginalName();
                $this->file->StoreAs(path: 'public/files', name: $fileName);
            };

            $data = [
                'id_mapel' => $this->id_mapel,
                'judul' => $this->judul,
                'deskripsi' => $this->deskripsi,
                'link' => $this->link,
                'file' => $fileName,
                'artikel' => $this->artikel,
            ];

            $this->materi->update($data);
            $this->dispatch('alert-success', message: 'Berhasil mengubah Materi');
        } else {
            $this->dispatch('alert-fail', message: 'Kamu tidak dapat mengubah materi ini');
        }
    }
}
