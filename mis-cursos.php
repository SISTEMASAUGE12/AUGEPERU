<?php $pagina='perfil_home';
include('auten.php');
if(!isset($_SESSION["suscritos"]["id_suscrito"])){ header('Location: '.$url); }
$meta = array(
    'title' => ' Mis cursos | Educa Auge',
    'description' => ''
);
include ('inc/header.php');

// echo '=>'.$_SESSION['suscritos']['id_suscrito']; 
$suscri = executesql("SELECT s.*, e.titulo FROM suscritos s INNER JOIN especialidades e ON s.id_especialidad = e.id_especialidad WHERE s.id_suscrito = '".$_SESSION['suscritos']['id_suscrito']."' ");
?>

<main id="perfil" class="margin_interno ">
<!-- Si ven el curso detalle en el perfil -->
<?php if(isset($_GET["task"]) && $_GET["task"]=="gracias" ){ /* ventana emergente de gracias por compra */ 
	include("inc/modal_gracias_por_compra.php");
}else{

	if( empty($suscri[0]["dni"]) || empty($suscri[0]["id_especialidad"]) || empty($suscri[0]["id_escala_mag"]) || empty($suscri[0]["id_tipo_cliente"]) || empty($suscri[0]["id_pais"]) || empty($suscri[0]["telefono"]) || empty($suscri[0]["email"])   ){
		// muestro modal apra actualizar datos 
		// include("inc/modal_actualiza_tus_datos.php");   // deshabilitado temporalmente 
	}

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


	<div class="callout callout-inicio "><div class="row "><div class="large-9 large-centered  medium-10 medium-centered  columns content_perfil ">

		<div class=" _buho_horarios">
			<img src="img/buho_horarios_mis_cursos_2.png">
			<?php 

			$_modal_horario='';

			/** valido lo de horarios  */
			$sql_valido_nombremiento="SELECT sc.* FROM `suscritos_x_cursos` sc INNER JOIN cursos c ON sc.id_curso=c.id_curso INNER JOIN categoria_subcate_cursos sb ON c.id_curso=sb.id_curso INNER JOIN categorias cat ON sb.id_cat=cat.id_cat WHERE cat.id_cat=1  and sc.estado_idestado=1 and sc.estado=1 and YEAR(sc.fecha_registro) = 2024  and sc.id_suscrito='".$_SESSION["suscritos"]["id_suscrito"]."'  ";
			$si_tiene_nombremiento = executesql($sql_valido_nombremiento);
			if(  !empty($si_tiene_nombremiento) ){
				$_modal_horario='exampleModal1_horarios'; 
			}
			
			
			$sql_valido_ascenso="SELECT sc.* FROM `suscritos_x_cursos` sc INNER JOIN cursos c ON sc.id_curso=c.id_curso INNER JOIN categoria_subcate_cursos sb ON c.id_curso=sb.id_curso INNER JOIN categorias cat ON sb.id_cat=cat.id_cat WHERE cat.id_cat=2  and sc.estado_idestado=1 and sc.estado=1 and YEAR(sc.fecha_registro) = 2024  and sc.id_suscrito='".$_SESSION["suscritos"]["id_suscrito"]."'  ";
			$si_tiene_ascenso = executesql($sql_valido_ascenso);
			if(  !empty($si_tiene_ascenso) ){
				$_modal_horario='exampleModal1_horarios_ascenso';
			}

			?>
			<div class=" text-center _contiene_info ">
				<p class=" poppi-sb " data-open="<?php echo $_modal_horario; ?>" >Revisa tu <b class="color2 ">HORARIO</b> de clases dando click aquí  </br> </p>
			</div>
		</div>


		<div class="reveal" id="exampleModal1_horarios_ascenso" data-reveal>
			<?php  $horarios= executesql(" select * from horarios_imagenes where estado_idestado =1 and tipo=2 and id_especialidad=".$especialidad_del_cliente." ORDER BY ORDEN DESC limit 0,1 "); ?>
			<ul class="no-bullet  text-center ">
				<li><figure><img src="tw7control/files/images/horarios_imagenes/<?php echo $horarios[0]["imagen"]; ?>"></figure></li>	
			</ul>		
			<button class="close-button" data-close aria-label="Close modal" type="button">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
		<div class="reveal" id="exampleModal1_horarios" data-reveal> <!-- nombramiento -->
			<?php  $horarios= executesql(" select * from horarios_imagenes where estado_idestado =1  and tipo=1  and id_especialidad=".$especialidad_del_cliente." ORDER BY ORDEN DESC limit 0,1 "); ?>
			<ul class="no-bullet  text-center ">
				<li><figure><img src="tw7control/files/images/horarios_imagenes/<?php echo $horarios[0]["imagen"]; ?>"></figure></li>	
			</ul>		
			<button class="close-button" data-close aria-label="Close modal" type="button">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>


		<blockquote class="color1 poppi-sb text-center"><small>Bienvenido, <?php echo $perfil[0]["nombre"]; ?> </small>
		</br>Empecemos a aprender </blockquote>	
		<div class=" capa_123 blanco text-center "> Recuerda que los cursos que has comprado puedes verlo dentro de cursos generales y cursos de especialidad </div>		

		<h4 class="color1 poppi-sb   text-center " style="padding-bottom:40px;">Mis cursos adquiridos  </h4>
		<div class=" medium-6 columns  text-center tipo_listado_curso  ">
			<figure class=" rel ">
				<a href="mis-cursos-generales" class="mascara abs"></a>
				<img src="img/mis_cursos_generales.jpg">
				<a href="mis-cursos-generales"><figcaption class=" poppi-b verticalalignmiddle  _subtitulo">Cursos </br>generales</figcaption></a>
			</figure>
		</div>
		<div class=" medium-6 columns  text-center tipo_listado_curso ">
			<figure class=" rel ">
				<a href="mis-cursos-especialidades" class="mascara abs"></a>				
				<img src="img/mis_cursos_especialidades.jpg">
				<a href="mis-cursos-especialidades"><figcaption  class=" poppi-b  verticalalignmiddle _subtitulo " >Cursos de </br> especialidades</figcaption></a>
			</figure>
		</div>

	</div></div></div>
	
	
	
	
	<div class="callout callout-inicio " style="padding-top:0;"><div class="row "><div class="large-9 large-centered  medium-10 medium-centered  columns content_perfil ">			
		<h4 class="color1 poppi-sb   text-center " style="padding-bottom:40px;">Mis exámenes adquiridos  </h4>
		<div class=" large-6 large-centered  medium-8 medium-centered  columns  text-center tipo_listado_curso     " style="float:none;">
			<figure class=" rel ">
				<a href="perfil/examenes" class="mascara abs"></a>
				<img src="img/mis_examenes_comprados_2.png">
				<a href="perfil/examenes"><figcaption class=" poppi-b verticalalignmiddle  _subtitulo">Exámenes por </br>especialidad</figcaption></a>
			</figure>
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
		// $deta = executesql("SELECT c.*, ca.titulo_rewrite AS catrewri, sc.titulo_rewrite AS subrewri, tc.titulo_rewrite AS tiprewri, tc.id_tipo AS tipocurso FROM cursos c INNER JOIN categoria_subcate_cursos csc ON c.id_curso = csc.id_curso INNER JOIN categorias ca ON csc.id_cat = ca.id_cat INNER JOIN subcategorias sc ON csc.id_sub = sc.id_sub INNER JOIN tipo_cursos tc ON csc.id_tipo = tc.id_tipo WHERE c.estado_idestado = 1 and c.tipo=1 and c.id_tipo=1 and c.precio > 0  and  c.id_curso NOT IN ( select id_curso from suscritos_x_cursos where id_suscrito='".$_SESSION["suscritos"]["id_suscrito"]."')   GROUP BY c.id_curso  ORDER BY c.orden_destacado DESC  limit 0,8");
		
		

		$sql_cc="SELECT c.*, ca.titulo_rewrite AS catrewri, sc.titulo_rewrite AS subrewri, tc.titulo_rewrite AS tiprewri, tc.id_tipo AS tipocurso FROM cursos c INNER JOIN categoria_subcate_cursos csc ON c.id_curso = csc.id_curso INNER JOIN categorias ca ON csc.id_cat = ca.id_cat INNER JOIN subcategorias sc ON csc.id_sub = sc.id_sub INNER JOIN tipo_cursos tc ON csc.id_tipo = tc.id_tipo WHERE c.estado_idestado = 1 and c.tipo=1 and c.id_tipo=1 and c.precio > 0  and  c.id_curso NOT IN ( select id_curso from suscritos_x_cursos where id_suscrito='".$_SESSION["suscritos"]["id_suscrito"]."')   ORDER BY c.orden_destacado DESC  limit 0,6 ";


		// echo $sql_cc;

		$deta = executesql($sql_cc);
		if(!empty($deta)){ foreach($deta as $detalles){
			$titulo=$detalles['titulo'];
    		$link='curso/'.$detalles['tiprewri'].'/'.$detalles['catrewri'].'/'.$detalles['subrewri'].'/'.$detalles['titulo_rewrite'];
    		// $imgproduct= 'tw7control/files/images/capa/'.$detalles['imagen'];
    		$imgproduct= 'tw7control/files/images/capa/'.$detalles['imagen2'];
?>
    		<!-- 
				<li><?php // include("inc/curso.php") ?></li>
				-->
    		<div class="large-4  medium-4 columns end "><?php include("inc/curso.php") ?></div>			 	
<?php
		} }
?>
		<!-- 
    	</ul>
			-->
				<div class="large-12 columns end text-center" >
					<a href="curso/todos" class="btn_2 botones " title="ver todos los cursos">VER TODOS LOS CURSOS</a>
				</div>
			</div></div>
	</div></div></div>
	
	
	<div class="callout callout-inicio-3"><div class="row text-center "><div class="large-12 medium-12 columns content_perfil ">
		<img src="img/logo-rojo.png">
		<h3 class="color1 poppi-sb text-center">Construyendo el camino a la Revolución Educativa</h3>
			
	</div></div></div>

</main>
<?php 


$pagina="mis_cursos";
include ('inc/footer.php'); 

?>


<?php 
	$flotantes=executesql("select * from flotantes where  id_especialidad=".$especialidad_del_cliente." and  estado_idestado=1 order by orden desc limit 0,1"); 
	if(!empty($flotantes)){
		include("inc_modal_emergente.php"); 
	} // end cosulta floantes 
?>
	<script>
		console.log("muestro modal emergente ");
		$(document).on('click','.gracias_close',function(){										
			document.getElementById('ventana-emergente-1').style.display = "none"; 
		});
	</script>

