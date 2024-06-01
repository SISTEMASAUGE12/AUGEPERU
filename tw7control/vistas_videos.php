<?php error_reporting(E_ALL ^ E_NOTICE);
include_once("auten.php");
if($_GET["task"]=='neworden'){
  $bd=new BD;
  $orden_actual=$_GET["orden"];
  $orden_nuevo=$_GET["nuevoorden"];
  $tipo=$_GET["tipo"];  
  $id_del_registro_actual=$_GET["id_vid"];
  $criterio_Orden ="";
  nuevoorden($orden_actual, $orden_nuevo, $tipo, $id_del_registro_actual, "conta_video", "id_vid", $criterio_Orden);    
  $bd->close(); 

}elseif($_GET["task"]=='drop' || $_GET["task"]=='dropselect'){  
  $bd = new BD;
  $bd->Begin();
  $ide = !isset($_GET['ide']) ? implode(',', $_GET['chkDel']) : $_GET['ide'];  
  $bd->actualiza_("DELETE FROM conta_video WHERE id_vid IN(".$ide.")");
  $bd->Commit();
  $bd->close();
  if($num_afect<=0){echo "Error: eliminando registro"; exit;}

}elseif($_GET["task"]=='ordenar'){
  $bd = new BD;
  $_GET['order'] = array_reverse($_GET['order']);
  foreach ($_GET['order'] as $order => $item) {
    $orden = $orden + 1;
    $num_afect=$bd->actualiza_("UPDATE conta_video SET orden= ".$orden." WHERE id_vid = ".$item."");
  }
  $bd->close();
}elseif($_GET["task"]=='uestado'){
  $bd = new BD;
  $bd->Begin();
  $ide = !isset($_GET['ide']) ? $_GET['estado_idestado'] : $_GET['ide'];
  $ide = is_array($ide) ? implode(',',$ide) : $ide;
  $comentarios = executesql("SELECT * FROM conta_video WHERE id_vid IN (".$ide.")");
  if(!empty($comentarios))
  foreach($comentarios as $reg => $item)
  if ($item['estado_idestado']==1) {
    $state = 2;
  }elseif ($item['estado_idestado']==2) {
    $state = 1;
  }
  $num_afect=$bd->actualiza_("UPDATE conta_video SET estado_idestado=".$state." WHERE id_vid=".$ide."");
  echo $state;
  $bd->Commit();
  $bd->close();

}elseif($_GET["task"]=='finder'){

  $array= array();
  $meses=array('Jan'=>'Enero','Feb'=>'Febrero','Mar'=>'Marzo','Apr'=>'Abril','May'=>'Mayo','Jun'=>'Junio','Jul'=>'Julio','Aug'=>'Agosto','Sep'=>'Septiembre','Oct'=>'Octubre','Nov'=>'Noviembre','Dec'=>'Diciembre');
  $sql.= "SELECT c.*,YEAR(c.fecha_registro) as anho, MONTH(c.fecha_registro) as mes,CONCAT(s.dni, ' ',s.ap_pa, ' ', s.ap_ma, ' ', s.nombre) as suscrito, s.email as email, s.telefono as telefono, cu.codigo as cod_curso, cu.titulo as curso, se.titulo as sesion, ds.titulo as detalle, e.nombre AS estado 
  FROM conta_video c 
	INNER JOIN estado e ON c.estado_idestado=e.idestado 
  INNER JOIN suscritos s ON c.id_suscrito=s.id_suscrito 
  INNER JOIN cursos cu ON c.id_curso=cu.id_curso 
  INNER JOIN sesiones se ON c.id_sesion=se.id_sesion
	INNER JOIN detalle_sesiones ds ON c.id_detalle=ds.id_detalle 
   ";
  if (isset($_GET['criterio_mostrar'])) $porPagina=$_GET['criterio_mostrar'];
  if(isset($_GET['criterio_usu_per']) && !empty($_GET['criterio_usu_per'])){
    $stringlike=fn_filtro(substr($_GET['criterio_usu_per'], 0, 16));
    $sql.= " WHERE s.ap_pa LIKE '%".$stringlike."%' or s.ap_ma LIKE '%".$stringlike."%' or s.nombre LIKE '%".$stringlike."%' or s.dni LIKE '%".$stringlike."%' or cu.codigo LIKE '%".$stringlike."%' ";
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
  $paging->pagina_proceso="vistas_videos.php";
?>
            <table id="example1" class="table table-bordered table-striped">
              <tbody id="sort">
<?php while ($detalles = $paging->fetchResultado()):
		$style=($detalles["estado_idestado"]==1)?'':'background:red;color:#fff;';
		$color=($detalles["estado_idestado"]==2)?'color:#fff;':'';
    if(!in_array(array('mes' => $detalles['mes'], 'anho' => $detalles['anho']), $array)){
        $array[] = array('mes' => $detalles['mes'], 'anho' => $detalles['anho']);
?>
        <tr class="lleva-mes">
          <td colspan="9"><h6><?php echo strtoupper(strtr(date('M Y',strtotime($detalles['fecha_registro'])),$meses)); ?></h6></td>
        </tr>


                <tr role="row">
          <th width="30">Día</th>
                  <th class="sort cnone">Suscrito</th>
                  <th class="sort">Correo</th>
                  <th class="sort cnone">Teléfono</th>
                  <th class="sort">Curso</th>
                  <th class="sort">SESION</th>
                  <th class="sort">CLASE</th>
                  <th class="sort cnone">ESTADO</th>
                  <th class="unafbe">Opciones</th>
                </tr>
 <?php
} ?>
                <tr id="order_<?php echo $detalles["id_vid"]; ?>" style="<?php echo $style;?>">
        <td><?php echo !empty($detalles['fecha_registro']) ? date('d',strtotime($detalles['fecha_registro'])) : '...'; ?></td>
                  <td class="cnone" ><?php echo $detalles["suscrito"]; ?></td>
                  <td class="cnone"><?php echo $detalles["email"]; ?></td>
                  <td class="cnone"><?php echo $detalles["telefono"]; ?></td>
                  <td><?php echo $detalles["cod_curso"].' - '.$detalles["curso"]; ?></td>
                  <td><?php echo $detalles["sesion"]; ?></td>
                  <td><?php echo $detalles["detalle"]; ?></td>
                  <td class="cnone">
<a href="javascript: fn_estado('<?php echo $detalles["id_vid"]; ?>')" style="<?php echo $color;?>"><?php echo $detalles["estado"]; ?></a>
									</td>
                  <td>
                    <div class="btn-eai btr">
                      <a href="javascript: fn_eliminar('<?php echo $detalles["id_vid"]; ?>')" title="Eliminar Vista"><i class="fa fa-trash-o"></i></a>
                    </div>
                  </td>
                </tr>
<?php endwhile; ?>
              </tbody>
            </table>
            <div class="pagination"><?php echo $paging->fetchNavegacion(); ?></div>
<script>
$(function(){
  // reordenar('vistas_videos.php');
  // checked();
  // sorter();
});
</script>

<?php }else{ ?>
        <div class="box-body">
          <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
            <form action="javascript: fn_buscar();" id="frm_buscar" name="frm_buscar">
							<div class="bg-gray-light">
                <div class="col-sm-5">
                  <div class="btn-eai">
										<p>Vistas de videos</p>
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
var link = "vistas_video";
var us = "vistas_video";
var l = "o";
var l2 = "3";
var pr = "El";
var ar = "el";
var id = "ide";
var mypage = "vistas_videos.php";
</script>
<?php } ?>