<?php include('auten.php');
$pagina='webinar';
if(isset($_GET['rewrite']) && !empty($_GET['rewrite'])){
	$sql="SELECT * FROM webinars WHERE estado_idestado=1 and titulo_rewrite='".$_GET['rewrite']."' order by orden desc limit 0,1 ";
	$webinars = executesql($sql);
	if(!empty($webinars[0])){
		$tit=$webinars[0]["titulo_seo"].' | GRUPO AUGE ';
		$desss=$webinars[0]["detalle_1"];
		$imgtit='tw7control/files/images/webinars/'.$webinars[0]['imagen'];
	}else{
		$tit="Webinar no encontrado | GRUPO AUGE ";
		$desss="";
		$imgtit="";
	}

	$meta= array(
		'title' => 'Webinar: '.$tit,
		'keywords' => $desss,
		'description' => $desss,
		'image' => $imgtit
	);
	
}else{ 	
	$meta = array(
			'title' => '	Webinar: | Grupo Auge',
			'description' => ''
	);
}

include('inc/header.php');
?>

<main id="land" class="poppi">    
<?php 
if( !empty($_GET["rewrite"]) ){ 
	if( !empty($webinars[0]) ){
?>
	<div  class="callout banners text-left blanco">
		<div class="abs mascara"></div>
	<div class="fondo fondo3 " style="background-image:url(tw7control/files/images/webinars/<?php echo $webinars[0]['imagen']; ?>);"><div class="row rel"><div class="large-7 medium-7 columns">
			<img src="img/logo_auge.png" class="rel " STYLE="z-index:99;">
			<h3 class="poppi-b blanco"><?php echo $webinars[0]['titulo_1']; ?></h3>
			<p class="blanco poppi text-left"><?php echo $webinars[0]['detalle_1']; ?></p>
		</div></div></div>
	</div>
	
	<section class="callout callout-1  poppi "><div class="row">
		<article class="large-4 medium-5 columns webinar_movil text-left">
			<div class="fond">
				<form  action="enviar-paisajismo" method="post" enctype="multipart/form-data"><fieldset><div class="row text-left">
					<h3 class=" poppi-b text-center">Regístrate y Participa De La Conferencia <b>GRATUITAMENTE</b> </h3>
					<div class="large-12 columns">
						<input type="text" required name="nombre" placeholder="Nombres" autocomplete="off">
						<!--
						<input type="text" required name="ap_pa" placeholder="Apellido Paterno" autocomplete="off">
						<input type="text" required name="ap_ma" placeholder="Apellido Materno" autocomplete="off">
						-->
						<input type="text" required name="telefono" placeholder="Celular" autocomplete="off">
					</div>
					<div class="large-12 columns">
						<input type="text" maxlength="12" autocomplete="off" onkeypress="javascript:return soloNumeros(event,0);" name="telefono" placeholder="Teléfono / celular">
					</div>
					<div class="large-12 columns"><input type="email" required name="correo" autocomplete="off" placeholder="Correo"></div>
					<div class="large-12 text-center  columns"><button class="poppi boton">ENTRAR</button></div>
				</div></fieldset></form>
			</div>
		</article>
		<article class="large-8 medium-7 columns text-left"><div class="row">
			<article class="large-11 medium-11 columns end ">
				<h3 class="color-5 poppi-b text-left"><?php echo $webinars[0]['titulo_2']; ?></h3>
				<div class="poppi detalle"><?php echo $webinars[0]['detalle_2']; ?></div>
			</article> 
		</div></article>
		<article class="large-4 medium-5 columns webinar_pc text-left">
			<div class="fond">
				<form  action="enviar-paisajismo" method="post" enctype="multipart/form-data"><fieldset><div class="row text-left">
					<h3 class="poppi-sb text-center ">Regístrate y Participa De La Conferencia <b>GRATUITAMENTE</b></h3>
					<div class="large-12 columns"><input type="text" required name="nombre" placeholder="Nombre completo"></div>
					<!-- 
					<div class="large-12 columns"><input type="text" required name="ap_pa" placeholder="Apellido Paterno" autocomplete="off"></div>
					<div class="large-12 columns"><input type="text" required name="ap_ma" placeholder="Apellido Materno" autocomplete="off"></div>
					-->
					<div class="large-12 columns"><input type="text" required name="telefono" placeholder="Celular" autocomplete="off"></div>
					<div class="large-12 columns">
						<input type="text" maxlength="12" onkeypress="javascript:return soloNumeros(event,0);" name="telefono" placeholder="Teléfono / celular">
					</div>
					<div class="large-12 columns">
						<input type="email" required name="correo" placeholder="Correo">
					</div>
					<div class="large-12 text-center columns">
						<button class="poppi boton">ENTRAR</button>
					</div>
			 
				</div></fieldset></form>
			</div>
		</article>
	</div></section> 
<?php 
	}else{
		echo '<section class="callout text-center "><div class="row"><div class="large-12 columns" style="padding:190px 0;"> <h3 class="poppi-sb" style="padding-bottom:30px;"> Lo sentimos: webinar no encontrado .. </br></h3><a href="'.$url.'"><img src="img/logo_auge.png"></a></div> </div> </section>';
	}
}else{
	echo '<section class="callout text-center"><div class="row"> <div class="large-12 columns" style="padding:190px 0;"> <h3 class="poppi-sb" style="padding-bottom:30px;">Ingresa un enlace válido </h3><a href="'.$url.'"><img src="img/logo_auge.png"></a></div></div> </section>';
}
?>
</main>
<?php include ('inc/footer.php'); ?>