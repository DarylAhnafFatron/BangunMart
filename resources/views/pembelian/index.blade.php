<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Pembelian</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light p-4">

<div class="container">
    <h4 class="mb-3">📋 Data Pembelian</h4>

    <a href="/pembelian/create" class="btn btn-primary mb-3">
        ➕ Tambah Pembelian
    </a>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Tanggal</th>
                <th>Supplier</th>
                <th>Total</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($data as $d)
            <tr>
                <td>{{ $d->id_pembelian }}</td>
                <td>{{ $d->tgl_pembelian }}</td>
                <td>{{ $d->nama_supplier }}</td>
                <td>{{ number_format($d->total_beli) }}</td>
                <td>
                    <a href="/pembelian/delete/{{ $d->id_pembelian }}"
                       class="btn btn-danger btn-sm"
                       onclick="return confirm('Yakin hapus pembelian ini? Stok akan dikurangi!')">
                        🗑 Hapus
                    </a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center text-muted">
                    Belum ada data pembelian
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <a href="/dashboard" class="btn btn-secondary">
        ⬅ Dashboard
    </a>
</div>

</body>
</html>
