<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('customer.index', [
            'customers' => Customer::all()
        ]);
    }

    public function getDataCustomer()
    {
        return response()->json([
            'success'   => true,
            'data'      => Customer::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('customer.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'customer'  => 'required',
            'alamat'    => 'required'
        ],[
            'customer.required' => 'Form Customer Wajib Di Isi !',
            'alamat.required'   => 'Form Alamat Wajib Diisi'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }

        $customer = Customer::create([
            'customer'  => $request->customer,
            'alamat'    => $request->alamat,
            'user_id'   => auth()->user()->id
        ]);

        return response()->json([
            'success'   => true,
            'message'   => 'Data Berhasil Disimpan !',
            'data'      => $customer
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
        return response()->json([
            'success' => true,
            'message' => 'Edit Data Barang',
            'data'    => $customer
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Customer $customer)
    {
        $validator = Validator::make($request->all(), [
            'customer'  => 'required',
            'alamat'    => 'required'
        ],[
            'customer.required' => 'Form Customer Wajib Di Isi !',
            'alamat.required'   => 'Form Alamat Wajib Diisi'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }

        $customer->update([
            'customer'  => $request->customer,
            'alamat'    => $request->alamat,
            'user_id'   => auth()->user()->id
        ]);

        return response()->json([
            'success'   => true,
            'message'   => 'Data Berhasil Terupdate',
            'data'      => $customer
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        Customer::destroy($customer->id);
        return response()->json([
            'success' => true,
            'message' => 'Data Berhasil Dihapus'
        ]);
    }
}
