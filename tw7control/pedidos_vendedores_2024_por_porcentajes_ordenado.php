<?php
error_reporting(E_ALL ^ E_NOTICE);
include_once("auten.php");

if ($_GET["task"] == 'finder') {
	if (!empty($_GET['fechabus_1']) && !empty($_GET['fechabus_2'])) {

		$array = array();
		$meses = array('Jan' => 'Enero', 'Feb' => 'Febrero', 'Mar' => 'Marzo', 'Apr' => 'Abril', 'May' => 'Mayo', 'Jun' => 'Junio', 'Jul' => 'Julio', 'Aug' => 'Agosto', 'Sep' => 'Septiembre', 'Oct' => 'Octubre', 'Nov' => 'Noviembre', 'Dec' => 'Diciembre');


		$usuarios = [];  // Array para almacenar todos los datos de los usuarios

		$sql = "SELECT uu.idusuario, uu.nomusuario as usuario, uu.nombre_corto as nombre_corto, uu.comision, uu.banco, uu.cuenta_banco, uu.tipo_asesora  
                FROM `usuario` uu 
                WHERE uu.estado_idestado=1 and uu.idtipo_usu=4 and uu.idusuario != 21";

		if (isset($_GET['criterio_mostrar'])) $porPagina = $_GET['criterio_mostrar'];


		if (!empty($_GET['idusuario'])) {
			$sql .= " AND uu.idusuario = '" . $_GET['idusuario'] . "'";
		}


		if (!empty($_GET['fechabus_1']) && !empty($_GET['fechabus_2'])) {
			//	$sql .= " AND DATE(pp.fecha_registro)  BETWEEN  DATE('".$_GET['fechabus_1']."')  and DATE('".$_GET['fechabus_2']."')  ";		
		}


		if (isset($_SESSION['pagina2'])) {
			$_GET['pagina'] = $_SESSION['pagina2'];
		}

		if (isset($_GET['criterio_ordenar_por'])) $sql .= sprintf(" order by %s %s", fn_filtro($_GET['criterio_ordenar_por']), fn_filtro($_GET['criterio_orden']));


		$paging = new PHPPaging;
		$paging->agregarConsulta($sql);
		$paging->porPagina(1000);
		$paging->ejecutar();

	/*  Fechas para excel */ 
					$fecha_excel_inicio= !empty($_GET["fechabus_1"])?$_GET["fechabus_1"]:fecha_hora(1); 
				?>
				<input type="hidden" name="sql_excel" id="sql_excel" value="<?php echo $sql; ?>">
				<a href="javascript:fn_exportar('tipo_form=1&fecha_filtro_inicio=<?php echo $fecha_excel_inicio;?>&fecha_filtro_fin=<?php echo $_GET["fechabus_2"];?>','comisiones_nuevo_porcentajes');" class="btn btn-primary excel "  > Excel</a>
				<?php
		while ($detalles = $paging->fetchResultado()) {
			// Ejecutar cada consulta SQL para obtener las métricas necesarias
			$ventas_clientes_nuevos = executesql("SELECT SUM(tipo_venta) as n_ventas, SUM(total) as n_total_soles FROM `pedidos` pp WHERE pp.estado_pago=1 and pp.idtipo_usu=4 and pp.estado_idestado=1 and pp.tipo_venta=1 and pp.total > 0 and pp.idusuario='" . $detalles["idusuario"] . "'");
			$ventas_compartidas = executesql("SELECT SUM(estado_idestado) as n_compartidas, SUM(total) as total_venta_soles_compartida FROM `pedidos` pp WHERE pp.estado_pago=1 and pp.idtipo_usu=4 and pp.estado_idestado=1 and pp.tipo_venta=2 and pp.total > 0 and pp.idusuario='" . $detalles["idusuario"] . "'");
			$ventas_sin_comision_antiguos = executesql("SELECT SUM(tipo_venta=3) as total_ventas_sin_comision, SUM(total) as total_ventas_cliente_antiguos FROM `pedidos` pe WHERE pe.estado_pago=1 and pe.estado_idestado=1 and pe.idusuario='" . $detalles["idusuario"] . "' and pe.total > 0 and pe.tipo_venta=3");
			$ventas_certificados = executesql("SELECT COUNT(*) as total_venta_certificados, SUM(total) as total_comision_certificado FROM `pedidos` pe WHERE pe.estado_pago=1 and pe.categoria_venta=2 and pe.estado_idestado=1 and pe.idusuario='" . $detalles["idusuario"] . "'");
			$ventas_libros = executesql("SELECT COUNT(*) as total_venta_libros, SUM(total) as total_comision_libros FROM `suscritos_x_cursos` pe WHERE pe.estado=1 and pe.id_tipo=2 and pe.estado_idestado=1 and pe.idusuario='" . $detalles["idusuario"] . "'");

			$total_comisionar = $ventas_clientes_nuevos[0]['n_total_soles'] + $ventas_compartidas[0]['total_venta_soles_compartida'] + $ventas_sin_comision_antiguos[0]['total_ventas_cliente_antiguos'];

			// Añade cada usuario y sus detalles calculados al array
			$usuarios[] = [
				'idusuario' => $detalles['idusuario'],
				'usuario' => $detalles['usuario'],
				'banco' => $detalles['banco'],
				'cuenta_banco' => $detalles['cuenta_banco'],
				'total_ventas_propias' => $ventas_clientes_nuevos[0]['n_total_soles'],
				'n_ventas_propias' => $ventas_clientes_nuevos[0]['n_ventas'],
				'n_ventas_compartidas' => $ventas_compartidas[0]['n_compartidas'],
				'total_ventas_compartidas' => $ventas_compartidas[0]['total_venta_soles_compartida'],
				'n_ventas_clientes_antiguos' => $ventas_sin_comision_antiguos[0]['total_ventas_sin_comision'],
				'total_ventas_clientes_antiguos' => $ventas_sin_comision_antiguos[0]['total_ventas_cliente_antiguos'],
				'n_ventas_certificados' => $ventas_certificados[0]['total_venta_certificados'],
				'total_comision_certificados' => $ventas_certificados[0]['total_comision_certificado'],
				'n_ventas_libros' => $ventas_libros[0]['total_venta_libros'],
				'total_comision_libros' => $ventas_libros[0]['total_comision_libros'],
				'total_comisionar' => $total_comisionar,
				'comision_cobrar' => round($total_comisionar * 0.019, 2)
			];
		}

		// Ordenar el array por total_comisionar
		usort($usuarios, function ($a, $b) {
			return $b['total_comisionar'] <=> $a['total_comisionar'];
		});

		// Mostrar los datos en una tabla
		echo '<table id="example1" class="table table-bordered table-striped">';
		echo '<thead>';
		echo '<tr>';
		echo '<th>USUARIO</th>';
		echo '<th>BANCO</th>';
		echo '<th>CUENTA</th>';
		echo '<th># V. Cursos Propias</th>';
		echo '<th>s/ VENTAS Propia</th>';
		echo '<th># Compartidas</th>';
		echo '<th>s/ VENTAS Compartidas</th>';
		echo '<th># Cliente Antiguo</th>';
		echo '<th>s/ VENTAS Cli Antiguo</th>';
		echo '<th># Ventas Certificados</th>';
		echo '<th>s/ Comisión Certificado</th>';
		echo '<th># Libros x5</th>';
		echo '<th>s/ Comisión Libros</th>';
		echo '<th>s/ Total VENTAS</th>';
		echo '<th>s/ COMISIÓN 1.9%</th>';
		echo '</tr>';
		echo '</thead>';
		echo '<tbody>';

		foreach ($usuarios as $usuario) {
			echo '<tr>';
			echo '<td>' . $usuario['usuario'] . '</td>';
			echo '<td>' . $usuario['banco'] . '</td>';
			echo '<td>' . $usuario['cuenta_banco'] . '</td>';
			echo '<td>' . $usuario['n_ventas_propias'] . '</td>';
			echo '<td>' . $usuario['total_ventas_propias'] . '</td>';
			echo '<td>' . $usuario['n_ventas_compartidas'] . '</td>';
			echo '<td>' . $usuario['total_ventas_compartidas'] . '</td>';
			echo '<td>' . $usuario['n_ventas_clientes_antiguos'] . '</td>';
			echo '<td>' . $usuario['total_ventas_clientes_antiguos'] . '</td>';
			echo '<td>' . $usuario['n_ventas_certificados'] . '</td>';
			echo '<td>' . $usuario['total_comision_certificados'] . '</td>';
			echo '<td>' . $usuario['n_ventas_libros'] . '</td>';
			echo '<td>' . $usuario['total_comision_libros'] . '</td>';
			echo '<td>' . $usuario['total_comisionar'] . '</td>';
			echo '<td>' . $usuario['comision_cobrar'] . '</td>';
			echo '</tr>';
		}

		echo '</tbody>';
		echo '</table>';
	} else {
		echo "<h3 style='padding-top:40px;'>Ingresa rango de fecha a consultar. </h3>";
	}
} else {
	?>

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

