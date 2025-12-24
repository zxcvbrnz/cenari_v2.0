<?php

namespace App\Livewire\Components\Admin;

use App\Models\Group;
use App\Models\Peserta;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class DetailPelatihan extends Component
{
    public $data;
    public string $nama_pelatihan = '';
    public $pesertas;
    public function mount(Group $data): void
    {
        $this->data = $data;
        $this->pesertas = $data->pesertas;
    }

    public function hapusPelatihan(): void
    {
        if (Peserta::where('id_group', $this->data->id)->count() > 0) {
            $this->dispatch('alert-fail', message: 'Gagal dihapus karena masih terdapat peserta didik.');
            return;
        }
        // Perform deletion within a transaction
        DB::beginTransaction();

        try {
            // Delete the pelatihan
            $this->data->delete();

            // Commit the transaction
            DB::commit();

            // Dispatch success message and redirect
            $this->redirectIntended(route('admin.data.pelatihan', absolute: false), navigate: true);
            $this->dispatch('alert-success', message: 'Berhasil menghapus pelatihan.');
        } catch (\Exception $e) {
            // Rollback the transaction on error
            DB::rollBack();
            $this->dispatch('alert-fail', message: 'Terjadi kesalahan saat menghapus pelatihan.');
        }
    }
}
