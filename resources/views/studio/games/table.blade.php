<table class="table table-striped">
    <thead>
    <tr>
        <th>Title</th>
        <th>Description</th>
        <th class="text-right"></th>
    </tr>
    </thead>
    <tbody>
    @foreach($games as $game)
        <tr>
            <td>{{ $game->title }}</td>
            <td>{{ $game->description }}</td>
            <td class="text-right">
                {!! Form::open(['route' => ['studio.games.destroy', $game->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{{ route('studio.games.show', [$game->id]) }}" class='btn btn-default btn-sm'><i
                            class="fas fa-eye"></i></a>
                    <a href="{{ route('studio.games.plugins.index', [$game->id]) }}" class='btn btn-default btn-sm'><i
                            class="fas fa-plug"></i></a>
                    <a href="{{ route('studio.games.builder.index', [$game->id]) }}" class='btn btn-default btn-sm'><i
                            class="fas fa-hammer"></i></a>
                    <a href="{{ route('studio.games.edit', [$game->id]) }}" class='btn btn-default btn-sm'><i
                            class="fas fa-edit"></i></a>
                    {!! Form::button('<i class="fas fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-sm', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
