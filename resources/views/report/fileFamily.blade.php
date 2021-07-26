
<html>
    <head>
        <title>Reporte de miembros</title>
        @include('report.css')
    </head>
    <body>
        @include('report.header')
        @include('report.footer')
        <main>
            <div class="title">Reporte estructurado de miembros</div>
            <br>
             <div class="section_title">Criterios de busqueda:</div>
            <table align="center" width="100%" style="background: #ebebeb" class="tab-font">
                <!-- <tr>
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
                        <label for="p1">Cantón:</label><br>
                        <input type="text" value="
                            {{ isset($organization->canton) ? $organization->canton->name : '' }}
                        "/>
                    </td>
                    <td width="3%">&nbsp;</td>
                </tr> -->
                <tr>
                    <td width="3%">&nbsp;</td>
                    <td width="94%">
                        <label for="p1">Parroquias:</label><br>
                        <input type="text" value="
                            {{ count($criterios['zone']) > 0 ? implode(', ', $criterios['zone']) : 'Todas' }}
                        "/>
                    </td>
                    <td width="3%">&nbsp;</td>
                </tr>
                <tr>
                    <td width="3%">&nbsp;</td>
                    <td width="94%">
                        <label for="p1">Niveles de riesgos:</label><br>
                        <input type="text" value="
                            {{ count($criterios['levelTotalRisk']) > 0 ? implode(', ', $criterios['levelTotalRisk']) : 'Todos' }}
                        "/>
                    </td>
                    <td width="3%">&nbsp;</td>
                </tr>
                <tr>
                    <td width="3%">&nbsp;</td>
                    <td width="94%">
                        <label for="p1">Niveles de riesgos:</label><br>
                        <input type="text" value="
                            {{ count($criterios['levelTotalRisk']) > 0 ? implode(', ', $criterios['levelTotalRisk']) : 'Todos' }}
                        "/>
                    </td>
                    <td width="3%">&nbsp;</td>
                </tr>
                <tr>
                    <td width="3%">&nbsp;</td>
                    <td width="94%">
                        <label for="p1">Grupos culturles:</label><br>
                        <input type="text" value="
                            {{ count($criterios['culturalGroup']) > 0 ? implode(', ', $criterios['culturalGroup']) : 'Todos' }}
                        "/>
                    </td>
                    <td width="3%">&nbsp;</td>
                </tr>
                <tr>
                    <td width="3%">&nbsp;</td>
                    <td width="94%">
                        <label for="p1">Contaminantes:</label><br>
                        <input type="text" value="
                            {{ count($criterios['contamination']) > 0 ? implode(', ', $criterios['contamination']) : 'Todos' }}
                        "/>
                    </td>
                    <td width="3%">&nbsp;</td>
                </tr>
                <tr>
                    <td width="3%">&nbsp;</td>
                    <td width="94%">
                        <label for="p1">Rango de fecha apertura:</label><br>
                        <input type="text" value="
                            {{ $criterios['startDate'] ? \Carbon\Carbon::parse($criterios['startDate'])->format('d/m/Y') : '' }} {{ $criterios['startDate']  ? '-' : '-' }} {{  $criterios['startDate'] ? \Carbon\Carbon::parse($criterios['endDate'])->format('d/m/Y') : '-' }}
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
            <table id="tblAcciones" style="page-break-inside: auto;" align="center" width="100%"   class="tab-font">
                <tr>
                  <td>Numero de historia</td>
                  <td>Numero de familia</td>
                  <td>Parroquia</td>
                  <td>Barrio</td>
                  <td>Dirección</td>
                  <td>Telefono de casa</td>
                  <td>Nivel de riesgo</td>
                  <td>Grupo cultural</td>
                  <td>Contaminación</td>
                  <td>Fecha de apertura</td>
                </tr>
                @foreach ($data as $item)
                    <?php
                        $contaminacion = $item->contaminationPoints;
                        $arrayContaminacion  = $contaminacion->map(function($query){
                            return $query->contamination ? $query->contamination->nombre : null;
                        })->toArray();
                    ?>
                    <tr>
                        <td>{{ $item->numero_historia }}</td>
                        <td>{{ $item->numero_familia }}</td>
                        <td>{{ $item->zone->name }}</td>
                        <td>{{ $item->barrio }}</td>
                        <td>{{ $item->direccion_habitual }}</td>
                        <td>{{ $item->numero_telefono}}</td>
                        <td>{{ $item["levelTotal"] ? $item["levelTotal"]["name"] : '-' }}</td>
                        <td>{{ $item->culturalGroup ? $item->culturalGroup->name : '-' }}</td>
                        <td>{{ count($arrayContaminacion) > 0 ?implode(", ", $arrayContaminacion) : '-' }}</td>
                        <td>{{ \Carbon\Carbon::parse( $item->created_at)->format('d/m/Y') ?? '' }}</td>
                    </tr>
                @endforeach
                <tr style="line-height: 4px;">
                    <td colspan="10">&nbsp;</td>
                </tr>
            </table>
        </main>
    </body>
</html>