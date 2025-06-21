<?php

namespace App\Http\Controllers;

use App\DataTables\LaporanKomparasiDataTable;
use App\Helpers\AuthHelper;
use App\Models\LaporanKomparasi;
use App\Models\Preorder;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LaporanKomparasiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(LaporanKomparasiDataTable $dataTable)
    {
        $pageHeader = 'Index Laporan Komparasi';
        $pageTitle = 'List Laporan Komparasi';
        $auth_user = AuthHelper::authSession();
        $assets = ['data-table'];
        $headerAction = '<a href="' . route('laporan-komparasi.create') . '" class="btn btn-sm btn-primary" role="button">Tambah Laporan</a>';
        return $dataTable->render('app.proses.laporan-komparasi.index', compact('pageHeader', 'pageTitle', 'auth_user', 'assets', 'headerAction'));
    }

    public function getDetailBahan($id)
    {
        $dataKomparasi = LaporanKomparasi::where('id_preorder', $id)->orderBy('created_at', 'desc')->first();
        if (!$dataKomparasi) {
            $dataKomparasi = Preorder::find($id);
        }

        return response()->json([
            'detail' => $dataKomparasi->list_pesanan,
            // 'progress' => $progressData
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pageHeader = 'Create Laporan Komparasi';
        $dataProyek = Preorder::where('status', 4)->get()->filter(function ($preorder) {
            $sudahAdaLaporan = LaporanKomparasi::where('id_preorder', $preorder->id)->where('total_progress', '>=', 100)->exists();
            // Hanya ambil preorder yang total bobotnya 100 DAN BELUM punya laporan
            return !$sudahAdaLaporan;
        });
        return view('app.proses.laporan-komparasi.form', compact('pageHeader', 'dataProyek'));
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
        $dNama = array_values($request->input('nama'));
        $dSatuan = array_values($request->input('satuan'));
        $dVolume = array_values($request->input('volume'));
        $dPrevProgress = array_values($request->input('previous_progress'));
        $dProgress = array_values($request->input('detail_progress'));
        foreach ($dProgress as $index => $value) {
            $progressBaru = (float) $value;
            $progressLama = (float) ($dPrevProgress[$index] ?? 0);
            $volume = (float) ($dVolume[$index] ?? 0);
        
            if ($progressBaru > $volume) {
                return redirect()->back()
                    ->withInput()
                    ->withErrors(['detail_progress.' . $index => 'Progress penggunaan tidak boleh lebih besar dari volume.']);
            }
        
            if ($progressBaru < $progressLama) {
                return redirect()->back()
                    ->withInput()
                    ->withErrors(['detail_progress.' . $index => 'Progress penggunaan harus lebih besar dari progress sebelumnya.']);
            }
        }

        $getDataKomparasi = [];
        $totalPreviousBobot = 0;
        $totalNowBobot = 0;
        $count = count($dNama);
        for ($i = 0; $i < count($dNama); $i++) {
            $volume = floatval($dVolume[$i]);
            $prevProgress = floatval($dPrevProgress[$i]);
            $progress = floatval($dProgress[$i]);

            $previousBobot = 0;
            if ($prevProgress > 0) {
                $previousBobot = ($prevProgress / $volume) * 100;
            }

            $nowBobot = 0;
            if ($progress > 0) {
                $nowBobot = ($progress / $volume) * 100;
            }

            $totalPreviousBobot += $previousBobot;
            $totalNowBobot += $nowBobot;

            $getDataKomparasi[] = [
                'nama' => $dNama[$i],
                'volume' => $dVolume[$i],
                'satuan' => $dSatuan[$i],
                'previous_progress' => $dPrevProgress[$i],
                'previous_bobot' => number_format($previousBobot, 2),
                'progress' => $dProgress[$i],
                'bobot' => number_format($nowBobot, 2),
            ];
        }

        // Hitung rata-rata (dibagi jumlah data)
        $averagePrevious = $count > 0 ? $totalPreviousBobot / $count : 0;
        $averageNow = $count > 0 ? $totalNowBobot / $count : 0;

        $data = [
            'id_preorder' => $request->id_proyek,
            'dari' => $request->dari,
            'sampai' => $request->sampai,
            'list_pesanan' => json_encode($getDataKomparasi) ?? null,
            'total_previous' => number_format($averagePrevious, 2),
            'total_progress' => number_format($averageNow, 2),
            'created_by' => auth()->user()->id,
            'updated_by' => auth()->user()->id,
        ];
        // dd($data);
        LaporanKomparasi::create($data);

        return redirect()->route('laporan-komparasi.index')->withSuccess(__('Tambah Laporan Komparasi Berhasil', ['name' => __('laporan-komparasi.store')]));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $id = dekrip($id);
        $pageHeader = 'Show Laporan Komparasi';
        $data = LaporanKomparasi::findOrFail($id);
        $listPesanan = json_decode($data->list_pesanan, true);

        $dari = Carbon::parse($data->dari);
        $sampai = Carbon::parse($data->sampai);
        $masaPelaksanaan = $dari->format('d') . ' S/D ' . $sampai->format('d F Y');

        return view('app.proses.laporan-komparasi.show', compact('id', 'pageHeader', 'data', 'listPesanan', 'masaPelaksanaan'));
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

    public function printLaporanKomparasi($id)
    {
        $id = dekrip($id);
        $pageHeader = 'Print Laporan Komparasi';
        $data = LaporanKomparasi::findOrFail($id);
        $listPesanan = json_decode($data->list_pesanan, true);

        $dari = Carbon::parse($data->dari);
        $sampai = Carbon::parse($data->sampai);
        $masaPelaksanaan = $dari->format('d') . ' S/D ' . $sampai->format('d F Y');

        return view('app.proses.laporan-komparasi.print', compact('pageHeader', 'data', 'listPesanan', 'masaPelaksanaan'));
    }
}
