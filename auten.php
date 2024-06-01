<?php error_reporting(E_ALL); session_start();
include_once("tw7control/class/functions.php");
include_once("tw7control/class/class.bd.php");
include_once("tw7control/class/PHPPaging.lib.php");

$des_keys="";
$des_meta=" ";


// $url = 'http://'.$_SERVER['SERVER_NAME'].''.( ($_SERVER['SERVER_NAME'] == 'localhost') ? '/mori/w2021/augeperu/' : '/augeperu/' );
$url = 'https://'.$_SERVER['SERVER_NAME'].''.( ($_SERVER['SERVER_NAME'] == 'localhost') ? '/mori/tuweb7/w2021/augeperu/' : '/' );


// /* para test local*/
// $_SESSION["suscritos"]["id_suscrito"]=3;
// $_SESSION["suscritos"]["email"]='luismori@tuweb7.com';
// /* end para test local*/

// echo   '==>'.$_SESSION["suscritos"]["id_suscrito"]; 


$_dominio='educaauge.com'; 
$_email_empresa='informes@educaauge.com'; 
$_num_wsp='957668571'; 
$_num_cel='957668571'; 
$_nombre_empresa=' EDUCA AUGE'; 
$link_facebook='https://web.facebook.com/educaauge';

$_num_wsp='957668571';

$_title_key="Accede a los mejores Cursos online de capacitación docente ";
$_frase_clave=" EDUCA AUGE";
$link_grupo_wasap='https://whatsapp.com/channel/0029VaFViED8V0toD7jgT30z';  // CANAL WSP  
 

//$recaptchat_public = "6LePAFApAAAAABlGgI3r7AWpPCp7OddAFDh8CMms";  // cirnaza
//$secret = "6LePAFApAAAAAL0zItJaek5QUQXlFbaz4RcHNXUS";   // crianz	a

/** ajustes / */
$ajustes =executesql("select * from ajustes order by id desc limit 0,1 "); // saco canal de wasap y otros 
if( !empty($ajustes)  && !empty($ajustes[0]["link_canal_wasap"]) ){
	$link_grupo_wasap= $ajustes[0]["link_canal_wasap"];  
}



// variable de tipo_categoria curso gratuita:
// variable de tipo_categoria curso gratuita:

$_variable_tipo_categoria_gratuita=4;   /* id categoria de curso gratis */
$fecha_hoy=fecha_hora(1);

	// unset($_SESSION["suscritos"]);
	// unset($_SESSION["webinar"]);
	
	 // unset($_SESSION["carrito"]);


if(!empty($_GET["task"])){
		if(!empty($_SESSION["suscritos"]["id_suscrito"])){
				$filtro_x_distinto_al_cliente=" and id_suscrito!='".$_SESSION["suscritos"]["id_suscrito"]."' ";
		}
		
  	if($_GET["task"] == "valida_email_suscrito"){ //registro crear clientes ..main.js
    	$consultando=executesql("select * from suscritos where email='".$_POST["envio_usuario"]."' ".$filtro_x_distinto_al_cliente);
    	echo !empty($consultando) ? 'false' : 'true';
    	exit();
  	}
	if($_GET["task"] == "valida_dni_suscrito"){ //registro crear clientes ..main.js
    	$consultando=executesql("select * from suscritos where dni='".$_POST["envio_dni_usuario"]."' ".$filtro_x_distinto_al_cliente);
    	echo !empty($consultando) ? 'false' : 'true';
    	exit();
  	}
		
		
		
		if($_GET["task"] == "cerrar_sesion" ){
/*		
		if( isset($_SESSION["suscritos"]["id_asistencia"]) && !empty($_SESSION["suscritos"]["id_asistencia"]) ){		// los q ya iniciaaron sesion antes de esto no hara efecto, hasta q se vuelvan a logear 		
				$bd=new BD;
				$bd->Begin();
				$campo_actua=array( array("estado_idestado",2), array("fecha_cierre",fecha_hora(2)) ); // cerramos la sesion en tabla asistenmcias 
				$bd->actualiza_(armaupdate('asistencia',$campo_actua," id_asistencia='".$_SESSION["suscritos"]["id_asistencia"]."'",'POST')); // fecha_cierre
				$bd->close();
			}
		*/
		$bd=new BD;

		$_POST["logeado"]=0;  // cierro su estado se logeado
		$bd->actualiza_(armaupdate('suscritos',array('logeado')," id_suscrito='".$_SESSION["suscritos"]["id_suscrito"]."'",'POST')); // fecha_cierre	
    	
		unset($_SESSION["suscritos"]);
    	header('Location:'.$url.'');
    	exit();
  	} //cerrando sesion
}


