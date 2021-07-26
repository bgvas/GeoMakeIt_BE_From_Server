@extends('layouts.studio')

@section('page_title')
    Game <strong>{{$game->title}}</strong>
@endsection
@section('show_title', true)

@section('content')
    <div class="row">
        <div class="col-md-3">
            <div class="card card-default card-outline">
                <div class="card-body">
                    <h5 class="text-muted text-center">Details</h5>

                    @include('studio.games.show_fields')
                </div>
            </div>
            <div class="col-sm-12">
                <a href="{{ route('studio.games.index') }}" class="btn btn-block btn-default">Back</a>
            </div>
        </div>
        <div class="col-md-9">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Installed plugins</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach($game->plugins as $plugin)
                            @include('studio.games.plugins.widget_installed', ['plugin' => $plugin])
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
