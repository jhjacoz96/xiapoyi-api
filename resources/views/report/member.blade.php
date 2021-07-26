<?php 
use App\Utils\CalAge;
use Carbon\Carbon;
?>
<html>
    <head>
        <title>Reporte de las fichas familiares</title>
        @include('report.css')
    </head>
    <body>
        @include('report.header')
        @include('report.footer')
        <main>
            <div class="title">Reporte estructurado de fichas familiares</div>
            <br>
             <div class="section_title">Criterios de busqueda:</div>
            <table align="center" width="100%" style="background: #ebebeb" class="tab-font">
                <tr>
                    <td width="3%">&nbsp;</td>
                    <td width="94%">
                        <label for="p1">Patología:</label><br>
                        <input type="text" value="
                            {{ count($criterios['pathology']) > 0 ? implode(', ', $criterios['pathology']) : 'Todas' }}
                        "/>
                    </td>
                    <td width="3%">&nbsp;</td>
                </tr>
                <tr>
                    <td width="3%">&nbsp;</td>
                    <td width="94%">
                        <label for="p1">Discapacidad:</label><br>
                        <input type="text" value="
                            {{ count($criterios['disability']) > 0 ? implode(', ', $criterios['disability']) : 'Todas' }}
                        "/>
                    </td>
                    <td width="3%">&nbsp;</td>
                </tr>
                <tr>
                    <td width="3%">&nbsp;</td>
                    <td width="94%">
                        <label for="p1">Grupo de edad:</label><br>
                        <input type="text" value="
                            {{ count($criterios['groupAge']) > 0 ? implode(', ', $criterios['groupAge']) : 'Todos' }}
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
                        <label for="p1">Esqueda de vacunación:</label><br>
                        <input type="text" value="
                            {{ $criterios['vaccine'] ? 'Completa' : 'Incompleta' }}
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
                  <td>Nombre</td>
                  <td>Cédula</td>
                  <td>Edad</td>
                  <td>Grupo de edad</td>
                  <td>Patologías</td>
                  <td>Discapacidades</td>
                  <td>Genero</td>
                  <td>Parroquia</td>
                  <td>Dirección</td>
                  <td>Vacunacíón</td>
                </tr>
                @foreach ($data as $item)
                    @php
                        $patologias = $item->pathologies->pluck('name')->toArray();
                        $discapacidades = $item->disabilities->pluck('name')->toArray();
                    @endphp
                    <tr>
                        <td >{{ $item->nombre }} {{ $item->apellido }}</td>
                        <td>{{ $item->cedula }}</td>
                        <td>{{ CalAge::get(Carbon::parse($item->fecha_nacimiento)) }}</td>
                        <td >{{ $item->groupAge ? $item->groupAge->name : '' }}</td>
                        <td>
                            @if (count($patologias) > 0)
                                {{ implode(", ", $patologias) }}
                            @else
                                -
                            @endif
                        </td>
                        <td >
                            @if (count($discapacidades) > 0)
                                {{ implode(", ", $discapacidades) }}
                            @else
                                -
                            @endif
                        </td>
                        <td >{{ $item->gender->nombre }}</td>
                        <td >{{ $item->fileFamily->zone ? $item->fileFamily->zone->name : '' }}</td>
                        <td >{{ $item->fileFamily->direccion_habitual }}</td>
                        <td>
                            @if ($item->vacunacion)
                            Completa
                            @else
                            Incompleta
                            @endif
                        </td>
                    </tr>
                @endforeach
                <tr style="line-height: 4px;">
                    <td colspan="10">&nbsp;</td>
                </tr>
            </table>
        </main>
    </body>
</html>