<?php

namespace App\Livewire\Laporan;

use Livewire\Component;
use App\Models\Keuangan as ModelsKeuangan;
use App\Models\Pembayaran;
use Illuminate\Support\Collection;

class Keuangan extends Component
{
    public string $filter_bulan;
    public Collection $keuangans;

    public function mount(): void
    {
        $this->filter_bulan = date('Y-m');
        $this->keuangans = collect();
        $this->loadData();
    }

    public function updatedFilterBulan(): void
    {
        $this->loadData();
    }

    public function loadData(): void
    {
        if (!preg_match('/^\d{4}-\d{2}$/', $this->filter_bulan)) {
            $this->keuangans = collect();
            return;
        }

        $year  = (int) substr($this->filter_bulan, 0, 4);
        $month = (int) substr($this->filter_bulan, 5, 2);

        /** ===============================
         *  KEUANGAN MANUAL
         *  =============================== */
        $keuanganManual = ModelsKeuangan::whereYear('date', $year)
            ->whereMonth('date', $month)
            ->get()
            ->map(fn($item) => [
                'id' => $item->id,
                'date' => $item->date,
                'description' => $item->description,
                'type' => $item->type,
                'amount' => (int) $item->amount,
                'is_pembayaran_spp' => false,
            ])
            ->values();

        /** ===============================
         *  PEMBAYARAN SPP
         *  =============================== */
        $pembayaranSpp = Pembayaran::whereYear('tanggal_dibayar', $year)
            ->whereMonth('tanggal_dibayar', $month)
            ->get()
            ->map(function ($item) {
                $displayName = $item->id_group
                    ? optional($item->group)->nama
                    : optional(optional($item->peserta)->user)->name;

                return [
                    'id' => $item->id,
                    'date' => optional($item->tanggal_dibayar)->format('Y-m-d'),
                    'description' => ($displayName ?? 'Umum') . ' - ' . ($item->deskripsi ?? 'Pembayaran'),
                    'type' => 'income',
                    'amount' => (int) ($item->jumlah_dibayar ?? 0),
                    'is_pembayaran_spp' => true,
                ];
            })
            ->values();

        /** ===============================
         *  PENTING: FORCE KE COLLECTION BIASA
         *  =============================== */
        $this->keuangans = collect()
            ->concat($keuanganManual)
            ->concat($pembayaranSpp)
            ->sortByDesc('date')
            ->values();
    }

    public function render()
    {
        $totalIncome = $this->keuangans
            ->where('type', 'income')
            ->sum('amount');

        $totalExpense = $this->keuangans
            ->where('type', 'expense')
            ->sum('amount');

        return view('livewire.laporan.keuangan', [
            'totalIncome'  => $totalIncome,
            'totalExpense' => $totalExpense,
            'saldo'        => $totalIncome - $totalExpense,
        ]);
    }
}
