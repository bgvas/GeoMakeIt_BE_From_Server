@php
    if (Voyager::translatable($items)) {
        $items = $items->load('translations');
    }
@endphp

@foreach ($items as $item)
    @php
        $originalItem = $item;
        if (Voyager::translatable($item)) {
            $item = $item->translate($options->locale);
        }

        $isActive = null;
        $styles = null;
        $icon = null;
        $hasChildren = !$originalItem->children->isEmpty();
        $isHeader = (substr( strtoupper($originalItem->title), 0, 8 ) === "HEADER: ");

        // Remove 'HEADER: ' if its a header
        if($isHeader) {
            $item->title = substr($originalItem->title, 8);
        }

        // Background Color or Color
        if (isset($options->color) && $options->color == true) {
            $styles = 'color:'.$item->color;
        }
        if (isset($options->background) && $options->background == true) {
            $styles = 'background-color:'.$item->color;
        }

        // Check if link is current
        if(url($item->link()) == url()->current()){
            $isActive = 'active';
        }

        // Set Icon
        if(isset($options->icon) && $options->icon == true){
            $icon = '<i class="nav-icon ' . $item->icon_class . '"></i>';
        }
    @endphp

    @if($isHeader)
        <li class="nav-header">{{ $item->title }}</li>
    @else
        {{--TODO: Check if child is active?--}}
        <li class="nav-item
            {{ $hasChildren ? 'has-treeview' : '' }}
            ">
            <a href="{{ url($item->link()) }}" target="{{ $item->target }}" style="{{ $styles }}" class="nav-link {{ $isActive }}">
                {!! $icon !!}
                <p>
                    {{ $item->title }}
                    @if($hasChildren)
                        <i class="right fas fa-angle-left"></i>
                        {{--TODO: Add badges (new, danger, +1, e.t.c)--}}
                    @endif
                </p>
            </a>
            @if($hasChildren)
                <ul class="nav nav-treeview">
                    @include('layouts.adminlte3.partials.sidebar.menu', ['items' => $originalItem->children, 'options' => $options])
                </ul>
            @endif
        </li>
    @endif

@endforeach

