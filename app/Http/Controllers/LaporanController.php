<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    // LAPORAN STOK MENIPIS
    public function stokMenipis()
{
    $data = DB::select("
        SELECT 
            id_produk,
            nama_produk,
            stok
        FROM produk
        WHERE stok <= 5
        ORDER BY stok ASC
    ");

    return view('laporan.stok', compact('data'));
}

    // LAPORAN PRODUK TERLARIS
    public function terlaris()
    {
        $data = DB::select("
            SELECT 
                p.id_produk,
                p.nama_produk,
                SUM(d.qty) AS total_terjual
            FROM detail_penjualan d
            JOIN produk p ON d.id_produk = p.id_produk
            JOIN penjualan n ON d.id_nota = n.id_nota
            WHERE n.status_nota = 'dibayar'
            GROUP BY p.id_produk, p.nama_produk
            ORDER BY total_terjual DESC
        ");

        return view('laporan.terlaris', compact('data'));
    }

public function omset(Request $r)
{
    $where = "";
    $params = [];

    if ($r->dari && $r->sampai) {
        $where = "AND DATE(p.tgl_nota) BETWEEN ? AND ?";
        $params = [$r->dari, $r->sampai];
    }

    $data = DB::select("
        SELECT 
            DATE(p.tgl_nota) AS tanggal,
            SUM(d.qty * d.harga_satuan) AS total_omset
        FROM penjualan p
        JOIN detail_penjualan d ON p.id_nota = d.id_nota
        WHERE p.status_nota = 'dibayar'
        $where
        GROUP BY DATE(p.tgl_nota)
        ORDER BY tanggal ASC
    ", $params);

    return view('laporan.omset', compact('data'));
}

//penjualan
    public function penjualan(Request $r)
{
    $from = $r->from;
    $to   = $r->to;

    $where = '';
    $param = [];

    if ($from && $to) {
        $where = 'WHERE DATE(p.tgl_nota) BETWEEN ? AND ?';
        $param = [$from, $to];
    }

    $data = DB::select("
        SELECT 
            p.id_nota,
            p.tgl_nota,
            p.status_nota,
            SUM(d.qty * d.harga_satuan) AS total,
            SUM(d.qty) AS total_item
        FROM penjualan p
        LEFT JOIN detail_penjualan d ON p.id_nota = d.id_nota
        $where
        GROUP BY p.id_nota, p.tgl_nota, p.status_nota
        ORDER BY p.tgl_nota DESC
    ", $param);

    $grandTotal = 0;
    foreach ($data as $d) {
        $grandTotal += $d->total;
    }

    return view('laporan.penjualan', compact('data', 'grandTotal', 'from', 'to'));
}
//omset
public function omsetPdf()
{
    $data = DB::select("
        SELECT DATE(p.tgl_nota) AS tanggal,
               SUM(d.qty * d.harga_satuan) AS total_omset
        FROM penjualan p
        JOIN detail_penjualan d ON p.id_nota = d.id_nota
        WHERE p.status_nota = 'dibayar'
        GROUP BY DATE(p.tgl_nota)
    ");

    $pdf = Pdf::loadView('laporan.omset_pdf', compact('data'));
    return $pdf->download('laporan-omset.pdf');
}

//Laporan laba rugi

public function labaRugi(Request $r)
{
    $awal  = $r->tanggal_awal;
    $akhir = $r->tanggal_akhir;

    /*
    ==========================
    PENJUALAN PER HARI
    ==========================
    */
    $queryJual = "
        SELECT 
            DATE(p.tgl_nota) AS tanggal,
            SUM(d.qty * d.harga_satuan) AS total
        FROM penjualan p
        JOIN detail_penjualan d ON p.id_nota = d.id_nota
        WHERE p.status_nota = 'dibayar'
    ";

    $paramJual = [];

    if ($awal && $akhir) {
        $queryJual .= " AND DATE(p.tgl_nota) BETWEEN ? AND ? ";
        $paramJual[] = $awal;
        $paramJual[] = $akhir;
    }

    $queryJual .= " GROUP BY DATE(p.tgl_nota) ";

    $penjualan = DB::select($queryJual, $paramJual);

    /*
    ==========================
    PEMBELIAN PER HARI
    ==========================
    */
    $queryBeli = "
        SELECT 
            DATE(pb.tgl_pembelian) AS tanggal,
            SUM(dp.qty * dp.harga_beli) AS total
        FROM pembelian pb
        JOIN detail_pembelian dp ON pb.id_pembelian = dp.id_pembelian
    ";

    $paramBeli = [];

    if ($awal && $akhir) {
        $queryBeli .= " WHERE DATE(pb.tgl_pembelian) BETWEEN ? AND ? ";
        $paramBeli[] = $awal;
        $paramBeli[] = $akhir;
    }

    $queryBeli .= " GROUP BY DATE(pb.tgl_pembelian) ";

    $pembelian = DB::select($queryBeli, $paramBeli);

    /*
    ==========================
    GABUNG DATA
    ==========================
    */
    $data = [];

    foreach ($penjualan as $j) {
        $data[$j->tanggal] = [
            'tanggal'   => $j->tanggal,
            'penjualan' => $j->total,
            'pembelian' => 0
        ];
    }

    foreach ($pembelian as $b) {
        if (!isset($data[$b->tanggal])) {
            $data[$b->tanggal] = [
                'tanggal'   => $b->tanggal,
                'penjualan' => 0,
                'pembelian' => $b->total
            ];
        } else {
            $data[$b->tanggal]['pembelian'] = $b->total;
        }
    }

    ksort($data);
    $data = array_values($data);

    /*
    ==========================
    TOTAL
    ==========================
    */
    $totalPenjualan = 0;
    $totalPembelian = 0;

    foreach ($data as $d) {
        $totalPenjualan += $d['penjualan'];
        $totalPembelian += $d['pembelian'];
    }

    $labaBersih = $totalPenjualan - $totalPembelian;

    return view('laporan.laba_rugi_grafik', compact(
        'data',
        'totalPenjualan',
        'totalPembelian',
        'labaBersih',
        'awal',
        'akhir'
    ));
}






public function labaRugiPdf()
{
    $jual = DB::selectOne("
        SELECT SUM(d.qty * d.harga_satuan) AS total
        FROM penjualan p
        JOIN detail_penjualan d ON p.id_nota = d.id_nota
        WHERE p.status_nota = 'dibayar'
    ");

    $beli = DB::selectOne("
        SELECT SUM(subtotal) AS total
        FROM detail_pembelian
    ");

    $pdf = Pdf::loadView('laporan.laba_rugi_pdf', [
        'jual' => $jual->total ?? 0,
        'beli' => $beli->total ?? 0,
        'laba' => ($jual->total ?? 0) - ($beli->total ?? 0)
    ]);

    return $pdf->download('laporan-laba-rugi.pdf');
}

}
