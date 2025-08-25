<?php

namespace App\Http\Controllers;

use App\DataTables\PreorderDataTable;
use App\Helpers\AuthHelper;
use App\Models\DetailPekerjaan;
use App\Models\LaporanMingguan;
use App\Models\Preorder;
use App\Models\Proyek;
use App\Models\Supplier;
use App\Models\TipePembayaran;
use Carbon\Carbon;
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
        $headerAction = '<a href="' . route('preorder.create') . '" class="btn btn-primary" role="button">Tambah Preorder</a>';
        return $dataTable->render('app.purchase.preorder.index', compact('pageHeader', 'pageTitle', 'auth_user', 'assets', 'headerAction'));
    }

    public function getMingguKe($id)
    {
        $data = 1;
        $dataDari = now()->format('Y-m-d');
        $dataSampai = now()->format('Y-m-d');

        $dataDok = Preorder::where('id_proyek', $id)->where('status', 4)->orderBy('created_at', 'desc')->first();
        if ($dataDok) {
            $dataLap = LaporanMingguan::where('id_proyek', $id)->where('minggu_ke', $dataDok->minggu_ke)->first();
        } else {
            $dataLap = LaporanMingguan::where('id_proyek', $id)->orderBy('created_at', 'asc')->first();
        }

        $dataMingguan = Preorder::where('id_laporan_mingguan', $dataLap->id)->where('status', 4)->orderBy('created_at', 'desc')->first();
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
        $pageHeader = 'Create Preorder';
        $dataProyek = Proyek::all()->filter(function ($proyek) {
            $totalBobot = DetailPekerjaan::where('id_proyek', $proyek->id)->sum('bobot');
            $sudahAdaLaporan = Preorder::where('id_proyek', $proyek->id)->where('bobot_total', '>=', 100)->exists();
            return $totalBobot == 100 && !$sudahAdaLaporan;
        });
        $listPesanan = [
            ['nama' => '', 'volume' => '', 'satuan' => '', 'harga' => '']
        ];
        $dataType = TipePembayaran::all();
        $dataSupplier = Supplier::all();

        return view('app.purchase.preorder.form', compact('pageHeader', 'dataProyek', 'dataSupplier', 'listPesanan', 'dataType'));
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
        $getProyek = Proyek::find($request->id_proyek);
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

        $sequenceKode = 1;
        $dateNowKode = date('ym');
        $getBayar = TipePembayaran::find($request->id_tipe_pembayaran);
        $getLastKode = Preorder::where('kode_bayar', 'like', $getBayar->kode . '%')
            ->whereRaw("SUBSTRING(kode_bayar, 2, 4) = ?", [$dateNowKode]) // filter by year-month
            ->orderByDesc('kode_bayar')
            ->value('kode_bayar'); // Ambil 1 kode terakhir (terbesar)
        if ($getLastKode) {
            // Pisahkan bagian-bagian dari kode terakhir
            $lastKodePrefix = substr($getLastKode, 0, 1);         // A
            $lastKodeDate   = substr($getLastKode, 1, 4);         // 2508
            $lastKodeNumber = (int) substr($getLastKode, -3);     // 001 -> 1
        
            if ($getBayar->kode == $lastKodePrefix && $dateNowKode == $lastKodeDate) {
                $sequenceKode = $lastKodeNumber + 1;
            } else {
                $sequenceKode = 1; // Reset karena beda kode atau beda bulan
            }
        }
        $getNomorKode = $getBayar->kode . $dateNowKode . str_pad($sequenceKode, 3, 0, STR_PAD_LEFT);

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
                "total" => $item['harga'] * $item['volume'],
            ];
            $totalHarga += $item['harga'] * $item['volume'];
        }

        $data = [
            'id_proyek' => $getProyek->id,
            'id_supplier' => $request->id_supplier,
            'id_tipe_pembayaran' => $request->id_tipe_pembayaran,
            'id_manager' => $getProyek->manager->id,
            'id_finance' => $getProyek->purchasing->id,
            'id_laporan_mingguan' => null,
            'minggu_ke' => $request->minggu_ke,
            'dari' => $request->dari,
            'sampai' => $request->sampai,
            'bobot_total' => 0,
            'no_po' => $getNomorPo,
            'list_pesanan' => json_encode($preorderResult),
            'total' => $totalHarga,
            'status' => 1,
            'kode_bayar' => $getNomorKode,
            'created_by' => auth()->user()->id,
            'updated_by' => auth()->user()->id,
        ];
        Preorder::create($data);

        return redirect()->route('approval.index')->withSuccess(__('Tambah Preorder Berhasil', ['name' => __('preorder.store')]));
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
        $pageHeader = 'Show Preorder';
        $data = Preorder::findOrFail($id);
        $listPesanan = json_decode($data->list_pesanan, true);

        return view('app.purchase.preorder.show', compact('id', 'pageHeader', 'data', 'listPesanan'));
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

    public function printPreorder($id)
    {
        $id = dekrip($id);
        $data = Preorder::findOrFail($id);
        $listPesanan = json_decode($data->list_pesanan, true);
        $totalPerType = collect($listPesanan)->groupBy('type')->map(function ($items) {
            return $items->sum('total');
        });

        $now = Carbon::parse($data->created_at)->format('d F Y');
        $last = Carbon::parse($data->updated_at)->format('d/m/y');
        $dari = Carbon::parse($data->dari);
        $sampai = Carbon::parse($data->sampai);
        $range = $dari->format('d') . ' - ' . $sampai->format('d F Y');

        return view('app.purchase.preorder.print', compact('now', 'last', 'data', 'listPesanan', 'range', 'totalPerType'));
    }

    public function printSelectedPreorder(Request $request, $id)
    {
        $id = dekrip($id);
        $data = Preorder::findOrFail($id);
        $listPesanan = json_decode($data->list_pesanan, true);
        $selected = $request->input('selected', []);
        $filteredPesanan = [];
        foreach ($selected as $index) {
            if (isset($listPesanan[$index])) {
                $filteredPesanan[] = $listPesanan[$index];
            }
        }

        $now = Carbon::parse($data->created_at)->format('d F Y');
        $last = Carbon::parse($data->updated_at)->format('d/m/y');
        $dari = Carbon::parse($data->dari);
        $sampai = Carbon::parse($data->sampai);
        $range = $dari->format('d') . ' - ' . $sampai->format('d F Y');

        return view('app.purchase.preorder.print-selected', compact('now', 'last', 'data', 'range', 'filteredPesanan'));
    }
}
