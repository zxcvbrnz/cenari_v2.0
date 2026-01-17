<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">

    <style>
        @page {
            size: A4 landscape;
            margin: 20px;
        }

        body {
            font-family: DejaVu Sans;
            font-size: 11px;
            position: relative;
        }

        /* ================= WATERMARK ================= */
        .watermark {
            position: fixed;
            top: 35%;
            left: 30%;
            width: 400px;
            opacity: 0.08;
            z-index: -1;
        }

        /* ================= HEADER ================= */
        .header {
            width: 100%;
            margin-bottom: 10px;
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
            text-transform: uppercase;
        }

        .instansi p {
            margin: 2px 0;
            font-size: 11px;
        }

        hr {
            border: 0;
            border-top: 2px solid #000;
            margin: 8px 0 15px;
        }

        /* ================= TABLE ================= */
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
            background: #0f172a;
            color: #fff;
            text-align: center;
            font-size: 11px;
        }

        .center {
            text-align: center;
        }

        .right {
            text-align: right;
        }

        /* ================= COLORS ================= */
        .income {
            color: #16a34a;
            font-weight: bold;
        }

        .expense {
            color: #dc2626;
            font-weight: bold;
        }

        .amount-income {
            color: #16a34a;
            font-weight: bold;
        }

        .amount-expense {
            color: #dc2626;
            font-weight: bold;
        }

        /* ================= SUMMARY ================= */
        .summary {
            margin-top: 20px;
            width: 40%;
            border-top: 2px solid #000;
        }

        .summary td {
            border: none;
            padding: 4px;
            font-size: 11px;
        }
    </style>
</head>

<body>

    {{-- WATERMARK --}}
    <img src="{{ public_path('image/cenari.png') }}" class="watermark">

    {{-- HEADER --}}
    <table class="header">
        <tr>
            <td width="15%">
                <img src="{{ public_path('image/cenari.png') }}" class="logo">
            </td>
            <td class="instansi">
                <h2>CENARI EDUCATION CENTER</h2>
                <p>Laporan Keuangan</p>
            </td>
            <td width="15%"></td>
        </tr>
    </table>

    <hr>

    <h3 style="text-align:center; margin-bottom:15px;">
        LAPORAN KEUANGAN BULAN
        {{ \Carbon\Carbon::parse($bulan . '-01')->translatedFormat('F Y') }}
    </h3>

    {{-- TABEL DATA --}}
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

                    <td>
                        {{ $item['description'] }}
                    </td>

                    <td class="center {{ $item['type'] === 'income' ? 'income' : 'expense' }}">
                        {{ $item['type'] === 'income' ? 'Pemasukan' : 'Pengeluaran' }}
                    </td>

                    <td class="right {{ $item['type'] === 'income' ? 'amount-income' : 'amount-expense' }}">
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
            <td class="right income">
                Rp {{ number_format($totalIncome, 0, ',', '.') }}
            </td>
        </tr>
        <tr>
            <td><strong>Total Pengeluaran</strong></td>
            <td class="right expense">
                Rp {{ number_format($totalExpense, 0, ',', '.') }}
            </td>
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
