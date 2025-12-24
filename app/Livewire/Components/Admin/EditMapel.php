<?php

namespace App\Livewire\Components\Admin;

use App\Models\Group;
use App\Models\InstrukturMapel;
use App\Models\Mapel;
use App\Models\Materi;
use App\Models\Peserta;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class EditMapel extends Component
{
    public $mapel;
    public string $nama = '';
    public int $harga;
    public array $materi = [
        'materi_1' => '',
        'materi_2' => '',
        'materi_3' => '',
        'materi_4' => '',
        'materi_5' => '',
        'materi_6' => '',
        'materi_7' => '',
        'materi_8' => '',
        'materi_9' => '',
        'materi_10' => '',
    ];

    public function mount(Mapel $data): void
    {
        $this->mapel = $data;
        $this->nama = $this->mapel->nama;
        $this->harga = $this->mapel->harga;

        foreach ($this->materi as $key => &$value) {
            $value = $data->$key;
        }
    }

    public function update(): void
    {
        $this->validate([
            'nama' => 'required|string|max:255',
            'harga' => 'required',
            'materi.materi_1' => 'nullable|string|max:255',
            'materi.materi_2' => 'nullable|string|max:255',
            'materi.materi_3' => 'nullable|string|max:255',
            'materi.materi_4' => 'nullable|string|max:255',
            'materi.materi_5' => 'nullable|string|max:255',
            'materi.materi_6' => 'nullable|string|max:255',
            'materi.materi_7' => 'nullable|string|max:255',
            'materi.materi_8' => 'nullable|string|max:255',
            'materi.materi_9' => 'nullable|string|max:255',
            'materi.materi_10' => 'nullable|string|max:255',
        ]);

        $this->mapel->update([
            'nama' => $this->nama,
            'harga' => $this->harga,
            'materi_1' => $this->materi['materi_1'],
            'materi_2' => $this->materi['materi_2'],
            'materi_3' => $this->materi['materi_3'],
            'materi_4' => $this->materi['materi_4'],
            'materi_5' => $this->materi['materi_5'],
            'materi_6' => $this->materi['materi_6'],
            'materi_7' => $this->materi['materi_7'],
            'materi_8' => $this->materi['materi_8'],
            'materi_9' => $this->materi['materi_9'],
            'materi_10' => $this->materi['materi_10'],
        ]);

        $this->dispatch('alert-success', message: 'Berhasil diedit.');
    }

    public function hapusMapel(): void
    {
        if (Group::where('id_mapel', $this->mapel->id)->count() > 0) {
            $this->dispatch('alert-fail', message: 'Gagal dihapus karena masih digunakan di pelatihan.');
            return;
        }

        if (Peserta::where('id_mapel', $this->mapel->id)->count() > 0) {
            $this->dispatch('alert-fail', message: 'Gagal dihapus karena masih digunakan oleh peserta.');
            return;
        }

        if (InstrukturMapel::where('id_mapel', $this->mapel->id)->count() > 0) {
            $this->dispatch('alert-fail', message: 'Gagal dihapus karena masih digunakan oleh instruktur.');
            return;
        }

        if (Materi::where('id_mapel', $this->mapel->id)->count() > 0) {
            $this->dispatch('alert-fail', message: 'Gagal dihapus karena masih digunakan di materi.');
            return;
        }

        // Perform deletion within a transaction
        DB::beginTransaction();

        try {
            // Delete the mapel
            $this->mapel->delete();

            // Commit the transaction
            DB::commit();

            // Dispatch success message and redirect
            $this->redirectIntended(route('admin.data.mapel', absolute: false), navigate: true);
            $this->dispatch('alert-success', message: 'Berhasil menghapus mata pelajaran.');
        } catch (\Exception $e) {
            // Rollback the transaction on error
            DB::rollBack();
            $this->dispatch('alert-fail', message: 'Terjadi kesalahan saat menghapus mata pelajaran.');
        }
    }
}
