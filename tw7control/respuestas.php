<?php error_reporting(E_ALL ^ E_NOTICE);
include ("auten.php");

if($_GET["task"]=='insert' || $_GET["task"]=='update'){
  $bd=new BD;
	$where = ($_GET["task"]=='update') ? "and id_rpta!='".$_POST["id_rpta"]."'" : '';
	$urlrewrite=armarurlrewrite($_POST["titulo"]);
  $urlrewrite=armarurlrewrite($urlrewrite,1,"respuestas","id_rpta","titulo_rewrite",$where);
	
	$_POST['fecha_actualizacion'] = fecha_hora(2);
	// $dir='files/images/imagenes/'.$_POST['id_examen'].'/'.$_POST['id_pregunta'].'/';
	// $dir='files/images/imagenes/'.$_POST['id_pregunta'].'/';
	$dir='files/images/imagenes/';
	// echo "SEE";
	
	// $campos=array('id_pregunta','id_examen','titulo',array('titulo_rewrite',$urlrewrite),'descripcion','estado_rpta','fecha_actualizacion','estado_idestado'); /*inserto campos principales*/
	$campos=array('id_pregunta','id_examen','titulo',array('titulo_rewrite',$urlrewrite),'estado_rpta','fecha_actualizacion','estado_idestado'); /*inserto campos principales*/
 
	if($_GET["task"]=='insert'){
		// echo "HOLA 1 ";
    // $_POST['orden'] = _orden_noticia("","respuestas","");
    $_POST['orden'] = 2021;
		// echo " demoro en calcular nuevo orden, por el exceso de registros en Base de datos: 'Preguntas' ";

		$_POST['fecha_registro'] = fecha_hora(2);
		
		 if(isset($_FILES['imagen']) && !empty($_FILES['imagen']['name'])){
      $_POST['imagen'] = carga_imagen($dir,'imagen','','600','700');
      $campos = array_merge($campos,array('imagen'));
    }
		
		// echo var_dump(arma_insert('respuestas',array_merge($campos,array('orden','fecha_registro')),'POST'));
		// exit();
		
    $bd->inserta_(arma_insert('respuestas',array_merge($campos,array('orden','fecha_registro')),'POST'));/*inserto hora -orden y guardo imag*/
		
  }else{
		
		if(isset($_FILES['imagen']) && !empty($_FILES['imagen']['name'])){
      $path = $dir.$_POST['imagen_ant'];
      if( file_exists($path) && !empty($_POST['imagen_ant']) ) unlink($path);    
      $_POST['imagen'] = carga_imagen($dir,'imagen','','600','700');
      $campos = array_merge($campos,array('imagen'));
    }
		
    $bd->actualiza_(armaupdate('respuestas',$campos," id_rpta='".$_POST["id_rpta"]."'",'POST'));/*actualizo*/
  }
	
  $bd->close();
  gotoUrl("index.php?page=".$_POST["nompage"]."&id_examen=".$_POST["id_examen"]."&id_pregunta=".$_POST["id_pregunta"]."&module=".$_POST["nommodule"]."&parenttab=".$_POST["nomparenttab"]);
	
}elseif($_GET["task"]=='new' || $_GET["task"]=='edit'){
  if($_GET["task"]=='edit'){
     $data_servicio=executesql("select * from respuestas where id_rpta='".$_GET["id_rpta"]."'",0);
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
				 <?php   
							 $sql_x=" select p.titulo as pregunta, x.titulo as examen  from preguntas p  INNER JOIN examenes x ON x.id_examen=p.id_examen WHERE  p.id_examen='".$_GET["id_examen"]."' and p.id_pregunta='".$_GET["id_pregunta"]."' "; 
							$datoscurso=executesql($sql_x,0); 
					?>				
          <h4 class="box-title"><?php echo ($_GET["task"]=="edit") ? 'Editar' : 'Agregando'; ?> Respuestas: <b><?php echo $datoscurso["pregunta"]; ?> </b> </h4>
        </div><!-- /.box-header -->
<?php $task_=$_GET["task"]; ?>
        <!-- form start -->
        <form id="registro" action="respuestas.php?task=<?php echo ($task_=='edit') ?  "update" : "insert"; ?>" class="form-horizontal" method="POST" enctype="multipart/form-data" onsubmit="return aceptar()">
<?php 
if($task_=='edit') create_input("hidden","id_rpta",$data_servicio["id_rpta"],"",$table,"");
create_input("hidden","urlfailed",basename($_SERVER['REQUEST_URI']),"",$table,"");  
create_input("hidden","urlgo",$link_pregunta,"",$table,"");
create_input("hidden","nompage",$_GET["page"],"",$table,""); 
create_input("hidden","id_examen",$_GET["id_examen"],"",$table,""); 
create_input("hidden","id_pregunta",$_GET["id_pregunta"],"",$table,""); 
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
                <?php create_input("textarea","titulo",$data_servicio["titulo"],"form-control",$table,"",$agregado); ?>
              </div>
            </div>
					<div class="form-group">
						<label for="inputPassword3" class="col-md-2 col-sm-2 control-label">Rpta correcta:</label>
						<div class="col-sm-3">
							<select id="estado_rpta" name="estado_rpta" class="form-control" requerid >  <!-- saco valor desde la BD -->
								<option value="2"  <?php echo ($data_servicio['estado_rpta'] == 2) ? 'selected' : '' ;?>>NO</option>
								<option value="1" <?php echo ($data_servicio['estado_rpta'] == 1) ? 'selected' : '' ;?>>SI</option>  
							</select>
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
						<label for="inputPassword3" class="col-sm-2 control-label">Imágen :</label>
						<div class="col-sm-6">
							<input type="file" name="imagen" id="imagen" class="form-control">
							<?php create_input("hidden","imagen_ant",$data_servicio["imagen"],"",$table,$agregado); 
								if($data_servicio["imagen"]!=""){ 
							?>
								<img src="<?php echo "files/images/imagenes/".$data_servicio["imagen"]; ?>" width="200" class="mgt15">
							<?php } ?> 
						</div>
					</div>
								
          </div>
              <div class="box-footer">
                <div class="form-group">
                  <div class="col-sm-10 pull-right">
                    <input  type="submit"  class="btn bg-blue btn-flat" id="btnguardar" value="Guardar">
                    <button type="button" class="btn bg-red btn-flat" onclick="javascript:gotourl('<?php echo $link_pregunta; ?>');">Cancelar</button>
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
  $id_rpta = !isset($_GET['id']) ? implode(',', $_GET['chkDel']) : $_GET['id'];
  $id_curso2 = executesql("SELECT video FROM detalle_pestanhas WHERE id_rpta IN(".$id_rpta.")");
  if(!empty($id_curso2)){
    foreach($id_curso2 as $row2){
      // $pfile2 = 'files/video/'.$row2['id_rpta'].'/'.$row2['video'];
      // if(file_exists($pfile2) && !empty($row2['video'])){ unlink_sesion($pfile2); }
    }
  }
  $bd->actualiza_("DELETE FROM respuestas WHERE id_rpta IN(".$id_rpta.")");
  $bd->Commit();
  $bd->close();

}elseif($_GET["task"]=='uestado'){
  $bd = new BD;
  $bd->Begin();
  $id_rpta = !isset($_GET['id']) ? $_GET['estado_idestado'] : $_GET['id'];
  $id_rpta = is_array($id_rpta) ? implode(',',$id_rpta) : $id_rpta;
  $respuestas = executesql("SELECT * FROM respuestas WHERE id_rpta IN (".$id_rpta.")");
  if(!empty($respuestas))
    foreach($respuestas as $reg => $item)
      if ($item['estado_idestado']==1) {
        $state = 2;
      }elseif ($item['estado_idestado']==2) {
        $state = 1;
      }
  $bd->actualiza_("UPDATE respuestas SET estado_idestado=".$state." WHERE id_rpta=".$id_rpta."");
  echo $state;
  $bd->Commit();
  $bd->close();
	
}elseif($_GET["task"]=='finder'){
  $sql = "SELECT cv.*, x.titulo as examen, p.titulo as pregunta, e.nombre AS estado FROM respuestas cv 
										INNER JOIN preguntas p ON p.id_pregunta=cv.id_pregunta  
										INNER JOIN examenes x ON x.id_examen=p.id_examen  
										INNER JOIN estado e ON cv.estado_idestado=e.idestado   
									WHERE  cv.id_pregunta =".$_GET['id_pregunta']." "; 
									
  if(!empty($_GET['criterio_mostrar'])) $porPagina=$_GET['criterio_mostrar'];
  if(!empty($_GET['criterio_usu_per'])){
    $stringlike=fn_filtro(substr($_GET['criterio_usu_per'], 0, 16));
    $sql.= " AND ( cv.titulo LIKE '%".$stringlike."%' or x.titulo LIKE '%".$stringlike."%' or p.titulo LIKE '%".$stringlike."%' )";
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
  $mantenerVar=array("id_examen","criterio_mostrar","task","criterio_usu_per","criterio_ordenar_por","criterio_orden");
  $paging->mantenerVar($mantenerVar);
  $paging->porPagina(fn_filtro((int)$porPagina));
  $paging->ejecutar();
  $paging->pagina_proceso="respuestas.php";
?>
<table id="example1" class="table table-bordered table-striped">
  <thead>
    <tr role="row">
      <th class="sort">RPTA</th>
      <th class="sort">CORRECTA</th>
      <th class="sort">PREGUNTA</th>
      <th class="sort">IMG</th>
      <th class="sort">EXAMEN</th>
      <th class="sort cnone">ESTADO</th>
      <th class="unafbe btn_varios">Opciones</th>
    </tr>
  </thead>
  <tbody id="sort">
<?php $i=0;
while ($detalles = $paging->fetchResultado()): 
	$i++;
	
	if( $detalles["estado_rpta"] == 1){ // por revisar 
		$fondo_entregar ="background:green; color:#fff !important; ";
	}else{
		$fondo_entregar="";
	}
?>
    <tr  style="<?php echo $fondo_entregar; ?>" >
      <td><?php echo $i.'. '.short_name($detalles["titulo"],60); ?></td>
      <td><?php echo ($detalles["estado_rpta"]==1)?'SI':'X'; ?></td>
      <td><?php echo short_name($detalles["pregunta"],60); ?></td>
      <td>	<?php if( !empty($detalles['imagen']) ){  /* imagen respuestas */
															echo "<figure><img src='files/images/imagenes/".$detalles["imagen"]."'></figure>";
			}else{ echo "---";}
								?>
			</td>
      <td><?php echo $detalles["examen"]; ?></td>
      <td class="cnone"><a href="javascript: fn_estado('<?php echo $detalles["id_rpta"]; ?>')"><?php echo $detalles["estado"]; ?></a></td>
      <td>
        <div class="btn-eai btns btr btn_varios text-center ">
          <a href="<?php echo $_SESSION["base_url"].'&task=edit&id_rpta='.$detalles["id_rpta"]; ?>" title="Editar"  style="color:#fff;"><i class="fa fa-edit"></i> editar</a>				
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
  reordenar('respuestas.php');
});
var mypage = "respuestas.php";
</script>
<?php }else{ ?>
<div class="box-body">
  <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
    <form action="javascript: fn_buscar();" id="frm_buscar" name="frm_buscar">
      <input type="hidden" name="id_examen" value="<?php echo $_GET['id_examen']; ?>">
      <input type="hidden" name="id_pregunta" value="<?php echo $_GET['id_pregunta']; ?>">
      <input type="hidden" name="module" value="<?php echo $_GET['module']; ?>">
      <input type="hidden" name="parenttab" value="<?php echo $_GET['parenttab']; ?>">
      <div class="bg-gray-light">      
        <div class="col-sm-12">
          <?php   $sql_x=" select p.id_pregunta, p.titulo as pregunta, x.id_examen, x.titulo as examen from preguntas p  INNER JOIN examenes x ON x.id_examen=p.id_examen WHERE p.id_examen='".$_GET["id_examen"]."' and p.id_pregunta='".$_GET["id_pregunta"]."' "; 
						$datoscurso=executesql($sql_x,0);
						// $volver_al_curso="index.php?page=examenes&module=".$_GET["module"]."&parenttab=".$_GET["parenttab"]."";

					?>
						<h3 style='margin:0;' ><small> <b style='color:#333;'>Respuestas :</b> </small></h3>
						<h3 style='margin-top:0;padding-top:0;padding-bottom:10px;' ><small> 
								<b style='color:#555;'><a href="index.php?page=examenes&module=<?php echo $_GET["module"]; ?>&parenttab=<?php echo $_GET["parenttab"]; ?>">EXAMEN</a> </b> : <?php echo 'id: '.$datoscurso["id_examen"].' - '.$datoscurso["examen"]; ?> </br>
								<b style='color:#555;'>Pregunta:</b> : <?php echo 'id: '.$datoscurso["id_pregunta"].' </br> '.$datoscurso["pregunta"]; ?> </small></h3>
        </div>
				
				<div class="col-sm-2">
          <div class="btn-eai">
            <a href="<?php echo $link_pregunta."&task=new"; ?>" title="Agregar" style="color:#fff;"><i class="fa fa-file" style="padding-right:5px;"></i>Agregar</a> 
          </div>
        </div>
        <div class="col-sm-4 ">          
          <?php create_input('text','criterio_usu_per','',"form-control pull-right",$table,'placeholder="Buscar .."'); ?>
        </div>
        <div class="col-sm-2 ">          
          <?php select_sql("nregistros"); ?>
        </div>
         <div class="col-sm-2 criterio_mostrar"><div class="btn-eai">            
						<a href="index.php?page=preguntas&id_examen=<?php echo $_GET["id_examen"]; ?>&module=<?php echo $_GET["module"]; ?>&parenttab=<?php echo $_GET["parenttab"]; ?>" title="Regresar << " style="color:#fff;"><i class="fa fa-file" style="padding-right:5px;"></i>  Regresar</a> 
          </div></div>
					
					
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
var us = "respuesta";
var link = "respuesta";
var ar = "la";
var l = "a";
var l2 = "a";
var pr = "La";
var id = "id_rpta";
var mypage = "respuestas.php";
</script>
<?php } ?>