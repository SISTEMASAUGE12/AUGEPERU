<?php error_reporting(E_ALL ^ E_NOTICE); include ("auten.php");

if($_GET["task"]=='neworden'){
  $bd=new BD;
  $orden_actual=$_GET["orden"];
  $orden_nuevo=$_GET["nuevoorden"];
  $tipo=$_GET["tipo"];  
  $id_del_registro_actual=$_GET["id_contacto"];
  $criterio_Orden =" ";
  nuevoorden($orden_actual, $orden_nuevo, $tipo, $id_del_registro_actual, "contactos", "id_contacto", $criterio_Orden);    
  $bd->close();

}elseif($_GET["task"]=='insert' || $_GET["task"]=='update'){ 
  $bd=new BD;
  $where = ($_GET["task"]=='update') ? "and id_contacto!='".$_POST["id_contacto"]."'" : '';
  // $urlrewrite=armarurlrewrite($_POST["nombre"]);
  // $urlrewrite=armarurlrewrite($urlrewrite,1,"contactos","id_contacto","nombre_rewrite",$where);

  $campos=array('nombre', 'mensaje','fono','correo','asunto',"estado_idestado"); 
  
  if($_GET["task"]=='insert'){
    if(isset($_FILES['imagen']) && !empty($_FILES['imagen']['name'])){
      $_POST['imagen'] = carga_imagen('files/images/contactos/','imagen','','','');
      $campos = array_merge($campos,array('imagen'));
    }
    // if(isset($_FILES['archivo']) && !empty($_FILES['archivo']['name'])){
      // $_POST['archivo'] = upload_files('files/files/','archivo','',0);
      // $campos = array_merge($campos,array('archivo'));
    // }
    // $_POST['orden'] = _orden_noticia("","contactos","");
    $_POST['orden'] = '';
    $_POST['fecha_registro'] = fecha_hora(2);
    $bd->inserta_(arma_insert('contactos',array_merge($campos,array('orden','fecha_registro')),'POST'));
		
  }else{
    if(isset($_FILES['imagen']) && !empty($_FILES['imagen']['name'])){
      $path = 'files/images/contactos/'.$_POST['imagen_ant'];
      if( file_exists($path) && !empty($_POST['imagen_ant']) ) unlink($path);    
      $_POST['imagen'] = carga_imagen('files/images/contactos/','imagen','','','');
      $campos = array_merge($campos,array('imagen'));
    }
    // if(isset($_FILES['archivo']) && !empty($_FILES['archivo']['name'])){
      // $path = 'files/files/'.$_POST['archivo_ant'];
      // if( file_exists($path) && !empty($_POST['archivo_ant']) ) unlink($path);    
      // $_POST['archivo'] = carga_imagen('files/files/','archivo','');
      // $campos = array_merge($campos,array('archivo'));
    // }
    $bd->actualiza_(armaupdate('contactos',$campos," id_contacto='".$_POST["id_contacto"]."'",'POST'));/*actualizo*/
  }
  $bd->close();
  gotoUrl("index.php?page=".$_POST["nompage"]."&module=".$_POST["nommodule"]."&parenttab=".$_POST["nomparenttab"]);

}elseif($_GET["task"]=='new' || $_GET["task"]=='edit'){
  if($_GET["task"]=='edit'){
     $data_producto=executesql("select * from contactos where id_contacto='".$_GET["id_contacto"]."'",0);
  }
?>
<script src="ckeditor/sample.js"></script>
<script src="ckeditor/ckeditor.js"></script>
<script src="ckfinder/ckfinder.js"></script>

<section class="content">
  <div class="row">
    <div class="col-md-12">          
          <div class="box box-info">
            <div class="box-header with-border"><h3 class="box-title">contactos </h3></div>
<?php $task_=$_GET["task"]; ?>            
            <form id="registro" action="contactos.php?task=<?php echo ($task_=='edit') ?  "update" : "insert"; ?>" class="form-horizontal" method="POST" enctype="multipart/form-data">
<?php 
if($task_=='edit') create_input("hidden","id_contacto",$data_producto["id_contacto"],"",$table,"");
create_input("hidden","urlfailed",basename($_SERVER['REQUEST_URI']),"",$table,"");  
create_input("hidden","urlgo",$link,"",$table,"");
create_input("hidden","nompage",$_GET["page"],"",$table,""); 
create_input("hidden","nommodule",$_GET["module"],"",$table,"");
create_input("hidden","nomparenttab",$_GET["parenttab"],"",$table,"");
?>
              <div class="box-body">								
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Estado</label>
                  <div class="col-sm-6">
                    <?php crearselect("estado_idestado","select * from estado where idestado in('1','2') order by 2 desc",'class="form-control"',$data_producto["estado_idestado"],""); ?>
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Nombre</label>
                  <div class="col-sm-6">
                    <?php create_input("text","nombre",$data_producto["nombre"],"form-control",$table,"",$agregado); ?>
                  </div>
                </div>
								<div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Email</label>
                  <div class="col-sm-6">
                    <?php create_input("text","correo",$data_producto["correo"],"form-control",$table,"",$agregado); ?>
                  </div>
                </div>
								<div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Celular</label>
                  <div class="col-sm-6">
                    <?php create_input("text","fono",$data_producto["fono"],"form-control",$table,"",$agregado); ?>
                  </div>
                </div>
								
								<div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Asunto:</label>
                  <div class="col-sm-6">
                    <?php create_input("text","asunto",$data_producto["asunto"],"form-control",$table,"",$agregado); ?>
                  </div>
                </div>
								

									<div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">mensaje</label>
                  <div class="col-sm-10">
                    <?php create_input("textarea","mensaje",$data_producto["mensaje"],'  ',$table,'style="height:650px!important;"');  ?>
                    
                  </div>
                </div>
								
								 <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">CV :</label>
                  <div class="col-sm-6">
                    <input type="file" name="imagen" id="imagen" class="form-control">
                    <?php create_input("hidden","imagen_ant",$data_producto["imagen"],"",$table,$agregado); 
                      if($data_producto["imagen"]!=""){ 
                    ?>
                      <a href="<?php echo "files/images/contactos/".$data_producto["imagen"]; ?>" target=" _blank " >
												<img src="dist/images/pdf.jpg" width="200" class="mgt15">
											</a>
												
                    <?php } ?>
                      <small style="color:red">Recomendado: 208 x 208</small>
                  </div>
                </div>
								
              </div>
              <div class="box-footer">
                <div class="form-group">
                  <div class="col-sm-10 pull-right">
                    <button type="submit" class="btn bg-blue btn-flat">Guardar</button>
                    <button type="button" class="btn bg-red btn-flat" onclick="javascript:gotourl('<?php echo $link; ?>');">Cancelar</button>
                  </div>
                </div>
              </div>
            </form>
          </div><!-- /.box -->
        </div><!--/.col (right) -->
  </div>
</section><!-- /.content -->
<script type="text/javascript">
var customValidate = {
      rules:{
        archivo:{ required:false,accept:'pdf,docs,doc,jpg,png' }
      }
    };
</script>
<?php
}elseif($_GET["task"]=='drop' || $_GET["task"]=='dropselect'){  
  $bd = new BD;
  $bd->Begin();
  $ide = !isset($_GET['id_contacto']) ? implode(',', $_GET['chkDel']) : $_GET['id_contacto'];
  $contactos = executesql("SELECT * FROM contactos WHERE id_contacto IN(".$ide.")");
  if(!empty($contactos)){
    foreach($contactos as $row){
      $pfile = 'files/images/contactos/'.$row['imagen']; if(file_exists($pfile) && !empty($row['imagen'])){ unlink($pfile); }
      // $pfile = 'files/files/'.$row['archivo']; if(file_exists($pfile) && !empty($row['archivo'])){ unlink($pfile); }
    }
  }

  $bd->actualiza_("DELETE FROM contactos WHERE id_contacto IN(".$ide.")");
  $bd->Commit();
  $bd->close();

}elseif($_GET["task"]=='ordenar'){

  $bd = new BD;
  $_GET['order'] = array_reverse($_GET['order']);
  foreach ($_GET['order'] as $order => $item) {
    $orden = $orden + 1;
    $bd->actualiza_("UPDATE contactos SET orden= ".$orden." WHERE id_contacto = ".$item."");
  }
  $bd->Commit();
  $bd->close();

}elseif($_GET["task"]=='uestado'){

  $bd = new BD;
  $bd->Begin();

  $ide = !isset($_GET['id_contacto']) ? $_GET['estado_idestado'] : $_GET['id_contacto'];
  $ide = is_array($ide) ? implode(',',$ide) : $ide;
  $contactos = executesql("SELECT * FROM contactos WHERE id_contacto IN (".$ide.")");

  if(!empty($contactos))
    foreach($contactos as $reg => $item)
      if ($item['estado_idestado']==1) {
        $state = 2;
      }elseif ($item['estado_idestado']==2) {
        $state = 1;
      }
  $bd->actualiza_("UPDATE contactos SET estado_idestado=".$state." WHERE id_contacto=".$ide."");
  echo $state;
  $bd->Commit();
  $bd->close();

}elseif($_GET["task"]=='finder'){
	
	$array= array();
	$meses=array('Jan'=>'Enero','Feb'=>'Febrero','Mar'=>'Marzo','Apr'=>'Abril','May'=>'Mayo','Jun'=>'Junio','Jul'=>'Julio','Aug'=>'Agosto','Sep'=>'Septiembre','Oct'=>'Octubre','Nov'=>'Noviembre','Dec'=>'Diciembre');
	
  $sql = "SELECT p.*, YEAR(p.fecha_registro) as anho, MONTH(p.fecha_registro) as mes,  e.nombre as estado
	FROM contactos p 
	inner join estado e ON p.estado_idestado=e.idestado 
	where p.estado_idestado=e.idestado   	"; 
  if(isset($_GET['criterio_mostrar'])) $porPagina=$_GET['criterio_mostrar'];
  if(isset($_GET['criterio_usu_per']) && !empty($_GET['criterio_usu_per'])){
    $stringlike=fn_filtro(substr($_GET['criterio_usu_per'], 0, 16));
    $sql.= " and  (p.nombre LIKE '%".$stringlike."%' or p.correo LIKE '%".$stringlike."%'  or p.fono LIKE '%".$stringlike."%' ) ";
  }else{
		// if( empty($_GET['fechabus_1']) && empty($_GET['fechabus_2']) ) {
			// $sql .= " AND DATE(p.fecha_registro) = '" . fecha_hora(1) . "'";
			
		// }
	}
	
	if(!empty($_GET['fechabus_1']) && !empty($_GET['fechabus_2'])) {
			$sql .= " AND DATE(p.fecha_registro)  BETWEEN  DATE('".$_GET['fechabus_1']."')  and DATE('".$_GET['fechabus_2']."')  ";		
	}

	
	
  if(isset($_GET['criterio_ordenar_por'])) $sql.= sprintf(" order by %s %s", fn_filtro($_GET['criterio_ordenar_por']), fn_filtro($_GET['criterio_orden']));

  $sql.= " ORDER BY id_contacto DESC";

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
  $paging->pagina_proceso="contactos.php";
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
                  <th class="sort">ORDEN</th>
                  <th class="sort" width="70">FECHA</th>
                  <th class="sort">NOMBRE</th>
                  <th class="sort cnone">CEL</th>
                  <th class="sort cnone">EMAIL</th>
                  <th class="sort cnone">ASUNTO</th>
                  <th class="sort cnone ">ARCHIVO / CV</th>
                  <th class="sort cnone">ESTADO</th>
                  <th class="unafbe" width="130">OPCIONES</th>
                </tr>
	<?php }//if meses ?> 			
								
								<tr >
									<td><?php echo $detalles['id_contacto']; ?></td>
                  <td><?php echo $detalles["fecha_registro"]; ?></td>                                               
                  <td class="sort  " ><?php echo $detalles["nombre"]; ?></td>                                               
                  <td class="sort cnone" ><?php echo $detalles["fono"]; ?></td>                                               
                  <td class="sort cnone" ><?php echo $detalles["correo"]; ?></td>                                               
                  <td class="sort cnone" ><?php echo $detalles["asunto"]; ?></td>                                               
                  
                  
									<td class="cnone">
                    <?php if(!empty($detalles["imagen"])){ ?>
                    <a href="<?php echo "files/images/contactos/".$detalles["imagen"]; ?>"  target="_blank " >
											<img src="dist/images/pdf.jpg" class="img-responsive">
										</a>
                    <?php }else{ echo "Not Image."; } ?>
                  </td>

                  <td class="cnone"><a href="javascript: fn_estado('<?php echo $detalles["id_contacto"]; ?>')"><?php echo $detalles["estado"]; ?></a></td>
                  <td class="text-center">
                    <div class="btn-eai btns btr">
                      <a href="<?php echo $_SESSION["base_url"].'&task=edit&id_contacto='.$detalles["id_contacto"]; ?>" style="color:#fff;"><i class="fa fa-edit" style="padding-right:3px;"></i> editar</a>
                      <a href="javascript: fn_eliminar('<?php echo $detalles["id_contacto"]; ?>')"><i class="fa fa-trash-o"></i></a>
                    </div>
									
                  </td>
                </tr>
<?php endwhile; ?>
              </tbody>
            </table>
            <div class="pagination"><?php echo $paging->fetchNavegacion(); ?></div>
<script>
$(function(){
  // checked();
   sorter();
  // reordenar('contactos.php');
});
var mypage = "contactos.php";
</script>

<?php }else{ ?>
        <div class="box-body">
          <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
            <form action="javascript: fn_buscar();" id="frm_buscar" name="frm_buscar">
              <div class="bg-gray-light">
            
								<div class="col-sm-3 criterio_buscar">
                  <?php create_input('text','criterio_usu_per','',"form-control pull-right",$table,'placeholder="Buscar .."'); ?>
                </div>
								<!--
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
               --> 
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
var us = "contacto";
var link = "contacto";
var ar = "la";
var l = "o";
var l2 = "o";
var pr = "La";
var id = "id_contacto";
var mypage = "contactos.php";
</script>

<?php } ?>