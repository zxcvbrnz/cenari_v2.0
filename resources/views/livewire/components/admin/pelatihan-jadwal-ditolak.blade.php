<div class="bg-white border border-slate-200 shadow-lg rounded-sm">
    <div class="p-4 flex justify-between items-center">
        <div class="text-xl text-slate-600">Jadwal Ditolak</div>
    </div>
    <hr>
    <div class="p-6">
        <table class="dat-table-jadwal-pelatihan stripe hover text-sm text-left text-gray-500"
            style="width:100%; padding-top: 1em;  padding-bottom: 1em;">
            <thead class="text-xs text-gray-700 uppercase">
                <tr>
                    <th class="text-start">Pelatihan</th>
                    <th class="text-start">Instruktur</th>
                    <th class="text-start">Tanggal / Waktu</th>
                    <th class="text-start">Alasan</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($jadwalDitolak as $dat)
                    <tr>
                        <td>{{ $dat->nama_group }}</td>
                        <td>{{ $dat->nama_instruktur }}</td>
                        <td>{{ $dat->waktu_mulai->format('d M Y h:i') }}</td>
                        <td>{{ $dat->keterangan }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
