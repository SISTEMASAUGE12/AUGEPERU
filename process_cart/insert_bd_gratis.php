<?php  header('Content-Type: text/html; charset=UTF-8');
error_reporting(E_ALL);
require("../class/Carrito.class.php");
// estos estan en class carrito 
// require("../tw7control/class/functions.php");
// require("../tw7control/class/class.bd.php"); 


// $url_completa = url_completa();
$url = 'https://'.$_SERVER['SERVER_NAME'].''.( ($_SERVER['SERVER_NAME'] == 'localhost') ? ':88/mori/tuweb7/w2019/withlove/' : '/' ); 

$_POST['action']=isset($_POST['action'])?$_POST['action']:'';
$rpta = 2;/*si es error*/
$rpta_pago="";

// $dominio="augeperu.org";
$dominio="educaauge.com";

$wsp="+51 1 7075755";

if($_POST['action']=='suscripcion_gratuita'){ 

if(isset($_SESSION["suscritos"]["id_suscrito"]) && !empty($_SESSION["suscritos"]["id_suscrito"])){
  $_POST["id_suscrito"]=$_SESSION["suscritos"]["id_suscrito"] ;	
  $email= $_SESSION["suscritos"]["email"];
  $_POST['fecha_registro'] = fecha_hora(2);
  $_POST['hora'] = fecha_hora(0);
  $_POST['id_pedido'] = '000';
  $_POST['gratis'] = 1;
  $_POST['estado_idestado'] = 1; // entra aprovado directo, curso gratis 
  $_POST['estado'] = 1; // entra aprovado directo, curso gratis 
	
//name client
$nclient=executesql("select * from suscritos where id_suscrito='".$_POST["id_suscrito"]."'");
$nombre_suscritos=$nclient[0]["nombre"];
     
//Preparamos el mensaje de contacto
  $email_venta="ventas@".$dominio;
		$mi_email_reply="noresponder@educaauge.com";

  //para Chiclayo Import
  $cabeceras  = "From: Suscripcion gratuita - GRUPO AUGE  <$email> \n" . "Reply-To: $email\n";
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
  $asunto     =  $dominio.', nueva suscripcion gratuita ';
  
  
  
$contenido  = '<p><br><br></p>
<div style="max-width: 580px; margin: 0 auto; padding: 20px 25px 60px; background: #f9f9f9"><img src="'.$url.'/img/send_email/cabezera_logo2.png">
<p style="font-size: 15px"><br><br><br> Estimado(a) '.$nombre_suscritos.' <br>, te haz suscrito exitosamente al curso.  <br></br>
</p>

<div style="text-align:left;">';

$contenido.='</div>
<p style="font-size: 12px">&nbsp;</p>
<p style="font-size: 14px">Ante cualquier duda, les invitamos a ponerse en comunicaci&oacute;n con nosotros.<br><br>Saludos cordiales,<br>- El Equipo '.$dominio.'<br><br><br><strong>DATOS DE CONTACTO:</strong> <br><strong>Correo:</strong> <a href="mailto:ventas@'.$dominio.'" rel="noreferrer">ventas@'.$dominio.' </a><br><strong>Cel:</strong> xxxx | xxxx <br><strong>WhatsApp:</strong> <a href="https://api.whatsapp.com/send?phone=5117075755&amp;text=Hola%'.$dominio.', tengo una consulta sobre .." target="_blank" rel="noreferrer">'.$wsp.'</a></p> 
</div> ';
	

//Registramos BD      
		$bd=new BD;      
		// asigno cursos _x _ alumnos con estado pendiente: estado:2 pendiente,
		$_POST['orden'] = _orden_noticia("","suscritos_x_cursos","");
		$campos=array('id_suscrito','id_curso','id_pedido','gratis','orden','fecha_registro','validez_meses','estado','estado_idestado');
		$_POST['ide']=$bd->inserta_(arma_insert('suscritos_x_cursos',$campos,'POST'));
		
		
		// asigno clases por curso del _ alumnos con estado pendiente: estado:2 pendiente, 1. finalizada ..
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
					$campos=array('id_suscrito','id_curso','id_sesion','id_detalle','id_pedido','orden','fecha_registro','estado_fin','estado_idestado');
					$bd->inserta_(arma_insert('avance_de_cursos_clases',$campos,'POST'));								
			}
		}
						
      $bd->close();
    
//Enviamos el mensaje y comprobamos el resultado
		if($_POST['ide']>0){		
			if(@mail($email_to_cli, $asunto, $contenido, $cabeceras_cli)){}//envio para cliente msj
			if(@mail($email_to, $asunto, $contenido, $cabeceras)){}  //envio para withlove msj
			$rpta=1;
			$rpta_pago="ok";
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
