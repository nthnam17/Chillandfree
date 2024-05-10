<!DOCTYPE html>
<html lang="en">
<head>
    @include('admin.partials.head')
    @include('admin.partials.javascripts')
</head>
<body>
<div class="container-scroller">
    @include('admin.partials.topbar')
    <div class="container-fluid page-body-wrapper">
        @include('admin.partials.sidebar')
        <div class="main-panel">
            <div class="content-wrapper">
                    @yield('content')
            </div>
        </div>
    </div>
</div>
@stack('custom-scripts')
</body>
</html>
