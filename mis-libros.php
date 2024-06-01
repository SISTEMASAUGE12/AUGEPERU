<?php include('auten.php');
if(!isset($_SESSION["suscritos"]["id_suscrito"])){ header('Location: '.$url); }
$pagina='perfil';
$meta = array(
    'title' => 'Mis libros | Auge Perú ',
    'description' => ''
);
include ('inc/header.php');
?>

<main id="perfil" class="margin_interno  certificados_listado ">
	<div class="callout callout-inicio "><div class="row ">
		<div class=" large-9 large-centered medium-10 medium-centered columns content_perfil ">
			<blockquote class="color1 poppi-sb text-center " style="padding-bottom:20px;"><small> Hola <?php echo $perfil[0]["nombre"]; ?>!</small>
			</br>Sus libros disponibles para adquirir </blockquote>
			<!--<p class="poppi  text-center " style="padding-bottom:60px;">* Recuerda que para solicitar la entrega de tu libro ya pagado, tienes que completar la visualización del curso comprado al 100%</p>-->
		</div>
		
		<div class="large-12 medium-12 columns content_perfil ">
<?php  /* consulto id_curso de los cursos comprados */
$suscur = executesql("SELECT * FROM suscritos_x_cursos WHERE estado_idestado=1 and estado=1 and id_tipo=2 and id_suscrito = '".$_SESSION['suscritos']['id_suscrito']."' ");
        if(!empty($suscur)){ ?>
			<h4 class="color1 poppi-sb">Solicítalos aquí </h4>
<?php 
			foreach ($suscur as $data_asignacion){
			/* consulto los certificados que tienen cada curso comprado : */
				$sql_x="SELECT * FROM cursos WHERE id_curso = '".$data_asignacion['id_curso']."' ";
				$data_certi = executesql($sql_x);
				if(!empty($data_certi)){ foreach($data_certi as $detalles){ 
					/* muestro los certificados que tienen cada curso comprado ... */
					$titulo=$detalles['titulo'];
					// $link='perfil/mis-cursos/'.$detalles['titulo_rewrite'];
					$imgproduct= !empty($detalles['imagen'])?'tw7control/files/images/capa/'.$detalles['imagen']:'img/no_imagen.jpg';
					echo '<div class="large-3 float-left medium-6 columns rel  end mis_cursos ">';
					include('inc/libro.php');
					echo '</div>';
				} }				
			}
		}else{
			echo '<div class="text-center" style="padding:40px 15px;">Aún no has comprado libros .. </div>';
		}
?>	
	</div></div></div>

<?php
		$deta = executesql("SELECT c.*, ca.titulo_rewrite AS catrewri, sc.titulo_rewrite AS subrewri, tc.titulo_rewrite AS tiprewri, tc.id_tipo AS tipocurso FROM cursos c INNER JOIN categoria_subcate_cursos csc ON c.id_curso = csc.id_curso INNER JOIN categorias ca ON csc.id_cat = ca.id_cat INNER JOIN subcategorias sc ON csc.id_sub = sc.id_sub INNER JOIN tipo_cursos tc ON csc.id_tipo = tc.id_tipo WHERE c.estado_idestado = 1 and c.tipo=1 and c.id_tipo=2 and c.precio > 0  and  c.id_curso NOT IN ( select id_curso from suscritos_x_cursos where id_suscrito='".$_SESSION["suscritos"]["id_suscrito"]."')    ORDER BY c.orden_destacado DESC  limit 0,4");
		if(!empty($deta)){ 
?>
	<div class="callout callout-inicio-2 "><div class="row "><div class="large-12 medium-12 columns content_perfil ">
		<h3 class="color1 poppi-sb text-center">Qué más deseas aprender con nosotros</h3>
		<p class="poppi text-center maxi ">Aprovecha que ya cuentas con tu registro en Auge y estás a un click de aprender más   </p>			
		<h4 class=" poppi-sb text-center">Te recomendamos estos Libros  </h4>
		<div class="large-12 columns"><div class="rel cursos_portada ">
				<!--
				<ul id="carousel-para-4" class="no-bullet">
				-->
<?php 		
			foreach($deta as $detalles){
				$titulo=$detalles['titulo'];
    		$link='curso/'.$detalles['tiprewri'].'/'.$detalles['catrewri'].'/'.$detalles['subrewri'].'/'.$detalles['titulo_rewrite'];
    		$imgproduct= 'tw7control/files/images/capa/'.$detalles['imagen'];
?>
    		<!-- 
				<li><?php  // include("inc/curso.php") ?></li>
				-->
    		<div class="large-3 medium-4 columns end "><?php include("inc/curso.php") ?></div>			 	
<?php
			} 
?>

		<!-- 
    	</ul>
			-->
		<div class="large-12 columns end text-center" >
					<a href="libro/todos-los-libros" class="btn_2 botones ">VER TODOS LOS LIBROS</a>
				</div>
			</div></div>
	</div></div></div>
<?php 
		}
?>
	
	
	<div class="callout callout-inicio-3"><div class="row text-center "><div class="large-12 medium-12 columns content_perfil ">
		<img src="img/logo-rojo.png">
		<h3 class="color1 poppi-sb text-center">Construyendo el camino a la Revolución Educativa</h3>
			
	</div></div></div>

</main>
<?php include ('inc/footer.php'); ?>