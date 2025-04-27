<?php

namespace App\Http\Controllers;

use App\DataTables\LaporanHarianDataTable;
use App\Helpers\AuthHelper;
use App\Models\Bahan;
use App\Models\LaporanHarian;
use App\Models\Proyek;
use App\Models\TenagaKerja;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LaporanHarianController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(LaporanHarianDataTable $dataTable)
    {
        $pageHeader = 'Index Laporan Harian';
        $pageTitle = 'List Laporan Harian';
        $auth_user = AuthHelper::authSession();
        $assets = ['data-table'];
        $headerAction = '<a href="' . route('laporan-harian.create') . '" class="btn btn-sm btn-primary" role="button">Tambah Laporan</a>';
        return $dataTable->render('app.proses.laporan-harian.index', compact('pageHeader', 'pageTitle', 'auth_user', 'assets', 'headerAction'));
    }

    public function getDataProyek($id)
    {
        // ubah data hari dari static ke datatanggal, tanya chatgpt
        $data = 1;
        $dataHarian = LaporanHarian::where('id_proyek', $id)->orderBy('created_at', 'desc')->first();
        if ($dataHarian) {
            $dataTanggal = Carbon::parse($dataHarian->tanggal)->addDay()->toDateString();
            $dataHari = Carbon::parse($dataTanggal)->locale('id')->isoFormat('dddd');
            $data = $dataHarian->minggu_ke;
            if (strtolower($dataHari) == 'senin') {
                $data += 1;
            }
        } else {
            $dataProyek = Proyek::find($id);
            $dataTanggal = $dataProyek->dari;
            $dataHari = Carbon::parse($dataTanggal)->locale('id')->isoFormat('dddd');
        }
        return response()->json([
            'minggu_ke' => $data,
            'hari' => $dataHari ?? 'Senin',
            'tanggal' => $dataTanggal ?? now()->format('Y-m-d')
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pageHeader = 'Create Laporan Harian';
        $dataProyek = Proyek::all()->filter(function ($proyek) {
            $jumlahLaporan = LaporanHarian::where('id_proyek', $proyek->id)->count();
            return $jumlahLaporan < $proyek->waktu_pelaksanaan;
        });
        $dataTenaga = TenagaKerja::all();
        $dataBahan = Bahan::all();
        return view('app.proses.laporan-harian.form', compact('pageHeader', 'dataProyek', 'dataTenaga', 'dataBahan'));
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
        $tenagaInput = $request->input('tenaga');
        $idTs = [];
        foreach ($tenagaInput as $item) {
            $idTs[] = $item['keahlian'];
        }
        $idTs = array_filter($idTs);
        $tenagaKerjaData = TenagaKerja::whereIn('id', $idTs)->pluck('nama', 'id'); 
        $tenagaResult = [];
        foreach ($tenagaInput as $item) {
            $id = $item['keahlian'];
            if ($id) {
                $tenagaResult[] = [
                    'id' => $id,
                    'nama' => $tenagaKerjaData[$id],
                    'jumlah' => $item['jumlah'],
                ];
            }
        }

        $bahanInput = $request->input('bahan');
        $idBs = [];
        foreach ($bahanInput as $item) {
            $idBs[] = $item['bangunan'];
        }
        $idBs = array_filter($idBs);
        $bahanData = Bahan::whereIn('id', $idBs)->pluck('nama', 'id'); 
        $bahanResult = [];
        foreach ($bahanInput as $item) {
            $id = $item['bangunan'];
            if ($id) {
                $bahanResult[] = [
                    'id' => $id,
                    'nama' => $bahanData[$id],
                    'jumlah' => $item['jumlah'],
                ];
            }
        }
        // dd($tenagaResult, $bahanResult);

        $data = [
            'id_proyek' => $request->id_proyek,
            'minggu_ke' => $request->minggu_ke,
            'hari' => $request->hari,
            'tanggal' => $request->tanggal,
            'list_tenaga' => json_encode($tenagaResult) ?? null,
            'list_bahan' => json_encode($bahanResult) ?? null,
            'created_by' => auth()->user()->id,
            'updated_by' => auth()->user()->id,
        ];
        LaporanHarian::create($data);

        return redirect()->route('laporan-harian.index')->withSuccess(__('Tambah Laporan Harian Berhasil', ['name' => __('laporan-harian.store')]));
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

    public function printLaporanHarian($id)
    {
        $pageHeader = 'Print Laporan Harian';
        $data = LaporanHarian::findOrFail($id);
        $dataTanggal = Carbon::parse($data->tanggal)->locale('id')->isoFormat('DD MMMM YYYY');

        return view('app.proses.laporan-harian.print', compact('pageHeader', 'data', 'dataTanggal'));
    }
}
