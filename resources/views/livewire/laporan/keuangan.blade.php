<main class="py-14 md:py-20">
    <div class="bg-white border border-slate-200 shadow-xl rounded-sm mb-10">
        <div class="p-4 bg-slate-50 border-b border-slate-200">
            <div class="text-slate-600 font-bold uppercase text-xs tracking-widest italic">Input Transaksi Kas</div>
        </div>

        <div class="p-6 border-b border-slate-100 bg-slate-50/30">
            <form wire:submit.prevent="tambahTransaksi" class="grid grid-cols-1 md:grid-cols-4 gap-6 items-end">
                <div>
                    <x-input-label class="required text-[10px]" for="date" :value="__('Tanggal')" />
                    <x-text-input wire:model="date" id="date" type="date"
                        class="mt-1 block w-full text-sm border-slate-200" required />
                </div>
                <div>
                    <x-input-label class="required text-[10px]" for="type" :value="__('Kategori')" />
                    <select wire:model="type"
                        class="border-slate-200 focus:border-violet-500 focus:ring-violet-500 rounded-sm shadow-sm block mt-1 w-full text-sm h-[42px]">
                        <option value="income">Pemasukan (+)</option>
                        <option value="expense">Pengeluaran (-)</option>
                    </select>
                </div>
                <div>
                    <x-input-label class="required text-[10px]" for="amount" :value="__('Nominal')" />
                    <x-text-input wire:model="amount" id="amount" type="number"
                        class="mt-1 block w-full text-sm border-slate-200" placeholder="0" required />
                </div>
                <div>
                    <x-input-label class="required text-[10px]" for="description" :value="__('Deskripsi')" />
                    <x-text-input wire:model="description" id="description" type="text"
                        class="mt-1 block w-full text-sm border-slate-200" placeholder="Contoh: Operasional" required />
                </div>
                <div class="md:col-span-4 flex justify-end">
                    <button type="submit" wire:loading.attr="disabled" wire:target="tambahTransaksi"
                        class="bg-slate-800 text-white px-6 py-2.5 rounded-sm text-xs font-bold uppercase hover:bg-violet-600 transition duration-300 shadow-md disabled:opacity-70 disabled:cursor-not-allowed">

                        {{-- Gunakan satu container --}}
                        <div class="flex items-center justify-center gap-2">

                            {{-- Teks ini akan HILANG saat loading --}}
                            <span wire:loading.remove wire:target="tambahTransaksi">
                                Simpan Transaksi
                            </span>

                            {{-- Teks ini kita paksa SEMBUNYI dengan style="display:none" agar tidak bergantung pada CSS file --}}
                            <span wire:loading wire:target="tambahTransaksi" style="display: none;"
                                class="items-center gap-2">
                                <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10"
                                        stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                    </path>
                                </svg>
                                <span>Memproses...</span>
                            </span>
                        </div>
                    </button>
                </div>
            </form>
        </div>

        {{-- Statistik Ringkas --}}
        <div
            class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 divide-y md:divide-y-0 md:divide-x divide-slate-100 bg-white">
            <div class="p-6">
                <div class="text-[10px] uppercase tracking-widest font-bold text-slate-400">
                    Total Pemasukan ({{ $filter_bulan }})</div>
                <div class="text-2xl font-mono font-bold text-emerald-600">Rp
                    {{ number_format($totalIncome, 0, ',', '.') }}</div>
            </div>
            <div class="p-6">
                <div class="text-[10px] uppercase tracking-widest font-bold text-slate-400">
                    Total Pengeluaran ({{ $filter_bulan }})</div>
                <div class="text-2xl font-mono font-bold text-rose-600">Rp
                    {{ number_format($totalExpense, 0, ',', '.') }}</div>
            </div>
            <div class="p-6">
                <div class="text-[10px] uppercase tracking-widest font-bold text-slate-400">
                    Pemasukan Bersih ({{ $filter_bulan }})</div>
                <div class="text-2xl font-mono font-bold {{ $saldo >= 0 ? 'text-emerald-600' : 'text-rose-600' }}">
                    Rp {{ number_format($saldo, 0, ',', '.') }}
                </div>
            </div>
            <div class="p-6 ">
                <div class="text-[10px] uppercase tracking-widest font-bold text-slate-400">
                    Saldo Total
                </div>
                <div
                    class="text-2xl font-mono font-bold {{ $saldoKeseluruhan >= 0 ? 'text-emerald-600' : 'text-rose-600' }}">
                    Rp {{ number_format($saldoKeseluruhan, 0, ',', '.') }}
                </div>
            </div>

        </div>
    </div>

    {{-- Tabel Riwayat --}}
    <div class="bg-white border border-slate-200 shadow-xl rounded-sm">
        <div class="p-6 flex flex-col md:flex-row justify-between items-center gap-4">
            <div class="text-xl text-slate-700 font-light italic"> Riwayat Keuangan
                <span class="text-sm font-bold opacity-50 text-slate-400">/ {{ $filter_bulan }}</span>
            </div>
            <div>
                <div class="flex items-center bg-slate-100 p-1 rounded-sm border border-slate-200">
                    <span class="px-3 text-[10px] font-black text-slate-500 uppercase">Periode :</span>
                    <input type="month" wire:model.lazy="filter_bulan"
                        class="text-sm border-none bg-transparent focus:ring-0 cursor-pointer">
                </div>
                <div wire:loading wire:target="filter_bulan" style="display: none;" class="ml-2">
                    <span class="text-[10px] text-violet-600 animate-pulse font-bold uppercase tracking-tighter">
                        ⚡ Memuat data...
                    </span>
                </div>
            </div>
        </div>

        <div class="px-6 pb-6 overflow-x-auto">
            <table class="w-full text-sm text-left text-slate-500 border border-slate-100">
                <thead class="text-xs text-slate-700 uppercase bg-slate-50 border-b border-slate-200">
                    <tr>
                        <th class="p-4 w-16 text-center">No</th>
                        <th class="p-4">Tanggal</th>
                        <th class="p-4">Keterangan</th>
                        <th class="p-4 text-right">Nominal</th>
                        <th class="p-4 text-center w-20">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($keuangans as $item)
                        <tr wire:key="item-{{ $item['is_pembayaran_spp'] ? 'spp' : 'man' }}-{{ $item['id'] }}"
                            class="hover:bg-slate-50 transition">

                            <td class="p-4 text-center text-slate-400">
                                {{ $loop->iteration }}
                            </td>

                            <td class="p-4 font-medium text-slate-700">
                                {{ \Carbon\Carbon::parse($item['date'])->translatedFormat('d M Y') }}
                            </td>

                            <td class="p-4">
                                <div class="text-slate-800 font-semibold">
                                    {{ $item['description'] }}
                                </div>

                                <div class="flex items-center gap-1 mt-1">
                                    <div
                                        class="w-2 h-2 rounded-full {{ $item['type'] === 'income' ? 'bg-emerald-500' : 'bg-rose-500' }}">
                                    </div>

                                    <span
                                        class="text-[10px] font-black uppercase tracking-widest {{ $item['type'] === 'income' ? 'text-emerald-600' : 'text-rose-600' }}">
                                        {{ $item['type'] === 'income' ? 'Pemasukan' : 'Pengeluaran' }}
                                    </span>
                                </div>
                            </td>

                            <td
                                class="p-4 text-right font-mono font-bold text-base {{ $item['type'] === 'income' ? 'text-emerald-600' : 'text-rose-600' }}">
                                {{ $item['type'] === 'expense' ? '-' : '' }}
                                {{ number_format($item['amount'], 0, ',', '.') }}
                            </td>

                            <td class="p-4 text-center">
                                @if ($item['is_deletable'])
                                    <button wire:click="hapusTransaksi({{ $item['id'] }})"
                                        wire:confirm="Yakin ingin menghapus transaksi ini?"
                                        class="text-slate-300 hover:text-rose-600 transition">
                                        🗑
                                    </button>
                                @elseif ($item['is_pembayaran_spp'])
                                    <span class="text-[9px] bg-slate-100 text-slate-400 px-2 py-1 rounded">
                                        Pembayaran
                                    </span>
                                @endif
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-10 text-center text-slate-400 italic">
                                Tidak ada transaksi pada periode ini.
                            </td>
                        </tr>
                    @endforelse

                </tbody>
            </table>
        </div>
    </div>
</main>
