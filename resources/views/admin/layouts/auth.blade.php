<!DOCTYPE html>
<html>
    <head>
        <title>Đăng nhập quản trị VICOPRO</title>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}" />

        <link rel="shortcut icon" href="{{ url('admin/img/logo_vicopro.png') }}">
        <link href="admin/css/login.css" rel="stylesheet">
        <link rel="stylesheet" href="https://unpkg.com/@coreui/icons@2.0.0-beta.3/css/all.min.css">
    </head>
    <body class="app flex-row align-items-center bg-login" data-base-url="{{url('/')}}">

        <div class="container" id="app">
                @yield('content')
            </div>
        </div>
        <!-- base js -->
        <script src="{{url('admin/js/app2.js')}}"></script>
        <!-- end base js -->

        <!-- plugin js -->
        @stack('plugin-scripts')
        <!-- end plugin js -->
        <script src="{{url('admin/js/my-ajax.js')}}"></script>
        <script src="{{url('admin/js/myJs.js')}}"></script>
        @stack('custom-scripts')

    </body>
</html>
