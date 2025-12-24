<div class="bg-white border border-slate-200 shadow-lg rounded-sm">
    <div class="p-4 flex justify-between items-center">
        <div class="text-xl text-slate-600">Private</div>
    </div>
    <hr>
    <div class="p-6">
        <table class="dat-table-permohonan stripe hover text-sm text-left text-gray-500"
            style="width:100%; padding-top: 1em;  padding-bottom: 1em;">
            <thead class="text-xs text-gray-700 uppercase">
                <tr>
                    <th data-priority="1" class="text-start">Peserta didik</th>
                    <th data-priority="2" class="text-start">Instruktur</th>
                    <th data-priority="3" class="text-start">Tanggal / Waktu</th>
                    <th data-priority="4" class="text-start">Ket.</th>
                    <th data-priority="5" class="text-start">Aksi</th>
                </tr>
            </thead>
            <tbody>
                {{-- {{ $permohonan }} --}}
                @foreach ($permohonan as $dat)
                    <tr>
                        <td>{{ $dat->nama_peserta }}</td>
                        <td>{{ $dat->nama_instruktur }}</td>
                        <td>{{ $dat->waktu_mulai->format('d M Y H:i') }}</td>
                        <td>{{ $dat->keterangan }}</td>
                        <td class="space-x-2">
                            <button
                                class="px-3 py-1 rounded text-violet-600 text-xs border border-violet-600 hover:bg-violet-800 hover:text-white transition duration-300 ease-linear"
                                onclick="confirmVerifs({{ $dat->id }})">Verifikasi</button>
                            <button onclick="tolakPrivate({{ $dat->id }})"
                                class="px-3 py-1 rounded text-red-600 text-xs border border-red-600 hover:bg-red-600 hover:text-white transition duration-300 ease-linear">Tolak</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<script>
    function confirmVerifs(id) {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Anda tidak akan bisa membatalkan ini!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, verifikasi!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                @this.call(`confirmVerifikasis`, (id));
            }
        });
    }

    function tolakPrivate(id) {
         Swal.fire({
            title: 'Tolak Jadwal',
            input: 'text',
            inputPlaceholder: 'Masukkan keterangan',
            showCancelButton: true,
            confirmButtonText: 'Submit',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                @this.call('tolakPrivate', id, result.value);
            }
        });
    }
</script>
