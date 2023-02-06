<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Pengajuan</title>
</head>

<body>
    <form action="" method="post">
        @csrf
        <label for="submiter_name"></label>
        <input type="text" name="submiter_name" id="submiter_name" placeholder="Nama Pengaju">
        <br>

        <label for="submiter_phone_number"></label>
        <input type="text" name="submiter_phone_number" id="submiter_phone_number" placeholder="Nomor WA">
        <br>

        <label for="business_name"></label>
        <input type="text" name="business_name" id="business_name" placeholder="Nama Usaha">
        <br>

        <label for="business_description"></label>
        <textarea name="business_description" id="business_description" placeholder="Nama Usaha"></textarea>
        <br>

        <label for="business_address"></label>
        <textarea name="business_address" id="business_address" placeholder="Nama Usaha"></textarea>
        <br>

        <button type="submit">Ajukan</button>

    </form>
</body>

</html>
