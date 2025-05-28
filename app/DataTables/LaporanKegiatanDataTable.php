<?php

namespace App\DataTables;

use App\Models\LaporanKegiatan;
use Carbon\Carbon;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class LaporanKegiatanDataTable extends DataTable
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
            ->editColumn('id_proyek', function ($query) {
                return $query->proyek->nama ?? '-';
            })
            ->editColumn('realisasi', function ($query) {
                return $query->realisasi . ' %' ?? '-';
            })
            ->editColumn('rencana', function ($query) {
                return $query->rencana . ' %' ?? '-';
            })
            ->editColumn('kemajuan', function ($query) {
                return $query->kemajuan . ' %' ?? '-';
            })
            ->addColumn('masa_pelaksanaan', function ($query) {
                $dari = Carbon::parse($query->dari);
                $sampai = Carbon::parse($query->sampai);

                // Jika bulan sama
                // if ($dari->format('F') === $sampai->format('F')) {
                //     return $dari->format('d') . '–' . $sampai->format('d F Y');
                // }

                // Jika bulan berbeda
                return $dari->format('d') . ' - ' . $sampai->format('d F Y');
            })
            ->addColumn('action', 'app.proses.laporan-kegiatan.action')
            ->rawColumns(['action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\LaporanKegiatan $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(LaporanKegiatan $model)
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
            ['data' => 'id_proyek', 'name' => 'id_proyek', 'title' => 'Proyek', 'orderable' => false, 'className' => 'text-center'],
            ['data' => 'bulan_ke', 'name' => 'bulan_ke', 'title' => 'Bulan Ke', 'orderable' => false, 'className' => 'text-center'],
            ['data' => 'masa_pelaksanaan', 'name' => 'masa_pelaksanaan', 'title' => 'Masa Pelaksanaan', 'orderable' => false, 'className' => 'text-center'],
            ['data' => 'realisasi', 'name' => 'realisasi', 'title' => 'Realisasi', 'orderable' => false, 'className' => 'text-center'],
            ['data' => 'rencana', 'name' => 'rencana', 'title' => 'Rencana', 'orderable' => false, 'className' => 'text-center'],
            ['data' => 'kemajuan', 'name' => 'kemajuan', 'title' => 'Kemajuan', 'orderable' => false, 'className' => 'text-center'],
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
        return 'LaporanKegiatan_' . date('YmdHis');
    }
}
