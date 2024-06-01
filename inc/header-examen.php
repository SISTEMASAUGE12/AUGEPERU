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
    <title ><?php echo isset($meta) ? $meta ['title'] : ' GRUPO AUGE '; ?></title>
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
    <link href="js/vendor/lightslider/lightslider.min.css" rel="stylesheet">
    <link href="js/vendor/magnific-popup/magnific-popup.css" rel="stylesheet">
    <link rel="stylesheet" href="css/animations.css" type="text/css">
    <link rel="stylesheet" href="css/sweetalert.min.css">
    <link rel="stylesheet" href="css/config.css?ud=<?php echo $unix_date; ?>" />
    <link rel="stylesheet" href="css/main.css?ud=<?php echo $unix_date; ?>" />
    <link rel="stylesheet" href="css/examen.css?ud=<?php echo $unix_date; ?>" />
		<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-0QZ9372LF8"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-0QZ9372LF8');
</script>



<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-KLHLD6M7W1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-KLHLD6M7W1');
</script>

<!-- Facebook Pixel Code -->
<script>
!function(f,b,e,v,n,t,s)
{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};
if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];
s.parentNode.insertBefore(t,s)}(window,document,'script',
'https://connect.facebook.net/en_US/fbevents.js');
 fbq('init', '952841461981060'); 
fbq('track', 'PageView');
</script>
<noscript>
 <img height="1" width="1" 
src="https://www.facebook.com/tr?id=952841461981060&ev=PageView
&noscript=1"/>
</noscript>
<!-- End Facebook Pixel Code -->

<!-- Start of grupoauge Zendesk Widget script -->
<script id="ze-snippet" src="https://static.zdassets.com/ekr/snippet.js?key=fdcefc75-d75d-4bb7-896b-6c97954e5fb5"> </script>
<!-- End of grupoauge Zendesk Widget script -->

<iframe width="250" height="50" style="" class="boton_mesinger" src="https://cdn.smooch.io/message-us/index.html?channel=messenger&color=blue&size=standard&radius=4px&label=Messenger Chat&pageId=243790482299542"></iframe>


</head>
<body id="top">
<?php include("inc/modales_registro_login_v2.php"); ?>

<header>
<?php 
if($_GET['task2']=='historial_examenes'){
    $tit_gene = 'Historial de examenes';
}else{
    $exa = executesql("SELECT * FROM examenes WHERE titulo_rewrite = '".$_GET['task2']."'");
    $tit_gene = $exa[0]['titulo'];
} ?>
    <div class="callout"><div class="row row-docen"><div class="large-12 columns">
        <div class="float-left">
            <a class="logo " href=""><img src="img/nueva_portada/logo.png" /></a>
            <h3 class="color-blanco titulo-perfil-curso poppi-b"><?php echo $tit_gene ?></h3>
        </div>
    </div></div></div>
</header>