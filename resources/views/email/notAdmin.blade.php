<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
</head>
<body>
    <h1>Administrador</h1>
    <p>Se registro un intento de acceder a un modulo no autorizado : </p>
    <p>Usuario : {{ $usuario }}</p>
    <p>Modulo Restringido: {{ $url }}</p>
</body>
</html>