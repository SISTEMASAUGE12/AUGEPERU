<?php error_reporting(E_ALL ^ E_NOTICE);
include ("auten.php");

if( $_GET["task"]=='edit' || $_GET["task"]=='new'){
  if($_GET["task"]=='edit'){
		 
		if( $_SESSION["visualiza"]["idtipo_usu"] ==4 ){  /* filtro solo ventas del vendedor : */
			$usuario=executesql("select * from pedidos_compartidos where id_pedido='".$_GET["id_pedido"]."' and idusuario='".$_SESSION["visualiza"]["idusuario"]."' ",0);

			 
		}else{
		 $usuario=executesql("select * from pedidos_compartidos where id_pedido='".$_GET["id_pedido"]."'",0);
			 
		}	
		 
		 
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
              <h3 class="box-title">COMPRAS COMPARTIDAS </h3>
            </div><!-- /.box-header -->
						
<?php 							 
		if( $_SESSION["visualiza"]["idtipo_usu"] ==4  && isset($_GET["id_pedido"]) ){  /* filtro solo ventas del vendedor : */
			if( empty($usuario) ){ /* si esta venta no pertence al usuario vendedor: conusltas */
					echo "<h3 style='color:red;'>No tienes acceso a esta venta, no te pertence. </h3>";
			}
			 
		}	
?>		 
						
							
<?php $task_=$_GET["task"]; ?>
            <!-- form start -->
            <form action="pedidos_compartidos.php?task=<?php echo ($task_=='edit') ?  "update" : "insert"; ?>"   class="form-horizontal" method="POST" enctype="multipart/form-data" autocomplete="OFF" onsubmit="return aceptar()" >
<?php 
if($task_=='edit') create_input("hidden","id_pedido",$usuario["id_pedido"],"",$table,"");
create_input("hidden","urlfailed",basename($_SERVER['REQUEST_URI']),"",$table,"");  
create_input("hidden","urlgo",$link2,"",$table,"");
create_input("hidden","tipo_pago",4,"",$table,""); 
create_input("hidden","nompage",$_GET["page"],"",$table,""); 
create_input("hidden","nommodule",$_GET["module"],"",$table,"");
create_input("hidden","nomparenttab",$_GET["parenttab"],"",$table,"");
?>
				 <div class="box-body">
<!-- Data Pedido principal... -->
							<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
									
									<!-- Data suscritos ... -->                  
                  <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingThree">
                      <h4 class="panel-title">
                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="true" aria-controls="collapseThree">
                          Datos Cliente
                        </a>
                      </h4>
                    </div>
                    <div id="collapseThree" class="panel-collapse collapse in " role="tabpanel" aria-labelledby="headingThree">
                      <div class="panel-body">
											
											
											<div class="form-group">
												<div class="col-sm-12"><h3>Datos del cliente:</h3></div>
												<div class="col-sm-4">
												<?php 
														$disabled='';
												if( $_GET["task"]=='edit' ){ 
														$cliente=executesql("select s.*, esp.titulo as especialidad from suscritos s INNER JOIN especialidades esp ON s.id_especialidad=esp.id_especialidad where id_suscrito=".$usuario["id_suscrito"]." ",0);
														
														$disabled='disabled';
												} 
												?>
												
													<label for="inputPassword3" class=" control-label">DNI</label>
													<?php 
													create_input("text","dni",$cliente["dni"],"form-control",$table,"required ".$disabled." placeholder='Ingresa DNI o correo cliente' autocomplete='off' onkeyup='autocompletar()' ",''); 	
													?>
													<ul id="listadobusqueda_cliente" class="no-bullet"></ul>
												</div>
												
											<?php	if($_SESSION["visualiza"]["idtipo_usu"] != 4 ){ ?> 
														<div class="col-sm-6">
															<label for="inputEmail3" class="col-sm- control-label">USUARIO VENDEDOR ASIGNADO</label>
															<?php crearselect("idusuario","select idusuario,nomusuario   from usuario where estado_idestado=1 and idtipo_usu=4 order by nomusuario asc",'class="form-control" ',$usuario["idusuario"],"-- seleccione vendedor --"); ?>
														</div>
											<?php } ?> 
												
											</div>
											<div class="form-group">					
												<div class="col-sm-5">
														<label for="inputPassword3" class=" control-label">Nombre: </label>
														<?php create_input("text","nombre",$cliente["nombre"].' '.$cliente["ap_pa"].' '.$cliente["ap_ma"],"form-control",$table,"disabled",$agregado); ?>
												</div>
												<div class="col-sm-3">
													<label for="inputPassword3" class=" control-label">Estado</label>
													<?php 
													create_input("text","estado",$cliente["estado"],"form-control",$table,"disabled",$agregado); 
													create_input("hidden","id_suscrito",$cliente["id_suscrito"],"form-control",$table,"",$agregado); 
													?>
												</div>					
											</div>	                

											<div class="form-group">
												<div class="col-sm-5">
													<label for="inputPassword3" class=" control-label">Especialidad:</label>
													<?php create_input("text","id_especialidad",$cliente["especialidad"],"form-control",$table,"disabled",$agregado); ?>
												</div>
												<div class="col-sm-5">
													<label for="inputPassword3" class=" control-label">Email</label>
													<?php create_input("text","email",$cliente["email"],"form-control",$table,"disabled",$agregado); ?>
												</div>
												<div class="col-sm-2">
													<label for="inputPassword3" class=" control-label">Telèfono</label>
													<?php create_input("text","telefono",$cliente["telefono"],"form-control",$table,"disabled","onkeypress='javascript:return soloNumeros(evt,0);'"); ?>
												</div>								
											</div>			
																		
															
                      </div>
                    </div>
                  </div>
									
								
								
								
                  <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingOne">
                      <h4 class="panel-title">
                        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        Datos Compra Manual: codigo:  <b><?php echo $usuario['id_pedido']; ?></b>
                        </a>
                      </h4>
                    </div>
                    <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                      <div class="panel-body">
												
											<div class="col-sm-6">											
												<div class="form-group">
                          <label for="inputEmail3" class="col-sm-4 control-label">Estado Pagó:</label>
													<div class="col-sm-8">
														<select id="estado_pago" name="estado_pago" class="form-control   "   >  <!-- saco valor desde la BD -->
															<option value="1" <?php echo ($usuario['estado_pago'] == 1) ? 'selected' : '' ;?>>APROBADO</option>
																									
															<option value="2" <?php echo ($usuario['estado_pago'] == 2) ? 'selected' : '' ;?>>Por aprobar</option>
															<option value="3" <?php echo ($usuario['estado_pago'] == 3) ? 'selected' : '' ;?>>Rechazado</option>
														</select>
													</div>
                        </div>
											</div>
											
											<div class="col-sm-6">											
													<div class="form-group">
														<label for="inputEmail3" class="col-sm-4 control-label">Tipo de compra: </label>
														<div class="col-sm-8">
															<label class="control-label" style="font-weight:400;">
															<?php echo 'COMPRA MANUAL';	?>
															</label>
														</div>																										                         
													</div>
											</div>
											
											<div class="col-sm-12">
                        <div class="form-group">
                          <label for="inputPassword3" class="col-sm-2 control-label">total Total:</label>
                          <div class="col-sm-4 ">
                            <?php create_input("text","total",$usuario["total"],"form-control",$table,' required ',$agregado); ?>
                          </div>
                        </div>
											</div>
											
											<div class="col-sm-12">
                        <div class="form-group">
                          <label for="inputPassword3" class="col-sm-2 control-label">Total de cursos:</label>
                          <div class="col-sm-4 ">
                            <?php create_input("text","articulos",$usuario["articulos"],"form-control",$table,' required ',$agregado); ?>
                          </div>
                        </div>
											</div>
										
									
										<div class="col-sm-12 ">											
												<div class="form-group">
                          <label for="inputPassword3" class="col-sm-2 control-label">Fecha del pago:</label>
                          <div class="col-sm-4">
                          <?php create_input("date","fecha_pago_off",$usuario["fecha_pago_off"],"form-control",$table," required ",$agregado); ?>
                          </div>
												</div>
										</div>
										<div class="col-sm-12 ">											
											<div class="form-group">
												<label for="inputPassword3" class="col-sm-2 control-label">Banco deposito:</label>
												<label class="col-sm-4 ">
													<?php crearselect("banco_pago","select id_banco, nombre from bancos where estado_idestado=1 order by nombre asc ",'class="form-control" required ',$usuario["banco_pago"],""); ?>              
												</label>
											</div>  
										</div>  
												
										<div class="col-sm-12 ">											
												<div class="form-group">
                          <label for="inputEmail3" class="col-sm-2 control-label">Código referencia:</label>
													<div class="col-sm-4 ">
                          <?php create_input("text","codigo_ope_off",$usuario["codigo_ope_off"],"form-control",$table," required ",$agregado); ?>
														
													</div>																										                         
                        </div>
										</div>

										<div class="col-sm-12 ">											
												<div class="form-group">
                          <label for="inputEmail3" class="col-sm-2 control-label">Observación:</label>
													<div class="col-sm-4 ">
                          <?php create_input("textarea","observacion",$usuario["observacion"],"form-control",$table,"  ",$agregado); ?>
														
													</div>																										                         
                        </div>
										</div>
												
										                        
                       <div class="form-group">
													<label for="inputPassword3" class="col-sm-2 control-label">Imágen comprobante</label>
													<div class="col-sm-6">
														<input type="file" name="imagen" id="imagen" required class="form-control">
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
	
			
												
                      </div>
                    </div>
                  </div>
<!-- Data detalle pedido... -->                  
                  <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingTwo">
                      <h4 class="panel-title">
                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                          Detalle Compra
                        </a>
                      </h4>
                    </div>
                    <div id="collapseTwo" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingTwo">
                      <div class="panel-body">
															
													<div class="form-group">
														<label for="inputEmail3" class="col-sm-4 control-label" style="float:none;text-align:left;">Selecciona los Cursos comprados:</label>
														<label for="inputEmail3" class="col-sm-12 control-label" style="float:none;text-align:left;"></br> <small>Mantener presionada la tecla "ctrl" para seleccionar varias cursos, esto dandoles click en el nombre del curso</small> </br></br></label>
														
														<div class="col-sm-10">
															<select name="subcategorias[]" multiple="multiple" class="form-control" required size="30">
												<?php

												$sql= "SELECT c.id_curso,CONCAT(c.codigo,' - ',c.titulo) as curso, cat.id_cat,cat.titulo as categ, c.modalidad 
												FROM cursos c 
												 LEFT JOIN categoria_subcate_cursos csub ON csub.id_curso= c.id_curso  
												 LEFT JOIN categorias cat ON cat.id_cat= csub.id_cat   
												 WHERE c.id_tipo_curso=1 
												 ORDER BY c.id_curso desc ";


													$exsql1 = executesql($sql);
													$grp1   = $grp2 = array();
													
													foreach($exsql1 as $row) $grp1[$row['categ']][$row['id_cat'].'_'.$row['id_curso']] = $row['curso']; $modalidad=$row['modalidad'];
													
													$exsql2 = executesql("SELECT * FROM linea_pedido WHERE id_pedido='".$usuario["id_pedido"]."'");
													foreach($exsql2 as $row) $grp2[] = $row['id_curso'];
													foreach($grp1 as $label => $opt)
													{
												?>
																				<optgroup label="<?php echo $label; ?>">
												<?php
														foreach($grp1[$label] as $id => $name)
														{
															if(!empty($name))
															{
																$selected = in_array(end(explode('_',$id)),$grp2) ? ' selected="selected"' : '';
												?>
																			<option value="<?php echo $id; ?>"  style="<?php echo ($modalidad==2)?'background:green;color:#fff;padding:5px 3px;':'';?>" <?php echo $selected; ?>> 
																					<?php echo $name; ?>
																			</option>
												<?php }
														}
												?>
																				</optgroup>
												<?php 
													}
												?>
														</select>
													</div>
												</div>
					
											
											
<?php 
if($_GET["task"]=='edit' ){ 
$detallepro=executesql("select li.* , tp.titulo as tipo, p.imagen as imagen ,p.titulo as titulo, p.codigo as codigo from linea_pedido li 
															INNER JOIN cursos p ON li.id_curso=p.id_curso  
															INNER JOIN tipo_cursos tp ON p.id_tipo=tp.id_tipo  
															WHERE li.id_pedido='".$_GET["id_pedido"]."'");
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
            <?php foreach($detallepro as $rowdetalle){ ?>
                            <tr id="order_<?php echo $rowdetalle["id_linea"]; ?>">
                              <td ><?php echo ($rowdetalle["talla"]=='9999')?'Certificado':$rowdetalle["tipo"]; ?></td>
                              <td ><?php echo $rowdetalle["codigo"]; ?></td>
                              <td ><?php echo $rowdetalle["titulo"]; ?></td>
                              <td  ><?php echo $rowdetalle["cantidad"]; ?></td>
                              <td class="cnone">S/ <?php echo $rowdetalle["precio"]; ?></td>
                              <td class="cnone"> S/<?php echo $rowdetalle["subtotal"]; ?></td>
                            </tr>
            <?php } ?>
                          </tbody>
                        </table>
<?php } ?>
                       
                      </div>
                    </div>
                  </div>
                


                </div>

              </div>
              <div class="box-footer">
                <div class="form-group">
                  <div class="col-sm-10 text-center">
							
											<button type="button" class="btn bg- btn-flat" onclick="javascript:gotourl('<?php echo $link2; ?>');">CERRAR</button>
								

                  </div>
                </div>
              </div>

<script>
function aceptar(){
	var nam1=document.getElementById("total").value;	
	var nam2=document.getElementById("id_suscrito").value;	
	var nam3=document.getElementById("dni").value;	
	var fecha_pago_off=document.getElementById("fecha_pago_off").value;	
	var articulos=document.getElementById("articulos").value;	
	var banco_pago=document.getElementById("banco_pago").value;	
	var codigo_ope_off=document.getElementById("codigo_ope_off").value;	
	
	if(nam1 !='' && nam2 !='' && nam2 >0 && nam3 !='' && articulos !='' && fecha_pago_off !='' && banco_pago !=''  && codigo_ope_off !=''  && cursos !='' ){									
		alert("Asignando  .. Aceptar y espere unos segundos ..");							
		document.getElementById("btnguardar").disabled=true;	
		
	}else{		
		alert("Recomendación: Completa todos los datos, para finalizar! )");
		return false; //el formulario no se envia		
	}
	
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
var mypage = "pedidos_compartidos.php";
</script>
<script type="text/javascript" src="js/buscar-autocompletado.js?ud=<?php echo $unix_date; ?>"></>

</section>
<!-- /.content -->
<?php
}elseif($_GET["task"]=='drop' || $_GET["task"]=='dropselect'){
  
  // $bd = new BD;
  // $bd->Begin();
  // $ide = !isset($_GET['id_pedido']) ? implode(',', $_GET['chkDel']) : $_GET['id_pedido'];
  // $bd->actualiza_("DELETE FROM  linea_pedido WHERE id_pedido IN(".$ide.")");
  // $bd->actualiza_("DELETE FROM pedidos_compartidos WHERE id_pedido IN(".$ide.")");
  // $bd->Commit();
  // $bd->close();
	
}elseif($_GET["task"]=='uestado'){
  $bd = new BD;
  $bd->Begin();
  $ide = !isset($_GET['id_pedido']) ? $_GET['estado_idestado'] : $_GET['id_pedido'];
  $ide = is_array($ide) ? implode(',',$ide) : $ide;
  $usuario = executesql("SELECT * FROM pedidos_compartidos WHERE id_pedido IN (".$ide.")");
  if(!empty($usuario))
  foreach($usuario as $reg => $item)
  if ($item['estado_idestado']==1) {
    $state = 2;
  }elseif ($item['estado_idestado']==2) {
    $state = 1;
  }
  $num_afect=$bd->actualiza_("UPDATE pedidos_compartidos SET estado_idestado=".$state." WHERE id_pedido=".$ide."");
  echo $state;
  $bd->Commit();
  $bd->close();



}elseif($_GET["task"]=='finder'){
  $array= array();
	$meses=array('Jan'=>'Enero','Feb'=>'Febrero','Mar'=>'Marzo','Apr'=>'Abril','May'=>'Mayo','Jun'=>'Junio','Jul'=>'Julio','Aug'=>'Agosto','Sep'=>'Septiembre','Oct'=>'Octubre','Nov'=>'Noviembre','Dec'=>'Diciembre');
	
  $sql= "SELECT pp.*,YEAR(pp.fecha_registro) as anho, MONTH(pp.fecha_registro) as mes, e.nombre AS estado ,s.email as email,  CONCAT(s.nombre,' ',s.ap_pa,' ',s.ap_ma )as suscritos, u.nomusuario as usuariox, s.dni, s.telefono  
	FROM pedidos_compartidos pp 
  INNER JOIN estado e ON pp.estado_idestado=e.idestado 
  INNER JOIN suscritos s ON pp.id_suscrito=s.id_suscrito 
  LEFT JOIN usuario u ON pp.idusuario=u.idusuario  
	WHERE 1  "; 
  
  if (isset($_GET['criterio_mostrar'])) $porPagina=$_GET['criterio_mostrar'];
  if(isset($_GET['criterio_usu_per']) && !empty($_GET['criterio_usu_per'])){
    $stringlike=fn_filtro(substr($_GET['criterio_usu_per'], 0, 16));
    $sql.= " AND ( s.nombre LIKE '%".$stringlike."%' or s.email LIKE '%".$stringlike."%'  or s.dni LIKE '%".$stringlike."%'  or s.telefono LIKE '%".$stringlike."%'   or pp.id_pedido LIKE '%".$stringlike."%' or pp.codigo LIKE '%".$stringlike."%' or pp.codreferencia LIKE '%".$stringlike."%' or pp.codigo_ope_off LIKE '%".$stringlike."%' )"; 
  }else{
		if( empty($_GET['fechabus_1']) && empty($_GET['fechabus_2']) ) {
			$sql .= " AND DATE(pp.fecha_registro) = '" . fecha_hora(1) . "'";
		}
		
	}
	
	if( !empty($_GET["idusuario"]) ){  /* filtro solo ventas del vendedor : */
			$sql .= " AND pp.idusuario = '".$_GET["idusuario"]."'";
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
 $sql.= " ORDER BY pp.id_pedido DESC";
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
  $paging->pagina_proceso="pedidos_compartidos.php";
?>
  <table id="example1" class="table table-bordered table-striped">
	<!-- *EXCEL -->
		<?php  /*  Fechas para excel */ 
			$fecha_excel_inicio= !empty($_GET["fechabus_1"])?$_GET["fechabus_1"]:fecha_hora(1); 
		?>
		<input type="hidden" name="sql_excel" id="sql_excel" value="<?php echo $sql; ?>">
		<a href="javascript:fn_exportar('tipo_form=1&fecha_filtro_inicio=<?php echo $fecha_excel_inicio;?>&fecha_filtro_fin=<?php echo $_GET["fechabus_2"];?>','ventas_compartidas');" class="btn btn-primary excel "  > Excel</a>
		

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
          <th class="sort " >Cod venta</th>
          <th class="sort cnone" >Cliente</th>
          <th class="sort cnone" >TEL</th>
          <th class="sort cnone">E-mail</th>
          <th class="sort ">ASESORA</th>
          <th class="sort ">TIPO</th>
          <th class="sort ">COMISION</th>
          <th class="sort ">COMPARTIDA CON</th>
          <th class="sort cnone" width="100">USUARIO</th>
					<!-- 
          <th class="unafbe" width="70">Ver</th>
					-->
        </tr>
<?php }//if meses 

?>

       <tr >
        <td><?php echo !empty($detalles['fecha_registro']) ? date('d',strtotime($detalles['fecha_registro'])) : '...'; ?></td>
        <td >	
					<span style="<?php echo $fondo_entregar; ?> border-radius:50%;height:12px;width:12px;position: absolute;"></span> 
							<span style="padding-left:20px;"><b><?php echo $detalles["id_pedido"]; ?></b></span> 
				</td>  
				<td class="cnone"><?php echo $detalles["dni"]; ?> - <?php echo $detalles["suscritos"]; ?></td>        
        <td class="cnone"><?php echo $detalles["telefono"]; ?></td>         
        <td class="cnone"><?php echo $detalles["email"]; ?></td>        
			     
        <td ><?php 
					if( $detalles["tipo_asesora"] ==1 ){
						echo "OICINA";
						
					}else{ //codigo del pago off-line -transccion
						echo 'EXTERNA';						
					}				
				?></td>        
        <td ><?php 
					if( $detalles["tipo_compartido"] ==1 ){
						echo "DUEÑO CLIENTE";
						
					}else{ //codigo del pago off-line -transccion
						echo 'AYUDO EN VENTA';						
					}				
				?></td>        			
				
        <td > S/<?php echo $detalles["comision"]; ?></td>
        <td class="cnone"> <?php echo $detalles["compartido_con"]; ?></td>
        <td class="cnone"> <?php echo $detalles["usuariox"]; ?>
						</br>
						<span style="border-top:1px solid #000;display:block;" ></span>
						<small><?php echo ($detalles["tipo_venta"] == 1 )?'PROPIA': $detalles["compartido_con"]; ?></small>
				</td>
        <!-- 
				<td class="cnone"><a href="javascript: fn_estado_pedido('<?php echo $detalles["id_pedido"]; ?>')"  style="color:#fff;font-weight:800;">
                <?php if($detalles["estado_entrega"]==2){ echo "Por entregar"; }elseif($detalles["estado_entrega"]==3){ echo "En camino"; }else{ echo "Entregado";} ?></a>
				</td>
        <td>
				<div class="btn-eai btr text-center" style="width:70px;">
				<a href="<?php echo $_SESSION["base_url"].'&task=edit&id_pedido='.$detalles["id_pedido"]; ?>" style="color:#fff;"><i class="fa fa-eye"></i> ver</a>
				
				</div>
        </td>
				-->
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
  // reordenar('pedidos_compartidos.php');
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
                <div class="col-sm-2 criterio_buscar">
                  <?php create_input('text','criterio_usu_per','',"form-control pull-right",$table,'placeholder="Buscar .."'); ?>
                </div>
								-->
								<div class="col-sm-2 criterio_buscar" style="padding-bottom:8px;">
									<?php crearselect("idusuario", "select idusuario, nomusuario from usuario where estado_idestado=1 order by nomusuario asc", 'class="form-control"  style="border:1px solid #CA3A2B;" ', '', " -- vendedor -- "); ?>
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
var link = "pedidos_compartidos_compartido";/*la s final se agrega en js fuctions*/
var us = "compra manual";/*sirve para mensaje en ventana eliminar*/
var l = "o";
var l2 = "e";/* est+ _ x {e,a,o ,etc}sirve para mensaje en ventana eliminar*/
var pr = "El";
var ar = "al";
var id = "id_pedido";
var mypage = "pedidos_compartidos.php";
</script>
<?php } ?>