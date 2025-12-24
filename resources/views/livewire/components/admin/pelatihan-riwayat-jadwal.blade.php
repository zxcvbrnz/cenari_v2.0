<div class="bg-white border border-slate-200 shadow-lg rounded-sm">
    <div class="p-4 flex justify-between items-center">
        <div class="text-xl text-slate-600">Riwayat Jadwal</div>
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
                </tr>
            </thead>
            <tbody>
                @foreach ($riwayatJadwal as $dat)
                    <tr>
                        <td>
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-green-600" fill="currentColor"
                                viewBox="0 0 256 256">
                                <path
                                    d="M173.66,98.34a8,8,0,0,1,0,11.32l-56,56a8,8,0,0,1-11.32,0l-24-24a8,8,0,0,1,11.32-11.32L112,148.69l50.34-50.35A8,8,0,0,1,173.66,98.34ZM224,48V208a16,16,0,0,1-16,16H48a16,16,0,0,1-16-16V48A16,16,0,0,1,48,32H208A16,16,0,0,1,224,48ZM208,208V48H48V208H208Z">
                                </path>
                            </svg>
                        </td>
                        <td>{{ $dat->nama_group }}</td>
                        <td>{{ $dat->nama_instruktur }}</td>
                        <td>{{ $dat->waktu_mulai->format('d M Y H:i') }}</td>
                        <td>{{ $dat->keterangan }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
