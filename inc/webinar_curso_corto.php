<div  class="callout banners text-left "><div class="fondo fondo3 " style="background-image:url(tw7control/files/images/webinars/<?php echo $webinars[0]['banner_2']; ?>);"><div class="row rel">
			<div class="medium-12 columns">
				<img src="img/logo-rojo.png" class="rel " STYLE="z-index:99;">
			</div>
			<div class="medium-10 medium-centered columns">
				<h1 class="poppi-b  text-center"> <?php echo $webinars[0]['titulo_carta']; ?></br><small> <?php echo ($webinars[0]['activar_carta_2']==1)?$webinars[0]['titulo_carta_2']:''; ?> </small></h1>
			</div>
			<div class="medium-8 medium-centered  data_principal text-center columns" style="float:none;">
				<?php if(!empty( $webinars[0]['link_carta'])){  /* video trailer */ ?>
					<div class="rel lleva_vimeo_listado">
						<iframe src="	<?php echo $webinars[0]['link_carta']; ?>"  frameborder="0" allow="autoplay; fullscreen" allowfullscreen></iframe>
					</div>
				<?php }else{ 
								$imgproduct= !empty($webinars[0]['imagen_carta'])?'tw7control/files/images/webinars/'.$webinars[0]['imagen_carta']:'img/no_imagen.jpg';
				?>
					<figure class="rel ">
						<img src="<?php echo $imgproduct ?>" class="principal ">
					</figure>
				<?php 
							}  
				?> 

				
	<?php if( !empty($webinars[0]['pdf_1']) && !empty($webinars[0]['pdf_1_titulo']) ){   /* boton pdf */ ?> 
		<div class="large-12 text-center  columns" style="padding:50px 0;">
			<a href="tw7control/files/images/webinars/<?php echo $webinars[0]['pdf_1']; ?>" class="poppi boton pulse btn_pdf_webinar  btn_pdf "  target="_blank" style="margin:auto;"  > 
				<?php echo $webinars[0]['pdf_1_titulo']; ?>
			</a>
		</div>
	<?php } ?>	
			
				
		<?php  /* bton personalizado */
			if( !empty($webinars[0]['titulo_boton_link']) &&  !empty($webinars[0]['link_boton_2']) ){ 
					$stiles_boton_bg='';
					$stiles_boton='';
					
					if( !empty($webinars[0]['color_fondo_boton_link']) ){ 
						$stiles_boton_bg= "background:".$webinars[0]['color_fondo_boton_link'].";";
					}
					if(  !empty($webinars[0]['color_boton_link']) ){ 
						$stiles_boton= "color:".$webinars[0]['color_boton_link'].";";
					}
					
			?>
			<div class="large-12 text-center  columns" style="padding:50px 0;">
				<a href="<?php echo $webinars[0]['link_boton_2']; ?>" class="poppi boton pulse btn_pdf"  target="_blank" style="margin:auto;<?php echo $stiles_boton_bg.$stiles_boton; ?>"  > 
					<?php echo $webinars[0]['titulo_boton_link']; ?>
				</a>
			</div>
			<?php } ?>
				
				
				<?php 
				include("inc/share_webinar_mas_wsp.php");
				?>
				
				
				
				<!-- 
				<a class="boton botones poppi pulse comprar_ahora_webinar " href=""><b>COMPRA AHORA</b>  s/ 200.00</a>
				-->
			</div>
</div></div></div>
					
					
<div id="curso">			
	<div class="callout callout-1  ingreso poppi carta_corta "  style="padding:60px 0 0;"><div class="row">
	<?php  
	// include("formulario_de_compra_webinar.php"); 
	?>	
		<?php if( !empty($webinars[0]['link_boton_action']) && !empty($webinars[0]['titulo_boton_action']) ){   /* boton pdf */ ?> 
		<div class="large-12 text-center  columns" style="padding:50px 0;">
			<a href="<?php echo $webinars[0]['link_boton_action']; ?>" class="poppi boton pulse btn_pdf_webinar  btn_pdf "  target="_blank" style="margin:auto;"  > 
				<?php echo $webinars[0]['titulo_boton_action']; ?>
			</a>
		</div>
	<?php } ?>	
	</div></div>
