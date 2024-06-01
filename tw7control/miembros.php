<?php
error_reporting(E_ALL ^ E_NOTICE);
include ("auten.php");


if($_GET["task"]=='update'){
  $bd=new BD;
  $miembros=array('titulo','texto','texto_2','texto_3','titulo_2','descripcion','titulo_3',"texto_4",'texto_5'); 
   
	if(isset($_FILES['banner']) && !empty($_FILES['banner']['name'])){
      $path = 'files/images/miembros/'.$_POST['imagen_ant_banner'];
      if( file_exists($path) && !empty($_POST['imagen_ant_banner']) ) unlink($path);    
      $_POST['banner'] = carga_imagen('files/images/miembros/','banner','','1600','320');
      $miembros = array_merge($miembros,array('banner'));
   }
	 
	 if(isset($_FILES['imagen']) && !empty($_FILES['imagen']['name'])){
      $path = 'files/images/miembros/'.$_POST['imagen_ant'];
      if( file_exists($path) && !empty($_POST['imagen_ant']) ) unlink($path);    
      $_POST['imagen'] = carga_imagen('files/images/miembros/','imagen','','400','400');
      $miembros = array_merge($miembros,array('imagen'));
   }
	if(isset($_FILES['imagen2']) && !empty($_FILES['imagen2']['name'])){
      $path = 'files/images/miembros/'.$_POST['imagen_ant2'];
      if( file_exists($path) && !empty($_POST['imagen_ant2']) ) unlink($path);    
      $_POST['imagen2'] = carga_imagen('files/images/miembros/','imagen2','','400','400');
      $miembros = array_merge($miembros,array('imagen2'));
   }
	 
	$bd->actualiza_(armaupdate('miembros',$miembros," id='1'",'POST'));
  
  $bd->close();
  gotoUrl("index.php?page=".$_POST["nompage"]."&tipo=".$_POST["tipo"]."&module=".$_POST["nommodule"]."&parenttab=".$_POST["nomparenttab"]);

}else{  
	$data_producto=executesql("select * from miembros where id='1'",0);  
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
              <h3 class="box-title"> Sección Miembros </h3>
            </div><!-- /.box-header -->
<?php $task_=$_GET["task"]; ?>
            <!-- form start -->
            <form id="registro" action="miembros.php?task=update" class="form-horizontal" method="POST" enctype="multipart/form-data">
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
					
					<?php /* 								
							 <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Banner (1600px ancho * 320px alto)</label>
                  <div class="col-sm-6">
                    <input type="file" name="banner" id="banner" class="form-control">
                    <?php create_input("hidden","imagen_ant_banner",$data_producto["banner"],"",$table,$agregado); 
                      if($data_producto["banner"]!=""){ 
                    ?>
                      <img src="<?php echo "files/images/miembros/".$data_producto["banner"]; ?>" width="200" class="mgt15">
                    <?php } ?> 
                  </div>
                </div>
								*/ ?>
								
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Título 1 banner:</label>
                  <div class="col-sm-6">
                    <?php create_input("text","titulo",$data_producto["titulo"],"form-control",$table,"",$agregado); ?>
                  </div>
                </div>
								<div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Texto 1:  debajo del Titulo 1:</label>
                  <div class="col-sm-6">
                    <?php create_input("textarea","texto",$data_producto["texto"],"form-control",$table,"style='height:250px;'",""); ?>
										<script>
                    var editor11_1 = CKEDITOR.replace('texto');
                    CKFinder.setupCKEditor( editor11_1, 'ckfinder/' );
                    </script> 
                  </div>
                </div>
		
								<div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Texto 2: "icono pregunta"</label>
                  <div class="col-sm-6">
                    <?php create_input("textarea","texto_2",$data_producto["texto_2"],"form-control",$table,"style='height:250px;'",$agregado); ?>
											<script>
                    var editor11_2 = CKEDITOR.replace('texto');
                    CKFinder.setupCKEditor( editor11_2, 'ckfinder/' );
                    </script> 
                  </div>
                </div>
								<div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Texto 3: "icono email"</label>
                  <div class="col-sm-6">
                    <?php create_input("textarea","texto_3",$data_producto["texto_3"],"form-control",$table,"style='height:250px;'",$agregado); ?>
											<script>
                    var editor11_3 = CKEDITOR.replace('texto');
                    CKFinder.setupCKEditor( editor11_3, 'ckfinder/' );
                    </script> 
                  </div>
                </div>
								
								<div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Título 2:</label>
                  <div class="col-sm-6">
                    <?php create_input("text","titulo_2",$data_producto["titulo_2"],"form-control",$table,"",$agregado); ?>
                  </div>
                </div>
								
								<div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Descripción: </label>
                  <div class="col-sm-10">
                    <?php create_input("textarea","descripcion",$data_producto["descripcion"],"",$table,$agregado);  ?>
                    <script>
                    var editor11 = CKEDITOR.replace('descripcion');
                    CKFinder.setupCKEditor( editor11, 'ckfinder/' );
                    </script> 
                  </div>
                </div>
								
								<div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Link Grupo de Facebook</label>
                  <div class="col-sm-6">
                    <?php create_input("text","link_facebook",$data_producto["link_facebook"],"form-control",$table,"",$agregado); ?>
                  </div>
                </div>
								
								<div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Título 3: "final"</label>
                  <div class="col-sm-6">
                    <?php create_input("text","titulo_3",$data_producto["titulo_3"],"form-control",$table,"",$agregado); ?>
                  </div>
                </div>
								
								<div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Texto 4:  "icono pregunta final"</label>
                  <div class="col-sm-6">
                    <?php create_input("textarea","texto_4",$data_producto["texto_4"],"form-control",$table,"style='height:250px;'",""); ?>
										<script>
                    var editor11_4 = CKEDITOR.replace('texto_4');
                    CKFinder.setupCKEditor( editor11_4, 'ckfinder/' );
                    </script> 
                  </div>
                </div>
		
								<div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Texto 5:  "icono email final"</label>
                  <div class="col-sm-6">
                    <?php create_input("textarea","texto_5",$data_producto["texto_5"],"form-control",$table,"style='height:250px;'",""); ?>
										<script>
                    var editor11_5 = CKEDITOR.replace('texto_5');
                    CKFinder.setupCKEditor( editor11_5, 'ckfinder/' );
                    </script> 
                  </div>
                </div>
		
								
								<?php /*
								 <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Imágen 1</label>
                  <div class="col-sm-6">
                    <input type="file" name="imagen" id="imagen" class="form-control">
                    <?php create_input("hidden","imagen_ant",$data_producto["imagen"],"",$table,$agregado); 
                      if($data_producto["imagen"]!=""){ 
                    ?>
                      <img src="<?php echo "files/images/miembros/".$data_producto["imagen"]; ?>" width="200" class="mgt15">
                    <?php } ?> 
                  </div>
                </div>
                
								 <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Imágen 2</label>
                  <div class="col-sm-6">
                    <input type="file" name="imagen2" id="imagen2" class="form-control">
                    <?php create_input("hidden","imagen_ant2",$data_producto["imagen2"],"",$table,$agregado); 
                      if($data_producto["imagen2"]!=""){ 
                    ?>
                      <img src="<?php echo "files/images/miembros/".$data_producto["imagen2"]; ?>" width="200" class="mgt15">
                    <?php } ?> 
                  </div>
                </div>
                */ ?>
							
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