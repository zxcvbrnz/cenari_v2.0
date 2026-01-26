<?php

namespace App\Livewire\Components\Admin;

use App\Models\Mapel;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Carbon\Carbon;

class Chart2 extends Component
{
    public $data;
    public int $year;

    public function mount(): void
    {
        $this->year = Carbon::now()->year;
        $this->loadChartData();
    }

    /**
     * Fungsi ini akan terpanggil otomatis oleh Livewire
     * setiap kali $year berubah via wire:model
     */
    public function updatedYear()
    {
        $this->loadChartData();
        // Mengirim event ke browser agar Chart.js melakukan update
        $this->dispatch('update-chart', data: $this->data);
    }

    public function loadChartData()
    {
        $mapelData = Mapel::with(['pesertas' => function ($query) {
            $query->select(DB::raw('id_mapel, MONTH(created_at) as month, COUNT(*) as count'))
                ->whereYear('created_at', $this->year)
                ->groupBy('id_mapel', 'month');
        }])->get();

        $this->data = $mapelData->map(function ($mapel) {
            $monthlyData = array_fill(0, 12, 0);
            foreach ($mapel->pesertas as $peserta) {
                $monthlyData[$peserta->month - 1] = $peserta->count;
            }
            return [
                'nama' => $mapel->nama,
                'monthlyData' => $monthlyData,
            ];
        });
    }

    public function render()
    {
        return view('livewire.components.admin.chart2');
    }
}