<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\JamDigital;

class JamDigitalManager extends Component
{
    public string $running_text = '';
    public string $sub_text = '';
    public string $web_url = '';
    public string $contact_info = '';

    public int $speed = 35;
    public int $size = 1;
    public int $clockSize = 1;

    public bool $enableClock = true;
    public bool $enableText = true;
    public bool $enableAnim = true;
    public bool $enableInfo = true;
    public int $animType = 1;

    // Field Hardware & Schedule (JSON Array)
    public bool $matrixPower = true;
    public bool $enableSchedule = true;
    public string $onTime = '06:00';
    public string $offTime = '22:00';

    protected array $rules = [
        'running_text'   => 'required|string|max:255',
        'sub_text'       => 'nullable|string|max:15',
        'web_url'        => 'nullable|string|max:255',
        'contact_info'   => 'nullable|string|max:50',
        'speed'          => 'required|integer|min:10|max:150',
        'size'           => 'required|integer|in:1,2',
        'clockSize'      => 'required|integer|in:1,2',
        'enableClock'    => 'boolean',
        'enableText'     => 'boolean',
        'enableAnim'     => 'boolean',
        'enableInfo'     => 'boolean',
        'animType'       => 'required|integer|in:1,2,3,4,5,6,7,8,9,10',
        'matrixPower'    => 'boolean',
        'enableSchedule' => 'boolean',
        'onTime'         => 'required|date_format:H:i',
        'offTime'        => 'required|date_format:H:i',
    ];

    public function mount(): void
    {
        $config = JamDigital::first();

        if ($config) {
            $this->running_text   = $config->running_text ?? '';
            $this->sub_text       = $config->sub_text ?? '';
            $this->web_url        = $config->web_url ?? '';
            $this->contact_info   = $config->contact_info ?? '';
            $this->speed          = (int) ($config->speed ?? 35);
            $this->size           = (int) ($config->size ?? 1);
            $this->clockSize      = (int) ($config->clockSize ?? 1);
            $this->enableClock    = (bool) ($config->enableClock ?? true);
            $this->enableText     = (bool) ($config->enableText ?? true);
            $this->enableAnim     = (bool) ($config->enableAnim ?? true);
            $this->enableInfo     = (bool) ($config->enableInfo ?? true);
            $this->animType       = (int) ($config->animType ?? 1);
            $this->matrixPower    = (bool) ($config->matrixPower ?? true);

            // Ekstrak data JSON schedule dari database
            $scheduleData         = $config->schedule ?? [];
            $this->enableSchedule = (bool) ($scheduleData['enable'] ?? true);
            $this->onTime         = $scheduleData['on_time'] ?? '06:00';
            $this->offTime        = $scheduleData['off_time'] ?? '22:00';
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
                'web_url'      => $this->web_url,
                'contact_info' => $this->contact_info,
                'speed'        => $this->speed,
                'size'         => $this->size,
                'clockSize'    => $this->clockSize,
                'enableClock'  => $this->enableClock,
                'enableText'   => $this->enableText,
                'enableAnim'   => $this->enableAnim,
                'enableInfo'   => $this->enableInfo,
                'animType'     => $this->animType,
                'matrixPower'  => $this->matrixPower,
                // Disimpan sebagai array (otomatis dikonversi ke JSON oleh $casts model)
                'schedule'     => [
                    'enable'   => $this->enableSchedule,
                    'on_time'  => $this->onTime,
                    'off_time' => $this->offTime,
                ],
            ]
        );

        session()->flash('message', 'Pengaturan Jam Digital berhasil disimpan!');
    }

    public function render()
    {
        return view('livewire.jam-digital-manager');
    }
}
