<?php include('auten.php');
$pagina='portada';
$meta = array(
    'title' => 'Auge: Testimonios ',
    'description' => ''
);
include ('inc/header.php'); ?>
<main id="portada" class="listado_testimonios">
    
<?php 
	include("inc/banners_portadas.php"); 
	?>
    <div class="callout callout-3"><div class="row">
        <div class="large-12 text-center columns">
            <h3 class="poppi" style="color:white">Los docentes nos recomiendan </h3>
				<!-- <ul class="no-bullet carousel-3 "> -->
<?php
        $fates = executesql("SELECT * FROM face_testimonios WHERE estado_idestado = 1 ORDER BY orden DESC limit 0,40 ");
        if(!empty($fates)){ foreach($fates as $fat){
					// <div class="medium-6 text-center float-left columns"><img src="tw7control/files/images/face_testimonios/<?php echo $fat['imagen'] "></div>
?>
        <div class=" large-4 medium-6 columns  end "><img src="tw7control/files/images/face_testimonios/<?php echo $fat['imagen'] ?>"></div>
<?php
        } }
?>
				<!--  </ul> -->
			</div>
	</div></div>
</main>
<?php include ('inc/footer.php'); ?>