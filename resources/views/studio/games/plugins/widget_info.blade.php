<div class="card card-widget widget-user-2">
    <div class="widget-user-header text-left bg-info">
        <h3 class="widget-user-username m-0">{{ $plugin->title }}</h3>
        @if(!empty($plugin->short_description))
            <h6 class="widget-user-desc ml-1">{{ $plugin->short_description }}</h6>
        @endif
    </div>
    <div class="card-footer">
        <div class="row">
            <div class="col-sm-4 border-right">
                <div class="description-block">
                    <span class="description-text"><i class="fas fa-download"></i> 3.000+</span><br>
                    <span class="description-text"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-o"></i></span>
                </div>
            </div>
            <div class="col-sm-4 border-right">
                <div class="description-block">
                    <h5 class="description-header"><a href="#"><i class="fas fa-info"></i> Info</a></h5>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="description-block">
                    <h5 class="description-header">
                        {!! Form::open(['route' => ['studio.games.plugins.install', $game, $plugin], 'method' => 'post']) !!}
                        {!! Form::button('<i class="fas fa-download"></i> Install', ['type' => 'submit', 'class' => 'btn btn-success btn-xs']) !!}
                        {!! Form::close() !!}
                    </h5>
                </div>
            </div>
        </div>
    </div>
</div>
