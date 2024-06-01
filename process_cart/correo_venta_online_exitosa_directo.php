<?php 
/* correos */
/* correos */
/* correos */  		 
//Preparamos el mensaje de contacto
$email_venta="informes@".$dominio;
$mi_email_reply="noresponder@educaauge.com";

// $email_venta="no-reply@".$dominio;
$mi_email="noresponder@educaauge.com";


//para EMPRESA
$cabeceras  = "From: COMPRAS - GRUPO AUGE  <$email> \n" . "Reply-To: $email\n";
$cabeceras .= 'MIME-Version: 1.0' . "\r\n";
$cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
$email_to =$email_venta;

//para clietne
$cabeceras_cli  = "From: COMPRAS - ".$dominio." <$mi_email_reply> \n" . "Reply-To: $mi_email_reply\n";
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

if( !empty($_POST["id_curso"]) ){//detalle del pedido
	
		$nproduct=executesql("select * from cursos where id_curso='".$_POST['id_curso']."' ");
		 $contenido.='
		<div style="width:100%;float:left;padding:20px 15px;margin:0;"><a >										
					<figure style="display:inline-grid;padding-right:30px;height: 100px;"><img src="'.$url.'/tw7control/files/images/cursos/'.$nproduct[0]["imagen"].'" style="height: 100px;padding-right: 8px;"></figure> 
					<div style="display:inline-block;">
						<blockquote style="margin:2px 0 7px;font-weight: bold;line-height: inherit;color: #ca3a2b !important;">'.$nproduct[0]["titulo"].'</blockquote>
						<p style="font-size: 14px;padding: 1px 0;color:#333;margin:2px 0;">Cantidad: <span style="float: right;font-weight: 800;">'.$row['cantidad'].'</span></p>
						<p style="font-size: 14px;padding: 1px 0;color:#333;margin:2px 0;">Precio: <span style="float: right;font-weight: 800;">s/ '.$row['precio'].'</span></p>
						<p style="font-size: 14px;padding: 1px 0;color:#333;margin:2px 0;">Subtotal: <span style="float: right;font-weight: 800;">s/ '.$row['precio']*$row['cantidad'].'</span></p>												
					</div>  

					<div style="max-width:600px;padding:0px 15px 20px;margin:0 auto">
						<p style="padding:15px 0">  </p>
						<a href="'.$nproduct[0]["link_grupo_wasap"].'" style="padding:15px 20px;background:green;color:#fff;font-size:19px;text-decoration:none;border-radius:8px;margin-top:30px" target="_blank"> 
							Únete a nuestro grupo de whastapp del curso <b>aquí </b>
						</a>
						<p style="padding:20px 0"> </br> </p>
					</div>				
		</a></div>';
			
}

$contenido.=""  
. " <p style='font-size: 15px'><br><br><br> Numero de Articulos: ".$_POST["articulos"]."<br> "
. " -------------------------- <br> "
. " SubTotal: s/".$_POST["subtotal"]." <br> "
. " --------------------------<br> ";

if(!isset($_POST['codreferencia']) && empty($_POST['codreferencia'])){
$contenido.= " DCTO  %10 por compra online: ".($_POST["total"]*0.1)."<br>";
}


$contenido.= " --------------------------<br><br> "
." Monto Total: s/".$_POST["total"]." <br></br>"
. " -------------------------- <br><br><br></br></br> </p>" 
. " <p style='padding: 15px 20px;background:#ca3a2b;color:#fff;font-size:19px';> TOTAL: <strong>S/".$_POST["total"]."</strong> </p><br><br> 
	<p style='font-size: 15px'>
";

if(!isset($_POST['codreferencia']) && empty($_POST['codreferencia'])){
$contenido.=" ******************************************<br><strong> Tu compra sera revisada y de estar todo conforme sera aprobada en unos minutos </strong><br> ******************************************<br><br><br></br> ";
}
$contenido.=" <br><br></br> "
. " Gracias por realizar tu compra mediante nuestro portal <a href='".$url."' target='_blank'>".$dominio."</a></br>"
. "</p>";

$contenido.='</div>
<p style="font-size: 12px">&nbsp;</p>
<p style="font-size: 14px">Ante cualquier duda, les invitamos a ponerse en comunicaci&oacute;n con nosotros.<br><br>Saludos cordiales,<br>- El Equipo '.$dominio.'<br><br><br><strong>DATOS DE CONTACTO:</strong> <br><strong>Correo:</strong> <a href="mailto:informes@'.$dominio.'" rel="noreferrer">informes@'.$dominio.' </a><br><strong>Cel:</strong> +51 957 668 571<br><strong>WhatsApp:</strong> <a href="https://api.whatsapp.com/send?phone=51957668571&amp;text=Hola%'.$dominio.', tengo una consulta sobre .." target="_blank" rel="noreferrer">'.$wsp.'</a></p> 
</div> ';
 
/* end correos */
/* end correos */
	
	?>