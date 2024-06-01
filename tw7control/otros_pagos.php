<?php 
error_reporting(E_ALL ^ E_NOTICE);
include ("auten.php");

if($_GET["task"]=='insert' || $_GET["task"]=='update'){
  $bd=new BD;

	if(empty($_POST['monto'])) $_POST['monto']='0.00'; 
	$_POST['idusuario'] =$_SESSION["visualiza"]["idusuario"];
	$_POST['usuario_modifico'] =$_SESSION["visualiza"]["idusuario"];

	// $campos=array('id_curso','titulo',array('titulo_rewrite',$urlrewrite),'monto','costo_promo','estado_idestado'); /*inserto campos principales*/
	
	$_POST['fecha_modificacion'] = fecha_hora(2);
	$_POST["nombre"]=$_POST["nombre_post"];
	$campos=array('usuario_modifico','fecha_modificacion','concepto','tipo_servicio','cuenta','n_operacion','nombre','detalle','monto','fecha_pago','estado_idestado'); /*inserto campos principales*/

  if($_GET["task"]=='insert'){
		if(isset($_FILES['imagen']) && !empty($_FILES['imagen']['name'])){
      $_POST['imagen'] = carga_imagen('files/images/otros_pagos/','imagen','','600','600');
      $campos = array_merge($campos,array('imagen'));
    }
		
		$_POST['orden'] = _orden_noticia("","otros_pagos","");
    $_POST['fecha_registro'] = fecha_hora(2);
		$campos=array_merge($campos,array('orden','fecha_registro','id_suscrito','idusuario'));  /* el que registro y el cliente ya no se peuen editar */
		
		// echo var_dump(arma_insert('otros_pagos',$campos,'POST'));
		// exit();
		
    $bd->inserta_(arma_insert('otros_pagos',$campos,'POST'));/*inserto hora -orden y guardo imag*/
 
 }else{
		 if(isset($_FILES['imagen']) && !empty($_FILES['imagen']['name'])){
      $path = 'files/images/otros_pagos/'.$_POST['imagen_ant'];
      if( file_exists($path) && !empty($_POST['imagen_ant']) ) unlink($path);    
      $_POST['imagen'] = carga_imagen('files/images/otros_pagos/','imagen','','600','600');
      $campos = array_merge($campos,array('imagen'));
    }
		
		// echo var_dump(armaupdate('otros_pagos',$campos," id_otro_pago='".$_POST["id_otro_pago"]."'",'POST'));
		// exit();
		
    $bd->actualiza_(armaupdate('otros_pagos',$campos," id_otro_pago='".$_POST["id_otro_pago"]."'",'POST'));/*actualizo*/
		
  }
  $bd->close();
  gotoUrl("index.php?page=".$_POST["nompage"]."&id_curso=".$_POST["id_curso"]."&module=".$_POST["nommodule"]."&parenttab=".$_POST["nomparenttab"]);
	
}elseif($_GET["task"]=='new' || $_GET["task"]=='edit'){
  if($_GET["task"]=='edit'){
     $data_producto=executesql("select * from otros_pagos where id_otro_pago='".$_GET["id_otro_pago"]."'",0);
  }
?>

<script type="text/javascript" src="js/buscar-autocompletado.js?ud=<?php echo $unix_date; ?>"></script>
<section class="content">
  <div class="row">
    <div class="col-md-12">
      <!-- Horizontal Form -->
      <div class="box box-info">
        <div class="box-header with-border">
				 <?php   $sql_x=" select * from cursos where id_curso='".$_GET["id_curso"]."' "; 
						$datoscurso=executesql($sql_x,0); 
					?>				
          <h4 class="box-title"><?php echo ($_GET["task"]=="edit") ? 'Editar' : 'Agregando'; ?> Otros Pagos </h4>
        </div><!-- /.box-header -->
<?php $task_=$_GET["task"]; ?>
        <!-- form start -->
        <form id="registro" action="otros_pagos.php?task=<?php echo ($task_=='edit') ?  "update" : "insert"; ?>" class="form-horizontal" method="POST" enctype="multipart/form-data" onsubmit="return aceptar()">
<?php 
if($task_=='edit') create_input("hidden","id_otro_pago",$data_producto["id_otro_pago"],"",$table,"");
create_input("hidden","urlfailed",basename($_SERVER['REQUEST_URI']),"",$table,"");  
create_input("hidden","urlgo",$link_sesion,"",$table,"");
create_input("hidden","nompage",$_GET["page"],"",$table,""); 
create_input("hidden","id_curso",$_GET["id_curso"],"",$table,""); 
create_input("hidden","nommodule",$_GET["module"],"",$table,"");
create_input("hidden","nomparenttab",$_GET["parenttab"],"",$table,"");
?>
          <div class="box-body">
            <div class="form-group hide">
              <label for="inputEmail3" class="col-sm-2 control-label">Estado</label>
              <div class="col-sm-4">
                <?php crearselect("estado_idestado","select * from estado where idestado in('1','2') order by 2 desc",'class="form-control"',$data_producto["estado"],""); ?>
              </div>
            </div>
<?php 
if($task_=='edit'){ 
?>
						<div class="form-group">
							<label for="inputPassword3" class="col-sm-2 control-label">Cliente:</label>
						<div class="col-sm-8 ">
							<?php create_input("text","nombre",$data_producto["nombre"],"form-control",$table," "," "); ?>
						</div>								
					</div>								

<?php 						
}else{ 
?>
            <!-- -->
            <!-- ** DATOS CLIENTES -->
        <div class="datos_del_cliente "  style="padding:10px;margin-bottom:30px;border-radius:8px;border:1px solid #333;">		
						<div class="form-group">
							<div class="col-sm-12"><h3 style="font-size:18px;line-height:20px;"> <b>Datos del Cliente:<b></h3></div>
							<label for="inputPassword3" class=" col-sm-2  control-label">DNI</label>
							<div class="col-sm-5 ">
								<?php 
								create_input("text","dni",$data_producto["dni"],"form-control",$table,"required autocomplete='off' onkeyup='autocompletar()'  placeholder=' Ingresa DNI o correo del cliente ' ",''); 	
								?>
								<ul id="listadobusqueda_cliente" class="no-bullet"></ul>
							</div>
							
							<label for="inputPassword3" class=" col-sm-2   control-label">Estado</label>
							<div class="col-sm-3">
								<?php 
								create_input("text","estado",$data_producto["estado"],"form-control",$table,"disabled",$agregado); 
								create_input("hidden","id_suscrito",$data_producto["id_suscrito"],"form-control",$table,"",$agregado); 
								?>
							</div>					
						</div>
						
						<div class="form-group">					
									<label for="inputPassword3" class=" col-sm-2  control-label">CLIENTE: </label>
									<div class="col-sm-5">
											<?php create_input("text","nombre",$data_producto["nombre"],"form-control",$table,"disabled",$agregado); ?>
											<?php create_input("hidden","nombre_post",$data_producto["nombre"],"form-control",$table,"",$agregado); ?>
									</div>
									
									<label for="inputPassword3" class=" col-sm-2  control-label">Especialidad:</label>
									<div class="col-sm-3">
										<?php create_input("text","id_especialidad",$data_producto["id_especialidad"],"form-control",$table,"disabled",$agregado); ?>
									</div>
									
						</div>	                

						<div class="form-group">
							<label for="inputPassword3" class=" col-sm-2  control-label">Email</label>
							<div class="col-sm-5 ">
								<?php create_input("text","email",$data_producto["email"],"form-control",$table,"disabled",$agregado); ?>
							</div>
							<label for="inputPassword3" class=" col-sm-2  control-label">Telèfono</label>
							<div class="col-sm-3">
								<?php create_input("text","telefono",$data_producto["telefono"],"form-control",$table,"disabled","onkeypress='javascript:return soloNumeros(evt,0);'"); ?>
							</div>								
						</div>	                
						
				</div>	 <!-- contenedor data cliente -->		
			
						
            <!-- ** END DATOS CLIENTES -->
<?php 
		} 

 ?>
						
						
						<div class="form-group">
									<label for="inputPassword3" class="col-md-2 col-sm-2 control-label">Tipo servicio:</label>
									<div class="col-sm-3">
										<select id="tipo_servicio" name="tipo_servicio" class="form-control" requerid >  <!-- saco valor desde la BD -->
											<option value=""  <?php echo ($data_producto['tipo_servicio'] == '') ? 'selected' : '' ;?>> - seleecione - </option>
											<option value="Capacitación Auge Docentes"  <?php echo ($data_producto['tipo_servicio'] == 'Capacitación Auge Docentes') ? 'selected' : '' ;?>>Capacitación Auge Docentes</option>
											<option value="Capacitación Auge Academía"  <?php echo ($data_producto['tipo_servicio'] == 'Capacitación Auge Academía') ? 'selected' : '' ;?>>Capacitación Auge Academía</option>
											<option value="Pago de personal" <?php echo ($data_producto['tipo_servicio'] == 'Pago de personal') ? 'selected' : '' ;?>>Pago de personal</option>  
											<option value="Pago de otros servicios" <?php echo ($data_producto['tipo_servicio'] == 'Pago de otros servicios') ? 'selected' : '' ;?>>Pago de otros servicios</option>  
										</select>
									</div>
               
									
									
						</div>
								
						
						<div class="form-group">
              <label for="inputPassword3" class="col-sm-2 control-label">Curso / servicio:</label>
              <div class="col-sm-8">
                <?php create_input("textarea","concepto",$data_producto["concepto"],"form-control",$table," placeholder='Describa el nombre de producto o servicio prestado ' "); ?>
              </div>
            </div>
						<div class="form-group">
              <label for="inputPassword3" class="col-sm-2 control-label">N#. Cuenta Bancario:</label>
              <div class="col-sm-8">
                <?php create_input("text","cuenta",$data_producto["cuenta"],"form-control",$table,"",$agregado); ?>
              </div>
            </div>
						
						<div class="form-group">
              <label for="inputPassword3" class="col-sm-2 control-label">Num. Operación:</label>
              <div class="col-sm-8">
                <?php create_input("text","n_operacion",$data_producto["n_operacion"],"form-control",$table," placeholder='Número de operación ' ",$agregado); ?>
              </div>
            </div>
						
							<div class="form-group">
								<label for="inputPassword3" class="col-md-2 col-sm-2 control-label">Monto S/. </label>
								<div class="col-md-2 col-sm-2">
									<?php create_input("text","monto",$data_producto["monto"],"form-control",$table,"onkeypress='javascript:return soloNumeros_monto(event,2);'"); /* el 2 permite poner  decmales */?> 
								</div>
								
							</div>
							
							<div class="form-group">
								<label for="inputPassword3" class="col-md-2 col-sm-2 control-label">Fecha de Pago:</label>
								<div class="col-md-3 col-sm-3">
									<?php create_input("date","fecha_pago",$data_producto["fecha_pago"],"form-control",$table,"onkeypress='javascript:return soloNumeros_monto(event,2);'"); ?>
								</div>
							</div>
						
						
						<div class="form-group">
								<label for="inputPassword3" class="col-sm-2 control-label">Observaciones <span style="color:red;"></span> </label>
								<div class="col-sm-6">
									<?php create_input("textarea","detalle",$data_producto["detalle"],"",$table,$agregado);  ?>
								 
								</div>
						</div>
				 <div class="form-group">
													<label for="inputPassword3" class="col-sm-2 control-label">Imágen comprobante</label>
													<div class="col-sm-6">
															<input type="file" name="imagen" id="imagen" class="form-control">
														<?php 
														create_input("hidden","imagen_ant",$data_producto["imagen"],"",$table,$agregado); 
															if($data_producto["imagen"]!=""){ 
														?>
														<!-- 
															<img src="<?php echo "files/images/otros_pagos/".$data_producto["imagen"]; ?>" width="200" class="mgt15">
															-->
															<button type="button" class="abrir_modal_images" data-toggle="modal" data-target="<?php echo '#image_1';  ?>" > 
																<img style="height:50px;width:50px;"  class="img-responsive" src="<?php echo "files/images/otros_pagos/".$data_producto["imagen"]; ?>">
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
								<img src="<?php echo 'files/images/otros_pagos/'.$data_producto["imagen"]; ?>"  class="img-responsive" style="max-width:600px;margin: auto;">								
								<div class="text-center" style="padding:30px 0 10px;">
									<a href="<?php echo 'files/images/otros_pagos/'.$data_producto["imagen"]; ?>"  target="_blank" class="btn btn-primary" style="max-width:600px;">	Ver imagen completa [Click aquí]</a>							
								</div>
							</div>
						</div>
					</div>
						
						
							
								
          </div>
              <div class="box-footer">
                <div class="form-group">
                  <div class="col-sm-10 pull-right">
                    <input  type="submit"  class="btn bg-blue btn-flat" id="btnguardar" value="Guardar">
                    <button type="button" class="btn bg-red btn-flat" onclick="javascript:gotourl('<?php echo $link_sesion; ?>');">Cancelar</button>
                  </div>
                </div>
              </div>
							
<script>	
function aceptar(){
	var nam1=document.getElementById("concepto").value;		
	
	if(nam1 !='' ){									
		alert("Registrando ... Click en Aceptar & espere unos segundos. ");							
		document.getElementById("btnguardar").disabled=true;			
	}else{		
		alert("Recomendación: Ingrese concepto)");
		return false; //el formulario no se envia		
	}
	
}				
</script>	
        </form>
      </div><!-- /.box -->
    </div><!--/.col (right) -->
  </div>
</section><!-- /.content -->
<script type="text/javascript">
var customValidate = {
      rules:{
        titulo:{required:true}
      }
    };
</script>
<?php
}elseif($_GET["task"]=='drop' || $_GET["task"]=='dropselect'){
  $bd = new BD;
  $bd->Begin();
  $ide = !isset($_GET['id']) ? implode(',', $_GET['chkDel']) : $_GET['id'];
  $id_curso2 = executesql("SELECT video FROM detalle_otros_pagos WHERE id_otro_pago IN(".$ide.")");
  if(!empty($id_curso2)){
    foreach($id_curso2 as $row2){
      $pfile2 = 'files/video/'.$row2['id_otro_pago'].'/'.$row2['video'];
      if(file_exists($pfile2) && !empty($row2['video'])){ unlink_sesion($pfile2); }
    }
  }
  $bd->actualiza_("DELETE FROM detalle_otros_pagos WHERE id_otro_pago IN(".$ide.")");
  $bd->actualiza_("DELETE FROM otros_pagos WHERE id_otro_pago IN(".$ide.")");
  $bd->Commit();
  $bd->close();

}elseif($_GET["task"]=='uestado'){
  $bd = new BD;
  $bd->Begin();
  $ide = !isset($_GET['id']) ? $_GET['estado_idestado'] : $_GET['id'];
  $ide = is_array($ide) ? implode(',',$ide) : $ide;
  $otros_pagos = executesql("SELECT * FROM otros_pagos WHERE id_otro_pago IN (".$ide.")");
  if(!empty($otros_pagos))
    foreach($otros_pagos as $reg => $item)
      if ($item['estado_idestado']==1) {
        $state = 2;
      }elseif ($item['estado_idestado']==2) {
        $state = 1;
      }
  $bd->actualiza_("UPDATE otros_pagos SET estado_idestado=".$state." WHERE id_otro_pago=".$ide."");
  echo $state;
  $bd->Commit();
  $bd->close();
	



	
}elseif($_GET["task"]=='finder'){
	
		$array= array();
	$meses=array('Jan'=>'Enero','Feb'=>'Febrero','Mar'=>'Marzo','Apr'=>'Abril','May'=>'Mayo','Jun'=>'Junio','Jul'=>'Julio','Aug'=>'Agosto','Sep'=>'Septiembre','Oct'=>'Octubre','Nov'=>'Noviembre','Dec'=>'Diciembre');
	
		$sql = "SELECT cv.*,e.nombre AS estado, CONCAT(s.nombre,' ',s.ap_pa,' ',s.ap_ma,' / ',s.email,' / ',s.telefono ) AS cliente, s.dni, s.email ,  YEAR(cv.fecha_registro) as anho, MONTH(cv.fecha_registro) as mes, u.nomusuario as usuario  
		FROM otros_pagos cv 
		INNER JOIN suscritos s ON cv.id_suscrito=s.id_suscrito 
		INNER JOIN usuario u ON cv.idusuario=u.idusuario  
		INNER JOIN estado e ON cv.estado_idestado=e.idestado 
		WHERE cv.estado_idestado != 100 
	"; 
  if(!empty($_GET['criterio_mostrar'])) $porPagina=$_GET['criterio_mostrar'];
  if(!empty($_GET['criterio_usu_per'])){
    $stringlike=fn_filtro(substr($_GET['criterio_usu_per'], 0, 16));
    $sql.= " AND (cv.concepto LIKE '%".$stringlike."%' or s.dni LIKE '%".$stringlike."%' or s.nombre LIKE '%".$stringlike."%' or s.ap_pa LIKE '%".$stringlike."%' or s.ap_ma LIKE '%".$stringlike."%'  or s.email LIKE '%".$stringlike."%' or s.telefono LIKE '%".$stringlike."%')";
  }
  
				if(!empty($_GET['fechabus_1']) && !empty($_GET['fechabus_2'])) {
					$sql .= " AND DATE(cv.fecha_pago)  BETWEEN  DATE('".$_GET['fechabus_1']."')  and DATE('".$_GET['fechabus_2']."')  ";		
			}
			
  if(!empty($_GET['criterio_ordenar_por'])) $sql.= sprintf(" order by %s %s", fn_filtro($_GET['criterio_ordenar_por']), fn_filtro($_GET['criterio_orden']));
	$sql.= " ORDER BY cv.orden ASC ";


  // echo $sql;
	
  $paging = new PHPPaging;
  $paging->agregarConsulta($sql); 
  $paging->div('div_listar');
  $paging->modo('desarrollo'); 
  $numregistro=1; 
  if($numregistro) $paging->porPagina(fn_filtro((int)$numregistro));
  $paging->verPost(true);
  $mantenerVar=array("id_curso","criterio_mostrar","task","criterio_usu_per","criterio_ordenar_por","criterio_orden");
  $paging->mantenerVar($mantenerVar);
  $paging->porPagina(fn_filtro((int)$porPagina));
  $paging->ejecutar();
  $paging->pagina_proceso="otros_pagos.php";
?>

            <table id="example1" class="table table-bordered table-striped">
		<!-- *EXCEL -->
		<?php  /*  Fechas para excel */ 
			$fecha_excel_inicio= !empty($_GET["fechabus_1"])?$_GET["fechabus_1"]:fecha_hora(1); 
		?>
		<input type="hidden" name="sql_excel" id="sql_excel" value="<?php echo $sql; ?>">
		<a href="javascript:fn_exportar('tipo_form=1&fecha_filtro_inicio=<?php echo $fecha_excel_inicio;?>&fecha_filtro_fin=<?php echo $_GET["fechabus_2"];?>','otros_pagos');" class="btn btn-primary  excel "  > Excel</a>
		
	
	
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
                  <th class="sort">DÍA </th>   									
									<th class="sort cnone ">USUARIO</th>
									<th class="sort cnone">TIPO SERVICIO</th>
									<th class="sort cnone ">CURSO-SERVICIO</th>
									<th class="sort cnone ">#CUENTA - BANCO</th>
									<th class="sort cnone ">#OPERACION</th>
									<th class="sort">monto</th>
									<th class="sort cnone ">FECHA PAGO</th>
									<th class="sort cnone">OBSERVACION</th>
									<th class="sort cnone ">DNI Cliente</th>
									<th class="sort cnone ">EMAIL </th>
									<th class="sort">Cliente</th>
									<th class="unafbe " style="width:90px;">Opciones</th>
							</tr>
						<?php }//if meses ?>
							<tr>
									<td><?php echo !empty($detalles['fecha_registro']) ? date('d',strtotime($detalles['fecha_registro'])) : '...'; ?></td>							
									<td class="cnone "><?php echo $detalles["usuario"]; ?></td>
									<td class="cnone "><?php echo $detalles["tipo_servicio"]; ?></td>
									<td class="cnone "><?php echo $detalles["concepto"]; ?></td>
									<td class="cnone " ><?php echo $detalles["cuenta"]; ?></td>
									<td class="cnone "><?php echo $detalles["n_operacion"]; ?></td>
									<td ><?php echo $detalles["monto"]; ?></td>
									<td class="cnone "><?php echo $detalles["fecha_pago"]; ?></td>
									<td class="cnone "><?php echo $detalles["detalle"]; ?></td>
									<td class="cnone "><?php echo $detalles["dni"]; ?></td>
									<td class="cnone "><?php echo $detalles["email"]; ?></td>
									<td><?php echo $detalles["cliente"]; ?></td>
									<td>
										<div class="btn-eai btns btr  text-center ">
											<a href="<?php echo $_SESSION["base_url"].'&task=edit&id_otro_pago='.$detalles["id_otro_pago"]; ?>" title="Editar"  style="color:#fff;"><i class="fa fa-edit"></i> edit</a>
									<?php  if($_SESSION["visualiza"]["idtipo_usu"] ==1){ ?>
                      <a href="javascript: fn_eliminar('<?php echo $detalles["ide"]; ?>')"style="background:red;"><i class="fa fa-trash-o"></i></a>
									<?php } ?>
											
										</div>
									</td>
								</tr>
<?php endwhile; ?>
  </tbody>
</table>
<div class="pagination"><?php echo $paging->fetchNavegacion(); ?></div>
<script>
// $(function(){
  // checked();
  // sorter();
  // reordenar('otros_pagos.php');
// });
// var mypage = "otros_pagos.php";
</script>
<?php }else{ ?>
<div class="box-body">
  <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
    <form action="javascript: fn_buscar();" id="frm_buscar" name="frm_buscar">
      <input type="hidden" name="module" value="<?php echo $_GET['module']; ?>">
      <input type="hidden" name="parenttab" value="<?php echo $_GET['parenttab']; ?>">
      <div class="bg-gray-light">      
        
				
				<div class="col-sm-1 ">
          <div class="btn-eai">
            <a href="<?php echo $link_sesion."&task=new"; ?>" title="Agregar" style="color:#fff;"> Agregar</a> 
          </div>
        </div>
        <div class="col-sm-2 ">          
          <?php create_input('text','criterio_usu_per','',"form-control pull-right",$table,'placeholder="Buscar .."'); ?>
        </div>
				<div class="col-sm-7 criterio_mostrar">
							*Filtar por fecha de pago 
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
								
					<div class="col-sm-1 ">          
						<?php select_sql("nregistros"); ?>
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
var us = "pago";
var link = "otros_pago";
var ar = "la";
var l = "a";
var l2 = "a";
var pr = "La";
var id = "id_otro_pago";
var mypage = "otros_pagos.php";
</script>
<?php } ?>