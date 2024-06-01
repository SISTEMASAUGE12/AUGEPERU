<?php error_reporting(E_ALL ^ E_NOTICE);
include_once("auten.php");


if($_POST["task"]=='atender_cliente_insertar_kardex' ){
	include("inc/proceso_guardar_seguimiento_flotante.php");
	
	$rpta=$bd->inserta_(arma_insert('kardex_clientes',$campos,'POST'));

	/* rpta ajax */
	$bd->close();

	if( $rpta > 0 && $_POST["id_suscrito"]>0 ){
		$rpta=1;
		$texto = '<label class="col-sm-12" style="margin-top:6px;font-size: 26px;font-weight: bold;margin-bottom: 25px;">OK Seguimiento registrado.</label>
              <div class="clearfix"></div>';
		// $texto .= '<a class="btn btn-primary" href="index.php?page=suscriptores&module=ver/registrar&parenttab=Mis%20Clientes" target="_blank" style="margin-right:15px;">IR A MIS CLIENTES</a>';
		$texto .= '<a class="btn btn-danger" onclick="cerrar_flotante()">Cerrar</a> ';

		// MARCO CLIENTE COMO ATENDIDO POR EL TOKY 
		$_POST['fecha_atencion_algoritmo']= fecha_hora(2);
		$campos_cliente=array('fecha_atencion_algoritmo');
		$bd->actualiza_(armaupdate('suscritos',$campos_cliente," id_suscrito='".$_POST["id_suscrito"]."'",'POST')); 

	}

	echo json_encode(array(
		'res' => $rpta,
		'texto' => $texto
	));
	

}else if($_GET["task"]=='insert' || $_GET["task"]=='update'){
 	$bd=new BD;       
	// $campos=array('nombre','ap_pa','ap_ma','dni','telefono','ciudad','direccion',"estado_idestado"); 	
	$campos=array('nombre','ap_pa','ap_ma','dni','telefono',"estado_idestado"); 	
	
	if(!empty($_POST["id_especialidad"]) ){
			$campos=array_merge($campos,array("id_especialidad") ); 			
	}
	if(!empty($_POST["id_canal"]) ){
			$campos=array_merge($campos,array("id_canal") ); 			
	}
	
	if(!empty($_POST["id_pais"]) ){
			$campos=array_merge($campos,array("id_pais") ); 			
	}
	
		if( $_POST["id_pais"]==1 && strlen($_POST["telefono"]) ==9  ){ 
			$_POST["telefono"]='+51'.$_POST["telefono"];
		
		}elseif( strlen($_POST["telefono"]) ==9  ){
			$_POST["telefono"]='+51'.$_POST["telefono"];
			// echo $_POST["telefono"];
			// exit();
			
		}elseif( strlen($_POST["telefono"]) ==12 ){
			$_POST["telefono"]=$_POST["telefono"];
		}
	
	
	if(!empty($_POST["email"]) ){
			$campos=array_merge($campos,array("email") ); 			
	}
	
	
	
	if($_GET["task"]=='insert'){		
		
		
		// $validamos=executesql(" select * from suscritos where (dni='".$_GET["dni"]."' or telefono='".$_GET["telefono"]."') and estado_idestado=1  ");
		
		$registramos='2';
		if( !empty($_POST["telefono"]) && !empty($_POST["dni"]) ){  /* valido si existe telefono */ 
			
			$sql_consulta=" select * from suscritos where (dni='".$_POST["dni"]."' or telefono='".$_POST["telefono"]."') and estado_idestado=1  ";
			// echo $sql_consulta;
			// exit();
			
			
			$validamos=executesql($sql_consulta);		
			if( empty($validamos) ){  /* sino existe registramos */
				$registramos='1';				
			}
			
		}else if( !empty($_POST["telefono"]) && empty($_POST["dni"]) ){
		/* consulto si telefono ya existe */
			$validamos_telefono=executesql(" select * from suscritos where telefono='".$_POST["telefono"]."' and estado_idestado=1  ");		
			if( empty($validamos_telefono) ){  /* sino existe registramos */
				$registramos='1';				
			
			}else{ /* si exste cliente, mostramos error */
				$registramos='2';		
			}
			
		}
		
		// echo 'rota=>>'.$registramos;
		// exit();
		
		
		if( $registramos == '1' ){  /* sino existe registramos */
			
			if($_SESSION["visualiza"]["idtipo_usu"] == 4 ){  /* si estan con perfil vendedor, asigna automatico a ese vendedor, sino al que marcoen el select  */
				$_POST['idusuario'] = $_SESSION["visualiza"]["idusuario"];				
			}
			
			
			
			$_POST['clave'] = md5($_GET["dni"]);
			$_POST['orden'] = _orden_noticia("","suscritos","");
			$_POST['fecha_registro'] = fecha_hora(2);
			
			// echo var_dump(arma_insert('suscritos',array_merge($campos,array('fecha_registro','idusuario','orden','clave')),'POST'));
			// exit();
			
			$bd->inserta_(arma_insert('suscritos',array_merge($campos,array('fecha_registro','idusuario','orden','clave')),'POST'));
			
		}else{  /* si ya existe */
			echo "<script>
							alert('".$_GET["dni"]." - cliente ya se encuentra registrado ! '); location.href('tw7control/index.php?page=suscriptores&module=Clientes%20en%20general&parenttab=Clientes'); 
					</script>";
		}


	}else{
		/* actualizando */
		/* si existe un mismo dni, diferente a este usuario actual y esta habilitado mostramos alrte dni ya existe */
		$sql_consulta=" select * from suscritos where dni='".$_POST["dni"]."' and  id_suscrito != '".$_POST["id_suscrito"]."' and estado_idestado=1  ";
			// echo $sql_consulta;
			// exit();
			
			if($_SESSION["visualiza"]["idtipo_usu"] ==1 && !empty($_POST["idusuario"])  ){
				$campos= array_merge($campos,array('idusuario')); /* administrador puede cambiar , reasigna vendeores */
			}
			
			
			$validamos=executesql($sql_consulta);		
			if( empty($validamos) ){  /* sino existe actualizamos */
			
				// echo "-----";
			
				$registramos='1';				
				$_POST['fecha_modifico'] = fecha_hora(2);
				$_POST['idusuario_modifico'] = $_SESSION["visualiza"]["idusuario"];
				
				
				// echo var_dump(armaupdate('suscritos',array_merge($campos,array('fecha_modifico','idusuario_modifico'))," id_suscrito='".$_POST["id_suscrito"]."'",'POST'));
				// exit();
				
				
				$bd->actualiza_(armaupdate('suscritos',array_merge($campos,array('fecha_modifico','idusuario_modifico'))," id_suscrito='".$_POST["id_suscrito"]."'",'POST')); 
				
			}else{
				/* si ya existe, mostramos alerta */
					echo "<script>
							alert('".$_POST["dni"]." - cliente ya se encuentra registrado ! '); location.href('tw7control/index.php?page=suscriptores&module=Clientes%20en%20general&parenttab=Clientes'); 
					</script>";
			}
				
	}
  $bd->close();  
  gotoUrl("index.php?page=".$_POST["nompage"]."&module=".$_POST["nommodule"]."&parenttab=".$_POST["nomparenttab"]);
 
	
}elseif($_GET["task"]=='new' || $_GET["task"]=='edit'){
  if($_GET["task"]=='edit'){
     $usuario=executesql("select * from suscritos where id_suscrito='".$_GET["id_suscrito"]."'",0);
  }
?>
<section class="content">
  <div class="row">
    <div class="col-md-12">
          <!-- Horizontal Form -->
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title"><?php echo ($_GET["task"]=="edit") ? 'Editar' : 'Nuevo'; ?> CLIENTES - ALUMNOS: DOCENTES</h3></div>
<?php $task_=$_GET["task"]; ?>            
            <form action="suscriptores_algoritmos.php?task=<?php echo ($task_=='edit') ?  "update" : "insert"; ?>" class="form-horizontal" method="POST" autocomplete="OFF" onsubmit="return aceptar()">
<?php 
if($task_=='edit') create_input("hidden","id_suscrito",$usuario["id_suscrito"],"",$table,"");
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
                    <?php crearselect("estado_idestado","select * from estado",'class="form-control"',$usuario["estado_idestado"],""); ?>
                  </div>
                </div>
								
						<?php	if($_SESSION["visualiza"]["idtipo_usu"] != 4 ){ ?> 
								<div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">USUARIO VENDEDOR ASIGNADO</label>
                  <div class="col-sm-6">
                    <?php crearselect("idusuario","select idusuario,nomusuario   from usuario where estado_idestado=1 and idtipo_usu=4 order by nomusuario asc",'class="form-control" ',$usuario["idusuario"],"-- seleccione vendedor --"); ?>
                  </div>
                </div>	
						<?php } ?> 
						
								<div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Especialidades</label>
                  <div class="col-sm-6">
                    <?php crearselect("id_especialidad","select * from especialidades where estado_idestado=1 order by titulo asc",'class="form-control" required ',$usuario["id_especialidad"],"-- seleccione especialidad --"); ?>
                  </div>
                </div>		
								
								<div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Canal</label>
                  <div class="col-sm-6">
                    <?php crearselect("id_canal","select * from canales where estado_idestado=1 order by titulo asc",'class="form-control" required ',$usuario["id_canal"],"-- seleccione canal--"); ?>
                  </div>
                </div>
								
								<div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">País</label>
                  <div class="col-sm-6">
                    <?php crearselect("id_pais","select * from paises where estado_idestado=1 order by nombre asc",'required class="form-control" required ',$usuario["id_pais"],"-- seleccione canal--"); ?>
                  </div>
                </div>			              
								
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Nombres Completos</label>
                  <div class="col-sm-6">
                    <?php create_input("text","nombre",$usuario["nombre"],"form-control",$table," required ",' required '); ?>
                  </div>
                </div>
								<div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Apellido Paterno</label>
                  <div class="col-sm-6">
                    <?php create_input("text","ap_pa",$usuario["ap_pa"],"form-control",$table," required",$agregado); ?>
                  </div>
                </div>
								<div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Apellido Materno</label>
                  <div class="col-sm-6">
                    <?php create_input("text","ap_ma",$usuario["ap_ma"],"form-control",$table," required ",$agregado); ?>
                  </div>
                </div>
								<div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">DNI</label>
                  <div class="col-sm-6">
                    <?php create_input("text","dni",$usuario["dni"],"form-control",$table," required onkeypress='javascript:return soloNumeros(evt,0);' maxlength=8 ".(($task_=='edit')?'required':''),$agregado); ?>
                  </div>
                </div>
								
								<?php if($task_=='edit'){ ?>
								<div class="form-group">
                  <label for="inputPassword3" class="col-sm-4 control-label">Teléfono <big>(verifica los 12 dígitos)</big></label>
                  <div class="col-sm-6">
                    <?php create_input("text","telefono",$usuario["telefono"],"form-control",$table," required maxlength='12' minlength='12'  ",$agregado); ?>
                  </div>
                </div>
								<?php }else{  ?>
								<div class="form-group">
                  <label for="inputPassword3" class="col-sm-4 control-label">Teléfono <big>(ingresa solo 9 dígitos)</big></label>
                  <div class="col-sm-6">
                    <?php create_input("text","telefono",$usuario["telefono"],"form-control",$table," required maxlength='9' minlength='9'  ",$agregado); ?>
                  </div>
                </div>
								
								<?php } ?>
								
								<?php /* 
								<div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Ciudad</label>
                  <div class="col-sm-6">
                    <?php create_input("text","ciudad",$usuario["ciudad"],"form-control",$table," required ",$agregado); ?>
                  </div>
                </div>
								
								<div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Dirección:</label>
                  <div class="col-sm-6">
                    <?php create_input("text","direccion",$usuario["direccion"],"form-control",$table," required ",$agregado); ?>
                  </div>
                </div>
								*/ ?>
								 
								<div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Email</label>
                  <div class="col-sm-6">
                    <?php create_input("text","email",$usuario["email"],"form-control",$table," required ",$agregado); ?>
                  </div>
                </div>
<?php if($_GET["task"]=='new'){  ?>
								<div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Clave:</label>
                  <div class="col-sm-6">
										<label for="inputPassword3" class=" control-label">Su número de DNI (Recomendar al Suscrito cambiar clave desde su perfil)</label>            
                  </div>
                </div>
<?php }else{ ?>
	
<?php } ?>
          
              </div>
							<div class="box-footer">
                <div class="form-group">
                  <div class="col-sm-10 pull-right">
                    <input  type="submit"  class="btn bg-blue btn-flat" id="btnguardar" value="Guardar">
                    <button type="button" class="btn bg-red btn-flat" onclick="javascript:gotourl('<?php echo $link; ?>');">Cancelar</button>
                  </div>
                </div>
              </div>							
<script>	
function aceptar(){
	var nam1=document.getElementById("telefono").value;			
	var nam2=document.getElementById("dni").value;			
	var nam3=document.getElementById("email").value;			
	var nam4=document.getElementById("id_especialidad").value;			
	var nam5=document.getElementById("id_canal").value;			
	var nam6=document.getElementById("nombre").value;			
	var nam7=document.getElementById("ap_pa").value;			
	var nam8=document.getElementById("ap_ma").value;			
	var nam9=document.getElementById("id_pais").value;
	/*			
	var nam10=document.getElementById("direccion").value;			
	var nam11=document.getElementById("ciudad").value;			
*/

	if(nam1 !='' && nam2 !=''  && nam3 !=''  && nam4 !=''  && nam5 !=''  && nam6 !=''  && nam7 !=''  && nam8 !=''  && nam9 !='' ){									
		alert("Registrando ... Click en Aceptar & espere unos segundos. ");							
		document.getElementById("btnguardar").disabled=true;			
	}else{		
		alert("Recomendación: Todos los datos son obligatorios! )");
		return false; //el formulario no se envia		
	}	
}				
</script>	
        </form>
          </div><!-- /.box -->
        </div><!--/.col (right) -->
  </div>
</section><!-- /.content -->
<?php
}elseif($_GET["task"]=='drop' || $_GET["task"]=='dropselect'){
  $bd = new BD;
  $bd->Begin();
  $ide = !isset($_GET['id_suscrito']) ? implode(',', $_GET['chkDel']) : $_GET['id_suscrito'];
  $bd->actualiza_("DELETE FROM suscritos WHERE id_suscrito IN(".$ide.")");
  $bd->Commit();
  $bd->close();


}elseif($_GET["task"]=='uestado'){
  $bd = new BD;
  $bd->Begin();
  $ide = !isset($_GET['id_suscrito']) ? $_GET['estado_idestado'] : $_GET['id_suscrito'];
  $ide = is_array($ide) ? implode(',',$ide) : $ide;
  $usuario = executesql("SELECT * FROM suscritos WHERE id_suscrito IN (".$ide.")");
  if(!empty($usuario))
  foreach($usuario as $reg => $item)
  if ($item['estado_idestado']==1) {
    $state = 2;
  }elseif ($item['estado_idestado']==2) {
    $state = 1;
  }
  $num_afect=$bd->actualiza_("UPDATE suscritos SET estado_idestado=".$state." WHERE id_suscrito=".$ide."");
  echo $state;
  $bd->Commit();
  $bd->close();


}elseif($_GET["task"]=='finder'){

	$array= array();
	$meses=array('Jan'=>'Enero','Feb'=>'Febrero','Mar'=>'Marzo','Apr'=>'Abril','May'=>'Mayo','Jun'=>'Junio','Jul'=>'Julio','Aug'=>'Agosto','Sep'=>'Septiembre','Oct'=>'Octubre','Nov'=>'Noviembre','Dec'=>'Diciembre');
		
	$sql.= "SELECT c.*,YEAR(c.fecha_registro) as anho, MONTH(c.fecha_registro) as mes, e.nombre AS estado, CONCAT(c.ap_pa,' ',c.ap_ma) as apellidos, esp.titulo as espe, pa.nombre as pais , can.titulo as canal, u.nomusuario as usuariox   
		FROM suscritos c 
		INNER JOIN estado e ON c.estado_idestado=e.idestado  
		LEFT JOIN usuario u ON c.idusuario=u.idusuario   
		LEFT JOIN canales can ON c.id_canal=can.id_canal  
		LEFT JOIN especialidades esp ON c.id_especialidad=esp.id_especialidad 
		LEFT JOIN paises pa ON c.id_pais= pa.id_pais  
		where e.idestado=c.estado_idestado  and c.dni !='' and c.dni is NOT NULL and c.id_especialidad !='' and c.id_especialidad is NOT NULL  and c.idusuario='".$_SESSION["visualiza"]["idusuario"]."'
				 and c.registro_desde is NOT NULL  and c.fecha_atencion_algoritmo is NULL 
		";  // NULL son los registro desde sistema de ventas 

			
  if (isset($_GET['criterio_mostrar'])) $porPagina=$_GET['criterio_mostrar'];
  if(isset($_GET['criterio_usu_per']) && !empty($_GET['criterio_usu_per']) ){
    $stringlike=fn_filtro(substr($_GET['criterio_usu_per'], 0, 50));
    // $sql.= " AND (ap_pa like '%".$stringlike."%' OR c.ap_ma like '%".$stringlike."%' OR c.telefono like '%".$stringlike."%' OR c.dni LIKE '%".$stringlike."%' OR c.email LIKE '%".$stringlike."%' OR c.nombre LIKE '%".$stringlike."%' OR c.id_suscrito LIKE '%".$stringlike."%' )";
    $sql.= " AND (ap_pa = '".$stringlike."' OR c.ap_ma = '".$stringlike."' OR c.telefono = '".$stringlike."' OR c.dni = '".$stringlike."' OR c.email = '".$stringlike."' OR c.nombre = '".$stringlike."' OR c.id_suscrito = '".$stringlike."' )";

  }else{
			if( empty($_GET['fechabus_1']) && empty($_GET['fechabus_2']) ) {
				$sql .= " AND DATE(c.fecha_registro) = '" . fecha_hora(1) . "'";
			}
	}
	
		
	/* filtro solo ventas del vendedor : 
	if( $_SESSION["visualiza"]["idtipo_usu"] ==4 ){ 
		$sql .= " AND c.idusuario = '".$_SESSION["visualiza"]["idusuario"]."'";
	}
	*/
	
	if(!empty($_GET['id_especialidad']) ) {
			$sql .= " AND c.id_especialidad='".$_GET['id_especialidad']."'  ";		
	}
	if(!empty($_GET['id_canal']) ) {
			$sql .= " AND c.id_canal='".$_GET['id_canal']."'  ";		
	}
	if(!empty($_GET['id_pais']) ) {
			$sql .= " AND c.id_pais='".$_GET['id_pais']."'  ";		
	}
	
	if(!empty($_GET['fechabus_1']) && !empty($_GET['fechabus_2'])) {
			$sql .= " AND DATE(c.fecha_registro)  BETWEEN  DATE('".$_GET['fechabus_1']."')  and DATE('".$_GET['fechabus_2']."')  ";		
	}

	$sql.=" ORDER BY c.fecha_registro desc ";
	
	// echo $sql; 
	
  $paging = new PHPPaging;
  $paging->agregarConsulta($sql); 
  $paging->div('div_listar');
  $paging->modo('desarrollo'); 
  $numregistro=1; 
  if($numregistro) $paging->porPagina(fn_filtro((int)$numregistro));
  $paging->verPost(true);
  $mantenerVar=array("criterio_mostrar","task","criterio_usu_per");
  $paging->mantenerVar($mantenerVar);
  // $paging->porPagina(fn_filtro((int)$porPagina));
  $paging->porPagina(1000);
  $paging->ejecutar();
  $paging->pagina_proceso="suscriptores_algoritmos.php";
?>
		<table id="example1" class="table table-bordered table-striped">
			<tbody id="sort">

<?php  $i=0;
		while ($detalles = $paging->fetchResultado()): 
			if(!in_array(array('mes' => $detalles['mes'], 'anho' => $detalles['anho']), $array)){
				$array[] = array('mes' => $detalles['mes'], 'anho' => $detalles['anho']);
?>
				<tr class="lleva-mes">
					<td colspan="9"><h6><?php echo strtoupper(strtr(date('M Y',strtotime($detalles['fecha_registro'])),$meses)); ?></h6></td>
				</tr>
				<tr role="row">
					<th width="30">Día</th>
					<th width="90">Fecha</th>
					<th width="90">Hora</th>
					<th width="90">USUARIO</th>
					<!-- 
					<th class="sort cnone">DESDE</th>
					-->
					<th class="sort cnone">PAÍS</th>
					<th class="sort cnone">CANAL</th>
					<th class="sort cnone">ESPECIALIDAD</th>
					<th class="sort cnone">EMAIL</th>
					<th class="sort cnone">Nombre</th>
					<th class="sort cnone">APE</th>
					<th class="sort cnone">DNI</th>
					<th class="sort cnone">CEL</th>
					<th class="sort cnone">ESTADO</th>
					<th class="unafbe "  	<?php if( $_SESSION["visualiza"]["idtipo_usu"] !=4 ){  echo ' width="305"';}else{ echo ' width="180"';} ?>  >Opciones</th>
				</tr>
<?php }//if meses ?>
				<tr>
					<td><?php echo !empty($detalles['fecha_registro']) ? date('d',strtotime($detalles['fecha_registro'])) : '...'; ?></td>
					<td><?php echo $detalles['fecha_registro']; ?></td>
					<td><?php echo $detalles['hora_registro']; ?></td>
					<!-- 
					<td><?php 
						if( $detalles["registro_desde"] =='1'){ 
							echo "Facebook";
						}else if( $detalles["registro_desde"] =='2'){
							echo "Google";
						}else{
							echo "-";
						}

					?></td>
					-->
					<td><?php echo $detalles["usuariox"]; ?></td>
					<td><?php echo $detalles["pais"]; ?></td>
					<td><?php echo $detalles["canal"]; ?></td>
					<td><?php echo $detalles["espe"]; ?></td>
					<td><?php echo $detalles["email"]; ?></td>
					<td><?php echo $detalles["nombre"]; ?></td>
					<td><?php echo $detalles["apellidos"]; ?></td>
					<td><?php echo $detalles["dni"]; ?></td>
					<td><?php echo $detalles["telefono"]; ?></td>
					<td class="cnone"><a href="javascript: fn_estado('<?php echo $detalles["id_suscrito"]; ?>')"><?php echo $detalles["estado"]; ?></a></td>
					<td>
						<div class="btn-eai btr  text-center"  	<?php if( $_SESSION["visualiza"]["idtipo_usu"] !=4 ){  echo ' style="width:305px;"'; }else{  echo ' style="width:180px;"'; } ?> >
						
							<a href="<?php echo 'index.php?page=suscriptores&task=edit&id_suscrito='.$detalles["id_suscrito"]; ?>" title="Editar suscrito" style="color:#fff;"> editar</a>

				<?php 
					$nombre_completo=$detalles['dni'].' - '.$detalles['nombre'].' '.$detalles['ap_pa'].' '.$detalles['ap_ma'].' - tel: '.$detalles['telefono']; 
					// TOKY 
					$js_llamar_toky='';
					$telefono_toky='';

					// if( $detalles['id_pais']==1) { // si e speru telefono tiene 12 carateres +51 - sacamos este +51 para toky
						if( strlen($detalles['telefono']) == 12 ){ // si tiene 12 esta bien registrado, quitamos los 3 primeros 
							$telefono_toky= substr($detalles['telefono'], 3);
							$js_llamar_toky=" onClick='TokyPopup(".$telefono_toky.")'  ";
						}

					// }
				?>
						<button type="button" class="btn btn-primary llama" data-toggle="modal" data-target="#exampleModal"  data-id_suscrito="<?php echo $detalles['id_suscrito']; ?>" data-whatever="@mdo" data-titulo="<?php echo $nombre_completo; ?> "    <?php echo $js_llamar_toky; ?> >
							ATENDER 
						</button>
					
							
	<?php 	if( $_SESSION["visualiza"]["idtipo_usu"] !=4 ){  ?>
		
							<a style="color:#fff;" href="index.php?page=suscritos_lista_de_cursos&id_suscrito=<?php echo $detalles['id_suscrito']; ?>&module=Alumnos&parenttab=AulaVirtual" title="ver cursos"> cursos</a>
							<a style="color:#fff;" href="index.php?page=suscriptores_certificados&id_suscrito=<?php echo $detalles['id_suscrito']; ?>&module=Alumnos&parenttab=AulaVirtual" title="Certificados"> certifi</a>
							<a style="color:#fff;" href="index.php?page=suscriptores_certificados_solicitados&id_suscrito=<?php echo $detalles['id_suscrito']; ?>&module=Alumnos&parenttab=AulaVirtual" title="Certificados"> certifi sol</a>
							
							<a style="color:#fff;" href="index.php?page=libros_vendidos&id_suscrito=<?php echo $detalles['id_suscrito']; ?>&module=Alumnos&parenttab=AulaVirtual" title="Certificados"> libros</a>
		<?php 
		// if($_SESSION["visualiza"]["idtipo_usu"] ==1){
			?>

<!--							
<a href="javascript: fn_eliminar('<?php echo $detalles["id_suscrito"]; ?>')" style="color:#fff;background:red;" title="Eliminar cliente"><i class="fa fa-trash-o"></i></a>
		--> 
		
				 <?php
				 // } 
				 ?> 									
		<?php }  /* restingiendo permisos segun tipo de usuario  */ ?> 


						
						</div>
					</td>
				</tr>
				<tr>
					<td></td>
					<td >Usuario modifico: </td>
					<td><?php echo ($_SESSION["visualiza"]["idusuario"] == $detalles["idusuario_modifico"])?ucwords($_SESSION['visualiza']['nomusuario']):$detalles["idusuario_modifico"]; ?></td>
					<td></td>
					<td >Fecha modifico: </td>
					<td><?php echo $detalles["fecha_modifico"]; ?> </td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
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
  // reordenar('suscriptores_algoritmos.php');
  checked();
  // sorter();
});
</script>

