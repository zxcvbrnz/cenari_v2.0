<?php

namespace App\Livewire\Components\Admin;

use App\Models\Group;
use App\Models\Instruktur;
use App\Models\Mapel;
use App\Models\Peserta;
use Livewire\Component;

class DataCard extends Component
{
    // public $peserta;
    // public int $instruktur;
    // public int $mapel;
    public int $pelatihan;
    // public int $dataBelumBernilai;

    public int $pesertaDidikBaru = 0;
    public int $pesertaDidikAktif = 0;
    public int $pesertaDidikSudahAbsendanNilai = 0;
    public int $pesertaDidikNonaktif = 0;
    public int $pesertaDidikBelumLunas = 0;

    public function mount(): void
    {
        $this->pesertaDidikBaru = Peserta::where('id_group', null)->whereHas('riwayatAbsensi', function ($query) {
            $query->havingRaw('COUNT(*) < 1');
        })
            ->where('status', 'aktif')
            ->count();

        $this->pesertaDidikAktif = Peserta::where('id_group', null)->whereHas('riwayatAbsensi', function ($query) {
            $query->havingRaw('COUNT(*) > 0 AND COUNT(*) < 10');
        })
            ->whereHas('sertifikat', function ($query) {
                $query->whereNull('link');
            })
            ->where('status', 'aktif')
            ->whereDoesntHave('nilai')
            ->count();

        $this->pesertaDidikSudahAbsendanNilai = Peserta::where('id_group', null)
            ->where('status', 'aktif')
            ->whereHas('riwayatAbsensi', function ($query) {
                $query->havingRaw('COUNT(*) = 10 OR COUNT(*) = 12');
            })
            ->whereHas('sertifikat', function ($query) {
                $query->whereNull('link');
            })
            ->whereHas('nilai')
            ->count();

        $this->pesertaDidikNonaktif = Peserta::where('id_group', null)->where('status', 'nonaktif')->whereHas('sertifikat', function ($query) {
            $query->whereNotNull('link');
        })
            ->count();

        $this->pesertaDidikBelumLunas = Peserta::where('id_group', null)->where('status_pembayaran', 'Belum Lunas')->count();
        // Counting active Peserta
        // $this->peserta = Peserta::where('status', 'aktif')->count();

        // // Counting all Instruktur
        // $this->instruktur = Instruktur::count();

        // // Counting all Mapel
        // $this->mapel = Mapel::count();

        // // Counting active Groups (pelatihan)
        $this->pelatihan = Group::where('status', 'aktif')->count();

        // // Counting Peserta with riwayatAbsensi >= 10
        // $this->dataBelumBernilai = Peserta::where('status', 'aktif')
        //     ->whereHas('riwayatAbsensi', function ($query) {
        //         $query->havingRaw('COUNT(*) = 10 OR COUNT(*) = 12');
        //     })
        //     ->whereDoesntHave('nilai')
        //     ->count();
    }
}
