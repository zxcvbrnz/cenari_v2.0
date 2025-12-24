<?php

namespace App\Livewire\Components\Admin;

use App\Models\Absen;
use App\Models\Instruktur;
use Livewire\Component;
use Silvanix\Wablas\Message;
use Carbon\Carbon;

class PrivatePermohonan extends Component
{
    public $permohonan;

    public function mount(): void
    {
        $this->permohonan =  Absen::where('status', 0)->where('id_group', null)->latest()->get();
    }

    public function confirmVerifikasis($id)
    {
        $data = Absen::findOrFail($id);
        $data->status = 1;
        $data->save();
        $this->dispatch('alert-success-1', message: 'Berhasil memverifikasi');
        $this->dispatch('reload-table');
        $this->permohonan =  Absen::where('status', 0)->where('id_group', null)->latest()->get();

        $this->sendWa($id);
    }

    public function tolakPrivate($id, $keterangan)
    {
        $data = Absen::findOrFail($id);
        $data->status = 3;
        $data->keterangan = $keterangan;
        $data->save();
        $this->dispatch('alert-success-1', message: 'Berhasil Menolak permohonan');
        $this->dispatch('reload-table');
        $this->permohonan =  Absen::where('status', 0)->where('id_group', null)->latest()->get();

        $this->sendWaTolak($id);
    }

    public function sendWa($id): void
    {
        $send = new Message();
        $data = Absen::findOrFail($id);
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
                        "Peserta Didik   : " . $data->nama_peserta . "\n" .
                        "Tanggal/Waktu   : " . $tanggalwaktu . " WITA" . "\n" .
                        "Keterangan      : " . $data->keterangan . "\n" .
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
                        "Instruktur      : " . $nomor_telpon->user->name . "\n" .
                        "Peserta Didik   : " . $data->nama_peserta . "\n" .
                        "Tanggal/Waktu   : " . $tanggalwaktu . " WITA" . "\n" .
                        "Keterangan      : " . $data->keterangan . "\n" .
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
                        "Instruktur      : " . $nomor_telpon->user->name . "\n" .
                        "Peserta Didik   : " . $data->nama_peserta . "\n" .
                        "Tanggal/Waktu   : " . $tanggalwaktu . " WITA" . "\n" .
                        "Keterangan      : " . $data->keterangan . "\n" .
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
                        "Instruktur      : " . $nomor_telpon->user->name . "\n" .
                        "Peserta Didik   : " . $data->nama_peserta . "\n" .
                        "Tanggal/Waktu   : " . $tanggalwaktu . " WITA" . "\n" .
                        "Keterangan      : " . $data->keterangan . "\n" .
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
        $data = Absen::findOrFail($id);
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
