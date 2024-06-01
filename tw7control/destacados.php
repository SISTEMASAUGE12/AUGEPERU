<?php error_reporting(E_ALL ^ E_NOTICE);
include ("auten.php");

if($_GET["task"]=='neworden'){
  $bd=new BD;
  $orden_actual=$_GET["orden_destacado"];
  $orden_nuevo=$_GET["nuevoorden"];
  $tipo=$_GET["tipo"];  
  $id_del_registro_actual=$_GET["id_curso"];
  $criterio_Orden =" ";
  nuevoorden($orden_actual, $orden_nuevo, $tipo, $id_del_registro_actual, "cursos", "id_curso", $criterio_Orden);    
  $bd->close();



}elseif($_GET["task"]=='reordenar_destacado'){

  $bd = new BD;
  $_GET['order'] = array_reverse($_GET['order']);
	
  foreach ($_GET['order'] as $order => $item) {
    $orden = $orden + 1;
		// echo "UPDATE cursos SET orden_destacado= ".$orden." WHERE id_curso = ".$item."";
		// exit();
		
    $bd->actualiza_("UPDATE cursos SET orden_destacado= ".$orden." WHERE id_curso = ".$item."");
  }
  $bd->Commit();
  $bd->close();

}elseif($_GET["task"]=='uestado'){

  $bd = new BD;
  $bd->Begin();

  $ide = !isset($_GET['id_curso']) ? $_GET['estado_idestado'] : $_GET['id_curso'];
  $ide = is_array($ide) ? implode(',',$ide) : $ide;
  $cursos = executesql("SELECT * FROM cursos WHERE id_curso IN (".$ide.")");

  if(!empty($cursos))
    foreach($cursos as $reg => $item)
      if ($item['estado_idestado']==1) {
        $state = 2;
      }elseif ($item['estado_idestado']==2) {
        $state = 1;
      }
  $bd->actualiza_("UPDATE cursos SET estado_idestado=".$state." WHERE id_curso=".$ide."");
  echo $state;
  $bd->Commit();
  $bd->close();
	

}elseif($_GET["task"]=='finder'){
	$array= array();
	$meses=array('Jan'=>'Enero','Feb'=>'Febrero','Mar'=>'Marzo','Apr'=>'Abril','May'=>'Mayo','Jun'=>'Junio','Jul'=>'Julio','Aug'=>'Agosto','Sep'=>'Septiembre','Oct'=>'Octubre','Nov'=>'Noviembre','Dec'=>'Diciembre');
	
  $sql = "SELECT  csc.id_cat,csc.id_sub, c.*, e.nombre as estado 
		FROM cursos c  
	 INNER JOIN categoria_subcate_cursos csc ON csc.id_curso=c.id_curso 
	 INNER JOIN categorias ctg ON ctg.id_cat=csc.id_cat  
	 INNER JOIN subcategorias sub ON csc.id_sub=sub.id_sub  
	 INNER JOIN estado e ON c.estado_idestado=e.idestado  
	 WHERE  c.tipo=1 and c.id_tipo='".$_GET["id_tipo"]."'     
	 "; 
  if(isset($_GET['criterio_mostrar'])) $porPagina=$_GET['criterio_mostrar'];
	
  if(isset($_GET['criterio_usu_per']) && !empty($_GET['criterio_usu_per'])){
    $stringlike=fn_filtro(substr($_GET['criterio_usu_per'], 0, 16));
    $sql.= " and  ( c.titulo LIKE '%".$stringlike."%' or  c.codigo LIKE '%".$stringlike."%' )  ";
  }else{
		// if( empty($_GET['fechabus_1']) && empty($_GET['fechabus_2']) ) {
			// $sql .= " AND DATE(c.fecha_registro) = '" . fecha_hora(1) . "'";
		// }	
	}
	
	if(!empty($_GET['id_cat'])) {
		$sql .= " AND csc.id_cat = '".$_GET['id_cat']."'";
	}
	
	// if(!empty($_GET['id_sub'])) {
		// $sql .= " AND csc.id_sub = '".$_GET['id_sub']."'";
	// }
	
	if(!empty($_GET['id_especialidad'])) {
		$sql .= " AND c.id_especialidad = '".$_GET['id_especialidad']."'";
	}
	
	if(!empty($_GET['visibilidad'])) {
		$sql .= " AND c.visibilidad = '".$_GET['visibilidad']."' ";
	}
	
	if(!empty($_GET['id_tipo_curso'])) {
		$sql .= " AND c.id_tipo_curso = '".$_GET['id_tipo_curso']."' ";
	}
	
	if(!empty($_GET['fechabus_1']) && !empty($_GET['fechabus_2'])) {
			$sql .= " AND DATE(c.fecha_registro)  BETWEEN  DATE('".$_GET['fechabus_1']."')  and DATE('".$_GET['fechabus_2']."')  ";		
	}
	
	
  if(isset($_GET['criterio_ordenar_por'])) $sql.= sprintf(" order by %s %s", fn_filtro($_GET['criterio_ordenar_por']), fn_filtro($_GET['criterio_orden']));
  // $sql.= " Group BY c.id_curso ORDER BY c.orden_destacado DESC  ";
  $sql.= " ORDER BY c.orden_destacado DESC  ";
	
	
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
  // $paging->porPagina(fn_filtro((int)10));
	
	if(empty($_GET['fechabus_1']) && empty($_GET['fechabus_2']) && empty($_GET['criterio_usu_per']) && empty($_GET['id_cat']) && empty($_GET['visibilidad']) && empty($_GET['id_tipo_curso']) && empty($_GET['id_especialidad']) ){
		// cargar por defecto los ultimos 10 cursos registrados ..
		// $sql.= " LIMIT 0,10   ";
		$paging->porPagina(100);		
	}else{
		$paging->porPagina(200);		
	}
  $paging->ejecutar();
  $paging->pagina_proceso="destacados.php";
?>
            <table id="example1" class="table table-bordered table-striped">
              <tbody id="sort">
<?php 
		while ($detalles = $paging->fetchResultado()): 
			if(!in_array(array('mes' => $detalles['mes'], 'anho' => $detalles['anho']), $array)){
				$array[] = array('mes' => $detalles['mes'], 'anho' => $detalles['anho']);
?>
				<tr class="lleva-mes">
				</tr>							
							
                <tr role="row">
                  <th class="sort"  width="70">COD </th>
                  <th class="sort"  width="120">ORDEN  DESTACA</th>
                  <th class="sort">TÍTULO </th>
                  <th class="sort cnone" width="80">MODALIDAD</th>
                  <th class="sort cnone" width="60">VISIBLE</th>
                  <th class="sort cnone" width="60">PRECIO</th>
                  <th class="sort cnone" width="160">ACTUALIZADO EL</th>
                  <th class="sort cnone" width="30">ESTADO</th>
  
                </tr>
<?php }//if meses ?>

								<tr id="order_<?php echo $detalles["id_curso"]; ?>">							
									<td><?php echo $detalles["codigo"]; ?></td>    
									<td><?php echo $detalles["orden_destacado"]; ?></td>    
                  <td><?php echo $detalles["titulo"]; ?></td>                                
                  <td class="cnone"><?php echo ($detalles['modalidad']==1)?'GRABADO':'EN VIVO'; ?></td>
                  <td class="cnone text-center"><?php echo ($detalles['visibilidad']==1)?'SI':'OCULTO'; ?></td>
                  <td><?php echo $detalles["precio"]; ?></td>                                
                  <td class="cnone"><?php echo fecha($detalles['fecha_actualizacion']); ?></td>
                  <td class="cnone"><a href="javascript: fn_estado('<?php echo $detalles["id_curso"]; ?>')"><?php echo $detalles["estado"]; ?></a></td>

                </tr>
		
<?php endwhile; ?>
              </tbody>
            </table>
            <div class="pagination"><?php echo $paging->fetchNavegacion(); ?></div>
<script>
$(function(){
  checked();
  sorter();
  reordenar_destacado('destacados.php');
});
var mypage = "destacados.php";
</script>

<?php }else{ ?>
        <div class="box-body">
          <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
            <form action="javascript: fn_buscar();" id="frm_buscar" name="frm_buscar">
							<input type="hidden" name="tipo" value="1">
							<input type="hidden" name="id_tipo" value="<?php echo $_GET["id_tipo"];?>">
							<input type="hidden" name="module" value="<?php echo $_GET["module"];?>">
							<input type="hidden" name="parenttab" value="<?php echo $_GET["parenttab"];?>">
              <div class="bg-gray-light">
									<div class="col-md-12 criterio_mostrar" style="margin-bottom:10px;">
								
									<div class="col-sm-8 criterio_buscar">
											<?php crearselect("id_cat", "select id_cat, titulo from categorias where id_tipo='".$_GET["id_tipo"]."' order by titulo asc", 'class="form-control"  style="border:1px solid #CA3A2B;" onchange="javascript:display(\'destacados.php\',this.value,\'cargar_subcategorias\',\'id_sub\')"', '', " Todas las  categorias "); ?>
										<div class="break" style="padding:6px 0;"></div>

										<label class="col-sm-1  text-right" style="padding-top: 8px;">Buscar: </label>
										<div class="col-sm-6 criterio_buscar">
											<?php create_input('text','criterio_usu_per','',"form-control pull-right",$table,'   '); ?>
										</div>
									</div>
								
								
									
							<!-- 
									<div class="col-sm-2 criterio_buscar">
											<select name="id_sub" id="id_sub" class="form-control" ><option value="" selected="selected">-- subcateg. --</option></select>
									</div>
								-->
									
									<?php /*
									<div class="col-sm-2 criterio_buscar">
											<?php crearselect("id_especialidad", "select id_especialidad, titulo from especialidades Order by titulo asc", 'class="form-control"  ', '', "-- especialidad --"); ?>
									</div>
									
									
									<div class="col-md-6 criterio_mostrar" style="margin-bottom:10px;">
										<div class="lleva_flechas" style="position:relative;">
											<label>Desde:</label>
											<?php create_input('date', 'fechabus_1', '', "form-control pull-right", $table, ''); ?>
										</div>
										<div class="lleva_flechas" style="position:relative;">
											<label>Hasta:</label>
											<?php create_input('date', 'fechabus_2', '', "form-control pull-right", $table, ''); ?>
										</div>
											<button>Buscar</button>
									</div>  
								</div>
			
                
                <div class="col-sm-2 criterio_buscar">
                </div>
                <div class="col-sm-4 criterio_buscar">
                  <?php create_input('text','criterio_usu_per','',"form-control pull-right",$table,'placeholder="Buscar .."'); ?>
                </div>
					
								<div class="col-md-2 criterio_mostrar" style="margin-bottom:10px;">
									<select id="visibilidad" name="visibilidad" class="form-control" requerid >  <!-- saco valor desde la BD -->
											<option value="" >-- visibilidad --</option>  
											<option value="1" >SI</option>  
											<option value="2" >OCULTO</option>
										</select>
								</div> 
								<div class="col-md-2 criterio_mostrar" style="margin-bottom:10px;">
									<select id="id_tipo_curso" name="id_tipo_curso" class="form-control" requerid >  <!-- saco valor desde la BD -->
											<option value="" >-- tipo --</option>  
											<option value="1" >GENERAL</option>  
											<option value="2" >ESPECIALIDADES</option>
										</select>
								</div>  
							*/ ?>
								
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
var link = "curso";
var us = "curso";
var ar = "la";
var l = "a";
var l2 = "a";
var pr = "La";
var id = "id_curso";
var mypage = "destacados.php";
</script>

<?php } ?>