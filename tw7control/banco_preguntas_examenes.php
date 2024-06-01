<?php error_reporting(E_ALL ^ E_NOTICE);
include ("auten.php");

if($_POST["task"]=='agregando_preguntas_desde_banco'){  
  $bd = new BD;
  $bd->Begin();
  $ide_bancos =  implode(',', $_POST['chkDel']);
  
	/* Recorro las preguntas del bnaco seleecionadas */
	$sql=" select * from banco_preguntas where id_banco IN (".$ide_bancos.") order by orden desc ";
// echo $sql;

	
	$banco_preguntas=executesql($sql);
	if( !empty($banco_preguntas) ){
		$_POST['estado_idestado'] = 1;
		$_POST['fecha_registro'] = fecha_hora(2);
		$_POST['fecha_actualizacion'] = fecha_hora(2);

		foreach($banco_preguntas as $data){
			
			/* registro pregunta y la asigno al examen */
			$_POST['id_banco']=$data['id_banco'];
			$_POST['titulo']=$data['b_pregunta'];
			$_POST['puntos']=$data['b_puntaje'];
			$_POST['imagen']=$data['imagen'];
			// $_POST['orden'] = _orden_noticia("","preguntas","");
			$urlrewrite=armarurlrewrite($data["b_pregunta"]);
			$_POST['titulo_rewrite']=$urlrewrite=armarurlrewrite($urlrewrite,1,"preguntas","id_pregunta","titulo_rewrite",'');
			
			
			// echo $data['b_resp1'];
			$campos=array('id_examen','titulo','titulo_rewrite','puntos','imagen','fecha_actualizacion','fecha_registro','estado_idestado'); /*inserto campos principales*/
			$_POST['id_pregunta']=$_POST['orden']=$bd->inserta_(arma_insert('preguntas',$campos,'POST'));/*inserto hora -orden y guardo imag*/

			/* orden == id_pregunta */
			/* update para guardar el orden */
			$bd->actualiza_(armaupdate('preguntas',array('orden')," id_pregunta='".$_POST['id_pregunta']."'",'POST'));/*actualizo*/

			// echo var_dump(arma_insert('preguntas',$campos,'POST'));
			
			
			
			/* Registramos las rptas de las pregunta */
			
			/* RPTA #1 */
			if( !empty($data['b_resp1']) ){
				
				$_POST['titulo']=$data['b_resp1'];
				// $_POST['orden'] = _orden_noticia("","respuestas",""); /* mucho demora en procesar tiempo de carga al parecer y causa conflicto */
				$_POST['orden'] = 1;
				// $urlrewrite=armarurlrewrite($_POST["titulo"]);
				// $_POST['titulo_rewrite']=$urlrewrite=armarurlrewrite($urlrewrite,1,"respuestas","id_rpta","titulo_rewrite",'');
				
				if($data['valor1'] == 'Si' || $data['valor1'] == 'si' || $data['valor1'] == 'SI'){
					$_POST['estado_rpta']=1;				
				}else{
					$_POST['estado_rpta']=2;
				}
				$campos_rptas=array('id_pregunta','id_examen','titulo',array('titulo_rewrite',$urlrewrite),'estado_rpta','fecha_actualizacion','orden','fecha_registro','estado_idestado'); /*inserto campos principales*/
				
				// echo var_dump(arma_insert('respuestas',$campos_rptas,'POST'));
				// exit();
				
				$_POST["id_rpta"]=$bd->inserta_(arma_insert('respuestas',$campos_rptas,'POST'));/*inserto hora -orden y guardo imag*/
				
			// }else{
				// echo "VACIO????".$data['b_resp1'];
			}
			
			/* RPTA #2 */
			if( !empty($data['b_resp2']) ){

				$_POST['titulo']=$data['b_resp2'];
				// $_POST['orden'] = _orden_noticia("","respuestas","");
				$_POST['orden'] = $_POST["id_rpta"]+1;
				// $urlrewrite=armarurlrewrite($_POST["titulo"]);
				// $_POST['titulo_rewrite']=$urlrewrite=armarurlrewrite($urlrewrite,1,"respuestas","id_rpta","titulo_rewrite",'');
				if($data['valor2'] == 'Si'  || $data['valor2'] == 'si' || $data['valor2'] == 'SI' ){
					$_POST['estado_rpta']=1;				
				}else{
					$_POST['estado_rpta']=2;
				}
				$campos_rptas=array('id_pregunta','id_examen','titulo',array('titulo_rewrite',$urlrewrite),'estado_rpta','fecha_actualizacion','orden','fecha_registro','estado_idestado'); /*inserto campos principales*/
				$_POST["id_rpta"]=$bd->inserta_(arma_insert('respuestas',$campos_rptas,'POST'));/*inserto hora -orden y guardo imag*/
			}
			
			/* RPTA #3 */
			if( !empty($data['b_resp3']) ){
				$_POST['titulo']=$data['b_resp3'];
				// $_POST['orden'] = _orden_noticia("","respuestas","");
				$_POST['orden'] = $_POST["id_rpta"]+1;

				// $urlrewrite=armarurlrewrite($_POST["titulo"]);
				// $_POST['titulo_rewrite']=$urlrewrite=armarurlrewrite($urlrewrite,1,"respuestas","id_rpta","titulo_rewrite",'');
				
				if($data['valor3'] == 'Si'  || $data['valor3'] == 'si' || $data['valor3'] == 'SI' ){
					$_POST['estado_rpta']=1;				
				}else{
					$_POST['estado_rpta']=2;
				}
				$campos_rptas=array('id_pregunta','id_examen','titulo',array('titulo_rewrite',$urlrewrite),'estado_rpta','fecha_actualizacion','orden','fecha_registro','estado_idestado'); /*inserto campos principales*/
				$_POST["id_rpta"]= $bd->inserta_(arma_insert('respuestas',$campos_rptas,'POST'));/*inserto hora -orden y guardo imag*/
			}
			
			/* RPTA #4 */
			if( !empty($data['b_resp4']) ){
				$_POST['titulo']=$data['b_resp4'];
				$_POST['orden'] = $_POST["id_rpta"]+1;

				// $_POST['orden'] = _orden_noticia("","respuestas","");
				// $urlrewrite=armarurlrewrite($_POST["titulo"]);
				// $_POST['titulo_rewrite']=$urlrewrite=armarurlrewrite($urlrewrite,1,"respuestas","id_rpta","titulo_rewrite",'');
				if($data['valor4'] == 'Si'  || $data['valor4'] == 'si' || $data['valor4'] == 'SI' ){
					$_POST['estado_rpta']=1;				
				}else{
					$_POST['estado_rpta']=2;
				}
				$campos_rptas=array('id_pregunta','id_examen','titulo',array('titulo_rewrite',$urlrewrite),'estado_rpta','fecha_actualizacion','orden','fecha_registro','estado_idestado'); /*inserto campos principales*/
				$_POST["id_rpta"]= $bd->inserta_(arma_insert('respuestas',$campos_rptas,'POST'));/*inserto hora -orden y guardo imag*/
			}
			
			/* RPTA #5 */
			if( !empty($data['b_resp5']) ){
				$_POST['titulo']=$data['b_resp5'];
				$_POST['orden'] = $_POST["id_rpta"]+1;
				// $_POST['orden'] = _orden_noticia("","respuestas","");
				// $urlrewrite=armarurlrewrite($_POST["titulo"]);
				// $_POST['titulo_rewrite']=$urlrewrite=armarurlrewrite($urlrewrite,1,"respuestas","id_rpta","titulo_rewrite",'');
				if($data['valor5'] == 'Si'  || $data['valor5'] == 'si' || $data['valor5'] == 'SI' ){
					$_POST['estado_rpta']=1;				
				}else{
					$_POST['estado_rpta']=2;
				}
				$campos_rptas=array('id_pregunta','id_examen','titulo',array('titulo_rewrite',$urlrewrite),'estado_rpta','fecha_actualizacion','orden','fecha_registro','estado_idestado'); /*inserto campos principales*/
				$_POST["id_rpta"]= $bd->inserta_(arma_insert('respuestas',$campos_rptas,'POST'));/*inserto hora -orden y guardo imag*/
			}

			/* Bancos _ x _ preguntas */
			$_POST['orden'] = _orden_noticia("","banco_preguntas_examenes","");
			$campos_bancos_x=array('id_banco','id_examen','orden','fecha_registro','estado_idestado'); /*inserto campos principales*/
			$bd->inserta_(arma_insert('banco_preguntas_examenes',$campos_bancos_x,'POST'));/*inserto hora -orden y guardo imag*/
		}
	}
	
	// echo var_dump();
	// exit();
	
	$rpta='ok';
	
  $bd->Commit();
  $bd->close();

	echo json_encode(array(
		"res" => $rpta
	));


}elseif($_GET["task"]=='finder'){

	$ya_existen=array();
	$arrays_existentes=[];
  $sql_ya_existe= "SELECT id_banco FROM banco_preguntas_examenes  WHERE  id_examen='".$_GET["id_examen"]."' "; 
	$consultando=executesql($sql_ya_existe);

	if( !empty($consultando) ){
		foreach($consultando as $consultando_data){
			array_push($arrays_existentes,$consultando_data['id_banco']);
		}
		$ya_existen=implode (',', $arrays_existentes ); // armamos el array 
	}
	
	// echo  var_dump($arrays_existentes);
	// echo  $ya_existen;
	// exit();
	
	$sql='';
	if( !empty($_GET["id_cate"]) ){
		
			$sql = "SELECT c.* FROM banco_preguntas c 
							WHERE (c.b_pregunta!='' or c.imagen !='') and c.estado_idestado=1 ";					
			if(!empty($ya_existen) ) $sql.=" and c.id_banco NOT IN (".$ya_existen.") "; /* si en caso deseen agregar preguntas duplicadas comentar esta linea, esta linea blokea las preguntas q ya han sido insertaas al examen. */
						
			if( isset($_GET['id_cate']) && !empty($_GET['id_cate']) ) $sql.=" and c.id_cate='".$_GET["id_cate"]."' ";
			 
			if(isset($_GET['criterio_mostrar'])) $porPagina=$_GET['criterio_mostrar'];
			if(isset($_GET['criterio_usu_per']) && !empty($_GET['criterio_usu_per'])){
				$stringlike=fn_filtro(substr($_GET['criterio_usu_per'], 0, 16));
				$sql.= " and  ( c.b_pregunta LIKE '%".$stringlike."%' or  c.id_banco LIKE '%".$stringlike."%' )  ";
			}
			if(isset($_GET['criterio_ordenar_por'])) $sql.= sprintf(" order by %s %s", fn_filtro($_GET['criterio_ordenar_por']), fn_filtro($_GET['criterio_orden']));
			$sql.= "  ORDER BY c.b_pregunta asc   ";
			
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
		$paging->pagina_proceso="banco_preguntas_examenes.php";
		
	}/* End si existe categoria filtrado , mostrados */
?>
			<table id="example1" class="table table-bordered table-striped">
				<tbody id="sort">
						<tr role="row">	
							<th class="unafbe" width="20">marcar</th>
							<!-- 
							<th class="sort"  width="20">DíA </th>
							-->
							<th class="sort" style='width:10px;'>Cod.</th>
							<th class="sort"  >Pregunta</th>
							<th class="" style='width:40px;'  >img</th>
							<th class="sort">Pts.</th>
							<th class="sort ">VER</th>
					 
						</tr>
<?php 
		while ($detalles = $paging->fetchResultado()): 

				// /* marcar marcar con check los que ya han sido agregados*/
					$checked='';
				// if( in_array($detalles["id_banco"],$arrays_existentes)  ){
					// $checked='checked';
				// }else{
					// $checked='';
				// }
?>
				<tr>
					<td class="text-center "><input type="checkbox" name="chkDel[]" style="margin:auto;" class="chkDel" value="<?php echo $detalles["id_banco"]; ?>"  <?php echo $checked; ?> ></td>						
					<td><?php echo $detalles["id_banco"]; ?></td>    
					<td  ><?php echo short_name($detalles["b_pregunta"],120); ?></td>                                
					<td style='width:40px;'><?php echo $detalles["imagen"]; ?></td>    
					<td><?php echo $detalles["b_puntaje"]; ?></td>    
					<td>
							<button type="button" class="btn btn-primary" data-toggle="modal"  data-id_banco="<?php echo $detalles['id_banco']; ?>" data-target="#exampleModal<?php echo $detalles['id_banco']; ?>">VER</button>
					</td>  
						<!-- Modal -->
						<div class="modal fade" id="exampleModal<?php echo $detalles['id_banco']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
							<div class="modal-dialog" role="document">
								<div class="modal-content">
									<div class="modal-header">
										<h5 class="modal-title" id="exampleModalLabel"><b>PREGUNTA</b></h5>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>
									<div class="modal-body">
										<h3 style="padding-bottom:30px;">
											<small>SKU: <?php echo $detalles["id_banco"]; ?></small>
											</br><?php echo $detalles["b_pregunta"]; ?>
										</h3>
										<?php if( !empty($detalles["imagen"]) ){ ?>
										<img src="files/images/imagenes/<?php echo $detalles["imagen"]; ?>" >
										<?php	}else{ echo "No contiene img.";} ?>
										
										<h4 style="padding-bottom:25px;"><b>Respuestas: </b></h4>
										<p class="rel" style="padding-left:25px;padding-bottom:12px;<?php echo ($detalles["valor1"]=='SI')?'color:green;':''; ?> ">
											<b class="abs" style="left:0;">1.</b> <?php echo $detalles["b_resp1"]; ?> 
											<b>valor:</b> <?php echo $detalles["valor1"]; ?> 
										</p>
										<p class="rel" style="padding-left:25px;padding-bottom:12px;<?php echo ($detalles["valor2"]=='SI')?'color:green;':''; ?>">	
											<b class="abs" style="left:0;">2.</b> <?php echo $detalles["b_resp2"]; ?> 
											<b>valor:</b> <?php echo $detalles["valor2"]; ?>
										</p>
										<p class="rel" style="padding-left:25px;padding-bottom:12px;<?php echo ($detalles["valor3"]=='SI')?'color:green;':''; ?>">
											<b class="abs" style="left:0;">3.</b> <?php echo $detalles["b_resp3"]; ?>  
											<b>valor:</b> <?php echo $detalles["valor3"]; ?>
										</p>
										<p class="rel" style="padding-left:25px;padding-bottom:12px;<?php echo ($detalles["valor4"]=='SI')?'color:green;':''; ?>">
											<b class="abs" style="left:0;">4.</b> <?php echo $detalles["b_resp4"]; ?>  
											<b>valor:</b> <?php echo $detalles["valor4"]; ?>
										</p>
										<p class="rel" style="padding-left:25px;padding-bottom:12px;<?php echo ($detalles["valor5"]=='SI')?'color:green;':''; ?>">	
											<b class="abs" style="left:0;">5.</b> <?php echo $detalles["b_resp5"]; ?> 
											<b>valor:</b> <?php echo $detalles["valor5"]; ?>
										</p>
										
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
									</div>
								</div>
							</div>
						</div>	

				</tr>
								
<?php endwhile; ?>

	
              </tbody>
            </table>
            <div class="pagination"><?php echo $paging->fetchNavegacion(); ?></div>
<script>
$(function(){
  // checked();
  // sorter();
  // reordenar('banco_preguntas_examenes.php');
	
});
var mypage = "banco_preguntas_examenes.php";
</script>

<?php }else{ ?>
        <div class="box-body">
          <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
            <form action="javascript: fn_buscar();" id="frm_buscar" name="frm_buscar">
						
						
							<input type="hidden" name="id_examen" value="<?php echo $_GET["id_examen"];?>">
							<input type="hidden" name="id_sub" value="<?php echo $_GET["id_sub"];?>">
							<input type="hidden" name="module" value="<?php echo $_GET["module"];?>">
							<input type="hidden" name="parenttab" value="<?php echo $_GET["parenttab"];?>">
              <div class="bg-gray-light">
								<div class="col-md-12">
									<?php $examen=executesql("select * from examenes where id_examen='".$_GET["id_examen"]."' "); ?>
									<h3 style="margin-top:0;">
											Banco de preguntas: </br> 
											<small style="color:#333;">Volver al Examen: <b><a href="index.php?page=preguntas&id_examen=<?php echo $_GET["id_examen"]; ?>&module=Examenes&parenttab=AulaVirtual"> <?php echo $examen[0]['titulo']; ?>  </a> </b> </small>
									</h3>
								</div>
								<div class="col-md-2 criterio_mostrar" style="margin-bottom:10px;">
										<div class="btn-eai">
											<a href="javascript:fn_add_banco_a_examenes(<?php echo $_GET["id_examen"];?>);" style="color:#fff;"><i class="fa fa-file"></i> Asignar </a>    
										</div>
								</div>
                <div class="col-sm-4 criterio_buscar" style="padding-bottom:8px;">
											<?php crearselect("id_cate", "select id_cate, titulo from categoria_examenes where estado_idestado=1 order by titulo asc", 'class="form-control"  style="border:1px solid #CA3A2B;" ', '', " Filtra por categoria "); ?>
								</div>
               
                <div class="col-sm-4 criterio_buscar">
                  <?php create_input('text','criterio_usu_per','',"form-control pull-right",$table,'placeholder="Buscar .."'); ?>
                </div>
								
								<?php /*
								<div class="col-md-2 criterio_mostrar" style="margin-bottom:10px;">
									<select id="visibilidad" name="visibilidad" class="form-control" requerid >  <!-- saco valor desde la BD -->
											<option value="" >-- visibilidad --</option>  
											<option value="1" >SI</option>  
											<option value="2" >OCULTO</option>
										</select>
								</div> 
							*/ 	?>
								
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
			$pagina_destino="aperturas";
			include("inc/formulario_ver_pregunta.php"); 
		?>					
        </div>
				
<script src="https://code.jquery.com/jquery-3.3.1.js"></script>

<script>
var link = "banco_preguntas_examene";
var us = "pregunta";
var ar = "la";
var l = "a";
var l2 = "a";
var pr = "La";
var id = "ide";
var mypage = "banco_preguntas_examenes.php";
</script>

<?php } ?>