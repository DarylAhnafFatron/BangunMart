<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KategoriController extends Controller
{
    public function index()
    {
        $data = DB::select("
            SELECT id_kategori, nama_kategori
            FROM kategori
            ORDER BY id_kategori DESC
        ");

        return view('kategori.index', compact('data'));
    }

    public function store(Request $r)
    {
        $r->validate([
            'nama_kategori' => 'required'
        ]);

        DB::insert("
            INSERT INTO kategori (nama_kategori)
            VALUES (?)
        ", [$r->nama_kategori]);

        return redirect('/kategori');
    }

    public function update(Request $r, $id)
    {
        $r->validate([
            'nama_kategori' => 'required'
        ]);

        DB::update("
            UPDATE kategori
            SET nama_kategori = ?
            WHERE id_kategori = ?
        ", [$r->nama_kategori, $id]);

        return redirect('/kategori');
    }

    public function destroy($id)
    {
        DB::delete("
            DELETE FROM kategori
            WHERE id_kategori = ?
        ", [$id]);

        return redirect('/kategori');
    }
}
