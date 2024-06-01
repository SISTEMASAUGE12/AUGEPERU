<?php include('auten.php');

// obtener numero de semana 
$fecha = new DateTime(fecha_hora(1));
$semana = $fecha->format('W');
// echo "Semana: $semana";

$fechaComoEntero = strtotime(fecha_hora(1));


if( $_GET['rewrite'] == 'esta_semana' ){
	$sql_filtro=" and  WEEK(fecha_inicio)=".$semana." ";
}elseif(  $_GET['rewrite'] == 'semana_sgte' ){
	$sql_filtro=" and WEEK(fecha_inicio)=".($semana +1)." ";

}elseif(  $_GET['rewrite'] == 'mes' ){
	$sql_filtro=" and MONTH(fecha_inicio)=".date("m", $fechaComoEntero)." ";

}

$sql = "SELECT p.*  FROM webinars p  WHERE p.estado_idestado = 1  ";
$sql.= (isset($_GET['rewrite']) && !empty($_GET['rewrite']))? $sql_filtro :"";
$sql.= " ORDER BY p.fecha_inicio DESC ";

// echo $sql; 
// echo $sql; 
 
// $custom = array();
// $custom['sql'] = $sql;
// $custom['div'] = 'listado_blog';
// $custom['params'] = isset($_POST) ?array_keys($_POST) : array();
// $custom['pages']  = 100;
// $paging = configurar_paginador($custom);

$blog_cate=executesql($sql);
if( !empty($blog_cate) ){ 
	foreach( $blog_cate as $blog01 ){
		
		if( !empty($blog01['imagen']) ){
			$imagen="tw7control/files/images/webinars/".$blog01['imagen'];
		}else{
			$imagen="img/no_imagen.jpg";
		}

		if( $blog01['tipo'] ==1){
			$link='https://www.educaauge.com/webinar/'.$blog01['titulo_rewrite']; 
		}else if( $blog01['tipo'] ==2){
			$link='https://www.educaauge.com/webinar2/'.$blog01['titulo_rewrite']; 
		}else if( $blog01['tipo'] ==3){
			$link='https://www.educaauge.com/webinar3/'.$blog01['titulo_rewrite']; 
		}else if( $blog01['tipo'] ==4){

			// $link='https://www.educaauge.com/webinar3/'.$blog01['titulo_rewrite']; 
			// aun no se usa : 13 - 09 - 2022 

		}else if( $blog01['tipo'] ==5){
			$link='https://www.educaauge.com/capacitate/'.$blog01['titulo_rewrite']; 

		}
?>
	<div class="large-12 columns blog-grande  "><div class="">
		<div class="large-3 medium-4  columns nothing ">
			<figure class="rel"><a href="<?php echo $link; ?>" target="_blank" >
				<img src="<?php echo $imagen; ?>"></a>
			</figure>
		</div>
		<div class="large-9  medium-8 columns">
			<div class="descri">
				<?php if( !empty( $blog01['fecha_en_texto']) ){ ?>
					<span class="fecha poppi fecha "><img src="img/iconos/fecha_rojo.jpg" style="padding-right:5px;"><?php echo $blog01['fecha_en_texto']; ?></span>
				<?php } ?>
				
				<?php if( !empty( $blog01['ante_titulo']) ){ ?>
					<span class="  poppi subtitulo "><?php echo $blog01['ante_titulo']; ?></span>
				<?php } ?>
				<span class="  poppi"><?php echo $blog01['titulo_seo']; ?></span>
				<div class="table-final">
					 <a href="<?php echo $link; ?>" target="_blank" class="poppi-b btn boton btn_eventos " > + información </a>
				</div>
			</div>
		</div>
	</div></div>			
<?php 
}  
?>
		

<?php

}else{

	echo '<p class="text-center osans color1" style="padding:110px 0;">No se encontro eventos </p>'; 
} 
	?>