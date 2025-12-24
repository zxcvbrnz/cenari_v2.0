<?php

namespace App\Livewire\Components\Admin;

use App\Models\Absen;
use Carbon\Carbon;
use Livewire\Component;

class PelatihanJadwalBerlangsung extends Component
{
    public $jadwalBerlangsung;
    
    public function loadData(): void
    {
            $this->jadwalBerlangsung = Absen::select('id_group', 'id_instruktur', 'nama_group', 'nama_instruktur', 'waktu_mulai', 'keterangan')
                ->where('status', 1)
                ->whereNotNull('id_group')
                ->groupBy('id_group', 'id_instruktur',  'nama_group', 'nama_instruktur', 'waktu_mulai', 'keterangan')
                ->latest()
                ->get();
    }

    public function mount(): void
    {
       $this->loadData();
    }
    public function selesaiPelatihan($idGroup, $idInstruktur, $waktuMulai): void
    {
        Absen::where('id_group', $idGroup)
            ->where('id_instruktur', $idInstruktur)
            ->where('waktu_mulai', $waktuMulai)
            ->where('status', 1)
            ->delete();
        
        $this->dispatch('alert-success', message: 'Berhasil absen peserta ~' . $idGroup . ' ~ ' . $idInstruktur . ' ~ ' . $waktuMulai);
        $this->dispatch('reload-table');
        $this->loadData();
    }
    public function absenPeserta($id)
    {
        $now = Carbon::now()->toDateTimeString();
        Absen::findOrFail($id)
            ->update([
                'status' => 2,
                'waktu_absen' => $now
            ]);
        $this->dispatch('alert-success', message: 'Berhasil absen peserta');
        $this->dispatch('reload-table');
        $this->jadwalBerlangsung =  Absen::where('status', 1)->where('id_group', null)->latest()->get();
    }
}
