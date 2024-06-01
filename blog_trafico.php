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

	$bd=new BD;
	// date_default_timezone_set('America/Lima');
	// $autos = json_decode(file_get_contents('https://api.ipify.org/?format=json'), true);
	// $ip =  $autos['ip'];
	
	
	// echo "select * from contador where publica='".$idep."' and ipe='".$ip."' "; 
	// $valido_vistas= executesql("select * from contador where publica='".$idep."' and ipe='".$ip."' ");
	
	
	/* si no existe registramos */ 
	
	// if( empty($valido_vistas) ){ 
		// $campos=array(array('publica',$idep),array('ipe',$ip),array('fecha',$fecha));
		// $bd->inserta_(arma_insert('contador',$campos,'POST'));
	// }else{ /* cuento cada visita: para evitar los errores delas ip vacias o en blanco que no deja sumar el contador .. */
		/* echo "si gustas esto deshbailita cada vez q ingresen contarar 1, no valida a 1 vista por ip. "; */ 
		// $campos=array(array('publica',$idep),array('ipe',$ip),array('fecha',$fecha));
		// $bd->inserta_(arma_insert('contador',$campos,'POST'));
	// }
	

}else{
  	$meta = array(
    	'title' => 'Educa Auge: Blog',
    	'description' => ''
	);
}

include ('inc/header_solo_logo.php');
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
			</div>
			<div class="parte-medio">
				<h1 class="color1 poppi-b"><?php echo $bloga['titulo'] ?></h1>
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
				<div class="imagenmedio" style="padding-top:0;" >
					<img src="tw7control/files/images/publicaciones/<?php echo $bloga['imagen'] ?>">
					<span class="poppi texto"><?php echo $bloga['credito'] ?></span>
				</div>
			<?php } ?>
		</div>
		
		<div class="large-12 columns" style="padding:10px;">
			<ul class="no-bullet color1 compa" style="max-width:950px;margin:0 auto;">							
						<?php  /* mandar la grupo de wasap */
							 if(!empty($bloga['link_grupo_wasap']) ){ ?>
							<li class="  text-center ">
								<h4 class="poppi-b color2 " style="padding-bottom: 15px;">Unete a nuestro grupo de WhatsApp</h4>
								<a href="<?php echo $bloga['link_grupo_wasap']; ?>"  class="unete_wsp" target="_blank">
									<img src="img/iconos/unete_wasap.png">
								</a>
								<p class="poppi-sb" style="padding-top: 12px;"> Para mantenerte informado de las últimas novedades </br> del concurso de nombramiento</p>
							</li>
					<?php  }else{ // sino han registrado link envio al canal  ?>
								<li class="  text-center ">
									<h4 class="poppi-b color2 " style="padding-bottom: 15px;">Descubre nuestras promociones<span> Chat en vivo</span></h4>
									<a href="<?php echo $link_grupo_wasap; ?>"  class="unete_wsp" target="_blank">
										<img src="img/iconos/unete_wasap.png">
									</a>
									<p class="poppi-sb" style="padding-top: 12px;"> Para mantenerte informado de las últimas novedades </br> del concurso de nombramiento</p>
								</li>
							<?php } ?>
				</ul>
		</div>
		
		<div class="large-12 columns" style="padding-bottom:100px;">
			<div class="parte-medio descr">
				<?php echo $bloga['descripcion'] ?>
			</div>
			<div class="parte-medio text-center  hide  " style="margin-top:60px;">
				<a href="<?php echo $link_grupo_wasap; ?>" title="  canal_wsp_flota" target="_blank" class=" canal_wsp_flota  poppi  "  >
					<img src="img/iconos/wspf.png" alt="Únete a nuestro  canal de whatsApp "> Únete al canal de whatsApp <span>de Grupo Auge  </span>
				</a>
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
		
		<div class="large-12 columns    hide  " style="padding:10px;">
			<ul class="no-bullet color1 compa" style="max-width:950px;margin:0 auto;">							
						
				<li class="  text-center ">
					<h4 class="poppi-b color2 " style="padding-bottom: 15px;">Unete a nuestro grupo de WhatsApp</h4>
					<a href="<?php echo $link_grupo_wasap; ?>"  class="unete_wsp" target="_blank">
						<img src="img/iconos/unete_wasap.png">
					</a>
					<p class="poppi-sb" style="padding-top: 15px;"> Para mantenerte informado de las últimas novedades </br> del concurso de nombramiento</p>
				</li>
			</ul>
		</div>
		
		<section class="social contenido medium-8 medium-centered  columns" style="float:none;">										
			<h6 class="osans" style="padding-top:30px;"><b>FORO:</b></h6>         
			<div class="fb-comments" data-href="<?php echo 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; ?>" data-width="800" data-numposts="15"></div>
			
			<div class="boton_volver text-center "  style="padding-top:120px;">
				<a href="curso/todos" class="poppi boton ">Ver cursos</a>
			</div>															
		</section>
	
	</div></div>
<?php 
		}  /*  	END  contenido free */
		
// Listado segun categoria ..
	}else{
?>
	<div class="callout callout-1"><div class="row row3 listado text-center ">
	<p> No se encontro contenido ..</p>
	</div></div>
<?php
	}
?>
</main>
<?php 
$pagina="blog_trafico";
include ('inc/footer.php'); ?>