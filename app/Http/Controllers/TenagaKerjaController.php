<?php

namespace App\Http\Controllers;

use App\DataTables\TenagaKerjaDataTable;
use App\Helpers\AuthHelper;
use App\Models\TenagaKerja;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TenagaKerjaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(TenagaKerjaDataTable $dataTable)
    {
        $pageHeader = 'Tenaga Kerja';
        $pageTitle = 'List Tenaga Kerja';
        $auth_user = AuthHelper::authSession();
        $assets = ['data-table'];
        $headerAction = '<a href="' . route('tenaga-kerja.create') . '" class="btn btn-sm btn-primary" role="button">Tambah Tenaga Kerja</a>';
        return $dataTable->render('app.master.tenaga-kerja.index', compact('pageHeader', 'pageTitle', 'auth_user', 'assets', 'headerAction'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pageHeader = 'Tambah Tenaga Kerja';
        return view('app.master.tenaga-kerja.form', compact('pageHeader'));
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
            'nama' => 'required|unique:tenaga_kerjas,nama',
        ], [
            'nama.unique' => 'Nama tenaga kerja sudah digunakan!',
        ]);

        $data = [
            'nama' => $request->nama,
            'created_by' => auth()->user()->id,
            'updated_by' => auth()->user()->id,
        ];
        TenagaKerja::create($data);

        return redirect()->route('tenaga-kerja.index')->withSuccess(__('Tambah Tenaga Kerja Berhasil', ['name' => __('tenaga-kerja.store')]));
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
        $pageHeader = 'Lihat Tenaga Kerja';
        $data = TenagaKerja::findOrFail($id);
        
        return view('app.master.tenaga-kerja.form', compact('pageHeader', 'data', 'id'));
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
        $dataTenaga = TenagaKerja::findOrFail($id);
        $request->validate([
            'nama' => [
                'required',
                Rule::unique('tenaga_kerjas', 'nama')->ignore($dataTenaga->id),
            ],
        ], [
            'nama.unique' => 'Nama tenaga kerja sudah digunakan!',
        ]);

        $data = [
            'nama' => $request->nama,
            'updated_by' => auth()->user()->id,
        ];
        $dataTenaga->update($data);

        return redirect()->route('tenaga-kerja.index')->withSuccess(__('Ubah Data Tenaga Kerja Berhasil', ['name' => __('tenaga-kerja.update')]));
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
