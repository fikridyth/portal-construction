<?php

namespace App\Http\Controllers;

use App\DataTables\TipePembayaranDataTable;
use App\Helpers\AuthHelper;
use App\Models\TipePembayaran;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TipePembayaranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(TipePembayaranDataTable $dataTable)
    {
        $pageHeader = 'Tipe Pembayaran';
        $pageTitle = 'List Tipe Pembayaran';
        $auth_user = AuthHelper::authSession();
        $assets = ['data-table'];
        $headerAction = '<a href="' . route('tipe-pembayaran.create') . '" class="btn btn-sm btn-primary" role="button">Tambah Tipe Pembayaran</a>';
        return $dataTable->render('app.master.tipe-pembayaran.index', compact('pageHeader', 'pageTitle', 'auth_user', 'assets', 'headerAction'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pageHeader = 'Tambah Tipe Pembayaran';
        return view('app.master.tipe-pembayaran.form', compact('pageHeader'));
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
            'kode' => 'required|unique:tipe_pembayarans,kode',
        ], [
            'kode.unique' => 'Kode sudah digunakan!',
        ]);

        $data = [
            'kode' => $request->kode,
            'nama' => $request->nama,
            'created_by' => auth()->user()->id,
            'updated_by' => auth()->user()->id,
        ];
        TipePembayaran::create($data);

        return redirect()->route('tipe-pembayaran.index')->withSuccess(__('Tambah Tipe Pembayaran Berhasil', ['name' => __('tipe-pembayaran.store')]));
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
        $pageHeader = 'Lihat Tipe Pembayaran';
        $data = TipePembayaran::findOrFail($id);
        
        return view('app.master.tipe-pembayaran.form', compact('pageHeader', 'data', 'id'));
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
        $dataTipe = TipePembayaran::findOrFail($id);
        $request->validate([
            'kode' => [
                'required',
                Rule::unique('tipe_pembayarans', 'kode')->ignore($dataTipe->id),
            ],
        ], [
            'kode.unique' => 'Kode sudah digunakan!',
        ]);

        $data = [
            'kode' => $request->kode,
            'nama' => $request->nama,
            'updated_by' => auth()->user()->id,
        ];
        $dataTipe->update($data);

        return redirect()->route('tipe-pembayaran.index')->withSuccess(__('Ubah Data Tipe Pembayaran Berhasil', ['name' => __('tenaga-kerja.update')]));
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
