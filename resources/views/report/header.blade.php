<?php 
    use Carbon\Carbon;
 ?>
<script type="text/php">
    if (isset($pdf)) { 

     $font = Font_Metrics::get_font("helvetica", "bold"); 
     $pdf->page_text(500,10, "Page: {PAGE_NUM} of {PAGE_COUNT}", $font, 6, array(0,0,0)); 

    } 
</script>
<header>
    <table align="center" width="100%">
    	<tr>
    		<td width="25%" align="left"><img src="{{ asset('/image/logo3.png') }}" class="img-logo" /></td>
            <td width="50%" align="center" class="titulo">&nbsp;</td>
    		<td width="25%" align="right" style="line-height: 80%;">Fecha: {{  Carbon::now()->format('Y-m-d') }}</td>
    	</tr>
    </table>
    <img src="{{ asset('image/bar.jpg') }}" class="line"/>
</header>