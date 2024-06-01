<?php 
$pagina='portada';
include('auten.php');
$meta = array(
    'title' => 'Accede a los mejores Cursos online para docentes | Educa Auge',
    'description' => 'Ya somos más de 10000 profesores que hemos logrado nuestros objetivos gracias a GRUPO AUGE. Construyendo el camino a la Revolución Educativa '
);
include ('inc/header.php'); ?>
<main id="portada" class=" <?php if(isset($_SESSION["suscritos"]["id_suscrito"]) && !empty($_SESSION["suscritos"]["id_suscrito"])){ echo "logeado"; }?>">
	<div class="callout banners"><ul id="carousel-1" class="no-bullet">

		  <li class="fondo banner-portada rel" style="background-image:url(tw7control/files/images/banners/XWJK43.jpg);"><div class="capa">
        	<div class="row">
						<div class="large-offset-6 large-6   columns medium-text-right text-center blanco ">
							<h3 class="poppi bold color-blanco">Volvemos dentro de poco, estamos en mantenimeinto.</h3>
							<p>Volvemos dentro de poco, estamos en mantenimeinto.</p>
						</div>
					</div>
        </div></li>
    </ul></div>
    <div class="callout callout-1"><div class="row text-center">
    	<div class="large-3 medium-6 columns"><div class="pod">
    		<figure class="rel"><img class="verticalalignmiddle" src="img/iconos/pizarra.png"></figure>
    		<span class="titu texto poppi-sb">100% virtuales </span>
    		<p class="texto poppi">Clases en vivo por internet, según tu interés.</p>
    	</div></div>
    	<div class="large-3 medium-6 columns"><div class="pod">
    		<figure class="rel"><img class="verticalalignmiddle" src="img/iconos/lentes.png"></figure>
    		<span class="titu texto poppi-sb">Profesionales</span>
    		<p class="texto poppi">Certifícate con los mejores profesionales del país.</p>
    	</div></div>
    	<div class="large-3 medium-6 columns"><div class="pod">
    		<figure class="rel"><img class="verticalalignmiddle" src="img/iconos/calendario.png"></figure>
    		<span class="titu texto poppi-sb">Capacitaciones</span>
    		<p class="texto poppi">Cursos para estudiantes y profesionales.</p>
    	</div></div>
    	<div class="large-3 medium-6 columns"><div class="pod">
    		<figure class="rel"><img class="verticalalignmiddle" src="img/iconos/archivo.png"></figure>
    		<span class="titu texto poppi-sb">Investigación</span>
    		<p class="texto poppi">Incentivamos para poder generar soluciones.</p>
    	</div></div>
    </div></div>
		
		
		
    <div class="callout callout-2"><div class="row">
    	<div class="medium-6 medium-centered text-center columns">
				<h3 class="poppi color4 bold"> Volvemos dentro de poco, estamos en mantenimeinto.  </h3>
				<!-- 
				<blockquote class="poppi  vert_todos"><a href="curso/todos" class="color2">Ver todos</a></blockquote>
				-->
			</div>
    	<div class="large-12 columns"><div class="rel cursos_portada ">
				
			</div></div>
    </div></div>
</main>
<?php include ('inc/footer.php'); ?>