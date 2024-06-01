<?php error_reporting(E_ALL ^ E_NOTICE);
include ("auten.php");

if($_GET["task"]=='neworden'){
  $bd=new BD;
  $orden_actual=$_GET["orden"];
  $orden_nuevo=$_GET["nuevoorden"];
  $tipo=$_GET["tipo"];  
  $id_del_registro_actual=$_GET["id_gratis"];
  $criterio_Orden =" ";
  nuevoorden($orden_actual, $orden_nuevo, $tipo, $id_del_registro_actual, "landing_gratis", "id_gratis", $criterio_Orden);    
  $bd->close();

}elseif($_GET["task"]=='insert' || $_GET["task"]=='update'){
  $bd=new BD;
  $where = ($_GET["task"]=='update') ? "and id_gratis!='".$_POST["id_gratis"]."'" : '';
  $urlrewrite=armarurlrewrite($_POST["titulo"]);
  $urlrewrite=armarurlrewrite($urlrewrite,1,"landing_gratis","id_gratis","titulo_rewrite",$where);

  // $campos=array('id_curso','titulo_seo','titulo', array('titulo_rewrite',$urlrewrite),'titulo_1','detalle_1','link_video','link_chat','link_externo','titulo_2','detalle_2','estado_idestado'); 
	
  $campos=array('id_curso','titulo_seo','titulo', array('titulo_rewrite',$urlrewrite),'titulo_1','detalle_1','titulo_2','detalle_2','titulo_gracias','link_gracias','estado_idestado'); 
	
  // $campos=array_merge($campos,array('fecha_inicio','hora_inicio', 'titulo_gracias','link_gracias','titulo_carta','link_carta','titulo_carta_2','activar_carta_2','link_carta_larga')); 


  if($_GET["task"]=='insert'){
    if(isset($_FILES['imagen']) && !empty($_FILES['imagen']['name'])){
      $_POST['imagen'] = carga_imagen('files/images/landing_gratis/','imagen','','400','400');
      $campos = array_merge($campos,array('imagen'));
    }
		if(isset($_FILES['banner']) && !empty($_FILES['banner']['name'])){
      $_POST['banner'] = carga_imagen('files/images/landing_gratis/','banner','','1600','650');
      $campos = array_merge($campos,array('banner'));
    }
		if(isset($_FILES['banner_2']) && !empty($_FILES['banner_2']['name'])){
      $_POST['banner_2'] = carga_imagen('files/images/landing_gratis/','banner_2','','900','400');
      $campos = array_merge($campos,array('banner_2'));
    }
		if(isset($_FILES['imagen_1']) && !empty($_FILES['imagen_1']['name'])){
      $_POST['imagen_1'] = carga_imagen('files/images/landing_gratis/','imagen_1','','370','340');
      $campos = array_merge($campos,array('imagen_1'));
    }
		
		if(isset($_FILES['imagen_2']) && !empty($_FILES['imagen_2']['name'])){
      $_POST['imagen_2'] = carga_imagen('files/images/landing_gratis/','imagen_2','','500','500');
      $campos = array_merge($campos,array('imagen_2'));
    
		}
		if(isset($_FILES['imagen_3']) && !empty($_FILES['imagen_3']['name'])){
      $_POST['imagen_3'] = carga_imagen('files/images/landing_gratis/','imagen_3','','1600','560');
      $campos = array_merge($campos,array('imagen_3'));
    }
		
		if(isset($_FILES['imagen_gracias']) && !empty($_FILES['imagen_gracias']['name'])){
      $_POST['imagen_gracias'] = carga_imagen('files/images/landing_gratis/','imagen_gracias','','700','500');
      $campos = array_merge($campos,array('imagen_gracias'));
    }
		// if(isset($_FILES['imagen_carta']) && !empty($_FILES['imagen_carta']['name'])){
      // $_POST['imagen_carta'] = carga_imagen('files/images/landing_gratis/','imagen_carta','','700','500');
      // $campos = array_merge($campos,array('imagen_carta'));
    // }
		// if(isset($_FILES['imagen_carta_2']) && !empty($_FILES['imagen_carta_2']['name'])){
      // $_POST['imagen_carta_2'] = carga_imagen('files/images/landing_gratis/','imagen_carta_2','','700','500');
      // $campos = array_merge($campos,array('imagen_carta_2'));
    // }
		
    $_POST['orden'] = _orden_noticia("","landing_gratis","");
    $_POST['fecha_registro'] = fecha_hora(2);
		
		$campos=array_merge($campos,array('fecha_registro','orden'));
		
		// echo var_dump(arma_insert('landing_gratis',$campos,'POST'));
		// exit();
		
    $_POST["id_gratis"]=$bd->inserta_(arma_insert('landing_gratis',$campos,'POST'));
		
  }else{
    if(isset($_FILES['imagen']) && !empty($_FILES['imagen']['name'])){
      $path = 'files/images/landing_gratis/'.$_POST['imagen_ant'];
      if( file_exists($path) && !empty($_POST['imagen_ant']) ) unlink($path);    
      $_POST['imagen'] = carga_imagen('files/images/landing_gratis/','imagen','','400','400');
      $campos = array_merge($campos,array('imagen'));
    }
		if(isset($_FILES['banner']) && !empty($_FILES['banner']['name'])){
      $path = 'files/images/landing_gratis/'.$_POST['imagen_ant_banner'];
      if( file_exists($path) && !empty($_POST['imagen_ant_banner']) ) unlink($path);    
      $_POST['banner'] = carga_imagen('files/images/landing_gratis/','banner','','1600','650');
      $campos = array_merge($campos,array('banner'));
    }
		if(isset($_FILES['banner_2']) && !empty($_FILES['banner_2']['name'])){
      $path = 'files/images/landing_gratis/'.$_POST['imagen_ant_banner_2'];
      if( file_exists($path) && !empty($_POST['imagen_ant_banner_2']) ) unlink($path);    
      $_POST['banner_2'] = carga_imagen('files/images/landing_gratis/','banner_2','','900','400');
      $campos = array_merge($campos,array('banner_2'));
    }
		if(isset($_FILES['imagen_1']) && !empty($_FILES['imagen_1']['name'])){
      $path = 'files/images/landing_gratis/'.$_POST['imagen_ant_1'];
      if( file_exists($path) && !empty($_POST['imagen_ant_1']) ) unlink($path);    
      $_POST['imagen_1'] = carga_imagen('files/images/landing_gratis/','imagen_1','','370','340');
      $campos = array_merge($campos,array('imagen_1'));
    }
		
		if(isset($_FILES['imagen_2']) && !empty($_FILES['imagen_2']['name'])){
      $path = 'files/images/landing_gratis/'.$_POST['imagen_ant_2'];
      if( file_exists($path) && !empty($_POST['imagen_ant_2']) ) unlink($path);    
      $_POST['imagen_2'] = carga_imagen('files/images/landing_gratis/','imagen_2','','700','500');
      $campos = array_merge($campos,array('imagen_2'));
    }

		if(isset($_FILES['imagen_3']) && !empty($_FILES['imagen_3']['name'])){
      $path = 'files/images/landing_gratis/'.$_POST['imagen_ant_3'];
      if( file_exists($path) && !empty($_POST['imagen_ant_3']) ) unlink($path);    
      $_POST['imagen_3'] = carga_imagen('files/images/landing_gratis/','imagen_3','','1600','560');
      $campos = array_merge($campos,array('imagen_3'));
    }
		
		if(isset($_FILES['imagen_gracias']) && !empty($_FILES['imagen_gracias']['name'])){
      $path = 'files/images/landing_gratis/'.$_POST['imagen_ant_gracias'];
      if( file_exists($path) && !empty($_POST['imagen_ant_gracias']) ) unlink($path);    
      $_POST['imagen_gracias'] = carga_imagen('files/images/landing_gratis/','imagen_gracias','','700','500');
      $campos = array_merge($campos,array('imagen_gracias'));
    }
		
		// if(isset($_FILES['imagen_carta']) && !empty($_FILES['imagen_carta']['name'])){
      // $path = 'files/images/landing_gratis/'.$_POST['imagen_ant_carta'];
      // if( file_exists($path) && !empty($_POST['imagen_ant_carta']) ) unlink($path);    
      // $_POST['imagen_carta'] = carga_imagen('files/images/landing_gratis/','imagen_carta','','700','500');
      // $campos = array_merge($campos,array('imagen_carta'));
    // }
		// if(isset($_FILES['imagen_carta_2']) && !empty($_FILES['imagen_carta_2']['name'])){
      // $path = 'files/images/landing_gratis/'.$_POST['imagen_ant_carta_2'];
      // if( file_exists($path) && !empty($_POST['imagen_ant_carta_2']) ) unlink($path);    
      // $_POST['imagen_carta_2'] = carga_imagen('files/images/landing_gratis/','imagen_carta_2','','700','500');
      // $campos = array_merge($campos,array('imagen_carta_2'));
    // }
		
    $bd->actualiza_(armaupdate('landing_gratis',$campos," id_gratis='".$_POST["id_gratis"]."'",'POST'));/*actualizo*/
  }

  $bd->close();
  gotoUrl("index.php?page=".$_POST["nompage"]."&module=".$_POST["nommodule"]."&parenttab=".$_POST["nomparenttab"]);

}elseif($_GET["task"]=='new' || $_GET["task"]=='edit'){
  if($_GET["task"]=='edit'){
     $data_producto=executesql("select * from landing_gratis where id_gratis='".$_GET["id_gratis"]."'",0);
  }
?>
<script src="ckeditor/sample.js"></script>
<script src="ckeditor/ckeditor.js"></script>
<script src="ckfinder/ckfinder.js"></script>

<section class="content">
  <div class="row">
    <div class="col-md-12">          
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Landing para Cursos gratuitos:  </h3>
            </div>
<?php $task_=$_GET["task"]; ?>            
            <form id="registro" action="landing_gratis.php?task=<?php echo ($task_=='edit') ?  "update" : "insert"; ?>" class="form-horizontal" method="POST" enctype="multipart/form-data" onsubmit="return aceptar()">
<?php 
if($task_=='edit') create_input("hidden","id_gratis",$data_producto["id_gratis"],"",$table,"");
create_input("hidden","urlfailed",basename($_SERVER['REQUEST_URI']),"",$table,"");  
create_input("hidden","urlgo",$link2,"",$table,"");
create_input("hidden","nompage",$_GET["page"],"",$table,""); 
create_input("hidden","nommodule",$_GET["module"],"",$table,"");
create_input("hidden","nomparenttab",$_GET["parenttab"],"",$table,"");
?>
              <div class="box-body   <?php echo !empty($_GET["id_gratis"])?'detalle_editar':'';?>  "   >
							
							
								<h3 style="font-weight:800;"><small style="color:green;">PASO 1: Lo mas importante, Aquí DATOS DE LANDING: </small></h3>
								<input type="hidden" name="tipo" value="<?php echo $_GET["tipo"];?>">
								
								<?php /*
								<div class="form-group">
                  <label for="inputPassword3" class="col-md-2 col-sm-2 control-label">Fecha inicio:  (*opcional)</label>
                  <div class="col-sm-6">
                    <?php create_input("date","fecha_inicio",$data_producto["fecha_inicio"],"form-control",$table,"",$agregado); ?>
                  </div>
                </div>
								
								<div class="form-group">
                  <label for="inputPassword3" class="col-md-2 col-sm-2 control-label">Hora Inicio: (* opcional )</label>
                  <div class="col-sm-6">
										<input type="time" id="hora_inicio" name="hora_inicio" value="<?php echo $data_producto["hora_inicio"]; ?>" >
                  </div>
                </div>
								
								
								<div class="form-group">
                  <label for="inputPassword3" class="col-md-2 col-sm-2 control-label">Imágen para Video externo </br><small style="color:red;">716px ancho * 400px alto</small></label>
                  <div class="col-sm-6">
                    <input type="file" name="imagen_3" id="imagen_3" class="form-control">
                    <?php create_input("hidden","imagen_ant_3",$data_producto["imagen_3"],"",$table,$agregado); 
                      if($data_producto["imagen_3"]!=""){ 
                    ?>
                      <img src="<?php echo "files/images/landing_gratis/".$data_producto["imagen_3"]; ?>" width="200" class="mgt15">
                    <?php } ?> 
                  </div>
                </div>
							
								<div class="form-group">
                  <label for="inputPassword3" class="col-md-2 col-sm-2 control-label">Link video vimeo:</label>
                  <div class="col-sm-6">
                    <?php create_input("text","link_video",$data_producto["link_video"],"form-control",$table,"",$agregado); ?>
                  </div>
                </div>
								<div class="form-group">
                  <label for="inputPassword3" class="col-md-2 col-sm-2 control-label">Link Chat vimeo:</label>
                  <div class="col-sm-6">
                    <?php create_input("text","link_chat",$data_producto["link_chat"],"form-control",$table,"",$agregado); ?>
                  </div>
                </div>
						
								<div class="form-group">
                  <label for="inputPassword3" class="col-md-2 col-sm-2 control-label">Link video externo:</label>
                  <div class="col-sm-6">
                    <?php create_input("text","link_externo",$data_producto["link_externo"],"form-control",$table,"",$agregado); ?>
                  </div>
                </div>
						*/ ?>
								
					
<!-- Data Pedido principal... -->
                <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                  <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingOne">
                      <h4 class="panel-title">
                        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        PASO 1: Configuración del LInk (url)  <small style="color:red;">*OBLIGATORIO</small>
                        </a>
                      </h4>
                    </div>
                    <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                      <div class="panel-body">
													<p>* Este titulo e imagen aparecen cuando compartiran el link en Redes sociales: </p>

													<div class="form-group">
														<label for="inputEmail3" class="col-md-2 col-sm-2 control-label">Estado</label>
														<div class="col-sm-3">
															<?php crearselect("estado_idestado","select * from estado where idestado in('1','2') order by 2 desc",'class="form-control"',$data_producto["estado_idestado"],""); ?>
														</div>                 
													</div>
													<div class="form-group">
														<label for="inputEmail3" class="col-md-2 col-sm-2 control-label">Seleccione el Curso gratuito:</label>
														<div class="col-sm-6">
															<?php crearselect("id_curso","select id_curso, titulo from cursos where estado_idestado=1 and id_tipo_curso=1 and id_tipo=4 order by titulo  asc",'class="form-control"',$data_producto["estado_idestado"],""); ?>
														</div>                 
													</div>
													<div class="form-group">
														<label for="inputPassword3" class="col-md-2 col-sm-2 control-label">Nombre de la ruta (url)</label>
														<div class="col-sm-6">
															<?php create_input("text","titulo",$data_producto["titulo"],"form-control",$table,"",$agregado); ?>
															<label for="inputPassword3" class="co control-label"> <small style="color:red;">( ejem: auge.com/matematica ) * este nombre es único, no repetir</small></label>
														</div>
													</div>
													<div class="form-group">
														<label for="inputPassword3" class="col-md-2 col-sm-2 control-label">Etiqueta Titulo SEO</label>
														<div class="col-sm-6">
															<?php create_input("text","titulo_seo",$data_producto["titulo_seo"],"form-control",$table,"",$agregado); ?>
														</div>
													</div>
													
													<div class="form-group">
														<label for="inputPassword3" class="col-md-2 col-sm-2 control-label">Imágen Share (400px ancho * 400px alto )</label>
														<div class="col-sm-6">
															<input type="file" name="imagen" id="imagen" class="form-control">
															<?php create_input("hidden","imagen_ant",$data_producto["imagen"],"",$table,$agregado); 
																if($data_producto["imagen"]!=""){ 
															?>
																<img src="<?php echo "files/images/landing_gratis/".$data_producto["imagen"]; ?>" width="200" class="mgt15">
															<?php } ?> 
														</div>
													</div>		
												
                      </div>
                    </div>
                  </div>
<!-- Data detalle pedido... -->                  
                  <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingTwo">
                      <h4 class="panel-title">
                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                          PASO 2: Página inicial - Formulario de Registro. <small style="color:red;">*OBLIGATORIO</small>
                        </a>
                      </h4>
                    </div>
                    <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                      <div class="panel-body">
													<div class="form-group">
														<label for="inputPassword3" class="col-md-2 col-sm-2 control-label">Título banner</label>
														<div class="col-sm-6">
															<?php create_input("text","titulo_1",$data_producto["titulo_1"],"form-control",$table,"",$agregado); ?>
														</div>
													</div>
													<div class="form-group">
														<label for="inputPassword3" class="col-md-2 col-sm-2 control-label">Banner (1600px * 650px alto)</label>
														<div class="col-sm-6">
															<input type="file" name="banner" id="banner" class="form-control">
															<?php create_input("hidden","imagen_ant_banner",$data_producto["banner"],"",$table,$agregado); 
																if($data_producto["banner"]!=""){ 
															?>
																<img src="<?php echo "files/images/landing_gratis/".$data_producto["banner"]; ?>" width="200" class="mgt15">
															<?php } ?> 
														</div>
													</div>
									
													
													<div class="form-group">
														<label for="inputPassword3" class="col-md-2 col-sm-2 control-label">Imagen  (370px ancho * 340px alto)</label>
														<div class="col-sm-6">
															<input type="file" name="imagen_1" id="imagen_1" class="form-control">
															<?php create_input("hidden","imagen_ant_1",$data_producto["imagen_1"],"",$table,$agregado); 
																if($data_producto["imagen_1"]!=""){ 
															?>
																<img src="<?php echo "files/images/landing_gratis/".$data_producto["imagen_1"]; ?>" width="200" class="mgt15">
															<?php } ?> 
														</div>
													</div>
																			

													<div class="form-group">
														<label for="inputPassword3" class="col-sm-2 control-label">Contiene (*modulos)</label>
														<div class="col-sm-10">
															<?php create_input("textarea","detalle_2",$data_producto["detalle_2"],'  ',$table,'style="height:150px!important;"');  ?>
															
														</div>
													</div>
													
												
                      </div>
                    </div>
                  </div>
               
<!-- Data Gracias por registrarte ... -->                  
                  <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingThree">
                      <h4 class="panel-title">
                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                         PASO 3:  Datos Gracias - unirte a WhatsApp  <small style="color:red;">*OBLIGATORIO</small>
                        </a>
                      </h4>
                    </div>
                    <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                      <div class="panel-body">
												
													<div class="form-group">
														<label for="inputPassword3" class="col-md-2 col-sm-2 control-label">Imagen principal #PASO 2 (700px ancho * 500px alto)</label>
														<div class="col-sm-6">
															<input type="file" name="imagen_gracias" id="imagen_gracias" class="form-control">
															<?php create_input("hidden","imagen_ant_gracias",$data_producto["imagen_gracias"],"",$table,$agregado); 
																if($data_producto["imagen_gracias"]!=""){ 
															?>
																<img src="<?php echo "files/images/landing_gratis/".$data_producto["imagen_gracias"]; ?>" width="200" class="mgt15">
															<?php } ?> 
														</div>
													</div>
													<div class="form-group">
														<label for="inputPassword3" class="col-md-2 col-sm-2 control-label">Link video #paso 2 </label>
														<div class="col-sm-6">
															<?php create_input("text","link_gracias",$data_producto["link_gracias"],"form-control",$table,"",$agregado); ?>
														</div>
													</div>
													
													<div class="form-group">
														<label for="inputPassword3" class="col-md-2 col-sm-2 control-label">Frase de franja azul </label>
														<div class="col-sm-6">
															<?php create_input("text","titulo_gracias",$data_producto["titulo_gracias"],"form-control",$table,"",$agregado); ?>
														</div>
													</div>	

													<div class="form-group">
														<label for="inputPassword3" class="col-md-2 col-sm-2 control-label">SubTítulo 1:</label>
														<div class="col-sm-6">
															<?php create_input("text","detalle_1",$data_producto["detalle_1"],"form-control",$table,"",$agregado); ?>
														</div>
													</div>
													

													<div class="form-group">
														<label for="inputPassword3" class="col-md-2 col-sm-2 control-label">Imagen debajo de subtitulo 1 (900px ancho * 400px alto)</label>
														<div class="col-sm-6">
															<input type="file" name="banner_2" id="banner_2" class="form-control">
															<?php create_input("hidden","imagen_ant_banner_2",$data_producto["banner_2"],"",$table,$agregado); 
																if($data_producto["banner_2"]!=""){ 
															?>
																<img src="<?php echo "files/images/landing_gratis/".$data_producto["banner_2"]; ?>" width="200" class="mgt15">
															<?php } ?> 
														</div>
													</div>
													
													<div class="form-group">
														<label for="inputPassword3" class="col-md-2 col-sm-2 control-label">Parrafo breve sobre certificado:</label>
														<div class="col-sm-6">
															<?php create_input("text","titulo_2",$data_producto["titulo_2"],"form-control",$table,"",$agregado); ?>
														</div>
													</div>
													<div class="form-group">
														<label for="inputPassword3" class="col-md-2 col-sm-2 control-label">Imagen del certificado (500px ancho * 500px alto)</label>
														<div class="col-sm-6">
															<input type="file" name="imagen_2" id="imagen_2" class="form-control">
															<?php create_input("hidden","imagen_ant_2",$data_producto["imagen_2"],"",$table,$agregado); 
																if($data_producto["imagen_2"]!=""){ 
															?>
																<img src="<?php echo "files/images/landing_gratis/".$data_producto["imagen_2"]; ?>" width="200" class="mgt15">
															<?php } ?> 
														</div>
													</div>
													
												<div class="form-group">
													<label for="inputPassword3" class="col-md-2 col-sm-2 control-label">Imágen banner final </br><small style="color:red;">1600px ancho * 560px alto</small></label>
													<div class="col-sm-6">
														<input type="file" name="imagen_3" id="imagen_3" class="form-control">
														<?php create_input("hidden","imagen_ant_3",$data_producto["imagen_3"],"",$table,$agregado); 
															if($data_producto["imagen_3"]!=""){ 
														?>
															<img src="<?php echo "files/images/landing_gratis/".$data_producto["imagen_3"]; ?>" width="200" class="mgt15">
														<?php } ?> 
													</div>
												</div>
								
                      </div>
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
        archivo:{ required:false,accept:'pdf,docs,doc,jpg,png' }
      }
    };
