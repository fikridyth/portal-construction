<?php

namespace App\Http\Controllers;

use App\Models\Bahan;
use App\Models\DetailPekerjaan;
use App\Models\LaporanMingguan;
use App\Models\Pekerjaan;
use App\Models\Proyek;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class DetailPekerjaanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexDetailPekerjaan($id)
    {
        $data = DetailPekerjaan::where('id_proyek', $id)->orderBy('id_pekerjaan', 'asc')->get();
        $nomor = 1;

        return datatables()
            ->of($data)
            ->addColumn('no', function () use (&$nomor) {
                return $nomor++;
            })
            ->addColumn('action', function ($row) {
                $data = LaporanMingguan::where('id_proyek', $row->id_proyek)->get();
                if ($data->count() > 0) {
                    return '<div class="text-center">
                        <button class="btn btn-xs btn-secondary" disabled>
                            <i class="fas fa-edit"></i>
                        </button>
                    </div>';
                } else {
                    return '<div class="text-center">
                        <a href="' . route('detail-pekerjaan.edit', enkrip($row->id)) . '" 
                            class="btn btn-xs btn-warning" role="button">
                            <i class="fas fa-edit"></i>
                        </a>
                    </div>';
                }
            })
            ->addColumn('nama_pekerjaan', function ($row) {
                return $row->pekerjaan->nama;
            })
            ->addColumn('nama', function ($row) {
                return $row->nama;
            })
            ->addColumn('volume', function ($row) {
                return $row->volume . ' ' . $row->satuan;
            })
            ->editColumn('bobot', function ($row) {
                return '<div class="text-end">' . ($row->bobot == null ? '-' : number_format($row->bobot, 2)) . '</div>';
            })
            ->addColumn('harga_modal_material', function ($row) {
                return '<div class="text-end">' . ($row->harga_modal_material == null ? '-' : number_format($row->harga_modal_material, 2)) . '</div>';
            })
            ->addColumn('harga_modal_upah', function ($row) {
                return '<div class="text-end">' . ($row->harga_modal_upah == null ? '-' : number_format($row->harga_modal_upah, 2)) . '</div>';
            })
            ->addColumn('harga_jual_satuan', function ($row) {
                return '<div class="text-end">' . ($row->harga_jual_satuan == null ? '-' : number_format($row->harga_jual_satuan, 2)) . '</div>';
            })
            ->addColumn('harga_jual_total', function ($row) {
                return '<div class="text-end">' . ($row->harga_jual_total == null ? '-' : number_format($row->harga_jual_total, 2)) . '</div>';
            })
            ->addColumn('is_bahan', function ($row) {
                return '<div class="text-center">' . (
                    $row->is_bahan == '0'
                        ? '-'
                        : '<button type="button" class="btn btn-sm btn-primary btn-show-modal"
                            data-id="' . $row->id . '"
                            data-nama="' . $row->nama . '"
                            data-detail="' . e($row->list_bahan) . '">
                            <i class="fas fa-eye"></i>
                        </button>'
                        ) . '</div>';
                    })
            ->rawColumns(['action', 'no', 'nama', 'bobot', 'harga_modal_material', 'harga_modal_upah', 'harga_jual_satuan', 'harga_jual_total', 'is_bahan'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createDetailPekerjaan($idProyek)
    {
        $idProyek = dekrip($idProyek);
        $pageHeader = 'Create Detail Pekerjaan';
        $dataProyek = Proyek::findOrFail($idProyek);
        $dataPekerjaan = Pekerjaan::all();
        $dataBahan = Bahan::all();

        return view('app.proses.detail-pekerjaan.form', compact('pageHeader', 'dataProyek', 'dataPekerjaan', 'dataBahan'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all(), isset($request->is_bahan));
        if ($request->harga_modal_upah == null && $request->harga_modal_material == null) {
            return redirect()->back()->withInput()->withErrors(['Peringatan' => 'Harga material dan upah tidak boleh kosong.']);
        }

        if ($request->harga_modal_upah !== null && $request->harga_modal_material !== null) {
            return redirect()->back()->withInput()->withErrors(['Peringatan' => 'Pilih 1 antara harga material dan upah.']);
        }

        if (isset($request->is_bahan)) {
            $isBahan = true;
            $idBahan = $request->input('id_bahan');
            $volumeBahan = $request->input('volume_bahan');
            $getReqBahan = [];
            for ($i = 0; $i < count($idBahan); $i++) {
                $getReqBahan[] = [
                    'id_bahan' => $idBahan[$i],
                    'volume' => $volumeBahan[$i],
                ];
            }

            $detailBahan = [];
            foreach ($getReqBahan as $detail) {
                $getBahan = Bahan::findOrFail((int)$detail['id_bahan']);
                $detailBahan[] = [
                    'id_bahan' => $getBahan->id,
                    'nama_bahan' => $getBahan->nama,
                    'volume' => $detail['volume'],
                    'satuan' => $getBahan->satuan,
                    'harga_modal_material' => $getBahan->harga_modal_material,
                    'harga_modal_upah' => $getBahan->harga_modal_upah,
                    'total' => $getBahan->harga_modal_material ? $getBahan->harga_modal_material * $detail['volume'] : $getBahan->harga_modal_upah * $detail['volume'],
                ];
            }
        } else {
            $isBahan = false;
            $detailBahan = [];
        }

        $data = [
            'id_proyek' => $request->id_proyek,
            'id_pekerjaan' => $request->id_pekerjaan,
            'nama' => $request->nama,
            'volume' => $request->volume,
            'satuan' => $request->satuan,
            'bobot' => $request->bobot,
            'harga_modal_material' => $request->harga_modal_material ?? null,
            'harga_modal_upah' => $request->harga_modal_upah ?? null,
            'harga_jual_satuan' => $request->harga_jual_satuan ?? null,
            'harga_jual_total' => $request->harga_jual_satuan * $request->volume ?? null,
            'is_bahan' => $isBahan,
            'list_bahan' => json_encode($detailBahan) ?? null,
            'created_by' => auth()->user()->id,
            'updated_by' => auth()->user()->id,
        ];
        DetailPekerjaan::create($data);

        return redirect()->route('proyek.show', enkrip($request->id_proyek))->withSuccess(__('Tambah Detail Pekerjaan Berhasil', ['name' => __('detail-pekerjaan.store')]));
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
        $pageHeader = 'Ubah DetailPekerjaan';
        $data = DetailPekerjaan::findOrFail($id);
        $dataPekerjaan = Pekerjaan::all();
        $dataBahan = Bahan::all();

        return view('app.proses.detail-pekerjaan.form', compact('pageHeader', 'data', 'id', 'dataPekerjaan', 'dataBahan'));
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
        // dd($request->all(), isset($request->is_bahan));
        $dataDetailPekerjaan = DetailPekerjaan::findOrFail($id);

        if (isset($request->is_bahan)) {
            $isBahan = true;
            $idBahan = $request->input('id_bahan');
            $volumeBahan = $request->input('volume_bahan');
            $getReqBahan = [];
            for ($i = 0; $i < count($idBahan); $i++) {
                $getReqBahan[] = [
                    'id_bahan' => $idBahan[$i],
                    'volume' => $volumeBahan[$i],
                ];
            }

            $detailBahan = [];
            foreach ($getReqBahan as $detail) {
                $getBahan = Bahan::findOrFail((int)$detail['id_bahan']);
                $detailBahan[] = [
                    'id_bahan' => $getBahan->id,
                    'nama_bahan' => $getBahan->nama,
                    'volume' => $detail['volume'],
                    'satuan' => $getBahan->satuan,
                    'harga_modal_material' => $getBahan->harga_modal_material,
                    'harga_modal_upah' => $getBahan->harga_modal_upah,
                    'total' => $getBahan->harga_modal_material ? $getBahan->harga_modal_material * $detail['volume'] : $getBahan->harga_modal_upah * $detail['volume'],
                ];
            }
        } else {
            $isBahan = false;
            $detailBahan = [];
        }

        $data = [
            'id_proyek' => $request->id_proyek,
            'id_pekerjaan' => $request->id_pekerjaan,
            'nama' => $request->nama,
            'volume' => $request->volume,
            'satuan' => $request->satuan,
            'bobot' => $request->bobot,
            'harga_modal_material' => $request->harga_modal_material ?? null,
            'harga_modal_upah' => $request->harga_modal_upah ?? null,
            'harga_jual_satuan' => $request->harga_jual_satuan ?? null,
            'harga_jual_total' => $request->harga_jual_satuan * $request->volume ?? null,
            'is_bahan' => $isBahan,
            'list_bahan' => json_encode($detailBahan) ?? null,
            'updated_by' => auth()->user()->id,
        ];
        $dataDetailPekerjaan->update($data);

        return redirect()->route('proyek.show', enkrip($request->id_proyek))->withSuccess(__('Update Detail Pekerjaan Berhasil', ['name' => __('detail-pekerjaan.update')]));
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
