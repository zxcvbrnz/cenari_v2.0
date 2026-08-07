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

    // Properti Baru
    public bool $enableClock = true;
    public bool $enableText = true;
    public bool $enableAnim = true;
    public int $animType = 1;

    protected array $rules = [
        'runningText' => 'required|string|max:255',
        'subText'     => 'required|string|max:15',
        'speed'       => 'required|integer|min:10|max:150',
        'size'        => 'required|integer|in:1,2',
        'enableClock' => 'boolean',
        'enableText'  => 'boolean',
        'enableAnim'  => 'boolean',
        'animType'    => 'required|integer|in:1,2,3',
    ];

    public function mount(): void
    {
        $config = JamDigital::first();

        if ($config) {
            $this->runningText = $config->running_text ?? $config->runningText;
            $this->subText     = $config->sub_text ?? $config->subText;
            $this->speed       = $config->speed;
            $this->size        = $config->size;

            // Inisialisasi Nilai Baru (dengan fallback nilai default)
            $this->enableClock = $config->enableClock ?? true;
            $this->enableText  = $config->enableText ?? true;
            $this->enableAnim  = $config->enableAnim ?? true;
            $this->animType    = $config->animType ?? 1;
        }
    }

    public function save(): void
    {
        $this->validate();

        // Validasi opsional: Minimal harus ada 1 mode tampilan yang aktif
        if (!$this->enableClock && !$this->enableText && !$this->enableAnim) {
            $this->enableClock = true;
        }

        JamDigital::updateOrCreate(
            ['id' => 1],
            [
                'running_text' => $this->runningText,
                'sub_text'     => $this->subText,
                'speed'        => $this->speed,
                'size'         => $this->size,
                'enableClock'  => $this->enableClock,
                'enableText'   => $this->enableText,
                'enableAnim'   => $this->enableAnim,
                'animType'     => $this->animType,
            ]
        );

        session()->flash('message', 'Pengaturan Jam Digital berhasil diperbarui!');
    }

    public function render()
    {
        return view('livewire.jam-digital-manager');
    }
}
