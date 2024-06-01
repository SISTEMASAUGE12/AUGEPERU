<?php error_reporting(E_ALL ^ E_NOTICE);
include ("auten.php");

if($_GET["task"]=='uestado'){

  $bd = new BD;
  $bd->Begin();
  $ide = !isset($_GET['ide']) ? $_GET['estado_idestado'] : $_GET['ide'];
  $ide = is_array($ide) ? implode(',',$ide) : $ide;
  $examenes = executesql("SELECT * FROM examenes_curso WHERE ide IN (".$ide.")");
  if(!empty($examenes))
    foreach($examenes as $reg => $item)
      if ($item['estado_idestado']==1) {
        $state = 2;
      }elseif ($item['estado_idestado']==2) {
        $state = 1;
      }
  $bd->actualiza_("UPDATE examenes_curso SET estado_idestado=".$state." WHERE ide=".$ide."");
  echo $state;
  $bd->Commit();
  $bd->close();

}elseif($_GET["task"]=='finder'){
	$array= array();
	$meses=array('Jan'=>'Enero','Feb'=>'Febrero','Mar'=>'Marzo','Apr'=>'Abril','May'=>'Mayo','Jun'=>'Junio','Jul'=>'Julio','Aug'=>'Agosto','Sep'=>'Septiembre','Oct'=>'Octubre','Nov'=>'Noviembre','Dec'=>'Diciembre');


  $sql = "SELECT  ex.*, ec.ide, YEAR(ec.fecha_registro) as anho, MONTH(ec.fecha_registro) as mes, e.nombre as estado, u.nomusuario as usuario 
				FROM examenes_curso ec 
							LEFT join usuario u ON u.idusuario=ec.idusuario
						INNER JOIN examenes ex ON ec.id_examen = ex.id_examen 
						INNER JOIN estado e ON ec.estado_idestado=e.idestado  
						WHERE ec.id_curso = ".$_GET['id_curso']." "; 
	
	
  if(isset($_GET['criterio_mostrar'])) $porPagina=$_GET['criterio_mostrar'];
  if(!empty($_GET['criterio_usu_per']) || !empty($_GET['id_cate'])){
    $stringlike=fn_filtro(substr($_GET['criterio_usu_per'], 0, 16));
    $sql.= " and  ( ex.id_examen LIKE '%".$stringlike."%'  or ex.titulo LIKE '%".$stringlike."%'  )  ";
	}

  if(isset($_GET['criterio_ordenar_por'])) $sql.= sprintf(" order by %s %s", fn_filtro($_GET['criterio_ordenar_por']), fn_filtro($_GET['criterio_orden']));
  $sql.= "  ORDER BY ec.ide DESC   ";
	
	// echo $sql; 
 
  $paging = new PHPPaging;
  $paging->agregarConsulta($sql); 
  $paging->div('div_listar');
  $paging->modo('desarrollo'); 
  $numregistro=1; 
  if($numregistro) $paging->porPagina(fn_filtro((int)$numregistro));
  $paging->verPost(true);
  $mantenerVar=array("criterio_mostrar","task","criterio_usu_per","criterio_ordenar_por","criterio_orden");

  $paging->mantenerVar($mantenerVar);
  // $paging->porPagina(fn_filtro((int)$porPagina));
  $paging->porPagina(1000);
  $paging->ejecutar();
  $paging->pagina_proceso="examene3s.php";
?>
            <table id="example1" class="table table-bordered table-striped">
              			<tbody id="sort">
                <tr role="row"> 
          <th class="unafbe" width="20"><input type="checkbox" id="chkDel" class="all"></th>  
                  <th class="sort">Cod. </th>
                  <th class="sort">EXAMEN </th>
                  <th class="sort">ESTADO </th> 
                  <th class="sort">USUARIO </th> 
                </tr>

<?php 
		while ($detalles = $paging->fetchResultado()): 
?>
								<tr>
                  <td><input type="checkbox" name="chkDel[]" class="chkDel" value="<?php echo $detalles["ide"]; ?>"  <?php echo $checked; ?> ></td>
                  <td><?php echo $detalles["id_examen"]; ?></td>
                  <td><?php echo $detalles["titulo"]; ?></td>
                  <td class="cnone"><a href="javascript: fn_estado('<?php echo $detalles["ide"]; ?>')"><?php echo $detalles["estado"]; ?></a></td>
                  <td><?php echo $detalles["usuario"]; ?></td>
                </tr>
<?php endwhile; ?>
              </tbody>
            </table>
            <div class="pagination"><?php echo $paging->fetchNavegacion(); ?></div>
<script>

$(function(){
  // checked();
  // sorter();
  // reordenar('examenes.php');
});
var mypage = "examene3s.php";
</script>

<?php 
}else{ ?>
        <div class="box-body">
          <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
            <form action="javascript: fn_buscar();" id="frm_buscar" name="frm_buscar">
              <input type="hidden" name="id_curso" value="<?php echo $_GET["id_curso"];?>">
							<input type="hidden" name="module" value="<?php echo $_GET["module"];?>">
							<input type="hidden" name="parenttab" value="<?php echo $_GET["parenttab"];?>">
              <div class="bg-gray-light">
								
                <div class="col-sm-3 criterio_buscar">
									<?php $cursi=executesql("select * from cursos where id_curso='".$_GET["id_curso"]."' ",0); ?>
									<p><b>Listado de examenes asignados </b></br>Curso: <b><?php echo $cursi["titulo"]; ?> </b></p>
								</div>
								
                <div class="col-sm-3 criterio_buscar">
                  <?php create_input('text','criterio_usu_per','',"form-control pull-right",$table,'placeholder="Buscar .."'); ?>
                </div>
							  <div class="col-sm-4 criterio_mostrar">
									<div class="lleva_flechas" style="position:relative;">
										<?php create_input('hidden', 'fechabus_1', '', "form-control pull-right", $table, ''); ?>
									</div>
									<div class="lleva_flechas" style="position:relative;">
										<!--<label>Hasta:</label>-->
										<?php create_input('hidden', 'fechabus_2', '', "form-control pull-right", $table, ''); ?>
									</div>
                    <button>Buscar</button>
                </div>
                <div class="col-sm-2 criterio_mostrar">
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
var link = "examene3";
var us = "examen";
var ar = "la";
var l = "a";
var l2 = "a";
var pr = "La";
var id = "id_examen";
var mypage = "examene3s.php";
</script>

<?php } ?>