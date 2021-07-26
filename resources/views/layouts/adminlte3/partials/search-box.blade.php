<form class="form-inline ml-3" action="/search" method="GET">
    <div class="input-group input-group-sm">
        <input class="form-control form-control-navbar" name="keywords" type="search" value="{{ \Request::get('keywords') }}" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
            <button class="btn btn-navbar" type="submit">
                <i class="fas fa-search"></i>
            </button>
        </div>
    </div>
</form>
