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
    <link rel="stylesheet" href="css/config.css?ud=<?php echo $unix_date; ?>" />
    <link rel="stylesheet" href="css/main.css?ud=<?php echo $unix_date; ?>" />
<?php  echo ($pagina=="cursos") ? '<link rel="stylesheet" href="css/cursos.css?ud='.$unix_date.'" />' : "";
    echo ($pagina=="noso") ? '<link rel="stylesheet" href="css/nosotros.css?ud='.$unix_date.'" />' : "";
    echo ($pagina=="portada") ? '<link rel="stylesheet" href="css/portada.css?ud='.$unix_date.'" />' : "";
    echo ($pagina=="cont") ? '<link rel="stylesheet" href="css/contacto.css?ud='.$unix_date.'" />' : "";
    echo ($pagina=="perfil") ? '<link rel="stylesheet" href="css/perfil.css?ud='.$unix_date.'" />' : ""; ?>
		<!-- Global site tag (gtag.js) - Google Analytics -->
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

<iframe width="250" height="50" style="" class="boton_mesinger" src="https://cdn.smooch.io/message-us/index.html?channel=messenger&color=blue&size=standard&radius=4px&label=Messenger Chat&pageId=243790482299542"></iframe>


</head>



<body id="top"   ondragstart="return false" onselectstart="return false" oncontextmenu="return false"   >
<!--
ondragstart="return false" onselectstart="return false" oncontextmenu="return false" 
* Con esto, evitas seleccionar, arrastrar, ver código fuente.

 -->


<!-- Start of grupoauge Zendesk Widget script -->
<script id="ze-snippet" src="https://static.zdassets.com/ekr/snippet.js?key=fdcefc75-d75d-4bb7-896b-6c97954e5fb5"> </script>
<!-- End of grupoauge Zendesk Widget script -->

<!-- modales registro, login  -->
<?php include("inc/modales_registro_login.php"); ?>
<!-- menu responsive "left"  -->
<div class="block-n position-left off-canvas-absolute " id="offCanvasLeftSplit1" data-off-canvas><div class="cuerpo">
    <div class="arriba">
        <button type="button" class="block-n cierra" data-toggle="offCanvasLeftSplit1"><img src="img/iconos/cerrar.png" class=""></button>
        <img src="img/nueva_portada/logo.png">
    </div>
    <?php if(!empty($_SESSION["suscritos"]["id_suscrito"])){ ?>
    <div class="fondo banner-1 text-right">
        <input id="name_perfil" name="name_perfil" type="hidden" value="<?php echo $perfil[0]["nombre"]; ?>">
        <input id="name_apellidos" name="name_apellidos" type="hidden" value="<?php echo $perfil[0]["ap_pa"].' '.$perfil[0]["ap_ma"]; ?>">
        <input id="name_direc" name="name_direc" type="hidden" value="<?php echo $perfil[0]["direccion"]; ?>">
        <input id="name_ciudad" name="name_ciudad" type="hidden" value="<?php echo $perfil[0]["ciudad"]; ?>">
        <input id="name_telef" name="name_telef" type="hidden" value="<?php echo $perfil[0]["telefono"]; ?>">
    </div>
    <?php } ?>
    <nav>
        <ul class="no-bullet poppi-sb fullwidth">
<?php 
        if(!empty($_SESSION["suscritos"]["id_suscrito"])){
        if(!empty($perfil[0]["nombre"])){
?>
            <li><a class="bold name_perfil poppi-sb">Hola <?php echo $perfil[0]["nombre"].'!'; ?></a></li>
<?php   }else{ ?>
            <li><a class="name_perfil poppi-sb"><?php echo $perfil[0]["email"]; ?></a></li>
<?php   }
        } // si sesion 
