<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Nota Penjualan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-4">

    <div class="card shadow">
        <div class="card-header bg-dark text-white">
            <h5 class="mb-0">Nota Penjualan</h5>
        </div>

        <div class="card-body">
            <p><strong>ID Nota:</strong> {{ $nota->id_nota }}</p>
            <p><strong>Tanggal:</strong> {{ $nota->tgl_nota }}</p>
            <p>
                <strong>Status:</strong>
                <span class="badge bg-{{ $nota->status_nota == 'dibayar' ? 'success' : 'warning' }}">
                    {{ strtoupper($nota->status_nota) }}
                </span>
            </p>

            {{-- FORM TAMBAH PRODUK --}}
            @if($nota->status_nota === 'baru')
            <form method="POST" action="/penjualan/{{ $nota->id_nota }}/add" class="mb-4">
                @csrf
                <div class="row g-2">
                    <div class="col-md-6">
                        <select name="id_produk" class="form-control" required>
                            <option value="">-- Pilih Produk --</option>
                            @foreach($produk as $p)
                                <option value="{{ $p->id_produk }}">
                                    {{ $p->nama_produk }} (stok: {{ $p->stok }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <input type="number" name="qty" class="form-control" min="1" required>
                    </div>
                    <div class="col-md-3">
                        <button class="btn btn-success w-100">Tambah</button>
                    </div>
                </div>
            </form>
            @endif

            {{-- TABEL DETAIL --}}
            <table class="table table-bordered">
                <thead class="table-secondary">
                    <tr>
                        <th>Produk</th>
                        <th>Qty</th>
                        <th>Harga Satuan</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @php $total = 0; @endphp
                    @forelse($detail as $d)
                    <tr>
                        <td>{{ $d->nama_produk }}</td>
                        <td>{{ $d->qty }}</td>
                        <td>{{ number_format($d->harga_satuan) }}</td>
                        <td>{{ number_format($d->subtotal) }}</td>
                    </tr>
                    @php $total += $d->subtotal; @endphp
                    @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted">
                            Belum ada produk
                        </td>
                    </tr>
                    @endforelse
                </tbody>
                <tfoot>
                    <tr class="table-dark">
                        <th colspan="3">TOTAL</th>
                        <th>{{ number_format($total) }}</th>
                    </tr>
                </tfoot>
            </table>

            {{-- PEMBAYARAN --}}
            @if($nota->status_nota === 'baru' && $total > 0)
            <hr>

            <h5>Pembayaran</h5>

            <form action="/penjualan/{{ $nota->id_nota }}/bayar" method="POST">
                @csrf
                <div class="mb-2">
                    <label>Metode Pembayaran</label>
                    <select name="metode" class="form-select" required>
                        <option value="cash">Cash</option>
                        <option value="debit">Debit</option>
                        <option value="transfer">Transfer</option>
                        <option value="qris">QRIS</option>
                    </select>
                </div>

                <div class="mb-2">
                    <label>Jumlah Bayar</label>
                    <input type="number" name="jumlah_bayar" class="form-control" required>
                </div>

                <button class="btn btn-primary w-100">
                    Bayar
                </button>
            </form>
            @endif

            <a href="/penjualan" class="btn btn-secondary mt-3">
                ⬅ Kembali ke Daftar Nota
            </a>
        </div>
    </div>
</div>


</body>
</html>
