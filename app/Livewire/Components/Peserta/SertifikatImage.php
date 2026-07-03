<?php

namespace App\Livewire\Components\Peserta;

use Livewire\Component;
use Livewire\WithFileUploads; // Wajib diimport
use App\Models\SertifikatImage as SertifikatModel;

class SertifikatImage extends Component
{
    use WithFileUploads;

    public $id_peserta;
    public $image;
    public $existingImage; // Untuk menampung gambar lama jika mode edit

    public function mount()
    {
        $id_peserta = auth()->user()->id_peserta;
        $this->id_peserta = $id_peserta;

        // Jika ada id_peserta, coba ambil data lama (mode edit)
        if ($id_peserta) {
            $data = SertifikatModel::where('id_peserta', $id_peserta)->first();
            if ($data) {
                $this->existingImage = $data->image;
            }
        }
    }

    public function save()
    {
        $this->validate([
            'image' => 'image|max:2048', // Maksimal 2MB
        ]);

        // Proses penyimpanan berkas
        $imageName = $this->image->store('sertifikat-images', 'public');

        // Update atau Create ke Database
        SertifikatModel::updateOrCreate(
            ['id_peserta' => $this->id_peserta],
            ['image' => $imageName]
        );

        session()->flash('message', 'Foto sertifikat berhasil diperbarui!');
    }

    public function render()
    {
        return view('livewire.components.peserta.sertifikat-image');
    }
}
