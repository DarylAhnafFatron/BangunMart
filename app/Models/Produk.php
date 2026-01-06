<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    protected $table = 'produk';
    protected $primaryKey = 'id_produk';
    public $timestamps = false;

    protected $fillable = [
        'id_kategori','id_satuan','barcode',
        'nama_produk','harga_jual','stok',
        'stok_minimum','rak','status'
    ];
}

