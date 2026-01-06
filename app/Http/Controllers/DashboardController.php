<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // =====================
        // PRODUK TERLARIS
        // =====================
        $produkTerlaris = DB::select("
            SELECT p.nama_produk, SUM(d.qty) AS total_jual
            FROM detail_penjualan d
            JOIN produk p ON d.id_produk = p.id_produk
            GROUP BY p.nama_produk
            ORDER BY total_jual DESC
            LIMIT 5
        ");

        // =====================
        // OMZET PENJUALAN
        // =====================
        $omzet = DB::select("
            SELECT DATE(tgl_nota) AS tanggal,
                   SUM(d.qty * d.harga_satuan) AS total
            FROM penjualan pj
            JOIN detail_penjualan d ON pj.id_nota = d.id_nota
            GROUP BY DATE(tgl_nota)
            ORDER BY tanggal ASC
        ");

        return view('dashboard', compact('produkTerlaris', 'omzet'));
    }
}