</script>
<?php
}elseif($_GET["task"]=='drop' || $_GET["task"]=='dropselect'){  
  $bd = new BD;
  $bd->Begin();
  $id_gratis = !isset($_GET['id_gratis']) ? implode(',', $_GET['chkDel']) : $_GET['id_gratis'];
  $landing_gratis = executesql("SELECT * FROM landing_gratis WHERE id_gratis IN(".$id_gratis.")");
  if(!empty($landing_gratis)){
    foreach($landing_gratis as $row){
      $pfile = 'files/images/landing_gratis/'.$row['imagen']; if(file_exists($pfile) && !empty($row['imagen'])){ unlink($pfile); }
      $pfile = 'files/images/landing_gratis/'.$row['banner']; if(file_exists($pfile) && !empty($row['banner'])){ unlink($pfile); }
      $pfile = 'files/images/landing_gratis/'.$row['banner_2']; if(file_exists($pfile) && !empty($row['banner_2'])){ unlink($pfile); }
      $pfile = 'files/images/landing_gratis/'.$row['imagen_1']; if(file_exists($pfile) && !empty($row['imagen_1'])){ unlink($pfile); }
      $pfile = 'files/images/landing_gratis/'.$row['imagen_2']; if(file_exists($pfile) && !empty($row['imagen_2'])){ unlink($pfile); }
      // $pfile = 'files/images/landing_gratis/'.$row['imagen_3']; if(file_exists($pfile) && !empty($row['imagen_3'])){ unlink($pfile); }
      $pfile = 'files/images/landing_gratis/'.$row['imagen_gracias']; if(file_exists($pfile) && !empty($row['imagen_gracias'])){ unlink($pfile); }
      // $pfile = 'files/images/landing_gratis/'.$row['imagen_carta']; if(file_exists($pfile) && !empty($row['imagen_carta'])){ unlink($pfile); }
      // $pfile = 'files/images/landing_gratis/'.$row['imagen_carta_2']; if(file_exists($pfile) && !empty($row['imagen_carta_2'])){ unlink($pfile); }
    }
  }

  $bd->actualiza_("DELETE FROM landing_gratis WHERE id_gratis IN(".$id_gratis.")");
  $bd->Commit();
  $bd->close();

}elseif($_GET["task"]=='ordenar'){

  $bd = new BD;
  $_GET['order'] = array_reverse($_GET['order']);
  foreach ($_GET['order'] as $order => $item) {
    $orden = $orden + 1;
    $bd->actualiza_("UPDATE landing_gratis SET orden= ".$orden." WHERE id_gratis = ".$item."");
  }
  $bd->Commit();
  $bd->close();

}elseif($_GET["task"]=='uestado'){

  $bd = new BD;
  $bd->Begin();

  $id_gratis = !isset($_GET['id_gratis']) ? $_GET['estado_idestado'] : $_GET['id_gratis'];
  $id_gratis = is_array($id_gratis) ? implode(',',$id_gratis) : $id_gratis;
  $landing_gratis = executesql("SELECT * FROM landing_gratis WHERE id_gratis IN (".$id_gratis.")");

  if(!empty($landing_gratis))
    foreach($landing_gratis as $reg => $item)
      if ($item['estado_idestado']==1) {
        $state = 2;
      }elseif ($item['estado_idestado']==2) {
        $state = 1;
      }
  $bd->actualiza_("UPDATE landing_gratis SET estado_idestado=".$state." WHERE id_gratis=".$id_gratis."");
  echo $state;
  $bd->Commit();
  $bd->close();

}elseif($_GET["task"]=='finder'){
	
	$array= array();
	$meses=array('Jan'=>'Enero','Feb'=>'Febrero','Mar'=>'Marzo','Apr'=>'Abril','May'=>'Mayo','Jun'=>'Junio','Jul'=>'Julio','Aug'=>'Agosto','Sep'=>'Septiembre','Oct'=>'Octubre','Nov'=>'Noviembre','Dec'=>'Diciembre');
	
  $sql = "SELECT  c.*, YEAR(c.fecha_registro) as anho, MONTH(c.fecha_registro) as mes, e.nombre as estado , cur.codigo as codigo_curso, cur.titulo as curso 
		FROM landing_gratis c 
	 INNER JOIN cursos cur ON c.id_curso=cur.id_curso 
	 INNER JOIN estado e ON c.estado_idestado=e.idestado    
	 "; 

  if(isset($_GET['criterio_usu_per']) && !empty($_GET['criterio_usu_per'])){
    $stringlike=fn_filtro(substr($_GET['criterio_usu_per'], 0, 16));
    $sql.= " and  ( c.titulo LIKE '%".$stringlike."%' and c.titulo_seo LIKE '%".$stringlike."%' and c.titulo_rewrite LIKE '%".$stringlike."%'  )  ";
  }else{
			if( empty($_GET['fechabus_1']) && empty($_GET['fechabus_2']) ) {
				$sql .= " AND MONTH(c.fecha_registro) = MONTH('".fecha_hora(1)."') ";
			}
			
	}
	
	if(!empty($_GET['fechabus_1']) && !empty($_GET['fechabus_2'])) {
			$sql .= " AND DATE(c.fecha_registro)  BETWEEN  DATE('".$_GET['fechabus_1']."')  and DATE('".$_GET['fechabus_2']."')  ";		
	}


  if(isset($_GET['criterio_ordenar_por'])) $sql.= sprintf(" order by %s %s", fn_filtro($_GET['criterio_ordenar_por']), fn_filtro($_GET['criterio_orden']));
  $sql.= "  ORDER BY c.orden DESC   ";
	
	// echo $sql; 
 
  $paging = new PHPPaging;
  $paging->agregarConsulta($sql); 
  $paging->div('div_listar');
  $paging->modo('desarrollo'); 
  $numregistro=1; 
  if($numregistro) $paging->porPagina(fn_filtro( (int)$numregistro ) );
  $paging->verPost(true);
  $mantenerVar=array("criterio_mostrar","task","criterio_usu_per","criterio_ordenar_por","criterio_orden");

  $paging->mantenerVar($mantenerVar);
  $paging->porPagina(1000); // 1000 cargas por pagina 
  $paging->ejecutar();
  $paging->pagina_proceso="landing_gratis.php";
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
								<th class="sort">DÍA </th>                
								<th class="sort">Landing </th>  
								<th class="sort">URL landing gratis </th>                
<!--								
								<th class="sort">INICIA </th>                
								<th class="sort" width="60">Vimeo </th>                
								<th class="sort" width="60">L.externo </th>   
-->								
								<th class="sort">CURSO </th>                
								<th class="sort cnone" width="60">ESTADO</th>
								<th class="unafbe "  style="width:250px;">Opciones</th>
							</tr>
	<?php }//if meses ?> 						
							
                <tr>
									<td><?php echo !empty($detalles['fecha_registro']) ? date('d',strtotime($detalles['fecha_registro'])) : '...'; ?></td>

                  <td><?php echo $detalles["titulo"]; ?></td>                                 
                  <td><a href='https://www.educaauge.com/gratis/<?php echo $detalles["titulo_rewrite"]; ?>' target="_blank">ver enlace</a></td>      
