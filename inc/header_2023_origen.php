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
		<!-- 
			-->
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
		// echo '<link rel="stylesheet" href="css/registro_version_2.css?ud='.$unix_date.'" />';
		
		
	// echo ($pagina=="cursos") ? '<link rel="stylesheet" href="css/cursos.css?ud='.$unix_date.'" />' : "";
	echo ($pagina=="cursos") ? '<link rel="stylesheet" href="css/cesta.css?ud='.$unix_date.'" />' : "";
    echo ($pagina=="noso") ? '<link rel="stylesheet" href="css/nosotros.css?ud='.$unix_date.'" />' : "";
    echo ($pagina=="miembros") ? '<link rel="stylesheet" href="css/miembros.css?ud='.$unix_date.'" />' : "";
    echo ($pagina=="preguntas_frecuentes") ? '<link rel="stylesheet" href="css/preguntas_frecuentes.css?ud='.$unix_date.'" />' : "";
    echo ($pagina=="examen") ? '<link rel="stylesheet" href="css/examen.css?ud='.$unix_date.'" />' : "";
    
	 echo ($pagina=="portada") ? '<link rel="stylesheet" href="css/portada.css?ud='.$unix_date.'" />' : "";
    // echo ($pagina=="portada") ? '<link rel="stylesheet" href="css/portada_2024.css?ud='.$unix_date.'" />' : "";

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
		<a href="https://api.whatsapp.com/send?phone=+51915152861&text=Hola%20Grupo%20AUGE%20Quiero%20Informaci%C3%B3n"  target="_blank" alt="whatsapp"><img src="img/iconos/whatsapp.png" alt="whatsapp" width="50px"> <span class=" "> WhatsApp</span></a>
</div>
<div class=" telefono_flotante poppi-sb  hide ">
	<a href="tel:915152861"><img src="img/iconos/phone.png"> 915152861 </a>
