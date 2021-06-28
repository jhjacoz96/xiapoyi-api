<footer>
    <img src="{{ asset('image/bar.jpg') }}" class="line_foot"/><br><br>
    <table align="center" width="100%">
        <tr>
            <td align="left">Unidad operativa: {{ $organization ? $organization->name : ''  }}</td>
        </tr>
        <tr>
            <td align="left">Código de unidad operativa: {{ $organization ? $organization->code_uo  : ''  }}</td>
        </tr>
    </table>
</footer>
