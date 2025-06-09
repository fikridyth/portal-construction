<?php

namespace App\Http\Controllers;

use App\DataTables\ProyekDataTable;
use App\Helpers\AuthHelper;
use App\Models\DetailPekerjaan;
use App\Models\LaporanMingguan;
use App\Models\Proyek;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Validation\Rule;

class ProyekController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ProyekDataTable $dataTable)
    {
        $pageHeader = 'Index Proyek';
        $pageTitle = 'List Proyek';
        $auth_user = AuthHelper::authSession();
        $assets = ['data-table'];
        $headerAction = '<a href="' . route('proyek.create') . '" class="btn btn-sm btn-primary" role="button">Tambah Proyek</a>';
        return $dataTable->render('app.proses.proyek.index', compact('pageHeader', 'pageTitle', 'auth_user', 'assets', 'headerAction'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pageHeader = 'Create Proyek';
        return view('app.proses.proyek.form', compact('pageHeader'));
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
            'nama' => 'required|unique:proyeks,nama',
        ], [
            'nama.unique' => 'Nama proyek sudah digunakan!',
        ]);

        $dari = Carbon::parse($request->dari);
        $sampai = Carbon::parse($request->sampai);

        if ($dari->gt($sampai)) {
            return redirect()->back()->withInput()->withErrors(['Peringatan' => 'Tanggal mulai tidak boleh lebih besar dari tanggal akhir.']);
        }

        $data = [
            'nama' => $request->nama,
            'lokasi' => $request->lokasi,
            'tahun_anggaran' => $request->tahun_anggaran,
            'kontrak' => $request->kontrak,
            'pelaksana' => $request->pelaksana,
            'direktur' => $request->direktur,
            'dari' => $request->dari,
            'sampai' => $request->sampai,
            'waktu_pelaksanaan' => $dari->diffInDays($sampai),
            'total_meter' => $request->total_meter,
            'nilai_kontrak' => $request->nilai_kontrak,
            'created_by' => auth()->user()->id,
            'updated_by' => auth()->user()->id,
        ];
        Proyek::create($data);

        return redirect()->route('proyek.index')->withSuccess(__('Tambah Proyek Berhasil', ['name' => __('proyek.store')]));
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
        $pageHeader = 'Lihat Proyek';
        $data = Proyek::findOrFail($id);
        $dataLaporan = LaporanMingguan::where('id_proyek', $data->id)->exists();
        $dataPekerjaan = DetailPekerjaan::where('id_proyek', $data->id)->orderBy('id_pekerjaan', 'asc')->get();
        $totalBobot = $dataPekerjaan->sum('bobot');

        return view('app.proses.proyek.show', compact('pageHeader', 'data', 'assets', 'dataLaporan', 'totalBobot'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $pageHeader = 'Ubah Proyek';
        $data = Proyek::findOrFail($id);

        return view('app.proses.proyek.form', compact('pageHeader', 'data', 'id'));
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
        $dataProyek = Proyek::findOrFail($id);
        $request->validate([
            'nama' => [
                'required',
                Rule::unique('proyeks', 'nama')->ignore($dataProyek->id),
            ],
        ], [
            'nama.unique' => 'Nama proyek sudah digunakan!',
        ]);

        $dari = Carbon::parse($request->dari);
        $sampai = Carbon::parse($request->sampai);

        if ($dari->gt($sampai)) {
            return redirect()->back()->withInput()->withErrors(['Peringatan' => 'Tanggal mulai tidak boleh lebih besar dari tanggal akhir.']);
        }

        $data = [
            'nama' => $request->nama,
            'lokasi' => $request->lokasi,
            'tahun_anggaran' => $request->tahun_anggaran,
            'kontrak' => $request->kontrak,
            'pelaksana' => $request->pelaksana,
            'direktur' => $request->direktur,
            'dari' => $request->dari,
            'sampai' => $request->sampai,
            'waktu_pelaksanaan' => $dari->diffInDays($sampai),
            'total_meter' => $request->total_meter,
            'nilai_kontrak' => $request->nilai_kontrak,
            'updated_by' => auth()->user()->id,
        ];
        $dataProyek->update($data);

        return redirect()->route('proyek.index')->withSuccess(__('Ubah Data Proyek Berhasil', ['name' => __('proyek.update')]));
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
    
    public function printRab($id)
    {
        $pageHeader = 'Print Rencana Anggaran Biaya';
        $dataProyek = Proyek::findOrFail($id);
        $dataPekerjaan = DetailPekerjaan::where('id_proyek', $dataProyek->id)->orderBy('id_pekerjaan', 'asc')->get();
        $dataPekerjaanById = $dataPekerjaan->groupBy('id_pekerjaan');
        // dd($dataPekerjaanById);

        return view('app.proses.proyek.print-rab', compact('pageHeader', 'dataProyek', 'dataPekerjaan', 'dataPekerjaanById'));
    }
    
    public function printBoq($id)
    {
        $pageHeader = 'Print Bill of Quantity';
        $dataProyek = Proyek::findOrFail($id);
        $dataPekerjaan = DetailPekerjaan::where('id_proyek', $dataProyek->id)->orderBy('id_pekerjaan', 'asc')->get();
        $dataPekerjaanById = $dataPekerjaan->groupBy('id_pekerjaan');
        // dd($dataPekerjaanById);

        return view('app.proses.proyek.print-boq', compact('pageHeader', 'dataProyek', 'dataPekerjaan', 'dataPekerjaanById'));
    }
    
    public function printRekap($id)
    {
        $pageHeader = 'Print Rekapitulasi Biaya';
        $dataProyek = Proyek::findOrFail($id);
        $dataPekerjaan = DetailPekerjaan::where('id_proyek', $dataProyek->id)->orderBy('id_pekerjaan', 'asc')->get();
        $dataPekerjaanById = $dataPekerjaan->groupBy('id_pekerjaan');
        // dd($dataPekerjaanById);

        return view('app.proses.proyek.print-rekap', compact('pageHeader', 'dataProyek', 'dataPekerjaan', 'dataPekerjaanById'));
    }
}
