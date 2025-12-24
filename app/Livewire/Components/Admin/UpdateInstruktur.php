<?php

namespace App\Livewire\Components\Admin;

use App\Models\Absen;
use App\Models\Group;
use App\Models\Instruktur;
use App\Models\InstrukturMapel;
use App\Models\Mapel;
use App\Models\Materi;
use App\Models\Peserta;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Silvanix\Wablas\Message;

class UpdateInstruktur extends Component
{
    public $instruktur;

    public $mapels;

    public $pesertadik;
    
    public $selectedMapels = [];

    public $instrukturMapels;

    public string $name;

    public array $data_instruktur = [
        'alamat' => '',
        'nik' => '',
        'kota' => '',
        'provinsi' => '',
        'email' => '',
        'ttl' => '',
        'jenis_kelamin' => '',
        'pendidikan' => '',
        'tanggal_menjadi' => '',
        'NUPWK' => '',
        'rekening' => '',
        'status' => '',
        'status_kerja' => '',
        'pekerjaan' => '',
        'nomor_telepon' => '',
    ];

    public function mount(Instruktur $data): void
    {
        $this->instruktur = $data;
        $this->instrukturMapels = $this->instruktur->instruktur_mapels;
        $this->mapels = Mapel::all();
        $this->pesertadik = Peserta::where('id_group', null)->where('id_instruktur', $this->instruktur->id)->latest()->get();
        $this->selectedMapels = $this->instrukturMapels->pluck('id_mapel');
        $this->name = $data->user->name;
        foreach ($this->data_instruktur as $key => &$value) {
            $value = $data->$key;
        }
    }
    public function update(): void
    {
        $this->instruktur->user->update(['name' => $this->name]);
        $this->instruktur->update($this->data_instruktur);
        $this->dispatch('alert-success', message: 'Berhasil diedit.');
        $this->dispatch('reload-table');
    }

    public function resetPassword(): void
    {
        $this->instruktur->user->update([
            'password' => bcrypt('cenarikursus')
        ]);
        $this->dispatch('alert-success', message: 'Berhasil reset password.');
        $this->dispatch('reload-table');
        $send = new Message();
        $wa = [
            [
                'phone' => $this->data_instruktur['nomor_telepon'],
                'message' => 'Halo ' . $this->instruktur->user->name . ', <br> Kami Ingin Memberitahukan Bahwa Password Anda Telah Direset Menjadi "cenarikursus" <br> Silahkan login Melalui  www.kursus.cenari.sch.id',
            ],
        ];
        $send->multiple_text($wa);
    }

    public function updateMapels(): void
    {
        InstrukturMapel::where('id_instruktur', $this->instruktur->id)->delete();

        foreach ($this->selectedMapels as $mapel) {
            $cek = InstrukturMapel::where('id_instruktur', $this->instruktur->id)
                ->where('id_mapel', $mapel)
                ->exists();

            if (!$cek) {
                InstrukturMapel::create([
                    'id_instruktur' => $this->instruktur->id,
                    'id_mapel' => $mapel,
                ]);
            }
        }
        $this->dispatch('alert-success', message: 'Berhasil mengubah mata pelajaran.');
        $this->dispatch('reload-table');
    }

    public function hapusInstruktur(): void
    {
        // Check for associated participants
        if (Peserta::where('id_instruktur', $this->instruktur->id)->count() > 0) {
            $this->dispatch('alert-fail', message: 'Gagal dihapus karena masih terdapat peserta didik.');
            return;
        }

        // Check for associated training groups
        if (Group::where('id_instruktur', $this->instruktur->id)->count() > 0) {
            $this->dispatch('alert-fail', message: 'Gagal dihapus karena masih terdapat pelatihan.');
            return;
        }

        // Check for associated educational materials
        if (Materi::where('id_instruktur', $this->instruktur->id)->count() > 0) {
            $this->dispatch('alert-fail', message: 'Gagal dihapus karena instruktur memiliki materi pembelajaran.');
            return;
        }

        // Perform deletion within a transaction
        DB::beginTransaction();

        try {
            // Delete mappings and user
            InstrukturMapel::where('id_instruktur', $this->instruktur->id)->delete();
            User::where('id_instruktur', $this->instruktur->id)->delete();

            // Delete instructor record
            $this->instruktur->delete();

            // Commit the transaction
            DB::commit();

            // Redirect and dispatch success message
            $this->redirectIntended(route('admin.data.instruktur', absolute: false), navigate: true);
            $this->dispatch('alert-success', message: 'Berhasil menghapus instruktur.');
        } catch (\Exception $e) {
            // Rollback the transaction on error
            DB::rollBack();
            $this->dispatch('alert-fail', message: 'Terjadi kesalahan saat menghapus instruktur.');
        }
    }
}
