<?php include('auten.php');
$pagina='perfil';
$meta = array(
    'title' => 'Compra y resuelve tus Exámenes aquí | Educa Auge ',
    'description' => ''
);
include ('inc/header.php'); 
?>

<main id="perfil" class="margin_interno  _examenes_ventas  class=" <?php if(isset($_SESSION["suscritos"]["id_suscrito"]) && !empty($_SESSION["suscritos"]["id_suscrito"])){ echo "logeado"; }?> " ">

	<div class="callout callout-inicio "><div class="row ">
		<div class=" large-9 large-centered medium-10 medium-centered columns content_perfil ">
			<blockquote class="color1 poppi-sb text-center " style="padding-bottom:20px;"> Exámenes disponibles para comprar </blockquote>
			<p class="poppi  text-center " style="padding-bottom:60px;"> Hemos puesto a disposición la venta de simulacros de exámenes, que lo puedes resolver desde nuestra web en tiempo real. </p>
		</div>
		
		<div class="large-12 medium-12 columns content_perfil ">
			<div class="large-3 medium-12 columns content_perfil ">
			</div>
			<div class="large-9 medium-12 columns content_perfil ">
<?php 
$sql_=" SELECT ex.* FROM examenes ex 
 LEFT JOIN categoria_examenes cat ON ex.id_cate= cat.id_cate 
 WHERE ex.privacidad=3 and ex.estado_idestado=1 
 ORDER BY ex.id_examen desc ";

// echo  $sql_;

$lista_examenes = executesql($sql_);
if(!empty($lista_examenes)){ ?>
<?php    								
	foreach($lista_examenes as $detalles){ 
		/* LISTO CERTIFICADOS, segun cursos comprados ... */
		$titulo=$detalles['titulo'];  
		// $link='perfil/mis-cursos/'.$detalles['titulo_rewrite'];
		$imgproduct= !empty($detalles['imagen'])?'tw7control/files/images/examenes/'.$detalles['imagen']:'img/no_imagen_color.jpg';

		echo '<div class=" large-4 medium-4  columns rel  end mis_cursos ">';
			include('inc/examen_vender.php');
		echo '</div>';
	}
				
}else{
	echo '<div class="text-center" style="padding:40px 15px;">Aún no hay exámenes a la venta .. </div>';
}
?>	
		</div><!-- l9 -->
	</div></div></div>

	<div class="callout callout-inicio-3"><div class="row text-center "><div class="large-12 medium-12 columns content_perfil ">
		<img src="img/logo-rojo.png">
		<h3 class="color1 poppi-sb text-center">Construyendo el camino a la Revolución Educativa</h3>
			
	</div></div></div>

</main>
<?php include ('inc/footer.php'); ?>