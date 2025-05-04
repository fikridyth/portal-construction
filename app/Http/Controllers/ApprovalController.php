<?php

namespace App\Http\Controllers;

use App\DataTables\ApprovalDataTable;
use App\Helpers\AuthHelper;
use App\Models\Preorder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApprovalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ApprovalDataTable $dataTable)
    {
        $pageHeader = 'Index Approval';
        $pageTitle = 'List Approval';
        $auth_user = AuthHelper::authSession();
        $assets = ['data-table'];
        return $dataTable->render('app.purchase.approval.index', compact('pageHeader', 'pageTitle', 'auth_user', 'assets'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        $id = dekrip($id);
        $pageHeader = 'Approval';
        $data = Preorder::findOrFail($id);
        $listPesanan = json_decode($data->list_pesanan, true);
        $userRole = Auth::user()->role->name;
        $dataType = [
            ['id' => 'Material', 'nama' => 'Material'],
            ['id' => 'Upah Borong Bangunan', 'nama' => 'Upah Borong Bangunan'],
            ['id' => 'Upah Borong Non Bangunan', 'nama' => 'Upah Borong Non Bangunan'],
            ['id' => 'Partisipasi', 'nama' => 'Partisipasi'],
            ['id' => 'Ongkos Kirim', 'nama' => 'Ongkos Kirim'],
            ['id' => 'Operasional Proyek', 'nama' => 'Operasional Proyek'],
            ['id' => 'Uang Makan Supervisor', 'nama' => 'Uang Makan Supervisor'],
            ['id' => 'Biaya Kendaraan', 'nama' => 'Biaya Kendaraan'],
            ['id' => 'Mobilisasi', 'nama' => 'Mobilisasi'],
            ['id' => 'Adm', 'nama' => 'Adm'],
        ];

        return view('app.purchase.approval.form', compact('id', 'pageHeader', 'data', 'listPesanan', 'userRole', 'dataType'));
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
        $preorder = Preorder::findOrFail($id);
        $userRole = Auth::user()->role->name;
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
                "type" => $item['type']
            ];
            $totalHarga += $item['harga'] * $item['volume'];
        }

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
            'updated_by' => auth()->id(),
        ];

        if ($request->aksi === 'approve' && $userRole == 'project_manager') {
            $data['approved_manager_by'] = auth()->id();
            $data['approved_manager_at'] = now();
            $data['status'] = 2;
        } else if ($request->aksi === 'reject' && $userRole == 'project_manager') {
            $data['approved_manager_by'] = auth()->id();
            $data['approved_manager_at'] = now();
            $data['status'] = 0;
        } else if ($request->aksi === 'approve' && $userRole == 'owner') {
            $data['approved_owner_by'] = auth()->id();
            $data['approved_owner_at'] = now();
            $data['status'] = 3;
        } else if ($request->aksi === 'reject' && $userRole == 'owner') {
            $data['approved_owner_by'] = auth()->id();
            $data['approved_owner_at'] = now();
            $data['status'] = 0;
        } else if ($request->aksi === 'approve' && $userRole == 'finance') {
            $data['approved_finance_by'] = auth()->id();
            $data['approved_finance_at'] = now();
            $data['status'] = 4;
        } else if ($request->aksi === 'reject' && $userRole == 'finance') {
            $data['approved_finance_by'] = auth()->id();
            $data['approved_finance_at'] = now();
            $data['status'] = 0;
        }
        $preorder->update($data);

        return redirect()->route('approval.index')->withSuccess(__('Updata Data Approval Berhasil', ['name' => __('approval.update')]));
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
}
