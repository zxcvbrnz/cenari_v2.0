<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <style>
        body {
            font-family: DejaVu Sans;
            font-size: 11px;
        }

        .header {
            width: 100%;
            margin-bottom: 15px;
        }

        .header td {
            border: none;
        }

        .logo {
            width: 70px;
        }

        .instansi {
            text-align: center;
        }

        .instansi h2 {
            margin: 0;
            font-size: 16px;
        }

        .instansi p {
            margin: 2px 0;
            font-size: 11px;
        }

        hr {
            border: 0;
            border-top: 2px solid #000;
            margin: 10px 0 15px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #444;
            padding: 6px;
        }

        th {
            background: #f1f5f9;
            text-align: center;
        }

        .right {
            text-align: right;
        }

        .center {
            text-align: center;
        }

        .summary {
            margin-top: 15px;
            width: 50%;
        }

        .summary td {
            border: none;
            padding: 4px;
        }
    </style>
</head>

<body>

    {{-- HEADER --}}
    <table class="header">
        <tr>
            <td width="15%">
                {{-- <img src="{{ asset('image/cenari.png') }}" class="logo"> --}}
                <img src="{{ public_path('image/cenari.png') }}" class="logo">
            </td>
            <td class="instansi">
                <h2>CENARI EDUCATION CENTER</h2>
            </td>
            <td width="15%"></td>
        </tr>
    </table>

    <hr>

    <h3 style="text-align:center;">
        LAPORAN KEUANGAN BULAN {{ \Carbon\Carbon::parse($bulan . '-01')->translatedFormat('F Y') }}
    </h3>

    {{-- TABEL --}}
    <table>
        <thead>
            <tr>
                <th width="15%">Tanggal</th>
                <th>Keterangan</th>
                <th width="15%">Jenis</th>
                <th width="20%">Nominal (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $item)
                <tr>
                    <td class="center">
                        {{ \Carbon\Carbon::parse($item['date'])->format('d M Y') }}
                    </td>
                    <td>{{ $item['description'] }}</td>
                    <td class="center">
                        {{ $item['type'] === 'income' ? 'Pemasukan' : 'Pengeluaran' }}
                    </td>
                    <td class="right">
                        {{ $item['type'] === 'expense' ? '-' : '' }}
                        {{ number_format($item['amount'], 0, ',', '.') }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{-- RINGKASAN --}}
    <table class="summary">
        <tr>
            <td><strong>Total Pemasukan</strong></td>
            <td class="right">Rp {{ number_format($totalIncome, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td><strong>Total Pengeluaran</strong></td>
            <td class="right">Rp {{ number_format($totalExpense, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td><strong>Pemasukan Bersih</strong></td>
            <td class="right">
                <strong>Rp {{ number_format($saldo, 0, ',', '.') }}</strong>
            </td>
        </tr>
    </table>

</body>

</html>
