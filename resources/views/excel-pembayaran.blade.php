<!DOCTYPE html>
<html>

<head>
    <title>Data Pembayaran</title>
</head>

<body>
    <table style="width: 100%; border-collapse: collapse; font-family: Arial, sans-serif;">
        <thead>
            <tr>
                <th style="background-color: #3572EF; color: white; text-align: center; font-weight: bold;">
                    Pembayar
                </th>
                <th style="background-color: #3572EF; color: white; text-align: center; font-weight: bold;">
                    Jumlah Dibayar
                </th>
                <th style="background-color: #3572EF; color: white; text-align: center; font-weight: bold;">
                    Harga
                </th>
                <th style="background-color: #3572EF; color: white; text-align: center; font-weight: bold;">
                    Tanggal Dibayarkan
                </th>
                <th style="background-color: #3572EF; color: white; text-align: center; font-weight: bold;">
                    Deskripsi
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($payment as $data)
                <tr>
                    <td>
                        {{ $data->id_group ? $data->group->nama : $data->peserta->user->name }}
                    </td>
                    <td>
                        Rp. {{ number_format($data->jumlah_dibayar) }}
                    </td>
                    <td>
                        Rp.
                        {{ $data->id_group ? number_format($data->group->harga) : number_format($data->peserta->mapel->harga) }}
                    </td>
                    <td>
                        {{ $data->tanggal_dibayar->format('d F Y H:i') }}
                    </td>
                    <td>
                        {{ $data->deskripsi }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
