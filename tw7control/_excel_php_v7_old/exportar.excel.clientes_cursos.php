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

$name_archivo  = 'Reporte_clientes_cursos_'.$_GET['fecha_filtro_inicio'].' _al_ '.$_GET['fecha_filtro_fin'];
$title  = 'Reporte de Clientes Cursos: '.$_GET['fecha_filtro_inicio'].' al '.$_GET['fecha_filtro_fin'];


$cols   = array('FECHA','COD. CURSO','CURSO','ESPECIALIDAD','DNI','CLIENTE','EMAIL','CELULAR','ID COMPRA','S/total','ASIGNADO POR','ESTADO ASIGNACION');
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

  
  
	if($row["estado_idestado"]==2){ $row["estado_idestado"]= "Deshabilitado";
	}elseif($row["estado_idestado"]==1){ $row["estado_idestado"]= "Habilitado";
	}else{ $row["estado"]= "#no fount."; 
	}
	
	
	if($row["id_pedido"] == 0){  // SI FUE ASIGNADO DIRECTAMENTE 

		if( !empty($row["idusuario"])){  // se registra apartir del 22/0872022
		  $usuario=executesql("select nomusuario from usuario where idusuario='".$row['idusuario']."' ");
		  $row["nombre_corto"]=  $usuario[0]['nomusuario']." -  directamente ";
		  
		}else{
			$row["nombre_corto"]= "ADMIN/gestion -  directamente ";		  
		}

	  }else{
		$row["nombre_corto"]= $row["nombre_corto"].'  - '; 

		if($row["tipo_pago"] == 1){  // SI FUE ASIGNADO DIRECTAMENTE 
			$row["nombre_corto"].= "Transferencia";
		}else if($row["tipo_pago"] == 2){  // SI FUE ASIGNADO DIRECTAMENTE 
			$row["nombre_corto"].=  "Online";
		}else if($row["tipo_pago"] == 4){  // SI FUE ASIGNADO DIRECTAMENTE 
			$row["nombre_corto"].=  "PAGO MANUAL ";
		}else if($row["tipo_pago"] == 3){  // SI FUE ASIGNADO DIRECTAMENTE 
		  echo "PAGO EFECTIVO";
		}else {
			$row["nombre_corto"].=  ' -- '; 
		}
	  }



	echo "<tr>";
		// echo "<td>$titee</td>"; 
		echo "<td>".$row['fecha_registro']."</td>";  
		echo "<td>".$row['codigo']."</td>";  
		echo "<td>".$row['curso']."</td>";  
		echo "<td>".$row['especialidad']."</td>";  

		echo "<td>".$row['dni']."</td>";  
		echo "<td>".$row['suscritos']."</td>";  
		echo "<td>".$row['email']."</td>";  
		echo "<td>".$row['telefono']."</td>";  
		echo "<td>".$row['id_pedido']."</td>";  
		echo "<td>".$row['total']."</td>";  
		echo "<td>".$row['nombre_corto']."</td>";  
		echo "<td>".$row['estado_idestado']."</td>";  
	echo '</tr>';



  } // end for 

  }else{
	  echo "<h3>No Hay Informaci&oacute;n en la Busqueda</h3>";
  }
 ?>
</table>

</body>
</html>


