<?php include('auten.php');
$pagina='miembros';
$meta = array(
    'title' => 'Tutoriales | Auge Perú: ',
    'description' => ''
);
include ('inc/header.php');
$miembros = executesql("SELECT * FROM miembros where id=1 ",0);
$listado_tutoriales=executesql("select * from tutoriales where tipo=1 and  estado_idestado=1 order by orden asc "); 

?>
<main id="miembros" >
<!-- Si ven el curso detalle en el perfil -->
<?php if(isset($_GET["rewrite"]) && !empty($_GET["rewrite"]) ){ /* ventana emergente de gracias por compra */ 
		$sql_cc="SELECT c.* FROM tutoriales c WHERE c.tipo=1 and  c.estado_idestado = 1 and c.titulo_rewrite='".$_GET["rewrite"]."' ";
		// echo $sql_cc;
		$deta = executesql($sql_cc);
?>
<div class="small reveal modal_gracias tutoriales " id="exampleModal1" data-reveal>
<?php if(!empty($deta)){ ?>
	<div class="large-12 columns nothing "><div class="rel cursos_portada modal_de_gracias_por_compra ">
		<?php 
			if(!empty( $deta[0]['link'])){  /* video trailer */ ?>
					<div class="rel lleva_vimeo_listado text-center ">
							<iframe src="<?php echo $deta[0]['link']; ?>"  frameborder="0" allow="autoplay; fullscreen" allowfullscreen></iframe>
					</div>
<?php }  ?>
		<h4 class=" poppi-sb color1 text-left " ><?php echo $deta[0]['titulo']; ?>  </h4>
	</div></div>
	
<?php }else{   ?>
	<h4 class=" poppi-sb color1 text-left " >No se encontro información..  </h4>
<?php } ?> 
	
  <button class="close-button gracias_close" data-close aria-label="Close modal" type="button">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
<?php } /* flotante video con rewrite */ ?>
 

<!--  
		<div class="callout banners">
			<div class="fondo banner-portada rel" style="background-image:url(img/banners/XWJK43.jpg);"><div class="capa">
				<div class="row">
					<div class="large-offset-4 large-4  medium-6 columns medium-text-left text-center blanco ">
						<h3 class="poppi bold color-blanco"> Tutoriales</h3>
						<p>Ya somos más de 50 mil profesores que hemos logrado nuestros objetivos gracias a GRUPO AUGE </p>
					</div>
					<div class=" large-4  medium-6  columns medium-text-right text-center blanco ">
						<?php // include('inc/formulario_registro_banner.php'); ?>
					</div>
				</div>
			</div></div>
		</div>
			 -->
 
		<div class="callout banners callout-2"><div class="fondo banner-miembros" style="background-color:#333;">
			<div class="capa" style="padding: 70px 10px 80px;height: 100%;">
				<div class="row">
					<div class="large-12 columns text-center">
						<h4 class="poppi-b color-blanco"><?php // echo $miembros['titulo'] ?> VIDEOS TUTORIALES </br> <small>explicados paso a paso</small></h4>
				<?php   $i=1;
					foreach( $listado_tutoriales as $tutorial ){
							if(!empty($tutorial["link"])  && $i < 25 ){   /* muetsro maximo 25 botones */
								
							// for($y=1;$y<18;$y++){
							?>
								<li class="rel blanco poppi-sb tutorial_li " style="background:#DB271C;">
									
									<!--
									<?php echo $tutorial["titulo"];?>
									<a class="abs mpopup-02" href="<?php echo $tutorial['link']; ?>"></a>
									-->
									<a class=" " href="tutorial/<?php echo $tutorial['titulo_rewrite']; ?>"><?php echo $tutorial["titulo"];?></a>
								</li>
				<?php  
							// }
							$i++;
						} 
					}?>
					</div>
				</div>
			</div>
	</div></div>
	
	
<?php 	/* 
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
*/ ?>	

<?php
if( !empty($listado_tutoriales) ){ 
?> 
	<div class="callout callout-6 text-left"><div class="row"><div class="large-12   columns">
			<h3 class="poppi-sb text-center ">Tutoriales de Educaauge </h3>
	<?php 
	$iy=1; 
	foreach( $listado_tutoriales as $tutorial ){  ?>
					<?php    if(!empty($tutorial["link"]) && !empty($tutorial["imagen"]) ){  ?>
							<div class="medium-4 columns linea_content end  ">
							<!-- 
								<div class=" lleva_icon  rel ">
									<figure><img src="img/ico_tutorial.png"></figure>
									<div class=" poppi "><span>VIDEO #<?php echo $iy; ?></span><?php echo $tutorial['titulo'] ?> </div>
								</div>
								-->
								<div class="rel ifra">
								<!-- 
									<iframe src="<?php echo $tutorial['link']; ?>" class="" id="video1" frameborder="0" allow="autoplay; fullscreen" allowfullscreen></iframe>
									-->
									<figure  CLASS="rel">
											<img src="tw7control/files/images/tutoriales/<?php echo $tutorial['imagen']; ?>" class="imagen_1" style="width:100%;height:210px;">
												<!--
											<a class="abs mpopup-02" href="<?php echo $tutorial['link']; ?>"><img src="img/iconos/ico-play.png" class="verticalalignmiddle"></a>
											-->
											<a class="abs "  href="tutorial/<?php echo $tutorial['titulo_rewrite']; ?>"><img src="img/iconos/ico-play.png" class="verticalalignmiddle"></a>
											
									</figure>
									<a href="tutorial/<?php echo $tutorial['titulo_rewrite']; ?>">
										<div class=" poppi color1" style="background:#eee;padding:15px 12px ;"><span style="padding-right:12px;"><?php echo $iy; ?>.</span><?php echo $tutorial['titulo'] ?> </div>
									</a>
									
								</div>
							</div> <!-- m6 -->
					<?php 
							 $iy++; 
						} ?> 	
	<?php  
				} /* end for tutoriales */ ?> 	
			
</div></div></div>
<?php } ?> 
	
	
	<div class="callout callout-4 text-center hide"><div class="row">
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