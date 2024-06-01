<?php
error_reporting(E_ALL ^ E_NOTICE);
include ("auten.php");

if($_GET["task"]=='neworden'){
  $bd=new BD;
  $orden_actual=$_GET["orden"];
  $orden_nuevo=$_GET["nuevoorden"];
  $tipo=$_GET["tipo"];  
  $id_del_registro_actual=$_GET["id_detalle"];
  $criterio_Orden =" ";
  nuevoorden($orden_actual, $orden_nuevo, $tipo, $id_del_registro_actual, "detalle_sesiones", "id_detalle", $criterio_Orden);    
  $bd->close();
	
}elseif($_GET["task"]=='insert' || $_GET["task"]=='update'){
	
	
  $bd=new BD;
	$where = ($_GET["task"]=='update') ? "and id_detalle!='".$_POST["id_detalle"]."'" : '';
	$urlrewrite=armarurlrewrite($_POST["titulo"]);
  $urlrewrite=armarurlrewrite($urlrewrite,1,"detalle_sesiones","id_detalle","titulo_rewrite",$where);
	
	if(empty($_POST['duracion']) ){
		$_POST['duracion']=0;
	}
	// $_POST['video_you']=$_POST['link'];
  $campos=array('id_sesion','titulo',array('titulo_rewrite',$urlrewrite),'descripcion','descripcion_intro','externo','duracion','lleva_video','link','estado_idestado'); 
	
  if($_GET["task"]=='insert'){
		if(isset($_FILES['video']) && !empty($_FILES['video']['name'])){
      $_POST['video'] = carga_imagen('files/videos/'.$_POST['id_sesion'].'/','video','');
      $campos = array_merge($campos,array('video'));
		}
    $_POST['orden'] = _orden_noticia("","detalle_sesiones","");;
    
		// echo var_dump(arma_insert('detalle_sesiones',array_merge($campos,array('orden')),'POST'));
		// exit(); 
		
		$bd->inserta_(arma_insert('detalle_sesiones',array_merge($campos,array('orden')),'POST'));
		
  }else{
		if(isset($_FILES['video']) && !empty($_FILES['video']['name'])){
      $path = 'files/videos/'.$_POST['id_sesion'].'/'.$_POST['video_ant'];
      if( file_exists($path) && !empty($_POST['video_ant']) ) unlink($path);    
      $_POST['video'] = carga_imagen('files/videos/'.$_POST['id_sesion'].'/','video','');
      $campos = array_merge($campos,array('video'));
    }
    $bd->actualiza_(armaupdate('detalle_sesiones',$campos," id_detalle='".$_POST["id_detalle"]."'",'POST'));/*actualizo*/
  }
  $bd->close();
  gotoUrl("index.php?page=".$_POST["nompage"]."&id_sesion=".$_POST["id_sesion"]."&module=".$_POST["nommodule"]."&parenttab=".$_POST["nomparenttab"]);
	
}elseif($_GET["task"]=='new' || $_GET["task"]=='edit'){
  if($_GET["task"]=='edit'){
     $data_producto=executesql("select * from detalle_sesiones where id_detalle='".$_GET["id_detalle"]."'",0);
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
          <h3 class="box-title"><?php echo ($_GET["task"]=="edit") ? 'Editar' : 'Nuevo'; ?> Tema:</h3>
        </div><!-- /.box-header -->
<?php $task_=$_GET["task"]; ?>
        <!-- form start -->
        <form id="registro" action="detalle_sesiones.php?task=<?php echo ($task_=='edit')?"update":"insert"; ?>" class="form-horizontal" method="POST" enctype="multipart/form-data" onsubmit="return aceptar()">
<?php 
if($task_=='edit') create_input("hidden","id_detalle",$data_producto["id_detalle"],"",$table,"");
create_input("hidden","urlfailed",basename($_SERVER['REQUEST_URI']),"",$table,"");  
create_input("hidden","urlgo",$link_detalle,"",$table,"");
create_input("hidden","nompage",$_GET["page"],"",$table,""); 
create_input("hidden","id_sesion",$_GET["id_sesion"],"",$table,""); 
create_input("hidden","nommodule",$_GET["module"],"",$table,"");
create_input("hidden","nomparenttab",$_GET["parenttab"],"",$table,"");
// $data_producto["link"]=$data_producto["video_you"];
?>
          <div class="box-body">
            <div class="form-group">
              <label for="inputEmail3" class="col-sm-2 control-label">Estado</label>
              <div class="col-sm-4">
                <?php crearselect("estado_idestado","select * from estado where idestado in('1','2') order by 2 desc",'class="form-control"',$data_producto["estado_idestado"],""); ?>
              </div>
            </div>
            <div class="form-group">
              <label for="inputPassword3" class="col-sm-2 control-label">Título del Tema</label>
              <div class="col-sm-6">
                <?php create_input("text","titulo",$data_producto["titulo"],"form-control",$table,"",$agregado); ?>
              </div>
            </div>
						<div class="form-group">
							<label for="inputPassword3" class="col-sm-2 control-label">Descripción Intro (antes del video):</label>
							<div class="col-sm-8">
								<?php create_input("textarea","descripcion_intro",$data_producto["descripcion_intro"],"",$table,$agregado);  ?>
								<script>
								var editor11_1= CKEDITOR.replace('descripcion_intro','');
								CKFinder.setupCKEditor( editor11_1, 'ckfinder/' );
								</script> 
							</div>
						</div>
						
						<div class="form-group">
							<label for="inputPassword3" class="col-sm-2 control-label">Descripción: (debajo del video)</label>
							<div class="col-sm-8">
								<?php create_input("textarea","descripcion",$data_producto["descripcion"],"",$table,$agregado);  ?>
								<script>
								var editor11 = CKEDITOR.replace('descripcion','');
								CKFinder.setupCKEditor( editor11, 'ckfinder/' );
								</script> 
							</div>
						</div>
						
						<div class="form-group">										
							<label for="inputEmail3" class="col-sm-2 control-label">Contiene algún video?</label>
							<div class="col-sm-2">
								<select id="lleva_video" name="lleva_video" required class="form-control">  <!-- saco valor desde la BD -->									
									<option value="2"  <?php echo ($data_producto['lleva_video'] == 2) ? 'selected' : '' ;?>>NO</option>
									<option value="1" <?php echo ($data_producto['lleva_video'] == 1) ? 'selected' : '' ;?>>SI</option>  
								</select>
							</div>
						</div>
				<?php /* 		
						<div class="form-group">
							<label for="inputPassword3" class="col-sm-2 control-label">Video</label>
							<div class="col-sm-6">
								<input type="file" name="video" id="video" class="form-control">
								<?php create_input("hidden","video_ant",$data_producto["video"],"",$table,$agregado); 
									if($data_producto["video"]!=""){ 
								?>
									<a href="<?php echo 'files/videos/'.$data_producto['id_sesion'].'/'.$data_producto["video"]; ?>" target="_blank">
										<img src="dist/img/icovideo.jpg"> Ver video {Click aquí}
									</a>
								<?php } ?> 
							</div>
						</div>
						
						<div class="form-group">
							<label for="inputPassword3" class="col-sm-2 control-label">Link video you</label>
							<div class="col-sm-6">
								<?php create_input("text","link",$data_producto["link"],"form-control",$table,"",$agregado); ?>
								<iframe frameborder="0" width="100%" height="200" class="lvideo"></iframe>
							</div>
						</div>
			*/ ?> 
			
						
						<div class="form-group">
							<label for="inputPassword3" class="col-sm-2 control-label">Link video VIMEO</label>
							<div class="col-sm-8">
                <p style="color:red;"> Ejem: https://player.vimeo.com/video/902606895?badge=0&autopause=0&player_id=0&app_id=58479   [ se extrae del iframe de vimeo ]</p>
								<?php create_input("text","link",$data_producto["link"],"form-control lleva_link_vimeo ",$table,"",$agregado); ?>
								<iframe frameborder="0" width="100%" height="200" class="video_vimeo "></iframe>
								<!-- 
								-->
							</div>
						</div>
						
						<div class="form-group">
							<label for="inputPassword3" class="col-sm-2 control-label">Link externo:</label>
							<div class="col-sm-8">
								<?php create_input("text","externo",$data_producto["externo"],"form-control ",$table,"",$agregado); ?>
								
							</div>
						</div>
						
						<div class="form-group">
              <label for="inputPassword3" class="col-sm-2 control-label">Duracion total en minutos (ejem: 90min)</label>
              <div class="col-sm-3">
                <?php create_input("text","duracion",$data_producto["duracion"],"form-control",$table," ") ; ?> <span style="float:right;">MIN</span>
              </div>
            </div>
          </div>
              <div class="box-footer">
                <div class="form-group">
                  <div class="col-sm-10 pull-right">
                    <input  type="submit"  class="btn bg-blue btn-flat" id="btnguardar" value="Guardar">
                    <button type="button" class="btn bg-red btn-flat" onclick="javascript:gotourl('<?php echo $link_detalle; ?>');">Cancelar</button>
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
}elseif($_GET["task"]=='drop' || $_GET["task"]=='dropselect'){
  $bd = new BD;
  $bd->Begin();
  $ide = !isset($_GET['id_detalle']) ? implode(',', $_GET['chkDel']) : $_GET['id_detalle'];
  $id_sesion2 = executesql("SELECT video FROM detalle_sesiones WHERE id_detalle IN(".$ide.")");
  if(!empty($id_sesion2)){
    foreach($id_sesion2 as $row2){
      $pfile2 = 'files/video/'.$row2['id_detalle'].'/'.$row2['video'];
      if(file_exists($pfile2) && !empty($row2['video'])){ unlink($pfile2); }
    }
  }
  
  $archivos = executesql("SELECT archivo FROM archivos_detalle_sesion_virtuals WHERE id_detalle IN(".$ide.")");
  if(!empty($archivos)){
    foreach($archivos as $row3){
      $pfile2 = 'files/files/'.$row3['id_detalle'].'/'.$row3['archivo'];
      if(file_exists($pfile2) && !empty($row3['archivo'])){ unlink($pfile2); }
    }
  }
  
  $bd->actualiza_("DELETE FROM archivos_detalle_sesion_virtuals WHERE id_detalle IN(".$ide.")");
  $bd->actualiza_("DELETE FROM detalle_sesiones WHERE id_detalle IN(".$ide.")");
  $bd->Commit();
  $bd->close();
	
	
}elseif($_GET["task"]=='ordenar'){
  $bd = new BD;
  $_GET['order'] = array_reverse($_GET['order']);
  foreach ($_GET['order'] as $order => $item) {
    $orden = $orden + 1;
    $bd->actualiza_("UPDATE detalle_sesiones SET orden= ".$orden." WHERE id_detalle = ".$item."");
  }
  $bd->Commit();
  $bd->close();
	
	
}elseif($_GET["task"]=='uestado_idestado'){
  $bd = new BD;
  $bd->Begin();
  $ide = !isset($_GET['id']) ? $_GET['estado_idestado'] : $_GET['id'];
  $ide = is_array($ide) ? implode(',',$ide) : $ide;
  $detalle_sesiones = executesql("SELECT * FROM detalle_sesiones WHERE id_detalle IN (".$ide.")");
  if(!empty($detalle_sesiones))
    foreach($detalle_sesiones as $reg => $item)
      if ($item['estado_idestado']==1) {
        $state = 2;
      }elseif ($item['estado_idestado']==2) {
        $state = 1;
      }
  $bd->actualiza_("UPDATE detalle_sesiones SET estado_idestado=".$state." WHERE id_detalle=".$ide."");
  echo $state;
  $bd->Commit();
  $bd->close();
	
	
}elseif($_GET["task"]=='fn_estado_eliminar_ocultar'){
  $bd = new BD;
  $bd->Begin();
  $ide = !isset($_GET['id']) ? $_GET['estado_idestado'] : $_GET['id'];
  $ide = is_array($ide) ? implode(',',$ide) : $ide;
  $detalle_sesiones = executesql("SELECT * FROM detalle_sesiones WHERE id_detalle IN (".$ide.")");
  if(!empty($detalle_sesiones))
    foreach($detalle_sesiones as $reg => $item)
        $state = 100;
  $bd->actualiza_("UPDATE detalle_sesiones SET estado_idestado=".$state." WHERE id_detalle=".$ide."");
  echo $state;
  $bd->Commit();
  $bd->close();
	
	
}elseif($_GET["task"]=='finder'){
  $sql = "SELECT cv.*, ss.id_curso, e.nombre AS estado FROM detalle_sesiones cv 
					INNER JOIN sesiones ss ON cv.id_sesion=ss.id_sesion  
					INNER JOIN cursos cc ON ss.id_curso=cc.id_curso   
					INNER JOIN estado e ON cv.estado_idestado=e.idestado  
					WHERE cv.estado_idestado !='100' 
					"; 
					
  if(!empty($_GET['criterio_mostrar'])) $porPagina=$_GET['criterio_mostrar'];
  if(!empty($_GET['criterio_usu_per'])){
    $stringlike=fn_filtro(substr($_GET['criterio_usu_per'], 0, 16));
    $sql.= " AND (cv.titulo LIKE '%".$stringlike."%')";
  }
  
	$sql.= " AND cv.id_sesion =".$_GET['id_sesion'];
  if(!empty($_GET['criterio_ordenar_por'])) $sql.= sprintf(" order by %s %s", fn_filtro($_GET['criterio_ordenar_por']), fn_filtro($_GET['criterio_orden']));
  $sql.= " ORDER BY cv.orden desc  ";
	
  $paging = new PHPPaging;
  $paging->agregarConsulta($sql); 
  $paging->div('div_listar');
  $paging->modo('desarrollo'); 
  $numregistro=1; 
  if($numregistro) $paging->porPagina(fn_filtro((int)$numregistro));
  $paging->verPost(true);
  $mantenerVar=array("id_sesion","criterio_mostrar","task","criterio_usu_per","criterio_ordenar_por","criterio_orden");
  $paging->mantenerVar($mantenerVar);
  $paging->porPagina(fn_filtro((int)$porPagina));
  $paging->ejecutar();
  $paging->pagina_proceso="detalle_sesiones.php";
?>
<table id="example1" class="table table-bordered table-striped">
  <thead>
    <tr role="row">
      <th class="unafbe" width="20"><input type="checkbox" id="chkDel" class="all"></th>
      <th class="sort">ORDEN</th>
      <th class="sort">TEMA</th>
      <th class="sort">Duración</th>
      <th class="sort cnone">Estado</th>
      <th class="unafbe btn_varios" >Opciones</th>
    </tr>
  </thead>
  <tbody id="sort">
<?php while ($detalles = $paging->fetchResultado()): ?>
    <tr id="order_<?php echo $detalles["id_detalle"]; ?>">
      <td><input type="checkbox" name="chkDel[]" class="chkDel" value="<?php echo $detalles["id_detalle"]; ?>"></td>
      <td><?php echo $detalles["orden"]; ?></td>
      <td><?php echo $detalles["titulo"]; ?></td>
      <td><?php echo !empty($detalles["duracion"])? $detalles["duracion"].'min':''; ?></td>
      <td class="cnone"><a href="javascript: fn_estado('<?php echo $detalles["id_detalle"]; ?>')"><?php echo $detalles["estado"]; ?></a></td>
      <td>
        <div class="btn-eai btns btr text-center ">
          <a href="<?php echo $_SESSION["base_url"].'&task=edit&id_detalle='.$detalles["id_detalle"]; ?>" title="Editar" style="color:#fff;"><i class="fa fa-edit"></i> editar</a>
					
        <?php if( $_SESSION["visualiza"]["idtipo_usu"] == 1 || $_SESSION["visualiza"]["idusuario"] == 64  || $_SESSION["visualiza"]["idusuario"] == 82 ){   // acesso soll a valeria y maricielo ?>
					<a href="index.php?page=archivos_detalle_sesion_virtuals&id_detalle=<?php echo $detalles['id_detalle']; ?>&module=<?php echo $_GET['module']; ?>&parenttab=<?php echo $_GET['parenttab']; ?>"  style="color:#fff;" title="Agregar Recursos" style="color:#fff;font-weight:800;"><i class="fa fa-file-o "></i> + Recursos</a>	 
        <?php } ?> 

          <!--  
					<a href="index.php?page=suscritos_x_cursos&id_curso=<?php echo $detalles['id_curso']; ?>&id_detalle=<?php echo $detalles['id_detalle']; ?>&module=<?php echo $detalles['module']; ?>&parenttab=<?php echo $detalles['parenttab']; ?>" title="Ver  usuarios" style="color:#fff;"><i class="fa fa-user"></i> alumnos</a> 
-->					
					
					<a href="javascript: fn_estado_eliminar_ocultar('<?php echo $detalles["id_detalle"]; ?>')"><i class="fa fa-trash-o "></i> </a>

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
  reordenar('detalle_sesiones.php');
});
var mypage = "detalle_sesiones.php";
</script>
<?php }else{ ?>
<div class="box-body">
  <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
    <form action="javascript: fn_buscar();" id="frm_buscar" name="frm_buscar">
      <input type="hidden" name="id_sesion" value="<?php echo $_GET['id_sesion']; ?>">
			<input type="hidden" name="module" value="<?php echo $_GET['module']; ?>">
      <input type="hidden" name="parenttab" value="<?php echo $_GET['parenttab']; ?>">
			
      <div class="bg-gray-light">
				<div class="col-sm-12">
          <?php  
						 $sql_x=" select c.id_curso, c.titulo as curso, s.titulo as sesion  from sesiones s  
													INNER JOIN cursos c  ON  s.id_curso=c.id_curso 
													WHERE s.id_sesion='".$_GET["id_sesion"]."' "; 
						$datoscurso=executesql($sql_x);
						
						$volver_al_curso="index.php?page=sesiones&id_curso=".$datoscurso[0]["id_curso"]."&module=".$_GET["module"]."&parenttab=".$_GET["parenttab"]."";
						
						echo "
									<h3 style='margin-top:0;padding-bottom:0;' > <small  style='color:#333;'><b> Clases</b> </small> </h3>
									<p style='margin-top:0;padding-bottom:1px;' >
											<b><small  style='color:#333;'> Curso: </small></b> 
											<span style='padding-left:7px;padding-right:7px;'>››</span> 
											<small> Modulo </small> 
									</p>
									<h3 style='margin-top:0;padding-bottom:20px;' >
											<b><small  style='color:#333;'> <a href='".$volver_al_curso."' > ".$datoscurso[0]["curso"]."</a></small></b> 
												<span style='padding-right:10px;padding-left:10px;'> ›› </span> 
											<small> ".$datoscurso[0]["sesion"]."</small>  </br> 
									</h3>";
					?>
        </div>
        <div class="col-sm-2">
          <div class="btn-eai">
            <a href="<?php echo $link_detalle."&task=new"; ?>" title="Agregar" style="color:#fff;"><i class="fa fa-file" style="padding-right:5px;"></i>Agregar</a>
          </div>
        </div>
        <div class="col-sm-4 criterio_buscar">         
          <?php create_input('text','criterio_usu_per','',"form-control pull-right",$table,'Placeholder="Buscar .."'); ?>
        </div>
        <div class="col-sm-3 criterio_mostrar">          
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
var us = "detalle";
var link = "detalle_sesione";
var ar = "la";
var l = "a";
var l2 = "a";
var pr = "La";
var id = "id_detalle";
var mypage = "detalle_sesiones.php";
</script>
<?php } ?>