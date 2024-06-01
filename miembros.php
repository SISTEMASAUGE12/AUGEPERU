<?php include('auten.php');
$pagina='miembros';
$meta = array(
    'title' => 'Miembros | Auge Perú: ',
    'description' => ''
);
include ('inc/header.php');
$miembros = executesql("SELECT * FROM miembros where id=1 ",0);
?>
<main id="miembros" >
		<div class="callout banners callout-2"><div class="fondo banner-miembros"><div class="capa"><div class="row">
		<div class="large-12 columns text-center">
				<h4 class="poppi-b color-blanco"><?php echo $miembros['titulo'] ?></h4>
		</div>
	</div></div></div></div>
	
	<div class="callout callout-1"><div class="row">
		<div class="large-7 medium-7 columns">
			<div class="texto poppi"><?php echo $miembros['texto'] ?> </div>
		</div>
		<div class="large-5 medium-5 columns">
			<div class=" lleva_icon  rel ">
				<figure><img src="img/iconos/ico_preguntas_1.png"></figure>
				<div class=" poppi "><?php echo $miembros['texto_2'] ?> </div>
			</div>
			
			<div class=" lleva_icon  rel ">
				<figure><img src="img/iconos/ico_email_1.png"></figure>
				<div class=" poppi "><?php echo $miembros['texto_3'] ?> </div>
			</div>
		
		</div>
	</div></div>
	

	<div class="callout callout-3"><div class="row">
		<div class="large-10 large-centered  columns">
			<h3 class="poppi text-center texto"><?php echo $miembros['titulo_2'] ?></h3>
			<div class="descri poppi "><?php echo $miembros['descripcion'] ?></div>
		</div>
	</div></div>
	
<?php $listado_tutoriales=executesql("select * from tutoriales where estado_idestado=1 order by orden asc "); 
if( !empty($listado_tutoriales) ){ 
?> 
	<div class="callout callout-6 text-left"><div class="row"><div class="large-10 large-centered  columns">
			<h3 class="poppi-sb text-center ">Tutoriales de Educaauge </h3>
	<?php foreach( $listado_tutoriales as $tutorial ){  $i=1; ?>
					<?php    if(!empty($tutorial["link"])){  ?>
							<div class="medium-6 columns linea_content end  ">
								<div class=" lleva_icon  rel ">
									<figure><img src="img/ico_tutorial.png"></figure>
									<div class=" poppi "><span>VIDEO #<?php echo $i; ?></span><?php echo $tutorial['titulo'] ?> </div>
								</div>
								<div class="rel ifra">
									<iframe src="<?php echo $tutorial['link']; ?>" class="" id="video1" frameborder="0" allow="autoplay; fullscreen" allowfullscreen></iframe>
								</div>
							</div> <!-- m6 -->
					<?php } ?> 	
	<?php   $i++; 
				} /* end for tutoriales */ ?> 	
			
</div></div></div>
<?php } ?> 
	
	
	<div class="callout callout-4 text-center"><div class="row">
		<div class="large-10 large-centered  columns">
			<figure><a href="<?php echo $miembros['link_facebook'] ?>" target="_blank"><img src="img/grupo_face_miembros.jpg"></a></figure>
		</div>
	</div></div>
	
	
	<div class="callout callout-5 color-blanco "><div class="row">
		<div class="large-12 text-center columns">
			<h3 class=" poppi"><?php echo $miembros['titulo_3'] ?> </h3>
		</div>
		
		<div class="large-12 columns linea_content ">
			<div class=" lleva_icon  rel ">
				<figure><img src="img/iconos/ico_preguntas_2.png"></figure>
				<div class=" poppi "><?php echo $miembros['texto_4'] ?> </div>
			</div>
			<a href="preguntas-frecuentes" class="btn ">Consulta las Preguntas Frecuentes</a>
		</div>
		
		<div class="large-12 columns linea_content ">
			<div class=" lleva_icon  rel ">
				<figure><img src="img/iconos/ico_preguntas_2.png"></figure>
				<div class=" poppi "><?php echo $miembros['texto_5'] ?> </div>
			</div>
			<a href="mailto:informes@educaauge.com" class="btn ">Envíanos un email</a>
		</div>
		
	</div></div>
	
</main>
<?php include ('inc/footer.php'); ?>