<?php

namespace App\Livewire\Setting;

use App\Models\Setting;
use Livewire\Component;

class General extends Component
{
    public $settings;
    public $setting1;
    public $setting2;
    public bool $setting1edit; // Mengubah ke boolean untuk mencerminkan status checkbox
    public bool $setting2edit; // Mengubah ke boolean untuk mencerminkan status checkbox

    public function mount()
    {
        $this->settings = Setting::all();
        $this->setting1 = Setting::findOrFail(1);
        $this->setting2 = Setting::findOrFail(2);
        // Mengatur nilai awal checkbox berdasarkan nilai dari database
        $this->setting1edit = $this->setting1->value === 'ON';
        $this->setting2edit = $this->setting2->value === 'ON';
    }

    public function update()
    {
        // Simpan nilai checkbox ke database
        $this->setting1->value = $this->setting1edit ? 'ON' : 'OFF';
        $this->setting2->value = $this->setting2edit ? 'ON' : 'OFF';

        $this->setting1->save();
        $this->setting2->save();

        $this->dispatch('alert-success', message: 'Berhasil Mengupdate Pengaturan');
    }
}