<?php error_reporting(E_ALL ^ E_NOTICE);
include_once("auten.php");

if($_POST["task"]=='marcar_enviado'){
  $bd=new BD;
  // $_POST['estado']=1;

  // $campos=array('estado','empresa_envio',"comentario"); 
  $campos=array('estado',"comentario"); 

	if( !empty($_POST['fecha_envio']) ){
		$campos=array_merge($campos,array('fecha_envio'));
	}
	
	if( !empty($_POST['fecha_entrega']) ){
		$campos=array_merge($campos,array('fecha_entrega'));
	}
	
	/*
	 echo var_dump(armaupdate('solicitudes',$campos," ide='".$_POST["ide"]."'",'POST'));
	 exit(); 
	*/
  
	$bd->actualiza_(armaupdate('solicitudes',$campos," ide='".$_POST["ide"]."'",'POST'));/*actualizo*/
  $bd->close();
	
  $state=$_POST['estado'];
	echo $state;

  // gotoUrl("index.php?page=".$_POST["nompage"]."&module=".$_POST["nommodule"]."&parenttab=".$_POST["nomparenttab"]);


}elseif( $_GET["task"]=='insert'){


}elseif( $_GET["task"]=='edit'){
  if($_GET["task"]=='edit'){
     $usuario=executesql("select * from solicitudes where ide='".$_GET["ide"]."'",0);
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
              <h3 class="box-title">Certificados</h3>
            </div><!-- /.box-header -->
<?php $task_=$_GET["task"]; ?>
            <!-- form start -->
            <form  class="form-horizontal" method="POST" enctype="multipart/form-data" autocomplete="OFF"   onsubmit="return aceptar()" >
<?php 
if($task_=='edit') create_input("hidden","ide",$usuario["ide"],"",$table,"");
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
                        Datos solicitud
                        </a>
                      </h4>
                    </div>
                    <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                      <div class="panel-body">
												
												<div class="form-group">
                          <label for="inputEmail3" class="col-sm-2 control-label">Estado entrega:</label>
												 <label for="inputEmail3" class="col-sm-2 control-label text-left ">	
															<?php if($usuario['estado'] == 1){
																				echo 'Entregado';
																		}elseif($usuario['estado'] == 2){
																				echo 'Pendiente';
																		}elseif($usuario['estado'] == 3){
																				echo 'Rechazada';
																		}elseif($usuario['estado'] == 4){
																				echo 'Procesando envio';
																		}elseif($usuario['estado'] == 5){
																				echo 'Enviado';
																		}
																?>

													 </label>
                          
                        </div>
										

												<div class="form-group">
                          <label for="inputPassword3" class="col-sm-2 control-label">Fecha de solicitud: (pendiente)</label>
                          <div class="col-sm-3">
                          <?php create_input("text","fecha_pago_off",$usuario["fecha_registro"],"form-control",$table,"disabled",$agregado); ?>
                          </div>
                        </div>  
												
												<div class="form-group">
                          <label for="inputPassword3" class="col-sm-2 control-label">Fecha de Envio: (enviado)</label>
                          <div class="col-sm-3">
                          <?php create_input("text","fecha_envio_2",$usuario["fecha_envio"],"form-control",$table,"disabled",$agregado); ?>
                          </div>
                        </div>  
												
												<div class="form-group">
                          <label for="inputPassword3" class="col-sm-2 control-label">Fecha de Entrega: (entregado)</label>
                          <div class="col-sm-3">
                          <?php create_input("text","fecha_entrega_2",$usuario["fecha_entrega"],"form-control",$table,"disabled",$agregado); ?>
                          </div>
                        </div>  
												
												<div class="form-group">
                          <label for="inputPassword3" class="col-sm-2 control-label">comentario: </label>
                          <div class="col-sm-6">
                          <?php create_input("textarea","comentario",$usuario["comentario"],"form-control",$table,"disabled",$agregado); ?>
                          </div>
                        </div>  
												
												<?php 
												$sql_c="select id_certificado, titulo from certificados	WHERE id_certificado IN (".$usuario["id_certificado"].") ";
												$detallepro=executesql($sql_c); 
												$i=0; ?>                        
                        <table  class="table table-bordered table-striped">
                          <thead>
                            <tr role="row">
                              <th class="sort cnone" width="50">CERTIFICADO</th>
                              
                            </tr>
                          </thead>
                          <tbody id="sort">
            <?php foreach($detallepro as $rowdetalle){  $i++; ?>
                            <tr id="order_<?php echo $rowdetalle["id_certificado"]; ?>">
                              <td ><?php echo $rowdetalle["id_certificado"].' - '.$rowdetalle["titulo"]; ?></td>
                              
                            </tr>
            <?php } ?>
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
												
													<?php /* 
												<div class="form-group">
                          <label for="inputPassword3" class="col-sm-2 control-label">Nombre Completo </br>Data de Magisterio:</label>
                          <div class="col-sm-10">
                          <?php create_input("text","nombre_magisterio",$usuario["nombre_magisterio"],"form-control",$table,"disabled",$agregado); ?>
                          </div>
                        </div>  		
                        */ ?>						
												<div class="form-group">
                          <label for="inputPassword3" class="col-sm-2 control-label">DNI:</label>
                          <div class="col-sm-3">
                          <?php create_input("text","dni",$usuario["dni"],"form-control",$table,"disabled",$agregado); ?>
                          </div>
                        </div>  
												<div class="form-group">
                          <label for="inputPassword3" class="col-sm-2 control-label">CEL:</label>
                          <div class="col-sm-3">
                          <?php create_input("text","telefono",$usuario["telefono"],"form-control",$table,"disabled",$agregado); ?>
                          </div>
                        </div>  
												<div class="form-group">
                          <label for="inputPassword3" class="col-sm-2 control-label">EMAIL:</label>
                          <div class="col-sm-3">
                          <?php create_input("text","email",$usuario["email"],"form-control",$table,"disabled",$agregado); ?>
                          </div>
                        </div> 
												

												<div class="form-group">
													<label for="inputPassword3" class="col-sm-2 control-label">Departamento:</label>
													<div class="col-sm-4 criterio_buscar">
														<?php crearselect("iddpto", "select iddpto,titulo from dptos order by titulo asc", 'class="form-control"  onchange="javascript:display(\'solicitudes.php\',this.value,\'cargar_prov2\',\'idprvc\')"', $usuario["iddpto"], "-- Dptos --"); ?>
													</div>
												</div>
												
												<div class="form-group">
														<label class="col-sm-2  control-label">Provincia</label>
														<div class="col-sm-4 criterio_buscar">
															
																	<?php if ($task_ == 'edit') {
																			$sql = "select idprvc,titulo from prvc WHERE dptos_iddpto='" . $usuario["iddpto"] . "' "; ?>
																			<select name="idprvc" id="idprvc" class="form-control" onchange="javascript:display('solicitudes.php',this.value,'cargar_dist2','iddist')">
																					<option value="" >-- Prov. --</option>
																					<?php $listaprov = executesql($sql);
																					foreach ($listaprov as $data) { ?>
																							<option value="<?php echo $data['idprvc']; ?>"
																											<?php echo ($data['idprvc'] == $usuario["idprvc"]) ? 'selected' : ''; ?> > <?php echo $data['titulo'] ?></option>
																					<?php } ?>
																			</select>
																	<?php } else { ?>
																			<select name="idprvc" id="idprvc" class="form-control"
																							onchange="javascript:display('solicitudes.php',this.value,'cargar_dist2','iddist')">
																					<option value="" selected="selected">-- Prov. --</option>
																			</select>
																	<?php } ?>
															</div>
													</div>
													
													<div class="form-group">
														<label class=" col-sm-2  control-label">Distrito</label>
														<div class="col-sm-4 criterio_buscar">
															<?php if ($task_ == 'edit') {
																	$sql = "select iddist,titulo from dist WHERE prvc_idprvc='" . $usuario["idprvc"] . "' "; ?>
																	<select name="iddist" id="iddist" class="form-control">
																			<option value="" >-- Prov. --</option>
																			<?php
																			$listaprov = executesql($sql);
																			foreach ($listaprov as $data) { ?>
																					<option value="<?php echo $data['iddist']; ?>"
																									<?php echo ($data['iddist'] == $usuario["iddist"]) ? 'selected' : ''; ?> > <?php echo $data['titulo'] ?></option>
																			<?php } ?>
																	</select>
															<?php } else { ?>
																	<select name="iddist" id="iddist" class="form-control">
																			<option value="" selected="selected">-- Dist. --</option>
																	</select>
															<?php } ?>
															</div>
														</div>
          
												
												

                            <div class="form-group">
                              <label for="inputPassword3" class="  col-sm-2  control-label">Agencia de Envio:</label>
                              <div class="col-sm-4 criterio_buscar">
                                
                                <?php crearselect("id_agencia", "select id_agencia,nombre from agencias where estado_idestado=1 order by nombre asc", 'class="form-control" requerid  onchange="javascript:display(\'pedidos_manuales_certificados.php\',this.value,\'cargar_sucursales\',\'id_sucursal\')"', $usuario["id_agencia"], "-- Agencia de envio --"); ?>
                              </div>
                            </div>
                            
                            <div class="form-group">
                              <label for="inputPassword3" class="  col-sm-2  control-label"> Sucursal </label>
												      <div class="col-sm-6 criterio_buscar">	

                                <?php if($task_=='edit'){  $sql="select id_sucursal, concat(nombre,' - ',direccion) as nombre from agencias_sucursales WHERE id_agencia='".$usuario["id_agencia"]."' "; ?>
                                  <select name="id_sucursal" id="id_sucursal" required class="form-control" >
                                    <option value="" selected="selected">-- subcateg. --</option>
                                    <?php 
                                        $listaprov=executesql($sql);
                                        foreach($listaprov as $data){ ?>
                                      <option value="<?php echo $data['id_sucursal']; ?>" selected="<?php echo ($data['id_sucursal']==$usuario["id_sucursal"])?'selected':'';?>"> <?php echo $data['nombre']?></option>
                                        <?php } ?>
                                  </select>
                                
                                <?php }else{ ?>
                                <select name="id_sucursal" id="id_sucursal"  required class="form-control" ><option value="" selected="selected">-- sucursal. --</option></select>
                                <?php } ?>
                              </div>
                            </div>

                      
												<div class="form-group">
                          <label for="inputPassword3" class="col-sm-2 control-label">DIRECCIÓN: (antes acctualizacion)</label>
                          <div class="col-sm-3">
                          <?php create_input("text","direccion",$usuario["direccion"],"form-control",$table,"disabled",$agregado); ?>
                          </div>
                        </div>  
												<div class="form-group">
                          <label for="inputPassword3" class="col-sm-2 control-label">Referencia DE ENVIO: (antes de actualizacion )</label>
                          <div class="col-sm-3">
                          <?php create_input("text","agencia",$usuario["agencia"],"form-control",$table,"disabled",$agregado); ?>
                          </div>
                        </div>  

                        


                        <div class="form-group hide ">
                          <div class="form-group">
                            <label for="inputPassword3" class="col-sm-2 control-label">Nombre BD:</label>
                            <div class="col-sm-8">
                            <?php create_input("text","nombre",$usuario["nombre"],"form-control",$table,"disabled",$agregado); ?>
                            </div>
                          </div>  
                          <div class="form-group">
                            <label for="inputPassword3" class="col-sm-2 control-label">Ape Paterno BD:</label>
                            <div class="col-sm-8">
                            <?php create_input("text","ap_pa",$usuario["ap_pa"],"form-control",$table,"disabled",$agregado); ?>
                            </div>
                          </div>  
                          <div class="form-group">
                            <label for="inputPassword3" class="col-sm-2 control-label">Ape Materno BD:</label>
                            <div class="col-sm-8">
                            <?php create_input("text","ap_ma",$usuario["ap_ma"],"form-control",$table,"disabled",$agregado); ?>
                            </div>
                          </div>  
                        </div>  
												
                        
                        <div class=" col-sm-6 ">
                          <div class="form-group">
                            <h3>DATOS DE API ORIGEN:</h3>
                            <label for="inputPassword3" class="col-sm-2 control-label">API NOMBRE:</label>
                            <div class="col-sm-8">
                            <?php create_input("text","api_nombre",$usuario["api_nombre"],"form-control",$table,"disabled",$agregado); ?>
                            </div>
                          </div>  
                          <div class="form-group">
                            <label for="inputPassword3" class="col-sm-2 control-label">API APELLIDO PATERNO:</label>
                            <div class="col-sm-8">
                            <?php create_input("text","api_paterno",$usuario["api_paterno"],"form-control",$table,"disabled",$agregado); ?>
                            </div>
                          </div>  
                          <div class="form-group">
                            <label for="inputPassword3" class="col-sm-2 control-label">API AP. MATERNO:</label>
                            <div class="col-sm-8">
                            <?php create_input("text","api_materno",$usuario["api_materno"],"form-control",$table,"disabled",$agregado); ?>
                            </div>
                          </div>  
                        </div>  
                      
                        <div class=" col-sm-6 ">
                          <div class="form-group">
                            <h3>DATOS DE API ACTUALIZADO:</h3>
                            <label for="inputPassword3" class="col-sm-2 control-label">API NOMBRE:</label>
                            <div class="col-sm-8">
                            <?php create_input("text","api_nombre_editado",$usuario["api_nombre_editado"],"form-control",$table,"disabled",$agregado); ?>
                            </div>
                          </div>  
                          <div class="form-group">
                            <label for="inputPassword3" class="col-sm-2 control-label">API APELLIDO PATERNO:</label>
                            <div class="col-sm-8">
                            <?php create_input("text","api_paterno_editado",$usuario["api_paterno_editado"],"form-control",$table,"disabled",$agregado); ?>
                            </div>
                          </div>  
                          <div class="form-group">
                            <label for="inputPassword3" class="col-sm-2 control-label">API AP. MATERNO:</label>
                            <div class="col-sm-8 ">
                            <?php create_input("text","api_materno_editado",$usuario["api_materno_editado"],"form-control",$table,"disabled",$agregado); ?>
                            </div>
                          </div>  
                        </div>  
											
      
                      </div>
                    </div>
                  </div>
									
<!-- Data aprobacion ... -->        
			<?php if($usuario['estado'] == 1){ ?> 
                  <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingThree_4">
                      <h4 class="panel-title">
                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse_4" aria-expanded="false" aria-controls="collapse_4">
                          Datos del envio: 
                        </a>
                      </h4>
                    </div>
                    <div id="collapse_4" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree_4">
                      <div class="panel-body">
                        <table  class="table table-bordered table-striped">
                          <thead>
                            <tr role="row">
                              <th class="sort ">Fecha</th>
                              <!-- <th class="sort ">Empresa envio</th> -->
                              <th class="sort cnone">Comentario</th>
                            </tr>
                          </thead>
                          <tbody id="sort">
                            <tr >                              
															<td ><?php echo $usuario["fecha_envio"]; ?></td>
                              <!-- <td ><?php echo $usuario["empresa_envio"]; ?></td> -->
                              <td ><?php echo $usuario["comentario"]; ?></td>
                            </tr>
                          </tbody>
                        </table>                        
                      </div>
                    </div>
                  </div>
			<?php } // si esta aprorbado  ?>
<!-- *** -->

                </div>
              </div>
							


<?php /* 
              <div class="box-footer">
                <div class="form-group">
                  <div class="col-sm-10 pull-right">
                    <input  type="submit"  class="btn bg-blue btn-flat" id="btnguardar" value="Guardar">
                  </div>
                </div>
              </div>
<script>	
function aceptar(){
	var nam1=document.getElementById("nombre").value;		
	
	if(nam1 !='' ){									
		alert("Registrando ... Click en Aceptar & espere unos segundos. ");							
		document.getElementById("btnguardar").disabled=true;			
	}else{		
		alert("Recomendación: Ingrese título)");
		return false; //el formulario no se envia		
	}
	
}		
</script>			
					
*/ ?>


              <div class="box-footer">
                <div class="form-group">
                  <div class="col-sm-10 text-center">
<?php if($usuario['estado'] != 1){ ?>                       
                   <button type="button" class=" btn_verde" style="padding:6.5px 15px;background: green;border: 0;color: #fff;" data-toggle="modal" data-target="<?php echo '#marcar_envio_'.$usuario["ide"];  ?>" > 
																Aprobar
										</button>

<?php   }   ?>                              
                    <button type="button" class="btn bg-gray btn-flat" onclick="javascript:gotourl('<?php echo $link_pedidos; ?>');">Cerrar</button>
<?php if($usuario['estado'] != 3){ ?>                       
                    <a  href="javascript: fn_estado_rechazar_solicitud('<?php echo $usuario["ide"]; ?>')"  class="btn bg-green btn-flat btn_verde" style="background-color:red!important;">Rechazar</a>
<?php   }   ?>                              
										
											<div id="<?php echo 'marcar_envio_'.$usuario["ide"]; ?>" class="modal  bd-example-modal-lg  modal_images modal_images_practico " tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display:none;">
												<div class="modal-dialog  modal-dialog-centered ">
													<div class="modal-content text-center">
														<div class="modal-header" style="background:#ddd;">
															<h5 class="modal-title" id="exampleModalLongTitle"><b>Envio de certificado:</b> </h5>
															<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top:-20px;">
																<span aria-hidden="true">&times;</span>
															</button>
														</div>
														
												<div class="text-left " style="padding:15px 15px;max-width:450px;margin:0 auto;">
														<div style="padding:15px;">
															<label for="inputPassword3" class=" control-label">Estado de proceso: </label>
															<select id="estado_rpta" name="estado_rpta" class="form-control" requerid >  <!-- saco valor desde la BD -->
																		<option value="" >-- estado de la solicitud  --</option>  
																		<option value="1" <?php echo ($usuario['estado']==1)?'selected':'';?> >Entregado</option>  
																		<option value="2" <?php echo ($usuario['estado']==2)?'selected':'';?>>Pendiente </option>
																		<!--
																		<option value="3" <?php echo ($usuario['estado']==3)?'selected':'';?>>Rechazado </option>
																		-->
																		<option value="4" <?php echo ($usuario['estado']==4)?'selected':'';?>>Procesando </option>
																		<option value="5" <?php echo ($usuario['estado']==5)?'selected':'';?>>Enviado </option>
																</select>
														</div>
															<?php create_input("hidden","ide",$usuario["ide"],"form-control",$table,"requerid",$agregado); ?>
															<div style="padding:15px;">
																<label>(*) Fecha de envio: </label>
																<?php create_input("date","fecha_envio",$usuario["fecha_envio"],"form-control",$table,"requerid",$agregado); ?>
															</div>

                              <!-- 
                              <div style="padding:15px;">
																<label>(*) Empresa de envio:</label>
															<?php create_input("text","empresa_envio",$usuario["empresa_envio"],"form-control",$table,"requerid",$agregado); ?>
															</div>
                            -->


															<div style="padding:15px;">
																<label>(*) Fecha de Entrega: </label>
																<?php create_input("date","fecha_entrega",$usuario["fecha_entrega"],"form-control",$table," ",$agregado); ?>
															</div>

															
															<div style="padding:15px;">
																<label>Comentario:</label>
																<?php create_input("textarea","comentario",$usuario["comentario"],"form-control",$table,"",$agregado); ?>
															</div>
															
															<div class="text-center" style="padding:30px 0 ;">
																 <a  class="btn bg-green btn-flat btn_verde marcar_certificado_como_enviado" > Guardar</a>
															</div>
														</div>
														
														<script>
																	if( document.getElementById("estado_rpta")){		
																		var select = document.getElementById('estado_rpta');
																		select.addEventListener('change',function(){
																			
																			$('#comentario').html('');
																			var selectedOption = this.options[select.selectedIndex];
																			console.log(selectedOption.value + ': ' + selectedOption.text);
																			
																			// alert(selectedOption.value);
																			
																			if(selectedOption.value=='1'){
																				document.getElementById("comentario").value="Tu certificado a sido entregado";
																				$('.marcar_certificado_como_enviado').html("Marcar como entregado");
																				
																			}else if(selectedOption.value=='2'){
																				 document.getElementById("comentario").value="Socilitud pendiete de revisión";						 
																					$('.marcar_certificado_como_enviado').html("Guardar");
																					
																			}else if(selectedOption.value=='3'){
																				 document.getElementById("comentario").value="Socilitud fue rechazada:  ";						 
																					$('.marcar_certificado_como_enviado').html("Guardar");
																					
																			}else if(selectedOption.value=='4'){
																				 document.getElementById("comentario").value="Estamos procesando tu solicitud  ";						 
																					$('.marcar_certificado_como_enviado').html("Guardar");
																					
																			}else if(selectedOption.value=='5'){
																				 document.getElementById("comentario").value="Hemos enviado tu certificado  ";	
																					$('.marcar_certificado_como_enviado').html("Marcar como enviado");
																			
																			}else{
																				$('#comentario').html('error_123');							
																			}
													
																		});
																	} 
														</script>
														
														
													</div>
												</div>
											</div>
										
										
                  </div>
                </div>
              </div>



            </form>
          </div><!-- /.box -->
        </div><!--/.col (right) -->
  </div>
<script>
var link = "solicitude";/*la s final se agrega en js fuctions*/
var us = "solicitud";/*sirve para mensaje en ventana eliminar*/
var l = "o";
var l2 = "e";/* est+ _ x {e,a,o ,etc}sirve para mensaje en ventana eliminar*/
var pr = "El";
var ar = "la";
var id = "ide";
var mypage = "solicitudes.php";
</script>
</section><!-- /.content -->
<?php

}elseif($_GET["task"]=='uestado_rechazar_solicitud'){
  $bd = new BD;
  $bd->Begin();
  $ide = !isset($_GET['ide']) ? $_GET['estado_idestado'] : $_GET['ide'];
  $ide = is_array($ide) ? implode(',',$ide) : $ide;
  $usuario = executesql("SELECT * FROM solicitudes WHERE ide IN (".$ide.")");
  if(!empty($usuario))
  foreach($usuario as $reg => $item)
  if ($item['estado']==1 || $item['estado']==2) {
    $state = 3;
 
  }
  $num_afect=$bd->actualiza_("UPDATE solicitudes SET estado=".$state." WHERE ide=".$ide."");
  echo $state;
  $bd->Commit();
  $bd->close();



}elseif($_GET["task"]=='finder'){
  $array= array();
	$meses=array('Jan'=>'Enero','Feb'=>'Febrero','Mar'=>'Marzo','Apr'=>'Abril','May'=>'Mayo','Jun'=>'Junio','Jul'=>'Julio','Aug'=>'Agosto','Sep'=>'Septiembre','Oct'=>'Octubre','Nov'=>'Noviembre','Dec'=>'Diciembre');
	
  $sql= "SELECT pp.*,YEAR(pp.fecha_registro) as anho, MONTH(pp.fecha_registro) as mes, s.email as email,  CONCAT(s.nombre,' ',s.ap_pa,' ',s.ap_ma )as suscritos, cer.titulo as certificado, cer.id_certificado as cod_certi, c.titulo as curso, c.codigo as cod_curso  , dp.titulo as dpto , prov.titulo as provincia, dist.titulo as dist , ag.nombre as agencia_titulo, su.nombre as sucursal 
	FROM solicitudes pp 
	LEFT JOIN dptos dp ON pp.iddpto= dp.iddpto  
	LEFT JOIN prvc prov ON pp.idprvc= prov.idprvc  
	LEFT JOIN dist dist ON pp.iddist= dist.iddist  
	LEFT JOIN agencias ag   ON pp.id_agencia= ag.id_agencia   
	LEFT JOIN agencias_sucursales su ON pp.id_sucursal= su.id_sucursal 
  
  INNER JOIN certificados cer ON pp.id_certificado=cer.id_certificado  
  INNER JOIN cursos c ON pp.id_curso=c.id_curso   
  INNER JOIN suscritos s ON pp.id_suscrito=s.id_suscrito 
  WHERE pp.estado_idestado=1 
	 "; 
  
  if (isset($_GET['criterio_mostrar'])) $porPagina=$_GET['criterio_mostrar'];
  if(isset($_GET['criterio_usu_per']) && !empty($_GET['criterio_usu_per'])){
    $stringlike=fn_filtro(substr($_GET['criterio_usu_per'], 0, 16));
    $sql.= " AND ( pp.ide LIKE '".$stringlike."%' or  pp.nombre_magisterio LIKE '".$stringlike."%' or  pp.dni LIKE '".$stringlike."%' or s.dni LIKE '".$stringlike."%' or s.nombre LIKE '".$stringlike."%' or s.email LIKE '".$stringlike."%' or pp.ap_pa LIKE '".$stringlike."%' or pp.ap_ma LIKE '".$stringlike."%' or cer.titulo LIKE '".$stringlike."%' or c.titulo LIKE '".$stringlike."%'  or c.codigo LIKE '".$stringlike."%' )"; 
  
  }else if(!empty($_GET['periodo']) ){
    $sql .= $_GET['periodo']; // between

  }else{
		if( empty($_GET['fechabus_1']) && empty($_GET['fechabus_2'])   && $_SESSION["visualiza"]["idtipo_usu"] !=6 ) { // si es tipo 6 no aplica filtros e fechas 
			$sql .= " AND MONTH(DATE(pp.fecha_registro)) = MONTH('" . fecha_hora(1) . "') ";
		}
	}
	
  if( $_SESSION["visualiza"]["idtipo_usu"] ==6 ){  // a tipo ugel le mostramos solo los activos no los rechazados 
    $sql .= " AND pp.estado !=3 "; // las rechazadas no mostramkos , solo las activas 
  }

  if(!empty($_GET['estado']) ){
			$sql .= " AND pp.estado = '".$_GET['estado']."'";
	}

	if(!empty($_GET['fechabus_1']) && !empty($_GET['fechabus_1'])) {
			$sql .= " AND DATE(pp.fecha_registro)  BETWEEN  DATE('".$_GET['fechabus_1']."')  and DATE('".$_GET['fechabus_2']."')  ";		
	}


	
  if(isset($_GET['criterio_ordenar_por'])) $sql.= sprintf(" order by %s %s", fn_filtro($_GET['criterio_ordenar_por']), fn_filtro($_GET['criterio_orden']));
 $sql.= " ORDER BY pp.ide DESC";
 
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
  // $paging->porPagina(fn_filtro((int)$porPagina));
  $paging->porPagina(1000);
  $paging->ejecutar();
  $paging->pagina_proceso="solicitudes.php";
?>
  <table id="example1" class="table table-bordered table-striped">
				<!-- *EXCEL -->
		<?php  /*  Fechas para excel */ 
			$fecha_excel_inicio= !empty($_GET["fechabus_1"])?$_GET["fechabus_1"]:fecha_hora(1); 
		?>    
		<input type="hidden" name="sql_excel" id="sql_excel" value="<?php echo $sql; ?>">
    
    <?php 	if( $_SESSION["visualiza"]["idtipo_usu"] !=6 ){// usuario tipo ugel no tiene acceso a este contenido ?>
		<a href="javascript:fn_exportar('tipo_form=1&fecha_filtro_inicio=<?php echo $fecha_excel_inicio;?>&fecha_filtro_fin=<?php echo $_GET["fechabus_2"];?>','certificados');" class="btn btn-primary"  > Excel</a>
		<?php 	} ?>
		
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
          <th class="sort " >DNI</th>
          <!-- 
          <th class="sort cnone" >Nombre EXCEL Magisterio</th>
      -->
          <th class="sort cnone" >Cliente</th>
          <th class="sort cnone" >API_NOMBRE</th>
          <th class="sort cnone" >API_AP</th>
          <th class="sort cnone" >API_AM</th>
          <?php 	if( $_SESSION["visualiza"]["idtipo_usu"] !=6 ){ ?>
          <th class="sort cnone">E-mail</th>
          <?php } ?> 
          <th class="sort cnone">CERTIFICADO</th>
          <!-- <th class="sort cnone">CURSOS</th> -->
          <?php 	if( $_SESSION["visualiza"]["idtipo_usu"] !=6 ){ ?>
          <th class="sort cnone"  width="95">ESTADO</th>
          <?php } ?>
          <th class="sort cnone"  width="120">VALIDACIÓN</th>
          <th class="unafbe" width="70">PDF</th>
          <th class="unafbe" width="70">N° Reg</th>
          <?php 	if( $_SESSION["visualiza"]["idtipo_usu"] !=6 ){ ?>
          <th class="unafbe" width="70">INFO</th>
          <?php } ?>
        </tr>
<?php }//if meses 

if( $detalles["estado"] == 2){ // por revisar 
	$fondo_entregar ="background:#F0A105; color:#fff !important; ";
}elseif( $detalles["estado"] == 1){  // aprobado
	$fondo_entregar ='background:green;';
}elseif( $detalles["estado"] == 3){ // rechazado 
	$fondo_entregar ='background:rgba(255,0,0,0.6); color:#fff !important;';
}

?>        
       <tr  >
        <td><?php echo !empty($detalles['fecha_registro']) ? date('d',strtotime($detalles['fecha_registro'])) : '...'; ?></td>
        <td >
					<span style="<?php echo $fondo_entregar; ?> border-radius:50%;height:12px;width:12px;position: absolute;"></span> 
					<span style="padding-left:20px;"><?php echo $detalles["dni"]; ?></span> 
          ID: <?php echo $detalles["ide"]; ?>
				</td>       
        <!--         
        <td class="cnone"><?php echo $detalles["nombre_magisterio"]; ?></td>  
-->      
        <td class="cnone"><?php echo $detalles["suscritos"]; ?></td>        
        <td class="cnone"><?php echo !empty($detalles["api_nombre_editado"])? $detalles["api_nombre_editado"].' </br> [edit] ':$detalles["api_nombre"]; ?></td>        
        <td class="cnone"><?php echo !empty($detalles["api_paterno_editado"])? $detalles["api_paterno_editado"] .' </br> [edit] ':$detalles["api_paterno"]; ?></td>        
        <td class="cnone"><?php echo !empty($detalles["api_materno_editado"])? $detalles["api_materno_editado"].' </br> [edit] ' :$detalles["api_materno"]; ?></td>        
        
        <?php 	if( $_SESSION["visualiza"]["idtipo_usu"] !=6 ){ ?>
        <td class="cnone"><?php echo $detalles["email"]; ?></td>  
        <?php } ?>      
        <td class="cnone"><?php echo $detalles["cod_certi"].' - '.$detalles["certificado"]; ?></td>    
        
        <!--     * hay algunos errores en id_curso, que tiene el mismo valor con id_certificado en tabla solicitudes:: si se quiere mostrar esto, se debe corere un script para coregir con kla tabla certificados_x_suscritos ahi est ael id_curso el campo corretco antes del: 19/07/2023  
        <td class="cnone"><?php echo $detalles["cod_curso"].' - '.$detalles["curso"]; ?></td>  
        -->  

      <?php 	if( $_SESSION["visualiza"]["idtipo_usu"] !=6 ){ ?>
				<td class="cnone">
					<a  style="color:#333;font-weight:800;">
						<?php 
							if($detalles['estado'] == 1){
									echo ' <b style="color:green;">  Entregado </b>';
							}elseif($detalles['estado'] == 2){
									echo 'Pendiente';
							}elseif($detalles['estado'] == 3){
									echo '<b style="color:red;"> Rechazada </b>';
							}elseif($detalles['estado'] == 4){
									echo 'Procesando envio';
							}elseif($detalles['estado'] == 5){
									echo 'Enviado';
							}
						?>
					</a>
				</td>
      <?php } ?> 

				<td class="cnone">
						<?php 
              $mostrar_pdf='display:none;';

              if($detalles['estado_api'] == 1){
                  $mostrar_pdf='';
									echo '<b style="color:green;">VALIDADO </b>';
                  
                  //echo '-->'.$detalles['id_usuario_valido'];

                  if( !empty($detalles['id_usuario_valido']) ){
                      $usuario_valido=executesql("select nomusuario from usuario where idusuario='".$detalles["id_usuario_valido"]."' ");
                      echo "<p> por: ".$usuario_valido[0]["nomusuario"]." </br> ".$detalles['fecha_validacion_manual']."</p>";
                  }


              }elseif($detalles['estado_api'] == 2 && $detalles["estado"] != 3 ){
                  echo ' <p><b style="color:purple;" >POR VALIDAR </b></p> ';
                  if( $_SESSION["visualiza"]["idtipo_usu"] !=6 ){  // usuario ugel no tiene accesoa  esto 
            ?>
                
                <div class="btn-eai btr text-center" style="width:70px;margin-top:5px;position:relative;">
                  <a href="solicitudes_validar_datos_certificado_manualmente?ide=<?php echo $detalles["ide"]; ?>" style="color:#fff;background:blue;font-size:10px!important;" target="_blank" >
                     VALIDAR
                  </a>
                </div>
          <?php 	
                  } // end usuario ugel no peude validar 
                                  
               }elseif( $detalles["estado"] == 3 ){
                echo ' <b style="color:red;" > rechazado </b> </br>  ';						
							}else{
									echo ' --- ';
							}

             
						?>
					</a>
				</td>
        
        <!-- PDF CERTIFICADO -->
        <td>
          <?php 
                if($detalles['estado'] == 3){  // si esta rechazado no se muestra  
                  echo " <b style='color:red;'>rechazado </b> ";
                }else{ ?> 

            <div class="btn-eai btr text-center" style="width:70px;">
              <a href="pdf/examples/certificado/<?php echo $detalles["ide"]; ?>" style="color:#fff;background:green;<?php echo $mostrar_pdf;?>" target="_blank" ><i class="fa fa-eye"></i> PDF</a>
            </div>
          <?php } ?> 
        </td>

        <td class="cnone">
          <?php 
          
          $pdf_order= executesql("select order_pdf from suscritos_x_certificados where id_pedido='".$detalle["id_pedido"]."' "); 
          echo $pdf_order[0]["order_pdf"]; 
          
          ?>
        </td>        
        
      <?php 	if( $_SESSION["visualiza"]["idtipo_usu"] !=6 ){ ?>
        <td>
          <div class="btn-eai btr text-center" style="width:70px;">
            <a href="<?php echo $_SESSION["base_url"].'&task=edit&ide='.$detalles["ide"]; ?>" style="color:#fff;"><i class="fa fa-eye"></i> ver</a>
					<?php if($detalles["estado"]==2){ ?>
          <!--					
					<a href="<?php echo $_SESSION["base_url"].'&task=edit&ide='.$detalles["ide"]; ?>" style="color:#fff;"><i class="fa fa-eye"></i> entregado</a>
					-->
					<?php } ?>
           
          </div>
        </td>
      <?php } ?> 

      </tr>
<?php endwhile; ?>
    </tbody>
  </table>
  <div class="pagination"><?php echo $paging->fetchNavegacion(); ?></div>
<script>
$(function(){
  // reordenar('solicitudes.php');
  // checked();
  // sorter();
});
</script>

<?php }else{ ?>
        <div class="box-body">
          <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
            <form action="javascript: fn_buscar();" id="frm_buscar" name="frm_buscar">
              <div class="bg-gray-light">


              <!-- 
                <div class="col-sm-2">
                  <div class="btn-eai" >
                    <a href="<?php echo $link."&task=new"; ?>" style="color:#fff;"><i class="fa fa-file" style="padding-right:8px;"></i> Agregar</a>		
                  </div>
                </div>
-->

                <div class="col-sm-4 criterio_buscar">
                  <?php create_input('text','criterio_usu_per','',"form-control pull-right",$table,'placeholder="Buscar por codigo certificado, por nombre o codigo de curso.."'); ?>
                </div>
								
                
                <?php 	if( $_SESSION["visualiza"]["idtipo_usu"] !=6 ){ ?>
                <div class="col-sm-2 criterio_buscar">
										<select name="periodo" id="periodo" class="form-control" >
												<option value="" >-- periodo --</option>
              <?php  $periodos=executesql(" select * from certificados_periodos where estado_idestado=1 order by idelos desc "); 
                      foreach( $periodos as $row ){
                          $value_= " and pp.fecha_registro BETWEEN '". $row["fecha_inicio"]."' AND  '". $row["fecha_fin"]."' ";
              ?>
                        <option value="<?php echo $value_; ?>" > <?php echo $row["nombre"]; ?> </option>

                <?php }    ?>
										</select>
								</div>
                <div class="col-sm-2 criterio_buscar">
										<select name="estado" id="estado" class="form-control" >
												<option value="" >ver todo</option>
												<option value="1" >Entregados</option>
												<option value="5" >Enviados</option>
												<option value="4" >Procesando</option>
												<option value="2" >Pendientes</option>
												<option value="3" >Rechazados</option>
										</select>
								</div>
                
                <div class="col-sm-6 criterio_mostrar"style="position: relative;margin-top: 30px;" >
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
                
                <?php } ?> 
               
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
var link = "solicitude";/*la s final se agrega en js fuctions*/
var us = "solicitud";/*sirve para mensaje en ventana eliminar*/
var l = "o";
var l2 = "e";/* est+ _ x {e,a,o ,etc}sirve para mensaje en ventana eliminar*/
var pr = "El";
var ar = "al";
var id = "ide";
var mypage = "solicitudes.php";
</script>
<?php } ?>