<?php 



}else{ ?>
        <div class="box-body">
          <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
            <form action="javascript: fn_buscar();" id="frm_buscar" name="frm_buscar">
              <div class="bg-gray-light">
                <div class="col-sm-12" style="padding-bottom:20px;">									

									<div class="col-sm-2  btn-eai ">                  
										<a href="https://www.educaauge.com/tw7control/index.php?page=suscriptores_algoritmos&module=Contactar_Ahora&parenttab=Mis%20Clientes" CLASS="btn " style="color:#fff;">Refrescar</a>
									</div>

									<div class="col-sm-4  criterio_buscar">                  
										<?php create_input('text','criterio_usu_per','',"form-control pull-right",$table,"placeholder='Buscar por nombre, apellidos, dni, teléfono..'"); ?>
									</div>
									
									<div class="col-sm-6 criterio_mostrar">
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
			 <?php 		if( $_SESSION["visualiza"]["idtipo_usu"] !=4 ){ ?>
  
								<div class="col-sm-2  criterio_buscar">                  
										<?php crearselect("id_especialidad","select * from especialidades where estado_idestado=1 order by titulo asc",'class="form-control" ',$usuario["id_especialidad"],"-- especialidad--"); ?>   
								</div>
								<div class="col-sm-2  criterio_buscar">                  
										<?php crearselect("id_canal","select * from canales where estado_idestado=1 order by titulo asc",'class="form-control" ',$usuario["id_canal"],"-- canales --"); ?>   
								</div>
								<div class="col-sm-2  criterio_buscar">                  
										<?php crearselect("id_pais","select * from paises where estado_idestado=1 order by nombre asc",'class="form-control" ',$usuario["id_pais"],"--  país"); ?>   
								</div>
			 <?php }  /* limitando filtro segun  tipo de usuario */ ?>
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
			<?php 
				$pagina_destino="suscriptores";
				include("inc/formulario_atender_cliente_y_registrar_kardex.php"); 
			?>	
		</div>
		
<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script src="js/tomar_cliente_registrado_registrar_kardex.js?ud=<?php echo $unix_date; ?>"></script>
<!--
-->
				
<script>
var link = "suscriptores_algoritmo";/*la s final se agrega en js fuctions*/
var us = "suscriptor";/*sirve para mensaje en ventana eliminar*/
var l = "o";
var l2 = "e";/* est+ _ x {e,a,o ,etc}sirve para mensaje en ventana eliminar*/
var pr = "El";
var ar = "al";
var id = "id_suscrito";
var mypage = "suscriptores_algoritmos.php";
</script>
<?php } ?>