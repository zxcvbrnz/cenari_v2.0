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

        // Pastikan tidak ada output lain sebelum ini
        if (ob_get_level()) ob_end_clean();

        try {
            // Kita generate sebagai PNG
            // Jika tetap gagal, server Anda mungkin butuh 'imagick' diaktifkan di cPanel
            $image = QrCode::format('png')
                ->size(1000)
                ->margin(2)
                ->errorCorrection('H')
                ->generate('https://kursus.cenari.sch.id/peserta/' . $this->peserta->unique_code);

            $fileName = "QRCode-" . str($this->peserta->user->name)->slug() . ".png";

            // Menggunakan Header manual untuk memastikan cPanel tidak salah baca format
            return Response::streamDownload(function () use ($image) {
                echo $image;
            }, $fileName, [
                'Content-Type' => 'image/png',
                'Content-Transfer-Encoding' => 'binary',
            ]);
        } catch (\Exception $e) {
            // Log pesan error asli agar kita tahu apa yang kurang di server
            Log::error("QR PNG Error: " . $e->getMessage());

            // Tampilkan error di layar jika dalam mode development
            $this->dispatch('alert-fail', message: 'Gagal: ' . $e->getMessage());
            return null;
        }
    }

    public function render()
    {
        return view('livewire.components.admin.qrcode-peserta');
    }
}