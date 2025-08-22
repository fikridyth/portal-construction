<?php

namespace App\Http\Controllers;

use App\DataTables\SupplierDataTable;
use App\Helpers\AuthHelper;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(SupplierDataTable $dataTable)
    {
        $pageHeader = 'Supplier';
        $pageTitle = 'List Supplier';
        $auth_user = AuthHelper::authSession();
        $assets = ['data-table'];
        $headerAction = '<a href="' . route('supplier.create') . '" class="btn btn-sm btn-primary" role="button">Tambah Supplier</a>';
        return $dataTable->render('app.master.supplier.index', compact('pageHeader', 'pageTitle', 'auth_user', 'assets', 'headerAction'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pageHeader = 'Tambah Supplier';
        return view('app.master.supplier.form', compact('pageHeader'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|unique:suppliers,nama',
        ], [
            'nama.unique' => 'Nama supplier sudah digunakan!',
        ]);

        $data = [
            'nama' => $request->nama,
            'owner' => $request->owner,
            'nomor_rekening' => $request->nomor_rekening,
            'nama_rekening' => $request->nama_rekening,
            'created_by' => auth()->user()->id,
            'updated_by' => auth()->user()->id,
        ];
        Supplier::create($data);

        return redirect()->route('supplier.index')->withSuccess(__('Tambah Supplier Berhasil', ['name' => __('supplier.store')]));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $id = dekrip($id);
        $pageHeader = 'Lihat Supplier';
        $data = Supplier::findOrFail($id);

        return view('app.master.supplier.form', compact('pageHeader', 'data', 'id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $dataSupplier = Supplier::findOrFail($id);
        $request->validate([
            'nama' => [
                'required',
                Rule::unique('suppliers', 'nama')->ignore($dataSupplier->id),
            ],
        ], [
            'nama.unique' => 'Nama supplier sudah digunakan!',
        ]);

        $data = [
            'nama' => $request->nama,
            'owner' => $request->owner,
            'nomor_rekening' => $request->nomor_rekening,
            'nama_rekening' => $request->nama_rekening,
            'updated_by' => auth()->user()->id,
        ];
        $dataSupplier->update($data);

        return redirect()->route('supplier.index')->withSuccess(__('Ubah Data Supplier Berhasil', ['name' => __('supplier.update')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
