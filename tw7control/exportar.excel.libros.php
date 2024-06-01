<?php 
 error_reporting(E_ALL); session_start();
$hora = time();
$name_archivo  = 'Reporte_libros_a_entregar_'.$_GET['fecha_filtro_inicio'].'_al_'.$_GET['fecha_filtro_fin'];
$title  = 'Reporte de Libros a entregar : '.$_GET['fecha_filtro_inicio'].' al '.$_GET['fecha_filtro_fin'];

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


$cols   = array('ID VENTA','FECHA SOLICITUD','DNI','DOCENTE','EMAIL','TELEFONO','LIBRO','DPTO','PROVINCIA','DISTRITO','AGENCIA','SUCURSAL','DIRECCION','REFERENCIA','s/ ENVIO','TRACKING');
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
	<tr> <td colspan="16" align="center"><b><font size="+2"><?php echo $title; ?></font></b></td> </tr>
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
    
foreach($data as $detalles) {
	$titee = $titee + 1;
	
	if($detalles["estado"] == 1){
		$detalles["estado"]="ENTREGADO";
	}elseif($detalles["estado"] == 2){
		$detalles["estado"]="PENDIENTE";
	}elseif($detalles["estado"] == 3){
		$detalles["estado"]="RECHAZADO";
	}elseif($detalles["estado"] == 4){
	$detalles["estado"]="PROCESANDO";
	}elseif($detalles["estado"] == 5){
	$detalles["estado"]="ENVIADO";
		
	}
	
	if( !empty($detalles["certificado"])){
		$detalles["certificado"]= $detalles["cod_certi"].' - '.$detalles["certificado"];
	}
	
	
	if( !empty($detalles["curso"]) ){
		$detalles["curso"]= $detalles["cod_curso"].' - '.$detalles["curso"];
	}

	echo "<tr>";
		echo "<td>".$detalles['id_pedido']."</td>";  
		echo "<td>".$detalles['fecha_registro']."</td>";  
		echo "<td>".$detalles['dni']."</td>";  
		echo "<td>".$detalles['suscritos']."</td>";  
		echo "<td>".$detalles['email']."</td>";  
		echo "<td>".$detalles['telefono']."</td>";  
		echo "<td>".$detalles['curso']."</td>";  
		echo "<td>".$detalles['dpto']."</td>";  
		echo "<td>".$detalles['provincia']."</td>";  
		echo "<td>".$detalles['dist']."</td>";  
		echo "<td>".$detalles['agencia']."</td>";  
		echo "<td>".$detalles['sucursal']."</td>";  
		echo "<td>".$detalles['direccion']."</td>";  
		echo "<td>".$detalles['referencia']."</td>";  
		echo "<td>".$detalles['estado']."</td>";  
		echo "<td>".$detalles['precio_envio']."</td>";  
		echo "<td>".$detalles['tracking']."</td>";  				
	echo '</tr>';

  } // end for 

  }else{
	  echo "<h3>No Hay Informaci&oacute;n en la Busqueda</h3>";
  }
 ?>
</table>

</body>
</html>


