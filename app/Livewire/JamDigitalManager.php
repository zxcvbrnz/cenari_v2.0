<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\JamDigital;

class JamDigitalManager extends Component
{
    public string $runningText = '';
    public string $subText = '';
    public int $speed = 35;
    public int $size = 1;

    protected array $rules = [
        'runningText' => 'required|string|max:255',
        'subText'     => 'required|string|max:15',
        'speed'       => 'required|integer|min:10|max:150',
        'size'        => 'required|integer|in:1,2',
    ];

    public function mount(): void
    {
        $config = JamDigital::first();

        if ($config) {
            $this->runningText = $config->running_text;
            $this->subText     = $config->sub_text;
            $this->speed       = $config->speed;
            $this->size        = $config->size;
        }
    }

    public function save(): void
    {
        $this->validate();

        JamDigital::updateOrCreate(
            ['id' => 1], // Menggunakan 1 row setting utama
            [
                'running_text' => $this->runningText,
                'sub_text'     => $this->subText,
                'speed'        => $this->speed,
                'size'         => $this->size,
            ]
        );

        session()->flash('message', 'Pengaturan Jam Digital berhasil diperbarui!');
    }

    public function render()
    {
        return view('livewire.jam-digital-manager');
    }
}
