<?php

namespace App\DataTables;

use App\Models\Preorder;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class PaymentDataTable extends DataTable
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
            ->eloquent($query->Filter(request(['periode', 'status']))->orderBy('created_at', 'desc'))
            ->addIndexColumn()
            ->addColumn('nama_proyek', function ($query) {
                return $query->proyek->nama ?? '-';
            })
            ->addColumn('pelaksana_proyek', function ($query) {
                return $query->proyek->pelaksana ?? '-';
            })
            ->addColumn('masa_pelaksanaan', function ($query) {
                $dari = Carbon::parse($query->dari);
                $sampai = Carbon::parse($query->sampai);

                return $dari->format('d') . ' S/D ' . $sampai->format('d F Y');
            })
            ->editColumn('total', function ($query) {
                return number_format($query->total, 0);
            })
            ->editColumn('id_supplier', function ($query) {
                return $query->supplier->nama;
            })
            ->editColumn('id_manager', function ($query) {
                return $query->proyek->manager->first_name . ' ' . $query->proyek->manager->last_name;
            })
            ->editColumn('id_finance', function ($query) {
                return $query->proyek->purchasing->first_name . ' ' . $query->proyek->purchasing->last_name;
            })
            ->editColumn('status', function ($query) {
                switch ($query->status) {
                    case 3:
                        return '<span class="badge bg-warning">Menunggu Pembayaran</span>';
                    default:
                        return '<span class="badge bg-secondary">-</span>';
                }
            })
            ->editColumn('created_at', function ($query) {
                $tanggal = Carbon::parse($query->created_at);
                return $tanggal->format('d F Y');
            })
            ->addColumn('action', function ($query) {
                return view('app.purchase.payment.action', [
                    'id' => $query->id,
                    'status' => $query->status,
                    'userRole' => Auth::user()->role->name,
                ]);
            })
            ->rawColumns(['action', 'status']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Preorder $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Preorder $model)
    {
        if (Auth::user()->role->name == 'finance') {
            return $model->where('status',  3)->where('id_finance', Auth::user()->id)->newQuery();
        } else {
            return $model->where('created_by',  Auth::user()->id)->newQuery();
        }
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
            ['data' => 'minggu_ke', 'name' => 'minggu_ke', 'title' => 'Minggu Ke', 'orderable' => false, 'className' => 'text-center'],
            ['data' => 'masa_pelaksanaan', 'name' => 'masa_pelaksanaan', 'title' => 'Masa Pelaksanaan', 'orderable' => false, 'className' => 'text-center'],
            ['data' => 'no_po', 'name' => 'no_po', 'title' => 'Nomor PO', 'orderable' => false, 'className' => 'text-center'],
            ['data' => 'kode_bayar', 'name' => 'kode_bayar', 'title' => 'Kode', 'orderable' => false, 'className' => 'text-center'],
            ['data' => 'total', 'name' => 'total', 'title' => 'Total', 'orderable' => false, 'className' => 'text-center'],
            ['data' => 'id_supplier', 'name' => 'id_supplier', 'title' => 'Supplier', 'orderable' => false, 'className' => 'text-center'],
            ['data' => 'id_manager', 'name' => 'id_manager', 'title' => 'Manager', 'orderable' => false, 'className' => 'text-center'],
            ['data' => 'id_finance', 'name' => 'id_finance', 'title' => 'Finance', 'orderable' => false, 'className' => 'text-center'],
            ['data' => 'status', 'name' => 'status', 'title' => 'Status', 'orderable' => false, 'className' => 'text-center'],
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
        return 'Payment_' . date('YmdHis');
    }
}
