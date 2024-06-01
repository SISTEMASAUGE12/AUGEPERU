<?php error_reporting(E_ALL ^ E_NOTICE);
include ("auten.php");

if($_GET["task"]=='neworden'){
  $bd=new BD;
  $orden_actual=$_GET["orden"];
  $orden_nuevo=$_GET["nuevoorden"];
  $tipo=$_GET["tipo"];  
  $id_del_registro_actual=$_GET["ide"];
  $criterio_Orden =" ";
  nuevoorden($orden_actual, $orden_nuevo, $tipo, $id_del_registro_actual, "face_testimonios", "ide", $criterio_Orden);    
  $bd->close();

}elseif($_GET["task"]=='insert' || $_GET["task"]=='update'){
  $bd=new BD;
  $campos=array('titulo',"estado_idestado"); 
  
  if($_GET["task"]=='insert'){
    if(isset($_FILES['imagen']) && !empty($_FILES['imagen']['name'])){
      $_POST['imagen'] = carga_imagen('files/images/face_testimonios/','imagen','','505','497');
      $campos = array_merge($campos,array('imagen'));
    }
    if(isset($_FILES['imagen2']) && !empty($_FILES['imagen2']['name'])){
      $_POST['imagen2'] = carga_imagen('files/images/face_testimonios/','imagen','','505','497');
      $campos = array_merge($campos,array('imagen2'));
    }
    // if(isset($_FILES['archivo']) && !empty($_FILES['archivo']['name'])){
      // $_POST['archivo'] = upload_files('files/files/','archivo','',0);
      // $campos = array_merge($campos,array('archivo'));
    // }
    $_POST['orden'] = _orden_noticia("","face_testimonios","");
    $bd->inserta_(arma_insert('face_testimonios',array_merge($campos,array('orden')),'POST'));
  }else{
    if(isset($_FILES['imagen']) && !empty($_FILES['imagen']['name'])){
      $path = 'files/images/face_testimonios/'.$_POST['imagen_ant'];
      if( file_exists($path) && !empty($_POST['imagen_ant']) ) unlink($path);    
      $_POST['imagen'] = carga_imagen('files/images/face_testimonios/','imagen','','505','497');
      $campos = array_merge($campos,array('imagen'));
    }
    if(isset($_FILES['imagen2']) && !empty($_FILES['imagen2']['name'])){
      $path = 'files/images/face_testimonios/'.$_POST['imagen_ant2'];
      if( file_exists($path) && !empty($_POST['imagen_ant2']) ) unlink($path);    
      $_POST['imagen2'] = carga_imagen('files/images/face_testimonios/','imagen','','505','497');
      $campos = array_merge($campos,array('imagen2'));
    }
    // if(isset($_FILES['archivo']) && !empty($_FILES['archivo']['name'])){
      // $path = 'files/files/'.$_POST['archivo_ant'];
      // if( file_exists($path) && !empty($_POST['archivo_ant']) ) unlink($path);    
      // $_POST['archivo'] = carga_imagen('files/files/','archivo','');
      // $campos = array_merge($campos,array('archivo'));
    // }
		
		// echo var_dump(armaupdate('face_testimonios',$campos," ide='".$_POST["ide"]."'",'POST'));
		// exit();
		
    $bd->actualiza_(armaupdate('face_testimonios',$campos," ide='".$_POST["ide"]."'",'POST'));/*actualizo*/
		
		
  }
  $bd->close();
  gotoUrl("index.php?page=".$_POST["nompage"]."&module=".$_POST["nommodule"]."&parenttab=".$_POST["nomparenttab"]);

}elseif($_GET["task"]=='new' || $_GET["task"]=='edit'){
  if($_GET["task"]=='edit'){
     $data_producto=executesql("select * from face_testimonios where ide='".$_GET["ide"]."'",0);
  }
?>
<script src="ckeditor/ckeditor.js"></script>
<script src="ckeditor/sample.js"></script>
<script src="ckfinder/ckfinder.js"></script>
<section class="content">
  <div class="row">
    <div class="col-md-12">
          <!-- Horizontal Form -->
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title"> Testimonios de Facebook </h3>
            </div><!-- /.box-header -->
<?php $task_=$_GET["task"]; ?>
            <!-- form start -->
            <form id="registro" action="face_testimonios.php?task=<?php echo ($task_=='edit') ?  "update" : "insert"; ?>" class="form-horizontal" method="POST" enctype="multipart/form-data" onsubmit="return aceptar()">
<?php 
if($task_=='edit') create_input("hidden","ide",$data_producto["ide"],"",$table,"");
create_input("hidden","titulo","Titulo","",$table,"");
create_input("hidden","urlfailed",basename($_SERVER['REQUEST_URI']),"",$table,"");  
create_input("hidden","urlgo",$link2,"",$table,"");
create_input("hidden","nompage",$_GET["page"],"",$table,""); 
create_input("hidden","nommodule",$_GET["module"],"",$table,"");
create_input("hidden","nomparenttab",$_GET["parenttab"],"",$table,"");
?>
              <div class="box-body">
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Estado</label>
                  <div class="col-sm-3">
                    <?php crearselect("estado_idestado","select * from estado where idestado in('1','2') order by 2 desc",'class="form-control"',$data_producto["estado_idestado"],""); ?>
                  </div>
									<!--<div class="form-group">
									<label for="inputPassword3" class="col-md-2 col-sm-2 control-label">Destacado:</label>
									<div class="col-sm-3">
										<select id="tipo" name="tipo" class="form-control" requerid > 
											<option value="2"  <?php echo ($data_producto['tipo'] == 2) ? 'selected' : '' ;?>>NO</option>
											<option value="1" <?php echo ($data_producto['tipo'] == 1) ? 'selected' : '' ;?>>SI</option>  
										</select>
									</div>-->
                </div>

                <!--<div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Nombre persona:</label>
                  <div class="col-sm-6">
                    <?php create_input("text","titulo",$data_producto["titulo"],"form-control",$table,"",$agregado); ?>
                  </div>
                </div>
								<div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Cargo</label>
                  <div class="col-sm-6">
                    <?php create_input("text","cargo",$data_producto["cargo"],"form-control",$table,"",$agregado); ?>
                  </div>
                </div>
							
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Link video</label>
                  <div class="col-sm-6">
                    <?php create_input("text","link",$data_producto["link"],"form-control",$table,"",$agregado); ?>
										<iframe frameborder="0" width="100%" height="200" class="lvideo"></iframe>

                  </div>
                </div>
                
								<div class="form-group">
							<label for="inputPassword3" class="col-sm-2 control-label">Comentario:</label>
							<div class="col-sm-8">
								<?php create_input("textarea","descripcion",$data_producto["descripcion"],"",$table,$agregado);  ?>
								<script>
								var editor11 = CKEDITOR.replace('descripcion','');
								CKFinder.setupCKEditor( editor11, 'ckfinder/' );
								</script> 
							</div>
						</div>-->
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Imágen :</label>
                  <div class="col-sm-6">
                    <input type="file" name="imagen" id="imagen" class="form-control">
                    <?php create_input("hidden","imagen_ant",$data_producto["imagen"],"",$table,$agregado); 
                      if($data_producto["imagen"]!=""){ 
                    ?>
                      <img src="<?php echo "files/images/face_testimonios/".$data_producto["imagen"]; ?>" width="200" class="mgt15">
                    <?php } ?> 
                      <small style="color:red">Recomendado: 505 x 497</small>
                  </div>
                </div>
               
              </div>
                  <div class="box-footer">
                <div class="form-group">
                  <div class="col-sm-10 pull-right">
                    <input  type="submit"  class="btn bg-blue btn-flat" id="btnguardar" value="Guardar">
                    <button type="button" class="btn bg-red btn-flat" onclick="javascript:gotourl('<?php echo $link2; ?>');">Cancelar</button>
                  </div>
                </div>
              </div>
<script>	
function aceptar(){
	var nam1=document.getElementById("titulo").value;		
	
	if(nam1 !='' ){									
		alert("Registrando ... Click en Aceptar & espere unos segundos. ");							
		document.getElementById("btnguardar").disabled=true;			
	}else{		
		alert("Recomendación: Ingrese Nombre de persona)");
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
        archivo:{ required:false,accept:'pdf,docs,doc,jpg,png' }
      }
    };
</script>
<?php
}elseif($_GET["task"]=='drop' || $_GET["task"]=='dropselect'){  
  $bd = new BD;
  $bd->Begin();
  $ide = !isset($_GET['ide']) ? implode(',', $_GET['chkDel']) : $_GET['ide'];
  $face_testimonios = executesql("SELECT * FROM face_testimonios WHERE ide IN(".$ide.")");
  if(!empty($face_testimonios)){
    foreach($face_testimonios as $row){
      $pfile = 'files/images/face_testimonios/'.$row['imagen']; if(file_exists($pfile) && !empty($row['imagen'])){ unlink($pfile); }
      // $pfile = 'files/images/face_testimonios/'.$row['imagen2']; if(file_exists($pfile) && !empty($row['imagen2'])){ unlink($pfile); }
     }
    }  
  $bd->actualiza_("DELETE FROM face_testimonios WHERE ide IN(".$ide.")");
  $bd->Commit();
  $bd->close();

}elseif($_GET["task"]=='ordenar'){

  $bd = new BD;
  $_GET['order'] = array_reverse($_GET['order']);
  foreach ($_GET['order'] as $order => $item) {
    $orden = $orden + 1;
    $bd->actualiza_("UPDATE face_testimonios SET orden= ".$orden." WHERE ide = ".$item."");
  }
  $bd->Commit();
  $bd->close();

}elseif($_GET["task"]=='uestado'){

  $bd = new BD;
  $bd->Begin();

  $ide = !isset($_GET['ide']) ? $_GET['estado_idestado'] : $_GET['ide'];
  $ide = is_array($ide) ? implode(',',$ide) : $ide;
  $face_testimonios = executesql("SELECT * FROM face_testimonios WHERE ide IN (".$ide.")");

  if(!empty($face_testimonios))
    foreach($face_testimonios as $reg => $item)
      if ($item['estado_idestado']==1) {
        $state = 2;
      }elseif ($item['estado_idestado']==2) {
        $state = 1;
      }
  $bd->actualiza_("UPDATE face_testimonios SET estado_idestado=".$state." WHERE ide=".$ide."");
  echo $state;
  $bd->Commit();
  $bd->close();

}elseif($_GET["task"]=='finder'){

  $sql = "SELECT p.*, e.nombre as estado FROM face_testimonios p Inner join estado e on p.estado_idestado=e.idestado "; 
  if(isset($_GET['criterio_mostrar'])) $porPagina=$_GET['criterio_mostrar'];
  if(isset($_GET['criterio_usu_per']) && !empty($_GET['criterio_usu_per'])){
    $stringlike=fn_filtro(substr($_GET['criterio_usu_per'], 0, 16));
    $sql.= " where p.titulo LIKE '".$stringlike."%' OR p.descripcion LIKE '".$stringlike."%' ";
  }
  if(isset($_GET['criterio_ordenar_por'])) $sql.= sprintf(" order by %s %s", fn_filtro($_GET['criterio_ordenar_por']), fn_filtro($_GET['criterio_orden']));
  $sql.= " ORDER BY p.orden DESC";
	
	
  $paging = new PHPPaging;
  $paging->agregarConsulta($sql); 
  $paging->div('div_listar');
  $paging->modo('desarrollo'); 
  $numregistro=1; 
  if($numregistro) $paging->porPagina(fn_filtro((int)$numregistro));
  $paging->verPost(true);
  $mantenerVar=array("criterio_mostrar","task","criterio_usu_per","criterio_ordenar_por","criterio_orden");

  $paging->mantenerVar($mantenerVar);
  $paging->porPagina(fn_filtro((int)$porPagina));
  $paging->ejecutar();
  $paging->pagina_proceso="face_testimonios.php";
?>
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr role="row">
                  <th class="unafbe" width="20"><input type="checkbox" id="chkDel" class="all"></th>
                  <th class="sort">TÍTULO</th>
                  <th class="unafbe cnone">IMÁGEN</th>
                  <th class="sort cnone">ESTADO</th>
                  <th class="unafbe" width="130">Opciones</th>
                </tr>
              </thead>
              <tbody id="sort">
<?php while ($detalles = $paging->fetchResultado()): ?>
                <tr id="order_<?php echo $detalles["ide"]; ?>">
                  <td><input type="checkbox" name="chkDel[]" class="chkDel" value="<?php echo $detalles["ide"]; ?>"></td>
                  <td><?php echo $detalles["titulo"]; ?></td>                
                  <td class="cnone">
                    <?php if(!empty($detalles["imagen"])){ ?>
                    <img src="<?php echo "files/images/face_testimonios/".$detalles["imagen"]; ?>"  class="img-responsive">
                    <?php }else{ echo "Not Image."; } ?>
                  </td>  
                  <td class="cnone"><a href="javascript: fn_estado('<?php echo $detalles["ide"]; ?>')"><?php echo $detalles["estado"]; ?></a></td>
                  <td>
                    <div class="btn-eai btns btr">
                      <a href="<?php echo $_SESSION["base_url"].'&task=edit&ide='.$detalles["ide"]; ?>" style="color:#fff;"><i class="fa fa-edit"></i> editar</a>
                      <a href="javascript: fn_eliminar('<?php echo $detalles["ide"]; ?>')"><i class="fa fa-trash-o"></i></a>
                    </div>
                  </td>
                </tr>
<?php endwhile; ?>
              </tbody>
            </table>
            <div class="pagination"><?php echo $paging->fetchNavegacion(); ?></div>
<script>
$(function(){
  checked();
  sorter();
  reordenar('face_testimonios.php');
});
var mypage = "face_testimonios.php";
</script>

<?php }else{ ?>
        <div class="box-body">
          <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
            <form action="javascript: fn_buscar();" id="frm_buscar" name="frm_buscar">
              <div class="bg-gray-light">
                <div class="col-sm-2">
                  <div class="btn-eai">
                    <a href="<?php echo $link2."&task=new"; ?>" style="color:#fff;"><i class="fa fa-file"></i> Agregar</a>
										<!-- 
                    <a href="javascript:fn_delete_all();"><i class="fa fa-trash-o"></i></a>
										-->
                  </div>
                </div>
                <div class="col-sm-4 criterio_buscar">
                  <?php create_input('text','criterio_usu_per','',"form-control pull-right",$table,"placeholder='Buscar ..'"); ?>
                </div>
                <div class="col-sm-2 criterio_mostrar">
                  <?php select_sql("nregistros"); ?>
                </div>
								<div class="col-sm-1 criterio_mostrar">
										<button class="btn_action_buscar ">B<span>uscar</span></button>
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
var us = "face_testimonio";
var link = "face_testimonio";
var ar = "el";
var l = "e";
var l2 = "e";
var pr = "el";
var id = "ide";
var mypage = "face_testimonios.php";
</script>

<?php } ?>