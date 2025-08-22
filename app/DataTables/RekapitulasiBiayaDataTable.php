<?php

namespace App\DataTables;

use App\Models\RekapitulasiBiaya;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class RekapitulasiBiayaDataTable extends DataTable
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
            ->editColumn('starting_balance', function ($query) {
                return number_format($query->starting_balance, 2);
            })
            ->editColumn('credit', function ($query) {
                return number_format($query->credit, 2);
            })
            ->editColumn('debet', function ($query) {
                return number_format($query->debet, 2);
            })
            ->editColumn('ending_balance', function ($query) {
                return number_format($query->ending_balance, 2);
            })
            ->editColumn('tanggal', function ($query) {
                return \Carbon\Carbon::parse($query->tanggal)->locale('id')->translatedFormat('F Y');
            })
            ->addColumn('action', 'app.proses.rekapitulasi-biaya.action')
            ->rawColumns(['action', 'status']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\RekapitulasiBiaya $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(RekapitulasiBiaya $model)
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
            ['data' => 'tanggal', 'name' => 'tanggal', 'title' => 'Bulan', 'orderable' => false, 'className' => 'text-center'],
            ['data' => 'name', 'name' => 'name', 'title' => 'Nama', 'orderable' => false, 'className' => 'text-center'],
            ['data' => 'account', 'name' => 'account', 'title' => 'No Account', 'orderable' => false, 'className' => 'text-center'],
            ['data' => 'currency', 'name' => 'currency', 'title' => 'Satuan', 'orderable' => false, 'className' => 'text-center'],
            ['data' => 'starting_balance', 'name' => 'starting_balance', 'title' => 'Saldo Awal', 'orderable' => false, 'className' => 'text-center'],
            ['data' => 'credit', 'name' => 'credit', 'title' => 'Credit', 'orderable' => false, 'className' => 'text-center'],
            ['data' => 'debet', 'name' => 'debet', 'title' => 'Debet', 'orderable' => false, 'className' => 'text-center'],
            ['data' => 'ending_balance', 'name' => 'ending_balance', 'title' => 'Saldo Akhir', 'orderable' => false, 'className' => 'text-center'],
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
        return 'RekapitulasiBiaya_' . date('YmdHis');
    }
}
