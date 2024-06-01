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


	// echo ($pagina=="cursos") ? '<link rel="stylesheet" href="css/cursos.css?ud='.$unix_date.'" />' : "";
	echo ($pagina=="detalle_curso" ) ? '<link rel="stylesheet" href="css/detalle_cursos_2024.css?ud='.$unix_date.'" />' : "";
	echo ($pagina=="cursos" || $pagina=="detalle_curso" ) ? '<link rel="stylesheet" href="css/cesta.css?ud='.$unix_date.'" />' : "";
    echo ($pagina=="noso") ? '<link rel="stylesheet" href="css/nosotros_2024.css?ud='.$unix_date.'" />' : "";
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
    echo ($pagina=="webinar") ? '<link rel="stylesheet" href="css/webinar.css?ud='.$unix_date.'" />' : "";
    echo (isset($pagina_2) && $pagina_2=="webinar_3") ? '<link rel="stylesheet" href="css/webinar_3.css?ud='.$unix_date.'" />' : "";
    echo ($pagina=="login_v2") ? '<link rel="stylesheet" href="css/registro_version_2.css?ud='.$unix_date.'" />' : "";
    echo ($pagina=="registro") ? '<link rel="stylesheet" href="css/registro_version_2.css?ud='.$unix_date.'" />' : "";
    echo ($pagina=="testimonios") ? '<link rel="stylesheet" href="css/testimonios_v2.css?ud='.$unix_date.'" />' : "";
    echo ($pagina=="canal-whatsapp") ? '<link rel="stylesheet" href="css/canal-whatsapp.css?ud='.$unix_date.'" />' : "";
    echo ($pagina=="landing_extra_larga") ? '<link rel="stylesheet" href="css/landing_extra_larga.css?ud='.$unix_date.'" />' : "";

	/** abril 2024  */
	echo '<link rel="stylesheet" href="css/cursos_2024_version_abril.css?ud='.$unix_date.'" />' ;  // nuevo diseño detalle curso y flotante abril 2024

?>

<meta name="google-site-verification" content="0tXT65vrzbXd28qJAByyM2DaA_ZQ7yhPwR3qRxDkPYw" /> <!-- educaaug -->

<script src="https://cdn.voximplant.com/voximplant.min.js"></script>

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

<!-- Google tag (gtag.js) 13/05/2024 -->
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

<body id="top">
<?php
if( $pagina!='login_v2' && $pagina !='webinar' ){
 include("inc/modales_registro_login_v2.php");
}
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
		<a href="https://api.whatsapp.com/send?phone=51957668571&text=%22%C2%A1Hola!%20Estoy%20muy%20interesado%20en%20conocer%20m%C3%A1s%20sobre%20los%20cursos%20de%20Grupo%20AUGE.%20%C2%BFPodr%C3%ADan%20enviarme%20m%C3%A1s%20informaci%C3%B3n?%20%C2%A1Gracias!%22"  target="_blank" alt="whatsapp"><img src="img/iconos/whatsapp_icon.png" alt="whatsapp" >
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

  <!-- insert_script -->
  <!-- <script>window.VoxKitWidgetSettings = {
    host: 'kit-im-us.voximplant.com',
    channel_uuid: '91d87f53-c296-4fc7-bea1-1a05752aa91d',
    token: '414ef68196a5eb0f8d71e3a4afb9918e',
    client_data: {
      client_id: '', // ID del cliente
      client_phone: '', // Número de teléfono del cliente
      client_avatar: ''  , // Enlace del avatar del cliente
      client_display_name: '',  // Nombre del cliente
      client_email: '', // Correo electrónico del cliente
      client_language: 'en' // Idioma de la interfaz: 'en' o 'ru'
  }
  };
  </script>

  <script>var l=function(){var t=function(){"object"==typeof VoxKitWidget&&"object"==typeof VoxKitWidgetSettings&&VoxKitWidget.init(VoxKitWidgetSettings)},e=document.createElement("script");e.type="text/javascript",e.async=!0,e.src="https://kit.voximplant.com/static/widgets/web-chat.js?"+(new Date).valueOf(),e.readyState?e.onreadystatechange=function(){"loaded"!==e.readyState&&"complete"!==e.readyState||(e.onreadystatechange=null,t())}:e.onload=function(){t()};var a=document.getElementsByTagName("script")[0];a.parentNode.insertBefore(e,a)};window.attachEvent?window.attachEvent("onload",l):window.addEventListener("load",l,!1);
  </script> -->

