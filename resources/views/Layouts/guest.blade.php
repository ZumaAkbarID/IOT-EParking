<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <link rel="stylesheet" href="{{ asset('/') }}assets/css/main/app-dark.css">
    <link rel="stylesheet" href="{{ asset('/') }}assets/css/main/app.css">

    <link rel="shortcut icon" href="{{ asset('/') }}assets/images/logo/favicon.png" type="image/x-icon">
    <link rel="shortcut icon" href="{{ asset('/') }}assets/images/logo/favicon.png" type="image/png">

    <link rel="stylesheet" href="{{ asset('/') }}assets/css/shared/iconly.css">

    <link rel="stylesheet" href="{{ asset('/') }}assets/extensions/sweetalert2/sweetalert2.min.css">
    @yield('guest_style')

</head>

<body class="theme-dark">
    <div id="app">
        <div id="main" class="layout-horizontal">

            @include('Layouts.guest-navbar')

            @yield('guest_content')

            @include('Layouts.footer')

        </div>
    </div>

    <script src="{{ asset('/') }}assets/extensions/jquery/jquery.min.js"></script>
    <script src="{{ asset('/') }}assets/js/bootstrap.js"></script>
    <script src="{{ asset('/') }}assets/js/app.js"></script>
    <script src="{{ asset('/') }}assets/js/switchTheme.js"></script>
    <script src="{{ asset('/') }}assets/js/pages/horizontal-layout.js"></script>
    <script src="{{ asset('/') }}assets/extensions/sweetalert2/sweetalert2.min.js"></script>

    @yield('guest_script')

</body>

</html>
