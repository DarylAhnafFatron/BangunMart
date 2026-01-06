<!DOCTYPE html>
<html>
<head>
    <title>Transaksi Penjualan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">🧾 Transaksi Penjualan</h5>
        </div>

        <div class="card-body">
            @if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

            <form action="/penjualan" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Produk</label>
                    <select name="id_produk" class="form-select" required>
                        <option value="">-- Pilih Produk --</option>
                        @foreach($produk as $p)
                            <option value="{{ $p->id_produk }}">
                                {{ $p->nama_produk }} (Stok: {{ $p->stok }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Jumlah</label>
                    <input type="number" name="qty" class="form-control" min="1" required>
                </div>

                <button type="submit" class="btn btn-success w-100">
                    💾 Simpan Transaksi
                </button>

                <a href="/penjualan" class="btn btn-secondary mt-3 w-100">
                    ← Kembali ke Daftar Nota
                </a>
            </form>
        </div>
    </div>
</div>

</body>
</html>
