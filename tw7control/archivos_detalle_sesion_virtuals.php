<?php error_reporting(E_ALL ^ E_NOTICE);
include_once("auten.php");

if($_GET["task"]=='neworden'){
  $bd=new BD;
  $orden_actual=$_GET["orden"];
  $orden_nuevo=$_GET["nuevoorden"];
  $tipo=$_GET["tipo"];  
  $id_del_registro_actual=$_GET["idimagen"];
  $criterio_Orden ="";
  nuevoorden($orden_actual, $orden_nuevo, $tipo, $id_del_registro_actual, "archivos_detalle_sesion_virtuals", "idimagen", $criterio_Orden);    
  $bd->close();

}elseif($_GET["task"]=='insert' || $_GET["task"]=='update'){
  $bd=new BD;
  $norden=_orden_noticia("","archivos_detalle_sesion_virtuals","");
  $campos=array("titulo","enlace",'id_detalle','descripcion',"estado_idestado", array("orden",$norden)); 
  
	$car = (isset($_POST['id_detalle']) AND $_POST['id_detalle']>0) ? $_POST['id_detalle'] : 0;//el cero es para archivos_detalle_sesion_virtuals de empresas
	$dir = "files/files/".$car."/";
	// exit();
	
  if($_GET["task"]=='insert'){
		if(isset($_FILES['archivo']) && !empty($_FILES['archivo']['name'])){
			$_POST['archivo'] = carga_imagen($dir,'archivo','','','');
			$campos = array_merge($campos,array('archivo'));
		}
		
		// if(isset($_FILES['archivo']) && !empty($_FILES['archivo']['name'])){
      // $_POST['archivo'] = carga_imagen($dir,'archivo','',0);
      // $campos = array_merge($campos,array('archivo'));
    // }
		
		
    $bd->inserta_(arma_insert('archivos_detalle_sesion_virtuals',$campos,'POST'));
		
  }else{
		if(isset($_FILES['archivo']) && !empty($_FILES['archivo']['name'])){
			$path = $dir.$_POST['imagen_ant'];
			if( file_exists($path) && !empty($_POST['imagen_ant']) ) unlink($path);    
			$_POST['archivo'] = carga_imagen($dir,'archivo','','','');
			$campos = array_merge($campos,array('archivo'));
		}
	 $bd->actualiza_(armaupdate('archivos_detalle_sesion_virtuals',$campos," idimagen='".$_POST["idimagen"]."'",'POST'));/*actualizo*/
  }
 
  $bd->close();
  gotoUrl("index.php?page=".$_POST["nompage"]."&module=".$_POST["nommodule"]."&id_detalle=".$_POST["id_detalle"]."&parenttab=".$_POST["nomparenttab"]);  
  
}elseif($_GET["task"]=='new' || $_GET["task"]=='edit'){
  if($_GET["task"]=='edit'){
     $data_producto=executesql("select * from archivos_detalle_sesion_virtuals where idimagen='".$_GET["idimagen"]."'",0);
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
              <h3 class="box-title">
                <?php echo ($_GET["task"]=="edit") ? 'Editar' : 'Nueva'; ?> Recursos de Apoyo</h3>	
							<?php  
 								$sql_x=" select c.titulo as curso, s.titulo as modulo, ds.titulo as clase  from detalle_sesiones ds  
															INNER JOIN sesiones s ON s.id_sesion=ds.id_sesion 
															INNER JOIN cursos c ON s.id_curso=  s.id_curso  
															WHERE ds.id_detalle='".$_GET["id_detalle"]."' "; 
															
								$datoscurso=executesql($sql_x);
								echo "<h3 style='margin-top:0;padding-bottom:10px;' >
													<b><small  style='color:#333;'> Curso: ".$datoscurso[0]["curso"]."</small></b> 
													<span style='padding-right:20px;'></span> 
													<small><b> Modulo :</b> ".$datoscurso[0]["modulo"]."</small> 
													<span style='padding-right:20px;'></span> 
													<small> <b>Recursos de clase :</b> ".$datoscurso[0]["clase"]."</small> 
											</h3>";
							?>


								
            </div><!-- /.box-header -->
<?php $task_=$_GET["task"]; ?>
            <!-- form start -->
            <form id="registro" action="archivos_detalle_sesion_virtuals.php?task=<?php echo ($task_=='edit')?"update":"insert"; ?>" class="form-horizontal" method="POST" onsubmit="return aceptar()" enctype="multipart/form-data"><!-- para cargar archivos o img -->
<?php 
if($task_=='edit') create_input("hidden","idimagen",$data_producto["idimagen"],"",$table,""); 

create_input("hidden","urlfailed",basename($_SERVER['REQUEST_URI']),"",$table,"");  
create_input("hidden","urlgo",$link_detalle_archivos,"",$table,"");
create_input("hidden","id_detalle",$_GET["id_detalle"],"",$table,""); 
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
                  <label for="inputPassword3" class="col-sm-2 control-label">Título Recurso: </label>
                  <div class="col-sm-6">
                    <?php create_input("text","titulo",$data_producto["titulo"],"form-control",$table,"required ",$agregado); ?>
                  </div>
                </div>
								
									<div class="form-group">
							<label for="inputPassword3" class="col-sm-2 control-label">Descripción:</label>
							<div class="col-sm-8">
								<?php create_input("textarea","descripcion",$data_producto["descripcion"],"",$table,$agregado);  ?>
								<script>
								var editor11 = CKEDITOR.replace('descripcion','');
								CKFinder.setupCKEditor( editor11, 'ckfinder/' );
								</script> 
							</div>
						</div>
						
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Archivo (Hasta 10MB)</label>
                  <div class="col-sm-6">
                    <input type="file" name="archivo" id="archivo" class="form-control">
                    <?php create_input("hidden","imagen_ant",$data_producto["archivo"],"",$table,$agregado); 
                      if($data_producto["archivo"]!=""){ 
                    ?>
                      <a href='files/files/<?php echo $data_producto["id_detalle"].'/'.$data_producto["archivo"];?>' target='_blank'><img src="dist/img/icons/archivo.jpg" ></a>
                    <?php } ?> 
                  </div>
                </div>

								<div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Enlace o Link (Si no contiene algún archivo)</label>
                  <div class="col-sm-6">
                    <?php create_input("textarea","enlace",$data_producto["enlace"],"form-control",$table,"",$agregado); ?>
                  </div>
                </div>

              </div>
               <div class="box-footer">
                <div class="form-group">
                  <div class="col-sm-10 pull-right">
                    <input  type="submit"  class="btn bg-blue btn-flat" id="btnguardar" value="Guardar">
                    <button type="button" class="btn bg-red btn-flat" onclick="javascript:gotourl('<?php echo $link_detalle_archivos; ?>');">Cancelar</button>
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
		alert("Recomendación: Ingrese Titulo");
		return false; //el formulario no se envia		
	}
	
}				
</script>	
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
  $categoria = executesql("SELECT archivo FROM archivos_detalle_sesion_virtuals where idimagen IN(".$ide.")");
  if(!empty($categoria)){
    foreach($categoria as $row){
      $pfile = 'files/files/'.$row['id_detalle'].'/'.$row['archivo']; 
      if(file_exists($pfile) && !empty($row['archivo'])) unlink($pfile);
    }
  }
  $bd->actualiza_("DELETE FROM archivos_detalle_sesion_virtuals where idimagen IN(".$ide.")"); 
  $bd->Commit();
  $bd->close();

  if($num_afect<=0){echo "Error: eliminando registro"; exit;}

}elseif($_GET["task"]=='ordenar'){
  $bd = new BD;

  $_GET['order'] = array_reverse($_GET['order']);

  foreach ($_GET['order'] as $order => $item) {
    $orden = $orden + 1;
    $num_afect=$bd->actualiza_("UPDATE archivos_detalle_sesion_virtuals SET orden= ".$orden." where idimagen = ".$item."");
  }

  $bd->close();

}elseif($_GET["task"]=='uestado'){
  $bd = new BD;
  $bd->Begin();
  $ide = !isset($_GET['id']) ? $_GET['estado_idestado'] : $_GET['id'];
  $ide = is_array($ide) ? implode(',',$ide) : $ide;
  $categoria = executesql("SELECT * FROM archivos_detalle_sesion_virtuals where idimagen IN (".$ide.")");
  if(!empty($categoria))
  foreach($categoria as $reg => $item)
  if ($item['estado_idestado']==1) {
    $state = 2;
  }elseif ($item['estado_idestado']==2) {
    $state = 1;
  }
  $num_afect=$bd->actualiza_("UPDATE archivos_detalle_sesion_virtuals SET estado_idestado=".$state." where idimagen=".$ide."");
  echo $state;
  $bd->Commit();
  $bd->close();

}elseif($_GET["task"]=='finder'){

  $sql= "SELECT c.*,e.nombre AS estado FROM archivos_detalle_sesion_virtuals c INNER JOIN estado e ON c.estado_idestado=e.idestado WHERE  c.estado_idestado=e.idestado ";
  if (isset($_GET['criterio_mostrar'])) $porPagina=$_GET['criterio_mostrar'];
	$sql.= isset($_GET['id_detalle']) ? " AND c.id_detalle='".$_GET['id_detalle']."'" : '';
  if(isset($_GET['criterio_usu_per']) && !empty($_GET['criterio_usu_per'])){
    $stringlike=fn_filtro(substr($_GET['criterio_usu_per'], 0, 16));
    $sql.= " and (c.titulo LIKE '%".$stringlike."%') ";
  }
  if(isset($_GET['criterio_ordenar_por'])) $sql.= sprintf(" order by %s %s", fn_filtro($_GET['criterio_ordenar_por']), fn_filtro($_GET['criterio_orden']));
   $sql.= " ORDER BY c.orden asc ";
	 
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
  $paging->pagina_proceso="archivos_detalle_sesion_virtuals.php";
?>
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr role="row">
                  <th class="unafbe" width="20"><input type="checkbox" id="chkDel" class="all"></th>
                  <th class="sort">TÍTULO </th>
									<th class="unafbe cnone">Archivo</th>
									<th class="unafbe cnone">Enlace</th>
                  <th class="sort cnone">ESTADO</th>
                  <th class="unafbe">Opciones</th>
                </tr>
              </thead>
              <tbody id="sort">
<?php while ($detalles = $paging->fetchResultado()): ?>
                <tr id="order_<?php echo $detalles["idimagen"]; ?>">
                  <td><input type="checkbox" name="chkDel[]" class="chkDel" value="<?php echo $detalles["idimagen"]; ?>"></td>
                  <td><?php echo $detalles["titulo"]; ?></td>                                   
									<td >
                    <?php if(!empty($detalles["archivo"])){ ?>
                    <a href="<?php echo "files/files/".$detalles["id_detalle"].'/'.$detalles["archivo"]; ?>" target="_blank"><img src="dist/img/icons/archivo.jpg"><a/>
                    <?php }else{ echo "Not archivo."; } ?>
                  </td>				  
                  <td><?php echo $detalles["enlace"]; ?></td>                                   
                  <td class="cnone"><a href="javascript: fn_estado('<?php echo $detalles["idimagen"]; ?>')"><?php echo $detalles["estado"]; ?></a></td>
                  <td>
                    <div class="btn-eai btr">
                      <a href="<?php echo $_SESSION["base_url"].'&task=edit&idimagen='.$detalles["idimagen"]; ?>" style="color:#fff;"><i class="fa fa-edit"></i> editar</a>
                      <a href="javascript: fn_eliminar('<?php echo $detalles["idimagen"]; ?>')"><i class="fa fa-trash-o"></i></a>
                    </div>
                  </td>
                </tr>
<?php endwhile; ?>
              </tbody>
            </table>
            <div class="pagination"><?php echo $paging->fetchNavegacion(); ?></div>
<script>
$(function(){
  reordenar('archivos_detalle_sesion_virtuals.php');
  checked();
  sorter();
});
</script>

<?php }else{ ?>
        <div class="box-body">
          <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
            <form action="javascript: fn_buscar();" id="frm_buscar" name="frm_buscar">
							<input type="hidden" name="id_detalle" value="<?php echo $_GET['id_detalle']; ?>"> 		
							 <div class="bg-gray-light">
								<div class="col-sm-12">
									<?php  
										$sql_x=" select s.id_curso, ds.id_sesion,  ds.titulo as clase, c.titulo as curso, s.titulo as sesion  from detalle_sesiones ds 
															INNER JOIN sesiones s ON ds.id_sesion=s.id_sesion 
															INNER JOIN cursos c ON s.id_curso=c.id_curso 
															where ds.id_detalle='".$_GET["id_detalle"]."' "; 															
										$datoscurso=executesql($sql_x);
										
										$volver_al_curso="index.php?page=sesiones&id_curso=".$datoscurso[0]["id_curso"]."&module=".$_GET["module"]."&parenttab=".$_GET["parenttab"]."";
										$volver_al_leccion="index.php?page=detalle_sesiones&id_sesion=".$datoscurso[0]["id_sesion"]."&module=".$_GET["module"]."&parenttab=".$_GET["parenttab"]."";


										echo "
													<h3 style='margin-top:0;padding-bottom:5px;' ><small  style='color:#333;'><b>Materiales de apoyo - archivos </b></small></h3>
													<p style='margin-top:0;padding-bottom:1px;' >
															<b><small  style='color:#333;'> Curso: </small></b> 
															<span style='padding-left:7px;padding-right:7px;'>››</span> 
															<small> Lección </small>  <span style='padding-left:7px;padding-right:7px;'>››</span>  <small> Clase </small> 
													</p>
													<h3 style='margin-top:0;padding-bottom:20px;' >
															<small  style='color:#333;'> <a href='".$volver_al_curso."' >".$datoscurso[0]["curso"]."</a></small> 
																			<span style='padding-left:10px;padding-right:10px;'>››</span> 
															<small style='color:#333;'> <a href='".$volver_al_leccion."' >".$datoscurso[0]["sesion"]."</a></small>  
																			<span style='padding-left:10px;padding-right:10px;'>››</span> 
															<small> <b>".$datoscurso[0]["clase"]."</b></small> 
													</h3>
													";
									?>
								</div>
				
								<div class="col-sm-2">
									<div class="btn-eai">
										<a href="<?php echo $link_detalle_archivos."&task=new"; ?>" title="Agregar" style="color:#fff;"><i class="fa fa-file" style="padding-right:5px;"></i>Agregar</a>
									</div>
								</div>
								<div class="col-sm-4 criterio_buscar">         
									<?php create_input('text','criterio_usu_per','',"form-control pull-right",$table,'Placeholder="Buscar .."'); ?>
								</div>
								<div class="col-sm-2 criterio_mostrar">          
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
var link = "archivos_detalle_sesion_virtual";
var us = "material";
var l = "os";
var l2 = "a";
var pr = "La";
var ar = "la";
var id = "idimagen";
var mypage = "archivos_detalle_sesion_virtuals.php";
</script>
<?php } ?>