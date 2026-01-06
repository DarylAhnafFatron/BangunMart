<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Satuan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-4">

    <div class="card shadow">
        <div class="card-header bg-info text-white">
            <h5 class="mb-0">📐 Data Satuan</h5>
        </div>

        <div class="card-body">

            {{-- FORM TAMBAH --}}
            <form action="/satuan/store" method="POST" class="mb-4">
                @csrf
                <div class="input-group">
                    <input type="text"
                           name="nama_satuan"
                           class="form-control"
                           placeholder="Nama satuan (pcs, kg, dll)"
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
                        <th>Nama Satuan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data as $i => $s)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $s->nama_satuan }}</td>
                        <td>

                            {{-- EDIT --}}
                            <form action="/satuan/update/{{ $s->id_satuan }}"
                                  method="POST"
                                  class="d-inline">
                                @csrf
                                <input type="text"
                                       name="nama_satuan"
                                       value="{{ $s->nama_satuan }}"
                                       required>
                                <button class="btn btn-warning btn-sm">
                                    ✏️
                                </button>
                            </form>

                            {{-- DELETE --}}
                            <a href="/satuan/delete/{{ $s->id_satuan }}"
                               class="btn btn-danger btn-sm"
                               onclick="return confirm('Hapus satuan?')">
                                🗑️
                            </a>

                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="text-muted">
                            Belum ada satuan
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
