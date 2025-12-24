<div class="p-6 bg-white border border-slate-200 shadow-lg rounded-sm">
    <table class="dat-table-permohonan stripe hover text-sm text-left text-gray-500"
        style="width:100%; padding-top: 1em;  padding-bottom: 1em;">
        <thead class="text-xs text-gray-700 uppercase">
            <tr>
                <th class="text-start">Pelatihan</th>
                <th class="text-start">Instruktur</th>
                <th class="text-start">Tanggal / Waktu</th>
                <th class="text-start">Ket.</th>
                <th class="text-start">Aksi</th>
            </tr>
        </thead>
        <tbody>
            {{-- {{ $permohonan }} --}}
            @foreach ($permohonangroup as $dat)
                <tr>
                    <td>{{ $dat->nama_group }}</td>
                    <td>{{ $dat->nama_instruktur }}</td>
                    <td>{{ $dat->waktu_mulai->format('d M Y h:i') }}</td>
                    <td>{{ $dat->keterangan }}</td>
                    <td class="space-x-2">
                        <button
                            class="px-3 py-1 rounded text-violet-600 text-xs border border-violet-600 hover:bg-violet-800 hover:text-white transition duration-300 ease-linear"
                            onclick="confirmVerif({{ $dat->id_group }})">Verifikasi</button>
                        <button
                            class="px-3 py-1 rounded text-red-600 text-xs border border-red-600 hover:bg-red-600 hover:text-white transition duration-300 ease-linear">Tolak</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<script>
    function confirmVerif($id) {
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
                @this.call(`confirmVerifikasi`, ($id));
            }
        });
    }
</script>