<?php } ?>


<!--<div class="wasap_flota poppi">
	<div class="lleva_contenido_wasap text-center hide ">
		<div class="data_verde blanco text-center ">
			<small class="cierra_wsp">X</small>
			<h4	 class="poppi-b">¿Necesitas ayuda?</h4>
			<p class="poppi ">Haga click una de nuestras representantes lo atenderá</p>
		</div>
		<div class="data_anexo text-center ">
			<div class="contentx rel">
				<a href="https://api.whatsapp.com/send?phone=+51915152861&text=Hola%20Grupo%20AUGE%20Quiero%20Informaci%C3%B3n"  target="_blank">
					<div class="img_repe"><img src="img/img_wsp_chicas.png"></div>
					<div  class="data_repe  text-left poppi">
						<h3> CHICAS AUGE </h3>
						<p> Teleoperadoras web</p>
						<p class="boton_wsp">En linea</p>
					</div>
				</a>
			</div>
		</div>

	</div>

	<div class="lleva_icono_wasap">
		<img src="img/wasap_flota2.png" width="50px">
	</div>
</div>-->
<!-- wsp -->

<!-- Messenger plugin del chat Code -->
<!-- Messenger plugin del chat Code -->
<?php /*
    <div id="fb-root"></div>
    <!-- Your plugin del chat code -->
    <div id="fb-customer-chat" class="fb-customerchat"></div>
    <script>
      var chatbox = document.getElementById('fb-customer-chat');
      chatbox.setAttribute("page_id", "243790482299542");
      chatbox.setAttribute("attribution", "biz_inbox");

      window.fbAsyncInit = function() {
        FB.init({
          xfbml            : true,
          version          : 'v12.0'
        });
      };
      (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = 'https://connect.facebook.net/es_LA/sdk/xfbml.customerchat.js';
        fjs.parentNode.insertBefore(js, fjs);
      }(document, 'script', 'facebook-jssdk'));
    </script>
*/ ?>

