<?php

namespace App\Livewire\Masukan;

use App\Models\Pesan;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class MasukanIndex extends Component
{
    public $masukans;

    public string $subject;
    public $message;

    public function mount(): void
    {
        if (Auth::user()->role === 'admin') {
            $this->masukans = Pesan::latest()->get();
        } else {
            $this->masukans = Pesan::where('id_user', Auth::user()->id)->latest()->get();
        }
    }

    public function createMasukan(): void
    {
        if(Auth::user()->role === 'peserta') {
            if(Auth::user()->peserta->status === 'nonaktif') {
                $this->dispatch('alert-fail', message: 'Anda sekarang tidak dapat memberikan masukkan atau saran!');
                return;
            }
        }
        
        $this->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);
        Pesan::create([
            'id_user' => Auth::user()->id,
            'subject' => $this->subject,
            'message' => $this->message,
        ]);
        $this->reset('subject', 'message');
        $this->masukans = Pesan::where('id_user', Auth::user()->id)->latest()->get();
        $this->dispatch('alert-success-1', message: 'Berhasil memberikan masukan atau saran');
    }

    public function hapusPesan($id): void
    {
        Pesan::findOrFail($id)->delete();
        $this->masukans = Pesan::where('id_user', Auth::user()->id)->latest()->get();
        $this->dispatch('alert-success-1', message: 'Berhasil menghapus masukan atau saran');
    }
}