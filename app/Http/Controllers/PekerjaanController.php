<?php

namespace App\Http\Controllers;

use App\DataTables\PekerjaanDataTable;
use App\Helpers\AuthHelper;
use App\Models\Pekerjaan;
use Illuminate\Http\Request;

class PekerjaanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(PekerjaanDataTable $dataTable)
    {
        $pageHeader = 'Pekerjaan';
        $pageTitle = 'List Pekerjaan';
        $auth_user = AuthHelper::authSession();
        $assets = ['data-table'];
        $headerAction = '<a href="' . route('pekerjaan.create') . '" class="btn btn-sm btn-primary" role="button">Tambah Pekerjaan</a>';
        return $dataTable->render('app.master.pekerjaan.index', compact('pageHeader', 'pageTitle', 'auth_user', 'assets', 'headerAction'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pageHeader = 'Tambah Pekerjaan';
        return view('app.master.pekerjaan.form', compact('pageHeader'));
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
            'nama' => 'required|unique:pekerjaans,nama',
        ], [
            'nama.unique' => 'Nama pekerjaan sudah digunakan!',
        ]);

        $data = [
            'nama' => $request->nama,
            'created_by' => auth()->user()->id,
            'updated_by' => auth()->user()->id,
        ];
        Pekerjaan::create($data);

        return redirect()->route('pekerjaan.index')->withSuccess(__('Tambah Pekerjaan Berhasil', ['name' => __('pekerjaan.store')]));
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
        $pageHeader = 'Lihat Pekerjaan';
        $data = Pekerjaan::findOrFail($id);
        
        return view('app.master.pekerjaan.form', compact('pageHeader', 'data', 'id'));
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
        $dataPekerjaan = Pekerjaan::findOrFail($id);
        $data = [
            'nama' => $request->nama,
            'updated_by' => auth()->user()->id,
        ];
        $dataPekerjaan->update($data);

        return redirect()->route('pekerjaan.index')->withSuccess(__('Ubah Data Pekerjaan Berhasil', ['name' => __('pekerjaan.update')]));
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
