<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ $title }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <link rel="stylesheet" href="{{ asset('/') }}assets/css/main/app.css" />
    <link rel="stylesheet" href="{{ asset('/') }}assets/css/main/app-dark.css" />
    <link rel="shortcut icon" href="{{ asset('/') }}assets/images/logo/favicon.png" type="image/x-icon" />
    <link rel="shortcut icon" href="{{ asset('/') }}assets/images/logo/favicon.png" type="image/png" />

    <link rel="stylesheet" href="{{ asset('/') }}assets/css/shared/iconly.css" />
    <link rel="stylesheet" href="{{ asset('/') }}assets/extensions/sweetalert2/sweetalert2.min.css">

    @yield('dashboard_style')
</head>

<body>
    <script src="{{ asset('/') }}assets/js/initTheme.js"></script>
    <div id="app">

        @include('Layouts.dashboard-sidebar')

        <div id="main">
            <header class="mb-3">
                <a href="#" class="burger-btn d-block d-xl-none">
                    <i class="bi bi-justify fs-3"></i>
                </a>
            </header>

            @yield('dashboard_content')

            @include('Layouts.footer')

        </div>
    </div>
    <script src="{{ asset('/') }}assets/extensions/jquery/jquery.min.js"></script>
    <script src="{{ asset('/') }}assets/js/bootstrap.js"></script>
    <script src="{{ asset('/') }}assets/js/app.js"></script>
    <script src="{{ asset('/') }}assets/extensions/sweetalert2/sweetalert2.min.js"></script>

    @yield('dashboard_script')
</body>

</html>
