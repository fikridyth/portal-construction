<?php

namespace App\DataTables;

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
            ->eloquent($query)
            ->addIndexColumn()
            ->addColumn('action', 'app.proses.proyek.action')
            ->rawColumns(['action']);
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
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->searchable(false)
                ->width(60)
                ->addClass('text-center hide-search'),
            ['data' => 'nama', 'name' => 'nama', 'title' => 'Nama', 'orderable' => false, 'className' => 'text-center'],
            ['data' => 'lokasi', 'name' => 'lokasi', 'title' => 'Lokasi', 'orderable' => false, 'className' => 'text-center'],
            ['data' => 'tahun_anggaran', 'name' => 'tahun_anggaran', 'title' => 'Tahun Anggaran', 'className' => 'text-center'],
            ['data' => 'kontrak', 'name' => 'kontrak', 'title' => 'kontrak', 'className' => 'text-center'],
            ['data' => 'pelaksana', 'name' => 'pelaksana', 'title' => 'pelaksana', 'className' => 'text-center'],
            ['data' => 'direktur', 'name' => 'direktur', 'title' => 'direktur', 'className' => 'text-center'],
            ['data' => 'dari', 'name' => 'dari', 'title' => 'dari', 'className' => 'text-center'],
            ['data' => 'sampai', 'name' => 'sampai', 'title' => 'sampai', 'className' => 'text-center'],
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
