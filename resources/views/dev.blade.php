<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dev Only</title>
    <link rel="stylesheet" href="{{ asset('/') }}assets/extensions/sweetalert2/sweetalert2.min.css">
</head>

<body>
    <form action="" method="post">
        @csrf

        <label for="secret">Secret</label>
        <input type="password" name="secret" id="secret" required>
        <br>
        <br>
        <label for="type">Action</label>
        <select name="type" id="type" required>
            <option value="symlink">Symlink</option>
            <option value="migrate-fresh-seed">Migrate Fresh Seed</option>
            <option value="migrate-fresh">Migrate Fresh</option>
        </select>
        <br>
        <br>
        <label for="confirm">Apakah Kamu Melakukan Dengan Sadar?</label>
        <select name="confirm" id="confirm" required>
            <option value="tidak">Tidak</option>
            <option value="ya">Ya</option>
        </select>
        <br>
        <br>
        <button type="submit">Jalankan</button>


    </form>

    <script src="{{ asset('/') }}assets/extensions/sweetalert2/sweetalert2.min.js"></script>
    @include('Layouts.sweetalert2')
</body>

</html>
