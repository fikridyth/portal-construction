<?php

namespace App\DataTables;

use App\Models\LaporanKomparasi;
use Carbon\Carbon;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class LaporanKomparasiDataTable extends DataTable
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
            ->editColumn('id_preorder', function ($query) {
                return $query->preorder->proyek->nama . ' - Minggu Ke ' . $query->preorder->minggu_ke ;
            })
            ->addColumn('masa_pelaksanaan', function ($query) {
                $dari = Carbon::parse($query->dari);
                $sampai = Carbon::parse($query->sampai);

                // Jika bulan sama
                // if ($dari->format('F') === $sampai->format('F')) {
                //     return $dari->format('d') . '–' . $sampai->format('d F Y');
                // }

                // Jika bulan berbeda
                return $dari->format('d') . ' S/D ' . $sampai->format('d F Y');
            })
            ->editColumn('total_progress', function ($query) {
                return $query->total_progress . '%';
            })
            ->addColumn('action', 'app.proses.laporan-komparasi.action')
            ->rawColumns(['action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\LaporanKomparasi $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(LaporanKomparasi $model)
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
            ['data' => 'id_preorder', 'name' => 'id_preorder', 'title' => 'Data Preorder', 'orderable' => false, 'className' => 'text-center'],
            ['data' => 'masa_pelaksanaan', 'name' => 'masa_pelaksanaan', 'title' => 'Masa Pelaksanaan', 'orderable' => false, 'className' => 'text-center'],
            ['data' => 'total_progress', 'name' => 'total_progress', 'title' => 'Progress Penggunaan Bahan', 'className' => 'text-center'],
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
        return 'LaporanKomparasi_' . date('YmdHis');
    }
}
