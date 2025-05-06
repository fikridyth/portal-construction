<?php

namespace App\DataTables;

use App\Models\LaporanMingguan;
use Carbon\Carbon;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class LaporanMingguanDataTable extends DataTable
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
            ->editColumn('bobot_minggu_lalu', function ($query) {
                return $query->bobot_minggu_lalu ?? '-';
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
            ->addColumn('action', 'app.proses.laporan-mingguan.action')
            ->rawColumns(['action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\LaporanMingguan $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(LaporanMingguan $model)
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
            ['data' => 'minggu_ke', 'name' => 'minggu_ke', 'title' => 'Minggu Ke', 'orderable' => false, 'className' => 'text-center'],
            ['data' => 'masa_pelaksanaan', 'name' => 'masa_pelaksanaan', 'title' => 'Masa Pelaksanaan', 'orderable' => false, 'className' => 'text-center'],
            ['data' => 'bobot_rencana', 'name' => 'bobot_rencana', 'title' => 'Bobot Rencana', 'className' => 'text-center'],
            ['data' => 'bobot_minggu_lalu', 'name' => 'bobot_minggu_lalu', 'title' => 'Bobot Minggu Lalu', 'className' => 'text-center'],
            ['data' => 'bobot_minggu_ini', 'name' => 'bobot_minggu_ini', 'title' => 'Bobot Minggu Ini', 'className' => 'text-center'],
            ['data' => 'bobot_total', 'name' => 'bobot_total', 'title' => 'Bobot Total', 'className' => 'text-center'],
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
        return 'LaporanMingguan_' . date('YmdHis');
    }
}
