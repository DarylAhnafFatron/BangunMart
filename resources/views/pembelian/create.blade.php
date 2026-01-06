<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pembelian Barang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light p-4">

<div class="container">
    <div class="card shadow">
        <div class="card-header bg-success text-white">
            <h5 class="mb-0">📦 Pembelian Barang dari Supplier</h5>
        </div>

        <div class="card-body">
            <form method="POST" action="/pembelian/store">
                @csrf

                <!-- SUPPLIER -->
                <div class="mb-3">
                    <label class="form-label">Supplier</label>
                    <select name="id_supplier" class="form-control" required>
                        <option value="">-- Pilih Supplier --</option>
                        @foreach($supplier as $s)
                            <option value="{{ $s->id_supplier }}">
                                {{ $s->nama_supplier }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <hr>

                <!-- PRODUK -->
                <div class="row g-2 mb-3">
                    <div class="col-md-5">
                        <label class="form-label">Produk</label>
                        <select name="produk[]" class="form-control" required>
                            <option value="">-- Pilih Produk --</option>
                            @foreach($produk as $p)
                                <option value="{{ $p->id_produk }}">
                                    {{ $p->nama_produk }} ({{ $p->nama_satuan }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Qty</label>
                        <input type="number"
                               name="qty[]"
                               min="1"
                               class="form-control"
                               required>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Harga Beli / Satuan</label>
                        <input type="number"
                               name="harga_beli[]"
                               min="1"
                               class="form-control"
                               required>
                    </div>
                </div>

                <button class="btn btn-success w-100">
                    💾 Simpan Pembelian
                </button>
            </form>

            <a href="/dashboard" class="btn btn-secondary mt-3">
                ⬅ Kembali ke Dashboard
            </a>
        </div>
    </div>
</div>

</body>
</html>
