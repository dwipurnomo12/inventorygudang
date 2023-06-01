<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Barang;
use App\Models\BarangMasuk;
use App\Models\BarangKeluar;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $barangCount        = Barang::all()->count();
        $barangMasukCount   = BarangMasuk::all()->count();
        $barangKeluarCount  = BarangKeluar::all()->count();
        $userCount          = User::all()->count();
        $barangMasukPerBulan = BarangMasuk::selectRaw('DATE_FORMAT(tanggal_masuk, "%Y-%m") as date, SUM(jumlah_masuk) as total')
            ->groupBy('date')
            ->get()
            ->map(function ($data) {
                $data->date = date('Y-m', strtotime($data->date));
                $data->total = (int) $data->total;
                return $data;
        });
        $barangKeluarPerBulan = BarangKeluar::selectRaw('DATE_FORMAT(tanggal_keluar, "%Y-%m") as date, SUM(jumlah_keluar) as total')
            ->groupBy('date')
            ->get()
            ->map(function ($data) {
                $data->date = date('Y-m', strtotime($data->date));
                $data->total = (int) $data->total;
                return $data;
        });
    
        $barangMinimum = Barang::where('stok', '<=', 10)->get();
        
                                
        return view('dashboard', [
            'barang'            => $barangCount,
            'barangMasuk'       => $barangMasukCount,
            'barangKeluar'      => $barangKeluarCount,
            'user'              => $userCount,
            'barangMasukData'   => $barangMasukPerBulan,
            'barangKeluarData'  => $barangKeluarPerBulan,
            'barangMinimum'     => $barangMinimum
        ]);
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
