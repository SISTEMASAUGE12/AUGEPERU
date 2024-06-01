<?php  
$pagina='blog';
include('auten.php'); $_SESSION["url"]=url_completa(); 
$fecha=fecha_hora(2);

if(isset($_GET['rewrite2']) && !empty($_GET['rewrite2'])){
  	$sql="SELECT * FROM publicacion WHERE estado_idestado=1 and titulo_rewrite='".$_GET['rewrite2']."' order by orden desc  ";
  	$rs = executesql($sql);
  	if(!empty($rs)){
  		$idep = $rs[0]["idpublicacion"];
    	$tit=$rs[0]["titulo"];
    	$desss=$rs[0]["avance"];
    	$imgtit='tw7control/files/images/publicaciones/'.$rs[0]['imagen'];
  	}else{
    	$tit="Blog | GRUPO AUGE ";
    	$desss="";
    	$imgtit="";
  	}

  	$meta= array(
		'title' => $tit.' | Blog | GRUPO AUGE ',
		'keywords' => $desss,
		'description' => $desss,
		'image' => $imgtit
	);


	/* 
	$bd=new BD;

	date_default_timezone_set('America/Lima');
	$autos = json_decode(file_get_contents('https://api.ipify.org/?format=json'), true);
	$ip =  $autos['ip'];
	
	
	// echo "select * from contador where publica='".$idep."' and ipe='".$ip."' "; 
	$valido_vistas= executesql("select * from contador where publica='".$idep."' and ipe='".$ip."' ");
	// si no existe registramos 
	
	if( empty($valido_vistas) ){ 
		$campos=array(array('publica',$idep),array('ipe',$ip),array('fecha',$fecha));
		$bd->inserta_(arma_insert('contador',$campos,'POST'));
		// echo "reg";
	}else{ // cuento cada visita: para evitar los errores delas ip vacias o en blanco que no deja sumar el contador .. 
		// echo "si gustas esto deshbailita cada vez q ingresen contarar 1, no valida a 1 vista por ip. ";
		$campos=array(array('publica',$idep),array('ipe',$ip),array('fecha',$fecha));
		$bd->inserta_(arma_insert('contador',$campos,'POST'));
	}
	*/


}else{
  	$meta = array(
    	'title' => 'Educa Auge: Blog',
    	'description' => ''
	);
}

