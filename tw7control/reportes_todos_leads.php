<?php error_reporting(E_ALL ^ E_NOTICE);
include_once("auten.php");

if($_POST["task"]=='atender_cliente_insertar_kardex' ){
	include("inc/proceso_guardar_seguimiento_flotante.php");
	
	
		$validate=executesql("select * from suscritos_leads where id_suscrito='".$_POST["id_suscrito"]."' ",0);
		if( !empty($validate) ){  /* si este vendedor es dueño de este cliente */
				
			if( $validate['idusuario'] == $_SESSION["visualiza"]["idusuario"] ){ /* si es suyo */
				
				$rpta=$bd->inserta_(arma_insert('kardex_clientes',$campos,'POST'));
				// $bd->close();
				// gotoUrl("index.php?page=suscriptores&module=ver/registrar&parenttab=Mis%20Clientes");	
				
			}else if( empty($validate['idusuario'] ) ){ /* si clinte no tien vendedor asignado, le asignamos */
			
				// echo var_dump(arma_insert('kardex_clientes',$campos,'POST'));
				// exit();
				
				$rpta=$bd->inserta_(arma_insert('kardex_clientes',$campos,'POST'));
				/* actualizo tabla cliente: le asigno vendedor a cliente */
				$campos_cliente=array('idusuario','fecha_atendido');
				$bd->actualiza_(armaupdate('suscritos',$campos_cliente," id_suscrito='".$_POST["id_suscrito"]."'",'POST')); 

				
				// $bd->close();
				// gotoUrl("index.php?page=suscriptores&module=ver/registrar&parenttab=Mis%20Clientes");	
				
			}else{  /* si ciente , tiene otro vendedor asignado */
				echo "<script>
									alert('Lo sentimos. Cliente, ya tiene un vendedor asignado. '; 				
									location.href='index.php?page=reportes_todos_leads&module=Buscar%20si%20existe%20Cliente&parenttab=Reportes' );
							</script>";
			}
			
		}		
	
	/* rpta ajax */
	$bd->close();

	if( $rpta > 0 && $_POST["id_suscrito"]>0 ){
		$rpta=1;
		$texto = '<label class="col-sm-12" style="margin-top:6px;font-size: 26px;font-weight: bold;margin-bottom: 25px;">Cliente y seguimiento asociado con éxito.</label>
              <div class="clearfix"></div>';
		$texto .= '<a class="btn btn-primary" href="index.php?page=suscriptores&module=ver/registrar&parenttab=Mis%20Clientes" target="_blank" style="margin-right:15px;">IR A MIS CLIENTES</a>';
		$texto .= '<a class="btn btn-danger" onclick="cerrar_flotante()">Cerrar</a> ';
	}

	echo json_encode(array(
		'res' => $rpta,
		'texto' => $texto
	));
	
	
	
}elseif($_GET["task"]=='finder'){
  $array= array();
	$meses=array('Jan'=>'Enero','Feb'=>'Febrero','Mar'=>'Marzo','Apr'=>'Abril','May'=>'Mayo','Jun'=>'Junio','Jul'=>'Julio','Aug'=>'Agosto','Sep'=>'Septiembre','Oct'=>'Octubre','Nov'=>'Noviembre','Dec'=>'Diciembre');

  $sql= "SELECT s.*, YEAR(s.fecha_registro) as anho, MONTH(s.fecha_registro) as mes, e.nombre AS estado, CONCAT(s.nombre,' ',s.ap_pa )as suscritos, ep.titulo as especialidad , u.nomusuario as usuariox 
	FROM suscritos_leads s 
  INNER JOIN estado e ON s.estado_idestado=e.idestado 
		LEFT JOIN usuario u ON s.idusuario=u.idusuario   
  LEFT JOIN especialidades ep ON s.id_especialidad=ep.id_especialidad 
	WHERE s.estado_idestado=e.idestado  
		";
  
  if (isset($_GET['criterio_mostrar'])) $porPagina=$_GET['criterio_mostrar'];
  if(isset($_GET['criterio_usu_per']) && !empty($_GET['criterio_usu_per'])){
    $stringlike=fn_filtro(substr($_GET['criterio_usu_per'], 0, 16));
		
      // $pos = strpos($sql, 'WHERE');
      // $sql.= (($pos === false) ? "WHERE" : "AND" )." ( s.dni LIKE '".$stringlike."%' or s.nombre LIKE '".$stringlike."%' or s.telefono LIKE '%".$stringlike."%'  or s.email LIKE '%".$stringlike."%' )"; 
			
      $sql.= "  AND ( s.dni LIKE '".$stringlike."%' or s.nombre LIKE '".$stringlike."%' or s.telefono LIKE '%".$stringlike."%'  or s.email LIKE '%".$stringlike."%' )"; 
			
			
  // }else{
		// if( empty($_GET['fechabus_1']) && empty($_GET['fechabus_2']) ) {
			// $pos = strpos($sql, 'WHERE');
      // $sql.= (($pos === false) ? "WHERE" : "AND" )." DATE(s.fecha_registro) < '" . fecha_hora(1) . "'";
		// }
		
	}
	
	if(!empty($_GET['idusuario']) ) {
		$sql .= " AND s.idusuario='".$_GET['idusuario']."'  ";		
}

	if(!empty($_GET['registro_desde']) ) {
		if( $_GET['registro_desde'] =='199' ) {  // 199 es NULO:: venta manual
			$sql .= " AND s.registro_desde is NULL  ";	

		}else if( $_GET['registro_desde'] =='200' ) {  // ver que asigno algoritmo 
			$sql .= " AND s.registro_desde is not NULL  AND c.registro_desde != 1   AND c.registro_desde != 2  ";	

		}else{
			$sql .= " AND s.registro_desde='".$_GET['registro_desde']."'  ";	

		}	
	}


		if(!empty($_GET['fechabus_1']) && !empty($_GET['fechabus_2'])) {
			$pos = strpos($sql, 'WHERE');
      $sql.= (($pos === false) ? "WHERE" : "AND" )." DATE(s.fecha_registro)  BETWEEN  DATE('".$_GET['fechabus_1']."')  and DATE('".$_GET['fechabus_2']."')  ";		
	}

	
	if(isset($_SESSION['pagina2'])) {
			$_GET['pagina'] = $_SESSION['pagina2'];
	}
	
  if(isset($_GET['criterio_ordenar_por'])) $sql.= sprintf(" order by %s %s", fn_filtro($_GET['criterio_ordenar_por']), fn_filtro($_GET['criterio_orden']));
 
 $sql.= " 
  GROUP by s.id_suscrito   
 ORDER BY s.id_suscrito DESC";
 
  //	| echo $sql;
 
 
  $paging = new PHPPaging;
  $paging->agregarConsulta($sql); 
  $paging->div('div_listar');
  $paging->modo('desarrollo'); 
  $numregistro=1; 
  if($numregistro) $paging->porPagina(fn_filtro((int)$numregistro));
  $paging->verPost(true);
  $mantenerVar=array("criterio_mostrar","task","criterio_usu_per","criterio_ordenar_por","criterio_orden");
  $paging->mantenerVar($mantenerVar);
  $paging->porPagina(1000);
  $paging->ejecutar();
  $paging->pagina_proceso="reportes_todos_leads.php";
?>
  <table id="example1" class="table table-bordered table-striped">

<?php 

// if($_SESSION["visualiza"]["idtipo_usu"] ==1 && $_SESSION["visualiza"]["idusuario"] ==6 ){  ?> 
	
		<!-- *EXCEL -->
		<?php  /*  Fechas para excel */ 
			$fecha_excel_inicio= !empty($_GET["fechabus_1"])?$_GET["fechabus_1"]:fecha_hora(1); 
		?>
		<input type="hidden" name="sql_excel" id="sql_excel" value="<?php echo $sql; ?>">
		<a href="javascript:fn_exportar('tipo_form=1&fecha_filtro_inicio=<?php echo $fecha_excel_inicio;?>&fecha_filtro_fin=<?php echo $_GET["fechabus_2"];?>','todos_leads');" class="btn btn-primary"  > Excel [aplicando filtros]</a>
		
		<a href="../datausuario_leads.php" class="btn btn-primary"  style="margin-left:20px;"> Excel [descargar todo]</a>
		
		
<?php // } ?>
	
    <tbody id="sort">            
<?php 

// total resultados 
$total= executesql($sql);
echo '<h3 style="padding:5px 0 25px;"><b> Total de resultados:  '.count($total).' </b> </h3>'; 



		while ($detalles = $paging->fetchResultado()): 
			if(!in_array(array('mes' => $detalles['mes'], 'anho' => $detalles['anho']), $array)){
				$array[] = array('mes' => $detalles['mes'], 'anho' => $detalles['anho']);
?>
				<tr class="lleva-mes">
					<td colspan="9"><h6><?php echo strtoupper(strtr(date('M Y',strtotime($detalles['fecha_registro'])),$meses)); ?></h6></td>
				</tr>
				<tr role="row">
					<th width="30">Día</th>
          <th class="sort cnone">FECHA</th>
          <th class="sort cnone">DESDE</th>
          <th class="sort">USUARIO </th>
          <th class="sort">DNI</th>
          <th class="sort cnone" >Cliente</th>
          <th class="sort cnone" >Especialidad</th>
          <th class="sort cnone" >Condición</th>
          <th class="sort cnone">E-mail</th>
          <th class="sort ">Teléfono</th>
			<?php if( $_SESSION["visualiza"]["idtipo_usu"] ==4 ){ ?>
          <th class="sort " width="100">opciones</th>
			<?php } ?> 
         </tr>
<?php }//if meses 

if( $detalles["estado_pago"] == 2){ // por revisar 
	$fondo_entregar ="background:#F0A105; color:#fff !important; ";
}elseif( $detalles["estado_pago"] == 1){  // aprobado
	$fondo_entregar ='';
}elseif( $detalles["estado_pago"] == 3){ // rechazado 
	$fondo_entregar ='background:rgba(255,0,0,0.6); color:#fff !important;';
}
?>        
       <tr>
        <td><?php echo !empty($detalles['fecha_registro']) ? date('d',strtotime($detalles['fecha_registro'])) : '...'; ?></td>
        <td class="cnone"><?php echo $detalles['fecha_registro']; ?></td>
				<td><?php 
						if( $detalles["registro_desde"] =='1'){ 
							echo "Facebook";
						}else if( $detalles["registro_desde"] =='2'){
							echo "Google";
						}else if( $detalles["registro_desde"] =='3'){
							echo "Registro web";
						}else if( $detalles["registro_desde"] =='4'){
							echo "Banner web";
						}else if( $detalles["registro_desde"] =='5'){
							echo "Trafico-Webinar";
						}else if( $detalles["registro_desde"] == NULL){
							echo "venta_manual";
						}else{
							echo "-";
						}

					?></td>
        <td class=" "><?php echo $detalles["usuariox"]; ?></td>        
        <td class=" "><?php echo $detalles["dni"]; ?></td>        
        <td class="cnone"><?php echo $detalles["suscritos"]; ?></td>        
        <td class="cnone"><?php echo $detalles["especialidad"]; ?></td>
		<td><?php 
						if( $detalles["id_tipo_cliente"] == 1 ){ 
							echo "NOMBRADO";						
						}else if( $detalles["id_tipo_cliente"] == 2){
							echo "CONTRATADO";
						}else{
							echo "--";
						}

					?></td>
        <td class="cnone"><?php echo $detalles["email"] ?></td>        
        <td class=" "><?php echo $detalles["telefono"]; ?></td>
				<?php 
					if( $_SESSION["visualiza"]["idtipo_usu"] ==4 ){
									if( empty($detalles["idusuario"]) ){    /* sino tiene vendedor asignado -usuario */ ?>
						
					<td>
						<div class="btn-eai btr  text-center"  >
						<!-- 
								<a style="color:#fff;" href="index.php?page=kardex_clientes&id_suscrito=<?php echo $detalles['id_suscrito']; ?>&module=Alumnos&parenttab=AulaVirtual" title="atender"> atender</a>
								-->
								<?php 
										$nombre_completo=$detalles['dni'].' - '.$detalles['nombre'].' '.$detalles['ap_pa'].' '.$detalles['ap_ma']; ?>
							<button type="button" class="btn btn-primary llama" data-toggle="modal" data-target="#exampleModal"  data-id_suscrito="<?php echo $detalles['id_suscrito']; ?>" data-whatever="@mdo" data-titulo="<?php echo $nombre_completo; ?> ">atender</button>
						</div>
					</td>
						<?php 
									}
							}
						?>
				
      </tr>
<?php endwhile; ?>

		<script>
$('#exampleModal').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget); // Button that triggered the modal
  var id_suscrito = button.data('id_suscrito'); // Extract info from data-* attributes
  var titulo = button.data('titulo'); // Extract info from data-* attributes
  // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
  // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
  var modal = $(this);
	
	document.getElementById("id_cliente").value= id_suscrito;				
  modal.find('.modal-title').text('' + titulo);
  // modal.find('.modal-body input').val(id_suscrito);
	
})		
		</script>

    </tbody>
  </table>
  <div class="pagination"><?php echo $paging->fetchNavegacion(); ?></div>
