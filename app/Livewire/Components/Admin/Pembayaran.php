<?php

namespace App\Livewire\Components\Admin;

use App\Models\Pembayaran as ModelsPembayaran;
use App\Models\Peserta;
use App\Models\Group;
use Livewire\Component;
use Livewire\WithFileUploads;

class Pembayaran extends Component
{
    use WithFileUploads;
    public $id_peserta;
    public $pembayarans;
    public $peserta;
    public $group;
    public $groups;
    public $pesertas;
    public $status_pembayaran;

    public $route;

    public array $data_pembayaran = [
        'id_peserta' => '',
        'id_group' => '',
        'jumlah_dibayar' => '',
        'tanggal_dibayar' => '',
        'deskripsi' => '',
    ];

    public function mount(): void
    {
        $this->route = url()->previous();
        $this->pesertas = Peserta::whereNull('id_group')
            ->where('status_pembayaran', '!=', 'Lunas')
            ->latest()
            ->get();
        $this->groups = Group::where('status_pembayaran', '!=', 'Lunas')
            ->latest()
            ->get();

        $this->pembayarans = ModelsPembayaran::latest()->get();
    }

    public function pembayaran(): void
    {
        ModelsPembayaran::create($this->data_pembayaran);
        if ($this->data_pembayaran['id_peserta']) {
            $this->peserta->status_pembayaran = $this->status_pembayaran;
            $this->peserta->save();
        } elseif ($this->data_pembayaran['id_group']) {
            $this->group->status_pembayaran = $this->status_pembayaran;
            $this->group->save();
        }
        $this->pembayarans = ModelsPembayaran::latest()->get();
        $this->reset('data_pembayaran');
        $this->dispatch('alert-success', message: 'Berhasil menambahakan pembayaran.');
        $this->dispatch('reload-table-pembayaran');
    }

    public function hapusPembayaran($id): void
    {
        ModelsPembayaran::findOrFail($id)->delete();
        $this->pembayarans = ModelsPembayaran::latest()->get();
        $this->reset('data_pembayaran');
        $this->dispatch('alert-success-delete', message: 'Berhasil Menghapus Pembayaran');
        $this->dispatch('reload-table-pembayaran');
    }

    public function pelunasan($id): void
    {
        $this->peserta = Peserta::findOrFail($id);
        if ($this->peserta->status_pembayaran === 'Lunas') {
            $this->dispatch('alert-fail', message: 'Peserta Sudah Lunas');
            return;
        }
        $this->data_pembayaran['id_peserta'] = $this->peserta->id;
        $this->data_pembayaran['id_group'] = null;
        $this->data_pembayaran['jumlah_dibayar'] = $this->peserta->mapel->harga - $this->peserta->pembayaran->sum('jumlah_dibayar');
        $this->status_pembayaran = 'Lunas';
        $this->dispatch('reload-table-pembayaran');
    }

    public function pelunasanGroup($id): void
    {
        $this->group = Group::findOrFail($id);
        if ($this->group->status_pembayaran === 'Lunas') {
            $this->dispatch('alert-fail', message: 'Group Sudah Lunas');
            return;
        }
        $this->data_pembayaran['id_group'] = $this->group->id;
        $this->data_pembayaran['id_peserta'] = null;
        $this->data_pembayaran['jumlah_dibayar'] = $this->group->harga - $this->group->pembayaran->sum('jumlah_dibayar');
        $this->status_pembayaran = 'Lunas';
        $this->dispatch('reload-table-pembayaran');
    }

    public function render()
    {
        return view('livewire.components.admin.pembayaran');
    }
}
