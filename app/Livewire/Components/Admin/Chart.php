<?php

namespace App\Livewire\Components\Admin;

use App\Models\Mapel;
use App\Models\Peserta;
use Carbon\Carbon;
use Livewire\Component;

class Chart extends Component
{
    public $data;

    public function mount(): void
    {
        $private_baru = [];
        $private_lulus = [];
        $pelatihan_baru = [];
        $pelatihan_lulus = [];
        $months = [];
        $prodata = [];

        // Ambil tanggal saat ini
        $endDate = Carbon::now();
        // Ambil tanggal 5 bulan ke belakang dari tanggal sekarang
        $startDate = Carbon::now()->subMonths(5);

        while ($startDate <= $endDate) {
            $months[] = $startDate->format('F');

            // Mengambil jumlah peserta aktif untuk bulan tertentu
            $jumlah_peserta1 = Peserta::where('status', 'aktif')
                ->whereMonth('created_at', $startDate->month)
                ->whereYear('created_at', $startDate->year)
                ->count();
            $private_baru[] = $jumlah_peserta1;

            // Mengambil jumlah peserta nonaktif untuk bulan tertentu
            $jumlah_peserta2 = Peserta::where('status', 'nonaktif')
                ->whereMonth('created_at', $startDate->month)
                ->whereYear('created_at', $startDate->year)
                ->count();
            $private_lulus[] = $jumlah_peserta2;

            // Mengambil jumlah peserta Pelatihan aktif untuk bulan tertentu
            $jumlah_peserta3 = Peserta::where('status', 'aktif')
                ->where('id_group', '!=', null)
                ->whereMonth('created_at', $startDate->month)
                ->whereYear('created_at', $startDate->year)
                ->count();
            $pelatihan_baru[] = $jumlah_peserta3;

            // Mengambil jumlah peserta Pelatihan nonaktif untuk bulan tertentu
            $jumlah_peserta4 = Peserta::where('status', 'nonaktif')
                ->where('id_group', '!=', null)
                ->whereMonth('created_at', $startDate->month)
                ->whereYear('created_at', $startDate->year)
                ->count();
            $pelatihan_lulus[] = $jumlah_peserta4;

            // Tambah 1 bulan
            $startDate->addMonth();
        }

        // Ambil nama bulan untuk bulan saat ini
        $currentMonth = Carbon::now()->format('F');
        // Jika nama bulan saat ini belum ada dalam array bulan, tambahkan data bulan ini
        if (!in_array($currentMonth, $months)) {
            $months[] = $currentMonth;

            // Mengambil jumlah peserta aktif untuk bulan ini
            $jumlah_peserta1 = Peserta::where('status', 'aktif')
                ->whereMonth('created_at', Carbon::now()->month)
                ->whereYear('created_at', Carbon::now()->year)
                ->count();
            $private_baru[] = $jumlah_peserta1;

            // Mengambil jumlah peserta nonaktif untuk bulan ini
            $jumlah_peserta2 = Peserta::where('status', 'nonaktif')
                ->whereMonth('created_at', Carbon::now()->month)
                ->whereYear('created_at', Carbon::now()->year)
                ->count();
            $private_lulus[] = $jumlah_peserta2;

            // Mengambil jumlah peserta Pelatihan aktif untuk bulan ini
            $jumlah_peserta3 = Peserta::where('status', 'aktif')
                ->where('id_group', '!=', null)
                ->whereMonth('created_at', Carbon::now()->month)
                ->whereYear('created_at', Carbon::now()->year)
                ->count();
            $pelatihan_baru[] = $jumlah_peserta3;

            // Mengambil jumlah peserta Pelatihan nonaktif untuk bulan ini
            $jumlah_peserta4 = Peserta::where('status', 'nonaktif')
                ->where('id_group', '!=', null)
                ->whereMonth('created_at', Carbon::now()->month)
                ->whereYear('created_at', Carbon::now()->year)
                ->count();
            $pelatihan_lulus[] = $jumlah_peserta4;
        }
        $SD = Peserta::where('pendidikan', 'SD')->count();

        $this->data = [
            'labels' => $months,
            'data' => $private_baru,
            'data2' => $private_lulus,
            'data3' => $pelatihan_baru,
            'data4' => $pelatihan_lulus,

            'label2' => ['SD', 'SMP', 'SMA', 'DIPLOMAT I-IV', 'S1', 'S2', 'S3'],
            'SD' => $SD,
            'SMP' => Peserta::where('pendidikan', 'SMP')->count(),
            'SMA' => Peserta::where('pendidikan', 'SMA')->count(),
            'DIPLOMAT' => Peserta::where('pendidikan', 'DIPLOMAT I-IV')->count(),
            'S1' => Peserta::where('pendidikan', 'S1')->count(),
            'S2' => Peserta::where('pendidikan', 'S2')->count(),
            'S3' => Peserta::where('pendidikan', 'S3')->count(),
        ];

        // $data = Mapel::withCount('pesertas')->get();
    }
}
