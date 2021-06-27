<footer>
    <img src="{{ public_path('img/bar.jpg') }}" class="line_foot"/><br><br>
    <table align="center" width="100%">
        <tr>
            <td align="left">Centro de salud: {{ $organization ? $organization->name : ''  }}</td>
        </tr>
    </table>
</footer>