<!--									
                  <td><?php echo $detalles["fecha_inicio"]; ?></td>                                 
                  <td> <a href="<?php echo $detalles["link_video"]; ?>" target="_blank"> enlace</a> </td>                                 
                  <td> <a href="<?php echo $detalles["link_externo"]; ?>" target="_blank"> enlace</a> </td>     
-->									
                  <td><?php echo $detalles["codigo_curso"].'- <small>'.$detalles["curso"]; ?></small></td>                                 
                  <td class="cnone"><a href="javascript: fn_estado('<?php echo $detalles["id_gratis"]; ?>')"><?php echo $detalles["estado"]; ?></a></td>
                  <td>
                    <div class="btn-eai  text-center btns btr    "  style="width:200px;">				
											<a href="index.php?page=landing_gratis&module=Ver&parenttab=landing_gratis
													<?php echo $_SESSION["base_url"].'&task=edit&id_gratis='.$detalles["id_gratis"]; ?>" style="color:#fff;">editar
											</a>
											
											<a href="index.php?page=silabos_landing_gratis&id_curso=<?php echo $detalles['id_curso']; ?>&module=<?php echo $_GET['module']; ?>&parenttab=<?php echo $_GET['parenttab']; ?>"  style="background:blue;padding:6px;color:#fff;border-radius:8px;margin:0 7px;" title="Agregar silabos">
												agenda
											</a> 
											
											<!-- 
											<a href="index.php?page=landing_gratis_x_leads&id_gratis=<?php echo $detalles['id_gratis']; ?>&module=<?php echo $_GET['module']; ?>&parenttab=<?php echo $_GET['parenttab']; ?>"  style="color:#fff;" title="Ver leads">
												<i class="fa fa-eye"></i> <span> leads</span>
											</a>
