<?php

namespace App\Livewire\Components\Admin;

use App\Models\Absen;
use App\Models\Instruktur;
use Livewire\Component;
use Silvanix\Wablas\Message;


class GroupPermohonan extends Component
{
    public $permohonangroup;

    public function mount(): void
    {
        // Menggunakan distinct untuk mendapatkan data yang unik
        $this->permohonangroup = Absen::select('id_group', 'nama_group', 'nama_instruktur', 'id_instruktur', 'waktu_mulai', 'keterangan')
            ->where('status', 0)
            ->whereNotNull('id_group')
            ->distinct()  // Menggunakan distinct untuk mendapatkan data unik
            ->latest()
            ->get();
    }
    
    public function confirmVerifikasi($id)
    {
        try {
            // Mengambil data dengan id_group tertentu
            $absen = Absen::where('id_group', $id)
                ->where('status', 0)
                ->select('id_group', 'nama_group', 'nama_instruktur', 'id_instruktur', 'waktu_mulai', 'keterangan');
    
            if ($absen) {
                // Melakukan update status menjadi 1
                $absen->update(['status' => 1]);
    
                // Menampilkan pesan sukses
                $this->dispatch('alert-success', message: 'Berhasil memverifikasi permohonan');
                
                // Menggunakan dispatch untuk reload tabel di frontend
                $this->dispatch('reload-table');
    
                // Kirim WA
                $this->sendWa($id);
                
                $this->permohonangroup = Absen::select('id_group', 'nama_group', 'nama_instruktur', 'id_instruktur', 'waktu_mulai', 'keterangan')
                                        ->where('status', 0)
                                        ->whereNotNull('id_group')
                                        ->distinct()  // Menggunakan distinct untuk mendapatkan data unik
                                        ->latest()
                                        ->get();
            } else {
                // Jika data tidak ditemukan
                $this->dispatch('alert-error', message: 'Permohonan tidak ditemukan atau sudah terverifikasi');
            }
    
        } catch (\Exception $e) {
            // Menangani error jika ada yang gagal
            $this->dispatch('alert-error', message: 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }


    public function tolakGroup($id)
    {
        try {
            // Mengambil data dengan id_group tertentu
            $absen = Absen::where('id_group', $id)
                ->where('status', 0)
                ->select('id_group', 'nama_group', 'nama_instruktur', 'id_instruktur', 'waktu_mulai', 'keterangan');
    
            if ($absen) {
                // Melakukan update status menjadi 3
                $absen->update(['status' => 3]);
    
                // Menampilkan pesan sukses
                $this->dispatch('alert-success', message: 'Berhasil memverifikasi permohonan');
                
                // Menggunakan dispatch untuk reload tabel di frontend
                $this->dispatch('reload-table');
    
                // Kirim WA
                $this->sendWaTolak($id);
                
                $this->permohonangroup = Absen::select('id_group', 'nama_group', 'nama_instruktur', 'id_instruktur', 'waktu_mulai', 'keterangan')
                                        ->where('status', 0)
                                        ->whereNotNull('id_group')
                                        ->distinct()  // Menggunakan distinct untuk mendapatkan data unik
                                        ->latest()
                                        ->get();
            } else {
                // Jika data tidak ditemukan
                $this->dispatch('alert-error', message: 'Permohonan tidak ditemukan atau sudah terverifikasi');
            }
    
        } catch (\Exception $e) {
            // Menangani error jika ada yang gagal
            $this->dispatch('alert-error', message: 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function sendWa($id): void
    {
        $send = new Message();
        $data = Absen::where('id_group', $id)->first();
        $ins = $data->id_instruktur;
        $nomor_telpon = Instruktur::findOrFail($ins);
        $tanggalwaktu = Carbon::parse($data->waktu_mulai)->locale('id')->format('d F Y - H:i');
        $wa = [
                [
                    'phone' => $nomor_telpon->nomor_telepon,
                    'message' =>
                        "Halo *" . $nomor_telpon->user->name . "*\n" .
                        "Permohonanmu Telah Direspon dan Disetujui\n" .
                        "```\n" .
                        "Pelatihan     : " . $data->nama_group . "\n" .
                        "Tanggal/Waktu : " . $tanggalwaktu . " WITA" . "\n" .
                        "Keterangan    : " . $data->keterangan . "\n" .
                        "```\n" .
                        "Silakan cek informasi lengkap di website kami:\n" .
                        "www.kursus.cenari.sch.id",
                ],
                [
                    'phone' => '085103326061',
                    'message' =>
                        "Halo *Admin*\n" .
                        "Permohonan Jadwal Telah Disetujui\n" .
                        "```\n" .
                        "Instruktur    : " . $nomor_telpon->user->name . "\n" .
                        "Pelatihan     : " . $data->nama_group . "\n" .
                        "Tanggal/Waktu : " . $tanggalwaktu . " WITA" . "\n" .
                        "Keterangan    : " . $data->keterangan . "\n" .
                        "```\n" .
                        "Silakan cek informasi lengkap di website kami:\n" .
                        "www.kursus.cenari.sch.id",
                ],
                [
                    'phone' => '081349674994',
                    'message' =>
                        "Halo *Admin*\n" .
                        "Permohonan Jadwal Telah Disetujui\n" .
                        "```\n" .
                        "Instruktur    : " . $nomor_telpon->user->name . "\n" .
                        "Pelatihan     : " . $data->nama_group . "\n" .
                        "Tanggal/Waktu : " . $tanggalwaktu . " WITA" . "\n" .
                        "Keterangan    : " . $data->keterangan . "\n" .
                        "```\n" .
                        "Silakan cek informasi lengkap di website kami:\n" .
                        "www.kursus.cenari.sch.id",
                ],
                [
                    'phone' => '089691884833',
                    'message' =>
                        "Halo *Admin*\n" .
                        "Permohonan Jadwal Telah Disetujui\n" .
                        "```\n" .
                        "Instruktur    : " . $nomor_telpon->user->name . "\n" .
                        "Pelatihan     : " . $data->nama_group . "\n" .
                        "Tanggal/Waktu : " . $tanggalwaktu . " WITA" . "\n" .
                        "Keterangan    : " . $data->keterangan . "\n" .
                        "```\n" .
                        "Silakan cek informasi lengkap di website kami:\n" .
                        "www.kursus.cenari.sch.id",
                ],
            ];
        $send->multiple_text($wa);
    }
    
    public function sendWaTolak($id): void
    {
        $send = new Message();
        $data = Absen::where('id_group', $id)->first();
        $ins = $data->id_instruktur;
        $nomor_telpon = Instruktur::findOrFail($ins);
        $wa = [
            [
                'phone' => $nomor_telpon->nomor_telepon,
                'message' =>
                    "Halo *" . $nomor_telpon->user->name . "*\n" .
                    "Permohonanmu Telah Direspon dan Ditolak\n\n" .
                    "Silakan cek informasi lengkap di website kami:\n" .
                    "www.kursus.cenari.sch.id",
            ],
        ];
        $send->multiple_text($wa);
    }
}
