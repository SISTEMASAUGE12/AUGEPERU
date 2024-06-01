<?php 
error_reporting(E_ALL ^ E_NOTICE);
include ("auten.php");

if($_GET["task"]=='neworden'){
  $bd=new BD;
  $orden_actual=$_GET["orden"];
  $orden_nuevo=$_GET["nuevoorden"];
  $tipo=$_GET["tipo"];  
  $id_del_registro_actual=$_GET["id_trailer"];
  $criterio_Orden =" ";
	

  nuevoorden($orden_actual, $orden_nuevo, $tipo, $id_del_registro_actual, "curso_trailers", "id_trailer", $criterio_Orden);    
  $bd->close();
	

}else if($_GET["task"]=='insert' || $_GET["task"]=='update'){
  $bd=new BD;
	$where = ($_GET["task"]=='update') ? "and id_trailer!='".$_POST["id_trailer"]."'" : '';
	$urlrewrite=armarurlrewrite($_POST["titulo"]);
  $urlrewrite=armarurlrewrite($urlrewrite,1,"curso_trailers","id_trailer","titulo_rewrite",$where);
	
	$campos=array('id_curso','titulo',array('titulo_rewrite',$urlrewrite),'link','duracion','estado_idestado'); /*inserto campos principales*/
  
	if($_GET["task"]=='insert'){
		if(isset($_FILES['imagen']) && !empty($_FILES['imagen']['name'])){
      $_POST['imagen'] = carga_imagen('files/images/trailers/','imagen','','64','36');
      $campos = array_merge($campos,array('imagen'));
    }
    $_POST['orden'] = _orden_noticia("","curso_trailers","");
    $bd->inserta_(arma_insert('curso_trailers',array_merge($campos,array('orden')),'POST'));/*inserto hora -orden y guardo imag*/
 
	}else{
		if(isset($_FILES['imagen']) && !empty($_FILES['imagen']['name'])){
      $path = 'files/images/trailers/'.$_POST['imagen_ant'];
      if( file_exists($path) && !empty($_POST['imagen_ant']) ) unlink($path);    
      $_POST['imagen'] = carga_imagen('files/images/trailers/','imagen','','64','36');
      $campos = array_merge($campos,array('imagen'));
    }
    $bd->actualiza_(armaupdate('curso_trailers',$campos,"id_trailer='".$_POST["id_trailer"]."'",'POST'));/*actualizo*/
  }
  $bd->close();
  gotoUrl("index.php?page=".$_POST["nompage"]."&id_curso=".$_POST["id_curso"]."&module=".$_POST["nommodule"]."&parenttab=".$_POST["nomparenttab"]);
	
}elseif($_GET["task"]=='new' || $_GET["task"]=='edit'){
  if($_GET["task"]=='edit'){
     $data_servicio=executesql("select * from curso_trailers where id_trailer='".$_GET["id_trailer"]."'",0);
  }
?>
<!-- CK EDITOR -->
<script src="ckeditor/ckeditor.js"></script>
<script src="ckeditor/sample.js"></script>
<script src="ckfinder/ckfinder.js"></script>
<section class="content">
  <div class="row">
    <div class="col-md-12">
      <!-- Horizontal Form -->
      <div class="box box-info">
        <div class="box-header with-border">
				 <?php   $sql_x=" select * from cursos where id_curso='".$_GET["id_curso"]."' "; 
						$datoscurso=executesql($sql_x,0); 
					?>				
          <h4 class="box-title"><?php echo ($_GET["task"]=="edit") ? 'Editar' : 'Agregando'; ?> Video curso_trailers del Curso: <b><?php echo $datoscurso["titulo"]; ?> </b> </h4>
        </div><!-- /.box-header -->
<?php $task_=$_GET["task"]; ?>
        <!-- form start -->
        <form id="registro" action="curso_trailers.php?task=<?php echo ($task_=='edit') ?  "update" : "insert"; ?>" class="form-horizontal" method="POST" enctype="multipart/form-data" onsubmit="return aceptar()">
<?php 
if($task_=='edit') create_input("hidden","id_trailer",$data_servicio["id_trailer"],"",$table,"");
create_input("hidden","urlfailed",basename($_SERVER['REQUEST_URI']),"",$table,"");  
create_input("hidden","urlgo",$link_sesion,"",$table,"");
create_input("hidden","nompage",$_GET["page"],"",$table,""); 
create_input("hidden","id_curso",$_GET["id_curso"],"",$table,""); 
create_input("hidden","nommodule",$_GET["module"],"",$table,"");
create_input("hidden","nomparenttab",$_GET["parenttab"],"",$table,"");
?>
          <div class="box-body">
            <div class="form-group">
              <label for="inputEmail3" class="col-sm-2 control-label">Estado</label>
              <div class="col-sm-4">
                <?php crearselect("estado_idestado","select * from estado where idestado in('1','2') order by 2 desc",'class="form-control"',$data_servicio["estado"],""); ?>
              </div>
            </div>
            <div class="form-group">
              <label for="inputPassword3" class="col-sm-2 control-label">Título</label>
              <div class="col-sm-8">
                <?php create_input("text","titulo",$data_servicio["titulo"],"form-control",$table,"",$agregado); ?>
              </div>
            </div>
						<div class="form-group">
							<label for="inputPassword3" class="col-sm-2 control-label">Imágen : 64px ancho * 36px alto</label>
							<div class="col-sm-6">
								<input type="file" name="imagen" id="imagen" class="form-control">
								<?php create_input("hidden","imagen_ant",$data_servicio["imagen"],"",$table,$agregado); 
									if($data_servicio["imagen"]!=""){ 
								?>
									<img src="<?php echo "files/images/trailers/".$data_servicio["imagen"]; ?>" width="200" class="mgt15">
								<?php } ?> 
									<small style="color:red">Recomendado: 64 x 36px alto</small>
							</div>
						</div>
						
						<div class="form-group">
							<label for="inputPassword3" class="col-sm-2 control-label">Link video vimeo</label>
							<div class="col-sm-8">
								<?php create_input("text","link",$data_servicio["link"],"form-control lleva_link_vimeo ",$table,"",$agregado); ?>
								<iframe frameborder="0" width="100%" height="200" class="video_vimeo "></iframe>
								<!-- 
								-->
							</div>
						</div>
						<div class="form-group">
              <label for="inputPassword3" class="col-sm-2 control-label">Duracion del video ejem[10:20]</label>
              <div class="col-sm-8">
                <?php create_input("text","duracion",$data_servicio["duracion"],"form-control",$table,"",$agregado); ?>
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
        titulo:{required:true}
      }
    };
