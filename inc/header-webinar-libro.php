<!DOCTYPE html>
<?php 
// $_SESSION["url"]=url_completa(); // redireciona aui el registro 

$unix_date = strtotime(date('Y-m-d H:i:s')); 

if($pagina != 'webinar' && $pagina != 'registro'){ /* esta sesion sirve para saber que el registro de webinar  vino desde un webinar */
	unset($_SESSION["url_webinar"]);  /* si esta en otra pagian que no es el webinar, eliminamos esta sesion */
}

?>
<html class="no-js" lang="es-ES">  
<head>
    <base href="<?php echo $url; ?>"/>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title ><?php echo isset($meta) ? $meta ['title'] : 'Accede a los mejores Cursos online para docentes | GRUPO AUGE '; ?></title>
    <?php if(isset($meta)){ foreach($meta as $k => $v){ ?>
    <meta name=<?php echo $k; ?>" content="<?php echo $v; ?>"/>
		<meta property="og:<?php echo $k; ?>" content="<?php echo $v; ?>"/>
    <?php } } ?>
	<meta name="author" content="Ing.Luis Mori - PERÚ - cel/whatsApp: +51945250434 -email: luismori@tuweb7.com  -web:  www.tuweb7.com  "/>

    <link rel="shortcut icon" href="favicon.png">
    <link rel="apple-touch-icon" href="apple-touch-icon.png">
    <link rel="apple-touch-icon" sizes="72x72" href="apple-touch-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="114x114" href="apple-touch-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="144x144" href="apple-touch-icon-144x144.png">
    <link rel="stylesheet" href="css/foundation.css" />
	<link rel="stylesheet" href="js/font-awesome/css/all.css">	
    <link href="js/vendor/lightslider/lightslider.min.css" rel="stylesheet">
    <link href="js/vendor/magnific-popup/magnific-popup.css" rel="stylesheet">
		<?php if($pagina=="examen" || $pagina=="perfil"){ ?>
    <link rel="stylesheet" href="css/sweetalert.min.css">
    <link rel="stylesheet" href="css/animations.css" type="text/css">
		<?php } ?> 
    <link rel="stylesheet" href="css/config.css?ud=<?php echo $unix_date; ?>" />
    <link rel="stylesheet" href="css/main.css?ud=<?php echo $unix_date; ?>" />
<?php   
	echo '<link rel="stylesheet" href="css/cursos.css?ud='.$unix_date.'" />' ;
	// echo '<link rel="stylesheet" href="css/cursos_2024.css?ud='.$unix_date.'" />' ; // otro diseño febrero 2024 		
	echo '<link rel="stylesheet" href="css/cursos_2024_version_abril.css?ud='.$unix_date.'" />' ;  // nuevo diseño detalle curso y flotante abril 2024 
	 
		
	// echo ($pagina=="cursos") ? '<link rel="stylesheet" href="css/cursos.css?ud='.$unix_date.'" />' : "";
	echo ($pagina=="detalle_curso" ) ? '<link rel="stylesheet" href="css/detalle_cursos_2024.css?ud='.$unix_date.'" />' : "";
	echo ($pagina=="cursos" || $pagina=="detalle_curso" ) ? '<link rel="stylesheet" href="css/cesta.css?ud='.$unix_date.'" />' : "";
    echo ($pagina=="noso") ? '<link rel="stylesheet" href="css/nosotros.css?ud='.$unix_date.'" />' : "";
    echo ($pagina=="miembros") ? '<link rel="stylesheet" href="css/miembros.css?ud='.$unix_date.'" />' : "";
    echo ($pagina=="preguntas_frecuentes") ? '<link rel="stylesheet" href="css/preguntas_frecuentes.css?ud='.$unix_date.'" />' : "";
    echo ($pagina=="examen") ? '<link rel="stylesheet" href="css/examen.css?ud='.$unix_date.'" />' : "";
    
	// echo ($pagina=="portada") ? '<link rel="stylesheet" href="css/portada.css?ud='.$unix_date.'" />' : "";
     echo ($pagina=="portada") ? '<link rel="stylesheet" href="css/portada_2024.css?ud='.$unix_date.'" />' : "";

    echo ($pagina=="cont") ? '<link rel="stylesheet" href="css/contacto.css?ud='.$unix_date.'" />' : "";
    echo ($pagina=="docen") ? '<link rel="stylesheet" href="css/docente.css?ud='.$unix_date.'" />' : "";
    echo ($pagina=="perfil") ? '<link rel="stylesheet" href="css/perfil.css?ud='.$unix_date.'" />' : "";
    echo ($pagina=="perfil" || $pagina=="coautoria") ? '<link rel="stylesheet" href="css/certificacion.css?ud='.$unix_date.'" />' : "";
    echo ($pagina=="perfil_home") ? '<link rel="stylesheet" href="css/perfil.css?ud='.$unix_date.'" />' : "";
    echo ($pagina=="blog") ? '<link rel="stylesheet" href="css/blog.css?ud='.$unix_date.'" />' : "";
    echo ($pagina=="landin_libro") ? '<link rel="stylesheet" href="css/webinar_libro.css?ud='.$unix_date.'" />' : "";
    echo (isset($pagina_2) && $pagina_2=="webinar_3") ? '<link rel="stylesheet" href="css/webinar_3.css?ud='.$unix_date.'" />' : "";
    echo ($pagina=="login_v2") ? '<link rel="stylesheet" href="css/registro_version_2.css?ud='.$unix_date.'" />' : "";
    echo ($pagina=="registro") ? '<link rel="stylesheet" href="css/registro_version_2.css?ud='.$unix_date.'" />' : "";
    echo ($pagina=="testimonios") ? '<link rel="stylesheet" href="css/testimonios_v2.css?ud='.$unix_date.'" />' : "";
    echo ($pagina=="canal-whatsapp") ? '<link rel="stylesheet" href="css/canal-whatsapp.css?ud='.$unix_date.'" />' : "";
    echo ($pagina=="landing_extra_larga") ? '<link rel="stylesheet" href="css/landing_extra_larga.css?ud='.$unix_date.'" />' : "";
		
?>

<meta name="google-site-verification" content="0tXT65vrzbXd28qJAByyM2DaA_ZQ7yhPwR3qRxDkPYw" /> <!-- educaaug -->

<!-- Global site tag - CUENTA SISTEMAS -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-0QZ9372LF8"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-0QZ9372LF8');
</script>


<!-- -EDUCA .. -->
<!-- Global site tag (gtag.js) - Google Analytics CORPORATIVO  -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-213621179-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-213621179-1');
</script>


<!-- Global site tag (gtag.js) - Google Analytics  nuevo informes@.. -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-218098818-1">
</script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-218098818-1');
</script>




<!-- Google tag (gtag.js)   03-09-2013  -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-W1Q4M9HVZ0">
</script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-W1Q4M9HVZ0');
</script>



<!-- Meta Pixel Code -->
<script>
!function(f,b,e,v,n,t,s)
{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};
if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];
s.parentNode.insertBefore(t,s)}(window, document,'script',
'https://connect.facebook.net/en_US/fbevents.js');
fbq('init', '189598158067978');
fbq('track', 'PageView');
<?php  // evento pagian de gracias trafic0 
if( isset($pagina_gracias) &&  $pagina_gracias="gracias_trafico" ){ ?>
fbq('track', 'CompleteRegistration');
<?php } ?>

</script>
<noscript><img height="1" width="1" style="display:none"
src="https://www.facebook.com/tr?id=189598158067978&ev=PageView&noscript=1"
/></noscript>
<!-- End Meta Pixel Code -->

<meta name="facebook-domain-verification" content="y161y9c4mlfq5z8ctom5xxy2j4qfto" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css">

</head>

<!-- <body id="top"> -->
<body >
<?php
// if( $pagina!='login_v2' && $pagina !='webinar' ){
//  include("inc/modales_registro_login_v2.php");
// }
 ?>

<?php
if( $pagina!='login_v2' && $pagina !='webinar' ){ ?>
<!-- Cargue el SDK de Facebook messinger  para JavaScript --> 
<div id="fb-root"></div>
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/es_ES/sdk.js#xfbml=1&version=v3.3&appId=345530296004647&autoLogAppEvents=1"></script>
<?php } ?>



<?php if( $pagina != "webinar"   &&  $pagina != "landing_extra_larga" ){  // para estos no aparece el header comun  ?>
	
<!-- Start of grupoauge Zendesk Widget script 
<script id="ze-snippet" src="https://static.zdassets.com/ekr/snippet.js?key=fdcefc75-d75d-4bb7-896b-6c97954e5fb5"> </script>
 -- End of grupoauge Zendesk Widget script -->



 <?php if( $pagina!='login_v2' && $pagina!='canal-whatsapp' ){  // no muestro mesinger en login   ?>
<!-- BOTON MESSINGER FLOTANTE 
<iframe width="140" height="50" style="" class="boton_mesinger" title="escribenos" src="https://cdn.smooch.io/message-us/index.html?channel=messenger&color=blue&size=standard&radius=4px&label=Chat&pageId=243790482299542"></iframe>
-->
<?php } ?> 
	
	
	<!-- zoom soporte -->
<!-- <div class="zoom_soporte_flota">
	<a href="https://zoom.us/j/96862067369" target="_blank"><img src="img/zoom.png"></a>
</div> -->
<!-- telegram --
<div class="telegram_flota">
	<a href="https://t.me/EducaAugeBot" target="_blank" title="telegram"><img src="img/telegram.png" alt="telegram"></a>
</div>
-->
  

<!-- wsp -->
<?php if( $pagina != 'canal-whatsapp'  ){ ?>   
	<div class="wasap_flota_flotados  <?php //  echo ( $pagina == 'blog' )?' _en_blog ':''; ?> "     style="bottom:330px;">
		<a href="https://api.whatsapp.com/send?phone=+51<?php echo $_num_wsp; ?>&text=Hola%20<?php echo $_nombre_empresa; ?>%20Quiero%20Informaci%C3%B3n"  target="_blank" alt="whatsapp"><img src="img/iconos/whatsapp_icon.png" alt="whatsapp" > 
		<!-- <span class=" "> WhatsApp</span> --> 
	</a>
</div>
<div class=" telefono_flotante_2  text-center poppi-sb    ">
	<!-- <a href="https://app.toky.co/AUGEPER" target="_blank"><img src="img/iconos/call_2.png"> Llama gratis </a> -->
	<a href="llamanos-gratis" class=" _ver_solo_en_pc "><img src="img/iconos/call_2.png"> Llama gratis </a>
	<a href="tel:017097855" target="_blank" class=" _ver_solo_en_movil  "><img src="img/iconos/call_2.png"> Llama gratis </a>
</div>
<div class=" micuenta_flotante  poppi-sb  text-center  ">
	<a href="<?php echo (!empty($_SESSION["suscritos"]["id_suscrito"]))?'mis-cursos':'iniciar-sesion_v2';?>">Mi cuenta </a>
</div>
<?php } ?>
	
<header>
   

</header>
<?php } /* webinar nos sale header */
?>