include ('inc/header.php');
?>
<main id="blog"  class=" <?php if(isset($_SESSION["suscritos"]["id_suscrito"]) && !empty($_SESSION["suscritos"]["id_suscrito"])){ echo "logeado"; }?> ">
<?php
	if(isset($_GET['rewrite2']) && !empty($_GET['rewrite2'])){
	
	$sql_="SELECT p.*, cb.login as login_req FROM publicacion p INNER JOIN categoriablogs cb ON p.tipo=cb.tipo  WHERE p.estado_idestado = 1 AND p.titulo_rewrite = '".$_GET['rewrite2']."'";
	
	$bloga = executesql($sql_,0);
	
	
	$sql_2="SELECT count(*) as total_vistas FROM contador WHERE publica=".$bloga['idpublicacion']; 
	
	$conta = executesql($sql_2);
	
	if( $bloga['login_req'] == '1' && !isset($_SESSION["suscritos"]["id_suscrito"]) ){  /* Si es contenido exclusivo, debe registrarse y estar logeado .. */
			/* 2:: recursos para docentes .. */
			// echo "AAA";
	?>
			<script>
				alert("Hola, debes Iniciar sesión en EducaAuge, para poder acceder a este contenido. ");
				console.log(" contenido exclusivo ");
				// location.href='registro';
				location.href='actualiza-tus-datos';
			</script>
			
	<?php 	
	}else{ /* cont general - free  */
			// echo "AAA 123";
?>
	<div class="callout callout-2"><div class="row ">
		<div class="large-12 columns">
			<div class="boton_volver ">
				<a href="blog" class="poppi boton ">Regresar al blog</a>
			</div>
			<div class="parte-medio">
				<h1 class="color1 poppi-b"><?php echo $bloga['titulo'] ?></h1>
				<ul class="no-bullet color1 compa">
				<!-- 
					<li class="poppi-sb">
						<img src="img/iconos/ojo.png"> 
						<?php 
						// if( $bloga['idpublicacion'] == '11'){ 
							// echo count($conta)+2042;
						
						// }else if($bloga['idpublicacion'] == '10'){
							// echo count($conta)+2467;
							
						// }else{ 
							// echo count($conta);
						// }
						
					
							echo $conta[0]['total_vistas'];
						?>
							Vistos
					</li>
					-->
					
					<li class="poppi">Comparte en tus redes sociales:<a title="Twitter" href="javascript: void(0);" onclick="window.open('https://twitter.com/intent/tweet?text=&url='+window.document.URL+'','ventanacompartir', 'toolbar=0, status=0, width=650, height=450');"><img src="img/iconos/twitter-b.png"></a> <a title="Facebook" href="javascript: void(0);" onclick="window.open('http://www.facebook.com/sharer.php?u='+window.document.URL+'','ventanacompartir', 'toolbar=0, status=0, width=650, height=450');"><img src="img/iconos/face-b.png"></a> <a title="Telegram" href="javascript: void(0);" onclick="window.open('https://telegram.me/share/url?url='+window.document.URL+'','ventanacompartir', 'toolbar=0, status=0, width=650, height=450');"><img src="img/iconos/telegram-b.png"></a> <a href="https://api.whatsapp.com/send/?phone&text=<?php echo 'https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'] ?>" target="_blank"><img src="img/iconos/wsp-b.png"></a></li>
					<!-- 
					<li>	<a href="blog" class="boton  ">volver al blog </a> </li>
					-->
				</ul>
				
			</div>
		</div>
		
		<div class="large-12 nothing text-center columns">
				<?php if(!empty($bloga['link']) ){ 
							$video= explode('watch?v=',$bloga['link']);
							$clemb= strpos($video[1],'&');
							$emb=substr($video[1],0,$clemb);
							$embed=($clemb !==false)?$emb:$video[1]; ?>
          <aside>                       
						<div class="para-video">
							<iframe width="100%" class="height-video-you" src="https://www.youtube.com/embed/<?php echo $embed; ?>" frameborder="0" allowfullscreen></iframe>
						</div>                         
          </aside>
			<?php }else{ ?>
				<div class="imagenmedio">
					<img src="tw7control/files/images/publicaciones/<?php echo $bloga['imagen'] ?>">
					<span class="poppi texto"><?php echo $bloga['credito'] ?></span>
				</div>
			<?php } ?>
		</div>
		
		<div class="large-12 columns" style="padding-bottom:100px;">
			<div class="parte-medio descr">
				<?php echo $bloga['descripcion'] ?>
			</div>
		</div>
		
			
			<?php 
			$categ_recursos=executesql("select * from categoria_archivos_blog where estado_idestado=1 and publicacion_idpublicacion='".$bloga['idpublicacion']."' ");
			if( !empty($categ_recursos)){
			?>
		<div class="large-12 columns lleva_recursos" style="padding-bottom:100px;">	<div class="parte-medio descr">
			<h3 class="poppi-sb ">Recursos <small>[click para descargar archivo]</small></h3>
			<?php
					foreach($categ_recursos as $categ){
			?>
			<h4 class="poppi-sb ">	<?php echo $categ['titulo'] ?></h4>
						<?php 
						$archivos=executesql("select * from archivos_blog where estado_idestado=1 and publicacion_idpublicacion='".$categ['publicacion_idpublicacion']."'  and categoria_idcategoria='".$categ['idcategoria']."' ");
						if( !empty($archivos)){
								foreach($archivos as $data){
						?>
							<p><a href="tw7control/files/files/blog_recursos/<?php echo $bloga['idpublicacion'].'/'.$data['archivo']?>" target="_blank"><?php echo $data['titulo'] ?></a></p>
						<?php 
								}
						}
						?>
						
			<?php 
					}
					?>
		</div></div>
		<?php 
			}
			?>
		
		<div class="large-12 nothing text-center columns">
			<?php if(!empty($bloga['link_externo']) ){ 
							$video= explode('watch?v=',$bloga['link_externo']);
							$clemb= strpos($video[1],'&');
							$emb=substr($video[1],0,$clemb);
							$embed=($clemb !==false)?$emb:$video[1]; ?>
          <aside>                       
						<div class="para-video">
							<iframe width="100%" class="height-video-you" src="https://www.youtube.com/embed/<?php echo $embed; ?>" frameborder="0" allowfullscreen></iframe>
						</div>                         
          </aside>
			<?php } ?>
		</div>
		
		<section class="social contenido medium-8 medium-centered  columns" style="float:none;">		
			<div class="fb-like" data-href="https://web.facebook.com/www.augeperu.org" data-width="" data-layout="" data-action="" data-size="" data-share="true"></div> <!--  likes -->
			<h6 class="osans" style="padding-top:30px;"><b>FORO:</b></h6>         
			<div class="fb-comments" data-href="<?php echo 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; ?>" data-width="800" data-numposts="15"></div>
			
			<div class="boton_volver text-center "  style="padding-top:10px;float:none;">
				<a href="curso/todos" class="poppi boton ">Ver cursos</a>
			</div>															
		</section>	
		
	</div></div>

	
	<div class="formulario_blog poppi">
		<div class=" _cabezera_form_blog ">
			<img src="img/cancel.png" class=" cerrar_suscribete_blog ">
			<figure><img src="img/correo-suscripcion-imagen-popup-post.png"></figure>
			<h3 class=" blanco poppi-sb "> Suscríbete a </br> Educa Auge</h3>
		</div>
		<p class=" text-center " >Únete y recibe las últimas novedades en tu email</p>
		<form action="btn_suscribete_blog" method="post">
			<input type="text" name="name_blog" required id="name_blog" placeholder="Nombre">
			<input type="email" name="email_blog" required id="email_blog" placeholder="Email">
			<input id="consentimiento" name="consentimiento" type="checkbox" class="acepta_politicas " required checked="checked" /><span>Acepto las politicas</span>
			<button class="boton poppi-sb   " style="margin:10px auto 0;">Suscríbete </button>
		</form>
	</div>

<?php 
		}  /*  	END  contenido free */
		
// Listado segun categoria ..
	}elseif(isset($_GET['rewrite']) && !empty($_GET['rewrite'])){
?>
	<div class="callout callout-1"><div class="row row3 listado ">
<?php
		$blog1 = executesql("SELECT  c.titulo as categ, c.titulo_rewrite as tipo_rew FROM  categoriablogs c  WHERE  c.titulo_rewrite='".$_GET['rewrite']."' ");
 ?> 
		<div class="large-12 columns"><h1 class="poppi-b color1"><a href="blog" style="color:#333;">Blog </a> >  <small style="color:#444;"><?php echo $blog1[0]["categ"];?></small> </h1></div>
		<div class="large-10 large-centered columns" style="float:none;">
			<?php include("listado_blog_x_categoria.php"); ?>
		</div>

	</div></div>
	<!-- end listado categoria -->
<?php
	}else{  // listado generarl 
?>

<?php /*
<div class="callout banners">
	<div class="fondo banner-portada rel" style="background-image:url(img/banners/XWJK43.jpg);"><div class="capa">
			<div class="row">
			<?php
         if(isset($_SESSION["suscritos"]["id_suscrito"]) and !empty($_SESSION["suscritos"]["id_suscrito"]) && empty($_GET['rewrite4']) ){  
            $offset='6';
						$padding="padding-bottom:90px;";
					}else{
						$offset='4';
						$padding="padding-bottom:20px;";
         }?>
				<div class="large-offset-<?php echo  $offset; ?> large-4  medium-6 columns medium-text-left text-center blanco ">			
						<h3 class="poppi bold color-blanco">Blog EducaAuge</h3>
						<p style=" <?php echo $padding; ?>">Ya somos más de 50 mil profesores que hemos logrado nuestros objetivos gracias a GRUPO AUGE </p>
				</div>
				<div class=" large-4  medium-6  columns medium-text-right text-center blanco ">
				<?php 
                                if(isset($_SESSION["suscritos"]["id_suscrito"]) && !empty($_SESSION["suscritos"]["id_suscrito"])){ 
                                }else{
                                    include('inc/formulario_registro_banner.php');
                                }
                ?>
				</div><!-- end l4 -->
			</div>
		</div></div>
</div> <!--  end banner -->
*/ ?> 

	<div class="callout callout-1"><div class="row row3">
		<div class="large-12 columns">
			<h1 class="poppi-b color1">Blog</h1>
		</div>
		<div class="large-4 medium-4 catego columns">
			<h5 class="poppi-b color1">Temas a seguir</h5>
<?php
        	$ses = executesql("SELECT * FROM categoriablogs WHERE estado_idestado = 1 ORDER BY ORDEN ASC");
        	if(!empty($ses)){ foreach($ses as $sesi){
?>
			<div class="separar"><p class="poppi-b color1"><?php echo $sesi['titulo'] ?><a href="blog/<?php echo $sesi['titulo_rewrite'] ?>" class="poppi-sb boton">Ver ahora</a></p></div>
<?php
			} }
?>
<!--
			<a class="bota">Leer más</a>
			-->
		</div>
		<div class="large-8 medium-8 nothing columns">
				<div id="listado_blog" class="load-content"><p class="text-center" style="padding:110px 0;">Espere mientras listado se va cargando...</p></div>
		</div>
		<!-- 
		<div class="clearfix clearfix2"></div>
		-->
	</div></div>
<?php
	}
?>
</main>
<?php include ('inc/footer.php'); ?>