<!DOCTYPE html>
<html lang="en">
<head>
    @include('admin.partials.head')
    @include('admin.partials.javascripts')
</head>
<body class="app header-fixed sidebar-fixed aside-menu-fixed sidebar-lg-show">
    @include('admin.partials.topbar')
    <div class="app-body">
        <div class="sidebar">
            @include('admin.partials.sidebar')
        </div>
        <main class="main">
            @yield('content')
        </main>
    </div>

    <footer class="app-footer">
{{--        <div>--}}
{{--            <a href="https://tektra.vn/" target="_blank">Tektra.Jsc</a>--}}
{{--            <span>&copy; 2021</span>--}}
{{--        </div>--}}
{{--        <div class="ml-auto">--}}
{{--            <span>Powered by</span>--}}
{{--            <a href="https://tektra.vn/" target="_blank">Tektra.Jsc</a>--}}
{{--        </div>--}}
    </footer>





@stack('custom-scripts')
</body>
</html>
