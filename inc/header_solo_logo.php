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
		<?php 
			if($pagina=="cursos" || $pagina=="trafico" ){
				echo 	'<link rel="stylesheet" href="css/cursos.css?ud='.$unix_date.'" />';
				echo 	'<link rel="stylesheet" href="css/cesta.css?ud='.$unix_date.'" />';
				
			}else if($pagina=="blog" ){
				echo 	'<link rel="stylesheet" href="css/blog.css?ud='.$unix_date.'" />';
				
			}else{ 
				echo 	'<link rel="stylesheet" href="css/docente.css?ud='.$unix_date.'" />';
				echo 	'<link rel="stylesheet" href="css/landing.css?ud='.$unix_date.'" />';
			}
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

<?php 
// if($pagina !="cursos" && $pagina !="blog" ){
if( $pagina !="blog" ){
   ?>

<div style="position:absolute;right:10px;left:inherit !important;">
<!-- Start of grupoauge Zendesk Widget script -->
<script id="ze-snippet" src="https://static.zdassets.com/ekr/snippet.js?key=fdcefc75-d75d-4bb7-896b-6c97954e5fb5"> </script>
<!-- End of grupoauge Zendesk Widget script -->
</div>

  <?php  if( $pagina !="trafico" ){    ?>
   <iframe width="250" height="50" style="" class="boton_mesinger" src="https://cdn.smooch.io/message-us/index.html?channel=messenger&color=blue&size=standard&radius=4px&label=Messenger Chat&pageId=243790482299542"></iframe>

        <!-- wsp -->
      <div class="wasap_flota_flotados" style="bottom:322px;">
          <a href="https://api.whatsapp.com/send?phone=+51957668571&text=Hola%20Grupo%20AUGE%20Quiero%20Informaci%C3%B3n"  target="_blank" alt="whatsapp"><img src="img/wasap_flota2.png" alt="whatsapp" width="50px"> <span class="hide">wsp</span></a>
      </div>

      <a href="https://app.toky.co/AUGEPER?callnow&amp;option=3106" title="llama gratis" target="_blank" class="llama_gratis " style="left:4px;"><img style="margin-top:10px;" src="img/iconos/llama_gratis.png" alt="llama gratis toky"></a>

  <?php } ?> 
  
<?php } ?> 


</head>
<body id="top">
<?php include("inc/modales_registro_login_v2.php"); ?>

<!-- Cargue el SDK de Facebook para JavaScript --> 
<div id="fb-root"></div>
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/es_ES/sdk.js#xfbml=1&version=v3.3&appId=345530296004647&autoLogAppEvents=1"></script>


<header>
    <div class="callout"><div class="row"><div class="large-12 columns">
        <div class="float-left"><a class="logo " href=""><img src="img/nueva_portada/logo.png" /></a></div>
    </div></div></div>
</header>
