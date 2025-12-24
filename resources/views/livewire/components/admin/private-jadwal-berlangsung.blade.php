<div class="bg-white border border-slate-200 shadow-lg rounded-sm">
    <div class="p-4 flex justify-between items-center">
        <div class="text-xl text-slate-600">Jadwal Berlangsung</div>
    </div>
    <hr>
    <div class="p-6">
        <table class="dat-table-jadwal-private stripe hover text-sm text-left text-gray-500"
            style="width:100%; padding-top: 1em;  padding-bottom: 1em;">
            <thead class="text-xs text-gray-700 uppercase">
                <tr>
                    <th data-priority="1" class="text-start">Status</th>
                    <th data-priority="2" class="text-start">Peserta didik</th>
                    <th data-priority="3" class="text-start">Instruktur</th>
                    <th data-priority="4" class="text-start">Tanggal / Waktu</th>
                    <th data-priority="5" class="text-start">Ket.</th>
                    <th data-priority="5" class="text-start">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($jadwalBerlangsung as $dat)
                    <tr>
                        <td>
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-orange-600" fill="currentColor"
                                viewBox="0 0 256 256">
                                <path
                                    d="M211.18,196.56,139.57,128l71.61-68.56a1.59,1.59,0,0,1,.13-.13A16,16,0,0,0,200,32H56A16,16,0,0,0,44.7,59.31l.12.13L116.43,128,44.82,196.56l-.12.13A16,16,0,0,0,56,224H200a16,16,0,0,0,11.32-27.31A1.59,1.59,0,0,1,211.18,196.56ZM56,48h0v0ZM89.43,80h77.14L128,116.92ZM200,48l-16.7,16H72.72L56,48ZM56,208l72-68.92L200,208Z">
                                </path>
                            </svg>
                        </td>
                        <td>{{ $dat->nama_peserta }}</td>
                        <td>{{ $dat->nama_instruktur }}</td>
                        <td>{{ $dat->waktu_mulai->format('d M Y H:i') }}</td>
                        <td>{{ $dat->keterangan }}</td>
                        <td class="flex space-x-2">
                            <button onclick="Absen({{ $dat->id }})"
                                class="px-3 py-1 rounded text-violet-600 text-xs border border-violet-600 hover:bg-violet-800 hover:text-white transition duration-300 ease-linear">
                                Absen
                            </button>
                            <button onclick="Batal({{ $dat->id }})"
                                class="px-3 py-1 rounded text-red-600 text-xs border border-red-600 hover:bg-red-800 hover:text-white transition duration-300 ease-linear">
                                Batal
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<script>
    function Batal(id) {
        Swal.fire({
            title: 'Batalkan Jadwal',
            input: 'text',
            inputPlaceholder: 'Masukkan keterangan',
            showCancelButton: true,
            confirmButtonText: 'Submit',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                @this.call('batalJadwal', id, result.value);
            }
        });
    }

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
