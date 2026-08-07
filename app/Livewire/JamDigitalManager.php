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

    // Mode Tampilan
    public bool $enableClock = true;
    public bool $enableText = true;
    public bool $enableAnim = true;
    public bool $enableInfo = true;
    public int $animType = 1;

    // Informasi Static
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
            $this->runningText = $config->running_text ?? $config->runningText ?? '';
            $this->subText     = $config->sub_text ?? $config->subText ?? '';
            $this->speed       = (int) ($config->speed ?? 35);
            $this->size        = (int) ($config->size ?? 1);

            // Inisialisasi Mode Tampilan (Support Snake & Camel Case)
            $this->enableClock = (bool) ($config->enable_clock ?? $config->enableClock ?? true);
            $this->enableText  = (bool) ($config->enable_text ?? $config->enableText ?? true);
            $this->enableAnim  = (bool) ($config->enable_anim ?? $config->enableAnim ?? true);
            $this->enableInfo  = (bool) ($config->enable_info ?? $config->enableInfo ?? true);
            $this->animType    = (int) ($config->anim_type ?? $config->animType ?? 1);

            // Inisialisasi Static Info
            $this->webUrl      = $config->web_url ?? $config->webUrl ?? 'cenari.sch.id';
            $this->contactInfo = $config->contact_info ?? $config->contactInfo ?? '081234567890';
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
                'enable_clock' => $this->enableClock,
                'enable_text'  => $this->enableText,
                'enable_anim'  => $this->enableAnim,
                'enable_info'  => $this->enableInfo,
                'anim_type'    => $this->animType,
                'web_url'      => $this->webUrl,
                'contact_info' => $this->contactInfo,
            ]
        );

        session()->flash('message', 'Pengaturan Jam Digital berhasil diperbarui!');
    }

    public function render()
    {
        return view('livewire.jam-digital-manager');
    }
}