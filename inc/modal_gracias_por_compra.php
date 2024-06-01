
<div class="small reveal modal_gracias " id="exampleModal1" data-reveal>
  <h1 class="poppi-b text-center blanco">¡<?php echo $perfil[0]["nombre"]; ?>, gracias por tu compra!</h1>					
	<h4 class=" poppi-sb color2 text-center" style="padding:20px 0;">Te recomendamos estos cursos  </h4>
	<div class="large-12 columns"><div class="rel cursos_portada modal_de_gracias_por_compra ">
<?php
		/* 
		$sql_cc="SELECT c.*, ca.titulo_rewrite AS catrewri, sc.titulo_rewrite AS subrewri, tc.titulo_rewrite AS tiprewri, tc.id_tipo AS tipocurso 
						FROM cursos c 
						INNER JOIN categoria_subcate_cursos csc ON c.id_curso = csc.id_curso
						INNER JOIN categorias ca ON csc.id_cat = ca.id_cat 
						INNER JOIN subcategorias sc ON csc.id_sub = sc.id_sub 
						INNER JOIN tipo_cursos tc ON csc.id_tipo = tc.id_tipo
						WHERE c.estado_idestado = 1 and c.tipo=1 and c.precio > 0  and  c.id_curso NOT IN ( select id_curso from suscritos_x_cursos where id_suscrito='".$_SESSION["suscritos"]["id_suscrito"]."')  
						GROUP BY c.id_curso  
						ORDER BY c.orden_destacado DESC  limit 0,4";
		*/

		$sql_cc="SELECT c.*, ca.titulo_rewrite AS catrewri, sc.titulo_rewrite AS subrewri, tc.titulo_rewrite AS tiprewri, tc.id_tipo AS tipocurso FROM cursos c INNER JOIN categoria_subcate_cursos csc ON c.id_curso = csc.id_curso INNER JOIN categorias ca ON csc.id_cat = ca.id_cat INNER JOIN subcategorias sc ON csc.id_sub = sc.id_sub INNER JOIN tipo_cursos tc ON csc.id_tipo = tc.id_tipo WHERE c.estado_idestado = 1 and c.tipo=1 and c.id_tipo=1 and c.precio > 0  and  c.id_curso NOT IN ( select id_curso from suscritos_x_cursos where id_suscrito='".$_SESSION["suscritos"]["id_suscrito"]."')   ORDER BY c.orden_destacado DESC  limit 0,4";
		 // echo $sql_cc;
?>
		<ul id="carousel-2-1" class="no-bullet">
<?php 		
		$deta = executesql($sql_cc);
		if(!empty($deta)){ foreach($deta as $detalles){
			$titulo=$detalles['titulo'];
    		$link='curso/'.$detalles['tiprewri'].'/'.$detalles['catrewri'].'/'.$detalles['subrewri'].'/'.$detalles['titulo_rewrite'];
    		$imgproduct= 'tw7control/files/images/capa/'.$detalles['imagen'];
?>
    		<li><?php include("inc/curso.php") ?></li>			 	
<?php
		} }
?>
		</ul>
		<div class="large-12 columns end text-center" >
			<a href="curso/todos" class="btn_2 botones ">VER TODOS LOS CURSOS</a>
		</div>
			
	</div></div>
	
  <button class="close-button gracias_close" data-close aria-label="Close modal" type="button">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
