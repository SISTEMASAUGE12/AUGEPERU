<?php error_reporting(E_ALL ^ E_NOTICE);
include_once("auten.php");

if( $_GET["task"]=='edit'){
  if($_GET["task"]=='edit'){
     $usuario=executesql("select * from pedidos where id_pedido='".$_GET["id_pedido"]."'",0);
  } 
?>
<script src="ckeditor/sample.js"></script>
<script src="ckeditor/ckeditor.js"></script>
<script src="ckfinder/ckfinder.js"></script>
<section class="content">
  <div class="row">
    <div class="col-md-12">
          <!-- Horizontal Form -->
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">COMPRAS ONLINE</h3>
            </div><!-- /.box-header -->
<?php $task_=$_GET["task"]; ?>
            <!-- form start -->
            <form  class="form-horizontal" method="POST" enctype="multipart/form-data" autocomplete="OFF">
<?php 
if($task_=='edit') create_input("hidden","id_pedido",$usuario["id_pedido"],"",$table,"");
create_input("hidden","urlfailed",basename($_SERVER['REQUEST_URI']),"",$table,"");  
create_input("hidden","urlgo",$link_pedidos,"",$table,"");
create_input("hidden","tipo_pago",$usuario["tipo_pago"],"",$table,""); 
create_input("hidden","nompage",$_GET["page"],"",$table,""); 
create_input("hidden","nommodule",$_GET["module"],"",$table,"");
create_input("hidden","nomparenttab",$_GET["parenttab"],"",$table,"");
?>
             <div class="box-body">
<!-- Data Pedido principal... -->
                <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                  <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingOne">
                      <h4 class="panel-title">
                        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        Datos Pedido
                        </a>
                      </h4>
                    </div>
                    <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                      <div class="panel-body">
												
												<div class="form-group">
                          <label for="inputEmail3" class="col-sm-2 control-label">Estado Pagó:</label>
												 <label for="inputEmail3" class="col-sm-2 control-label text-left ">	<b>
															<?php if($usuario['estado_pago'] == 1){
																				echo 'Aprobado';
																		}elseif($usuario['estado_pago'] == 2){
																				echo 'Por aprobar';
																		}else{ 
																				echo 'Rechazado';
																		}
																?>
													</b> </label>
                          
                        </div>
										<div class="col-sm-6">											
												<div class="form-group">
                          <label for="inputEmail3" class="col-sm-4 control-label">Tipo de compra: </label>
													<div class="col-sm-8">
														<label class="control-label" style="font-weight:400;">
														<?php if($usuario['tipo_pago'] == '2'){
																		echo 'Pago Online';
																	}else{
																		echo 'Deposito';																		
																	} ?>
														</label>
													</div>																										                         
                        </div>
											</div>
										<div class="col-sm-6">											
												<div class="form-group">
                          <label for="inputEmail3" class="col-sm-4 control-label">Código referencia:</label>
													<div class="col-sm-8">
														<label class="control-label" style="font-weight:400;">
														<?php echo !empty($usuario['codreferencia'])?$usuario['codreferencia']:'off-'.$usuario['codigo_ope_off']; ?>
														</label>
													</div>																										                         
                        </div>
										</div>
												
												<?php /* 
                        <div class="form-group">
                          <label for="inputEmail3" class="col-sm-2 control-label">Estado de Entrega</label>
                          <div class="col-sm-8">
                            <select id="estado_entrega" name="estado_entrega" class="form-control">  <!-- saco valor desde la BD -->
                              <option value="1" <?php echo ($usuario['estado_entrega'] == 1) ? 'selected' : '' ;?>>Entregado</option>  
                              <option value="2"  <?php echo ($usuario['estado_entrega'] == 2) ? 'selected' : '' ;?>>No entregado</option>
                              <option value="3"  <?php echo ($usuario['estado_entrega'] == 3) ? 'selected' : '' ;?>>En camino</option>
                            </select>
                          </div>
                        </div>
												*/ ?>
												
												
								<?php if($usuario['tipo_pago'] == '1'){ ?>				
												<div class="form-group">
                          <label for="inputPassword3" class="col-sm-2 control-label">Fecha del deposito:</label>
                          <div class="col-sm-3">
                          <?php create_input("text","fecha_pago_off",$usuario["fecha_pago_off"],"form-control",$table,"disabled",$agregado); ?>
                          </div>
                          <label for="inputPassword3" class="col-sm-3 control-label">Banco deposito:</label>
                          <label class="col-sm-2">
														<?php 
																	if($usuario['banco_pago'] == '1'){
																		echo 'BANCO NACIÓN';
																	}else if($usuario['banco_pago'] == '2'){
																		echo 'BCP';
																	}else if($usuario['banco_pago'] == '3'){
																		echo 'BBVA';
																	}else{
																		echo 'NO RECONOCIDO';																		
																	} 
														?>                     
													</label>
                        </div>  
								<?php } ?> 				
												
										<div class="col-sm-12">
                        <div class="form-group">
                          <label for="inputPassword3" class="col-sm-2 control-label">Monto Total:</label>
                          <div class="col-sm-3">
                            <?php create_input("text","total",$usuario["total"],"form-control",$table,'disabled',$agregado); ?>
                          </div>
                        </div>
										</div>
										
										<div class="col-sm-6">
                        <div class="form-group">
                          <label for="inputPassword3" class="col-sm-4 control-label">Subtotal:</label>
                          <div class="col-sm-6">
                            <?php create_input("text","subtotal",$usuario["subtotal"],"form-control",$table,"disabled",$agregado); ?>
                          </div>
									<?php /*                       
												<label for="inputPassword3" class="col-sm-2 control-label">Costo envio </label>
                          <div class="col-sm-2">
                            <?php create_input("text","envio",$usuario["envio"],"form-control",$table,"disabled",$agregado); ?>
                          </div>
								*/ ?>
                        </div>
										</div>
										<div class="col-sm-6">

                        <div class="form-group">
                          <label for="inputPassword3" class="col-sm-2 control-label">Fecha  </label>
                          <div class="col-sm-4">
                          <?php create_input("text","fecha_registro",$usuario["fecha_registro"],"form-control",$table,"disabled",$agregado); ?>
                          </div>
                          <label for="inputPassword3" class="col-sm-2 control-label">N°cursos </label>
                          <div class="col-sm-4">
                            <?php create_input("text","articulos",$usuario["articulos"],"form-control",$table,"disabled",$agregado); ?>
                          </div>
                        </div>
											</div>

								<?php if($usuario['tipo_pago'] == '1'){ ?>				                        
                       <div class="form-group">
													<label for="inputPassword3" class="col-sm-2 control-label">Imágen comprobante</label>
													<div class="col-sm-6">
														<?php create_input("hidden","imagen_ant",$usuario["imagen"],"",$table,$agregado); 
															if($usuario["imagen"]!=""){ 
														?>
														<!-- 
															<img src="<?php echo "files/images/comprobantes/".$usuario["imagen"]; ?>" width="200" class="mgt15">
															-->
															<button type="button" class="abrir_modal_images" data-toggle="modal" data-target="<?php echo '#image_1';  ?>" > 
																<img style="height:50px;width:50px;"  class="img-responsive" src="<?php echo "files/images/comprobantes/".$usuario["imagen"]; ?>">
															</button>
															
														<?php } ?> 
													</div>
												</div>

					<div id="<?php echo 'image_1'; ?>" class="modal  bd-example-modal-lg  modal_images modal_images_practico " tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display:none;">
						<div class="modal-dialog modal-lg">
							<div class="modal-content text-center">
								<div class="modal-header">
									<h5 class="modal-title" id="exampleModalLongTitle">Comprobante adjunto: </h5>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top:-20px;">
										<span aria-hidden="true">&times;</span>
									</button>
								</div>
								<img src="<?php echo 'files/images/comprobantes/'.$usuario["imagen"]; ?>"  class="img-responsive" style="max-width:600px;margin: auto;">								
								<div class="text-center" style="padding:30px 0 10px;">
									<a href="<?php echo 'files/images/comprobantes/'.$usuario["imagen"]; ?>"  target="_blank" class="btn btn-primary" style="max-width:600px;">	Ver imagen completa [Click aquí]</a>							
								</div>
							</div>
						</div>
					</div>
	
								<?php } ?> 
												
												
                      </div>
                    </div>
                  </div>
<!-- Data detalle pedido... -->                  
                  <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingTwo">
                      <h4 class="panel-title">
                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                          Detalle Pedido
                        </a>
                      </h4>
                    </div>
                    <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                      <div class="panel-body">
<?php 
	
	$linea=executesql("select * from linea_pedido where  id_pedido='".$_GET["id_pedido"]."' ");
	// $detallepro=executesql("select li.* , tp.titulo as tipo, p.imagen as imagen ,p.titulo as titulo, p.codigo as codigo from linea_pedido li 
															// INNER JOIN cursos p ON li.id_curso=p.id_curso  
															// INNER JOIN tipo_cursos tp ON p.id_tipo=tp.id_tipo  
															// WHERE li.id_pedido='".$_GET["id_pedido"]."'");
									?>                        
                        <table  class="table table-bordered table-striped">
                          <thead>
                            <tr role="row">
                              <th class="sort cnone" width="50">Tipo</th>
                              <th class="sort cnone" width="50">Codigo</th>
                              <th class="sort ">Producto</th>
                              <th class="sort ">N°</th>
                              <th class="sort cnone">Precio</th>
                              <th class="sort cnone">Subtotal</th>
                            </tr>
                          </thead>
                          <tbody id="sort">
					<?php 
								
						foreach( $linea as $rowdetalle){

								if($rowdetalle["talla"]=='9999'){ /* si es certificado */
										$detalle_certificado=executesql("select  cer.imagen as imagen ,cer.titulo as titulo, cer.id_certificado as codigo, cur.codigo as curso_codigo, cur.titulo as curso_de_certificado
															FROM certificados cer    
															INNER JOIN cursos cur ON cer.id_curso=cur.id_curso   
															WHERE cer.id_certificado='".$rowdetalle["id_curso"]."' ");
								?>
														<tr id="order_<?php echo $rowdetalle["id_linea"]; ?>">
                              <td ><b>Certificado</b></td>
                              <td ><?php echo $detalle_certificado[0]["codigo"]; ?></td>
                              <td ><?php echo $detalle_certificado[0]["titulo"].'</br> <small><b>curso:</b> '.$detalle_certificado[0]["curso_codigo"].'-'.$detalle_certificado[0]["curso_de_certificado"].'</small>'; ?></td>
                              <td  ><?php echo $rowdetalle["cantidad"]; ?></td>
                              <td class="cnone">S/ <?php echo $rowdetalle["precio"]; ?></td>
                              <td class="cnone"> S/<?php echo $rowdetalle["subtotal"]; ?></td>
                            </tr>
								<?php 	
								}else{  /* si es curso */
									$detalle_producto=executesql("select  tp.titulo as tipo, c.imagen as imagen ,c.titulo as titulo, c.codigo as codigo from cursos c    
															INNER JOIN tipo_cursos tp ON c.id_tipo=tp.id_tipo  
															WHERE c.id_curso='".$rowdetalle["id_curso"]."'");

							?>
                            <tr id="order_<?php echo $rowdetalle["id_linea"]; ?>">
                              <td ><?php echo $detalle_producto[0]["tipo"]; ?></td>
                              <td ><?php echo $detalle_producto[0]["codigo"]; ?></td>
                              <td ><?php echo $detalle_producto[0]["titulo"]; ?></td>
                              <td  ><?php echo $rowdetalle["cantidad"]; ?></td>
                              <td class="cnone">S/ <?php echo $rowdetalle["precio"]; ?></td>
                              <td class="cnone"> S/<?php echo $rowdetalle["subtotal"]; ?></td>
                            </tr>
				<?php 
							}
							
					} /* END FOR pedido */ ?>
                          </tbody>
                        </table>
                       
                      </div>
                    </div>
                  </div>
                
<!-- Data suscritos ... -->                  
                  <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingThree">
                      <h4 class="panel-title">
                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                          Datos Cliente
                        </a>
                      </h4>
                    </div>
                    <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                      <div class="panel-body">
<?php $detallepro=executesql("select *  from suscritos  where id_suscrito='".$usuario["id_suscrito"]."'"); ?>
                        <table  class="table table-bordered table-striped">
                          <thead>
                            <tr role="row">
                              <th class="sort ">Nombre</th>
                              <th class="sort ">DNI</th>
                              <th class="sort cnone">telefono</th>
                              <th class="sort ">Direccion</th>
                              <th class="sort cnone">email</th>
                            </tr>
                          </thead>
                          <tbody id="sort">
            <?php foreach($detallepro as $rowdetalle){ ?>
                            <tr id="order_<?php echo $rowdetalle["id_linea"]; ?>">                              
                              <td ><?php echo $rowdetalle["nombre"].' '.$rowdetalle["ap_pa"].' '.$rowdetalle["ap_ma"]; ?></td>
                              <td ><?php echo $rowdetalle["dni"]; ?></td>
                              <td ><?php echo $rowdetalle["telefono"]; ?></td>
                              <td ><?php echo $rowdetalle["direccion"]; ?></td>
                              <td ><?php echo $rowdetalle["email"]; ?></td>
                            </tr>
            <?php } ?>
                          </tbody>
                        </table>                        
                      </div>
                    </div>
                  </div>

                </div>

              </div>
              <div class="box-footer">
                <div class="form-group">
                  <div class="col-sm-10 text-center">
                    <button type="button" class="btn bg-gray btn-flat" onclick="javascript:gotourl('<?php echo $link_pedidos; ?>');">Cerrar</button>										
                  </div>
									
                </div>
              </div>
            </form>
          </div><!-- /.box -->
        </div><!--/.col (right) -->
  </div>
<script>
var link = "pedido";/*la s final se agrega en js fuctions*/
var us = "pedido";/*sirve para mensaje en ventana eliminar*/
var l = "o";
var l2 = "e";/* est+ _ x {e,a,o ,etc}sirve para mensaje en ventana eliminar*/
var pr = "El";
var ar = "al";
var id = "id_pedido";
var mypage = "reportes_ventas_onlines.php";
</script>
</section><!-- /.content -->
<?php

}elseif($_GET["task"]=='finder'){
  $array= array();
	$meses=array('Jan'=>'Enero','Feb'=>'Febrero','Mar'=>'Marzo','Apr'=>'Abril','May'=>'Mayo','Jun'=>'Junio','Jul'=>'Julio','Aug'=>'Agosto','Sep'=>'Septiembre','Oct'=>'Octubre','Nov'=>'Noviembre','Dec'=>'Diciembre');
	
  $sql= "SELECT pp.*,YEAR(pp.fecha_registro) as anho, MONTH(pp.fecha_registro) as mes, e.nombre AS estado ,s.email as email,  CONCAT(s.nombre,' ',s.ap_pa,' ',s.ap_ma )as suscritos , s.dni as dni 
	FROM pedidos pp 
  INNER JOIN estado e ON pp.estado_idestado=e.idestado 
  INNER JOIN suscritos s ON pp.id_suscrito=s.id_suscrito 
	WHERE pp.tipo_pago=2 "; 
  
  if (isset($_GET['criterio_mostrar'])) $porPagina=$_GET['criterio_mostrar'];
  if(isset($_GET['criterio_usu_per']) && !empty($_GET['criterio_usu_per'])){
    $stringlike=fn_filtro(substr($_GET['criterio_usu_per'], 0, 16));
    $sql.= " AND ( s.dni LIKE '".$stringlike."%' or s.nombre LIKE '".$stringlike."%' or s.email LIKE '".$stringlike."%' or pp.codigo LIKE '".$stringlike."%' or pp.codreferencia LIKE '".$stringlike."%' or pp.id_pedido LIKE '".$stringlike."%' )"; 
  }else{
		if( empty($_GET['fechabus_1']) && empty($_GET['fechabus_2']) ) {
			$sql .= " AND DATE(pp.fecha_registro) = '" . fecha_hora(1) . "'";
		}
		
	}
	
	if(!empty($_GET['estado_pago']) ){
			$sql .= " AND pp.estado_pago = '".$_GET['estado_pago']."'";
	}


		if(!empty($_GET['fechabus_1']) && !empty($_GET['fechabus_2'])) {
			$sql .= " AND DATE(pp.fecha_registro)  BETWEEN  DATE('".$_GET['fechabus_1']."')  and DATE('".$_GET['fechabus_2']."')  ";		
	}

	
	if(isset($_SESSION['pagina2'])) {
			$_GET['pagina'] = $_SESSION['pagina2'];
	}
	
  if(isset($_GET['criterio_ordenar_por'])) $sql.= sprintf(" order by %s %s", fn_filtro($_GET['criterio_ordenar_por']), fn_filtro($_GET['criterio_orden']));
 $sql.= " ORDER BY pp.orden DESC";
 
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
  $paging->pagina_proceso="reportes_ventas_onlines.php";
?>
  <table id="example1" class="table table-bordered table-striped">
		<!-- *EXCEL -->
		<?php  /*  Fechas para excel */ 
			$fecha_excel_inicio= !empty($_GET["fechabus_1"])?$_GET["fechabus_1"]:fecha_hora(1); 
		?>
		<input type="hidden" name="sql_excel" id="sql_excel" value="<?php echo $sql; ?>">
		<a href="javascript:fn_exportar('tipo_form=1&fecha_filtro_inicio=<?php echo $fecha_excel_inicio;?>&fecha_filtro_fin=<?php echo $_GET["fechabus_2"];?>','ventas_online');" class="btn btn-primary excel "  > Excel</a>
		
	
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
          <th class="sort " >Cod COMPRA</th>
          <th class="sort "  width="100">Cod transac</th>
          <th class="sort cnone" >Cliente</th>
          <th class="sort cnone">E-mail</th>
          <th class="sort cnone" width="95">Estado de COMPRA</th>
          <th class="sort ">Total</th>
          <th class="sort cnone" width="60">#cursos</th>
					<!-- 
          <th class="sort cnone" width="100">ENTREGADO</th>
					-->
          <th class="unafbe" width="70">Ver</th>
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
        <td><?php echo !empty($detalles['fecha_registro']) ? date('d',strtotime($detalles['fecha_registro'])) : '...'; ?></td>
        <td >	
					<span style="<?php echo $fondo_entregar; ?> border-radius:50%;height:12px;width:12px;position: absolute;"></span> 
							<span style="padding-left:20px;"><?php echo $detalles["id_pedido"]; ?></span> 
				</td>        
        <td ><?php 
					if(!empty($detalles["codreferencia"])){
						echo $detalles["codreferencia"];
						
					}else{ //codigo del pago off-line -transccion
						echo 'off-'.$detalles["codigo_ope_off"];
						
					}
				
				?></td>        
        <td class="cnone"><?php echo $detalles["dni"].' - '.$detalles["suscritos"]; ?></td>        
        <td class="cnone"><?php echo $detalles["email"]; ?></td>        
				<td class="cnone">
					<a  style="color:#333;font-weight:800;">
						<?php if($detalles["estado_pago"]==2){ echo "Por verificar";
						}elseif($detalles["estado_pago"]==1){ echo "Aprobado";  
						}elseif($detalles["estado_pago"]==3){ echo "Rechazado"; 
						}else{ echo "#no fount."; 
						} ?>
					</a>
				</td>
        <td > S/<?php echo $detalles["total"]; ?></td>
        <td class="cnone"> <?php echo $detalles["articulos"]; ?></td>
        <!-- 
				<td class="cnone"><a href="javascript: fn_estado_pedido('<?php echo $detalles["id_pedido"]; ?>')"  style="color:#fff;font-weight:800;">
                <?php if($detalles["estado_entrega"]==2){ echo "Por entregar"; }elseif($detalles["estado_entrega"]==3){ echo "En camino"; }else{ echo "Entregado";} ?></a>
				</td>
				-->
        <td>
          <div class="btn-eai btr text-center" style="width:70px;">
            <a href="<?php echo $_SESSION["base_url"].'&task=edit&id_pedido='.$detalles["id_pedido"]; ?>" style="color:#fff;"><i class="fa fa-eye"></i> ver</a>
           
          </div>
        </td>
      </tr>
<?php endwhile; ?>
    </tbody>
  </table>
  <div class="pagination"><?php echo $paging->fetchNavegacion(); ?></div>
<script>
$(function(){
  // reordenar('reportes_ventas_onlines.php');
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
										<h4>Reporte: Ventas online: culqi</h4>
									</div>
								<?php create_input('hidden','tipo_pago',$_GET["tipo_pago"],"form-control pull-right",$table,$agregados); ?>
                <div class="col-sm-3 criterio_buscar">
                  <?php create_input('text','criterio_usu_per','',"form-control pull-right",$table,'placeholder="Busca por cod.compra, cod.transacción, DNI "'); ?>
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
var link = "pedido";/*la s final se agrega en js fuctions*/
var us = "pedido";/*sirve para mensaje en ventana eliminar*/
var l = "o";
var l2 = "e";/* est+ _ x {e,a,o ,etc}sirve para mensaje en ventana eliminar*/
var pr = "El";
var ar = "al";
var id = "id_pedido";
var mypage = "reportes_ventas_onlines.php";
</script>
<?php } ?>