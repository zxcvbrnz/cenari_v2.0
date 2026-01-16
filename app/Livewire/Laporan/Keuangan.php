<?php

namespace App\Livewire\Laporan;

use Livewire\Component;
use App\Models\Keuangan as ModelsKeuangan;
use App\Models\Pembayaran;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class Keuangan extends Component
{
    public string $filter_bulan;
    public Collection $keuangans;

    // Form input
    public string $date = '';
    public string $description = '';
    public string $type = 'income';
    public int|string $amount = 0;

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

    /* ===============================
     * LOAD DATA
     * =============================== */
    public function loadData(): void
    {
        if (!preg_match('/^\d{4}-\d{2}$/', $this->filter_bulan)) {
            $this->keuangans = collect();
            return;
        }

        $year  = (int) substr($this->filter_bulan, 0, 4);
        $month = (int) substr($this->filter_bulan, 5, 2);

        $keuanganManual = ModelsKeuangan::whereYear('date', $year)
            ->whereMonth('date', $month)
            ->get()
            ->map(function ($item) {
                $selisihHari = Carbon::parse($item->created_at)->diffInDays(now());

                return [
                    'id' => $item->id,
                    'date' => $item->date,
                    'created_at' => $item->created_at,
                    'description' => $item->description,
                    'type' => $item->type,
                    'amount' => (int) $item->amount,
                    'is_pembayaran_spp' => false,

                    // ✅ INI INTINYA
                    'is_deletable' => $selisihHari <= 3,
                ];
            })
            ->values();


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
                    'created_at' => $item->created_at,
                    'description' => ($displayName ?? 'Umum') . ' - ' . ($item->deskripsi ?? 'Pembayaran'),
                    'type' => 'income',
                    'amount' => (int) ($item->jumlah_dibayar ?? 0),
                    'is_pembayaran_spp' => true,
                    'is_deletable' => false,
                ];
            })
            ->values();


        $this->keuangans = collect()
            ->concat($keuanganManual)
            ->concat($pembayaranSpp)
            ->sortByDesc('date')
            ->values();
    }

    /* ===============================
     * TAMBAH TRANSAKSI
     * =============================== */
    public function tambahTransaksi(): void
    {
        $this->validate([
            'date'        => 'required|date',
            'description' => 'required|min:3',
            'type'        => 'required|in:income,expense',
            'amount'      => 'required|numeric|min:1',
        ]);

        ModelsKeuangan::create([
            'date'        => $this->date,
            'description' => $this->description,
            'type'        => $this->type,
            'amount'      => $this->amount,
        ]);

        // reset form
        $this->reset(['date', 'description', 'amount', 'type']);
        $this->type = 'income';

        $this->loadData();

        $this->dispatch('alert-success-1', message: 'Transaksi berhasil ditambahkan');
    }

    /* ===============================
     * HAPUS TRANSAKSI
     * =============================== */
    public function hapusTransaksi(int $id): void
    {
        $transaksi = ModelsKeuangan::findOrFail($id);

        if ($transaksi->created_at->diffInDays(now()) > 3) {
            abort(403, 'Transaksi sudah terkunci');
        }

        $transaksi->delete();

        $this->loadData();

        $this->dispatch('alert-success-1', message: 'Transaksi berhasil dihapus');
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
