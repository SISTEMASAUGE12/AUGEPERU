<?php error_reporting(E_ALL ^ E_NOTICE);
include_once("auten.php");
if($_GET["task"]=='neworden'){
  $bd=new BD;
  $orden_actual=$_GET["orden"];
  $orden_nuevo=$_GET["nuevoorden"];
  $tipo=$_GET["tipo"];  
  $id_del_registro_actual=$_GET["id_com"];
  $criterio_Orden ="";
  nuevoorden($orden_actual, $orden_nuevo, $tipo, $id_del_registro_actual, "comentario", "id_com", $criterio_Orden);    
  $bd->close();

}elseif($_GET["task"]=='update'){
  $bd=new BD;
  $campos=array("comen","estado_idestado"); 	
	$bd->actualiza_(armaupdate('comentario',$campos," id_com='".$_POST["id_com"]."'",'POST'));
	$bd->close();
	gotoUrl("index.php?page=".$_POST["nompage"]."&module=".$_POST["nommodule"]."&parenttab=".$_POST["nomparenttab"]);  
  
}elseif($_GET["task"]=='edit'){
  $data_producto=executesql("select * from comentario where id_com='".$_GET["id_com"]."' ",0);
?>
<section class="content">
  <div class="row">
    <div class="col-md-12">
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Comentarios:</h3>
              <p style="color:red">*Leer que el contenido tenga congruencia si es así, habilitar el estado.</p>
            </div>
            <form id="registro" action="comentario2s.php?task=update" class="form-horizontal" method="POST"  enctype="multipart/form-data">
<?php 
create_input("hidden","id_com",$data_producto["id_com"],"",$table,""); 
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
					  <label for="inputPassword3" class="col-sm-2 control-label">Comentario</label>
					  <div class="col-sm-6">
						<?php create_input("textarea","comen",$data_producto["comen"],"form-control",$table,"",$agregado); ?>
					  </div>
					</div>
				</div>
				<div class="box-footer">
					<div class="form-group">
						<div class="col-sm-10 pull-right">
							<button type="submit" class="btn bg-blue btn-flat">Guardar</button>
<?php $retornar="index.php?page=".$_GET["page"]."&module=".$_GET["module"]."&parenttab=".$_GET["parenttab"]; ?>
							<button type="button" class="btn bg-red btn-flat" onclick="javascript:gotourl('<?php echo $retornar; ?>');">Cancelar</button>
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
  $bd->actualiza_("DELETE FROM comentario WHERE id_com IN(".$ide.")");
  $bd->Commit();
  $bd->close();
  if($num_afect<=0){echo "Error: eliminando registro"; exit;}

}elseif($_GET["task"]=='ordenar'){
  $bd = new BD;
  $_GET['order'] = array_reverse($_GET['order']);
  foreach ($_GET['order'] as $order => $item) {
    $orden = $orden + 1;
    $num_afect=$bd->actualiza_("UPDATE comentario SET orden= ".$orden." WHERE id_com = ".$item."");
  }
  $bd->close();
}elseif($_GET["task"]=='uestado'){
  $bd = new BD;
  $bd->Begin();
  $ide = !isset($_GET['ide']) ? $_GET['estado_idestado'] : $_GET['ide'];
  $ide = is_array($ide) ? implode(',',$ide) : $ide;
  $comentarios = executesql("SELECT * FROM comentario WHERE id_com IN (".$ide.")");
  if(!empty($comentarios))
  foreach($comentarios as $reg => $item)
  if ($item['estado_idestado']==1) {
    $state = 2;
  }elseif ($item['estado_idestado']==2) {
    $state = 1;
  }
  $num_afect=$bd->actualiza_("UPDATE comentario SET estado_idestado=".$state." WHERE id_com=".$ide."");
  echo $state;
  $bd->Commit();
  $bd->close();

}elseif($_GET["task"]=='finder'){

  $sql.= "SELECT c.*,CONCAT(s.ap_pa, ' ', s.ap_ma, ' ', s.nombre) as suscrito, s.email as email, s.telefono as telefono, cu.titulo as curso, se.titulo as sesion, ds.titulo as detalle, e.nombre AS estado 
  FROM comentario c 
	INNER JOIN estado e ON c.estado_idestado=e.idestado 
  INNER JOIN suscritos s ON c.id_suscrito=s.id_suscrito 
  INNER JOIN cursos cu ON c.id_curso=cu.id_curso 
  INNER JOIN sesiones se ON c.id_sesion=se.id_sesion
	INNER JOIN detalle_sesiones ds ON c.id_detalle=ds.id_detalle 
   ";
  if (isset($_GET['criterio_mostrar'])) $porPagina=$_GET['criterio_mostrar'];
  if(isset($_GET['criterio_usu_per']) && !empty($_GET['criterio_usu_per'])){
    $stringlike=fn_filtro(substr($_GET['criterio_usu_per'], 0, 16));
    $sql.= " WHERE s.pais LIKE '%".$stringlike."%' or s.ciudad LIKE '%".$stringlike."%' or s.email LIKE '%".$stringlike."%' ";
  }
  if(isset($_GET['criterio_ordenar_por'])) $sql.= sprintf(" order by %s %s", fn_filtro($_GET['criterio_ordenar_por']), fn_filtro($_GET['criterio_orden']));
  $sql.= " ORDER BY c.orden DESC";
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
  $paging->pagina_proceso="comentario2s.php";
?>
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr role="row">
                  <th class="unafbe" width="20"><input type="checkbox" id="chkDel" class="all"></th>
                  <th class="sort   ">Suscrito</th>
                  <th class="sort cnone ">Correo</th>
                  <th class="sort cnone">Teléfono</th>
                  <th class="sort cnone ">Curso</th>
                  <th class="sort cnone ">Sesión</th>
                  <th class="sort cnone ">Detalle Sesión</th>
                  <th class="sort cnone  ">Comentario</th>
                  <th class="sort cnone">ESTADO</th>
                  <th class="unafbe">Opciones</th>
                </tr>
              </thead>
              <tbody id="sort">
<?php while ($detalles = $paging->fetchResultado()):
		$style=($detalles["estado_idestado"]==1)?'':'background:red;color:#fff;';
		$color=($detalles["estado_idestado"]==2)?'color:#fff;':'';
 ?>
                <tr id="order_<?php echo $detalles["id_com"]; ?>" style="<?php echo $style;?>">
                  <td><input type="checkbox" name="chkDel[]" class="chkDel" value="<?php echo $detalles["id_com"]; ?>"></td>
                  <td class="   " ><?php echo $detalles["suscrito"]; ?></td>
                  <td class="cnone"><?php echo $detalles["email"]; ?></td>
                  <td class="cnone"><?php echo $detalles["telefono"]; ?></td>
                  <td class="cnone" ><?php echo $detalles["curso"]; ?></td>
                  <td class="cnone" ><?php echo $detalles["sesion"]; ?></td>
                  <td class="cnone"><?php echo $detalles["detalle"]; ?></td>
                  <td class=" cnone "><?php echo short_name($detalles["comen"],80); ?></td>
                  <td class="  cnone">
<a href="javascript: fn_estado('<?php echo $detalles["id_com"]; ?>')" style="<?php echo $color;?>"><?php echo $detalles["estado"]; ?></a>
									</td>
                  <td>
                    <div class="btn-eai btr">
                      <a href="<?php echo $_SESSION["base_url"].'&task=edit&id_com='.$detalles["id_com"]; ?>" title="Editar comentario"><i class="fa fa-edit"></i></a>
                      <a href="javascript: fn_eliminar('<?php echo $detalles["id_com"]; ?>')" title="Eliminar comentario"><i class="fa fa-trash-o"></i></a>
                    </div>
                  </td>
                </tr>
<?php endwhile; ?>
              </tbody>
            </table>
            <div class="pagination"><?php echo $paging->fetchNavegacion(); ?></div>
<script>
$(function(){
  reordenar('comentario2s.php');
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
										<p>Comentarios de usuarios</p>
                  </div>
                </div>
                <div class="break"></div>
                <div class="col-sm-3 criterio_buscar">
                  <label for="">Buscar</label>
                  <?php create_input('text','criterio_usu_per','',"form-control pull-right",$table,"placeholder='ejem:LambayequeTurismo'"); ?>
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
var link = "comentario2";
var us = "comentario";
var l = "o";
var l2 = "3";
var pr = "El";
var ar = "el";
var id = "ide";
var mypage = "comentario2s.php";
</script>
<?php } ?>