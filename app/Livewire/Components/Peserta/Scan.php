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
        $id = auth()->user()->id_peserta;
        $ins = auth()->user()->peserta->id_instruktur ? auth()->user()->peserta->instruktur->id : auth()->user()->peserta->group->instruktur->id;
        $qrcode = Instruktur::where('id', $ins)->value('qrcode');

        if ($this->token_absen === $qrcode) {
            $waktu_sekarang = Carbon::now();
            $absen = Absen::where('id_peserta', $id)->where('id_instruktur', $ins)->where('status', 1)->first();
            if ($absen) {
                $start_time = Carbon::parse($absen->waktu_mulai);

                if ($waktu_sekarang->greaterThanOrEqualTo($start_time)) {
                    $absen->update([
                        'status' => 2,
                        'waktu_absen' =>Carbon::now()->toDateTimeString(),
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
