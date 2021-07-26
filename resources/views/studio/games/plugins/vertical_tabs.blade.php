<div class="row">
    <div class="col-5 col-sm-3">
        <div class="nav flex-column nav-tabs h-100" role="tablist" aria-orientation="vertical">
            <!-- Information -->
            <a class="nav-link active" data-toggle="pill" href="#tab_plugins_{{$plugin->identifier}}_info"
               role="tab" aria-controls="tab_plugins_{{$plugin->identifier}}_info" aria-selected="true">
                <i class="fas fa-info-circle"></i> Information</a>

            <!-- Configs -->
            <a class="nav-link" data-toggle="pill" href="#tab_plugins_{{$plugin->identifier}}_configs"
               role="tab" aria-controls="tab_plugins_{{$plugin->identifier}}_configs" aria-selected="false">
                <i class="fas fa-file-code"></i> Configs</a>

            <!-- Strings -->
            <a class="nav-link" data-toggle="pill" href="#tab_plugins_{{$plugin->identifier}}_strings"
               role="tab" aria-controls="tab_plugins_{{$plugin->identifier}}_strings" aria-selected="false">
                <i class="fas fa-language"></i> Strings</a>
        </div>
    </div>
    <div class="col-7 col-sm-9">
        <div class="tab-content" id="vert-tabs-tabContent">
            <!-- Information tab -->
            <div class="tab-pane text-left fade show active" id="tab_plugins_{{$plugin->identifier}}_info"
                 role="tabpanel" aria-labelledby="tab_plugins_{{$plugin->identifier}}_info">
                <dl class="row">
                    <dt class="col-sm-4">Title</dt>
                    <dd class="col-sm-8 font-weight-bold">{{ $plugin->title }}</dd>
                    <dt class="col-sm-4">Author</dt>
                    <dd class="col-sm-8 font-weight-bold">Vasilis Dimitriadis</dd>
                    <dt class="col-sm-4">Version</dt>
                    <dd class="col-sm-8 font-weight-bold">{{ $plugin->version }}</dd>
                    <dt class="col-sm-4">Description</dt>
                    <dd class="col-sm-8">{{ $plugin->description }}</dd>
                </dl>
            </div>

            <!-- Config tab -->
            <div class="tab-pane fade" id="tab_plugins_{{$plugin->identifier}}_configs"
                 role="tabpanel" aria-labelledby="tab_plugins_{{$plugin->identifier}}_configs">
                @include('studio.games.plugins.configs.index', ['configs' => $plugin->pivot->data()->ofType(\App\Models\PluginData::TYPE_CONFIG)->get()])
            </div>
            <div class="tab-pane fade" id="tab_plugins_{{$plugin->identifier}}_strings"
                 role="tabpanel" aria-labelledby="tab_plugins_{{$plugin->identifier}}_strings">
                @php
                    //$plugin_data = \App\Models\PluginData::ofType(\App\Models\PluginData::TYPE_STRING)->where('plugin_id', $plugin->id)->get(['name', 'contents AS default_value']);
                    $game_plugin_data = \App\Models\GamePluginData::with('default')->ofType(\App\Models\PluginData::TYPE_STRING)
                        ->where('plugin_id', $plugin->id)->where('game_id', $game->id)->get();
                @endphp
                {!! Form::open(['route' => ['studio.games.plugins.data.store', $game->id, $plugin->id, \App\Models\PluginData::TYPE_STRING], 'method' => 'POST']) !!}
                    @foreach($game_plugin_data->all() as $data)
                        <div class="input-group input-group-sm mb-1">
                            <div class="input-group-prepend">
                                <span class="input-group-text">{{ $data->name }}</span>
                            </div>
                            <input type="text" class="form-control" name="{{ $data->name }}" value="{{ $data->contents }}" attr-default="{{ $data->default->contents }}">
                            <div class="input-group-append">
                                <button type="button" class="btn btn-info btn-flat" onclick="geomakeit_reset_data($(this).parent().parent().find('input'));"><i class="fas fa-undo"></i></button>
                            </div>
                        </div>
                    @endforeach
                    <div class="clearfix"></div>
                    {!! Form::button('Save', ['type' => 'submit', 'class' => 'btn btn-info float-right']) !!}
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
