<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <link rel="stylesheet" href="{{ asset('/') }}assets/css/main/app.css">
    <link rel="stylesheet" href="{{ asset('/') }}assets/css/main/app-dark.css">

    <link rel="shortcut icon" href="{{ asset('/') }}assets/images/logo/favicon.svg" type="image/x-icon">
    <link rel="shortcut icon" href="{{ asset('/') }}assets/images/logo/favicon.png" type="image/png">
    @yield('guest_style')
</head>

<body class="theme-dark">

    <nav class="navbar navbar-light">
        <div class="container d-block">
            @if (!is_null(Request::segment(1)))
                <a href="{{ url('/') }}"><i class="bi bi-chevron-left"></i></a>
            @endif
            <a class="navbar-brand ms-4" href="{{ url('/') }}">
                <img src="{{ asset('/') }}assets/images/logo/logo.svg">
            </a>

        </div>
    </nav>


    @yield('guest_content')

    <script src="{{ asset('/') }}assets/extensions/jquery/jquery.min.js"></script>

    @yield('guest_script')
</body>

</html>
