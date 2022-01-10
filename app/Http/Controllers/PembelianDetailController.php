<?php

namespace App\Http\Controllers;

use App\Models\Pembelian;
use App\Models\PembelianDetail;
use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Supplier;

class PembelianDetailController extends Controller
{
    public function index()
    {
        // panggil data pembelian dan supplier dari session yang sudah di buat
        $id_pembelian = session('id_pembelian');
        $supplier = Supplier::find(session('id_supplier'));

        // ambil data value diskon
        $diskon = Pembelian::find($id_pembelian)->diskon ?? 0;

        // panggil juga data peroduk
        $produk = Produk::orderBy('nama_produk')->get();


        // buat pengkondisian, jika tidak ada supplier mmaka kasi abort 404
        if(! $supplier) {
            abort(404);
        }

        return view('pembelian_detail.index', compact('id_pembelian', 'produk', 'supplier', 'diskon'));
    }

    public function store(Request $request)
    {
        // cek produknya berdasarkan dengan id yang di dalam form
        $produk = Produk::where('id_produk', $request->id_produk)->first();
        if(! $produk){
            return response()->json('Data gagal disimpan', 400);
        }

        $detail = new PembelianDetail();
        $detail->id_pembelian = $request->id_pembelian;
        $detail->id_produk = $produk->id_produk;
        $detail->harga_beli = $produk->harga_beli;
        $detail->jumlah = 1;
        $detail->subtotal = $produk->harga_beli;
        $detail->save();

        return response()->json('Data berhasil disimpan', 200);
    }

    // menampilkan data detail pembelian menggunakan datatable serverside
    public function data($id)
    {
        // ambil datanya dari tabel kategori
        $detail = PembelianDetail::with('produk')
            ->where('id_pembelian', $id)
            ->get();

            // data default untuk form pembelian
        $data       = array();
        $total      = 0;
        $total_item = 0;

        foreach($detail as $item) {
            $row = array();
            $row['kode_produk'] = '<center><span class="label label-success">'. $item->produk['kode_produk'] .'</span></center>';
            $row['nama_produk'] = $item->produk['nama_produk'];
            $row['harga_beli'] = 'Rp. '. format_uang($item->harga_beli);
            $row['jumlah'] = '<input type="number" class="form-control input-sm quantity" data-id="'. $item->id_pembelian_detail .'" value="'. $item->jumlah .'">';
            $row['subtotal'] = 'Rp. ' . format_uang($item->subtotal);
            $row['aksi'] = '
                            <center>
                                <div class="btn-group">
                                    <button onclick="deleteData(`'. route('pembelian_detail.destroy', $item->id_pembelian_detail) .'`)" class="btn btn-xs btn-danger btn-flat" title="hapus"><i class="fa fa-trash"></i></button>
                                </div>
                            </center>
                            ';
            $data[] = $row;

            $total += $item->harga_beli * $item->jumlah;
            $total_item += $item->jumlah;
        }

        $data[] = [
            'kode_produk'   =>'<div class="total hide">'. $total .'</div> <div class="total_item hide">'. $total_item .'</div>',
            'nama_produk'   => '',
            'harga_beli'    => '',
            'jumlah'        => '',
            'subtotal'      => '',
            'aksi'          => '',
        ];

        return datatables()
            ->of($data)
            ->addIndexColumn()
            ->rawColumns(['aksi', 'kode_produk', 'jumlah'])
            ->make(true);
            
    }

    public function update(Request $request, $id)
    {
        $detail = PembelianDetail::find($id);

        $detail->jumlah = $request->jumlah;
        $detail->subtotal = $detail->harga_beli * $request->jumlah;
        $detail->update();
    }

    public function destroy($id)
    {
        $detail = PembelianDetail::find($id);
        $detail->delete();

        return response(null, 204);
    }

    public function loadForm($diskon, $total)
    {
        $bayar = $total - ($diskon / 100 * $total);
        $data = [
            'totalrp' => format_uang($total),
            'bayar' => $bayar,
            'bayarrp' => format_uang($bayar),
            'terbilang' => ucwords(terbilang($bayar). ' Rupiah')
        ];

        return response()->json($data);
    }
}
