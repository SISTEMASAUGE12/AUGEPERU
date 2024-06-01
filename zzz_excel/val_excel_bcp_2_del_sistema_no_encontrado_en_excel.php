<?php 
/* para generar excel  */
$hora = time();
header('Pragma: public');  
header('Expires: 0');  
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');  
header('Content-Type: application/force-download');  
header('Content-Type: application/octet-stream');  
header('Content-Type: application/download');  
header('Content-Disposition: attachment;filename=bcp_voucher_del_sistema_que_no_excel_'.$hora.'.xls ');  
header('Content-Transfer-Encoding: binary ');

set_time_limit(950);
ini_set('memory_limit', '990M');

?>
<table cellspacing='0' cellpadding='0' width='50%' style='font-size:18px;'>
<tr> <td colspan='4' align='center'><b><font size='+2'>VOUCHER <b>BCP</b> DEL SISTEMA NO ENCONTRADOS EN EL EXCEL </font></b></td> </tr>
<tr>
    <td style='background:#CCC; color:#000'>BANCO</td>
    <td style='background:#CCC; color:#000'>Fecha</td>
    <td style='background:#CCC; color:#000'>ID PEDIDO</td>
    <td style='background:#CCC; color:#000'>CODIGO OPERACION</td>
    <td style='background:#CCC; color:#000'>IMPORTE.</td>
    <td style='background:#CCC; color:#000'>VENDEDOR.</td>
</tr>
<?php 
  if( !empty($_POST["data_sistema_no_en_excel"]) ){
    echo $_POST["data_sistema_no_en_excel"];
  }else{
    echo "<h3> 0 resultados </h3>";
  }
  ?>
</table>
