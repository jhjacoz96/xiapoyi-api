<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Document</title>
    </head>
<body>
   Hola {{ $suscriptor->nombre }}  te informamos que hemos dado de alta una nueva publicación, que podrás visualizar en nuestro portal web KA-THANI.
   &nbsp;
    Titulo de la publicación: <strong>{{ $publicacion->name }}</strong>
    &nbsp;
    @if ($publicacion->filterOnePublication)    
        ¿A quién va dirigido?: <strong>{{ $publicacion->filterOnePublication->name }}</strong>
        &nbsp;
    @endif
    @if ($publicacion->filterTwoPublication)    
        Patrón funcional general: <strong>{{ $publicacion->filterTwoPublication->name }}</strong>
        &nbsp;
    @endif
    @if ($publicacion->filterThreePublication != null)    
        Patrón funcional específico: <strong>{{ $publicacion->filterThreePublication->name }}</strong>
        &nbsp;
    @endif
    @if ($publicacion->resource)
        Tipo de recurso: <strong>{{ $publicacion->resource->type_resource }}</strong>
    @endif
</body>
</html>