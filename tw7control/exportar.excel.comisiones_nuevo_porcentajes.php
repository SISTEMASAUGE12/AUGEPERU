<?php  error_reporting(E_ALL); 
session_start();
$hora = time();

$name_archivo  = 'Reporte_comisiones__'.$_GET['fecha_filtro_inicio'].'_al_'.$_GET['fecha_filtro_fin'];
$title  = 'Reporte de Comisiones del: '.$_GET['fecha_filtro_inicio'].' al '.$_GET['fecha_filtro_fin'];


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


$cols   = array('USUARIO','BANCO','CUENTA','VENTAS PROPIAS	','S/ VENTAS PROPIAS','# COMPARTIDAS','S/ VENTAS COMPARTIDAS','VENTAS CLIENTE ANTIGUO','S/ VENTAS ANTIGUOS',' # CERTIFICADOS ','# LIBROS' ,'TOTAL VENDIDO','TOTAL A PAGAR 1.9%');
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
  // echo $_POST["sql"];

	$data=executesql($_GET["sql"]);  // viene del success 

  if( !empty($data) ) {
	$titee=0;
    
	foreach($data as $detalles) {
		$titee = $titee + 1;
			// aca sacamos vendas solo ventas propias 	- ventas nuevas		
			$sql_ventas_clientes_nuevos= "	SELECT SUM(tipo_venta) as n_ventas, SUM(total) as n_total_soles, pp.idusuario, uu.nomusuario as usuario, uu.nombre_corto as nombre_corto,  uu.comision, uu.banco, uu.cuenta_banco, uu.tipo_asesora  
				FROM `pedidos` pp 
				LEFT JOIN usuario uu ON pp.idusuario=uu.idusuario 
				where pp.estado_pago=1 and uu.idtipo_usu=4 and pp.tipo_venta=1 and pp.total > 0   and uu.idusuario='".$detalles["idusuario"]."' ";  


			// venta compartidas

			$sql_compartidas= "	SELECT SUM(pp.estado_idestado) as n_compartidas,  SUM(pp.estado_idestado) as suma_vcompar_que_el_realizo,  SUM(total) as total_venta_soles_compartida, pp.idusuario, uu.nomusuario as usuario, uu.nombre_corto as nombre_corto,  uu.comision, uu.banco, uu.cuenta_banco, uu.tipo_asesora  
							FROM `pedidos` pp 
							LEFT JOIN usuario uu ON pp.idusuario=uu.idusuario 
							where pp.estado_pago=1 and uu.idtipo_usu=4  and pp.estado_idestado=1 and pp.tipo_venta=2  and pp.total > 0 and uu.idusuario='".$detalles["idusuario"]."'  
						";  /* todos los que han comprado, solo salen las aprobadas para facturar */ 


			// ventas clientes antiguos : 
			// solo sumo la de ventas tipo de cursos; nose considerara las ventas de clientes antoguo para certificados ya que se paga una comision aparte por venta de certificado, asi que esas las excluiremos aqui 
			$sql_cliente_antiguo= 'select SUM(pe.tipo_venta=3) as total_ventas_sin_comision, sum(pe.total) as total_ventas_cliente_antiguos from pedidos pe where pe.estado_pago=1 and pe.estado_idestado=1  and pe.idusuario="'.$detalles["idusuario"].'" and pe.total >0  and pe.tipo_venta=3';
				
			// ventas certificados   
			$sql_venta_certificados= 'select SUM(pe.categoria_venta=2) as total_venta_certificados from pedidos pe where pe.estado_pago=1 and pe.categoria_venta=2 and pe.estado_idestado=1  and pe.idusuario="'.$detalles["idusuario"].'" ';
			
			// ventas libros   
			$sql_venta_libros= 'select SUM(pe.id_tipo=2) as total_venta_libros from suscritos_x_cursos pe where pe.estado=1 and pe.id_tipo=2 and pe.estado_idestado=1  and pe.idusuario="'.$detalles["idusuario"].'" ';
				

			if(!empty( $_GET['fecha_filtro_inicio']) && !empty($_GET['fecha_filtro_fin'])) {
				  $sql_ventas_clientes_nuevos .= " AND DATE(pp.fecha_registro)  BETWEEN  DATE('".$_GET['fecha_filtro_inicio']."')  and DATE('".$_GET['fecha_filtro_fin']."')  ";		


				  $sql_compartidas .= " AND DATE(pp.fecha_registro)  BETWEEN  DATE('".$_GET['fecha_filtro_inicio']."')  and DATE('".$_GET['fecha_filtro_fin']."')  ";		

				  $sql_cliente_antiguo .= " AND DATE(pe.fecha_registro)  BETWEEN  DATE('".$_GET['fecha_filtro_inicio']."')  and DATE('".$_GET['fecha_filtro_fin']."')  ";	

				$sql_venta_certificados .= " AND DATE(pe.fecha_registro)  BETWEEN  DATE('".$_GET['fecha_filtro_inicio']."')  and DATE('".$_GET['fecha_filtro_fin']."')  ";		
				
				$sql_venta_libros .= " AND DATE(pe.fecha_registro)  BETWEEN  DATE('".$_GET['fecha_filtro_inicio']."')  and DATE('".$_GET['fecha_filtro_fin']."')  ";		

			}


			$detalles["n_ventas"]=0;
			$detalles["n_total_soles"]=0;
			$detalles["n_compartidas"]=0;
			$detalles["suma_vcompar_que_el_realizo"]=0;
			$total_comision_compartida=0;

			// echo $sql_compartidas;	
			

			$ventas_clientes_nuevos=executesql($sql_ventas_clientes_nuevos);
			if(!empty($ventas_clientes_nuevos)){

				$detalles["n_ventas"]= 	$ventas_clientes_nuevos[0]["n_ventas"];
				$detalles["n_total_soles"]= 	$ventas_clientes_nuevos[0]["n_total_soles"];
			}
			
			
			$ventas_compartidas=executesql($sql_compartidas);
			if(!empty($ventas_compartidas)){

				$detalles["suma_vcompar_que_el_realizo"]= 	$ventas_compartidas[0]["suma_vcompar_que_el_realizo"];
				$total_comision_compartida = $detalles["total_venta_soles_compartida"] = 	$ventas_compartidas[0]["total_venta_soles_compartida"] ;						
			}
			

			// echo $comision cliente antoiguo 
			
			$detalles["total_ventas_cliente_antiguos"] =0;
			$comision_propia=0;
			$ventas_sin_copmision_antiguos=executesql($sql_cliente_antiguo);
			if(!empty($ventas_sin_copmision_antiguos)){
				$detalles["total_ventas_sin_comision"]  = $ventas_sin_copmision_antiguos[0]['total_ventas_sin_comision'];
				$detalles["total_ventas_cliente_antiguos"]  = $ventas_sin_copmision_antiguos[0]['total_ventas_cliente_antiguos'];
			}

			
			// echo $comision venta de certificados  			
			$detalles["total_ventas_certificados"] =0;
			$detalles["total_soles_certificados"] =0;
		
			// echo $comision venta de libros   			
			$detalles["total_ventas_libros"] =0;
			$detalles["total_soles_libros"] =0;


			$venta_certificado=executesql($sql_venta_certificados);
			if(!empty($venta_certificado)){
				$detalles["total_ventas_certificados"]  = $venta_certificado[0]['total_venta_certificados'];
				$detalles["total_soles_certificados"]  = $venta_certificado[0]['total_venta_certificados'] * 1;
				
				// $detalles["total_ventas_certificados"]  = "por_pagar";
				// $detalles["total_soles_certificados"]  = 1;
			}
			
			// LIBROS 
			$venta_libros=executesql($sql_venta_libros); 
			if(!empty($venta_libros)){
				$detalles["total_ventas_libros"]  = $venta_libros[0]['total_venta_libros'];
				$detalles["total_soles_libros"]  = $venta_libros[0]['total_venta_libros'] * 5;  // valor origen es por 5
				
				// $detalles["total_ventas_certificados"]  = "por_pagar";
				// $detalles["total_soles_certificados"]  = 1;
			}
			



			// include("lista_de_comision_actual.php"); // aca sale comiison propia 


			$detalles["monto_total_vendido"]=  $detalles["n_total_soles"]  + 	$total_comision_compartida + $detalles["total_ventas_cliente_antiguos"]; // comison de venta spropias 
			$detalles["total_a_pagar"]=     round($detalles["monto_total_vendido"] * 0.019, 2); // comison de venta spropias 


		echo "<tr>";
			// echo "<td>$titee</td>"; 
			echo "<td>".$detalles['usuario']."</td>";  		
			echo "<td>".$detalles['banco']."</td>";  		
			echo "<td>".$detalles['cuenta_banco']."</td>";  		
			echo "<td>".$detalles['n_ventas']."</td>";  		
			echo "<td>".$detalles['n_total_soles']."</td>";  		
			echo "<td>".$detalles['suma_vcompar_que_el_realizo']."</td>";  		
			echo "<td>".$detalles['total_venta_soles_compartida']."</td>";  		
			echo "<td>".$detalles['total_ventas_sin_comision']."</td>";  		
			echo "<td>".$detalles['total_ventas_cliente_antiguos']."</td>";  		
			echo "<td>".$detalles['total_ventas_certificados']."</td>";  		
			echo "<td>".$detalles['total_ventas_libros']."</td>";  		
			echo "<td>".$detalles['monto_total_vendido']."</td>";  		
			echo "<td>".$detalles['total_a_pagar']."</td>";  		
		echo '</tr>';

	} // end for 


  }else{
	  echo "<h3>No Hay Informaci&oacute;n en la Busqueda</h3>";
  }
 ?>
</table>

</body>
</html>


