<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Document</title>
    </head>
<body>
   Hola {{ $datosMensaje->usuario->nombre }}  {{ $datosMensaje->usuario->apellido }} te damos la bienvenida a Xiayi, para ingresar a la aplicación movil, podrá hacerlo con el uso de su correo electrónico y la siguiente contraseña:   {{ $datosMensaje->password }}.
</body>
</html>