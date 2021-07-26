<!-- Title Field -->
<div class="form-group col-sm-6">
    {!! Form::label('identifier', 'Identifier:') !!}
    {!! Form::text('identifier', null, ['class' => 'form-control']) !!}
</div>

@isset($plugin)
    <div class="form-group col-sm-6">
        {!! Form::label('file', 'File: ') !!}
        @if (isset($plugin->plugin_source))
            {{ $plugin->identifier.'.aar' }}
        @endif
        {!! Form::file('plugin_source') !!}
    </div>

{{--    <div class="form-group col-sm-6">--}}
{{--        {!! Form::label('title', 'Title:') !!}--}}
{{--        {!! Form::text('title', null, ['class' => 'form-control']) !!}--}}
{{--    </div>--}}

{{--    <!-- Description Field -->--}}
{{--    <div class="form-group col-sm-6">--}}
{{--        {!! Form::label('description', 'Description:') !!}--}}
{{--        {!! Form::text('description', null, ['class' => 'form-control']) !!}--}}
{{--    </div>--}}

    {{--    <div class="form-group col-sm-6">--}}
{{--        {!! Form::label('main', 'Main: ') !!}--}}
{{--        {!! Form::text('main', null, ['class' => 'form-control']) !!}--}}
{{--    </div>--}}
@endisset

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('studio.plugins.index') }}" class="btn btn-default">Cancel</a>
</div>
