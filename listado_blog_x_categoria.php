<?php 
// include('auten.php');
$ruta="curso";$id_tipo=1;

$sql = "SELECT p.*, c.titulo_rewrite as tipo_rew FROM publicacion p INNER JOIN categoriablogs c ON c.tipo = p.tipo WHERE p.estado_idestado = 1  ";
$sql.= (isset($_GET['rewrite']) && !empty($_GET['rewrite']))?" and c.titulo_rewrite='".$_GET['rewrite']."' ":"";
$sql.= " ORDER BY p.orden DESC ";

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
		$meses=array('Jan'=>'ENERO','Feb'=>'FEBRERO','Mar'=>'MARZO','Apr'=>'ABRIL','May'=>'MAYO','Jun'=>'JUNIO','Jul'=>'JULIO','Aug'=>'AGOSTO','Sep'=>'SEPTIEMBRE','Oct'=>'OCTUBRE','Nov'=>'NOVIEMBRE','Dec'=>'DICIEMBRE');
		$fecha= strtr(date('d\ \d\e\ M',strtotime($blog01['fecha_registro'])),$meses);
		$idq=$blog01['idpublicacion'];
	 
?>
		
			<div class="large-12 columns blog-grande "><div class="">
					<p class="poppi-sb titulo "><a href="blog/<?php echo $blog01['tipo_rew'].'/'.$blog01['titulo_rewrite'] ?>"><?php echo $blog01['titulo'] ?></a></p>
					<div class="large-3 medium-4  columns nothing ">
						<figure class="rel"><a href="blog/<?php echo $blog01['tipo_rew'].'/'.$blog01['titulo_rewrite'] ?>"><img src="tw7control/files/images/publicaciones/<?php echo $blog01[	'imagen'] ?>"></a></figure>
					</div>
					<div class="large-9  medium-8 columns">
						<div class="descri">
							<span class="fecha poppi"><?php echo short_name( $blog01['avance'],120); ?></span>
							<span class="fecha poppi"><?php echo $fecha?></span>
							<div class="table-final">
								<div class="poppi"><a href="blog/<?php echo $blog01['tipo_rew'].'/'.$blog01['titulo_rewrite'] ?>" class="ref">Leer más</a></div>
								<!--
								<div class="poppi">7 min de lectura</div> 
								<div class="poppi text-right"><a><img src="img/iconos/compartir.png"></a></div>
								-->
							</div>
						</div>
					</div>
			</div></div>
			
<?php
	}
?>
		

<?php
	// echo '<div class="large-12 columns"><div class="pagination text-center " role="navigation" arial-label="Pagination">'.$paging->fetchNavegacion().'</div></div>';
}else echo '<p class="text-center osans color1" style="padding:110px 0;">No se encontro contenido .. </p>'; ?>