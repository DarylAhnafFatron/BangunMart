<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use Illuminate\Http\Request;

class ProdukApiController extends Controller
{
    public function index()
    {
        return response()->json(Produk::all());
    }

    public function store(Request $request)
{
    $validated = $request->validate([
        'id_kategori'   => 'required|integer',
        'id_satuan'     => 'required|integer',
        'nama_produk'   => 'required|string',
        'harga_jual'    => 'required|numeric',
        'stok'          => 'required|integer',
        'stok_minimum'  => 'required|integer',
        'status'        => 'required|string'
    ]);

    $produk = Produk::create($validated);

    return response()->json([
        'message' => 'Produk berhasil ditambahkan',
        'data' => $produk
    ], 201);
}


    public function show($id)
    {
        return response()->json(Produk::findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $produk = Produk::findOrFail($id);

        $validated = $request->validate([
    'id_kategori'   => 'required|integer',
    'id_satuan'     => 'required|integer',
    'nama_produk'   => 'required|string',
    'harga_jual'    => 'required|numeric',
    'stok'          => 'required|integer',
    'stok_minimum'  => 'required|integer',
    'status'        => 'required|string'
]);


        $produk->update($validated);

        return response()->json([
            'message' => 'Produk berhasil diupdate',
            'data'    => $produk
        ]);
    }

    public function destroy($id)
    {
        Produk::destroy($id);

        return response()->json([
            'message' => 'Produk berhasil dihapus'
        ]);
    }
}
