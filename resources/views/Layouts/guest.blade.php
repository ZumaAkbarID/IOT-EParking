<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>

    <link rel="stylesheet" href="{{ asset('/') }}assets/css/main/app.css">
    <link rel="stylesheet" href="{{ asset('/') }}assets/css/main/app-dark.css">

    <link rel="shortcut icon" href="{{ asset('/') }}assets/images/logo/favicon.svg" type="image/x-icon">
    <link rel="shortcut icon" href="{{ asset('/') }}assets/images/logo/favicon.png" type="image/png">
</head>

<body class="dark">

    <script src="https://zuramai.github.io/mazer/demo/assets/js/initTheme.js"></script>

    <nav class="navbar navbar-light">
        <div class="container d-block">
            <a href="{{ url('/') }}"><i class="bi bi-chevron-left"></i></a>
            <a class="navbar-brand ms-4" href="{{ url('/') }}">
                <img src="{{ asset('/') }}assets/images/logo/logo.svg">
            </a>
        </div>
    </nav>


    <div class="container">
        <div class="card mt-5">
            <div class="card-header">
                <h4 class="card-title">Ini Halaman Landing Page</h4>
            </div>
            <div class="card-body">
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Soluta natus quaerat est, minus omnis
                    deleniti voluptate cupiditate nulla modi saepe laboriosam, quae corporis. Aliquam earum in hic
                    perferendis explicabo laboriosam. Sint quia, voluptas numquam possimus ipsum eligendi vitae dicta
                    facere hic dolorum quasi illo sapiente asperiores odit est? Amet deleniti debitis maiores odit?
                    Similique ad repellat soluta vel nihil quas, placeat, rem voluptatum, corporis velit sint quam
                    quisquam aperiam! Odit eligendi ut a eos commodi laudantium? Eos eveniet, distinctio, explicabo
                    eaque quo, at reprehenderit provident est quas ratione eum maxime dolorum? Sunt odio expedita
                    corporis accusantium animi voluptatem optio quis.</p>
            </div>
        </div>
    </div>

</body>

</html>