<script>
$(function(){
  // reordenar('reportes_ventas_offlines.php');
  // checked();
  // sorter();
});
</script>

<?php }else{ ?>
        <div class="box-body">
          <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
            <form action="javascript: fn_buscar();" id="frm_buscar" name="frm_buscar">
              <div class="bg-gray-light">
								<?php create_input('hidden','tipo_pago',$_GET["tipo_pago"],"form-control pull-right",$table,$agregados); ?>
                <div class="col-sm-6 criterio_buscar" style="padding-bottom:22px;">
                  <?php create_input('text','criterio_usu_per','',"form-control pull-right",$table,' placeholder="Buscar por dni o celular 9 digitos.."'); ?>
                </div>
								<div class="col-sm-2  criterio_buscar">                  
										<select id="registro_desde" name="registro_desde" class="form-control"  >  <!-- saco valor desde la BD -->
											<option value="">registro desde</option>  
											<option value="1">FACEBOOK</option>  
											<option value="2" > GOOGLE</option>
											<option value="3" > REGISTRO WEB</option>
											<option value="4" > BANNER WEB</option>
											<option value="5" > TRAFICO/WEBINAR</option>
											<option value="199" > VENTA MANUAL</option>
											<option value="200" > ASIGNACION ALGORITMO</option>
										</select>
									</div>			
									<div class="col-sm-2  criterio_buscar">                  
										<?php crearselect("idusuario","select idusuario, nomusuario  from usuario where estado_idestado=1 and idtipo_usu=4 order by nomusuario asc",'class="form-control" ',$usuario["idusuario"],"--  vendeor --"); ?>   
								</div>

							 <div class="col-sm-7 criterio_mostrar">
							 <?php if($_SESSION["visualiza"]["idtipo_usu"] ==1 && $_SESSION["visualiza"]["idusuario"] ==6 ){  ?> 

									<div class="lleva_flechas" style="position:relative;">
										<label>Desde:</label>
										<?php create_input('date', 'fechabus_1', '', "form-control pull-right", $table, ''); ?>
									</div>
									<div class="lleva_flechas" style="position:relative;">
										<label>Hasta:</label>
										<?php create_input('date', 'fechabus_2', '', "form-control pull-right", $table, ''); ?>
									</div>
							<?php } ?>
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
						<?php 
							$pagina_destino="reportes_todos_leads";
							include("inc/formulario_atender_cliente_y_registrar_kardex.php"); 
						?>
						
        </div>
<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script src="js/tomar_cliente_registrado_registrar_kardex.js?ud=<?php echo $unix_date; ?>"></script>
<!--
-->

<script>
var link = "reportes_todos_lead";/*la s final se agrega en js fuctions*/
var us = "reportes_todos_cliente";/*sirve para mensaje en ventana eliminar*/
var l = "o";
var l2 = "e";/* est+ _ x {e,a,o ,etc}sirve para mensaje en ventana eliminar*/
var pr = "El";
var ar = "al";
var id = "id_pedido";
var mypage = "reportes_todos_leads.php";
</script>
<?php } ?>