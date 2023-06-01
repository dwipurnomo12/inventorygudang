<?php

namespace App\Http\Controllers;

use App\Models\Jenis;
use App\Models\Barang;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Satuan;
use Illuminate\Contracts\Cache\Store;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;



class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('barang.index', [
            'barangs'         => Barang::all(),
            'jenis_barangs'   => Jenis::all(),
            'satuans'         => Satuan::all()
        ]);
    }

    public function getDataBarang()
    {
        $barangs = Barang::all();
        
        return response()->json([
            'success'   => true,
            'data'      => $barangs
        ]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('barang.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_barang'   => 'required',
            'deskripsi'     => 'required',
            'gambar'        => 'required|mimes:jpeg,png,jpg',
            'stok_minimum'  => 'required|numeric',
            'jenis_id'      => 'required',
            'satuan_id'     => 'required'
        ], [
            'nama_barang.required'  => 'Form Nama Barang Wajib Di Isi !',
            'deskripsi.required'    => 'Form Deskripsi Wajib Di Isi !',
            'gambar.required'       => 'Tambahkan Gambar !',
            'gambar.mimes'          => 'Gunakan Gambar Yang Memiliki Format jpeg, png, jpg !',
            'stok_minimum.required' => 'Form Stok Minimum Wajib Di Isi !',
            'stok_minimum.numeric'  => 'Gunakan Angka Untuk Mengisi Form Ini !',
            'jenis_id.required'     => 'Pilih Jenis Barang !',
            'satuan_id.required'    => 'Pilih Jenis Barang !'
        ]);

        if ($request->hasFile('gambar')) 
        {
            $path       = 'gambar-barang/';
            $file       = $request->file('gambar');
            $fileName   = $file->getClientOriginalName();
            $gambar     = $file->storeAs($path, $fileName, 'public');
        } else{
            $gambar = null;
        }
          
        $kode_barang = 'BRG-' . str_pad(rand(1, 99999), 5, '0', STR_PAD_LEFT);
        $request->merge([
            'kode_barang'   => $kode_barang,
            'gambar'        => $gambar,
            'user_id'       => auth()->user()->id,
        ]);

        if($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $barang = Barang::create([
            'nama_barang' => $request->nama_barang,
            'deskripsi'   => $request->deskripsi,
            'user_id'     => $request->user_id,
            'kode_barang' => $request->kode_barang,
            'gambar'      => $path . $fileName,
            'stok_minimum'=> $request->stok_minimum,
            'jenis_id'    => $request->jenis_id,
            'satuan_id'   => $request->satuan_id
        ]);

        return response()->json([
            'success'   => true,
            'message'   => 'Data Berhasil Disimpan !',
            'data'      => $barang
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Barang $barang)
    {
        return response()->json([
            'success' => true,
            'message' => 'Detail Data Barang',
            'data'    => $barang
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Barang $barang)
    {
        return response()->json([
            'success' => true,
            'message' => 'Edit Data Barang',
            'data'    => $barang
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Barang $barang)
    {
        $validator = Validator::make($request->all(), [
            'nama_barang'   => 'required',
            'deskripsi'     => 'required',
            'gambar'        => 'nullable|mimes:jpeg,png,jpg',
            'stok_minimum'  => 'required|numeric',
            'jenis_id'      => 'required',
            'satuan_id'      => 'required'
        ], [
            'nama_barang.required'  => 'Form Nama Barang Wajib Di Isi !',
            'deskripsi.required'    => 'Form Deskripsi Wajib Di Isi !',
            'gambar.mimes'          => 'Gunakan Gambar Yang Memiliki Format jpeg, png, jpg !',
            'stok_minimum.required' => 'Form Stok Minimum Wajib Di Isi !',
            'stok_minimum.numeric'  => 'Gunakan Angka Untuk Mengisi Form Ini !',
            'jenis_id.required'     => 'Pilih Jenis Barang !',
            'satuan_id.required'    => 'Pilih Satuan Barang !'
        ]);
    
        // cek apakah gambar diubah atau tidak
        if($request->hasFile('gambar')){
            // hapus gambar lama
            if($barang->gambar) {
                unlink('.'.Storage::url($barang->gambar));
            }
            $path       = 'gambar-barang/';
            $file       = $request->file('gambar');
            $fileName   = $file->getClientOriginalName();
            $gambar     = $file->storeAs($path, $fileName, 'public');
            $path      .= $fileName; 
        } else {
            // jika tidak ada file gambar, gunakan gambar lama
            $validator = Validator::make($request->all(), [
                'nama_barang'   => 'required',
                'deskripsi'     => 'required',
                'stok_minimum'  => 'required|numeric',
                'jenis_id'      => 'required',
                'satuan_id'      => 'required'
            ], [
                'nama_barang.required'  => 'Form Nama Barang Wajib Di Isi !',
                'deskripsi.required'    => 'Form Deskripsi Wajib Di Isi !',
                'stok_minimum.required' => 'Form Stok Minimum Wajib Di Isi !',
                'stok_minimum.numeric'  => 'Gunakan Angka Untuk Mengisi Form Ini !',
                'jenis_id.required'     => 'Pilih Jenis Barang !',
                'satuan_id.required'    => 'Pilih Satuan Barang !'
            ]);

            $path = $barang->gambar;
        } 
        
        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }
    
        $barang->update([
            'nama_barang'   => $request->nama_barang,
            'stok_minimum'  => $request->stok_minimum, 
            'deskripsi'     => $request->deskripsi,
            'user_id'       => auth()->user()->id,
            'gambar'        => $path,
            'jenis_id'      => $request->jenis_id,
            'satuan_id'     => $request->satuan_id
        ]);
    
        return response()->json([
            'success'   => true,
            'message'   => 'Data Berhasil Terupdate',
            'data'      => $barang
        ]);
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Barang $barang)
    {
        unlink('.'.Storage::url($barang->gambar));
    
        Barang::destroy($barang->id);

        return response()->json([
            'success' => true,
            'message' => 'Data Barang Berhasil Dihapus!'
        ]);
    }
}
