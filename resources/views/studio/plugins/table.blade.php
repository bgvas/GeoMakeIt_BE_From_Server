<table class="table table-striped" id="plugins-table">
    <thead>
        <tr>
            <th>Identifier</th>
            <th>Title</th>
            <th>Description</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
    @foreach($plugins as $plugin)
        <tr>
            <td>{{ $plugin->identifier }}</td>
            <td>{{ $plugin->title }}</td>
            <td>{{ $plugin->description }}</td>
            <td class="text-right">
                {!! Form::open(['route' => ['studio.plugins.destroy', $plugin], 'method' => 'delete']) !!}
                <div class='btn-group'>
{{--                    <a href="{{ route('studio.plugins.show', [$plugin]) }}" class='btn btn-default btn-sm'><i class="fas fa-eye"></i></a>--}}
                    @if(empty($plugin->plugin_source))
                        <a href="{{ route('studio.plugins.edit', [$plugin]) }}" class='btn btn-default btn-sm'><i class="fas fa-upload"></i> Upload first version!</a>
                    @else
                        <a href="{{ route('studio.plugins.edit', [$plugin]) }}" class='btn btn-default btn-sm'><i class="fas fa-eye"></i></a>
                    @endif
                    {!! Form::button('<i class="fas fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-sm', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
