<?php $pagina='webinar';
include('auten.php');   


if(isset($_GET['rewrite']) && !empty($_GET['rewrite'])){
	$_SESSION["url"]='clase_vivo/'.$_GET['rewrite']; // redireciona aui el registro 

	$sql="SELECT * FROM clases_en_vivos WHERE estado_idestado=1 and titulo_rewrite='".$_GET['rewrite']."' and estado_idestado=1 order by orden desc limit 0,1 ";
	$clases_en_vivos = executesql($sql);
	if(!empty($clases_en_vivos[0])){
		$tit='Clase en vivo:: '.$clases_en_vivos[0]["titulo"].' | EDUCA AUGE ';
		$desss=$clases_en_vivos[0]["detalle_1"];
		$imgtit='tw7control/files/images/clases_en_vivos/'.$clases_en_vivos[0]['imagen'];			

	}else{
		$tit="clase no encontrado | GRUPO AUGE ";
		$desss="";
		$imgtit="";
	}

	$meta= array(
		'title' => ''.$tit,
		'keywords' => $desss,
		'description' => $desss,
		'image' => $imgtit
	);
	
}else{ 	
	$meta = array(
			'title' => '	Clase en vivo: | Educa Auge',
			'description' => ''
	);
}

include('inc/header.php');
?>

