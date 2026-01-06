<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Produk - BangunMart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4 bg-light">

<div class="container">

    <h3 class="mb-4">Data Produk BangunMart</h3>

    {{-- FORM TAMBAH PRODUK --}}
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            Tambah Produk
        </div>
        <div class="card-body">
            <form method="POST" action="/produk/store">
                @csrf

                <div class="row g-2">

                    <div class="col-md-3">
                        <input type="text" 
                               name="nama_produk" 
                               class="form-control" 
                               placeholder="Nama Produk" 
                               required>
                    </div>

                    <div class="col-md-2">
                        <select name="id_satuan" class="form-control" required>
                            <option value="">-- Pilih Satuan --</option>
                            @foreach($satuan as $s)
                                <option value="{{ $s->id_satuan }}">
                                    {{ $s->nama_satuan }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2">
                        <input type="number" 
                               name="harga_jual" 
                               class="form-control" 
                               placeholder="Harga Jual" 
                               required>
                    </div>

                    <div class="col-md-2">
                        <input type="number" 
                               name="stok_minimum" 
                               class="form-control" 
                               placeholder="Stok Min" 
                               required>
                    </div>
<div class="col-md-2">
    <select name="id_kategori" class="form-control" required>
        <option value="">-- Kategori --</option>
        @foreach($kategori as $k)
            <option value="{{ $k->id_kategori }}">
                {{ $k->nama_kategori }}
            </option>
        @endforeach
    </select>
</div>

                    <div class="col-md-1">
                        <button class="btn btn-success w-100">
                            Simpan
                        </button>
                    </div>

                </div>
            </form>
        </div>
    </div>


    
    {{-- TABEL DATA PRODUK --}}
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Nama Produk</th>
                <th>Satuan</th>
                <th>Harga</th>
                <th>Stok</th>
                <th>Stok Min</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($produk as $p)
            <tr>
                <td>{{ $p->id_produk }}</td>
                <td>{{ $p->nama_produk }}</td>
                <td>{{ $p->nama_satuan }}</td>
                <td>{{ number_format($p->harga_jual) }}</td>
                <td>{{ $p->stok }}</td>
                <td>{{ $p->stok_minimum }}</td>
                <td>
                   
                    <a href="/produk/delete/{{ $p->id_produk }}"
                       class="btn btn-danger btn-sm"
                       onclick="return confirm('Hapus produk ini?')">
                        Hapus
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
<a href="/dashboard" class="btn btn-secondary">
    ⬅ Kembali ke Dashboard
</a>


</body>
</html>
