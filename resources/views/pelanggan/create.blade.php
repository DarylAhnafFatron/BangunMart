<!DOCTYPE html>
<html>
<head>
    <title>Tambah Pelanggan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Tambah Pelanggan</h5>
        </div>

        <div class="card-body">
            <form method="POST" action="/pelanggan/store">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Nama Pelanggan</label>
                    <input type="text" name="nama_pelanggan" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">No HP</label>
                    <input type="text" name="no_hp" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Tipe</label>
                    <select name="tipe" class="form-select" required>
                        <option value="umum">Umum</option>
                        <option value="member">Member</option>
                        <option value="proyek">Proyek</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Kota</label>
                    <input type="text" name="kota" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-success w-100">
                    💾 Simpan
                </button>

                <a href="/pelanggan" class="btn btn-secondary w-100 mt-2">
                    ← Kembali
                </a>
            </form>
        </div>
    </div>
</div>

</body>
</html>
