<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Message;
use App\Facades\Whatsapp;
use Illuminate\Support\Facades\DB;

class WhatsAppChat extends Component
{
    public $selectedPhone = null;
    public $replyMessage = '';

    // Modal state & input
    public $showNewChatModal = false;
    public $newPhone = '';

    protected $listeners = ['refreshChat' => '$refresh'];

    public function selectContact($phone)
    {
        $this->selectedPhone = $phone;

        // Tandai pesan belum dibaca menjadi dibaca (read)
        Message::where('phone_number', $phone)
            ->where('status', 'unread')
            ->update(['status' => 'read']);
    }

    public function openNewChat()
    {
        $this->validate([
            'newPhone' => 'required|numeric|digits_between:9,15'
        ], [
            'newPhone.required' => 'Nomor WhatsApp wajib diisi.',
            'newPhone.numeric' => 'Nomor WhatsApp hanya boleh berupa angka.',
            'newPhone.digits_between' => 'Nomor WhatsApp tidak valid (terlalu pendek/panjang).'
        ]);

        // Otomatis ubah awalan 08xx menjadi 628xx
        $formattedPhone = preg_replace('/^0/', '62', preg_replace('/[^0-9]/', '', $this->newPhone));

        $this->selectedPhone = $formattedPhone;
        $this->newPhone = '';
        $this->showNewChatModal = false;
    }

    public function sendMessage()
    {
        $this->validate([
            'replyMessage' => 'required|string',
            'selectedPhone' => 'required'
        ], [
            'replyMessage.required' => 'Tulis pesan terlebih dahulu.'
        ]);

        // 1. Kirim via Facade WhatsApp Meta
        $status = Whatsapp::sendText($this->selectedPhone, $this->replyMessage);

        if ($status) {
            // 2. Simpan ke database
            Message::create([
                'phone_number' => $this->selectedPhone,
                'direction'    => 'outbound',
                'body'         => $this->replyMessage,
                'status'       => 'sent'
            ]);

            $this->reset('replyMessage');
        } else {
            session()->flash('error', 'Gagal mengirim pesan via API. Pastikan sesi 24 jam dengan kontak masih aktif.');
        }
    }

    public function render()
    {
        $contacts = Message::select('phone_number', DB::raw('MAX(created_at) as last_chat'))
            ->groupBy('phone_number')
            ->orderBy('last_chat', 'desc')
            ->get();

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
