<?php

namespace App\Http\Controllers;

use App\DataTables\LaporanPelaksanaanDataTable;
use App\Helpers\AuthHelper;
use App\Models\DetailPekerjaan;
use App\Models\LaporanPelaksanaan;
use App\Models\Proyek;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LaporanPelaksanaanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(LaporanPelaksanaanDataTable $dataTable)
    {
        $pageHeader = 'Index Laporan Pelaksanaan';
        $pageTitle = 'List Laporan Pelaksanaan';
        $auth_user = AuthHelper::authSession();
        $assets = ['data-table'];
        $headerAction = '<a href="' . route('laporan-pelaksanaan.create') . '" class="btn btn-sm btn-primary" role="button">Tambah Laporan</a>';
        return $dataTable->render('app.proses.laporan-pelaksanaan.index', compact('pageHeader', 'pageTitle', 'auth_user', 'assets', 'headerAction'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pageHeader = 'Create Laporan Pelaksanaan';
        $dataProyek = Proyek::all()->filter(function ($proyek) {
            $totalBobot = DetailPekerjaan::where('id_proyek', $proyek->id)->sum('bobot');
            $sudahAdaLaporan = LaporanPelaksanaan::where('id_proyek', $proyek->id)->where('realisasi', '>=', 100)->exists();
            return $totalBobot == 100 && !$sudahAdaLaporan;
        });

        return view('app.proses.laporan-pelaksanaan.form', compact('pageHeader', 'dataProyek'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $dari = Carbon::parse($request->dari);
        $sampai = Carbon::parse($request->sampai);

        if ($dari->gt($sampai)) {
            return redirect()->back()->withInput()->withErrors(['Peringatan' => 'Tanggal mulai tidak boleh lebih besar dari tanggal akhir.']);
        }

        $data = [
            'id_proyek' => $request->id_proyek,
            'bulan_ke' => $request->bulan_ke,
            'dari' => $request->dari,
            'sampai' => $request->sampai,
            'lokasi' => $request->lokasi,
            'keadaan_tenaga' => (int)$request->keadaan_tenaga ?? 0,
            'keadaan_bahan' => (int)$request->keadaan_bahan ?? 0,
            'keadaan_keuangan' => (int)$request->keadaan_keuangan ?? 0,
            'realisasi' => $request->realisasi,
            'rencana' => $request->rencana,
            'deviasi' => $request->realisasi - $request->rencana,
            'keterangan' => $request->keterangan ?? '',
            'created_by' => auth()->user()->id,
            'updated_by' => auth()->user()->id,
        ];
        LaporanPelaksanaan::create($data);

        return redirect()->route('laporan-pelaksanaan.index')->withSuccess(__('Tambah Laporan Pelaksanaan Berhasil', ['name' => __('laporan-pelaksanaan.store')]));
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

    public function printPelaksanaan($id)
    {
        $data = LaporanPelaksanaan::findOrFail($id);
        $mulai = Carbon::parse($data->proyek->dari);
        $dari = Carbon::parse($data->dari);
        $sampai = Carbon::parse($data->sampai);
        $range = $dari->format('d') . ' S/D ' . $sampai->format('d F Y');

        return view('app.proses.laporan-pelaksanaan.print', compact('data', 'mulai', 'range'));
    }
}
