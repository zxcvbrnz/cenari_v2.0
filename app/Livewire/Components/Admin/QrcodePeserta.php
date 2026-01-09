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

        try {
            // Generate gambar sebagai string
            // Tambahkan ->format('png') secara eksplisit
            $image = QrCode::format('png')
                ->size(1000)
                ->margin(2)
                ->errorCorrection('H')
                ->generate('https://kursus.cenari.sch.id/peserta/' . $this->peserta->unique_code);

            $fileName = "QRCode-" . str($this->peserta->user->name)->slug() . ".png";

            // Menggunakan streamDownload dengan output yang dipaksa bersih
            return Response::streamDownload(function () use ($image) {
                echo $image;
            }, $fileName, [
                'Content-Type' => 'image/png',
            ]);
        } catch (\Exception $e) {
            // Jika masih error, besar kemungkinan modul sistem server belum lengkap
            Log::error("QR Download Error: " . $e->getMessage());

            // Kirim notifikasi ke UI Livewire
            $this->dispatch('alert-error', message: 'Server gagal memproses gambar. Gunakan format SVG atau hubungi admin server.');
            return null;
        }
    }

    public function render()
    {
        return view('livewire.components.admin.qrcode-peserta');
    }
}