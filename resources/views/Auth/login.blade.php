<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>LOGIN</title>
</head>

<body>
    <form action="" method="post">
        @csrf
        <label for="phone">Nomor HP</label>
        <input type="text" name="phone" id="phone">
        <br>
        <label for="password">Password</label>
        <input type="password" name="password" id="password">
        <br>
        <button type="submit">Login</button>
    </form>
</body>

</html>
