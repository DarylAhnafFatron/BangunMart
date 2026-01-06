<!DOCTYPE html>
<html>
<head>
    <title>Tambah Supplier</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h5>Tambah Supplier</h5>
        </div>

        <div class="card-body">
            <form method="POST" action="/supplier/store">
                @csrf

                <div class="mb-3">
                    <label>Nama Supplier</label>
                    <input type="text" name="nama_supplier" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>No HP</label>
                    <input type="text" name="no_hp" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Kota</label>
                    <input type="text" name="kota" class="form-control" required>
                </div>

                <button class="btn btn-success w-100">Simpan</button>
                <a href="/supplier" class="btn btn-secondary w-100 mt-2">Kembali</a>
            </form>
        </div>
    </div>
</div>

</body>
</html>
