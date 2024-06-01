<?php error_reporting(E_ALL ^ E_NOTICE);
include_once("auten.php");

if($_GET["task"]=='finder'){
  $array= array();
	$meses=array('Jan'=>'Enero','Feb'=>'Febrero','Mar'=>'Marzo','Apr'=>'Abril','May'=>'Mayo','Jun'=>'Junio','Jul'=>'Julio','Aug'=>'Agosto','Sep'=>'Septiembre','Oct'=>'Octubre','Nov'=>'Noviembre','Dec'=>'Diciembre');
		
  $sql= "SELECT se.*, YEAR(se.fecha_registro) as anho, MONTH(se.fecha_registro) as mes, e.nombre AS estado ,s.email as email,  CONCAT(s.nombre,' ',s.ap_pa,' ',s.ap_ma )as suscritos , s.dni as dni, s.telefono, pp.titulo as exatitu  
	FROM suscritos_x_examenes se  
  INNER JOIN suscritos s ON se.id_suscrito=s.id_suscrito 
	INNER JOIN examenes pp ON se.id_examen = pp.id_examen   
  INNER JOIN estado e ON se.estado_idestado=e.idestado "; 
  
  if (isset($_GET['criterio_mostrar'])) $porPagina=$_GET['criterio_mostrar'];
  if(isset($_GET['criterio_usu_per']) && !empty($_GET['criterio_usu_per'])){
    $stringlike=fn_filtro(substr($_GET['criterio_usu_per'], 0, 16));
    $sql.= " AND ( s.dni LIKE '".$stringlike."%' )"; 
  }else{
		if(empty($_GET['fechabus_1']) && empty($_GET['fechabus_2'])){
			$sql .= " AND DATE(se.fecha_registro)  <=  '" . fecha_hora(1) . "'";
		}
	}
	
	if(!empty($_GET['fechabus_1']) && !empty($_GET['fechabus_2'])){
		$sql .= " AND DATE(se.fecha_registro)  BETWEEN  DATE('".$_GET['fechabus_1']."')  and DATE('".$_GET['fechabus_2']."')  ";		
	}


	if(isset($_SESSION['pagina2'])){
		$_GET['pagina'] = $_SESSION['pagina2'];
	}
	
  if(isset($_GET['criterio_ordenar_por'])) $sql.= sprintf(" order by %s %s", fn_filtro($_GET['criterio_ordenar_por']), fn_filtro($_GET['criterio_orden']));
 $sql.= " ORDER BY se.nota DESC ";

  // echo $sql;
  $paging = new PHPPaging;
  $paging->agregarConsulta($sql); 
  $paging->div('div_listar');
  $paging->modo('desarrollo'); 
  $numregistro=1; 
  if($numregistro) $paging->porPagina(fn_filtro((int)$numregistro));
  $paging->verPost(true);
  $mantenerVar=array("criterio_mostrar","task","criterio_usu_per","criterio_ordenar_por","criterio_orden");
  $paging->mantenerVar($mantenerVar);
  $paging->porPagina(16);
  $paging->ejecutar();
  $paging->pagina_proceso="reportes_examenes_cliente2s.php";
?>
  <table id="example1" class="table table-bordered table-striped">
		<!-- *EXCEL -->
		<?php  /*  Fechas para excel */ 
			$fecha_excel_inicio= !empty($_GET["fechabus_1"])?$_GET["fechabus_1"]:fecha_hora(1); 
		?>
		<input type="hidden" name="sql_excel" id="sql_excel" value="<?php echo $sql; ?>">
		<a href="javascript:fn_exportar('tipo_form=1&fecha_filtro_inicio=<?php echo $fecha_excel_inicio;?>&fecha_filtro_fin=<?php echo $_GET["fechabus_2"];?>','examenes_cliente2s');" class="btn btn-primary"  > Excel</a>
		
    <tbody id="sort">            
<?php 
		while ($detalles = $paging->fetchResultado()): 
			if(!in_array(array('mes' => $detalles['mes'], 'anho' => $detalles['anho']), $array)){
				$array[] = array('mes' => $detalles['mes'], 'anho' => $detalles['anho']);
?>
			<tr class="lleva-mes">
				<td colspan="9"><h6><?php echo strtoupper(strtr(date('M Y',strtotime($detalles['fecha_registro'])),$meses)); ?></h6></td>
			</tr>
			<tr role="row">
				<th width="30">Día</th>
        <th class="sort">DNI</th>
        <th class="sort">Cliente</th>
        <th class="sort">Teléfono</th>
        <th class="sort">Examen</th>
        <th class="sort">Puntaje</th>
      </tr>
<?php }//if meses 

?>        
       <tr>
        <td><?php echo !empty($detalles['fecha_registro']) ? date('d',strtotime($detalles['fecha_registro'])) : '...'; ?></td>
        <td ><?php echo $detalles["dni"]; ?></td>        
        <td ><?php echo $detalles["suscritos"]; ?></td>  
        <td ><?php echo $detalles["telefono"]; ?></td> 
        <td ><?php echo $detalles["exatitu"]; ?></td> 
        <td ><?php echo $detalles["nota"]; ?></td>
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
<div class="box-body"><div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
  <form action="javascript: fn_buscar();" id="frm_buscar" name="frm_buscar"><div class="bg-gray-light">
		<?php create_input('hidden','tipo_pago',$_GET["tipo_pago"],"form-control pull-right",$table,$agregados); ?>
  	<div class="col-sm-12 titulo_reporte criterio_buscar">
			<h4 style="margin-bottom:10px">Reporte de examenes com mayor puntaje:</h4>
    </div>
    <div class="col-sm-6 criterio_mostrar">
			<div class="lleva_flechas" style="position:relative;">
				<!--<label>Desde:</label>-->
				<?php create_input('date','fechabus_1', '', "form-control pull-right", $table, ''); ?>
			</div>
			<div class="lleva_flechas" style="position:relative;">
				<!--<label>Hasta:</label>-->
				<?php create_input('date','fechabus_2', '', "form-control pull-right", $table, ''); ?>
			</div>
			<button>Buscar</button>
		</div>  
	</div></form>
  <div class="row"><div class="col-sm-12">
    <div id="div_listar"></div>
    <div id="div_oculto" style="display: none;"></div>
  </div></div>
</div></div>
<script>
var link = "reportes_examenes_cliente2";/*la s final se agrega en js fuctions*/
var us = "reportes_examenes_cliente2";/*sirve para mensaje en ventana eliminar*/
var l = "o";
var l2 = "e";/* est+ _ x {e,a,o ,etc}sirve para mensaje en ventana eliminar*/
var pr = "El";
var ar = "al";
var id = "id_pedido";
var mypage = "reportes_examenes_cliente2s.php";
</script>
<?php } ?>