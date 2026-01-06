<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Penjualan - BangunMart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold">🧾 Data Penjualan</h3>

        <a href="/penjualan/create" class="btn btn-success">
            + Transaksi Baru
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-header bg-dark text-white">
            Daftar Nota Penjualan
        </div>

        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead class="table-secondary">
                    <tr>
                        <th>ID Nota</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data as $d)
                        <tr>
                            <td>#{{ $d->id_nota }}</td>
                            <td>{{ $d->tgl_nota }}</td>
                            <td>
                                <a href="/penjualan/{{ $d->id_nota }}"
                                   class="btn btn-sm btn-primary">
                                    Lihat Nota
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center py-4">
                                Belum ada transaksi
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
<a href="/dashboard" class="btn btn-secondary">
    ⬅ Kembali ke Dashboard
</a>

</body>
</html>
