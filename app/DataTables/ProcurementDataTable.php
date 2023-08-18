<?php

namespace App\DataTables;

use App\Models\Procurement;
use App\Models\Division;
use App\Models\Official;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ProcurementDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
        ->addColumn('division_code', function ($data) {
            return $data->division->code;
        })
        ->addColumn('official_initials', function ($data) {
            return $data->official->initials;
        })
        ->addColumn('status', function ($data) {
            if ($data->status == 0) {
                return '<span class="badge text-bg-info">Process</span>';
            } elseif ($data->status == 1) {
                return '<span class="badge text-bg-success">Success</span>';
            } elseif ($data->status == 2) {
                return '<span class="badge text-bg-danger">Canceled</span>';
            }
            return '<span class="badge text-bg-dark">Unknown</span>';
        })
        ->addColumn('action', function($data){
            $route = 'procurements';
            return view ('procurement.action', compact ('route', 'data'));
        })
        ->addindexcolumn()
        ->rawColumns(['status'])
        ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Procurement $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('procurement-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('lfBrtip')
                    ->orderBy(1)
                    ->selectStyleSingle()
                    ->buttons([
                        Button::make('excel'),
                        Button::make('csv'),
                        // Button::make('pdf'),
                        Button::make('print'),
                        // Button::make('reset'),
                        // Button::make('reload')
                    ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('DT_RowIndex')->title('No')->orderable(false)->searchable(false),
            Column::make('receipt')->title('TTPP'),
            Column::make('number')->title('No PP'),
            Column::make('name')->title('Nama Pekerjaan'),
            Column::make('division_code')->title('Divisi'),
            Column::make('official_initials')->title('PIC Pengadaan'),
            Column::make('status')->title('Status Dokumen PP')->orderable(false)->searchable(false),
            Column::computed('action')
            ->exportable(false)
            ->printable(false)
            ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Procurement_' . date('YmdHis');
    }
}
