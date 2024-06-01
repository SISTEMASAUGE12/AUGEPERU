<?php
error_reporting(E_ALL ^ E_NOTICE);
include ("auten.php");


if($_GET["task"]=='neworden'){
  $bd=new BD;
  $orden_actual=$_GET["orden"];
  $orden_nuevo=$_GET["nuevoorden"];
  $tipo=$_GET["tipo"];  
  $id_del_registro_actual=$_GET["idpublicacion"];
  $criterio_Orden =" ";
  nuevoorden($orden_actual, $orden_nuevo, $tipo, $id_del_registro_actual, "publicacion", "idpublicacion", $criterio_Orden);    
  $bd->close();

}elseif($_GET["task"]=='insert' || $_GET["task"]=='update'){
  $bd=new BD;
  $where = ($_GET["task"]=='update') ? "and idpublicacion!='".$_POST["idpublicacion"]."'" : '';
  $urlrewrite=armarurlrewrite($_POST["titulo"]);
  $urlrewrite=armarurlrewrite($urlrewrite,1,"publicacion","idpublicacion","titulo_rewrite",$where);

  $campos=array('titulo', array('titulo_rewrite',$urlrewrite),"tipo",'credito','link_grupo_wasap','link','link_externo','avance',"descripcion","estado_idestado"); 
  
  if($_GET["task"]=='insert'){
    if(isset($_FILES['imagen']) && !empty($_FILES['imagen']['name'])){
      $_POST['imagen'] = carga_imagen('files/images/publicaciones/','imagen','','800','500');
      $campos = array_merge($campos,array('imagen'));
    }
    if(isset($_FILES['archivo']) && !empty($_FILES['archivo']['name'])){
      $_POST['archivo'] = upload_files('files/files/','archivo','',0);
      $campos = array_merge($campos,array('archivo'));
    }
    $_POST['orden'] = _orden_noticia("","publicacion","");
    $_POST['fecha_registro'] = fecha_hora(2);
		
		// echo var_dump(arma_insert('publicacion',array_merge($campos,array('fecha_registro','orden')),'POST'));
		// exit();
		
    $_POST["idusuario"]= $_SESSION["visualiza"]["idusuario"];
		
    $bd->inserta_(arma_insert('publicacion',array_merge($campos,array('fecha_registro','orden','idusuario')),'POST'));
		
		
  }else{
    if(isset($_FILES['imagen']) && !empty($_FILES['imagen']['name'])){
      $path = 'files/images/publicaciones/'.$_POST['imagen_ant'];
      if( file_exists($path) && !empty($_POST['imagen_ant']) ) unlink($path);    
      $_POST['imagen'] = carga_imagen('files/images/publicaciones/','imagen','','800','500');
      $campos = array_merge($campos,array('imagen'));
    }
    if(isset($_FILES['archivo']) && !empty($_FILES['archivo']['name'])){
      $path = 'files/files/'.$_POST['imagen_ant'];
      if( file_exists($path) && !empty($_POST['imagen_ant']) ) unlink($path);    
      $_POST['archivo'] = carga_imagen('files/files/','archivo','');
      $campos = array_merge($campos,array('archivo'));
    }

    $_POST["idusuario_modifico"]= $_SESSION["visualiza"]["idusuario"];
    $_POST['fecha_modifico'] = fecha_hora(2);

    
    $campos=array_merge($campos,array('fecha_modifico','idusuario_modifico'));



    $bd->actualiza_(armaupdate('publicacion',$campos," idpublicacion='".$_POST["idpublicacion"]."'",'POST'));/*actualizo*/
  }
  $bd->close();
  gotoUrl("index.php?page=".$_POST["nompage"]."&tipo=".$_POST["tipo"]."&module=".$_POST["nommodule"]."&parenttab=".$_POST["nomparenttab"]);

}elseif($_GET["task"]=='new' || $_GET["task"]=='edit'){
  if($_GET["task"]=='edit'){
     $data_producto=executesql("select * from publicacion where idpublicacion='".$_GET["idpublicacion"]."'",0);
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
              <h3 class="box-title"> Publicación </h3>
            </div><!-- /.box-header -->
<?php $task_=$_GET["task"]; ?>
            <!-- form start -->
            <form id="registro" action="publicaciones.php?task=<?php echo ($task_=='edit') ?  "update" : "insert"; ?>" class="form-horizontal" method="POST" enctype="multipart/form-data"  onsubmit="return aceptar()">
<?php 
if($task_=='edit') create_input("hidden","idpublicacion",$data_producto["idpublicacion"],"",$table,"");
create_input("hidden","urlfailed",basename($_SERVER['REQUEST_URI']),"",$table,"");  
create_input("hidden","urlgo",$link,"",$table,"");
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
                  <label for="inputEmail3" class="col-sm-2 control-label">Categoria</label>
                  <div class="col-sm-6">
                    <?php crearselect("tipo","select * from categoriablogs where estado_idestado=1 order by titulo asc",'class="form-control"',$data_producto["tipo"],"-- seleccione categ --"); ?>
                  </div>
                </div>


                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Título</label>
                  <div class="col-sm-6">
                    <?php create_input("text","titulo",$data_producto["titulo"],"form-control",$table,"",$agregado); ?>
                  </div>
                </div>				
								
								<div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Breve detalle</label>
                  <div class="col-sm-6">
                    <?php create_input("textarea","avance",$data_producto["avance"],"form-control",$table,"",$agregado); ?>
                  </div>
                </div>
				
				<div class="form-group">
					<label for="inputPassword3" class="col-sm-2 control-label">Link video youtube - principal</label>
					<div class="col-sm-6">
						<?php create_input("text","link",$data_producto["link"],"form-control",$table,"",$agregado); ?>
						<iframe frameborder="0" width="100%" height="200" class="lvideo"></iframe>
					</div>
				</div>
				
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Imágen</br> <small>800px ancho * 500px alto</small></label>
                  <div class="col-sm-6">
                    <input type="file" name="imagen" id="imagen" class="form-control">
                    <?php create_input("hidden","imagen_ant",$data_producto["imagen"],"",$table,$agregado); 
                      if($data_producto["imagen"]!=""){ 
                    ?>
                      <img src="<?php echo "files/images/publicaciones/".$data_producto["imagen"]; ?>" width="200" class="mgt15">
                    <?php } ?> 
                  </div>
                </div>
								<div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Creditos y fuente: </label>
                  <div class="col-sm-6">
                    <?php create_input("text","credito",$data_producto["credito"],"form-control",$table,"",$agregado); ?>
                  </div>
                </div>	
                
								<div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Link grupo whatsapp: (*para trafico) </label>
                  <div class="col-sm-6">
                    <?php create_input("text","link_grupo_wasap",$data_producto["link_grupo_wasap"],"form-control",$table,"",$agregado); ?>
                  </div>
                </div>	
                
			<?php /* 
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
 */  ?>
            
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
								
								<div class="form-group">
									<label for="inputPassword3" class="col-sm-2 control-label">Link video youtube - final</label>
									<div class="col-sm-6">
										<?php create_input("text","link_externo",$data_producto["link_externo"],"form-control",$table,"",$agregado); ?>
										<!--
										<iframe frameborder="0" width="100%" height="200" class="lvideo"></iframe>
										-->
									</div>
								</div>
				
								
              </div>
              <div class="form-group">
                  <div class="col-sm-10 pull-right">
                    <input  type="submit"  class="btn bg-blue btn-flat" id="btnguardar" value="Guardar">
                    <button type="button" class="btn bg-red btn-flat" onclick="javascript:gotourl('<?php echo $link; ?>');">Cancelar</button>
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
		alert("Recomendación: Ingrese título., imagen , breve detalle, descripción !");
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
        // archivo:{ required:false,accept:'pdf,docs,doc,jpg,png' }
      }
    };
