<?php 
use App\Utils\CalAge;
use Carbon\Carbon;
?>
<html>
    <head>
        <title>Reporte  de ficha clinica obtetrica</title>
        @include('report.css')
    </head>
    <body>
        @include('report.header')
        @include('report.footer')
        <main>
            <div class="title">Reporte estructurado de fichas clinicas de obstetrica</div>
            <br>
             <div class="section_title">Critrios de busqueda:</div>
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
                        <label for="p1">Tipo de parto:</label><br>
                        <input type="text" value="
                             {{ count($criterios['tipo_parto']) > 0 ? implode(', ', $criterios['tipo_parto']) : 'Todos' }}
                        "/>
                    </td>
                    <td width="3%">&nbsp;</td>
                </tr>
                <tr>
                    <td width="3%">&nbsp;</td>
                    <td width="94%">
                        <label for="p1">Embarazo planificado:</label><br>
                        <input type="text" value="
                             @if($criterios['embarazo_planificado'] === null)
                                Todos
                            @elseif($criterios['embarazo_planificado'] === true)
                                Si
                            @else
                                No
                            @endif
                        "/>
                    </td>
                    <td width="3%">&nbsp;</td>
                </tr>
                <tr>
                    <td width="3%">&nbsp;</td>
                    <td width="94%">
                        <label for="p1">Causa de embarazo:</label><br>
                        <input type="text" value="
                             {{ count($criterios['causa_embarazo']) > 0 ? implode(', ', $criterios['causa_embarazo']) : 'Todos' }}
                        "/>
                    </td>
                    <td width="3%">&nbsp;</td>
                </tr>
                <tr>
                    <td width="3%">&nbsp;</td>
                    <td width="94%">
                        <label for="p1">Estado:</label><br>
                        <input type="text" value="
                             @if($criterios['embarazo_planificado'] === null)
                                Todos
                            @elseif($criterios['embarazo_planificado'] === true)
                                Control activo
                            @else
                                Historial
                            @endif
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
                  <td>Número de historia</td>
                  <td>Nombre</td>
                  <td>Edad</td>
                  <td>Edad gestacional</td>
                  <td>Grupo de edad</td>
                  <td>Tipo de parto</td>
                  <td>Embarazo planificado</td>
                  <td>Causa embarazo</td>
                  <td>Embarazo activo</td>
                  <td>Fecha de apertura de historia</td>
                </tr>
                @foreach ($data as $item)
                    <tr>
                        <td>{{ $item->numero_historia }}</td>
                        <td>{{ $item->member->nombre }} {{ $item->member->apellido }}</td>
                        <td>{{ CalAge::get(Carbon::parse($item->member->fecha_nacimiento)) }}</td>
                        <td>
                            @if ($item->descripcion_gestacion)
                                {{ $item->descripcion_gestacion }}
                            @else
                                -
                            @endif
                        </td>
                        <td>{{ $item->member->groupAge->name }}</td>
                        <td>
                            @if ($item->tipo_parto)
                                {{ $item->tipo_parto }}
                            @else
                                -
                            @endif
                        </td>
                        <td>
                            @if ($item->embarazo_planificado !== null)
                                @if ($item->embarazo_planificado)
                                    Si
                                @else
                                    No
                                @endif
                            @else
                                -
                            @endif
                        </td>
                        <td>
                            @if ($item->causa_embarazo)
                                {{ $item->causa_embarazo }}
                            @else
                                -
                            @endif
                        </td>
                        <td>
                            @if ($item->member->embarazo)
                                Si
                            @else
                                No
                            @endif
                        </td>
                        <td>{{  \Carbon\Carbon::parse($item->created_at)->format('d/m/Y') }}</td>
                    </tr>
                @endforeach
                <tr style="line-height: 4px;">
                    <td colspan="10">&nbsp;</td>
                </tr>
            </table>
        </main>
    </body>
</html>