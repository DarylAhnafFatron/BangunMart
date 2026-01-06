<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SatuanController extends Controller
{
    public function index()
    {
        $data = DB::select("
            SELECT id_satuan, nama_satuan
            FROM satuan
            ORDER BY id_satuan DESC
        ");

        return view('satuan.index', compact('data'));
    }

    public function store(Request $r)
    {
        $r->validate([
            'nama_satuan' => 'required'
        ]);

        DB::insert("
            INSERT INTO satuan (nama_satuan)
            VALUES (?)
        ", [$r->nama_satuan]);

        return redirect('/satuan');
    }

    public function update(Request $r, $id)
    {
        $r->validate([
            'nama_satuan' => 'required'
        ]);

        DB::update("
            UPDATE satuan
            SET nama_satuan = ?
            WHERE id_satuan = ?
        ", [$r->nama_satuan, $id]);

        return redirect('/satuan');
    }

    public function destroy($id)
    {
        DB::delete("
            DELETE FROM satuan
            WHERE id_satuan = ?
        ", [$id]);

        return redirect('/satuan');
    }
}
