<?php error_reporting(E_ALL ^ E_NOTICE);
include_once("auten.php");

if($_GET["task"]=='uestado'){
    $bd = new BD;
    $bd->Begin();
    $ide = !isset($_GET['id_asistencia']) ? $_GET['id_asistencia'] : $_GET['id_asistencia'];
    $ide = is_array($ide) ? implode(',',$ide) : $ide;
    $usuario = executesql("SELECT * FROM asistencia WHERE id_asistencia IN (".$ide.")");
    if(!empty($usuario)) foreach($usuario as $reg => $item)
        if($item['estado_idestado']==1) $state = 2;
        elseif($item['estado_idestado']==2) $state = 1;
  
    $num_afect=$bd->actualiza_("UPDATE asistencia SET estado_idestado=".$state." WHERE id_asistencia=".$ide."");
    echo $state;
    $bd->Commit();
    $bd->close();


}elseif($_GET["task"]=='drop' || $_GET["task"]=='dropselect'){
  
  $bd = new BD;
  $bd->Begin();
  $ide = !isset($_GET['id_asistencia']) ? implode(',', $_GET['chkDel']) : $_GET['id_asistencia'];
  $bd->actualiza_("DELETE FROM asistencia WHERE id_asistencia IN(".$ide.")");
  $bd->Commit();
  $bd->close();



}elseif($_GET["task"]=='finder'){
    $array= array();
    $meses=array('Jan'=>'Enero','Feb'=>'Febrero','Mar'=>'Marzo','Apr'=>'Abril','May'=>'Mayo','Jun'=>'Junio','Jul'=>'Julio','Aug'=>'Agosto','Sep'=>'Septiembre','Oct'=>'Octubre','Nov'=>'Noviembre','Dec'=>'Diciembre');
	
    $sql.= "SELECT a.*, e.nombre AS estado, CONCAT(c.ap_pa,' ',c.ap_ma,' ',c.nombre ) as apellidos, c.dni, s.titulo as sesion, ds.titulo as detalle, cu.titulo as curso, cu.codigo as codigo_c
    FROM asistencia a 
    INNER JOIN suscritos c ON a.id_suscrito = c.id_suscrito 
    LEFT JOIN cursos cu ON a.id_curso = cu.id_curso 
    LEFT JOIN sesiones s ON a.id_sesion = s.id_sesion 
    LEFT JOIN detalle_sesiones ds ON a.id_detalle = ds.id_detalle
    INNER JOIN estado e ON c.estado_idestado=e.idestado ";
		
    if(isset($_GET['criterio_mostrar'])) $porPagina=$_GET['criterio_mostrar'];
    if(isset($_GET['criterio_usu_per']) && !empty($_GET['criterio_usu_per']) ){
        $stringlike=fn_filtro(substr($_GET['criterio_usu_per'], 0, 16));
        $sql.= " AND (cu.codigo like '".$stringlike."%' OR cu.titulo like '".$stringlike."%' OR ds.titulo like '".$stringlike."%' OR c.dni like '".$stringlike."%' OR c.ap_pa like '".$stringlike."%' OR c.ap_pa like '".$stringlike."%' OR c.ap_ma like '".$stringlike."%' OR a.cap_ip like '".$stringlike."%'  OR c.nombre LIKE '".$stringlike."%' OR c.email LIKE '".$stringlike."%')";
    }else{
		if( empty($_GET['fechabus_1']) && empty($_GET['fechabus_2']) ) {
            $fecha = fecha_hora(2);
            $fecha_1 = strtotime('-15 minute',strtotime($fecha));  
            $fecha_1 = date('Y-m-d H:i:s',$fecha_1); 
			// $sql .= " AND MONTH(DATE(a.fecha_registro)) = MONTH('" . fecha_hora(1) . "') ";
			$sql .= " AND a.fecha_registro BETWEEN '".$fecha_1."' AND '".$fecha."' ";
		}
	}
	/* filtro fechas */
	if(!empty($_GET['fechabus_1']) && !empty($_GET['fechabus_1'])){
		$sql .= " AND DATE(a.fecha_registro)  BETWEEN  DATE('".$_GET['fechabus_1']."')  and DATE('".$_GET['fechabus_2']."')  ";		
	}

    $sql.=" ORDER BY c.orden DESC";

	  $paging = new PHPPaging;
    $paging->agregarConsulta($sql); 
    $paging->div('div_listar');
    $paging->modo('desarrollo'); 
    $numregistro=1; 
    if($numregistro) $paging->porPagina(fn_filtro((int)$numregistro));
    $paging->verPost(true);
    $mantenerVar=array("criterio_mostrar","task","criterio_usu_per");
    $paging->mantenerVar($mantenerVar);
    // $paging->porPagina(fn_filtro((int)$porPagina));
    $paging->porPagina(1000);
    $paging->ejecutar();
    $paging->pagina_proceso="reporte_asistencia2s.php";
?>
	<table id="example1" class="table table-bordered table-striped">
		
<!-- *EXCEL -->
<?php  /*  Fechas para excel */ 
		$fecha_excel_inicio= !empty($_GET["fechabus_1"])?$_GET["fechabus_1"]:fecha_hora(1); 
?>
		<input type="hidden" name="sql_excel" id="sql_excel" value="<?php echo $sql; ?>">
		<a href="javascript:fn_exportar('tipo_form=1&fecha_filtro_inicio=<?php echo $fecha_excel_inicio;?>&fecha_filtro_fin=<?php echo $_GET["fechabus_2"];?>','asistencia2s');" class="btn btn-primary excel "  > Excel</a>
		
		
        <thead id="sort"><tr role="row">
            <th class="sort cnone">DNI</th>
            <th class="sort cnone">USUARIO</th>
			<th class="sort cnone">CODIGO CURSO</th>
            <th class="sort cnone">CURSO</th>
			<th class="sort cnone">SESIÓN</th>
			<th class="sort cnone">DETALLE SESIÓN</th>
            <th class="sort cnone">IP USUARIO</th>
            <th class="sort cnone">AGENTE</th>
            <th class="sort cnone">TIEMPO EN PÁGINA</th>
			<th class="sort cnone">FECHA</th>
			<th class="sort cnone">HORA</th>
			<th class="sort cnone">OPC</th>
	    </tr></thead>
        <tbody id="sort">
<?php 
        while($detalles = $paging->fetchResultado()):
?>
            <tr>
                <td><?php echo $detalles["dni"]; ?></td>
				<td><?php echo $detalles["apellidos"]; ?></td>
                <td><?php echo $detalles["codigo_c"]; ?></td>
                <td><?php echo $detalles["curso"]; ?></td>
				<td><?php echo $detalles["sesion"]; ?></td>
				<td><?php echo $detalles["detalle"]; ?></td>
                <td><?php echo $detalles["cap_ip"]; ?></td>
                <td><?php echo $detalles["agente"]; ?></td>
                <td><?php echo $detalles["tiempo"]; ?></td>
				<td><?php echo date('d\/m\/Y ',strtotime($detalles['fecha_registro'])); ?></td>
				<td><?php echo date("g:i a",strtotime($detalles["hora_registro"])); ?></td>
						<td>
						<div class="btn-eai btns btr">
									 <a href="javascript: fn_eliminar('<?php echo $detalles["id_asistencia"]; ?>')"><i class="fa fa-trash-o"></i></a>
						</div>
					</td>
			</tr>
<?php endwhile; ?>
        </tbody>
	</table>
    <div class="pagination"><?php echo $paging->fetchNavegacion(); ?></div>
<script>
$(function(){
  // reordenar('suscriptores.php');
  checked();
  // sorter();
});
</script>

<?php }else{ ?>
        <div class="box-body">
          <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
            <form action="javascript: fn_buscar();" id="frm_buscar" name="frm_buscar">
              <div class="bg-gray-light">
								<div class="col-sm-12 titulo_reporte criterio_buscar">
									<h4>Reporte: Conexiones del cliente:</h4>
								</div>
								
                <div class="col-sm-3 criterio_buscar">
                  <?php create_input('text','criterio_usu_per','',"form-control pull-right",$table,'placeholder="Buscar por DNI o cod.curso "'); ?>
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
                <div class="break"></div>
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
var link = "reporte_asistencia2";/*la s final se agrega en js fuctions*/
var us = "reporte_asistencia2";/*sirve para mensaje en ventana eliminar*/
var l = "o";
var l2 = "e";/* est+ _ x {e,a,o ,etc}sirve para mensaje en ventana eliminar*/
var pr = "El";
var ar = "al";
var id = "id_asistencia";
var mypage = "reporte_asistencia2s.php";
</script>
<?php } ?>