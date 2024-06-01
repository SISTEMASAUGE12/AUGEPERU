<?php include('auten.php');
$pagina='miembros';
$meta = array(
    'title' => 'Capacitaciones del personal | Auge Perú: ',
    'description' => ''
);
include ('inc/header.php');
$miembros = executesql("SELECT * FROM miembros where id=1 ",0);
$listado_tutoriales=executesql("select * from tutoriales where  tipo=2 and estado_idestado=1 order by orden asc "); 

?>
<main id="miembros" >
<!-- Si ven el curso detalle en el perfil -->
<?php if(isset($_GET["rewrite"]) && !empty($_GET["rewrite"]) ){ /* ventana emergente de gracias por compra */ 
		$sql_cc="SELECT c.* FROM tutoriales c WHERE c.tipo=2 and  c.estado_idestado = 1 and c.titulo_rewrite='".$_GET["rewrite"]."' ";
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
 

 
	<div class="callout banners callout-2"><div class="fondo banner-miembros" style="background-color:#333;">
		<div class="capa" style="padding: 70px 10px 80px;height: 100%;">
			<div class="row">
				<div class="large-12 columns text-center">
					<h4 class="poppi-b color-blanco"><?php // echo $miembros['titulo'] ?> CAPACITACIONE PERSONAL </br> <small>explicados paso a paso</small></h4>
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
								<a class=" " href="tutorialprivado/<?php echo $tutorial['titulo_rewrite']; ?>"><?php echo $tutorial["titulo"];?></a>
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


<?php
if( !empty($listado_tutoriales) ){ 
?> 
	<div class="callout callout-6 text-left"><div class="row">
		
		<div class="large-12  columns">
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
											<a class="abs "  href="tutorialprivado/<?php echo $tutorial['titulo_rewrite']; ?>"><img src="img/iconos/ico-play.png" class="verticalalignmiddle"></a>
											
									</figure>
									<a href="tutorialprivado/<?php echo $tutorial['titulo_rewrite']; ?>">
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
	
	
	<div class="callout callout-4 text-center" style="background:#fff;" ><div class="row">
		<div class="large-10 large-centered  columns">
			<figure><img src="img/logo-rojo.png"></figure>
			<h3 class=" poppi-b color1 "> Construyendo el camino a la Revolución Educativa</h3>
		</div>
	</div></div>
	
	
</main>
<?php include ('inc/footer.php'); ?>