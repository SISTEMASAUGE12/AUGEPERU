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

<main id="perfil" class="margin_interno pagina_listado_de_cursos_comprados ">

	<div class="callout callout-inicio "><div class="row "><div class="large-12 medium-12 columns content_perfil ">
		<blockquote class="color1 poppi-sb text-center"><small>Bienvenido, <?php echo $perfil[0]["nombre"]; ?> </small>
		</br>Empecemos a aprender </blockquote>			
		<h4 class="color1 poppi-sb">Mis cursos de especialidad  </h4>

		<ul class="tabs text-center  poppi-sb " data-tabs id="example-tabs">
			<li class="tabs-title is-active bold "><a href="#panel1" aria-selected="true"> CURSOS ACTIVOS </a></li>
			<li class="tabs-title  bold "><a href="#panel2" aria-selected="true"> CURSOS VENCIDOS </a></li>
			<li class=" _btn_extra   bold "><a href="mis-cursos-generales" > IR A MIS CURSOS GENERALES </a></li>			

		</ul>
		<div class="tabs-content" data-tabs-content="example-tabs">
			<div class="tabs-panel is-active" id="panel1">
				<!--  ACTIVOS -->
				<?php
					$sql_x1="SELECT sc.*, c.orden  FROM suscritos_x_cursos sc INNER JOIN cursos c ON sc.id_curso=c.id_curso
								WHERE sc.estado_idestado=1 and c.estado_idestado=1  and sc.estado=1  and sc.condicion=1  and sc.id_suscrito = '".$_SESSION['suscritos']['id_suscrito']."'  and sc.especialidades=1   
									Order by c.orden desc , c.en_vivo asc  ";
					$suscur = executesql($sql_x1);

					include('mis_cursos_listado.php');
				?>
				<!--  END ACTIVOS  -->
			</div>		
			<div class="tabs-panel " id="panel2">
				<!--  ACTIVOS -->
				<?php
					$sql_x1="SELECT sc.*, c.orden  FROM suscritos_x_cursos sc INNER JOIN cursos c ON sc.id_curso=c.id_curso
								WHERE sc.estado_idestado=1  and c.estado_idestado=1 and sc.estado=1  and sc.condicion=2  and sc.id_suscrito = '".$_SESSION['suscritos']['id_suscrito']."'  and sc.especialidades=1   
									Order by c.orden desc , c.en_vivo asc  ";
					$suscur = executesql($sql_x1);

					include('mis_cursos_listado.php');
				?>
				<!--  END ACTIVOS  -->
			</div>		
		</div>

		</div></div></div>

	
<div class="callout callout-inicio-3"><div class="row text-center "><div class="large-12 medium-12 columns content_perfil ">
	<img src="img/logo-rojo.png">
	<h3 class="color1 poppi-sb text-center">Construyendo el camino a la Revolución Educativa</h3>
		
</div></div></div>

</main>
<?php include ('inc/footer.php'); ?>