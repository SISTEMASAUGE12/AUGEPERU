<?php error_reporting(E_ALL ^ E_NOTICE);
include ("auten.php");

if($_GET["task"]=='insert' || $_GET["task"]=='update'){
  $bd=new BD;
	$where = ($_GET["task"]=='update') ? "and id_pregunta!='".$_POST["id_pregunta"]."'" : '';
	 $urlrewrite=armarurlrewrite($_POST["titulo"]);
   $urlrewrite=armarurlrewrite($urlrewrite,1,"preguntas_bancos","id_pregunta","titulo_rewrite",$where);
	
	$_POST['fecha_actualizacion'] = fecha_hora(2);
	// $dir='files/images/imagenes/'.$_POST['id_cate'].'/';
	$dir='files/images/imagenes/';
	
	
	$campos=array('id_cate','titulo',array('titulo_rewrite',$urlrewrite),'puntos','descripcion','solucion','solucion_es_video','fecha_actualizacion','estado_idestado'); /*inserto campos principales*/
  if($_GET["task"]=='insert'){
		// echo "A";
    // $_POST['orden'] = _orden_noticia("","preguntas_bancos","");
		// echo "B";
		$_POST['fecha_registro'] = fecha_hora(2);
		// echo "hola se ";
	
		if(isset($_FILES['imagen']) && !empty($_FILES['imagen']['name'])){
      $_POST['imagen'] = carga_imagen($dir,'imagen','','800','400');
      $campos = array_merge($campos,array('imagen'));
    }
		
		if(isset($_FILES['imagen_pre_2']) && !empty($_FILES['imagen_pre_2']['name'])){
      $_POST['imagen_pre_2'] = carga_imagen($dir,'imagen_pre_2','','800','400');
      $campos = array_merge($campos,array('imagen_pre_2'));
    }
		
		/* IMG SOLUCION */
		if(isset($_FILES['imagen2']) && !empty($_FILES['imagen2']['name'])){
      $_POST['imagen2'] = carga_imagen($dir,'imagen2','','800','400');
      $campos = array_merge($campos,array('imagen2'));
    }
		
		// echo var_dump(arma_insert('preguntas_bancos',array_merge($campos,array('orden','fecha_registro')),'POST'));
		// exit();
		
    $id_pregunta=$_POST['orden']= $bd->inserta_(arma_insert('preguntas_bancos',array_merge($campos,array('fecha_registro')),'POST'));/*inserto hora -orden y guardo imag*/
		/* orden == id_pregunta */
		/* update para guardar el orden */
    $bd->actualiza_(armaupdate('preguntas_bancos',array('orden')," id_pregunta='".$id_pregunta."'",'POST'));/*actualizo*/
		
		
  }else{
		
		if(isset($_FILES['imagen']) && !empty($_FILES['imagen']['name'])){
      $path = $dir.$_POST['imagen_ant'];
      // if( file_exists($path) && !empty($_POST['imagen_ant']) ) unlink($path);      // no elimino al alctualizar porque puede etasr siendo usada en banco de pregunta o en clonacion    
      $_POST['imagen'] = carga_imagen($dir,'imagen','','800','400');
      $campos = array_merge($campos,array('imagen'));
    }
		
		if(isset($_FILES['imagen_pre_2']) && !empty($_FILES['imagen_pre_2']['name'])){
      $path = $dir.$_POST['imagen_ant_pre'];
      // if( file_exists($path) && !empty($_POST['imagen_ant']) ) unlink($path);      // no elimino al alctualizar porque puede etasr siendo usada en banco de pregunta o en clonacion     
      $_POST['imagen_pre_2'] = carga_imagen($dir,'imagen_pre_2','','800','400');
      $campos = array_merge($campos,array('imagen_pre_2'));
    }
		
		/* IMG SOLUCION */
		if(isset($_FILES['imagen2']) && !empty($_FILES['imagen2']['name'])){
      $path = $dir.$_POST['imagen_ant2'];
      // if( file_exists($path) && !empty($_POST['imagen_ant2']) ) unlink($path);     // no elimino al alctualizar porque puede etasr siendo usada en banco de pregunta o en clonacion      
      $_POST['imagen2'] = carga_imagen($dir,'imagen2','','800','400');
      $campos = array_merge($campos,array('imagen2'));
    }
		
    $bd->actualiza_(armaupdate('preguntas_bancos',$campos," id_pregunta='".$_POST["id_pregunta"]."'",'POST'));/*actualizo*/
  }
	
  $bd->close();
  gotoUrl("index.php?page=".$_POST["nompage"]."&id_cate=".$_POST["id_cate"]."&module=".$_POST["nommodule"]."&parenttab=".$_POST["nomparenttab"]);
	
}elseif($_GET["task"]=='new' || $_GET["task"]=='edit'){
  if($_GET["task"]=='edit'){
     $data_servicio=executesql("select * from preguntas_bancos where id_pregunta='".$_GET["id_pregunta"]."'",0);
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
				 			
          <h4 class="box-title"><?php echo ($_GET["task"]=="edit") ? 'Editar' : 'Agregando'; ?> Pregunta: </h4>
        </div><!-- /.box-header -->
<?php $task_=$_GET["task"]; ?>
        <!-- form start -->
        <form id="registro" action="preguntas_bancos_corregidas.php?task=<?php echo ($task_=='edit') ?  "update" : "insert"; ?>" class="form-horizontal" method="POST" enctype="multipart/form-data" onsubmit="return aceptar()">
<?php 
if($task_=='edit') create_input("hidden","id_pregunta",$data_servicio["id_pregunta"],"",$table,"");
create_input("hidden","urlfailed",basename($_SERVER['REQUEST_URI']),"",$table,"");  
create_input("hidden","urlgo",$link2,"",$table,"");
create_input("hidden","nompage",$_GET["page"],"",$table,""); 
create_input("hidden","id_cate",$_GET["id_cate"],"",$table,""); 
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
              <label for="inputEmail3" class="col-sm-2 control-label">CATEGORIA</label>
              <div class="col-sm-4">
                <?php crearselect("id_cate","select * from categoria_examenes where estado_idestado=1 order by titulo asc ",'class="form-control" requerid ',$data_servicio["id_cate"]," -- seleccione -- "); ?>
              </div>
            </div>
           
            <div class="form-group">
              <label for="inputPassword3" class="col-sm-2 control-label">Título</label>
              <div class="col-sm-8">
                <?php create_input("text","titulo",$data_servicio["titulo"],"form-control",$table,"",$agregado); ?>
              </div>
            </div>
						 <div class="form-group">
              <label for="inputPassword3" class="col-sm-2 control-label">Puntos</label>
              <div class="col-sm-8">
                <?php create_input("text","puntos",$data_servicio["puntos"],"form-control",$table,"",$agregado); ?>
              </div>
            </div>
						
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
					<div class="form-group">
						<label for="inputPassword3" class="col-sm-2 control-label">Imágen pregunta 1: tamaño max. 800px anxho * 400px alto</label>
						<div class="col-sm-6">
							<input type="file" name="imagen" id="imagen" class="form-control">
							<?php create_input("hidden","imagen_ant",$data_servicio["imagen"],"",$table,$agregado); 
								if($data_servicio["imagen"]!=""){ 
							?>
							<!-- 
								<img src="<?php echo "files/images/imagenes/".$data_servicio['id_cate']."/".$data_servicio["imagen"]; ?>" width="200" class="mgt15">
								-->
								<img src="<?php echo "files/images/imagenes/".$data_servicio["imagen"]; ?>" width="200" class="mgt15">
							<?php } ?> 
						</div>
					</div>
					
					<div class="form-group">
						<label for="inputPassword3" class="col-sm-2 control-label">Imágen pregunta adicional: tamaño max. 800px anxho * 400px alto</label>
						<div class="col-sm-6">
							<input type="file" name="imagen_pre_2" id="imagen_pre_2" class="form-control">
							<?php create_input("hidden","imagen_ant_pre",$data_servicio["imagen_pre_2"],"",$table,$agregado); 
								if($data_servicio["imagen_pre_2"]!=""){ 
							?>
							<!-- 
								-->
								<img src="<?php echo "files/images/imagenes/".$data_servicio["imagen_pre_2"]; ?>" width="200" class="mgt15">
							<?php } ?> 
						</div>
					</div>

<!-- ** SOLUCION -->
					<div class="form-group">
						<h3 STYLE="padding-top:35px;">SOLUCIÓN DE PREGUNTA: </h3>
					</div>
					<div class="form-group">
							<label for="inputEmail3" class="col-md-2 col-sm-2 control-label">SOLUCIÓN ES UN VIDEO?</label>				
							<div class="col-sm-3">
								<select id="solucion_es_video" name="solucion_es_video" class="form-control" requerid >  <!-- saco valor desde la BD -->
									<option value="2"  <?php echo ($data_servicio['solucion_es_video'] == 2) ? 'selected' : '' ;?>>NO</option>
									<option value="1" <?php echo ($data_servicio['solucion_es_video'] == 1) ? 'selected' : '' ;?>>SI</option>  
								</select>
							</div>
						</div>
					 <div class="form-group">
              <label for="inputPassword3" class="col-sm-2 control-label">Solución:</label>
              <div class="col-sm-8">
                <?php create_input("textarea","solucion",$data_servicio["solucion"],"form-control lleva_link_vimeo",$table,"",$agregado); ?>
								<iframe frameborder="0" width="100%" height="200" class="video_vimeo "></iframe>
              </div>
            </div>
					<div class="form-group">
						<label for="inputPassword3" class="col-sm-2 control-label">Imágen solución: tamaño max. 800px anxho * 400px alto</label>
						<div class="col-sm-6">
							<input type="file" name="imagen2" id="imagen2" class="form-control">
							<?php create_input("hidden","imagen_ant2",$data_servicio["imagen2"],"",$table,$agregado); 
								if($data_servicio["imagen2"]!=""){ 
							?>
								<img src="<?php echo "files/images/imagenes/".$data_servicio["imagen2"]; ?>" width="200" class="mgt15">
							<?php } ?> 
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
  $id_pregunta = !isset($_GET['id_pregunta']) ? implode(',', $_GET['chkDel']) : $_GET['id_pregunta'];
  
	$sql="SELECT * FROM preguntas_bancos WHERE id_pregunta IN(".$id_pregunta.")";
	// echo $sql;
	
	$id_curso2 = executesql($sql);
  if(!empty($id_curso2)){
    foreach($id_curso2 as $row2){
      $pfile1 = 'files/images/imagenes/'.$row2['imagen'];
      // if(file_exists($pfile1) && !empty($row2['imagen'])){ unlink($pfile1); }    // no elimino al alctualizar porque puede etasr siendo usada en banco de pregunta o en clonacion    
			
			$pfile2 = 'files/images/imagenes/'.$row2['imagen2'];
      // if(file_exists($pfile2) && !empty($row2['imagen2'])){ unlink($pfile2); }   // no elimino al alctualizar porque puede etasr siendo usada en banco de pregunta o en clonacion    
    }
  }
  $sql_delete="DELETE FROM preguntas_bancos WHERE id_pregunta IN(".$id_pregunta.")";
	// echo $sql_delete;
	
	$bd->actualiza_($sql_delete);
  $bd->Commit();
  $bd->close();


}elseif($_GET["task"]=='actualizar_puntaje_total'){
  $bd = new BD;
  $bd->Begin();
  $id_cate = $_GET['id_cate'];

  $_POST['puntos'] = $_GET['puntaje'];
  $campos = array('puntos');

  $bd->actualiza_(armaupdate('preguntas_bancos',$campos," id_cate='".$id_cate."'",'POST'));
  $bd->Commit();
  $bd->close();

}elseif($_GET["task"]=='actualizar_puntaje'){
  $bd = new BD;
  $bd->Begin();
  $id_pregunta = $_GET['id_pregunta'];

  $_POST['puntos'] = $_GET['puntaje'];
  $campos = array('puntos');

  $bd->actualiza_(armaupdate('preguntas_bancos',$campos," id_pregunta='".$id_pregunta."'",'POST'));
  $bd->Commit();
  $bd->close();

}elseif($_GET["task"]=='uestado'){
  $bd = new BD;
  $bd->Begin();
  $id_pregunta = !isset($_GET['id']) ? $_GET['estado_idestado'] : $_GET['id'];
  $id_pregunta = is_array($id_pregunta) ? implode(',',$id_pregunta) : $id_pregunta;
  $preguntas_bancos = executesql("SELECT * FROM preguntas_bancos WHERE id_pregunta IN (".$id_pregunta.")");
  if(!empty($preguntas_bancos))
    foreach($preguntas_bancos as $reg => $item)
      if ($item['estado_idestado']==1) {
        $state = 2;
      }elseif ($item['estado_idestado']==2) {
        $state = 1;
      }
  $bd->actualiza_("UPDATE preguntas_bancos SET estado_idestado=".$state." WHERE id_pregunta=".$id_pregunta."");
  echo $state;
  $bd->Commit();
  $bd->close();
	
}elseif($_GET["task"]=='finder'){
  $sql = "SELECT cv.*, ld.titulo as categoria_examen, e.nombre AS estado FROM preguntas_bancos cv 
										LEFT JOIN categoria_examenes ld ON ld.id_cate=cv.id_cate  
										INNER JOIN estado e ON cv.estado_idestado=e.idestado   
									WHERE   cv.estado_idestado=1  and cv.corregido=1 "; 
									
  if(!empty($_GET['criterio_mostrar'])) $porPagina=$_GET['criterio_mostrar'];

  if(!empty($_GET['id_cate'])){
    $sql.= " AND  cv.id_cate = ".$_GET["id_cate"]." ";
  }
 
  if(!empty($_GET['criterio_usu_per'])){
    $stringlike=fn_filtro(substr($_GET['criterio_usu_per'], 0, 16));
    $sql.= " AND ( cv.titulo LIKE '%".$stringlike."%' or ld.titulo LIKE '%".$stringlike."%' )";
  }
  
  if(!empty($_GET['criterio_ordenar_por'])) $sql.= sprintf(" order by %s %s", fn_filtro($_GET['criterio_ordenar_por']), fn_filtro($_GET['criterio_orden']));
  $sql.= " ORDER BY cv.id_pregunta desc ";
  $paging = new PHPPaging;
  $paging->agregarConsulta($sql); 
  $paging->div('div_listar');
  $paging->modo('desarrollo'); 
  $numregistro=1; 
  if($numregistro) $paging->porPagina(fn_filtro((int)$numregistro));
  $paging->verPost(true);
  $mantenerVar=array("id_cate","criterio_mostrar","task","criterio_usu_per","criterio_ordenar_por","criterio_orden");
  $paging->mantenerVar($mantenerVar);
  $paging->porPagina(fn_filtro((int)$porPagina));
  $paging->ejecutar();
  $paging->pagina_proceso="preguntas_bancos_corregidas.php";
?>
<table id="example1" class="table table-bordered table-striped">
  <thead>
    <tr role="row">
      <th class="sort" style="width:50px;" >ID</th>
      <th class="sort" >PREGUNTA</th>
			<!-- 
        <th class="sort">EXAMEN</th>
			-->
      <th class="sort cnone" style="width:60px;" >PTOS</th>
			<!-- 
        <th class="sort cnone">ACTUALIZAR PUNTAJE</th>
			-->
      <th class="sort" style="width:100px;">CATEGORIA</th>
      <th class="unafbe " style="width:150px;">Opciones</th>
    </tr>
  </thead>
  <tbody id="sort">
<?php $i=0;
while ($detalles = $paging->fetchResultado()): 
	$i++;
?>
    <tr>
      <td> <?php echo '<p><big>'. '<b>'.$detalles["id_pregunta"].'.</b></big></p> '; ?> </td>
      <td>
			<?php echo '<p>titulo: <big>'.  $detalles["titulo"].'</big></p> '; ?>
			<?php echo (!empty($detalles["descripcion"]) )?'<div style="padding:12px 0;">'. '<b>Descripción </b> </br> '.$detalles["descripcion"].'</div> ':' '; ?>
			<?php 
					if( !empty($detalles["imagen"]) ){ 
							echo "<figure class='img_pregunta ' style='padding-top:10px;'><img src='files/images/imagenes/".$detalles["imagen"]."' style='height:100px;'></figure>";
					} 
					if( !empty($detalles["imagen_pre_2"]) ){ 
							echo "<figure class='img_pregunta ' style='padding-top:15px;'><img src='files/images/imagenes/".$detalles["imagen_pre_2"]."'></figure>";
					} 
			?>
			
			<!-- Respueats -->
			<?php 
				$rptas=executesql(" select * from respuestas_bancos where id_pregunta='".$detalles["id_pregunta"]."' ");
				if( !empty($rptas) ){ $y=0;
					echo "<p style='padding:15px 0;'><b>Respuestas:</b></p> <div class='listado_rptas' style='padding-bottom:5px;margin-bottom:20px;border-bottom:2px solid #333;' >";
					
					foreach($rptas as $date){
							$y++; 
						?>
							<p style="padding-bottom:9px;position:relative;padding-left:16px;" >
								<?php if( ($date["estado_rpta"] == 1) ){ 
												echo '<span style="background:green;height:10px;width:10px;border-radius:50%;left:0;top:7px;position:absolute;"></span>';
											}else{
												echo '<span style="background:red;height:10px;width:10px;border-radius:50%;left:0;top:7px;position:absolute;"></span>';
											}	
										
										echo '<b>'.$y.'.</b> '.$date["titulo"]; ?>
							</p>
						<?php 
					} /* end for */
					echo "</div> <!-- list rptas -->";
				}
			?>
			
			</td>
			<!-- 
      <td><?php echo $detalles["examen"]; ?></td>
    -->
    <td><?php echo $detalles["puntos"]; ?></td>
    <!-- 
      <td class="cnone"><a href="javascript: actualizar_puntaje('<?php echo $detalles["id_pregunta"]; ?>')">Actualizar</a></td>
    -->
      
      <td><?php echo $detalles["categoria_examen"]; ?></td>
      <td>
        <div class="btn-eai btns btr  text-center "  style="width:150px;" >
          <a href="<?php echo $_SESSION["base_url"].'&task=edit&id_pregunta='.$detalles["id_pregunta"]; ?>" title="Editar" 
					style="color:#fff;"> editar</a>
					
					<a href="index.php?page=respuestas_bancos&id_cate=<?php echo $detalles['id_cate']; ?>&id_pregunta=<?php echo $detalles['id_pregunta']; ?>&module=<?php echo $_GET['module']; ?>&parenttab=<?php echo $_GET['parenttab']; ?>"  style="color:#fff;" title="ver Respuestas">
						 <span> rptas</span>
					</a> 	
          <?php  if( $detalles["estado_idestado"] ==1){ ?>	 					
          <a href="javascript: fn_estado('<?php echo $detalles["id_pregunta"]; ?>')" style="background:red;"><i class="fa fa-trash-o"></i></a>
          <?PHP } ?>

			<?php  if($_SESSION["visualiza"]["idtipo_usu"] ==1){ ?>	 					
        <!-- 
					<a href="javascript: fn_eliminar('<?php echo $detalles["id_pregunta"]; ?>')" style="background:red;"><i class="fa fa-trash-o"></i></a>
      -->
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
  // reordenar('preguntas_bancos_corregidas.php');
});
var mypage = "preguntas_bancos_corregidas.php";
</script>
<?php }else{ ?>
<div class="box-body">
  <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
    <form action="javascript: fn_buscar();" id="frm_buscar" name="frm_buscar">
      <input type="hidden" name="id_cate" value="<?php echo $_GET['id_cate']; ?>">
      <input type="hidden" name="module" value="<?php echo $_GET['module']; ?>">
      <input type="hidden" name="parenttab" value="<?php echo $_GET['parenttab']; ?>">
      <div class="bg-gray-light">      
       
	
        
        <div class="col-sm-2  criterio_buscar">                  
            <?php crearselect("id_cate","select * from categoria_examenes where estado_idestado=1 order by titulo asc",'class="form-control" ','',"-- categoria--"); ?>   
        </div>

        <div class="col-sm-4 ">          
          <?php create_input('text','criterio_usu_per','',"form-control pull-right",$table,'placeholder="Buscar .."'); ?>
        </div>
        <div class="col-sm-1 hide ">          
          <?php select_sql("nregistros"); ?>
        </div>
				<!-- 
				-->
     
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
var us = "pregunta";
var link = "preguntas_bancos_corregida";
var ar = "la";
var l = "a";
var l2 = "a";
var pr = "La";
var id = "id_pregunta";
var mypage = "preguntas_bancos_corregidas.php";
</script>
<?php } ?>