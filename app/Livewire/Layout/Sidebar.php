<?php

namespace App\Livewire\Layout;

use Livewire\Component;
use App\Models\Absen;
use App\Models\Message;
use App\Models\Setting;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;

class Sidebar extends Component
{
    public $role;
    public $isOpen = false;
    public $permohonan;
    public $unreadMessages;
    public $settingWhatsapp;

    public function mount(): void
    {
        $this->role = Auth::user()->role;

        // Cukup panggil method ini sekali di mount
        $this->loadSettings();

        // Query Unread Messages
        $this->unreadMessages = Message::where('direction', 'inbound')
            ->where('status', 'unread')
            ->count();

        // Query Permohonan
        $permohonanPrivate = Absen::where('status', 0)->whereNull('id_group')->count();
        $permohonanGroup = Absen::select('id_group', 'id_instruktur', 'waktu_mulai', 'keterangan')
            ->where('status', 0)
            ->whereNotNull('id_group')
            ->groupBy('id_group', 'id_instruktur', 'waktu_mulai', 'keterangan')
            ->get()
            ->count();

        $this->permohonan = $permohonanPrivate + $permohonanGroup;
    }

    #[On('whatsapp-setting-updated')]
    public function loadSettings(): void
    {
        // Cari berdasarkan ID atau kolom 'key' agar lebih fleksibel
        $this->settingWhatsapp = Setting::find(3);
        // Atau jika menggunakan key:
        // $this->settingWhatsapp = Setting::where('key', 'whatsapp')->first();
    }

    public function render()
    {
        return view('livewire.layout.sidebar');
    }
}
