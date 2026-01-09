<?php

namespace App\Livewire\Components\Admin;

use Illuminate\Support\Facades\Log;
use Livewire\Component;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;

class QrcodePeserta extends Component
{
    public string $qrcode;
    public $peserta;

    public function mount($peserta)
    {
        $this->peserta = $peserta;
        $this->qrcode = QrCode::size(200)->generate('https://kursus.cenari.sch.id/peserta/' . $peserta->unique_code);
    }

    // public function downloadQrCode(): ?StreamedResponse
    // {
    //     if (!$this->peserta) return null;

    //     // Ganti PNG ke SVG
    //     $image = QrCode::format('svg')
    //         ->size(500)
    //         ->margin(1)
    //         ->generate('https://kursus.cenari.sch.id/peserta/' . $this->peserta->unique_code);

    //     $fileName = "QRCode-" . str($this->peserta->user->name)->slug() . ".svg";

    //     return Response::streamDownload(function () use ($image) {
    //         echo $image;
    //     }, $fileName, ['Content-Type' => 'image/svg+xml']);
    // }

    public function downloadQrCode(): ?StreamedResponse
    {
        if (!$this->peserta) return null;

        // 1. Ubah format ke png
        // 2. Pastikan margin cukup agar QR tidak terpotong saat masuk frame
        $image = QrCode::format('png')
            ->size(1000) // Ukuran besar agar tidak pecah di Canva
            ->margin(2)
            ->errorCorrection('H') // High error correction agar tetap terbaca meski di-resize
            ->generate('https://kursus.cenari.sch.id/peserta/' . $this->peserta->unique_code);

        $fileName = "QRCode-" . str($this->peserta->user->name)->slug() . ".png";

        // 3. Ubah Content-Type menjadi image/png
        return Response::streamDownload(function () use ($image) {
            echo $image;
        }, $fileName, ['Content-Type' => 'image/png']);
    }

    public function render()
    {
        return view('livewire.components.admin.qrcode-peserta');
    }
}