<html>
    <head>
        <title>Reporte de fichas clínicas de neonatología</title>
        @include('report.css')
    </head>
    <body>
        @include('report.header')
        @include('report.footer')
        <main>
            <div class="title">Reporte de fichas clínicas de neonatología</div>
            <br>
             <div class="section_title">Datos generales:</div>
            <table align="center" width="100%" style="background: #ebebeb" class="tab-font">
                <tr>
                    <td width="3%">&nbsp;</td>
                    <td width="94%">
                        <label for="p1">Cantón:</label><br>
                        <input type="text" value="
                            {{ isset($organization->canton) ? $organization->canton->name : '' }}
                        "/>
                    </td>
                    <td width="3%">&nbsp;</td>
                </tr>
                <tr>
                    <td width="3%">&nbsp;</td>
                    <td width="94%">
                        <label for="p1">Provincia:</label><br>
                        <input type="text" value="
                            {{ isset( $organization->province) ? $organization->province->name : '' }}
                        "/>
                    </td>
                    <td width="3%">&nbsp;</td>
                </tr>
                <tr>
                    <td width="3%">&nbsp;</td>
                    <td width="94%">
                        <label for="p1">Total de registros:</label><br>
                        <input type="text" value="
                            <?php $count = count($data) ?>
                            {{ $count }}
                        "/>
                    </td>
                    <td width="3%">&nbsp;</td>
                </tr>
                <tr style="line-height: 4px;">
                    <td colspan="4">&nbsp;</td>
                </tr>
            </table>
            <br>
            <table id="tblAcciones" align="center" width="100%"   class="tab-font">
                <tr>
                  <td>Numero de historia</td>
                  <td>Nombre</td>
                  <td>Genero</td>
                  <td>Peso</td>
                  <td>Edad gestacional</td>
                  <td>Fecha de nacimiento</td>
                </tr>
                @foreach ($data as $item)
                    <tr>
                        <td>{{ $item->numero_historia }}</td>
                        <td>{{ $item->member->nombre }} {{ $item->member->apellido }}</td>
                        <td>{{ $item->member->gender->nombre }}</td>
                        <td>
                            @if($item->peso)
                                {{ $item->peso }} g
                            @else
                                -
                            @endif
                        </td>
                        <td>
                            @if($item->pregnant->descripcion_gestacion)
                                {{ $item->pregnant->descripcion_gestacion}}
                            @else
                                -
                            @endif
                        </td>
                        <td>{{ \Carbon\Carbon::parse($item->member->fecha_nacimiento)->format('d/m/Y') }}</td>
                    </tr>
                @endforeach
                <tr style="line-height: 4px;">
                    <td colspan="9">&nbsp;</td>
                </tr>
            </table>
        </main>
    </body>
</html>