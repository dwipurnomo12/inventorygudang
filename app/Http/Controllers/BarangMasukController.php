<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Satuan;
use App\Models\Supplier;
use App\Models\BarangMasuk;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Validated;
use Illuminate\Support\Facades\Validator;

class BarangMasukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('barang-masuk.index', [
            'barangs'      => Barang::all(),
            'barangsMasuk' => BarangMasuk::all(),
            'suppliers'    => Supplier::all()
        ]);
    }

    public function getDataBarangMasuk()
    {
        return response()->json([
            'success'   => true,
            'data'      => BarangMasuk::all(),
            'supplier'  => Supplier::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('barang-masuk.create', [
            'barangs'   => Barang::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tanggal_masuk'     => 'required',
            'nama_barang'       => 'required',
            'jumlah_masuk'      => 'required',
            'supplier_id'       => 'required'
        ],[
            'tanggal_masuk.required'    => 'Pilih Barang Terlebih Dahulu !',
            'nama_barang.required'      => 'Form Nama Barang Wajib Di Isi !',
            'jumlah_masuk.required'     => 'Form Jumlah Stok Masuk Wajib Di Isi !',
            'supplier_id.required'      => 'Pilih Supplier !'
        ]);


        if($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $barangMasuk = BarangMasuk::create([
            'tanggal_masuk'     => $request->tanggal_masuk,
            'nama_barang'       => $request->nama_barang,
            'jumlah_masuk'      => $request->jumlah_masuk,
            'supplier_id'       => $request->supplier_id,
            'kode_transaksi'    => $request->kode_transaksi,
            'user_id'           => auth()->user()->id
        ]); 

        if ($barangMasuk) {
            $barang = Barang::where('nama_barang', $request->nama_barang)->first();
            if ($barang) {
                $barang->stok += $request->jumlah_masuk;
                $barang->save();
            }
        }

        return response()->json([
            'success'   => true,
            'message'   => 'Data Berhasil Disimpan !',
            'data'      => $barangMasuk
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(BarangMasuk $barangMasuk)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BarangMasuk $barangMasuk)
    {
        return response()->json([
            'success' => true,
            'message' => 'Edit Data Barang',
            'data'    => $barangMasuk
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BarangMasuk $barangMasuk)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BarangMasuk $barangMasuk)
    {
        $jumlahMasuk = $barangMasuk->jumlah_masuk;
        $barangMasuk->delete();

        $barang = Barang::where('nama_barang', $barangMasuk->nama_barang)->first();
        if ($barang) {
            $barang->stok -= $jumlahMasuk;
            $barang->save();
        }
        
        return response()->json([
            'success' => true,
            'message' => 'Data Barang Berhasil Dihapus!'
        ]);
    }


    /**
     * Create Autocomplete Data
     */
    public function getAutoCompleteData(Request $request)
    {
        $barang = Barang::where('nama_barang', $request->nama_barang)->first();;
        if($barang){
            return response()->json([
                'nama_barang'   => $barang->nama_barang,
                'stok'          => $barang->stok,
                'satuan_id'     => $barang->satuan_id,
            ]);
        }
    }

    /**
     * Get Satuan
     */
    public function getSatuan()
    {
       $satuans = Satuan::all();
       
       return response()->json($satuans);
    }

}
