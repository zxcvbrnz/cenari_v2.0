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

    // Properti Mode Tampilan
    public bool $enableClock = true;
    public bool $enableText = true;
    public bool $enableAnim = true;
    public bool $enableInfo = true; // Tambahan Baru
    public int $animType = 1;

    // Properti Info Static Tambahan
    public string $webUrl = 'cenari.sch.id';
    public string $contactInfo = '081234567890';

    protected array $rules = [
        'runningText' => 'required|string|max:255',
        'subText'     => 'required|string|max:15',
        'speed'       => 'required|integer|min:10|max:150',
        'size'        => 'required|integer|in:1,2',
        'enableClock' => 'boolean',
        'enableText'  => 'boolean',
        'enableAnim'  => 'boolean',
        'enableInfo'  => 'boolean',
        'animType'    => 'required|integer|in:1,2,3',
        'webUrl'      => 'required|string|max:255',
        'contactInfo' => 'required|string|max:50',
    ];

    public function mount(): void
    {
        $config = JamDigital::first();

        if ($config) {
            $this->runningText = $config->running_text ?? $config->runningText;
            $this->subText     = $config->sub_text ?? $config->subText;
            $this->speed       = $config->speed;
            $this->size        = $config->size;

            // Inisialisasi Pengaturan Mode Tampilan
            $this->enableClock = $config->enableClock ?? true;
            $this->enableText  = $config->enableText ?? true;
            $this->enableAnim  = $config->enableAnim ?? true;
            $this->enableInfo  = $config->enableInfo ?? true;
            $this->animType    = $config->animType ?? 1;

            // Inisialisasi Teks Static Info
            $this->webUrl      = $config->webUrl ?? 'cenari.sch.id';
            $this->contactInfo = $config->contactInfo ?? '081234567890';
        }
    }

    public function save(): void
    {
        $this->validate();

        // Validasi opsional: Minimal harus ada 1 mode tampilan yang aktif
        if (!$this->enableClock && !$this->enableText && !$this->enableAnim && !$this->enableInfo) {
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
                'enableInfo'   => $this->enableInfo,
                'animType'     => $this->animType,
                'webUrl'       => $this->webUrl,
                'contactInfo'  => $this->contactInfo,
            ]
        );

        session()->flash('message', 'Pengaturan Jam Digital berhasil diperbarui!');
    }

    public function render()
    {
        return view('livewire.jam-digital-manager');
    }
}
