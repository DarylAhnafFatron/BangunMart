<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Stok Menipis</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-4">

    <div class="card shadow">
        <div class="card-header bg-warning text-dark">
            <h5 class="mb-0">⚠️ Laporan Stok Menipis</h5>
        </div>

        <div class="card-body">

            <table class="table table-bordered table-striped text-center">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Nama Produk</th>
                        <th>Stok</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data as $i => $p)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>{{ $p->nama_produk }}</td>
                            <td>{{ $p->stok }}</td>
                            <td>
                                <span class="badge bg-danger">
                                    Stok Menipis
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-muted">
                                Semua stok aman
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <a href="/dashboard" class="btn btn-secondary mt-2">
                ⬅ Kembali ke Dashboard
            </a>

        </div>
    </div>

</div>

</body>
</html>
