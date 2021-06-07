<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Document</title>
    </head>
<body>
   Hola {{ $comentario->nombre }}, te informamos que hemos recibido tu {{ $tipoComentario->nombre }}.
   &nbsp;
   <strong>Respuesta:</strong> {{ $comentario->respuesta }}
</body>
</html>