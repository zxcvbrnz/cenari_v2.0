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

        // Membersihkan buffer agar file tidak korup
        if (ob_get_level()) ob_end_clean();

        try {
            // Generate PNG
            $image = QrCode::format('png')
                ->size(1000)
                ->margin(2)
                ->generate('https://kursus.cenari.sch.id/peserta/' . $this->peserta->unique_code);

            $fileName = "QRCode-" . str($this->peserta->user->name)->slug() . ".png";

            return Response::streamDownload(function () use ($image) {
                echo $image;
            }, $fileName, [
                'Content-Type' => 'image/png',
            ]);
        } catch (\Exception $e) {
            // Jika Imagick tetap diminta, kita tampilkan instruksi ke user
            Log::error("QR PNG Error: " . $e->getMessage());
            $this->dispatch('alert-fail', message: 'Ekstensi Imagick belum aktif di cPanel.');
            return null;
        }
    }

    public function render()
    {
        return view('livewire.components.admin.qrcode-peserta');
    }
}