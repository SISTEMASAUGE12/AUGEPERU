<?php
error_reporting(E_ALL ^ E_NOTICE);
include_once("auten.php");

if($_GET["task"]=='neworden'){
  $bd=new BD;
  $orden_actual=$_GET["orden"];
  $orden_nuevo=$_GET["nuevoorden"]; 
  $id_del_registro_actual=$_GET["ide"];
  $criterio_Orden ="";
  nuevoorden($orden_actual, $orden_nuevo, $id_del_registro_actual, "trabajo", "ide", $criterio_Orden);    
  $bd->close();

}elseif($_GET["task"]=='edit'){
     $usuario=executesql("select * from trabajo where ide='".$_GET["ide"]."'",0);
?>
<section class="content">
  <div class="row">
    <div class="col-md-12">
          <!-- Horizontal Form -->
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">
                 Postulaciones</h3>
            </div><!-- /.box-header -->
<?php $task_=$_GET["task"]; ?>
            <!-- form start -->
            <form action="trabajos.php" class="form-horizontal" method="POST" autocomplete="OFF">
<?php 
if($task_=='edit') create_input("hidden","ide",$usuario["ide"],"",$table,"");
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
                    <?php crearselect("estado_idestado","select * from estado",'class="form-control"',$usuario["estado_idestado"],""); ?>
                  </div>
                </div>
			
              
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Nombre</label>
                  <div class="col-sm-6">
                    <?php create_input("text","nombre",$usuario["nombre"],"form-control",$table,"required",$agregado); ?>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Apellidos</label>
                  <div class="col-sm-6">
                    <?php create_input("text","apellido",$usuario["apellido"],"form-control",$table,"required",$agregado); ?>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">DNI</label>
                  <div class="col-sm-6">
                    <?php create_input("text","dni",$usuario["dni"],"form-control",$table,"required",$agregado); ?>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Telefono</label>
                  <div class="col-sm-6">
                    <?php create_input("text","telefono",$usuario["telefono"],"form-control",$table,"required",$agregado); ?>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Ciudad</label>
                  <div class="col-sm-6">
                    <?php create_input("text","ciudad",$usuario["ciudad"],"form-control",$table,"required",$agregado); ?>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Email</label>
                  <div class="col-sm-6">
                    <?php create_input("text","email",$usuario["email"],"form-control",$table,"required",$agregado); ?>
                  </div>
                </div>
                
                 <div class="form-group">
              <label for="inputPassword3" class="col-sm-2 control-label">CV.</label>
              <div class="col-sm-6">
                <?php create_input("hidden","archivo_ant",$usuario["archivo"],"",$table,$agregado); 
                  if($usuario["archivo"]!=""){ 
                ?>
                 <a target="_blank" href="files/files/trabajo/<?php echo $usuario['archivo']; ?>"> <img src="../intranet/dist/img/icons/icon-pdf.jpg"></a>
                <?php } ?> 
              </div>
          </div>  
          
              </div>
              <div class="box-footer">
                <div class="form-group">
                  <div class="col-sm-10 pull-right">
                    <button type="button" class="btn bg-red btn-flat" onclick="javascript:gotourl('<?php echo $link2; ?>');">Cerrar</button>
                  </div>
                </div>
              </div>
            </form>
          </div><!-- /.box -->
        </div><!--/.col (right) -->
  </div>
</section><!-- /.content -->
<?php
}elseif($_GET["task"]=='drop' || $_GET["task"]=='dropselect'){
  
  $bd = new BD;
  $bd->Begin();
  $ide = !isset($_GET['ide']) ? implode(',', $_GET['chkDel']) : $_GET['ide'];
  $product = executesql("SELECT * FROM trabajo WHERE ide IN(".$ide.")");
  if(!empty($product)){
    foreach($product as $row){
      $pfile = 'files/files/trabajo/'.$row['archivo']; if(file_exists($pfile) && !empty($row['archivo'])){ unlink($pfile); }
    }
  } 
   $bd->actualiza_("DELETE FROM trabajo WHERE ide IN(".$ide.")");
  $bd->Commit();
  $bd->close();

  if($num_afect<=0){echo "Error: eliminando registro"; exit;}

}elseif($_GET["task"]=='ordenar'){
  $bd = new BD;

  $_GET['order'] = array_reverse($_GET['order']);

  foreach ($_GET['order'] as $order => $item) {
    $orden = $orden + 1;
    $num_afect=$bd->actualiza_("UPDATE trabajo SET orden= ".$orden." WHERE ide = ".$item."");
  }

  $bd->close();
  
}elseif($_GET["task"]=='uestado'){
  $bd = new BD;
  $bd->Begin();
  $ide = !isset($_GET['ide']) ? $_GET['estado_idestado'] : $_GET['ide'];
  $ide = is_array($ide) ? implode(',',$ide) : $ide;
  $usuario = executesql("SELECT * FROM trabajo WHERE ide IN (".$ide.")");
  if(!empty($usuario))
  foreach($usuario as $reg => $item)
  if ($item['estado_idestado']==1) {
    $state = 2;
  }elseif ($item['estado_idestado']==2) {
    $state = 1;
  }
  $num_afect=$bd->actualiza_("UPDATE trabajo SET estado_idestado=".$state." WHERE ide=".$ide."");
  echo $state;
  $bd->Commit();
  $bd->close();

}elseif($_GET["task"]=='finder'){

  $sql.= "SELECT c.*, e.nombre AS estado FROM trabajo c,estado e ";
  $sql.= " WHERE c.estado_idestado=e.idestado ";
  if (isset($_GET['criterio_mostrar'])) $porPagina=$_GET['criterio_mostrar'];
  if(isset($_GET['criterio_usu_per']) && !empty($_GET['criterio_usu_per'])){
    $stringlike=fn_filtro(substr($_GET['criterio_usu_per'], 0, 16));
    $sql.= " AND (c.nombre like '%".$stringlike."%' OR c.apellido like '%".$stringlike."%' OR c.dni like '%".$stringlike."%' OR c.ciudad like '%".$stringlike."%' OR c.email LIKE '%".$stringlike."%')";
  }
  $paging = new PHPPaging;
  $paging->agregarConsulta($sql); 
  $paging->div('div_listar');
  $paging->modo('desarrollo'); 
  $numregistro=1; 
  if($numregistro) $paging->porPagina(fn_filtro((int)$numregistro));
  $paging->verPost(true);
  $mantenerVar=array("criterio_mostrar","task","criterio_usu_per");
  $paging->mantenerVar($mantenerVar);
  $paging->porPagina(fn_filtro((int)$porPagina));
  $paging->ejecutar();
  $paging->pagina_proceso="trabajos.php";
?>
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr role="row">
                  <th class="unafbe" width="20"><input type="checkbox" id="chkDel" class="all"></th>
                  <th class="sort ">Nombre</th>
                  <th class="sort ">DNI</th>
                  <th class="sort ">Telefono</th>
                  <th class="sort  ">Email</th>
                  <th class="sort  ">Ciudad</th>
                  <th class="sort  ">CV</th>
                  <th class="sort cnone">ESTADO</th>
                  <th class="unafbe">Opciones</th>
                </tr>
              </thead>
              <tbody id="sort">
<?php while ($detalles = $paging->fetchResultado()): ?>
                <tr id="order_<?php echo $detalles["ide"]; ?>">
                  <td><input type="checkbox" name="chkDel[]" class="chkDel" value="<?php echo $detalles["ide"]; ?>" id="id"></td>
                  <td><?php echo $detalles["nombre"]." ".$detalles["apellido"]; ?></td>
                  <td><?php echo $detalles["dni"]; ?></td>
                  <td><?php echo $detalles["telefono"]; ?></td>
                  <td><?php echo $detalles["email"]; ?></td>
                  <td><?php echo $detalles["ciudad"]; ?></td>
                   <td class="">
                    <?php if(!empty($detalles["archivo"])){ ?>
                    <a target="_blank" href="<?php echo "files/files/trabajo/".$detalles["archivo"]; ?>"><img src="../intranet/dist/img/icons/icon-pdf.jpg" class="img-responsive"></a>
                    <?php }else{ echo "Not archivo."; } ?>
                  </td>
                  <td class="cnone"><a href="javascript: fn_estado('<?php echo $detalles["ide"]; ?>')"><?php echo $detalles["estado"]; ?></a></td>
                  <td>
                    <div class="btn-eai btr">
                      <a href="<?php echo $_SESSION["base_url"].'&task=edit&ide='.$detalles["ide"]; ?>"><i class="fa fa-edit"></i></a>
                      <a href="javascript: fn_eliminar('<?php echo $detalles["ide"]; ?>')"><i class="fa fa-trash-o"></i></a>
                    </div>
                  </td>
                </tr>
<?php endwhile; ?>
              </tbody>
            </table>
            <div class="pagination"><?php echo $paging->fetchNavegacion(); ?></div>
<script>
$(function(){
  reordenar('trabajos.php');
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
                    <a href="javascript:fn_delete_all();"><i class="fa fa-trash-o"></i></a>
                  </div>
                </div>
                <div class="break"></div>
                <div class="col-sm-3 criterio_buscar">
                  <label for="">Criterio</label>
                  <?php create_input('text','criterio_usu_per','',"form-control pull-right",$table,$agregados); ?>
                </div>
                <div class="col-sm-3 criterio_mostrar">
                  <label for="">N° Registros</label>
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
var link = "trabajo";/*la s final se agrega en js fuctions*/
var us = "suscriptor";/*sirve para mensaje en ventana eliminar*/
var l = "o";
var l2 = "e";/* est+ _ x {e,a,o ,etc}sirve para mensaje en ventana eliminar*/
var pr = "El";
var ar = "al";
var id = "ide";
var mypage = "trabajos.php";
</script>
<?php } ?>