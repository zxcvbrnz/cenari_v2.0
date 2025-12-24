<!DOCTYPE html>

<head>
    <title>Data Peserta Didik</title>
</head>

<body>
    <table style="width: 100%; border-collapse: collapse; font-family: Arial, sans-serif;">
        <thead>
            <tr style="display: none;">
                <td style="border: none"></td>
                <td style="border: none"></td>
                <td style="border: none"></td>
            </tr>
            <tr style="display: none;">
                <td style="border: none"></td>
                <td style="border: none"></td>
                <td style="border: none"></td>
            </tr>
            <tr>
                <th style="border: none">
                </th>
                <th style="background-color: #3572EF; color: white; text-align: center; font-weight: bold;">
                    Nama</th>
                <th style="background-color: #3572EF; color: white; text-align: center; font-weight: bold;">
                    Tempat Lahir</th>
                <th style="background-color: #3572EF; color: white; text-align: center; font-weight: bold;">
                    Tanggal Lahir</th>
                <th style="background-color: #3572EF; color: white; text-align: center; font-weight: bold;">
                    Nama Ibu</th>
                <th style="background-color: #3572EF; color: white; text-align: center; font-weight: bold;">
                    Nama Ayah</th>
                <th style="background-color: #3572EF; color: white; text-align: center; font-weight: bold;">
                    NISN</th>
                <th style="background-color: #3572EF; color: white; text-align: center; font-weight: bold;">
                    NIK</th>
                <th style="background-color: #3572EF; color: white; text-align: center; font-weight: bold;">
                    Jenis Kelamin</th>
                <th style="background-color: #3572EF; color: white; text-align: center; font-weight: bold;">
                    Pendidikan</th>
                <th style="background-color: #3572EF; color: white; text-align: center; font-weight: bold;">
                    Agama</th>
                <th style="background-color: #3572EF; color: white; text-align: center; font-weight: bold;">
                    Kewarganegaraan</th>
                <th style="background-color: #3572EF; color: white; text-align: center; font-weight: bold;">
                    Penerima KPS</th>
                <th style="background-color: #3572EF; color: white; text-align: center; font-weight: bold;">
                    No KPS</th>
                <th style="background-color: #3572EF; color: white; text-align: center; font-weight: bold;">
                    Layak PIP</th>
                <th style="background-color: #3572EF; color: white; text-align: center; font-weight: bold;">
                    Alasan PIP</th>
                <th style="background-color: #3572EF; color: white; text-align: center; font-weight: bold;">
                    Penerima KIP</th>
                <th style="background-color: #3572EF; color: white; text-align: center; font-weight: bold;">
                    No KIP</th>
                <th style="background-color: #3572EF; color: white; text-align: center; font-weight: bold;">
                    Alamat</th>
                <th style="background-color: #3572EF; color: white; text-align: center; font-weight: bold;">
                    RT</th>
                <th style="background-color: #3572EF; color: white; text-align: center; font-weight: bold;">
                    RW</th>
                <th style="background-color: #3572EF; color: white; text-align: center; font-weight: bold;">
                    Kode Pos</th>
                <th style="background-color: #3572EF; color: white; text-align: center; font-weight: bold;">
                    Nama Desa/Kelurahan</th>
                <th style="background-color: #3572EF; color: white; text-align: center; font-weight: bold;">
                    Provinsi</th>
                <th style="background-color: #3572EF; color: white; text-align: center; font-weight: bold;">
                    Kab/Kota</th>
                <th style="background-color: #3572EF; color: white; text-align: center; font-weight: bold;">
                    Kecamatan</th>
                <th style="background-color: #3572EF; color: white; text-align: center; font-weight: bold;">
                    Kelurahan</th>
                <th style="background-color: #3572EF; color: white; text-align: center; font-weight: bold;">
                    Jenis Tinggal</th>
                <th style="background-color: #3572EF; color: white; text-align: center; font-weight: bold;">
                    Alat Transportasi</th>
                <th style="background-color: #3572EF; color: white; text-align: center; font-weight: bold;">
                    Nomor Telepon</th>
                <th style="background-color: #3572EF; color: white; text-align: center; font-weight: bold;">
                    Status</th>
                <th style="background-color: #3572EF; color: white; text-align: center; font-weight: bold;">
                    Status Pembayaran</th>
                <th style="background-color: #3572EF; color: white; text-align: center; font-weight: bold;">
                    Absen</th>
                <th style="background-color: #3572EF; color: white; text-align: center; font-weight: bold;">
                    Program</th>
                <th style="background-color: #3572EF; color: white; text-align: center; font-weight: bold;">
                    Instruktur</th>
                <th style="background-color: #3572EF; color: white; text-align: center; font-weight: bold;">
                    Nama Group/Pelatihan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($exportData as $data)
                <tr>
                    <td style="border: none"></td>
                    <td>{{ $data['nama'] }}</td>
                    <td>{{ $data['biodata']->tempat_lahir }}</td>
                    <td>{{ $data['biodata']->tanggal_lahir }}</td>
                    <td>{{ $data['biodata']->nama_ibu }}</td>
                    <td>{{ $data['biodata']->nama_ayah }}</td>
                    <td>{{ $data['biodata']->nisn }}</td>
                    <td>{{ $data['biodata']->nik }}</td>
                    <td>{{ $data['biodata']->jenis_kelamin }}</td>
                    <td>{{ $data['biodata']->pendidikan }}</td>
                    <td>{{ $data['biodata']->agama }}</td>
                    <td>{{ $data['biodata']->kewarganegaraan }}
                    </td>
                    <td>{{ $data['biodata']->penerima_kps }}</td>
                    <td>{{ $data['biodata']->no_kps }}</td>
                    <td>{{ $data['biodata']->layak_pip }}</td>
                    <td>{{ $data['biodata']->alasan_pip }}</td>
                    <td>{{ $data['biodata']->penerima_kip }}</td>
                    <td>{{ $data['biodata']->no_kip }}</td>
                    <td>{{ $data['biodata']->alamat }}</td>
                    <td>{{ $data['biodata']->rt }}</td>
                    <td>{{ $data['biodata']->rw }}</td>
                    <td>{{ $data['biodata']->kode_pos }}</td>
                    <td>{{ $data['biodata']->nama_desa_kelurahan }}
                    </td>
                    <td>{{ $data['biodata']->provinsi }}</td>
                    <td>{{ $data['biodata']->kab_kota }}</td>
                    <td>{{ $data['biodata']->kecamatan }}</td>
                    <td>{{ $data['biodata']->kelurahan }}</td>
                    <td>{{ $data['biodata']->jenis_tinggal }}</td>
                    <td>{{ $data['biodata']->alat_transportasi }}
                    </td>
                    <td>{{ $data['biodata']->nomor_telepon }}</td>
                    <td>{{ $data['biodata']->status }}</td>
                    <td>{{ $data['pembayaran'] }}</td>
                    <td>{{ $data['absen'] }}</td>
                    <td>{{ $data['mapel'] }}</td>
                    <td>{{ $data['instruktur'] }}</td>
                    <td>{{ $data['group'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
