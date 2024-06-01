<?php /* correos */	 
$dominio="educaauge.com";
$email_venta="informes@".$dominio;
$mi_email_reply="noresponder@educaauge.com";

//para clietne
$cabeceras_cli  = "From: VALIDA TUS DATOS - GRUPO AUGE  - ".$dominio." <$mi_email_reply> \n" . "Reply-To: $mi_email_reply\n";
$cabeceras_cli .= 'MIME-Version: 1.0' . "\r\n"; $cabeceras_cli .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
$email_to_cli = $nclient[0]["email"];//para suscritos

//cuerpo mensaje
$asunto     =  $dominio.', tienes un  nuevo pedido';
$contenido  = '<p><br><br></p>
<div style="max-width: 580px; margin: 0 auto; padding: 20px 25px 60px; background: #f9f9f9"><img src="https://www.'.$dominio.'/img/send_email/cabezera_logo2.png">
<p style="font-size: 15px"><br>Estimado(a) '.$nclient[0]["nombre"].' <br>'.$dominio.', le hace llegar los datos que se emplearan en su certificado, para su validación de estar todo correcto o dar click en editar si fuera necesario. <br></br>
</p>
<div style="text-align:left;">';

/*
$contenido.='
<div style="width:100%;float:left;padding:20px 15px;margin:0;"><a >														
<div style="display:inline-block;">
	<p style="font-size: 14px;padding: 1px 0;color:#333;margin:2px 0;">NOMBRE: <span style="float: right;font-weight: 800;">'.$_POST['api_nombre'].'</span></p>
	<p style="font-size: 14px;padding: 1px 0;color:#333;margin:2px 0;">AP. PATERNO: <span style="float: right;font-weight: 800;">'.$_POST['api_paterno'].'</span></p>
	<p style="font-size: 14px;padding: 1px 0;color:#333;margin:2px 0;">AP. MATERNO: <span style="float: right;font-weight: 800;"> '.$_POST['api_materno'].'</span></p>
	
	<p style="font-size: 14px;padding: 1px 0;color:#333;margin:2px 0;">DPTO:: <span style="float: right;font-weight: 800;"> '.$_POST['dpto'].'</span></p>
	<p style="font-size: 14px;padding: 1px 0;color:#333;margin:2px 0;">PROVINCIA: <span style="float: right;font-weight: 800;"> '.$_POST['provincia'].'</span></p>
	<p style="font-size: 14px;padding: 1px 0;color:#333;margin:2px 0;">DISTRITO: <span style="float: right;font-weight: 800;"> '.$_POST['distrito'].'</span></p>
	
	<p style="font-size: 14px;padding: 1px 0;color:#333;margin:2px 0;">DIRECCIÓN: <span style="float: right;font-weight: 800;"> '.$_POST['direccion'].'</span></p>
	<p style="font-size: 14px;padding: 1px 0;color:#333;margin:2px 0;">AGENCIA: <span style="float: right;font-weight: 800;"> '.$_POST['agencia'].'</span> <br></br> </p>											
</div>  					
</a></div>';
*/

$contenido.='
<div style="width:100%;float:left;padding:20px 15px;margin:0;"><a >														
<div style="display:inline-block;">
	<p style="font-size: 14px;padding: 1px 0;color:#333;margin:2px 0;">DNI/CÉDULA: <span style="float: right;font-weight: 800;">'.$_POST['dni'].'</span></p>
	<p style="font-size: 14px;padding: 1px 0;color:#333;margin:2px 0;">NOMBRE: <span style="float: right;font-weight: 800;">'.$_POST['api_nombre'].'</span></p>
	<p style="font-size: 14px;padding: 1px 0;color:#333;margin:2px 0;">AP. PATERNO: <span style="float: right;font-weight: 800;">'.$_POST['api_paterno'].'</span></p>
	<p style="font-size: 14px;padding: 1px 0;color:#333;margin:2px 0;">AP. MATERNO: <span style="float: right;font-weight: 800;"> '.$_POST['api_materno'].'</span></p>
		
</div>  					
</a></div>';

$contenido.= " <div style='max-width:400px;padding:50px 15px 20px;margin:0 auto;' >
<p style='padding:20px 0;'> </br> </p>

<a href='https://www.educaauge.com/approbeseguimiento/".$_POST["id_suscrito"]."/".$id_seguimiento."' style='padding: 15px 20px;background:green;color:#fff;font-size:19px;text-decoration: none;
border-radius: 8px;margin-top:30px;'> 
	Click para aprobar datos 
</a>
<p style='padding:20px 0;'> ó </p>
<br></br> 
<a href='https://www.educaauge.com/updateseguimiento/".$_POST["id_suscrito"]."/".$id_seguimiento."' style='padding: 15px 20px;background:red;color:#fff;font-size:19px;text-decoration: none;
border-radius: 8px;margin-top:30px;' >
	 Click para <b>actualizar</b> datos 
</a>
</div> ";

$contenido.='</div>
<p style="font-size: 12px">&nbsp;</p>
<p style="font-size: 14px">Ante cualquier duda, les invitamos a ponerse en comunicaci&oacute;n con nosotros.<br><br>Saludos cordiales,<br>- El Equipo '.$dominio.'<br><br><br></p> 
</div> ';
 
if(@mail($email_to_cli, $asunto, $contenido, $cabeceras_cli)){
	echo "<script>alert('Se envio un correo al cliente para la validación de los datos!');</script>";
}else{
	echo "<script>alert('*Error en envio de correo de validación a cliente!');</script>";

}//envio para cliente msj
/* end correos */	?>