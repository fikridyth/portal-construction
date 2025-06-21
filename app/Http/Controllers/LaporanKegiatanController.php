<?php

namespace App\Http\Controllers;

use App\DataTables\LaporanKegiatanDataTable;
use App\Helpers\AuthHelper;
use App\Models\DetailPekerjaan;
use App\Models\LaporanKegiatan;
use App\Models\Proyek;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LaporanKegiatanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(LaporanKegiatanDataTable $dataTable)
    {
        $pageHeader = 'Index Laporan Kegiatan';
        $pageTitle = 'List Laporan Kegiatan';
        $auth_user = AuthHelper::authSession();
        $assets = ['data-table'];
        $headerAction = '<a href="' . route('laporan-kegiatan.create') . '" class="btn btn-sm btn-primary" role="button">Tambah Laporan</a>';
        return $dataTable->render('app.proses.laporan-kegiatan.index', compact('pageHeader', 'pageTitle', 'auth_user', 'assets', 'headerAction'));
    }

    public function getDetailPekerjaan($id)
    {
        $data = DetailPekerjaan::with('pekerjaan')->where('id_proyek', $id)->orderBy('id_pekerjaan', 'asc')->get();
        $dataBulanan = LaporanKegiatan::where('id_proyek', $id)->orderBy('created_at', 'desc')->first();

        // Decode list_pekerjaan menjadi array keyed by id_detail_pekerjaan
        $progressData = [];
        if ($dataBulanan && $dataBulanan->list_pekerjaan) {
            foreach (json_decode($dataBulanan->list_pekerjaan, true) as $row) {
                $progressData[$row['id_detail_pekerjaan']] = $row['progress_total'];
            }
        }

        return response()->json([
            'detail' => $data,
            'progress' => $progressData
        ]);
    }

    public function getBulanKe($id)
    {
        $data = 0;
        $dataBulanan = LaporanKegiatan::where('id_proyek', $id)->orderBy('created_at', 'desc')->first();
        if ($dataBulanan) {
            $data = $dataBulanan->bulan_ke;
        }
    
        return response()->json(['bulan_ke' => $data + 1 ?? 1]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pageHeader = 'Create Laporan Kegiatan';
        $dataProyek = Proyek::all()->filter(function ($proyek) {
            $totalBobot = DetailPekerjaan::where('id_proyek', $proyek->id)->sum('bobot');
            $sudahAdaLaporan = LaporanKegiatan::where('id_proyek', $proyek->id)->where('realisasi', '>=', 100)->exists();
            return $totalBobot == 100 && !$sudahAdaLaporan;
        });

        return view('app.proses.laporan-kegiatan.form', compact('pageHeader', 'dataProyek'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $dIdProyek = array_values($request->input('detail_id_proyek'));
        $dIdPekerjaan = array_values($request->input('detail_id_pekerjaan'));
        $dIdDetailPekerjaan = array_values($request->input('detail_id_detail_pekerjaan'));
        $dNamaPekerjaan = array_values($request->input('detail_nama_pekerjaan'));
        $dVolume = array_values($request->input('detail_volume'));
        $dSatuan = array_values($request->input('detail_satuan'));
        $dBobot = array_values($request->input('detail_bobot'));
        $dProgress = array_values($request->input('detail_progress'));
        
        $getDataBulanan = [];
        $countBobot = 0;
        for ($i = 0; $i < count($dIdProyek); $i++) {
            $idDetail = $dIdDetailPekerjaan[$i];
            $bobotMingguIni = ($dBobot[$i] * $dProgress[$i]) / 100;

            $getDataBulanan[] = [
                'id_proyek' => $dIdProyek[$i],
                'id_pekerjaan' => $dIdPekerjaan[$i],
                'id_detail_pekerjaan' => $idDetail,
                'nama_pekerjaan' => $dNamaPekerjaan[$i],
                'volume' => $dVolume[$i],
                'satuan' => $dSatuan[$i],
                'bobot' => $dBobot[$i],
                'progress_total' => $dProgress[$i],
                'bobot_total' => number_format($bobotMingguIni, 2),
            ];
            $countBobot += $bobotMingguIni;
        }

        $data = [
            'id_proyek' => $request->id_proyek,
            'bulan_ke' => $request->bulan_ke,
            'dari' => $request->dari,
            'sampai' => $request->sampai,
            'rencana' => number_format($request->rencana, 2),
            'realisasi' => number_format($countBobot, 2),
            'kemajuan' => number_format($countBobot - $request->rencana, 2),
            'list_pekerjaan' => json_encode($getDataBulanan) ?? null,
            'situasi_pekerjaan' => $request->situasi_pekerjaan,
            'permasalahan' => $request->permasalahan,
            'created_by' => auth()->user()->id,
            'updated_by' => auth()->user()->id,
        ];
        // dd($data);
        LaporanKegiatan::create($data);

        return redirect()->route('laporan-kegiatan.index')->withSuccess(__('Tambah Laporan Kegiatan Berhasil', ['name' => __('laporan-kegiatan.store')]));
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

    public function printKegiatan($id)
    {
        $id = dekrip($id);
        $data = LaporanKegiatan::findOrFail($id);
        $dataPekerjaan = DetailPekerjaan::where('id_proyek', $data->id_proyek)->orderBy('id_pekerjaan', 'asc')->get();
        $dataPekerjaanById = $dataPekerjaan->groupBy('id_pekerjaan');
        $mulai = Carbon::parse($data->proyek->dari);
        $dari = Carbon::parse($data->dari);
        $sampai = Carbon::parse($data->sampai);
        $range = $dari->format('d') . ' S/D ' . $sampai->format('d F Y');
        $proyekDari = Carbon::parse($data->proyek->dari);
        $proyekSampai = Carbon::parse($data->proyek->sampai);
        $proyekRange = $proyekDari->format('d') . ' S/D ' . $proyekSampai->format('d F Y');
        $waktu = $dari->diffInDays($sampai);

        return view('app.proses.laporan-kegiatan.print', compact('data', 'mulai', 'range', 'proyekRange', 'waktu', 'sampai', 'dataPekerjaanById'));
    }
}
