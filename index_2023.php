<?php
include('auten.php');
$ajustes_mostrar_login=executesql(" select * from ajustes where mostrar_solo_inicio_de_sesion_index=1 ");
if( !empty($ajustes_mostrar_login) && !isset($_SESSION["suscritos"]["id_suscrito"]) ){  /*  si esta activado mostrar login */
	include('index_inc_solo_login.php');
	
}else{ 
/* muestro el index natural */
$pagina='portada';
// include('auten.php');
$meta = array(
    'title' => 'Accede a los mejores Cursos online para docentes | Educa Auge',
    'description' => 'Ya somos más de 50000 profesores que hemos logrado nuestros objetivos gracias a GRUPO AUGE. Construyendo el camino a la Revolución Educativa '
);
include ('inc/header_2023.php'); ?>
<main id="portada" class=" <?php if(isset($_SESSION["suscritos"]["id_suscrito"]) && !empty($_SESSION["suscritos"]["id_suscrito"])){ echo "logeado"; }?>">
	<div class="callout banners">
<?php /*
	<ul id="carousel-1" class="no-bullet">
		$ban = executesql("SELECT * FROM banners where estado_idestado=1 order by orden desc ");
		if(!empty($ban)){ foreach($ban as $banner){
?>
        <li class="fondo banner-portada rel" style="background-image:url(tw7control/files/images/banners/<?php echo $banner['imagen'] ?>);"><div class="capa">
        	<div class="row">
						<div class="large-offset-8 large-4  medium-offset-6 medium-6  columns medium-text-right text-center blanco ">
							<h3 class="poppi bold color-blanco"><?php echo $banner['titulo'] ?></h3>
							<?php if(!empty($banner['descripcion']) ){ ?><p><?php echo $banner['descripcion'] ?></p><?php } ?>
							<?php if(!empty($banner['link']) ){ ?><a class="btn bold " href="<?php echo $banner['link'] ?>"><?php echo $banner['boton'] ?></a><?php } ?>
						</div>
					</div>
        </div></li>
<?php
		} }
		*/
?>


		  <div class="fondo banner-portada rel" style="background-image:url(img/banners/XWJK43.jpg);"><div class="capa">
        	<div class="row">
					<?php
         if(isset($_SESSION["suscritos"]["id_suscrito"]) and !empty($_SESSION["suscritos"]["id_suscrito"]) && empty($_GET['rewrite4']) ){  
            $offset='6';
        }else{
             $offset='4';
         }?>
            <div class="large-offset-<?php echo  $offset; ?> large-4  medium-6 columns medium-text-left text-center blanco ">
							<h3 class="poppi bold color-blanco">Capacítate online.</h3>
							<p>Ya somos más de 50 mil profesores que hemos logrado nuestros objetivos gracias a GRUPO AUGE </p>
							<!--
							<a class="btn bold " title="regístrate" href="https://www.educaauge.com/registro">Crea tu cuenta gratis</a>
								-->
						</div>
						<div class=" large-4  medium-6  columns medium-text-right text-center blanco ">
						<?php 
							if(isset($_SESSION["suscritos"]["id_suscrito"]) && !empty($_SESSION["suscritos"]["id_suscrito"])){ 
							
							}else{
								include('inc/formulario_registro_banner.php');
							}
						?>
						</div><!-- end l4 -->

					</div>
        </div></div>
				<!-- 
    </ul>
		-->
		</div> <!-- end banner  -->
		
    <div class="callout callout-1 data_index_pc "><div class="row text-center">
			<?php include("inc/datos_index.php"); ?>
    </div></div>
	
		
    <div class="callout callout-2"><div class="row">
    	<div class="medium-6 medium-centered text-center columns">
				<h3 class="poppi color4 bold">Accede a los mejores Cursos online para docentes </h3>
				<!-- 
				<blockquote class="poppi  vert_todos"><a href="curso/todos" class="color2">Ver todos</a></blockquote>
				-->
			</div>
    	<div class="large-12 columns"><div class="rel cursos_portada ">
				<!--
				<ul id="carousel-para-4" class="no-bullet">
				-->
<?php
		// $deta = executesql("SELECT c.*, ca.titulo_rewrite AS catrewri, sc.titulo_rewrite AS subrewri, tc.titulo_rewrite AS tiprewri, tc.id_tipo AS tipocurso FROM cursos c INNER JOIN categoria_subcate_cursos csc ON c.id_curso = csc.id_curso INNER JOIN categorias ca ON csc.id_cat = ca.id_cat INNER JOIN subcategorias sc ON csc.id_sub = sc.id_sub INNER JOIN tipo_cursos tc ON csc.id_tipo = tc.id_tipo WHERE c.id_tipo=1 AND ( c.cursos_dependientes ='' or c.cursos_dependientes is NULL)  and  c.estado_idestado = 1 and c.tipo=1 and c.precio > 0 GROUP BY c.id_curso  ORDER BY c.orden_destacado DESC  limit 0,8"); /* este query no muestra packs destacados */
		
		// $deta = executesql("SELECT c.*, ca.titulo as categoria, ca.titulo_rewrite AS catrewri, sc.titulo_rewrite AS subrewri, tc.titulo_rewrite AS tiprewri, tc.id_tipo AS tipocurso FROM cursos c INNER JOIN categoria_subcate_cursos csc ON c.id_curso = csc.id_curso INNER JOIN categorias ca ON csc.id_cat = ca.id_cat INNER JOIN subcategorias sc ON csc.id_sub = sc.id_sub INNER JOIN tipo_cursos tc ON csc.id_tipo = tc.id_tipo WHERE c.id_tipo=1 and  c.estado_idestado = 1 and c.tipo=1 and c.precio > 0 GROUP BY c.id_curso  ORDER BY c.orden_destacado DESC  limit 0,8"); /* este query si muestra pack destacados ::: error GROUP BY ?? */
	
		
		 $consulta_cursos="SELECT c.*, ca.titulo as categoria, ca.titulo_rewrite AS catrewri, sc.titulo_rewrite AS subrewri, tc.titulo_rewrite AS tiprewri, tc.id_tipo AS tipocurso FROM cursos c INNER JOIN categoria_subcate_cursos csc ON c.id_curso = csc.id_curso INNER JOIN categorias ca ON csc.id_cat = ca.id_cat INNER JOIN subcategorias sc ON csc.id_sub = sc.id_sub INNER JOIN tipo_cursos tc ON csc.id_tipo = tc.id_tipo WHERE c.id_tipo=1 and  c.estado_idestado = 1 and c.tipo=1 and c.precio > 0   ORDER BY c.orden_destacado DESC  limit 0,12";
		
		// echo $consulta_cursos;
		$deta = executesql($consulta_cursos); /* este query si muestra pack destacados */
		
		if(!empty($deta)){ foreach($deta as $detalles){
			$titulo=$detalles['titulo'];
    		$link='curso/'.$detalles['tiprewri'].'/'.$detalles['catrewri'].'/'.$detalles['subrewri'].'/'.$detalles['titulo_rewrite'];
    		// $imgproduct= 'tw7control/files/images/capa/'.$detalles['imagen'];
    		$imgproduct= 'tw7control/files/images/capa/'.$detalles['imagen2'];
?>
    		<!-- 
				<li><?php  // include("inc/curso.php") ?></li>
				-->
    		<div class="large-3 medium-4 columns end "><?php include("inc/curso_2023.php") ?></div>
				 	
<?php
		} }
?>
		<!-- 
    	</ul>
			-->
				<div class="large-12 columns end text-center" >
					<a title="ver todos los cursos" href="curso/todos" class="btn_2 botones ">VER TODOS LOS CURSOS</a>
				</div>
			</div></div>
    </div></div>
		
		<div class="callout callout-1 data_index_movil "><div class="row text-center">
			<?php include("inc/datos_index.php"); ?>
    </div></div>
		
    <div class="callout callout-3"><div class="row">
        <div class="large-12 text-center columns">
            <h3 class="poppi blanco ">Testimonios</h3>
						<blockquote class="poppi  vert_todos"><a title="ver testimonio" href="testimonios" class="blanco">Los docentes nos recomiendan <small>[ver más]</small></a></blockquote>
        </div>
        <div class="large-12 columns"><div class="rel" style="max-width: 1124px;margin: auto;">
					<div class="clientes text-center ">
						<div class="lSAction"><a class="lSPrev" title="regresar"></a><a class="lSNext" title="avanzar"></a></div>
					</div>
					<ul id="carousel-3" class="no-bullet">
<?php  /*
        $test = executesql("SELECT * FROM testimonios WHERE estado_idestado = 1 and tipo=1  ORDER BY orden DESC limit 0,8");
        if(!empty($test)){ foreach($test as $testi){
?>
            <li><div <?php echo (!empty($testi["link"])) ? 'style="padding:0"' : '' ?> class="testimonio">
									<?php include("inc/testimonios.php") ?>
            </div></li>
<?php
        } }
				*/
?>
						 <li><div style="padding:0" class="testimonio">
									<div class="descrip text-right medium-6 columns ">
											<span class="poppi-b color4">kike Flores Julón 
												<small class="poppi">Docente capacitada en AUGE</small>
											</span>
											<div class="poppi color4">Los cursos que he recibido de manera virtual me ha servico no solo para aprobar los examnes si no para aplicarlo en el el aula y me ha servicio para poder dar solución a los diferentes problemas que se presentan en el aula.</div>
											<p class="poppi color4 curso"></p>
									</div>
									<div class="foto medium-6 columns rel">
										<figure  CLASS="rel">
											<img src="img/BC9145.jpeg" class="imagen_1" style="width:100%;" alt="Testimonios educaauge">
												
											<a title="ver testimonio" class="abs mpopup-02" href="https://www.youtube.com/watch?v=ENYralDBuac"><img src="img/iconos/ico-play.png" alt="clik ver video" class="verticalalignmiddle"></a>
										
										<!-- 
											<div class="rel lleva_vimeo_listado">
												<iframe src="	link"  frameborder="0"  allow="autoplay; fullscreen; picture-in-picture" allowfullscreen  width="884" height="497"></iframe>
												<a class="abs mpopup-02" href="link"><img src="img/iconos/ico-play.png" class="verticalalignmiddle"></a>
											</div>
											-->
										</figure>
									</div>
							</div></li>
					</ul>
				</div></div>
    </div></div>
    <div class="callout callout-4"><div class="row text-center">
    	<div class="large-12 columns">
    		<h3 class="poppi color3"><b class="poppi-sb">Únete</b> </br> <small class="color3">a nuestros grupos gratuitos </small></h3>
    		<p class="texto poppi">Compartimos material de mucho interés para ti, Ingresa de manera gratuita dándole click al enlace de abajo o desde aquí.</p>
    	</div>
    	<div class="large-10 large-offset-1 float-left columns"><div class="rel"><ul id="carousel-4" class="no-bullet">
	    	
			<?php  
			$grupos=executesql("select * from grupos where estado_idestado=1 order by orden desc"); 
			if( !empty($grupos) ){ 
								foreach( $grupos as $row){
			?>	
				<li><div class="cuadro">
    			<figure class="rel"><img class="verticalalignmiddle" src="tw7control/files/images/grupos/<?php echo $row["imagen"]; ?>" ></figure>
    			<p class="texto poppi"><?php echo $row["titulo"]; ?></p>
    			<a href="<?php echo $row["enlace"]; ?>" target="_blank" class="boton poppi-sb">Aquí</a>
    		</div></li>
			<?php 
								} 
			} 
			
			?>						

    	</ul></div></div>
    </div></div>
    <div class="callout callout-5"><div class="row"><div class="contiene">
<?php /*
		$porta = executesql("SELECT * FROM portada");
		*/ 
?>
			<div class="large-6 medium-6 float-right columns">
				<div class="descri">
					<h3 class="poppi bold color3">Grupo AUGE<br style="margin-top:20px;"><small class="color3">Construyendo el camino a la Revolución Educativa</small></h3>
					<p class="poppi color3">La filosofía que inspiró la fundación del Grupo AUGE se orienta a la búsqueda de la verdad científica y preparación de profesionales altamente capacitados, con cultura humanística y criterios de permanente actualización y superación.</p>
					<a href="nosotros" title="conoce mas " class="boton poppi-sb ">CONÓCENOS MÁS</a>
				</div>
			</div>
			<div class="large-6 medium-6 columns rel">
				<figure class="rel">
					<img class="imagen_1" src="img/IWCJ17.jpg" alt="Educa Auge .com">
					<a title="ver video" class="abs mpopup-02" href="https://www.youtube.com/watch?v=zX9CF5ru7vY"><img src="img/iconos/ico-play.png" alt="ver video" class="verticalalignmiddle"></a>
					</figure>
			</div>
    </div></div></div>
		
    <div class="callout callout-6"><div class="row">
			<div class="large-12 text-center columns">
            <h3 class="poppi-sb blanco ">Nuestros docentes</h3>
			</div>
        <div class="large-12 columns ">
					<div class="clientes text-center ">
						<div class="lSAction"><a class="lSPrev"></a><a class="lSNext"></a></div>
					</div>
				</div>
				
        <div class="large-12 columns"><div class="rel">
					<ul   class="no-bullet carousel-5">
<?php  
        $docente = executesql("SELECT * FROM profesores WHERE estado_idestado = 1 ORDER BY orden DESC limit 0,12");
        if(!empty($docente)){ foreach($docente as $docentes){
?>
            <li><div   class="">
								<div class=" text-center columns ">
									<figure  CLASS="rel">
											<img src="tw7control/files/images/profesores/<?php echo $docentes['imagen'] ?>"  >
									</figure>
									<p  class="poppi blanco"><?php echo $docentes["titulo"];?></p>
									<blockquote   class="poppi blanco"><?php echo $docentes["titulo"];?></blockquote>
								</div>
            </div></li>
<?php
        } }
				
?>
									
					</ul>
				</div></div>
    </div></div>
</main>
<?php include ('inc/footer.php'); 
} /* fin de validacion de ajuste */
?>