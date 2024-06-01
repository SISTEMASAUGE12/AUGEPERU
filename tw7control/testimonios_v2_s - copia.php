<?php
error_reporting(E_ALL ^ E_NOTICE);
include ("auten.php");

if($_GET["task"]=='insert' || $_GET["task"]=='update'){
  $bd=new BD;
	$where = ($_GET["task"]=='update') ? "and id_testimonio!='".$_POST["id_testimonio"]."'" : '';
	$urlrewrite=armarurlrewrite($_POST["titulo"]);
  $urlrewrite=armarurlrewrite($urlrewrite,1,"testimonios_v2_s","id_testimonio","titulo_rewrite",$where);


$campos=array('id_cate','titulo',array('titulo_rewrite',$urlrewrite),'link','dni','region','ugel','nombre','ap_pa','ap_ma','competencia','puntaje_prueba','puntaje_trayectoria','puntaje_final','bonificacion_discapacidad','escala','estado_idestado'); 


  if($_GET["task"]=='insert'){
		if(isset($_FILES['imagen']) && !empty($_FILES['imagen']['name'])){
      $_POST['imagen'] = carga_imagen('files/images/testimonios_v2_s/','imagen','','480','210');
      $campos = array_merge($campos,array('imagen'));
    }
		
		if(isset($_FILES['imagen_video']) && !empty($_FILES['imagen_video']['name'])){
      $_POST['imagen_video'] = carga_imagen('files/images/testimonios_v2_s/','imagen_video','','400','234');
      $campos = array_merge($campos,array('imagen_video'));
    }
		
		if(isset($_FILES['imagen_fb']) && !empty($_FILES['imagen_fb']['name'])){
      $_POST['imagen_fb'] = carga_imagen('files/images/testimonios_v2_s/','imagen_fb','','','');
      $campos = array_merge($campos,array('imagen_fb'));
    }
    $_POST['orden'] = _orden_noticia("","testimonios_v2_s","");
    $bd->inserta_(arma_insert('testimonios_v2_s',array_merge($campos,array('orden')),'POST'));/*inserto hora -orden y guardo imag*/
		
		
  }else{
		 if(isset($_FILES['imagen']) && !empty($_FILES['imagen']['name'])){
      $path = 'files/images/testimonios_v2_s/'.$_POST['imagen_ant'];
      if( file_exists($path) && !empty($_POST['imagen_ant']) ) unlink($path);    
      $_POST['imagen'] = carga_imagen('files/images/testimonios_v2_s/','imagen','','480','210');
      $campos = array_merge($campos,array('imagen'));
    }

		if(isset($_FILES['imagen_video']) && !empty($_FILES['imagen_video']['name'])){
      $path = 'files/images/testimonios_v2_s/'.$_POST['imagen_ant_2'];
      if( file_exists($path) && !empty($_POST['imagen_ant_2']) ) unlink($path);    
      $_POST['imagen_video'] = carga_imagen('files/images/testimonios_v2_s/','imagen_video','','400','234');
      $campos = array_merge($campos,array('imagen_video'));
    }
		
		if(isset($_FILES['imagen_fb']) && !empty($_FILES['imagen_fb']['name'])){
      $path = 'files/images/testimonios_v2_s/'.$_POST['imagen_ant_3'];
      if( file_exists($path) && !empty($_POST['imagen_ant_3']) ) unlink($path);    
      $_POST['imagen_fb'] = carga_imagen('files/images/testimonios_v2_s/','imagen_fb','','','');
      $campos = array_merge($campos,array('imagen_fb'));
    }
		
    $bd->actualiza_(armaupdate('testimonios_v2_s',$campos," id_testimonio='".$_POST["id_testimonio"]."'",'POST'));/*actualizo*/
  }
  $bd->close();
  gotoUrl("index.php?page=".$_POST["nompage"]."&module=".$_POST["nommodule"]."&parenttab=".$_POST["nomparenttab"]);
	
}elseif($_GET["task"]=='new' || $_GET["task"]=='edit'){
  if($_GET["task"]=='edit'){
     $data_servicio=executesql("select * from testimonios_v2_s where id_testimonio='".$_GET["id_testimonio"]."'",0);
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
							
          <h4 class="box-title"><?php echo ($_GET["task"]=="edit") ? 'Editar' : 'Agregando'; ?> Testimonios </b> </h4>
        </div><!-- /.box-header -->
<?php $task_=$_GET["task"]; ?>
        <!-- form start -->
        <form id="registro" action="testimonios_v2_s.php?task=<?php echo ($task_=='edit') ?  "update" : "insert"; ?>" class="form-horizontal" method="POST" enctype="multipart/form-data" onsubmit="return aceptar()">
<?php 
if($task_=='edit') create_input("hidden","id_testimonio",$data_servicio["id_testimonio"],"",$table,"");
create_input("hidden","urlfailed",basename($_SERVER['REQUEST_URI']),"",$table,"");  
create_input("hidden","urlgo",$link_sesion,"",$table,"");
create_input("hidden","nompage",$_GET["page"],"",$table,""); 
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
              <label for="inputEmail3" class="col-sm-2 control-label">Categoria</label>
              <div class="col-sm-4">
                <?php crearselect("id_cate","select * from categorias_testimonios_v2_s where estado_idestado=1 order by orden asc",'class="form-control"',$data_servicio["id_cate"],""); ?>
              </div>
            </div>
            <div class="form-group">
              <label for="inputPassword3" class="col-sm-2 control-label">Título [nombre completo]</label>
              <div class="col-sm-8">
                <?php create_input("text","titulo",$data_servicio["titulo"],"form-control",$table,"",$agregado); ?>
              </div>
            </div>
						
						
						
						  <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Imágen docente: 176px ancho * 176px alto</label>
                  <div class="col-sm-6">
                    <input type="file" name="imagen" id="imagen" class="form-control">
                    <?php create_input("hidden","imagen_ant",$data_servicio["imagen"],"",$table,$agregado); 
                      if($data_servicio["imagen"]!=""){ 
                    ?>
                      <img src="<?php echo "files/images/testimonios_v2_s/".$data_servicio["imagen"]; ?>" width="200" class="mgt15">
                    <?php } ?> 
                      <small style="color:red">Recomendado: 176 x 176</small>
                  </div>
                </div>
								
								<div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Imágen si video: </br>400px ancho * 234px alto</label>
                  <div class="col-sm-6">
                    <input type="file" name="imagen_video" id="imagen_video" class="form-control">
                    <?php create_input("hidden","imagen_ant_2",$data_servicio["imagen_video"],"",$table,$agregado); 
                      if($data_servicio["imagen_video"]!=""){ 
                    ?>
                      <img src="<?php echo "files/images/testimonios_v2_s/".$data_servicio["imagen_video"]; ?>" width="200" class="mgt15">
                    <?php } ?> 
                      <small style="color:red">Recomendado: 400 x 234</small>
                  </div>
                </div>
               
								<div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Imágen si facebook: </br> 584px ancho maximo * 180px alto maximo</label>
                  <div class="col-sm-6">
                    <input type="file" name="imagen_fb" id="imagen_fb" class="form-control">
                    <?php create_input("hidden","imagen_ant_3",$data_servicio["imagen_fb"],"",$table,$agregado); 
                      if($data_servicio["imagen_fb"]!=""){ 
                    ?>
                      <img src="<?php echo "files/images/testimonios_v2_s/".$data_servicio["imagen_fb"]; ?>" width="200" class="mgt15">
                    <?php } ?> 
                      <small style="color:red">Recomendado: 584px ancho maximo * 180px alto maximo</small>
                  </div>
                </div>
						
						
						<div class="form-group">
              <label for="inputPassword3" class="col-sm-2 control-label">UGEL/DRE:</label>
              <div class="col-sm-8">
                <?php create_input("text","ugel",$data_servicio["ugel"],"form-control",$table,"",$agregado); ?>
              </div>
            </div>
						
						<div class="form-group">
              <label for="inputPassword3" class="col-sm-2 control-label">Region:</label>
              <div class="col-sm-8">
                <?php create_input("text","region",$data_servicio["region"],"form-control",$table,"",$agregado); ?>
              </div>
            </div>
						
				
						
						<div class="form-group">
              <label for="inputPassword3" class="col-sm-2 control-label">Competencia</label>
              <div class="col-sm-8">
                <?php create_input("text","competencia",$data_servicio["competencia"],"form-control",$table,"",$agregado); ?>
              </div>
            </div>
						
						<div class="form-group">
							<label for="inputPassword3" class="col-sm-2 control-label">Puntaje final:</label>
							<div class="col-sm-8">
								<?php create_input("text","puntaje_final",$data_servicio["puntaje_final"],"form-control",$table,"",$agregado); ?>
							</div>
						</div>
						
						
						<div class="form-group">
							<label for="inputPassword3" class="col-sm-2 control-label">bonificacion_discapacidad:</label>
							<div class="col-sm-8">
								<?php create_input("text","bonificacion_discapacidad",$data_servicio["bonificacion_discapacidad"],"form-control",$table,"",$agregado); ?>
							</div>
						</div>
						
						
               
							 
						<div class="form-group">
              <label for="inputPassword3" class="col-sm-2 control-label">DNI:</label>
              <div class="col-sm-8">
                <?php create_input("text","dni",$data_servicio["dni"],"form-control",$table,"",$agregado); ?>
              </div>
            </div>
						<div class="form-group">
              <label for="inputPassword3" class="col-sm-2 control-label">Nombres:</label>
              <div class="col-sm-8">
                <?php create_input("text","nombre",$data_servicio["nombre"],"form-control",$table,"",$agregado); ?>
              </div>
            </div>
						<div class="form-group">
              <label for="inputPassword3" class="col-sm-2 control-label">Apellido paterno:</label>
              <div class="col-sm-8">
                <?php create_input("text","ap_pa",$data_servicio["ap_pa"],"form-control",$table,"",$agregado); ?>
              </div>
            </div>
						<div class="form-group">
              <label for="inputPassword3" class="col-sm-2 control-label">Ap. materno Ugel</label>
              <div class="col-sm-8">
                <?php create_input("text","ap_ma",$data_servicio["ap_ma"],"form-control",$table,"",$agregado); ?>
              </div>
            </div>
						
				
						<div class="form-group">
              <label for="inputPassword3" class="col-sm-2 control-label">Puntaje prueba:</label>
              <div class="col-sm-8">
                <?php create_input("text","puntaje_prueba",$data_servicio["puntaje_prueba"],"form-control",$table,"",$agregado); ?>
              </div>
            </div>
						<div class="form-group">
							<label for="inputPassword3" class="col-sm-2 control-label">Puntaje trayectoria:</label>
							<div class="col-sm-8">
								<?php create_input("text","puntaje_trayectoria",$data_servicio["puntaje_trayectoria"],"form-control",$table,"",$agregado); ?>
							</div>
						</div>
				
							 
						<?php /*
						<div class="form-group">
								<label for="inputPassword3" class="col-sm-2 control-label">Descripción</label>
								<div class="col-sm-10">
									<?php create_input("textarea","descripcion",$data_servicio["descripcion"],"",$table,$agregado);  ?>
									<script>
									var editor11 = CKEDITOR.replace('descripcion');
									CKFinder.setupCKEditor( editor11, 'ckfinder/' );
									</script> 
								</div>
							</div>
					*/ ?>
					 
					 <div class="form-group">
							<label for="inputPassword3" class="col-sm-2 control-label">Link video vimeo:</label>
							<div class="col-sm-6">
								<?php create_input("text","link",$data_servicio["link"],"form-control",$table,"",$agregado); ?>
								<iframe frameborder="0" width="100%" height="200" class="video_vimeo"></iframe>
								<!-- 
								-->

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
}elseif($_GET["task"]=='drop' || $_GET["task"]=='dropselect'){
  $bd = new BD;
  $bd->Begin();
  $ide = !isset($_GET['id_testimonio']) ? implode(',', $_GET['chkDel']) : $_GET['id_testimonio'];
  // $id_curso2 = executesql("SELECT video FROM detalle_testimonios_v2_s WHERE id_testimonio IN(".$ide.")");

  $bd->actualiza_("DELETE FROM testimonios_v2_s WHERE id_testimonio IN(".$ide.")");
  $bd->Commit();
  $bd->close();

}elseif($_GET["task"]=='uestado'){
  $bd = new BD;
  $bd->Begin();
  $ide = !isset($_GET['id']) ? $_GET['estado_idestado'] : $_GET['id'];
  $ide = is_array($ide) ? implode(',',$ide) : $ide;
  $testimonios_v2_s = executesql("SELECT * FROM testimonios_v2_s WHERE id_testimonio IN (".$ide.")");
  if(!empty($testimonios_v2_s))
    foreach($testimonios_v2_s as $reg => $item)
      if ($item['estado_idestado']==1) {
        $state = 2;
      }elseif ($item['estado_idestado']==2) {
        $state = 1;
      }
  $bd->actualiza_("UPDATE testimonios_v2_s SET estado_idestado=".$state." WHERE id_testimonio=".$ide."");
  echo $state;
  $bd->Commit();
  $bd->close();
	
}elseif($_GET["task"]=='finder'){
  $sql = "SELECT cv.*,e.nombre AS estado , ct.titulo as categoria 
					FROM testimonios_v2_s cv 
					INNER JOIN categorias_testimonios_v2_s ct ON cv.id_cate=ct.id_cate  
					INNER JOIN estado e ON cv.estado_idestado=e.idestado
					WHERE cv.estado_idestado=e.idestado 
					"; 
  if(!empty($_GET['criterio_mostrar'])) $porPagina=$_GET['criterio_mostrar'];
	
 
	if(!empty($_GET['criterio_usu_per'])){
    $stringlike=fn_filtro(substr($_GET['criterio_usu_per'], 0, 16));
    $sql.= " AND (cv.titulo LIKE '%".$stringlike."%')";
  }
  
	if(!empty($_GET['id_cate'])){
		$sql.= " AND cv.id_cate ='".$_GET["id_cate"]."' ";
  }
	
  if(!empty($_GET['criterio_ordenar_por'])) $sql.= sprintf(" order by %s %s", fn_filtro($_GET['criterio_ordenar_por']), fn_filtro($_GET['criterio_orden']));
  $sql.= " ORDER BY cv.id_testimonio ASC";
	
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
  $paging->pagina_proceso="testimonios_v2_s.php";
?>
<table id="example1" class="table table-bordered table-striped">
  <thead>
    <tr role="row">
      <th class="sort">#</th>
      <th class="sort">Testimonio</th>
      <th class="sort">Categoria</th>
      <th class="sort">IMG</th>
      <th class="sort">IMG video</th>
      <th class="sort">IMG FB</th>
      <th class="sort">LINK</th>
      <th class="sort cnone">ESTADO</th>
      <th class="unafbe " width="120">Opciones</th>
    </tr>
  </thead>
  <tbody id="sort">
<?php  $i=0;
	while ($detalles = $paging->fetchResultado()): 
			$i++; 
	?>
    <tr> 
      <td><?php echo $i; ?></td>
      <td><?php echo $detalles["titulo"]; ?></td>
      <td><?php echo $detalles["categoria"]; ?></td>
      <td><?php echo !empty($detalles["imagen"])?'SI':''; ?></td>
      <td><?php echo !empty($detalles["imagen_video"])?'SI':''; ?></td>
      <td><?php echo !empty($detalles["imagen_fb"])?'SI':''; ?></td>
      <td><a href="<?php echo $detalles["link"]; ?>" target="_blank"> link </a></td>
      <td class="cnone"><a href="javascript: fn_estado('<?php echo $detalles["id_testimonio"]; ?>')"><?php echo $detalles["estado"]; ?></a></td>
      <td>
        <div class="btn-eai btns btr  text-center ">
          <a href="<?php echo $_SESSION["base_url"].'&task=edit&id_testimonio='.$detalles["id_testimonio"]; ?>" title="Editar"  style="color:#fff;"><i class="fa fa-edit"></i> editar</a>
			<?php  if($_SESSION["visualiza"]["idtipo_usu"] ==1){ ?>	 
				 <a href="javascript: fn_eliminar('<?php echo $detalles["id_testimonio"]; ?>')" style="color:#fff;" title="Eliminar Sessión"><i class="fa fa-trash-o"></i></a>
				 <?php } ?> 									

<!--          
--> 
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
  reordenar('testimonios_v2_s.php');
});
var mypage = "testimonios_v2_s.php";
</script>
<?php }else{ ?>
<div class="box-body">
  <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
    <form action="javascript: fn_buscar();" id="frm_buscar" name="frm_buscar">
      <input type="hidden" name="module" value="<?php echo $_GET['module']; ?>">
      <input type="hidden" name="parenttab" value="<?php echo $_GET['parenttab']; ?>">
      <div class="bg-gray-light">      
        <div class="col-sm-12">
          <?php   
						echo "<h3 style='margin:0;' ><small> <b style='color:#333;'>Testimonios :</b> </small></h3>";
					
					?>
        </div>
				
				<div class="col-sm-3">
          <div class="btn-eai">
            <a href="<?php echo $link_sesion."&task=new"; ?>" title="Agregar" style="color:#fff;"><i class="fa fa-file" style="padding-right:5px;"></i>Agregar</a> 
            <a href="../zzz_excel/testimonios.php" title="Agregar excel"  target="_blank" style="color:#fff;">
							<i class="fa fa-file" style="padding-right:5px;"></i>cargar EXCEL
						</a> 
          </div>
        </div>
			
				<div class="col-sm-3">
					<?php crearselect("id_cate","select * from categorias_testimonios_v2_s where estado_idestado=1 order by orden asc",'class="form-control"',''," -- categoria --"); ?>
				</div>
							
        <div class="col-sm-3 ">          
          <?php create_input('text','criterio_usu_per','',"form-control pull-right",$table,'placeholder="Buscar .."'); ?>
        </div>
        <div class="col-sm-1 ">          
          <?php select_sql("nregistros"); ?>
        </div>
        <div class="col-sm-1">          
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
var us = "testimonio";
var link = "testimonios_v2_";
var ar = "la";
var l = "a";
var l2 = "a";
var pr = "La";
var id = "id_testimonio";
var mypage = "testimonios_v2_s.php";
</script>
<?php } ?>