<?php

namespace App\Http\Controllers;

use App\DataTables\DokumentasiMingguanDataTable;
use App\Helpers\AuthHelper;
use App\Models\DetailPekerjaan;
use App\Models\DokumentasiMingguan;
use App\Models\LaporanMingguan;
use App\Models\Proyek;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

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
        $data = null;
        $dataDari = now()->format('Y-m-d');
        $dataSampai = now()->format('Y-m-d');

        $dataDok = DokumentasiMingguan::where('id_proyek', $id)->orderBy('created_at', 'desc')->first();
        if ($dataDok) {
            $dataLap = LaporanMingguan::where('id_proyek', $id)->where('minggu_ke', $dataDok->minggu_ke)->first();
        } else {
            $dataLap = LaporanMingguan::where('id_proyek', $id)->orderBy('created_at', 'asc')->first();
        }

        $dataMingguan = DokumentasiMingguan::where('id_laporan_mingguan', $dataLap->id)->orderBy('created_at', 'desc')->first();
        if ($dataMingguan) {
            $dataDate = LaporanMingguan::where('id_proyek', $id)->where('minggu_ke', $dataMingguan->minggu_ke + 1)->first();
        }
        if (isset($dataDate)) {
            $data = $dataMingguan->minggu_ke + 1;
            $dataDari = $dataDate->dari;
            $dataSampai = $dataDate->sampai;
        } else {
            $dataDari = null;
            $dataSampai = null;
        }
    
        return response()->json([
            'minggu_ke' => $data,
            'dari' => $dataDari,
            'sampai' => $dataSampai
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
        $dataProyek = Proyek::all()->filter(function ($proyek) {
            $totalBobot = DetailPekerjaan::where('id_proyek', $proyek->id)->sum('bobot');
            $sudahAdaLaporan = DokumentasiMingguan::where('id_proyek', $proyek->id)->where('bobot_total', '>=', 100)->exists();
            // Hanya ambil proyek yang total bobotnya 100 DAN BELUM punya laporan
            return $totalBobot == 100 && !$sudahAdaLaporan;
        });

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
        $getDataLap = LaporanMingguan::where('id_proyek', $request->id_proyek)->where('minggu_ke', $request->minggu_ke)->first();
        // dd($getDataLap, $request->all());

        $listGambar = [];
        if ($request->hasFile('file')) {
            foreach ($request->file('file') as $index => $file) {
                $namaFile = Str::random(20) . '.' . $file->getClientOriginalExtension();
                $file->storeAs('public/dokumentasi', $namaFile);

                $listGambar[] = [
                    'file' => 'dokumentasi/' . $namaFile,
                    'keterangan' => $request->keterangan[$index] ?? ''
                ];
            }
        }

        if ($getDataLap == null) {
            return redirect()->back()->withInput()->withErrors(['Peringatan' => 'Input Laporan Mingguan Proyek Minggu Ini Terlebih Dulu.']);
        }

        $data = [
            'id_proyek' => $request->id_proyek,
            'id_laporan_mingguan' => $getDataLap->id,
            'minggu_ke' => $request->minggu_ke,
            'dari' => $request->dari,
            'sampai' => $request->sampai,
            'bobot_total' => $getDataLap->bobot_total,
            'list_gambar' => json_encode($listGambar),
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
        $id = dekrip($id);
        $data = DokumentasiMingguan::findOrFail($id);
        $listGambar = json_decode($data->list_gambar, true);

        $dari = Carbon::parse($data->dari);
        $sampai = Carbon::parse($data->sampai);
        $range = $dari->format('d') . ' - ' . $sampai->format('d F Y');

        return view('app.proses.dokumentasi-mingguan.print', compact('data', 'listGambar', 'range'));
    }
}
