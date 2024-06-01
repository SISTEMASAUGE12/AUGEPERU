<?php
error_reporting(E_ALL ^ E_NOTICE);
include ("auten.php");

if($_GET["task"]=='insert' || $_GET["task"]=='update'){
  $bd=new BD;

  if( $_SESSION["visualiza"]["idtipo_usu"] == 1 || $_SESSION["visualiza"]["idtipo_usu"] == 8 ){  
      $where = ($_GET["task"]=='update') ? "and id_tutorial!='".$_POST["id_tutorial"]."'" : '';
      $urlrewrite=armarurlrewrite($_POST["titulo"]);
      $urlrewrite=armarurlrewrite($urlrewrite,1,"tutoriales","id_tutorial","titulo_rewrite",$where);
      
    // $campos=array('titulo',array('titulo_rewrite',$urlrewrite),'descripcion','link','estado_idestado'); /*inserto campos principales*/
    $campos=array('tipo','titulo',array('titulo_rewrite',$urlrewrite),'link','estado_idestado'); /*inserto campos principales*/

      if($_GET["task"]=='insert'){
        if(isset($_FILES['imagen']) && !empty($_FILES['imagen']['name'])){
          $_POST['imagen'] = carga_imagen('files/images/tutoriales/','imagen','','480','210');
          $campos = array_merge($campos,array('imagen'));
        }
        $_POST['orden'] = _orden_noticia("","tutoriales","");
        $bd->inserta_(arma_insert('tutoriales',array_merge($campos,array('orden')),'POST'));/*inserto hora -orden y guardo imag*/
      }else{
        if(isset($_FILES['imagen']) && !empty($_FILES['imagen']['name'])){
          $path = 'files/images/tutoriales/'.$_POST['imagen_ant'];
          if( file_exists($path) && !empty($_POST['imagen_ant']) ) unlink($path);    
          $_POST['imagen'] = carga_imagen('files/images/tutoriales/','imagen','','480','210');
          $campos = array_merge($campos,array('imagen'));
        }
        $bd->actualiza_(armaupdate('tutoriales',$campos," id_tutorial='".$_POST["id_tutorial"]."'",'POST'));/*actualizo*/
      }
      $bd->close();
      gotoUrl("index.php?page=".$_POST["nompage"]."&module=".$_POST["nommodule"]."&parenttab=".$_POST["nomparenttab"]."&tipo=".$_POST["tipo"]);
  
  } // solo puede registrar y editar el admin y el solo_nblog


}elseif($_GET["task"]=='new' || $_GET["task"]=='edit'){
  if($_GET["task"]=='edit'){
     $data_servicio=executesql("select * from tutoriales where id_tutorial='".$_GET["id_tutorial"]."'",0);
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
          <h4 class="box-title"><?php echo ($_GET["task"]=="edit") ? 'Editar' : 'Agregando'; ?> VIDEOTUTORIALES: <b><?php echo ($_GET["tipo"]==1)?'Clientes':'Personal Auge'; ?> <?php echo $datoscurso["titulo"]; ?>  </b> </h4>

          <p style="color:red;">*Ubicacion:  Esta configuración afecta a la portada de la web. Ruta: <?php echo $_dominio; ?>/tutoriales</p>

        </div><!-- /.box-header -->
<?php $task_=$_GET["task"]; ?>
        <!-- form start -->
        <form id="registro" action="tutoriales.php?task=<?php echo ($task_=='edit') ?  "update" : "insert"; ?>" class="form-horizontal" method="POST" enctype="multipart/form-data" onsubmit="return aceptar()">
<?php 
if($task_=='edit') create_input("hidden","id_tutorial",$data_servicio["id_tutorial"],"",$table,"");
create_input("hidden","urlfailed",basename($_SERVER['REQUEST_URI']),"",$table,"");  
create_input("hidden","urlgo",$link_tutoriales,"",$table,"");
create_input("hidden","nompage",$_GET["page"],"",$table,""); 
create_input("hidden","nommodule",$_GET["module"],"",$table,"");
create_input("hidden","nomparenttab",$_GET["parenttab"],"",$table,"");
create_input("hidden","tipo",$_GET["tipo"],"",$table,"");
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
                  <label for="inputPassword3" class="col-sm-2 control-label">Imágen : 480px ancho * 210px alto</label>
                  <div class="col-sm-6">
                    <input type="file" name="imagen" id="imagen" class="form-control">
                    <?php create_input("hidden","imagen_ant",$data_servicio["imagen"],"",$table,$agregado); 
                      if($data_servicio["imagen"]!=""){ 
                    ?>
                      <img src="<?php echo "files/images/tutoriales/".$data_servicio["imagen"]; ?>" width="200" class="mgt15">
                    <?php } ?> 
                      <small style="color:red">Recomendado: 480 x 210</small>
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
                <p style="color:red;"> ejem: https://player.vimeo.com/video/700554130 </p>
								<?php create_input("text","link",$data_servicio["link"],"form-control lleva_link_vimeo ",$table,"",$agregado); ?>
								<iframe frameborder="0" width="100%" height="200" class="video_vimeo "></iframe>
								<!-- 
								-->

							</div>
						</div>
                
								
          </div>
              <div class="box-footer">
                <div class="form-group">
                  <div class="col-sm-10 pull-right">
                <?php   if( $_SESSION["visualiza"]["idtipo_usu"] == 1 || $_SESSION["visualiza"]["idtipo_usu"] == 8 ){  ?>
                    <input  type="submit"  class="btn bg-blue btn-flat" id="btnguardar" value="Guardar">
                <?php } ?>
                    <button type="button" class="btn bg-red btn-flat" onclick="javascript:gotourl('<?php echo $link_tutoriales; ?>');">CERRAR</button>
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
  $ide = !isset($_GET['id_tutorial']) ? implode(',', $_GET['chkDel']) : $_GET['id_tutorial'];
  // $id_curso2 = executesql("SELECT video FROM detalle_tutoriales WHERE id_tutorial IN(".$ide.")");

  $bd->actualiza_("DELETE FROM tutoriales WHERE id_tutorial IN(".$ide.")");
  $bd->Commit();
  $bd->close();

}elseif($_GET["task"]=='uestado'){
  $bd = new BD;
  $bd->Begin();
  $ide = !isset($_GET['id']) ? $_GET['estado_idestado'] : $_GET['id'];
  $ide = is_array($ide) ? implode(',',$ide) : $ide;
  $tutoriales = executesql("SELECT * FROM tutoriales WHERE id_tutorial IN (".$ide.")");
  if(!empty($tutoriales))
    foreach($tutoriales as $reg => $item)
      if ($item['estado_idestado']==1) {
        $state = 2;
      }elseif ($item['estado_idestado']==2) {
        $state = 1;
      }
  $bd->actualiza_("UPDATE tutoriales SET estado_idestado=".$state." WHERE id_tutorial=".$ide."");
  echo $state;
  $bd->Commit();
  $bd->close();
	

}elseif($_GET["task"]=='finder'){

  $sql = "SELECT cv.*,e.nombre AS estado FROM tutoriales cv INNER JOIN estado e ON cv.estado_idestado=e.idestado 
          WHERE cv.tipo='".$_GET["tipo"]."'  "; 

  if(!empty($_GET['criterio_mostrar'])) $porPagina=$_GET['criterio_mostrar'];
  if(!empty($_GET['criterio_usu_per'])){
    $stringlike=fn_filtro(substr($_GET['criterio_usu_per'], 0, 16));
    $sql.= " AND (cv.titulo LIKE '%".$stringlike."%')";
  }
  
  if(!empty($_GET['criterio_ordenar_por'])) $sql.= sprintf(" order by %s %s", fn_filtro($_GET['criterio_ordenar_por']), fn_filtro($_GET['criterio_orden']));
  $sql.= " ORDER BY cv.orden ASC";
	
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
  $paging->pagina_proceso="tutoriales.php";
?>
<table id="example1" class="table table-bordered table-striped">
  <thead>
    <tr role="row">
      <th class="sort">#</th>
      <th class="sort">TUTORIAL</th>
      <th class="sort">IMG</th>
      <th class="sort">LINK</th>
      <th class="sort cnone">ESTADO</th>
      <th class="unafbe btn_varios">Opciones</th>
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
      <td><?php echo !empty($detalles["imagen"])?'SI':''; ?></td>
      <td><a href="<?php echo $detalles["link"]; ?>" target="_blank"> link </a></td>
      <td class="cnone"><a href="javascript: fn_estado('<?php echo $detalles["id_tutorial"]; ?>')"><?php echo $detalles["estado"]; ?></a></td>
      <td>
        <div class="btn-eai btns btr btn_varios text-center ">
          <a href="<?php echo $_SESSION["base_url"].'&task=edit&id_tutorial='.$detalles["id_tutorial"]; ?>" title="Editar"  style="color:#fff;"><i class="fa fa-edit"></i> editar</a>

			<?php  if($_SESSION["visualiza"]["idtipo_usu"] ==1){ ?>	 
				 <a href="javascript: fn_eliminar('<?php echo $detalles["id_tutorial"]; ?>')" style="color:#fff;" title="Eliminar Sessión"><i class="fa fa-trash-o"></i></a>
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
  reordenar('tutoriales.php');
});
var mypage = "tutoriales.php";
</script>
<?php }else{ ?>
<div class="box-body">
  <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
    <form action="javascript: fn_buscar();" id="frm_buscar" name="frm_buscar">
      <input type="hidden" name="module" value="<?php echo $_GET['module']; ?>">
      <input type="hidden" name="parenttab" value="<?php echo $_GET['parenttab']; ?>">
      <input type="hidden" name="tipo" value="<?php echo $_GET['tipo']; ?>">
      <div class="bg-gray-light">      
        <div class="col-sm-12">
          <?php   

						echo "<h3 style='margin:0;' ><small> <b style='color:#333;'>Video tutoriales: ".(($_GET["tipo"]==1)?'Clientes':' Personal Auge ')."</b> </small></h3>";
					
					?>
        </div>
<?php 
    if( $_SESSION["visualiza"]["idtipo_usu"] == 1 || $_SESSION["visualiza"]["idtipo_usu"] == 8 ){   
  ?>
				<div class="col-sm-2">
          <div class="btn-eai">
            <a href="<?php echo $link_tutoriales."&task=new"; ?>" title="Agregar" style="color:#fff;"><i class="fa fa-file" style="padding-right:5px;"></i>Agregar</a> 
          </div>
        </div>
  <?php } ?>
  
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
var us = "tutorial";
var link = "tutoriale";
var ar = "la";
var l = "a";
var l2 = "a";
var pr = "La";
var id = "id_tutorial";
var mypage = "tutoriales.php";
</script>
<?php } ?>