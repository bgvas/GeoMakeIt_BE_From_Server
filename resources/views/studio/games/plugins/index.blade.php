@extends('layouts.studio')

@section('page_title')
    Plugins for <strong>{{$game->title}}</strong>
@endsection
@section('show_title', true)

@section('content')
    @include('flash::message')

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header with-border">
                    <h3 class="card-title">Installed plugins</h3>

                    <div class="card-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        @forelse($game->plugins as $plugin)
                            <div class="col-md-4">
                                @include('studio.games.plugins.widget_installed', ['plugin', $plugin])
                            </div>
                        @empty
                            <p>You currently have <strong>no plugins installed</strong>!</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header with-border">
                    <h3 class="card-title">Other plugins</h3>

                    <div class="card-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                    @foreach($plugins->diff($game->plugins) as $plugin)
                        @if($plugin->plugin_source != null)
                            <div class="col-md-4">
                                @include('studio.games.plugins.widget_info', ['plugin', $plugin])
                            </div>
                        @endif
                    @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

