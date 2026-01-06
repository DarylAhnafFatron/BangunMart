<!DOCTYPE html>
<html>
<head>
    <title>Supplier</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-4">
    <div class="card shadow">
        <div class="card-header bg-dark text-white d-flex justify-content-between">
            <h5 class="mb-0">Data Supplier</h5>
            <a href="/supplier/create" class="btn btn-success btn-sm">+ Tambah</a>
        </div>

        <div class="card-body">
            <table class="table table-bordered">
                <thead class="table-secondary">
                    <tr>
                        <th>Nama</th>
                        <th>No HP</th>
                        <th>Kota</th>
                        <th width="150">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $s)
                    <tr>
                        <td>{{ $s->nama_supplier }}</td>
                        <td>{{ $s->no_hp }}</td>
                        <td>{{ $s->kota }}</td>
                        <td>
                            <a href="/supplier/edit/{{ $s->id_supplier }}" class="btn btn-warning btn-sm">Edit</a>
                            <a href="/supplier/delete/{{ $s->id_supplier }}"
                               onclick="return confirm('Hapus supplier?')"
                               class="btn btn-danger btn-sm">Hapus</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <a href="/dashboard" class="btn btn-secondary mt-2">⬅ Dashboard</a>
        </div>
    </div>
</div>

</body>
</html>
