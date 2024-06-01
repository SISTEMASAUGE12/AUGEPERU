<?php
error_reporting(E_ALL ^ E_NOTICE);
include_once("auten.php");

if ($_GET["task"]=='update'){
  
    $bd=new BD;
    // $campos=array('nombre','tel1','tel2','tel3','wasap','correo','web','direccion','link_mapa_google','mostrar_solo_inicio_de_sesion_index','mostrar_formularios_registro_en_banners');
    $campos=array('nombre');
		
    if(isset($_FILES['logo']) && !empty($_FILES['logo']['name'])){
      $path = 'files/ajustes/'.$_POST['imagen_ant'];
      if( file_exists($path) && !empty($_POST['imagen_ant']) ) unlink($path);    
      $_POST['logo'] = carga_imagen('files/ajustes/','logo','','223','223');
      $campos = array_merge($campos,array('logo'));
    }
		
		if(isset($_FILES['logo_movil']) && !empty($_FILES['logo_movil']['name'])){
      $path = 'files/ajustes/'.$_POST['imagen_ant_2'];
      if( file_exists($path) && !empty($_POST['imagen_ant_2']) ) unlink($path);    
      $_POST['logo_movil'] = carga_imagen('files/ajustes/','logo_movil','','223','223');
      $campos = array_merge($campos,array('logo_movil'));
    }
		
		if(isset($_FILES['img_face']) && !empty($_FILES['img_face']['name'])){
      $path = 'files/ajustes/'.$_POST['imagen_ant_3'];
      if( file_exists($path) && !empty($_POST['imagen_ant_3']) ) unlink($path);    
      $_POST['img_face'] = carga_imagen('files/ajustes/','img_face','','223','223');
      $campos = array_merge($campos,array('img_face'));
    }
		
		if(isset($_FILES['img_contacto']) && !empty($_FILES['img_contacto']['name'])){
      $path = 'files/ajustes/'.$_POST['imagen_ant_4'];
      if( file_exists($path) && !empty($_POST['imagen_ant_4']) ) unlink($path);    
      $_POST['img_contacto'] = carga_imagen('files/ajustes/','img_contacto','','600','600');
      $campos = array_merge($campos,array('img_contacto'));
    }
    

   
    $bd->actualiza_(armaupdate('ajustes',array_merge($campos),"id='".$_POST["id"]."'",'POST'));/*actualizo*/
  
  $bd->close();
  gotoUrl("index.php?page=".$_POST["nompage"]."&module=".$_POST["nommodule"]."&parenttab=".$_POST["nomparenttab"]);  

  
  
}else{
     $usuario=executesql("select * from ajustes where id='1'",0);
?>
<!-- CK EDITOR -->
<script src="ckeditor/ckeditor.js"></script>
<script src="ckeditor/sample.js"></script>

<section class="content">
  <div class="row">
    <div class="col-md-12">
          <!-- Horizontal Form -->
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">
               Ajustes</h3>
               <p style="color:red;">*Ubicacion:  Esta configuración afecta a la portada de la web. Ruta: <?php echo $_dominio; ?>/contacto</p>

            </div><!-- /.box-header -->
<?php $task_=$_GET["task"]; ?>
            <!-- form start -->
            <form action="ajustes.php?task=update" class="form-horizontal" method="POST" enctype="multipart/form-data" autocomplete="OFF">
<?php 
create_input("hidden","id",$usuario["id"],"",$table,"");
create_input("hidden","urlfailed",basename($_SERVER['REQUEST_URI']),"",$table,"");  
create_input("hidden","urlgo",$link2,"",$table,"");
create_input("hidden","nompage",$_GET["page"],"",$table,""); 
create_input("hidden","nommodule",$_GET["module"],"",$table,"");
create_input("hidden","nomparenttab",$_GET["parenttab"],"",$table,"");
?>
              <div class="box-body"> 
                
               <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Nombre Institución:  </label>
                  <div class="col-sm-6">
                      <?php create_input("text","nombre",$usuario["nombre"],"form-control ",$table," required",' '); ?>
                  </div>
                </div>
								
								<?php /* 
								
								<div class="form-group" >
                      <label for="inputPassword3" class="col-sm-2 control-label">logo</label>
                      <div class="col-sm-6">
                        <input type="file" name="logo" id="logo" class="form-control" >
                        <p style="color:red;">Tamaño recomendado: 300px ancho x 300px altura</p>
                        <?php create_input("hidden","imagen_ant",$usuario["logo"],"",$table,$agregado); 
                          if($usuario["logo"]!=""){ 
                        ?>
                          <img src="<?php echo "files/ajustes/".$usuario["logo"]; ?>" width="200" class="mgt15" >
                        <?php } ?> 
                      </div>
                </div>

								<div class="form-group" >
                      <label for="inputPassword3" class="col-sm-2 control-label">logo movil</label>
                      <div class="col-sm-6">
                        <input type="file" name="logo_movil" id="logo_movil" class="form-control" >
                        <p style="color:red;">Tamaño recomendado: 300px ancho x 300px altura</p>
                        <?php create_input("hidden","imagen_ant_2",$usuario["logo_movil"],"",$table,$agregado); 
                          if($usuario["logo_movil"]!=""){ 
                        ?>
                          <img src="<?php echo "files/ajustes/".$usuario["logo_movil"]; ?>" width="200" class="mgt15" >
                        <?php } ?> 
                      </div>
                </div>
             
						 
								<div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Tel/cel Principal :  </label>
                  <div class="col-sm-6">
                      <?php create_input("text","tel1",$usuario["tel1"],"form-control ",$table," ",' '); ?>
                  </div>
                </div>
								
								<div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">tel/cel #2 :  </label>
                  <div class="col-sm-6">
										<?php create_input("text","tel2",$usuario["tel2"],"form-control ",$table," ",' '); ?>
                  </div>
                </div>
								
								<div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">tel/cel #3:  </label>
                  <div class="col-sm-6">
										<?php create_input("text","tel3",$usuario["tel3"],"form-control ",$table," ",' '); ?>
                  </div>
                </div>

								<div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">#WhatsApp:  </label>
                  <div class="col-sm-6">
										<?php create_input("text","wasap",$usuario["wasap"],"form-control ",$table," ",' '); ?>
                  </div>
                </div>
								
								<div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Correo / e-mail:  </label>
                  <div class="col-sm-6">
										<?php create_input("text","correo",$usuario["correo"],"form-control ",$table," ",' '); ?>
                  </div>
                </div>
								
								<div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Dirección:  </label>
                  <div class="col-sm-6">
										<?php create_input("text","direccion",$usuario["direccion"],"form-control ",$table," ",' '); ?>
                  </div>
                </div>
								
								<div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Link Web:  </label>
                  <div class="col-sm-6">
										<?php create_input("text","web",$usuario["web"],"form-control ",$table," ",' '); ?>
                  </div>
                </div>

								<div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Link MapaGoogle:  </label>
                  <div class="col-sm-6">
										<?php create_input("text","link_mapa_google",$usuario["link_mapa_google"],"form-control ",$table," ",' '); ?>
                  </div>
                </div>


             
						 
							<div class="form-group" >
                      <label for="inputPassword3" class="col-sm-2 control-label">Imagen face shared</label>
                      <div class="col-sm-6">
                        <input type="file" name="img_face" id="img_face" class="form-control" >
                        <p style="color:red;">Tamaño recomendado: 300px ancho x 300px altura</p>
                        <?php create_input("hidden","imagen_ant_3",$usuario["img_face"],"",$table,$agregado); 
                          if($usuario["img_face"]!=""){ 
                        ?>
                          <img src="<?php echo "files/ajustes/".$usuario["img_face"]; ?>" width="200" class="mgt15" >
                        <?php } ?> 
                      </div>
                </div>
             
						 */ ?>
						 

						 
						
						 
								<div class="form-group" >
                      <label for="inputPassword3" class="col-sm-2 control-label">Imagen formulario </label>
                      <div class="col-sm-6">
                        <input type="file" name="img_contacto" id="img_contacto" class="form-control" >
                        <p style="color:red;">Tamaño recomendado: 600px ancho x 600px altura</p>
                        <?php create_input("hidden","imagen_ant_4",$usuario["img_contacto"],"",$table,$agregado); 
                          if($usuario["img_contacto"]!=""){ 
                        ?>
                          <img src="<?php echo "files/ajustes/".$usuario["img_contacto"]; ?>" width="200" class="mgt15" >
                        <?php } ?> 
                      </div>
                </div>
						 
						
              </div>
              <div class="box-footer">
                <div class="form-group">
                  <div class="col-sm-12 text-center">
                    <button type="submit" class="btn bg-blue btn-flat">Guardar</button>
                    <button type="button" class="btn bg-red btn-flat" onclick="javascript:gotourl('index.html');">Cancelar</button>
                  </div>
                </div>
              </div>
            </form>
          </div><!-- /.box -->
        </div><!--/.col (right) -->
  </div>
</section><!-- /.content -->
<?php } ?>




