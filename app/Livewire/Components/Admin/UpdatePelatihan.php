<?php

namespace App\Livewire\Components\Admin;

use App\Models\Group;
use App\Models\Peserta;
use App\Models\InstrukturMapel;
use Livewire\Component;

class UpdatePelatihan extends Component
{
    public $ins;
    public $data;
    public string $nama = '';
    public string $instruktur = '';
    public string $status = '';
    public $harga = 0;
    public string $status_pembayaran = '';

    public function mount(Group $data): void
    {
        $this->data = $data;
        $this->ins = InstrukturMapel::all();

        $this->nama = $data->nama;
        $this->instruktur = $data->id_instruktur . '-' . $data->id_mapel;
        $this->harga = $data->harga;
        $this->status = $data->status;
        $this->status_pembayaran = $data->status_pembayaran;
    }

    public function update(): void
    {
        $this->validate([
            'nama' => 'required|string|max:255',
        ]);

        $insmap = explode('-', $this->instruktur);
        $id_instruktur = $insmap[0];
        $id_mapel = $insmap[1];

        $this->data->update([
            'nama' => $this->nama,
            'id_instruktur' => $id_instruktur,
            'harga' => $this->harga,
            'id_mapel' => $id_mapel,
            'status' => $this->status,
            'status_pembayaran' => $this->status_pembayaran,
        ]);
        
        Peserta::where('id_group', $this->data->id)->update(['status' => $this->status]);

        $this->dispatch('alert-success', message: 'Berhasil diedit.');
    }
}