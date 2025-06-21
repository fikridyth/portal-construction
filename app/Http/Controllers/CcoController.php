<?php

namespace App\Http\Controllers;

use App\Models\Cco;
use App\Models\DetailPekerjaan;
use App\Models\Proyek;
use Illuminate\Http\Request;

class CcoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexCcoPekerjaan($id)
    {
        $data = Cco::where('id_proyek', $id)->orderBy('created_at', 'asc')->get();
        $nomor = 1;

        return datatables()
            ->of($data)
            ->addColumn('no', function () use (&$nomor) {
                return $nomor++;
            })
            ->addColumn('action', function ($row) {
                return '<div class="text-center">
                        <a href="' . route('cco-pekerjaan.edit', enkrip($row->id)) . '" 
                            class="btn btn-xs btn-warning" role="button">
                            <i class="fas fa-edit"></i>
                        </a>
                    </div>';
            })
            ->addColumn('nama', function ($row) {
                return $row->nama;
            })
            ->addColumn('volume', function ($row) {
                return $row->volume;
            })
            ->addColumn('harga', function ($row) {
                return '<div class="text-end">' . ($row->harga == null ? '-' : number_format($row->harga, 2)) . '</div>';
            })
            ->addColumn('total_harga', function ($row) {
                return '<div class="text-end">' . ($row->harga == null ? '-' : number_format($row->harga * $row->volume, 2)) . '</div>';
            })
            ->rawColumns(['action', 'no', 'harga', 'total_harga'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createCcoPekerjaan($idProyek)
    {
        $idProyek = dekrip($idProyek);
        $pageHeader = 'Create CCO Pekerjaan';
        $dataProyek = Proyek::findOrFail($idProyek);

        return view('app.proses.cco-pekerjaan.form', compact('pageHeader', 'dataProyek'));
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
            'nama' => $request->nama,
            'volume' => $request->volume,
            'harga' => $request->harga ?? null,
            'created_by' => auth()->user()->id,
            'updated_by' => auth()->user()->id,
        ];
        Cco::create($data);

        return redirect()->route('proyek.show', enkrip($request->id_proyek))->withSuccess(__('Tambah CCO Pekerjaan Berhasil', ['name' => __('cco-pekerjaan.store')]));
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
        $pageHeader = 'Create CCO Pekerjaan';
        $data = Cco::findOrFail($id);

        return view('app.proses.cco-pekerjaan.form', compact('pageHeader', 'data', 'id'));
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
        $dataCco = Cco::findOrFail($id);

        $data = [
            'id_proyek' => $request->id_proyek,
            'nama' => $request->nama,
            'volume' => $request->volume,
            'harga' => $request->harga ?? null,
            'updated_by' => auth()->user()->id,
        ];
        $dataCco->update($data);

        return redirect()->route('proyek.show', enkrip($request->id_proyek))->withSuccess(__('Ubah CCO Pekerjaan Berhasil', ['name' => __('cco-pekerjaan.update')]));
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

    public function printCcoPekerjaan($id)
    {
        $id = dekrip($id);
        $pageHeader = 'Print Rencana Anggaran Biaya dengan CCO';
        $dataProyek = Proyek::findOrFail($id);
        $dataPekerjaan = DetailPekerjaan::where('id_proyek', $dataProyek->id)->orderBy('id_pekerjaan', 'asc')->get();
        $dataPekerjaanById = $dataPekerjaan->groupBy('id_pekerjaan');
        $dataCco = Cco::where('id_proyek', $dataProyek->id)->get();
        // dd($dataPekerjaanById);

        return view('app.proses.proyek.print-cco', compact('pageHeader', 'dataProyek', 'dataPekerjaan', 'dataPekerjaanById', 'dataCco'));
    }
}
