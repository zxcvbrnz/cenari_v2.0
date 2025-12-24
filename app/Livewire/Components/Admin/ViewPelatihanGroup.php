<?php

namespace App\Livewire\Components\Admin;

use App\Models\Absen;
use App\Models\Instruktur;
use App\Models\Group;
use Carbon\Carbon;
use Livewire\Component;

class ViewPelatihanGroup extends Component
{
    public $jadwalBerlangsung;
    public $namaGroup;
    public $namaInstruktur;
    public $waktuMulai;
    public $keterangan;
    
    public $idGroup;
    public $idInstruktur;

    public function mount($id_group, $id_instruktur, $waktu_mulai, $keterangan): void
    {
        $this->jadwalBerlangsung = Absen::where('id_group', $id_group)
            ->where('id_instruktur', $id_instruktur)
            ->where('waktu_mulai', $waktu_mulai)
            ->where('keterangan', $keterangan)
            ->get(['id', 'nama_peserta', 'status']);

        $group = Group::findOrFail($id_group);
        $this->namaGroup = $group->nama;

        $instruktur = Instruktur::findOrFail($id_instruktur);
        $this->namaInstruktur = $instruktur->user->name;

        $this->waktuMulai = $waktu_mulai;
        $this->keterangan = $keterangan;
        
        $this->idGroup = $id_group;
        $this->idInstruktur = $id_instruktur;
    }

    public function absenPeserta($id)
    {
        $now = Carbon::now()->toDateTimeString();
        Absen::findOrFail($id)->update([
            'status' => 2,
            'waktu_absen' => $now
        ]);

        $this->dispatch('alert-success', message: 'Berhasil absen peserta');
        $this->dispatch('reload-table');

        $this->mount($this->idGroup, $this->idInstruktur, $this->waktuMulai, $this->keterangan);
    }
}
