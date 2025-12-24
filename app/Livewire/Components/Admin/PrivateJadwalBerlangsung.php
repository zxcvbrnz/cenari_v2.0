<?php

namespace App\Livewire\Components\Admin;

use App\Models\Absen;
use Carbon\Carbon;
use Livewire\Component;

class PrivateJadwalBerlangsung extends Component
{
    public $jadwalBerlangsung;

    public function mount(): void
    {
        $this->jadwalBerlangsung =  Absen::where('status', 1)->where('id_group', null)->latest('updated_at')->get();
    }

    public function batalJadwal($id, $keterangan)
    {
        Absen::findOrFail($id)
            ->update([
                'status' => 3,
                'keterangan' => $keterangan
            ]);
        $this->dispatch('alert-success', message: 'Berhasil membatalkan jadwal');
        $this->dispatch('reload-table');
        $this->jadwalBerlangsung =  Absen::where('status', 1)->where('id_group', null)->latest()->get();
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