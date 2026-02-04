<?php

namespace App\Livewire\Components\Peserta;

use App\Models\Absen;
use App\Models\Instruktur;
use App\Models\Peserta;
use Carbon\Carbon;
use Livewire\Component;

class Scan extends Component
{
    public $token_absen;
    public function absen()
    {
        $peserta = auth()->user()->peserta; // Ambil data peserta
        $id = $peserta->id;
        $ins = $peserta->id_instruktur ? $peserta->instruktur->id : $peserta->group->instruktur->id;
        $qrcode = Instruktur::where('id', $ins)->value('qrcode');

        if ($this->token_absen === $qrcode) {

            // --- LOGIKA BATASAN PEMBAYARAN ---

            // Hitung jumlah absen yang sudah BERHASIL dilakukan (status = 2)
            $jumlahAbsenSelesai = Absen::where('id_peserta', $id)->where('status', 2)->count();

            // 1. Jika Belum Bayar sama sekali (Absen ke-1 gagal)
            if ($peserta->status_pembayaran === 'Belum Bayar' && $jumlahAbsenSelesai >= 0) {
                $this->dispatch('alert-fail', message: 'Gagal! Silahkan lakukan pembayaran terlebih dahulu sebelum absen pertama.');
                $this->dispatch('scannerReset');
                return;
            }

            // 2. Jika Belum Lunas (Hanya boleh 1x absen, absen ke-2 gagal)
            if ($peserta->status_pembayaran === 'Belum Lunas' && $jumlahAbsenSelesai >= 1) {
                $this->dispatch('alert-fail', message: 'Gagal! Silahkan lunasi pembayaran untuk melanjutkan absen berikutnya.');
                $this->dispatch('scannerReset');
                return;
            }

            // --- AKHIR LOGIKA PEMBAYARAN ---

            $waktu_sekarang = Carbon::now();
            $absen = Absen::where('id_peserta', $id)
                ->where('id_instruktur', $ins)
                ->where('status', 1)
                ->first();

            if ($absen) {
                $start_time = Carbon::parse($absen->waktu_mulai);

                if ($waktu_sekarang->greaterThanOrEqualTo($start_time)) {
                    $absen->update([
                        'status' => 2,
                        'waktu_absen' => Carbon::now()->toDateTimeString(),
                    ]);
                    $this->dispatch('alert-success', message: 'Berhasil melakukan absen.');
                } else {
                    $this->dispatch('alert-fail', message: 'Waktu absen belum dimulai.');
                }
            } else {
                $this->dispatch('alert-fail', message: 'Tidak Terdapat Jadwal.');
            }
        } else {
            $this->dispatch('alert-fail', message: 'Instruktur tidak sesuai.');
        }
        $this->dispatch('scannerReset');
    }
}