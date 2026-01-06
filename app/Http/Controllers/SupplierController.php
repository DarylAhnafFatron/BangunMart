<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SupplierController extends Controller
{
    // =====================
    // LIST SUPPLIER
    // =====================
    public function index()
    {
        $data = DB::select("SELECT * FROM supplier ORDER BY id_supplier DESC");
        return view('supplier.index', compact('data'));
    }

    // =====================
    // FORM TAMBAH
    // =====================
    public function create()
    {
        return view('supplier.create');
    }

    // =====================
    // SIMPAN
    // =====================
    public function store(Request $r)
    {
        $r->validate([
            'nama_supplier' => 'required',
            'no_hp'         => 'required',
            'kota'          => 'required'
        ]);

        DB::insert("
            INSERT INTO supplier (nama_supplier, no_hp, kota)
            VALUES (?, ?, ?)
        ", [
            $r->nama_supplier,
            $r->no_hp,
            $r->kota
        ]);

        return redirect('/supplier')->with('success', 'Supplier berhasil ditambahkan');
    }

    // =====================
    // FORM EDIT
    // =====================
    public function edit($id)
    {
        $supplier = DB::selectOne("
            SELECT * FROM supplier WHERE id_supplier = ?
        ", [$id]);

        if (!$supplier) {
            abort(404);
        }

        return view('supplier.edit', compact('supplier'));
    }

    // =====================
    // UPDATE
    // =====================
    public function update(Request $r, $id)
    {
        DB::update("
            UPDATE supplier
            SET nama_supplier = ?, no_hp = ?, kota = ?
            WHERE id_supplier = ?
        ", [
            $r->nama_supplier,
            $r->no_hp,
            $r->kota,
            $id
        ]);

        return redirect('/supplier')->with('success', 'Supplier berhasil diupdate');
    }

    // =====================
    // DELETE
    // =====================
    public function destroy($id)
    {
        DB::delete("
            DELETE FROM supplier WHERE id_supplier = ?
        ", [$id]);

        return redirect('/supplier')->with('success', 'Supplier berhasil dihapus');
    }
}
