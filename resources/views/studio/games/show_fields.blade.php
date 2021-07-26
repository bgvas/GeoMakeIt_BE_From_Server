<ul class="list-group list-group-unbordered mb-3">
    <li class="list-group-item">
        <b>Title</b> <a class="float-right">{{ $game->title }}</a>
    </li>
    <li class="list-group-item">
        <b>Plugins</b> <a class="float-right" href="{{ route('studio.games.plugins.index', $game) }}">{{ $game->plugins()->count() }}</a>
    </li>
</ul>
