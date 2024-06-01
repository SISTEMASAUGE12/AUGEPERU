<?php 
 error_reporting(E_ALL); session_start();
$hora = time();
$name_archivo  = 'Reporte_clientes_certificados_'.$_GET['fecha_filtro_inicio'].'_al_'.$_GET['fecha_filtro_fin'];
$title  = 'Reporte de Clientes de Certificados : '.$_GET['fecha_filtro_inicio'].' al '.$_GET['fecha_filtro_fin'];

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


$cols   = array('FECHA','CODIGO','CERTIFICADO','ESPECIALIDAD','DNI','CLIENTE','EMAIL','CELULAR','ID COMPRA','S/total','ASIGNADO POR','ESTADO ASIGNACION','DPTO','PROV','DISTRITO','DIRECCION DESTINO','AGENCIA');
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

	$detalles["dni"] = strval($detalles["dni"]);


			if($detalles["estado_idestado"]==2){ 
				$detalles["estado_idestado"]= "Deshabilitado";
			}elseif($detalles["estado_idestado"]==1){ 
				$detalles["estado_idestado"]= "Habilitado";
			}else{ 
				$detalles["estado"]= "#no fount."; 
			}
			
			
			if($detalles["id_pedido"] == 0){  // SI FUE ASIGNADO DIRECTAMENTE 

					if( !empty($detalles["idusuario"])){  // se registra apartir del 22/0872022
						$usuario=executesql("select nomusuario from usuario where idusuario='".$detalles['idusuario']."' ");
						$detalles["nombre_corto"]=  $usuario[0]['nomusuario']." -  directamente ";
						
					}else{
						$detalles["nombre_corto"]= "ADMIN/gestion -  directamente ";
						
					}
		
			}else{
						$detalles["nombre_corto"]= $detalles["nombre_corto"].'  - '; 
			
						if($detalles["tipo_pago"] == 1){  // SI FUE ASIGNADO DIRECTAMENTE 
							$detalles["nombre_corto"].= "Transferencia";
						}else if($detalles["tipo_pago"] == 2){  // SI FUE ASIGNADO DIRECTAMENTE 
							$detalles["nombre_corto"].=  "Online";
						}else if($detalles["tipo_pago"] == 4){  // SI FUE ASIGNADO DIRECTAMENTE 
							$detalles["nombre_corto"].=  "PAGO MANUAL ";
						}else if($detalles["tipo_pago"] == 3){  // SI FUE ASIGNADO DIRECTAMENTE 
							echo "PAGO EFECTIVO";
						}else {
							$detalles["nombre_corto"].=  ' -- '; 
						}
			}
			


			// seguimiento. 
			$segui=executesql("select * from solicitudes where estado_idestado=1 and id_pedido='".$detalles["id_pedido"]."' and id_certificado='".$detalles["id_certificado"]."' ");

			if( !empty($segui[0]["direccion"]) ){
				$detalles["direccion_solicitud"]=  $segui[0]['direccion'];	
				
			}else{
				$detalles["direccion_solicitud"]=  ' puede ser una venta no manual';	

			}
		
			if( !empty($segui[0]["agencia"]) ){
				$detalles["agencia"]=  $segui[0]['agencia'];	
				
			}else{
				$detalles["agencia"]=  ' puede ser una venta no manual';	

			}
		
		
			if( !empty($segui[0]["iddpto"]) ){
				$dpto=executesql("select titulo from dptos where iddpto='".$segui[0]['iddpto']."' ");
				$detalles["iddpto"]=  $dpto[0]['titulo'];	
				
			}else{
				$detalles["iddpto"]=  ' - no tiene ubigeo enviado, puede ser una venta no manual';	

			}
		

			if( !empty($segui[0]["idprvc"]) ){
				$prvc=executesql("select titulo from prvc where idprvc='".$segui[0]['idprvc']."' ");
				$detalles["idprvc"]=  $prvc[0]['titulo'];	
				
			}else{
				$detalles["idprvc"]=  ' - no tiene ubigeo enviado, puede ser una venta no manual';	

			}
		

			if( !empty($segui[0]["iddist"]) ){							
				$dist=executesql("select titulo from dist where iddist='".$segui[0]['iddist']."' ");
				$detalles["iddist"]=  $dist[0]['titulo'];		
				
			}else{
				$detalles["iddist"]=  ' - no tiene ubigeo enviado, puede ser una venta no manual';	

			}
		
		
			

	echo "<tr>";
		echo "<td>".$detalles['fecha_registro']."</td>";  
		echo "<td>".$detalles['codigo']."</td>";  
		echo "<td>".$detalles['certificado']."</td>";  
		echo "<td>".$detalles['especialidad']."</td>";  
		echo "<td>".$detalles['dni']."</td>";  
		echo "<td>".$detalles['suscritos']."</td>";  
		echo "<td>".$detalles['email']."</td>";  
		echo "<td>".$detalles['telefono']."</td>";  
		echo "<td>".$detalles['id_pedido']."</td>";  
		echo "<td>".$detalles['total']."</td>";  
		echo "<td>".$detalles['nombre_corto']."</td>";  
		echo "<td>".$detalles['estado_idestado']."</td>";  
		echo "<td>".$detalles['iddpto']."</td>";  
		echo "<td>".$detalles['idprvc']."</td>";  
		echo "<td>".$detalles['iddist']."</td>";  
		echo "<td>".$detalles['direccion_solicitud']."</td>";  
		echo "<td>".$detalles['agencia']."</td>";  
		
	echo '</tr>';

  } // end for 

  }else{
	  echo "<h3>No Hay Informaci&oacute;n en la Busqueda</h3>";
  }
 ?>
</table>

</body>
</html>


