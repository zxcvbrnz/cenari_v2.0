<?php

namespace App\Livewire\Components\Admin;

use App\Models\InstrukturMapel;
use App\Models\Peserta;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Silvanix\Wablas\Message;

class UpdatePeserta extends Component
{
    public $ins;

    public string $role;

    public $peserta;

    public string $name = '';

    public string $instruktur = '';

    public array $data_peserta = [
        'id_group' => '',
        'tempat_lahir' => '',
        'tanggal_lahir' => '',
        'nama_ibu' => '',
        'nama_ayah' => '',
        'nisn' => '',
        'nik' => '',
        'jenis_kelamin' => '',
        'pendidikan' => '',
        'agama' => '',
        'kewarganegaraan' => '',
        'penerima_kps' => '',
        'no_kps' => '',
        'layak_pip' => '',
        'alasan_pip' => '',
        'penerima_kip' => '',
        'no_kip' => '',
        'alamat' => '',
        'rt' => '',
        'rw' => '',
        'kode_pos' => '',
        'nama_desa_kelurahan' => '',
        'provinsi' => '',
        'kab_kota' => '',
        'kecamatan' => '',
        'kelurahan' => '',
        'jenis_tinggal' => '',
        'alat_transportasi' => '',
        'nomor_telepon' => '',
        'status_pembayaran' => '',
        'honor_instruktur' => '',
        'status' => '',
        'email' => '',
        'status_saat_ini' => '',
    ];

    public function mount(Peserta $peserta): void
    {
        $this->role = Auth::user()->role;
        $this->peserta = $peserta;
        $this->ins = InstrukturMapel::all();
        $this->instruktur = $peserta->id_instruktur . '-' . $peserta->id_mapel;
        $this->name = $peserta->user->name;
        foreach ($this->data_peserta as $key => &$value) {
            $value = $peserta->$key;
        }
    }

    public function update(): void
    {
        if ($this->peserta->riwayatAbsensi->count() > 0) {
            if ($this->instruktur != $this->peserta->id_instruktur . '-' . $this->peserta->id_mapel) {
                $this->dispatch('alert-fail', message: 'Tidak dapat mengganti instruktur jika pembelajaran sudah dimulai.');
                return;
            }
        }
        $insmap = explode('-', $this->instruktur);
        $id_instruktur = $insmap[0];
        $id_mapel = $insmap[1];
        $this->peserta->user->update(['name' => $this->name]);
        if ($this->peserta->id_group) {
            $this->peserta->update([
                ...$this->data_peserta,
            ]);
        } else {
            $this->peserta->update([
                'id_instruktur' => $id_instruktur,
                'id_mapel' => $id_mapel,
                ...$this->data_peserta,
            ]);
        }

        $this->dispatch('alert-success', message: 'Berhasil diedit.');
        $this->dispatch('reload-province');
    }

    public function resetPassword(): void
    {
        $this->peserta->user->update([
            'password' => bcrypt('cenarikursus')
        ]);
        $this->dispatch('alert-success', message: 'Berhasil reset password.');
        $this->dispatch('reload-province');

        $send = new Message();
        $wa = [
            [
                'phone' => $this->data_peserta['nomor_telepon'],
                'message' => 'Halo ' . $this->peserta->user->name . ', <br> Kami Ingin Memberitahukan Bahwa Password Anda Telah Direset Menjadi "cenarikursus" <br> Silahkan login Melalui  www.kursus.cenari.sch.id',
            ],
        ];
        $send->multiple_text($wa);
    }
}
