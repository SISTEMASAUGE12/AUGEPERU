<?php include('auten.php');
if(!isset($_SESSION["suscritos"]["id_suscrito"])){ header('Location: '.$url); }
$pagina='perfil_home';
$meta = array(
    'title' => 'Auge: Perfil',
    'description' => ''
);
include ('inc/header.php');

$suscri = executesql("SELECT s.*, e.titulo FROM suscritos s INNER JOIN especialidades e ON s.id_especialidad = e.id_especialidad WHERE s.id_suscrito = '".$_SESSION['suscritos']['id_suscrito']."' ");
?>

<main id="perfil" class="margin_interno ">
<!-- Si ven el curso detalle en el perfil -->
<?php if(isset($_GET["task"]) && !empty($_GET["task"]=="gracias") ){ /* ventana emergente de gracias por compra */ 
	include("inc/modal_gracias_por_compra.php");
}
 ?>

<!-- 
<div class="success callout" data-closable="slide-out-right">
  <p>You can close me too, and I close using a Motion UI animation.</p>
  <button class="close-button" aria-label="Dismiss alert" type="button" data-close>
    <span aria-hidden="true">&times;</span>
  </button>
</div>
-->
	<div class="callout callout-inicio "><div class="row "><div class="large-12 medium-12 columns content_perfil ">
		<blockquote class="color1 poppi-sb text-center"><small>Bienvenido <?php echo $perfil[0]["nombre"]; ?> </small>
		</br>Empecemos a aprender </blockquote>
				
<?php $suscur = executesql("SELECT * FROM suscritos_x_cursos WHERE estado_idestado=1 and condicion=1 and estado=1 and id_suscrito = '".$_SESSION['suscritos']['id_suscrito']."' ");
            if(!empty($suscur)){ ?>
		<h4 class="color1 poppi-sb">Mis cursos adquiridos </h4>
							<?php 
								foreach ($suscur as $data_asignacion){
									$sql_x="SELECT * FROM cursos WHERE id_tipo=1 and  id_curso = '".$data_asignacion['id_curso']."' ";
									
									$data_curso = executesql($sql_x);
									if(!empty($data_curso)){ 
										foreach($data_curso as $detalles){ 
											$titulo=$detalles['titulo'];
											$link='perfil/mis-cursos/'.$detalles['titulo_rewrite'];
											$imgproduct= 'tw7control/files/images/capa/'.$detalles['imagen'];

											echo '<div class="large-3 float-left medium-6 columns rel  end mis_cursos ">';
												include('inc/curso2.php');
											echo '</div>';
										}
									}
							
							} 
						}else{
									// echo '<div class="text-center" style="padding:40px 15px;">Aún no has comprado cursos .. </div>';
						}
?>
		
		<!-- LIBROS COMPRADOS -->
	<div class="large-12 columns nothing ">
<?php $suscur = executesql("SELECT * FROM suscritos_x_cursos WHERE estado_idestado=1 and condicion=1 and estado=1 and id_tipo=2 and id_suscrito = '".$_SESSION['suscritos']['id_suscrito']."' ");
            if(!empty($suscur)){ ?>
			<h4 class="color1 poppi-sb">Mis libros adquiridos </h4>
			<?php 
				foreach ($suscur as $data_asignacion){
					$sql_x="SELECT c.*, ca.titulo_rewrite AS catrewri, sc.titulo_rewrite AS subrewri, tc.titulo_rewrite AS tiprewri, tc.id_tipo AS tipocurso FROM cursos c
								INNER JOIN categoria_subcate_cursos csc ON c.id_curso = csc.id_curso
								INNER JOIN categorias ca ON csc.id_cat = ca.id_cat
								INNER JOIN subcategorias sc ON csc.id_sub = sc.id_sub
								INNER JOIN tipo_cursos tc ON csc.id_tipo = tc.id_tipo
								WHERE  c.id_tipo=2 and c.id_curso = '".$data_asignacion['id_curso']."' ";
										
// echo $sql_x;										
												
									$data_curso = executesql($sql_x);
									if(!empty($data_curso)){ 
										foreach($data_curso as $detalles){ 
											$titulo=$detalles['titulo'];
											$link='curso/'.$detalles['tiprewri'].'/'.$detalles['catrewri'].'/'.$detalles['subrewri'].'/'.$detalles['titulo_rewrite'];
											$imgproduct= 'tw7control/files/images/capa/'.$detalles['imagen'];

											echo '<div class="large-3 float-left medium-6 columns rel  end mis_cursos ">';
												include('inc/curso2.php');
											echo '</div>';
										}
									}
							
							} 
						}else{
									// echo '<div class="text-center" style="padding:40px 15px;">Aún no has comprado libros .. </div>';
						}
?>		
	</div>	
	<!-- 	END LIBROS COMPRADOS -->
	
	<!-- LIBROS CO AUTORES COAUTORES -->
	<div class="large-12 columns nothing ">
