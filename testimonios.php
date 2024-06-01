<?php include('auten.php');
$pagina='testimonios';
$meta = array(
    'title' => 'Testimonios | Auge Perú: ',
    'description' => ''
);
include ('inc/header.php');
$miembros = executesql("SELECT * FROM miembros where id=1 ",0);
$categorias_testi=executesql("select * from categorias_testimonios_v2_s where estado_idestado=1 order by id_cate asc "); 

$sql_listado="select t.* from testimonios_v2_s t 
							INNER JOIN categorias_testimonios_v2_s ct ON t.id_cate=ct.id_cate 
							WHERE t.estado_idestado=1 ";
							
$sql_listado.= (isset($_GET["rewrite"]) && !empty($_GET["rewrite"]) )?" and ct.titulo_rewrite='".$_GET["rewrite"]."'  ":' and t.id_cate !=4 and t.id_cate !=5 ';

$sql_listado.=" ORDER by t.imagen desc ";

// echo $sql_listado;

$listado_tutoriales=executesql($sql_listado); 

?>
<main id="miembros" >
<!-- Si ven el curso detalle en el perfil -->
<?php if(isset($_GET["rewrite2"]) && !empty($_GET["rewrite2"]) ){ /* ventana emergente de gracias por compra */ 
		$sql_cc="SELECT c.* FROM testimonios_v2_s c WHERE c.estado_idestado = 1 and c.titulo_rewrite='".$_GET["rewrite2"]."'  order by c.imagen desc  " ;
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
 
 
<?php //include("inc/banners_portadas.php"); ?>


 
<div class="callout banners callout-2"><div class="fondo banner-miembros" style="background-color:#fff;">
	<div class="capa" style="padding: 70px 10px 10px;height: 100%;">
		<div class="row">
			<div class="large-12 columns text-center">
				<h4 class="poppi-b color2 "><small class="color1 ">Se prepararon en auge y lograron su objetivo</small> </br> Casos de éxito y Testimonios </br> </h4>
		<?php   $i=1;
		if( !empty($categorias_testi)){ 
			foreach( $categorias_testi as $cate ){
					?>
						<li class="rel blanco poppi-sb tutorial_li <?php echo (isset($_GET["rewrite"]) && $_GET["rewrite"]==$cate['titulo_rewrite'])?' activo ':''; ?> ">
							<a class=" " href="testimonios/<?php echo $cate['titulo_rewrite']; ?>">
								<?php echo $cate["titulo"];?>
							</a>
						</li>
			<?php  
					
				}
			} /* end if categ */?>
				</div>
			</div>
		</div>
	</div></div>
	

<?php
if( !empty($listado_tutoriales) ){ 
?> 
	<div class="callout callout-6 text-left"><div class="row"><div class="large-12   columns">
	<?php 
	foreach( $listado_tutoriales as $tutorial ){  ?>
			<?php    
		// if(  !empty($tutorial["imagen"]) || !empty($tutorial["imagen_video"]) || !empty($tutorial["imagen_fb"]) ){ 

			$clase_css='';
			$large_x='';
			$imagen_test='img/no_testimonio.jpg';
			
			// if( $tutorial['id_cate'] == 1 || $tutorial['id_cate'] == 2 || $tutorial['id_cate'] == 3){ 
			if($tutorial['id_cate'] != 4 && $tutorial['id_cate'] != 5 ){ 
				$clase_css=' img_1';
				$large_x=' large-17 medium-2 small-3 ';
				$imagen_test= !empty($tutorial['imagen'])?'tw7control/files/images/testimonios_v2_s/'.$tutorial['imagen']:$imagen_test;
				
			}elseif($tutorial['id_cate'] == 4){
				$clase_css=' img_4';		
				$large_x=' large-4 medium-4  ';	
				$imagen_test= !empty($tutorial['imagen_video'])?'tw7control/files/images/testimonios_v2_s/'.$tutorial['imagen_video']:$imagen_test;
				
			}elseif($tutorial['id_cate'] == 5){
				$clase_css=' img_5';										
				$large_x=' large-6 medium-6 ';										
				$imagen_test= !empty($tutorial['imagen_fb'])?'tw7control/files/images/testimonios_v2_s/'.$tutorial['imagen_fb']:$imagen_test;
			}
			?>
							<div class="  <?php echo $large_x; ?>   columns linea_content end  ">
								<div class="rel ifra">
									<figure  CLASS="rel  <?php echo $clase_css; ?> ">
											
										<?php if( $tutorial['id_cate'] != 4 && $tutorial['id_cate'] != 5 ){ 
											
										?>
										<img src="<?php echo $imagen_test; ?>" class="imagen_1 " >
										<figcaption>
											<p class="poppi blanco ">
												<?php echo $tutorial['titulo']; ?> </br></br>
												<span></span> </br>
												<b>UGEL:</b> </br>
												<?php echo $tutorial['ugel'] .' '.$tutorial['region']; ?></br></br>
												<b><?php echo $tutorial['competencia']; ?></b> </br>
												PUNTAJE: <?php echo $tutorial['puntaje_final']; ?>
											</p>
										</figcaption>
										<?php } ?> 

										<?php if( $tutorial['id_cate'] == 4){ ?>
											<img src="<?php echo $imagen_test; ?>" class="imagen_1 " >
											<a class="abs "  href="testimonios/<?php echo $_GET['rewrite']; ?>/<?php echo $tutorial['titulo_rewrite']; ?>"><img src="img/iconos/ico-play.png" class="verticalalignmiddle"></a>
										<?php } ?> 
										
										<?php if( $tutorial['id_cate'] == 5){ ?>
											<div class="lleva_img_fb rel " >	
												<img src="<?php echo $imagen_test; ?>" class="imagen_1 verticalalignmiddle " >
											</div>
										<?php } ?> 
											
									</figure>
									
									
								</div>
							</div> <!-- m6 -->
					<?php 
						// } 
						?> 	
	<?php  
					
		} /* end for testimonios  */
	?> 	
			
</div></div></div>

<div class="callout banners callout-3"><div class="row">
	<div class="medium-6  columns medium-text-right text-center ">
		<img src="img/testi_1.jpg">
	</div>
	<div class="medium-6  columns medium-text-left text-center ">
		<h4 class="poppi-b color1 "> Tú también puedes </br> capacitarte en Auge </br> y lograr tus objetivos  </h4>
		<a class="boton poppi" href="https://www.educaauge.com/curso/todos">ver cursos</a>
	</div>
</div></div>

<?php } ?> 
	
	
	
</main>
<?php include ('inc/footer.php'); ?>