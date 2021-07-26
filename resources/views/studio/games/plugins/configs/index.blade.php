@php
    $tab_prefix = "tab_plugins_{$plugin->identifier}_configs_"
@endphp

@if(!$configs->isEmpty())
    <div class="card card-tabs card-outline">
        <div class="card-header p-0 pt-1 border-bottom-0">
            <ul class="nav nav-tabs">
                @foreach($configs as $index=>$config)
                    <li class="nav-item">
                        <a class="nav-link {{ ($loop->first) ? 'active' : '' }}" href="#{{ $tab_prefix.$index }}" data-toggle="tab">
                            {{ $config->name }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
        <div class="card-body">
            {!! Form::model($config, [
                'route' => ['studio.games.plugins.data.store', $config->game_id, $config->plugin_id, \App\Models\PluginData::TYPE_CONFIG],
                'method' => 'POST',
                'id' => "form_configs_{$plugin->identifier}"]) !!}
                <div class="tab-content">
                    @foreach($configs as $index=>$config)
                        <div class="tab-pane fade {{ ($loop->first) ? 'active show' : '' }}" id="{{ $tab_prefix.$index  }}">
                            <div id="jsoneditor_{{$plugin->identifier}}_{{ $config->plugin_id }}_{{ $index }}" style="width: 100%;height:600px;"></div>
                            @push('scripts')
                                <!-- TODO: CAREFUL. THIS CAN CAUSE A LOT OF SECURITY ISSUES. VERIFY JSON on the backend! -->
                                <script>
                                    let jsonEditor_{{$plugin->identifier}}_{{ $config->plugin_id }}_{{ $index }} = createJSONEditor(
                                        'jsoneditor_{{$plugin->identifier}}_{{ $config->plugin_id }}_{{ $index }}', {!! $config->contents !!}
                                    );
                                </script>
                            @endpush
                        </div>
                    @endforeach
                    @push('scripts')
                        <!-- Keep "hidden" the json conversion -->
                        <script>
                            $("#form_configs_{{ $plugin->identifier }}").submit( function(eventObj) {
                                @foreach($configs as $index=>$config)
                                    $("<input />").attr("type", "hidden")
                                        .attr("name", "{{ $config->name }}")
                                        .attr("value", JSON.stringify(jsonEditor_{{$plugin->identifier}}_{{ $config->plugin_id }}_{{ $index }}.get()))
                                        .appendTo("#form_configs_{{ $plugin->identifier }}");
                                @endforeach
                                return true;
                            });
                        </script>
                    @endpush
                </div>
                <div class="clearfix mb-1"></div>
                {!! Form::submit('Save', ['class' => 'btn btn-info float-right']) !!}
            {!! Form::close() !!}
        </div>
{{--        <div class="card-body">--}}
{{--            <div class="tab-content">--}}
{{--                @foreach($configs as $index=>$config)--}}
{{--                    <div class="tab-pane fade {{ ($loop->first) ? 'active show' : '' }}" id="{{ $tab_prefix.$index  }}">--}}
{{--                        {!! Form::model($config, ['route' => ['studio.games.plugins.data.store', $config->game_id, $config->plugin_id, \App\Models\PluginData::TYPE_CONFIG], 'method' => 'POST']) !!}--}}
{{--                        <div class="row">--}}
{{--                            <div id="jsoneditor_{{$plugin->identifier}}_{{ $config->plugin_id }}_{{ $index }}" style="width: 100%;height:600px;"></div>--}}
{{--                            <div class="form-group col-sm-12">--}}
{{--                                {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        --}}{{--                        <div class="form-group col-sm-12">--}}
{{--                        --}}{{--                            {!! Form::textarea('contents', $config->contents, ['class' => 'form-control']) !!}--}}
{{--                        --}}{{--                        </div>--}}
{{--                        @push('scripts')--}}
{{--                        <!-- TODO: CAREFUL. THIS CAN CAUSE A LOT OF SECURITY ISSUES. VERIFY JSON on the backend! -->--}}
{{--                            <script>--}}
{{--                                let jsonEditor_{{$plugin->identifier}}_{{ $config->plugin_id }}_{{ $index }} = createJSONEditor(--}}
{{--                                    'jsoneditor_{{$plugin->identifier}}_{{ $config->plugin_id }}_{{ $index }}', {!! $config->contents !!}--}}
{{--                                );--}}
{{--                            </script>--}}
{{--                        @endpush--}}

{{--                        {!! Form::close() !!}--}}
{{--                    </div>--}}
{{--                @endforeach--}}
{{--            </div>--}}
{{--        </div>--}}
    </div>
@else
    {{ __($plugin->title.' has no configurations to be made.') }}
@endif
