<?php

namespace App\DataTables;

use App\Models\DokumentasiMingguan;
use Carbon\Carbon;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class DokumentasiMingguanDataTable extends DataTable
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
            ->eloquent($query)
            ->addIndexColumn()
            ->addColumn('nama_proyek', function ($query) {
                return $query->laporanMingguan->proyek->nama ?? '-';
            })
            ->addColumn('pelaksana_proyek', function ($query) {
                return $query->laporanMingguan->proyek->pelaksana ?? '-';
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
            ->addColumn('waktu_pelaksanaan', function ($query) {
                return $query->laporanMingguan->proyek->waktu_pelaksanaan . ' Hari' ?? '-';
            })
            ->addColumn('action', 'app.proses.dokumentasi-mingguan.action')
            ->rawColumns(['action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\DokumentasiMingguan $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(DokumentasiMingguan $model)
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
            ['data' => 'pelaksana_proyek', 'name' => 'pelaksana_proyek', 'title' => 'Kontraktor', 'orderable' => false, 'className' => 'text-center'],
            ['data' => 'masa_pelaksanaan', 'name' => 'masa_pelaksanaan', 'title' => 'Masa Pelaksanaan', 'orderable' => false, 'className' => 'text-center'],
            ['data' => 'waktu_pelaksanaan', 'name' => 'waktu_pelaksanaan', 'title' => 'Waktu Pelaksanaan', 'orderable' => false, 'className' => 'text-center'],
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
        return 'DokumentasiMingguan_' . date('YmdHis');
    }
}
