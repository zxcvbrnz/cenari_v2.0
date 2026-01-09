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
        $apiUrl = "https://api.qrserver.com/v1/create-qr-code/?size=1000x1000&data=" . urlencode($url) . "&format=png&ecc=H";

        try {
            // Membersihkan buffer
            if (ob_get_level()) ob_end_clean();

            // Menggunakan cURL sebagai pengganti file_get_contents
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $apiUrl);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Bypass cek SSL jika perlu
            $imageContent = curl_exec($ch);
            curl_close($ch);

            if (!$imageContent) {
                throw new \Exception("cURL gagal mengambil data dari API.");
            }

            $fileName = "QRCode-" . str($this->peserta->user->name)->slug() . ".png";

            return Response::streamDownload(function () use ($imageContent) {
                echo $imageContent;
            }, $fileName, [
                'Content-Type' => 'image/png',
            ]);
        } catch (\Exception $e) {
            Log::error("cURL QR Error: " . $e->getMessage());
            $this->dispatch('alert-fail', message: 'Koneksi Server gagal, hubungi admin.');
            return null;
        }
    }

    public function render()
    {
        return view('livewire.components.admin.qrcode-peserta');
    }
}