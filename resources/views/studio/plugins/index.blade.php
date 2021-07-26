@extends('layouts.studio')

@section('page_title', "My plugins")
@section('show_title', true)

@section('content')
    @include('flash::message')
    <h5 class="float-right">
        <a class="btn btn-success btn-sm" href="{{ route('studio.plugins.create') }}"><i class="fa fa-plus"></i> New</a>
    </h5>
    <div class="clearfix"></div>
    <div class="card">
        <div class="card-body p-0">
            @include('studio.plugins.table')
        </div>
    </div>
    @includeWhen(isset($soft_deleted) && count($soft_deleted) > 0, 'studio.plugins.soft_deleted', ['plugins' => $soft_deleted])
@endsection
