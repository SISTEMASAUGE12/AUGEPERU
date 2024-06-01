<?php session_start();
error_reporting(0);
include_once("tw7control/class/class.bd.php"); 
include_once("tw7control/class/functions.php");

$_GET['opera'] = isset($_GET['opera']) ? $_GET['opera'] : '';

if($_GET['opera']=='face'){
	
  $rpta='no';
  $bd=new BD;
  $name='';
  if(!empty($_POST["id"])) $id_fb=$_POST['id'].' ';
  if(!empty($_POST["nombre"])) $name=$_POST['nombre'].' ';
  if(!empty($_POST["apellido"])) $ape=$_POST['apellido'];
	
  if(!empty($name)) $data = array(array('id_fb',$id_fb),'nombre',array('ap_pa',$ape));
  if(!empty($_POST["correo"])) $data = array_merge($data,array(array('email',$_POST['correo'])));
  if(!empty($_POST["imagen"])) $data = array_merge($data,array(array('imagen',$_POST['imagen'])));  
	
	if(!empty($_POST["correo"])){
		$sql = "select * from suscritos where email='".$_POST['correo']."' LIMIT 0,1";		
	}else{
		$sql = "select * from suscritos where id_fb='".$id_fb."' LIMIT 0,1";
	}
	
  $exsql = executesql($sql,0);
  if(!empty($exsql)){
		// si ya existe su registro
    if($exsql['id_suscrito'] > 0){

			$_SESSION["suscritos"]["id_suscrito"] = $exsql['id_suscrito'];			
			$_SESSION["suscritos"]["email"] = $exsql['email'];			
			$_SESSION["suscritos"]["registro_desde"]='1';

			// validamos si esta completa su información sino lo enviamos ala registro
			// es informacion sensible para hacer compras en ecommerce. 
			
			// if( empty($exsql['id_pais']) || empty($exsql['nombre']) || empty($exsql['ap_pa']) || empty($exsql['ap_ma']) || empty($exsql['telefono']) || empty($exsql['email']) || empty($exsql['dni'])  || empty($exsql['ciudad'])  || empty($exsql['direccion'])   ){
			
			if( empty($exsql['nombre']) || empty($exsql['dni']) || empty($exsql['telefono']) || empty($exsql['email'])  || empty($exsql['id_especialidad'])   ){
				$rpta = 'completar_datos';
			}else{
				$rpta = 'ya_existe'; 
			}
			
			/* SI ya existe agrego las etiquetas del webinar */
			
				
			/* API INFUSUSION SOFT */
			/* ID CATE: 28 --> EDUCACAUGE */
			/* ID TAG: 2100 --> REG. COMUN  EDUCACAUGE ******************  */
				
				require_once 'vendor/autoload.php';
				require('vendor/infusionsoft/php-sdk/src/Infusionsoft/Api/ContactService.php');
				$token = file_get_contents("token/token/token.json"); //Obtiene el token del archivo (se puede cambiar a su base de datos)

				$_POST["fecha_registro"]=fecha_hora(1); /* solo fecha */
				$_POST["fecha_hora"]=fecha_hora(2);
				$_POST["fecha_hoy"]=fecha_hora(2);

				/* Establece su información de conexión */
				$infusionsoft = new Infusionsoft\Infusionsoft(array(
					'clientId' => 'hAgVQQ86FV2EeKZW7nhuhuI2GLnhaRnV',   
						'clientSecret' => 'sRa4sAqTDZjMI96G', 	
				));

				/* token sale del arcgivo de donde se incluye este script */
				if (!empty($token)) {
					$infusionsoft->setToken(unserialize($token)); //Establece el token que se utilizará en las llamadas
				}

				$tagId=2100;	
				$_POST['FirstName']=$exsql['nombre'];
				$_POST['LastName']=$exsql['ap_pa'].''.$exsql['ap_ma'];
				$_POST['StreetAddress1']='not';
				$_POST['Phone1']=$exsql['telefono'];
				$_POST['correo']=$exsql['email'];
				include('inc_generar_add_tag_webinar_clientes_ya_registrados_api_infusionsoft.php');
				
			/*  END API INFUSUSION SOFT */
					
		}	/* end if */
		
  }else{
		// si es usuario nuevo..
		$_POST['registro_desde']='1'; /* reg. con facebook */  
    $data = array_merge($data,array(array('estado_idestado',1)));
    $_POST['orden'] = _orden_noticia('','suscritos','');
    $_POST['fecha_registro'] = fecha_hora(2);
		// registro 
    $id_suscrito=$bd->inserta_(arma_insert('suscritos',array_merge($data,array('fecha_registro','orden','registro_desde')),'POST'));
    if($id_suscrito > 0){ 
			// creo sesion id_suscrito
      // $_SESSION['loginredes'] = $_SESSION["suscritos"]["id_suscrito"]  = $id_suscrito;
      // $_SESSION['loginredes'] =  $id_suscrito;
     
			$_SESSION["suscritos"]["id_suscrito"]=  $id_suscrito;
			$_SESSION["suscritos"]["email"]=  $_POST['correo'];
			$_SESSION["suscritos"]["registro_desde"]='1';

			
			
      // $rpta = 'ok';
      $rpta = 'completar_datos';
		}
  }

include('process_cart/webinar_registro_de_clientes_x_webinar_leads.php');/* registro clientes a los webinars */
include('process_cart/registro_a_cursos_gratis.php');  /* registro a cursos gratis mediante landing pages */

	
if( isset($_SESSION["webinar"]["rewrite"]) && !empty($_SESSION["webinar"]["rewrite"]) ){
		$link_go='webinar/'.$_SESSION["webinar"]["rewrite"];
		
// }else if( isset($_SESSION["url"]) && $_SESSION["url"]=="cesta" ){
		// $link_go='cesta';

}else if( isset($_SESSION["curso_gratis"]["rewrite"]) && !empty($_SESSION["curso_gratis"]["rewrite"]) ){
		$link_go='gratis/'.$_SESSION["curso_gratis"]["rewrite"];
		
		
}else if( isset($_SESSION["url"]) &&  !empty($_SESSION["url"]) ){
		$link_go=$_SESSION["url"];
	
}else{
	$link_go="mis-cursos";
}



	  // echo  $rpta;
	echo json_encode(array(    
    "res" => $rpta ,
    "link_go" => $link_go 
  )); 
	

}
?>