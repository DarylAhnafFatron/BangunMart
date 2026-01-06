<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Kategori</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-4">

    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">📂 Data Kategori</h5>
        </div>

        <div class="card-body">

            {{-- FORM TAMBAH --}}
            <form action="/kategori/store" method="POST" class="mb-4">
                @csrf
                <div class="input-group">
                    <input type="text"
                           name="nama_kategori"
                           class="form-control"
                           placeholder="Nama kategori"
                           required>
                    <button class="btn btn-success">
                        ➕ Tambah
                    </button>
                </div>
            </form>

            {{-- TABEL --}}
            <table class="table table-bordered text-center">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Nama Kategori</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data as $i => $k)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $k->nama_kategori }}</td>
                        <td>

                            {{-- EDIT --}}
                            <form action="/kategori/update/{{ $k->id_kategori }}"
                                  method="POST"
                                  class="d-inline">
                                @csrf
                                <input type="text"
                                       name="nama_kategori"
                                       value="{{ $k->nama_kategori }}"
                                       required>
                                <button class="btn btn-warning btn-sm">
                                    ✏️
                                </button>
                            </form>

                            {{-- DELETE --}}
                            <a href="/kategori/delete/{{ $k->id_kategori }}"
                               class="btn btn-danger btn-sm"
                               onclick="return confirm('Hapus kategori?')">
                                🗑️
                            </a>

                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="text-muted">
                            Belum ada kategori
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            <a href="/dashboard" class="btn btn-secondary">
                ⬅ Kembali ke Dashboard
            </a>

        </div>
    </div>

</div>

</body>
</html>
