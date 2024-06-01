<?php error_reporting(E_ALL ^ E_NOTICE);
include ("auten.php");

if($_GET["task"]=='agregando_examen'){  
  $bd = new BD;
  $bd->Begin();
  $ide =  implode(',', $_GET['chkDel']);
  $ide2 = explode(',',$ide);
  $longitud = count($ide2);
  for($i=0; $i<$longitud; $i++){
      //saco el valor de cada elemento
		$_POST['idusuario']=$_SESSION["visualiza"]["idusuario"];

    $_POST['id_curso'] = $_GET['id_curso'];
    $_POST['id_examen'] = $ide2[$i];
    $_POST['fecha_registro'] = fecha_hora(2);
    $_POST['estado_idestado'] = 1;
		
    $campos=array('id_curso','idusuario','id_examen','fecha_registro','estado_idestado'); 
    $hola=$bd->inserta_(arma_insert('examenes_curso',$campos,'POST'));/*actualizo*/
  }
    
  echo arma_insert('examenes_curso',$campos,'POST');
  $bd->Commit();
  $bd->close();

}elseif($_GET["task"]=='finder'){
	$array= array();
	$meses=array('Jan'=>'Enero','Feb'=>'Febrero','Mar'=>'Marzo','Apr'=>'Abril','May'=>'Mayo','Jun'=>'Junio','Jul'=>'Julio','Aug'=>'Agosto','Sep'=>'Septiembre','Oct'=>'Octubre','Nov'=>'Noviembre','Dec'=>'Diciembre');
// primero averiguar si el curso
  $sql2 = "SELECT  c.titulo FROM examenes_curso ec INNER JOIN examenes c ON ec.id_examen = c.id_examen "; 
  $sql2.= " and c.titulo = '".$_GET['criterio_usu_per']."' ";
  $examen = executesql($sql2);
  if(!empty($_GET['criterio_usu_per']) && !empty($examen)){
    echo 'Examen ya registrado en este curso';
  }else{

	$cursos = executesql("SELECT id_examen FROM examenes_curso WHERE id_curso = ".$_GET['id_curso']."");
  if(!empty($cursos)){ 
    foreach($cursos as $recor){
      $lear.= $recor['id_examen'].',';
    }
    $lear = substr($lear, 0, -1);
    $lear = "WHERE c.id_examen NOT IN (".$lear.") ";
  }else{
    $lear = ' ';
  }

  $sql = "SELECT  c.*, YEAR(c.fecha_registro) as anho, MONTH(c.fecha_registro) as mes, e.nombre as estado, ce.titulo as categoria FROM examenes c  INNER JOIN estado e ON c.estado_idestado=e.idestado INNER JOIN categoria_examenes ce ON ce.id_cate = c.id_cate ".$lear; 
  if(isset($_GET['criterio_mostrar'])) $porPagina=$_GET['criterio_mostrar'];
  if(!empty($_GET['criterio_usu_per']) || !empty($_GET['id_cate'])){
    $stringlike=fn_filtro(substr($_GET['criterio_usu_per'], 0, 16));
    $sql.= " and  ( c.titulo LIKE '%".$stringlike."%'  )  ";

    if(!empty($_GET['id_cate'])){
      $sql.=" AND c.id_cate = '".$_GET['id_cate']."' ";
    }
  
  if(!empty($_GET['fechabus_1']) && !empty($_GET['fechabus_2'])) {
      $sql .= " AND DATE(c.fecha_registro)  BETWEEN  DATE('".$_GET['fechabus_1']."')  and DATE('".$_GET['fechabus_2']."')  ";   
  }

  }else{
		if(empty($_GET['fechabus_1']) && empty($_GET['fechabus_2'])){
			$sql .= " AND DATE(c.fecha_registro) > '" . fecha_hora(1) . "'";
		}
	}


	
  if(isset($_GET['criterio_ordenar_por'])) $sql.= sprintf(" order by %s %s", fn_filtro($_GET['criterio_ordenar_por']), fn_filtro($_GET['criterio_orden']));
  $sql.= "  ORDER BY c.orden DESC   ";
	
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
  $paging->pagina_proceso="examene2s.php";
?>
            <table id="example1" class="table table-bordered table-striped">
              			<tbody id="sort">
                <tr role="row"> 
          <th class="unafbe" width="20"><input type="checkbox" id="chkDel" class="all"></th>  
                  <th class="sort">EXAMEN </th>
                  <th class="sort">TOTAL PREGUNTAS </th> 
                  <th class="sort">ESTADO </th> 
                </tr>

<?php 
		while ($detalles = $paging->fetchResultado()): 
?>
								<tr>
                  <td><input type="checkbox" name="chkDel[]" class="chkDel" value="<?php echo $detalles["id_examen"]; ?>"  <?php echo $checked; ?> ></td>
                  <td><?php echo $detalles["titulo"]; ?></td>
                  <td><?php echo $detalles["total_preguntas"]; ?></td>                                 
                  <td><?php echo ($detalles["estado_examen"]==1)?'ABIERTO':'CERRADO'; ?></td>
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
var mypage = "examene2s.php";
</script>

<?php 
}

}else{ ?>
        <div class="box-body">
          <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
            <form action="javascript: fn_buscar();" id="frm_buscar" name="frm_buscar">
              <input type="hidden" name="id_curso" value="<?php echo $_GET["id_curso"];?>">
							<input type="hidden" name="module" value="<?php echo $_GET["module"];?>">
							<input type="hidden" name="parenttab" value="<?php echo $_GET["parenttab"];?>">
              <div class="bg-gray-light">
                <div class="col-md-2">
                    <div class="btn-eai">
                      <a href="javascript:fn_add_examen_a_curso(<?php echo $_GET["id_curso"];?>);" style="color:#fff;"><i class="fa fa-file"></i> Asignar </a>    
                    </div>
                </div>
							
                <div class="col-sm-3 criterio_buscar">
                  <?php create_input('text','criterio_usu_per','',"form-control pull-right",$table,'placeholder="Buscar .."'); ?>
                </div>
							  <div class="col-sm-4 criterio_mostrar">
									<div class="lleva_flechas" style="position:relative;">
                    <?php crearselect("id_cate","select * from categoria_examenes where estado_idestado = 1 order by id_cate desc",'class="form-control"','',"--Categotía--"); ?>
										<?php create_input('hidden', 'fechabus_1', '', "form-control pull-right", $table, ''); ?>
									</div>
									<div class="lleva_flechas" style="position:relative;">
										<!--<label>Hasta:</label>-->
										<?php create_input('hidden', 'fechabus_2', '', "form-control pull-right", $table, ''); ?>
									</div>
                </div>
                <div class="col-sm-2 criterio_mostrar">
										<button>Buscar</button>
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
var link = "examene2";
var us = "examen";
var ar = "la";
var l = "a";
var l2 = "a";
var pr = "La";
var id = "id_examen";
var mypage = "examene2s.php";
</script>

<?php } ?>