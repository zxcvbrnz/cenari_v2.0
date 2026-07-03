<?php

namespace App\Livewire\Components\Peserta;

use Livewire\Component;
use Livewire\WithFileUploads; // Wajib diimport
use App\Models\SertifikatImage as SertifikatModel;
use Illuminate\Support\Facades\Storage;

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

        // 1. Cari tahu apakah peserta ini sudah punya data gambar lama di database
        $oldData = SertifikatModel::where('id_peserta', $this->id_peserta)->first();

        // 2. Proses penyimpanan berkas baru ke storage
        $imageName = $this->image->store('sertifikat-images', 'public');

        // 3. Jika data lama ada DAN file lamanya benar-benar ada di folder storage, HAPUS!
        if ($oldData && $oldData->image && Storage::disk('public')->exists($oldData->image)) {
            Storage::disk('public')->delete($oldData->image);
        }

        // 4. Update atau Create data baru ke Database
        SertifikatModel::updateOrCreate(
            ['id_peserta' => $this->id_peserta],
            ['image' => $imageName]
        );

        // 5. Reset input file agar tombol kembali otomatis terkunci (disabled) setelah berhasil
        $this->reset('image');

        // 6. Perbarui data gambar saat ini agar preview langsung berganti ke foto yang baru disave
        $this->existingImage = $imageName;

        session()->flash('message', 'Foto sertifikat berhasil diperbarui!');

        $this->dispatch('saved');
    }

    public function render()
    {
        return view('livewire.components.peserta.sertifikat-image');
    }
}