<?php $suscur = executesql("SELECT * FROM suscritos_x_cursos WHERE estado_idestado=1 and condicion=1 and estado=1 and id_tipo=3 and id_suscrito = '".$_SESSION['suscritos']['id_suscrito']."' ");
            if(!empty($suscur)){ ?>
			<h4 class="color1 poppi-sb">Mis libros Coautores adquiridos </h4>
			<?php 
				foreach ($suscur as $data_asignacion){
					$sql_x="SELECT c.*, ca.titulo_rewrite AS catrewri, sc.titulo_rewrite AS subrewri, tc.titulo_rewrite AS tiprewri, tc.id_tipo AS tipocurso FROM cursos c
								INNER JOIN categoria_subcate_cursos csc ON c.id_curso = csc.id_curso
								INNER JOIN categorias ca ON csc.id_cat = ca.id_cat
								INNER JOIN subcategorias sc ON csc.id_sub = sc.id_sub
								INNER JOIN tipo_cursos tc ON csc.id_tipo = tc.id_tipo
								WHERE  c.id_tipo=3 and c.id_curso = '".$data_asignacion['id_curso']."' ";
										
// echo $sql_x;										
												
									$data_curso = executesql($sql_x);
									if(!empty($data_curso)){ 
										foreach($data_curso as $detalles){ 
											$titulo=$detalles['titulo'];
											$link='curso/'.$detalles['tiprewri'].'/'.$detalles['catrewri'].'/'.$detalles['subrewri'].'/'.$detalles['titulo_rewrite'];
											$imgproduct= 'tw7control/files/images/capa/'.$detalles['imagen'];

											echo '<div class="large-3 float-left medium-6 columns rel  end mis_cursos ">';
												include('inc/curso2.php');
											echo '</div>';
										}
									}
							
							} 
						}else{
									// echo '<div class="text-center" style="padding:40px 15px;">Aún no has comprado libros .. </div>';
						}
?>
		
	</div>
		
	</div></div></div>

	<div class="callout callout-inicio-2 "><div class="row "><div class="large-12 medium-12 columns content_perfil ">
		<h3 class="color1 poppi-sb text-center">Qué más deseas aprender con nosotros</h3>
		<p class="poppi text-center maxi ">Aprovecha que ya cuentas con tu registro en Auge y estás a un click de aprender más   </p>
				
		<h4 class=" poppi-sb text-center">Te recomendamos estos cursos  </h4>
		<div class="large-12 columns"><div class="rel cursos_portada ">
				<!--
				<ul id="carousel-para-4" class="no-bullet">
				-->
<?php
		$deta = executesql("SELECT c.*, ca.titulo_rewrite AS catrewri, sc.titulo_rewrite AS subrewri, tc.titulo_rewrite AS tiprewri, tc.id_tipo AS tipocurso FROM cursos c INNER JOIN categoria_subcate_cursos csc ON c.id_curso = csc.id_curso INNER JOIN categorias ca ON csc.id_cat = ca.id_cat INNER JOIN subcategorias sc ON csc.id_sub = sc.id_sub INNER JOIN tipo_cursos tc ON csc.id_tipo = tc.id_tipo WHERE c.estado_idestado = 1 and c.tipo=1 and c.id_tipo=1 and c.precio > 0  and  c.id_curso NOT IN ( select id_curso from suscritos_x_cursos where id_suscrito='".$_SESSION["suscritos"]["id_suscrito"]."')   GROUP BY c.id_curso  ORDER BY c.orden_destacado DESC  limit 0,8");
		if(!empty($deta)){ foreach($deta as $detalles){
			$titulo=$detalles['titulo'];
    		$link='curso/'.$detalles['tiprewri'].'/'.$detalles['catrewri'].'/'.$detalles['subrewri'].'/'.$detalles['titulo_rewrite'];
    		$imgproduct= 'tw7control/files/images/capa/'.$detalles['imagen'];
?>
    		<!-- 
				<li><?php  // include("inc/curso.php") ?></li>
				-->
    		<div class="large-3 medium-4 columns end "><?php include("inc/curso.php") ?></div>			 	
<?php
		} }
?>
		<!-- 
    	</ul>
			-->
				<div class="large-12 columns end text-center" >
					<a href="curso/todos" class="btn_2 botones ">VER TODOS LOS CURSOS</a>
				</div>
			</div></div>
	</div></div></div>
	
	
	<div class="callout callout-inicio-3"><div class="row text-center "><div class="large-12 medium-12 columns content_perfil ">
		<img src="img/logo-rojo.png">
		<h3 class="color1 poppi-sb text-center">Construyendo el camino a la Revolución Educativa</h3>
			
	</div></div></div>

</main>
<?php include ('inc/footer.php'); ?>