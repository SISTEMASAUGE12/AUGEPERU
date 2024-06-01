<?php 
 error_reporting(E_ALL); session_start();
$hora = time();
$name_archivo  = 'Reporte_vendedoras_efectividad_'.$_GET['fecha_filtro_inicio'].'_al_'.$_GET['fecha_filtro_fin'];
$title  = 'Reporte de Vendedoras por Efectividad :  '.$_GET['fecha_filtro_inicio'].' al '.$_GET['fecha_filtro_fin'];

header("Pragma: public");  
header("Expires: 0");  
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");  
header("Content-Type: application/force-download");  
header("Content-Type: application/octet-stream");  
header("Content-Type: application/download");  
header("Content-Disposition: attachment;filename=".$name_archivo."__".$hora.".xls ");  
header("Content-Transfer-Encoding: binary ");

include_once("class/functions.php");
include_once("class/class.bd.php");

set_time_limit(950);
ini_set('memory_limit', '990M');
$style='mso-number-format:"@";';

$cols   = array('VENDEDOR','# CLIENTES','#. ATENCIONES','# VENTAS',' #VENTAS COMISIONES PROPIAS','# VENTAS  SIN COMISION ',' % EFECTIVIDAD');
$array_num = count($cols);

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
</head>

<body>

<table cellspacing="0" cellpadding="0" width="100%" style="font-size:12px;">
	<tr> <td colspan="16" align="center"><b><font size="+2"><?php echo $title; ?></font></b></td> </tr>
	<tr>
<?php  for ($i = 0; $i < $array_num; ++$i){  ?>    
		<td style='background:#CCC; color:#000'><?PHP  echo $cols[$i]; ?></td>					
<?php } ?>
	</tr>


<?php 
	$data=executesql($_GET["sql"]);  // viene del success 

  if( !empty($data) )   {
		$titee=0;
    
foreach($data as $detalles) {
	$titee = $titee + 1;	

	$total_cliente= !empty($detalles["total_cliente"])?$detalles["total_cliente"]:0;
	$total_ventas_propias= !empty($detalles["total_ventas_propias"])?$detalles["total_ventas_propias"]:0;
	$total_ventas_compartidas= !empty($detalles["total_ventas_compartidas"])?$detalles["total_ventas_compartidas"]:0;

	$detalles["total_venta_compartida"]=  $total_ventas_propias + $total_ventas_compartidas;

	if( $total_cliente > 0 ){
		$detalles["efectividad"]= round( ($total_ventas_propias + $total_ventas_compartidas) *100/ $total_cliente,2);  // efectividad total ventas comisionadas 
	}else{
		$detalles["efectividad"]= 0;  // efectividad total ventas comisionadas 
	}		
	
	
	if( $detalles["efectividad"] > 100){
		$detalles["efectividad"] = '+100';
	}
	
	echo "<tr>";
		echo "<td>".$detalles['usuario']."</td>";    
		echo "<td>".$detalles['total_cliente']."</td>";  
		echo "<td>".$detalles['total_atenciones']."</td>";  
		echo "<td>".$detalles['total_ventas']."</td>";  
		echo "<td>".$detalles['total_venta_compartida']."</td>";  
		echo "<td>".$detalles['total_ventas_sin_comision']."</td>";  		
		echo "<td>".$detalles['efectividad']."</td>";  		
			
	echo '</tr>';



  } // end for 

  }else{
	  echo "<h3>No Hay Informaci&oacute;n en la Busqueda</h3>";
  }
 ?>
</table>

</body>
</html>


