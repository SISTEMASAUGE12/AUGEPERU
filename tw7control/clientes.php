<?php error_reporting(E_ALL ^ E_NOTICE);
include_once("auten.php");

if($_GET["task"]=='neworden'){
  $bd=new BD;
  $orden_actual=$_GET["orden"];
  $orden_nuevo=$_GET["nuevoorden"];
  $tipo=$_GET["tipo"];  
  $id_del_registro_actual=$_GET["ide"];
  $criterio_Orden ="";
  nuevoorden($orden_actual, $orden_nuevo, $tipo, $id_del_registro_actual, "clientes", "ide", $criterio_Orden);    
  $bd->close();

}elseif($_GET['task']=='insert'){
  $bd=new BD;
    $dir = "files/images/clientes/";
    $norden=_orden_noticia("","clientes","");
    $campos= array(array("orden", $norden), array("estado_idestado", 1));
	
	if(isset($_FILES['file']) && !empty($_FILES['file']['name'])){
      $_POST['imagen'] = carga_imagen($dir,'file','');
      $campos = array_merge($campos,array('imagen'));
    }
	$sql=arma_insert("clientes",$campos,"POST");
      $bd->inserta_($sql);
    $bd->close();

}elseif($_GET['task']=='update'){
    
    $bd = new BD;
    if(isset($_POST['nombre'])){
        // echo var_dump($_POST['nombre']);
        // exit;
        foreach($_POST['nombre'] as $k => $row){
           $bd->actualiza_( armaupdate('clientes',array(array("nombre",$row[0]))," ide='".$k."'",'POST')); /*actualizo*/
        }
    }
    $bd->close();
    gotoUrl("index.php?page=".$_POST["nompage"]."&module=".$_POST["nommodule"]."&parenttab=".$_POST["nomparenttab"]);  
 
}elseif($_GET["task"]=='drop' || $_GET["task"]=='dropselect'){
  
  $bd = new BD;
  $bd->Begin();
  $ide = !isset($_GET['ide']) ? implode(',', $_GET['chkDel']) : $_GET['ide'];
  $destinos = executesql("SELECT * FROM clientes WHERE ide IN(".$ide.")");
  if(!empty($destinos)){
    foreach($destinos as $row){
      $pfile = 'files/images/clientes/'.$row['imagen']; 
      if(file_exists($pfile) && !empty($row['imagen'])) unlink($pfile);
    }
  }
   
  $bd->actualiza_("DELETE FROM clientes WHERE ide IN(".$ide.")");
  $bd->Commit();
  $bd->close();

}elseif($_GET["task"]=='ordenar'){
  $bd = new BD;

  $_GET['order'] = array_reverse($_GET['order']);

  foreach ($_GET['order'] as $order => $item) {
    $orden = $orden + 1;
    $num_afect=$bd->actualiza_("UPDATE clientes SET orden= ".$orden." WHERE ide = ".$item."");
  }

}elseif($_GET["task"]=='finder'){

  $sql.= "SELECT i.*, e.nombre AS estado FROM clientes i inner join  estado e ";
  $sql.= " WHERE i.estado_idestado=e.idestado ";
  if (isset($_GET['criterio_mostrar'])) $porPagina=$_GET['criterio_mostrar'];
  
  $sql.= " ORDER BY orden DESC";
  $paging = new PHPPaging;
  $paging->agregarConsulta($sql); 
  $paging->div('div_listar');
  $paging->modo('desarrollo'); 
  //$numregistro=1; 
  //if($numregistro) $paging->porPagina(fn_filtro((int)$numregistro));
  $paging->verPost(true);
  $ip = 1500;
  // $mantenerVar=array("criterio_mostrar","task");
  // $paging->mantenerVar($mantenerVar);
  $paging->porPagina(fn_filtro($ip));
  $paging->ejecutar();
  $paging->pagina_proceso="clientes.php";
?>
       <form action="clientes.php?task=update" class="form-horizontal" method="POST" enctype="multipart/form-data" autocomplete="OFF">
            <input type="hidden" name="nompage" value="<?php echo $_GET['nompage']; ?>">
            <input type="hidden" name="nommodule" value="<?php echo $_GET['nommodule']; ?>">
            <input type="hidden" name="nomparenttab" value="<?php echo $_GET['nomparenttab']; ?>">  
            <div class="box-body">
              <a href="javascript:history.go(-1)" class="pull-right">&laquo; RETORNAR</a>
              <div class="dai">
                <input type="checkbox" id="chkDel" class="all">&nbsp;&nbsp;|&nbsp;&nbsp;
                <a href="javascript:fn_delete_all();"><i class="fa fa-trash-o"></i></a>
                <button  style="margin-left:20px;">Guardar</button> 
              </div>
              <div class="gallery">
                <ul id="sort" class="reorder_ul reorder-photos-list">
  <?php while ($detalles = $paging->fetchResultado()): ?>
                  <li id="order_<?php echo $detalles['ide']; ?>" class="ui-sortable-handle">
                    <a href="javascript: fn_eliminar('<?php echo $detalles["ide"]; ?>')"><i class="fa fa-trash-o delete_image"></i></a>
                    <img src="files/images/clientes/<?php echo $detalles['imagen']; ?>" alt="">
                    <?php create_input("text","nombre[".$detalles['ide']."][]",$detalles["nombre"],"form-control",$table,"","Placeholder='Nombre Imágen'"); ?>
                    <div class="break"></div>
                    <input type="checkbox" name="chkDel[]" class="chk_image chkDel" value="<?php echo $detalles["ide"]; ?>">
                  </li>
  <?php endwhile; ?>
                </ul>
              </div>
            </div>
        </form>
            <div class="pagination"><?php echo $paging->fetchNavegacion(); ?></div>
<script>
$(function(){
  reordenar('clientes.php');
  checked();
});
</script>
<?php }else{ ?>

<section class="content">
  <div class="row">
    <div class="col-md-12">
          <!-- Horizontal Form -->
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">
                Lista de Testimonios</h3>
                <p style="color:red;">Tamaño Exactamente: 500px ancho x 150px altura Maxima</p>
            </div><!-- /.box-header -->
            <div class="box-body">
              <div id="example1_wrapper">
                <div class="row">
                  <div class="col-sm-12">
                    <div class="image_upload_div">
                      <form action="clientes.php?task=insert" id="frm_buscar" class="dropzone">                  
                        <input type="hidden" name="nompage" value="<?php echo $_GET['page']; ?>">
                        <input type="hidden" name="nommodule" value="<?php echo $_GET['module']; ?>">
                        <input type="hidden" name="nomparenttab" value="<?php echo $_GET['parenttab']; ?>">
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div id="div_listar"></div>
            <div id="div_oculto" style="display: none;"></div>
          </div><!-- /.box -->
        </div><!--/.col (right) -->
  </div>
</section><!-- /.content -->
<script>
var accept = ".png, .jpg, .jpeg, .JPG, .PNG, .JPEG";
var msj = "Click o arrastra tus imágenes para subirlas.";
var link = "cliente";
var us = "imagen";
var l = "o";
var l2 = "o";
var pr = "La";
var ar = "la";
var id = "ide";
var mypage = "clientes.php";
</script>
<?php } ?>