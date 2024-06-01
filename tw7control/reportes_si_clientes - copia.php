<?php error_reporting(E_ALL ^ E_NOTICE);
include_once("auten.php");

if($_GET["task"]=='finder'){
  $array= array();
	$meses=array('Jan'=>'Enero','Feb'=>'Febrero','Mar'=>'Marzo','Apr'=>'Abril','May'=>'Mayo','Jun'=>'Junio','Jul'=>'Julio','Aug'=>'Agosto','Sep'=>'Septiembre','Oct'=>'Octubre','Nov'=>'Noviembre','Dec'=>'Diciembre');
  
  if (isset($_GET['criterio_mostrar'])) $porPagina=$_GET['criterio_mostrar'];
  if(isset($_GET['criterio_usu_per']) && !empty($_GET['criterio_usu_per'])){
		
    $stringlike=fn_filtro(substr($_GET['criterio_usu_per'], 0, 16));
    
	//primero buscar si el DNI tiene compra
    $comprasi = executesql("SELECT s.id_suscrito, count(s.id_suscrito) c FROM pedidos p INNER JOIN suscritos s ON p.id_suscrito=s.id_suscrito WHERE s.dni LIKE'".$stringlike."%' AND p.estado_pago = 1 GROUP BY s.id_suscrito HAVING c >= 1");
    
	if(!empty($comprasi)){
      $sql61 = executesql("SELECT s.id_suscrito, count(s.id_suscrito) c FROM pedidos p INNER JOIN suscritos s ON p.id_suscrito=s.id_suscrito WHERE s.dni LIKE '".$stringlike."%' AND p.estado_pago = 1 GROUP BY s.id_suscrito HAVING c >= 1");
    	$conte='';
      if(!empty($sql61)){ 
        foreach($sql61 as $row61){ $conte.= $row61['id_suscrito'].','; }
        $ulti = substr($conte, 0, -1);
        $sql62 = "WHERE s.id_suscrito IN (".$ulti.") ";
		
      }else{ $sql62 = ""; }
			$sql= "SELECT s.*, YEAR(s.fecha_registro) as anho, MONTH(s.fecha_registro) as mes, e.nombre AS estado, CONCAT(s.nombre,' ',s.ap_pa,' ',s.ap_ma )as suscritos, ep.titulo as especialidad, count(s.id_suscrito) c, SUM(p.total) as gastototal 
			FROM suscritos s 
			INNER JOIN estado e ON s.estado_idestado=e.idestado 
			INNER JOIN pedidos p ON s.id_suscrito=p.id_suscrito 
			INNER JOIN especialidades ep ON s.id_especialidad=ep.id_especialidad ".$sql62;

			if( empty($_GET['fechabus_1']) && empty($_GET['fechabus_2']) ) {
				$pos = strpos($sql, 'WHERE');
				$sql.= (($pos === false) ? "WHERE" : "AND" )." DATE(s.fecha_registro) < '" . fecha_hora(1) . "'";
			}else{
				$pos = strpos($sql, 'WHERE');
				$sql.= (($pos === false) ? "WHERE" : "AND" )." DATE(s.fecha_registro)  BETWEEN  DATE('".$_GET['fechabus_1']."')  and DATE('".$_GET['fechabus_2']."')  "; 
			}

			if( !empty($_GET['id_tipo_cliente']) && isset($_GET['id_tipo_cliente']) ) {
				$sql.= " and s.id_tipo_cliente= '".$_GET['id_tipo_cliente']."' ";  
			
			}
			
			if(isset($_GET['criterio_ordenar_por'])) $sql.= sprintf(" order by %s %s", fn_filtro($_GET['criterio_ordenar_por']), fn_filtro($_GET['criterio_orden']));
			$sql.= " GROUP BY s.id_suscrito HAVING c >= 1 ORDER BY s.orden DESC";
    }
		
  }else{



    $comprasin = executesql("SELECT s.id_suscrito, count(s.id_suscrito) as c FROM pedidos p INNER JOIN suscritos s ON p.id_suscrito=s.id_suscrito WHERE p.estado_pago = 1 GROUP BY s.id_suscrito HAVING c >= 1");
    $conte='';
    if(!empty($comprasin)){ 
      foreach($comprasin as $row61){ $conte.= $row61['id_suscrito'].','; }
      $ulti = substr($conte, 0, -1);
      $sql62 = "WHERE s.id_suscrito IN (".$ulti.") ";

    }else{ 
		$sql62 = " "; 
	
	}

			$sql= "SELECT s.*, YEAR(s.fecha_registro) as anho, MONTH(s.fecha_registro) as mes, e.nombre AS estado, CONCAT(s.nombre,' ',s.ap_pa,' ',s.ap_ma ) as suscritos, ep.titulo as especialidad, count(s.id_suscrito) c, SUM(p.total) as gastototal 
			FROM suscritos s 
			INNER JOIN estado e ON s.estado_idestado=e.idestado 
			INNER JOIN pedidos p ON s.id_suscrito=p.id_suscrito 
			INNER JOIN especialidades ep ON s.id_especialidad=ep.id_especialidad ".$sql62;
			if( empty($_GET['fechabus_1']) && empty($_GET['fechabus_2']) ) {
				$pos = strpos($sql, 'WHERE');
				$sql.= (($pos === false) ? "WHERE" : "AND" )." DATE(s.fecha_registro) < '" . fecha_hora(1) . "'";
			}else{
				$pos = strpos($sql, 'WHERE');
				$sql.= (($pos === false) ? "WHERE" : "AND" )." DATE(s.fecha_registro)  BETWEEN  DATE('".$_GET['fechabus_1']."')  and DATE('".$_GET['fechabus_2']."')  "; 
			}

			if( !empty($_GET['id_tipo_cliente']) && isset($_GET['id_tipo_cliente']) ) {
				$sql.= " and s.id_tipo_cliente= '".$_GET['id_tipo_cliente']."' ";  
		  
			}

			if(isset($_GET['criterio_ordenar_por'])) $sql.= sprintf(" order by %s %s", fn_filtro($_GET['criterio_ordenar_por']), fn_filtro($_GET['criterio_orden']));
			$sql.= " GROUP BY s.id_suscrito HAVING c >= 1 ORDER BY s.orden DESC";
  }
	

		/*if(!empty($_GET['fechabus_1']) && !empty($_GET['fechabus_2'])) {
			$pos = strpos($sql, 'WHERE');
      $sql.= (($pos === false) ? "WHERE" : "AND" )." DATE(s.fecha_registro)  BETWEEN  DATE('".$_GET['fechabus_1']."')  and DATE('".$_GET['fechabus_2']."')  ";		
	}
	*/

	
	if(isset($_SESSION['pagina2'])) {
			$_GET['pagina'] = $_SESSION['pagina2'];
	}


	 echo $sql;

  if((isset($comprasi) && !empty($comprasi)) || isset($comprasin) && !empty($comprasin)){
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
		$paging->pagina_proceso="reportes_si_clientes.php";
?>
  <table id="example1" class="table table-bordered table-striped">

  <?php if($_SESSION["visualiza"]["idtipo_usu"] ==1 && ($_SESSION["visualiza"]["idusuario"] ==6 || $_SESSION["visualiza"]["idusuario"] ==80 )){  ?> 

		<!-- *EXCEL -->
		<?php  /*  Fechas para excel */ 
			$fecha_excel_inicio= !empty($_GET["fechabus_1"])?$_GET["fechabus_1"]:fecha_hora(1); 
		?>
		<input type="hidden" name="sql_excel" id="sql_excel" value="<?php echo $sql; ?>">
		<a href="javascript:fn_exportar('tipo_form=1&fecha_filtro_inicio=<?php echo $fecha_excel_inicio;?>&fecha_filtro_fin=<?php echo $_GET["fechabus_2"];?>','si_clientes');" class="btn btn-primary"  > Excel</a>
	<?php } ?> 	
	
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
          <th class="sort">DNI</th>
          <th class="sort cnone" >Cliente</th>
          <th class="sort cnone" >Especialidad</th>
		  <th class="sort cnone" >Nombrado?</th>

          <th class="sort cnone">E-mail</th>
          <th class="sort cnone">Teléfono</th>
          <th class="sort cnone">Cantidad de Compras</th>
          <th class="sort cnone">(S/.) Total de Compras</th>
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
       <tr>
        <td><?php echo !empty($detalles['fecha_registro']) ? date('d',strtotime($detalles['fecha_registro'])) : '...'; ?></td>
        <td class="cnone"><?php echo $detalles["dni"]; ?></td>        
        <td class="cnone"><?php echo $detalles["suscritos"]; ?></td>        
        <td class="cnone"><?php echo $detalles["especialidad"]; ?></td>
        <td class="cnone"><?php echo $detalles["email"] ?></td>        
        <td class="cnone"><?php echo $detalles["telefono"]; ?></td>
		<td class="cnone"><?php echo ($detalles["id_tipo_cliente"]==1 ) ?'SI':'NO'; ?></td>

        <td class="cnone"><?php echo $detalles["c"]; ?></td>
        <td class="cnone"><?php echo $detalles["gastototal"]; ?></td>
      </tr>
<?php endwhile; ?>
    </tbody>
  </table>
  <div class="pagination"><?php echo $paging->fetchNavegacion(); ?></div>
<?php
  }else{
    echo (isset($comprasi)) ? 'Cliente DNI:'.$stringlike.'; No presenta compras registrasdas.' : 'Sin resultados';
  }
?>
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
								<?php create_input('hidden','tipo_pago',$_GET["tipo_pago"],"form-control pull-right",$table,$agregados); ?>
                <div class="col-sm-2 criterio_buscar">
                  <?php create_input('text','criterio_usu_per','',"form-control pull-right",$table,'placeholder="Buscar .."'); ?>
                </div>
						
				<div class="col-sm-2  criterio_buscar">                  
					<select id="id_tipo_cliente" name="id_tipo_cliente" class="form-control"  >  <!-- saco valor desde la BD -->
						<option value=""> -- nombrado si/no --</option>  
						<option value="1">SI NOMBRADO</option>  
						<option value="2" > NO NOMBRADO</option>											
					</select>
				</div>	
				
				<div class="col-sm-7 criterio_mostrar">
				<?php if($_SESSION["visualiza"]["idtipo_usu"] ==1 && ($_SESSION["visualiza"]["idusuario"] ==6 || $_SESSION["visualiza"]["idusuario"] ==80 ) ){  ?> 

					<div class="lleva_flechas" style="position:relative;">
						<label>Desde:</label>
						<?php create_input('date', 'fechabus_1', '', "form-control pull-right", $table, ''); ?>
					</div>
					<div class="lleva_flechas" style="position:relative;">
						<label>Hasta:</label>
						<?php create_input('date', 'fechabus_2', '', "form-control pull-right", $table, ''); ?>
						</div>
				<?php } ?>
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
var link = "reportes_si_cliente";/*la s final se agrega en js fuctions*/
var us = "reportes_si_cliente";/*sirve para mensaje en ventana eliminar*/
var l = "o";
var l2 = "e";/* est+ _ x {e,a,o ,etc}sirve para mensaje en ventana eliminar*/
var pr = "El";
var ar = "al";
var id = "id_pedido";
var mypage = "reportes_si_clientes.php";
</script>
<?php } ?>