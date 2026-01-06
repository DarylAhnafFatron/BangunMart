<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\SatuanController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PembelianController;


/*
|--------------------------------------------------------------------------
| ROUTE UMUM
|--------------------------------------------------------------------------
*/

Route::get('/register', function () {
    return view('register');
});

Route::post('/register', function (\Illuminate\Http\Request $r) {

    DB::insert("
        INSERT INTO users (username, password, role)
        VALUES (?, ?, 'kasir')
    ", [
        $r->username,
        $r->password
    ]);

    return redirect('/login')
        ->with('success', 'Registrasi berhasil, silakan login');
});



Route::get('/', function () {
    return redirect('/login');
});

Route::get('/login', function () {
    return view('login');
});

Route::post('/login', function (Request $r) {

    $user = DB::selectOne(
        "SELECT * FROM users WHERE username = ? AND password = ?",
        [$r->username, $r->password]
    );

    if (!$user) {
        return back()->with('error', 'Login gagal');
    }

    session([
        'id_user'  => $user->id_user,
        'username' => $user->username,
        'role'     => $user->role
    ]);

    if ($user->role === 'admin') {
    return redirect('/dashboard');
}

if ($user->role === 'kasir') {
    return redirect('/dashboard');
}


    abort(403);
});

Route::get('/dashboard', function () {
    return view('dashboard');
});


Route::get('/logout', function () {
    session()->flush();
    return redirect('/login');
});

/*
|--------------------------------------------------------------------------
| ROUTE ADMIN
|--------------------------------------------------------------------------
*/

Route::middleware('admin')->group(function () {


    Route::get('/produk', [ProdukController::class, 'index']);
    Route::post('/produk/store', [ProdukController::class, 'store']);
    Route::post('/produk/update/{id}', [ProdukController::class, 'update']);
    Route::get('/produk/delete/{id}', [ProdukController::class, 'destroy']);


    Route::get('/laporan/stok', [LaporanController::class, 'stokMenipis']);


    Route::get('/laporan/terlaris', [LaporanController::class, 'terlaris']);


    Route::get('/kategori', [\App\Http\Controllers\KategoriController::class, 'index']);
    Route::post('/kategori/store', [\App\Http\Controllers\KategoriController::class, 'store']);
    Route::post('/kategori/update/{id}', [\App\Http\Controllers\KategoriController::class, 'update']);
    Route::get('/kategori/delete/{id}', [\App\Http\Controllers\KategoriController::class, 'destroy']);


    Route::get('/satuan', [\App\Http\Controllers\SatuanController::class, 'index']);
    Route::post('/satuan/store', [\App\Http\Controllers\SatuanController::class, 'store']);
    Route::post('/satuan/update/{id}', [\App\Http\Controllers\SatuanController::class, 'update']);
    Route::get('/satuan/delete/{id}', [\App\Http\Controllers\SatuanController::class, 'destroy']);


    Route::get('/supplier', [SupplierController::class, 'index']);
    Route::get('/supplier/create', [SupplierController::class, 'create']);
    Route::post('/supplier/store', [SupplierController::class, 'store']);
    Route::get('/supplier/edit/{id}', [SupplierController::class, 'edit']);
    Route::post('/supplier/update/{id}', [SupplierController::class, 'update']);
    Route::get('/supplier/delete/{id}', [SupplierController::class, 'destroy']);


    Route::get('/pelanggan', [PelangganController::class, 'index']);
    Route::get('/pelanggan/create', [PelangganController::class, 'create']);
    Route::post('/pelanggan/store', [PelangganController::class, 'store']);
    Route::get('/pelanggan/edit/{id}', [PelangganController::class, 'edit']);
    Route::post('/pelanggan/update/{id}', [PelangganController::class, 'update']);
    Route::get('/pelanggan/delete/{id}', [PelangganController::class, 'destroy']);



    Route::get('/laporan/penjualan', [LaporanController::class, 'penjualan']);


    Route::get('/activity-log', [ActivityLogController::class, 'index']);


    Route::get('/laporan/omset', [LaporanController::class, 'omset']);


    Route::get('/laporan/omset/pdf', [LaporanController::class, 'omsetPdf']);


    Route::post('/produk/restock/{id}', [ProdukController::class, 'restock']);


    Route::get('/pembelian', [PembelianController::class, 'index']);
    Route::get('/pembelian/create', [PembelianController::class, 'create']);
    Route::post('/pembelian/store', [PembelianController::class, 'store']);
    Route::get('/pembelian/delete/{id}', [PembelianController::class, 'destroy']);


    Route::get('/laporan/laba-rugi', [LaporanController::class, 'labaRugi']);
    Route::get('/laporan/laba-rugi/pdf', [LaporanController::class, 'labaRugiPdf']);
    Route::get('/laporan/laba-rugi/grafik', [LaporanController::class, 'labaRugiGrafik']);




});

/*
|--------------------------------------------------------------------------
| ROUTE KASIR 
|--------------------------------------------------------------------------
*/

Route::middleware('kasir')->group(function () {

    // daftar nota
    Route::get('/penjualan', [PenjualanController::class, 'index']);

    // form buat nota baru
    Route::get('/penjualan/create', [PenjualanController::class, 'create']);

    // simpan nota (nota kosong dulu)
    Route::post('/penjualan', [PenjualanController::class, 'store']);

    // lihat nota + detail
    Route::get('/penjualan/{id}', [PenjualanController::class, 'nota']);

    // tambah produk ke nota
    Route::post('/penjualan/{id}/add', [PenjualanController::class, 'storeDetail']);

    // pembayaran
    Route::post('/penjualan/{id}/bayar', [PenjualanController::class, 'bayar']);

});
