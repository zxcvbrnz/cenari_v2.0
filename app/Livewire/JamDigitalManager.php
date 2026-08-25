<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\JamDigital;

class JamDigitalManager extends Component
{
    // Field Pengaturan Teks & Tampilan
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

    public bool $matrixPower = true;

    // Array Jadwal 7 Hari (Senin - Minggu)
    public array $schedules = [];

    protected array $rules = [
        'running_text'           => 'required|string|max:255',
        'sub_text'               => 'nullable|string|max:15',
        'web_url'                => 'nullable|string|max:255',
        'contact_info'           => 'nullable|string|max:50',
        'speed'                  => 'required|integer|min:10|max:150',
        'size'                   => 'required|integer|in:1,2',
        'clockSize'              => 'required|integer|in:1,2',
        'enableClock'            => 'boolean',
        'enableText'             => 'boolean',
        'enableAnim'             => 'boolean',
        'enableInfo'             => 'boolean',
        'animType'               => 'required|integer|in:1,2,3,4,5,6,7,8,9,10',
        'matrixPower'            => 'boolean',
        'schedules.*.enabled'    => 'boolean',
        'schedules.*.start_time' => 'required|date_format:H:i',
        'schedules.*.end_time'   => 'required|date_format:H:i',
    ];

    public function mount(): void
    {
        $config = JamDigital::first();
        $dayNames = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];

        if ($config) {
            $this->running_text   = $config->running_text ?? '';
            $this->sub_text       = $config->sub_text ?? '';
            $this->web_url        = $config->web_url ?? '';
            $this->contact_info   = $config->contact_info ?? '';
            $this->speed          = (int) ($config->speed ?? 35);
            $this->size           = (int) ($config->size ?? 1);
            $this->clockSize      = (int) ($config->clock_size ?? 1);
            $this->enableClock    = (bool) ($config->enableClock ?? true);
            $this->enableText     = (bool) ($config->enableText ?? true);
            $this->enableAnim     = (bool) ($config->enableAnim ?? true);
            $this->enableInfo     = (bool) ($config->enableInfo ?? true);
            $this->animType       = (int) ($config->animType ?? 1);
            $this->matrixPower    = (bool) ($config->matrix_power ?? true);

            $savedSchedule = $config->schedule ?? [];

            foreach ($dayNames as $index => $dayName) {
                $item = $savedSchedule[$index] ?? null;

                $startH = isset($item['startHour']) ? sprintf('%02d', $item['startHour']) : '06';
                $startM = isset($item['startMinute']) ? sprintf('%02d', $item['startMinute']) : '00';
                $endH   = isset($item['endHour']) ? sprintf('%02d', $item['endHour']) : '22';
                $endM   = isset($item['endMinute']) ? sprintf('%02d', $item['endMinute']) : '00';

                $this->schedules[$index] = [
                    'day_name'   => $dayName,
                    'enabled'    => isset($item['enabled']) ? (bool) $item['enabled'] : ($index < 6),
                    'start_time' => "{$startH}:{$startM}",
                    'end_time'   => "{$endH}:{$endM}",
                ];
            }
        } else {
            foreach ($dayNames as $index => $dayName) {
                $this->schedules[$index] = [
                    'day_name'   => $dayName,
                    'enabled'    => $index < 6,
                    'start_time' => '06:00',
                    'end_time'   => '22:00',
                ];
            }
        }
    }

    public function save(): void
    {
        $this->validate();

        // Mengubah string HH:MM dari form ke format integer struct ESP (DaySchedule)
        $formattedSchedule = array_map(function ($item) {
            [$startH, $startM] = explode(':', $item['start_time'] ?: '00:00');
            [$endH, $endM]     = explode(':', $item['end_time'] ?: '00:00');

            return [
                'enabled'     => (bool) $item['enabled'],
                'startHour'   => (int) $startH,
                'startMinute' => (int) $startM,
                'endHour'     => (int) $endH,
                'endMinute'   => (int) $endM,
            ];
        }, $this->schedules);

        JamDigital::updateOrCreate(
            ['id' => 1],
            [
                'running_text' => $this->running_text,
                'sub_text'     => $this->sub_text,
                'web_url'      => $this->web_url,
                'contact_info' => $this->contact_info,
                'speed'        => $this->speed,
                'size'         => $this->size,
                'clock_size'    => $this->clockSize,
                'enableClock'  => $this->enableClock,
                'enableText'   => $this->enableText,
                'enableAnim'   => $this->enableAnim,
                'enableInfo'   => $this->enableInfo,
                'animType'     => $this->animType,
                'matrix_power'  => $this->matrixPower,
                'schedule'     => $formattedSchedule,
            ]
        );

        session()->flash('message', 'Pengaturan Jam Digital berhasil disimpan!');
    }

    public function render()
    {
        return view('livewire.jam-digital-manager');
    }
}
