<?php

namespace App\Livewire\Components\Admin;

use App\Models\Mapel;
use Livewire\Component;

class CreateMapel extends Component
{
    public string $nama = '';
    public int $harga;
    public array $materi = [
        'materi_1' => '',
        'materi_2' => '',
        'materi_3' => '',
        'materi_4' => '',
        'materi_5' => '',
        'materi_6' => '',
        'materi_7' => '',
        'materi_8' => '',
        'materi_9' => '',
        'materi_10' => '',
    ];

    public function create(): void
    {
        $this->validate([
            'nama' => 'required|string|max:255',
            'harga' => 'required',
            'materi.materi_1' => 'nullable|string|max:255',
            'materi.materi_2' => 'nullable|string|max:255',
            'materi.materi_3' => 'nullable|string|max:255',
            'materi.materi_4' => 'nullable|string|max:255',
            'materi.materi_5' => 'nullable|string|max:255',
            'materi.materi_6' => 'nullable|string|max:255',
            'materi.materi_7' => 'nullable|string|max:255',
            'materi.materi_8' => 'nullable|string|max:255',
            'materi.materi_9' => 'nullable|string|max:255',
            'materi.materi_10' => 'nullable|string|max:255',
        ]);

        Mapel::create([
            'nama' => $this->nama,
            'harga' => $this->harga,
            'materi_1' => $this->materi['materi_1'],
            'materi_2' => $this->materi['materi_2'],
            'materi_3' => $this->materi['materi_3'],
            'materi_4' => $this->materi['materi_4'],
            'materi_5' => $this->materi['materi_5'],
            'materi_6' => $this->materi['materi_6'],
            'materi_7' => $this->materi['materi_7'],
            'materi_8' => $this->materi['materi_8'],
            'materi_9' => $this->materi['materi_9'],
            'materi_10' => $this->materi['materi_10'],
        ]);

        $this->dispatch('alert-success', message: 'Berhasil membuat mata pelajaran.');
    }
}
