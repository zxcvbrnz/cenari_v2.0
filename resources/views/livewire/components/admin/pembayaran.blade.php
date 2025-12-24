<main id="pembayaran" class="py-14 md:py-20">
    <div class="mb-6">
        <div class="bg-white border border-slate-200 shadow-lg rounded-sm">
            <div class="p-4 flex justify-between items-center">
                <div class="text-slate-600">Pembayaran </div>
            </div>
            <hr>
            <div class="p-6">
                @if ($data_pembayaran['id_peserta'] || $data_pembayaran['id_group'])
                    <form wire:submit="pembayaran" class="grid lg:grid-cols-2 gap-4">
                        <div>
                             <div class="grid gap-4">
                                @if ($data_pembayaran['id_peserta'])
                                    <div>
                                        <x-input-label class="required" for="data_pembayaran.id_peserta" :value="__('Peserta Didik')" />
                                        <select wire:model="data_pembayaran.id_peserta" name="data_pembayaran.id_peserta"
                                            id="data_pembayaran.id_peserta" required
                                            class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-sm shadow-sm block mt-1 w-full">
                                            <option selected value="">Pilih Peserta
                                            </option>
                                            @foreach ($pesertas as $peserta)
                                                <option value="{{ $peserta->id }}">
                                                    {{ $peserta->user->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <x-input-error class="mt-2" :messages="$errors->get('data_pembayaran.id_peserta')" />
                                    </div>
                                @elseif($data_pembayaran['id_group'])
                                    <div>
                                        <x-input-label class="required" for="data_pembayaran.id_group" :value="__('Pelatihan')" />
                                        <select wire:model="data_pembayaran.id_group" name="data_pembayaran.id_group"
                                            id="data_pembayaran.id_group" required
                                            class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-sm shadow-sm block mt-1 w-full">
                                            <option selected value="">Pilih Pelatihan
                                            </option>
                                            @foreach ($groups as $group)
                                                <option value="{{ $group->id }}">
                                                    {{ $group->nama }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <x-input-error class="mt-2" :messages="$errors->get('data_pembayaran.id_group')" />
                                    </div>
                                @endif
                                <div>
                                    <x-input-label class="required" for="data_pembayaran.jumlah_dibayar"
                                        :value="__('Jumlah')" />
                                    <div class="flex items-center text-slate-600 space-x-2">
                                        <div>Rp.</div>
                                        <x-text-input
                                            id="data_pembayaran.jumlah_dibayar" wire:model="data_pembayaran.jumlah_dibayar" name="data_pembayaran.jumlah_dibayar"
                                            type="text" class="mt-1 block w-full" required
                                            autocomplete="data_pembayaran.jumlah_dibayar"/>
                                    </div>
                                    <x-input-error class="mt-2" :messages="$errors->get('data_pembayaran.jumlah_dibayar')" />
                                </div>
                                <div>
                                    <x-input-label class="required" for="data_pembayaran.tanggal_dibayar"
                                        :value="__('Tanggal')" />
                                    <x-text-input wire:model="data_pembayaran.tanggal_dibayar"
                                        id="data_pembayaran.tanggal_dibayar" name="data_pembayaran.tanggal_dibayar"
                                        type="datetime-local" class="mt-1 block w-full" required
                                        autocomplete="data_pembayaran.tanggal_dibayar" />
                                    <x-input-error class="mt-2" :messages="$errors->get('data_pembayaran.tanggal_dibayar')" />
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="grid gap-4">
                                <div>
                                    <x-input-label class="required" for="status_pembayaran" :value="__('Status Pembayaran')" />
                                    <select wire:model="status_pembayaran" name="status_pembayaran" id="status_pembayaran"
                                        required
                                        class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-sm shadow-sm block mt-1 w-full">
                                        <option selected value="">Pilih Status Pembayaran
                                        </option>
                                        <option value="Belum Lunas">DP 2</option>
                                        <option value="Lunas">Pelunasan</option>
                                    </select>
                                    <x-input-error class="mt-2" :messages="$errors->get('status_pembayaran')" />
                                </div>
                                <div>
                                    <x-input-label class="required" for="data_pembayaran.deskripsi" :value="__('Deskripsi')" />
                                    <x-text-input wire:model="data_pembayaran.deskripsi" id="data_pembayaran.deskripsi"
                                        name="data_pembayaran.deskripsi" type="text" class="mt-1 block w-full" required
                                        autocomplete="data_pembayaran.deskripsi" />
                                    <x-input-error class="mt-2" :messages="$errors->get('data_pembayaran.deskripsi')" />
                                </div>
                            </div>
                        </div>
                        <div class="">
                            <x-primary-button>Simpan</x-primary-button>
                        </div>
                    </form>
                @endif
            </div>
            <hr>
            <div class="p-4 flex justify-between items-center">
                <div class="text-slate-600">Data Pembayaran</div>
                <form action="/export-pembayaran" method="post" class="space-x-1">
                    @csrf
                    <div class="inline-block">
                        <x-text-input id="tanggal" name="tanggal" type="month" class="mt-1 block w-full text-xs" />
                    </div>
                    <x-primary-button>Export</x-primary-button>
                </form>
            </div>
            <hr>
            <div class="p-6">
                <table id="tablePembayaran" class="stripe hover text-sm text-left text-gray-500"
                    style="width:100%; padding-top: 1em;  padding-bottom: 1em;">
                    <thead class="text-xs text-gray-700 uppercase">
                        <tr>
                            <th class="text-start">No</th>
                            <th class="text-start">Pembayar</th>
                            <th class="text-start">Jumlah Dibayar</th>
                            <th class="text-start">Harga</th>
                            <th class="text-start">Sisa Pembayaran</th>
                            <th class="text-start">Tanggal dibayar</th>
                            <th class="text-start">Deskripsi</th>
                            <th class="text-start">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pembayarans as $pembayaran)
                            @php
                                $threeDaysInHours = 3 * 24; // 3 days in hours
                                $hoursSincePayment = \Carbon\Carbon::now()->diffInHours($pembayaran->created_at);
                                $isOlderThanThreeDays = abs($hoursSincePayment) > $threeDaysInHours;
                    
                                // Hitung harga berdasarkan grup atau peserta
                                $harga = $pembayaran->id_group ? $pembayaran->group->harga : $pembayaran->peserta->mapel->harga;
                    
                                // Hitung total pembayaran peserta jika ada
                                $totalPembayaranPeserta = $pembayaran->id_group ? $pembayaran->group->pembayaran->sum('jumlah_dibayar') : $pembayaran->peserta->pembayaran->sum('jumlah_dibayar');
                            @endphp
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td class="{{ $pembayaran->id_group ? 'font-semibold' : '' }}">
                                    <div>{{ $pembayaran->id_group ? $pembayaran->group->nama : $pembayaran->peserta->user->name }}</div>
                                    <div class="text-xs">
                                        {{ $pembayaran->id_group ? $pembayaran->group->mapel->nama . ' | Pelatihan' : $pembayaran->peserta->mapel->nama }}
                                    </div>
                                </td>
                                <td>Rp{{ number_format($pembayaran->jumlah_dibayar, 0, ',', '.') }}</td>
                                <td>Rp{{ number_format($harga, 0, ',', '.') }}</td>
                                <!-- Kolom baru untuk menampilkan selisih -->
                                <td>{{ $harga - $totalPembayaranPeserta == 0 ? 'Lunas' : 'Rp' . number_format($harga - $totalPembayaranPeserta, 0, ',', '.') }}</td>
                                <td>{{ $pembayaran->tanggal_dibayar->format('d F Y H:i') }}</td>
                                <td>{{ $pembayaran->deskripsi }}</td>
                                <td class="flex space-x-1">
                                    @if (!$isOlderThanThreeDays)
                                        <button onclick="hapusPembayaranJs({{ $pembayaran->id }})"
                                            class="px-3 py-1 rounded text-red-600 text-xs border border-red-600 hover:bg-red-800 hover:text-white transition duration-300 ease-linear">
                                            Hapus
                                        </button>
                                    @endif
                                    @if (!$pembayaran->id_group && $pembayaran->peserta->status_pembayaran !== 'Lunas')
                                        <button onclick="pelunasanJs({{ $pembayaran->peserta->id }}, '{{ $pembayaran->peserta->user->name }}')"
                                            class="px-3 py-1 rounded text-violet-600 text-xs border border-violet-600 hover:bg-violet-800 hover:text-white transition duration-300 ease-linear">
                                            Lanjut
                                        </button>
                                    @endif
                                    @if ($pembayaran->id_group && $pembayaran->group->status_pembayaran !== 'Lunas')
                                        <button onclick="pelunasanGroupJs({{ $pembayaran->group->id }}, '{{ $pembayaran->group->nama }}')"
                                            class="px-3 py-1 rounded text-violet-600 text-xs border border-violet-600 hover:bg-violet-800 hover:text-white transition duration-300 ease-linear">
                                            Lanjut
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>
<script>
    function hapusPembayaranJs(id) {
        Swal.fire({
            title: "Apakah kamu yakin?",
            text: "Kamu akan menghapus data pembayaran ini!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Ya , Hapus!",
            cancelButtonText: "Batal"
        }).then((result) => {
            if (result.isConfirmed) {
                @this.call('hapusPembayaran', id);
            }
        });
    }

    function pelunasanJs(id, nama) {
        Swal.fire({
            title: "Lakukan Pembayaran Lanjutan?",
            text: "Melanjutkan pembayaran untuk peserta " + nama,
            icon: "question",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Lanjutkan",
            cancelButtonText: "Batal"
        }).then((result) => {
            if (result.isConfirmed) {
                @this.call('pelunasan', id);
            }
        });
    }

    function pelunasanGroupJs(id, nama) {
        Swal.fire({
            title: "Lakukan Pembayaran Lanjutan?",
            text: "Melanjutkan pembayaran untuk Pelatihan " + nama,
            icon: "question",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Lanjutkan",
            cancelButtonText: "Batal"
        }).then((result) => {
            if (result.isConfirmed) {
                @this.call('pelunasanGroup', id);
            }
        });
    }
</script>