<main id="land" class="poppi">    
<?php 
if( !empty($_GET["rewrite"]) ){ 

	if( !empty($clases_en_vivos) ){
		
		if( (isset($_SESSION["suscritos"]["id_suscrito"]) && $_SESSION["suscritos"]["id_suscrito"] > 0 ) ){
		
			/* tiene acceso al clase en vivo  */
			$sql_c=" SELECT * FROM suscritos_x_cursos c WHERE c.estado_idestado = 1  and c.id_curso = '".$clases_en_vivos[0]['id_curso']."' and c.id_suscrito = '".$_SESSION["suscritos"]["id_suscrito"]."' ORDER BY c.ide DESC ";
			// echo $sql_c;
			$acceso_al_curso = executesql($sql_c);
						
			if( !empty($acceso_al_curso) && $acceso_al_curso[0]['estado_idestado'] ==1 ){ // si tiene acceso al curso y esta activo. ?>

				<div  class="callout banners text-left "><div class="fondo fondo3 " style="background-image:url(img/banners/fondo_clase_en_vivo.jpg);"><div class="row rel">
				<div class="medium-12 columns">
					<img src="img/logo-rojo.png" class="rel " STYLE="z-index:99;">
				</div>
				<div class="medium-10 medium-centered columns">
					<h1 class="poppi-b  text-center" style="padding-bottom:10px;">Clase:  <?php echo $clases_en_vivos[0]['titulo']; ?></h1>
					<h3 class="poppi-b  text-center" style="padding-bottom:30px;">Hola <?php echo $perfil[0]["nombre"]; //$_SESSION["webinar"]["nombre"]; ?>! <small class="color1 ">Bienvenido al Grupo AUGE</small></h1>
				</div>
										
			<?php 
			if(!empty( $clases_en_vivos[0]['link_video'])){  /* video trailer */ ?>
				<div class="  <?php echo !empty($clases_en_vivos[0]['link_chat'])?'medium-8 ':' medium-12 ';?>   medium data_principal text-center columns">
					<div class="rel lleva_vimeo_listado">
						<iframe src="<?php echo $clases_en_vivos[0]['link_video']; ?>"  frameborder="0" allow="autoplay; fullscreen" allowfullscreen></iframe>
					</div>
				</div>									
			<?php }else{ ?>
				<div class="medium-12  medium data_principal text-center columns">
					<figure class="rel ">
						<img src="img/img_no_video.jpg" class="principal ">
					</figure>
				</div> <!-- * este ciere de div-->
			<?php }  ?>
																			
			<?php  
			if( !empty($clases_en_vivos[0]['link_chat']) ){ 
			?>
				<div class="medium-4 medium columns">
					<div class="fond"><iframe src="	<?php echo $clases_en_vivos[0]['link_chat']; ?>"  frameborder="0" class="lleva_chat_vimeo" allow="autoplay; fullscreen" allowfullscreen></iframe></div>
				</div>
			<?php } ?>
																																										
			</div></div></div>
			<div class="callout callout-1  ingreso poppi "><div class="row">
					<section class="social contenido medium-10 medium-centered  columns" style="float:none;">										
						<h6 class="osans" style="padding-top:30px;"><b>FORO:</b></h6>         
						<div class="fb-comments" data-href="<?php echo 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; ?>" data-width="800" data-numposts="15"></div>
					</section>
			</div></div></div>

<?php 		
			}else{  // sino tiene acceso al curso
				echo '<section class="callout text-center "><div class="row"><div class="large-12 columns" style="padding:190px 0;"> <h3 class="poppi-sb" style="padding-bottom:30px;"> Ingresa a mis cursos comprados en el siguiente enlace .. <a href="www.educaauge.com/mis-cursos">[click aquí]</a></br></h3><a href="'.$url.'"><img src="img/logo_auge.png"></a></div> </div> </section>';
			}	 // end si tiene acces o al curso 			
			/* END SI YA SE LOGEO */ 

		}else{ 		/* SI NO se logea   */		
?>
<div  class="callout banners text-left "><div class="fondo fondo3 " style="background-image:url(img/banners/fondo_clase_en_vivo.jpg);"><div class="row rel">
		<div class="medium-12 columns">
			<img src="img/logo-rojo.png" class="rel " STYLE="z-index:99;">
		</div>
		<div class="medium-10 medium-centered columns" style="float:none!important;">
			<h3 class="poppi-b  text-left color2 " style="padding:95px 0 0;line-height:20px;"><?php echo $clases_en_vivos[0]['ante_titulo']; ?></h3>
			<h1 class="poppi-b  text-center" style="padding-top:10px;"><?php echo $clases_en_vivos[0]['titulo_1']; ?></h1>
		</div>
		<div class="medium-7 medium data_principal registro text-center columns">
		<!--
			<p class=" poppi text-left"><?php echo $clases_en_vivos[0]['detalle_1']; ?></p>
		-->
			<?php if( !empty($clases_en_vivos[0]['imagen']) ){  ?> 
					<img src="tw7control/files/images/clases_en_vivos/<?php echo $clases_en_vivos[0]['imagen']; ?>">
			<?php } ?>													
						
		</div>
		<div class="medium-5 medium columns end ">
			<div class="fond">
			<p class="color4 poppi text-center" style="padding-bottom:20px;">Ingresa con</p>
            <div class="modal-inner"><div class="credentials-box">
                <form   class="general" method="post" enctype="multipart/form-data">
                    <fieldset class="rel"><label class="rederror  label_log_email hide">Ingresa un correo valido .. </label><input type="text" name="email_login" class="roboto" placeholder="Correo Electrónico"></fieldset>
										
                    <fieldset class="rel"><label class="rederror  label_log_clave hide">Ingresa una clave correcta .. </label><input type="password" name="clave_login" class="roboto" placeholder="Contraseña"></fieldset>
                    <fieldset class="rel lleva_btn_ingresar_v2 " style="max-width: 416px;margin: 0 auto; ">
                        <a class="btn_login_alumno boton poppi-sb " style="margin-left:0;border-radius: 4px;max-width: 150px;">Ingresar</a>
                        <div class='hide monset pagoespera ' id='rptapago'>Procesando ...</div>
                    </fieldset>
                </form>
            </div></div>

            <p class="color4 poppi text-right" style="padding-bottom:10px;"><a href="recuperar" class="poppi-b color4 ">Olvide mi contraseña</a></p>
            <p class="color4 poppi text-center">¿No tienes cuenta? <a href="registrate_v2" class="poppi-b">Regístrate</a></p>
			<!-- 
            <p class=" poppi text-center" style="padding-top:10px;">
								<a href="actualiza-tus-datos" class="poppi-b boton">Actualizar mis datos</a>
						</p>
			-->
			</div>
		</div>	
	</div></div></div>
	

	
<?php 
		} /* end si no exite sesion webinar aun */
		
	}else{
		echo '<section class="callout text-center "><div class="row"><div class="large-12 columns" style="padding:190px 0;"> <h3 class="poppi-sb" style="padding-bottom:30px;"> Lo sentimos: Clase no encontrada .. </br></h3><a href="'.$url.'"><img src="img/logo_auge.png"></a></div> </div> </section>';
	}
}else{
	echo '<section class="callout text-center"><div class="row"> <div class="large-12 columns" style="padding:190px 0;"> <h3 class="poppi-sb" style="padding-bottom:30px;">Ingresa un enlace válido </h3><a href="'.$url.'"><img src="img/logo_auge.png"></a></div></div> </section>';
}
?>
</main>
<?php include ('inc/footer.php'); ?>