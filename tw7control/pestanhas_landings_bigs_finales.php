<?php 
error_reporting(E_ALL ^ E_NOTICE);
include ("auten.php");

if($_GET["task"]=='insert' || $_GET["task"]=='update'){
  $bd=new BD;
	$where = ($_GET["task"]=='update') ? "and id_pesta!='".$_POST["id_pesta"]."'" : '';
	$urlrewrite=armarurlrewrite($_POST["titulo"]);
  $urlrewrite=armarurlrewrite($urlrewrite,1,"pestanhas_landings_bigs_finales","id_pesta","titulo_rewrite",$where);
	
	$dir='files/images/landings_bigs/'.$_POST['id_big'].'/';

	$campos=array('id_big','titulo',array('titulo_rewrite',$urlrewrite),'descripcion','detalle_2', 'link_video','texto_boton','texto_2_boton','href_boton','estado_idestado','color_fondo','color_titulo','color_texto','color_fondo_btn','color_texto_btn'); /*inserto campos principales*/
  
  if($_GET["task"]=='insert'){
		if(isset($_FILES['imagen']) && !empty($_FILES['imagen']['name'])){
      $_POST['imagen'] = carga_imagen($dir,'imagen','','','');
      $campos = array_merge($campos,array('imagen'));
    }
    $_POST['orden'] = _orden_noticia("","pestanhas_landings_bigs_finales","");
    $bd->inserta_(arma_insert('pestanhas_landings_bigs_finales',array_merge($campos,array('orden')),'POST'));/*inserto hora -orden y guardo imag*/
  
	}else{
		if(isset($_FILES['imagen']) && !empty($_FILES['imagen']['name'])){
      $path = $dir.$_POST['imagen_ant'];
      if( file_exists($path) && !empty($_POST['imagen_ant']) ) unlink($path);    
      $_POST['imagen'] = carga_imagen($dir,'imagen','','','');
      $campos = array_merge($campos,array('imagen'));
    }
	

    $bd->actualiza_(armaupdate('pestanhas_landings_bigs_finales',$campos," id_pesta='".$_POST["id_pesta"]."'",'POST'));/*actualizo*/
  }

  $bd->close();
  gotoUrl("index.php?page=".$_POST["nompage"]."&id_big=".$_POST["id_big"]."&module=".$_POST["nommodule"]."&parenttab=".$_POST["nomparenttab"]);
	
}elseif($_GET["task"]=='new' || $_GET["task"]=='edit'){
  if($_GET["task"]=='edit'){
     $data_servicio=executesql("select * from pestanhas_landings_bigs_finales where id_pesta='".$_GET["id_pesta"]."'",0);
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
				 <?php   $sql_x=" select * from landings_bigs where id_big='".$_GET["id_big"]."' "; 
						$datoscurso=executesql($sql_x,0); 
					?>				
          <h4 class="box-title"><?php echo ($_GET["task"]=="edit") ? 'Editar' : 'Agregando'; ?> Sección landing big: <b><?php echo $datoscurso["titulo"]; ?> </b> </h4>
        </div><!-- /.box-header -->
<?php $task_=$_GET["task"]; ?>
        <!-- form start -->
        <form id="registro" action="pestanhas_landings_bigs_finales.php?task=<?php echo ($task_=='edit') ?  "update" : "insert"; ?>" class="form-horizontal" method="POST" enctype="multipart/form-data" onsubmit="return aceptar()">
<?php 
if($task_=='edit') create_input("hidden","id_pesta",$data_servicio["id_pesta"],"",$table,"");
create_input("hidden","urlfailed",basename($_SERVER['REQUEST_URI']),"",$table,"");  
create_input("hidden","urlgo",$link_info_landing_bigs,"",$table,"");
create_input("hidden","nompage",$_GET["page"],"",$table,""); 
create_input("hidden","id_big",$_GET["id_big"],"",$table,""); 
create_input("hidden","nommodule",$_GET["module"],"",$table,"");
create_input("hidden","nomparenttab",$_GET["parenttab"],"",$table,"");
?>
          <div class="box-body">
            <div class="form-group">
              <label for="inputEmail3" class="col-sm-2 control-label">Estado</label>
              <div class="col-sm-4">
                <?php crearselect("estado_idestado","select * from estado where idestado in('1','2') order by 2 desc",'class="form-control"',$data_servicio["estado_idestado"],""); ?>
              </div>
            </div>
            <div class="form-group">
              <label for="inputPassword3" class="col-sm-2 control-label">Título</label>
              <div class="col-sm-8">
                <?php create_input("textarea","titulo",$data_servicio["titulo"],"form-control",$table,"",$agregado); ?>
              </div>
            </div>
						  <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Descripción</label>
                  <div class="col-sm-10">
                    <?php create_input("textarea","descripcion",$data_servicio["descripcion"],"",$table,$agregado);  ?>
                    <script>
                    var editor11 = CKEDITOR.replace('descripcion');
                    CKFinder.setupCKEditor( editor11, 'ckfinder/' );
                    CKEDITOR.config.height = 800;

                    </script> 
                  </div>
                </div>
								
						<div class="form-group">
							<label for="inputPassword3" class="col-sm-2 control-label">Imágen :</label>
							<div class="col-sm-6">
								<input type="file" name="imagen" id="imagen" class="form-control">
								<?php create_input("hidden","imagen_ant",$data_servicio["imagen"],"",$table,$agregado); 
									if($data_servicio["imagen"]!=""){ 
								?>
									<img src="<?php echo "files/images/landings_bigs/".$data_servicio['id_big']."/".$data_servicio["imagen"]; ?>" width="200" class="mgt15">
								<?php } ?> 
							</div>
						</div>
            
            <div class="form-group">
							<label for="inputPassword3" class="col-sm-2 control-label">Link video VIMEO </br> * va debajo de la imagen en caso existan las 2</label>
							<div class="col-sm-8">
								<?php create_input("text","link_video",$data_servicio["link_video"],"form-control lleva_link_vimeo ",$table,"",$agregado); ?>
								<iframe frameborder="0" width="100%" height="200" class="video_vimeo "></iframe>
								<!-- 
								-->
							</div>
						</div>



            <div class="form-group">
              <label for="inputPassword3" class="col-sm-2 control-label">Descripción 2 -debajo imagen</label>
              <div class="col-sm-10">
                <?php create_input("textarea","detalle_2",$data_servicio["detalle_2"],"height:800px;",$table,'');  ?>
                <script>
                var detalle_2 = CKEDITOR.replace('detalle_2');
                CKFinder.setupCKEditor( detalle_2, 'ckfinder/' );
                </script> 
              </div>
            </div>
								
            <h3 style="padding-top:30px;">Boton acción: [ algun link en especial]</h3>								
            <div class="form-group">
              <label for="inputPassword3" class="col-md-2 col-sm-2 control-label"> Titulo Boton acción:</label>
              <div class="col-sm-6">
                <?php create_input("text","texto_boton",$data_servicio["texto_boton"],"form-control",$table,"",$agregado); ?>
              </div>
            </div>
            <div class="form-group">  
              <label for="inputPassword3" class="col-md-2 col-sm-2 control-label"> sub_Titulo Boton:</label>
              <div class="col-sm-6">
                <?php create_input("text","texto_2_boton",$data_servicio["texto_2_boton"],"form-control",$table,"",$agregado); ?>
              </div>
            </div>
            <div class="form-group">
              <label for="inputPassword3" class="col-md-2 col-sm-2 control-label">Link boton acción:</label>
              <div class="col-sm-6">
                <?php create_input("text","href_boton",$data_servicio["href_boton"],"form-control",$table,"",$agregado); ?>
              </div>
            </div>	
            <div class="form-group">
              <label for="inputPassword3" class="col-md-2 col-sm-2 control-label"> Color fondo  : #333333</label>
              <div class="col-sm-6">
                <?php create_input("text","color_fondo_btn",$data_servicio["color_fondo_btn"],"form-control color-picker",$table," ",' maxlength="7" size="7"'); ?>
              </div>
            </div>
            <div class="form-group">
              <label for="inputPassword3" class="col-md-2 col-sm-2 control-label"> Color texto  : #333333</label>
              <div class="col-sm-6">
                <?php create_input("text","color_texto_btn",$data_servicio["color_texto_btn"],"form-control color-picker",$table," ",' maxlength="7" size="7"'); ?>
              </div>
            </div>	
            



            <h3 style="padding-top:30px;"> Si el fondo sera de otro color: </br> fondo azul degradado copiar =>  linear-gradient(180deg, #042956 0%, #000 100%);</h3>								
            <div class="form-group">
              <label for="inputPassword3" class="col-md-2 col-sm-2 control-label"> Color fondo  *opcional:</label>
              <div class="col-sm-6">
                <?php create_input("text","color_fondo",$data_servicio["color_fondo"],"form-control color-picker",$table," ",'  '); ?>
              </div>
            </div>
            <div class="form-group">
              <label for="inputPassword3" class="col-md-2 col-sm-2 control-label"> Color titulo  : #333333</label>
              <div class="col-sm-6">
                <?php create_input("text","color_titulo",$data_servicio["color_titulo"],"form-control color-picker",$table," ",' maxlength="7" size="7"'); ?>
              </div>
            </div>
            <div class="form-group">
              <label for="inputPassword3" class="col-md-2 col-sm-2 control-label"> Color texto  : #333333</label>
              <div class="col-sm-6">
                <?php create_input("text","color_texto",$data_servicio["color_texto"],"form-control color-picker",$table," ",' maxlength="7" size="7"'); ?>
              </div>
            </div>
            
          </div>
              <div class="box-footer">
                <div class="form-group">
                  <div class="col-sm-10 pull-right">
                    <input  type="submit"  class="btn bg-blue btn-flat" id="btnguardar" value="Guardar">
                    <button type="button" class="btn bg-red btn-flat" onclick="javascript:gotourl('<?php echo $link_info_landing_bigs; ?>');">Cancelar</button>
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
  $ide = !isset($_GET['id_pesta']) ? implode(',', $_GET['id_pesta']) : $_GET['id_pesta'];
  
	 $sql_="SELECT * FROM pestanhas_landings_bigs_finales WHERE id_pesta IN(".$ide.")";
	
	$pestanhas_landings_bigs_finales = executesql($sql_);
  if(!empty($pestanhas_landings_bigs_finales)){
    foreach($pestanhas_landings_bigs_finales as $row){
      // $pfile = 'files/images/pestanhas_landings_bigs_finales/'.$row['imagen']; if(file_exists($pfile) && !empty($row['imagen'])){ unlink($pfile); }
    }
  }

  $bd->actualiza_("DELETE FROM pestanhas_landings_bigs_finales WHERE id_pesta IN(".$ide.")");
  $bd->Commit();
  $bd->close();
	

}elseif($_GET["task"]=='uestado'){
  $bd = new BD;
  $bd->Begin();
  $ide = !isset($_GET['estado_idestado']) ? $_GET['estado_idestado'] : $_GET['estado_idestado'];
  $ide = is_array($ide) ? implode(',',$ide) : $ide;
  $pestanhas_landings_bigs_finales = executesql("SELECT * FROM pestanhas_landings_bigs_finales WHERE id_pesta IN (".$ide.")");
  if(!empty($pestanhas_landings_bigs_finales))
    foreach($pestanhas_landings_bigs_finales as $reg => $item)
      if ($item['estado_idestado']==1) {
        $state = 2;
      }elseif ($item['estado_idestado']==2) {
        $state = 1;
      }
  $bd->actualiza_("UPDATE pestanhas_landings_bigs_finales SET estado_idestado=".$state." WHERE id_pesta=".$ide."");
  echo $state;
  $bd->Commit();
  $bd->close();
	
	
}elseif($_GET["task"]=='finder'){
  $sql = "SELECT cv.*,e.nombre AS estado FROM pestanhas_landings_bigs_finales cv INNER JOIN estado e ON cv.estado_idestado=e.idestado "; 
  if(!empty($_GET['criterio_mostrar'])) $porPagina=$_GET['criterio_mostrar'];
  if(!empty($_GET['criterio_usu_per'])){
    $stringlike=fn_filtro(substr($_GET['criterio_usu_per'], 0, 16));
    $sql.= " AND (cv.titulo LIKE '%".$stringlike."%')";
  }
  
	$sql.= " AND cv.id_big =".$_GET['id_big'];
  if(!empty($_GET['criterio_ordenar_por'])) $sql.= sprintf(" order by %s %s", fn_filtro($_GET['criterio_ordenar_por']), fn_filtro($_GET['criterio_orden']));
  $sql.= " ORDER BY cv.orden desc ";
  $paging = new PHPPaging;
  $paging->agregarConsulta($sql); 
  $paging->div('div_listar');
  $paging->modo('desarrollo'); 
  $numregistro=1; 
  if($numregistro) $paging->porPagina(fn_filtro((int)$numregistro));
  $paging->verPost(true);
  $mantenerVar=array("id_big","criterio_mostrar","task","criterio_usu_per","criterio_ordenar_por","criterio_orden");
  $paging->mantenerVar($mantenerVar);
  $paging->porPagina(fn_filtro((int)$porPagina));
  $paging->ejecutar();
  $paging->pagina_proceso="pestanhas_landings_bigs_finales.php";
?>
<table id="example1" class="table table-bordered table-striped">
  <thead>
    <tr role="row">
      <th class="unafbe" width="20"><input type="checkbox" id="chkDel" class="all"></th>
      <th class="sort">ORDEN</th>
      <th class="sort">Pestaña</th>
      <th class="sort cnone">IMG</th>
      <th class="sort cnone">ESTADO</th>
      <th class="unafbe btn_varios">Opciones</th>
    </tr>
  </thead>
  <tbody id="sort">
<?php while ($detalles = $paging->fetchResultado()): ?>
    <tr>
      <td><input type="checkbox" name="chkDel[]" class="chkDel" value="<?php echo $detalles["id_pesta"]; ?>"></td>
      <td><?php echo $detalles["orden"]; ?></td>
      <td><?php echo $detalles["titulo"]; ?></td>
      <td><?php echo !empty($detalles["imagen"])?'SI':'NO'; ?></td>
      <td class="cnone"><a href="javascript: fn_estado('<?php echo $detalles["id_pesta"]; ?>')"><?php echo $detalles["estado"]; ?></a></td>
      <td>
        <div class="btn-eai btns btr btn_varios text-center ">
          <a href="<?php echo $_SESSION["base_url"].'&task=edit&id_pesta='.$detalles["id_pesta"]; ?>" title="Editar"  style="color:#fff;"><i class="fa fa-edit"></i> editar</a>
					
				 <a href="javascript: fn_eliminar('<?php echo $detalles["id_pesta"]; ?>')" style="color:#fff;" title="Eliminar Sessión"><i class="fa fa-trash-o"></i></a>
				 
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
  reordenar('pestanhas_landings_bigs_finales.php');
});
var mypage = "pestanhas_landings_bigs_finales.php";
</script>
<?php }else{ ?>
<div class="box-body">
  <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
    <form action="javascript: fn_buscar();" id="frm_buscar" name="frm_buscar">
      <input type="hidden" name="id_big" value="<?php echo $_GET['id_big']; ?>">
      <input type="hidden" name="module" value="<?php echo $_GET['module']; ?>">
      <input type="hidden" name="parenttab" value="<?php echo $_GET['parenttab']; ?>">
      <div class="bg-gray-light">      
        <div class="col-sm-12">
          <?php   $sql_x=" select * from landings_bigs where id_big='".$_GET["id_big"]."' "; 
						$datoscurso=executesql($sql_x,0);
						// $volver_al_curso="index.php?page=landings_bigs&module=".$_GET["module"]."&parenttab=".$_GET["parenttab"]."";

						echo "<h3 style='margin:0;' ><small> <b style='color:#333;'>Contenido de Presentación al final del evento :</b> </small></h3>";
						echo "<h3 style='margin-top:0;padding-top:0;padding-bottom:10px;' ><small> <b style='color:#555;'>Landing BIg</b> : ".$datoscurso["id_big"].' - '.$datoscurso["titulo"]." </small></h3>";
					?>
        </div>
				
				<div class="col-sm-2">
          <div class="btn-eai">
            <a href="<?php echo $link_info_landing_bigs."&task=new"; ?>" title="Agregar" style="color:#fff;"><i class="fa fa-file" style="padding-right:5px;"></i>Agregar</a> 
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
var us = "seccion";
var link = "pestanhas_landings_bigs_finale";
var ar = "la";
var l = "a";
var l2 = "a";
var pr = "La";
var id = "id_pesta";
var mypage = "pestanhas_landings_bigs_finales.php";
</script>
<?php } ?>