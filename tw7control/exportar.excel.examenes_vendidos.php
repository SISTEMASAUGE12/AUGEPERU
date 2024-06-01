<?php 
 error_reporting(E_ALL); session_start();
$hora = time();
$name_archivo  = 'Reporte_examenes_comprados__'.$_GET['fecha_filtro_inicio'].'_al_'.$_GET['fecha_filtro_fin'];
$title  = 'Reporte de examenes comprados:: '.$_GET['fecha_filtro_inicio'].' al '.$_GET['fecha_filtro_fin'];

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


$cols   = array('FECHA','COD. COMPRA','TIPO DE COMPRA','ID examen','EXAMEN','PRECIO','DNI','CLIENTE','CELULAR');
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

	if($detalles["tipo_pago"]==2){ $detalles["tipo_pago"]= "Online";
	}elseif($detalles["tipo_pago"]==1){ $detalles["tipo_pago"]= "Offline";  
	}elseif($detalles["tipo_pago"]==3){ $detalles["tipo_pago"]= "Pago efectivo";  
	}elseif($detalles["tipo_pago"]==4){ $detalles["tipo_pago"]= "Manual";  
	}else{ $detalles["tipo_pago"]= "#no fount."; 
	}

	echo "<tr>";
		echo "<td>".$detalles['fecha_registro']."</td>";  				
		echo "<td>".$detalles['codped']."</td>";  				
		echo "<td>".$detalles['tipo_pago']."</td>";  				
		echo "<td>".$detalles['id_examen']."</td>";  				
		echo "<td>".$detalles['examen']."</td>";  				
		echo "<td>".$detalles['precio']."</td>";  				
		echo "<td>".$detalles['dni']."</td>";  				
		echo "<td>".$detalles['suscritos']."</td>";  				
		echo "<td>".$detalles['telefono']."</td>";  				
								 		
	echo '</tr>';



  } // end for 

  }else{
	  echo "<h3>No Hay Informaci&oacute;n en la Busqueda</h3>";
  }
 ?>
</table>

</body>
</html>


