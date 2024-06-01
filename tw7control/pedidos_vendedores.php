<?php error_reporting(E_ALL ^ E_NOTICE);
include_once("auten.php");


if($_GET["task"]=='finder'){
	if(!empty($_GET['fechabus_1']) && !empty($_GET['fechabus_2'])) {

			$array= array();
			$meses=array('Jan'=>'Enero','Feb'=>'Febrero','Mar'=>'Marzo','Apr'=>'Abril','May'=>'Mayo','Jun'=>'Junio','Jul'=>'Julio','Aug'=>'Agosto','Sep'=>'Septiembre','Oct'=>'Octubre','Nov'=>'Noviembre','Dec'=>'Diciembre');
			
			$sql= "	SELECT SUM(tipo_venta) as n_ventas, SUM(total) as n_total_soles, pp.idusuario, uu.nomusuario as usuario, uu.nombre_corto as nombre_corto,  uu.comision, uu.banco, uu.cuenta_banco, uu.tipo_asesora  
			FROM `pedidos` pp 
			LEFT JOIN usuario uu ON pp.idusuario=uu.idusuario 
			where pp.estado_pago=1 and uu.idtipo_usu=4 and pp.tipo_venta=1  and uu.idusuario !=21 
			";  /* todos los que han comprado, solo salen las aprobadas para facturar */ 
			
			// sumo tipo_enta 1, venta propias comision completa. 


			
			if (isset($_GET['criterio_mostrar'])) $porPagina=$_GET['criterio_mostrar'];
			
			
			if(!empty($_GET['idusuario']) ){
					$sql .= " AND pp.idusuario = '".$_GET['idusuario']."'";
			}


				if(!empty($_GET['fechabus_1']) && !empty($_GET['fechabus_2'])) {
					$sql .= " AND DATE(pp.fecha_registro)  BETWEEN  DATE('".$_GET['fechabus_1']."')  and DATE('".$_GET['fechabus_2']."')  ";		
			}

			
			if(isset($_SESSION['pagina2'])) {
					$_GET['pagina'] = $_SESSION['pagina2'];
			}
			
			if(isset($_GET['criterio_ordenar_por'])) $sql.= sprintf(" order by %s %s", fn_filtro($_GET['criterio_ordenar_por']), fn_filtro($_GET['criterio_orden']));
		$sql.= " GROUP by pp.idusuario  
		ORDER BY n_ventas DESC";
		
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
			$paging->pagina_proceso="pedidos_vendedores.php";
		?>

			<?php  
			/* 
			// para grafico barras 
			// echo $sql;
			$grafico=executesql($sql);
			if( !empty($grafico) ){ 
				$array_data_texto=array();
				$array_data_comision_total=array();

				foreach($grafico as $data_grafico){ 
				
						$sql_compartidas_grafi="select sum(pc.estado_idestado) as n_compartidas, sum(pc.comision) as total_comision_compartida 
							FROM pedidos_compartidos pc 
							WHERE pc.estado_idestado=1 and pc.idusuario='".$data_grafico["idusuario"]."' ";
						if(!empty($_GET['fechabus_1']) && !empty($_GET['fechabus_2'])) {
						$sql_compartidas_grafi .= " AND DATE(pc.fecha_registro)  BETWEEN  DATE('".$_GET['fechabus_1']."')  and DATE('".$_GET['fechabus_2']."')  ";		
						}
						// echo $sql_compartidas;	
						$ventas_compartidas_grafi=executesql($sql_compartidas_grafi);											
						$total_comisionar_grafico= $ventas_compartidas_grafi[0]["total_comision_compartida"] + ( $data_grafico["n_ventas"]* $data_grafico["comision"]); 

						$array_data_comision_total= array_merge($array_data_comision_total,array($total_comisionar_grafico));
						$array_data_texto= array_merge($array_data_texto,array($data_grafico['usuario']));
						
			?>

					
			<?php  
					}
					echo var_dump($array_data_texto);
			?>
				<script>	
					let valores_data_nombre = <?php echo $array_data_texto; ?>;
					alert(valores_data_nombre.length);
				</script>

			<?php 
			} // end grafico 
			*/
			?>


			<table id="example1" class="table table-bordered table-striped">
				<!-- *EXCEL -->
				<?php  /*  Fechas para excel */ 
					$fecha_excel_inicio= !empty($_GET["fechabus_1"])?$_GET["fechabus_1"]:fecha_hora(1); 
				?>
				<input type="hidden" name="sql_excel" id="sql_excel" value="<?php echo $sql; ?>">
				<a href="javascript:fn_exportar('tipo_form=1&fecha_filtro_inicio=<?php echo $fecha_excel_inicio;?>&fecha_filtro_fin=<?php echo $_GET["fechabus_2"];?>','comisiones');" class="btn btn-primary excel "  > Excel</a>
				
		
				<tbody id="sort">		
		<?php 
			$array_data_comision_total= array();
			$array_data_comision_propia= array();
			$array_data_comision_compartida= array();
			$array_data_nombre= array();

			while ($detalles = $paging->fetchResultado()): 
						$sql_compartidas="select sum(pc.estado_idestado) as n_compartidas, sum(pc.comision) as total_comision_compartida , sum(pc.tipo_compartido=1) as suma_vcompar_externas,  sum(pc.tipo_compartido=2) as suma_vcompar_que_el_realizo
														FROM pedidos_compartidos pc 
															WHERE pc.estado_idestado=1 and pc.idusuario='".$detalles["idusuario"]."' ";
					
					if(!empty($_GET['fechabus_1']) && !empty($_GET['fechabus_2'])) {
						$sql_compartidas .= " AND DATE(pc.fecha_registro)  BETWEEN  DATE('".$_GET['fechabus_1']."')  and DATE('".$_GET['fechabus_2']."')  ";		
					}

					 // echo $sql_compartidas;	
					$ventas_compartidas=executesql($sql_compartidas);

					if(!in_array(array('mes' => $detalles['mes'], 'anho' => $detalles['anho']), $array)){
						$array[] = array('mes' => $detalles['mes'], 'anho' => $detalles['anho']);
		?>
		<!-- 
						<tr class="lleva-mes">
							<td colspan="9"><h6><?php echo strtoupper(strtr(date('M Y',strtotime($detalles['fecha_registro'])),$meses)); ?></h6></td>
						</tr>
						-->
						<tr role="row">
							<th class="sort " width="160">USUARIO</th>
							<th class="sort cnone" width="160">BANCO</th>
							<th class="sort cnone" width="160">CUENTA</th>
							<!-- 
							<th class="sort cnone" width="200">#total s/</th>
							-->
							<th class="sort  " width="100">#v. propias</th>
							<th class="sort cnone" width="100">s/v. propia</th>
							<th class="sort  " width="120">#compartidas</th>
							<th class="sort cnone" width="80">s/ compartidas</th>
							<th class="sort  " width="100">s/ total comision</th>
						</tr>
		<?php }//if meses 

		if( $detalles["estado_pago"] == 2){ // por revisar 
			$fondo_entregar ="background:#F0A105; color:#fff !important; ";
		}elseif( $detalles["estado_pago"] == 1){  // aprobado
			$fondo_entregar ='';
		}elseif( $detalles["estado_pago"] == 3){ // rechazado 
			$fondo_entregar ='background:rgba(255,0,0,0.6); color:#fff !important;';
		}
		?>        
					<tr >
						
						<td class=" "> <?php echo $detalles["idusuario"].' - '.$detalles["usuario"]; ?></td>
						<td class="cnone"> <?php echo $detalles["banco"]; ?></td>
						<td class="cnone"> <?php echo $detalles["cuenta_banco"]; ?></td>
						<!-- 
						<td > S/<?php echo $detalles["n_total_soles"]; ?></td>
						-->
						<td class=" "> <?php echo $detalles["n_ventas"]; ?></td>
						<td class="cnone"> s/. <?php echo $comision_propia= $detalles["n_ventas"]* $detalles["comision"]; ?></td>
						<td class=" "> 
							<?php 
							$vcomp_realizo= $ventas_compartidas[0]["suma_vcompar_que_el_realizo"];
							$vcomp_ext= $ventas_compartidas[0]["suma_vcompar_externas"];

							if( $detalles["tipo_asesora"] ==1){ // oficina
								// $_tipo_asesora='5';
								$_tipo_asesora='0';
								$_tipo_asesora_realizo='0';
							}else if( $detalles["tipo_asesora"] ==2){ // vendedoras 
								// $_tipo_asesora='8';
								$_tipo_asesora='3';
								$_tipo_asesora_realizo='2';  // x2 
							}
							?>
							<?php echo $ventas_compartidas[0]["n_compartidas"]; ?> </br>
							<span style="color:blue;">realizo: (x<?php echo $_tipo_asesora_realizo; ?>):  <b><?php echo $vcomp_realizo; ?> </b> - s/<?php echo ($vcomp_realizo* $_tipo_asesora_realizo); ?> </span> </br>

							<span style="color:red;">
								 ext (x<?php echo $_tipo_asesora; ?>): <b> <?php echo $vcomp_ext; ?> </b> - S/<?php echo ($vcomp_ext * $_tipo_asesora ); ?>
							</span>
						</td>

						<td class="cnone"> s/. <?php echo $comision_compartida= $ventas_compartidas[0]["total_comision_compartida"]; ?></td>
						
						<?php $total_comisionar= $ventas_compartidas[0]["total_comision_compartida"] + ( $detalles["n_ventas"]* $detalles["comision"]); ?>
						<td class=" "> <b>s/. <?php echo $total_comisionar; ?> </b></td>
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

						var barChart = new Chart(densityCanvas, {
							type: 'bar',
							data: {
								//  labels: ["Mercury", "Venus", "Earth", "Mars", "Jupiter", "Saturn", "Uranus", "Neptune"],
								labels: array_data_nombre,						
								datasets: [densityData_comision_total,densityData_comision_propia,densityData_comision_compartida]						
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
var link = "pedidos_todo";/*la s final se agrega en js fuctions*/
var us = "pedido";/*sirve para mensaje en ventana eliminar*/
var l = "o";
var l2 = "e";/* est+ _ x {e,a,o ,etc}sirve para mensaje en ventana eliminar*/
var pr = "El";
var ar = "al";
var id = "id_pedido";
var mypage = "pedidos_vendedores.php";
</script>
<?php } ?>