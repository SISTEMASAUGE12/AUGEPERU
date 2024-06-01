<?php error_reporting(E_ALL ^ E_NOTICE);
include ("auten.php");

if($_GET["task"]=='neworden'){
  $bd=new BD;
  $orden_actual=$_GET["orden"];
  $orden_nuevo=$_GET["nuevoorden"];
  $tipo=$_GET["tipo"];  
  $id_del_registro_actual=$_GET["id_escala_mag"];
  $criterio_Orden =" ";
  nuevoorden($orden_actual, $orden_nuevo, $tipo, $id_del_registro_actual, "escala_magisteriales", "id_escala_mag", $criterio_Orden);    
  $bd->close();

}elseif($_GET["task"]=='insert' || $_GET["task"]=='update'){
  $bd=new BD;
  $where = ($_GET["task"]=='update') ? "and id_escala_mag!='".$_POST["id_escala_mag"]."'" : '';
  $urlrewrite=armarurlrewrite($_POST["titulo"]);
  $urlrewrite=armarurlrewrite($urlrewrite,1,"escala_magisteriales","id_escala_mag","titulo_rewrite",$where);
  // $campos=array('titulo', array('titulo_rewrite',$urlrewrite),'descripcion',"enlace","estado_idestado"); 
  $campos=array('titulo', array('titulo_rewrite',$urlrewrite),"estado_idestado"); 
  
  if($_GET["task"]=='insert'){
		$_POST['fecha_registro'] = fecha_hora(2);
    $_POST['orden'] = _orden_noticia("","escala_magisteriales","");
    $bd->inserta_(arma_insert('escala_magisteriales',array_merge($campos,array('orden','fecha_registro')),'POST'));
  }else{
  
    $bd->actualiza_(armaupdate('escala_magisteriales',$campos," id_escala_mag='".$_POST["id_escala_mag"]."'",'POST'));/*actualizo*/
  }
  $bd->close();
  gotoUrl("index.php?page=".$_POST["nompage"]."&module=".$_POST["nommodule"]."&parenttab=".$_POST["nomparenttab"]);

}elseif($_GET["task"]=='new' || $_GET["task"]=='edit'){
  if($_GET["task"]=='edit'){
     $data_producto=executesql("select * from escala_magisteriales where id_escala_mag='".$_GET["id_escala_mag"]."'",0);
  }
?>

<section class="content">
  <div class="row">
    <div class="col-md-12">
          <!-- Horizontal Form -->
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title"> escala_magisteriales </h3>
            </div><!-- /.box-header -->
<?php $task_=$_GET["task"]; ?>
            <!-- form start -->
            <form id="registro" action="escala_magisteriales.php?task=<?php echo ($task_=='edit') ?  "update" : "insert"; ?>" class="form-horizontal" method="POST" enctype="multipart/form-data">
<?php 
if($task_=='edit') create_input("hidden","id_escala_mag",$data_producto["id_escala_mag"],"",$table,"");
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
                  <label for="inputPassword3" class="col-sm-2 control-label">Nombre grupo:</label>
                  <div class="col-sm-6">
                    <?php create_input("text","titulo",$data_producto["titulo"],"form-control",$table,"",$agregado); ?>
                  </div>
                </div>
		
               
              </div>
              <div class="box-footer">
                <div class="form-group">
                  <div class="col-sm-10 pull-right">
                    <button type="submit" class="btn bg-blue btn-flat">Guardar</button>
                    <button type="button" class="btn bg-red btn-flat" onclick="javascript:gotourl('<?php echo $link2; ?>');">Cancelar</button>
                  </div>
                </div>
              </div>
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
  $id_escala_mag = !isset($_GET['id_escala_mag']) ? implode(',', $_GET['chkDel']) : $_GET['id_escala_mag'];
  $escala_magisteriales = executesql("SELECT * FROM escala_magisteriales WHERE id_escala_mag IN(".$id_escala_mag.")");
  if(!empty($escala_magisteriales)){
    foreach($escala_magisteriales as $row){
      $pfile = 'files/images/escala_magisteriales/'.$row['imagen']; if(file_exists($pfile) && !empty($row['imagen'])){ unlink($pfile); }
      // $pfile = 'files/images/escala_magisteriales/'.$row['imagen2']; if(file_exists($pfile) && !empty($row['imagen2'])){ unlink($pfile); }
     }
    }  
  $bd->actualiza_("DELETE FROM escala_magisteriales WHERE id_escala_mag IN(".$id_escala_mag.")");
  $bd->Commit();
  $bd->close();

}elseif($_GET["task"]=='ordenar'){

  $bd = new BD;
  $_GET['order'] = array_reverse($_GET['order']);
  foreach ($_GET['order'] as $order => $item) {
    $orden = $orden + 1;
    $bd->actualiza_("UPDATE escala_magisteriales SET orden= ".$orden." WHERE id_escala_mag = ".$item."");
  }
  $bd->Commit();
  $bd->close();

}elseif($_GET["task"]=='uestado'){

  $bd = new BD;
  $bd->Begin();

  $id_escala_mag = !isset($_GET['id_escala_mag']) ? $_GET['estado_idestado'] : $_GET['id_escala_mag'];
  $id_escala_mag = is_array($id_escala_mag) ? implode(',',$id_escala_mag) : $id_escala_mag;
  $escala_magisteriales = executesql("SELECT * FROM escala_magisteriales WHERE id_escala_mag IN (".$id_escala_mag.")");

  if(!empty($escala_magisteriales))
    foreach($escala_magisteriales as $reg => $item)
      if ($item['estado_idestado']==1) {
        $state = 2;
      }elseif ($item['estado_idestado']==2) {
        $state = 1;
      }
  $bd->actualiza_("UPDATE escala_magisteriales SET estado_idestado=".$state." WHERE id_escala_mag=".$id_escala_mag."");
  echo $state;
  $bd->Commit();
  $bd->close();

}elseif($_GET["task"]=='finder'){

  $sql = "SELECT p.*, e.nombre as estado FROM escala_magisteriales p Inner join estado e on p.estado_idestado=e.idestado "; 
  if(isset($_GET['criterio_mostrar'])) $porPagina=$_GET['criterio_mostrar'];
  if(isset($_GET['criterio_usu_per']) && !empty($_GET['criterio_usu_per'])){
    $stringlike=fn_filtro(substr($_GET['criterio_usu_per'], 0, 16));
    $sql.= " where titulo LIKE '%".$stringlike."%' OR descripcion LIKE '%".$stringlike."%' ";
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
  $paging->pagina_proceso="escala_magisteriales.php";
?>
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr role="row">
                  <th class="unafbe" width="20"><input type="checkbox" id="chkDel" class="all"></th>
                  <th class="sort">NOMBRE</th>
                  <th class="sort cnone">ESTADO</th>
                  <th class="unafbe" width="70">Opciones</th>
                </tr>
              </thead>
              <tbody id="sort">
<?php while ($detalles = $paging->fetchResultado()): ?>
                <tr id="order_<?php echo $detalles["id_escala_mag"]; ?>">
                  <td><input type="checkbox" name="chkDel[]" class="chkDel" value="<?php echo $detalles["id_escala_mag"]; ?>"></td>
                  <td><?php echo $detalles["titulo"]; ?></td>                             
                  <td class="cnone"><a href="javascript: fn_estado('<?php echo $detalles["id_escala_mag"]; ?>')"><?php echo $detalles["estado"]; ?></a></td>
                  <td>
                    <div class="btn-eai btns btr text-center ">
                      <a href="<?php echo $_SESSION["base_url"].'&task=edit&id_escala_mag='.$detalles["id_escala_mag"]; ?>" style="color:#fff;"><i class="fa fa-edit"></i> editar</a>
											
                    </div>
                  </td>
                </tr>
<?php endwhile; ?>
              </tbody>
            </table>
            <div class="pagination"><?php echo $paging->fetchNavegacion(); ?></div>
<script>
$(function(){
  checked();
  sorter();
  reordenar('escala_magisteriales.php');
});
var mypage = "escala_magisteriales.php";
</script>

<?php }else{ ?>
        <div class="box-body">
          <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
            <form action="javascript: fn_buscar();" id="frm_buscar" name="frm_buscar">
              <div class="bg-gray-light">
                <div class="col-sm-2">
                  <div class="btn-eai">
                    <a href="<?php echo $link2."&task=new"; ?>" style="color:#fff;"><i class="fa fa-file"></i> Agregar</a>
										<!-- 
                    <a href="javascript:fn_delete_all();"><i class="fa fa-trash-o"></i></a>
										-->
                  </div>
                </div>
                <div class="col-sm-4 criterio_buscar">
                  <?php create_input('text','criterio_usu_per','',"form-control pull-right",$table,"placeholder='Buscar ..'"); ?>
                </div>
                <div class="col-sm-2 criterio_mostrar">
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
var us = "escala";
var link = "escala_magisteriale";
var ar = "el";
var l = "e";
var l2 = "e";
var pr = "el";
var id = "id_escala_mag";
var mypage = "escala_magisteriales.php";
</script>

<?php } ?>