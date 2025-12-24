<div class="bg-white border border-slate-200 shadow-lg rounded-sm">
    <div class="p-4 flex justify-between items-center">
        <div class="text-xl text-slate-600">Jadwal Berlangsung</div>
    </div>
    <hr>
    <div class="p-6">
        <table class="dat-table-jadwal-pelatihan stripe hover text-sm text-left text-gray-500"
            style="width:100%; padding-top: 1em;  padding-bottom: 1em;">
            <thead class="text-xs text-gray-700 uppercase">
                <tr>
                    <th class="text-start">Status</th>
                    <th class="text-start">Pelatihan</th>
                    <th class="text-start">Instruktur</th>
                    <th class="text-start">Tanggal / Waktu</th>
                    <th class="text-start">Ket.</th>
                    <th class="text-start">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($jadwalBerlangsung as $index => $dat)
                    <tr>
                        <td>
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-orange-600" fill="currentColor"
                                viewBox="0 0 256 256">
                                <path
                                    d="M211.18,196.56,139.57,128l71.61-68.56a1.59,1.59,0,0,1,.13-.13A16,16,0,0,0,200,32H56A16,16,0,0,0,44.7,59.31l.12.13L116.43,128,44.82,196.56l-.12.13A16,16,0,0,0,56,224H200a16,16,0,0,0,11.32-27.31A1.59,1.59,0,0,1,211.18,196.56ZM56,48h0v0ZM89.43,80h77.14L128,116.92ZM200,48l-16.7,16H72.72L56,48ZM56,208l72-68.92L200,208Z">
                                </path>
                            </svg>
                        </td>
                        <td>{{ $dat->nama_group }}</td>
                        <td>{{ $dat->nama_instruktur }}</td>
                        <td>{{ $dat->waktu_mulai->format('d M Y H:i') }}</td>
                        <td>{{ $dat->keterangan }}</td>
                        <td class="space-x-2">
                            <a href="{{ route('admin.jadwal.pelatihan.view', ['id_group' => $dat->id_group, 'id_instruktur' => $dat->id_instruktur, 'waktu_mulai' => $dat->waktu_mulai, 'keterangan' => $dat->keterangan]) }}"
                               wire:navigate
                               class="px-3 py-1 rounded text-violet-600 text-xs border border-violet-600 hover:bg-violet-800 hover:text-white transition duration-300 ease-linear">
                               View
                            </a>
                            <button onclick="selesai({{ $dat->id_group }}, {{ $dat->id_instruktur }}, '{{ $dat->waktu_mulai }}')"
                                class="px-3 py-1 rounded text-green-600 text-xs border border-green-600 hover:bg-green-800 hover:text-white transition duration-300 ease-linear">
                                Selesai
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<script>
    function selesai(idGroup, idInstruktur, waktuMulai) {
        Swal.fire({
            icon: 'warning',
            title: 'Absen?',
            text: 'Dengan ini Kamu menyatakan bahwa peserta telah absen!',
            showCancelButton: true,
            confirmButtonText: 'Ya',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                @this.call('selesaiPelatihan', idGroup, idInstruktur, waktuMulai);
                // Swal.fire(`Nilai yang Anda masukkan: ${idGroup} , ${idInstruktur} , ${waktuMulai}`);
            }
        });
    }
</script>
