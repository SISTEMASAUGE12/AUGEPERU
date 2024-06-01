<?php
error_reporting(E_ALL ^ E_NOTICE);
include ("auten.php");


if($_GET["task"]=='update'){
  $bd=new BD;
  $nosotros=array('titulo','texto','mision','vision',"descripcion"); 
   
	if(isset($_FILES['imagen']) && !empty($_FILES['imagen']['name'])){
      $path = 'files/images/nosotros/'.$_POST['imagen_ant'];
      if( file_exists($path) && !empty($_POST['imagen_ant']) ) unlink($path);    
      $_POST['imagen'] = carga_imagen('files/images/nosotros/','imagen','');
      $nosotros = array_merge($nosotros,array('imagen'));
   }
	if(isset($_FILES['imagen2']) && !empty($_FILES['imagen2']['name'])){
      $path = 'files/images/nosotros/'.$_POST['imagen_ant2'];
      if( file_exists($path) && !empty($_POST['imagen_ant2']) ) unlink($path);    
      $_POST['imagen2'] = carga_imagen('files/images/nosotros/','imagen2','');
      $nosotros = array_merge($nosotros,array('imagen2'));
   }
	 
	$bd->actualiza_(armaupdate('nosotros',$nosotros," id='1'",'POST'));
  
  $bd->close();
  gotoUrl("index.php?page=".$_POST["nompage"]."&tipo=".$_POST["tipo"]."&module=".$_POST["nommodule"]."&parenttab=".$_POST["nomparenttab"]);

}else{  
	$data_producto=executesql("select * from nosotros where id='1'",0);  
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
              <h3 class="box-title"> Nosotros </h3>
            </div><!-- /.box-header -->
<?php $task_=$_GET["task"]; ?>
            <!-- form start -->
            <form id="registro" action="nosotros.php?task=update" class="form-horizontal" method="POST" enctype="multipart/form-data">
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
                  <label for="inputPassword3" class="col-sm-2 control-label">Título:</label>
                  <div class="col-sm-6">
                    <?php create_input("text","titulo",$data_producto["titulo"],"form-control",$table,"",$agregado); ?>
                  </div>
                </div>
								<div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Texto debajo del Titulo:</label>
                  <div class="col-sm-6">
                    <?php create_input("textarea","texto",$data_producto["texto"],"form-control",$table,"style='height:250px;'",""); ?>
                  </div>
                </div>
								
								<?php /*
								<div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Mision:</label>
                  <div class="col-sm-6">
                    <?php create_input("textarea","mision",$data_producto["mision"],"form-control",$table,"style='height:250px;'",$agregado); ?>
                  </div>
                </div>
								<div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Vision:</label>
                  <div class="col-sm-6">
                    <?php create_input("textarea","vision",$data_producto["vision"],"form-control",$table,"style='height:250px;'",$agregado); ?>
                  </div>
                </div>
								
								*/ 
								?>
								
								
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
								
								<?php /*
								 <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Imágen 1</label>
                  <div class="col-sm-6">
                    <input type="file" name="imagen" id="imagen" class="form-control">
                    <?php create_input("hidden","imagen_ant",$data_producto["imagen"],"",$table,$agregado); 
                      if($data_producto["imagen"]!=""){ 
                    ?>
                      <img src="<?php echo "files/images/nosotros/".$data_producto["imagen"]; ?>" width="200" class="mgt15">
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
                      <img src="<?php echo "files/images/nosotros/".$data_producto["imagen2"]; ?>" width="200" class="mgt15">
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