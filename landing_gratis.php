<?php include('auten.php');   
$_SESSION["url"]=url_completa(); // redireciona aui el registro 
$pagina='webinar';
$_SESSION["url"]='pagina_cursos_gratis'; // redireciona aui el registro 

if(isset($_GET['rewrite']) && !empty($_GET['rewrite'])){
	
	$sql="SELECT * FROM landing_gratis WHERE estado_idestado=1 and titulo_rewrite='".$_GET['rewrite']."' order by orden desc limit 0,1 ";
	$landing_gratis = executesql($sql);
	if(!empty($landing_gratis[0])){
		$tit=$landing_gratis[0]["titulo_seo"].' | EDUCA AUGE ';
		$desss=$landing_gratis[0]["detalle_1"];
		$imgtit='tw7control/files/images/landing_gratis/'.$landing_gratis[0]['imagen'];
		
		/* sirve para reegistro de suscrito x curso_gratis */
		$_SESSION["url_gratis"]["id_gratis"]=$landing_gratis[0]["id_gratis"]; // redireciona aui el registro 
		$_SESSION["url_gratis"]["id_curso"]=$landing_gratis[0]["id_curso"]; // redireciona aui el registro 
		$_SESSION["url_gratis"]["rewrite"]=$_GET["rewrite"]; // redireciona aui el registro 

	}else{
		$tit="Landing no encontrado | EDUCA AUGE ";
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
			'title' => '	Landing Curso gratis  | EDUCA Auge',
			'description' => ''
	);
}

include('inc/header.php');
?>

<main id="land" class="poppi">    
<?php 
if( !empty($_GET["rewrite"]) ){ 

	// echo $_SESSION["suscritos"]["id_suscrito"].'=====>>';
	// echo $_SESSION["curso_gratis"]["rewrite"].'=====>>';
	
	if( !empty($landing_gratis) ){
		
		// if( isset($_SESSION["curso_gratis"]) && !empty($_SESSION["curso_gratis"])  && $_SESSION["curso_gratis"]["rewrite"]==$_GET["rewrite"]){
		if( (isset($_SESSION["suscritos"]["id_suscrito"]) && $_SESSION["suscritos"]["id_suscrito"] > 0 ) && isset($_SESSION["curso_gratis"]["rewrite"])  && $_SESSION["curso_gratis"]["rewrite"]==$_GET["rewrite"]){
			/* tiene acceso al curso_gratis */
			// unset($_SESSION["curso_gratis"]);


			$hoy=fecha_hora(1);
			$hora_hoy=fecha_hora(0);
			

					
					include("inc/curso_gratis_gracias_registro.php"); /* mensaje de gracias */
			
		}else{ 
		/* SI NO EXISTE UNA SESSION DEL curso_gratis AUN, */
?>
<div  class="callout banners text-left "><div class="fondo fondo3 " style="background-image:url(tw7control/files/images/landing_gratis/<?php echo $landing_gratis[0]['banner']; ?>);"><div class="row rel" style="padding-bottom:90px;">
		<div class="medium-12 columns">
			<img src="img/logo-rojo.png" class="rel " STYLE="z-index:99;">
			<h3 class="color1 poppi-sb ">Curso online gratuito</h3>
		</div>
		<div class="medium-10 medium-centered columns">
			<h1 class="poppi-b  text-center"><?php echo $landing_gratis[0]['titulo_1']; ?></h1>
		</div>
		<div class="medium-7 medium  text-center columns">
		<!--
			<p class=" poppi text-left"><?php echo $landing_gratis[0]['detalle_1']; ?></p>
			-->
			<?php if( !empty($landing_gratis[0]['imagen_1']) ){  ?> 
					<img src="tw7control/files/images/landing_gratis/<?php echo $landing_gratis[0]['imagen_1']; ?>">
			<?php } ?>
			
			<?php if( !empty($landing_gratis[0]['detalle_2']) ){  ?> 
			<div class="caja_con_temas">
				<p class="poppi "><?php echo $landing_gratis[0]['detalle_2']; ?> </p>
			</div>
			<?php } ?>
			
		</div>
		<div class="medium-5 medium columns end ">
			<div class="fond" style="margin-top:45px;">
				<form  action="btn_registro_de_landing_gratis" method="post" enctype="multipart/form-data"><fieldset><div class="row text-left">
					<h3 class=" poppi text-center"><b>Regístrate / Inicia sesión en EDUCA AUGE</b></br></br>crea un cuenta y accede a este curso gratuito y beneficios del GRUPO AUGE</h3>
<!--				
					<div class="large-12 columns">
						<input type="hidden" required name="id_gratis" value="<?php echo $landing_gratis[0]['id_gratis']; ?>" autocomplete="off">
						<input type="hidden" required name="rewrite" value="<?php echo $landing_gratis[0]['titulo_rewrite']; ?>" autocomplete="off">
						<input type="hidden" required name="curso_gratis" value="<?php echo $landing_gratis[0]['titulo']; ?>" autocomplete="off">
						
						<input type="text" required name="nombre_completo" placeholder="Nombre completo" autocomplete="off">
					</div>
					<div class="large-12 columns">
						<input type="text" maxlength="12" autocomplete="off" onkeypress="javascript:return soloNumeros(event,0);" name="telefono" required placeholder="Teléfono / celular">
					</div>
					<div class="large-12 columns">
							<select id="tipo" name="tipo" class="form-control" required > 
								<option value="1" >NOMBRADO</option>  
								<option value="2" >CONTRATADO</option>
							</select>
					</div>
					<div class="large-12 columns"><input type="email" required name="email" autocomplete="off" placeholder="Correo"></div>
	-->
					<div class="large-12 text-center  columns">
						<a href="registro" class="poppi boton pulse "> ¡Sí, quiero registrarme!</a>
						<div class='hide monset pagoespera ' id='rptapago'>Procesando ...</div>
					</div>
				</div></fieldset></form>
			</div>
		</div>	
	</div></div></div>
	
	<?php 
	// include('inc/cronometro.php');
	?>

		<!-- 
	<section class="callout callout-1  poppi "><div class="row">
		<article class=" medium-12 columns  text-center">
			<h4 class="poppi "><?php echo $landing_gratis[0]['titulo_2']; ?></h4>
		</article>
		<article class=" medium-6 columns  text-left">
				<div class="poppi detalle"><?php echo $landing_gratis[0]['detalle_2']; ?></div>		
		</article>
		<article class="medium-6 columns text-center ">
				<?php if( !empty($landing_gratis[0]['imagen_2']) ){  ?> 
							<figure>	<img src="tw7control/files/images/landing_gratis/<?php echo $landing_gratis[0]['imagen_2']; ?>"></figure>	
			<?php } ?>
		</article>	
	</div></section> 
			-->
	
<?php 
		} /* end si no exite sesion curso_gratis aun */
		
	}else{
		echo '<section class="callout text-center "><div class="row"><div class="large-12 columns" style="padding:190px 0;"> <h3 class="poppi-sb" style="padding-bottom:30px;"> Lo sentimos: landing no encontrado .. </br></h3><a href="'.$url.'"><img src="img/logo_auge.png"></a></div> </div> </section>';
	}
}else{
	echo '<section class="callout text-center"><div class="row"> <div class="large-12 columns" style="padding:190px 0;"> <h3 class="poppi-sb" style="padding-bottom:30px;">Ingresa un enlace válido </h3><a href="'.$url.'"><img src="img/logo_auge.png"></a></div></div> </section>';
}
?>
</main>
<?php include ('inc/footer.php'); ?>