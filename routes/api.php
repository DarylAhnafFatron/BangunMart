<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProdukApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
| Semua route di sini otomatis pakai prefix /api
| Contoh: http://127.0.0.1:8000/api/produk
|--------------------------------------------------------------------------
*/

// Cek API hidup (testing awal)
Route::get('/tes', function () {
    return response()->json([
        'status' => 'API BangunMart aktif',
        'timestamp' => now()
    ]);
});

// REST API PRODUK
Route::apiResource('produk', ProdukApiController::class);
