<?php

namespace App\Http\Controllers;

use App\DataTables\LaporanMingguanDataTable;
use App\Helpers\AuthHelper;
use App\Models\DetailPekerjaan;
use App\Models\LaporanMingguan;
use App\Models\Proyek;
use Illuminate\Http\Request;

class LaporanMingguanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(LaporanMingguanDataTable $dataTable)
    {
        $pageHeader = 'Index Laporan Mingguan';
        $pageTitle = 'List Laporan Mingguan';
        $auth_user = AuthHelper::authSession();
        $assets = ['data-table'];
        $headerAction = '<a href="' . route('laporan-mingguan.create') . '" class="btn btn-sm btn-primary" role="button">Tambah Laporan</a>';
        return $dataTable->render('app.proses.laporan-mingguan.index', compact('pageHeader', 'pageTitle', 'auth_user', 'assets', 'headerAction'));
    }

    public function getDetailPekerjaan($id)
    {
        $data = DetailPekerjaan::with('pekerjaan')->where('id_proyek', $id)->orderBy('id_pekerjaan', 'asc')->get();
        return response()->json($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pageHeader = 'Create Laporan Mingguan';
        $dataProyek = Proyek::all()->filter(function ($proyek) {
            $totalBobot = DetailPekerjaan::where('id_proyek', $proyek->id)->sum('bobot');
            $sudahAdaLaporan = LaporanMingguan::where('id_proyek', $proyek->id)->where('bobot_total', '>=', 100)->exists();
            // Hanya ambil proyek yang total bobotnya 100 DAN BELUM punya laporan
            return $totalBobot == 100 && !$sudahAdaLaporan;
        });
        return view('app.proses.laporan-mingguan.form', compact('pageHeader', 'dataProyek'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $dIdProyek = array_values($request->input('detail_id_proyek'));
        $dIdPekerjaan = array_values($request->input('detail_id_pekerjaan'));
        $dIdDetailPekerjaan = array_values($request->input('detail_id_detail_pekerjaan'));
        $dNamaPekerjaan = array_values($request->input('detail_nama_pekerjaan'));
        $dVolume = array_values($request->input('detail_volume'));
        $dSatuan = array_values($request->input('detail_satuan'));
        $dBobot = array_values($request->input('detail_bobot'));
        $dProgress = array_values($request->input('detail_progress'));
        $getLastData = [];
        if ($request->minggu_ke > 1) {
            $pastReports = LaporanMingguan::where('id_proyek', $request->id_proyek)
                ->where('minggu_ke', '<', $request->minggu_ke)
                ->get();
        
            foreach ($pastReports as $report) {
                if ($report->list_pekerjaan) {
                    $decodedList = json_decode($report->list_pekerjaan, true);
        
                    foreach ($decodedList as $item) {
                        $idDetail = $item['id_detail_pekerjaan'];
        
                        if (!isset($getLastData[$idDetail])) {
                            $getLastData[$idDetail] = [
                                'total_progress' => 0,
                                'total_bobot' => 0,
                            ];
                        }
        
                        $getLastData[$idDetail]['total_progress'] += floatval($item['progress_minggu_ini']);
                        $getLastData[$idDetail]['total_bobot'] += floatval($item['bobot_minggu_ini']);
                    }
                }
            }
        }
        // dd($getLastData);
        
        $getDataMingguan = [];
        for ($i = 0; $i < count($dIdProyek); $i++) {
            $idDetail = $dIdDetailPekerjaan[$i];
            $progressMingguLalu = $getLastData[$idDetail]['total_progress'] ?? 0;
            $bobotMingguLalu = $getLastData[$idDetail]['total_bobot'] ?? 0;
            $bobotMingguIni = ($dBobot[$i] * $dProgress[$i]) / 100;

            $getDataMingguan[] = [
                'id_proyek' => $dIdProyek[$i],
                'id_pekerjaan' => $dIdPekerjaan[$i],
                'id_detail_pekerjaan' => $idDetail,
                'nama_pekerjaan' => $dNamaPekerjaan[$i],
                'volume' => $dVolume[$i],
                'satuan' => $dSatuan[$i],
                'bobot' => $dBobot[$i],
                'progress_minggu_lalu' => $progressMingguLalu,
                'bobot_minggu_lalu' => number_format($bobotMingguLalu, 2),
                'progress_minggu_ini' => $dProgress[$i],
                'bobot_minggu_ini' => number_format($bobotMingguIni, 2),
            ];
        }
        $totalBobotMingguLalu = number_format(array_sum(array_column($getDataMingguan, 'bobot_minggu_lalu')), 2);
        $totalBobotMingguIni = number_format(array_sum(array_column($getDataMingguan, 'bobot_minggu_ini')), 2);

        $data = [
            'id_proyek' => $request->id_proyek,
            'minggu_ke' => $request->minggu_ke,
            'bobot_rencana' => number_format($request->bobot_rencana, 2),
            'bobot_minggu_lalu' => $totalBobotMingguLalu ?? null,
            'bobot_minggu_ini' => $totalBobotMingguIni,
            'bobot_total' => number_format(($totalBobotMingguLalu ?? null) + $totalBobotMingguIni, 2),
            'list_pekerjaan' => json_encode($getDataMingguan) ?? null,
            'created_by' => auth()->user()->id,
            'updated_by' => auth()->user()->id,
        ];
        LaporanMingguan::create($data);

        return redirect()->route('laporan-mingguan.index')->withSuccess(__('Tambah Laporan Mingguan Berhasil', ['name' => __('laporan-mingguan.store')]));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $assets = ['data-table'];
        $pageHeader = 'Lihat Laporan Mingguan';
        $data = LaporanMingguan::findOrFail($id);

        return view('app.proses.laporan-mingguan.show', compact('pageHeader', 'data', 'assets'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $pageHeader = 'Ubah Laporan Mingguan';
        $data = LaporanMingguan::findOrFail($id);

        return view('app.proses.laporan-mingguan.form', compact('pageHeader', 'data', 'id'));
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

    public function printLaporanMingguan($id)
    {
        $pageHeader = 'Print Laporan Mingguan';
        $data = LaporanMingguan::findOrFail($id);
        $dataPekerjaan = DetailPekerjaan::where('id_proyek', $data->id_proyek)->orderBy('id_pekerjaan', 'asc')->get();
        $dataPekerjaanById = $dataPekerjaan->groupBy('id_pekerjaan');
        // dd($dataPekerjaanById);

        return view('app.proses.laporan-mingguan.print', compact('pageHeader', 'data', 'dataPekerjaan', 'dataPekerjaanById'));
    }
}
