<?php

namespace App\Livewire\Components\Admin;

use App\Models\Absen;
use App\Models\Instruktur;
use Carbon\Carbon;
use Livewire\Component;
use Silvanix\Wablas\Message;

class GroupPermohonan extends Component
{
    public $permohonangroup;

    public function mount(): void
    {
        $this->permohonangroup = Absen::select('id_group', 'nama_group', 'nama_instruktur', 'id_instruktur', 'waktu_mulai', 'keterangan')
            ->where('status', 0)
            ->whereNotNull('id_group')
            ->distinct()
            ->latest()
            ->get();
    }

    public function confirmVerifikasi($id)
    {
        try {
            $absen = Absen::where('id_group', $id)
                ->where('status', 0);

            if ($absen->exists()) {
                $absen->update(['status' => 1]);

                $this->dispatch('alert-success', message: 'Berhasil memverifikasi permohonan');
                $this->dispatch('reload-table');

                // Kirim WA dengan jeda
                $this->sendWa($id);

                $this->permohonangroup = Absen::select('id_group', 'nama_group', 'nama_instruktur', 'id_instruktur', 'waktu_mulai', 'keterangan')
                    ->where('status', 0)
                    ->whereNotNull('id_group')
                    ->distinct()
                    ->latest()
                    ->get();
            } else {
                $this->dispatch('alert-error', message: 'Permohonan tidak ditemukan atau sudah terverifikasi');
            }
        } catch (\Exception $e) {
            $this->dispatch('alert-error', message: 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function tolakGroup($id)
    {
        try {
            $absen = Absen::where('id_group', $id)
                ->where('status', 0);

            if ($absen->exists()) {
                $absen->update(['status' => 3]);

                $this->dispatch('alert-success', message: 'Berhasil menolak permohonan');
                $this->dispatch('reload-table');

                // Kirim WA dengan jeda
                $this->sendWaTolak($id);

                $this->permohonangroup = Absen::select('id_group', 'nama_group', 'nama_instruktur', 'id_instruktur', 'waktu_mulai', 'keterangan')
                    ->where('status', 0)
                    ->whereNotNull('id_group')
                    ->distinct()
                    ->latest()
                    ->get();
            } else {
                $this->dispatch('alert-error', message: 'Permohonan tidak ditemukan atau sudah terverifikasi');
            }
        } catch (\Exception $e) {
            $this->dispatch('alert-error', message: 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function sendWa($id): void
    {
        $send = new Message();
        $data = Absen::where('id_group', $id)->first();
        if (!$data) return;

        $ins = $data->id_instruktur;
        $nomor_telpon = Instruktur::findOrFail($ins);
        $tanggalwaktu = Carbon::parse($data->waktu_mulai)->locale('id')->format('d F Y - H:i');

        // Daftar antrean pesan
        $queue = [
            [
                'phone' => $nomor_telpon->nomor_telepon,
                'message' => "Halo *" . $nomor_telpon->user->name . "*\n" .
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
                'message' => "Halo *Admin*\n" .
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
                'message' => "Halo *Admin*\n" .
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
                'message' => "Halo *Admin*\n" .
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

        // Eksekusi kirim satu per satu dengan jeda
        foreach ($queue as $index => $item) {
            $send->multiple_text([$item]);

            // Beri jeda 5-9 detik kecuali setelah pesan terakhir
            if ($index < count($queue) - 1) {
                sleep(rand(5, 9));
            }
        }
    }

    public function sendWaTolak($id): void
    {
        $send = new Message();
        $data = Absen::where('id_group', $id)->first();
        if (!$data) return;

        $ins = $data->id_instruktur;
        $nomor_telpon = Instruktur::findOrFail($ins);

        $wa = [
            'phone' => $nomor_telpon->nomor_telepon,
            'message' => "Halo *" . $nomor_telpon->user->name . "*\n" .
                "Permohonanmu Telah Direspon dan Ditolak\n\n" .
                "Silakan cek informasi lengkap di website kami:\n" .
                "www.kursus.cenari.sch.id",
        ];

        $send->multiple_text([$wa]);
    }
}