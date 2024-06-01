<?php
error_reporting(E_ALL ^ E_NOTICE);
include_once("auten.php");

if ($_GET["task"]=='update'){
  
    $bd=new BD;
    $campos=array('mostrar_solo_inicio_de_sesion_index','mostrar_formularios_registro_en_banners','link_canal_wasap');
		


    $bd->actualiza_(armaupdate('ajustes',$campos,"id='".$_POST["id"]."'",'POST'));
  
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
              Configuraciones web:  Activar/Desactivar</h3>
            </div><!-- /.box-header -->
<?php $task_=$_GET["task"]; ?>
            <!-- form start -->
            <form action="registro_emergente.php?task=update" class="form-horizontal" method="POST" enctype="multipart/form-data" autocomplete="OFF">
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
                  <label for="inputPassword3" class="col-sm-2 control-label">
                      link_canal_wasap: 
                  </label>
                  <div class="col-sm-6">
                    <?php create_input("text","link_canal_wasap",$usuario["link_canal_wasap"],"form-control",$table,"",$agregado); ?>
                  </div>
                </div>
                
								<div class="form-group">
                  <label for="inputEmail3" class="col-md-2 col-sm-2 control-label">MOSTRAR SOLO EL LOGIN EN EL INDEX: </label>
									<div class="col-sm-3">
										<select id="mostrar_solo_inicio_de_sesion_index" name="mostrar_solo_inicio_de_sesion_index" class="form-control" requerid >  <!-- saco valor desde la BD -->
											<option value="1" <?php echo ($usuario['mostrar_solo_inicio_de_sesion_index'] == 1) ? 'selected' : '' ;?>>SI</option>  
											<option value="2"  <?php echo ($usuario['mostrar_solo_inicio_de_sesion_index'] == 2) ? 'selected' : '' ;?>>NO</option>
										</select>
									</div>
                </div>
						 
								<div class="form-group">
                  <label for="inputEmail3" class="col-md-2 col-sm-2 control-label">MOSTRAR FORMULARIOS EN LOS BANNERS: </label>
									<div class="col-sm-3">
										<select id="mostrar_formularios_registro_en_banners" name="mostrar_formularios_registro_en_banners" class="form-control" requerid >  <!-- saco valor desde la BD -->
											<option value="1" <?php echo ($usuario['mostrar_formularios_registro_en_banners'] == 1) ? 'selected' : '' ;?>>SI</option>  
											<option value="2"  <?php echo ($usuario['mostrar_formularios_registro_en_banners'] == 2) ? 'selected' : '' ;?>>NO</option>
										</select>
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

