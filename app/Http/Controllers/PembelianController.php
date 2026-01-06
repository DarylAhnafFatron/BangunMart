<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PembelianController extends Controller
{
    public function index()
{
    $data = DB::select("
        SELECT 
            p.id_pembelian,
            p.tgl_pembelian,
            s.nama_supplier,
            p.total_beli
        FROM pembelian p
        JOIN supplier s ON p.id_supplier = s.id_supplier
        ORDER BY p.id_pembelian DESC
    ");

    return view('pembelian.index', compact('data'));
}



   public function store(Request $r)
{
    DB::beginTransaction();

    try {
        // 1. buat header pembelian
        DB::insert("
            INSERT INTO pembelian (id_supplier, tgl_pembelian, total_beli)
            VALUES (?, NOW(), 0)
        ", [$r->id_supplier]);

        $idPembelian = DB::getPdo()->lastInsertId();
        $total = 0;

        // 2. detail pembelian
        foreach ($r->produk as $i => $idProduk) {

            $qty   = $r->qty[$i];
            $harga = $r->harga_beli[$i];
            $sub   = $qty * $harga;

            DB::insert("
                INSERT INTO detail_pembelian
                (id_pembelian, id_produk, qty, harga_beli, subtotal)
                VALUES (?, ?, ?, ?, ?)
            ", [$idPembelian, $idProduk, $qty, $harga, $sub]);

            // 3. stok naik
            DB::update("
                UPDATE produk
                SET stok = stok + ?
                WHERE id_produk = ?
            ", [$qty, $idProduk]);

            $total += $sub;
        }

        // 4. update total pembelian
        DB::update("
            UPDATE pembelian
            SET total_beli = ?
            WHERE id_pembelian = ?
        ", [$total, $idPembelian]);

        logActivity('PEMBELIAN', 'Pembelian ID ' . $idPembelian);

        DB::commit();
        return redirect('/pembelian')->with('success', 'Pembelian berhasil');

    } catch (\Exception $e) {
        DB::rollback();
        return back()->with('error', $e->getMessage());
    }
}

    public function create()
{
    $supplier = DB::select("SELECT * FROM supplier");

    $produk = DB::select("
        SELECT p.id_produk, p.nama_produk, s.nama_satuan
        FROM produk p
        JOIN satuan s ON p.id_satuan = s.id_satuan
        ORDER BY p.nama_produk
    ");

    return view('pembelian.create', compact('supplier', 'produk'));
}

    public function destroy($id)
{
    DB::beginTransaction();

    try {
        // ambil detail pembelian
        $detail = DB::select("
            SELECT id_produk, qty
            FROM detail_pembelian
            WHERE id_pembelian = ?
        ", [$id]);

        // kembalikan stok
        foreach ($detail as $d) {
            DB::update("
                UPDATE produk
                SET stok = stok - ?
                WHERE id_produk = ?
            ", [$d->qty, $d->id_produk]);
        }

        // hapus detail
        DB::delete("
            DELETE FROM detail_pembelian
            WHERE id_pembelian = ?
        ", [$id]);

        // hapus pembelian
        DB::delete("
            DELETE FROM pembelian
            WHERE id_pembelian = ?
        ", [$id]);

        logActivity(
            'DELETE PEMBELIAN',
            'Menghapus pembelian ID ' . $id
        );

        DB::commit();
        return back()->with('success', 'Pembelian berhasil dihapus & stok dikembalikan');

    } catch (\Exception $e) {
        DB::rollback();
        return back()->with('error', $e->getMessage());
    }
}

}
