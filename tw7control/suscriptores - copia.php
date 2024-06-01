<?php error_reporting(E_ALL ^ E_NOTICE);
include_once("auten.php");


if($_GET["task"]=='buscardni'){
	$id=''; $nombre=''; $rpta=2;
  
	$exsql = executesql("SELECT * FROM suscritos WHERE dni =".$_GET["dni"]);
	if(!empty($exsql)){
		foreach($exsql as $row){
			$id = $row['id_suscrito'];
			$nombre = $row['nombre'];
			$ap_pa = $row['ap_pa'];
			$ap_ma = $row['ap_ma'];
			$rpta = 1;
		} 
	}
	  
  
	echo json_encode(array(
	  'res' => $rpta,
	  'id' => $id,
	  "nombre" => $nombre,
	  "ap_pa" => $ap_pa,
	  "ap_ma" => $ap_ma
	));

	
}else if($_POST["task"]=='atender_cliente_insertar_kardex' ){
	include("inc/proceso_guardar_seguimiento_flotante.php");
	
	$rpta=$bd->inserta_(arma_insert('kardex_clientes',$campos,'POST'));
	
	/*    todos atiendes a todos , comento esta validacion que limitaba a a tendet solo a tus clientes de c/vendedor 
		$validate=executesql("select * from suscritos where id_suscrito='".$_POST["id_suscrito"]."' ",0);
		if( !empty($validate) ){  // si este vendedor es dueño de este cliente 
				
			if( $validate['idusuario'] == $_SESSION["visualiza"]["idusuario"] ){ // si es suyo 
				
				// $bd->close();
				// gotoUrl("index.php?page=suscriptores&module=ver/registrar&parenttab=Mis%20Clientes");	
				
			// }else if( empty($validate['idusuario'] ) ){ // si clinte no tien vendedor asignado, le asignamos 
			
				// $rpta=$bd->inserta_(arma_insert('kardex_clientes',$campos,'POST'));
				// $campos_cliente=array('idusuario','fecha_atendido');
				// $bd->actualiza_(armaupdate('suscritos',$campos_cliente," id_suscrito='".$_POST["id_suscrito"]."'",'POST')); 
				

			}else{  // si ciente , tiene otro vendedor asignado 
				echo "<script>
									alert('Lo sentimos. Cliente, ya tiene un vendedor asignado. '; 				
									location.href='index.php?page=reportes_todos_clientes&module=Buscar%20si%20existe%20Cliente&parenttab=Reportes' );
							</script>";
			}
			
		}		
		*/
	

	/* rpta ajax */
	$bd->close();

	if( $rpta > 0 && $_POST["id_suscrito"]>0 ){
		$rpta=1;
		$texto = '<label class="col-sm-12" style="margin-top:6px;font-size: 26px;font-weight: bold;margin-bottom: 25px;">Seguimiento asociado con éxito.</label>
              <div class="clearfix"></div>';
		$texto .= '<a class="btn btn-primary" href="index.php?page=suscriptores&module=ver/registrar&parenttab=Mis%20Clientes" target="_blank" style="margin-right:15px;">IR A MIS CLIENTES</a>';
		$texto .= '<a class="btn btn-danger" onclick="cerrar_flotante()">Cerrar</a> ';
	}

	echo json_encode(array(
		'res' => $rpta,
		'texto' => $texto
	));
	

}else if($_GET["task"]=='insert' || $_GET["task"]=='update'){
 	$bd=new BD;       
	// $campos=array('nombre','ap_pa','ap_ma','dni','telefono','ciudad','direccion',"estado_idestado"); 	

	// echo '-->'.$_POST["id_pais"];
	
	/*
	if( $_POST["id_pais"] == 1){  
		$_POST["dni"]=  !empty($_POST["dni"])?$_POST["dni"]:$_POST["api_dni"]; // puede ser que no viene de reniec , entonces dni = post:dni, dni esta vacio, vino desde api
		$_POST["nombre"]=  $_POST["api_nombre"];
		$_POST["ap_pa"]=  $_POST["api_ap_pa"];
		$_POST["ap_ma"]=  $_POST["api_ap_ma"];
		
	}
	

	if(  $_GET["task"]=='update' &&  $_POST["id_pais"] == 1){  
		$_POST["dni"]=  !empty($_POST["dni"])?$_POST["dni"]:$_POST["api_dni"]; //  puede ser q api no encomtro datos y se registro manual 
		$_POST["nombre"]=  $_POST["api_nombre"];
		$_POST["ap_pa"]=  $_POST["api_ap_pa"];
		$_POST["ap_ma"]=  $_POST["api_ap_ma"];		
	}
	if(  $_GET["task"]=='update'  && $_POST["id_pais"] != 1){  
		$_POST["dni"]=  !empty($_POST["dni"]) ?$_POST["dni"]:$_POST["api_dni"];
		$_POST["nombre"]=  !empty($_POST["nombre"]) ?$_POST["nombre"]: $_POST["api_nombre"];
		$_POST["ap_pa"]=  !empty($_POST["ap_pa"]) ?$_POST["ap_pa"]:$_POST["api_ap_pa"];
		$_POST["ap_ma"]=  !empty($_POST["ap_ma"]) ?$_POST["ap_ma"]:$_POST["api_ap_ma"];
		
	}
	*/


	
	$_POST["dni"]=  !empty($_POST["dni"]) ?$_POST["dni"]:$_POST["api_dni"];
	$_POST["nombre"]=  !empty($_POST["nombre"]) ?$_POST["nombre"]: $_POST["api_nombre"];
	$_POST["ap_pa"]=  !empty($_POST["ap_pa"]) ?$_POST["ap_pa"]:$_POST["api_ap_pa"];
	$_POST["ap_ma"]=  !empty($_POST["ap_ma"]) ?$_POST["ap_ma"]:$_POST["api_ap_ma"];



	$campos=array('nombre','ap_pa','ap_ma','dni','telefono',"estado_idestado"); 	
	
	if(!empty($_POST["id_tipo_cliente"]) ){
			$campos=array_merge($campos,array("id_tipo_cliente") ); 			
	}
	
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
		
		$_POST['registro_desde']='4'; // si registro desde sistema es manual 
		$campos=array_merge($campos,array('registro_desde') ); 			

		
		// $validamos=executesql(" select * from suscritos where (dni='".$_GET["dni"]."' or telefono='".$_GET["telefono"]."') and estado_idestado=1  ");
		
		$registramos_dni='2';
		$registramos_telefono='2';
		$registramos_correo='2';

		if(  !empty($_POST["dni"])  && strlen($_POST["dni"]) >= 8 ){  /* valido si existe telefono */ 
				
				if(  !empty($_POST["dni"]) ){  /* valido si existe telefono */ 
					
					$sql_consulta=" select * from suscritos where dni='".$_POST["dni"]."'  and estado_idestado=1  ";
					// echo $sql_consulta;
					// exit();

					$validamos=executesql($sql_consulta);		
					if( empty($validamos) ){  /* sino existe registramos */
						$registramos_dni='1';				
					}
					
				}

				// valido por telefono
				if( !empty($_POST["telefono"])  ){
				/* consulto si telefono ya existe */
					$validamos_telefono=executesql(" select * from suscritos where telefono='".$_POST["telefono"]."' and estado_idestado=1  ");		
					if( empty($validamos_telefono) ){  /* sino existe registramos */
						$registramos_telefono='1';				
					
					}else{ /* si exste cliente, mostramos error */
						$registramos_telefono='2';		
					}
					
				}
				

				// valido por correo: 
				/* consulto si correo ya existe */
				$validamos_email=executesql(" select * from suscritos where email='".$_POST["email"]."' and estado_idestado=1  ");		
				if( empty($validamos_email) ){  /* sino existe registramos */
					$registramos_correo='1';				
				
				}else{ /* si exste cliente, mostramos error */
					$registramos_correo='2';		
				}

				// echo 'rota=>>'.$registramos;
				// exit();
				
				
				if( $registramos_dni == '1'  && $registramos_telefono =='1' && $registramos_correo =='1' ){  /* sino existe registramos */
					
					if($_SESSION["visualiza"]["idtipo_usu"] == 4 ){  /* si estan con perfil vendedor, asigna automatico a ese vendedor, sino al que marcoen el select  */
						$_POST['idusuario'] = $_SESSION["visualiza"]["idusuario"];				
					}
					
					
					
					$_POST['clave'] = md5($_POST["dni"]);
					$_POST['orden'] = _orden_noticia("","suscritos","");
					$_POST['fecha_registro'] = fecha_hora(2);
					$_POST['hora_registro'] = fecha_hora(0);
					
					// echo var_dump(arma_insert('suscritos',array_merge($campos,array('fecha_registro','idusuario','orden','clave')),'POST'));
					// exit();
					
					$bd->inserta_(arma_insert('suscritos',array_merge($campos,array('fecha_registro','hora_registro','idusuario','orden','clave')),'POST'));
					
				}else{  /* si ya existe */
					echo "<script>
									alert('".$_GET["dni"]." - cliente ya se encuentra registrado ! '); location.href('tw7control/index.php?page=suscriptores&module=Clientes%20en%20general&parenttab=Clientes'); 
							</script>";
				}

		}else{  /* DNI 8 digitos  */
			echo "<script>
							alert('".$_GET["dni"]." - EL DNI debe tener 8 digitos '); location.href('tw7control/index.php?page=suscriptores&module=Clientes%20en%20general&parenttab=Clientes'); 
					</script>";
		}


	}else{
		/* actualizando */
		/* si existe un mismo dni, diferente a este usuario actual y esta habilitado mostramos alrte dni ya existe */
		$sql_consulta=" select * from suscritos where dni='".$_POST["dni"]."' and  id_suscrito != '".$_POST["id_suscrito"]."' and estado_idestado=1  ";
		$sql_consulta_email=" select * from suscritos where email='".$_POST["email"]."' and  id_suscrito != '".$_POST["id_suscrito"]."' and estado_idestado=1  ";
			// echo $sql_consulta;
			// exit();
			
			if($_SESSION["visualiza"]["idtipo_usu"] ==1 && !empty($_POST["idusuario"])  ){
				$campos= array_merge($campos,array('idusuario')); /* administrador puede cambiar , reasigna vendeores */
			}
			
			
			$validamos=executesql($sql_consulta);		
			$validamos_email=executesql($sql_consulta_email);		

			if( empty($validamos) &&  empty($validamos_email) ){  // sino existe actualizamos 
			
				// echo "-----";
			
				$registramos='1';				
				$_POST['fecha_modifico'] = fecha_hora(2);
				$_POST['idusuario_modifico'] = $_SESSION["visualiza"]["idusuario"];
								
				// echo var_dump(armaupdate('suscritos',array_merge($campos,array('fecha_modifico','idusuario_modifico'))," id_suscrito='".$_POST["id_suscrito"]."'",'POST'));
				// exit();								
				$bd->actualiza_(armaupdate('suscritos',array_merge($campos,array('fecha_modifico','idusuario_modifico'))," id_suscrito='".$_POST["id_suscrito"]."'",'POST')); 
		
		
			}else{
				// si ya existe, mostramos alerta /
					echo "<script>
							alert('".$_POST["dni"]." o '".$_POST["email"]."' - cliente ya se encuentra registrado, verifica bien los datos aingresar ! '); location.href('tw7control/index.php?page=suscriptores&module=Clientes%20en%20general&parenttab=Clientes'); 
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

<script src="js/buscar_reniec_reg_cliente_2023.js"></script>
<section class="content">
  <div class="row">
    <div class="col-md-12">
          <!-- Horizontal Form -->
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title"><?php echo ($_GET["task"]=="edit") ? 'Editar' : 'Nuevo'; ?> CLIENTES - ALUMNOS: DOCENTES</h3></div>
<?php $task_=$_GET["task"]; ?>            
            <form action="suscriptores.php?task=<?php echo ($task_=='edit') ?  "update" : "insert"; ?>" class="form-horizontal" method="POST" autocomplete="OFF" onsubmit="return aceptar()">
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
					<label for="inputEmail3" class="col-sm-2 control-label">País</label>
					<div class="col-sm-6">
					<?php  
					$_control_pais='';
					if($task_ == 'edit' && !empty($usuario["dni"])  ){ 
						// $_control_pais=' disabled ';  // de momento para que las vendedoras puedan editar registros ::: 13 - 08 -2023 
					}

					if($task_ =='edit'  ){ // si dni esta vacio muentro select para editar sino ya no 
						if( empty($usuario["dni"]) ){ // si dni esta vacio muentro select para editar sino ya no 
							crearselect("id_pais","select * from paises where estado_idestado=1 order by nombre asc",'required class="form-control" required '.$_control_pais ,$usuario["id_pais"],"-- seleccione canal--");
						}else{
							crearselect("id_pais_info_edit","select * from paises where estado_idestado=1 order by nombre asc",'required class="form-control" required '.$_control_pais ,$usuario["id_pais"],"-- seleccione canal--"); // solo para mostrar 
							create_input("hidden","id_pais",$usuario["id_pais"],"form-control",$table," required ",' required ');  // id_pais lo envio oculto 

						}

					}else{ // si es new registro 
						crearselect("id_pais","select * from paises where estado_idestado=1 order by nombre asc",'required class="form-control" required '.$_control_pais ,$usuario["id_pais"],"-- seleccione canal--");
					}
					?>
					</div>
			</div>		

				<div class="form-group">			

					<!--  *  new desde reniec -->
					<?php  // echo $usuario["registro_desde"] ;
						if($task_!='edit' || ( $usuario["registro_desde"] != '3' && $usuario["registro_desde"] !='4' && empty($usuario["dni"]))  ){  // si es nuevo || o estoy editando alguien de webinar que no tiene un dni reistrado  ?>
						<label class="label_dni col-sm-2 control-label ">DNI cliente.: <small style="color:red;font-size:10px;"></small></label>
						<div class="col-sm-2 ">
							<input type="text" onkeypress='javascript:return soloNumeros(event,0);'  id="dni" name="dni" class="form-control">
							<a class="btn bg-blue btn-flat btn_buscar_dni <?php echo (( ($task_ =='edit' && !empty($usuario["dni"]) ) || $task_ =='new'  )?"  hide ":"  ") ?> " style="float: right;margin-top: -34px;position: relative;" onclick="busque_cliente();">B</a>
						</div>
						<?php create_input("hidden","api_dni",$usuario["dni"],"form-control",$table," required ",' required '); ?>


					<?php }else{ ?>
						<input type="hidden"  id="api_dni" name="api_dni" value="<?php echo $usuario["dni"]; ?>" class="form-control">
						
						<label class=" col-sm-2 control-label ">DNI: </label>
						<!-- <label class=" col-sm-2 control-label "> <?php echo $usuario["dni"]; ?></label> -->
						<div class="col-sm-6">
							<input type="text"  id="dni" name="dni" value="<?php echo $usuario["dni"]; ?>" class="form-control">  <!-- * por mientras para q venderorea edite registros. 13-08-2023 -->
						</div>
					
					<?php } ?>

				</div>

		<fieldset id="field_client" >
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Nombres Completos</label>
                  <div class="col-sm-6">
                    <?php create_input("hidden","api_nombre",$usuario["nombre"],"form-control ",$table," required ",'   '); ?>
                    <?php 
						
						if( $usuario["nombre"]  == 'error en api reniec'){ // para donde no se encontr datos api - que ingresen manual 	 
							$_bloqueamos=' '; 								

						}else if( $task_ =='edit' && !empty($usuario["dni"]) ){
								// $_bloqueamos='disabled';  // por mientras para q venderoa edte manual
							
						}else{
							if( $task_ =='edit' &&  $usuario["id_pais"] ==1 ){ // si peru 
								// $_bloqueamos='disabled'; // por mientras para q venderoa edte manual
							}else{ // si es otro pais normal dejamos en blanco para que ingrese manual 
								$_bloqueamos=' ';
							}

						}
						create_input("text","nombre",$usuario["nombre"],"form-control",$table," required ".$_bloqueamos,' required '); ?>
                  </div>
                </div>
								<div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Apellido Paterno</label>
                  <div class="col-sm-6">
				  	<?php create_input("hidden","api_ap_pa",$usuario["ap_pa"],"form-control",$table," required ",' required '); ?>
                    <?php create_input("text","ap_pa",$usuario["ap_pa"],"form-control",$table," required ".$_bloqueamos ,$agregado); ?>
                  </div>
                </div>
				<div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Apellido Materno</label>
                  <div class="col-sm-6">
				  	<?php create_input("hidden","api_ap_ma",$usuario["ap_ma"],"form-control",$table," required ",' required '); ?>
                    <?php create_input("text","ap_ma",$usuario["ap_ma"],"form-control",$table," required ".$_bloqueamos, $agregado); ?>
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
                    <?php create_input("text","telefono",$usuario["telefono"],"form-control",$table," required maxlength='9' onkeypress='javascript:return soloNumeros_precio(event,0);' minlength='9'  ",$agregado); ?>
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
                  <label for="inputEmail3" class="col-sm-2 control-label">Especialidades</label>
                  <div class="col-sm-6">
                    <?php crearselect("id_especialidad","select * from especialidades where estado_idestado=1 order by titulo asc",'class="form-control" required ',$usuario["id_especialidad"],"-- seleccione especialidad --"); ?>
                  </div>
                </div>		
				
				<div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Eres docente nombrado ? (SI/NO)</label>
                  <div class="col-sm-6">
                    <?php  crearselect("id_tipo_cliente","select id_tipo_cliente, titulo  from tipo_clientes where estado_idestado=1 order by titulo asc ",'class="poppi " required ',$usuario["id_tipo_cliente"],"  Eres docente nombrado ? ");  ?>
                  </div>
                </div>		
								
								<div class="form-group">
									<label for="inputEmail3" class="col-sm-2 control-label">Canal</label>
									<div class="col-sm-6">
                    <?php crearselect("id_canal","select * from canales where estado_idestado=1 order by titulo asc",'class="form-control" required ',$usuario["id_canal"],"-- seleccione canal--"); ?>
                  </div>
                </div>
				
		

								<div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Email</label>
                  <div class="col-sm-6">
										<input type="email" id="email" name="email" required value="<?php echo $usuario["email"];?>"  class="form-control ">
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
				</fieldset>
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



<?php if($task_!='edit'){ ?>
	console.log(" fieldset");
	document.getElementById("field_client").disabled=true;
<?php } ?>

if (document.getElementById("id_pais")) {
		var select = document.getElementById('id_pais');
		console.log(' selecciono pais .. ');
		select.addEventListener('change', function () {
				var selectedOption = this.options[select.selectedIndex];
				console.log(selectedOption.value + ': ' + selectedOption.text);
				
				$('#dni').val('');
				$('#nombre').val('');
				$('#ap_pa').val('');
				$('#ap_ma').val('');

				$('#api_dni').val('');
				$('#api_nombre').val('');
				$('#api_ap_pa').val('');
				$('#api_ap_ma').val('');
				document.getElementById("dni").disabled=false;							

				
				// quitamos atributos para agrgarlos mas abajo nuevamente y evotar error
				document.getElementById("dni").removeAttribute('maxLength');
				document.getElementById("dni").removeAttribute('minLength');

				if(selectedOption.value == "1"){ // si selecciona peru
					console.log(" seleciono peru, filtramos por dni .. ");
					$('.btn_buscar_dni').removeClass('hide');
					
					document.getElementById("dni").minLength=8; // limitados a 8
					document.getElementById("dni").maxLength=8; // limitados a 8
					document.getElementById("field_client").disabled=true;							

				}else{ // si otros paises
					$('.btn_buscar_dni').addClass('hide');
					document.getElementById("dni").minLength=8; // limitados a 8
					document.getElementById("dni").maxLength=13; // limitados a 8
					// document.getElementById('fecha_inicio').value="";
					document.getElementById("field_client").disabled= false; // libero para registro manual 
					document.getElementById("dni").disabled=false;							
					document.getElementById("nombre").disabled=false;							
					document.getElementById("ap_pa").disabled=false;							
					document.getElementById("ap_ma").disabled=false;							
										
				}
		});
} // end id_pais 

</script>	



<script>
var link = "suscriptores";/*la s final se agrega en js fuctions*/
var mypage = "suscriptores.php";
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

	if( (isset($_GET['criterio_usu_per']) && !empty($_GET['criterio_usu_per'])) || (!empty($_GET['fechabus_1']) && !empty($_GET['fechabus_2'])) ){

	$array= array();
	$meses=array('Jan'=>'Enero','Feb'=>'Febrero','Mar'=>'Marzo','Apr'=>'Abril','May'=>'Mayo','Jun'=>'Junio','Jul'=>'Julio','Aug'=>'Agosto','Sep'=>'Septiembre','Oct'=>'Octubre','Nov'=>'Noviembre','Dec'=>'Diciembre');
		
	$sql.= "SELECT c.*,YEAR(c.fecha_registro) as anho, MONTH(c.fecha_registro) as mes, e.nombre AS estado, CONCAT(c.nombre,' ',c.ap_pa,' ',c.ap_ma) as suscritos, CONCAT(c.ap_pa,' ',c.ap_ma) as apellidos, esp.titulo as espe, pa.nombre as pais , can.titulo as canal, u.nomusuario as usuariox   
		FROM suscritos c 
		INNER JOIN estado e ON c.estado_idestado=e.idestado  
		LEFT JOIN usuario u ON c.idusuario=u.idusuario   
		LEFT JOIN canales can ON c.id_canal=can.id_canal  
		LEFT JOIN especialidades esp ON c.id_especialidad=esp.id_especialidad 
		LEFT JOIN paises pa ON c.id_pais= pa.id_pais  
		where e.idestado=c.estado_idestado 
		";
			
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
	
	if(!empty($_GET['idusuario']) ) {
			$sql .= " AND c.idusuario='".$_GET['idusuario']."'  ";		
	}

	if(!empty($_GET['id_especialidad']) ) {
			$sql .= " AND c.id_especialidad='".$_GET['id_especialidad']."'  ";		
	}
	if(!empty($_GET['id_canal']) ) {
			$sql .= " AND c.id_canal='".$_GET['id_canal']."'  ";		
	}

	if(!empty($_GET['registro_desde']) ) {
		if( $_GET['registro_desde'] =='199' ) {  // 199 es NULO:: venta manual
			$sql .= " AND c.registro_desde is NULL  ";	

		}else if( $_GET['registro_desde'] =='200' ) {  // ver que asigno algoritmo 
			$sql .= " AND c.registro_desde is not NULL  AND c.registro_desde != 1   AND c.registro_desde != 2  ";	

		}else{
			$sql .= " AND c.registro_desde='".$_GET['registro_desde']."'  ";	

		}	
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
  $paging->pagina_proceso="suscriptores.php";
?>
	<div class="table-responsive">
		<table id="example1" class="table table-bordered table-striped">

<?php 		
if($_SESSION["visualiza"]["idtipo_usu"] ==1){ 
		 /*  Fechas para excel */ 
			$fecha_excel_inicio= !empty($_GET["fechabus_1"])?$_GET["fechabus_1"]:fecha_hora(1); 
?>
		<input type="hidden" name="sql_excel" id="sql_excel" value="<?php echo $sql; ?>">
		<a href="javascript:fn_exportar('tipo_form=1&fecha_filtro_inicio=<?php echo $fecha_excel_inicio;?>&fecha_filtro_fin=<?php echo $_GET["fechabus_2"];?>','suscriptores');" class="btn btn-primary"  > Excel [aplicando filtros]</a>				
<?php } ?>

			<tbody id="sort">

<?php  $i=0;
	// echo  'cc'.$_GET['registro_desde'];

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
					<th  class="sort cnone" width="90">Fecha</th>
					<th class="sort cnone" width="90">DESDE</th>
					<th class="sort  cnone " width="90">USUARIO</th>
					<?php 	if( $_SESSION["visualiza"]["idtipo_usu"] ==1 ){  ?>
					<th width="90" class="sort cnone" >ATENDIDO</th>
					<?php }  ?>

					<!-- 
					<th class="sort cnone">DESDE</th>
					-->
					<th class="sort cnone">PAÍS</th>
					<th class="sort cnone">CANAL</th>
					<th class="sort cnone">ESPECIALIDAD</th>
					<th class="sort cnone">EMAIL</th>
					<th class="sort cnone">Nombre</th>
					<th class="sort cnone">APE</th>
					<th class="sort  ">DNI</th>
					<th class="sort  ">CEL</th>
					<th class="sort  cnone ">ESTADO</th>
					<th class="unafbe "  	<?php if( $_SESSION["visualiza"]["idtipo_usu"] !=4 ){  echo ' width="305"';}else{ echo ' width="180"';} ?>  >Opciones</th>
				</tr>
<?php }//if meses ?>
				<tr>
					<td><?php echo !empty($detalles['fecha_registro']) ? date('d',strtotime($detalles['fecha_registro'])) : '...'; ?></td>
					<td class="sort cnone"><?php echo $detalles['fecha_registro']; ?></td>
					 
					<td class="sort cnone" ><?php 
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
					
					<td class=" cnone "><?php echo $detalles["usuariox"]; ?></td>
					<?php 	if( $_SESSION["visualiza"]["idtipo_usu"] ==1 ){ 
									if( !empty( $detalles["fecha_atencion_algoritmo"] )  ){  ?>
														<td class=" cnone "><?php echo $detalles["fecha_atencion_algoritmo"]; ?></td>

														<?php 
									}else{
											echo "<td class=' cnone' >aun_no_atendito </td>";
									}

					?>

					<?php 	}   ?>

					<td class="sort cnone" ><?php echo $detalles["pais"]; ?></td>
					<td class="sort cnone" ><?php echo $detalles["canal"]; ?></td>
					<td class="sort cnone"><?php echo $detalles["espe"]; ?></td>
					<td class="sort cnone"><?php echo $detalles["email"]; ?></td>
					<td class="sort cnone"><?php echo $detalles["nombre"]; ?></td>
					<td class="sort cnone"><?php echo $detalles["apellidos"]; ?></td>
					<td><?php echo $detalles["dni"]; ?></td>
					<td><?php echo $detalles["telefono"]; ?></td>
					<td class=" cnone  "><a href="javascript: fn_estado('<?php echo $detalles["id_suscrito"]; ?>')"><?php echo $detalles["estado"]; ?></a></td>
					<td class=" listado_btn_suscritos ">
						<div class="btn-eai btr  text-center opc_listado_suscritos"  >
						<!-- 
							-->
							<a href="<?php echo 'index.php?page=suscriptores&task=edit&id_suscrito='.$detalles["id_suscrito"]; ?>" title="Editar suscrito" style="color:#fff;"> editar</a>

				<?php $nombre_completo=$detalles['dni'].' - '.$detalles['nombre'].' '.$detalles['ap_pa'].' '.$detalles['ap_ma'].' - tel: '.$detalles['telefono']; ?>
							<button type="button" class="btn btn-primary llama" data-toggle="modal" data-target="#exampleModal"  data-id_suscrito="<?php echo $detalles['id_suscrito']; ?>" data-whatever="@mdo" data-titulo="<?php echo $nombre_completo; ?> ">reg segui</button>
					
							<?php 	if( $_SESSION["visualiza"]["idtipo_usu"] ==1 ){  ?>
								<a style="color:#fff;" href="index.php?page=kardex_clientes&id_suscrito=<?php echo $detalles['id_suscrito']; ?>&module=Alumnos&parenttab=AulaVirtual" title="ver seguimiento">ver  segui</a>
							<?php 	}  ?>

			
	<?php 	if( $_SESSION["visualiza"]["idtipo_usu"] !=4 ){  ?>
		
							<a style="color:#fff;" href="index.php?page=suscritos_lista_de_cursos&id_suscrito=<?php echo $detalles['id_suscrito']; ?>&module=Alumnos&parenttab=AulaVirtual" title="ver cursos"> cursos</a>
							<a style="color:#fff;" href="index.php?page=suscriptores_certificados&id_suscrito=<?php echo $detalles['id_suscrito']; ?>&module=Alumnos&parenttab=AulaVirtual" title="Certificados"> certifi</a>
							<a style="color:#fff;" href="index.php?page=suscriptores_certificados_solicitados&id_suscrito=<?php echo $detalles['id_suscrito']; ?>&module=Alumnos&parenttab=AulaVirtual" title="Certificados"> certifi sol</a>
							
							<a style="color:#fff;" href="index.php?page=libros_vendidos&id_suscrito=<?php echo $detalles['id_suscrito']; ?>&module=Alumnos&parenttab=AulaVirtual" title="Certificados"> libros</a>
		<?php 
		// if($_SESSION["visualiza"]["idtipo_usu"] ==1){
			?>

							<a href="javascript: fn_eliminar('<?php echo $detalles["id_suscrito"]; ?>')" style="color:#fff;background:red;" title="Eliminar cliente"><i class="fa fa-trash-o"></i></a>
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
					<td></td>
					<td></td>
					<td >Fecha modifico: </td>
					<td><?php echo $detalles["fecha_modifico"]; ?> </td>
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
	</div> <!-- *end tabla repsonsuve  -->
            <div class="pagination"><?php echo $paging->fetchNavegacion(); ?></div>
<script>
$(function(){
  // reordenar('suscriptores.php');
  checked();
  // sorter();
});
</script>

<?php 
	}else{
		echo "<h3 class='text-center' style='padding:30px 0;'>Buscar el cliente por DNI o telefono ejemplo: ( +51987654321 )</h3>";
	}


}else{ ?>
        <div class="box-body">
          <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
            <form action="javascript: fn_buscar();" id="frm_buscar" name="frm_buscar">
              <div class="bg-gray-light">
                <div class="col-sm-12" style="padding-bottom:20px;">
									<div class="col-sm-2">
										<div class="btn-eai">
											<a href="<?php echo $link."&task=new"; ?>" title="Registrar / Agregar" style="color:#fff;"><i class="fa fa-file" style="padding-right:5px;"></i>Agregar cliente</a>

										 <!--
												<a href="javascript:fn_exportar('tipo_form=1');" style="color:#fff;"><i class="fa fa-file-excel-o"></i> excel</a>
											-->                    
										</div>
									</div>

									<div class="col-sm-4  criterio_buscar">                  
										<?php create_input('text','criterio_usu_per','',"form-control pull-right",$table,"placeholder='Buscar por nombre, apellidos, dni, teléfono..'"); ?>
									</div>
									
									<div class="col-sm-6 criterio_mostrar">
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
			 <?php 		if( $_SESSION["visualiza"]["idtipo_usu"] !=4 ){ ?>
  
								<div class="col-sm-2  criterio_buscar">                  
										<?php crearselect("id_especialidad","select * from especialidades where estado_idestado=1 order by titulo asc",'class="form-control" ',$usuario["id_especialidad"],"-- especialidad--"); ?>   
								</div>
								<div class="col-sm-2  criterio_buscar">                  
										<?php crearselect("id_canal","select * from canales where estado_idestado=1 order by titulo asc",'class="form-control" ',$usuario["id_canal"],"-- canales --"); ?>   
								</div>
								<div class="col-sm-2  criterio_buscar">                  
										<?php crearselect("id_pais","select * from paises where estado_idestado=1 order by nombre asc",'class="form-control" ',$usuario["id_pais"],"--  pais -- "); ?>   
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
var link = "suscriptore";/*la s final se agrega en js fuctions*/
var us = "suscriptor";/*sirve para mensaje en ventana eliminar*/
var l = "o";
var l2 = "e";/* est+ _ x {e,a,o ,etc}sirve para mensaje en ventana eliminar*/
var pr = "El";
var ar = "al";
var id = "id_suscrito";
var mypage = "suscriptores.php";
</script>
<?php } ?>