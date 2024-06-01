<?php include 'auten.php';
$unix_date = strtotime(date('Y-m-d H:i:s'));
$no_galeria="";
?>

<main id="curso" class=" trailers">
<?php 
if(!empty($_GET["rewrite"])){  
	$sql_=" select c.*, cu.titulo as curso 
					FROM curso_trailers c 
					INNER JOIN cursos cu ON c.id_curso=cu.id_curso 
					WHERE c.estado_idestado = 1  and c.id_curso = '".$_GET['rewrite']."' ORDER BY c.orden asc  ";
	$trailers = executesql($sql_);
	
?>
    <div class="callout callout-10  poppi flotante "><div class="row">
			<div class="large-12  poppi  pad_1 columns">						
				<blockquote>Vista previa del curso</blockquote>
				<h1 class="poppi-sb  " ><?php echo $trailers[0]['curso']; ?></h1>
			</div>
			<div class="large-12  poppi nothing listado_trailers columns">	
<?php 
			$inicio=1;
			foreach($trailers as $data){
					
					if(!empty( $data['link'])){  /* video trailer */ ?>
					<div id="videotrailer-<?php echo $data["id_trailer"];?>" class="rel lleva_vimeo_listado  mostrar_traile_<?php echo $data["id_trailer"];?> <?php echo ($inicio==1)?'':' hide';?>  ">
							<iframe src="	<?php echo $data['link']; ?>"  frameborder="0" allow="autoplay; fullscreen" allowfullscreen></iframe>
					</div>
		<?php 
				$inicio++;
				}  
			} 
		?>
				<blockquote class="poppi-sb " >Vídeos de ejemplo gratuitos:</blockquote>
		<?php 		
			$inicio_2=1;
			foreach($trailers as $data){
			?>
					<div id="trailer-<?php echo $data["id_trailer"];?>" class="large-12 poppi nothing blanco linea_trailer columns <?php echo ($inicio_2==1)?'activado ':' ';?> ">	
						<div class="large-2  small-2	 text-center poppi  columns">	
							<figure><img src="tw7control/files/images/trailers/<?php echo $data["imagen"];?>"></figure>
						</div>					
						<div class="large-8  small-8 nothing poppi  columns">	
							<p class="rel titulo activado "><img src="img/iconos/ico_video_play.png" class="abs"><?php echo $data["titulo"];?></p>
						</div>					
						<div class="large-2  small-2 text-center poppi  columns">	
							<p><?php echo $data["duracion"];?></p>
						
						</div>
					
					
					</div>
		<?php
				$inicio_2++;
			} /* end for */ ?>
			</div>
    </div></div>
		
	
<?php 
}else{ //si exist rew?>
<p class="osans em texto blanco  text-center " style="padding:80px 0;">No existe parametro...</p>
<?php } ?>
</main>


<script src="js/foundation.min.js"></script>
<script>
$(document).foundation();
</script>

<script src="js/main.js?ud=<?php echo $unix_date; ?>"></script>  
