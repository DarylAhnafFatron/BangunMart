<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Laba Rugi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-light p-4">

<div class="container">
    <h4 class="mb-4">📊 Laporan Laba Rugi</h4>
<form method="GET" class="row g-2 mb-4">
    <div class="col-md-4">
        <input type="date"
               name="tanggal_awal"
               value="{{ $awal ?? '' }}"
               class="form-control"
               required>
    </div>

    <div class="col-md-4">
        <input type="date"
               name="tanggal_akhir"
               value="{{ $akhir ?? '' }}"
               class="form-control"
               required>
    </div>

    <div class="col-md-4">
        <button class="btn btn-primary w-100">
            🔍 Filter
        </button>
    </div>
</form>

    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>Tanggal</th>
                <th>Penjualan</th>
                <th>Pembelian</th>
                <th>Laba</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $d)
            <tr>
                <td>{{ $d['tanggal'] }}</td>
                <td>Rp {{ number_format($d['penjualan']) }}</td>
                <td>Rp {{ number_format($d['pembelian']) }}</td>
                <td>Rp {{ number_format($d['penjualan'] - $d['pembelian']) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="row my-4">
        <div class="col-md-4">
            <div class="card text-center">
                <div class="card-body">
                    <h6>Total Penjualan</h6>
                    <h5 class="text-success">Rp {{ number_format($totalPenjualan) }}</h5>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center">
                <div class="card-body">
                    <h6>Total Pembelian</h6>
                    <h5 class="text-danger">Rp {{ number_format($totalPembelian) }}</h5>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center border-primary">
                <div class="card-body">
                    <h6><b>Laba Bersih</b></h6>
                    <h4 class="text-primary">Rp {{ number_format($labaBersih) }}</h4>
                </div>
            </div>
        </div>
    </div>

    <canvas id="grafik"></canvas>

    <a href="/dashboard" class="btn btn-secondary mt-3">⬅ Kembali ke Dashboard</a>
</div>

<script>
new Chart(document.getElementById('grafik'), {
    type: 'bar',
    data: {
        labels: {!! json_encode(array_column($data, 'tanggal')) !!},
        datasets: [
            {
                label: 'Penjualan',
                data: {!! json_encode(array_column($data, 'penjualan')) !!}
            },
            {
                label: 'Pembelian',
                data: {!! json_encode(array_column($data, 'pembelian')) !!}
            },
            {
                label: 'Laba',
                data: {!! json_encode(
                    array_map(fn($d) => $d['penjualan'] - $d['pembelian'], $data)
                ) !!}
            }
        ]
    }
});
</script>

</body>
</html>