</script>
<?php
}elseif($_GET["task"]=='drop' || $_GET["task"]=='dropselect'){  
  $bd = new BD;
  $bd->Begin();
  $ide = !isset($_GET['idpublicacion']) ? implode(',', $_GET['chkDel']) : $_GET['idpublicacion'];
  $publicacion = executesql("SELECT * FROM publicacion WHERE idpublicacion IN(".$ide.")");
  if(!empty($publicacion)){
    foreach($publicacion as $row){
      $pfile = 'files/images/publicaciones/'.$row['imagen']; if(file_exists($pfile) && !empty($row['imagen'])){ unlink($pfile); }
      $pfile = 'files/files/'.$row['archivo']; if(file_exists($pfile) && !empty($row['archivo'])){ unlink($pfile); }
    }
  }

  $bd->actualiza_("DELETE FROM publicacion WHERE idpublicacion IN(".$ide.")");
  $bd->Commit();
  $bd->close();

}elseif($_GET["task"]=='ordenar'){

  $bd = new BD;
  $_GET['order'] = array_reverse($_GET['order']);
  foreach ($_GET['order'] as $order => $item) {
    $orden = $orden + 1;
    $bd->actualiza_("UPDATE publicacion SET orden= ".$orden." WHERE   idpublicacion = ".$item."");
  }
  $bd->Commit();
  $bd->close();

}elseif($_GET["task"]=='uestado'){

  $bd = new BD;
  $bd->Begin();

  $ide = !isset($_GET['idpublicacion']) ? $_GET['estado_idestado'] : $_GET['idpublicacion'];
  $ide = is_array($ide) ? implode(',',$ide) : $ide;
  $publicacion = executesql("SELECT * FROM publicacion WHERE idpublicacion IN (".$ide.")");

  if(!empty($publicacion))
    foreach($publicacion as $reg => $item)
      if ($item['estado_idestado']==1) {
        $state = 2;
      }elseif ($item['estado_idestado']==2) {
        $state = 1;
      }
  $bd->actualiza_("UPDATE publicacion SET estado_idestado=".$state." WHERE idpublicacion=".$ide."");
  echo $state;
  $bd->Commit();
  $bd->close();

}elseif($_GET["task"]=='finder'){
	  $array= array();
	$meses=array('Jan'=>'Enero','Feb'=>'Febrero','Mar'=>'Marzo','Apr'=>'Abril','May'=>'Mayo','Jun'=>'Junio','Jul'=>'Julio','Aug'=>'Agosto','Sep'=>'Septiembre','Oct'=>'Octubre','Nov'=>'Noviembre','Dec'=>'Diciembre');
	
  $sql = "
        SELECT p.*,YEAR(p.fecha_registro) as anho, MONTH(p.fecha_registro) as mes,  cc.titulo as categ, e.nombre as estado , u.nomusuario  as usuario 
            FROM publicacion p 
						inner join estado e ON p.estado_idestado=e.idestado   
						inner  join categoriablogs cc ON cc.tipo=p.tipo  
            LEFT JOIN usuario u ON  p.idusuario=u.idusuario 
          WHERE p.estado_idestado=e.idestado 
		";
					
  if(isset($_GET['criterio_mostrar'])) $porPagina=$_GET['criterio_mostrar'];
	if(isset($_GET['criterio_usu_per']) && !empty($_GET['criterio_usu_per'])){
    $stringlike=fn_filtro(substr($_GET['criterio_usu_per'], 0, 16));
    $sql.= " and  ( p.titulo LIKE '%".$stringlike."%'  )  ";
  }else{
			if( empty($_GET['fechabus_1']) && empty($_GET['fechabus_2']) ) {
				$sql .= " AND DATE(p.fecha_registro) = '" . fecha_hora(1) . "'";
			}
			
	}
	
	if(!empty($_GET['fechabus_1']) && !empty($_GET['fechabus_2'])) {
			$sql .= " AND DATE(p.fecha_registro)  BETWEEN  DATE('".$_GET['fechabus_1']."')  and DATE('".$_GET['fechabus_2']."')  ";		
	}

  $sql.= "  ORDER BY p.orden DESC";
	
	//  echo $sql;
	
 $paging = new PHPPaging;
  $paging->agregarConsulta($sql); 
  $paging->div('div_listar');
  $paging->modo('desarrollo'); 
  $numregistro=1; 
  if($numregistro) $paging->porPagina(fn_filtro((int)$numregistro));
  $paging->verPost(true);
  $mantenerVar=array("criterio_mostrar","task","criterio_usu_per","criterio_ordenar_por","criterio_orden");

  $paging->mantenerVar($mantenerVar);
  $paging->porPagina(1000);
  $paging->ejecutar();
  $paging->pagina_proceso="publicaciones.php";
?>
            <table id="example1" class="table table-bordered table-striped">
    <tbody id="sort">
              
<?php 
		while ($detalles = $paging->fetchResultado()): 
			if(!in_array(array('mes' => $detalles['mes'], 'anho' => $detalles['anho']), $array)){
				$array[] = array('mes' => $detalles['mes'], 'anho' => $detalles['anho']);
?>
				<tr class="lleva-mes">
					<td colspan="9"><h6><?php echo strtoupper(strtr(date('M Y',strtotime($detalles['fecha_registro'])),$meses)); ?></h6></td>
				</tr>
								<tr role="row">
									<th width="30">Día</th>
                  <th class="sort cnone ">CATEG</th>
                  <th class="sort">TÍTULO</th>
                  <th class="sort cnone ">link trafico</th>
                  <th class="sort cnone ">link wasap</th>
                  <th class="sort cnone ">VISTAS</th>
                  <th class="unafbe cnone">IMÁGEN</th>
                  <th class="sort cnone">FECHA</th>
                  <th class="sort cnone" width="150">USUARIO</th>
                  <th class="sort cnone">ESTADO</th>
                  <th class="unafbe" width="160">Opciones</th>
                </tr>
<?php }//if meses ?>

                <tr >
									<td><?php echo !empty($detalles['fecha_registro']) ? date('d',strtotime($detalles['fecha_registro'])) : '...'; ?></td>
                  <td class=" cnone "><?php echo $detalles["categ"]; ?></td>                
                  <td><?php echo $detalles["titulo"]; ?></td>                
                  <td class=" cnone "><a href="https://www.educaauge.com/blogs/<?php echo $detalles["titulo_rewrite"]; ?>" target="_blank">Link trafico</a> </td>                
                  <td class=" cnone ">
                    <?php if(!empty($detalles["link_grupo_wasap"])){ ?>
											<a href="<?php echo $detalles["link_grupo_wasap"]; ?>" target="_blank">ver wasap</a> 
                    <?php }else{ echo "Not Image."; } ?>
									</td>                
                  <td class=" cnone " ><?php 
												$conta=executesql("SELECT count(*) as total_vistas FROM contador WHERE publica='".$detalles["idpublicacion"]."' ");
												echo $conta[0]["total_vistas"]; 
											?>
									</td>                
                  <td class="cnone">
                    <?php if(!empty($detalles["imagen"])){ ?>
                    <img src="<?php echo "files/images/publicaciones/".$detalles["imagen"]; ?>" alt="<?php echo $detalles["titulo"]; ?>" class="img-responsive">
                    <?php }else{ echo "Not Image."; } ?>
                  </td>
									
									<?php /* 
									<td class="cnone">
                    <?php if(!empty($detalles["archivo"])){ ?>
                    <a href="<?php echo "files/files/".$detalles["archivo"]; ?>" target="_blank"> <img src="dist/img/icons/icon-pdf.jpg"></a> 
                    <?php }else{ echo "Not file."; } ?>
                  </td>
									*/ ?>
									
                  <td class="cnone"><?php echo fecha($detalles['fecha_registro']); ?></td>
                  <td class="cnone"><?php 
                      echo $detalles['idusuario'] .' -> '. $detalles['usuario']; 

                      if( !empty($detalles['idusuario_modifico']) ){
                        echo " <br> -------------- <br> ";
                        // echo "select * from usuario WHERE idusuario='".$detalles['idusuario_modifico']."' ";
                        $modifico=executesql("select * from usuario  WHERE idusuario='".$detalles['idusuario_modifico']."' ");
                          echo "Modificado por: ".$modifico[0]["nomusuario"].' <br> '.$detalles["fecha_modifico"] ;
                      }
                    ?>
                
                  </td>
                  <td class="cnone"><a href="javascript: fn_estado('<?php echo $detalles["idpublicacion"]; ?>')"><?php echo $detalles["estado"]; ?></a></td>
                  <td>
                    <div class="btn-eai btns btr text-center ">
                      <a href="<?php echo $_SESSION["base_url"].'&task=edit&idpublicacion='.$detalles["idpublicacion"]; ?>"><i class="fa fa-edit"></i></a>
                      <a href="index.php?page=categoria_archivos&publicacion_idpublicacion=<?php echo $detalles['idpublicacion']; ?>&module=<?php echo $_GET['module']; ?>&parenttab=<?php echo $_GET['parenttab']; ?>" style="color:white;">Cate. Archivo</a>
											<!--
                      <a href="javascript: fn_eliminar('<?php echo $detalles["idpublicacion"]; ?>')"><i class="fa fa-trash-o"></i></a>
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
  reordenar('publicaciones.php');
});
var mypage = "publicaciones.php";
</script>

<?php }else{ ?>
        <div class="box-body">
          <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
            <form action="javascript: fn_buscar();" id="frm_buscar" name="frm_buscar">
              <input type="hidden" name="module" value="<?php echo $_GET["module"];?>">
              <input type="hidden" name="parenttab" value="<?php echo $_GET["parenttab"];?>">
							<input type="hidden" name="tipo" value="<?php echo $_GET["tipo"];?>">
              <div class="bg-gray-light">
                <div class="col-sm-2">
                  <div class="btn-eai">
                    <a href="<?php echo $link."&task=new"; ?>" style="color:#fff;"><i class="fa fa-file"></i> Agregar</a>                    
                  </div>
                </div>
                <div class="col-sm-3 criterio_buscar">
                  <?php create_input('text','criterio_usu_per','',"form-control pull-right",$table,$agregados); ?>
                </div>
								 <div class="col-sm-7 criterio_mostrar">
									<div class="lleva_flechas" style="position:relative;">
										<label>Desde:</label>
										<?php create_input('date', 'fechabus_1', '', "form-control pull-right", $table, ''); ?>
									</div>
									<div class="lleva_flechas" style="position:relative;">
										<label>Hasta:</label>
										<?php create_input('date', 'fechabus_2', '', "form-control pull-right", $table, ''); ?>
									</div>
										<button>Buscar</button>
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
var us = "publicación";
var link = "publicacione";
var ar = "la";
var l = "a";
var l2 = "a";
var pr = "La";
var id = "idpublicacion";
var mypage = "publicaciones.php";
</script>

<?php } ?>