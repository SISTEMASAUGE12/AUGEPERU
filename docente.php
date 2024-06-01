<?php include('auten.php');
if(!isset($_GET["rewrite"])){ header('Location: '.$url); }
$pagina='docen';
$meta = array(
    'title' => 'Auge: Docente',
    'description' => ''
);
include ('inc/header.php');
$profe = executesql("SELECT * FROM profesores WHERE titulo_rewrite = '".$_GET['rewrite']."'",0);
?>
<main id="docente" class=" <?php if(isset($_SESSION["suscritos"]["id_suscrito"]) && !empty($_SESSION["suscritos"]["id_suscrito"])){ echo "logeado"; }?> " >
	<div class="callout callout-1"><div class="row row-docen"><div class="large-12 columns">
		<div class="large-12 columns">
			<div class="foto text-center "><img class="docen" src="<?php echo !empty($profe['imagen']) ? 'tw7control/files/images/profesores/'.$profe['imagen'] : 'img/perfil-docente.png' ?>"></div>
			<div class="descri">
				<p class="poppi-b azul titulo" ><?php echo $profe['titulo'] ?></p>
				<p class="poppi-b color1 " style="padding-bottom:35px;"><small><?php echo $profe['cargo'] ?></small> </p>
				<p class="poppi-b color1 detalle"><?php echo $profe['descripcion'] ?></p>
			</div>
		</div>
	</div></div>
	
<?php 
		$sql_consulta="SELECT c.*, ca.titulo_rewrite AS catrewri, sc.titulo_rewrite AS subrewri, tc.titulo_rewrite AS tiprewri  
		FROM cursos c 
		INNER JOIN categoria_subcate_cursos csc ON c.id_curso = csc.id_curso 
		INNER JOIN categorias ca ON csc.id_cat = ca.id_cat  
		INNER JOIN subcategorias sc ON csc.id_sub = sc.id_sub 
		INNER JOIN tipo_cursos tc ON csc.id_tipo = tc.id_tipo 
		WHERE c.estado_idestado = 1  and c.visibilidad=1  AND c.id_pro IN ('".$profe['id_profesor']."') 
		GROUP BY c.id_curso  
		ORDER BY c.id_curso DESC";
		
		// echo $sql_consulta;
		
		$deta = executesql($sql_consulta);
		if(!empty($deta)){ ?>
	<div class="row">
    	<div class="large-12 columns"><h3 class="poppi-sb color1"> Cursos</h3></div>
    	<div class="large-12 columns nothing">
		
		<?php 
		foreach($deta as $detalles){
			$titulo=$detalles['titulo'];
    		$link='curso/'.$detalles['tiprewri'].'/'.$detalles['catrewri'].'/'.$detalles['subrewri'].'/'.$detalles['titulo_rewrite'];
    		$imgproduct= 'tw7control/files/images/capa/'.$detalles['imagen'];
?>
    		<div class="large-3 medium-4  columns end "><?php include("inc/curso.php") ?></div>
<?php } /* end for */ ?>
    	</div>
    </div></div>
<?php 	} ?>

</main>
<?php 

$pagina="asdsa";
include ('inc/footer.php'); ?>