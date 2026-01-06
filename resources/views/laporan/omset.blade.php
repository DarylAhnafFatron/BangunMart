<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Omset Penjualan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-4">

    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">💰 Laporan Omset Penjualan</h5>
        </div>

        <div class="card-body">
<form method="GET" class="row g-2 mb-3">
    <div class="col-md-4">
        <input type="date" name="dari" class="form-control" required>
    </div>
    <div class="col-md-4">
        <input type="date" name="sampai" class="form-control" required>
    </div>
    <div class="col-md-4">
        <button class="btn btn-primary w-100">Filter</button>
    </div>
</form>

<a href="/laporan/omset/pdf" class="btn btn-danger mb-3">
    📄 Export PDF
</a>
            <!-- TABEL -->
            <table class="table table-bordered text-center">
                <thead class="table-dark">
                    <tr>
                        <th>Tanggal</th>
                        <th>Total Omset</th>
                    </tr>
                </thead>
                <tbody>
                    @php $grand = 0; @endphp
                    @forelse($data as $d)
                        <tr>
                            <td>{{ $d->tanggal }}</td>
                            <td>Rp {{ number_format($d->total_omset) }}</td>
                        </tr>
                        @php $grand += $d->total_omset; @endphp
                    @empty
                        <tr>
                            <td colspan="2" class="text-muted">
                                Belum ada transaksi
                            </td>
                        </tr>
                    @endforelse
                </tbody>
                <tfoot>
                    <tr class="table-success fw-bold">
                        <td>Total Omset</td>
                        <td>Rp {{ number_format($grand) }}</td>
                    </tr>
                </tfoot>
            </table>

            <!-- GRAFIK -->
            <hr class="my-4">

            <h6 class="text-center mb-3">📈 Grafik Omset BangunMart</h6>

            <div class="card shadow-sm">
                <div class="card-body">
                    <canvas id="omsetChart"></canvas>
                </div>
            </div>

            <a href="/dashboard" class="btn btn-secondary mt-3">
                ⬅ Kembali ke Dashboard
            </a>

        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
const labels = @json(array_column($data, 'tanggal'));
const values = @json(array_column($data, 'total_omset'));

new Chart(document.getElementById('omsetChart'), {
    type: 'line',
    data: {
        labels: labels,
        datasets: [{
            label: 'Omset',
            data: values,
            borderColor: '#0d6efd',
            backgroundColor: 'rgba(13,110,253,0.2)',
            fill: true,
            tension: 0.3
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
