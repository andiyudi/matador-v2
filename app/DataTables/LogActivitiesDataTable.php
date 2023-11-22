<?php

namespace App\DataTables;

use Carbon\Carbon;
use App\Models\LogActivity;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Spatie\Activitylog\Models\Activity;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;

class LogActivitiesDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('agent', function ($log) {
                // Ambil nilai kolom properties dan tampilkan sesuai kebutuhan
                $properties = json_decode($log->properties, true);
                // Lakukan manipulasi atau ambil data tertentu dari $properties
                if (isset($properties['agent'])) {
                    // Access the 'agent' data
                    $agentData = $properties['agent'];

                    // Create a formatted string or HTML representation
                    $formattedAgent = '<strong>IP:</strong>' . $agentData['ip'] . '<br><strong>URL:</strong>' . $agentData['url'];

                    // You might want to format the data or do additional processing here
                    return $formattedAgent;
                }

                return '<span class="badge text-bg-dark">Tidak Ada Data</span>';
            })
            ->addColumn('before', function ($log) {
                // Ambil nilai kolom properties dan tampilkan sesuai kebutuhan
                $properties = json_decode($log->properties, true);

                // Lakukan manipulasi atau ambil data tertentu dari $properties
                if (isset($properties['old'])) {
                    // Access the 'old' data
                    $oldData = $properties['old'];

                    // Remove 'updated_at' from the 'old' data if it exists
                    // unset($oldData['updated_at']);

                    // Remove unwanted keys (created_at, updated_at, deleted_at, etc.)
                    $excludeKeys = ['created_at', 'updated_at', 'deleted_at'];
                    $oldData = array_diff_key($oldData, array_flip($excludeKeys));

                    // You might want to format the data or do additional processing here
                    $formattedData = implode('<br> ', array_map(function ($value, $key) {
                        return "$key: $value";
                    }, $oldData, array_keys($oldData)));

                    return $formattedData;
                }

                return '<span class="badge text-bg-dark">Tidak Ada Data</span>';
            })
            ->addColumn('after', function ($log) {
                // Ambil nilai kolom properties dan tampilkan sesuai kebutuhan
                $properties = json_decode($log->properties, true);

                // Lakukan manipulasi atau ambil data tertentu dari $properties
                if (isset($properties['attributes'])) {
                    // Access the 'attributes' data
                    $attributesData = $properties['attributes'];

                    // Remove unwanted keys (updated_at, deleted_at, etc.)
                    $excludeKeys = ['created_at', 'updated_at', 'deleted_at'];
                    $attributesData = array_diff_key($attributesData, array_flip($excludeKeys));

                    // You might want to format the data or do additional processing here
                    // return json_encode($attributesData, JSON_PRETTY_PRINT);  // Convert it back to JSON or format as needed
                    $formattedData = implode('<br> ', array_map(function ($value, $key) {
                        return "$key: $value";
                    }, $attributesData, array_keys($attributesData)));

                    return $formattedData;
                }

                return '<span class="badge text-bg-dark">Tidak Ada Data</span>';
            })
            ->addColumn('action', function($data){
                $route = 'logactivity';
                return view ('logactivity.action', compact ('route', 'data'));
            })
            ->addColumn('log_at', function ($data) {
                return Carbon::parse($data->created_at)->diffForHumans();
            })
            ->rawColumns(['action','agent', 'before', 'after'])
            ->addindexcolumn()
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Activity $model): QueryBuilder
    {
        return $model->newQuery()->orderByDesc('id');
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('logactivities-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    // ->dom('lfBrtip')
                    ->orderBy(1)
                    ->selectStyleSingle()
                    ->buttons([
                        Button::make('excel'),
                        Button::make('csv'),
                        Button::make('pdf'),
                        Button::make('print'),
                        Button::make('reset'),
                        Button::make('reload')
                    ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('DT_RowIndex')->title('No')->orderable(false)->searchable(false),
            Column::make('agent')->title('Agent'),
            Column::make('before')->title('Before'),
            Column::make('after')->title('After'),
            Column::make('log_at')->title('Log At'),
            Column::make('action')->title('Action'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'LogActivities_' . date('YmdHis');
    }
}
