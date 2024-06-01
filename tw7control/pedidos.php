<?php error_reporting(E_ALL ^ E_NOTICE);
include_once("auten.php");

if(  $_GET["task"]=='update'){
  $bd=new BD;
	

	
	
	$_POST['fecha_modificacion'] = fecha_hora(2);
	$_POST['usuario_modifico'] =$_SESSION["visualiza"]["idusuario"];	
	$campos=array('usuario_modifico','fecha_modificacion','observacion'); /*inserto campos principales*/
	
	/* valido si el cliente ya tiene un compra, si ya tiene compra, sera tipo_venta=3, cliente ya con compra no suma en comisiones.  */
	$cliente_ya_compro=executesql(" select * from pedidos where estado_pago=1 and estado_idestado=1 and id_suscrito='".$_POST["id_suscrito"]."' ");
	if( !empty($cliente_ya_compro) ){  // si ya tiene compras, esta venta no suma en comision: ser tipo_venta =3 
		$_POST["tipo_venta"]=3; // venta CLIENTE ya con compra
		// si cliente ya tenia compras actuliazo este tipo de venta para q no sume la comiiosnh
		$campos=array_merge($campos,array('tipo_venta'));  
	}

	if($_SESSION["visualiza"]["idtipo_usu"] == 4){  /* si estoy con usuario de ventas y marco que esta venta me pertenece */
		$_POST['idusuario'] =$_SESSION["visualiza"]["idusuario"];
		$campos=array_merge($campos,array('idusuario'));
	}
	
	// echo var_dump(armaupdate('pedidos',$campos," id_pedido='".$_POST["id_pedido"]."'",'POST'));	
	// exit();
		
	$bd->actualiza_(armaupdate('pedidos',$campos," id_pedido='".$_POST["id_pedido"]."'",'POST'));/*actualizo*/


  $bd->close();
  gotoUrl("index.php?page=".$_POST["nompage"]."&tipo_pago=".$_POST["tipo_pago"]."&module=".$_POST["nommodule"]."&parenttab=".$_POST["nomparenttab"]);
	
	
	
}else if( $_GET["task"]=='edit'){
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
              <h3 class="box-title">COMPRAS</h3>
            </div><!-- /.box-header -->
<?php $task_=$_GET["task"]; ?>
            <!-- form start -->
            <form  class="form-horizontal" action="pedidos.php?task=update" method="POST" enctype="multipart/form-data" autocomplete="OFF" onsubmit="return aceptar()" >
<?php 
if($task_=='edit') create_input("hidden","id_pedido",$usuario["id_pedido"],"",$table,"");
if($task_=='edit') create_input("hidden","id_suscrito",$usuario["id_suscrito"],"",$table,""); 

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
																				echo '<span style="color:green;">Aprobado </span>';
																		}elseif($usuario['estado_pago'] == 2){
																				echo 'Por aprobar';
																		}else{ 
																				echo '<span style="color:red;">Rechazado</span>';
																		}
																?>
													</b> </label>
                          
                        </div>
										<div class="col-sm-6">											
												<div class="form-group">
                          <label for="inputEmail3" class="col-sm-4 control-label">Tipo de compra: </label>
													<div class="col-sm-8">
														<label class="control-label" style="font-weight:400;">
														<?php 
																	if($usuario['tipo_pago'] == '2'){
																		echo 'Pago Online';
																	}else if($usuario['tipo_pago'] == '1'){
																		echo 'Deposito / YAPE';																		
																	}else if($usuario['tipo_pago'] == '3'){
																		echo 'Pago Efectivo';																		
																	}else{
																		echo ' error_ cosultar a sistemas ';																		
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
																		echo 'BANCO NACIÓN CC CORRIENTE';
																	}else if($usuario['banco_pago'] == '5'){
																		echo 'BANCO NACIÓN CC AHORROS ';
																		
																	}else if($usuario['banco_pago'] == '9'){
																		echo 'BANCO BBVA  ';
																	}else if($usuario['banco_pago'] == '8'){
																		echo 'BANCO BCP ';
																		
																	}else if($usuario['banco_pago'] == '6'){
																		echo 'YAPE';
																	}else{
																		echo 'NO RECONOCIDO';																		
																	} 
														?>                     
													</label>
                        </div>  
								<?php } ?> 			
								
								<?php if($usuario['tipo_pago'] == '3'){  /* Pago efectivo */ ?>				
												<div class="form-group">
												<!-- 
                          <label for="inputPassword3" class="col-sm-2 control-label">Fecha del pago:</label>
                          <div class="col-sm-3">
                          <?php create_input("text","fecha_pago_off",$usuario["fecha_pago_off"],"form-control",$table,"disabled",$agregado); ?>
                          </div>
													-->
                          <label for="inputPassword3" class="col-sm-3 control-label">Orden Pago efectivo:</label>
                          <label class="col-sm-2">
														<?php 
																	echo $usuario['codigo_ope_off'].' - '.$usuario['comentario'];
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
								}else if($rowdetalle["talla"]=='7777'){ /* si es examenes  */
									$sql_examen="select  cer.imagen as imagen ,cer.titulo as titulo, cer.id_examen as codigo 
									FROM examenes cer    
									WHERE cer.id_examen='".$rowdetalle["id_curso"]."' "; 
									// echo $sql_examen;	
									$detalle_examen=executesql($sql_examen);
								?>
														<tr id="order_<?php echo $rowdetalle["id_linea"]; ?>">
                              <td ><b>Examen</b></td>
                              <td ><?php echo $detalle_examen[0]["codigo"]; ?></td>
                              <td ><?php echo $detalle_examen[0]["titulo"]; ?></td>
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
                              <td ><?php echo $rowdetalle["id_suscrito"].'-'.$rowdetalle["nombre"].' '.$rowdetalle["ap_pa"].' '.$rowdetalle["ap_ma"]; ?></td>
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
								
								<div class="form-group">
									<label for="inputPassword3" class="col-sm-2 control-label">Agregar observación:</label>
									<div class="col-sm-8">
										<?php create_input("textarea","observacion",$usuario["observacion"],"form-control",$table, (($_SESSION["visualiza"]["idtipo_usu"] ==4)?' disabled ':'')." placeholder='Describa una onservación si existiera ' "); ?>
									</div>
								</div>
						

              </div>
              <div class="box-footer">
                <div class="form-group">
								
                  <div class="col-sm-10 text-center" style="margin-top:30px;">	
				 <?php  if( $_SESSION["visualiza"]["idtipo_usu"] ==4   ){   /* ventas se asigne como el de la venta   */ ?>
							<?php  if( empty($usuario["idusuario"]) ){   /* ventas se asigne como el de la venta   */ ?>
										<input  type="submit"  class="btn bg-blue btn-flat" id="btnguardar" value="Asignarme esta venta">
							<?php } ?> 
										<button type="button" class="btn bg-gray btn-flat" onclick="javascript:gotourl('<?php echo $link_pedidos; ?>');">Cerrar.</button>
										
				 <?php }else{ ?>
										<input  type="submit"  class="btn bg-blue btn-flat" id="btnguardar" value="Guardar observación">
				 <?php } ?>
									</div>


                  <div class="col-sm-10 text-center">
				 <?php  if($_SESSION["visualiza"]["idtipo_usu"] ==1 || $_SESSION["visualiza"]["idtipo_usu"] ==3){  /* solo admin y gestion aprueban  */ ?>
				 
								<?php if($usuario['estado_pago'] ==2 || $usuario['estado_pago'] ==3){  /* si el pago esta en pendiente o rechazado se le puede aporbar */ ?>                       
                    <a  href="javascript: fn_estado_pago('<?php echo $usuario["id_pedido"]; ?>')"  class="btn bg-green btn-flat btn_verde">Aprobar</a>
								<?php  }   ?>      								               								
                  </div>
				<?php  }  ?> 										
									
				<div class="col-sm-12 " style="padding-top:25px;">											
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-3 control-label">Motivo porque anuló: *requerido</label>
						<div class="col-sm-9  ">
							<?php create_input("textarea","comentario",$usuario["comentario"],"form-control",$table,"  ",$agregado); ?>
							
						</div>																										                         
					</div>
				</div>
				
				<?php if($usuario['estado_pago'] != 3 && $task_=='edit' ){  ?>   
									<a href="javascript: fn_estado_rechazar_pago('<?php echo $usuario["id_pedido"]; ?>')" class="btn bg-red btn-flat">Rechazar</a>
				<?php } ?>
									
									<button type="button" class="btn bg- btn-flat" onclick="javascript:gotourl('<?php echo $link2; ?>');">CERRAR</button>

									
									

                </div>
              </div>
<script>	
function aceptar(){
	var nam1=document.getElementById("observacion").value;		
	
	// if(nam1 !='' ){									
		alert("Guardando observacion ... Click en Aceptar & espere unos segundos. ");							
		document.getElementById("btnguardar").disabled=true;			
	// }else{		
		// alert("Recomendación: Ingrese una observación ");
		// return false; //el formulario no se envia		
	// }
	
}				
</script>								
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
var mypage = "pedidos.php";
</script>
</section><!-- /.content -->
<?php

}elseif($_GET["task"]=='drop' || $_GET["task"]=='dropselect'){
  
  // $bd = new BD;
  // $bd->Begin();
  // $ide = !isset($_GET['id_pedido']) ? implode(',', $_GET['chkDel']) : $_GET['id_pedido'];
  // $bd->actualiza_("DELETE FROM  linea_pedido WHERE id_pedido IN(".$ide.")");
  // $bd->actualiza_("DELETE FROM pedidos WHERE id_pedido IN(".$ide.")");
  // $bd->Commit();
  // $bd->close();
	
}elseif($_GET["task"]=='uestado'){
  $bd = new BD;
  $bd->Begin();
  $ide = !isset($_GET['id_pedido']) ? $_GET['estado_idestado'] : $_GET['id_pedido'];
  $ide = is_array($ide) ? implode(',',$ide) : $ide;
  $usuario = executesql("SELECT * FROM pedidos WHERE id_pedido IN (".$ide.")");
  if(!empty($usuario))
  foreach($usuario as $reg => $item)
  if ($item['estado_idestado']==1) {
    $state = 2;
  }elseif ($item['estado_idestado']==2) {
    $state = 1;
  }
  $num_afect=$bd->actualiza_("UPDATE pedidos SET estado_idestado=".$state." WHERE id_pedido=".$ide."");
  echo $state;
  $bd->Commit();
  $bd->close();


// Aprobamos pago
}elseif($_GET["task"]=='uestado_pago'){
  $bd = new BD;
  $bd->Begin();
  $ide = !isset($_GET['id_pedido']) ? $_GET['id_pedido'] : $_GET['id_pedido'];
  $ide = is_array($ide) ? implode(',',$ide) : $ide;
  
 $sql_aprobando="SELECT * FROM pedidos WHERE id_pedido IN (".$ide.")";
 
  $usuario = executesql($sql_aprobando); //

  if(!empty($usuario))
  foreach($usuario as $reg => $item)
	$id_suscrito=$item['id_suscrito'];

	if( $item['estado_pago']==2 || $item['estado_pago']==3){
    $state = 1;
		// actualizando confirmando el pago: Pago Ok! 
		// asignamos cursos al alumno automaticamente: 
		if( !empty($_GET['id_pedido'] ) && $_GET['id_pedido'] > 0 ){ // si existe id_pedido hacemos el recorrido 
			$bd=new BD;  
			$_POST['estado'] = 1;
			$campos=array('estado');

			$bd->actualiza_(armaupdate('suscritos_x_cursos',$campos," id_pedido='".$_GET["id_pedido"]."'",'POST'));/*actualizo*/
			// echo "A";
		
			/*marco certificados como pagados .. */
			// saco orden para PDF		
			$certificado_data=executesql("select * from suscritos_x_certificados where  id_pedido=".$_GET["id_pedido"] );		
			if( !empty($certificado_data) ){
				$orden_pdf=executesql("select * from suscritos_x_certificados where  id_certificado='".$certificado_data[0]["id_certificado"]."' and estado_idestado=1  and estado=1 ");
				$_POST["order_pdf"]=   !empty($orden_pdf) ?count($orden_pdf) +1 : 1;
				$campos=array_merge($campos, array('order_pdf'));
	
				$bd->actualiza_(armaupdate('suscritos_x_certificados',$campos," id_pedido='".$_GET["id_pedido"]."'",'POST'));/*actualizo*/
				
				// exit();
			}									
			
			// se aprueba la venta del examen 
			$examen=executesql("select * from suscritos_x_examenes where  id_pedido=".$_GET["id_pedido"] );		
			if( !empty($examen) ){			
				$bd->actualiza_(armaupdate('suscritos_x_examenes',$campos," id_pedido='".$_GET["id_pedido"]."'",'POST'));/*actualizo*/				
				// exit();
			}									

	
		} // si exite id_pedido
  	} // elseif 
	

	$_POST['fecha_modificacion'] = fecha_hora(2);
	$_POST['usuario_modifico'] =$_SESSION["visualiza"]["idusuario"];
	
  	$num_afect=$bd->actualiza_("UPDATE pedidos SET estado_pago=".$state.", fecha_modificacion='".$_POST['fecha_modificacion']."' , usuario_modifico='".$_POST['usuario_modifico']."'  WHERE id_pedido=".$ide."");
	
	
	
	/* API INFUSION */
	/* Infusion*/
		$tag_id_campana_shop=''; /*Infusion soft api */
		$link_api='https://www.educaauge.com/tw7conrol/pedidos.php'; /* pagina donde se va a utilizar el token */
		require_once '../vendor/autoload.php';
		require('../vendor/infusionsoft/php-sdk/src/Infusionsoft/Api/ContactService.php');
		/* Infusion*/
		
		$data_client=executesql(" select * from suscritos where id_suscrito='".$id_suscrito."' ");
		$correo_cliente_api=$data_client[0]['email'];

		/* 1. API INFUSION CLIENTE: Obtener ID si ya existe o registrar sino esta en infusion aun  */
		if( !empty($correo_cliente_api) ){ /* si es pago transferencia */
		
			$tagId=2100;	
			$registro_desde="compra_online_transferencia";
			$_POST['FirstName']= $data_client[0]["nombre"];
			$_POST['LastName']= $data_client[0]["ap_pa"].' '.$data_client[0]["ap_ma"];
			$_POST['StreetAddress1']=$data_client[0]["direccion"];
			$_POST['Phone1']= $data_client[0]["telefono"];					
			$_POST['correo']=$data_client[0]["email"];

			include('../inc_api_infusion_compro_curso.php');
		}
		// /* API INFUSION */
			// echo "salio";
		/* recorro linea de pedido  */
				$sql_p='select lp.*, c.tag as tag  
							from linea_pedido lp 
							INNER JOIN cursos c ON lp.id_curso=c.id_curso 
							WHERE  id_pedido="'.$_GET["id_pedido"].'" ';
						
				$linea_pedido=executesql($sql_p);
				if(!empty($linea_pedido) ){ 
					foreach($linea_pedido as $data ){  /* linea de pedido, saca curso y sus especialidades y pack ya esta todo en linea de pedido  */
							$_POST['id_curso']=$data["id_curso"];
							$tag_id_campana_shop=$data['tag'];	
							
							// /* 2. API INFUSION ADD TAG CURSO COMPRADO */
							if( !empty($tag_id_campana_shop) && $tag_id_campana_shop > 0 ){ /* se detecto los cursos de campaña se activa esta parte */
								include('../inc_api_infusion_compro_curso_todos_tags.php');
							}
							// /* API INFUSION */
							
						
					} // for linea pedido
				} // if		linea pedido 				

	/* END API */
			/* END API */
	
   echo $state;	
	
  $bd->Commit();
  $bd->close();


// rechazamos pago
}elseif($_GET["task"]=='uestado_pago_rechazar'){
  $bd = new BD;
  $bd->Begin();
 $usuario_modifico =$_SESSION["visualiza"]["idusuario"];

  $ide = !isset($_GET['id_pedido']) ? $_GET['id_pedido'] : $_GET['id_pedido'];
  $ide = is_array($ide) ? implode(',',$ide) : $ide;
  $usuario = executesql("SELECT * FROM pedidos WHERE id_pedido IN (".$ide.")"); //
  
	if(!empty($usuario) && !empty($_GET['comentario']) ){   // comentario motivo de rechazo obligatorio 

		foreach($usuario as $reg => $item){
			if ($item['estado_pago']==1 || $item['estado_pago']==2){
				$state = 3;
				// actualizando Rechazando la compra 
				// deshabilitamos estados de cursos asignados 
				if( !empty($_GET['id_pedido'] ) && $_GET['id_pedido'] > 0 ){ // si existe id_pedido hacemos el recorrido 
					$bd=new BD;  
					$sql_p='select ide, estado from suscritos_x_cursos  where  id_pedido="'.$_GET["id_pedido"].'" ';
					$linea_pedido=executesql($sql_p);
					if(!empty($linea_pedido) ){ 
						foreach($linea_pedido as $data ){
								//asignamos
								$_POST['estado'] = 3;
								$campos=array('estado');
								$bd->actualiza_(armaupdate('suscritos_x_cursos',$campos," id_pedido='".$_GET["id_pedido"]."'",'POST'));/*actualizo*/
					
						} // for
					} // if
					
				} // si exite id_pedido
			} // elseif 
		} // end for 


		/*  suscritos_x_certificados  */
		$sql_cer='select ide, estado from suscritos_x_certificados  where  id_pedido="'.$_GET["id_pedido"].'" ';
		$certi=executesql($sql_cer);
		if(!empty($certi) ){ 
			foreach($certi as $data ){
					//asignamos
					$_POST['estado'] = 3;
					$campos=array('estado');
					$bd->actualiza_(armaupdate('suscritos_x_certificados',$campos," id_pedido='".$_GET["id_pedido"]."'",'POST'));/*actualizo*/
		
			} // for
		} // if
		
		/** examenes vendidos  */
		$sql_exam ='select ide, estado from suscritos_x_examenes where  id_pedido="'.$_GET["id_pedido"].'" ';
		$examen=executesql($sql_exam);
		if(!empty($examen) ){ 
			$_POST['estado'] = 3;
			$campos=array('estado');
			$bd->actualiza_(armaupdate('suscritos_x_examenes',$campos," id_pedido='".$_GET["id_pedido"]."'",'POST'));/*actualizo*/			
		} // if


		/*  si tiene solicitudes   */
		$sql_p='select ide, estado from solicitudes  where  id_pedido="'.$_GET["id_pedido"].'" ';
		$linea_pedido=executesql($sql_p);
		if(!empty($linea_pedido) ){ 
			foreach($linea_pedido as $data ){
					//asignamos
					$_POST['estado'] = 3;  // rechazados 
					$campos=array('estado');
					$bd->actualiza_(armaupdate('solicitudes',$campos," id_pedido='".$_GET["id_pedido"]."'",'POST'));/*actualizo*/
		
			} // for
		} // if


		$_POST['estado_idestado']=3;
		$campo_vouchers=array('estado_idestado');
		$bd->actualiza_(armaupdate('vouchers',$campo_vouchers," id_pedido='".$_GET["id_pedido"]."'",'POST'));/*actualizo*/
		
		$num_afect=$bd->actualiza_("UPDATE pedidos SET estado_pago=".$state.", usuario_modifico=".$usuario_modifico.", comentario='".$_GET["comentario"]."' WHERE id_pedido=".$ide."");
		echo $state;
		// echo $sql_p;	
		$bd->Commit();
		$bd->close();
		
	}else{   // si no puso comentario
		$state= 99; // 99:: sin_motivo_rechazo
		echo $state;
	}	 // end if si existe pedido 


}elseif($_GET["task"]=='finder'){
  $array= array();
	$meses=array('Jan'=>'Enero','Feb'=>'Febrero','Mar'=>'Marzo','Apr'=>'Abril','May'=>'Mayo','Jun'=>'Junio','Jul'=>'Julio','Aug'=>'Agosto','Sep'=>'Septiembre','Oct'=>'Octubre','Nov'=>'Noviembre','Dec'=>'Diciembre');
	
  $sql= "SELECT pp.*,YEAR(pp.fecha_registro) as anho, MONTH(pp.fecha_registro) as mes, e.nombre AS estado ,s.email as email,  CONCAT(s.nombre,' ',s.ap_pa,' ',s.ap_ma )as suscritos , s.telefono,  s.dni as dni, u.nomusuario as usuario  "; 
	if(!empty($_GET['tipo_pago']) && $_GET['tipo_pago']==1 ){ /* si es pago offline muestro bancos y fecha de pago */
			$sql .= " , ban.nombre as banco  ";
	}
	
	$sql.=" FROM pedidos pp 
  INNER JOIN estado e ON pp.estado_idestado=e.idestado 
  INNER JOIN suscritos s ON pp.id_suscrito=s.id_suscrito
  LEFT JOIN usuario u ON pp.idusuario= u.idusuario
	";
	
	if(!empty($_GET['tipo_pago']) && $_GET['tipo_pago']==1 ){ /* si es pago offline muestro bancos y fecha de pago */
			$sql .= " INNER JOIN bancos ban ON pp.banco_pago = ban.id_banco ";
	}
	
	$sql.=" WHERE pp.tipo_pago='".$_GET["tipo_pago"]."' "; 
	
	/* si estoy con perfil de ventas, muestro solo las ventas de mis clientes asociados  */
	if($_SESSION["visualiza"]["idtipo_usu"] == 4){  /* si estoy con usuario de ventas y marco que esta venta me pertenece */
		$sql.=" and s.idusuario='".$_SESSION["visualiza"]["idusuario"]."'  "; 
	}

  
  if (isset($_GET['criterio_mostrar'])) $porPagina=$_GET['criterio_mostrar'];
  if(isset($_GET['criterio_usu_per']) && !empty($_GET['criterio_usu_per'])){
    $stringlike=fn_filtro(substr($_GET['criterio_usu_per'], 0, 16));
    $sql.= " AND ( s.dni LIKE '%".$stringlike."%' or  s.nombre LIKE '%".$stringlike."%'  or  s.ap_pa LIKE '%".$stringlike."%'  or  s.ap_ma LIKE '%".$stringlike."%' or s.email LIKE '%".$stringlike."%' or pp.codigo LIKE '%".$stringlike."%' or pp.codreferencia LIKE '%".$stringlike."%'  or pp.id_pedido LIKE '%".$stringlike."%' or pp.codigo_ope_off LIKE '%".$stringlike."%' )"; 
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
  $paging->pagina_proceso="pedidos.php";
?>
  <table id="example1" class="table table-bordered table-striped">
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
          <th class="sort " >Cod  </th>
					<th class="sort  " >Cliente</th>
					<th class="sort cnone">E-mail</th>
          <th class="sort  cnone "  width="100">Cod transac</th>
					<?php if(!empty($_GET['tipo_pago']) && $_GET['tipo_pago']==1 ){ ?>
          <th class="sort cnone" >Fecha voucher.</th>
          <th class="sort cnone" >Banco</th>
					<?php } ?>
					
					<?php if(!empty($_GET['tipo_pago']) && $_GET['tipo_pago']==3 ){ ?>
          <th class="sort cnone" >cod. orden</th>
					<!-- 
          <th class="sort cnone" >Fecha pago.</th>
					-->
					<?php } ?>
          <th class="sort cnone"  width="95">IMG</th>
          <th class="sort cnone"  width="95">PAGÓ?</th>
					<?php if(!empty($_GET['tipo_pago']) && $_GET['tipo_pago']==3 ){ ?>
					<th class="sort cnone" >status</th>
					<?php } ?>
					
          <th class="sort ">Total</th>
          <th class="sort cnone" width="60">#cursos</th>
          <th class="sort cnone" width="100">USUARIO</th>
					<!-- 
          <th class="sort cnone" width="100">ENTREGADO</th>
					-->
          <th class="unafbe" width="90">Ver</th>
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
				<td class=" "><?php echo $detalles["dni"].' - '.$detalles["suscritos"]; ?></td>        
				<td class="cnone"><?php echo $detalles["email"]; ?></td>        
        <td class=" cnone " >
				<?php 
					if(!empty($detalles["codreferencia"])){
						echo $detalles["codreferencia"];
						
					}else{ //codigo del pago off-line -transccion
						echo 'off-'.$detalles["codigo_ope_off"];
						
					}
				?>
				</td>        
				<?php if(!empty($_GET['tipo_pago']) && $_GET['tipo_pago']==1 ){ ?>
        <td class="cnone"><?php echo $detalles["fecha_pago_off"]; ?></td>        
        <td class="cnone"><?php echo $detalles["banco"]; ?></td>        
				<?php } ?>
				
				<?php if(!empty($_GET['tipo_pago']) && $_GET['tipo_pago']==3 ){ ?>
        <td class="cnone"><?php echo $detalles["codigo_ope_off"]; ?></td>   <!-- id orden generada  -->  
				<!-- 
        <td class="cnone"><?php echo $detalles["fecha_pago_off"]; ?></td>   
				fecha de pago, ocambio de estado 
				-->
				<?php } ?>
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
			
				<td class="cnone">
					<a  style="color:#333;font-weight:800;">
						<?php if($detalles["estado_pago"]==2){ echo "<span style='color:orange;'>Por verificar</span>";
						}elseif($detalles["estado_pago"]==1){ echo "<span style='color:green;'>Aprobado</span>";  
						}elseif($detalles["estado_pago"]==3){
							
							echo "<span style='color:red;'>Rechazado </span>";
							$rechazo=executesql("select * from usuario where idusuario='".$detalles["usuario_modifico"]."' ");
							echo '<span>'.$rechazo[0]['nomusuario'].' - </br>'.$detalles["fecha_modificacion"]. ' </span>'; 
							
					 }else{ echo "#no fount."; 
						} ?>
					</a>
				</td>
				<?php if(!empty($_GET['tipo_pago']) && $_GET['tipo_pago']==3 ){ ?>
        <td class=" cnone "> <?php echo $detalles["comentario"]; ?></td>  <!-- coemntario status de pago efectivo -->
				<?php } ?>
				
				
        <td > S/<?php echo $detalles["total"]; ?></td>
        <td class="cnone"> <?php echo $detalles["articulos"]; ?></td>
        <td class="cnone"> <?php echo $detalles["usuario"]; ?></td>
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
<?php
			// $line=executesql("SELECT c.titulo, c.codigo FROM linea_pedido lp INNER JOIN cursos c ON lp.id_curso = c.id_curso WHERE lp.id_pedido = '".$detalles['id_pedido']."' ORDER BY lp.orden DESC");
			$line=executesql("SELECT c.titulo, c.codigo FROM suscritos_x_cursos lp INNER JOIN cursos c ON lp.id_curso = c.id_curso WHERE lp.id_pedido = '".$detalles['id_pedido']."' ORDER BY lp.ide DESC");
			if(!empty($line)){ foreach($line as $linea){
?>
      <tr>
      	<td></td>
      	<td><b>Cod.: </b><?php echo $linea['codigo'] ?></td>
      	<td><b> </b><?php echo $linea['titulo'] ?></td>
      	<td></td>
      	<td></td>
      	<td></td>
      	<td></td>
      	<td></td>
      	<td></td>
      	<td></td>
      	<td></td>
      </tr>
<?php } }

		endwhile; ?>
    </tbody>
  </table>
  <div class="pagination"><?php echo $paging->fetchNavegacion(); ?></div>
<script>
$(function(){
  // reordenar('pedidos.php');
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
var mypage = "pedidos.php";
</script>
<?php } ?>