<div class="user-panel mt-3 pb-3 mb-3 d-flex">
    <div class="image">
{{--        <img src="{{ Voyager::image(Auth::user()->avatar) }}" class="img-circle elevation-2" alt="User Image">--}}
        <img src=" {{ url('images/user-default.png') }}" class="img-circle elevation-2" alt="User Image">
    </div>
    <div class="info">
        <a href="{{ route('studio.account') }}" class="d-block">{{ Auth::user()->name }}</a>
    </div>
</div>
