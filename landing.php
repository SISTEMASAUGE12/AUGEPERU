<?php include('auten.php');
$pagina='landing';
$landing = executesql("SELECT * FROM landings where estado_idestado=1 and titulo_rewrite='".$_GET['rewrite']."' ");
if( !empty($landing) ){
	$titu=$landing[0]['titulo'];
}else{
	$titu="";
}
$meta = array(
    'title' => $titu.' | GRUPO AUGE',
    'description' => ''
);
include('inc/header_solo_logo.php'); 
?>
<main id="landing">

<?php  
if(isset($_GET['rewrite']) && !empty($_GET['rewrite']) ){ 
	if( !empty($landing) ){
			$landing_modulos = executesql("SELECT * FROM modulos_landings where estado_idestado=1 and id_landing='".$landing[0]['id_landing']."' ");
			if( !empty($landing_modulos) ){
				$i=0;
					foreach($landing_modulos as $detalle){ 
						if($i ==2){
							$i=1;
						}else{
							$i++;
						}
?>

	<div class="callout callout-<?php echo $i; ?>"><div class="row">
		<div class="large-12 columns">
			<h2 class="poppi-b color1 text-left"><?php echo $detalle['titulo'] ?></h2>
			<div class="texto poppi detalle ">
				<?php echo $detalle['descripcion'] ?>
			</div>
		</div>
	</div></div>

<?php 		}// for 
			}else{  // si no existen modulos 
					echo "<div class='text-center' style='padding:190px 0;'>Aún no tenemos información disponible ..</div> "; 
			}
			
	}else{ 
		echo "<script>alert('Landing no existe o no esta disponible ..');</script>";
		header('Location: '.$url); 
	}
	
}else{ 
?> 
	<script>alert('Landing no existe o no esta disponible ..');</script>
<?php 
	header('Location: '.$url);
}
?> 

</main>
<?php include ('inc/footer.php'); ?>