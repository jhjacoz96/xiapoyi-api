
<html>
    <head>
        <title>Reporte de las fichas familiares</title>
        @include('report.css')
    </head>
    <body>
        @include('report.header')
        @include('report.footer')
        <main>
            <div class="title">Reporte de ficha familiar</div>
            <br>
             <div class="section_title">Datos generales:</div>
            <table align="center" width="100%" style="background: #ebebeb" class="tab-font">
                <tr>
                    <td width="3%">&nbsp;</td>
                    <td width="94%">
                        <label for="p1">Cantón:</label><br>
                        <input type="text" value="
                            {{ $organization->canton->name }}
                        "/>
                    </td>
                    <td width="3%">&nbsp;</td>
                </tr>
                <tr>
                    <td width="3%">&nbsp;</td>
                    <td width="94%">
                        <label for="p1">Provincia:</label><br>
                        <input type="text" value="
                            {{ $organization->province->name }}
                        "/>
                    </td>
                    <td width="3%">&nbsp;</td>
                </tr>
                <tr>
                    <td width="3%">&nbsp;</td>
                    <td width="94%">
                        <label for="p1">Institución del sistema:</label><br>
                        <input type="text" value="
                            {{ $organization->institution->name }}
                        "/>
                    </td>
                    <td width="3%">&nbsp;</td>
                </tr>
                <tr>
                    <td width="3%">&nbsp;</td>
                    <td width="94%">
                        <label for="p1">Código de unidad operativa:</label><br>
                        <input type="text" value="
                            {{ $organization->code_uo }}
                        "/>
                    </td>
                    <td width="3%">&nbsp;</td>
                </tr>
                <!-- <tr>
                    <td width="3%">&nbsp;</td>
                    <td width="94%">
                        <label for="p1">Total de registros:</label><br>
                        <input type="text" value="
                            <?php $count = count($data) ?>
                            {{ $count }}
                        "/>
                    </td>
                    <td width="3%">&nbsp;</td>
                </tr> -->
                <tr style="line-height: 4px;">
                    <td colspan="4">&nbsp;</td>
                </tr>
            </table>
            <br>
            <table id="tblAcciones" align="center" width="100%"   class="tab-font">
                <tr>
                  <td>Numero de historia</td>
                  <td>Parroquia</td>
                  <td>Dirección</td>
                  <td>Numero de casa</td>
                  <td>Barrio</td>
                  <td>Nivel de riesgo</td>
                  <td>Grupo cultural</td>
                  <td>Telefono</td>
                  <td>Fecha</td>
                </tr>
                @foreach ($data as $item)
                    <tr>
                        <td width="6%">{{ $item->numero_historia }}</td>
                        <td width="11%">{{ $item->zone->name }}</td>
                        <td width="16%">{{ $item->direccion_habitual }}</td>
                        <td width="11%">{{ $item->numero_casa }}</td>
                        <td width="11%">{{ $item->barrio }}</td>
                        <td width="11%">{{ $item["levelTotal"] ? $item["levelTotal"]["name"] : '' }}</td>
                        <td width="11%">{{ $item->culturalGroup ? $item->culturalGroup->name : '' }}</td>
                        <td  width="11%">{{ $item->numero_telefono}}</td>
                        <td width="11%">{{  \Carbon\Carbon::parse($item->created_at)->format('d/m/Y') }}</td>
                    </tr>
                @endforeach
                <tr style="line-height: 4px;">
                    <td colspan="9">&nbsp;</td>
                </tr>
            </table>
        </main>
    </body>
</html>