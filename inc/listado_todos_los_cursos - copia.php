<?php 
$ruta="curso";
if($_GET['rewrite']=='todos'){
	$sql_cc="SELECT * FROM categorias WHERE id_tipo=1 and estado_idestado = 1 and id_cat!='36'  Group BY id_cat ORDER BY titulo ASC";
	// echo $sql_cc;
	$cat = executesql($sql_cc);
					
}elseif($_GET['rewrite']=='todos-los-libros' || $_GET['rewrite']=='libros'){
	$ruta="libro";
	$sql_cc="SELECT * FROM categorias WHERE id_tipo=2 and estado_idestado = 1 Group BY id_cat ORDER BY titulo ASC";
	// echo $sql_cc;
	$cat = executesql($sql_cc);
						
}elseif($_GET['rewrite']=='todos-los-libros-coautoria' || $_GET['rewrite']=='libros-coautores'){
	$ruta="coautoria";
	$sql_cc="SELECT * FROM categorias WHERE id_tipo=3 and estado_idestado = 1 Group BY id_cat ORDER BY titulo ASC";
	// echo $sql_cc;
	$cat = executesql($sql_cc);
					
}else{ /* listo categorias, excluyo a packs, xq ya sale manuelamente primero en orden . */
	$sql_cc="SELECT c.* FROM categorias c
	INNER JOIN categoria_subcate_cursos csc ON csc.id_cat = c.id_cat INNER JOIN tipo_cursos tc ON csc.id_tipo = tc.id_tipo WHERE  c.id_tipo=1 and c.estado_idestado = 1 AND tc.titulo_rewrite='".$_GET['rewrite']."' and c.id_cat!='36' Group BY c.id_cat ORDER BY c.titulo ASC";
	$sql_cc;
	// echo $sql_cc;
	$cat = executesql($sql_cc);

}
?> 

<div class="callout banners">
    <div class="fondo banner-portada rel" style="background-image:url(img/banners/XWJK43.jpg);"><div class="capa">
        <div class="row">
        <?php
         if(isset($_SESSION["suscritos"]["id_suscrito"]) and !empty($_SESSION["suscritos"]["id_suscrito"]) && empty($_GET['rewrite4']) ){  
            $offset='6';
        }else{
             $offset='4';
         }?>
            <div class="large-offset-<?php echo  $offset; ?> large-4  medium-6 columns medium-text-left text-center blanco ">
                <h3 class="poppi bold color-blanco">Compra en Educaauge</h3>
                <p>Ya somos más de 50 mil profesores que hemos logrado nuestros objetivos gracias a GRUPO AUGE </p>
            
                 <?php if(isset($_SESSION["suscritos"]["id_suscrito"]) and !empty($_SESSION["suscritos"]["id_suscrito"]) && empty($_GET['rewrite4']) ){  
                        /* si esta session y no esta en detalle de curso (orq afecta y roba espacio al flotante comprar ) */
                ?>
                    <div style="padding:40px 0 ;margin:0 auto;max-width:320px;">
                        <a href="mis-cursos"><p class="nro_pedidos poppi-sb" style="background: #db271c;padding: 10px;color: #fff;border-radius: 8px;text-align:center;">Mis cursos comprados</p></a>
                    </div>
                <?php } ?> 

            </div>
            <div class=" large-4  medium-6  columns medium-text-right text-center blanco ">
                <?php 
                                if(isset($_SESSION["suscritos"]["id_suscrito"]) && !empty($_SESSION["suscritos"]["id_suscrito"])){ 
                                }else{
                                    include('inc/formulario_registro_banner.php');
                                }
                ?>
            </div><!-- end l4 -->
        </div>  
    </div></div>
</div> <!--  end banner -->


<div class="callout callout-3"><div class="row">
    <div class="men-fil">
        <a id="mita1" class="mita1 poppi-b"><img src="img/iconos/filtro.png"> Filtros</a>
		<!-- 
        <a id="mita2" class="mita2 poppi-b">Recomendados <i class="ica"></i></a>
		-->
    </div>
<?php	
    if(!empty($cat)){
    echo '<ul id="memi" class="accordion" data-accordion>';
    foreach($cat as $cate){
?>
        <li class="accordion-item <?php echo (isset($_GET['rewrite2']) && ($_GET['rewrite2']==$cate['titulo_rewrite'])) ? ' is-active' : '' ?>" data-accordion-item>
            <a href="#" class="accordion-title poppi-b"><?php echo $cate['titulo'] ?></a>
            <div class="accordion-content" data-tab-content><div class="lista">
<?php
            $sub = executesql("SELECT * FROM subcategorias WHERE estado_idestado = 1 AND id_cat = ".$cate['id_cat']." ORDER BY orden DESC");
            if(!empty($sub)){ foreach($sub as $subc){
?>
                <a href="<?php echo $ruta.'/'.$_GET['rewrite'].'/'.$cate['titulo_rewrite'].'/'.$subc['titulo_rewrite'] ?>" class="poppi<?php echo (isset($_GET['rewrite3']) && ($_GET['rewrite3']==$subc['titulo_rewrite'])) ? ' activo' : '' ?>"><?php echo $subc['titulo'] ?></a>
<?php
            } }
?>
            </div></div>
        </li>
<?php
    }
    echo '</ul>';
    }
?>
    <div id="laca" style="display:none"><ol class="no-bullet">
        <li><a class="poppi-b">Recomendados</a></li>
        <li><a class="poppi-b">Ofertas</a></li>
        <li><a class="poppi-b">Nuevos</a></li>
        <li><a class="poppi-b">Gratuitos</a></li>
    </ol></div>

    <div class="large-12 columns">
        <p class="poppi-b tosd color3">Todos los <?php echo ($ruta=="coautoria")?'Libros de '.$ruta: $ruta.'s'; ?></p>
        <h1 class="poppi-b desc color1">Nuestros <?php echo ($ruta=="coautoria")?'Libros de '.$ruta: $ruta.'s'; ?></h1>
    </div>

    <div class="large-12 columns">
<?php
        $link = $_SERVER['REQUEST_URI'];
?>
        <div class=" large-8  medium-6  columns medium-text-right text-center blanco ">
            <form class="formulario desc" action="<?php echo $link ?>" method="POST">
                <input type="text" name="buscar" <?php echo (isset($_POST['buscar']) && !empty($_POST['buscar'])) ? 'value="'.$_POST['buscar'].'"' : '' ?>>
                <button><img src="img/iconos/lupa.png"></button>
                <label class="poppi-l color1">Busca el <?php echo ($ruta=="coautoria")?'Libro de '.$ruta: $ruta; ?> de tu interés</label>
            </form>
        </div>
        <div class=" large-4  medium-6  columns medium-text-right text-center blanco hide ">
            <?php include('inc/formulario_registro_banner.php'); ?>
        </div><!-- end l4 -->
    </div>
				
    <div class="large-3 medium-3 columns menu_categorias_cursos_pc "> <!--  menu de cursos -->
        <span class="poppi cate color4 desc">Categorías</span>
<?php
        if(!empty($cat)){
        echo '<ul class="accordion desc" data-accordion>';
						
		if($_GET['rewrite'] !='todos-los-libros' && $_GET['rewrite'] !='libros'  &&  $_GET['rewrite'] !='todos-los-libros-coautoria' && $_GET['rewrite'] !='libros-coautores'){
?>
			<!-- Inicio ostranto opcion de packs de cursos: cursos que tienen cursos depenientes -->
		    <li class="accordion-item <?php echo (isset($_GET['rewrite2']) && ($_GET['rewrite2']=="packs")) ? ' is-active' : '' ?>" data-accordion-item>
                <a href="#" class="accordion-title poppi-b">Packs de  <?php echo $ruta.'s'; ?>. </a>
                <div class="accordion-content" data-tab-content><div class="lista">
					<a href="<?php echo  $ruta.'/'.$_GET['rewrite']; ?>/packs" class="  poppi-b  <?php echo (isset($_GET['rewrite2']) && ($_GET['rewrite2']=='packs')) ? ' activo' : '' ?> ">Packs de <?php echo $ruta.'s'; ?> </a>
                </div></div>
			</li>
<?php 
		}
		/* recorro las categorias */
        foreach($cat as $cate){
?>
            <li class="accordion-item <?php echo (isset($_GET['rewrite2']) && ($_GET['rewrite2']==$cate['titulo_rewrite'])) ? ' is-active' : '' ?>" data-accordion-item>
                <a href="#" class="accordion-title poppi-b"><?php echo $cate['titulo'] ?></a>
                <div class="accordion-content" data-tab-content><div class="lista">
<?php
                $sub = executesql("SELECT * FROM subcategorias WHERE estado_idestado = 1 AND id_cat = ".$cate['id_cat']." ORDER BY orden DESC");
                if(!empty($sub)){ foreach($sub as $subc){
?>
                    <a href="<?php echo $ruta.'/'.$_GET['rewrite'].'/'.$cate['titulo_rewrite'].'/'.$subc['titulo_rewrite'] ?>" class="poppi<?php echo (isset($_GET['rewrite3']) && ($_GET['rewrite3']==$subc['titulo_rewrite'])) ? ' activo' : '' ?>"><?php echo $subc['titulo'] ?></a>
<?php
                } }
?>
                </div></div>
            </li>
<?php
        }
        echo '</ul>';
        }
