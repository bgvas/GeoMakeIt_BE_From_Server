@extends('layouts.studio')

@section('page_title')
    Plugin: <strong>{{$plugin->title}}</strong>
@endsection
@section('show_title', true)

@section('content')
    <div class="card card-primary">
        <div class="card-body">
            @include('studio.plugins.show_fields')
        </div>
    </div>
    <div class="col-sm-12">
        <a href="{{ route('studio.plugins.index') }}" class="btn btn-default">Back</a>
    </div>
@endsection
