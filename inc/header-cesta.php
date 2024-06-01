<!DOCTYPE html>
<?php 
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
    <title ><?php echo isset($meta) ? $meta ['title'] : 'ingelme'; ?></title>
    <?php if(isset($meta)){ foreach($meta as $k => $v){ ?>
    <meta property="og:<?php echo $k; ?>" content="<?php echo $v; ?>"/>
    <?php } } ?>
    <link rel="shortcut icon" href="favicon.png">
    <link rel="apple-touch-icon" href="apple-touch-icon.png">
    <link rel="apple-touch-icon" sizes="72x72" href="apple-touch-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="114x114" href="apple-touch-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="144x144" href="apple-touch-icon-144x144.png">
    <link rel="stylesheet" href="css/foundation.css" />
    <link rel="stylesheet" href="js/font-awesome/css/all.css">
    <!-- Lightslider -->
    <link href="js/vendor/lightslider/lightslider.min.css" rel="stylesheet">
    <!-- Magnific Popup -->
    <link href="js/vendor/magnific-popup/magnific-popup.css" rel="stylesheet">
    <!-- Own CSS -->
    <link rel="stylesheet" href="css/animations.css" type="text/css">
    <link rel="stylesheet" href="css/config.css?ud=<?php echo $unix_date ; ?>" />
    <link rel="stylesheet" href="css/main.css?ud=<?php echo $unix_date ; ?>" />
    <link rel="stylesheet" href="css/cesta.css?ud=<?php echo $unix_date ; ?>" />
		<!-- 
		-->
	<?php if($pagina != 'pago_efectivo'){ ?>
		<script src="https://checkout.culqi.com/v2"></script>
	<?php } ?>
	
<!-- Global site tag (gtag.js) - Google Analytics  este es tuweb7-->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-0QZ9372LF8"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-0QZ9372LF8');
</script>



<!-- Global site tag (gtag.js) - Google Analytics
<script async src="https://www.googletagmanager.com/gtag/js?id=G-KLHLD6M7W1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-KLHLD6M7W1');
</script>
 -->

<!-- Global site tag (gtag.js) - Google Analytics  nuevo informes@.. -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-218098818-1">
</script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-218098818-1');
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
</script>
<noscript><img height="1" width="1" style="display:none"
src="https://www.facebook.com/tr?id=189598158067978&ev=PageView&noscript=1"
/></noscript>
<!-- End Meta Pixel Code -->

<!-- Start of grupoauge Zendesk Widget script -->
<script id="ze-snippet" src="https://static.zdassets.com/ekr/snippet.js?key=fdcefc75-d75d-4bb7-896b-6c97954e5fb5"> </script>
<!-- End of grupoauge Zendesk Widget script -->

<!--
<iframe width="250" height="50" style="" class="boton_mesinger" src="https://cdn.smooch.io/message-us/index.html?channel=messenger&color=blue&size=standard&radius=4px&label=Messenger Chat&pageId=243790482299542"></iframe>
-->

</head>
<body id="top">



<?php include("inc/modales_registro_login.php"); ?>

<header>
    <div class="callout"><div class="row"><div class="large-12 columns">
        <div class="float-left"><a class="logo " href=""><img src="img/nueva_portada/logo.png" /></a></div>
        <div class="float-right"><p class="poppi-b pago color-blanco"><img src="img/iconos/candado2.png">Pago 100% seguro</p></div>
    </div></div></div>
</header>
<?php if(!empty($_SESSION["suscritos"]["id_suscrito"])){ ?>
  <div class="fondo banner-1">
	<!-- 
    <img class="img-perfil-movi" src="<?php echo $image_perfil;?>">
    <?php if(!empty($perfil[0]["nombre"])){ ?><p class="bold name_perfil"><?php echo $perfil[0]["nombre"]; ?></p><?php } ?>
    <p class="name_perfil"><?php echo $perfil[0]["email"]; ?></p>
		-->
		<input id="id_suscrito_js" name="id_suscrito_js" type="hidden" value="<?php echo $perfil[0]["id_suscrito"]; ?>">
		<input id="name_perfil" name="name_perfil" type="hidden" value="<?php echo $perfil[0]["nombre"]; ?>">
		<input id="name_apellidos" name="name_apellidos" type="hidden" value="<?php echo !empty($perfil[0]["ap_pa"])?$perfil[0]["ap_pa"].' '.$perfil[0]["ap_ma"]:''; ?>">				
		<input id="email_ecommerce" name="email_ecommerce" type="hidden" value="<?php echo $perfil[0]["email"]; ?>">				
		<!-- 
		<input id="name_direc" name="name_direc" type="hidden" value="Chiclayo, Perú">
		-->
		<input id="name_direc" name="name_direc" type="hidden" value="<?php echo $perfil[0]["direccion"]; ?>"> 
		<input id="name_ciudad" name="name_ciudad" type="hidden" value="<?php echo $perfil[0]["ciudad"]; ?>">	
		<input id="name_telef" name="name_telef" type="hidden" value="<?php echo $perfil[0]["telefono"]; ?>">				
  </div>
<?php } ?>  
