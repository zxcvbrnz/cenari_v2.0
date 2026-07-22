<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Message;
use App\Facades\Whatsapp; // Sesuaikan dengan namespace Facade milikmu
use Illuminate\Support\Facades\DB;

class WhatsAppChat extends Component
{
    public $selectedPhone = null;
    public $replyMessage = '';

    // Auto refresh setiap 3 detik untuk mengecek pesan baru masuk
    protected $listeners = ['refreshChat' => '$refresh'];

    public function selectContact($phone)
    {
        $this->selectedPhone = $phone;
    }

    public function sendMessage()
    {
        $this->validate([
            'replyMessage' => 'required|string',
            'selectedPhone' => 'required'
        ]);

        // 1. Kirim via Facade WhatsApp Meta
        $status = Whatsapp::sendText($this->selectedPhone, $this->replyMessage);

        if ($status) {
            // 2. Simpan pesan outbound ke database
            Message::create([
                'phone_number' => $this->selectedPhone,
                'direction'    => 'outbound',
                'body'         => $this->replyMessage,
                'status'       => 'sent'
            ]);

            $this->replyMessage = '';
        } else {
            session()->flash('error', 'Gagal mengirim pesan via API Meta. Pastikan sesi 24 jam masih aktif.');
        }
    }

    public function render()
    {
        // Ambil daftar kontak unik yang pernah chat
        $contacts = Message::select('phone_number', DB::raw('MAX(created_at) as last_chat'))
            ->groupBy('phone_number')
            ->orderBy('last_chat', 'desc')
            ->get();

        // Ambil riwayat chat untuk kontak yang terpilih
        $messages = [];
        if ($this->selectedPhone) {
            $messages = Message::where('phone_number', $this->selectedPhone)
                ->orderBy('created_at', 'asc')
                ->get();
        }

        return view('livewire.whats-app-chat', [
            'contacts' => $contacts,
            'messages' => $messages,
        ]);
    }
}