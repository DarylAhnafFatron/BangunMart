<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background: #f4f6f9;
        }
        .card-menu {
            border: none;
            border-radius: 15px;
            transition: all 0.3s ease;
            cursor: pointer;
        }
        .card-menu:hover {
            transform: translateY(-6px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }
        .icon-box {
            font-size: 2.5rem;
            margin-bottom: 10px;
        }
        a {
            text-decoration: none;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-dark bg-dark px-4">
    <span class="navbar-brand mb-0 h5">
        💻 Sistem Kasir UMKM
    </span>
    <div class="text-white">
        {{ session('username') }} ({{ session('role') }})
        <a href="/logout" class="btn btn-sm btn-outline-light ms-3">Logout</a>
    </div>
</nav>

<div class="container my-5">

    <h4 class="mb-4">Dashboard</h4>

    <div class="row g-4">

        {{-- ================= ADMIN MENU ================= --}}
        @if(session('role') === 'admin')

        <div class="col-md-3">
            <a href="/kategori">
                <div class="card card-menu text-center p-4">
                    <div class="icon-box text-primary">
                        <i class="bi bi-tags"></i>
                    </div>
                    <h6>Kategori</h6>
                    <small class="text-muted">Kelola kategori produk</small>
                </div>
            </a>
        </div>

        <div class="col-md-3">
            <a href="/satuan">
                <div class="card card-menu text-center p-4">
                    <div class="icon-box text-success">
                        <i class="bi bi-box"></i>
                    </div>
                    <h6>Satuan</h6>
                    <small class="text-muted">Kelola satuan barang</small>
                </div>
            </a>
        </div>

        <div class="col-md-3">
            <a href="/produk">
                <div class="card card-menu text-center p-4">
                    <div class="icon-box text-warning">
                        <i class="bi bi-bag-check"></i>
                    </div>
                    <h6>Produk</h6>
                    <small class="text-muted">CRUD & stok produk</small>
                </div>
            </a>
        </div>

        <div class="col-md-3">
            <a href="/supplier">
                <div class="card card-menu text-center p-4">
                    <div class="icon-box text-info">
                        <i class="bi bi-truck"></i>
                    </div>
                    <h6>Supplier</h6>
                    <small class="text-muted">Data pemasok</small>
                </div>
            </a>
        </div>

        <div class="col-md-3">
            <a href="/pelanggan">
                <div class="card card-menu text-center p-4">
                    <div class="icon-box text-secondary">
                        <i class="bi bi-people"></i>
                    </div>
                    <h6>Pelanggan</h6>
                    <small class="text-muted">Data pelanggan</small>
                </div>
            </a>
        </div>

        <div class="col-md-3">
            <a href="/laporan/penjualan">
                <div class="card card-menu text-center p-4">
                    <div class="icon-box text-danger">
                        <i class="bi bi-clipboard-data"></i>
                    </div>
                    <h6>Laporan Penjualan</h6>
                    <small class="text-muted">Rekap transaksi</small>
                </div>
            </a>
        </div>

        <div class="col-md-3">
            <a href="/laporan/terlaris">
                <div class="card card-menu text-center p-4">
                    <div class="icon-box text-dark">
                        <i class="bi bi-graph-up"></i>
                    </div>
                    <h6>Produk Terlaris</h6>
                    <small class="text-muted">Statistik penjualan</small>
                </div>
            </a>
        </div>

        <div class="col-md-3">
            <a href="/laporan/stok">
                <div class="card card-menu text-center p-4">
                    <div class="icon-box text-warning">
                        <i class="bi bi-exclamation-triangle"></i>
                    </div>
                    <h6>Stok Menipis</h6>
                    <small class="text-muted">Monitoring stok</small>
                </div>
            </a>
        </div>

<div class="col-md-3">
    <a href="/activity-log">
        <div class="card card-menu text-center p-4">
            <div class="icon-box text-dark">
                <i class="bi bi-journal-text"></i>
            </div>
            <h6>Activity Log</h6>
            <small class="text-muted">Riwayat aktivitas sistem</small>
        </div>
    </a>
</div>

<div class="col-md-3">
    <a href="/laporan/omset">
        <div class="card card-menu text-center p-4">
            <div class="icon-box text-primary">
                <i class="bi bi-cash-stack"></i>
            </div>
            <h6>Omset Penjualan</h6>
            <small class="text-muted">Rekap pendapatan</small>
        </div>
    </a>
</div>

<div class="col-md-3">
    <a href="/laporan/laba-rugi">
        <div class="card card-menu text-center p-4">
            <div class="icon-box text-success">
                <i class="bi bi-cash-stack"></i>
            </div>
            <h6>Laba Rugi</h6>
            <small class="text-muted">Analisis keuntungan</small>
        </div>
    </a>
</div>
<div class="col-md-3">
    <a href="/pembelian" class="text-decoration-none">
        <div class="card card-menu text-center p-4 shadow-sm h-100">
            <div class="icon-box text-success mb-2" style="font-size: 40px;">
                <i class="bi bi-truck"></i>
            </div>
            <h6 class="fw-bold">Pembelian</h6>
            <small class="text-muted">
                Barang masuk dari supplier
            </small>
        </div>
    </a>
</div>


        @endif

        {{-- ================= KASIR MENU ================= --}}
        @if(session('role') === 'kasir')

        <div class="col-md-4">
            <a href="/penjualan/create">
                <div class="card card-menu text-center p-4">
                    <div class="icon-box text-success">
                        <i class="bi bi-cart-plus"></i>
                    </div>
                    <h6>Transaksi Baru</h6>
                    <small class="text-muted">Buat nota penjualan</small>
                </div>
            </a>
        </div>

        <div class="col-md-4">
            <a href="/penjualan">
                <div class="card card-menu text-center p-4">
                    <div class="icon-box text-primary">
                        <i class="bi bi-receipt"></i>
                    </div>
                    <h6>Daftar Nota</h6>
                    <small class="text-muted">Riwayat transaksi</small>
                </div>
            </a>
        </div>
@endif

    </div>
</div>

</body>
</html>
