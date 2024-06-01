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
include ('inc/header.php'); ?>
<?php
		$portada = executesql("SELECT * FROM portada where id=1 ");		
?>

<?php include("inc/banners_portadas_movil_pantalla_completa.php"); ?>

<main id="portada" class=" <?php if(isset($_SESSION["suscritos"]["id_suscrito"]) && !empty($_SESSION["suscritos"]["id_suscrito"])){ echo "logeado"; }?>">
	
	<?php include("inc/banners_portadas.php"); ?>

    <div class="callout callout-1 fondo _mostrar_solo_pc  "><div class="row text-center">
			<?php include("inc/datos_index.php"); ?>
    </div></div>
	
		
    <div class="callout callout-2"><div class="row">
    	<div class="medium-8 medium-centered text-center columns">
				<h3 class="poppi blanco bold"> <?php echo $portada[0]["titulo_cursos"]; ?>  </h3>		
		</div>
    	<div class="large-12 columns cursos_portada "><div class="rel  ">
<?php
		 $consulta_cursos="SELECT c.*, ca.titulo as categoria, ca.titulo_rewrite AS catrewri, sc.titulo_rewrite AS subrewri, tc.titulo_rewrite AS tiprewri, tc.id_tipo AS tipocurso FROM cursos c INNER JOIN categoria_subcate_cursos csc ON c.id_curso = csc.id_curso INNER JOIN categorias ca ON csc.id_cat = ca.id_cat INNER JOIN subcategorias sc ON csc.id_sub = sc.id_sub INNER JOIN tipo_cursos tc ON csc.id_tipo = tc.id_tipo WHERE c.id_tipo=1 and  c.estado_idestado = 1 and c.tipo=1 and c.precio > 0   ORDER BY c.orden_destacado DESC  limit 0,12";		
		// echo $consulta_cursos;
		$deta = executesql($consulta_cursos); /* este query si muestra pack destacados */
		
		if(!empty($deta)){ 
			foreach($deta as $detalles){
				$titulo=$detalles['titulo'];
				$link='curso/'.$detalles['tiprewri'].'/'.$detalles['catrewri'].'/'.$detalles['subrewri'].'/'.$detalles['titulo_rewrite'];
				$imgproduct= 'tw7control/files/images/capa/'.$detalles['imagen2'];
			?>
    		<div class="large-4 medium-4 columns end  "><?php include("inc/curso.php") ?></div>
			
<?php		}// end for 
		} 
?> 


				<div class="large-12 columns end text-center" >
					<a title="ver todos los cursos" href="curso/todos" class="btn_2 botones ">VER TODOS LOS CURSOS</a>
				</div>
			</div></div>
    </div></div>

	<div class="callout callout-1 fondo _mostrar_solo_movil  "><div class="row text-center">
			<?php include("inc/datos_index.php"); ?>
    </div></div>
	


<?php  
        $test = executesql("SELECT * FROM testimonios WHERE estado_idestado = 1 and tipo=1  ORDER BY orden DESC limit 0,8");
        if(!empty($test)){ ?>
    <div class="callout callout-3"><div class="row">
		<div class="large-12 text-center columns">
			<h3 class="poppi   "><?php echo $portada[0]["titulo_testimonios"]; ?></h3>
			<blockquote class="poppi  vert_todos"><a title="ver testimonio" href="testimonios" class=" color1 "> <?php echo $portada[0]["titulo_testimonios_2"]; ?></a></blockquote>
		</div>
        <div class="large-12 columns"><div class="rel" style="max-width: 1124px;margin: auto;">
					<div class="clientes text-center ">
						<div class="lSAction"><a class="lSPrev" title="regresar"></a><a class="lSNext" title="avanzar"></a></div>
					</div>
					<ul id="carousel-3" class="no-bullet">
			<?php 
			foreach($test as $testi){
?>
            <li><div <?php echo (!empty($testi["link"])) ? 'style="padding:0"' : '' ?> class="testimonio">
									<?php include("inc/testimonios.php") ?>
            </div></li>
<?php
        } 				
?>						
					</ul>
				</div></div>
    </div></div>
<?php } ?>


    <div class="callout callout-4"><div class="row text-center">
    	<div class="large-12 columns">
    		<h3 class="poppi blanco "><b class="poppi-sb">Únete</b> </br> <small class=" blanco ">a nuestros grupos gratuitos </small></h3>
    		<p class="  poppi blanco ">Compartimos material de mucho interés para ti, Ingresa de manera gratuita dándole click al enlace de abajo o desde aquí.</p>
    	</div>
    	<div class="large-10 large-offset-1 float-left columns"><div class="rel"><ul id="carousel-4" class="no-bullet">
	    	
			<?php  
			$grupos=executesql("select * from grupos where estado_idestado=1 order by orden desc"); 
			if( !empty($grupos) ){ 
								foreach( $grupos as $row){
			?>	
				<li>
					<div class="cuadro">
						<a href="<?php echo $row["enlace"]; ?>" target="_blank" class="  poppi-sb">
							<figure class="rel"><img class="verticalalignmiddle" src="tw7control/files/images/grupos/<?php echo $row["imagen"]; ?>" ></figure>
							<p class="texto poppi"><?php echo $row["titulo"]; ?></p>
						</a>
    				</div>
				</li>
			<?php 
				} 
			} 
			
			?>			
    	</ul></div></div>
    </div></div>
    <div class="callout callout-5"><div class="row contiene">

			<div class="large-6 medium-6 float-right columns">
				<div class="descri">
					<h3 class="poppi bold blanco "> <?php echo $portada[0]["titulo_1"]; ?><br style="margin-top:20px;"><small class=" blanco "> <?php echo $portada[0]["titulo"]; ?></small></h3>
					<p class="poppi blanco"> <?php echo $portada[0]["descripcion"]; ?></p>
					<a href="nosotros" title="conoce mas " class="boton poppi-sb ">CONÓCENOS MÁS</a>
				</div>
			</div>
			<div class="large-6 medium-6 columns rel">
				<figure class="rel">
					<img class="imagen_1" src="tw7control/files/images/portada/<?php echo $portada[0]["imagen"]; ?>" alt="Enfermeraonline.com">
					<?php if( $portada[0]["link"]) { ?> 
					<a title="ver video" class="abs mpopup-02" href="<?php echo $portada[0]["link"]; ?>"><img src="img/iconos/ico-play.png" alt="ver video" class="verticalalignmiddle"></a>
					<?php } ?> 
				</figure>
			</div>
    </div></div>
		
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
											<img src="tw7control/files/images/profesores/<?php echo $docentes['imagen']; ?>"  >
									</figure>
									<p  class="poppi blanco"><?php echo $docentes["titulo"];?></p>
									<blockquote   class="poppi blanco hide "><?php echo $docentes["titulo"];?></blockquote>
								</div>
            </div></li>
<?php
        } }
				
?>									
					</ul>
				</div></div>
    </div></div>
</main>

<?php 
include ('inc/footer.php'); 
} /* fin de validacion de ajuste */
?>