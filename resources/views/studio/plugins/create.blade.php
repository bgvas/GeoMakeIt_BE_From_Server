@extends('layouts.studio')

@section('page_title', 'New Plugin')
@section('show_title', true)

@section('content')
    @include('layouts.adminlte3.common.errors')
    <div class="card card-primary">
        <div class="card-body">
            {!! Form::open(['route' => 'studio.plugins.store']) !!}
            <div class="row">
                @include('studio.plugins.fields')
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection
