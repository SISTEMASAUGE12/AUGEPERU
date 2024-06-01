<?php 
session_start();
error_reporting(0);
require("tw7control/class/class.bd.php");
require("tw7control/class/functions.php");
echo '<html class="no-js" lang="es-ES">';
echo '<meta charset="utf-8" />';
echo '<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>';
echo '<script src="js/functions.js"></script>';
echo '<script src="js/sweetalert.min.js"></script>';
echo '<link rel="stylesheet" href="css/sweetalert.min.css">';
echo '<link rel="stylesheet" href="css/main.css">';
echo '<head>';
echo '<style type="text/css">';
echo 'body{background:#EB1F25;}';
echo '</style>';
echo '</head>';
echo '<body id="top">';
/*Campos de formulario*/
@$nombre        = utf8_decode(addslashes($_POST['nombre']));
@$apellidop = utf8_decode(addslashes($_POST['apellidop']));
@$apellidom = utf8_decode(addslashes($_POST['apellidom']));
@$tipodoc   = utf8_decode(addslashes($_POST['tipodoc']));
@$documento = utf8_decode(addslashes($_POST['documento']));
@$correo    = utf8_decode(addslashes($_POST['correo']));
@$telefono  = utf8_decode(addslashes($_POST['telefono']));
@$departamento  = utf8_decode(addslashes($_POST['dpt']));
@$provincia = utf8_decode(addslashes($_POST['prv']));
@$distrito  = utf8_decode(addslashes($_POST['dis']));
@$direccion = utf8_decode(addslashes($_POST['direccion']));
@$biencontra    = utf8_decode(addslashes($_POST['biencontra']));
@$descripcion   = utf8_decode(addslashes($_POST['descripcionbien']));
@$tiporeclamo   = utf8_decode(addslashes($_POST['tiporeclamo']));
@$detallerecla  = utf8_decode(addslashes($_POST['detallerecla']));
@$pedidoconsu   = utf8_decode(addslashes($_POST['pedidoconsu']));
$bd=new BD;
$exsql = executesql("SELECT d.titulo AS departamento_nom, p.titulo AS provi_nom, di.titulo FROM dptos d INNER JOIN prvc p ON d.iddpto = p.dptos_iddpto INNER JOIN dist di ON p.idprvc = di.prvc_idprvc WHERE di.iddist =".$distrito." AND p.idprvc = ".$provincia." AND d.iddpto =".$departamento);

if($tiporeclamo='reclamo'){ $asunto='RECLAMO'; }else{ $asunto='QUEJA'; }

//Preparamos el mensaje
$cabeceras  = "From: Libro de reclamaciones. <".$correo."> \n" //La persona que envia el correo
."Reply-To: ".$correo."\n";
$cabeceras .= 'MIME-Version: 1.0' . "\r\n";
$cabeceras .= 'Content-type: text/html; charset=utf-8' . "\r\n";

$email_to   = "informes@educaauge.com";
// $email_to   = "ing.moriayala@gmail.com";
// $email_to   = "info@augeperu.com";

$contenido  = "<p style='padding-bottom:20px;'>Se acaba de registrar una ".$asunto." a su sistema mediante la web. Revisar la informacion en el sistema web de quejas.</p>"
. "<p>"
. "Nombre: ".$apellidop." ".$apellidom." ".$nombre."<br />"
.( $tipodoc=="dni" ? "DNI: ".$documento."<br />" : "RUC: ".$documento."<br />" )
. "Email: ".$correo."<br />"
. ( !empty($telefono) ? "Tel&eacute;fono: ".$telefono."<br />" : '' )
. "Distrito: ".$exsql[0]['d_nom'].", "
. "Provincia: ".$exsql[0]['provi_nom'].", "
. "Departamento: ".$exsql[0]['departamento_nom']."<br />"
. "Dirección: ".$direccion."<br />"
. "IDENTIFICACIÓN DEL BIEN CONTRATADO<br />"
.( $biencontra=="producto" ? "Producto: ".$descripcion."<br />" : "Servicio: ".$descripcion."<br />" )
. "DETALLE DE LA RECLAMACIÓN Y PEDIDO DEL CONSUMIDOR<br />"
.( $tiporeclamo=="reclamo" ? "Reclamo <br />" : "Queja <br />" )
. "Detalle: ".$detallerecla."<br />"
. "Pedido del Consumidor: ".$pedidoconsu."<br />"
. "</p>";


    if(@mail($email_to, $asunto, $contenido, $cabeceras)){
    /* Registrar usuario */
    $clave = "";
    $longitud = 4;
    for ($i=1; $i<=$longitud; $i++){
    $numero = rand(0,5);
    $clave .= $numero;
    }
    $codigo ='CV'.$clave;
    $fecha  = date('Y-m-d');
    $campos=array(array("nombre",$nombre),array("codigoreclamo",$codigo),array("apellidop",$apellidop),array("apellidom",$apellidom),array("tipodoc",$tipodoc),array("documento",$documento),array("correo",$correo),array("telefono",$telefono),array("departamento",$departamento),array("provincia",$provincia),array("distrito",$distrito),array("direccion",$direccion),array("biencontra",$biencontra),array("descripcionbien",$descripcion),array("tiporeclamo",$tiporeclamo),array("detallerecla",$detallerecla),array("pedidoconsu",$pedidoconsu),array("fecharecla",$fecha));

    $bd-> inserta_(arma_insert('reclamo',$campos,'POST')); ?>
    <script type="text/javascript">
    $(document).ready(function(){
      swal({
        title: "Solicitud de <?php echo $asunto ?> enviada",
        html:'<b><span class="titu2">Código de <?php echo $asunto ?> generada <span style="color:red;"><?php echo $codigo ?></span></span></b>' + '<br /><br />' + '<span class="text2">Guarde este código para que pueda realizar el seguimiento a su <?php echo $asunto ?> generado.' + '<br /><br />' + 'Acabamos de recepcionar tu solicitud, y uno de nuestros asesores de atención al cliente te estara contactando a la brevedad posible para su <?php echo $asunto ?>.' + '<br />' + 'Nos contactaremos con usted con los datos que nos esta proporcinando ya sea por EMAIL/CORREO o directamente a su número de CELULAR' + '<br /><br />' + '<b>ATTE EDUCA AUGE</b>',
        allowOutsideClick:false,
        showCloseButton: true,
        confirmButtonColor: '#EB1F25',
        confirmButtonText: 'Cerrar'
      }).then(function() {
        window.location.href = "libro-de-reclamaciones";
        })});
    </script>
    <?php
    }else{ ?>
    <script type="text/javascript">
    $(document).ready(function(){
      swal({
        title: 'Error',
        text: 'Su información no pudo ser enviada, intente más tarde',
        type: 'error'
      }).then(function() {
        window.location.href = "libro-de-reclamaciones";
        })});
    </script>
    <?php  } ?>
</script>
  </body>
</html>