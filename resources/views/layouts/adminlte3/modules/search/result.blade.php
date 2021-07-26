<div class="col-sm-12 invoice-col">
    <h5>
        <a href="/{{ $result->slug }}">{{ $result->title }}</a>
    </h5>

    <p class="search-result-url"><a href="/{{ $result->slug }}">{{ URL::to('/') }}/{{ $result->slug }}</a></p>

    @if ($result->excerpt)
        <p>{{ Illuminate\Support\Str::limit($result->excerpt, 200, '&hellip;') }}</p>
    @endif
</div>
