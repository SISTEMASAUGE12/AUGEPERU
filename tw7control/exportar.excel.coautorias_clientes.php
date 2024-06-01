<?php 
 error_reporting(E_ALL); session_start();
$hora = time();
$name_archivo  = 'Reporte_coautorias_clientes__'.$_GET['fecha_filtro_inicio'].'_al_'.$_GET['fecha_filtro_fin'];
$title  = 'Reporte de CoAutorías Clientes: '.$_GET['fecha_filtro_inicio'].' al '.$_GET['fecha_filtro_fin'];

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

$cols   = array('FECHA','COD. CURSO','CURSO','DNI','CLIENTE','EMAIL','CELULAR','ESTADO DE LA COAUTORIA');
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

	if($detalles["estado"]==2){ $detalles["estado"]= "Pendiente";
	}elseif($detalles["estado"]==1){ $detalles["estado"]= "Aprobado";  
	}elseif($detalles["estado"]==3){ $detalles["estado"]= "Rechazado"; 
	}else{ $detalles["estado"]= "#no fount."; 
	}

	echo "<tr>";
		echo "<td>".$detalles['fecha_registro']."</td>";  				
		echo "<td>".$detalles['codigo']."</td>";  				
		echo "<td>".$detalles['curso']."</td>";  				
		echo "<td>".$detalles['dni']."</td>";  				
		echo "<td>".$detalles['suscritos']."</td>";  				
		echo "<td>".$detalles['email']."</td>";  				
		echo "<td>".$detalles['telefono']."</td>";  				
		echo "<td>".$detalles['estado']."</td>";  								 		
	echo '</tr>';



  } // end for 

  }else{
	  echo "<h3>No Hay Informaci&oacute;n en la Busqueda</h3>";
  }
 ?>
</table>

</body>
</html>


