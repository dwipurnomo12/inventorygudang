<?php

namespace App\Http\Controllers;

use Dompdf\Dompdf;
use App\Models\Barang;
use App\Models\Satuan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LaporanStokController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('laporan-stok.index');
    }

    /**
     * Get Data 
     */
    public function getData(Request $request)
    {
        $selectedOption = $request->input('opsi');

        if($selectedOption == 'semua'){
             $barangs = Barang::all();
        } elseif ($selectedOption == 'minimum'){
             $barangs = Barang::where('stok', '<=', 10)->get();
        } elseif ($selectedOption == 'stok-habis'){
             $barangs = Barang::where('stok', 0)->get();
        } else {
             $barangs = Barang::all();
        }
 
        return response()->json($barangs);
    }

    /**
     * Print Data 
    */
    public function printStok(Request $request)
    {
        $selectedOption = $request->input('opsi');

        if ($selectedOption == 'semua') {
            $barangs = Barang::all();
        } elseif ($selectedOption == 'minimum') {
            $barangs = Barang::where('stok', '<=', 10)->get();
        } elseif ($selectedOption == 'stok-habis') {
            $barangs = Barang::where('stok', 0)->get();
        } else {
            $barangs = Barang::all();
        }

        // Generate PDF
        $dompdf = new Dompdf();
        $html = view('/laporan-stok/print-stok', compact('barangs', 'selectedOption'))->render();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        $dompdf->stream('print-stok.pdf', ['Attachment' => false]);
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

    /**
     * Get Satuan
     */
    public function getSatuan()
    {
        $satuans = Satuan::all();
        return response()->json($satuans);
    }
}
