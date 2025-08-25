<?php

namespace App\DataTables;

use App\Models\Preorder;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class PreorderDataTable extends DataTable
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
            ->eloquent($query->whereIn('status', [3, 4])->where('created_by', Auth::user()->id)->Filter(request(['periode']))->orderBy('created_at', 'desc'))
            ->addIndexColumn()
            ->addColumn('nama_proyek', function ($query) {
                return $query->proyek->nama ?? '-';
            })
            ->addColumn('pelaksana_proyek', function ($query) {
                return $query->proyek->pelaksana ?? '-';
            })
            ->addColumn('purchasing', function ($query) {
                return $query->createdBy->first_name . ' ' . $query->createdBy->last_name ?? '-';
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
            ->editColumn('total', function ($query) {
                return number_format($query->total, 0);
            })
            ->editColumn('created_at', function ($query) {
                $tanggal = Carbon::parse($query->created_at);
                return $tanggal->format('d F Y');
            })
            ->editColumn('status', function ($query) {
                switch ($query->status) {
                    case 3:
                        return '<span class="badge bg-warning">Belum Bayar</span>';
                    case 4:
                        return '<span class="badge bg-success">Sudah Bayar</span>';
                    default:
                        return '<span class="badge bg-secondary">-</span>';
                }
            })
            ->addColumn('action', function ($query) {
                return view('app.purchase.preorder.action', [
                    'id' => $query->id,
                    'status' => $query->status,
                ]);
            })
            ->rawColumns(['status', 'action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Preorder $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Preorder $model)
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
            ['data' => 'minggu_ke', 'name' => 'minggu_ke', 'title' => 'Minggu Ke', 'orderable' => false, 'className' => 'text-center'],
            ['data' => 'pelaksana_proyek', 'name' => 'pelaksana_proyek', 'title' => 'Kontraktor', 'orderable' => false, 'className' => 'text-center'],
            ['data' => 'purchasing', 'name' => 'purchasing', 'title' => 'Purchasing', 'orderable' => false, 'className' => 'text-center'],
            ['data' => 'masa_pelaksanaan', 'name' => 'masa_pelaksanaan', 'title' => 'Masa Pelaksanaan', 'orderable' => false, 'className' => 'text-center'],
            ['data' => 'total', 'name' => 'total', 'title' => 'Total', 'orderable' => false, 'className' => 'text-center'],
            ['data' => 'kode_bayar', 'name' => 'kode_bayar', 'title' => 'Kode Bayar', 'orderable' => false, 'className' => 'text-center'],
            ['data' => 'created_at', 'name' => 'created_at', 'title' => 'Tanggal', 'orderable' => false, 'className' => 'text-center'],
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
        return 'Approval_' . date('YmdHis');
    }
}
