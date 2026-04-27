<?php

namespace App\Livewire\Components\Peserta;

use App\Models\Absen;
use App\Models\Pembayaran;
use App\Models\Sertifikat;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class DataCard extends Component
{
    public string $statusPembayaran;
    public string $absensi;
    public $sertifikat;

    public $kursus;
    public function mount(): void
    {
        $data = Auth::user();
        $this->kursus = $data->peserta->group->nama ?? $data->peserta->mapel->nama;
        $this->statusPembayaran = $data->peserta->status_pembayaran;
        $this->absensi = Absen::where('id_peserta', $data->id_peserta)->where('status', 2)->count();
        $this->sertifikat = $data->peserta->sertifikat;
    }
}