<!-- menu responsive "left"  -->
<div class="block-n position-left off-canvas-absolute " id="offCanvasLeftSplit1" data-off-canvas>
	<div class="cuerpo">
			<div class="arriba">
				<button type="button" class="block-n cierra hide " data-toggle="offCanvasLeftSplit1"><img src="img/iconos/cerrar.png" class=""></button>
				<img src="img/nueva_portada/logo.png" alt="educaauge.com">
		</div>
	<?php if(!empty($_SESSION["suscritos"]["id_suscrito"])){ ?>
		<div class="fondo banner-1 text-center ">
			<input id="name_perfil" name="name_perfil" type="hidden" value="<?php echo $perfil[0]["nombre"]; ?>">
			<input id="name_apellidos" name="name_apellidos" type="hidden" value="<?php echo !empty($perfil[0]["ap_pa"])?$perfil[0]["ap_pa"].' '.$perfil[0]["ap_ma"]:''; ?>">
			<input id="name_direc" name="name_direc" type="hidden" value="<?php echo $perfil[0]["direccion"]; ?>">
			<input id="name_ciudad" name="name_ciudad" type="hidden" value="<?php echo $perfil[0]["ciudad"]; ?>">
			<input id="name_telef" name="name_telef" type="hidden" value="<?php echo $perfil[0]["telefono"]; ?>">
		</div>
	<?php } ?>
		<nav>
			<ul class="no-bullet poppi-sb fullwidth">
	<?php if(!empty($_SESSION["suscritos"]["id_suscrito"])){
					if(!empty($perfil[0]["nombre"])){ ?>
					<li><a title="bienvenido" class="bold name_perfil poppi-sb">Hola <?php echo $perfil[0]["nombre"].'!'; ?></a></li>
				<?php }else{ ?>
					<li><a  title="bienvenido" class="name_perfil poppi-sb"><?php echo $perfil[0]["email"]; ?></a></li>
				<?php }
				} // si sesion ?>

				<?php if(!isset($_SESSION["suscritos"]["id_suscrito"])){ ?>
					<li class="sombreado_1 <?php echo ($pagina=="index") ? "active " : ""; ?>"><a  title="entrar" href="iniciar-sesion_v2"> <img src="img/iconos/ico_menu_6.png">Entrar</a></li>
					<li class="sombreado_2 <?php echo ($pagina=="index") ? "active " : ""; ?>"><a  title="registrate" href="https://www.educaauge.com/registrate_v2"> <img src="img/iconos/ico_menu_1.png">Regístrate</a></li>
				<?php } ?>
				<li class="sombreado_1 <?php echo ($pagina=="index") ? "active " : ""; ?>"><a  title="inicio" href="<?php echo $url; ?>"> <img src="img/iconos/ico_menu_1.png">Inicio</a></li>

				<?php if(isset($_SESSION["suscritos"]["id_suscrito"])){ ?>
					<li class="sombreado_1  _menu_movil_mis_cursos_comprados <?php echo ($pagina=="mis-cursos") ? "active " : ""; ?>"><a  title="cursos comprados" href="mis-cursos"> <img src="img/iconos/ico_menu_6.png">Mis cursos comprados</a></li>
				<?php } ?>

				<li class="sombreado_2 <?php echo ($pagina=="cursos") ? "active " : ""; ?>"><a  title="comprar cursos" href="curso/todos"> <img src="img/iconos/ico_menu_2.png">Cursos</a></li>
				<li class="sombreado_1 <?php echo ($pagina=="cesta") ? "active " : ""; ?>"><a href="examen/todos"  title="compra examens"><img src="img/iconos/ico_menu_8.png">Comprar examen</a></li>

				<li class="sombreado_2 <?php echo ($pagina=="blog") ? "active " : ""; ?>"><a href="blog"  title="visita el blog"><img src="img/iconos/ico_menu_3.png">Noticias</a></li>
				<li class="sombreado_1 <?php echo ($pagina=="testimonios") ? "active " : ""; ?>"><a href="testimonios"  title="testimonios"><img src="img/iconos/ico_menu_4.png">Testimonios</a></li>
				<li class="sombreado_2 <?php echo ($pagina=="tutoriales") ? "active " : ""; ?>"><a href="tutoriales"  title="tutoriales  "><img src="img/iconos/ico_menu_5.png">Tutoriales</a></li>
				<li class="sombreado_1 <?php echo ($pagina=="noso") ? "active " : ""; ?>"><a href="nosotros"  title="nosotros"> <img src="img/iconos/ico_menu_6.png"> Nosotros</a></li>
				<li class="sombreado_2 <?php echo ($pagina=="clie") ? "active " : ""; ?>"><a href="contacto"  title="contactenos"><img src="img/iconos/ico_menu_7.png">Contáctanos</a></li>


			<?php if(!empty($_SESSION["suscritos"]["id_suscrito"])){ ?>
				<li class="<?php echo ($pagina=="serv") ? "active " : ""; ?>"><a href="certificados"  title="certificados"><img src="img/iconos/ico_menu_1.png"> Certificados</a></li>
			<?php } ?>
			</ul>

	 <?php if(!empty($_SESSION["suscritos"]["id_suscrito"])){ ?>
			<div id="menu_perfil" class="large-2 menu_perfil columns block-n">
				<?php include("inc/menu_perfil.php");?>
        		<a class="poppi-sb cesti" style="margin-top:20px;" href="cesta"  title="ver carrito ">Ver carrito</a>
			</div>
	<?php }else{ ?>

		<!--  SE MOVI OARRIBA DEL MENU MOBIL
				<a  href="iniciar-sesion_v2" class=" poppi-sb boton  " >Iniciar sesión</a>
				<a href="actualiza-tus-datos" class="poppi-sb boton boton2  llama_al_registro "  title="registrate">Regístrate</a>
				 -->
			<a class="poppi-sb cesti" href="cesta"  title="ver carrito ">Ver carrito</a>
    <?php } ?>
		</nav>
	</div> <!-- cuerrpo -->
</div>
<!-- menu responsive "left"  -->
<!-- end menu left  -->

<header>
    <div class="callout"><div class="row"><div class="large-12 columns">
        <div class="float-left lleva_el_logo "><a class="logo" href="https://www.educaauge.com" title="ir inicio"><img src="img/nueva_portada/logo.png" alt="educaauge.com"/></a></div>

