<?php if(  $pagina != "perfil_home"  &&  $pagina != "detalle_curso"  &&   $pagina != "cesta" ){ ?>

<div class=" _flotante_izquierda  text-center poppi ">
	<ul class=" no-bullet  text-center ">
		<li>
			<a href="<?php echo $url; ?>">
				<figure><img src="img/iconos/icono_flotante_1.png"></figure>
				<p>Inicio</p>
			</a>
		</li>
		<li>
			<a href="curso/todos">
				<figure><img src="img/iconos/icono_flotante_2.png"></figure>
				<p>Cursos</p>
			</a>
		</li>
		
		<li>
			<a href="blog">
				<figure><img src="img/iconos/icono_flotante_3.png"></figure>
				<p>Noticias</p>
			</a>
		</li>
		
		<li>
			<a href="examen/todos">
				<figure><img src="img/iconos/icono_flotante_7.png"></figure>
				<p>Exámenes</p>
			</a>
		</li>
		
		<li>
		<a href="testimonios">
				<figure><img src="img/iconos/icono_flotante_5.png"></figure>
				<p>Testimonios</p>
			</a>
		</li>
		<li>
			<a href="nosotros">
				<figure><img src="img/iconos/icono_flotante_6.png"></figure>
				<p>Nosotros</p>
			</a>
		</li>
		
	</ul>
</div> 

<?php } ?> 