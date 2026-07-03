<?php

namespace App\Livewire\Components\Admin;

use Livewire\Component;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;

class SertifikatImagePeserta extends Component
{
    public $peserta;
    public $sertifikatImage;

    public function mount($peserta)
    {
        $this->peserta = $peserta;
        // Mengambil data relasi sertifikat dari model Peserta
        $this->sertifikatImage = $peserta->sertifikatImage ?? null;
    }

    public function downloadImage()
    {
        if (!$this->sertifikatImage || !$this->sertifikatImage->image) {
            $this->dispatch('alert-fail', message: 'Peserta belum mengunggah foto.');
            return null;
        }

        $path = $this->sertifikatImage->image;

        // Memastikan file fisik ada di disk public
        if (!Storage::disk('public')->exists($path)) {
            $this->dispatch('alert-fail', message: 'File gambar tidak ditemukan di server.');
            return null;
        }

        $extension = pathinfo($path, PATHINFO_EXTENSION);
        $fileName = "FotoSertifikat-" . str($this->peserta->user->name)->slug() . "." . $extension;

        return Storage::disk('public')->download($path, $fileName);
    }

    public function render()
    {
        return view('livewire.components.admin.sertifikat-image-peserta');
    }
}
