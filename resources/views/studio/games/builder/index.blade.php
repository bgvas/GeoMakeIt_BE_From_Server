@extends('layouts.studio')

@section('page_title')
    <strong>{{$game->title}}</strong>'s Builder
@endsection
@section('show_title', true)

@section('content')
    @include('flash::message')
    @include('layouts.adminlte3.common.errors')
    <div class="card card-primary">
        <div class="card-body">
            <div class="d-flex">
            {!! Form::open(['route' => ['studio.games.builder.build', $game->id], 'method' => 'post', 'class' => 'm-2']) !!}
                {!! Form::button('<i class="fas fa-hammer"></i> Build "'.$game->title.'"', ['type' => 'submit', 'class' => 'btn btn-success btn-sm']) !!}
            {!! Form::close() !!}

            {!! Form::open(['route' => ['studio.games.builder.download', $game->id], 'method' => 'post', 'class' => 'm-2']) !!}
                {!! Form::button('<i class="fas fa-download"></i> Download "'.$game->title.'"', ['type' => 'submit', 'class' => 'btn btn-success btn-sm', "disabled"=>($game->status == "release" && $game->release_file != null ? false : true)]) !!}
            {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection
