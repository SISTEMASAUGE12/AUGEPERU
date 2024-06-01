<?php
error_reporting(E_ALL ^ E_NOTICE);
include ("auten.php");

if($_GET["task"]=='neworden'){
  $bd=new BD;
  $orden_actual=$_GET["orden"];
  $orden_nuevo=$_GET["nuevoorden"];
  $tipo=$_GET["tipo"];  
  $id_del_registro_actual=$_GET["idreclamo"];
  $criterio_Orden =" ";
   
  $bd->close();

}elseif($_GET["task"]=='insert' || $_GET["task"]=='update'){
  
  $bd=new BD;
  $where = ($_GET["task"]=='update') ? "and idreclamo!='".$_POST["idreclamo"]."'" : '';
  
$campos=array('observacion','detallesolu','solucion','implicada','estado','fechasolucion'); /*inserto campos principales*/
  
  if($_GET["task"]=='insert'){

  }else{
       $bd->actualiza_(armaupdate('reclamo',$campos," idreclamo='".$_POST["idreclamo"]."'",'POST'));
    
  }
  $bd->close();
  gotoUrl("index.php?page=".$_POST["nompage"]."&module=".$_POST["nommodule"]."&parenttab=".$_POST["nomparenttab"]);

}elseif($_GET["task"]=='new' || $_GET["task"]=='edit'){
  if($_GET["task"]=='edit'){
     $data_reclamo=executesql("select * from reclamo where idreclamo='".$_GET["idreclamo"]."'",0);
  }
?>
<!-- CK EDITOR -->
<script src="ckeditor/ckeditor.js"></script>
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
                 Solucionar
              </h3>
            </div><!-- /.box-header -->
<?php $task_=$_GET["task"]; ?>
            <!-- form start -->
            <form id="registro" action="reclamos.php?task=<?php echo ($task_=='edit') ?  "update" : "insert"; ?>" class="form-horizontal" method="POST" enctype="multipart/form-data">
<?php 
if($task_=='edit') create_input("hidden","idreclamo",$data_reclamo["idreclamo"],"",$table,"");
create_input("hidden","urlfailed",basename($_SERVER['REQUEST_URI']),"",$table,"");  
create_input("hidden","urlgo",$link,"",$table,"");
create_input("hidden","nompage",$_GET["page"],"",$table,""); 
create_input("hidden","nommodule",$_GET["module"],"",$table,"");
create_input("hidden","nomparenttab",$_GET["parenttab"],"",$table,"");
?>
              <div class="box-body">
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">
                    Nombre
                  </label>
                  <div class="col-sm-4">
                    <?php create_input("text","nombre",$data_reclamo["nombre"]." ".$data_reclamo["apellidop"]." ".$data_reclamo["apellidom"],"form-control",$table,"disabled",$agregado); ?>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">
                    Numero de Documento
                  </label>
                  <div class="col-sm-4">
                    <?php create_input("text","nombre",$data_reclamo["documento"],"form-control",$table,"disabled",$agregado); ?>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">
                    Correo Electrónico
                  </label>
                  <div class="col-sm-4">
                    <?php create_input("text","nombre",$data_reclamo["correo"],"form-control",$table,"disabled",$agregado); ?>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">
                    Teléfono
                  </label>
                  <div class="col-sm-4">
                    <?php create_input("text","nombre",$data_reclamo["telefono"],"form-control",$table,"disabled",$agregado); ?>
                  </div>
                </div>
                <div class="form-group">
		  <label for="inputEmail3" class="col-sm-2 control-label">Departamento</label>
		  <div class="col-sm-4">
		    <?php crearselect("dpt","select iddpto , titulo from dptos",'class="form-control" disabled',$data_reclamo["departamento"],"Seleccione"); ?>
		  </div>
		</div>
		<div class="form-group"> 
		  <label for="inputEmail3" class="col-sm-2 control-label">Provincia</label>
		  <div class="col-sm-4">
		    <?php if($task_=='edit'){ crearselect("idprvc","select idprvc ,titulo from prvc WHERE idprvc='".$data_reclamo["provincia"]."'",'class="form-control" disabled',$data_reclamo["provincia"],"Seleccione"); } ?>
		  </div>
		</div>
		<div class="form-group"> 
		  <label for="inputEmail3" class="col-sm-2 control-label">Distrito</label>
		  <div class="col-sm-4">
		    <?php if($task_=='edit'){ crearselect("iddist","select iddist , titulo from dist WHERE iddist='".$data_reclamo["distrito"]."'",'class="form-control" disabled',$data_reclamo["distrito"],"Seleccione"); } ?>
		  </div>        
		</div>	
		<div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">
                    Tipo de Bien
                  </label>
                  <div class="col-sm-4">
                    <?php create_input("text","nombre",$data_reclamo["biencontra"],"form-control",$table,"disabled",$agregado); ?>
                  </div>
                </div>			
		<div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">
                    Descripción
                  </label>
                  <div class="col-sm-6">
                    <?php create_input("textarea","nombre",$data_reclamo["descripcionbien"],"form-control",$table,"disabled style='height:100px;'",$agregado); ?>
                  </div>
                </div>
		<div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">
                    Tipo
                  </label>
                  <div class="col-sm-4">
                    <?php create_input("text","nombre",$data_reclamo["tiporeclamo"],"form-control",$table,"disabled",$agregado); ?>
                  </div>
                </div>			
		<div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">
                    Detalle
                  </label>
                  <div class="col-sm-6">
                    <?php create_input("textarea","nombre",$data_reclamo["detallerecla"],"form-control",$table,"disabled style='height:100px;'",$agregado); ?>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">
                    Pedido del consumidor
                  </label>
                  <div class="col-sm-6">
                    <?php create_input("textarea","nombre",$data_reclamo["pedidoconsu"],"form-control",$table,"disabled style='height:100px;'",$agregado); ?>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">
                    Estado del reclamo
                  </label>
                  <div class="col-sm-6">
                    <select name="estado" id="estado" class="form-control">
                    <option value="1" <?php echo ($data_reclamo['estado'] == 1) ? 'selected' : '' ?>>Pendiente</option>
                    <option value="2" <?php echo ($data_reclamo['estado'] == 2) ? 'selected' : '' ?>>Culminado</option>
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">
                    Fecha de solución
                  </label>
                  <div class="col-sm-6">
                    <?php create_input("date","fechasolucion",$data_reclamo["fechasolucion"],"form-control",$table,"",$agregado); ?>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">
                    Área implicada                  </label>
                  <div class="col-sm-6">
                    <?php create_input("text","implicada",$data_reclamo["implicada"],"form-control",$table,"",$agregado); ?>
                  </div>
                </div>
		<div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">
                    Encargado de solución                  </label>
                  <div class="col-sm-6">
                    <?php create_input("text","solucion",$data_reclamo["solucion"],"form-control",$table,"",$agregado); ?>
                  </div>
                </div>
		<div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Observación</label>
                  <div class="col-sm-8">
                    <?php create_input("textarea","observacion",$data_reclamo["observacion"],"form-control",$table,"style='height:150px;'",$agregado); ?>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Solución</label>
                  <div class="col-sm-8">
                    <?php create_input("textarea","detallesolu",$data_reclamo["detallesolu"],"form-control",$table,"style='height:150px;'",$agregado); ?>
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
<script type="text/javascript">
var customValidate = {
      rules:{
        archivo:{ accept:'pdf' }
      }
    };
</script>
<?php

}elseif($_GET["task"]=='drop' || $_GET["task"]=='dropselect'){
  
  $bd = new BD;
  $bd->Begin();
  $ide = !isset($_GET['idreclamo']) ? implode(',', $_GET['chkDel']) : $_GET['idreclamo'];
  $bd->actualiza_("DELETE FROM reclamo WHERE idreclamo IN(".$ide.")");
  $bd->Commit();
  $bd->close();


}elseif($_GET["task"]=='finder'){

  $sql = "SELECT r.*, p.titulo as ciudad FROM reclamo r INNER JOIN dist p on r.distrito=p.iddist  "; 

  if(!empty($_GET['criterio_mostrar'])) $porPagina=$_GET['criterio_mostrar'];
  if(!empty($_GET['criterio_usu_per'])){
    $stringlike=fn_filtro(substr($_GET['criterio_usu_per'], 0, 16));
    $sql.= " AND (r.codigoreclamo LIKE '%".$stringlike."%')";
  }
  if(!empty($_GET['estado'])){
    $sql.= " AND r.estado = '".$_GET['estado']."'";
  }
  if(!empty($_GET['criterio_ordenar_por'])) $sql.= sprintf(" order by %s %s", fn_filtro($_GET['criterio_ordenar_por']), fn_filtro($_GET['criterio_orden']));
  $sql.= " ORDER BY r.fecharecla DESC";
  $paging = new PHPPaging;
  $paging->agregarConsulta($sql); 
  $paging->div('div_listar');
  $paging->modo('desarrollo'); 
  $numregistro=1; 
  if($numregistro) $paging->porPagina(fn_filtro((int)$numregistro));
  $paging->verPost(true);
  $mantenerVar=array("idtipo_reclamo","criterio_mostrar","task","criterio_usu_per","criterio_ordenar_por","criterio_orden");

  $paging->mantenerVar($mantenerVar);
  $paging->porPagina(fn_filtro((int)$porPagina));
  $paging->ejecutar();
  $paging->pagina_proceso="reclamos.php";
?>
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr role="row">
                  <th class="unafbe" width="20"><input type="checkbox" id="chkDel" class="all"></th>
                  <th class="sort">CÓDIGO DE RECLAMO</th>
                  <th class="unafbe cnone">USUARIO</th>
                  <th class="unafbe cnone">PROCEDENCIA</th>
                  <th class="unafbe cnone">ESTADO</th>
                  <th class="unafbe cnone">FECHA INGRESO</th>
                  <th class="unafbe cnone">FECHA SOL.</th>
                  <th class="unafbe cnone">ÁREA</th>
                  <th class="unafbe cnone">ENCARGADO</th>
                  <th class="unafbe" width="130">Opciones</th>
                </tr>
              </thead>
              <tbody id="sort">
<?php while ($detalles = $paging->fetchResultado()): ?>
                <tr id="order_<?php echo $detalles["idreclamo"]; ?>">
                  <td><input type="checkbox" name="chkDel[]" class="chkDel" value="<?php echo $detalles["idreclamo"]; ?>"></td>
                  <td><?php echo $detalles["codigoreclamo"]; ?></td>
                  <td><?php echo $detalles["nombre"]; ?></td>
                  <td><?php echo $detalles["ciudad"]; ?></td>
                  <td><?php if($detalles["estado"] == 2){ echo 'Culminado'; }else{ echo 'Pendiente'; } ?></td>
                  <td><?php echo $detalles["fecharecla"]; ?></td>
		  <td><?php echo $detalles["fechasolucion"]; ?></td>
		  <td><?php echo $detalles["implicada"]; ?></td>
		  <td><?php echo $detalles["solucion"]; ?></td>
                  <td>
                    <div class="btn-eai btns btr">
                      <a href="<?php echo $_SESSION["base_url"].'&task=edit&idreclamo='.$detalles["idreclamo"]; ?>"><i class="fa fa-edit"></i></a>
<!-- oculte 2 br}tn q me enlazabn para subri archivos y cargar img aqui no necesario  xq solo editaran
					 <a href="index.php?page=images&idreclamo=<?php /* echo $detalles['idreclamo'];*/ ?>&module=Imágenes&parenttab=Galería"><i class="fa fa-picture-o"></i></a>
                      <a href="index.php?page=archivos&idreclamo=<?php /*echo $detalles['idreclamo'];*/ ?>&module=Archivos&parenttab=Archivos"><i class="fa fa-file-text-o"></i></a> -->
                      <a href="javascript: fn_eliminar('<?php echo $detalles["idreclamo"]; ?>')"><i class="fa fa-trash-o"></i></a>
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
  reordenar('reclamos.php');
});
var mypage = "reclamos.php";
</script>

<?php }else{ ?>
        <div class="box-body">
          <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
            <form action="javascript: fn_buscar();" id="frm_buscar" name="frm_buscar">
              <input type="hidden" name="idtipo_reclamo" value="<?php echo $_GET['idtipo_reclamo']; ?>">
              <div class="bg-gray-light">
                <!--<div class="col-sm-5">
                  <div class="btn-eai">
                    <a href="<?php /* echo $link."&task=new";*/ ?>"><i class="fa fa-file"></i></a>
                    <a href="javascript:fn_delete_all();"><i class="fa fa-trash-o"></i></a>
                  </div>
                </div>-->
                <div class="break"></div>
                <div class="col-sm-3 criterio_buscar">
                  <label for="">Criterio</label>
                  <?php create_input('text','criterio_usu_per','',"form-control pull-right",$table,$agregados); ?>
                </div>
                <div class="col-sm-3 criterio_mostrar">
                  <label for="">N° Registros</label>
                  <?php select_sql("nregistros"); ?>
                </div>
                <div class="col-sm-3 criterio_mostrar">
                  <label for="">Estado del reclamo</label>
                  <select name="estado" id="estado" class="form-control">
                    <option value="">Todos</option>
                    <option value="1">Pendiente</option>
                    <option value="2">Culminado</option>
                  </select>
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
var us = "reclamo";
var link = "reclamo";
var ar = "la";
var l = "a";
var l2 = "a";
var pr = "La";
var id = "idreclamo";
var mypage = "reclamos.php";
</script>

<?php } ?>