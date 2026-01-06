<!DOCTYPE html>
<html>
<head>
    <title>Data Pelanggan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-4">
    <div class="card shadow">
        <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Data Pelanggan</h5>
            <a href="/pelanggan/create" class="btn btn-success btn-sm">
                + Tambah Pelanggan
            </a>
        </div>

        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead class="table-secondary">
                    <tr>
                        <th>Nama</th>
                        <th>No HP</th>
                        <th>Tipe</th>
                        <th>Kota</th>
                        <th>Tgl Daftar</th>
                        <th width="150">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data as $p)
                    <tr>
                        <td>{{ $p->nama_pelanggan }}</td>
                        <td>{{ $p->no_hp }}</td>
                        <td>{{ ucfirst($p->tipe) }}</td>
                        <td>{{ $p->kota }}</td>
                        <td>{{ $p->tgl_daftar }}</td>
                        <td>
                            <a href="/pelanggan/edit/{{ $p->id_pelanggan }}" class="btn btn-warning btn-sm">
                                Edit
                            </a>
                            <a href="/pelanggan/delete/{{ $p->id_pelanggan }}"
                               onclick="return confirm('Yakin ingin menghapus pelanggan ini?')"
                               class="btn btn-danger btn-sm">
                                Hapus
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted">
                            Belum ada data pelanggan
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            <a href="/dashboard" class="btn btn-secondary mt-2">
                ← Kembali ke Dashboard
            </a>
        </div>
    </div>
</div>

</body>
</html>
