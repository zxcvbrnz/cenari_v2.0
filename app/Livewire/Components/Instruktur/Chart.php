<?php

namespace App\Livewire\Components\Instruktur;

use App\Models\Absen;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use SimpleSoftwareIO\QrCode\Facades\QrCode;


class Chart extends Component
{
    public string $qrcode;
    public $jadwalPrivate;
    public $jadwalGroup;
    public $jadwalCount;

    public function mount(): void
    {
        $data = Auth::user();
        $this->jadwalPrivate = Absen::where('id_instruktur', $data->id_instruktur)->where('status', 1)->where('id_group', null)->latest()->get();
        $this->jadwalGroup = Absen::select('id_group', 'id_instruktur', 'nama_group', 'nama_instruktur', 'waktu_mulai', 'keterangan')
                ->where('id_instruktur', $data->id_instruktur)
                ->where('status', 1)
                ->whereNotNull('id_group')
                ->groupBy('id_group', 'id_instruktur',  'nama_group', 'nama_instruktur', 'waktu_mulai', 'keterangan')
                ->latest()
                ->get();
        $this->qrcode = QrCode::size(250)->generate($data->instruktur->qrcode);
        $this->jadwalCount = $this->jadwalPrivate->count() + $this->jadwalGroup->count();
    }
}