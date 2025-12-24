<!DOCTYPE html>
<html>

<head>
    <title>Data Peserta {{ $peserta->user->name }}</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>
        body {
            font-size: 12px;
        }

        .container {
            padding: 20px;
        }

        h3 {
            font-size: 16px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>
    <div>{{ now()->format('d M Y H:i') }}</div>
    <div class="container">
        <h3>Data Peserta {{ $peserta->user->name }}</h3>
        <p>{{ $peserta->mapel->nama ?? $peserta->group->nama . ' | ' . $peserta->group->mapel->nama }}</p>

        <table class="table mt-4 table-sm">
            <tr>
                <th>Tempat/Tanggal Lahir</th>
                <td>: {{ $peserta->tempat_lahir }}/{{ $peserta->tanggal_lahir }}</td>
            </tr>
            <tr>
                <th>Nama Ibu</th>
                <td>: {{ $peserta->nama_ibu }}</td>
            </tr>
            <tr>
                <th>Nama Ayah</th>
                <td>: {{ $peserta->nama_ayah }}</td>
            </tr>
            <tr>
                <th>NISN</th>
                <td>: {{ $peserta->nisn }}</td>
            </tr>
            <tr>
                <th>NIK</th>
                <td>: {{ $peserta->nik }}</td>
            </tr>
            <tr>
                <th>Jenis Kelamin</th>
                <td>: {{ $peserta->jenis_kelamin }}</td>
            </tr>
            <tr>
                <th>Pendidikan</th>
                <td>: {{ $peserta->pendidikan }}</td>
            </tr>
            <tr>
                <th>Agama</th>
                <td>: {{ $peserta->agama }}</td>
            </tr>
            <tr>
                <th>Kewarganegaraan</th>
                <td>: {{ $peserta->kewarganegaraan }}</td>
            </tr>
            <tr>
                <th>Penerima KPS</th>
                <td>: {{ $peserta->penerima_kps }}</td>
            </tr>
            <tr>
                <th>No KPS</th>
                <td>: {{ $peserta->no_kps }}</td>
            </tr>
            <tr>
                <th>Layak PIP</th>
                <td>: {{ $peserta->layak_pip }}</td>
            </tr>
            <tr>
                <th>Alasan PIP</th>
                <td>: {{ $peserta->alasan_pip }}</td>
            </tr>
            <tr>
                <th>Penerima KIP</th>
                <td>: {{ $peserta->penerima_kip }}</td>
            </tr>
            <tr>
                <th>No KIP</th>
                <td>: {{ $peserta->no_kip }}</td>
            </tr>
            <tr>
                <th>Alamat</th>
                <td>: {{ $peserta->alamat }}</td>
            </tr>
            <tr>
                <th>RT/RW</th>
                <td>: {{ $peserta->rt }}/{{ $peserta->rw }}</td>
            </tr>
            <tr>
                <th>Kode Pos</th>
                <td>: {{ $peserta->kode_pos }}</td>
            </tr>
            <tr>
                <th>Nama Desa/Kelurahan</th>
                <td>: {{ $peserta->nama_desa_kelurahan }}</td>
            </tr>
            <tr>
                <th>Provinsi</th>
                <td>: {{ $peserta->provinsi }}</td>
            </tr>
            <tr>
                <th>Kab/Kota</th>
                <td>: {{ $peserta->kab_kota }}</td>
            </tr>
            <tr>
                <th>Kecamatan</th>
                <td>: {{ $peserta->kecamatan }}</td>
            </tr>
            <tr>
                <th>Kelurahan</th>
                <td>: {{ $peserta->kelurahan }}</td>
            </tr>
            <tr>
                <th>Jenis Tinggal</th>
                <td>: {{ $peserta->jenis_tinggal }}</td>
            </tr>
            <tr>
                <th>Alat Transportasi</th>
                <td>: {{ $peserta->alat_transportasi }}</td>
            </tr>
            <tr>
                <th>Nomor Telepon</th>
                <td>: {{ $peserta->nomor_telepon }}</td>
            </tr>
            <tr>
                <th>Email</th>
                <td>: {{ $peserta->email }}</td>
            </tr>
            <tr>
                <th>Status Saat Ini</th>
                <td>: {{ $peserta->status_saat_ini }}</td>
            </tr>
        </table>
    </div>
    <br>
    <br>
    <br>
    <br>
    <br>
    <div class="container">
        <h3>Data Nilai Peserta {{ $peserta->user->name }}</h3>
        <p>{{ $peserta->mapel->nama ?? $peserta->group->nama . ' | ' . $peserta->group->mapel->nama }}</p>

        <table class="table mt-4 table-sm">
            @if ($peserta->nilai)
                @for ($i = 1; $i <= 10; $i++)
                    <tr>
                        <td> {{ $peserta->nilai->{'materi_' . $i} }}</td>
                        <td> {{ $peserta->nilai->{'nilai_' . $i} }}</td>
                    </tr>
                @endfor
            @endif
        </table>
        <br>
        <br>
        <br>
        <h3>Data Absensi Peserta {{ $peserta->user->name }}</h3>

        <table class="table mt-4 table-sm">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Jadwal</th>
                    <th>Absen pada</th>
                    <th>Instruktur / Pelatihan</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            @foreach ($peserta->riwayatAbsensi as $absen)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $absen->waktu_mulai->format('d M Y h:i') }}</td>
                    <td>{{ $absen->waktu_absen->format('d M Y h:i') }}</td>
                    <td>{{ $absen->nama_instruktur }} / {{ $absen->nama_group ?? '-' }}</td>
                    <td>{{ $absen->keterangan }}</td>
                </tr>
            @endforeach
        </table>
        <br>
        <br>
        <br>
        @if (!$peserta->id_group)
            <h3>Data Pembayaran Peserta {{ $peserta->user->name }}</h3>

            <table class="table mt-4 table-sm">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Jumlah Dibayar</th>
                        <th>Deskripsi</th>
                    </tr>
                </thead>
                @foreach ($peserta->pembayaran as $pembayaran)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $pembayaran->tanggal_dibayar->format('d M Y h:i') }}</td>
                        <td>{{ number_format($pembayaran->jumlah_dibayar) }}</td>
                        <td>{{ $pembayaran->deskripsi }}</td>
                    </tr>
                @endforeach
            </table>
        @endif
    </div>
</body>

</html>
