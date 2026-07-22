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
        $this->loadSettings();
        $this->role = Auth::user()->role;
        $this->settingWhatsapp = Setting::findOrFail(3);
        $this->unreadMessages = Message::where('direction', 'inbound')
            ->where('status', 'unread') // atau 'received'
            ->count();
        $permohonanPrivate = Absen::where('status', 0)->where('id_group', null)->count();
        $permohonanGroup = Absen::select('id_group', 'id_instruktur', 'waktu_mulai', 'keterangan')
            ->where('status', 0)
            ->whereNotNull('id_group')
            ->groupBy('id_group', 'id_instruktur', 'waktu_mulai', 'keterangan')
            ->get()
            ->count();

        $this->permohonan = $permohonanPrivate + $permohonanGroup;
    }
    #[On('whatsapp-setting-updated')]
    public function loadSettings()
    {
        $this->settingWhatsapp = Setting::findOrFail(3);
    }
    public function render()
    {
        return view('livewire.layout.sidebar');
    }
}