</script>
<?php


}elseif($_GET["task"]=='ordenar'){

  $bd = new BD;
  $_GET['order'] = array_reverse($_GET['order']);
  foreach ($_GET['order'] as $order => $item) {
    $orden = $orden + 1;
    $bd->actualiza_("UPDATE curso_trailers SET orden= ".$orden." WHERE id_trailer = ".$item."");
  }
  $bd->Commit();
  $bd->close();


}elseif($_GET["task"]=='drop' || $_GET["task"]=='dropselect'){
  $bd = new BD;
  $bd->Begin();
  $ide = !isset($_GET['id_trailer']) ? implode(',', $_GET['chkDel']) : $_GET['id_trailer'];
	
  $id_curso2 = executesql("SELECT * FROM curso_trailers WHERE id_trailer IN(".$ide.")");
  if(!empty($id_curso2)){
    foreach($id_curso2 as $row2){
      $pfile2 = 'files/images/trailers/'.$row2['imagen'];
      if(file_exists($pfile2) && !empty($row2['imagen'])){ unlink_sesion($pfile2); }
    }
  }
  $bd->actualiza_("DELETE FROM curso_trailers WHERE id_trailer IN(".$ide.")");
  $bd->Commit();
  $bd->close();

}elseif($_GET["task"]=='uestado'){
  $bd = new BD;
  $bd->Begin();
  $ide = !isset($_GET['id']) ? $_GET['estado_idestado'] : $_GET['id'];
  $ide = is_array($ide) ? implode(',',$ide) : $ide;
  $curso_trailers = executesql("SELECT * FROM curso_trailers WHERE id_trailer IN (".$ide.")");
  if(!empty($curso_trailers))
    foreach($curso_trailers as $reg => $item)
      if ($item['estado_idestado']==1) {
        $state = 2;
      }elseif ($item['estado_idestado']==2) {
        $state = 1;
      }
  $bd->actualiza_("UPDATE curso_trailers SET estado_idestado=".$state." WHERE id_trailer=".$ide."");
  echo $state;
  $bd->Commit();
  $bd->close();
	

}elseif($_GET["task"]=='finder'){
		$sql = "SELECT cv.*,e.nombre AS estado FROM curso_trailers cv INNER JOIN estado e ON cv.estado_idestado=e.idestado 
				WHERE cv.estado_idestado != 100 
	"; 
  if(!empty($_GET['criterio_mostrar'])) $porPagina=$_GET['criterio_mostrar'];
  if(!empty($_GET['criterio_usu_per'])){
    $stringlike=fn_filtro(substr($_GET['criterio_usu_per'], 0, 16));
    $sql.= " AND (cv.titulo LIKE '%".$stringlike."%')";
  }
  
	$sql.= " AND cv.id_curso =".$_GET['id_curso'];
  if(!empty($_GET['criterio_ordenar_por'])) $sql.= sprintf(" order by %s %s", fn_filtro($_GET['criterio_ordenar_por']), fn_filtro($_GET['criterio_orden']));
  $sql.= " ORDER BY cv.orden desc  ";
	
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
  $paging->pagina_proceso="curso_trailers.php";
?>
<table id="example1" class="table table-bordered table-striped">
  <thead>
    <tr role="row">
      <th class="sort">orden</th>
      <th class="sort">titulo</th>
      <th class="sort">IMG</th>
      <th class="sort">LINK</th>
      <th class="sort cnone">ESTADO</th>
      <th class="unafbe btn_varios">Opciones</th>
    </tr>
  </thead>
  <tbody id="sort">
<?php while ($detalles = $paging->fetchResultado()): ?>

    <tr id="order_<?php echo $detalles["id_trailer"]; ?>">
      <td><?php echo $detalles["orden"]; ?></td>
      <td><?php echo $detalles["titulo"]; ?></td>
			<td class="cnone">
				<?php if(!empty($detalles["imagen"])){ ?>
				<img src="<?php echo "files/images/trailers/".$detalles["imagen"]; ?>"  class="img-responsive">
				<?php }else{ echo "Not Image."; } ?>
			</td>
      <td><a href="<?php echo $detalles["link"]; ?>" target="_blank" >[link]</a> </td>
      <td class="cnone"><a href="javascript: fn_estado('<?php echo $detalles["id_trailer"]; ?>')"><?php echo $detalles["estado"]; ?></a></td>
      <td>
        <div class="btn-eai btns btr btn_varios text-center ">
          <a href="<?php echo $_SESSION["base_url"].'&task=edit&id_trailer='.$detalles["id_trailer"]; ?>" title="Editar"  style="color:#fff;"><i class="fa fa-edit"></i> editar</a>
						
<?php  if($_SESSION["visualiza"]["idtipo_usu"] ==1){ ?>
					
					<a href="javascript: fn_eliminar('<?php echo $detalles["id_trailer"]; ?>')"><i class="fa fa-trash-o "></i> </a>
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
  reordenar('curso_trailers.php');
});
var mypage = "curso_trailers.php";
</script>





