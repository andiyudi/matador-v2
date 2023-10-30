@extends('layouts.template')
@section('content')
@php
$pretitle = 'Change';
$title    = 'Password'
@endphp
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                @include('profile.partials.update-password-form')
            </div>
        </div>
    </div>
</div>
@endsection
