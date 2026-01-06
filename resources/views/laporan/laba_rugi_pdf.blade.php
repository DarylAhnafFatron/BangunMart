<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        h2 { text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        td, th { border: 1px solid #000; padding: 8px; }
        th { background: #f2f2f2; }
    </style>
</head>
<body>

<h2>Laporan Laba Rugi BangunMart</h2>

<p>
Periode:
<strong>
{{ $awal ?? 'Semua' }} s/d {{ $akhir ?? 'Semua' }}
</strong>
</p>

<table>
    <tr>
        <th>Keterangan</th>
        <th>Jumlah</th>
    </tr>
    <tr>
        <td>Total Penjualan</td>
        <td>Rp {{ number_format($jual) }}</td>
    </tr>
    <tr>
        <td>Total Pembelian</td>
        <td>Rp {{ number_format($beli) }}</td>
    </tr>
    <tr>
        <th>Laba Bersih</th>
        <th>Rp {{ number_format($laba) }}</th>
    </tr>
</table>

<br>
<p style="text-align:right;">
Dicetak pada: {{ now() }}
</p>

</body>
</html>
