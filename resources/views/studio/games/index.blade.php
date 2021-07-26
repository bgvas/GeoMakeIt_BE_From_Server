@extends('layouts.studio')

@section('page_title', "My games")
@section('show_title', true)

@section('content')
    @include('flash::message')
    <h5 class="float-right">
        <a class="btn btn-success btn-sm" href="{{ route('studio.games.create') }}"><i class="fa fa-plus"></i> New</a>
    </h5>
    <div class="clearfix"></div>
    <div class="card">
        <div class="card-body p-0">
            @include('studio.games.table')
        </div>
    </div>
@endsection