?>
            <li class="<?php echo ($pagina=="cursos") ? "active " : ""; ?>"><a href="curso/todos">Cursos</a></li>
            <li class="<?php echo ($pagina=="serv") ? "active " : ""; ?>"><a href="">Exámenes</a></li>
            <li class="<?php echo ($pagina=="noso") ? "active " : ""; ?>"><a href="nosotros">Quienes somos</a></li>
            <li class="<?php echo ($pagina=="clie") ? "active " : ""; ?>"><a href="contacto">Contáctanos</a></li>
        </ul>
     <?php if(!empty($_SESSION["suscritos"]["id_suscrito"])){ ?>
        <div id="menu_perfil" class="large-2 menu_perfil columns block-n">
        <?php include("inc/menu_perfil.php");?>
        <a class="poppi-sb cesti" style="margin-top:20px;" href="cesta">Ver carrito</a>
        </div>
    <?php }else{ ?>
        <a  class="poppi-sb boton llama_al_registro ">Regístrate</a>
        <a  class="llama_al_login poppi-sb boton boton2 ">Ingresa</a>
        <a class="poppi-sb cesti" href="cesta">Ver carrito</a>
    <?php } ?>
    </nav>
</div></div>
<!-- menu responsive "left"  -->
<!-- end menu left  -->
<?php 
$sql_cc="SELECT c.id_curso,c.titulo, c.en_vivo, c.enlace_en_vivo, c.hora_en_vivo FROM suscritos_x_cursos sc INNER JOIN cursos c ON sc.id_curso=c.id_curso WHERE  c.titulo_rewrite = '".$_GET['task2']."' and sc.id_suscrito='".$_SESSION['suscritos']['id_suscrito']."' ";
$cursa= executesql($sql_cc);

$si_finalizado = executesql("SELECT ide,finalizado FROM suscritos_x_cursos WHERE estado_idestado = 1 AND id_curso = '".$cursa[0]['id_curso']."' and  id_suscrito = '".$_SESSION['suscritos']['id_suscrito']."'  ");
if($si_finalizado[0]['finalizado']!=1){
    $total_n_clases = executesql("SELECT count(*) as total_clases FROM avance_de_cursos_clases WHERE id_curso = '".$cursa[0]['id_curso']."' and id_suscrito='".$_SESSION['suscritos']['id_suscrito']."' ");
    if(!empty($total_n_clases) && $total_n_clases[0]['total_clases'] > 0 ){
        $finalizadas = executesql("SELECT count(*) as total_finalizadas FROM avance_de_cursos_clases WHERE id_curso = '".$cursa[0]['id_curso']."' and id_suscrito='".$_SESSION['suscritos']['id_suscrito']."'  and estado_fin=1 ");
        $porcentaje= round( ($finalizadas[0]['total_finalizadas']*100)/$total_n_clases[0]['total_clases']);
        if($porcentaje =='100'){
            $bd=new BD;
            $_POST['finalizado']=1;
            $campos=array('finalizado');
            $bd->actualiza_(armaupdate('suscritos_x_cursos',$campos," ide='".$si_finalizado[0]["ide"]."'",'POST'));/*actualizo*/
        }
    }else{
        $porcentaje ='0';
    }
}else{
    $porcentaje='100';
}
?>
<header>
    <div class="callout"><div class="row row-docen"><div class="large-12 columns">
        <div class="float-left">
            <a class="logo" href=""><img src="img/nueva_portada/logo.png" /></a>
            <!--<h3 class="color-blanco titulo-perfil-curso poppi-b"><?php echo !empty($cursa[0]['titulo'])? $cursa[0]['titulo']:' no tienes acceso'; ?></h3>-->
        </div>
        <div class="barra-de-progreso">
            <div><p class="color-blanco poppi-b">Progreso del curso: <?php echo $porcentaje ?>%</p></div>
            <div class="progreso"><div class="avanc" style="width:<?php echo $porcentaje ?>%"></div></div>
        </div>
				<div class="lleva_boton_en_vivo ">
				<?php
						if( $cursa[0]['en_vivo']==1){ /* valido si esta activo el boton */
									if(!empty($cursa[0]['enlace_en_vivo']) && !empty($cursa[0]['hora_en_vivo']) ){ ?>
								<a href="<?php echo $cursa[0]['enlace_en_vivo'];?>" target="_blank">
									<figcaption class="en_vivo text-center">
											<b class="float-left" style="padding-right:20px;"> <span>Transmisión en vivo</span> </b> <?php echo $cursa[0]['hora_en_vivo'];?>
									</figcaption>
								</a> 
						<?php }
						}
					?>
					</div>
				
        <div class="float-right rel">
            <nav><ul class="no-bullet poppi">
                <li class="btn btn2 poppi-sb  "><a href="mis-cursos">Volver a Mis cursos</a></li>
            </ul></nav>
        </div>
    </div></div></div>
</header>