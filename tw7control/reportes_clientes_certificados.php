<?php error_reporting(E_ALL ^ E_NOTICE);
include_once("auten.php");

if($_GET["task"]=='finder'){
  $array= array();
	$meses=array('Jan'=>'Enero','Feb'=>'Febrero','Mar'=>'Marzo','Apr'=>'Abril','May'=>'Mayo','Jun'=>'Junio','Jul'=>'Julio','Aug'=>'Agosto','Sep'=>'Septiembre','Oct'=>'Octubre','Nov'=>'Noviembre','Dec'=>'Diciembre');
		
	/*
	$sql= "SELECT sc.*, YEAR(sc.fecha_registro) as anho, MONTH(sc.fecha_registro) as mes ,s.email as email,  CONCAT(s.nombre,' ',s.ap_pa,' ',s.ap_ma )as suscritos , s.dni as dni, c.titulo as certificado, c.id_certificado,  c.id_certificado as codigo, s.telefono , esp.titulo as especialidad, p.total , u.nombre_corto , p.tipo_pago  ,
  sol.direccion as direccion_solicitud, sol.agencia , sol.iddpto, sol.idprvc, sol.iddist 
	FROM suscritos_x_certificados sc  
  INNER JOIN estado e ON sc.estado_idestado=e.idestado  
  INNER JOIN suscritos s ON sc.id_suscrito=s.id_suscrito   
  LEFT JOIN pedidos p ON sc.id_pedido=p.id_pedido    
  LEFT JOIN usuario u ON p.idusuario=u.idusuario   
  LEFT JOIN especialidades esp ON s.id_especialidad=esp.id_especialidad   
  LEFT  JOIN solicitudes sol ON sc.id_pedido= sol.id_pedido    
  INNER JOIN certificados c ON sc.id_certificado=c.id_certificado   
  WHERE sc.estado=1 and sc.estado_idestado=1  ";  //solo muestro los habilitados/ activos 
	*/
  
	$sql= "SELECT sc.*, YEAR(sc.fecha_registro) as anho, MONTH(sc.fecha_registro) as mes ,s.email as email,  CONCAT(s.nombre,' ',s.ap_pa,' ',s.ap_ma )as suscritos , s.dni as dni, c.titulo as certificado, c.id_certificado,  c.id_certificado as codigo, s.telefono , esp.titulo as especialidad, p.total , u.nombre_corto , p.tipo_pago ,  c.certificado_codigo, c.certificado_libro 
	FROM suscritos_x_certificados sc  
  INNER JOIN estado e ON sc.estado_idestado=e.idestado  
  INNER JOIN suscritos s ON sc.id_suscrito=s.id_suscrito   
  LEFT JOIN pedidos p ON sc.id_pedido=p.id_pedido    
  LEFT JOIN usuario u ON p.idusuario=u.idusuario   
  LEFT JOIN especialidades esp ON s.id_especialidad=esp.id_especialidad   
  INNER JOIN certificados c ON sc.id_certificado=c.id_certificado   
  WHERE sc.estado=1 and sc.estado_idestado=1  ";  //solo muestro los habilitados/ activos 
	
  
  if (isset($_GET['criterio_mostrar'])) $porPagina=$_GET['criterio_mostrar'];
  if(isset($_GET['criterio_usu_per']) && !empty($_GET['criterio_usu_per'])){
    $stringlike=fn_filtro(substr($_GET['criterio_usu_per'], 0, 16));
    $sql.= " AND ( c.id_certificado LIKE '".$stringlike."%' or c.titulo LIKE '".$stringlike."%' )"; 
  }else{
		if(empty($_GET['fechabus_1']) && empty($_GET['fechabus_2'])){
			$sql .= " AND DATE(sc.fecha_registro) = '" . fecha_hora(1) . "'";
		}
	}
	
	if(!empty($_GET['fechabus_1']) && !empty($_GET['fechabus_2'])){
    $sql .= " AND DATE(sc.fecha_registro)  BETWEEN  DATE('".$_GET['fechabus_1']."')  and DATE('".$_GET['fechabus_2']."')  ";		
    $sql_fecha_total = " AND DATE(sc.fecha_registro)  BETWEEN  DATE('".$_GET['fechabus_1']."')  and DATE('".$_GET['fechabus_2']."')  ";		
	}

	if(isset($_SESSION['pagina2'])) {
		$_GET['pagina'] = $_SESSION['pagina2'];
	}
	
  if(isset($_GET['criterio_ordenar_por'])) $sql.= sprintf(" order by %s %s", fn_filtro($_GET['criterio_ordenar_por']), fn_filtro($_GET['criterio_orden']));
  $sql.= " ORDER BY sc.order_pdf DESC";
 
 //echo $sql;
	
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
  $paging->pagina_proceso="reportes_clientes_certificados.php";
?>
  <table id="example1" class="table table-bordered table-striped">
		<!-- *EXCEL -->
		<?php  /*  Fechas para excel */ 
			$fecha_excel_inicio= !empty($_GET["fechabus_1"])?$_GET["fechabus_1"]:fecha_hora(1); 
		?>
		<input type="hidden" name="sql_excel" id="sql_excel" value="<?php echo $sql; ?>">
		<a href="javascript:fn_exportar_todo('excel_todo_clientes_x_certificados');" class="btn btn-primary excel "  > Excel </a>
		
    <!-- 
		<a href="javascript:fn_exportar_todo('excel_todo_clientes_x_certificados.php');"  class="btn btn-primary"  style="margin-left:20px;"> Excel [descargar todo]</a>
-->
		
    <tbody id="sort">            
<?php 
if(!empty($stringlike)  || !empty($sql_fecha_total) ){ 
 $sql_t="select count(*) as total  
								from suscritos_x_certificados sc 
								INNER JOIN certificados c ON sc.id_certificado= c.id_certificado 
								where sc.estado_idestado=1 and sc.estado=1  ".$sql_fecha_total."  and  ( c.id_certificado LIKE '".$stringlike."%' or c.titulo LIKE '".$stringlike."%' ) ";
		
		 // echo $sql_t; 
		
		$conulta_total=executesql($sql_t);
		
		if(!empty($conulta_total) ){
			// echo 'Total de registros: '.$paging->numTotalRegistros();
			echo 'Total de registros: '.$conulta_total[0]["total"];
			
		}
		
}		
		$ii=0;
		
		while ($detalles = $paging->fetchResultado()): 
			if(!in_array(array('mes' => $detalles['mes'], 'anho' => $detalles['anho']), $array)){
				$array[] = array('mes' => $detalles['mes'], 'anho' => $detalles['anho']);
?>
			<tr class="lleva-mes">
				<td colspan="9"><h6><?php echo strtoupper(strtr(date('M Y',strtotime($detalles['fecha_registro'])),$meses)); ?></h6></td>
			</tr>
			<tr role="row">
				<th width="30">Día</th>
        <th class="sort">N° REG</th>
        <th class="sort">CODIGO</th>
        <th class="sort">LIBRO</th>
        <th class="sort">Cod.cer</th>
        <th class="sort">Certificado</th>
        <th class="sort">COMPRA</th>
        <th class="sort">S/ TOTAL</th>
				<!--
				-->
        <th class="sort cnone" >ESPECIALIDAD</th>
        <th class="sort cnone" >DNI</th>
        <th class="sort cnone" >Cliente</th>
        <th class="sort cnone">E-mail</th>
        <th class="sort cnone">Celular</th>
        <th class="sort cnone">ASIGNADO POR</th>
				<th class="sort cnone" width="100">Estado de asignación</th>
			</tr>
<?php }//if meses 

$ii++;

if( $detalles["estado"] == 1){  // aprobado
	$fondo_entregar ='';
}elseif( $detalles["estado"] == 2){ // rechazado 
	$fondo_entregar ='background:rgba(255,0,0,0.6); color:#fff !important;';
}
?>        
       <tr>
        <td><?php echo !empty($detalles['fecha_registro']) ? date('d',strtotime($detalles['fecha_registro'])) : '...'; ?></td>
        <td ><?php echo $detalles["order_pdf"]; ?></td>   
        <td ><?php echo $detalles["certificado_codigo"]; ?></td>   
        <td ><?php echo $detalles["certificado_libro"]; ?></td>   
        <td >	
					<span style="<?php echo $fondo_entregar; ?> border-radius:50%;height:12px;width:12px;position: absolute;"></span> 
					<span style="padding-left:20px;"><?php echo $detalles["id_certificado"]; ?></span> 
				</td>        
        <td ><?php echo $detalles["certificado"]; ?></td>   
        <td class="cnone"><?php echo $detalles["id_pedido"]; ?></td>
        <td class="cnone"><?php echo $detalles["total"]; ?></td>
				<!-- 
				-->
        <td class="cnone"><?php echo $detalles["especialidad"]; ?></td>
        <td class="cnone"><?php echo $detalles["dni"]; ?></td>
        <td class="cnone"><?php echo $detalles["suscritos"]; ?></td>        
        <td class="cnone"><?php echo $detalles["email"]; ?></td> 
        <td class="cnone"><?php echo $detalles["telefono"]; ?></td> 
        <td class="cnone">
          <?php 
          if($detalles["id_pedido"] == 0){  // SI FUE ASIGNADO DIRECTAMENTE 

            if( !empty($detalles["idusuario"])){  // se registra apartir del 22/0872022
              $usuario=executesql("select nomusuario from usuario where idusuario='".$detalles['idusuario']."' ");
              echo $usuario[0]['nomusuario']." - </br> directamente ";
              
            }else{
              echo "ADMIN/gestion - </br> directamente ";
              
            }

          }else{
            echo $detalles["nombre_corto"].' </BR> - '; 

            if($detalles["tipo_pago"] == 1){  // SI FUE ASIGNADO DIRECTAMENTE 
              echo "Transferencia";
            }else if($detalles["tipo_pago"] == 2){  // SI FUE ASIGNADO DIRECTAMENTE 
              echo "Online";
            }else if($detalles["tipo_pago"] == 4){  // SI FUE ASIGNADO DIRECTAMENTE 
              echo "PAGO MANUAL ";
            }else if($detalles["tipo_pago"] == 3){  // SI FUE ASIGNADO DIRECTAMENTE 
              echo "PAGO EFECTIVO";
            }else{
              echo ' -- '; 
            }
          }
          
          ?>
        </td> 
        <td class="cnone"><?php if($detalles["estado_idestado"]==2){ echo "Deshabilitado"; }elseif($detalles["estado_idestado"]==1){ echo "Habilitado"; } ?></a>
				</td>
      </tr>
<?php endwhile; 

// echo 'okey_'.$ii;
?>
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
		<div class="col-sm-12 titulo_reporte criterio_buscar">
			<h4>Reporte: Clientes por certificados :</h4>
		</div>
								
		<?php create_input('hidden','tipo_pago',$_GET["tipo_pago"],"form-control pull-right",$table,$agregados); ?>
  	<div class="col-sm-2 criterio_buscar">
      <?php create_input('text','criterio_usu_per','',"form-control pull-right",$table,'placeholder="Ingrese cod.certificado "'); ?>
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
	</div></form>
  <div class="row"><div class="col-sm-12">
    <div id="div_listar"></div>
    <div id="div_oculto" style="display: none;"></div>
  </div></div>
</div></div>
<script>
var link = "reportes_clientes_certificado";/*la s final se agrega en js fuctions*/
var us = "reportes_clientes_certificados";/*sirve para mensaje en ventana eliminar*/
var l = "o";
var l2 = "e";/* est+ _ x {e,a,o ,etc}sirve para mensaje en ventana eliminar*/
var pr = "El";
var ar = "al";
var id = "id_pedido";
var mypage = "reportes_clientes_certificados.php";
</script>
<?php } ?>