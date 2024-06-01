<?php include 'auten.php';
$unix_date = strtotime(date('Y-m-d H:i:s'));
$no_galeria="";
?>

<main id="curso" class=" ">
<?php  
if(!empty($_GET["rewrite4"])){  

	$curso = executesql(" SELECT c.*, ca.titulo as categoria, ca.titulo_rewrite AS catrewri, sc.titulo as subcategoria, sc.titulo_rewrite AS subrewri, tc.titulo_rewrite AS tiprewri, tc.id_tipo AS tipocurso FROM cursos c INNER JOIN categoria_subcate_cursos csc ON c.id_curso = csc.id_curso INNER JOIN categorias ca ON csc.id_cat = ca.id_cat INNER JOIN subcategorias sc ON csc.id_sub = sc.id_sub INNER JOIN tipo_cursos tc ON csc.id_tipo = tc.id_tipo WHERE c.estado_idestado = 1  and c.titulo_rewrite = '".$_GET['rewrite4']."' ORDER BY c.orden DESC ");
	
	$link='curso/'.$curso[0]['tiprewri'].'/'.$curso[0]['catrewri'].'/'.$curso[0]['subrewri'].'/'.$curso[0]['titulo_rewrite'];

	// data puntual
	$alumn = executesql("SELECT * FROM suscritos_x_cursos WHERE estado_idestado = 1 AND id_curso = '".$curso[0]['id_curso']."'");
	$profe = executesql("SELECT * FROM profesores WHERE id_profesor IN (".$curso[0]['id_pro'].") ");
	$fecha= date('m\/Y ',strtotime($curso[0]['fecha_actualizacion']));
	$mes= date('m',strtotime($curso[0]['fecha_actualizacion']));
	$mes_actual = date("m"); 
?>
    <div class="callout callout-10 flotante "><div class="row">
		<img src="img/iconos/ico_decora_2024.png" class="  icono_decora_flota_1 ">
			<div class="large-12  text-center  columns">
				<?php  
				/* detecto que tipo de cirso es, segun eso mofifico la ruta del link:  */
				if($curso[0]['tipocurso']==1){
						$ruta='curso/todos/';
				}else if($curso[0]['tipocurso']==2){
						$ruta='libro/todos-los-libros/';
				}else if($curso[0]['tipocurso']==3){
						$ruta='coautoria/todos-los-libros-coautoria/';
				}else{
						$ruta='error_tipo_curso';
				}
				?>
				<button title="Close (Esc)" type="button"><img src="img/iconos/icono_cerrar_index_flota.png"  class="mfp-close  " ></button>
				<blockquote class="cabezera_menu text-left poppi ">
					<?php  echo '<a href="'.$ruta.$curso[0]['catrewri'].'">'.$curso[0]['categoria'].' </a> / <a href="'.$ruta.$curso[0]['catrewri'].'/'.$curso[0]['subrewri'].'">'.$curso[0]['subcategoria'].'</a>'?>
				</blockquote>

				<?php if(!empty( $curso[0]['link_video'])){  /* video trailer */ ?>
						<div class="rel lleva_vimeo_listado">
							<iframe src="<?php echo $curso[0]['link_video']; ?>"  frameborder="0" allow="autoplay=1; fullscreen" allowfullscreen></iframe>
						</div>
				<?php }else{ 
						$imgproduct= !empty($curso[0]['imagen2'])?'tw7control/files/images/capa/'.$curso[0]['imagen2']:'img/no_imagen.jpg';
				?>
						<figure class="rel ">
							<img src="<?php echo $imgproduct ?>" class="principal _flotante ">
						</figure>
				<?php }  ?>
			</div>
			<div class="large-7 medium-6  columns">
	
				<h1 class="poppi-sb  "><?php echo $curso[0]['titulo'] ?></h1>				
				<?php echo !empty($curso[0]['breve_detalle']) ? '<div class="poppi texto rel breve_detalle text-justify "><p>'.$curso[0]['breve_detalle'].'</p></div>' : '' ?>
				<a class=" poppi-sb  " href="<?php echo $link ?>" ><p class="poppi-b _mas_info texto"> Más detalles  <img src="img/iconos/flecha_flotante.png" style="padding-left:8px;"> </p></a>
				
			<?php  if(!empty($curso[0]['link_grupo_wasap']) ){ ?>													
				<div class="parte-medio text-center " style="margin-top:10px;">
					<a href="<?php echo $curso[0]['link_grupo_wasap']; ?>" title="  canal_wsp_flota" target="_blank" class=" canal_wsp_flota  poppi  "  >
						<img src="img/iconos/ws.png" alt="Únete a nuestro  canal de whatsApp "> Descubre nuestras promociones<span> Chat en vivo</span>
					</a>
				</div>
			<?php }else{  ?>
				<div class="parte-medio text-center " style="margin-top:10px;">
					<a href="<?php echo $link_grupo_wasap; ?>" title="  canal_wsp_flota" target="_blank" class=" canal_wsp_flota  poppi  "  >
						<img src="img/iconos/ws.png" alt="Únete a nuestro  canal de whatsApp "> Únete al canal de whatsApp <span>de Grupo Auge  </span>
					</a>
				</div>				
			<?php }  ?>

				<hr>
				<div id="compi" >
					<ul class="no-bullet poppi float-left color1">
						<li class="poppi">
							<a title="whatsapp" href="https://api.whatsapp.com/send/?phone&text=<?php echo 'https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'] ?>" ><img src="img/iconos/detalle_1_wsp.png"></a>
							<a title="facebook" href="javascript: void(0);" onclick="window.open('http://www.facebook.com/sharer.php?u='+window.document.URL+'','ventanacompartir', 'toolbar=0, status=0, width=650, height=450');"><img src="img/iconos/detalle_2_fb.png"></a>
							<a title="tiktok" href="" ><img src="img/iconos/detalle_3_tiktok.png"></a>
							<a title="youtube" href="" ><img src="img/iconos/detalle_4_you.png"></a>							
						</li>
					</ul>
				</div>			
			</div> <!--  end l7 -->
			
			<div class="large-5 medium-6  columns"><div class="contiene_datos_compra ">				
				<?php  
				$pagina_open="_detalle_flotante";
				include("formulario_de_compra_2024_abril.php");  
				?>
			</div></div><!--  end l5 -->

		<img src="img/iconos/ico_decora_2024.png" class=" icono_decora_flota_2 ">
    </div></div>
		
	
<?php 
}else{ //si exist rew?>
<p class="osans em texto" style="padding:80px 0;">No existe parametro...</p>
<?php } ?>
</main>

<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script src="js/foundation.min.js"></script>
<script>
$(document).foundation();
</script>
<script src="js/functions.js?ud=<?php echo $unix_date; ?>"></script>  
<script src="js/main.js?ud=<?php echo $unix_date; ?>"></script>  
<script src="js/carrito.js?ud=<?php echo $unix_date; ?>"></script>
<script src="js/suscribir_curso_gratis.js?ud=<?php echo $unix_date; ?>"></script>
