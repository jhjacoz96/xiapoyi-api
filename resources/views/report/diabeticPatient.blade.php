<?php 
    use App\Utils\CalAge;
    use Carbon\Carbon;
?>
<html>
    <head>
        <title>Reporte de pacientes diabeticos</title>
        @include('report.css')
    </head>
    <body>
        @include('report.header')
        @include('report.footer')
        <main>
            <div class="title">Reporte de pacientes diabeticos</div>
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
                  <td>Genero</td>
                  <td>Grupo de edad</td>
                  <td>Edad</td>
                  <td>Tratamiento farmacológico</td>
                  <td>Patologías (Comorbidades)</td>
                  <td>Fecha de apertura historia</td>
                </tr>
                @foreach ($data as $item)
                    <?php 
                        $tratamientos = $item->medicines->pluck('name')->toArray();
                        $patologias = $item->member->pathologies->where("id",">=", 2)->pluck('name')->toArray();
                    ?>
                    <tr>
                        <td>{{ $item->member->nombre }} {{ $item->member->apellido }}</td>
                        <td>{{ $item->member->cedula }}</td>
                        <td>{{ $item->member->gender->nombre }}</td>
                        <td>{{ $item->member->groupAge->name }}</td>
                        <td>{{ CalAge::get(Carbon::parse($item->member->fecha_nacimiento)) }}</td>
                        <td>
                            @if (count($tratamientos) > 0)
                                {{ implode(", ", $tratamientos) }}
                            @else
                                -
                            @endif
                        </td>
                        <td>
                            @if (count($patologias) > 0)
                                {{ implode(", ", $patologias) }}
                            @else
                                -
                            @endif
                        </td>
                        <td>{{ Carbon::parse($item->created_at)->format('d/m/Y') }}</td>
                    </tr>
                @endforeach
                <tr style="line-height: 4px;">
                    <td colspan="8">&nbsp;</td>
                </tr>
            </table>
        </main>
    </body>
</html>