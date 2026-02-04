<main class="pb-14 md:pb-20">
    <div class="mb-6">
        <div class="bg-white border border-slate-200 shadow-lg rounded-sm">
            <div class="p-4 flex justify-between items-center border-b border-slate-100">
                <div class="flex items-center gap-3">
                    <div class="text-xl text-slate-600 font-semibold">Riwayat Pembayaran</div>
                </div>

                <div class="flex items-center gap-3">
                    {{-- Tombol Pelunasan --}}
                    {{-- @if (auth()->user()->peserta->status_pembayaran !== 'Lunas')
                        <button wire:click="bayar" wire:loading.attr="disabled"
                            class="bg-violet-600 hover:bg-violet-700 text-white px-4 py-2 rounded text-xs font-bold transition flex items-center gap-2">
                            <span wire:loading.remove wire:target="bayar" class="flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                </svg>
                                BAYAR PELUNASAN
                            </span>
                            <span wire:loading wire:target="bayar" style="display: none;">MENGHUBUNGKAN...</span>
                        </button>
                    @endif --}}

                    {{-- Badge Status --}}
                    @php
                        $status = auth()->user()->peserta->status_pembayaran;
                        $statusClasses = match ($status) {
                            'Lunas' => 'bg-emerald-100 text-emerald-600 border border-emerald-200',
                            'Belum Lunas' => 'bg-orange-100 text-orange-600 border border-orange-200',
                            'Belum Bayar' => 'bg-red-100 text-red-600 border border-red-200',
                            default => 'bg-slate-100 text-slate-600',
                        };
                    @endphp
                    <div class="text-sm font-medium px-3 py-1 rounded-full {{ $statusClasses }}">
                        {{ $status }}
                    </div>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-0 border-b border-slate-100">
                <div class="p-6 border-b md:border-b-0 md:border-r border-slate-100 text-center">
                    <p class="text-xs uppercase tracking-wider text-slate-400 font-semibold mb-1">Total Harga Program
                    </p>
                    <p class="text-lg font-bold text-slate-700">Rp {{ number_format($harga, 0, ',', '.') }}</p>
                </div>
                <div class="p-6 border-b md:border-b-0 md:border-r border-slate-100 text-center">
                    <p class="text-xs uppercase tracking-wider text-slate-400 font-semibold mb-1">Total Telah Dibayar
                    </p>
                    <p class="text-lg font-bold text-emerald-600">Rp
                        {{ number_format($riwayat->where('status', 'paid')->sum('jumlah_dibayar'), 0, ',', '.') }}</p>
                </div>
                <div class="p-6 text-center bg-slate-50/50">
                    <p class="text-xs uppercase tracking-wider text-slate-400 font-semibold mb-1">Sisa Tagihan</p>
                    <p
                        class="text-lg font-bold {{ $harga - $riwayat->sum('jumlah_dibayar') > 0 ? 'text-red-500' : 'text-slate-700' }}">
                        Rp
                        {{ number_format($harga - $riwayat->where('status', 'paid')->sum('jumlah_dibayar'), 0, ',', '.') }}
                    </p>
                    @if (auth()->user()->peserta->status_pembayaran !== 'Lunas')
                        <p class="text-[10px] text-red-400 mt-1 italic">* Harap segera melakukan pelunasan</p>
                    @endif
                </div>
            </div>

            <div class="p-6">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-slate-50 border-b">
                            <tr>
                                <th class="px-6 py-4">#</th>
                                <th class="px-6 py-4 text-center">Tanggal Transaksi</th>
                                <th class="px-6 py-4 text-center">status Pembayaran</th>
                                <th class="px-6 py-4 text-right">Nominal Pembayaran</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($riwayat as $item)
                                <tr class="hover:bg-slate-50/80 transition-colors">
                                    <td class="px-6 py-4 text-slate-400 w-10">{{ $loop->iteration }}</td>
                                    <td class="px-6 py-4 text-center">{{ $item->tanggal_dibayar->format('d F Y') }}</td>
                                    <td class="px-6 py-4 text-center">
                                        @php
                                            // LOGIKA WARNA STATUS
                                            $colorClass = match (strtolower($item->status)) {
                                                'paid',
                                                'success'
                                                    => 'text-emerald-600 bg-emerald-50 border-emerald-100',
                                                'pending' => 'text-amber-600 bg-amber-50 border-amber-100',
                                                'failed', 'expire', 'cancel' => 'text-red-600 bg-red-50 border-red-100',
                                                default => 'text-slate-600 bg-slate-50 border-slate-100',
                                            };
                                        @endphp
                                        <span
                                            class="px-3 py-1 rounded-full text-[10px] font-bold border {{ $colorClass }}">
                                            {{ strtoupper($item->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-right font-bold text-slate-900">
                                        Rp {{ number_format($item->jumlah_dibayar, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center gap-2 text-slate-400">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 opacity-20"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                            </svg>
                                            <p class="italic">Belum ada catatan transaksi pembayaran.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                        @if ($riwayat->count() > 0)
                            <tfoot class="bg-slate-50 font-bold border-t-2 border-slate-100">
                                <tr>
                                    <td colspan="3" class="px-6 py-4 text-slate-600">Total Akumulasi:</td>
                                    <td class="px-6 py-4 text-right text-emerald-600 text-base">
                                        Rp
                                        {{ number_format($riwayat->where('status', 'paid')->sum('jumlah_dibayar'), 0, ',', '.') }}
                                    </td>
                                </tr>
                            </tfoot>
                        @endif
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>
