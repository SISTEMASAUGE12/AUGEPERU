<?php error_reporting(E_ALL ^ E_NOTICE);
include_once("auten.php");


if($_GET["task"]=='finder'){
	if(!empty($_GET['fechabus_1']) && !empty($_GET['fechabus_2'])) {

			$array= array();
			$meses=array('Jan'=>'Enero','Feb'=>'Febrero','Mar'=>'Marzo','Apr'=>'Abril','May'=>'Mayo','Jun'=>'Junio','Jul'=>'Julio','Aug'=>'Agosto','Sep'=>'Septiembre','Oct'=>'Octubre','Nov'=>'Noviembre','Dec'=>'Diciembre');
			
			// aca sacamos vendas solo ventas propias 			
			$sql= "	SELECT  uu.idusuario, uu.nomusuario as usuario, uu.nombre_corto as nombre_corto,  uu.comision, uu.banco, uu.cuenta_banco, uu.tipo_asesora  
			FROM `usuario` uu 
			where uu.estado_idestado=1 and uu.idtipo_usu=4 and uu.idusuario != 21 
			";  /* todos los que han comprado, solo salen las aprobadas para facturar */ 

			// pp.categoria_venta !=2  : las ventas de certificacdo no las consideramos ahora solo este script es para ventas propias
			// pp.categoria_venta == 3  :  las ventas de curso y libro si sumas como is fuera de solo cursos. 
			// pp.categoria_venta !=4  : las ventas de solo libros tampoco no las consideramos ahora solo este script es para ventas propias
			// pp.categoria_venta !=5  : ventas propias no se conte,plas las de cursos gratis 

			
			// sumo tipo_enta 1, venta propias comision completa. 


			
			if (isset($_GET['criterio_mostrar'])) $porPagina=$_GET['criterio_mostrar'];
			
			
			if(!empty($_GET['idusuario']) ){
					$sql .= " AND uu.idusuario = '".$_GET['idusuario']."'";
			}


			if(!empty($_GET['fechabus_1']) && !empty($_GET['fechabus_2'])) {
				//	$sql .= " AND DATE(pp.fecha_registro)  BETWEEN  DATE('".$_GET['fechabus_1']."')  and DATE('".$_GET['fechabus_2']."')  ";		
			}

			
			if(isset($_SESSION['pagina2'])) {
					$_GET['pagina'] = $_SESSION['pagina2'];
			}
			
			if(isset($_GET['criterio_ordenar_por'])) $sql.= sprintf(" order by %s %s", fn_filtro($_GET['criterio_ordenar_por']), fn_filtro($_GET['criterio_orden']));
			
			$sql.= "  ORDER BY idusuario asc ";
			// $sql.= "  ORDER BY total_comisiones DESC ";
		
		// echo  $sql; 
		
			$paging = new PHPPaging;
			$paging->agregarConsulta($sql); 
			$paging->div('div_listar');
			$paging->modo('desarrollo'); 
			$numregistro=1; 
			if($numregistro) $paging->porPagina(fn_filtro((int)$numregistro));
			$paging->verPost(true);
			$mantenerVar=array("criterio_mostrar","task","criterio_usu_per","criterio_ordenar_por","criterio_orden");
			$paging->mantenerVar($mantenerVar);
			$paging->porPagina(1000);
			$paging->ejecutar();
			$paging->pagina_proceso="pedidos_vendedores_2024_por_porcentajes.php";
		?>

				<!-- *EXCEL -->
				<?php  /*  Fechas para excel */ 
					$fecha_excel_inicio= !empty($_GET["fechabus_1"])?$_GET["fechabus_1"]:fecha_hora(1); 
				?>
				<input type="hidden" name="sql_excel" id="sql_excel" value="<?php echo $sql; ?>">
				<a href="javascript:fn_exportar('tipo_form=1&fecha_filtro_inicio=<?php echo $fecha_excel_inicio;?>&fecha_filtro_fin=<?php echo $_GET["fechabus_2"];?>','comisiones_nuevo_porcentajes');" class="btn btn-primary excel "  > Excel</a>
				
			<table id="example1" class="table table-bordered table-striped">
			
				<thead>
					<tr role="row">
						<th class="sort " width="160">USUARIO</th>
						<th class="sort cnone" width="160">BANCO</th>
						<th class="sort cnone" width="160">CUENTA</th>
						<!-- 
						<th class="sort cnone" width="200">#total que genero para la empresa </th>
						-->
						<th class="sort  " width="100">#v. cursos propias</th>
						<th class="sort cnone" width="100">s/VENTAS propia</th>

						<th class="sort  " width="120">#compartidas</th>
						<th class="sort cnone" width="80">s/VENTAS compartidas</th>

						<th class="sort  " width="120">#cliente antiguo</th>
						<th class="sort cnone" width="80">s/VENTAS cli antiguo</th>

						<th class="sort  " width="120">#ventas certificados</th>
						<th class="sort cnone  hide " width="80">s/Comision certificado</th>
						
						<th class="sort  " width="120"># libros x5</th>
						<th class="sort cnone  hide  " width="80">s/Comision libros</th>

						<th class="sort  " width="100">s/ total VENTAS</th>
						<th class="sort  " width="100">s/ COMISION 1.9%</th>
					</tr>
				</thead>
				<tbody id="sort">
				
						
		<?php 
			$array_data_comision_total= array();
			$array_data_comision_propia= array();
			$array_data_comision_compartida= array();
			$array_data_nombre= array();


			while ($detalles = $paging->fetchResultado()): 

						$ventas_clientes_nuevos[0]["n_ventas"]=0;
						$ventas_clientes_nuevos[0]["n_total_soles"]=0;
						// aca sacamos vendas solo ventas propias 	- ventas nuevas		

						$sql_ventas_clientes_nuevos= "	SELECT SUM(tipo_venta) as n_ventas, SUM(total) as n_total_soles, pp.idusuario, uu.nomusuario as usuario, uu.nombre_corto as nombre_corto,  uu.comision, uu.banco, uu.cuenta_banco, uu.tipo_asesora  
							FROM `pedidos` pp 
							LEFT JOIN usuario uu ON pp.idusuario=uu.idusuario 
							where pp.estado_pago=1 and uu.idtipo_usu=4  and pp.estado_idestado=1 and pp.tipo_venta=1 and pp.total > 0 and uu.idusuario='".$detalles["idusuario"]."'  
						";  /* todos los que han comprado, solo salen las aprobadas para facturar */ 

						// venta compartidas
						/*
						$sql_compartidas="select sum(pc.estado_idestado) as n_compartidas, sum(pc.comision) as total_comision_compartida , sum(pc.tipo_compartido=1) as suma_vcompar_externas,  sum(pc.tipo_compartido=2) as suma_vcompar_que_el_realizo, sum(pp.total) as total_venta_soles_compartida 
 														FROM pedidos_compartidos pc  
														INNER JOIN pedidos pp ON pc.id_pedido=pp.id_pedido  
														WHERE pc.estado_idestado=1 and pc.idusuario='".$detalles["idusuario"]."' and pp.estado_pago=1 ";
						
						*/

						$sql_compartidas= "	SELECT SUM(pp.estado_idestado) as n_compartidas,  SUM(pp.estado_idestado) as suma_vcompar_que_el_realizo,  SUM(total) as total_venta_soles_compartida, pp.idusuario, uu.nomusuario as usuario, uu.nombre_corto as nombre_corto,  uu.comision, uu.banco, uu.cuenta_banco, uu.tipo_asesora  
							FROM `pedidos` pp 
							LEFT JOIN usuario uu ON pp.idusuario=uu.idusuario 
							where pp.estado_pago=1 and uu.idtipo_usu=4  and pp.estado_idestado=1 and pp.tipo_venta=2 and pp.total > 0 and uu.idusuario='".$detalles["idusuario"]."'  
						";  /* todos los que han comprado, solo salen las aprobadas para facturar */ 


						// ventas clientes antiguos : 
						// solo sumo la de ventas tipo de cursos; nose considerara las ventas de clientes antoguo para certificados ya que se paga una comision aparte por venta de certificado, asi que esas las excluiremos aqui 
						$sql_cliente_antiguo= 'select SUM(pe.tipo_venta=3) as total_ventas_sin_comision, sum(pe.total) as total_ventas_cliente_antiguos from pedidos pe where pe.estado_pago=1 and pe.estado_idestado=1  and pe.idusuario="'.$detalles["idusuario"].'" and pe.total > 0 and pe.tipo_venta=3';
						 
						// ventas certificados   
						$sql_venta_certificados= 'select SUM(pe.categoria_venta=2) as total_venta_certificados from pedidos pe where pe.estado_pago=1 and pe.categoria_venta=2 and pe.estado_idestado=1  and pe.idusuario="'.$detalles["idusuario"].'" ';
						
						// ventas libros   
						$sql_venta_libros= 'select SUM(pe.id_tipo=2) as total_venta_libros from suscritos_x_cursos pe where pe.estado=1 and pe.id_tipo=2 and pe.estado_idestado=1  and pe.idusuario="'.$detalles["idusuario"].'" ';
						 

					if(!empty($_GET['fechabus_1']) && !empty($_GET['fechabus_2'])) {
						   $sql_ventas_clientes_nuevos .= " AND DATE(pp.fecha_registro)  BETWEEN  DATE('".$_GET['fechabus_1']."')  and DATE('".$_GET['fechabus_2']."')  ";		
						    $sql_compartidas .= " AND DATE(pp.fecha_registro)  BETWEEN  DATE('".$_GET['fechabus_1']."')  and DATE('".$_GET['fechabus_2']."')  ";		

						    $sql_cliente_antiguo .= " AND DATE(pe.fecha_registro)  BETWEEN  DATE('".$_GET['fechabus_1']."')  and DATE('".$_GET['fechabus_2']."')  ";		
						$sql_venta_certificados .= " AND DATE(pe.fecha_registro)  BETWEEN  DATE('".$_GET['fechabus_1']."')  and DATE('".$_GET['fechabus_2']."')  ";		
						$sql_venta_libros .= " AND DATE(pe.fecha_registro)  BETWEEN  DATE('".$_GET['fechabus_1']."')  and DATE('".$_GET['fechabus_2']."')  ";		
					}

					
					// echo $sql_cliente_antiguo; 
					// echo $sql_venta_certificados; 

					 // echo $sql_compartidas;	
					$ventas_clientes_nuevos=executesql($sql_ventas_clientes_nuevos);
					$ventas_compartidas=executesql($sql_compartidas);
					$ventas_sin_copmision_antiguos=executesql($sql_cliente_antiguo);  
					$ventas_certificados=executesql($sql_venta_certificados);  
					
					$ventas_libros=executesql($sql_venta_libros);  


	

		if( $detalles["estado_pago"] == 2){ // por revisar 
			$fondo_entregar ="background:#F0A105; color:#fff !important; ";
		}elseif( $detalles["estado_pago"] == 1){  // aprobado
			$fondo_entregar ='';
		}elseif( $detalles["estado_pago"] == 3){ // rechazado 
			$fondo_entregar ='background:rgba(255,0,0,0.6); color:#fff !important;';
		}
		?>        
					<tr >
						
						<td class=" ">
								<?php echo $detalles["idusuario"].' - '.$detalles["usuario"]; ?> <br>
								<small> 
									<?php 
									if( $detalles["tipo_asesora"] ==1){ // oficina 
										echo "oficina";		
									}else if( $detalles["tipo_asesora"] ==2){ // vendedoras 
										echo "ventas";												
									}
									
									?>
								</small> 
						</td>
						<td class="cnone"> <?php echo $detalles["banco"]; ?></td>
						<td class="cnone"> <?php echo $detalles["cuenta_banco"]; ?></td>
						<!-- 
						<td > S/<?php echo $detalles["n_total_soles"]; ?></td>
						-->
						
						<td class=" "> <?php echo ($ventas_clientes_nuevos[0]["n_ventas"] >0) ?$ventas_clientes_nuevos[0]["n_ventas"]:0; ?></td>
						<?php
						
					// include("lista_de_comision_actual.php");
					
						?>

						<td class="cnone"> s/. <?php echo $comision_propia= ($ventas_clientes_nuevos[0]["n_total_soles"] > 0) ?$ventas_clientes_nuevos[0]["n_total_soles"]:0; ?></td>

						<td class=" "> 
							<?php 
								echo $vcomp_realizo= $ventas_compartidas[0]["suma_vcompar_que_el_realizo"];							
						
							?>														
						</td>
						
						<td class="cnone"> s/ <?php  echo $comision_compartida= $ventas_compartidas[0]["total_venta_soles_compartida"]; ?></td>

						<!--  comision cliente antiguo -->
						<td class="cnone">  <?php echo $ventas_sin_copmision_antiguos[0]['total_ventas_sin_comision']; ?> </td>
						<td class="cnone"> s/  <?php echo $ventas_sin_copmision_antiguos[0]['total_ventas_cliente_antiguos']; ?></td>										
						
						<!--  comision ventas_certificados   -->						
						<td class="cnone">  <?php echo $ventas_certificados[0]['total_venta_certificados'];  ?> </td>
						<td class="cnone  hide "> s/  <?php echo $total_comision_certificado =  ($ventas_certificados[0]['total_venta_certificados'] *1) ;  ?></td>
						
						<!--  comision ventas_ libros x 5soles x libro    -->						
						<td class="cnone">  <?php echo $ventas_libros[0]['total_venta_libros'];  ?> </td> 
						<td class="cnone  hide "> s/  <?php echo $total_comision_libros =  ($ventas_libros[0]['total_venta_libros'] *5 ) ;  ?></td>
						

						<?php
							// $total_comisionar= $ventas_compartidas[0]["total_comision_compartida"] + ( $detalles["n_ventas"]* $detalles["comision"]);   // calculo anterior: propias + compartidas
							//$total_comisionar= $comision_propia + $comision_compartida + $ventas_sin_copmision_antiguos[0]['total_ventas_sin_comision'] + $total_comision_certificado + $total_comision_libros;   // calculo anterior: propias + compartidas
							$total_comisionar= $comision_propia + $comision_compartida + $ventas_sin_copmision_antiguos[0]['total_ventas_cliente_antiguos'] ;   // calculo anterior: propias + compartidas
							
						?>

						<td class=" "> <b>s/.  <?php echo $total_comisionar; ?> </b></td>
						<td class=" "> <b>s/.  <?php echo  $_total_comision_a_cobrar= round($total_comisionar * 0.019, 2); ?> </b></td>

					</tr>
		<?php 

				$array_data_comision_propia= array_merge($array_data_comision_propia,array($comision_propia));
				$array_data_comision_compartida= array_merge($array_data_comision_compartida,array($comision_compartida));
				$array_data_comision_total= array_merge($array_data_comision_total,array($total_comisionar));
				$array_data_nombre= array_merge($array_data_nombre,array($detalles['nombre_corto']));
					

				endwhile; ?>
				</tbody>
			</table>
			<div class="pagination"><?php echo $paging->fetchNavegacion(); ?></div>


		<div class="  _lleva_grafico_barras ">
				<canvas id="densityChart" class="_grafico_de_barras" ></canvas>
				<script>
						let array_data_nombre = <?php echo json_encode($array_data_nombre); ?>;
						let array_data_comision_propia = <?php echo json_encode($array_data_comision_propia); ?>;
						let array_data_comision_compartida = <?php echo json_encode($array_data_comision_compartida); ?>;
						let array_data_comision_total = <?php echo json_encode($array_data_comision_total); ?>;

						// alert(array_data_comision_total.length);				
						// alert(array_data_comision_total);

						var densityCanvas = document.getElementById("densityChart");
						Chart.defaults.global.defaultFontFamily = "Lato";
						Chart.defaults.global.defaultFontSize = 11;

						var densityData_comision_total = {
							label: 'Comisión total s/',
							// data: [5427, 5243, 5514, 3933, 1326, 687, 1271, 1638]
							data: array_data_comision_total,
							backgroundColor: 'rgba(219, 39, 28, 1)',
							borderColor: 'rgba(0, 99, 132, 1)'
						};

						/*
						var densityData_comision_propia = {
							label: 'Comisión propia s/',
							// data: [5427, 5243, 5514, 3933, 1326, 687, 1271, 1638]
							data: array_data_comision_propia,
							backgroundColor: 'rgba(72, 50, 73, 1)',
							borderColor: 'rgba(0, 99, 132, 1)'
						};
						
						var densityData_comision_compartida = {
							label: 'Comisión compartida s/',
							// data: [5427, 5243, 5514, 3933, 1326, 687, 1271, 1638]
							data: array_data_comision_compartida,
							backgroundColor: 'rgba(54, 44, 135, 1)',
							borderColor: 'rgba(0, 99, 132, 1)'
						};
						
						*/ 

						var barChart = new Chart(densityCanvas, {
							type: 'bar',
							data: {
								//  labels: ["Mercury", "Venus", "Earth", "Mars", "Jupiter", "Saturn", "Uranus", "Neptune"],
								labels: array_data_nombre,						
								// datasets: [densityData_comision_total,densityData_comision_propia,densityData_comision_compartida]			// salen 3 barras 			
								datasets: [densityData_comision_total]						
							}
						});						
				</script>
		</div> <!-- * end grafico -->


<?php
	}else{
		echo "<h3 style='padding-top:40px;'>Ingresa rango de fecha a consultar. </h3>";

	} // end obigarotio fecha

}else{ ?>

	<?php  if($_SESSION["visualiza"]["idtipo_usu"] ==1){ ?>

        <div class="box-body">
          <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
            <form action="javascript: fn_buscar();" id="frm_buscar" name="frm_buscar">
              <div class="bg-gray-light">
								<?php create_input('hidden','tipo_pago',$_GET["tipo_pago"],"form-control pull-right",$table,$agregados); ?>
                
								<div class="col-sm-1 criterio_buscar">
										<a href="dist/nueva_comision.xlsx" target="_blank"> <b>[ver tabla ] </b> </a>
								</div>
								<div class="col-sm-1 criterio_buscar">
										<select name="estado_pago" id="estado_pago" class="form-control" >
												<option value="" >ver todo</option>
												<option value="1" >Aprobados</option>
												<option value="2" >Pendientes</option>
												<option value="3" >Rechazados</option>
										</select>
								</div>
								<div class="col-sm-2 criterio_buscar" style="padding-bottom:8px;">
											<?php crearselect("idusuario", "select idusuario, nomusuario from usuario where estado_idestado=1 order by nomusuario asc", 'class="form-control"  style="border:1px solid #CA3A2B;" ', '', " -- vendedor -- "); ?>
										</div>
											
											
							 <div class="col-sm-7 criterio_mostrar">
									<div class="lleva_flechas" style="position:relative;">
										<label>Desde:</label>
										<?php create_input('date', 'fechabus_1', '', "form-control pull-right", $table, ''); ?>
									</div>
									<div class="lleva_flechas" style="position:relative;">
										<label>Hasta:</label>
										<?php create_input('date', 'fechabus_2', '', "form-control pull-right", $table, ''); ?>
									</div>
										<button>Buscar</button>
								</div>  
								
              
              </div>
            </form>
            <div class="row">
              <div class="col-sm-12">
                <div id="div_listar"></div>
                <div id="div_oculto" style="display: none;"></div>
              </div>
            </div>
            </div>
        </div>
	<?php }else{
		 echo "<div style='padding:90px 0;text-align:center;'> <p>  No tienes permiso a este modulo. </p></div>";
	} 
	?>

<script>
var link = "pedidos_vendedores_2024_por_porcentaje";/*la s final se agrega en js fuctions*/
var us = "pedido";/*sirve para mensaje en ventana eliminar*/
var l = "o";
var l2 = "e";/* est+ _ x {e,a,o ,etc}sirve para mensaje en ventana eliminar*/
var pr = "El";
var ar = "al";
var id = "id_pedido";
var mypage = "pedidos_vendedores_2024_por_porcentajes.php";
</script>
<?php } ?>