</div>



<?php 
$sql_2="select * from pestanhas_webinars_cortas where estado_idestado=1 and id_webinar='".$webinars[0]['id_webinar']."' ORDER by orden asc ";
// echo $sql_2;

$pestañas=executesql($sql_2); 
if( !empty($pestañas) ){ $i=1;
	foreach( $pestañas as $row){ 
		$i++;	
		$img="tw7control/files/images/webinars/".$webinars[0]['id_webinar']."/".$row['imagen'];
		
		if($i ==2 ){
?>
<!-- pestañas landing -->
<div class="callout callout-3   poppi  "><div class="row"><div class="large-12 columns ">
	<div class="medium-6 columns  lleva_data_right ">
		<h3 class="poppi-sb "><?php echo $row["titulo"]; ?></h3>
		<div class="poppi desc_detalle "><?php echo $row["descripcion"]; ?></div>
	</div>
	<div class="medium-6 text-center columns ">
		<?php if(!empty($row["titulo"])){  ?>
		<figure class="rel" ><img src="<?php echo $img; ?>"></figure>
	<?php } ?>
	</div>
</div></div></div>
<?php 		$i=0;
			}else{  /* INMG I<QUIERDA  */ ?>
			
<div class="callout callout-3  daforma poppi  "><div class="row"><div class="large-12 columns ">
	<div class="medium-6  text-center columns ">
		<?php if(!empty($row["titulo"])){  ?>
		<figure class="rel" ><img src="<?php echo $img; ?>"></figure>
	<?php } ?>
	</div>
	<div class="medium-6 columns lleva_data_left ">
		<h3 class="poppi-sb "><?php echo $row["titulo"]; ?></h3>
		<div class="poppi desc_detalle "><?php echo $row["descripcion"]; ?></div>
	</div>
</div></div></div>		
			
<?php } ?>

<?php 
	} /* for */
} /* end pestañas 1-3 */?>


	<!-- CASOS DE EXITO -->	
<div class="callout callout-testimonios  ingreso poppi "><div class="row">
			<?php $exitos=executesql(" select * from casos_de_exitos where estado_idestado=1 and link !='' order by orden desc ");
				if( !empty($exitos)){		
			?>
			<div class=" casos_exito text-center " >
				<h4 class="poppi-b  text-center "> <img src="img/iconos/ico-exito-azul.png" style="padding-right:10px;"> Casos de éxito </h4>
			
				<?php foreach( $exitos as $row ){		 ?>
					<?php if( !empty($row["imagen"])){ ?>
				<div class="large-3 medium-4 small-6  columns end " >
					<figure  CLASS="rel">
						<img src="tw7control/files/images/casos_de_exitos/<?php echo $row['imagen'] ?>" class="imagen_1" style="width:100%;">
							<?php if(!empty($row["link"]) ){ ?>
						<a class="abs mpopup-02" href="<?php echo $row['link'] ?>"><img src="img/iconos/ico-play-small.png" class="verticalalignmiddle"></a>
							<?php }?>

					</figure>
					<div class="lleva_name_testi"><p class="poppi texto ">	<?php echo $row['titulo']; ?> </p></div>
				</div>
					<?php } /* si registor un img  */ ?>
			<?php } /*for exitos */?>
				
			</div>
			<?php } /* si existe casos de exitos */?>
</div></div>
	
<div id="curso">			
	<div class="callout callout-1  ingreso poppi carta_corta "  style="padding:10px 0 0;"><div class="row">
	<?php  
		// include("formulario_de_compra_webinar.php");  /* este boton te permite mandar directo al carrito el curdso asociado */
		?>	
		
			<?php if( !empty($webinars[0]['link_boton_action']) && !empty($webinars[0]['titulo_boton_action']) ){   /* boton pdf */ ?> 
		<div class="large-12 text-center  columns" style="padding:50px 0;">
			<a href="<?php echo $webinars[0]['link_boton_action']; ?>" class="poppi boton pulse btn_pdf_webinar  btn_pdf "  target="_blank" style="margin:auto;"  > 
				<?php echo $webinars[0]['titulo_boton_action']; ?>
			</a>
		</div>
	<?php } ?>	
	
	</div></div>
</div>
