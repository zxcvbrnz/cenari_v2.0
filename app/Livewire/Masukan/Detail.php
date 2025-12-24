<?php

namespace App\Livewire\Masukan;

use App\Models\Pesan;
use Livewire\Component;

class Detail extends Component
{
    public $masukan;

    public string $subject;
    public $message;
    public $reply;
    public function mount($id): void
    {
        $this->masukan = Pesan::findOrFail($id);
        $this->subject = $this->masukan->subject;
        $this->message = $this->masukan->message;
        $this->reply = $this->masukan->reply;
    }

    public function balasan(): void
    {
        $this->masukan->update([
            'reply' => $this->reply,
        ]);
        $this->dispatch('alert-success', message: 'Berhasil memberikan balasan');
    }
}
