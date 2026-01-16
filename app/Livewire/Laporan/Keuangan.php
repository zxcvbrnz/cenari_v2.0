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
                    'is_deletable' => $selisihHari <= 3,

                    'sort_date' => Carbon::parse($item->date)->startOfDay()->timestamp,
                    'sort_created' => $item->created_at->timestamp,
                ];
            })
            ->values();


        $pembayaranSpp = Pembayaran::whereYear('tanggal_dibayar', $year)
            ->whereMonth('tanggal_dibayar', $month)
            ->where('jumlah_dibayar', '!=', 0)
            ->get()
            ->map(function ($item) {
                $displayName = $item->id_group
                    ? optional($item->group)->nama
                    : optional(optional($item->peserta)->user)->name;

                $tanggal = optional($item->tanggal_dibayar)->format('Y-m-d');

                return [
                    'id' => $item->id,
                    'date' => $tanggal,
                    'created_at' => $item->created_at,
                    'description' => ($displayName ?? 'Umum') . ' - ' . ($item->deskripsi ?? 'Pembayaran'),
                    'type' => 'income',
                    'amount' => (int) ($item->jumlah_dibayar ?? 0),
                    'is_pembayaran_spp' => true,
                    'is_deletable' => false,

                    'sort_date' => Carbon::parse($tanggal)->startOfDay()->timestamp,
                    'sort_created' => $item->created_at->timestamp,
                ];
            })
            ->values();


        $this->keuangans = collect()
            ->concat($keuanganManual)
            ->concat($pembayaranSpp)
            ->sort(function ($a, $b) {

                // 1️⃣ PRIORITAS DATE (tanggal)
                if ($a['sort_date'] !== $b['sort_date']) {
                    return $b['sort_date'] <=> $a['sort_date'];
                }

                // 2️⃣ JIKA DATE SAMA → CREATED_AT (jam)
                return $b['sort_created'] <=> $a['sort_created'];
            })
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

    protected function getSaldoKeseluruhan(): int
    {
        // 1️⃣ TOTAL PEMASUKAN MANUAL
        $incomeManual = ModelsKeuangan::where('type', 'income')->sum('amount');

        // 2️⃣ TOTAL PENGELUARAN MANUAL
        $expenseManual = ModelsKeuangan::where('type', 'expense')->sum('amount');

        // 3️⃣ TOTAL PEMBAYARAN SPP
        $incomeSpp = Pembayaran::where('jumlah_dibayar', '>', 0)
            ->sum('jumlah_dibayar');

        return ($incomeManual + $incomeSpp) - $expenseManual;
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
            // 🔹 BULAN TERPILIH
            'totalIncome'  => $totalIncome,
            'totalExpense' => $totalExpense,
            'saldo'        => $totalIncome - $totalExpense,

            // 🔥 KESELURUHAN
            'saldoKeseluruhan' => $this->getSaldoKeseluruhan(),
        ]);
    }
}
