<?php

namespace App\Livewire\Components\Instruktur;

use App\Models\Absen;
use App\Models\Group;
use App\Models\Peserta;
use App\Models\User;
use Silvanix\Wablas\Message;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class DaftarPermohonan extends Component
{

    public string $id_instruktur = '';
    public string $id_peserta = '';
    public string $id_group = '';
    public string $nama_group = '';
    public string $nama_peserta = '';
    public string $nama_instruktur = '';
    public string $waktu_mulai = '';
    public string $keterangan = '';

    public $peserta;
    public $pelatihan;
    public $permohonanPrivate;
    public $permohonanGroup;
    public $permohonanDitolak;

    public function mount(): void
    {
        $this->id_instruktur = Auth::user()->id_instruktur;
        $this->nama_instruktur = Auth::user()->name;
        $this->peserta = Peserta::where('id_instruktur', $this->id_instruktur)
            ->where('status', 'aktif')
            ->with('user')
            ->get();
        $this->pelatihan = Group::where('id_instruktur', $this->id_instruktur)->where('status', 'aktif')->get();
        $this->permohonanPrivate = Absen::where('id_instruktur', $this->id_instruktur)->where('status', 0)->where('id_group', null)->latest()->get();
        $this->permohonanGroup = Absen::select('id_group', 'nama_group', 'waktu_mulai', 'keterangan')->where('id_instruktur', $this->id_instruktur)->where('status', 0)->whereNotNull('id_group')
            ->groupBy('id_group', 'nama_group', 'waktu_mulai', 'keterangan')
            ->latest()->get();
        $this->permohonanDitolak = Absen::where('id_instruktur', $this->id_instruktur)->where('status', 3)->where('id_group', null)->latest()->get();
    }
    public function create_permohonan(): void
    {
        $id_group = $this->id_group;
        $send = new Message();
        if ($id_group) {
            $peserta = Peserta::where('id_group', $this->id_group)
                ->get();
            $this->nama_group = Group::findOrFail($id_group)->nama;
            foreach ($peserta as $data) {
                Absen::create([
                    'id_instruktur' => $this->id_instruktur,
                    'id_peserta' => $data->id,
                    'id_group' => $this->id_group,
                    'nama_group' => $this->nama_group,
                    'nama_peserta' => $data->user->name,
                    'nama_instruktur' => $this->nama_instruktur,
                    'waktu_mulai' => $this->waktu_mulai,
                    'keterangan' => $this->keterangan,
                    'status' => 0,
                ]);
            }
            $wa = [
                [
                    'phone' => env('ADMIN_NUMBER'),
                    'message' => 'Halo *Admin*' . '<br><br>' . ' Terdapat Permohonan Dari Group *' . $this->nama_group .
                        '*<br><br>' . 'Silahkan Verifikasi Dibawah ini' .
                        '<br>' . 'www.kursus.cenari.sch.id',
                ],

            ];
            $send->multiple_text($wa);
        } else {
            $peserta = User::where('id_peserta', $this->id_peserta)->value('name');
            Absen::create([
                'id_instruktur' => $this->id_instruktur,
                'id_peserta' => $this->id_peserta,
                'nama_peserta' => $peserta,
                'nama_instruktur' => $this->nama_instruktur,
                'waktu_mulai' => $this->waktu_mulai,
                'keterangan' => $this->keterangan,
                'status' => 0,
            ]);
            $wa = [
                [
                    'phone' => env('ADMIN_NUMBER'),
                    'message' => 'Halo *Admin*' . '<br><br>' . ' Terdapat Permohonan Dari Instruktur *' . $this->nama_instruktur .
                        '*<br><br>' . 'Silahkan Verifikasi Dibawah ini' .
                        '<br>' . 'www.kursus.cenari.sch.id',
                ],

            ];
            $send->multiple_text($wa);
        }
        $this->permohonanPrivate = Absen::where('id_instruktur', $this->id_instruktur)->where('status', 0)->where('id_group', null)->latest()->get();
        $this->permohonanGroup = Absen::select('id_group', 'nama_group', 'waktu_mulai', 'keterangan')->where('id_instruktur', $this->id_instruktur)->where('status', 0)->whereNotNull('id_group')
            ->groupBy('id_group', 'nama_group', 'waktu_mulai', 'keterangan')
                ->latest()->get();
        $this->id_instruktur = '';
        $this->id_peserta = '';
        $this->id_group = '';
        $this->nama_group = '';
        $this->nama_peserta = '';
        $this->nama_instruktur = '';
        $this->waktu_mulai = '';
        $this->keterangan = '';
        $this->dispatch('alert-success', message: 'Permohonan berhasil dibuat.');
    }
}
