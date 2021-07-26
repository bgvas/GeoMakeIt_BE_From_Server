<!DOCTYPE html>
<html>
@include('layouts.adminlte3.partials.meta')
<body class="hold-transition sidebar-mini layout-fixed">
@include('layouts.adminlte3.partials.navbar')
@include('layouts.adminlte3.partials.sidebar')
<div class="content-wrapper">
    @hasSection('show_title')
        @include('layouts.adminlte3.partials.page-title')
    @endif
    <section class="content">
        <div class="container-fluid">
            @yield('content')
        </div>
    </section>
</div>
@include('layouts.adminlte3.partials.footer')
@include('layouts.adminlte3.partials.scripts')
</body>
</html>
