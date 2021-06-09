<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Document</title>
    </head>
<body>
   Hola {{ $usuario->nombre }}  {{ $usuario->apellido }} te damos la bienvenida a KA-THANI. Para ingresar a la aplicación móvil, deberás usar los siguientes datos: <br> 
   &nbsp;
   <table>
       <tr>
           <td>
            Correo electrónico:
           </td>
           <td>
            {{ $usuario->correo }}
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