<?php

namespace App\DataTables;

use App\Models\LaporanHarian;
use Carbon\Carbon;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class LaporanHarianDataTable extends DataTable
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
            ->addColumn('nama_proyek', function ($query) {
                return $query->proyek->nama ?? '-';
            })
            ->addColumn('lokasi_proyek', function ($query) {
                return $query->proyek->lokasi ?? '-';
            })
            ->addColumn('pelaksana_proyek', function ($query) {
                return $query->proyek->pelaksana ?? '-';
            })
            ->editColumn('tanggal', function ($query) {
                $tanggal = Carbon::parse($query->tanggal);
                return $tanggal->format('d F Y');
            })
            ->addColumn('action', 'app.proses.laporan-harian.action')
            ->rawColumns(['action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\LaporanHarian $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(LaporanHarian $model)
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
            ['data' => 'nama_proyek', 'name' => 'nama_proyek', 'title' => 'Proyek', 'orderable' => false, 'className' => 'text-center'],
            ['data' => 'lokasi_proyek', 'name' => 'lokasi_proyek', 'title' => 'Lokasi', 'orderable' => false, 'className' => 'text-center'],
            ['data' => 'pelaksana_proyek', 'name' => 'pelaksana_proyek', 'title' => 'Kontraktor', 'orderable' => false, 'className' => 'text-center'],
            ['data' => 'minggu_ke', 'name' => 'minggu_ke', 'title' => 'Minggu Ke', 'orderable' => false, 'className' => 'text-center'],
            ['data' => 'hari', 'name' => 'hari', 'title' => 'Hari', 'orderable' => false, 'className' => 'text-center'],
            ['data' => 'tanggal', 'name' => 'tanggal', 'title' => 'Tanggal', 'orderable' => false, 'className' => 'text-center'],
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
        return 'LaporanHarian_' . date('YmdHis');
    }
}
