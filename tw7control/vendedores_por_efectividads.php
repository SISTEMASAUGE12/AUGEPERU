<?php error_reporting(E_ALL ^ E_NOTICE);
include_once("auten.php");

if($_GET["task"]=='finder'){
  $array= array();

	if(!empty($_GET['fechabus_1']) && !empty($_GET['fechabus_2'])) {

			$sql_atenciones='';

			$meses=array('Jan'=>'Enero','Feb'=>'Febrero','Mar'=>'Marzo','Apr'=>'Abril','May'=>'Mayo','Jun'=>'Junio','Jul'=>'Julio','Aug'=>'Agosto','Sep'=>'Septiembre','Oct'=>'Octubre','Nov'=>'Noviembre','Dec'=>'Diciembre');
			
			$sql= "	
			SELECT u.idusuario , u.nomusuario as usuario , 
			(select SUM(su.estado_idestado=1) from suscritos su where u.idusuario = su.idusuario and DATE(su.fecha_registro)  BETWEEN  DATE('".$_GET['fechabus_1']."')  and DATE('".$_GET['fechabus_2']."')  ) total_cliente,
			(select SUM(pp.estado_idestado=1) from kardex_clientes pp where u.idusuario = pp.idusuario and DATE(pp.fecha_registro)  BETWEEN  DATE('".$_GET['fechabus_1']."')  and DATE('".$_GET['fechabus_2']."')  ) total_atenciones,
			(select SUM(pe.estado_pago=1) from pedidos pe where u.idusuario = pe.idusuario and  pe.estado_idestado=1 and  DATE(pe.fecha_registro)  BETWEEN  DATE('".$_GET['fechabus_1']."')  and DATE('".$_GET['fechabus_2']."')   ) total_ventas ,
			
			(select SUM(pe.tipo_venta=1)  from pedidos pe where u.idusuario = pe.idusuario and pe.estado_pago=1 and pe.estado_idestado=1  and  DATE(pe.fecha_registro)  BETWEEN  DATE('".$_GET['fechabus_1']."')  and DATE('".$_GET['fechabus_2']."')  ) total_ventas_propias, 

			(select SUM(pe.tipo_venta=2)  from pedidos pe where u.idusuario = pe.idusuario and pe.estado_pago=1 and pe.estado_idestado=1  and  DATE(pe.fecha_registro)  BETWEEN  DATE('".$_GET['fechabus_1']."')  and DATE('".$_GET['fechabus_2']."')  ) total_ventas_compartidas, 

			(select SUM(pe.tipo_venta=3)  from pedidos pe where u.idusuario = pe.idusuario and pe.estado_pago=1 and pe.estado_idestado=1  and  DATE(pe.fecha_registro)  BETWEEN  DATE('".$_GET['fechabus_1']."')  and DATE('".$_GET['fechabus_2']."')  ) total_ventas_sin_comision 

			FROM usuario u where u.idtipo_usu=4 and u.estado_idestado=1 and u.idusuario!=21 

			";  /* todos los que han comprado, solo salen las aprobadas para facturar */ 

			// sumo tipo_enta 1, venta propias comision completa. 
			
			if (isset($_GET['criterio_mostrar'])) $porPagina=$_GET['criterio_mostrar'];
		
			
			if(!empty($_GET['idusuario']) ){
					$sql .= " AND u.idusuario = '".$_GET['idusuario']."'";
			}


			if(isset($_SESSION['pagina2'])) {
					$_GET['pagina'] = $_SESSION['pagina2'];
			}
			
			if(isset($_GET['criterio_ordenar_por'])) $sql.= sprintf(" order by %s %s", fn_filtro($_GET['criterio_ordenar_por']), fn_filtro($_GET['criterio_orden']));
		
			$sql.= " 	ORDER BY  total_ventas_propias  DESC, total_cliente ASC ";
		
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
			$paging->pagina_proceso="vendedores_por_efectividads.php";
		?>

			<h3 style="color:green;">Formula: ( Produccion real: #Ventas_comision / Produccion esperada: #clientes) * 100 </h3>

			<table id="example1" class="table table-bordered table-striped">
				<!-- *EXCEL -->
				<?php  /*  Fechas para excel */ 
					$fecha_excel_inicio= !empty($_GET["fechabus_1"])?$_GET["fechabus_1"]:fecha_hora(1); 
				?>
				<input type="hidden" name="sql_excel" id="sql_excel" value="<?php echo $sql; ?>">
				<a href="javascript:fn_exportar('tipo_form=1&fecha_filtro_inicio=<?php echo $fecha_excel_inicio;?>&fecha_filtro_fin=<?php echo $_GET["fechabus_2"];?>','vendedores_efectividad');" class="btn btn-primary excel "  > Excel</a>
				<!--
			-->
				<tbody id="sort">          
		<?php 
				while ($detalles = $paging->fetchResultado()): 

					if(!in_array(array('mes' => $detalles['mes'], 'anho' => $detalles['anho']), $array)){
						$array[] = array('mes' => $detalles['mes'], 'anho' => $detalles['anho']);
		?>
					<!-- CABEZERAS  -->
						<tr role="row">
							<th class="sort cnone" width="160">VENDEDOR</th> 
							<th class="sort cnone" width="60">#Clientes</th> 
							<th class="sort cnone" width="60">#Atenciones</th> 
							<th class="sort cnone" width="60">#ventas</th> 
							<th class="sort cnone" width="60">#ventas comisionadas propias</th> 
							<th class="sort cnone" width="60">#ventas sin comision</th> 
							<th class="sort cnone" width="60">Efectividad</th> 
			

						
						</tr>
		<?php }//if meses 

		?>        
					<tr class=" text-center " id="order_<?php echo $detalles["idusuario"]; ?>" >
						<td class="cnone text-left "> <small><?php echo $detalles["idusuario"].' - '.$detalles["usuario"]; ?></small>		</td>
						<td class="cnone " > 							
							<b><?php echo $detalles['total_cliente']; ?></b>	
						</td>

						<td class="cnone " style="color:blue;"> <b><?php echo $detalles["total_atenciones"]; ?></b>		</td>
						<td class="cnone "> 						
							<span style="color:blue;"> <?php echo $detalles["total_ventas"]; ?> </span>
						</td>						
						<td class="cnone "> 
							<span style="color:green;font-weight:800;">v.comision: <?php echo ($detalles["total_ventas_propias"] +  $detalles["total_ventas_compartidas"]); ?> </span> </br>
							v.propias: <?php echo $detalles["total_ventas_propias"]; ?> </br>
							v.compartidas: <?php echo $detalles["total_ventas_compartidas"]; ?>  </br>
						</td>
						<td class="cnone "> 							
							<span style="color:red;">v.sin comision: <?php echo $detalles["total_ventas_sin_comision"]; ?> </span>
						</td>

						<td class="cnone " style="color:blue;"> 
							<?php
								// $efectividad= round($detalles["total_ventas"]*100/$detalles["total_cliente"],2);  // efectividad total ventas
								 $efectividad= round( ($detalles["total_ventas_propias"] + $detalles["total_ventas_compartidas"]) *100/$detalles["total_cliente"],2);  // efectividad total ventas comisionadas 

								if($efectividad > 100){
									$efectividad= '+100';
								}
							?> 
							<b> <?php echo $efectividad; ?> %</b>	
						</td>
						<!-- 5efectivbidad = ventas * 100/ clientes -->

						
					</tr>
		<?php endwhile; ?>
				</tbody>
			</table>
			<div class="pagination"><?php echo $paging->fetchNavegacion(); ?></div>
		<script>

		</script>

<?php 
	}else{
			echo "<h3 style='padding-top:40px;'>Ingresa rango de fecha a consultar. </h3>";
	} // end fecha obligatorias para listar

}else{ ?>

	<?php  if($_SESSION["visualiza"]["idtipo_usu"] ==1 || $_SESSION["visualiza"]["idtipo_usu"] ==13){ ?>

        <div class="box-body">
          <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
            <form action="javascript: fn_buscar();" id="frm_buscar" name="frm_buscar">
              <div class="bg-gray-light">						
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
var link = "vendedores_por_efectividad";/*la s final se agrega en js fuctions*/
var us = "pedido";/*sirve para mensaje en ventana eliminar*/
var l = "o";
var l2 = "e";/* est+ _ x {e,a,o ,etc}sirve para mensaje en ventana eliminar*/
var pr = "El";
var ar = "al";
var id = "id_pedido";
var mypage = "vendedores_por_efectividads.php";
</script>
<?php } ?>