if(!empty($_SESSION["suscritos"]["id_suscrito"])){ //ide_suscrito	&& img_perfil
	
	/*
	if( !isset($_SESSION["suscritos"]["id_asistencia"]) && empty($_SESSION["suscritos"]["id_asistencia"]) ){ // sino existe sesion asistencia, cierro y obligo a que se logee
			unset($_SESSION["suscritos"]);
    	header('Location:'.$url.'');
    	exit();
	}else{  // si existe valido si es que esta activa esa sesion de asitencia capas entro en otro la do y se deshabilito entonces cerramos
			
			$valido_asistencia= executesql(" select * from asistencia where id_asistencia='".$_SESSION["suscritos"]["id_asistencia"]."' and estado_idestado=1 ");
			if( !empty($valido_asistencia) ){ // si esta activa no pasa nada
				
			}else{ // pero si esta desctivada cierro la sesion y q se loge nuevamente 		
				unset($_SESSION["suscritos"]);
				header('Location:'.$url.'');
				exit();
			}
		
	}
	
	
		08/11/2023  ==>> DESACTIVO ASISTENCIA XQ NO TIENE PRIORIDAD EN NEGOCIO
	*/
	
	
	if( $_SESSION["suscritos"]["id_suscrito"]==1 && (!empty($pagina) && $pagina=="webinar")  ){ 
		/*  ...   */
		echo "...".$_SESSION["suscritos"]["id_suscrito"];
		// exit();
		
		echo " Hola_ ".$_SESSION["suscritos"]["nombre"];
		echo " web ".$_SESSION["webinar"]["rewrite"];
		echo 'A ==>'.$pagina; 
		
	}elseif( $_SESSION["suscritos"]["id_suscrito"]==1 &&  (!empty($pagina) && $pagina!="webinar")  ){ 
		// echo 'B ==>'.$pagina; 
		// echo " Hola_ ".$_SESSION["suscritos"]["nombre"];
		// echo " web ".$_SESSION["webinar"]["rewrite"];
		// exit();
    	// header('Location:contacto');
		
		/*
			// si sale del webinar [de la pagina webinar], se elimina la session, ya que esa session es una general 
			unset($_SESSION["suscritos"]);
    	header('Location:'.$url.'');
    	exit();
			*/
			
	}else{ /* proceso comun de login cliente */
	
			// echo 'C ==>'.$pagina; 
			
			
			$ide_suscrito=$_SESSION["suscritos"]["id_suscrito"];
			$perfil=executesql("select * from suscritos where id_suscrito=".$ide_suscrito." ");
			
			$image_perfil=!empty($perfil[0]["imagen"])?'tw7control/files/images/suscritos/'.$perfil[0]["imagen"]:'img/ico-perfil.png';
			$dni_cliente=$codusuario=!empty($perfil[0]["dni"]) ? $perfil[0]["dni"] : '';
			$especialidad_del_cliente=!empty($perfil[0]["id_especialidad"]) ? $perfil[0]["id_especialidad"] : '0';
			
			if(!empty($dni_cliente) ){
					//sacar grados disponibles:
					$grados_disponibles=executesql("select * from suscritos_x_cursos where id_suscrito=".$ide_suscrito." ");
					$array='';
					if(!empty($grados_disponibles)){
						$x=0;
						foreach( $grados_disponibles as $datagrados){
							if($x==0){
								$array=$datagrados['id_curso'];
							}else{
								$array=$array.', '.$datagrados['id_curso'];
							}
							$x++;
						}
					}
					// $codgrado=$perfil[0]["id_curso"];
					//gradios disponibles del alumnos
					$codgrado=$array;
					
					/* consulta se usa para el perfill.php y coutoria .., certificaos */
					$suscri = executesql("SELECT s.*, e.titulo FROM suscritos s INNER JOIN especialidades e ON s.id_especialidad = e.id_especialidad WHERE s.id_suscrito = '".$_SESSION['suscritos']['id_suscrito']."' ");
					
			}elseif( empty($dni_cliente) || empty($especialidad_del_cliente) || empty($perfil[0]["telefono"]) || empty($perfil[0]["email"]) ){
					if( !isset($pagina) || ($pagina != "registro" && $pagina != "webinar") ){  /* sino existe pagina o es diferente a registro y en webinar que no salga esta validacion */
						// $actualicate='https://www.educaauge.com/actualiza-tus-datos/'.$_SESSION['suscritos']['id_suscrito'];
						// header('Location: '.$actualicate);
/*
			?>
			
				<div style="max-width:600px;margin:70px auto;padding:30px;text-align:center;">
					<img src="img/logo-rojo.png" style="">
					<h1 style="padding-bottom:40px;"> Completa tus datos para poder seguir navegando en Educaauge.com </h1>
					<p> Datos requeridos: Nombre y apellidos, DNI/cédula, email, telefono, <b>Especialidad</b> y e-mail (* correo) </br> Completa todos estos datos para poder comprar en la web.</p>
					<a href="https://www.educaauge.com/actualiza-tus-datos/<?php echo $_SESSION['suscritos']['id_suscrito']; ?>" style="background:red;padding:10px 15px;margin-bottom:30px;display:inline-block;color:#fff;border-radius:8px;    text-decoration: none;"> Completar datos aquí</a>
					
					<p style="padding:30px 0 10px;border-top:apx solid #333;"><b>Nota</b>: Si tu DNI/cédula ya figura como registrado por favor igresa con tu otro correo, si no te acuerdas con qué correo te has registrado, coloca tu DNI/cédula y te aparecerá tu correo correcto: </p>
					<form action="inc_consultar_correos_registrados" method="post" >
						<input name="dni" id="dni" placeholder="Ingresa tu DNI/cédula ">
						<button style="background:red;padding:10px 15px;margin-bottom:30px;display:inline-block;color:#fff;border-radius:8px;    text-decoration: none;"> Consulta tu correo aquí</button>
					</form>
					<p> </br>Si tu problema persiste envía un correo a <span class="solor-1"><a href="mailto:informes@educaauge.com"><b>informes@educaauge.com</b></a></span>  </br> 
												con el <b>Asunto: Problema Registro DNI/cédula [tu dni/cédula] </b></br> </p>
																						</p>
					<p><a href="index?task=cerrar_sesion"><img src="img/iconos/ico-cerrar-sesion.png"> Cerrar sesión</a></p>
				</div>
					
				
			<?php
						*/
						
						// exit();
					 /* si l apagina es diferente de regisro */	
					}
					
			}  /* end registro cliente sin DNI , lo enviamo a que compelte su registro . */
			
	}/* end suscrito comun: proceso normal */		
	
}else{
		$especialidad_del_cliente='';
} /* end si existe session */


