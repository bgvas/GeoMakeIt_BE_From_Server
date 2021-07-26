@foreach($items as $menu_item)
<li class="nav-item d-none d-sm-inline-block">
    <a href="{{ $menu_item->link() }}" class="nav-link">{{ $menu_item->title }}</a>
</li>
@endforeach

