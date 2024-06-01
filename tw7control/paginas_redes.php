<?php error_reporting(E_ALL ^ E_NOTICE);
include ("auten.php");

if($_GET["task"]=='neworden'){
  $bd=new BD;
  $orden_actual=$_GET["orden"];
  $orden_nuevo=$_GET["nuevoorden"];
  $tipo=$_GET["tipo"];  
  $id_del_registro_actual=$_GET["id_pagina"];
  $criterio_Orden =" ";
  nuevoorden($orden_actual, $orden_nuevo, $tipo, $id_del_registro_actual, "paginas_redes", "id_pagina", $criterio_Orden);    
  $bd->close();

}elseif($_GET["task"]=='insert' || $_GET["task"]=='update'){
  $bd=new BD;
  $where = ($_GET["task"]=='update') ? "and id_pagina!='".$_POST["id_pagina"]."'" : '';
  $urlrewrite=armarurlrewrite($_POST["titulo"]);
  $urlrewrite=armarurlrewrite($urlrewrite,1,"paginas_redes","id_pagina","titulo_rewrite",$where);


  $campos=array('titulo', array('titulo_rewrite',$urlrewrite),'titulo_iconos','texto_1','texto_2','texto_3','texto_4','texto_5','titulo_2','texto_6','texto_7','texto_8','titulo_3','texto_9','texto_10','enlace','estado_idestado','enlace_2','enlace_3'); 

  if($_GET["task"]=='insert'){
    if(isset($_FILES['imagen']) && !empty($_FILES['imagen']['name'])){
      $_POST['imagen'] = carga_imagen('files/images/paginas_redes/','imagen','','380','450');
      $campos = array_merge($campos,array('imagen'));
    }
    if(isset($_FILES['imagen_2']) && !empty($_FILES['imagen_2']['name'])){
      $_POST['imagen_2'] = carga_imagen('files/images/paginas_redes/','imagen_2','','380','380');
      $campos = array_merge($campos,array('imagen_2'));
    }
    if(isset($_FILES['imagen_3']) && !empty($_FILES['imagen_3']['name'])){
      $_POST['imagen_3'] = carga_imagen('files/images/paginas_redes/','imagen_3','','380','380');
      $campos = array_merge($campos,array('imagen_3'));
    }
    if(isset($_FILES['imagen_4']) && !empty($_FILES['imagen_4']['name'])){
      $_POST['imagen_4'] = carga_imagen('files/images/paginas_redes/','imagen_4','','280','98');
      $campos = array_merge($campos,array('imagen_4'));
    }
    if(isset($_FILES['imagen_5']) && !empty($_FILES['imagen_5']['name'])){
      $_POST['imagen_5'] = carga_imagen('files/images/paginas_redes/','imagen_5','','280','98');
      $campos = array_merge($campos,array('imagen_5'));
    }

		
    if(isset($_FILES['imagen_6']) && !empty($_FILES['imagen_6']['name'])){
      $_POST['imagen_6'] = carga_imagen('files/images/paginas_redes/','imagen_6','','100','100');
      $campos = array_merge($campos,array('imagen_6'));
    }

		
    if(isset($_FILES['imagen_7']) && !empty($_FILES['imagen_7']['name'])){
      $_POST['imagen_7'] = carga_imagen('files/images/paginas_redes/','imagen_7','','100','100');
      $campos = array_merge($campos,array('imagen_7'));
    }

		
    if(isset($_FILES['imagen_8']) && !empty($_FILES['imagen_8']['name'])){
      $_POST['imagen_8'] = carga_imagen('files/images/paginas_redes/','imagen_8','','100','100');
      $campos = array_merge($campos,array('imagen_8'));
    }
    if(isset($_FILES['imagen_9']) && !empty($_FILES['imagen_9']['name'])){
      $_POST['imagen_9'] = carga_imagen('files/images/paginas_redes/','imagen_9','','100','100');
      $campos = array_merge($campos,array('imagen_9'));
    }

		
    $_POST['orden'] = _orden_noticia("","paginas_redes","");
    $_POST['fecha_registro'] = fecha_hora(2);
		
		// echo var_dump(arma_insert('paginas_redes',array_merge($campos,array('codigo','fecha_registro','orden')),'POST'));
		// exit();
		
    $_POST["id_pagina"]=$bd->inserta_(arma_insert('paginas_redes',array_merge($campos,array('fecha_registro','orden')),'POST'));
		
  }else{
    if(isset($_FILES['imagen']) && !empty($_FILES['imagen']['name'])){
      $path = 'files/images/paginas_redes/'.$_POST['imagen_ant'];
      if( file_exists($path) && !empty($_POST['imagen_ant']) ) unlink($path);    
      $_POST['imagen'] = carga_imagen('files/images/paginas_redes/','imagen','','380','450');
      $campos = array_merge($campos,array('imagen'));
    }
    if(isset($_FILES['imagen_2']) && !empty($_FILES['imagen_2']['name'])){
      $path = 'files/images/paginas_redes/'.$_POST['imagen_ant_2'];
      if( file_exists($path) && !empty($_POST['imagen_ant_2']) ) unlink($path);    
      $_POST['imagen_2'] = carga_imagen('files/images/paginas_redes/','imagen_2','','380','380');
      $campos = array_merge($campos,array('imagen_2'));
    }
    if(isset($_FILES['imagen_3']) && !empty($_FILES['imagen_3']['name'])){
      $path = 'files/images/paginas_redes/'.$_POST['imagen_ant_3'];
      if( file_exists($path) && !empty($_POST['imagen_ant_3']) ) unlink($path);    
      $_POST['imagen_3'] = carga_imagen('files/images/paginas_redes/','imagen_3','','380','380');
      $campos = array_merge($campos,array('imagen_3'));
    }
    if(isset($_FILES['imagen_4']) && !empty($_FILES['imagen_4']['name'])){
      $path = 'files/images/paginas_redes/'.$_POST['imagen_ant_4'];
      if( file_exists($path) && !empty($_POST['imagen_ant_4']) ) unlink($path);    
      $_POST['imagen_4'] = carga_imagen('files/images/paginas_redes/','imagen_4','','280','98');
      $campos = array_merge($campos,array('imagen_4'));
    }
    if(isset($_FILES['imagen_5']) && !empty($_FILES['imagen_5']['name'])){
      $path = 'files/images/paginas_redes/'.$_POST['imagen_ant_5'];
      if( file_exists($path) && !empty($_POST['imagen_ant_5']) ) unlink($path);    
      $_POST['imagen_5'] = carga_imagen('files/images/paginas_redes/','imagen_5','','280','98');
      $campos = array_merge($campos,array('imagen_5'));
    }

    if(isset($_FILES['imagen_6']) && !empty($_FILES['imagen_6']['name'])){
      $path = 'files/images/paginas_redes/'.$_POST['imagen_ant_6'];
      if( file_exists($path) && !empty($_POST['imagen_ant_6']) ) unlink($path);    
      $_POST['imagen_6'] = carga_imagen('files/images/paginas_redes/','imagen_6','','100','100');
      $campos = array_merge($campos,array('imagen_6'));
    }

    if(isset($_FILES['imagen_7']) && !empty($_FILES['imagen_7']['name'])){
      $path = 'files/images/paginas_redes/'.$_POST['imagen_ant_7'];
      if( file_exists($path) && !empty($_POST['imagen_ant_7']) ) unlink($path);    
      $_POST['imagen_7'] = carga_imagen('files/images/paginas_redes/','imagen_7','','100','100');
      $campos = array_merge($campos,array('imagen_7'));
    }
    
    if(isset($_FILES['imagen_8']) && !empty($_FILES['imagen_8']['name'])){
      $path = 'files/images/paginas_redes/'.$_POST['imagen_ant_8'];
      if( file_exists($path) && !empty($_POST['imagen_ant_8']) ) unlink($path);    
      $_POST['imagen_8'] = carga_imagen('files/images/paginas_redes/','imagen_8','','100','100');
      $campos = array_merge($campos,array('imagen_8'));
    }

    
    if(isset($_FILES['imagen_9']) && !empty($_FILES['imagen_9']['name'])){
      $path = 'files/images/paginas_redes/'.$_POST['imagen_ant_9'];
      if( file_exists($path) && !empty($_POST['imagen_ant_9']) ) unlink($path);    
      $_POST['imagen_9'] = carga_imagen('files/images/paginas_redes/','imagen_9','','100','100');
      $campos = array_merge($campos,array('imagen_9'));
    }





    $bd->actualiza_(armaupdate('paginas_redes',$campos," id_pagina='".$_POST["id_pagina"]."'",'POST'));/*actualizo*/
  }

  $bd->close();
  gotoUrl("index.php?page=".$_POST["nompage"]."&module=".$_POST["nommodule"]."&parenttab=".$_POST["nomparenttab"]);

}elseif($_GET["task"]=='new' || $_GET["task"]=='edit'){
  if($_GET["task"]=='edit'){
     $data_producto=executesql("select * from paginas_redes where id_pagina='".$_GET["id_pagina"]."'",0);
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
              <h3 class="box-title">paginas_redes </h3>
            </div>
<?php $task_=$_GET["task"]; ?>            
            <form id="registro" action="paginas_redes.php?task=<?php echo ($task_=='edit') ?  "update" : "insert"; ?>" class="form-horizontal" method="POST" enctype="multipart/form-data" onsubmit="return aceptar()">
<?php 
if($task_=='edit') create_input("hidden","id_pagina",$data_producto["id_pagina"],"",$table,"");
create_input("hidden","urlfailed",basename($_SERVER['REQUEST_URI']),"",$table,"");  
create_input("hidden","urlgo",$link2,"",$table,"");
create_input("hidden","nompage",$_GET["page"],"",$table,""); 
create_input("hidden","nommodule",$_GET["module"],"",$table,"");
create_input("hidden","nomparenttab",$_GET["parenttab"],"",$table,"");
?>
              <div class="box-body   <?php echo !empty($_GET["id_pagina"])?'detalle_editar':'';?>  "   >
								<input type="hidden" name="tipo" value="<?php echo $_GET["tipo"];?>">
                <div class="form-group">
                  <label for="inputEmail3" class="col-md-2 col-sm-2 control-label">Estado</label>
                  <div class="col-sm-3">
                    <?php crearselect("estado_idestado","select * from estado where idestado in('1','2') order by 2 desc",'class="form-control"',$data_producto["estado_idestado"],""); ?>
                  </div>
                  
                </div>
  

								<div class="form-group">
                  <label for="inputPassword3" class="col-md-2 col-sm-2 control-label">Título</label>
                  <div class="col-sm-6">
                    <?php create_input("text","titulo",$data_producto["titulo"],"form-control",$table,"",$agregado); ?>
                  </div>
                </div>
							
                <div class="form-group">
                  <label for="inputPassword3" class="col-md-2 col-sm-2 control-label">Enlace</label>
                  <div class="col-sm-6">
                    <?php create_input("text","enlace",$data_producto["enlace"],"form-control",$table,"",$agregado); ?>
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputPassword3" class="col-md-2 col-sm-2 control-label">Imágen</label>
                  <div class="col-sm-6">
                    <input type="file" name="imagen" id="imagen" class="form-control">
                    <?php create_input("hidden","imagen_ant",$data_producto["imagen"],"",$table,$agregado); 
                      if($data_producto["imagen"]!=""){ 
                    ?>
                      <img src="<?php echo "files/images/paginas_redes/".$data_producto["imagen"]; ?>" width="200" class="mgt15">
                    <?php } ?> 
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Texto debajo del Titulo:</label>
                  <div class="col-sm-6">
                    <?php create_input("textarea","texto_1",$data_producto["texto_1"],"form-control",$table,"style='height:250px;'",""); ?>
                  </div>
                </div>


                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label"> Titulo de iconos :</label>
                  <div class="col-sm-6">
                    <?php create_input("textarea","titulo_iconos",$data_producto["titulo_iconos"],"form-control",$table,"style='height:250px;'",""); ?>
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputPassword3" class="col-md-2 col-sm-2 control-label">Imágen icono 1: 100px * 100px</label>
                  <div class="col-sm-6">
                    <input type="file" name="imagen_6" id="imagen_6" class="form-control">
                    <?php create_input("hidden","imagen_ant_6",$data_producto["imagen_6"],"",$table,$agregado); 
                      if($data_producto["imagen_6"]!=""){ 
                    ?>
                      <img src="<?php echo "files/images/paginas_redes/".$data_producto["imagen_6"]; ?>" width="200" class="mgt15">
                    <?php } ?> 
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Texto icono 1:</label>
                  <div class="col-sm-6">
                    <?php create_input("textarea","texto_2",$data_producto["texto_2"],"form-control",$table,"style='height:250px;'",""); ?>
                  </div>
                </div>


                <div class="form-group">
                  <label for="inputPassword3" class="col-md-2 col-sm-2 control-label">Imágen icono 2: 100px * 100px</label>
                  <div class="col-sm-6">
                    <input type="file" name="imagen_7" id="imagen_7" class="form-control">
                    <?php create_input("hidden","imagen_ant_7",$data_producto["imagen_7"],"",$table,$agregado); 
                      if($data_producto["imagen_7"]!=""){ 
                    ?>
                      <img src="<?php echo "files/images/paginas_redes/".$data_producto["imagen_7"]; ?>" width="200" class="mgt15">
                    <?php } ?> 
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Texto icono 2:</label>
                  <div class="col-sm-6">
                    <?php create_input("textarea","texto_3",$data_producto["texto_3"],"form-control",$table,"style='height:250px;'",""); ?>
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputPassword3" class="col-md-2 col-sm-2 control-label">Imágen icono 3: 100px * 100px</label>
                  <div class="col-sm-6">
                    <input type="file" name="imagen_8" id="imagen_8" class="form-control">
                    <?php create_input("hidden","imagen_ant_8",$data_producto["imagen_8"],"",$table,$agregado); 
                      if($data_producto["imagen_8"]!=""){ 
                    ?>
                      <img src="<?php echo "files/images/paginas_redes/".$data_producto["imagen_8"]; ?>" width="200" class="mgt15">
                    <?php } ?> 
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Texto icono 3:</label>
                  <div class="col-sm-6">
                    <?php create_input("textarea","texto_4",$data_producto["texto_4"],"form-control",$table,"style='height:250px;'",""); ?>
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputPassword3" class="col-md-2 col-sm-2 control-label">Imágen icono 4: 100px * 100px</label>
                  <div class="col-sm-6">
                    <input type="file" name="imagen_9" id="imagen_9" class="form-control">
                    <?php create_input("hidden","imagen_ant_9",$data_producto["imagen_9"],"",$table,$agregado); 
                      if($data_producto["imagen_9"]!=""){ 
                    ?>
                      <img src="<?php echo "files/images/paginas_redes/".$data_producto["imagen_9"]; ?>" width="200" class="mgt15">
                    <?php } ?> 
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Texto icono 4:</label>
                  <div class="col-sm-6">
                    <?php create_input("textarea","texto_5",$data_producto["texto_5"],"form-control",$table,"style='height:250px;'",""); ?>
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputPassword3" class="col-md-2 col-sm-2 control-label">Título 2</label>
                  <div class="col-sm-6">
                    <?php create_input("text","titulo_2",$data_producto["titulo_2"],"form-control",$table,"",$agregado); ?>
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Texto izquierda del Titulo 2:</label>
                  <div class="col-sm-6">
                    <?php create_input("textarea","texto_6",$data_producto["texto_6"],"form-control",$table,"style='height:250px;'",""); ?>
                  </div>
                </div>
                
                <div class="form-group">
                  <label for="inputPassword3" class="col-md-2 col-sm-2 control-label">Imágen derecha</label>
                  <div class="col-sm-6">
                    <input type="file" name="imagen_2" id="imagen_2" class="form-control">
                    <?php create_input("hidden","imagen_ant_2",$data_producto["imagen_2"],"",$table,$agregado); 
                      if($data_producto["imagen_2"]!=""){ 
                    ?>
                      <img src="<?php echo "files/images/paginas_redes/".$data_producto["imagen_2"]; ?>" width="200" class="mgt15">
                    <?php } ?> 
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">sub Titulo 2:</label>
                  <div class="col-sm-6">
                    <?php create_input("textarea","texto_7",$data_producto["texto_7"],"form-control",$table,"style='height:250px;'",""); ?>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Texto derecha del Titulo 2:</label>
                  <div class="col-sm-6">
                    <?php create_input("textarea","texto_8",$data_producto["texto_8"],"form-control",$table,"style='height:250px;'",""); ?>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputPassword3" class="col-md-2 col-sm-2 control-label">Imágen izquierda</label>
                  <div class="col-sm-6">
                    <input type="file" name="imagen_3" id="imagen_3" class="form-control">
                    <?php create_input("hidden","imagen_ant_3",$data_producto["imagen_3"],"",$table,$agregado); 
                      if($data_producto["imagen_3"]!=""){ 
                    ?>
                      <img src="<?php echo "files/images/paginas_redes/".$data_producto["imagen_3"]; ?>" width="200" class="mgt15">
                    <?php } ?> 
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label"> Titulo 3:</label>
                  <div class="col-sm-6">
                    <?php create_input("textarea","titulo_3",$data_producto["titulo_3"],"form-control",$table,"style='height:250px;'",""); ?>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label"> texto paso 1:</label>
                  <div class="col-sm-6">
                    <?php create_input("textarea","texto_9",$data_producto["texto_9"],"form-control",$table,"style='height:250px;'",""); ?>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputPassword3" class="col-md-2 col-sm-2 control-label">Imágen 4</label>
                  <div class="col-sm-6">
                    <input type="file" name="imagen_4" id="imagen_4" class="form-control">
                    <?php create_input("hidden","imagen_ant_4",$data_producto["imagen_4"],"",$table,$agregado); 
                      if($data_producto["imagen_4"]!=""){ 
                    ?>
                      <img src="<?php echo "files/images/paginas_redes/".$data_producto["imagen_4"]; ?>" width="200" class="mgt15">
                    <?php } ?> 
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label"> Link de la imagen 4:</label>
                  <div class="col-sm-6">
                    <?php create_input("text","enlace_2",$data_producto["enlace_2"],"form-control",$table,"style='height: ;'",""); ?>
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputPassword3" class="col-md-2 col-sm-2 control-label">Imágen 5</label>
                  <div class="col-sm-6">
                    <input type="file" name="imagen_5" id="imagen_5" class="form-control">
                    <?php create_input("hidden","imagen_ant_5",$data_producto["imagen_5"],"",$table,$agregado); 
                      if($data_producto["imagen_5"]!=""){ 
                    ?>
                      <img src="<?php echo "files/images/paginas_redes/".$data_producto["imagen_5"]; ?>" width="200" class="mgt15">
                    <?php } ?> 
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label"> Link de la imagen 5:</label>
                  <div class="col-sm-6">
                    <?php create_input("text","enlace_3",$data_producto["enlace_3"],"form-control",$table,"style='height: ;'",""); ?>
                  </div>
                </div>
                
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label"> texto paso 2:</label>
                  <div class="col-sm-6">
                    <?php create_input("textarea","texto_10",$data_producto["texto_10"],"form-control",$table,"style='height:250px;'",""); ?>
                  </div>
                </div>
              
								
<?php /*
								<div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Descripción</label>
                  <div class="col-sm-10">
                    <?php create_input("textarea","descripcion",$data_producto["descripcion"],'  ',$table,'style="height:650px!important;"');  ?>
                    <script>
                    var editor11 = CKEDITOR.replace('descripcion');
                    CKFinder.setupCKEditor( editor11, 'ckfinder/' );
                    </script> 
                  </div>
                </div>
								
							
                <div class="form-group">
                  <label for="inputPassword3" class="col-md-2 col-sm-2 control-label">Imágen</label>
                  <div class="col-sm-6">
                    <input type="file" name="imagen" id="imagen" class="form-control">
                    <?php create_input("hidden","imagen_ant",$data_producto["imagen"],"",$table,$agregado); 
                      if($data_producto["imagen"]!=""){ 
                    ?>
                      <img src="<?php echo "files/images/paginas_redes/".$data_producto["imagen"]; ?>" width="200" class="mgt15">
                    <?php } ?> 
                  </div>
                </div>
				*/	?> 		
           
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
  $id_pagina = !isset($_GET['id_pagina']) ? implode(',', $_GET['chkDel']) : $_GET['id_pagina'];
  $paginas_redes = executesql("SELECT * FROM paginas_redes WHERE id_pagina IN(".$id_pagina.")");
  if(!empty($paginas_redes)){
    foreach($paginas_redes as $row){
      $pfile = 'files/images/paginas_redes/'.$row['imagen']; if(file_exists($pfile) && !empty($row['imagen'])){ unlink($pfile); }
    }
  }

  $bd->actualiza_("DELETE FROM paginas_redes WHERE id_pagina IN(".$id_pagina.")");
  $bd->Commit();
  $bd->close();

}elseif($_GET["task"]=='ordenar'){

  $bd = new BD;
  $_GET['order'] = array_reverse($_GET['order']);
  foreach ($_GET['order'] as $order => $item) {
    $orden = $orden + 1;
    $bd->actualiza_("UPDATE paginas_redes SET orden= ".$orden." WHERE id_pagina = ".$item."");
  }
  $bd->Commit();
  $bd->close();

}elseif($_GET["task"]=='uestado'){

  $bd = new BD;
  $bd->Begin();

  $id_pagina = !isset($_GET['id_pagina']) ? $_GET['estado_idestado'] : $_GET['id_pagina'];
  $id_pagina = is_array($id_pagina) ? implode(',',$id_pagina) : $id_pagina;
  $paginas_redes = executesql("SELECT * FROM paginas_redes WHERE id_pagina IN (".$id_pagina.")");

  if(!empty($paginas_redes))
    foreach($paginas_redes as $reg => $item)
      if ($item['estado_idestado']==1) {
        $state = 2;
      }elseif ($item['estado_idestado']==2) {
        $state = 1;
      }
  $bd->actualiza_("UPDATE paginas_redes SET estado_idestado=".$state." WHERE id_pagina=".$id_pagina."");
  echo $state;
  $bd->Commit();
  $bd->close();

}elseif($_GET["task"]=='finder'){
	
	$array= array();
	$meses=array('Jan'=>'Enero','Feb'=>'Febrero','Mar'=>'Marzo','Apr'=>'Abril','May'=>'Mayo','Jun'=>'Junio','Jul'=>'Julio','Aug'=>'Agosto','Sep'=>'Septiembre','Oct'=>'Octubre','Nov'=>'Noviembre','Dec'=>'Diciembre');
	
  $sql = "SELECT  c.*, YEAR(c.fecha_registro) as anho, MONTH(c.fecha_registro) as mes, e.nombre as estado 
		FROM paginas_redes c 
	 INNER JOIN estado e ON c.estado_idestado=e.idestado    
	 "; 

  if(isset($_GET['criterio_usu_per']) && !empty($_GET['criterio_usu_per'])){
    $stringlike=fn_filtro(substr($_GET['criterio_usu_per'], 0, 16));
    $sql.= " and  ( c.titulo LIKE '%".$stringlike."%'  )  ";
  }else{
	
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
  $paging->pagina_proceso="paginas_redes.php";
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
								<th class="sort">TÍTULO </th>                
								<th class="sort">LINK </th>                
								<th class="sort cnone" width="60">ESTADO</th>
								<th class="unafbe btn_varios">Opciones</th>
							</tr>
	<?php }//if meses ?> 						
							
                <tr>
									<td><?php echo !empty($detalles['fecha_registro']) ? date('d',strtotime($detalles['fecha_registro'])) : '...'; ?></td>

                  <td><?php echo $detalles["titulo"]; ?></td>                                 
                  <td> <a href="<?php echo $detalles["titulo_rewrite"]; ?>" target="_blank" > link </a></td>                                 
                  <td class="cnone"><a href="javascript: fn_estado('<?php echo $detalles["id_pagina"]; ?>')"><?php echo $detalles["estado"]; ?></a></td>
                  <td>
                    <div class="btn-eai  text-center btns btr   btn_varios ">				
											<a href="index.php?page=paginas_redes&module=Ver&parenttab=paginas_redes
													<?php echo $_SESSION["base_url"].'&task=edit&id_pagina='.$detalles["id_pagina"]; ?>" style="color:#fff;"><i class="fa fa-edit"></i> <span>editar</span>
											</a>
										
											
                    </div>
                  </td>
                </tr>
<?php endwhile;  
?>
              </tbody>
            </table>
            <div class="pagination"><?php echo $paging->fetchNavegacion(); ?></div>
<script>
$(function(){
  // checked();
  // sorter();
  // reordenar('paginas_redes.php');
});
var mypage = "paginas_redes.php";
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
var link = "paginas_rede";
var us = "landing";
var ar = "la";
var l = "a";
var l2 = "a";
var pr = "La";
var id = "id_pagina";
var mypage = "paginas_redes.php";
</script>

<?php } ?>