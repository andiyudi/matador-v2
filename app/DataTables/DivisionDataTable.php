<?php

namespace App\DataTables;

use App\Models\Division;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class DivisionDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
        ->addColumn('status', function ($data) {
            if ($data->status == 1) {
                return '<span class="badge text-bg-success">Active</span>';
            } elseif ($data->status == 0) {
                return '<span class="badge text-bg-danger">InActive</span>';
            }
            return '<span class="badge text-bg-dark">Unknown</span>';
        })
            // ->addColumn('action', 'division.action')
            ->addColumn('action', function($data){
                $button = '<button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editDivisionModal" data-division-id="'.$data->id.'" data-division-name="'.$data->name.'" data-division-status="'.$data->status.'">
                Edit
            </button> ';
                $button .= ' <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteDivisionModal" data-division-id="'.$data->id.'">
                Delete
            </button>';
                return $button;
            })
            ->rawColumns(['status', 'action'])
            ->addindexcolumn()
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Division $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('division-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->lengthMenu([5,10,25,50])
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
            Column::make('name')->title('Nama Divisi'),
            Column::make('status')->title('Status'),
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
        return 'Division_' . date('YmdHis');
    }
}
