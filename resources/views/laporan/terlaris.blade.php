<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Produk Terlaris</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-4">

    <div class="card shadow">
        <div class="card-header bg-success text-white">
            <h5 class="mb-0">📊 Laporan Produk Terlaris</h5>
        </div>

        <div class="card-body">

            <!-- TABEL -->
            <table class="table table-bordered table-striped text-center">
                <thead class="table-dark">
                    <tr>
                        <th>Peringkat</th>
                        <th>Nama Produk</th>
                        <th>Total Terjual</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data as $i => $d)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>{{ $d->nama_produk }}</td>
                            <td>{{ $d->total_terjual }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-muted">
                                Belum ada data penjualan
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- GRAFIK -->
            <hr class="my-4">

            <h6 class="mb-3 text-center">📈 Grafik Produk Terlaris</h6>

            <div class="card shadow-sm">
                <div class="card-body">
                    <canvas id="produkTerlarisChart"></canvas>
                </div>
            </div>

            <a href="/dashboard" class="btn btn-secondary mt-3">
                ⬅ Kembali ke Dashboard
            </a>

        </div>
    </div>

</div>

<!-- CHART JS -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
const labels = @json(array_column($data, 'nama_produk'));
const values = @json(array_column($data, 'total_terjual'));

new Chart(document.getElementById('produkTerlarisChart'), {
    type: 'bar',
    data: {
        labels: labels,
        datasets: [{
            label: 'Total Terjual',
            data: values,
            backgroundColor: '#198754'
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { display: false }
        }
    }
});
</script>

</body>
</html>
