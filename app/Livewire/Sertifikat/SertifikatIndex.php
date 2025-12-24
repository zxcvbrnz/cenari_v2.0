<?php

namespace App\Livewire\Sertifikat;

use App\Models\Peserta;
use App\Models\Sertifikat;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Silvanix\Wablas\Message;
use Livewire\WithFileUploads;

class SertifikatIndex extends Component
{
    use WithFileUploads;
    public $pesertas;
    public $pesertaSertifikats;

    public $id_peserta;
    public $sertifikat;
    public string $nomor_sertifikat;

    public function mount(): void
    {
        $this->pesertas = Sertifikat::where('link', null)
            ->whereHas('peserta', function ($query) {
                $query->where('status', 'aktif');
            })
            ->whereHas('peserta', function ($query) {
                $query->whereHas('nilai');
            })
            ->latest()->get();
        $this->pesertaSertifikats = Sertifikat::whereNotNull('link')->latest('updated_at')->get();
    }

    public function tambahSertifikat(): void
    {
        $this->validate([
            'id_peserta' => ['required'],
            'sertifikat' => ['required', 'max:1024'],
        ]);
        
        $send = new Message();
        $peserta = Peserta::findOrFail($this->id_peserta);

        if (!$peserta->nilai) {
            $this->dispatch('alert-fail', message: 'Peserta Belum Memiliki Nilai');
            return;
        }

        if ($this->sertifikat && $this->sertifikat->getPathname()) {
            $fileName = $this->sertifikat->getClientOriginalName();

            $this->sertifikat->StoreAs(path: 'public/sertifikat', name: $fileName);

            Sertifikat::where('id_peserta', $this->id_peserta)->update([
                'nomor_sertifikat' => $this->nomor_sertifikat,
                'link' => $fileName
            ]);
            Peserta::findOrFail($this->id_peserta)->update([
                'status' => 'nonaktif'
            ]);
            
            $wa = [
                [
                    'phone' => $peserta->nomor_telepon,
                    'message' => 'Halo *' . $peserta->user->name . '*' . '<br><br>' . 'Anda telah mendapatkan e-Sertifikat.' .
                        '<br>' . 'Sertifikat fisik dapat diambil ditempat kami dengan membawa 2 pas foto 3x4.' .
                        '<br><br>' . 'Silahkan buka link dibawah untuk melihat' .
                        '<br>' . 'www.kursus.cenari.sch.id',
                ],

            ];
            $send->multiple_text($wa);

            $this->reset('id_peserta', 'sertifikat');
            // $this->pesertas = Sertifikat::where('link', null)->latest()->get();
            // $this->pesertaSertifikats = Sertifikat::whereNotNull('link')->latest('updated_at')->get();
            $this->mount();
            $this->dispatch('reload-table-sertifikat');
            $this->dispatch('alert-success-1', message: 'Berhasil menambahkan sertifikat');
        } else {
            $this->dispatch('reload-table-sertifikat');
            $this->dispatch('alert-fail', message: 'Gagal menambahkan sertifikat');
        }
    }

    public function hapusSertifikat($id): void
    {
        $sertifikat = Sertifikat::findOrFail($id);
        Storage::disk('public')->delete('sertifikat/' . $sertifikat->link);
        $sertifikat->update([
            'nomor_sertifikat' => null,
            'link' => null
        ]);
        $this->mount();
        $this->dispatch('reload-table-sertifikat');
        $this->dispatch('alert-success-1', message: 'Berhasil menghapus sertifikat');
    }
}
