<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>

{{--        {{ menu('navbar', 'layouts.adminlte3.partials.navbar.menu') }}--}}
    </ul>

    <!-- SEARCH FORM -->
    @include('layouts.adminlte3.partials.search-box')

    <!-- Right navbar links -->
    @include('layouts.adminlte3.partials.navbar.right')
</nav>
<!-- /.navbar -->
