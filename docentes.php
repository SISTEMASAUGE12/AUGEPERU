<?php 
$pagina='portada';
include('auten.php');
$meta = array(
    'title' => 'Accede a los mejores Cursos online para docentes | Educa Auge',
    'description' => 'Ya somos más de 50000 profesores que hemos logrado nuestros objetivos gracias a GRUPO AUGE. Construyendo el camino a la Revolución Educativa '
);
include ('inc/header.php'); ?>
<main id="portada" class=" <?php if(isset($_SESSION["suscritos"]["id_suscrito"]) && !empty($_SESSION["suscritos"]["id_suscrito"])){ echo "logeado"; }?>">
	<?php 
	$pagina='docentes';
	// include("inc/banners_portadas.php"); 
	$pagina='portada';

	?>


    <div class="callout callout-7" style="padding-top:90px;background:#fff;">
			<div class="row">
					<div class="large-12 text-center columns end ">
						<h3 class="poppi-sb color1 ">Nuestros docentes</h3>
					</div>
			</div>
      
			<div class="row">	
<?php  
        $docente = executesql("SELECT * FROM profesores WHERE estado_idestado = 1 ORDER BY orden DESC ");
        if(!empty($docente)){ foreach($docente as $docentes){
?>
				<div class=" medium-10 medium-centered contiene_sesiones_listado    columns  " style="margin-bottom:35px;float:none;" >
						<!-- 
						<a href="docente/<?php echo $docentes["titulo_rewrite"];?>">
						</a>
						-->
						<div class="row ">
								<div class="large-4 medium-5 columns ">
									<figure  CLASS="rel">
										<img src="tw7control/files/images/profesores/<?php echo $docentes['imagen'] ?>"  >
									</figure>
								</div>
								<div class=" large-8 medium-7 columns ">
									<h2 class="poppi-b azul"><?php echo $docentes["titulo"];?></h2>
									<div class="data_finder   detalle_docentes poppi " style="padding:15px 0 25px">
										<?php echo $docentes["descripcion"];?>
									</div>
								</div>		
						</div>
						
				</div>
<?php
        } } 		
?>
									
				
    </div></div>
</main>
<?php 

$pagina="asdsa";
include ('inc/footer.php'); ?>