$not_img="img/iconos/no-disponible.jpg";


 $login_button = '<div class="google_registro"><a id="googleSignIn" class="  btn-google poppi-sb " href="javascript:;" ><img src="img/iconos/google.png">Regístrate con google</a>  </div>';

 $login_button_ingresar = ' <div class="google_ingresar"> <a id="googleSignIn" class="  btn-google poppi-sb " href="javascript:;" ><img src="img/iconos/google.png">Ingresar con google</a></div>';


// if(!isset( $_SESSION["suscritos"]["id_suscrito"] )){
 // $login_button = '<div class="google_registro"><a id="googleSignIn" class="  btn-google poppi-sb " href="javascript:;" ><img src="img/iconos/google.png">Regístrate con google</a>  </div>';

 // $login_button_ingresar = ' <div class="google_ingresar"> <a id="googleSignIn" class="  btn-google poppi-sb " href="javascript:;" ><img src="img/iconos/google.png">Ingresar con google</a></div>';

// }else{ $login_button =""; $login_button_ingresar ="";}


if(isset($_GET['task']) && $_GET['task'] == 'cargar_prov') {
    $array=[];
    // $array = array('id' => '', 'value' => 'Seleccione');
    $sql = "select idprvc,titulo from prvc where dptos_iddpto=" . $_GET['variable'] . " order by titulo asc";
    $exsql = executesql($sql);
		$array[] = array('id' => '', 'value' => 'Seleccione provincia');
    if (!empty($exsql)) foreach ($exsql as $row) $array[] = array('id' => $row[0], 'value' => $row[1]);
    echo json_encode($array);
    exit();
		
}elseif (isset($_GET['task']) && $_GET['task'] == 'cargar_dist') {
    $array_dist=[];
    // $array_dist = array('id' => '', 'value' => 'Seleccione');
    $sql = "select iddist,titulo from dist where prvc_idprvc=" . $_GET['variable'] . " order by titulo asc";
    $exsql = executesql($sql);
		
		$array_dist[] = array('id' => '', 'value' => 'Seleccione distrito');
    if (!empty($exsql)) foreach ($exsql as $row) $array_dist[] = array('id' => $row[0], 'value' => $row[1]);
    echo json_encode($array_dist);
    exit();
}


if( isset($_GET['task']) && $_GET['task']=='cargar_sucursales'){  
	$array[] = array('id' => '', 'value' => 'Seleccione');
	$sql = "select id_sucursal, concat(nombre,' - ',direccion) as nombre from agencias_sucursales where id_agencia=".$_GET['variable']." order by nombre asc";
	$exsql = executesql($sql);
	if(!empty($exsql)) foreach($exsql as $row) $array[] = array('id' => $row[0], 'value' => $row[1]);
	echo json_encode($array);
	exit();
  }
  
  


?>