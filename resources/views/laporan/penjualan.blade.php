<!DOCTYPE html>
<html>
<head>
    <title>Laporan Penjualan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-4">

    <div class="card shadow mb-3">
        <div class="card-header bg-dark text-white">
            <h5 class="mb-0">📊 Laporan Penjualan</h5>
        </div>

        <div class="card-body">
            <form method="GET" class="row g-2 mb-3">
                <div class="col-md-4">
                    <label>Dari Tanggal</label>
                    <input type="date" name="from" class="form-control" value="{{ $from }}">
                </div>

                <div class="col-md-4">
                    <label>Sampai Tanggal</label>
                    <input type="date" name="to" class="form-control" value="{{ $to }}">
                </div>

                <div class="col-md-4 d-flex align-items-end">
                    <button class="btn btn-primary w-100">
                        🔍 Filter
                    </button>
                </div>
            </form>

            <table class="table table-bordered table-striped">
                <thead class="table-secondary">
                    <tr>
                        <th>ID Nota</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th>Total Item</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data as $d)
                    <tr>
                        <td>{{ $d->id_nota }}</td>
                        <td>{{ $d->tgl_nota }}</td>
                        <td>
                            <span class="badge bg-{{ $d->status_nota == 'dibayar' ? 'success' : 'warning' }}">
                                {{ strtoupper($d->status_nota) }}
                            </span>
                        </td>
                        <td>{{ $d->total_item ?? 0 }}</td>
                        <td>{{ number_format($d->total ?? 0) }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted">
                            Tidak ada data
                        </td>
                    </tr>
                    @endforelse
                </tbody>

                <tfoot>
                    <tr class="table-dark">
                        <th colspan="4">GRAND TOTAL</th>
                        <th>{{ number_format($grandTotal) }}</th>
                    </tr>
                </tfoot>
            </table>

            <a href="/dashboard" class="btn btn-secondary">
                ← Kembali ke Dashboard
            </a>
        </div>
    </div>

</div>

</body>
</html>
