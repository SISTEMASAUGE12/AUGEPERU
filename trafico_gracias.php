<?php $pagina='webinar'; $pagina_gracias="gracias_trafico";
include('auten.php');   

$tit=' Gracias por registrarte | EducaAuge ';
$desss="Gracias por registrarte";
$imgtit='';

$meta= array(
'title' => ''.$tit,
'keywords' => $desss,
'description' => $desss,
'image' => $imgtit
);
include('inc/header.php');
?>

<main id="land" class="poppi">    

<?php if( isset($_SESSION['trafico']['id']) && $_SESSION['trafico']['id'] > 0 ){	 ?>

<div  class="callout banners text-left "><div class="fondo fondo3 " style="background-image:url(tw7control/files/images/webinars/KMD341.jpg);"><div class="row rel" style=" padding-bottom:25px;">
						<div class="medium-12  text-center columns"><img src="img/logo-rojo.png" class="rel " STYLE="z-index:99;"></div>
						<div class="medium-10 medium-centered columns">
							<h1 class="poppi-b  text-center">Hola 
								<?php echo (isset($_SESSION["suscritos"]["nombre"]) && !empty($_SESSION["suscritos"]["nombre"]) )?$_SESSION["suscritos"]["nombre"] : ' estimado docente ' ?> ! 
								</br><small>¡Gracias por registrarte!</small>
							</h1>
						</div>
						<div class="medium-8 medium-centered data_principal text-center columns" style="float:none;">							
								<figure class="rel ">
									<img src="img/webinar_externo.jpg" class="principal ">
								</figure>						
						</div>
						

						<div id="compi" style="padding-top:50px;" >
								
								<figure class="text-center"><a href="<?php echo $_SESSION['trafico']['link_wsp']; ?>" target="_blank">
									<img src="img/iconos/wasap_w3.svg">
								</a></figure>

								
								<ul class="no-bullet poppi float-right color1" style="padding-top:60px;">
										<li class="poppi"><em style="display:inline-block;padding-right:10px;">Compartir: </em> 
										<a title="Twitter" href="javascript: void(0);" onclick="window.open('https://twitter.com/intent/tweet?text=&url='+window.document.URL+'','ventanacompartir', 'toolbar=0, status=0, width=650, height=450');"><img src="img/iconos/twitter-b.png"></a> <a title="Facebook" href="javascript: void(0);" onclick="window.open('http://www.facebook.com/sharer.php?u='+window.document.URL+'','ventanacompartir', 'toolbar=0, status=0, width=650, height=450');"><img src="img/iconos/face-b.png"></a> <a title="Telegram" href="javascript: void(0);" onclick="window.open('https://telegram.me/share/url?url='+window.document.URL+'','ventanacompartir', 'toolbar=0, status=0, width=650, height=450');"><img src="img/iconos/telegram-b.png"></a> <a href="https://api.whatsapp.com/send/?phone&text=<?php echo 'https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'] ?>" target="_blank"><img src="img/iconos/wsp-b.png" style="margin-top:;"></a></li>
								</ul>
						</div>


					</div></div></div>
					
					<script>
						setTimeout(function () {
							location.href='<?php echo $_SESSION['trafico']['link_wsp']; ?>';
						}, 6000); //msj desparece en 5seg.
					</script>
				
					
					<div class="callout callout-testimonios  ingreso poppi "><div class="row">
								<?php $exitos=executesql(" select * from casos_de_exitos where estado_idestado=1 and link !='' order by orden desc ");
									if( !empty($exitos)){		
								?>
								<div class=" casos_exito text-center " >
									<h4 class="poppi-b  text-center "> <img src="img/iconos/ico-exito-azul.png" style="padding-right:10px;"> Casos de éxito </h4>
								
									<?php foreach( $exitos as $row ){		 ?>
										<?php if( !empty($row["imagen"])){ ?>
									<div class="large-3 medium-4 small-6  columns end " >
										<figure  CLASS="rel">
											<img src="tw7control/files/images/casos_de_exitos/<?php echo $row['imagen'] ?>" class="imagen_1" style="width:100%;">
												<?php if(!empty($row["link"]) ){ ?>
											<a class="abs mpopup-02" href="<?php echo $row['link'] ?>"><img src="img/iconos/ico-play-small.png" class="verticalalignmiddle"></a>
												<?php }?>

										</figure>
										<div class="lleva_name_testi"><p class="poppi texto ">	<?php echo $row['titulo']; ?> </p></div>
									</div>
										<?php } /* si registor un img  */ ?>
								<?php } /*for exitos */?>
									
								</div>
								<?php } /* si existe casos de exitos */?>
					</div></div>
	
<?php 
/* end si no exite sesion aun */
}else{
	echo '<section class="callout text-center"><div class="row"> <div class="large-12 columns" style="padding:190px 0;"> <h3 class="poppi-sb" style="padding-bottom:30px;">Ingresa un enlace válido </h3><a href="'.$url.'"><img src="img/logo_auge.png"></a></div></div> </section>';
}
?>
</main>
<?php include ('inc/footer.php'); ?>