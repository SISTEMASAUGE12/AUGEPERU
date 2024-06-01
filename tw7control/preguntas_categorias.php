<?php
error_reporting(E_ALL ^ E_NOTICE);
include ("auten.php");


if($_GET["task"]=='neworden'){
  $bd=new BD;
  $orden_actual=$_GET["orden"];
  $orden_nuevo=$_GET["nuevoorden"];
  $tipo=$_GET["tipo"];  
  $id_del_registro_actual=$_GET["id_cat"];
  $criterio_Orden =" ";
  nuevoorden($orden_actual, $orden_nuevo, $tipo, $id_del_registro_actual, "preguntas_categorias", "id_cat", $criterio_Orden);    
  $bd->close();

}elseif($_GET["task"]=='insert' || $_GET["task"]=='update'){
  $bd=new BD;
  $where = ($_GET["task"]=='update') ? "and id_cat!='".$_POST["id_cat"]."'" : '';
  $urlrewrite=armarurlrewrite($_POST["titulo"]);
  $urlrewrite=armarurlrewrite($urlrewrite,1,"preguntas_categorias","id_cat","titulo_rewrite",$where);

$campos=array('titulo', array('titulo_rewrite',$urlrewrite),'titulo_boton',"color","estado_idestado"); 
  
  if($_GET["task"]=='insert'){
    if(isset($_FILES['imagen']) && !empty($_FILES['imagen']['name'])){
      $_POST['imagen'] = carga_imagen('files/images/preguntas_categorias/','imagen','','70','110');
      $campos = array_merge($campos,array('imagen'));
    }
    // if(isset($_FILES['archivo']) && !empty($_FILES['archivo']['name'])){
      // $_POST['archivo'] = upload_files('files/files/','archivo','',0);
      // $campos = array_merge($campos,array('archivo'));
    // }
    $_POST['orden'] = _orden_noticia("","preguntas_categorias","");
    $_POST['fecha_registro'] = fecha_hora(2);
    $bd->inserta_(arma_insert('preguntas_categorias',array_merge($campos,array('fecha_registro','orden')),'POST'));
  }else{
    if(isset($_FILES['imagen']) && !empty($_FILES['imagen']['name'])){
      $path = 'files/images/preguntas_categorias/'.$_POST['imagen_ant'];
      if( file_exists($path) && !empty($_POST['imagen_ant']) ) unlink($path);    
      $_POST['imagen'] = carga_imagen('files/images/preguntas_categorias/','imagen','','70','110');
      $campos = array_merge($campos,array('imagen'));
    }
    // if(isset($_FILES['archivo']) && !empty($_FILES['archivo']['name'])){
      // $path = 'files/files/'.$_POST['archivo_ant'];
      // if( file_exists($path) && !empty($_POST['archivo_ant']) ) unlink($path);    
      // $_POST['archivo'] = carga_imagen('files/files/','archivo','');
      // $campos = array_merge($campos,array('archivo'));
    // }
    $bd->actualiza_(armaupdate('preguntas_categorias',$campos," id_cat='".$_POST["id_cat"]."'",'POST'));/*actualizo*/
  }
  $bd->close();
  gotoUrl("index.php?page=".$_POST["nompage"]."&module=".$_POST["nommodule"]."&parenttab=".$_POST["nomparenttab"]);

}elseif($_GET["task"]=='new' || $_GET["task"]=='edit'){
  if($_GET["task"]=='edit'){
     $data_producto=executesql("select * from preguntas_categorias where id_cat='".$_GET["id_cat"]."'",0);
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
              <h3 class="box-title"> Preguntas Frecuentes </h3>
            </div><!-- /.box-header -->
<?php $task_=$_GET["task"]; ?>
            <!-- form start -->
            <form id="registro" action="preguntas_categorias.php?task=<?php echo ($task_=='edit') ?  "update" : "insert"; ?>" class="form-horizontal" method="POST" enctype="multipart/form-data"  onsubmit="return aceptar()" >
<?php 
if($task_=='edit') create_input("hidden","id_cat",$data_producto["id_cat"],"",$table,"");
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
                  <label for="inputPassword3" class="col-sm-2 control-label">Título</label>
                  <div class="col-sm-6">
                    <?php create_input("text","titulo",$data_producto["titulo"],"form-control",$table,"",$agregado); ?>
                  </div>
                </div>								
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Imágen: 70px ancho x 110px alto</label>
                  <div class="col-sm-6">
                    <input type="file" name="imagen" id="imagen" class="form-control">
                    <?php create_input("hidden","imagen_ant",$data_producto["imagen"],"",$table,$agregado); 
                      if($data_producto["imagen"]!=""){ 
                    ?>
                      <img src="<?php echo "files/images/preguntas_categorias/".$data_producto["imagen"]; ?>" width="200" class="mgt15">
                    <?php } ?> 
                  </div>
                </div>
					<?php /*			
				*/ ?>				               
									
								<div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Título del boton</label>
                  <div class="col-sm-6">
                    <?php create_input("text","titulo_boton",$data_producto["titulo_boton"],"form-control",$table,"",$agregado); ?>
                  </div>
                </div>	
								
								<div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Color fondo del boton</label>
                  <div class="col-sm-6">
									<?php create_input("text","color",$data_producto["color"],"form-control color-picker",$table," ",' maxlength="7" size="7"'); ?>
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
<script>	
function aceptar(){
	var nam1=document.getElementById("titulo").value;		
	
	if(nam1 !='' ){									
		alert("Registrando ... Click en Aceptar & espere unos segundos. ");							
		document.getElementById("btnguardar").disabled=true;			
	}else{		
		alert("Recomendación: Ingrese título)");
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
  $ide = !isset($_GET['id_cat']) ? implode(',', $_GET['chkDel']) : $_GET['id_cat'];
  $preguntas_categorias = executesql("SELECT * FROM preguntas_categorias WHERE id_cat IN(".$ide.")");
  if(!empty($preguntas_categorias)){
    foreach($preguntas_categorias as $row){
      $pfile = 'files/images/preguntas_categorias/'.$row['imagen']; if(file_exists($pfile) && !empty($row['imagen'])){ unlink($pfile); }
      // $pfile = 'files/files/'.$row['archivo']; if(file_exists($pfile) && !empty($row['archivo'])){ unlink($pfile); }
    }
  }

  $bd->actualiza_("DELETE FROM preguntas_categorias WHERE id_cat IN(".$ide.")");
  $bd->Commit();
  $bd->close();

}elseif($_GET["task"]=='ordenar'){

  $bd = new BD;
  $_GET['order'] = array_reverse($_GET['order']);
  foreach ($_GET['order'] as $order => $item) {
    $orden = $orden + 1;
    $bd->actualiza_("UPDATE preguntas_categorias SET orden= ".$orden." WHERE id_cat = ".$item."");
  }
  $bd->Commit();
  $bd->close();

}elseif($_GET["task"]=='uestado'){

  $bd = new BD;
  $bd->Begin();

  $ide = !isset($_GET['id_cat']) ? $_GET['estado_idestado'] : $_GET['id_cat'];
  $ide = is_array($ide) ? implode(',',$ide) : $ide;
  $preguntas_categorias = executesql("SELECT * FROM preguntas_categorias WHERE id_cat IN (".$ide.")");

  if(!empty($preguntas_categorias))
    foreach($preguntas_categorias as $reg => $item)
      if ($item['estado_idestado']==1) {
        $state = 2;
      }elseif ($item['estado_idestado']==2) {
        $state = 1;
      }
  $bd->actualiza_("UPDATE preguntas_categorias SET estado_idestado=".$state." WHERE id_cat=".$ide."");
  echo $state;
  $bd->Commit();
  $bd->close();

}elseif($_GET["task"]=='finder'){

  $sql = "SELECT p.*, e.nombre as estado 
	FROM preguntas_categorias p 
	inner join estado e ON p.estado_idestado=e.idestado
  "; 
  if(isset($_GET['criterio_mostrar'])) $porPagina=$_GET['criterio_mostrar'];
  if(isset($_GET['criterio_usu_per']) && !empty($_GET['criterio_usu_per'])){
    $stringlike=fn_filtro(substr($_GET['criterio_usu_per'], 0, 16));
    $sql.= " where p.titulo LIKE '%".$stringlike."%'  ";
  }

  if(isset($_GET['criterio_ordenar_por'])) $sql.= sprintf(" order by %s %s", fn_filtro($_GET['criterio_ordenar_por']), fn_filtro($_GET['criterio_orden']));
  $sql.= " ORDER BY orden DESC";
	
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
  $paging->pagina_proceso="preguntas_categorias.php";
?>
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr role="row">
                  <th class="unafbe" width="20"><input type="checkbox" id="chkDel" class="all"></th>
                  <th class="sort">TÍTULO</th>
                  <th class="unafbe cnone">IMÁGEN</th>    
									<!--
-->									
                  <th class="sort cnone">FECHA</th>
                  <th class="sort cnone">ESTADO</th>
                  <th class="unafbe" width="130">Opciones</th>
                </tr>
              </thead>
              <tbody id="sort">
<?php while ($detalles = $paging->fetchResultado()): ?>
                <tr id="order_<?php echo $detalles["id_cat"]; ?>">
                  <td><input type="checkbox" name="chkDel[]" class="chkDel" value="<?php echo $detalles["id_cat"]; ?>"></td>
                  <td><?php echo $detalles["titulo"]; ?></td>  
                  <td class="cnone">
                    <?php if(!empty($detalles["imagen"])){ ?>
                    <img src="<?php echo "files/images/preguntas_categorias/".$detalles["imagen"]; ?>" alt="<?php echo $detalles["titulo"]; ?>" class="img-responsive">
                    <?php }else{ echo "Not Image."; } ?>
                  </td>
<?php /*									
						*/				?>
                  <td class="cnone"><?php echo fecha($detalles['fecha_registro']); ?></td>
                  <td class="cnone"><a href="javascript: fn_estado('<?php echo $detalles["id_cat"]; ?>')"><?php echo $detalles["estado"]; ?></a></td>
                  <td>
                    <div class="btn-eai btns btr">
                      <a href="<?php echo $_SESSION["base_url"].'&task=edit&id_cat='.$detalles["id_cat"]; ?>"><i class="fa fa-edit"></i></a>
											<!--
											<a href="index.php?page=galeria_pros&id_cat=<?php echo $detalles['id_cat']; ?>&module=<?php echo $detalles['titulo']; ?>&parenttab=Galería" title="Subir galería"><i class="fa fa-picture-o"></i></a>
											-->
														<?php  if($_SESSION["visualiza"]["idtipo_usu"] ==1){ ?>	 
                      <a href="javascript: fn_eliminar('<?php echo $detalles["id_cat"]; ?>')"><i class="fa fa-trash-o"></i></a>
															 <?php } ?> 									


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
  reordenar('preguntas_categorias.php');
});
var mypage = "preguntas_categorias.php";
</script>

<?php }else{ ?>
        <div class="box-body">
          <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
            <form action="javascript: fn_buscar();" id="frm_buscar" name="frm_buscar">
              <div class="bg-gray-light">
                <div class="col-sm-2">
                  <div class="btn-eai">
                    <a href="<?php echo $link."&task=new"; ?>" style="color:#fff;"><i class="fa fa-file"></i> agregar</a>
										<!--
                    <a href="javascript:fn_delete_all();"><i class="fa fa-trash-o"></i></a>
										-->
                  </div>
                </div>
               
                <div class="col-sm-3 criterio_buscar">
                  <?php create_input('text','criterio_usu_per','',"form-control pull-right",$table,"placeholder='buscar.. ' "); ?>
                </div>
                <div class="col-sm-2 criterio_mostrar">
                  <?php select_sql("nregistros"); ?>
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
var us = "categoria";
var link = "preguntas_categoria";
var ar = "el";
var l = "o";
var l2 = "a";
var pr = "El";
var id = "id_cat";
var mypage = "preguntas_categorias.php";
</script>

<?php } ?>