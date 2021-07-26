<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="/" class="brand-link">
        <img src="{{ url('assets/dist/img/AdminLTELogo.png') }} " alt="AdminLTE Logo" class="brand-image elevation-3" />
        <span class="brand-text font-weight-light">GeoMakeIt! Studio</span>
    </a>


    <div class="sidebar">
        @include('layouts.adminlte3.partials.sidebar.user_panel')

        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                {{ menu('sidebar', 'layouts.adminlte3.partials.sidebar.menu', ['icon'=>true]) }}
            </ul>
        </nav>
    </div>
</aside>
