<?php 
 error_reporting(E_ALL); session_start();
$hora = time();
header("Pragma: public");  
header("Expires: 0");  
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");  
header("Content-Type: application/force-download");  
header("Content-Type: application/octet-stream");  
header("Content-Type: application/download");  
header("Content-Disposition: attachment;filename=reporte_Clientes_del_curso__".$hora.".xls ");  
header("Content-Transfer-Encoding: binary ");

include_once("class/functions.php");
include_once("class/class.bd.php");

set_time_limit(950);
ini_set('memory_limit', '990M');
$style='mso-number-format:"@";';


$name_archivo  = 'Reporte_ventas_todos_pagadas_'.$_GET['fecha_filtro_inicio'].'_al_'.$_GET['fecha_filtro_fin'];
$title  = 'Reporte de Ventas pagadas: '.$_GET['fecha_filtro_inicio'].' al '.$_GET['fecha_filtro_fin'];

$cols   = array('FECHA','TIPO. COMPRA','COD. COMPRA','ESTADO DE PEDIDO','TOTAL S/','COD. TRANSACCIÓN','FECHA VOUCHER','BANCO','DNI CLIENTE','CLIENTE','EMAIL','# ITEMS','USUARIO');
$array_num = count($cols);

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
</head>

<body>
     
<!-- DIV DONDE SE MOSTRARÁ  LA TABLA DE CONTENIDOS -->
     <!--  <div id="contenido"></div> -->
      

<table cellspacing="0" cellpadding="0" width="100%" style="font-size:12px;">
	<tr> <td colspan="16" align="center"><b><font size="+2">Data CLIENTES POR CURSO</font></b></td> </tr>
	<tr>
<?php  for ($i = 0; $i < $array_num; ++$i){  ?>    
		<td style='background:#CCC; color:#000'><?PHP  echo $cols[$i]; ?></td>					
<?php } ?>
	</tr>


<?php
	 /*consultamos los datos*/
  // echo $_POST["sql"];

	$data=executesql($_GET["sql"]);  // viene del success 

  if( !empty($data) )   {
		$titee=0;
    
foreach($data as $row) {
	$titee = $titee + 1;	

	echo "<tr>";
		// echo "<td>$titee</td>"; 
		echo "<td>".$row['fecha_registro']."</td>";  
		echo "<td>".$row['tipo_pago']."</td>";  
		echo "<td>".$row['id_pedido']."</td>";  
		echo "<td>".$row['estado_pago']."</td>";  
		echo "<td>".$row['total']."</td>";  
		echo "<td>".$row['codigo_ope_off']."</td>";  
		echo "<td>".$row['fecha_pago_off']."</td>";  
		echo "<td>".$row['banco']."</td>";  
		echo "<td>".$row['dni']."</td>";  
		echo "<td>".$row['suscritos']."</td>";  
		echo "<td>".$row['email']."</td>";  
		echo "<td>".$row['articulos']."</td>";  
		echo "<td>".$row['usuario']."</td>";  		
	echo '</tr>';



  } // end for 

  }else{
	  echo "<h3>No Hay Informaci&oacute;n en la Busqueda</h3>";
  }
 ?>
</table>

</body>
</html>


