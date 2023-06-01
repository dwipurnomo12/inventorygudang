<?php

namespace App\Http\Controllers;

use Dompdf\Dompdf;
use App\Models\Supplier;
use App\Models\BarangMasuk;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LaporanBarangMasukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('laporan-barang-masuk.index');
    }

    /**
     * Get Data 
     */
    public function getData(Request $request)
    {
        $tanggalMulai = $request->input('tanggal_mulai');
        $tanggalSelesai = $request->input('tanggal_selesai');
    
        $barangMasuk = BarangMasuk::query();
    
        if ($tanggalMulai && $tanggalSelesai) {
            $barangMasuk->whereBetween('tanggal_masuk', [$tanggalMulai, $tanggalSelesai]);
        }
    
        $data = $barangMasuk->get();

        if (empty($tanggalMulai) && empty($tanggalSelesai)) {
            $data = BarangMasuk::all();
        }
    
        return response()->json($data);
    }
    
    /**
     * Print DomPDF
     */
    public function printBarangMasuk(Request $request)
    {
        $tanggalMulai = $request->input('tanggal_mulai');
        $tanggalSelesai = $request->input('tanggal_selesai');
    
        $barangMasuk = BarangMasuk::query();
    
        if ($tanggalMulai && $tanggalSelesai) {
            $barangMasuk->whereBetween('tanggal_masuk', [$tanggalMulai, $tanggalSelesai]);
        }
    
        if ($tanggalMulai !== null && $tanggalSelesai !== null) {
            $data = $barangMasuk->get();
        } else {
            $data = BarangMasuk::all();
        }
        
        //Generate PDF
        $dompdf = new Dompdf();
        $html = view('/laporan-barang-masuk/print-barang-masuk', compact('data', 'tanggalMulai', 'tanggalSelesai'))->render();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        $dompdf->stream('print-barang-masuk.pdf', ['Attachment' => false]);
    }
    
    /**
     * Get Supplier
     */
    public function getSupplier()
    {
        $supplier = Supplier::all();
        return response()->json($supplier);
    }

    
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
