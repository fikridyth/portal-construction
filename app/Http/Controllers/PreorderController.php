<?php

namespace App\Http\Controllers;

use App\DataTables\PreorderDataTable;
use App\Helpers\AuthHelper;
use App\Models\DetailPekerjaan;
use App\Models\LaporanMingguan;
use App\Models\Preorder;
use App\Models\Proyek;
use Illuminate\Http\Request;

class PreorderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(PreorderDataTable $dataTable)
    {
        $pageHeader = 'Index Preorder';
        $pageTitle = 'List Preorder';
        $auth_user = AuthHelper::authSession();
        $assets = ['data-table'];
        $headerAction = '<a href="' . route('preorder.create') . '" class="btn btn-sm btn-primary" role="button">Tambah Preorder</a>';
        return $dataTable->render('app.purchase.preorder.index', compact('pageHeader', 'pageTitle', 'auth_user', 'assets', 'headerAction'));
    }

    public function getMingguKe($id)
    {
        $data = 1;
        $dataDari = now()->format('Y-m-d');
        $dataSampai = now()->format('Y-m-d');

        $dataDok = Preorder::where('id_proyek', $id)->orderBy('created_at', 'desc')->first();
        if ($dataDok) {
            $dataLap = LaporanMingguan::where('id_proyek', $id)->where('minggu_ke', $dataDok->minggu_ke)->first();
        } else {
            $dataLap = LaporanMingguan::where('id_proyek', $id)->orderBy('created_at', 'asc')->first();
        }

        $dataMingguan = Preorder::where('id_laporan_mingguan', $dataLap->id)->orderBy('created_at', 'desc')->first();
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
        $pageHeader = 'Create Dokumentasi Mingguan';
        $dataProyek = Proyek::all()->filter(function ($proyek) {
            $totalBobot = DetailPekerjaan::where('id_proyek', $proyek->id)->sum('bobot');
            $sudahAdaLaporan = Preorder::where('id_proyek', $proyek->id)->where('bobot_total', '>=', 100)->exists();
            // Hanya ambil proyek yang total bobotnya 100 DAN BELUM punya laporan
            return $totalBobot == 100 && !$sudahAdaLaporan;
        });
        $listPesanan = [
            ['nama' => '', 'volume' => '', 'satuan' => '', 'harga' => '']
        ];

        return view('app.purchase.preorder.form', compact('pageHeader', 'dataProyek', 'listPesanan'));
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

        // get nomor po
        $sequence = '0001';
        $dateNow = now()->format('ym');
        $getLastPo = Preorder::max("no_po");
        if ($getLastPo) {
            $explodeLastPo = explode('-', $getLastPo);
            if ($explodeLastPo[1] == $dateNow) {
                $sequence = (int) $explodeLastPo[2] + 1;
            } else {
                (int) $sequence;
            }
        } else {
            (int) $sequence;
        }
        $getNomorPo = 'PO-' . $dateNow . '-' . str_pad($sequence, 4, 0, STR_PAD_LEFT);

        // list pesanan
        $preoderInput = $request->input('preorder');
        $preorderResult = [];
        $totalHarga = 0;
        foreach ($preoderInput   as $item) {
            $preorderResult[] = [
                "nama" => $item['nama'],
                "volume" => $item['volume'],
                "satuan" => $item['satuan'],
                "harga" => $item['harga'],
                "total" => $item['harga'] * $item['volume']
            ];
            $totalHarga += $item['harga'] * $item['volume'];
        }

        $data = [
            'id_proyek' => $request->id_proyek,
            'id_laporan_mingguan' => $getDataLap->id,
            'minggu_ke' => $request->minggu_ke,
            'dari' => $request->dari,
            'sampai' => $request->sampai,
            'bobot_total' => $getDataLap->bobot_total,
            'no_po' => $getNomorPo,
            'list_pesanan' => json_encode($preorderResult),
            'total' => $totalHarga,
            'status' => 1,
            'created_by' => auth()->user()->id,
            'updated_by' => auth()->user()->id,
        ];
        Preorder::create($data);

        return redirect()->route('preorder.index')->withSuccess(__('Tambah Preorder Berhasil', ['name' => __('preorder.store')]));
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
        $pageHeader = 'Create Dokumentasi Mingguan';
        $data = Preorder::findOrFail($id);
        $listPesanan = json_decode($data->list_pesanan, true);

        return view('app.purchase.preorder.form', compact('id', 'pageHeader', 'data', 'listPesanan'));
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
        // list pesanan
        $preoderInput = $request->input('preorder');
        $preorderResult = [];
        $totalHarga = 0;
        foreach ($preoderInput   as $item) {
            $preorderResult[] = [
                "nama" => $item['nama'],
                "volume" => $item['volume'],
                "satuan" => $item['satuan'],
                "harga" => $item['harga'],
                "total" => $item['harga'] * $item['volume']
            ];
            $totalHarga += $item['harga'] * $item['volume'];
        }

        $preorder = Preorder::findOrFail($id);
        $data = [
            'id_proyek' => $preorder->id_proyek,
            'id_laporan_mingguan' => $preorder->id_laporan_mingguan,
            'minggu_ke' => $preorder->minggu_ke,
            'dari' => $preorder->dari,
            'sampai' => $preorder->sampai,
            'bobot_total' => $preorder->bobot_total,
            'no_po' => $preorder->no_po,
            'list_pesanan' => json_encode($preorderResult),
            'total' => $totalHarga,
            'status' => 1,
            'updated_by' => auth()->user()->id,
        ];
        $preorder->update($data);

        return redirect()->route('preorder.index')->withSuccess(__('Ubah Preorder Berhasil', ['name' => __('preorder.update')]));
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

    public function printPreorder($id)
    {
        $data = Preorder::findOrFail($id);
        $listPesanan = json_decode($data->list_pesanan, true);

        $dari = Carbon::parse($data->dari);
        $sampai = Carbon::parse($data->sampai);
        $range = $dari->format('d') . ' - ' . $sampai->format('d F Y');

        return view('app.purchase.preorder.print', compact('data', 'listPesanan', 'range'));
    }
}
