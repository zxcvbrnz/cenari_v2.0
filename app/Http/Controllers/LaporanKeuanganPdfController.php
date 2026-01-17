<?php

namespace App\Http\Controllers;

use App\Models\Keuangan;
use App\Models\Pembayaran;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanKeuanganPdfController extends Controller
{
    public function bulanan(string $bulan)
    {
        if (!preg_match('/^\d{4}-\d{2}$/', $bulan)) {
            abort(404);
        }

        $year  = substr($bulan, 0, 4);
        $month = substr($bulan, 5, 2);

        $carbon = Carbon::createFromFormat('Y-m', $bulan)->locale('id');

        $namaBulan = $carbon->translatedFormat('F'); // Januari
        $tahun     = $carbon->year;

        $filename = "Laporan_Keuangan_{$namaBulan}_{$tahun}.pdf";

        /** ===============================
         * DATA MANUAL
         * =============================== */
        $manual = Keuangan::whereYear('date', $year)
            ->whereMonth('date', $month)
            ->get()
            ->map(function ($item) {
                return [
                    'date'        => $item->date,
                    'created_at'  => $item->created_at,
                    'description' => $item->description,
                    'type'        => $item->type,
                    'amount'      => $item->amount,
                    'sort_date'   => Carbon::parse($item->date)->timestamp,
                    'sort_created' => $item->created_at->timestamp,
                ];
            });

        /** ===============================
         * DATA SPP
         * =============================== */
        $spp = Pembayaran::whereYear('tanggal_dibayar', $year)
            ->whereMonth('tanggal_dibayar', $month)
            ->where('jumlah_dibayar', '>', 0)
            ->get()
            ->map(function ($item) {
                return [
                    'date'        => $item->tanggal_dibayar,
                    'created_at'  => $item->created_at,
                    'description' => 'Pembayaran - ' . ($item->deskripsi ?? 'SPP'),
                    'type'        => 'income',
                    'amount'      => $item->jumlah_dibayar,
                    'sort_date'   => Carbon::parse($item->tanggal_dibayar)->timestamp,
                    'sort_created' => $item->created_at->timestamp,
                ];
            });

        /** ===============================
         * GABUNG + SORT
         * =============================== */
        $data = collect()
            ->concat($manual)
            ->concat($spp)
            ->sort(function ($a, $b) {
                if ($a['sort_date'] !== $b['sort_date']) {
                    return $b['sort_date'] <=> $a['sort_date'];
                }
                return $b['sort_created'] <=> $a['sort_created'];
            })
            ->values();

        $totalIncome  = $data->where('type', 'income')->sum('amount');
        $totalExpense = $data->where('type', 'expense')->sum('amount');

        $pdf = Pdf::loadView('pdf.laporan-keuangan-bulanan', [
            'bulan'        => $bulan,
            'data'         => $data,
            'totalIncome'  => $totalIncome,
            'totalExpense' => $totalExpense,
            'saldo'        => $totalIncome - $totalExpense,
        ])->setPaper('A4', 'landscape');

        return $pdf->download($filename);
    }
}
