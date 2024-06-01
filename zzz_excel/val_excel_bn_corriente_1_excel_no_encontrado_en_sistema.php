<?php 
/* para generar excel  */
$hora = time();
header('Pragma: public');  
header('Expires: 0');  
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');  
header('Content-Type: application/force-download');  
header('Content-Type: application/octet-stream');  
header('Content-Type: application/download');  
header('Content-Disposition: attachment;filename=bn_corriente_que_no_estan_en_sistema_'.$hora.'.xls ');  
header('Content-Transfer-Encoding: binary ');
?>
<table cellspacing='0' cellpadding='0' width='50%' style='font-size:18px;'>
<tr> <td colspan='4' align='center'><b><font size='+2'>VOUCHER <b>BN CORRIENTEs</b> NO ENCONTRADOS EN EL SISTEMA</font></b></td> </tr>
<tr>
    <td style='background:#CCC; color:#000'>Fecha</td>
    <td style='background:#CCC; color:#000'>DETALLE</td>
    <td style='background:#CCC; color:#000'>CODIGO OPERACION</td>
    <td style='background:#CCC; color:#000'>IMPORTE.</td>
</tr>
<?php 
  if( !empty($_POST["data_excel_no_sistema"]) ){
    echo $_POST["data_excel_no_sistema"];
  }else{
    echo "<h3> 0 resultados </h3>";
  }
  ?>
</table>
