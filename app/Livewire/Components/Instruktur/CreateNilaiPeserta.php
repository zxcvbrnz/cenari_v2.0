<?php

namespace App\Livewire\Components\Instruktur;

use App\Models\Nilai;
use App\Models\Peserta;
use App\Models\Setting;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Silvanix\Wablas\Message;


class CreateNilaiPeserta extends Component
{
    public $peserta;
    public $nilai;
    public $mapel;
    public $status;

    public array $postNilai = [
        'id_peserta' => '',
        'materi_1' => '',
        'materi_2' => '',
        'materi_3' => '',
        'materi_4' => '',
        'materi_5' => '',
        'materi_6' => '',
        'materi_7' => '',
        'materi_8' => '',
        'materi_9' => '',
        'materi_10' => '',
        'nilai_1' => null,
        'nilai_2' => null,
        'nilai_3' => null,
        'nilai_4' => null,
        'nilai_5' => null,
        'nilai_6' => null,
        'nilai_7' => null,
        'nilai_8' => null,
        'nilai_9' => null,
        'nilai_10' => null,
    ];

    public function mount(Peserta $peserta): void
    {
        $this->peserta = $peserta;
        $this->mapel = $peserta->mapel ?? $peserta->group->mapel;
        $this->status = $peserta->group ? $peserta->group->status : $peserta->status;
        $this->postNilai['id_peserta'] = $peserta->id;

        for ($i = 1; $i <= 10; $i++) {
            $this->postNilai["materi_$i"] = $peserta->nilai ? $peserta->nilai->{"materi_$i"} : $this->mapel->{"materi_$i"};
            if ($peserta->nilai) {
                $this->postNilai["nilai_$i"] = $peserta->nilai->{"nilai_$i"};
            }
        }
    }


    public function postNilaiPeserta(): void
    {
        // Validate the data
        $validatedData = $this->validate([
            'postNilai.id_peserta' => 'required|exists:pesertas,id',
            'postNilai.materi_1' => 'required|string',
            'postNilai.materi_2' => 'nullable|string',
            'postNilai.materi_3' => 'nullable|string',
            'postNilai.materi_4' => 'nullable|string',
            'postNilai.materi_5' => 'nullable|string',
            'postNilai.materi_6' => 'nullable|string',
            'postNilai.materi_7' => 'nullable|string',
            'postNilai.materi_8' => 'nullable|string',
            'postNilai.materi_9' => 'nullable|string',
            'postNilai.materi_10' => 'nullable|string',
            'postNilai.nilai_1' => 'required|numeric',
            'postNilai.nilai_2' => 'nullable|numeric',
            'postNilai.nilai_3' => 'nullable|numeric',
            'postNilai.nilai_4' => 'nullable|numeric',
            'postNilai.nilai_5' => 'nullable|numeric',
            'postNilai.nilai_6' => 'nullable|numeric',
            'postNilai.nilai_7' => 'nullable|numeric',
            'postNilai.nilai_8' => 'nullable|numeric',
            'postNilai.nilai_9' => 'nullable|numeric',
            'postNilai.nilai_10' => 'nullable|numeric',
        ]);
        if ($this->status === 'nonaktif') {
                $this->dispatch('alert-fail', message: 'Tidak dapat mengubah peserta nonaktif');
                    return;
        }
        $setting = Setting::findOrFail(1);
        if ($setting->value === 'ON') {
            if ($this->peserta->id_group) {
                if ($this->peserta->riwayatAbsensi->count() < 1) {
                    $this->dispatch('alert-fail', message: 'Belum terdapat absensi untuk peserta');
                    return;
                }
            } else {
                if ($this->peserta->riwayatAbsensi->count() < 1) {
                    $this->dispatch('alert-fail', message: 'Belum terdapat absensi untuk peserta');
                    return;
                } elseif ($this->peserta->riwayatAbsensi->count() < 10) {
                    $this->dispatch('alert-fail', message: 'Peserta belum menyelesaikan kursus');
                    return;
                }
            }
        }

        if (
            !$validatedData['postNilai']['nilai_1'] &&
            !$validatedData['postNilai']['nilai_2'] &&
            !$validatedData['postNilai']['nilai_3'] &&
            !$validatedData['postNilai']['nilai_4'] &&
            !$validatedData['postNilai']['nilai_5'] &&
            !$validatedData['postNilai']['nilai_6'] &&
            !$validatedData['postNilai']['nilai_7'] &&
            !$validatedData['postNilai']['nilai_8'] &&
            !$validatedData['postNilai']['nilai_9'] &&
            !$validatedData['postNilai']['nilai_10']
        ) {
            return;
        }

        $nilai = Nilai::firstOrNew(['id_peserta' => $validatedData['postNilai']['id_peserta']]);

        foreach (range(1, 10) as $i) {
            $nilai->{"materi_$i"} = $validatedData['postNilai']["materi_$i"];
            $nilai->{"nilai_$i"} = $validatedData['postNilai']["nilai_$i"];
        }

        $nilai->save();
        $send = new Message();

        $wa = [
            [
                'phone' => env('ADMIN_NUMBER'),
                'message' => 'Halo *Admin*' . '<br><br>' . ' Insturktur *' . Auth::user()->name .  '* Telah memberikan nilai ke peserta *' . $this->peserta->user->name .
                    '*<br>' . 'www.kursus.cenari.sch.id',
            ],

        ];
        $send->multiple_text($wa);

        $wa = [
            [
                'phone' => env('ADMIN_NUMBER_2'),
                'message' => 'Halo *Admin*' . '<br><br>' . ' Insturktur *' . Auth::user()->name .  '* Telah memberikan nilai ke peserta *' . $this->peserta->user->name .
                    '*<br>' . 'www.kursus.cenari.sch.id',
            ],

        ];
        $send->multiple_text($wa);

        $this->dispatch('alert-success', message: 'Berhasil menambah nilai.');
    }
}