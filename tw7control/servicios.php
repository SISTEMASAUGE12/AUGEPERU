<?php
error_reporting(E_ALL ^ E_NOTICE);
include ("auten.php");


if($_GET["task"]=='neworden'){
  $bd=new BD;
  $orden_actual=$_GET["orden"];
  $orden_nuevo=$_GET["nuevoorden"];
  $tipo=$_GET["tipo"];  
  $id_del_registro_actual=$_GET["idser"];
  $criterio_Orden =" ";
  nuevoorden($orden_actual, $orden_nuevo, $tipo, $id_del_registro_actual, "servicios", "idser", $criterio_Orden);    
  $bd->close();

}elseif($_GET["task"]=='insert' || $_GET["task"]=='update'){
  $bd=new BD;
  $where = ($_GET["task"]=='update') ? "and idser!='".$_POST["idser"]."'" : '';
  $urlrewrite=armarurlrewrite($_POST["nombre"]);
  $urlrewrite=armarurlrewrite($urlrewrite,1,"servicios","idser","nombre_rewrite",$where);

  $campos=array('nombre', array('nombre_rewrite',$urlrewrite),'link','texto1',"descripcion","estado_idestado"); 
  
  if($_GET["task"]=='insert'){
    if(isset($_FILES['imagen']) && !empty($_FILES['imagen']['name'])){
      $_POST['imagen'] = carga_imagen('files/images/servicios/','imagen','');
      $campos = array_merge($campos,array('imagen'));
    }
    if(isset($_FILES['archivo']) && !empty($_FILES['archivo']['name'])){
      $_POST['archivo'] = upload_files('files/files/','archivo','',0);
      $campos = array_merge($campos,array('archivo'));
    }
    $_POST['orden'] = _orden_noticia("","servicios","");
    // $_POST['fecha_registro'] = fecha_hora(2);
    $bd->inserta_(arma_insert('servicios',array_merge($campos,array('orden')),'POST'));
  }else{
    if(isset($_FILES['imagen']) && !empty($_FILES['imagen']['name'])){
      $path = 'files/images/servicios/'.$_POST['imagen_ant'];
      if( file_exists($path) && !empty($_POST['imagen_ant']) ) unlink($path);    
      $_POST['imagen'] = carga_imagen('files/images/servicios/','imagen','');
      $campos = array_merge($campos,array('imagen'));
    }
    if(isset($_FILES['archivo']) && !empty($_FILES['archivo']['name'])){
      $path = 'files/files/'.$_POST['imagen_ant'];
      if( file_exists($path) && !empty($_POST['imagen_ant']) ) unlink($path);    
      $_POST['archivo'] = carga_imagen('files/files/','archivo','');
      $campos = array_merge($campos,array('archivo'));
    }
    $bd->actualiza_(armaupdate('servicios',$campos," idser='".$_POST["idser"]."'",'POST'));/*actualizo*/
  }
  $bd->close();
  gotoUrl("index.php?page=".$_POST["nompage"]."&module=".$_POST["nommodule"]."&parenttab=".$_POST["nomparenttab"]);

}elseif($_GET["task"]=='new' || $_GET["task"]=='edit'){
  if($_GET["task"]=='edit'){
     $data_producto=executesql("select * from servicios where idser='".$_GET["idser"]."'",0);
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
              <h3 class="box-title"> Servicios </h3>
            </div><!-- /.box-header -->
<?php $task_=$_GET["task"]; ?>
            <!-- form start -->
            <form id="registro" action="servicios.php?task=<?php echo ($task_=='edit') ?  "update" : "insert"; ?>" class="form-horizontal" method="POST" enctype="multipart/form-data">
<?php 
if($task_=='edit') create_input("hidden","idser",$data_producto["idser"],"",$table,"");
create_input("hidden","urlfailed",basename($_SERVER['REQUEST_URI']),"",$table,"");  
create_input("hidden","urlgo",$link,"",$table,"");
create_input("hidden","nompage",$_GET["page"],"",$table,""); 
create_input("hidden","nommodule",$_GET["module"],"",$table,"");
create_input("hidden","nomparenttab",$_GET["parenttab"],"",$table,"");
?>
              <div class="box-body">
								<input type="hidden" name="tipo" value="<?php echo $_GET["tipo"];?>">
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Estado</label>
                  <div class="col-sm-6">
                    <?php crearselect("estado_idestado","select * from estado where idestado in('1','2') order by 2 desc",'class="form-control"',$data_producto["estado_idestado"],""); ?>
                  </div>
                </div>
				
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Título</label>
                  <div class="col-sm-6">
                    <?php create_input("text","nombre",$data_producto["nombre"],"form-control",$table,"",$agregado); ?>
                  </div>
                </div>				
					
<?php 			/*		
								<div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Texto Grande</label>
                  <div class="col-sm-6">
                    <?php create_input("textarea","texto1",$data_producto["texto1"],"form-control",$table,"",$agregado); ?>
                  </div>
                </div>
				
				<div class="form-group">
					<label for="inputPassword3" class="col-sm-2 control-label">Link video youtube</label>
					<div class="col-sm-6">
						<?php create_input("text","link",$data_producto["link"],"form-control",$table,"",$agregado); ?>
						<iframe frameborder="0" width="100%" height="200" class="lvideo"></iframe>
					</div>
				</div>
				
				<div class="form-group">
								<label for="inputPassword3" class="col-sm-2 control-label">Archivo</label>
								<div class="col-sm-6">
									<input type="file" name="archivo" id="archivo" class="form-control">
									<?php  create_input("hidden","archivo_ant",$data_producto["archivo"],"",$table,$agregado); 
										if($data_producto["archivo"]!=""){ 
									?>
									 <a href="files/files/<?php  echo $data_producto['archivo'];  ?>" target="_blank"> <img src="dist/img/icons/icon-pdf.jpg"></a>
									<?php  } ?> 
								</div>
							</div> 
				 */ ?>
				
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Imágen</label>
                  <div class="col-sm-6">
                    <input type="file" name="imagen" id="imagen" class="form-control">
                    <?php create_input("hidden","imagen_ant",$data_producto["imagen"],"",$table,$agregado); 
                      if($data_producto["imagen"]!=""){ 
                    ?>
                      <img src="<?php echo "files/images/servicios/".$data_producto["imagen"]; ?>" width="200" class="mgt15">
                    <?php } ?> 
                  </div>
                </div>
              
							
  
            
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Descripción</label>
                  <div class="col-sm-10">
                    <?php create_input("textarea","descripcion",$data_producto["descripcion"],"",$table,$agregado);  ?>
                    <script>
                    var editor11 = CKEDITOR.replace('descripcion');
                    CKFinder.setupCKEditor( editor11, 'ckfinder/' );
                    </script> 
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
  $ide = !isset($_GET['idser']) ? implode(',', $_GET['chkDel']) : $_GET['idser'];
  $servicios = executesql("SELECT * FROM servicios WHERE idser IN(".$ide.")");
  if(!empty($servicios)){
    foreach($servicios as $row){
      $pfile = 'files/images/servicios/'.$row['imagen']; if(file_exists($pfile) && !empty($row['imagen'])){ unlink($pfile); }
      $pfile = 'files/files/'.$row['archivo']; if(file_exists($pfile) && !empty($row['archivo'])){ unlink($pfile); }
    }
  }

  $bd->actualiza_("DELETE FROM servicios WHERE idser IN(".$ide.")");
  $bd->Commit();
  $bd->close();

}elseif($_GET["task"]=='ordenar'){

  $bd = new BD;
  $_GET['order'] = array_reverse($_GET['order']);
  foreach ($_GET['order'] as $order => $item) {
    $orden = $orden + 1;
    $bd->actualiza_("UPDATE servicios SET orden= ".$orden." WHERE idser = ".$item."");
  }
  $bd->Commit();
  $bd->close();

}elseif($_GET["task"]=='uestado'){

  $bd = new BD;
  $bd->Begin();

  $ide = !isset($_GET['idser']) ? $_GET['estado_idestado'] : $_GET['idser'];
  $ide = is_array($ide) ? implode(',',$ide) : $ide;
  $servicios = executesql("SELECT * FROM servicios WHERE idser IN (".$ide.")");

  if(!empty($servicios))
    foreach($servicios as $reg => $item)
      if ($item['estado_idestado']==1) {
        $state = 2;
      }elseif ($item['estado_idestado']==2) {
        $state = 1;
      }
  $bd->actualiza_("UPDATE servicios SET estado_idestado=".$state." WHERE idser=".$ide."");
  echo $state;
  $bd->Commit();
  $bd->close();

}elseif($_GET["task"]=='finder'){

  $sql = "SELECT p.*, e.nombre as estado FROM servicios p inner join estado e ON p.estado_idestado=e.idestado  "; 
  if(isset($_GET['criterio_mostrar'])) $porPagina=$_GET['criterio_mostrar'];
  if(isset($_GET['criterio_usu_per']) && !empty($_GET['criterio_usu_per'])){
    $stringlike=fn_filtro(substr($_GET['criterio_usu_per'], 0, 16));
    $sql.= " nombre LIKE '%".$stringlike."%' OR descripcion LIKE '%".$stringlike."%'  and ";
  }
  if(isset($_GET['criterio_ordenar_por'])) $sql.= sprintf(" order by %s %s", fn_filtro($_GET['criterio_ordenar_por']), fn_filtro($_GET['criterio_orden']));
  $sql.= "  ORDER BY orden DESC";
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
  $paging->pagina_proceso="servicios.php";
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
                <tr id="order_<?php echo $detalles["idser"]; ?>">
                  <td><input type="checkbox" name="chkDel[]" class="chkDel" value="<?php echo $detalles["idser"]; ?>"></td>                                
                  <td><?php echo $detalles["nombre"]; ?></td>                
                  <td class="cnone">
                    <?php if(!empty($detalles["imagen"])){ ?>
                    <img src="<?php echo "files/images/servicios/".$detalles["imagen"]; ?>" alt="<?php echo $detalles["nombre"]; ?>" class="img-responsive">
                    <?php }else{ echo "Not Image."; } ?>
                  </td>								                  
                  <td class="cnone"><a href="javascript: fn_estado('<?php echo $detalles["idser"]; ?>')"><?php echo $detalles["estado"]; ?></a></td>
                  <td>
                    <div class="btn-eai btns btr">
                      <a href="<?php echo $_SESSION["base_url"].'&task=edit&idser='.$detalles["idser"]; ?>"><i class="fa fa-edit"></i></a>
                      <a href="javascript: fn_eliminar('<?php echo $detalles["idser"]; ?>')"><i class="fa fa-trash-o"></i></a>
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
  reordenar('servicios.php');
});
var mypage = "servicios.php";
</script>

<?php }else{ ?>
        <div class="box-body">
          <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
            <form action="javascript: fn_buscar();" id="frm_buscar" name="frm_buscar">
							<input type="hidden" name="tipo" value="<?php echo $_GET["tipo"];?>">
              <div class="bg-gray-light">
                <div class="col-sm-5">
                  <div class="btn-eai">
                    <a href="<?php echo $link."&task=new"; ?>"><i class="fa fa-file"></i></a>                    
                  </div>
                </div>
                <div class="break"></div>
                <div class="col-sm-3 criterio_buscar">
                  <label for="">Criterio</label>
                  <?php create_input('text','criterio_usu_per','',"form-control pull-right",$table,$agregados); ?>
                </div>
                <div class="col-sm-3 criterio_mostrar">
                  <label for="">N° Registros</label>
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
var us = "servicio";
var link = "servicio";
var ar = "la";
var l = "a";
var l2 = "a";
var pr = "La";
var id = "idser";
var mypage = "servicios.php";
</script>

<?php } ?>