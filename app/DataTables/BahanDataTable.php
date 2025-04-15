<?php

namespace App\DataTables;

use App\Models\Bahan;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class BahanDataTable extends DataTable
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
            ->editColumn('harga_modal_material', function ($query) {
                return $query->harga_modal_material == null ? '-' : number_format($query->harga_modal_material);
            })
            ->editColumn('harga_modal_upah', function ($query) {
                return $query->harga_modal_upah == null ? '-' : number_format($query->harga_modal_upah);
            })
            ->addColumn('action', 'app.master.bahan.action')
            ->rawColumns(['action', 'status']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Bahan $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Bahan $model)
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
            ['data' => 'nama', 'name' => 'nama', 'title' => 'Nama', 'orderable' => false, 'className' => 'text-center', 'width' => 600],
            // ['data' => 'volume', 'name' => 'volume', 'title' => 'Volume', 'orderable' => false, 'className' => 'text-center'],
            ['data' => 'satuan', 'name' => 'satuan', 'title' => 'Satuan', 'orderable' => false, 'className' => 'text-center'],
            ['data' => 'harga_modal_material', 'name' => 'harga_modal_material', 'title' => 'Harga Modal Material', 'orderable' => false, 'className' => 'text-end'],
            ['data' => 'harga_modal_upah', 'name' => 'harga_modal_upah', 'title' => 'Harga Modal Upah', 'orderable' => false, 'className' => 'text-end'],
            // ['data' => 'harga_jual', 'name' => 'harga_jual', 'title' => 'Harga Jual', 'orderable' => false],
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Bahan_' . date('YmdHis');
    }
}
