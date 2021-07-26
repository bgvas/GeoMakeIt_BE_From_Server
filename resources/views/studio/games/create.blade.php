@extends('layouts.studio')

@section('page_title', 'New Game')
@section('show_title', true)

@section('content')
    @include('layouts.adminlte3.common.errors')
    <div class="card card-primary">
        <div class="card-body">
            {!! Form::open(['route' => 'studio.games.store']) !!}
                <div class="row">
                    @include('studio.games.fields')
                </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection
