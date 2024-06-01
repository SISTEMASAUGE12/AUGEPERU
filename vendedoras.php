<?php 
$pagina='portada';
include('auten.php');
$meta = array(
    'title' => 'Asesoras de venta | Educa Auge',
    'description' => 'Ya somos más de 50000 profesores que hemos logrado nuestros objetivos gracias a GRUPO AUGE. Construyendo el camino a la Revolución Educativa '
);
include ('inc/header.php'); ?>
<main id="portada" class=" ">
	
		
    <div class="callout callout-6" style="padding-top:90px;background:#fff;height:auto;"><div class="row">
			<div class="large-12 text-center columns">
          	  <h3 class="poppi-sb color1 ">Asesoras de ventas</h3>
			</div>      							
<?php  
        $docente = executesql("SELECT * FROM usuario WHERE estado_idestado = 1 and idtipo_usu =4 and idusuario!=21  ORDER BY nomusuario ASC  ");
        if(!empty($docente)){ foreach($docente as $docentes){
					$imagen= !empty($docentes["imagen"])?'tw7control/files/images/usuario/'.$docentes["imagen"]:'img/no_imagen_color.jpg';
?>
						<div class="large-3 medium-4  columns end " style="margin-bottom:45px;" ><div   class="">
								<div class=" text-center columns ">
									<figure  CLASS="rel">
										<img  class="asesoras" src="<?php echo $imagen; ?>"  >
									</figure>
									<p  class="poppi color1"><?php echo $docentes["nomusuario"];?> </p>
									<a class="boton poppi-sb _ver_solo_en_pc " href="llamanos-gratis" target="_blank">Contactar</a>
									<a class="boton poppi-sb  _ver_solo_en_movil  " href="tel:017097855" target="_blank">Contactar.</a>
								</div>
            </div></div>
<?php
        } } 		
?>											
				
			<div class="large-12 text-center columns">
          	  <h3 class="poppi-sb color1 " style="padding-top:90px;">Atención al cliente  </h3>
			</div>      							
<?php  
        $docente = executesql("SELECT * FROM usuario WHERE estado_idestado = 1 and idtipo_usu =10  ORDER BY nomusuario asc ");
        if(!empty($docente)){ foreach($docente as $docentes){
					$imagen= !empty($docentes["imagen"])?'tw7control/files/images/usuario/'.$docentes["imagen"]:'img/no_imagen_color.jpg';
?>
						<div class="large-3 medium-4  columns end " style="margin-bottom:45px;" ><div   class="">
								<div class=" text-center columns ">
									<figure  CLASS="rel">
										<img  class="asesoras" src="<?php echo $imagen; ?>"  >
									</figure>
									<p  class="poppi color1"><?php echo $docentes["nomusuario"];?> </p>
									<a class="boton poppi-sb _ver_solo_en_pc " href="llamanos-gratis" target="_blank">Contactar</a>
									<a class="boton poppi-sb  _ver_solo_en_movil  " href="tel:017097855" target="_blank">Contactar.</a>
								</div>
            </div></div>
<?php
        } } 		
?>											
				
    </div></div>
</main>
<?php 

$pagina="....";
include ('inc/footer.php'); ?>