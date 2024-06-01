<?php  header('Content-Type: text/html; charset=UTF-8');
error_reporting(E_ALL);
require("../class/Carrito.class.php");
// estos estan en class carrito 
// require("../tw7control/class/functions.php");
// require("../tw7control/class/class.bd.php"); 
require("../tw7control/class/class.upload.php");

/* Infusion*/
$tag_id_campana_shop=''; /*Infusion soft api */
$link_api='https://www.educaauge.com/process_cart/insert_bd.php'; /* pagina donde se va a utilizar el token */

require_once '../vendor/autoload.php';
require('../vendor/infusionsoft/php-sdk/src/Infusionsoft/Api/ContactService.php');
$correo_cliente_api=( isset($_SESSION["suscritos"]["id_suscrito"]) && !empty($_SESSION["suscritos"]["id_suscrito"]) )? $_SESSION["suscritos"]["email"]:'';
/* Infusion*/


// $url_completa = url_completa();
$url = 'https://'.$_SERVER['SERVER_NAME'].''.( ($_SERVER['SERVER_NAME'] == 'localhost') ? ':88/mori/tuweb7/w2019/withlove/' : '/' ); 

$_POST['action']=isset($_POST['action'])?$_POST['action']:'';
$rpta = 2;/*si es error*/
$rpta_pago="";


// $dominio="augeperu.org";
$dominio="educaauge.com";

$wsp="+51 1 7075755";
$bd=new BD; 

