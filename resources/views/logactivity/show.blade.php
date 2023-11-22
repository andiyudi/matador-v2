@extends('layouts.template')
@section('content')
@php
$pretitle = 'Detail';
$title    = 'Log Data ' . $log->id
@endphp
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th width="20%">Log Name</th>
                                <td>{{ $log->log_name }}</td>
                            </tr>
                            <tr>
                                <th>Description</th>
                                <td>{{ $log->description }}</td>
                            </tr>
                            <tr>
                                <th>Subject Type</th>
                                <td>{{ $log->subject_type }}</td>
                            </tr>
                            <tr>
                                <th>Event</th>
                                <td>{{ $log->event }}</td>
                            </tr>
                            <tr>
                                <th>Subject Id</th>
                                <td>{{ $log->subject_id }}</td>
                            </tr>
                            <tr>
                                <th>Causer Type</th>
                                <td>{{ $log->causer_type }}</td>
                            </tr>
                            <tr>
                                <th>Causer Id</th>
                                <td>{{ $log->causer_id }}</td>
                            </tr>
                            <tr>
                                <th>Properties</th>
                                <td>
                                    @php
                                        $properties = json_decode($log->properties, true);
                                    @endphp
                                    @if ($properties)
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Key</th>
                                                    <th>Value</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($properties as $key => $value)
                                                    <tr>
                                                        <td>{{ $key }}</td>
                                                        <td>{{ is_array($value) ? json_encode($value, JSON_PRETTY_PRINT) : $value }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    @else
                                        Data tidak valid
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Batch Uuid</th>
                                <td>{{ $log->batch_uuid }}</td>
                            </tr>
                            <tr>
                                <th>Created At</th>
                                <td>{{ $log->created_at }}</td>
                            </tr>
                            <tr>
                                <th>Updated At</th>
                                <td>{{ $log->updated_at }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-3">
                    <a type="button" href="{{ route('logactivity.index') }}" class="btn btn-secondary">Back</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
