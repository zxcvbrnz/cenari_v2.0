<?php

namespace App\Livewire\Components\Instruktur;

use App\Models\Absen;
use App\Models\InstrukturMapel;
use App\Models\Peserta;
use App\Models\Group;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class DataCard extends Component
{
    public $peserta = 0;
    public $mapel = 0;
    public $permohonan = 0;
    public $pelatihan = 0;
    public $dataBelumBernilai = 0;

    public function mount(): void
    {
        $id = Auth::user()->id_instruktur;
        $permohonanPrivate = Absen::where('id_instruktur', $id)->where('status', 0)->where('id_group', null)->count();
        $permohonanGroup = Absen::select('id_group', 'nama_group', 'waktu_mulai', 'keterangan')->where('id_instruktur', $id)->where('status', 0)->whereNotNull('id_group')
            ->groupBy('id_group', 'nama_group', 'waktu_mulai', 'keterangan')
            ->get()
            ->count();
        $this->peserta = Peserta::where('id_instruktur', $id)->where('status', 'aktif')->count();
        $this->mapel = InstrukturMapel::where('id_instruktur', $id)->count();
        $this->permohonan = $permohonanPrivate + $permohonanGroup;
        $this->pelatihan = Group::where('id_instruktur', $id)->where('status', 'aktif')->count();
        $this->dataBelumBernilai = Peserta::where('status', 'aktif')
            ->where('id_instruktur', $id)
            ->whereHas('riwayatAbsensi', function ($query) {
                $query->havingRaw('COUNT(*) = 10 OR COUNT(*) = 12');
            })
            ->whereDoesntHave('nilai')
            ->count();
    }
}
