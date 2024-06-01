<?php error_reporting(E_ALL ^ E_NOTICE);
include("auten.php");

if($_GET["task"]=='neworden'){
  $bd=new BD;
  $orden_actual=$_GET["orden"];
  $orden_nuevo=$_GET["nuevoorden"];
  $tipo=$_GET["tipo"];  
  $id_del_registro_actual=$_GET["id"];
  $criterio_Orden ="";
  nuevoorden($orden_actual, $orden_nuevo, $tipo, $id_del_registro_actual, "flotantes", "id", $criterio_Orden);    
  $bd->close();

}elseif($_GET["task"]=='insert' || $_GET["task"]=='update'){
  $bd=new BD;

  $norden=1;
  $_POST["id_especialidad"]= empty($_POST["id_especialidad"])? 0 :$_POST["id_especialidad"];
  $campos=array('id_especialidad',"titulo","descripcion","boton","link", 'enlace',"estado_idestado"); 
  // $campos=array("titulo","descripcion","estado_idestado"); 
  
  if($_GET["task"]=='insert'){
    $_POST['fecha_registro']=fecha_hora(2);
    $_POST['idusuario']=$_SESSION["visualiza"]["idusuario"];

    $campos=array_merge($campos,array('fecha_registro','idusuario'));
    if(isset($_FILES['imagen']) && !empty($_FILES['imagen']['name'])){
      $_POST['imagen'] = carga_imagen('files/images/flotantes/','imagen','','400','400');      
      $campos = array_merge($campos,array('imagen'));      
    }          
			
			// echo var_dump(arma_insert('flotantes',$campos,'POST'));
			// exit();
			
    $bd->inserta_(arma_insert('flotantes',$campos,'POST'));
		
  }else{
    
    $_POST['fecha_registro_modifico']=fecha_hora(2);
    $_POST['idusuario_modifico']=$_SESSION["visualiza"]["idusuario"];

    $campos=array_merge($campos,array('fecha_registro_modifico','idusuario_modifico'));

    if(isset($_FILES['imagen']) && !empty($_FILES['imagen']['name'])){
      $path = 'files/images/flotantes/'.$_POST['imagen_ant'];
      if( file_exists($path) && !empty($_POST['imagen_ant']) ) unlink($path);    
      $_POST['imagen'] = carga_imagen('files/images/flotantes/','imagen','','400','400');
      $campos = array_merge($campos,array('imagen'));
    }

//    echo var_dump(armaupdate('flotantes',$campos,' id="'.$_POST["id"].'"','POST'));
  //  exit();

     $bd->actualiza_(armaupdate('flotantes',$campos,' id="'.$_POST["id"].'"','POST'));/*actualizo*/
  }
 
  $bd->close();
  gotoUrl("index.php?page=".$_POST["nompage"]."&module=".$_POST["nommodule"]."&parenttab=".$_POST["nomparenttab"]);  
  
}elseif($_GET["task"]=='new' || $_GET["task"]=='edit'){
  if($_GET["task"]=='edit'){
     $data_producto=executesql("select * from flotantes where id='".$_GET["id"]."'",0);
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
                <?php echo ($_GET["task"]=="edit") ? 'Editar' : 'Nueva'; ?> Comunicados emergentes</h3>
                <p style=" color:red;"> Permite tener una ventana emergente, para cuando el usuario ingresa a la página, le va a mostrar este aviso; solo se vizualiza 1.</p>
            </div><!-- /.box-header -->
<?php $task_=$_GET["task"]; ?>
            <!-- form start -->
            <form id="registro" action="flotantes.php?task=<?php echo ($task_=='edit') ?  "update" : "insert"; ?>" class="form-horizontal" method="POST"  enctype="multipart/form-data"  onsubmit="return aceptar()"><!-- para cargar archivos o img -->
<?php 
if($task_=='edit') create_input("hidden","id",$data_producto["id"],"",$table,""); 

create_input("hidden","urlfailed",basename($_SERVER['REQUEST_URI']),"",$table,"");  
create_input("hidden","urlgo",$link2,"",$table,"");
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
                  <label for="inputEmail3" class="col-sm-2 control-label"> Dirigido a</label>
                  <div class="col-sm-6">
                    <?php crearselect("id_especialidad","select * from especialidades where estado_idestado=1 order by titulo  asc ",'class="form-control"',$data_producto["id_especialidad"]," -- Para todos en general --"); ?>
                  </div>
                </div>
								
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Título referencia</label>
                  <div class="col-sm-6">
                    <?php create_input("text","titulo",$data_producto["titulo"],"form-control",$table,"",$agregado); ?>                    
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Link video VIMEO</label>
                  <div class="col-sm-8">
                    <?php create_input("text","link",$data_producto["link"],"form-control lleva_link_vimeo ",$table,"",$agregado); ?>
                    <iframe frameborder="0" width="100%" height="200" class="video_vimeo "></iframe>
                    <!-- 
                    -->
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Imagen(400px ancho * 400px largo) *opcional</label>
                  <div class="col-sm-10">
                    <input type="file" name="imagen" id="imagen" class="form-control">
                    <?php create_input("hidden","imagen_ant",$data_producto["imagen"],"",$table,$agregado); 
                      if($data_producto["imagen"]!=""){ 
                    ?>
                      <img src="<?php echo "files/images/flotantes/".$data_producto["imagen"]; ?>" width="200" class="mgt15">
                    <?php } ?> 
                  </div>
                </div>

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
                  <label for="inputPassword3" class="col-sm-2 control-label">enlace</label>
                  <div class="col-sm-6">
                    <?php create_input("text","enlace",$data_producto["enlace"],"form-control",$table,"",$agregado); ?>                    
                  </div>
                </div>
						
              </div>

              <div class="box-footer">
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
<?php
}elseif($_GET["task"]=='drop' || $_GET["task"]=='dropselect'){
  
  $bd = new BD;
  $bd->Begin();
  $ide = !isset($_GET['id']) ? implode(',', $_GET['chkDel']) : $_GET['id'];
  $categoria = executesql("SELECT * FROM flotantes WHERE id IN(".$ide.")");
  if(!empty($categoria)){
    foreach($categoria as $row){
      $pfile = 'files/images/flotantes/'.$row['imagen']; 
      $pfile2 = 'files/images/flotantes/'.$row['imagen2']; 
      if(file_exists($pfile) && !empty($row['imagen'])) unlink($pfile);
      if(file_exists($pfile2) && !empty($row['imagen2'])) unlink($pfile2);
    }
  }
  $bd->actualiza_("DELETE FROM flotantes WHERE id IN(".$ide.")"); 
  $bd->Commit();
  $bd->close();

  if($num_afect<=0){echo "Error: eliminando registro"; exit;}

}elseif($_GET["task"]=='ordenar'){
  $bd = new BD;

  $_GET['order'] = array_reverse($_GET['order']);

  foreach ($_GET['order'] as $order => $item) {
    $orden = $orden + 1;
    $num_afect=$bd->actualiza_("UPDATE flotantes SET orden= ".$orden." WHERE id = ".$item."");
  }

  $bd->close();

}elseif($_GET["task"]=='uestado'){
  $bd = new BD;
  $bd->Begin();
  $ide = !isset($_GET['id']) ? $_GET['estado_idestado'] : $_GET['id'];
  $ide = is_array($ide) ? implode(',',$ide) : $ide;
  $categoria = executesql("SELECT * FROM flotantes WHERE id IN (".$ide.")");
  if(!empty($categoria))
  foreach($categoria as $reg => $item)
  if ($item['estado_idestado']==1) {
    $state = 2;
  }elseif ($item['estado_idestado']==2) {
    $state = 1;
  }
  $num_afect=$bd->actualiza_("UPDATE flotantes SET estado_idestado=".$state." WHERE id=".$ide."");
  echo $state;
  $bd->Commit();
  $bd->close();

}elseif($_GET["task"]=='finder'){

  $sql.= "SELECT c.*,e.nombre AS estado, u.nomusuario  , esp.titulo as especialidad 
  FROM flotantes c 
  INNER JOIN estado e ON c.estado_idestado=e.idestado
  LEFT JOIN especialidades esp ON c.id_especialidad= esp.id_especialidad 
  inner join usuario u ON c.idusuario=u.idusuario 
  ";

  if (isset($_GET['criterio_mostrar'])) $porPagina=$_GET['criterio_mostrar'];
  if(isset($_GET['criterio_usu_per'])){
    $stringlike=fn_filtro(substr($_GET['criterio_usu_per'], 0, 16));
    $sql.= " WHERE c.titulo LIKE '%".$stringlike."%'";
  }
  if(isset($_GET['criterio_ordenar_por'])) $sql.= sprintf(" order by %s %s", fn_filtro($_GET['criterio_ordenar_por']), fn_filtro($_GET['criterio_orden']));
  $sql.= " ORDER BY orden DESC";
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
  $paging->pagina_proceso="flotantes.php";
?>
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr role="row">
                  <th class="unafbe" width="20"><input type="checkbox" id="chkDel" class="all"></th>
                  <th class="sort">ID </th>
                  <th class="sort">ESPECIALIDAD </th>
                  <th class="sort">TÍTULO </th>
                  <th class="unafbe cnone">IMAGEN</th>
                  <th class="unafbe cnone">PUBLICADO</th>
                  <th class="unafbe cnone">FECHA</th>
                  <th class="sort cnone">ESTADO</th>
                  <th class="unafbe">Opciones</th>
                </tr>
              </thead>
              <tbody id="sort">
<?php while ($detalles = $paging->fetchResultado()): ?>
                <tr id="order_<?php echo $detalles["id"]; ?>">
                  <td><input type="checkbox" name="chkDel[]" class="chkDel" value="<?php echo $detalles["id"]; ?>"></td>
                  <td><?php echo $detalles["id"]; ?></td>
                  <td><?php echo !empty($detalles["id_especialidad"])?$detalles["especialidad"]:' PARA TODOS'; ?></td>
                  <td><?php echo $detalles["titulo"].' '.$detalles["boton"]; ?></td>
                  
                  <td >
                    <?php if(!empty($detalles["imagen"])){ ?>
                      <img src="<?php echo "files/images/flotantes/".$detalles["imagen"]; ?>" alt="<?php echo $detalles["nombre"]; ?>" class="img-responsive">
                      <?php }else{ echo "Not Image."; } ?>
                    </td>
                    
                    <td><?php echo $detalles["nomusuario"]; ?></td>
                    <td><?php echo $detalles["fecha_registro"]; ?></td>
                    <td class="cnone"><a href="javascript: fn_estado('<?php echo $detalles["id"]; ?>')"><?php echo $detalles["estado"]; ?></a></td>
                  <td>
                    <div class="btn-eai btr">
                      <a href="<?php echo $_SESSION["base_url"].'&task=edit&id='.$detalles["id"]; ?>"><i class="fa fa-edit"></i></a>
                      <a href="javascript: fn_eliminar('<?php echo $detalles["id"]; ?>')"><i class="fa fa-trash-o"></i></a>
                    </div>
                  </td>
                </tr>
<?php endwhile; ?>
              </tbody>
            </table>
            <div class="pagination"><?php echo $paging->fetchNavegacion(); ?></div>
<script>
$(function(){
  reordenar('flotantes.php');
  checked();
  sorter();
});
</script>

<?php }else{ ?>
        <div class="box-body">
          <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
            <form action="javascript: fn_buscar();" id="frm_buscar" name="frm_buscar">
              <div class="bg-gray-light">
                <div class="col-sm-5">
                  <div class="btn-eai">
                    <a href="<?php echo $link2."&task=new"; ?>" style=" color:#fff;" ><i class="fa fa-file"></i> Agregar</a>
                    <a href="javascript:fn_delete_all();" style=" color:#fff;" ><i class="fa fa-trash-o" ></i> eliminar </a>
                  </div>
                </div>
                <div class="col-sm-3 criterio_buscar">
                  <?php create_input('text','criterio_usu_per','',"form-control pull-right",$table,$agregados); ?>
                </div>
                <div class="col-sm-3 criterio_mostrar">
                  <?php select_sql("nregistros"); ?>
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
var link = "flotante";
var us = "imagen_flotante";
var l = "o";
var l2 = "e";
var pr = "La";
var ar = "la";
var id = "id";
var mypage = "flotantes.php";
</script>
<?php } ?>