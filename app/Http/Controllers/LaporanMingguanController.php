<?php

namespace App\Http\Controllers;

use App\DataTables\LaporanMingguanDataTable;
use App\Helpers\AuthHelper;
use App\Models\DetailPekerjaan;
use App\Models\LaporanMingguan;
use App\Models\Pekerjaan;
use App\Models\Proyek;
use Carbon\Carbon;
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
        $dataMingguan = LaporanMingguan::where('id_proyek', $id)->orderBy('created_at', 'desc')->first();

        // Decode list_pekerjaan menjadi array keyed by id_detail_pekerjaan
        $progressData = [];
        if ($dataMingguan && $dataMingguan->list_pekerjaan) {
            foreach (json_decode($dataMingguan->list_pekerjaan, true) as $row) {
                $progressData[$row['id_detail_pekerjaan']] = $row['progress_total'];
            }
        }

        return response()->json([
            'detail' => $data,
            'progress' => $progressData
        ]);
    }

    public function getMingguKe($id)
    {
        $data = 0;
        $dataMingguan = LaporanMingguan::where('id_proyek', $id)->orderBy('created_at', 'desc')->first();
        if ($dataMingguan) {
            $data = $dataMingguan->minggu_ke;
        }
    
        return response()->json(['minggu_ke' => $data + 1 ?? 1]);
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
        $dLastProgress = array_values($request->input('last_progress'));
        $dProgress = array_values($request->input('detail_progress'));
        foreach ($dProgress as $index => $value) {
            $progressBaru = (float) $value;
            $progressLama = (float) ($dLastProgress[$index] ?? 0);
        
            if ($progressBaru > 100) {
                return redirect()->back()
                    ->withInput()
                    ->withErrors(['detail_progress.' . $index => 'Progress tidak boleh lebih dari 100.']);
            }
        
            if ($progressBaru < $progressLama) {
                return redirect()->back()
                    ->withInput()
                    ->withErrors(['detail_progress.' . $index => 'Progress harus lebih besar dari progress sebelumnya.']);
            }
        }

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
                'progress_minggu_ini' => $dProgress[$i] - $progressMingguLalu,
                'bobot_minggu_ini' => number_format($bobotMingguIni - $bobotMingguLalu, 2),
                'progress_total' => $dProgress[$i],
                'bobot_total' => number_format($bobotMingguIni, 2),
            ];
        }
        $totalBobotMingguLalu = number_format(array_sum(array_column($getDataMingguan, 'bobot_minggu_lalu')), 2);
        $totalBobotMingguIni = number_format(array_sum(array_column($getDataMingguan, 'bobot_total')), 2);

        $data = [
            'id_proyek' => $request->id_proyek,
            'minggu_ke' => $request->minggu_ke,
            'dari' => $request->dari,
            'sampai' => $request->sampai,
            'bobot_rencana' => number_format($request->bobot_rencana, 2),
            'bobot_minggu_lalu' => number_format($totalBobotMingguLalu ?? null, 2),
            'bobot_minggu_ini' => number_format($totalBobotMingguIni - $totalBobotMingguLalu ?? null, 2),
            'bobot_total' => number_format($totalBobotMingguIni, 2),
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
        $job = Pekerjaan::all()->keyBy('id');

        $dari = Carbon::parse($data->dari);
        $sampai = Carbon::parse($data->sampai);
        $masaPelaksanaan = $dari->format('d') . ' S/D ' . $sampai->format('d F Y');

        return view('app.proses.laporan-mingguan.show', compact('assets', 'pageHeader', 'data', 'job', 'masaPelaksanaan'));
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

        $dari = Carbon::parse($data->dari);
        $sampai = Carbon::parse($data->sampai);
        $masaPelaksanaan = $dari->format('d') . ' S/D ' . $sampai->format('d F Y');

        return view('app.proses.laporan-mingguan.print', compact('pageHeader', 'data', 'dataPekerjaan', 'dataPekerjaanById', 'masaPelaksanaan'));
    }
}
