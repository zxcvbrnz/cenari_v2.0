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

    public function downloadQrCode()
    {
        if (!$this->peserta) return null;

        $url = 'https://kursus.cenari.sch.id/peserta/' . $this->peserta->unique_code;

        // Menggunakan API QR Server (Gratis & Cepat) untuk menghasilkan PNG
        $apiUrl = "https://api.qrserver.com/v1/create-qr-code/?size=1000x1000&data=" . urlencode($url) . "&format=png&ecc=H";

        try {
            $imageContent = file_get_contents($apiUrl);

            if ($imageContent === false) {
                throw new \Exception("Gagal mengambil gambar dari API");
            }

            $fileName = "QRCode-" . str($this->peserta->user->name)->slug() . ".png";

            return Response::streamDownload(function () use ($imageContent) {
                echo $imageContent;
            }, $fileName, [
                'Content-Type' => 'image/png',
            ]);
        } catch (\Exception $e) {
            Log::error("API QR Error: " . $e->getMessage());
            $this->dispatch('alert-fail', message: 'Koneksi API gagal.');
            return null;
        }
    }

    public function render()
    {
        return view('livewire.components.admin.qrcode-peserta');
    }
}