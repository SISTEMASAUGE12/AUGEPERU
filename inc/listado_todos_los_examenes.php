<?php 
$ruta="examen";
if($_GET['rewrite']=='todos'){
	$sql_cc="SELECT * FROM categoria_examenes WHERE  estado_idestado = 1  and mostrar_en_la_web =1  Group BY id_cate ORDER BY orden desc";
//	echo $sql_cc;
	$cat = executesql($sql_cc);
		
    /*
}else{ // listo categoria_examenes, excluyo a packs,  y incluyo a gratis ::: xq ya sale manuelamente primero en orden . 
	$sql_cc="SELECT c.* FROM categoria_examenes c
	 WHERE   c.estado_idestado = 1 AND c.titulo_rewrite='".$_GET['rewrite']."'  Group BY c.id_cate ORDER BY c.orden desc";
    // echo $sql_cc;
	$cat = executesql($sql_cc);
    */

}

// include("inc/banners_portadas.php"); 
?>


<div class="callout callout-3"><div class="row">
    <div class="men-fil">
        <a id="mita1" class="mita1 poppi-b"><img src="img/iconos/filtro.png"> Filtros</a>
    </div>
<?php	
    if(!empty($cat)){
    echo '<ul id="memi" class="accordion" data-accordion>';
    foreach($cat as $cate){
?>
        <li class="accordion-item <?php echo (isset($_GET['rewrite2']) && ($_GET['rewrite2']==$cate['titulo_rewrite'])) ? ' is-active' : '' ?>" data-accordion-item>
            <a href="#" class="accordion-title poppi-b"><?php echo $cate['titulo'] ?></a>
            <div class="accordion-content" data-tab-content><div class="lista">
                <a href="<?php echo $ruta.'/'.$_GET['rewrite'].'/'.$cate['titulo_rewrite'] ?>" class="poppi "> ver exámenes </a>
            </div></div>
        </li>
<?php
    }
    echo '</ul>';
    }
?>
   
    <div class="large-12 columns">
        <p class="poppi-b tosd color3">Todos los exámenes</p>
        <h1 class="poppi-b desc color1">Nuestros exámenes</h1>
    </div>
				
    <div class="large-3 medium-3 columns menu_categoria_examenes_cursos_pc "> <!--  menu de cursos -->
        <span class="poppi cate color4 desc">Categorías: </span>
<?php
        if(!empty($cat)){
        echo '<ul class="accordion desc" data-accordion>'; 
        /*
?>           
            <!-- que salgan curso gratis -->
		    <li class="accordion-item <?php echo (isset($_GET['rewrite2']) && ($_GET['rewrite2']=="gratis")) ? ' is-active' : '' ?>" data-accordion-item>
                <a href="#" class="accordion-title poppi-b"> Cursos gratuitos </a> <!--  algo mas complejo se pude conactenar con ruta para mostras libros , etc -->
                <div class="accordion-content" data-tab-content><div class="lista">
                    <a href="<?php echo  $ruta.'/'.$_GET['rewrite']; ?>/gratis" class="  poppi-b  <?php echo (isset($_GET['rewrite2']) && ($_GET['rewrite2']=='gratis')) ? ' activo' : '' ?> ">
                        Ver cursos gratuitos <!-- Packs de <?php echo $ruta.'s'; ?> -->
                    </a>
                </div></div>
			</li>              
<?php 
		*/
		/* recorro las categoria_examenes */
        foreach($cat as $cate){
?>
            <li class="accordion-item <?php echo (isset($_GET['rewrite2']) && ($_GET['rewrite2']==$cate['titulo_rewrite'])) ? ' is-active' : '' ?>" data-accordion-item>
                <a href="#" class="accordion-title poppi-b"><?php echo $cate['titulo'] ?></a>
                <div class="accordion-content" data-tab-content><div class="lista">
                    <a href="<?php echo $ruta.'/'.$_GET['rewrite'].'/'.$cate['titulo_rewrite']?>" class=" "> ver exámenes</a>
                </div></div>
            </li>
<?php
        }
        echo '</ul>';
        }
?>
    </div> <!-- end menu de cursos  -->
     <!-- end menu de cursos  -->
     
    <div class="large-9 medium-9 columns nothing list_examenes_vender ">
<?php 
	if( ($_GET['rewrite']=='todos' ) && !isset($_GET['rewrite2'])){ /*  muestro los cuadros de categeorias */ ?>
					
		<span class="poppi-sb curs desc color4">Nuestras categorías </span>
        <div id="listado_categorias_examenes" class="load-content"><p class="text-center" style="padding:110px 0;">Espere mientras listado se va cargando...</p></div>
						
<?php 
    }else{  // listado de curso genrales neto cursos  ?>
            <span class="poppi-sb curs desc color4">
                <?php
                    if( isset($_GET['rewrite2']) && !empty($_GET['rewrite2']) && $_GET['rewrite2']=="packs" ){ 
                        echo 'Packs de cursos';
                    }else if( isset($_GET['rewrite2']) && !empty($_GET['rewrite2']) && $_GET['rewrite2']=="gratis" ){ 
                        echo ' Cursos gratuitos ';
            
                    }else{ 
                        echo 'Nuevos exámenes';
                    }
                ?>  
            </span>

            <form name="frm_listado" style="display:none;" id="frm_listado" enctype="multipart/form-data">
            <?php
                echo (isset($_GET['rewrite']) && !empty($_GET['rewrite'])) ? '<input type="hidden" name="tipa" value="'.$_GET['rewrite'].'">' : '';
                echo (isset($_GET['rewrite2']) && !empty($_GET['rewrite2'])) ? '<input type="hidden" name="categoria" value="'.$_GET['rewrite2'].'">' : '';
                echo (isset($_POST['buscar']) && !empty($_POST['buscar'])) ? '<input type="hidden" name="busque" value="'.$_POST['buscar'].'">' : '';
            ?>
            </form>
		
        <?php  // echo "asfasfasf";
				include("listado_examen.php");
        ?>											
<?php } // end else general ?>						
        </div>
				
    </div></div>