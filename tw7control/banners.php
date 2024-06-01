<?php error_reporting(E_ALL ^ E_NOTICE);
include_once("auten.php");

if($_GET["task"]=='neworden'){
  $bd=new BD;
  $orden_actual=$_GET["orden"];
  $orden_nuevo=$_GET["nuevoorden"];
  $tipo=$_GET["tipo"];  
  $id_del_registro_actual=$_GET["id"];
  $criterio_Orden ="";
  nuevoorden($orden_actual, $orden_nuevo, $tipo, $id_del_registro_actual, "banners", "id", $criterio_Orden);    
  $bd->close();

}elseif($_GET["task"]=='insert' || $_GET["task"]=='update'){
  $bd=new BD;
  $norden=_orden_noticia("","banners","");
  $campos=array("titulo",'descripcion','boton','link', "estado_idestado", array("orden",$norden)); 
  // $campos=array("estado_idestado", array("orden",$norden)); 
  
  if($_GET["task"]=='insert'){
      if(isset($_FILES['imagen']) && !empty($_FILES['imagen']['name'])){
        $_POST['imagen'] = carga_imagen('files/images/banners/','imagen','','1920','696');
        $campos = array_merge($campos,array('imagen'));
      }

      if(isset($_FILES['imagen2']) && !empty($_FILES['imagen2']['name'])){
        $_POST['imagen2'] = carga_imagen('files/images/banners/','imagen2','','1920','696');
        $campos = array_merge($campos,array('imagen2'));
      }
    $bd->inserta_(arma_insert('banners',$campos,'POST'));

  }else{
      if(isset($_FILES['imagen']) && !empty($_FILES['imagen']['name'])){
      $path = 'files/images/banners/'.$_POST['imagen_ant'];
      if( file_exists($path) && !empty($_POST['imagen_ant']) ) unlink($path);    
      $_POST['imagen'] = carga_imagen('files/images/banners/','imagen','','1920','696');
      $campos = array_merge($campos,array('imagen'));
    }

    if(isset($_FILES['imagen2']) && !empty($_FILES['imagen2']['name'])){
      $path = 'files/images/banners/'.$_POST['imagen_ant_2'];
      if( file_exists($path) && !empty($_POST['imagen_ant_2']) ) unlink($path);    
      $_POST['imagen2'] = carga_imagen('files/images/banners/','imagen2','','1920','696');
      $campos = array_merge($campos,array('imagen2'));
    }
     $bd->actualiza_(armaupdate('banners',$campos," id='".$_POST["id"]."'",'POST'));/*actualizo*/
  }
 
  $bd->close();
  gotoUrl("index.php?page=".$_POST["nompage"]."&module=".$_POST["nommodule"]."&parenttab=".$_POST["nomparenttab"]);  
  
}elseif($_GET["task"]=='new' || $_GET["task"]=='edit'){
  if($_GET["task"]=='edit'){
     $data_producto=executesql("select * from banners where id='".$_GET["id"]."'",0);
  }
?>
<section class="content">
  <div class="row">
    <div class="col-md-12">          
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">
                <?php echo ($_GET["task"]=="edit") ? 'Editar' : 'Nueva'; ?> Banners</h3>
                <p style="color:red;">* Esta configuración afecta a la portada de la web. Ruta: <?php echo $_dominio; ?></p>

				<!-- <p>(*) Opcional, no indispensable</p>-->
            </div>
<?php $task_=$_GET["task"]; ?>            
            <form id="registro" action="banners.php?task=<?php echo ($task_=='edit') ?  "update" : "insert"; ?>" class="form-horizontal" method="POST"  enctype="multipart/form-data">
<?php 
if($task_=='edit') create_input("hidden","id",$data_producto["id"],"",$table,""); 

create_input("hidden","urlfailed",basename($_SERVER['REQUEST_URI']),"",$table,"");  
create_input("hidden","urlgo",$link2,"",$table,"");
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
                  <label for="inputPassword3" class="col-sm-2 control-label">Banner</label>
                  <div class="col-sm-6">
                    <input type="file" name="imagen" id="imagen" class="form-control">
                    <?php create_input("hidden","imagen_ant",$data_producto["imagen"],"",$table,$agregado); 
                      if($data_producto["imagen"]!=""){ 
                    ?>
                      <img src="<?php echo "files/images/banners/".$data_producto["imagen"]; ?>" width="200" class="mgt15">
                    <?php } ?> 
                      <small style="color:red">Recomendado: 1900 x 860 </small>
                  </div>
                </div>
             
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Banner movil </label>
                  <div class="col-sm-6">
                    <input type="file" name="imagen2" id="imagen2" class="form-control">
                    <?php create_input("hidden","imagen_ant_2",$data_producto["imagen2"],"",$table,$agregado); 
                      if($data_producto["imagen2"]!=""){ 
                    ?>
                      <img src="<?php echo "files/images/banners/".$data_producto["imagen2"]; ?>" width="200" class="mgt15">
                    <?php } ?> 
                      <small style="color:red">Recomendado: 768px x 600px aproximado</small>
                  </div>
                </div>
             
								<div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Texto adicional del titulo (*)</label>
                  <div class="col-sm-6">
                    <?php create_input("text","descripcion",$data_producto["descripcion"],"form-control",$table,"",$agregado); ?>
                  </div>
                </div>
								
								<div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Nombre del Boton (*)</label>
                  <div class="col-sm-6">
                    <?php create_input("text","boton",$data_producto["boton"],"form-control",$table,"",$agregado); ?>
                  </div>
                </div>
								
								<div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Link del Boton (*)</label>
                  <div class="col-sm-6">
                    <?php create_input("text","link",$data_producto["link"],"form-control",$table,"",$agregado); ?>
                  </div>
                </div>                
						 
						 
						 
						 
              </div>
              <div class="box-footer">
                <div class="form-group">
                  <div class="col-sm-10 pull-right">
                    <button type="submit" class="btn bg-blue btn-flat">Guardar</button>
                    <button type="button" class="btn bg-red btn-flat" onclick="javascript:gotourl('<?php echo $link2; ?>');">Cancelar</button>
                  </div>
                </div>
              </div>
            </form>
          </div><!-- /.box -->
        </div><!--/.col (right) -->
  </div>
</section><!-- /.content -->
<?php
}elseif($_GET["task"]=='drop' || $_GET["task"]=='dropselect'){
  
  $bd = new BD;
  $bd->Begin();
  $ide = !isset($_GET['id']) ? implode(',', $_GET['chkDel']) : $_GET['id'];
  $categoria = executesql("SELECT imagen FROM banners WHERE id IN(".$ide.")");
  if(!empty($categoria)){
    foreach($categoria as $row){
      $pfile = 'files/images/banners/'.$row['imagen']; 
      if(file_exists($pfile) && !empty($row['imagen'])) unlink($pfile);
    }
  }
  $bd->actualiza_("DELETE FROM banners WHERE id IN(".$ide.")"); 
  $bd->Commit();
  $bd->close();

  if($num_afect<=0){echo "Error: eliminando registro"; exit;}

}elseif($_GET["task"]=='ordenar'){
  $bd = new BD;

  $_GET['order'] = array_reverse($_GET['order']);

  foreach ($_GET['order'] as $order => $item) {
    $orden = $orden + 1;
    $num_afect=$bd->actualiza_("UPDATE banners SET orden= ".$orden." WHERE id = ".$item."");
  }

  $bd->close();

}elseif($_GET["task"]=='uestado'){
  $bd = new BD;
  $bd->Begin();
  $ide = !isset($_GET['id']) ? $_GET['estado_idestado'] : $_GET['id'];
  $ide = is_array($ide) ? implode(',',$ide) : $ide;
  $categoria = executesql("SELECT * FROM banners WHERE id IN (".$ide.")");
  if(!empty($categoria))
  foreach($categoria as $reg => $item)
  if ($item['estado_idestado']==1) {
    $state = 2;
  }elseif ($item['estado_idestado']==2) {
    $state = 1;
  }
  $num_afect=$bd->actualiza_("UPDATE banners SET estado_idestado=".$state." WHERE id=".$ide."");
  echo $state;
  $bd->Commit();
  $bd->close();

}elseif($_GET["task"]=='finder'){

  $sql.= "SELECT c.*,e.nombre AS estado FROM banners c INNER JOIN estado e ON c.estado_idestado=e.idestado";
  if (isset($_GET['criterio_mostrar'])) $porPagina=$_GET['criterio_mostrar'];
  if(isset($_GET['criterio_usu_per']) && !empty($_GET['criterio_usu_per'])){
    $stringlike=fn_filtro(substr($_GET['criterio_usu_per'], 0, 16));
    $sql.= " WHERE c.titulo LIKE '%".$stringlike."%'";
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
  $paging->pagina_proceso="banners.php";
?>
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr role="row">
                  <th class="unafbe" width="20"><input type="checkbox" id="chkDel" class="all"></th>
                  
									<th class=" cnone">TITULO</th>
									<th class="unafbe cnone">BANNER</th>
                  <th class="sort cnone">ESTADO</th>
                  <th class="unafbe">Opciones</th>
                </tr>
              </thead>
              <tbody id="sort">
<?php while ($detalles = $paging->fetchResultado()): ?>
                <tr id="order_<?php echo $detalles["id"]; ?>">
                  <td><input type="checkbox" name="chkDel[]" class="chkDel" value="<?php echo $detalles["id"]; ?>"></td>
									<td>
                    <?php echo $detalles["titulo"]; ?>
									</td>
									<td>
                    <?php if(!empty($detalles["imagen"])){ ?>
                    <img src="<?php echo "files/images/banners/".$detalles["imagen"]; ?>" alt="<?php echo $detalles["nombre"]; ?>" class="img-responsive">
                    <?php }else{ echo "Not Image."; } ?>
                  </td>
				  
                  <td class="cnone"><a href="javascript: fn_estado('<?php echo $detalles["id"]; ?>')"><?php echo $detalles["estado"]; ?></a></td>
                  <td>
                    <div class="btn-eai btr">
                      <a href="<?php echo $_SESSION["base_url"].'&task=edit&id='.$detalles["id"]; ?>" style="color:#fff;"><i class="fa fa-edit" style="padding-right:3px;"></i> editar</a>
                      <a href="javascript: fn_eliminar('<?php echo $detalles["id"]; ?>')"><i class="fa fa-trash-o"></i> </a>
                    </div>
                  </td>
                </tr>
<?php endwhile; ?>
              </tbody>
            </table>
            <div class="pagination"><?php echo $paging->fetchNavegacion(); ?></div>
<script>
$(function(){
  reordenar('banners.php');
  checked();
  sorter();
});
</script>

<?php }else{ ?>
        <div class="box-body">
          <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
            <form action="javascript: fn_buscar();" id="frm_buscar" name="frm_buscar">
              <div class="bg-gray-light">
                <div class="col-sm-3">
                  <div class="btn-eai" >
                    <a href="<?php echo $link2."&task=new"; ?>" style="color:#fff;"><i class="fa fa-file" style="padding-right:8px;"></i> Agregar</a>
										<!-- 
                    <a href="javascript:fn_delete_all();"><i class="fa fa-trash-o"></i></a>
										-->
                  
                  </div>
                </div>
                <div class="col-sm-3 criterio_buscar">
                  <?php create_input('text','criterio_usu_per','',"form-control pull-right",$table,'placeholder="Buscar.."'); ?>
                </div>
                <div class="col-sm-3 criterio_mostrar">
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
var link = "banner";
var us = "banner";
var l = "o";
var l2 = "a";
var pr = "La";
var ar = "la";
var id = "id";
var mypage = "banners.php";
</script>
<?php } ?>