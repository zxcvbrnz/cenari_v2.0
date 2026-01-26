<?php

namespace App\Livewire\Components\Admin;

use App\Models\Mapel;
use App\Models\Peserta;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Carbon\Carbon;

class Chart2 extends Component
{
    public $data;
    public int $year;

    // Tambahkan properti ini agar Livewire memantau perubahan input
    protected $updatesQueryString = ['year'];

    public function mount(): void
    {
        $this->year = Carbon::now()->year;
        $this->dispatch('updateChartData',  $this->data);
        $this->prepareData();
    }

    // Fungsi ini kita pisahkan agar bisa dipanggil di mount() dan render()
    public function prepareData(): void
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
        // Panggil ulang data setiap kali render agar data tetap ada saat tahun berubah
        $this->prepareData();
        return view('livewire.components.admin.chart2');
    }
}