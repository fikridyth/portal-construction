<?php

namespace App\Http\Controllers;

use App\DataTables\CuacaMingguanDataTable;
use App\Helpers\AuthHelper;
use App\Models\CuacaMingguan;
use App\Models\DetailPekerjaan;
use App\Models\LaporanMingguan;
use App\Models\Proyek;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CuacaMingguanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(CuacaMingguanDataTable $dataTable)
    {
        $pageHeader = 'Index Cuaca Mingguan';
        $pageTitle = 'List Cuaca Mingguan';
        $auth_user = AuthHelper::authSession();
        $assets = ['data-table'];
        $headerAction = '<a href="' . route('cuaca-mingguan.create') . '" class="btn btn-sm btn-primary" role="button">Tambah Cuaca</a>';
        return $dataTable->render('app.proses.cuaca-mingguan.index', compact('pageHeader', 'pageTitle', 'auth_user', 'assets', 'headerAction'));
    }

    public function getMingguKe($id)
    {
        $data = 1;
        $dataDari = now()->format('Y-m-d');
        $dataSampai = now()->format('Y-m-d');

        $dataCuaca = CuacaMingguan::where('id_proyek', $id)->orderBy('created_at', 'desc')->first();
        if ($dataCuaca) {
            $dataLap = LaporanMingguan::where('id_proyek', $id)->where('minggu_ke', $dataCuaca->minggu_ke)->first();
        } else {
            $dataLap = LaporanMingguan::where('id_proyek', $id)->orderBy('created_at', 'asc')->first();
        }

        $dataMingguan = CuacaMingguan::where('id_laporan_mingguan', $dataLap->id)->orderBy('created_at', 'desc')->first();
        if ($dataMingguan) {
            $data = $dataMingguan->minggu_ke + 1;
            $dataDate = LaporanMingguan::where('id_proyek', $id)->where('minggu_ke', $dataMingguan->minggu_ke + 1)->first();
        }
        if (isset($dataDate)) {
            $dataDari = $dataDate->dari;
            $dataSampai = $dataDate->sampai;
        } else {
            $dataDari = $dataLap->dari;
            $dataSampai = $dataLap->sampai;
        }
    
        return response()->json([
            'minggu_ke' => $data,
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
        $pageHeader = 'Create Cuaca Mingguan';
        $dataProyek = Proyek::all()->filter(function ($proyek) {
            $totalBobot = DetailPekerjaan::where('id_proyek', $proyek->id)->sum('bobot');
            $sudahAdaLaporan = CuacaMingguan::where('id_proyek', $proyek->id)->where('bobot_total', '>=', 100)->exists();
            // Hanya ambil proyek yang total bobotnya 100 DAN BELUM punya laporan
            return $totalBobot == 100 && !$sudahAdaLaporan;
        });

        return view('app.proses.cuaca-mingguan.form', compact('pageHeader', 'dataProyek'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $getDataLap = LaporanMingguan::where('id_proyek', $request->id_proyek)->where('minggu_ke', $request->minggu_ke)->first();
        // dd($getDataLap, json_encode($request->cuaca));

        $data = [
            'id_proyek' => $request->id_proyek,
            'id_laporan_mingguan' => $getDataLap->id,
            'minggu_ke' => $request->minggu_ke,
            'dari' => $request->dari,
            'sampai' => $request->sampai,
            'bobot_total' => $getDataLap->bobot_total,
            'list_cuaca' => json_encode($request->cuaca),
            'created_by' => auth()->user()->id,
            'updated_by' => auth()->user()->id,
        ];
        CuacaMingguan::create($data);

        return redirect()->route('cuaca-mingguan.index')->withSuccess(__('Tambah Cuaca Mingguan Berhasil', ['name' => __('cuaca-mingguan.store')]));
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

    public function printCuacaMingguan($id)
    {
        $id = dekrip($id);
        $data = CuacaMingguan::findOrFail($id);
        $listCuaca = json_decode($data->list_cuaca, true);

        $dari = Carbon::parse($data->dari);
        $sampai = Carbon::parse($data->sampai);
        $range = $dari->format('d') . ' S/D ' . $sampai->format('d F Y');

        return view('app.proses.cuaca-mingguan.print', compact('data', 'listCuaca', 'range'));
    }
}
