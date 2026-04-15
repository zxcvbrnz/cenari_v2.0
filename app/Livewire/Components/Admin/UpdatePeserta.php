<?php

namespace App\Livewire\Components\Admin;

use App\Models\Instruktur;
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
        // 1. Validasi Absensi
        if ($this->peserta->riwayatAbsensi->count() > 0) {
            if ($this->instruktur != $this->peserta->id_instruktur . '-' . $this->peserta->id_mapel) {
                $this->dispatch('alert-fail', message: 'Tidak dapat mengganti instruktur jika pembelajaran sudah dimulai.');
                return;
            }
        }

        // 2. Persiapan Data
        $insmap = explode('-', $this->instruktur);
        $id_instruktur = $insmap[0];
        $id_mapel = $insmap[1];

        // Simpan ID lama sebelum update untuk pengecekan
        $oldInstrukturId = $this->peserta->id_instruktur;

        // 3. Update User & Peserta
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

        // Refresh data model agar relasi instruktur ikut terupdate
        $this->peserta->refresh();

        // 4. Logika Pengiriman WhatsApp
        $send = new Message();
        $waMessages = []; // Inisialisasi array kosong agar tidak error jika tidak ada if yang terpenuhi

        // Cek jika Instruktur berubah
        if ($oldInstrukturId != $id_instruktur) {
            // Ambil data instruktur baru beserta relasi usernya
            $newInstruktur = Instruktur::with('user')->find($id_instruktur);

            if ($newInstruktur) {
                // Pesan untuk Murid
                $waMessages[] = [
                    'phone' => $this->data_peserta['nomor_telepon'],
                    'message' => 'Halo ' . $this->peserta->user->name . ', <br> Instruktur pembimbing Anda telah diperbarui menjadi: ' . ($newInstruktur->user->name ?? 'Instruktur Baru'),
                ];

                // Pesan untuk Instruktur Baru
                $waMessages[] = [
                    'phone' => $newInstruktur->nomor_telepon,
                    'message' => 'Halo *' . ($newInstruktur->user->name ?? 'Instruktur') . '*<br><br>' .
                        'Murid Bernama *' . $this->name . '* Telah Menjadi Murid Didik Anda. Untuk informasi lebih lanjut,' . "<br><br>" .
                        'Silahkan Buka: www.kursus.cenari.sch.id' . "<br>" .
                        'Tutorial penggunaan aplikasi: http://cenari.sch.id/modul-tutorial',
                ];
            }
        }

        // Kirim hanya jika ada pesan dalam antrean
        if (!empty($waMessages)) {
            $send->multiple_text($waMessages);
        }

        // 5. Finishing
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