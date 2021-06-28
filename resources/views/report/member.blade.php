
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
                  <td>Nombre</td>
                  <td>Cédula</td>
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
                        <td >{{ $item->groupAge ? $item->groupAge->name : '' }}</td>
                        <td>
                            @if (count($patologias) > 0)
                                {{ implode($patologias , ', ') }}
                            @else
                                Sin registro 
                            @endif
                        </td>
                        <td >
                            @if (count($discapacidades) > 0)
                                {{ implode($discapacidades , ', ') }}
                            @else
                                Sin registro
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
                    <td colspan="9">&nbsp;</td>
                </tr>
            </table>
        </main>
    </body>
</html>