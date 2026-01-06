<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Laba Rugi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light p-4">

<div class="container">

    <h3 class="mb-4">📊 Laporan Laba Rugi</h3>

    {{-- FILTER --}}
    <form class="row g-2 mb-4">
        <div class="col-md-4">
            <input type="date" name="tanggal_awal" class="form-control"
                   value="{{ $tanggalAwal }}">
        </div>
        <div class="col-md-4">
            <input type="date" name="tanggal_akhir" class="form-control"
                   value="{{ $tanggalAkhir }}">
        </div>
        <div class="col-md-4">
            <button class="btn btn-primary w-100">Filter</button>
        </div>
    </form>

    {{-- CARD --}}
    <div class="row">

        <div class="col-md-4">
            <div class="card shadow text-center">
                <div class="card-body">
                    <h6 class="text-muted">Total Penjualan</h6>
                    <h4 class="text-success">
                        Rp {{ number_format($penjualan) }}
                    </h4>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow text-center">
                <div class="card-body">
                    <h6 class="text-muted">Total Pembelian</h6>
                    <h4 class="text-danger">
                        Rp {{ number_format($pembelian) }}
                    </h4>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow text-center">
                <div class="card-body">
                    <h6 class="text-muted">Laba Bersih</h6>
                    <h4 class="{{ $laba >= 0 ? 'text-primary' : 'text-danger' }}">
                        Rp {{ number_format($laba) }}
                    </h4>
                </div>
            </div>
        </div>

    </div>

    <a href="/dashboard" class="btn btn-secondary mt-4">
        ⬅ Kembali ke Dashboard
    </a>

</div>

</body>
</html>
