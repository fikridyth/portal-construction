<?php

namespace App\Http\Controllers;

use App\Models\DetailPekerjaan;
use App\Models\Pekerjaan;
use App\Models\Proyek;
use Illuminate\Http\Request;

class DetailPekerjaanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexDetailPekerjaan($id)
    {
        $query = DetailPekerjaan::all();

        return datatables()
            ->eloquent($query)
            ->addIndexColumn()
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createDetailPekerjaan($idProyek)
    {
        $pageHeader = 'Create Detail Pekerjaan';
        $dataProyek = Proyek::findOrFail($idProyek);
        $dataPekerjaan = Pekerjaan::all();

        return view('app.proses.detail-pekerjaan.form', compact('pageHeader', 'dataProyek', 'dataPekerjaan'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = [
            'id_proyek' => $request->id_proyek,
            'id_pekerjaan' => $request->id_pekerjaan,
            'nama' => $request->nama,
            'volume' => $request->volume,
            'satuan' => $request->satuan,
            'harga_modal_material' => $request->harga_modal_material ?? null,
            'harga_modal_upah' => $request->harga_modal_upah ?? null,
            'harga_jual_satuan' => $request->harga_jual_satuan ?? null,
            'harga_jual_total' => $request->harga_jual_satuan * $request->volume ?? null,
            'is_bahan' => $request->is_bahan ?? false,
            'created_by' => auth()->user()->id,
            'updated_by' => auth()->user()->id,
        ];
        DetailPekerjaan::create($data);

        return redirect()->route('proyek.show', $request->id_proyek)->withSuccess(__('Tambah Detail Pekerjaan Berhasil', ['name' => __('detail-pekerjaan.store')]));
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
        $pageHeader = 'Ubah DetailPekerjaan';
        $data = DetailPekerjaan::findOrFail($id);

        return view('app.proses.detail-pekerjaan.form', compact('pageHeader', 'data', 'id'));
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
        $dataDetailPekerjaan = DetailPekerjaan::findOrFail($id);
        $data = [
            'id_proyek' => $request->id_proyek,
            'id_pekerjaan' => $request->id_pekerjaan,
            'nama' => $request->nama,
            'volume' => $request->volume,
            'satuan' => $request->satuan,
            'harga_modal_material' => $request->harga_modal_material ?? null,
            'harga_modal_upah' => $request->harga_modal_upah ?? null,
            'harga_jual_satuan' => $request->harga_jual_satuan ?? null,
            'harga_jual_total' => $request->harga_jual_satuan * $request->volume ?? null,
            'is_bahan' => $request->is_bahan ?? false,
            'created_by' => auth()->user()->id,
            'updated_by' => auth()->user()->id,
        ];
        $dataDetailPekerjaan->update($data);

        return redirect()->route('proyek.show', $request->id_proyek)->withSuccess(__('Update Detail Pekerjaan Berhasil', ['name' => __('detail-pekerjaan.update')]));
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
