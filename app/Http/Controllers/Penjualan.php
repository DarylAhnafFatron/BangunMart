<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class PenjualanController extends Controller
{
    // DAFTAR PENJUALAN
    public function index()
    {
        $data = DB::select("
            SELECT 
                pj.id_nota,
                pj.tgl_nota,
                pg.nama_pegawai,
                pl.nama_pelanggan
            FROM penjualan pj
            JOIN pegawai pg ON pj.id_pegawai = pg.id_pegawai
            JOIN pelanggan pl ON pj.id_pelanggan = pl.id_pelanggan
            ORDER BY pj.tgl_nota DESC
        ");

        return view('penjualan.index', compact('data'));
    }

    // DETAIL NOTA
    public function nota($id)
{
    $nota = DB::selectOne("
        SELECT *
        FROM penjualan
        WHERE id_nota = ?
    ", [$id]);

    if (!$nota) {
        abort(404);
    }

    $detail = DB::select("
        SELECT p.nama_produk, d.qty, d.harga_satuan,
               (d.qty * d.harga_satuan) AS subtotal
        FROM detail_penjualan d
        JOIN produk p ON d.id_produk = p.id_produk
        WHERE d.id_nota = ?
    ", [$id]);

    // 🔥 INI WAJIB ADA
    $produk = DB::select("
        SELECT id_produk, nama_produk, stok
        FROM produk
        WHERE stok > 0
    ");

    return view('penjualan.nota', compact('nota', 'detail', 'produk'));
}
}