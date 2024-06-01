<?php include_once("auten.php");

$url = 'https://'.$_SERVER['SERVER_NAME'].''.( ($_SERVER['SERVER_NAME'] == 'localhost') ? ':88/mori/tuweb7/w2019/withlove/' : '/' );
$_POST['action']=isset($_POST['action'])?$_POST['action']:'';
$rpta = 2;/*si es error*/

$_tag_blog=2920; // id tag blog de insufion 
@$nombre=$_POST["nombre_blog"];
@$email     = utf8_decode(addslashes($_POST['email_blog']));

/* 
	$bd = new BD;
	$_POST["estado_idestado"]=1;
	$_POST['orden'] = 1;
	$_POST["fecha_registro"]=fecha_hora(2);		
	$_POST["estado"]=1;
	$_POST["id_pais"]=1; // setiado a peru				
	$_POST["clave"]=md5($_POST["telefono"]);
	$_POST['id_canal']='1'; // canal::: online default  
	$_POST['registro_desde']='6'; // desde suscribete blog  	

	// registratr el cliente  	
	$validate_email=executesql("select * from suscritos where estado_idestado=1 and email='".$email."' ");
	if(!empty($validate_email) ){		
		$_POST["id_suscrito"]= $validate_email[0]['id_suscrito'];							
	}else{	
		$campos=array("nombre","telefono","email","id_pais","clave","estado",'estado_idestado','registro_desde','id_canal');
		include('process_cart/asignacion_automatica_de_cliente_a_vendedoras.php');  		// asigno vendedora automaticamnete a cada registro
		$insertado=$_POST["id_suscrito"]=$bd->inserta_(arma_insert('suscritos',array_merge($campos,array('orden','fecha_registro','hora_registro')),'POST'));
	}			
	
	if( !empty($_POST["clientes_aleatorios"]) ){ 	// si se asigno a aun avendedora aleatoria:: *sumo un asignado al usuario vendedor:  sale de include asignacion 
		$campos_vendedor=array('clientes_aleatorios');
		$bd->actualiza_(armaupdate('usuario',$campos_vendedor," idusuario='".$_POST["idusuario"]."'",'POST'));
	}


	// Registro lead:: webinar  o una tabala de susbristos al blog 
	$campos=array('id_webinar','id_suscrito',"nombre_completo","email",'telefono','fecha_registro','estado_idestado','orden');
	$validate=executesql("select * from webinars_x_leads where email='".$_POST["email"]."' and id_webinar='".$_POST["id_webinar"]."' ");
	if( !empty($validate) ){
		// ya no registro creo su sesion de ingreso 
		$rpta=1;
	}else{
		// registro 
		$insertado=$bd->inserta_(arma_insert('webinars_x_leads',$campos,'POST'));
		if( $insertado > 0){			
			$rpta=1;			
			// @mail($email_to, $asunto, $contenido, $cabeceras); // cliente 		
		}		
	}
	*/


		
	/* API INFUSUSION SOFT */		
	if( !empty($_tag_blog) ){					
		require_once 'vendor/autoload.php';
		require('vendor/infusionsoft/php-sdk/src/Infusionsoft/Api/ContactService.php');
		$token = file_get_contents("token/token/token.json"); //Obtiene el token del archivo (se puede cambiar a su base de datos)
		$infusionsoft = new Infusionsoft\Infusionsoft(array(
			'clientId' => 'hAgVQQ86FV2EeKZW7nhuhuI2GLnhaRnV',   
			'clientSecret' => 'sRa4sAqTDZjMI96G', 	
		));

		/* 
		$_POST["fecha_registro"]=fecha_hora(1); 
		$_POST["fecha_hora"]=fecha_hora(2);
		$_POST["fecha_hoy"]=fecha_hora(2);
		*/
		// token sale del arcgivo de donde se incluye este script 
		if (!empty($token)) {
			$infusionsoft->setToken(unserialize($token)); //Establece el token que se utilizará en las llamadas
		}

		$_POST['FirstName']=$_POST['nombre_blog'];
		$_POST['StreetAddress1']='not';
		$_POST['correo']=$_POST['email_blog'];
		// echo "aqui okey";

		include('inc_api_infusionsoft_suscribete_blog.php');

	?>
		<script> alert("Suscripción exitosa!");
			location.href='<?php echo $_SESSION["url"]; ?>';
		</script>
	<?php 
	}			
	/*  END API INFUSUSION SOFT */		
	
?>