<?php
error_reporting(E_ALL ^ E_NOTICE);
include ("auten.php");


if($_GET["task"]=='update'){
  $bd=new BD;
  $campos=array('titulo','titulo_1','titulo_cursos','titulo_testimonios','titulo_testimonios_2','detalle_titulo_docentes',"link","descripcion"); 
  if(isset($_FILES['imagen']) && !empty($_FILES['imagen']['name'])){
      $path = 'files/images/portada/'.$_POST['imagen_ant'];
      if( file_exists($path) && !empty($_POST['imagen_ant']) ) unlink($path);    
      $_POST['imagen'] = carga_imagen('files/images/portada/','imagen','','632','473');
      $campos = array_merge($campos,array('imagen'));
    }
		
	// echo var_dump(armaupdate('portada',$campos," id='".$_POST["id"]."'",'POST'));
	// exit();
	 
	$bd->actualiza_(armaupdate('portada',$campos," id='1'",'POST'));
  
  $bd->close();
  gotoUrl("index.php?page=".$_POST["nompage"]."&tipo=".$_POST["tipo"]."&module=".$_POST["nommodule"]."&parenttab=".$_POST["nomparenttab"]);

}else{  
	$data_producto=executesql("select * from portada where id='1'",0);  
?>

<section class="content">
  <div class="row">
    <div class="col-md-12">
          <!-- Horizontal Form -->
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title"> Portada </h3>
              <p style="color:red;">*Ubicacion:  Esta configuración afecta a la portada de la web. Ruta: <?php echo $_dominio; ?></p>

            </div><!-- /.box-header -->
<?php $task_=$_GET["task"]; ?>
            <!-- form start -->
            <form id="registro" action="campos.php?task=update" class="form-horizontal" method="POST" enctype="multipart/form-data">
<?php 
if($task_=='edit') create_input("hidden","id",$data_producto["id"],"",$table,"");
create_input("hidden","urlfailed",basename($_SERVER['REQUEST_URI']),"",$table,"");  
create_input("hidden","urlgo",$link,"",$table,"");
create_input("hidden","nompage",$_GET["page"],"",$table,""); 
create_input("hidden","nommodule",$_GET["module"],"",$table,"");
create_input("hidden","nomparenttab",$_GET["parenttab"],"",$table,"");
?>
              <div class="box-body">
								<input type="hidden" name="tipo" value="<?php echo $_GET["tipo"];?>">              

                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Título </label>
                  <div class="col-sm-6">
                    <?php create_input("text","titulo_1",$data_producto["titulo_1"],"form-control",$table,"",$agregado); ?>
                  </div>
                </div>
								
								<div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Sub Título</label>
                  <div class="col-sm-6">
                    <?php create_input("text","titulo",$data_producto["titulo"],"form-control",$table,"",$agregado); ?>
                  </div>
                </div>
								<div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">  titulo SECCION cursos</label>
                  <div class="col-sm-6">
                    <?php create_input("text","titulo_cursos",$data_producto["titulo_cursos"],"form-control",$table,"",$agregado); ?>
                  </div>
                </div>
								<div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">  titulo SECCION testimonios</label>
                  <div class="col-sm-6">
                    <?php create_input("text","titulo_testimonios",$data_producto["titulo_testimonios"],"form-control",$table,"",$agregado); ?>
                  </div>
                </div>
								<div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">  texto debajo de titulo testimonios</label>
                  <div class="col-sm-6">
                    <?php create_input("text","titulo_testimonios_2",$data_producto["titulo_testimonios_2"],"form-control",$table,"",$agregado); ?>
                  </div>
                </div>                                            
                
                <div class="form-group">
								  <label for="inputPassword3" class="col-sm-2 control-label">Descripcion seccion lleva imagen-video</label>
                  <div class="col-sm-6">
                    <?php create_input("textarea","descripcion",$data_producto["descripcion"],"form-control",$table,"",$agregado); ?>
                  </div>
                </div>
								
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Link video [ youtube]</label>
                  <div class="col-sm-6">
                    <p>ejem: https://www.youtube.com/watch?v=LfwVGlW237o</p>
                    <?php create_input("text","link",$data_producto["link"],"form-control",$table,"",$agregado); ?>
										<iframe frameborder="0" width="100%" height="200" class="lvideo"></iframe>
                  </div>
                </div>

                 <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Imágen</label>
                  <div class="col-sm-6">
                    <input type="file" name="imagen" id="imagen" class="form-control">
                    <?php create_input("hidden","imagen_ant",$data_producto["imagen"],"",$table,$agregado); 
                      if($data_producto["imagen"]!=""){ 
                    ?>
                      <img src="<?php echo "files/images/portada/".$data_producto["imagen"]; ?>" width="200" class="mgt15">
                    <?php } ?>
                    <small style="color:red">Recomendado: 632 x 473</small>
                  </div>
                </div>
								
                <div class="form-group">
								  <label for="inputPassword3" class="col-sm-2 control-label"> --------------------------------------------------</label>           
                </div>
                <div class="form-group">
								  <label for="inputPassword3" class="col-sm-2 control-label">Descripcion Docentes: en detalle de un curso </label>
                  <div class="col-sm-6">
                    <?php create_input("textarea","detalle_titulo_docentes",$data_producto["detalle_titulo_docentes"],"form-control",$table,"",$agregado); ?>
                  </div>
                </div>
							
              </div>
              <div class="box-footer">
                <div class="form-group">
                  <div class="col-sm-10 pull-right">
                    <button type="submit" class="btn bg-blue btn-flat">Guardar</button>
                    <button type="button" class="btn bg-red btn-flat" onclick="javascript:gotourl('<?php echo $link; ?>');">Cancelar</button>
                  </div>
                </div>
              </div>
            </form>
          </div><!-- /.box -->
        </div><!--/.col (right) -->
  </div>
</section><!-- /.content -->
<?php } ?>