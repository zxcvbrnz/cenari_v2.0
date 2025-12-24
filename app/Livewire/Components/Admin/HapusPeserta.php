<?php

namespace App\Livewire\Components\Admin;

use App\Models\Absen;
use App\Models\Pembayaran;
use App\Models\Peserta;
use App\Models\Sertifikat;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class HapusPeserta extends Component
{
    public $peserta;

    public function mount(Peserta $peserta): void
    {
        $this->peserta = $peserta;
    }

    public function hapusPeserta(): void
    {

        if ($this->peserta->sertifikat->link) {
            $this->dispatch('alert-fail', message: 'Peserta yang sudah memiliki sertifikat tidak dapat dihapus!.');
            return;
        }

        if ($this->peserta->nilai) {
            $this->dispatch('alert-fail', message: 'Peserta yang sudah memiliki nilai tidak dapat dihapus!.');
            return;
        }

        // Perform deletion within a transaction
        DB::beginTransaction();

        try {
            // Delete related data
            User::where('id_peserta', $this->peserta->id)->delete();
            Absen::where('id_peserta', $this->peserta->id)->delete();
            Pembayaran::where('id_peserta', $this->peserta->id)->delete();
            Sertifikat::where('id_peserta', $this->peserta->id)->delete();

            // Delete peserta record
            $this->peserta->delete();

            // Commit the transaction
            DB::commit();

            // Redirect and dispatch success message
            $this->redirectIntended(route('admin.data.peserta', absolute: false), navigate: true);
            $this->dispatch('alert-success', message: 'Berhasil menghapus peserta didik.');
        } catch (\Exception $e) {
            // Rollback the transaction on error
            DB::rollBack();
            $this->dispatch('alert-fail', message: 'Terjadi kesalahan saat menghapus peserta didik.');
        }
    }
}