<?php }else{ ?>
<div class="box-body">
  <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
    <form action="javascript: fn_buscar();" id="frm_buscar" name="frm_buscar">
      <input type="hidden" name="id_curso" value="<?php echo $_GET['id_curso']; ?>">
      <input type="hidden" name="module" value="<?php echo $_GET['module']; ?>">
      <input type="hidden" name="parenttab" value="<?php echo $_GET['parenttab']; ?>">
      <div class="bg-gray-light">      
        <div class="col-sm-12">
          <?php   $sql_x=" select * from cursos where id_curso='".$_GET["id_curso"]."' "; 
						$datoscurso=executesql($sql_x,0);
						// $volver_al_curso="index.php?page=cursos&module=".$_GET["module"]."&parenttab=".$_GET["parenttab"]."";
						
						echo "<h3 style='margin:0;' ><small> <b style='color:#333;'>Videos curso_trailers :</b> </small></h3>";
						echo "<h3 style='margin-top:0;padding-top:0;padding-bottom:10px;' ><small> <b style='color:#555;'>Curso</b> : ".$datoscurso["titulo"]." </small></h3>";
					?>
        </div>
				
				<div class="col-sm-2">
          <div class="btn-eai">
            <a href="<?php echo $link_sesion."&task=new"; ?>" title="Agregar" style="color:#fff;"><i class="fa fa-file" style="padding-right:5px;"></i>Agregar</a> 
          </div>
        </div>
        <div class="col-sm-4 ">          
          <?php create_input('text','criterio_usu_per','',"form-control pull-right",$table,'placeholder="Buscar .."'); ?>
        </div>
        <div class="col-sm-2 ">          
          <?php select_sql("nregistros"); ?>
        </div>
        <div class="col-sm-2">          
					<a href="javascript:history.go(-1)" class="pull-right">&laquo; RETORNAR</a>
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
var us = "trailer";
var link = "curso_trailer";
var ar = "la";
var l = "a";
var l2 = "a";
var pr = "La";
var id = "id_trailer";
var mypage = "curso_trailers.php";
</script>
<?php } ?>