if($_POST['action']=='registro'){ 

if(isset($_SESSION["suscritos"]["id_suscrito"]) && !empty($_SESSION["suscritos"]["id_suscrito"])){
  $_POST["id_suscrito"]=$_SESSION["suscritos"]["id_suscrito"];
// *Add PEDidos
	$_POST['orden'] = _orden_noticia("","pedidos","");
	$_POST['estado_idestado']='1';
	$_POST['estado']='2';
	$_POST['estado_pago']=2; // por revisar
	
	$email= $_SESSION["suscritos"]["email"];
  $carrito = new Carrito();
	$_POST["envio"] = $carrito->precio_envio();

	if( isset($_POST['tipo_pago']) && $_POST['tipo_pago']=='3'){
		/* si es pago efectivo */
		$_POST["banco_pago"]='0'; //desde pago efectivo 
		
	}else{
		if(isset($_POST['codreferencia']) && !empty($_POST['codreferencia'])){ 
			$_POST['tipo_pago']='2'; 
			$_POST['estado_pago']=1; // pago directo aprobado autoamtiacamente 
			$_POST['estado']='1'; //curso habilitado directa
			// $_POST['id_envio']= (isset($_POST['idenvio']) && !empty($_POST['idenvio']) )?$_POST['idenvio']:0;	
		}else{ 
			$_POST['tipo_pago']='1';
		}
		
	}


	// if( empty($_POST['codreferencia']) &&	$_POST['tipo_pago']=='1' ){ 
	if( $_POST['tipo_pago']=='1' || $_POST['tipo_pago']=='3' ){   /* si es pago efectivo o pago con deposito */
			$_POST["subtotal"] = $carrito->precio_subtotal();
			$_POST["total"] = $carrito->precio_total();
			
			if( $_POST['tipo_pago']=='1' and $_POST["banco_pago"] !='6' ){ /* si es tipo pago DEPOSITO y si banco no fue YAPE : validamos */
				/* si es un pago offline: valido que el codigo de operacion y Banco, no esten previamente registrados.. */
				$sql_validate="select * from vouchers where id_banco='".$_POST["banco_pago"]."' and codigo_operacion='".$_POST["codigo_ope_off"]."' and estado_idestado=1 ";
				
				
				$valido_vouchers=executesql($sql_validate);
				if( !empty($valido_vouchers) ){
					/* si ya existe: error intento de fraude .. pago ya registrado anteriormente */
					$rpta_pago=5;
					$rpta=5;
					echo json_encode(array(
						'rpta' => $rpta, 
						"res" => $rpta_pago	
					));
					exit();			
				}
			} /* end validate vauchers */
		
	}else{ 		/* SI PAGO ONLINE */
		/* sino todo okey no hay problema se continua proceso */
		/* SI PAGO ONLINE */
		$_POST["subtotal"] = $carrito->precio_subtotal_online();
		$_POST["total"] = $carrito->precio_total_online();
	}
	
	

	$_POST["articulos"] = $carrito->articulos_total();
  $_POST['fecha_registro'] = fecha_hora(2);
		$_POST['hora'] = fecha_hora(0);
	//Generando - Cod venta
	$end_venta=executesql("select * from pedidos order by orden desc limit 0,1");
	// "CH".1000000.1=> sumar el ultimo valor o count mejor dicho  y sumarle 1 , luegio sumarlo con los 100000 y concatenar y listo guardar .. 
	if(!empty($end_venta)){
		$ultima_venta=$end_venta[0]["id_pedido"]+1;  
	}else{
		$ultima_venta=1;  
	}

	IF($ultima_venta<10){
		$_POST["codigo"]= "AU000000".$ultima_venta;
	}ELSE IF($ultima_venta<100){
		$_POST["codigo"]= "AU00000".$ultima_venta;
	}ELSE IF($ultima_venta<1000){
		$_POST["codigo"]= "AU0000".$ultima_venta;
	}ELSE IF($ultima_venta<10000){
		$_POST["codigo"]= "AU000".$ultima_venta;
	}ELSE IF($ultima_venta<100000){
		$_POST["codigo"]= "AU00".$ultima_venta;
	}ELSE IF($ultima_venta<1000000){
		$_POST["codigo"]= "AU0".$ultima_venta;
	}ELSE IF($ultima_venta<10000000){
		$_POST["codigo"]= "AU".$ultima_venta;
	}
	
	
	//name client
	$nclient=executesql("select * from suscritos where id_suscrito='".$_POST["id_suscrito"]."'");
	$nombre_suscritos=$nclient[0]["nombre"];
     
//Preparamos el mensaje de contacto
  $email_venta="informes@".$dominio;
	$mi_email_reply="noresponder@educaauge.com";

  // $email_venta="no-reply@".$dominio;
	$mi_email="noresponder@educaauge.com";

	
  //para Chiclayo Import
  $cabeceras  = "From: COMPRAS - GRUPO AUGE  <$email> \n" . "Reply-To: $email\n";
  $cabeceras .= 'MIME-Version: 1.0' . "\r\n";
  $cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
  $email_to =$email_venta;
  // $email_to ='miguel96_libra@hotmail.com';
	
//para clietne
  $cabeceras_cli  = "From: Pedidos - ".$dominio." <$mi_email_reply> \n" . "Reply-To: $mi_email_reply\n";
  $cabeceras_cli .= 'MIME-Version: 1.0' . "\r\n";
  $cabeceras_cli .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
  $email_to_cli = "$email";//para suscritos
  
  //cuerpo mensaje
  $asunto     =  $dominio.', tienes un  nuevo pedido';
  
  
  
$contenido  = '<p><br><br></p>
<div style="max-width: 580px; margin: 0 auto; padding: 20px 25px 60px; background: #f9f9f9"><img src="'.$url.'img/send_email/cabezera_logo2.png">
<p style="font-size: 15px"><br><br><br> Estimado(a) '.$nombre_suscritos.' <br>'.$dominio.', le hace llegar el detalle de su pedido (<strong>Cod. de Pedido:</strong>'.$_POST["codigo"].'): <br></br>
</p>

<div style="text-align:left;">';

if($carrito->get_content()){//detalle del pedido
    foreach($carrito->get_content() as $row){ //recorro carrito
			$link_linea="tuweb7.com";
      $nproduct=executesql("select * from cursos where id_curso='".$row['id']."' ");
      // $contenido.=""      
      // ."* ".$nproduct[0]["titulo"]."<br></br> "
      // ."cantidad=".$row['cantidad']."<br></br> "
      // ."precio=".$row['precio']."<br></br> " 
      // ."subtotal=".$row['precio']*$row['cantidad']."<br></br> <br></br> "; 
			
			 $contenido.='
			<div style="width:100%;float:left;padding:20px 15px;margin:0;"><a >										
						<figure style="display:inline-grid;padding-right:30px;height: 100px;"><img src="'.$url.'/tw7control/files/images/cursos/'.$nproduct[0]["imagen"].'" style="height: 100px;padding-right: 8px;"></figure> 
						<div style="display:inline-block;">
							<blockquote style="margin:2px 0 7px;font-weight: bold;line-height: inherit;color: #ca3a2b !important;">'.$nproduct[0]["titulo"].'</blockquote>
							<p style="font-size: 14px;padding: 1px 0;color:#333;margin:2px 0;">Cantidad: <span style="float: right;font-weight: 800;">'.$row['cantidad'].'</span></p>
							<p style="font-size: 14px;padding: 1px 0;color:#333;margin:2px 0;">Precio: <span style="float: right;font-weight: 800;">s/ '.$row['precio'].'</span></p>
							<p style="font-size: 14px;padding: 1px 0;color:#333;margin:2px 0;">Subtotal: <span style="float: right;font-weight: 800;">s/ '.$row['precio']*$row['cantidad'].'</span></p>												
						</div>  

						<div style="max-width:400px;padding:50px 15px 20px;margin:0 auto">
							<p style="padding:20px 0">  </p>
							<a href="'.$nproduct[0]["link_grupo_wasap"].'" style="padding:15px 20px;background:green;color:#fff;font-size:19px;text-decoration:none;border-radius:8px;margin-top:30px" target="_blank"> 
								Únete a nuestro grupo de whastapp del curso <b>aquí </b>
							</a>
							<p style="padding:20px 0"> </br> </p>
						</div>							
			</a></div>';
			
    }
  }
  
  $contenido.=""  
  . " <p style='font-size: 15px'><br><br><br> Numero de Articulos: ".$_POST["articulos"]."<br> "
  . " -------------------------- <br> "
  . " SubTotal: s/".$_POST["subtotal"]." <br> "
  . " --------------------------<br> "
  . " --------------------------<br><br> "
  . " Monto Total: s/".$_POST["total"]." <br></br>"
  . " -------------------------- <br><br><br></br></br> </p>" 
  . " <p style='padding: 15px 20px;background:#ca3a2b;color:#fff;font-size:19px';> TOTAL: <strong>S/".$_POST["total"]."</strong> </p><br><br> 
		<p style='font-size: 15px'>
	";

if(!isset($_POST['codreferencia']) && empty($_POST['codreferencia'])){
  $contenido.=" ******************************************<br>Confirmar pago mediante correo: informes@".$dominio." </br> o a los WhatsApp: <strong>".$wsp."</strong><br> ******************************************<br><br><br></br> ";
}
  $contenido.=" <br><br></br> "
  . " Gracias por realizar su pedido mediante nuestro portal <a href='".$url."' target='_blank'>".$dominio."</a></br>"
  . "</p>";

$contenido.='</div>
<p style="font-size: 12px">&nbsp;</p>
<p style="font-size: 14px">Ante cualquier duda, les invitamos a ponerse en comunicaci&oacute;n con nosotros.<br><br>Saludos cordiales,<br>- El Equipo '.$dominio.'<br><br><br><strong>DATOS DE CONTACTO:</strong> <br><strong>Correo:</strong> <a href="mailto:informes@'.$dominio.'" rel="noreferrer">informes@'.$dominio.' </a><br><strong>Cel:</strong> '.$wsp.'<br><strong>WhatsApp:</strong> <a href="https://api.whatsapp.com/send?phone=5117075755&amp;text=Hola%'.$dominio.', tengo una consulta sobre .." target="_blank" rel="noreferrer">'.$wsp.'</a></p> 
</div> ';
	

//Registramos BD
	if($carrito->get_content()){
      // echo var_dump( $carrito->get_content() );
      // exit();
      $bd=new BD;      
// *Add PEDidos
    
			

      $campos_pedido=array('tipo_pago','estado_pago','id_suscrito','codigo','envio','total','subtotal','articulos','direccion','hora','estado_idestado','fecha_registro','orden');
			if(isset($_FILES['file']) && !empty($_FILES['file']['name'])){
					$_POST['imagen'] = carga_imagen('../tw7control/files/images/comprobantes/','file','','500','500');
				$campos_pedido = array_merge($campos_pedido,array('imagen'));
			}
			
			//OFF_LINE
			if(isset($_POST['banco_pago']) && !empty($_POST['banco_pago'])){
				$campos_pedido = array_merge($campos_pedido,array('banco_pago'));
			}
			if(isset($_POST['codigo_ope_off']) && !empty($_POST['codigo_ope_off'])){
				$campos_pedido = array_merge($campos_pedido,array('codigo_ope_off'));
			}
			if(isset($_POST['fecha_pago_off']) && !empty($_POST['fecha_pago_off'])){
				$campos_pedido = array_merge($campos_pedido,array('fecha_pago_off'));
			}
			
			// $campos_pedido = array_merge($campos_pedido,array('codreferencia'));			
			if(isset($_POST['codreferencia']) && !empty($_POST['codreferencia'])){
				$campos_pedido = array_merge($campos_pedido,array('codreferencia'));
			}
			

			// echo var_dump(arma_insert("pedidos",$campos_pedido,"POST"));
			// exit();
			
      $_POST['id_pedido']=$bd->inserta_(arma_insert("pedidos",$campos_pedido,"POST"));      
			
//Detalle Pedido
       foreach($carrito->get_content() as $row){ //recorro carrito
            $_POST['orden'] = _orden_noticia("","linea_pedido","");
						$_POST['dependiente'] = 2; // por defecto que no son dependientes 
						$_POST['especialidades'] = 2; // por defecto que no son especiales 
            $_POST['id_curso']=  $row['id']; 
            $_POST['id_tipo']=  $row['id_tipo']; /* si es libro o curso, etc */
						
						$_POST['talla']='';
					 if( $_POST['id_tipo']== '9999'){ /* id_tipo::9999 => venta de un certificado */
						$_POST['talla']= '9999'; /* si es libro o curso, etc */							
					 }
					 
					 if( $_POST['id_tipo']== '7777'){ /* id_tipo::7777 => venta de un examen */
						$_POST['talla']= '7777'; /* si es libro o curso, etc */							
					 }


					/* Infusion */
					 if( $_POST['id_curso']== '555'){
							$tag_id_campana_shop=2110;	/* cod.curso 555 - */
							
					 }else if( $_POST['id_curso']== '487'){  /* Curso test: 487      */
							$tag_id_campana_shop=2110;	/* cod.curso 487 -test  - */
							
					 }else if( $_POST['id_curso']== '561'){ 
							$tag_id_campana_shop=2106;	/* cod.curso 561 - */
							
					 }else{
							$tag_id_campana_shop='';
						}
					/* Infusion */
						
						
            $_POST['cantidad']=  $row['cantidad']; 
            $_POST['precio']=  $row['precio']; 
            $_POST['subtotal']=  $row['precio']*$row['cantidad']; 
            $campos_detalle=array('id_pedido','id_curso','cantidad','precio','subtotal','talla','fecha_registro','orden','estado_idestado'); 	
			
            $bd->inserta_(arma_insert("linea_pedido",$campos_detalle,"POST"));
						
						
						if( empty($row['validez_meses']) ){
								
							$_POST['validez_meses']=  12; 
						}else{
							$_POST['validez_meses']=  $row['validez_meses']; 
							
						}
						
						
					/* si se compro un certificado, solo se registra en suscritos_x_certificasos*/
					if( $_POST['id_tipo']== '9999'){ /* id_tipo::9999 => venta de un certificado */
								// asigno cursos _x _ alumnos 
								$_POST['id_certificado']=  $row['id']; 
								$_POST['id_curso']=  $row['validez_meses']; /* solo se eusa esta varibale para venta de certificados .. */
								$_POST['orden'] = _orden_noticia("","suscritos_x_certificados","");
								
								/* validamos si ya tiene asignado el  certificado*/
								$validate_certi=executesql("select * from suscritos_x_certificados where id_certificado='".$_POST['id_certificado']."' and id_suscrito='".$_POST['id_suscrito']."' and estado_idestado=1 and estado!=3 "); /* si tiene un pago rechazado se le permite volver a pagarlo */
								if(!empty($validate_certi)){ /* si ya existe este certificado en la lista del cliente ya no lo volvemos a sgnar.. */
								}else{
									/* si no tiene este certificado asignado, lo registramos */
									$campos_compra_de_certi=array('id_suscrito','id_certificado','id_curso','id_tipo','id_pedido','precio','orden','fecha_registro','estado','estado_idestado');
									$bd->inserta_(arma_insert('suscritos_x_certificados',$campos_compra_de_certi,'POST'));
								}
								/* End validate certificado */
							
					}else if( $_POST['id_tipo']== '7777'){ /* id_tipo::7777 => venta de un examen */
								// asigno cursos _x _ alumnos 
								$_POST['id_examen']=  $row['id']; 
								$_POST['estado']=  2;  // por aprobar 
								$_POST['orden'] = _orden_noticia("","suscritos_x_examenes","");
								
								/* validamos si ya tiene asignado el  examen */
								$validate_certi=executesql("select * from suscritos_x_examenes where id_examen='".$_POST['id_examen']."' and id_suscrito='".$_POST['id_suscrito']."' and estado_idestado=1"); /* si tiene un pago rechazado se le permite volver a pagarlo */
								if(!empty($validate_certi)){ /* si ya existe este w examen en la lista del cliente ya no lo volvemos a sgnar.. */
								}else{
									/* si no tiene este examen asignado, lo registramos */
									$campos_examenes=array('id_suscrito','id_examen','id_pedido','fecha_registro','estado','estado_idestado');
									$bd->inserta_(arma_insert('suscritos_x_examenes',$campos_examenes,'POST'));
								}
								/* End validate examen */
							
					}else{ 
								/* validamos si ya tiene asignado el  curso */
								$validate_curso_existente=executesql("select * from suscritos_x_cursos where id_curso='".$_POST['id_curso']."' and id_suscrito='".$_POST['id_suscrito']."' and estado_idestado=1 and estado!=3 ");
								if(!empty($validate_curso_existente)){ /* si ya existe este curso en la lista del cliente ya no lo volvemos a asignar.. */
								}else{
									
									/* asigno cursos _x _ suscritos  */ 
									$_POST['orden'] = _orden_noticia("","suscritos_x_cursos","");
									$campos=array('id_suscrito','id_curso','id_tipo','id_pedido','orden','fecha_registro','dependiente','especialidades','validez_meses','estado','estado_idestado');
									// echo var_dump(arma_insert('suscritos_x_cursos',$campos,'POST'));
									// exit();
								
										$bd->inserta_(arma_insert('suscritos_x_cursos',$campos,'POST'));						
										
										// asigno clases por curso del _ alumnos con estado pendiente: estado:2 pendiente, 1. finalizada ..
										$_POST['orden'] = _orden_noticia("","avance_de_cursos_clases","");
										$_POST['estado_idestado']='1';
										$_POST['estado_fin']='2';
										// recorremos las clases del curso ..
										$sql_n_clase="select d.id_detalle,d.id_sesion from detalle_sesiones d 
																				INNER JOIN sesiones s  ON s.id_sesion=d.id_sesion 
																				INNER JOIN cursos c  ON c.id_curso=s.id_curso 
																				WHERE d.estado_idestado=1 and c.id_curso='". $_POST['id_curso']."' ";
										$n_clases=executesql($sql_n_clase);
										if( !empty($n_clases)){
											foreach($n_clases as $rowe){
												// recorremos y agregamos 
													$_POST['id_detalle']=$rowe['id_detalle'];
													$_POST['id_sesion']=$rowe['id_sesion'];
													$campos_avances=array('id_suscrito','id_curso','id_sesion','id_detalle','id_pedido','orden','fecha_registro','estado_fin','estado_idestado');
													$bd->inserta_(arma_insert('avance_de_cursos_clases',$campos_avances,'POST'));								
											}
										}	

										/*		los ocmento xq falla al momento de asignar especiaoidades de los cursos q  forman  parte de un pack, el de abajo inc ya esta coregio y todo okey 																	
									// ... dependientes scrip 
									include('add_cursos_dependientes.php');									
									// add especialidades --> si es que tiene .. 
									include('add_cursos_especialidades.php');
									*/

									include('../tw7control/inc/inc_cursos_dependientes_y_especialidades.php');  /* todo okey 10-08-2023 */

									
								}	/* End validate asignacion de curso  */
							
					} /* END: registrando sucritos_x_cursos */	
					
					
					/* API INFUSION */
					if( !empty($tag_id_campana_shop) &&  $_POST['tipo_pago']=='2' ){ // si es pago tarjeta y  se detecto los cursos de campaña se activa esta parte 
						$_POST['FirstName']= $nclient[0]["nombre"];
						$_POST['LastName']= $nclient[0]["ap_pa"].' '.$nclient[0]["ap_ma"];
						$_POST['StreetAddress1']=$nclient[0]["direccion"];
						$_POST['Phone1']= $nclient[0]["telefono"];
						$_POST['correo']= $_SESSION["suscritos"]["email"];
						
						$tagId_registro=2979;	
						include('../inc_api_infusion_compro_curso.php');
					}
					/* API INFUSION */
					
					
							
        } // fin foreach del  carrito.. 
// Endd linea_pedido
      $bd->close();
    }// if $carrito
    
//Enviamos el mensaje y comprobamos el resultado

		if($_POST['id_pedido']>0){
			/* Registro voucher si fue pago offline */
			if( $_POST['tipo_pago']=='1' || $_POST['tipo_pago']=='3' ){ 
				$_POST['estado_idestado']=1;
				$_POST['fecha_registro']=fecha_hora(2);
				$_POST['codigo_operacion']=$_POST["codigo_ope_off"];
				$_POST['orden'] = _orden_noticia("","vouchers","");
				$_POST['id_banco']=$_POST["banco_pago"];
				
				$campos_voucher=array('id_banco','codigo_operacion','id_suscrito','id_pedido','total','estado_idestado','fecha_registro','orden');
				$_POST['id_vouchers']=$bd->inserta_(arma_insert("vouchers",$campos_voucher,"POST"));
			}
			
			
			if(@mail($email_to_cli, $asunto, $contenido, $cabeceras_cli)){}//envio para cliente msj
			if(@mail($email_to, $asunto, $contenido, $cabeceras)){}  //envio para withlove msj
			unset($_SESSION["carrito"]);//despues de todo el proceso reinicio el carrito
			$rpta=1;
			$rpta_pago="ok";

			
			$cel_mensaje_texto= $nclient[0]["telefono"];
			include('envio_mensaje_exto_venta_okey.php'); // mensaje de texto 
		}
		
	}else{  // si no existe sesion deusuario ?>
<script type='text/javascript'>
<?php   echo "alert('Inicie sesion para poder comprar');document.location=('".$url."');"; ?>
</script>
<?php }  


}


echo json_encode(array(
	'rpta' => $rpta, 
	"res" => $rpta_pago	
));

?>
