<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciamento de TCC</title>
</head>
<body>
    @foreach ($teste as $t)
        <p>{{ $t->nome }}</p>
        <p>{{ $t->idade }}</p>
    @endforeach
</body>
</html>