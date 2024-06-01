<?php error_reporting(E_ALL ^ E_NOTICE);
include_once("auten.php");

if($_GET["task"]=='drop' || $_GET["task"]=='dropselect'){
  $bd = new BD;
  $bd->Begin();
  $ide = !isset($_GET['id_vouchers']) ? implode(',', $_GET['chkDel']) : $_GET['id_vouchers'];
	
  $bd->actualiza_("DELETE FROM vouchers WHERE id_vouchers IN(".$ide.")");
  $bd->Commit();
  $bd->close();
	
	
}else if($_GET["task"]=='finder'){
  $array= array();
	$meses=array('Jan'=>'Enero','Feb'=>'Febrero','Mar'=>'Marzo','Apr'=>'Abril','May'=>'Mayo','Jun'=>'Junio','Jul'=>'Julio','Aug'=>'Agosto','Sep'=>'Septiembre','Oct'=>'Octubre','Nov'=>'Noviembre','Dec'=>'Diciembre');
		
  $sql= "SELECT v.*,YEAR(v.fecha_registro) as anho, MONTH(v.fecha_registro) as mes, CONCAT(s.nombre,' ',s.ap_pa,' ',s.ap_ma )as suscritos, bb.nombre as banco, pp.codigo, s.dni, pp.estado_pago, pp.tipo_pago , pp.imagen 
		FROM vouchers v 
  	LEFT JOIN pedidos pp ON v.id_pedido=pp.id_pedido
  	LEFT JOIN suscritos s ON v.id_suscrito=s.id_suscrito
  	LEFT JOIN bancos bb ON v.id_banco=bb.id_banco ";
  
  if (isset($_GET['criterio_mostrar'])) $porPagina=$_GET['criterio_mostrar'];
  if(isset($_GET['criterio_usu_per']) && !empty($_GET['criterio_usu_per'])){
    $stringlike=fn_filtro(substr($_GET['criterio_usu_per'], 0, 16));
			$pos = strpos($sql, 'WHERE');
      $sql.= (($pos === false) ? "WHERE" : "AND" )." (s.dni LIKE '".$stringlike."%' OR s.nombre LIKE '".$stringlike."%' OR s.ap_pa LIKE '".$stringlike."%' OR s.ap_ma LIKE '".$stringlike."%' OR v.codigo_operacion LIKE '".$stringlike."%' OR pp.codigo LIKE '".$stringlike."%' OR pp.id_pedido LIKE '".$stringlike."%') "; 
  }else{
		if( empty($_GET['fechabus_1']) && empty($_GET['fechabus_2']) ) {
			$pos = strpos($sql, 'WHERE');
      $sql.= (($pos === false) ? "WHERE" : "AND" )." DATE(v.fecha_registro) <= '" . fecha_hora(1) . "'";
		}
		
	}
	
	if(!empty($_GET['estado_pago']) ){
			$sql .= " AND pp.estado_pago = '".$_GET['estado_pago']."'";
	}

		if(!empty($_GET['fechabus_1']) && !empty($_GET['fechabus_2'])) {
			$pos = strpos($sql, 'WHERE');
      $sql.= (($pos === false) ? "WHERE" : "AND" )." DATE(v.fecha_registro)  BETWEEN  DATE('".$_GET['fechabus_1']."')  and DATE('".$_GET['fechabus_2']."')  ";		
	}
	
	if(isset($_SESSION['pagina2'])) {
			$_GET['pagina'] = $_SESSION['pagina2'];
	}
	
  if(isset($_GET['criterio_ordenar_por'])) $sql.= sprintf(" order by %s %s", fn_filtro($_GET['criterio_ordenar_por']), fn_filtro($_GET['criterio_orden']));
 $sql.= " ORDER BY v.fecha_registro DESC";
 
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
  $paging->porPagina(1000);
  $paging->ejecutar();
  $paging->pagina_proceso="reportes_voucher.php";
?>
  <table id="example1" class="table table-bordered table-striped">
		<!-- *EXCEL -->
		<?php  
	if( $_SESSION["visualiza"]["idtipo_usu"] != 4 ){
		/*  Fechas para excel */ 
			$fecha_excel_inicio= !empty($_GET["fechabus_1"])?$_GET["fechabus_1"]:fecha_hora(1); 
		?>
		<input type="hidden" name="sql_excel" id="sql_excel" value="<?php echo $sql; ?>">
		<a href="javascript:fn_exportar('tipo_form=1&fecha_filtro_inicio=<?php echo $fecha_excel_inicio;?>&fecha_filtro_fin=<?php echo $_GET["fechabus_2"];?>','voucher');" class="btn btn-primary excel "  > Excel</a>
<?php } ?> 
	
	
    <tbody id="sort">            
<?php 
echo 'Total de registros: '.$paging->numTotalRegistros();
		while ($detalles = $paging->fetchResultado()): 
			if(!in_array(array('mes' => $detalles['mes'], 'anho' => $detalles['anho']), $array)){
				$array[] = array('mes' => $detalles['mes'], 'anho' => $detalles['anho']);
?>
				<tr class="lleva-mes">
					<td colspan="11"><h6><?php echo strtoupper(strtr(date('M Y',strtotime($detalles['fecha_registro'])),$meses)); ?></h6></td>
				</tr>
				<tr role="row">
					<th width="30">Día</th>
          <th class="sort cnone">TIPO_VENTA</th>
          <th class="sort">Banco</th>
          <th class="sort" width="60">Cód.Ope</th>
          <th class="sort" width="60"> IMG</th>
          <th class="sort cnone" >Pedido</th>
          <th class="sort cnone  ">DNI</th>
          <th class="sort cnone">Cliente</th>
          <th class="sort ">Estado envío</th>
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
        <td class="cnone"><?php
        	if($detalles["tipo_pago"]==1){ echo 'Offline/Deposito';
        	}elseif($detalles["tipo_pago"]==2){ echo 'Online';
        	}elseif($detalles["tipo_pago"]==3){ echo 'PafoEfectivo';
        	}elseif($detalles["tipo_pago"]==4){ echo 'Venta Manual';
        	}
       ?></td>
        <td class=" "><?php echo $detalles["banco"]; ?></td>        
        <td class=" "><?php echo $detalles["codigo_operacion"]; ?></td>  
        
        <td class="cnone">
				
        <?php if($detalles["imagen"]!=""){  ?>													
          <button type="button" class="abrir_modal_images" data-toggle="modal" data-target="#img_<?php echo $detalles["id_pedido"];  ?>" > 
            <img style="height:50px;width:50px;"  class="img-responsive" src="<?php echo "files/images/comprobantes/".$detalles["imagen"]; ?>">
          </button>						
        <?php } ?> 
                  
          <div id="img_<?php echo $detalles["id_pedido"];  ?>" class="modal  bd-example-modal-lg  modal_images modal_images_practico " tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display:none;">
              <div class="modal-dialog modal-lg">
                <div class="modal-content text-center">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Comprobante adjunto: </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top:-20px;">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <img src="<?php echo 'files/images/comprobantes/'.$detalles["imagen"]; ?>"  class="img-responsive img_flota "  style="max-width:600px;margin: auto;">								
                  <div class="text-center" style="padding:30px 0 10px;">
                    <a href="<?php echo 'files/images/comprobantes/'.$detalles["imagen"]; ?>"  target="_blank" class="btn btn-primary" style="max-width:600px;">	Ver imagen completa [Click aquí]</a>							
                  </div>
                </div>
              </div>
          </div>

      </td>

        <td class="cnone"><?php echo $detalles["id_pedido"]; ?></td>        
        <td class=" cnone "><?php echo $detalles["dni"]; ?></td>        
        <td class="cnone"><?php echo $detalles["suscritos"]; ?></td>    
        <td class=" "><?php
        	if($detalles["estado_pago"]==1){ echo 'Aprobado';
        	}elseif($detalles["estado_pago"]==2){ echo 'Pendiente';
        	}elseif($detalles["estado_pago"]==3){ echo '<span style="color:red;">Rechazado</span>';
        	}
       ?></td>
        
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
									<h4>Reporte: Vouchers:</h4>
								</div>
								
								<?php create_input('hidden','tipo_pago',$_GET["tipo_pago"],"form-control pull-right",$table,$agregados); ?>
                <div class="col-sm-3 criterio_buscar">
                  <?php create_input('text','criterio_usu_per','',"form-control pull-right",$table,'placeholder="Ingresa .... "'); ?>
                </div>
								<div class="col-sm-2 criterio_buscar">
										<select name="estado_pago" id="estado_pago" class="form-control" >
												<option value="" >ver todo</option>
												<option value="1" >Entregado</option>
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
var link = "reportes_voucher";/*la s final se agrega en js fuctions*/
var us = "voucher";/*sirve para mensaje en ventana eliminar*/
var l = "o";
var l2 = "e";/* est+ _ x {e,a,o ,etc}sirve para mensaje en ventana eliminar*/
var pr = "El";
var ar = "al";
var id = "id_vouchers";
var mypage = "reportes_voucher.php";
</script>
<?php } ?>