<?php

namespace App\Livewire\Materi;

use App\Models\InstrukturMapel;
use App\Models\Mapel;
use App\Models\Materi;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Validate;

class MateriCreate extends Component
{
    use WithFileUploads;
    
    public $mapels;
    
    public $id_mapel = null;
    
    public $judul = '';
    
    public $deskripsi = '';
    
    public $link = '';
    
    #[Validate('max:10240')] 
    public $file;
    
    public $artikel;

    public function mount(): void
    {
        $data = Auth::user();
        $this->mapels = $data->id_instruktur ? $data->instruktur->instruktur_mapels : Mapel::all();
    }

    public function create(): void
    {
        $this->validate([
            'id_mapel' => ['required'],
            'judul' => ['required', 'string', 'max:255'],
            'deskripsi' => ['required', 'string', 'max:255'],
            'artikel' => ['required'],
            'link' => ['nullable', 'string', 'max:255'],
            'file' => ['nullable', 'max:10240'],
        ]);

        $fileName = '';
        if ($this->file && $this->file->getPathname()) {
            $fileName = $this->file->getClientOriginalName();
            $this->file->StoreAs(path: 'public/files', name: $fileName);
        };

        $data = [
            'id_instruktur' => Auth::user()->id_instruktur ?? null,
            'id_mapel' => $this->id_mapel,
            'judul' => $this->judul,
            'deskripsi' => $this->deskripsi,
            'link' => $this->link,
            'file' => $fileName,
            'artikel' => $this->artikel,
        ];

        Materi::create($data);
        $this->dispatch('alert-success', message: 'Berhasil menambahkan Materi');
        $this->id_mapel = null;
        $this->judul = '';
        $this->deskripsi = '';
        $this->link = '';
        $this->file = null;
        $this->artikel = null;
    }
}
