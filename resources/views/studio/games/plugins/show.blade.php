@push('styles')
    <link href="{{ url('assets/plugins/jsoneditor/jsoneditor.css') }}" rel="stylesheet" type="text/css">
@endpush
@push('scripts')
    <script src="{{ url('assets/plugins/jsoneditor/jsoneditor.js') }}"></script>
    <script>
        function createJSONEditor(id, contents) {
            // create the editor
            let container = document.getElementById(id);
            let options = {};
            let editor = new JSONEditor(container, options);

            // set json
            let initialJson = contents
            editor.set(initialJson);

            return editor;
        }

        function geomakeit_reset_data(id) {
            id.val(id.attr('attr-default'));
        }
    </script>
@endpush

<div class="card card-tabs card-outline">
    <div class="card-header p-0 pt-1 border-bottom-0">
        <ul class="nav nav-tabs" role="tablist">
            @foreach($game->plugins as $plugin)
                @php
                    $isActive = (isset($focus) && preg_match('/tab_plugins_'.$plugin->identifier.'/', $focus)) ||
                                 (!isset($focus) && $loop->first);
                @endphp
                <li class="nav-item">
                    <a class="nav-link {{ ($isActive) ? 'active' : '' }}" href="#tab_plugins_{{ $plugin->identifier }}" data-toggle="pill"
                       aria-controls="tab_plugins_{{ $plugin->identifier }}" aria-selected="{{ $isActive }}">
                        {{ $plugin->title }}
                    </a>
                </li>
            @endforeach
        </ul>
    </div>

    <!-- Vertical Tabs -->
    <div class="card-body">
        <div class="tab-content">
            @foreach($game->plugins as $plugin)
                @php
                    $isActive = (isset($focus) && preg_match('/tab_plugins_'.$plugin->identifier.'/', $focus)) ||
                                 (!isset($focus) && $loop->first);
                @endphp
                <div class="tab-pane fade {{ $isActive ? 'active show' : '' }}" id="tab_plugins_{{ $plugin->identifier }}">
                    @include('studio.games.plugins.vertical_tabs', ['plugin' => $plugin])
                </div>
            @endforeach
        </div>
    </div>
</div>
