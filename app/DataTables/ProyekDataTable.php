<?php

namespace App\DataTables;

use App\Models\DetailPekerjaan;
use App\Models\LaporanMingguan;
use App\Models\Proyek;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class ProyekDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query->orderBy('created_at', 'desc'))
            ->addIndexColumn()
            ->addColumn('bobot', function ($query) {
                $data = DetailPekerjaan::where('id_proyek', $query->id)->get();
                $totalBobot = $data->sum('bobot');
                return $totalBobot . '%' ?? '0%';
            })
            ->addColumn('progress', function ($query) {
                $proyek = Proyek::find($query->id);
                $getBobot = LaporanMingguan::where('id_proyek', $proyek->id)->orderBy('created_at', 'desc')->first();
                return $getBobot ? $getBobot->bobot_total . '%' : '0%';
            })
            ->addColumn('status', function ($query) {
                $proyek = Proyek::find($query->id);
                $sudahAdaLaporan = LaporanMingguan::where('id_proyek', $proyek->id)
                    ->where('bobot_total', '>=', 100)
                    ->exists();

                if ($sudahAdaLaporan) {
                    return '<span class="badge bg-success">Selesai</span>';
                } else {
                    return '<span class="badge bg-warning">Proses</span>';
                }
            })
            ->addColumn('action', 'app.proses.proyek.action')
            ->rawColumns(['action', 'status']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Proyek $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Proyek $model)
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('dataTable')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('<"row align-items-center"<"col-md-2" l><"col-md-6" B><"col-md-4"f>><"table-responsive my-3" rt><"row align-items-center" <"col-md-6" i><"col-md-6" p>><"clear">')

            ->parameters([
                "processing" => true,
                "autoWidth" => false,
                'buttons' => [
                    [
                        'extend' => 'excel',
                        'text' => 'Export Excel',
                        'className' => 'btn btn-success btn-sm mx-3' // Tambahkan class di sini
                    ],
                    [
                        'extend' => 'pdf',
                        'text' => 'Export PDF',
                        'className' => 'btn btn-danger btn-sm'
                    ],
                ],
            ]);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            ['data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'title' => 'No', 'orderable' => false, 'searchable' => false],
            ['data' => 'nama', 'name' => 'nama', 'title' => 'Nama', 'orderable' => false, 'className' => 'text-center'],
            ['data' => 'lokasi', 'name' => 'lokasi', 'title' => 'Lokasi', 'orderable' => false, 'className' => 'text-center'],
            ['data' => 'tahun_anggaran', 'name' => 'tahun_anggaran', 'title' => 'Tahun Anggaran', 'className' => 'text-center'],
            ['data' => 'kontrak', 'name' => 'kontrak', 'title' => 'kontrak', 'className' => 'text-center'],
            ['data' => 'pelaksana', 'name' => 'pelaksana', 'title' => 'pelaksana', 'className' => 'text-center'],
            ['data' => 'direktur', 'name' => 'direktur', 'title' => 'direktur', 'className' => 'text-center'],
            ['data' => 'dari', 'name' => 'dari', 'title' => 'dari', 'className' => 'text-center'],
            ['data' => 'sampai', 'name' => 'sampai', 'title' => 'sampai', 'className' => 'text-center'],
            ['data' => 'bobot', 'name' => 'bobot', 'title' => 'Bobot', 'orderable' => false, 'className' => 'text-center'],
            ['data' => 'progress', 'name' => 'progress', 'title' => 'progress', 'orderable' => false, 'className' => 'text-center'],
            ['data' => 'status', 'name' => 'status', 'title' => 'status', 'className' => 'text-center'],
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->searchable(false)
                ->width(60)
                ->addClass('text-center hide-search'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Proyek_' . date('YmdHis');
    }
}
