<?php error_reporting(E_ALL ^ E_NOTICE);
include_once("auten.php");

if($_GET["task"]=='finder'){
  $array= array();
	$meses=array('Jan'=>'Enero','Feb'=>'Febrero','Mar'=>'Marzo','Apr'=>'Abril','May'=>'Mayo','Jun'=>'Junio','Jul'=>'Julio','Aug'=>'Agosto','Sep'=>'Septiembre','Oct'=>'Octubre','Nov'=>'Noviembre','Dec'=>'Diciembre');
		
  $sql= "SELECT sc.*, sc.estado as estado_sxc ,YEAR(sc.fecha_registro) as anho, MONTH(sc.fecha_registro) as mes, e.nombre AS estado ,s.email as email,  CONCAT(s.nombre,' ',s.ap_pa,' ',s.ap_ma )as suscritos , s.dni as dni, s.telefono, pp.codigo as codped, c.codigo AS codcur, c.titulo as titcur  
	FROM suscritos_x_cursos sc  
  LEFT JOIN pedidos pp ON sc.id_pedido=pp.id_pedido 
  INNER JOIN suscritos s ON sc.id_suscrito=s.id_suscrito 
  INNER JOIN cursos c ON sc.id_curso=c.id_curso 
  INNER JOIN estado e ON sc.estado_idestado=e.idestado  
  ";
  
  if (isset($_GET['criterio_mostrar'])) $porPagina=$_GET['criterio_mostrar'];
  if(isset($_GET['criterio_usu_per']) && !empty($_GET['criterio_usu_per'])){
    $stringlike=fn_filtro(substr($_GET['criterio_usu_per'], 0, 16));
			$pos = strpos($sql, 'WHERE');
      $sql.= (($pos === false) ? "WHERE" : "AND" )." (s.dni LIKE '".$stringlike."%' or s.nombre LIKE '".$stringlike."%' or s.email LIKE '".$stringlike."%' or pp.codigo LIKE '".$stringlike."%' )"; 
  }else{
		if( empty($_GET['fechabus_1']) && empty($_GET['fechabus_2']) ) {
			$pos = strpos($sql, 'WHERE');
      $sql.= (($pos === false) ? "WHERE" : "AND" )." DATE(pp.fecha_registro) = '" . fecha_hora(1) . "'";
		}
		
	}
	

	if(!empty($_GET['fechabus_1']) && !empty($_GET['fechabus_2'])) {
			$pos = strpos($sql, 'WHERE');
      $sql.= (($pos === false) ? " WHERE" : " AND" )." DATE(sc.fecha_registro)  BETWEEN  DATE('".$_GET['fechabus_1']."')  and DATE('".$_GET['fechabus_2']."')  ";		
	}

	if(!empty($_GET['estado_pago']) && !empty($_GET['estado_pago'])) {
		$sql.=" AND sc.estado='".$_GET["estado_pago"]."' ";
	}
	
	if(isset($_SESSION['pagina2'])) {
			$_GET['pagina'] = $_SESSION['pagina2'];
	}
	
  if(isset($_GET['criterio_ordenar_por'])) $sql.= sprintf(" order by %s %s", fn_filtro($_GET['criterio_ordenar_por']), fn_filtro($_GET['criterio_orden']));
 $sql.= " ORDER BY sc.fecha_registro DESC";
 
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
  $paging->pagina_proceso="reportes_pedido_clientes.php";
?>
  <table id="example1" class="table table-bordered table-striped">
		<!-- *EXCEL -->
		<?php  /*  Fechas para excel */ 
			$fecha_excel_inicio= !empty($_GET["fechabus_1"])?$_GET["fechabus_1"]:fecha_hora(1); 
		?>
		<input type="hidden" name="sql_excel" id="sql_excel" value="<?php echo $sql; ?>">
		<a href="javascript:fn_exportar('tipo_form=1&fecha_filtro_inicio=<?php echo $fecha_excel_inicio;?>&fecha_filtro_fin=<?php echo $_GET["fechabus_2"];?>','pedido_clientes');" class="btn btn-primary excel "  > Excel</a>
		
	
    <tbody id="sort">            
<?php 
echo 'Total de registros: '.$paging->numTotalRegistros();
		while ($detalles = $paging->fetchResultado()): 
			if(!in_array(array('mes' => $detalles['mes'], 'anho' => $detalles['anho']), $array)){
				$array[] = array('mes' => $detalles['mes'], 'anho' => $detalles['anho']);
?>
				<tr class="lleva-mes">
					<td colspan="9"><h6><?php echo strtoupper(strtr(date('M Y',strtotime($detalles['fecha_registro'])),$meses)); ?></h6></td>
				</tr>
				<tr role="row">
					<th width="30">Día</th>
          <th class="sort ">COD. COMPRA</th>
          <th class="sort ">COD. CURSO</th>
          <th class="sort ">CURSO</th>
          <th class="sort">DNI</th>
          <th class="sort cnone" >Cliente</th>
          <th class="sort cnone">E-mail</th>
          <th class="sort cnone">Teléfono</th>
          <th class="sort cnone">Estado</th>
         </tr>
<?php }//if meses 

if( $detalles["estado_sxc"] == 2){ // por revisar 
	$fondo_entregar ="background:#F0A105; color:#fff !important; ";
	$estado = "Pendiente";
}elseif( $detalles["estado_sxc"] == 1){  // aprobado
	$fondo_entregar ='';
	$estado = "Aprobado";
}elseif( $detalles["estado_sxc"] == 3){ // rechazado 
	$fondo_entregar ='background:rgba(255,0,0,0.6); color:#fff !important;';
	$estado = "Rechazado / expirado";
}
?>        
       <tr>
        <td><?php echo !empty($detalles['fecha_registro']) ? date('d',strtotime($detalles['fecha_registro'])) : '...'; ?></td>
        <td class="cnone"><?php echo $detalles["codped"]; ?></td>
        <td class="cnone"><?php echo $detalles["codcur"]; ?></td>        
        <td class="cnone"><?php echo $detalles["titcur"]; ?></td>        
        <td class="cnone"><?php echo $detalles["dni"]; ?></td>        
        <td class="cnone"><?php echo $detalles["suscritos"]; ?></td>        
        <td class="cnone"><?php echo $detalles["email"] ?></td>        
        <td class="cnone"><?php echo $detalles["telefono"]; ?></td>
        <td class="cnone"><?php echo $estado; ?></td>
      </tr>
<?php endwhile; ?>
    </tbody>
  </table>
  <div class="pagination"><?php echo $paging->fetchNavegacion(); ?></div>
<script>
$(function(){
  // reordenar('reportes_ventas_offlines.php');
  // checked();
  // sorter();
});
</script>

<?php }else{ ?>
        <div class="box-body">
          <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
            <form action="javascript: fn_buscar();" id="frm_buscar" name="frm_buscar">
              <div class="bg-gray-light">
								<div class="col-sm-12 titulo_reporte criterio_buscar">
									<h4>Reporte: Cursos del cliente:</h4>
								</div>
								
								<?php create_input('hidden','tipo_pago',$_GET["tipo_pago"],"form-control pull-right",$table,$agregados); ?>
                <div class="col-sm-3 criterio_buscar">
                  <?php create_input('text','criterio_usu_per','',"form-control pull-right",$table,'placeholder="Ingresa DNI del cliente "'); ?>
                </div>
								<div class="col-sm-2 criterio_buscar">
										<select name="estado_pago" id="estado_pago" class="form-control" >
												<option value="" >ver todo</option>
												<option value="1" >Aprobados</option>
												<option value="2" >Pendientes</option>
												<option value="3" >Rechazados</option>
										</select>
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
<script>
var link = "reportes_pedido_cliente";/*la s final se agrega en js fuctions*/
var us = "reportes_pedido_cliente";/*sirve para mensaje en ventana eliminar*/
var l = "o";
var l2 = "e";/* est+ _ x {e,a,o ,etc}sirve para mensaje en ventana eliminar*/
var pr = "El";
var ar = "al";
var id = "id_pedido";
var mypage = "reportes_pedido_clientes.php";
</script>
<?php } ?>