<?php

namespace App\Http\Controllers;

use App\Models\Jenis;
use Illuminate\Http\Request;
use function Pest\Laravel\json;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

use Illuminate\Auth\Events\Validated;
use Illuminate\Support\Facades\Validator;

class JenisController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('jenis-barang.index', [
            'jenisBarangs' => Jenis::all()
        ]);
    }

    public function getDataJenisBarang()
    {
        return response()->json([
            'success' => true,
            'data'    => Jenis::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('jenis-barang.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'jenis_barang'  => 'required'
        ],[
            'jenis_barang.required' => 'Form Jenis Barang Wajib Di Isi !'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }

        $jenisBarang = Jenis::create([
            'jenis_barang' => $request->jenis_barang,
            'user_id'      => auth()->user()->id
        ]);

        return response()->json([
            'success'   => true,
            'message'   => 'Data Berhasil Disimpan !',
            'data'      => $jenisBarang
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Jenis $jenis)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $jenis = Jenis::findOrFail($id);   
        return response()->json([
            'success' => true,
            'message' => 'Edit Data Barang',
            'data'    => $jenis
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $jenis = Jenis::find($id);

        $validator = Validator::make($request->all(),[
            'jenis_barang'  => 'required',
        ],[
            'jenis_barang.required' => 'Form Jenis Barang Tidak Boleh Kosong'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }

        $jenis->update([
            'jenis_barang'  => $request->jenis_barang,
            'user_id'       => auth()->user()->id
        ]);

        return response()->json([
            'success'   => true,
            'message'   => 'Data Berhasil Terupdate',
            'data'      => $jenis
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Jenis::find($id)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data Berhasil Dihapus!'
        ]);    
    }
}
