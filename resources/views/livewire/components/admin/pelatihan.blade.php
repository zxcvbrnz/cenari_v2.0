<main class="py-14 md:py-20">
    <div class="mb-6">
        <div class="bg-white border border-slate-200 shadow-lg rounded-sm">
            <div class="p-4 flex justify-between items-center">
                <div class="text-xl text-slate-600">Data Pelatihan</div>
            </div>
            <hr>
            <div class="p-6">
                <table class="dat-table stripe hover text-sm text-left text-gray-500"
                    style="width:100%; padding-top: 1em;  padding-bottom: 1em;">
                    <thead class="text-xs text-gray-700 uppercase">
                        <tr>
                            <th class="text-start">No</th>
                            <th class="text-start">Nama</th>
                            <th class="text-start">Harga</th>
                            <th class="text-start">Instruktur</th>
                            <th class="text-start">Program</th>
                            <th class="text-start">Status</th>
                            <th class="text-start">Pembayaran</th>
                            <th class="text-start">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pelatihan as $dat)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $dat->nama }}</td>
                                <td>Rp{{ number_format($dat->harga, 0, ',', '.') }}</td>
                                <td>{{ $dat->instruktur->user->name }}</td>
                                <td>{{ $dat->mapel->nama }}</td>
                                <td>
                                    @if ($dat->status === 'aktif')
                                        <span
                                            class="text-green-800 bg-green-300 text-sm py-0.5 rounded-full px-3">{{ $dat->status }}</span>
                                    @else
                                        <span
                                            class="text-red-800 bg-red-300 text-sm py-0.5 rounded-full px-3">{{ $dat->status }}</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($dat->status_pembayaran === 'Lunas')
                                        <span
                                            class="text-green-800 bg-green-300 text-sm py-0.5 rounded-full px-3">{{ $dat->status_pembayaran }}</span>
                                    @elseif($dat->status_pembayaran === 'Belum Lunas')
                                        <span
                                            class="text-orange-800 bg-orange-300 text-sm py-0.5 rounded-full px-3">B-Lunas</span>
                                    @elseif($dat->status_pembayaran === 'Belum Bayar')
                                        <span
                                            class="text-red-800 bg-red-300 text-sm py-0.5 rounded-full px-3">B-Bayar</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.data.pelatihan.detail', ['id' => $dat->id]) }}"
                                        wire:navigate
                                        class="px-3 py-1 rounded text-violet-600 text-xs border border-violet-600 hover:bg-violet-800 hover:text-white transition duration-300 ease-linear">View</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>
@script
    <script>
        $(document).ready(function() {
            var table = $('.dat-table').DataTable({
                    responsive: true
                })
                .columns.adjust()
                .responsive.recalc();
        });
    </script>
@endscript
