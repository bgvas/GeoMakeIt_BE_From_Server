<div class="card card-widget widget-user-2 m-2">
    <div class="widget-user-header text-left bg-info">
        <h3 class="widget-user-username m-0 {{ $plugin->isRequired() ? 'font-weight-bolder' : 'font-weight-bold' }}">{{ $plugin->title }}</h3>
        @if(!empty($plugin->short_description))
            <h6 class="widget-user-desc ml-1 mb-0">{{ $plugin->short_description }}</h6>
        @endif
        <h6 class="widget-user-desc ml-1"><small>Version: {{ $plugin->version }}</small></h6>
    </div>
    <div class="card-footer">
        <div class="row">
            <div class="col-sm-4 border-right">
                <div class="description-block">
                    <span class="description-text {{ $plugin->pivot->enabled ? 'text-success' : 'text-danger' }}">
                        {{ $plugin->pivot->enabled ? 'ENABLED' : 'DISABLED' }}
                    </span>
                </div>
            </div>
            <div class="col-sm-4 border-right">
                <div class="description-block">
                    <span class="description-text">
                        <a href="{{ route('studio.games.plugins.show', ['game'=>$game, 'plugin'=>$plugin]) }}">
                            <i class="fa fa-cog"></i> CONFIG
                        </a>
                    </span>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="description-block">
                    @if(!$plugin->isRequired())
                        {!! Form::open(['route' => ['studio.games.plugins.destroy', $game, $plugin], 'method' => 'delete']) !!}
                        {!! Form::button('<i class="fa fa-trash"></i> DELETE', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                        {!! Form::close() !!}
                    @else
                        <span class="font-weight-light ">This plugin is <u>required</u>!</span>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
