<?php error_reporting(E_ALL ^ E_NOTICE);
include ("auten.php");

if($_GET["task"]=='uestado'){
  $bd = new BD;
  $bd->Begin();
  $ide = !isset($_GET['id']) ? $_GET['estado_idestado'] : $_GET['id'];
  $ide = is_array($ide) ? implode(',',$ide) : $ide;
  $webinars_x_leads = executesql("SELECT * FROM webinars_x_leads WHERE ide IN (".$ide.")");
  if(!empty($webinars_x_leads))
    foreach($webinars_x_leads as $reg => $item)
      if ($item['estado_idestado']==1) {
        $state = 2;
      }elseif ($item['estado_idestado']==2) {
        $state = 1;
      }
  $bd->actualiza_("UPDATE webinars_x_leads SET estado_idestado=".$state." WHERE ide=".$ide."");
  echo $state;
  $bd->Commit();
  $bd->close();
	

	
}elseif($_GET["task"]=='finder'){ 
	
	$array= array();
	$meses=array('Jan'=>'Enero','Feb'=>'Febrero','Mar'=>'Marzo','Apr'=>'Abril','May'=>'Mayo','Jun'=>'Junio','Jul'=>'Julio','Aug'=>'Agosto','Sep'=>'Septiembre','Oct'=>'Octubre','Nov'=>'Noviembre','Dec'=>'Diciembre');
	
	$sql = "SELECT  cv.*, YEAR(cv.fecha_registro) as anho, MONTH(cv.fecha_registro) as mes, e.nombre AS estado , s.nombre as cliente, s.telefono as tel_cli 
	FROM webinars_x_leads cv INNER JOIN estado e ON cv.estado_idestado=e.idestado 
	LEFT JOIN suscritos s ON  cv.id_suscrito=s.id_suscrito  
	WHERE cv.id_webinar =".$_GET['id_webinar'];
				
  if(!empty($_GET['criterio_mostrar'])) $porPagina=$_GET['criterio_mostrar'];
  if(!empty($_GET['criterio_usu_per'])){
    $stringlike=fn_filtro(substr($_GET['criterio_usu_per'], 0, 16));
    $sql.= " AND (cv.nombre_completo LIKE '%".$stringlike."%' or cv.email LIKE '%".$stringlike."%' or cv.telefono LIKE '%".$stringlike."%')";
  }

  if(!empty($_GET['fechabus_1']) && !empty($_GET['fechabus_2'])) {
    $sql .= " AND DATE(cv.fecha_registro)  BETWEEN  DATE('".$_GET['fechabus_1']."')  and DATE('".$_GET['fechabus_2']."')  ";		
  }

  
  if(!empty($_GET['criterio_ordenar_por'])) $sql.= sprintf(" order by %s %s", fn_filtro($_GET['criterio_ordenar_por']), fn_filtro($_GET['criterio_orden']));
  $sql.= " ORDER BY cv.fecha_registro desc ";
	
	// echo $sql;
	
  $paging = new PHPPaging;
  $paging->agregarConsulta($sql); 
  $paging->div('div_listar');
  $paging->modo('desarrollo'); 
  $numregistro=1; 
  if($numregistro) $paging->porPagina(fn_filtro((int)$numregistro));
  $paging->verPost(true);
  $mantenerVar=array("id_webinar","criterio_mostrar","task","criterio_usu_per","criterio_ordenar_por","criterio_orden");
  $paging->mantenerVar($mantenerVar);
  $paging->porPagina(fn_filtro((int)$porPagina));
  $paging->ejecutar();
  $paging->pagina_proceso="webinars_x_leads.php";

?>
<table id="example1" class="table table-bordered table-striped">		

    <!-- *EXCEL -->
		<?php  /*  Fechas para excel */ 
			$fecha_excel_inicio= !empty($_GET["fechabus_1"])?$_GET["fechabus_1"]:fecha_hora(1); 
		?>
		<input type="hidden" name="sql_excel" id="sql_excel" value="<?php echo $sql; ?>">
		<a href="javascript:fn_exportar('tipo_form=1&fecha_filtro_inicio=<?php echo $fecha_excel_inicio;?>&fecha_filtro_fin=<?php echo $_GET["fechabus_2"];?>','webinars_x_leads');" class="btn btn-primary  excel "  > Excel todo. </a>
		

    <?php  /*  Fechas para excel sql_2_alterno */ 
			$sql_2_alterno= "select s.idusuario, s.id_especialidad, s.fecha_atendido, wxl.*, w.titulo as webinar, w.titulo_rewrite as webinar_rew FROM webinars_x_leads wxl 
      LEFT JOIN webinars w ON wxl.id_webinar=w.id_webinar  
      LEFT JOIN suscritos s ON wxl.email= s.email   
      where wxl.id_webinar=".$_GET['id_webinar']." and wxl.id_suscrito=0 and (s.idusuario ='' or s.idusuario is NULL)  order by wxl.orden desc "; 
		?>
		<input type="hidden" name="sql_2_alterno" id="sql_2_alterno" value="<?php echo $sql_2_alterno; ?>">
		<a href="javascript:fn_exportar('tipo_form=1&fecha_filtro_inicio=<?php echo $fecha_excel_inicio;?>&fecha_filtro_fin=<?php echo $_GET["fechabus_2"];?>','webinars_x_leads_nuevos_clientes');" class="btn btn-primary  excel "  > Excel solo nuevos. </a>
            

    <?php  /*  Fechas para excel sql_3_alterno */ 
			$sql_3_alterno= "select s.idusuario, s.id_especialidad, s.fecha_atendido, wxl.*, w.titulo as webinar, w.titulo_rewrite as webinar_rew , s.idusuario 
      FROM webinars_x_leads wxl 
      LEFT JOIN webinars w ON wxl.id_webinar=w.id_webinar  
      LEFT JOIN suscritos s ON wxl.id_suscrito= s.id_suscrito   
      where wxl.id_webinar=".$_GET['id_webinar']." and (s.id_especialidad='' or s.id_especialidad is NULL) and wxl.id_suscrito !=0  order by wxl.orden desc ";      
		?>
		<input type="hidden" name="sql_3_alterno" id="sql_3_alterno" value="<?php echo $sql_3_alterno; ?>">
		<a href="javascript:fn_exportar('tipo_form=1&fecha_filtro_inicio=<?php echo $fecha_excel_inicio;?>&fecha_filtro_fin=<?php echo $_GET["fechabus_2"];?>','webinars_x_leads_clientes_completar_info');" class="btn btn-primary  excel "  > Excel completar info. </a>
            


		<tbody id="sort">
<?php 
 $sql_count="select count(*) as total_asistentes from webinars_x_leads  WHERE id_webinar ='".$_GET['id_webinar']."' ";
$total_=executesql($sql_count);
echo '<p><b>Total registrados al webinar : '.$total_[0]['total_asistentes'].' </b></br></p> ';

while ($detalles = $paging->fetchResultado()): 
	
	if(!in_array(array('mes' => $detalles['mes'], 'anho' => $detalles['anho']), $array)){
		$array[] = array('mes' => $detalles['mes'], 'anho' => $detalles['anho']);
?>
				<tr class="lleva-mes">
					<td colspan="9"><h6><?php echo strtoupper(strtr(date('M Y',strtotime($detalles['fecha_registro'])),$meses)); ?></h6></td>
				</tr>
				<tr role="row">
					<th class="sort">DÍA </th>  
					<th class="sort">NOMBRE</th>
					<th class="sort">E-MAIL</th>
					<th class="sort">CEL</th>
					<th class="sort cnone">ESTADO</th>
					<th class="unafbe btn_varios">Opciones</th>
				</tr>
	<?php }//if meses ?> 						
							
				<tr>
					<td><?php echo !empty($detalles['fecha_registro']) ? date('d',strtotime($detalles['fecha_registro'])) : '...'; ?></td>
					<td><?php echo $detalles["nombre_completo"]; ?></td>
					<td><?php echo $detalles["email"]; ?></td>
					<td><?php echo $detalles["telefono"]; ?></td>
					<td class="cnone"><a href="javascript: fn_estado('<?php echo $detalles["ide"]; ?>')"><?php echo $detalles["estado"]; ?></a></td>
					<td>
						<div class="btn-eai btns btr btn_varios text-center ">
							<a href="javascript: fn_estado_eliminar_ocultar('<?php echo $detalles["ide"]; ?>')"><i class="fa fa-trash-o "></i> </a>
						</div>
					</td>
				</tr>
<?php endwhile; ?>
		</tbody>
</table>
<div class="pagination"><?php echo $paging->fetchNavegacion(); ?></div>

<?php }else{ ?>
<div class="box-body">
  <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
    <form action="javascript: fn_buscar();" id="frm_buscar" name="frm_buscar">
      <input type="hidden" name="id_webinar" value="<?php echo $_GET['id_webinar']; ?>">
      <input type="hidden" name="module" value="<?php echo $_GET['module']; ?>">
      <input type="hidden" name="parenttab" value="<?php echo $_GET['parenttab']; ?>">
      <div class="bg-gray-light">      
        <div class="col-sm-12">
          <?php   
						$sql_x=" select * from webinars where id_webinar='".$_GET["id_webinar"]."' "; 
						$datoscurso=executesql($sql_x,0);
						// $volver_al_curso="index.php?page=cursos&module=".$_GET["module"]."&parenttab=".$_GET["parenttab"]."";
						
						echo "<h3 style='margin-top:0;padding-top:0;padding-bottom:10px;' ><small> <b style='color:#555;'>Webinar</b> : ".$datoscurso["titulo"]." </small></h3>";
					?>
        </div>
								
        <div class="col-sm-3 ">          
          <?php create_input('text','criterio_usu_per','',"form-control pull-right",$table,'placeholder="Buscar .."'); ?>
        </div>
        <div class="col-sm-7 criterio_mostrar">
							*Filtar por fecha de pago 
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

      
        <div class="col-sm-2 ">          
          <?php select_sql("nregistros"); ?>
        </div>
        <div class="col-sm-2">          
					<a href="javascript:history.go(-1)" class="pull-right">&laquo; RETORNAR</a>
        </div>
        <div class="break"></div>
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
var us = "Lead";
var link = "webinars_x_lead";
var ar = "la";
var l = "a";
var l2 = "a";
var pr = "La";
var id = "ide";
var mypage = "webinars_x_leads.php";
</script>
<?php } ?>