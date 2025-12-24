<div class="bg-white border border-slate-200 shadow-lg rounded-sm">
    <div class="p-4 flex justify-between items-center">
        <div class="text-xl text-slate-600">
            <div>{{ $namaGroup . ' | ' . $waktuMulai . ' | ' . $keterangan }}</div>
            <div>Instruktur : {{ $namaInstruktur }}</div>
        </div>
    </div>
    <hr>
    <div class="p-6">
        <table class="dat-table-jadwal-pelatihan-view stripe hover text-sm text-left text-gray-500"
            style="width:100%; padding-top: 1em;  padding-bottom: 1em;">
            <thead class="text-xs text-gray-700 uppercase">
                <tr>
                    <th data-priority="1" class="text-start">Nomor</th>
                    <th data-priority="2" class="text-start">Peserta didik</th>
                    <th data-priority="5" class="text-start">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($jadwalBerlangsung as $dat)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $dat->nama_peserta }}</td>
                        <td>
                            @if($dat->status === '1')
                                <button onclick="Absen({{ $dat->id }})"
                                    class="px-3 py-1 rounded text-violet-600 text-xs border border-violet-600 hover:bg-violet-800 hover:text-white transition duration-300 ease-linear">
                                    Absen
                                </button>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<script>
    function Absen(id) {
        Swal.fire({
            icon: 'warning',
            title: 'Absen?',
            text: 'Dengan ini Kamu menyatakan bahwa peserta telah absen!',
            showCancelButton: true,
            confirmButtonText: 'Ya',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                @this.call('absenPeserta', id);
            }
        });
    }
</script>
