<?php

namespace App\Http\Controllers;

use App\DataTables\BahanDataTable;
use App\Helpers\AuthHelper;
use App\Models\Bahan;
use Illuminate\Http\Request;

class BahanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(BahanDataTable $dataTable)
    {
        $pageHeader = 'Bahan';
        $pageTitle = 'List Bahan';
        $auth_user = AuthHelper::authSession();
        $assets = ['data-table'];
        $headerAction = '<a href="' . route('bahan.create') . '" class="btn btn-sm btn-primary" role="button">Tambah Bahan</a>';
        return $dataTable->render('app.master.bahan.index', compact('pageHeader', 'pageTitle', 'auth_user', 'assets', 'headerAction'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        $pageHeader = 'Tambah Bahan';
        return view('app.master.bahan.form', compact('pageHeader'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = [
            'nama' => $request->nama,
            // 'volume' => $request->volume,
            'satuan' => $request->satuan,
            'harga_modal_material' => $request->harga_modal_material,
            'harga_modal_upah' => $request->harga_modal_upah,
            // 'harga_jual' => $request->harga_jual,
            'created_by' => auth()->user()->id,
            'updated_by' => auth()->user()->id,
        ];
        Bahan::create($data);

        return redirect()->route('bahan.index')->withSuccess(__('Tambah Bahan Berhasil', ['name' => __('bahan.store')]));
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
        $pageHeader = 'Lihat Bahan';
        $data = Bahan::findOrFail($id);
        
        return view('app.master.bahan.form', compact('pageHeader', 'data', 'id'));
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
        $dataBahan = Bahan::findOrFail($id);
        $data = [
            'nama' => $request->nama,
            // 'volume' => $request->volume,
            'satuan' => $request->satuan,
            'harga_modal_material' => $request->harga_modal_material,
            'harga_modal_upah' => $request->harga_modal_upah,
            // 'harga_jual' => $request->harga_jual,
            'updated_by' => auth()->user()->id,
        ];
        $dataBahan->update($data);

        return redirect()->route('bahan.index')->withSuccess(__('Ubah Data Bahan Berhasil', ['name' => __('bahan.update')]));
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
