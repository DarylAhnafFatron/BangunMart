<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProdukController extends Controller
{
    // =========================
    // TAMPILKAN DATA PRODUK
    // =========================
    public function index()
    {
        $produk = DB::select("
            SELECT 
                p.id_produk,
                p.nama_produk,
                k.nama_kategori,
                s.nama_satuan,
                p.harga_jual,
                p.stok,
                p.stok_minimum
            FROM produk p
            JOIN satuan s ON p.id_satuan = s.id_satuan
            JOIN kategori k ON p.id_kategori = k.id_kategori
            ORDER BY p.id_produk DESC
        ");

        $satuan = DB::select("SELECT id_satuan, nama_satuan FROM satuan");
        $kategori = DB::select("SELECT id_kategori, nama_kategori FROM kategori");

        return view('produk.index', compact('produk', 'satuan', 'kategori'));
    }

    // =========================
    // SIMPAN PRODUK BARU
    // =========================
    public function store(Request $r)
    {
        DB::insert("
            INSERT INTO produk 
            (nama_produk, id_kategori, id_satuan, harga_jual, stok, stok_minimum)
            VALUES (?, ?, ?, ?, 0, ?)
        ", [
            $r->nama_produk,
            $r->id_kategori,
            $r->id_satuan,
            $r->harga_jual,
            $r->stok_minimum
        ]);

        logActivity(
            'CREATE',
            'Menambahkan produk: ' . $r->nama_produk
        );

        return redirect('/produk');
    }

    // =========================
    // UPDATE PRODUK (TANPA STOK)
    // =========================
    public function update(Request $r, $id)
    {
        DB::update("
            UPDATE produk SET
                nama_produk = ?,
                id_kategori = ?,
                id_satuan = ?,
                harga_jual = ?,
                stok_minimum = ?
            WHERE id_produk = ?
        ", [
            $r->nama_produk,
            $r->id_kategori,
            $r->id_satuan,
            $r->harga_jual,
            $r->stok_minimum,
            $id
        ]);

        logActivity(
            'UPDATE',
            'Mengubah produk ID ' . $id
        );

        return redirect('/produk');
    }

    // =========================
    // HAPUS PRODUK
    // =========================
    public function destroy($id)
    {
        DB::delete("
            DELETE FROM produk WHERE id_produk = ?
        ", [$id]);

        logActivity(
            'DELETE',
            'Menghapus produk ID ' . $id
        );

        return redirect('/produk');
    }

    // =========================
    // RESTOCK PRODUK
    // =========================
    public function restock(Request $r, $id)
    {
        $r->validate([
            'jumlah' => 'required|numeric|min:1'
        ]);

        DB::update("
            UPDATE produk
            SET stok = stok + ?
            WHERE id_produk = ?
        ", [$r->jumlah, $id]);

        logActivity(
            'RESTOCK',
            'Menambah stok produk ID ' . $id . ' sebanyak ' . $r->jumlah
        );

        return back()->with('success', 'Stok berhasil ditambahkan');
    }

//Laba Rugi Grafik
public function labaRugiGrafik()
{
    $data = DB::select("
        SELECT DATE_FORMAT(p.tgl_nota,'%Y-%m') AS bulan,
               SUM(d.qty * d.harga_satuan) AS penjualan
        FROM penjualan p
        JOIN detail_penjualan d ON p.id_nota = d.id_nota
        WHERE p.status_nota = 'dibayar'
        GROUP BY bulan
        ORDER BY bulan
    ");

    return view('laporan.laba_rugi_grafik', compact('data'));
}


}
