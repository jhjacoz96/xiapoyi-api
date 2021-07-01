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
            <div class="title">Reporte de ficha clinica obstetrica</div>
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
                  <td>Número de historia</td>
                  <td>Nombre</td>
                  <td>Edad</td>
                  <td>Edad gestacional</td>
                  <td>Grupo de edad</td>
                  <td>Tipo de parto</td>
                  <td>Embarazo planificado</td>
                  <td>Causa embarazo</td>
                  <td>Embarazo activo</td>
                  <td>Fecha de incio</td>
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