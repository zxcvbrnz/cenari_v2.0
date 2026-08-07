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
    public int $clockSize = 1;

    public bool $enableClock = true;
    public bool $enableText = true;
    public bool $enableAnim = true;
    public bool $enableInfo = true;
    public int $animType = 1;

    public string $webUrl = '';
    public string $contactInfo = '';

    protected array $rules = [
        'runningText' => 'required|string|max:255',
        'subText'     => 'required|string|max:15',
        'speed'       => 'required|integer|min:10|max:150',
        'size'        => 'required|integer|in:1,2',
        'clockSize'   => 'required|integer|in:1,2',
        'enableClock' => 'boolean',
        'enableText'  => 'boolean',
        'enableAnim'  => 'boolean',
        'enableInfo'  => 'boolean',
        'animType'    => 'required|integer|in:1,2,3,4,5,6,7,8,9,10',
        'webUrl'      => 'required|string|max:255',
        'contactInfo' => 'required|string|max:50',
    ];

    public function mount(): void
    {
        $config = JamDigital::first();

        if ($config) {
            $this->runningText = $config->runningText ?? '';
            $this->subText     = $config->subText ?? '';
            $this->speed       = (int) ($config->speed ?? 35);
            $this->size        = (int) ($config->size ?? 1);
            $this->clockSize   = (int) ($config->clockSize ?? 1);
            $this->enableClock = (bool) ($config->enableClock ?? true);
            $this->enableText  = (bool) ($config->enableText ?? true);
            $this->enableAnim  = (bool) ($config->enableAnim ?? true);
            $this->enableInfo  = (bool) ($config->enableInfo ?? true);
            $this->animType    = (int) ($config->animType ?? 1);
            $this->webUrl      = $config->webUrl ?? '';
            $this->contactInfo = $config->contactInfo ?? '';
        }
    }

    public function save(): void
    {
        $this->validate();

        JamDigital::updateOrCreate(
            ['id' => 1],
            [
                'runningText' => $this->runningText,
                'subText'     => $this->subText,
                'speed'       => $this->speed,
                'size'        => $this->size,
                'clockSize'   => $this->clockSize,
                'enableClock' => $this->enableClock,
                'enableText'  => $this->enableText,
                'enableAnim'  => $this->enableAnim,
                'enableInfo'  => $this->enableInfo,
                'animType'    => $this->animType,
                'webUrl'      => $this->webUrl,
                'contactInfo' => $this->contactInfo,
            ]
        );

        session()->flash('message', 'Pengaturan Jam Digital berhasil disimpan!');
    }

    public function render()
    {
        return view('livewire.jam-digital-manager');
    }
}
