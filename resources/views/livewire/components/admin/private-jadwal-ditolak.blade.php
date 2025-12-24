<div class="bg-white border border-slate-200 shadow-lg rounded-sm">
    <div class="p-4 flex justify-between items-center">
        <div class="text-xl text-slate-600">Jadwal Ditolak</div>
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
                    <th data-priority="5" class="text-start">Alasan</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($jadwalDitolak as $dat)
                    <tr>
                        <td>
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-red-600" fill="currentColor"
                                viewBox="0 0 256 256">
                                <path
                                    d="M208,32H48A16,16,0,0,0,32,48V208a16,16,0,0,0,16,16H208a16,16,0,0,0,16-16V48A16,16,0,0,0,208,32Zm0,176H48V48H208V208ZM165.66,101.66,139.31,128l26.35,26.34a8,8,0,0,1-11.32,11.32L128,139.31l-26.34,26.35a8,8,0,0,1-11.32-11.32L116.69,128,90.34,101.66a8,8,0,0,1,11.32-11.32L128,116.69l26.34-26.35a8,8,0,0,1,11.32,11.32Z">
                                </path>
                            </svg>
                        </td>
                        <td>{{ $dat->nama_peserta }}</td>
                        <td>{{ $dat->nama_instruktur }}</td>
                        <td>{{ $dat->waktu_mulai->format('d M Y H:i') }}</td>
                        <td>{{ $dat->keterangan }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