<?php  if($pagina !='canal-whatsapp'){   ?>
		<div class="float-right rel <?php echo (!isset($_SESSION["suscritos"]["id_suscrito"]))?' web_sin_logeado ':'';?>">
			<div>
        	    <span id="busquita" class="busquita" title="buscar"><img src="img/iconos/lupa2.png" alt="buscar"></span>
	            <div id="busq" style="display:none" class="formu-busque">
					<?php if($pagina=='cursos' && !isset($_GET['rewrite4'])){
						$linka = $_SERVER['REQUEST_URI'];
					}else{
						$linka = 'curso/todos';
					} ?>
					<form class="form" action="<?php echo $linka;?>" method="POST">
						<input type="text" class="poppi" name="buscar" <?php if(isset($_POST['buscar']) && !empty($_POST['buscar'])){ echo 'value="'.$_POST['buscar'].'"'; } ?> placeholder="Buscar curso">
						<button><img src="img/iconos/lupa2.png" alt="buscar"></button>
					</form>
            	</div>

			<?php if( !isset($_SESSION["suscritos"]["id_suscrito"]) && empty($_SESSION["suscritos"]["id_suscrito"])){  ?>
				<li class="carrito aparecer " ><a href="cesta" title="ir a pagar"><img src="img/iconos/carrito.png" alt="carrito de compras">
				</a></li>
				<!--
				<li class="  aparecer " >
					<a href="iniciar-sesion_v2" title="inicia sesion"><img src="img/iconos/icono_sesion.png"  class=" _icono_sesion_movil " alt="inicia sesion"></a>
				</li>
				-->
				<li class="aparecer btn btn2 poppi-sb btn_sesion_movil  "><a href="iniciar-sesion_v2"> <img src="img/nueva_portada/login.png" alt="inicia sesion" class=" _icono_sesion_movil ">Iniciar sesión  </a></li>

			<?php }else{  ?>
				<li class="carrito aparecer " ><a href="cesta" title="ir a pagar"><img src="img/iconos/carrito.png" alt="carrito de compras">
					<span class="monset  articulos_total "></span>
				</a></li>
			<?php } ?>

				<button type="button" class=" menu_bar block-n" data-toggle="offCanvasLeftSplit1"><img src="img/iconos/menu.png" alt="menu" class=""></button>
			</div>



	<?php if( !isset($_SESSION["suscritos"]["id_suscrito"]) && empty($_SESSION["suscritos"]["id_suscrito"])){  ?>
			<div class="float- lleva_link_acceso aparecer poppi-sb  rel   hide ">
				<a href="registrate_v2"  title="registrate"><p>Regístrate</p></a>
			<!-- modal flotrante
				<span class="llama_al_login"  title="ingresa "><p>Ingresar</p></span>
			-->
				<a  href="iniciar-sesion_v2" class=" poppi-sb  " >Iniciar sesión</a>
			</div>
	<?php } ?>

		<?php if(!empty($_SESSION["suscritos"]["id_suscrito"])){
					include("inc/menu_perfil_logeado.php");
			}else{ ?>
			<nav>
				<ul class="no-bullet poppi">
					<li class="  poppi-sb"><a href="tutoriales"  title="Tutoriales" style="text-transform: uppercase;">Tutoriales </a></li>
					<li class="  poppi-sb"><a href="landin_libro"  title="Libros" style="text-transform: uppercase;">Libros  </a></li>
					<li class="btn poppi-b text-left " >
						<!-- <a href="llamanos-gratis" alt="llamar"  class=" _icono_llamar_tel "  > <img src="img/iconos/call_3.png">  LLAMA AL </br>(01) 7097855 </a> -->
						<a href="#" onclick="llamarGratis()" title="Llamar" class="_icono_llamar_tel"><img src="img/iconos/call_3.png" alt="Llamar"> LLAMA AL <br>(01) 7097855</a>
						<!-- <button class="call-button" onclick="llamarGratis()">Click to Call</button> -->


					</li>
					<li class="carrito"><a href="cesta"  title="carrito "><img src="img/iconos/carrito_2024.png" alt="carrito de compras"><span class="monset  articulos_total "></span></a></li>

					<li class="  poppi-sb"><a href="actualiza-tus-datos"  title="registrate aqui" style="text-transform: uppercase;">Regístrate  </a></li>
					<li class="btn btn2 poppi-sb  "><a href="iniciar-sesion_v2"> <img src="img/nueva_portada/login.png">Iniciar sesión  </a></li>

            	</ul>
			</nav>
		<?php  } ?>

        </div>
<?php } ?>
    </div></div></div>



</header>
<?php } /* webinar nos sale header */
?>



<?php include("inc/menu_flotante_2024.php"); ?>
