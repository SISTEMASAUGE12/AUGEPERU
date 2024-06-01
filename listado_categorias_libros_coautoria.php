<?php include('auten.php');
$ruta="coautoria";$id_tipo=3;

$sql = "SELECT c.*, c.titulo_rewrite as catrewri, tc.titulo_rewrite as tiprewri FROM categorias c
						INNER JOIN tipo_cursos tc ON c.id_tipo = tc.id_tipo 
						WHERE  c.id_tipo=".$id_tipo." and  c.estado_idestado = 1   ";
// $sql.=" Group BY c.id_cat ORDER BY c.titulo DESC ";
$sql.="  ORDER BY c.titulo DESC ";

// echo $sql; 

$custom = array();
$custom['sql'] = $sql;
$custom['div'] = 'listado_categorias_libros_coautoria';
$custom['params'] = isset($_POST) ?array_keys($_POST) : array();
$custom['pages']  = 100;
$paging = configurar_paginador($custom);
if($paging->numTotalRegistros>0){ while ($detalles = $paging->fetchResultado()):
    $titulo=$detalles['titulo'];
    $link=$ruta.'/'.$detalles['tiprewri'].'/'.$detalles['catrewri'];
    $imgproduct= 'tw7control/files/images/categorias/'.$detalles['imagen']; ?>
		
    <div class="large-4 medium-4 columns nothing"><?php include("inc/categoria.php") ?></div>
<?php
	endwhile;
	?>
		<script >
			    // Magnific Popup
			if($('.mpopup-01').length){ $('.mpopup-01').magnificPopup({ type : 'image', delegate : 'a', gallery : { enabled:true } }); }
			if($('.mpopup-02').length){ $('.mpopup-02').magnificPopup({ type : 'iframe' }); } /* efecto ventana emergente ara video*/
			$('.mpopup-03').magnificPopup({ type : 'ajax' });//emergente
		</script>
		<script src="js/carrito.js"></script>

<?php
	echo '<div class="large-12 columns"><div class="pagination text-right" role="navigation" arial-label="Pagination">'.$paging->fetchNavegacion().'</div></div>';
}else echo '<p class="text-center osans color1" style="padding:110px 0;">No se encontro '.$ruta.'</p>'; ?>