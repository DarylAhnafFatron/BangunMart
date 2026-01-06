<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Omset</title>
</head>
<body>

<h3 style="text-align:center">LAPORAN OMSET PENJUALAN</h3>
<hr>

<table width="100%" border="1" cellspacing="0" cellpadding="6">
    <tr>
        <th>Tanggal</th>
        <th>Total Omset</th>
    </tr>

    @php $total = 0; @endphp
    @foreach($data as $d)
    <tr>
        <td>{{ $d->tanggal }}</td>
        <td>Rp {{ number_format($d->total_omset) }}</td>
    </tr>
    @php $total += $d->total_omset; @endphp
    @endforeach

    <tr>
        <th>Total</th>
        <th>Rp {{ number_format($total) }}</th>
    </tr>
</table>

</body>
</html>