?>
    </div> <!-- end menu de cursos  -->
     <!-- end menu de cursos  -->
     
    <div class="large-9 medium-9 columns nothing">
<?php 
	if( ($_GET['rewrite']=='todos' || $_GET['rewrite']=='todos-los-libros' || $_GET['rewrite']=='todos-los-libros-coautoria') && !isset($_GET['rewrite2'])){ /*  muestro las categeorias */ ?>
					
		<span class="poppi-sb curs desc color4">Nuestras categorías</span>
        <form name="frm_listado" style="display:none;" id="frm_listado" enctype="multipart/form-data">
<?php
            echo (isset($_GET['rewrite']) && !empty($_GET['rewrite'])) ? '<input type="hidden" name="tipa" value="'.$_GET['rewrite'].'">' : '';
            echo (isset($_GET['rewrite2']) && !empty($_GET['rewrite2'])) ? '<input type="hidden" name="categoria" value="'.$_GET['rewrite2'].'">' : '';
            echo (isset($_GET['rewrite3']) && !empty($_GET['rewrite3'])) ? '<input type="hidden" name="subcategoria" value="'.$_GET['rewrite3'].'">' : '';
            echo (isset($_POST['buscar']) && !empty($_POST['buscar'])) ? '<input type="hidden" name="busque" value="'.$_POST['buscar'].'">' : '';
        ?>
        </form>
<?php 
		if( $_GET['rewrite']=='todos-los-libros' ){ /*  muestro las categeorias */ ?>
        <div id="listado_categorias_libros" class="load-content"><p class="text-center" style="padding:110px 0;">Espere mientras listado se va cargando...</p></div>
				
						<?php }else if( $_GET['rewrite']=='todos-los-libros-coautoria' ){ /*  muestro las categeorias */ ?>
            <div id="listado_categorias_libros_coautoria" class="load-content"><p class="text-center" style="padding:110px 0;">Espere mientras listado se va cargando...</p></div>
						
						<?php }else{ ?>
            <div id="listado_categorias" class="load-content"><p class="text-center" style="padding:110px 0;">Espere mientras listado se va cargando...</p></div>
						<?php } ?>
								
			<?php }else{ ?>
            <span class="poppi-sb curs desc color4">
							<?php
								if( isset($_GET['rewrite2']) && !empty($_GET['rewrite2']) && $_GET['rewrite2']=="packs" ){ 
									echo 'Packs de cursos';
									
								}else if( isset($_GET['rewrite2']) && !empty($_GET['rewrite2']) && $ruta=="coautoria" ){ 
									echo 'Libros de coautoría';
								}else{ 
									echo 'Nuevos '.$ruta.'s';
								}
							?>
						</span>
            <form name="frm_listado" style="display:none;" id="frm_listado" enctype="multipart/form-data">
            <?php
                echo (isset($_GET['rewrite']) && !empty($_GET['rewrite'])) ? '<input type="hidden" name="tipa" value="'.$_GET['rewrite'].'">' : '';
                echo (isset($_GET['rewrite2']) && !empty($_GET['rewrite2'])) ? '<input type="hidden" name="categoria" value="'.$_GET['rewrite2'].'">' : '';
                echo (isset($_GET['rewrite3']) && !empty($_GET['rewrite3'])) ? '<input type="hidden" name="subcategoria" value="'.$_GET['rewrite3'].'">' : '';
                echo (isset($_POST['buscar']) && !empty($_POST['buscar'])) ? '<input type="hidden" name="busque" value="'.$_POST['buscar'].'">' : '';
            ?>
            </form>
						<?php if( $_GET['rewrite']=='todos-los-libros' ||  $_GET['rewrite']=='libros' ){ /*  muestro las libros  */ ?>
            <div id="listado_curso_libros" class="load-content"><p class="text-center" style="padding:110px 0;">Espere mientras listado se va cargando...</p></div>
						
						<?php }else if( $_GET['rewrite']=='todos-los-libros-coautoria' ||  $_GET['rewrite']=='libros-coautores' ){ /*  muestro las libros  */ ?>
            <div id="listado_curso_libros_coautoria" class="load-content"><p class="text-center" style="padding:110px 0;">Espere mientras listado se va cargando...</p></div>
						
						<?php }else{
												include("listado_curso.php");
						?>
						<!-- 
            <div id="listado_curso" class="load-content"><p class="text-center" style="padding:110px 0;">Espere mientras listado se va cargando...</p></div>
						-->
						<?php } ?>
						
			<?php } ?>
						
				</div>
				
    </div></div>