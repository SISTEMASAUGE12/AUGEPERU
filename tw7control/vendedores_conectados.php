<?php error_reporting(E_ALL ^ E_NOTICE);
include_once("auten.php");

if(  $_GET["task"]=='update'){
  $bd=new BD;

	$_POST['fecha_modificacion'] = fecha_hora(2);
	$_POST['usuario_modifico'] =$_SESSION["visualiza"]["idusuario"];
	$campos=array('usuario_modifico','fecha_modificacion','observacion'); /*inserto campos principales*/
	
	// echo var_dump(armaupdate('pedidos',$campos," id_asistencia='".$_POST["id_asistencia"]."'",'POST'));	
	// exit();
		
	$bd->actualiza_(armaupdate('pedidos',$campos," id_asistencia='".$_POST["id_asistencia"]."'",'POST'));/*actualizo*/
  $bd->close();
  gotoUrl("index.php?page=".$_POST["nompage"]."&tipo_pago=".$_POST["tipo_pago"]."&module=".$_POST["nommodule"]."&parenttab=".$_POST["nomparenttab"]);
	

}elseif($_GET["task"]=='uestado'){
  $bd = new BD;
  $bd->Begin();
  $ide = !isset($_GET['id_asistencia']) ? $_GET['estado_idestado'] : $_GET['id_asistencia'];
  $ide = is_array($ide) ? implode(',',$ide) : $ide;
  $usuario = executesql("SELECT * FROM pedidos WHERE id_asistencia IN (".$ide.")");
  if(!empty($usuario))
  foreach($usuario as $reg => $item)
  if ($item['estado_idestado']==1) {
    $state = 2;
  }elseif ($item['estado_idestado']==2) {
    $state = 1;
  }
  $num_afect=$bd->actualiza_("UPDATE pedidos SET estado_idestado=".$state." WHERE id_asistencia=".$ide."");
  echo $state;
  $bd->Commit();
  $bd->close();



}elseif($_GET["task"]=='finder'){
  $array= array();
	$meses=array('Jan'=>'Enero','Feb'=>'Febrero','Mar'=>'Marzo','Apr'=>'Abril','May'=>'Mayo','Jun'=>'Junio','Jul'=>'Julio','Aug'=>'Agosto','Sep'=>'Septiembre','Oct'=>'Octubre','Nov'=>'Noviembre','Dec'=>'Diciembre');
	
  $sql= "	SELECT au.*, u.idusuario, u.nomusuario, u.conectividad, au.fecha_registro, au.hora_registro, au.fecha_cierra, au.hora_cierra
	FROM asistencia_usuarios au
	LEFT JOIN usuario u ON au.idusuario = u.idusuario
	WHERE 1

	";  /* todos los que han comprado, solo salen las aprobadas para facturar */ 
  
	// sumo tipo_enta 1, venta propias comision completa. 


	
  if (isset($_GET['criterio_mostrar'])) $porPagina=$_GET['criterio_mostrar'];
  if(isset($_GET['criterio_usu_per']) && !empty($_GET['criterio_usu_per'])){
    $stringlike=fn_filtro(substr($_GET['criterio_usu_per'], 0, 16));
    $sql.= " AND (   uu.nomusuario LIKE '%".$stringlike."%' or au.cap_ip LIKE '%".$stringlike."%' or uu.email LIKE '%".$stringlike."%' or uu.codusuario LIKE '%".$stringlike."%'  )"; 
  }else{
		if( empty($_GET['fechabus_1']) && empty($_GET['fechabus_2']) ) {
			$sql .= " AND DATE(au.fecha_registro) = '" . fecha_hora(1) . "'";
		}
		
	}
	
	if(!empty($_GET['idusuario']) ){
			$sql .= " AND au.idusuario = '".$_GET['idusuario']."'";
	}
	
	if(!empty($_GET['conectividad']) ){
			$sql .= " AND u.conectividad = '".$_GET['conectividad']."'";
	}


		if(!empty($_GET['fechabus_1']) && !empty($_GET['fechabus_2'])) {
			$sql .= " AND DATE(au.fecha_registro)  BETWEEN  DATE('".$_GET['fechabus_1']."')  and DATE('".$_GET['fechabus_2']."')  ";		
	}

	
	if(isset($_SESSION['pagina2'])) {
			$_GET['pagina'] = $_SESSION['pagina2'];
	}
	
  if(isset($_GET['criterio_ordenar_por'])) $sql.= sprintf(" order by %s %s", fn_filtro($_GET['criterio_ordenar_por']), fn_filtro($_GET['criterio_orden']));
 // $sql.= " GROUP by u.idusuario  ";
 $sql.=" ORDER BY au.id_asistencia DESC";
 
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
  $paging->pagina_proceso="vendedores_conectados.php";
?>
  <table id="example1" class="table table-bordered table-striped">
		<!-- *EXCEL -->
		<?php  /*  Fechas para excel */ 
			$fecha_excel_inicio= !empty($_GET["fechabus_1"])?$_GET["fechabus_1"]:fecha_hora(1); 
		?>
		<!--
		<input type="hidden" name="sql_excel" id="sql_excel" value="<?php echo $sql; ?>">
		<a href="javascript:fn_exportar('tipo_form=1&fecha_filtro_inicio=<?php echo $fecha_excel_inicio;?>&fecha_filtro_fin=<?php echo $_GET["fechabus_2"];?>','ventas_todos');" class="btn btn-primary excel "  > Excel</a>
		-->
	
    <tbody id="sort">
              
<?php 
		while ($detalles = $paging->fetchResultado()): 

			if(!in_array(array('mes' => $detalles['mes'], 'anho' => $detalles['anho']), $array)){
				$array[] = array('mes' => $detalles['mes'], 'anho' => $detalles['anho']);
?>
<!-- 
				<tr class="lleva-mes">
					<td colspan="9"><h6><?php echo strtoupper(strtr(date('M Y',strtotime($detalles['fecha_registro'])),$meses)); ?></h6></td>
				</tr>
				-->
				<tr role="row">
          <th class="sort cnone" width="160">USUARIO</th>
					<!-- 
          <th class="sort cnone" width="200">#total s/</th>
					-->
          <th class="sort cnone" width="100">Conectividad</th>
          <th class="sort cnone" width="100">IP</th>
          <th class="sort cnone" width="100">AGENTE</th>
          <th class="sort cnone" width="100">Fecha ingreso</th>
          <th class="sort cnone" width="100">Hora ingreso</th>
          <th class="sort cnone" width="100">Fecha cierre</th>
          <th class="sort cnone" width="100">Hora cierre</th>
        </tr>
<?php }//if meses 

if( empty($detalles["fecha_cierra"]) ){ // conectado 
	$fondo_entregar ='style="background:green; color:#fff !important; border-radius:50%;height:12px;width:12px;position: absolute;"';
// }elseif( $detalles["conectividad"] == 2){ // off 
}else{ // off 
	$fondo_entregar ='style="background:rgba(255,0,0,0.6); color:#fff !important; border-radius:50%;height:12px;width:12px;position: absolute;"';
}
?>        
       <tr >
				
        <td class="cnone" > 
						<span <?php echo $fondo_entregar; ?> ></span>  
						<span style="padding-left:20px;"><?php echo $detalles["idusuario"].' - '.$detalles["nomusuario"]; ?> </span>
				</td>
				<td class="cnone"> 
					<?php 
				if( empty($detalles["fecha_cierra"]) ){ // conectado 
					echo "ONLINE";
				}elseif( !empty($detalles["fecha_cierra"]) ){ // off 
					echo "OFF ";					
				}
				?>
				</td>
		<td class="cnone"> <?php echo $detalles["cap_ip"]; ?></td>
		<td class="cnone"> <?php echo $detalles["agente"]; ?></td>
        <td class="cnone"> <?php echo $detalles["fecha_registro"]; ?></td>
        <td class="cnone"> <?php echo $detalles["hora_registro"]; ?></td>
        <td class="cnone"> <?php echo $detalles["fecha_cierra"]; ?></td>
        <td class="cnone"> <?php echo $detalles["hora_cierra"]; ?></td>
			</tr>
<?php endwhile; ?>
    </tbody>
  </table>
  <div class="pagination"><?php echo $paging->fetchNavegacion(); ?></div>
<script>
$(function(){
  // reordenar('vendedores_conectados.php');
  // checked();
  // sorter();
});
</script>

<?php }else{ ?>

	<?php  if($_SESSION["visualiza"]["idtipo_usu"] ==1){ ?>

        <div class="box-body">
          <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
            <form action="javascript: fn_buscar();" id="frm_buscar" name="frm_buscar">
              <div class="bg-gray-light">
          
								<div class="col-sm-2 criterio_buscar" style="padding-bottom:8px;">
											<?php crearselect("idusuario", "select idusuario, nomusuario from usuario where estado_idestado=1 order by nomusuario asc", 'class="form-control"  style="border:1px solid #CA3A2B;" ', '', " -- vendedor -- "); ?>
										</div>
											
								<div class="col-sm-2 criterio_buscar">
										<select name="conectividad" id="conectividad" class="form-control" >
												<option value="" >-- conectividad --</option>
												<option value="1" >Conectado</option>
												<option value="2" >Offline</option>
										</select>
								</div>

							 <div class="col-sm- c6riterio_mostrar">
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
var link = "vendedores_conectado";/*la s final se agrega en js fuctions*/
var us = "asistencia";/*sirve para mensaje en ventana eliminar*/
var l = "o";
var l2 = "e";/* est+ _ x {e,a,o ,etc}sirve para mensaje en ventana eliminar*/
var pr = "El";
var ar = "al";
var id = "id_asistencia";
var mypage = "vendedores_conectados.php";
</script>
<?php } ?>