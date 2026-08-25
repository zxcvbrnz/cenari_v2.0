<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\JamDigital;

class JamDigitalManager extends Component
{
    public string $running_text = '';
    public string $sub_text = '';
    public int $speed = 35;
    public int $size = 1;
    public int $clockSize = 1;

    public bool $enableClock = true;
    public bool $enableText = true;
    public bool $enableAnim = true;
    public bool $enableInfo = true;
    public int $animType = 1;

    public string $webUrl = '';
    public string $contactInfo = '';

    // 3 Field Tambahan
    public int $brightness = 7;
    public int $timeFormat = 24;
    public int $timezone = 8;

    protected array $rules = [
        'running_text' => 'required|string|max:255',
        'sub_text'     => 'required|string|max:15',
        'speed'        => 'required|integer|min:10|max:150',
        'size'         => 'required|integer|in:1,2',
        'clockSize'    => 'required|integer|in:1,2',
        'enableClock'  => 'boolean',
        'enableText'   => 'boolean',
        'enableAnim'   => 'boolean',
        'enableInfo'   => 'boolean',
        'animType'     => 'required|integer|in:1,2,3,4,5,6,7,8,9,10',
        'webUrl'       => 'required|string|max:255',
        'contactInfo'  => 'required|string|max:50',
        'brightness'   => 'required|integer|min:0|max:15',
        'timeFormat'   => 'required|integer|in:12,24',
        'timezone'     => 'required|integer|in:7,8,9',
    ];

    public function mount(): void
    {
        $config = JamDigital::first();

        if ($config) {
            $this->running_text = $config->running_text ?? '';
            $this->sub_text     = $config->sub_text ?? '';
            $this->speed        = (int) ($config->speed ?? 35);
            $this->size         = (int) ($config->size ?? 1);
            $this->clockSize    = (int) ($config->clockSize ?? 1);
            $this->enableClock  = (bool) ($config->enableClock ?? true);
            $this->enableText   = (bool) ($config->enableText ?? true);
            $this->enableAnim   = (bool) ($config->enableAnim ?? true);
            $this->enableInfo   = (bool) ($config->enableInfo ?? true);
            $this->animType     = (int) ($config->animType ?? 1);
            $this->webUrl       = $config->webUrl ?? '';
            $this->contactInfo  = $config->contactInfo ?? '';
            $this->brightness   = (int) ($config->brightness ?? 7);
            $this->timeFormat   = (int) ($config->timeFormat ?? 24);
            $this->timezone     = (int) ($config->timezone ?? 8);
        }
    }

    public function save(): void
    {
        $this->validate();

        JamDigital::updateOrCreate(
            ['id' => 1],
            [
                'running_text' => $this->running_text,
                'sub_text'     => $this->sub_text,
                'speed'        => $this->speed,
                'size'         => $this->size,
                'clockSize'    => $this->clockSize,
                'enableClock'  => $this->enableClock,
                'enableText'   => $this->enableText,
                'enableAnim'   => $this->enableAnim,
                'enableInfo'   => $this->enableInfo,
                'animType'     => $this->animType,
                'webUrl'       => $this->webUrl,
                'contactInfo'  => $this->contactInfo,
                'brightness'   => $this->brightness,
                'timeFormat'   => $this->timeFormat,
                'timezone'     => $this->timezone,
            ]
        );

        session()->flash('message', 'Pengaturan Jam Digital berhasil disimpan!');
    }

    public function render()
    {
        return view('livewire.jam-digital-manager');
    }
}
