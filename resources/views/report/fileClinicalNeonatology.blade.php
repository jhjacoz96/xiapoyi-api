<html>
    <head>
        <title>Reporte de fichas clínicas de neonatología</title>
        @include('report.css')
    </head>
    <body>
        @include('report.header')
        @include('report.footer')
        <main>
            <div class="title">Reporte estructurado de fichas clínicas de neonatologías</div>
            <br>
             <div class="section_title">Criterios de busqueda:</div>
            <table align="center" width="100%" style="background: #ebebeb" class="tab-font">
                <tr>
                    <td width="3%">&nbsp;</td>
                    <td width="94%">
                        <label for="p1">Edad gestacional:</label><br>
                        <input type="text" value="
                            {{ count($criterios['gestacion']) > 0 ? implode(', ', $criterios['gestacion']) : 'Todas' }}
                        "/>
                    </td>
                    <td width="3%">&nbsp;</td>
                </tr>
                <tr>
                    <td width="3%">&nbsp;</td>
                    <td width="94%">
                        <label for="p1">Genero:</label><br>
                        <input type="text" value="
                            {{ count($criterios['gender']) > 0 ? implode(', ', $criterios['gender']) : 'Todos' }}
                        "/>
                    </td>
                    <td width="3%">&nbsp;</td>
                </tr>
                <tr>
                    <td width="3%">&nbsp;</td>
                    <td width="94%">
                        <label for="p1">Rango de fecha de nacimiento:</label><br>
                        <input type="text" value="
                            {{ $criterios['startDate'] ? $criterios['startDate'] : ' ' }} - {{  $criterios['startDate'] ? $criterios['endDate'] : ' ' }}

                        "/>
                    </td>
                    <td width="3%">&nbsp;</td>
                </tr>
                <tr>
                    <td width="3%">&nbsp;</td>
                    <td width="94%">
                        <label for="p1">Rango de fecha de nacimiento:</label><br>
                        <input type="text" value="
                            {{ $criterios['startDate'] ? $criterios['startDate'] : ' ' }} - {{  $criterios['startDate'] ? $criterios['endDate'] : ' ' }}

                        "/>
                    </td>
                    <td width="3%">&nbsp;</td>
                </tr>
                <tr>
                    <td width="3%">&nbsp;</td>
                    <td width="94%">
                        <label for="p1">Vacuna bcg:</label><br>
                        <input type="text" value="
                            {{ count($criterios['bcg']) > 0 ? implode(', ', $criterios['bcg']) : '-' }}
                        "/>
                    </td>
                    <td width="3%">&nbsp;</td>
                </tr>
                <tr>
                    <td width="3%">&nbsp;</td>
                    <td width="94%">
                        <label for="p1">Vacuna hb:</label><br>
                        <input type="text" value="
                            {{ count($criterios['hb']) > 0 ? implode(', ', $criterios['hb']) : '-' }}
                        "/>
                    </td>
                    <td width="3%">&nbsp;</td>
                </tr>
                <tr>
                    <td width="3%">&nbsp;</td>
                    <td width="94%">
                        <label for="p1">Vacuna rotavirus:</label><br>
                        <input type="text" value="
                            {{ count($criterios['rotavirus']) > 0 ? implode(', ', $criterios['rotavirus']) : '-' }}
                        "/>
                    </td>
                    <td width="3%">&nbsp;</td>
                </tr>
                <tr>
                    <td width="3%">&nbsp;</td>
                    <td width="94%">
                        <label for="p1">Vacuna fipv:</label><br>
                        <input type="text" value="
                            {{ count($criterios['fipv']) > 0 ? implode(', ', $criterios['fipv']) : '-' }}
                        "/>
                    </td>
                    <td width="3%">&nbsp;</td>
                </tr>
                <tr>
                    <td width="3%">&nbsp;</td>
                    <td width="94%">
                        <label for="p1">Vacuna bopv:</label><br>
                        <input type="text" value="
                            {{ count($criterios['bopv']) > 0 ? implode(', ', $criterios['bopv']) : '-' }}
                        "/>
                    </td>
                    <td width="3%">&nbsp;</td>
                </tr>
                <tr>
                    <td width="3%">&nbsp;</td>
                    <td width="94%">
                        <label for="p1">Vacuna pentavaliente:</label><br>
                        <input type="text" value="
                            {{ count($criterios['pentavaliente']) > 0 ? implode(', ', $criterios['pentavaliente']) : '-' }}
                        "/>
                    </td>
                    <td width="3%">&nbsp;</td>
                </tr>
                <tr>
                    <td width="3%">&nbsp;</td>
                    <td width="94%">
                        <label for="p1">Vacuna neumococo:</label><br>
                        <input type="text" value="
                            {{ count($criterios['neumococo']) > 0 ? implode(', ', $criterios['neumococo']) : '-' }}
                        "/>
                    </td>
                    <td width="3%">&nbsp;</td>
                </tr>
                <tr>
                    <td width="3%">&nbsp;</td>
                    <td width="94%">
                        <label for="p1">Vacuna influenza estacionaria:</label><br>
                        <input type="text" value="
                            {{ count($criterios['influenza_estacionaria']) > 0 ? implode(', ', $criterios['influenza_estacionaria']) : '-' }}
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
                  <td>Nombre</td>
                  <td>Cédula</td>
                  <td>Genero</td>
                  <td>Peso (g)</td>
                  <td>Edad gestacional</td>
                  <td>Lugar de nacimiento</td>
                  <td>Fecha de nacimiento</td>
                </tr>
                @foreach ($data as $item)
                    <tr>
                        <td>{{ $item->numero_historia }}</td>
                        <td>{{ $item->member->nombre }} {{ $item->member->apellido }}</td>
                        <td>{{ $item->member->cedula }} </td>
                        <td>{{ $item->member->gender->nombre }}</td>
                        <td>
                            @if($item->peso)
                                {{ $item->peso }}
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
                        <td>{{ $item->lugar_naciento }}</td>
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