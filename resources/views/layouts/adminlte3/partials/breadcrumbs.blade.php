@if (isset($breadcrumbs) && count($breadcrumbs) > 2)
    @php
        array_shift($breadcrumbs)
    @endphp
    <ol class="breadcrumb float-sm-right">
        @foreach ($breadcrumbs as $key => $crumb)
            @php
                $isLast = ($key + 1) === count($breadcrumbs)
            @endphp
            <li class="breadcrumb-item {{ $isLast ? 'active' : '' }}">
            @if ($isLast)
                {{ ucfirst($crumb['text']) }}
            @else
                <a href="{{ $crumb['link'] }}">{{ ucfirst($crumb['text']) }}</a>
            @endif
            </li>
        @endforeach
    </ol>
@endif