-->											
										<?php  if($_SESSION["visualiza"]["idtipo_usu"] ==1){ ?>
											<a href="javascript: fn_eliminar('<?php echo $detalles["id_gratis"]; ?>')"><i class="fa fa-trash-o"></i></a>
										<?php } ?> 									

                    </div>
                  </td>
                </tr>
<?php endwhile;  ?>
              </tbody>
            </table>
            <div class="pagination"><?php echo $paging->fetchNavegacion(); ?></div>
<script>
$(function(){
  // checked();
  // sorter();
  // reordenar('landing_gratis.php');
});
var mypage = "landing_gratis.php";
</script>

<?php }else{ ?>
        <div class="box-body">
          <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
            <form action="javascript: fn_buscar();" id="frm_buscar" name="frm_buscar">
							<input type="hidden" name="module" value="<?php echo $_GET["module"];?>">
							<input type="hidden" name="parenttab" value="<?php echo $_GET["parenttab"];?>">
              <div class="bg-gray-light">
                <div class="col-md-2">
                  <div class="btn-eai">
                    <a href="<?php echo $link2."&task=new"; ?>" style="color:#fff;"><i class="fa fa-file"></i> Agregar </a>                    
                  </div>
                </div>
                <div class="col-sm-3 criterio_buscar">
                  <?php create_input('text','criterio_usu_per','',"form-control pull-right",$table,'placeholder="Buscar .."'); ?>
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
var link = "webinar";
var us = "webinar";
var ar = "la";
var l = "a";
var l2 = "a";
var pr = "La";
var id = "id_gratis";
var mypage = "landing_gratis.php";
</script>

<?php } ?>