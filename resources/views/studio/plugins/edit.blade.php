@extends('layouts.studio')

@section('page_title')
    Edit <strong>{{$plugin->title}}</strong>
@endsection
@section('show_title', true)

@push('scripts')
    <script src="{{ url('assets/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            bsCustomFileInput.init();
        });
    </script>
@endpush
@section('content')
    @include('flash::message')
    @include('layouts.adminlte3.common.errors')

    <div class="row">
        <div class="col-md-3">
            <div class="card card-default card-outline">
                <div class="card-body">
                    <h5 class="text-muted text-center">{{ $plugin->title }}</h5>
                    @if($plugin->plugin_source != null)
                        <p class="text-center text-muted">{{ $plugin->short_description }}</p>
                        <ul class="list-group list-group-unbordered mb-3">
                            <li class="list-group-item">
                                <b>Version</b> <a class="float-right">{{ $plugin->version }}</a>
                            </li>
                            <li class="list-group-item">
                                <b>Main</b> <a class="float-right">{{ $plugin->main }}</a>
                            </li>
                            <li class="list-group-item">
                                <b>Status</b> <a class="float-right">{{ $plugin->status }}</a>
                            </li>
                            <li class="list-group-item">
                                <b>Updated at</b> <a class="float-right">{{ $plugin->updated_at->diffForHumans() }}</a>
                            </li>
                            <li class="list-group-item">
                                <b>Created at</b> <a class="float-right">{{ $plugin->created_at->diffForHumans() }}</a>
                            </li>
                        </ul>
                    @else
                        <p class="text-muted">No information about this plugin yet.</p>
                        <p><span class="font-weight-bold">Upload your first plugin</span> to get extra information.</p>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="card card-default card-outline">
                <div class="card-body">
                    <h3 class="text-bold">Upload your plugin</h3>
                    {!! Form::model($plugin, ['route' => ['studio.plugins.update', $plugin->id], 'method' => 'patch', 'files' => true]) !!}
                        {{ Form::hidden('identifier', $plugin->identifier) }}
                        <div class="form-group">
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" name="plugin_source" id="plugin_source">
                                    <label class="custom-file-label" for="plugin_source">Choose a file</label>
                                </div>
                                <div class="input-group-append">
                                    {!! Form::submit('Upload plugin', ['class' => 'input-group-text float-right']) !!}
                                </div>
                            </div>
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <a href="{{ route('studio.plugins.index') }}" class="btn btn-default">Back</a>
        </div>
    </div>

    {{--    <div class="card card-tabs card-outline">--}}
    {{--           <div class="card-header p-0 pt-1 border-bottom-0">--}}
    {{--               <ul class="nav nav-tabs">--}}
    {{--                   <li class="nav-item"><a class="nav-link active" href="#tab_general" data-toggle="tab"><i class="fas fa-plug"></i> Plugin Information</a></li>--}}
    {{--                   <li class="nav-item"><a class="nav-link" href="#tab_config" data-toggle="tab"><i class="fas fa-file-code-o"></i> Configs</a></li>--}}
    {{--               </ul>--}}
    {{--           </div>--}}
    {{--           <div class="card-body">--}}
    {{--               <div class="tab-content">--}}
    {{--                   <div class="tab-pane active" id="tab_general">--}}
    {{--                       {!! Form::model($plugin, ['route' => ['studio.plugins.update', $plugin->id], 'method' => 'patch', 'files' => true]) !!}--}}
    {{--                       <div class="row">--}}
    {{--                           @include('studio.plugins.fields')--}}
    {{--                       </div>--}}
    {{--                       {!! Form::close() !!}--}}
    {{--                   </div>--}}
    {{--                   <div class="tab-pane" id="tab_config">--}}
    {{--                        @foreach($plugin->configs as $config)--}}
    {{--                            {{ $config->file_name }}--}}
    {{--                        @endforeach--}}
    {{--                   </div>--}}
    {{--               </div>--}}
    {{--           </div>--}}
    {{--       </div>--}}

{{--    <div class="card card-primary">--}}
{{--        <div class="card-body">--}}
{{--            {!! Form::open(['route' => 'studio.plugins.store']) !!}--}}
{{--            <div class="row">--}}
{{--                @include('studio.plugins.fields')--}}
{{--            </div>--}}
{{--            {!! Form::close() !!}--}}
{{--        </div>--}}
{{--    </div>--}}

{{--    <div class="card card-tabs card-outline">--}}
{{--           <div class="card-header p-0 pt-1 border-bottom-0">--}}
{{--               <ul class="nav nav-tabs">--}}
{{--                   <li class="nav-item"><a class="nav-link active" href="#tab_general" data-toggle="tab"><i class="fas fa-plug"></i> Plugin Information</a></li>--}}
{{--                   <li class="nav-item"><a class="nav-link" href="#tab_config" data-toggle="tab"><i class="fas fa-file-code-o"></i> Configs</a></li>--}}
{{--               </ul>--}}
{{--           </div>--}}
{{--           <div class="card-body">--}}
{{--               <div class="tab-content">--}}
{{--                   <div class="tab-pane active" id="tab_general">--}}
{{--                       {!! Form::model($plugin, ['route' => ['studio.plugins.update', $plugin->id], 'method' => 'patch', 'files' => true]) !!}--}}
{{--                       <div class="row">--}}
{{--                           @include('studio.plugins.fields')--}}
{{--                       </div>--}}
{{--                       {!! Form::close() !!}--}}
{{--                   </div>--}}
{{--                   <div class="tab-pane" id="tab_config">--}}
{{--                        @foreach($plugin->configs as $config)--}}
{{--                            {{ $config->file_name }}--}}
{{--                        @endforeach--}}
{{--                   </div>--}}
{{--               </div>--}}
{{--           </div>--}}
{{--       </div>--}}
@endsection
