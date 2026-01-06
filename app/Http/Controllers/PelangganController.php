<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PelangganController extends Controller
{
    public function index()
    {
        $data = DB::select("
            SELECT *
            FROM pelanggan
            ORDER BY id_pelanggan DESC
        ");

        return view('pelanggan.index', compact('data'));
    }

    public function create()
    {
        return view('pelanggan.create');
    }

    public function store(Request $r)
{
    DB::insert("
        INSERT INTO pelanggan
        (nama_pelanggan, no_hp, tipe, kota, tgl_daftar)
        VALUES (?, ?, ?, ?, ?)
    ", [
        $r->nama_pelanggan,
        $r->no_hp,
        $r->tipe,
        $r->kota,
        date('Y-m-d H:i:s')
    ]);

    return redirect('/pelanggan')->with('success', 'Pelanggan berhasil ditambahkan');
}


    public function edit($id)
    {
        $pelanggan = DB::selectOne("
            SELECT *
            FROM pelanggan
            WHERE id_pelanggan = ?
        ", [$id]);

        if (!$pelanggan) abort(404);

        return view('pelanggan.edit', compact('pelanggan'));
    }

    public function update(Request $r, $id)
    {
        DB::update("
            UPDATE pelanggan
            SET nama_pelanggan = ?, no_hp = ?, tipe = ?, kota = ?
            WHERE id_pelanggan = ?
        ", [
            $r->nama_pelanggan,
            $r->no_hp,
            $r->tipe,
            $r->kota,
            $id
        ]);

        return redirect('/pelanggan')->with('success', 'Pelanggan berhasil diupdate');
    }

    public function destroy($id)
    {
        DB::delete("DELETE FROM pelanggan WHERE id_pelanggan = ?", [$id]);
        return redirect('/pelanggan')->with('success', 'Pelanggan berhasil dihapus');
    }
}
