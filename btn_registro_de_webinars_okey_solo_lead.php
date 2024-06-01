<?php include_once("auten.php");

$url = 'https://'.$_SERVER['SERVER_NAME'].''.( ($_SERVER['SERVER_NAME'] == 'localhost') ? ':88/mori/tuweb7/w2019/withlove/' : '/' );

$_POST['action']=isset($_POST['action'])?$_POST['action']:'';
$rpta = 2;/*si es error*/


if($_POST['action']=='registro'){

@$webinar    = utf8_decode(addslashes($_POST['webinar']));
@$nombre    = utf8_decode(addslashes($_POST['nombre_completo']));
@$email     = utf8_decode(addslashes($_POST['email']));
@$telefono  = utf8_decode(addslashes($_POST['telefono']));

// @$tipo     = utf8_decode(addslashes($_POST['tipo']));

$mi_email="noresponder@educaauge.com";
$nombre_empresa="EDUCA AUGE ";


/*Para Empresa*/
$cabeceras_emp  = "From: ".$nombre_empresa." <$mi_email> \n"
. "Reply-To: $mi_email\n";
$cabeceras_emp .= 'MIME-Version: 1.0' . "\r\n";
$cabeceras_emp .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
$asunto_emp     = " Registrado correctamente  -  ".$webinar;
$email_to_emp   = $mi_email;
$contenido_emp  = "
<p> Nuevo Usuario Registrado <br />
Nombre: ".$nombre."<br />
Email: ".$email."<br /><br /></p>
<p>* Recomendamos, que proceda a contartar con este nuevo usuario.</p>

";




/*Para Client*/
$cabeceras  = "From: ".$nombre_empresa." <$mi_email> \n"
. "Reply-To: $mi_email\n";
$cabeceras .= 'MIME-Version: 1.0' . "\r\n";
$cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
$asunto     = " Registrado correctamente  -  ".$webinar;
$email_to   = $email;
$contenido  = '<p><br><br></p>
<div style="max-width: 580px; margin: 0 auto; padding: 20px 25px 60px; background: #f9f9f9"><img src="'.$url.'/img/send_email/cabezera_logo2.png"><p style="font-size: 15px"><br><br><br><strong>Hola '.$nombre.',</strong><br> Hola, registro exitoso al webinar: '.$webinar.'.<br><br>

</p>

<p style="font-size: 15px">&nbsp;</p>

<p style="font-size: 12px">&nbsp;</p>
<p style="font-size: 12px">&nbsp;</p>
<p style="font-size: 14px">Ante cualquier duda, les invitamos a ponerse en comunicaci&oacute;n con nosotros.<br><br>Saludos cordiales,<br>- El Equipo '.$nombre_empresa.'<br><br></p>
</div> ';

	$bd = new BD;
	$_POST["estado_idestado"]=1;
	$_POST['orden'] = _orden_noticia("","webinars_x_leads","");
	$_POST["fecha_registro"]=fecha_hora(2);
	$_POST["id_suscrito"]=1; /* para registro a webinar tipo 2 */

	$campos=array('id_webinar','id_suscrito',"nombre_completo","email",'telefono','fecha_registro','estado_idestado','orden');
	
	// echo var_dump($campos);
	// exit();
	

	$validate=executesql("select * from webinars_x_leads where email='".$_POST["email"]."' and id_webinar='".$_POST["id_webinar"]."' ");
	if( !empty($validate) ){
		/* ya no registro creo su sesion de ingreso */
			$_SESSION["webinar"]["rewrite"]=$_POST["rewrite"];
			$_SESSION["webinar"]["nombre"]=$_POST["nombre_completo"];
			
			$_SESSION["suscritos"]["id_suscrito"] = 1;
			$_SESSION["suscritos"]["email"] =  $_POST["email"];
			$_SESSION["suscritos"]["nombre"]=$_POST["nombre_completo"];
			
			$rpta=1;
		
	}else{
		
		// echo var_dump(arma_insert('webinars_x_leads',$campos,'POST'));
		// exit();
		
		
		/* registro */
		$insertado=$bd->inserta_(arma_insert('webinars_x_leads',$campos,'POST'));
		if( $insertado > 0){
			$_SESSION["webinar"]["rewrite"]=$_POST["rewrite"];
			$_SESSION["webinar"]["nombre"]=$_POST["nombre_completo"];
			
			$_SESSION["suscritos"]["id_suscrito"] = 1;
			$_SESSION["suscritos"]["email"] =  $_POST["email"];
			$_SESSION["suscritos"]["nombre"]=$_POST["nombre_completo"];
			
			$rpta=1;
			
			@mail($email_to_emp, $asunto_emp, $contenido_emp, $cabeceras_emp); /* empresa */
			@mail($email_to, $asunto, $contenido, $cabeceras); /* cliente */
	
			
		}
		
	}


		
			/* API INFUSUSION SOFT */
			/*
		if( isset($_SESSION["data_webinar"]["etiqueta_infusion"]) && !empty($_SESSION["data_webinar"]["etiqueta_infusion"]) ){	
				
				require_once 'vendor/autoload.php';
				require('vendor/infusionsoft/php-sdk/src/Infusionsoft/Api/ContactService.php');
				$token = file_get_contents("token/token/token.json"); //Obtiene el token del archivo (se puede cambiar a su base de datos)
				$infusionsoft = new Infusionsoft\Infusionsoft(array(
					'clientId' => 'hAgVQQ86FV2EeKZW7nhuhuI2GLnhaRnV',   
						'clientSecret' => 'sRa4sAqTDZjMI96G', 	
				));

				$_POST["fecha_registro"]=fecha_hora(1); 
				$_POST["fecha_hora"]=fecha_hora(2);
				$_POST["fecha_hoy"]=fecha_hora(2);

				// token sale del arcgivo de donde se incluye este script 
				if (!empty($token)) {
					$infusionsoft->setToken(unserialize($token)); //Establece el token que se utilizará en las llamadas
				}

				$_POST['FirstName']=$_POST['nombre_completo'];
				$_POST['StreetAddress1']='not';
				$_POST['correo']=$_POST['email'];
				// echo "aqui okey";
				
				include('inc_api_infusionsoft_webinar_modo_2.php');
			}	
			*/ 
			
			/*  END API INFUSUSION SOFT */
	
	
	
}
echo json_encode(array('rpta' => $rpta));
?>