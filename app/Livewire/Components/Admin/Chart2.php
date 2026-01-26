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
    public string $type = 'Private'; // Default awal

    protected $updatesQueryString = ['year', 'type'];

    public function mount(): void
    {
        $this->year = Carbon::now()->year;
        $this->prepareData();
    }

    public function prepareData(): void
    {
        // Tentukan relasi berdasarkan tipe
        $relation = ($this->type === 'Private') ? 'pesertas' : 'groups';

        $mapelData = Mapel::with([$relation => function ($query) {
            $query->select(DB::raw('id_mapel, MONTH(created_at) as month, COUNT(*) as count'))
                ->whereYear('created_at', $this->year)
                ->groupBy('id_mapel', 'month');
        }])->get();

        $this->data = $mapelData->map(function ($mapel) use ($relation) {
            $monthlyData = array_fill(0, 12, 0);

            // Ambil data dari relasi yang sedang aktif (pesertas atau groups)
            foreach ($mapel->$relation as $item) {
                $monthlyData[$item->month - 1] = $item->count;
            }

            return [
                'nama' => $mapel->nama,
                'monthlyData' => $monthlyData,
            ];
        });
    }

    public function render()
    {
        $this->prepareData();
        $this->dispatch('updateChartData', chartData: $this->data);
        return view('livewire.components.admin.chart2');
    }
}