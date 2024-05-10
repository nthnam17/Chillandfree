{{--@inject('setting', 'App\CustomClasses\Setting')--}}
{{--@section('pageTitle', $setting->get('meta_title'))--}}

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Web MUSEUM</title>
        <meta property="og:image" content="{{ url('/admin/image/logo-mini.svg') }}">
        <meta name="description" content="data tektra">
        <meta property="og:description" content="{{ config('app.url') }}">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}" />

        <link rel="shortcut icon" href="{{ url('/admin/image/logo-mini.svg') }}">
{{--        <link href="admin/css/login.css" rel="stylesheet">--}}
        <link rel="stylesheet" href="https://unpkg.com/@coreui/icons@2.0.0-beta.3/css/all.min.css">
    </head>
    <body class="app auth-mic flex-row align-items-center" data-base-url="{{url('/')}}">

        <div class="container" id="app">
                @yield('content')
            </div>
        </div>
        <!-- base js -->
        <script src="{{ asset('admin/js/app2.js') }}"></script>
        <!-- end base js -->
        <script src="{{ asset('admin/js/simple-notify.min.js') }}"></script>

        <!-- plugin js -->
        @stack('plugin-scripts')
        <!-- end plugin js -->
        <script src="{{ asset('admin/js/ajax-main.js') }}"></script>
        <script src="{{ asset('admin/js/js-main.js') }}"></script>

        @stack('custom-scripts')

    </body>
</html>
