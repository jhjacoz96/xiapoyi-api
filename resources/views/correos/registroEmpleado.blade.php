<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Document</title>
    </head>
<body>
   Hola {{ $usuario->name }}, te damos la bienvenida a  KA-THANI. Para ingresar al panel administrativo podrás hacerlo con uso de los siguientes datos: <br>
   <table>
    <tr>
        <td>
         Correo electrónico:
        </td>
        <td>
         {{ $email }}
        </td>
    </tr>
    <tr>
        <td>
         Contraseña:
        </td>
        <td>
         {{ $password }}
        </td>
    </tr>
</table>
<br>
&nbsp;
<span>!Tu salud es nuestro compromiso!</span>
</body>
</html>