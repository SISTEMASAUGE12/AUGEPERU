<!DOCTYPE html>
<?php $unix_date = strtotime(date('Y-m-d H:i:s')); ?>
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
		
<?php if($pagina != "login_v2"){ ?>
    <link rel="stylesheet" href="js/font-awesome/css/all.css">
    <!-- Lightslider -->
    <link href="js/vendor/lightslider/lightslider.min.css" rel="stylesheet">
    <!-- Magnific Popup -->
    <link href="js/vendor/magnific-popup/magnific-popup.css" rel="stylesheet">
    <!-- Own CSS -->
    <link rel="stylesheet" href="css/animations.css" type="text/css">
<?php } ?>
		
    <link rel="stylesheet" href="css/config.css?ud=<?php echo $unix_date ; ?>" />
    <link rel="stylesheet" href="css/main.css?ud=<?php echo $unix_date ; ?>" />
    <link rel="stylesheet" href="css/registro.css?ud=<?php echo $unix_date ; ?>" />
    <link rel="stylesheet" href="css/registro_version_2.css?ud=<?php echo $unix_date ; ?>" />
		
		
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


<?php if($pagina != "login_v2"){ ?>
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

<?php }  /* fin son etiquetas marketing */?>
</head>

<body id="top">
<?php
if( $pagina!='login_v2'){
 include("inc/modales_registro_login_v2.php");
}
 ?>
 
<header class="menu-registro">
    <div class="callout"><div class="row"><div class="large-12 columns">
        <div class="float-left"><a class="logo" href=""><img src="img/nueva_portada/logo.png" /></a></div>
    </div></div></div>
</header>