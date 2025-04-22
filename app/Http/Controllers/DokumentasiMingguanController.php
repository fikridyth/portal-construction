<?php

namespace App\Http\Controllers;

use App\DataTables\DokumentasiMingguanDataTable;
use App\Helpers\AuthHelper;
use App\Models\DokumentasiMingguan;
use App\Models\LaporanMingguan;
use App\Models\Proyek;
use Illuminate\Http\Request;

class DokumentasiMingguanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(DokumentasiMingguanDataTable $dataTable)
    {
        $pageHeader = 'Index Dokumentasi Mingguan';
        $pageTitle = 'List Dokumentasi Mingguan';
        $auth_user = AuthHelper::authSession();
        $assets = ['data-table'];
        $headerAction = '<a href="' . route('dokumentasi-mingguan.create') . '" class="btn btn-sm btn-primary" role="button">Tambah Dokumentasi</a>';
        return $dataTable->render('app.proses.dokumentasi-mingguan.index', compact('pageHeader', 'pageTitle', 'auth_user', 'assets', 'headerAction'));
    }

    public function getMingguKe($id)
    {
        $data = 0;
        $dataDari = now()->format('Y-m-d');
        $dataSampai = now()->format('Y-m-d');
        $dataLap = LaporanMingguan::where('id_proyek', $id)->orderBy('created_at', 'asc')->first();
        if ($dataLap) {
            $dataDari = $dataLap->dari;
            $dataSampai = $dataLap->sampai;
        }
        $dataMingguan = DokumentasiMingguan::where('id_laporan_mingguan', $dataLap->id)->orderBy('created_at', 'desc')->first();
        if ($dataMingguan) {
            $data = $dataMingguan->minggu_ke;
        }
    
        return response()->json([
            'minggu_ke' => $data + 1 ?? 1,
            'dari' => $dataDari ?? now()->format('Y-m-d'),
            'sampai' => $dataSampai ?? now()->format('Y-m-d')
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pageHeader = 'Create Dokumentasi Mingguan';
        $dataProyek = Proyek::all();

        return view('app.proses.dokumentasi-mingguan.form', compact('pageHeader', 'dataProyek'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $getDataLap = LaporanMingguan::where('id_proyek', $request->id_proyek)->where('minggu_ke', $request->minggu_ke)->pluck('id')->first();
        // dd($getDataLap, $request->all());

        $data = [
            'id_laporan_mingguan' => $getDataLap,
            'minggu_ke' => $request->minggu_ke,
            'dari' => $request->dari,
            'sampai' => $request->sampai,
            'list_gambar' => null,
            'created_by' => auth()->user()->id,
            'updated_by' => auth()->user()->id,
        ];
        DokumentasiMingguan::create($data);

        return redirect()->route('dokumentasi-mingguan.index')->withSuccess(__('Tambah Dokumentasi Mingguan Berhasil', ['name' => __('dokumentasi-mingguan.store')]));
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
        //
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
        //
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
    
    public function printDokumentasiMingguan($id)
    {
        //
    }
}
