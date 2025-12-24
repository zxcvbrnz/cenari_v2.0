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
    public $chartData;

    public int $year;
    public function mount(): void
    {
        // $this->loadChartData();
        $this->year = Carbon::now()->year;

        $mapelData = Mapel::with(['pesertas' => function ($query) {
            $query->select(DB::raw('id_mapel, MONTH(created_at) as month, COUNT(*) as count'))
                ->whereYear('created_at', $this->year)
                ->groupBy('id_mapel', 'month');
        }])->get();

        // Mengorganisir data untuk dikirim ke view
        $this->data = $mapelData->map(function ($mapel) {
            $monthlyData = array_fill(0, 12, 0); // Inisialisasi 12 bulan dengan nilai 0
            foreach ($mapel->pesertas as $peserta) {
                $monthlyData[$peserta->month - 1] = $peserta->count; // Isi data sesuai bulan
            }
            return [
                'nama' => $mapel->nama,
                'monthlyData' => $monthlyData,
            ];
        });
    }
}