</div>
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
				<button type="button" class="block-n cierra" data-toggle="offCanvasLeftSplit1"><img src="img/iconos/cerrar.png" class=""></button>
				<img src="img/logo_auge.png" alt="educaauge.com">
		</div>
	<?php if(!empty($_SESSION["suscritos"]["id_suscrito"])){ ?>
		<div class="fondo banner-1 text-right">
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
				<li class="<?php echo ($pagina=="cursos") ? "active " : ""; ?>"><a  title="comprar cursos" href="curso/todos">Cursos</a></li>
				<!-- 
				<li class="<?php echo ($pagina=="serv") ? "active " : ""; ?>"><a href="">Exámenes</a></li>
				-->

				<!-- 
				<li class="<?php echo ($pagina=="libros") ? "active " : ""; ?>"><a href="libro/todos-los-libros">Libros</a></li>
			-->
				<li class="<?php echo ($pagina=="blog") ? "active " : ""; ?>"><a href="blog"  title="visita el blog">Blog</a></li>

				<?php 
				 /* link coutoria */
				 $link_coautoria=( isset($_SESSION["coautoria"]) && !empty($_SESSION["coautoria"])  && $_SESSION["coautoria"]["rewrite"]==1)?'coautoria/todos-los-libros-coautoria':'coautoria';
				?>
				<!-- 
				<li class="<?php echo ($pagina=="coautoria") ? "active " : ""; ?>"><a href="<?php echo $link_coautoria; ?>">Coautoría</a></li>
			-->

				
				<li class="<?php echo ($pagina=="testimonios") ? "active " : ""; ?>"><a href="testimonios"  title="testimonios">Testimonios</a></li>

				<li class="<?php echo ($pagina=="noso") ? "active " : ""; ?>"><a href="nosotros"  title="nosotros">Nosotros</a></li>
			<?php if(!empty($_SESSION["suscritos"]["id_suscrito"])){ ?>
			<!-- 
				<li class="<?php echo ($pagina=="serv") ? "active " : ""; ?>"><a href="perfil/certificados">Certificados</a></li>
				-->
				<li class="<?php echo ($pagina=="serv") ? "active " : ""; ?>"><a href="certificados"  title="certificados">Certificados</a></li>
	<?php } ?>
				<li class="<?php echo ($pagina=="blog") ? "active " : ""; ?>"><a href="blog"  title="Blog">Publicaciones</a></li>
				<!-- 
				-->
				<li class="<?php echo ($pagina=="clie") ? "active " : ""; ?>"><a href="eventos"  title="eventos">Eventos Gratuitos</a></li>

				<li class="<?php echo ($pagina=="clie") ? "active " : ""; ?>"><a href="contacto"  title="contactenos">Contáctanos</a></li>
				<li class="<?php echo ($pagina=="tutoriales") ? "active " : ""; ?>"><a href="tutoriales"  title="tutoriales  ">Tutoriales</a></li>
			</ul>
	 <?php if(!empty($_SESSION["suscritos"]["id_suscrito"])){ ?>
			<div id="menu_perfil" class="large-2 menu_perfil columns block-n">
				<?php include("inc/menu_perfil.php");?>
        <a class="poppi-sb cesti" style="margin-top:20px;" href="cesta"  title="ver carrito ">Ver carrito</a>
			</div>
	<?php }else{ ?>
	<!-- 
        <a  href="registro" class="poppi-sb boton llama_al_registro ">Regístrate</a>
        <a  href="iniciar-sesion_v2" class="llama_al_login poppi-sb boton boton2 ">Ingresa</a>
				-->


				<a href="actualiza-tus-datos" class="poppi-sb boton llama_al_registro "  title="registrate">Regístrate</a>
				<a  href="iniciar-sesion_v2" class=" poppi-sb boton boton2 " >Iniciar sesión</a>
				<!-- v2  * login flotante 
				<span  class="llama_al_login poppi-sb boton boton2 "  title="ingresa">Ingresa</span> 
				-->
        <a class="poppi-sb cesti" href="cesta"  title="ver carrito ">Ver carrito</a>
    <?php } ?>
		</nav>
	</div> <!-- cuerrpo -->
</div>
<!-- menu responsive "left"  -->
<!-- end menu left  -->

<header>
	<?php if(isset($_SESSION["suscritos"]["id_suscrito"]) && !empty($_SESSION["suscritos"]["id_suscrito"])){ ?>
    <div class="callout callout-logeado"><div class="row"><div class="large-12 columns">
				<?php include("inc/menu_perfil_logeado.php");?>
		</div></div></div>
	<?php } ?>	
	
    <div class="callout"><div class="row"><div class="large-12 columns">
        <div class="float-left lleva_el_logo "><a class="logo" href="https://www.educaauge.com" title="ir inicio"><img src="img/logo_auge.png" alt="educaauge.com"/></a></div>
        
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
				<li class="carrito aparecer " ><a href="cesta" title="ir a pagar"><img src="img/iconos/carrito_2023.png" alt="carrito de compras"><span class="monset  articulos_total "></span></a></li>
				<button type="button" class=" menu_bar block-n" data-toggle="offCanvasLeftSplit1"><img src="img/iconos/menu.png" alt="menu" class=""></button>
			</div>	
	<?php if( !isset($_SESSION["suscritos"]["id_suscrito"]) && empty($_SESSION["suscritos"]["id_suscrito"])){  ?>
			<div class="float- lleva_link_acceso aparecer poppi-sb  rel">
				<a href="registrate_v2"  title="registrate"><p>Regístrate</p></a>
			<!-- modal flotrante 
				<span class="llama_al_login"  title="ingresa "><p>Ingresar</p></span> 
			-->
				<a  href="iniciar-sesion_v2" class=" poppi-sb  " >Iniciar sesión</a>
			</div>
	<?php } ?>		

			<nav>
				<ul class="no-bullet poppi">
					<li class="<?php echo ($pagina=="cursos")?"active ":""; ?> submenu">
						<a href="curso/todos"  title="comprar cursos ">Cursos</a>
			<?php /* 
						<div class="children"><div class="cuadro"><ul class="no-bullet">
	<?php
						$sql = executesql("SELECT * FROM tipo_cursos WHERE estado_idestado = 1 ORDER BY titulo ASC");
						$it=1;
						if($sql){ foreach($sql as $row){
							echo ($it & 1) ? '<div class="large-6 medium-6 columns">' : ''; // si es impar "& 1"
	?>
							<li>
								<a class="poppi-sb" href="curso/<?php echo $row['titulo_rewrite']; ?>"><?php echo $row['titulo']; ?></a>
	<?php $sql2 = executesql("SELECT c.*, ca.titulo_rewrite AS catrewri, sc.titulo_rewrite AS subrewri, tc.titulo_rewrite AS tiprewri FROM cursos c INNER JOIN categoria_subcate_cursos csc ON c.id_curso = csc.id_curso INNER JOIN categorias ca ON csc.id_cat = ca.id_cat INNER JOIN subcategorias sc ON csc.id_sub = sc.id_sub INNER JOIN tipo_cursos tc ON csc.id_tipo = tc.id_tipo WHERE c.estado_idestado = 1 AND tc.id_tipo =".$row['id_tipo']." Group BY c.id_curso ORDER BY c.orden DESC");
								if($sql2){ echo '<ul class="no-bullet">'; foreach($sql2 as $row2){ ?>
									<li>
																		<a href="<?php echo 'curso/'.$row2['tiprewri'].'/'.$row2['catrewri'].'/'.$row2['subrewri'].'/'.$row2['titulo_rewrite'] ?>" ><?php echo $row2['titulo']; ?></a>
																	</li>
	<?php } echo '</ul>'; } ?>
							</li>

	<?php
						echo ($it & 1) ? '' : '</div>'; // si es impar vacio; par cierro div
	$it++; } } ?>
						</ul></div></div>
											*/ ?>
											
					</li>
				<!-- 
					<li class="<?php echo ($pagina=="serv") ? "active " : ""; ?>"><a href="">Exámenes</a></li>
				-->
				<!-- 
					<li class="<?php echo ($pagina=="libros") ? "active " : ""; ?>"><a href="libro/todos-los-libros">Libros</a></li>
				-->
					<li class="<?php echo ($pagina=="blog") ? "active " : ""; ?>"><a  title="blog" href="blog">Blog</a></li>
				<!-- 
					<li class="<?php echo ($pagina=="coautoria") ? "active " : ""; ?>"><a href="<?php echo $link_coautoria; ?>">Coautoría</a></li>
				-->
					<li class="<?php echo ($pagina=="testimonios") ? "active " : ""; ?>"><a  title="testimonios" href="testimonios">Testimonios</a></li>

		<?php if(!empty($_SESSION["suscritos"]["id_suscrito"])){ ?>
				<!--
					<li class="<?php echo ($pagina=="serv") ? "active " : ""; ?>"><a href="perfil/certificados">Certificados</a></li>
				-->
					<li class="<?php echo ($pagina=="serv") ? "active " : ""; ?>"><a href="certificados"  title="certificados">Certificados</a></li>
		<?php } ?>
					<li class="<?php echo ($pagina=="noso") ? "active " : ""; ?>"><a href="nosotros"  title="nosotros">Nosotros</a></li>
				<!--
					<li class="<?php echo ($pagina=="blog") ? "active " : ""; ?>"><a href="blog">Publicaciones</a></li>
				-->

					<li class="<?php echo ($pagina=="clie") ? "active " : ""; ?>"><a href="tutoriales"  title="tutoriales">Tutoriales </a></li>
			<!--
					<li class="btn poppi-sb" >
						<a href="https://app.toky.co/AUGEPER" alt="llamar" style=" padding: 9px 13px;background:transparent;color:#fff;border:1px solid #fff;" >
							<img src="img/iconos/telfijo.png" alt="llamanos gratis" style="padding-right:5px;margin-top:-3px;"> Llamar gratis 
						</a>
					</li>
		-->
					<li class="btn poppi-b" >
						<a href="https://app.toky.co/AUGEPER" alt="llamar" style=" padding: 9px 13px;background:transparent;color:#fff;border:0;" >Llamar gratis </a>
					</li>
					<li class="carrito"><a href="cesta"  title="carrito "><img src="img/iconos/carrito_2023.png" alt="carrito de compras"><span class="monset  articulos_total "></span></a></li>
			<?php  if(isset($_SESSION["suscritos"]["id_suscrito"]) && !empty($_SESSION["suscritos"]["id_suscrito"])){ 
				/*
			?>
					<li>
							<a class="llamar-menu-xl block-b">
							<?php if(!empty($perfil[0]["nombre"])){ ?>
								<p id="name_perfil" class=" name_perfil"><?php echo $perfil[0]["nombre"]; ?><span></span></p>
							<?php }else{ ?> <p class="name_perfil"><?php echo $perfil[0]["email"]; ?><span></span></p><?php } ?>
							</a>
							<div id="menu_perfil" class="large-2 medium-2 menu_perfil columns osans block-b hide">
								<?php include("inc/menu_perfil.php");?>
							</div>
					</li>
			<?php 
								*/
					}else{ ?>
				<!--  2022
					<li class="btn poppi-sb"><a href="registro">Regístrate</a></li>
					<li class="btn btn2 poppi-sb"><a href="iniciar-sesion_v2">Ingresa</a></li>
				-->
					<li class="btn poppi-sb"><a href="actualiza-tus-datos"  title="registrate aqui">Regístrate</a></li>
					<li class="btn btn2 poppi-sb  "><a href="iniciar-sesion_v2" style="padding: 8px;padding-right: 20px;border-radius: 20px;">Iniciar sesión</a></li>


					
				<!-- 
					<li class="btn btn2 poppi-sb llama_al_login "><span  title="ingresa aqui">Ingresa</span></li>
				-->
						
			<?php } ?>
            	</ul>
			</nav>
        </div>
<?php } ?>
    </div></div></div>

</header>
<?php } /* webinar nos sale header */

?>

