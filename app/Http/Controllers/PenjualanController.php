<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PenjualanController extends Controller
{
    // =====================
    // LIST NOTA
    // =====================
    public function index()
    {
        $data = DB::select("
            SELECT id_nota, tgl_nota, status_nota
            FROM penjualan
            ORDER BY id_nota DESC
        ");

        return view('penjualan.index', compact('data'));
    }

    // =====================
    // FORM BUAT NOTA BARU
    // =====================
    public function create()
{
    $produk = DB::select("
        SELECT id_produk, nama_produk, stok
        FROM produk
        WHERE stok > 0
    ");

    return view('penjualan.create', compact('produk'));
}


    // =====================
    // SIMPAN NOTA (TANPA DETAIL)
    // =====================
    public function store(Request $r)
{
    DB::beginTransaction();

    try {
        // 1. buat nota
        DB::insert("
            INSERT INTO penjualan (tgl_nota, id_pegawai, status_nota)
            VALUES (NOW(), ?, 'baru')
        ", [ session('id_user') ]);

        $idNota = DB::getPdo()->lastInsertId();

        // 2. ambil data produk
        $produk = DB::selectOne("
            SELECT stok, harga_jual
            FROM produk
            WHERE id_produk = ?
        ", [ $r->id_produk ]);

        if (!$produk || $produk->stok < $r->qty) {
            DB::rollBack();
            return back()->with('error', 'Stok tidak cukup');
        }

        // 3. simpan detail penjualan
        DB::insert("
            INSERT INTO detail_penjualan
            (id_nota, id_produk, qty, harga_satuan)
            VALUES (?, ?, ?, ?)
        ", [
            $idNota,
            $r->id_produk,
            $r->qty,
            $produk->harga_jual
        ]);

        // 4. kurangi stok
        DB::update("
            UPDATE produk
            SET stok = stok - ?
            WHERE id_produk = ?
        ", [
            $r->qty,
            $r->id_produk
        ]);

        DB::commit();

        // 5. masuk ke nota
        return redirect("/penjualan/$idNota");

    } catch (\Exception $e) {
        DB::rollBack();
        return back()->with('error', $e->getMessage());
    }
}


    // =====================
    // TAMBAH BARANG KE NOTA
    // =====================
    public function storeDetail(Request $r, $id)
    {
        $produk = DB::selectOne("
            SELECT stok, harga_jual
            FROM produk
            WHERE id_produk = ?
        ", [$r->id_produk]);

        if (!$produk || $produk->stok < $r->qty) {
            return back()->with('error', 'Stok tidak cukup');
        }

        // cek apakah produk sudah ada di nota
        $detail = DB::selectOne("
            SELECT qty
            FROM detail_penjualan
            WHERE id_nota = ? AND id_produk = ?
        ", [$id, $r->id_produk]);

        if ($detail) {
            // UPDATE qty
            DB::update("
                UPDATE detail_penjualan
                SET qty = qty + ?
                WHERE id_nota = ? AND id_produk = ?
            ", [
                $r->qty,
                $id,
                $r->id_produk
            ]);
        } else {
            // INSERT baru
            DB::insert("
                INSERT INTO detail_penjualan
                (id_nota, id_produk, qty, harga_satuan)
                VALUES (?, ?, ?, ?)
            ", [
                $id,
                $r->id_produk,
                $r->qty,
                $produk->harga_jual
            ]);
        }

        // kurangi stok
        DB::update("
            UPDATE produk
            SET stok = stok - ?
            WHERE id_produk = ?
        ", [
            $r->qty,
            $r->id_produk
        ]);

        return redirect("/penjualan/$id");
    }

    // =====================
    // TAMPILKAN NOTA
    // =====================
    public function nota($id)
{
    $nota = DB::selectOne("
        SELECT id_nota, tgl_nota, status_nota, diskon_nota
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

    // ⬇️ INI KUNCI UTAMANYA
    $produk = [];

    if ($nota->status_nota === 'baru') {
        $produk = DB::select("
            SELECT id_produk, nama_produk, stok
            FROM produk
            WHERE stok > 0
        ");
    }

    return view('penjualan.nota', compact('nota', 'detail', 'produk'));
}


    // =====================
    // PEMBAYARAN
    // =====================
    public function bayar(Request $r, $id)
    {
        $total = DB::selectOne("
            SELECT SUM(qty * harga_satuan) AS total
            FROM detail_penjualan
            WHERE id_nota = ?
        ", [$id])->total ?? 0;

        if ($total <= 0) {
            return back()->with('error', 'Nota masih kosong');
        }

        if ($r->jumlah_bayar < $total) {
            return back()->with('error', 'Uang bayar kurang');
        }

        DB::beginTransaction();

        try {
            DB::insert("
                INSERT INTO pembayaran
                (id_nota, metode, jumlah_tagihan, jumlah_bayar, kembalian, status_bayar)
                VALUES (?, ?, ?, ?, ?, 'berhasil')
            ", [
                $id,
                $r->metode,
                $total,
                $r->jumlah_bayar,
                $r->jumlah_bayar - $total
            ]);

            DB::update("
                UPDATE penjualan
                SET status_nota = 'dibayar'
                WHERE id_nota = ?
            ", [$id]);

            DB::commit();

            return redirect("/penjualan/$id")
                ->with('success', 'Pembayaran berhasil');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', $e->getMessage());
        }

    // =====================
    // TERLARIS
    // =====================

    }
    public function terlaris()
{
    $data = DB::select("
        SELECT 
            p.nama_produk,
            SUM(d.qty) AS total_terjual
        FROM detail_penjualan d
        JOIN produk p ON d.id_produk = p.id_produk
        GROUP BY p.id_produk, p.nama_produk
        ORDER BY total_terjual DESC
        LIMIT 10
    ");

    return view('penjualan.terlaris', compact('data'));
}

}
