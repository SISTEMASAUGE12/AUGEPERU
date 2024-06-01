    <div class="large-3 medium-4 nothing columns new_menu menu_del_clases ">
    	<div class="titu-gene">
            <h3 class="poppi-sb"><?php echo $curs[0]['titulo'] ?></h3>
            <div class="progreso"><div class="avanc" style="width:<?php echo $porcentaje ?>%"></div></div>
            <div><p class="color-blanco poppi texto_progreso"> <?php echo $porcentaje ?>%  completado</p></div>

            <?php   if(  $curs[0]['en_vivo']==1){ /* valido si esta activo el boton */   
                          $enlace_a_clase= $curs[0]['enlace_en_vivo'];
                          ?>
                      <div class="lleva_boton_en_vivo text-center ">
                        <a href="<?php echo $enlace_a_clase; ?>" target="_blank">
                        <figcaption class="en_vivo text-left animated infinite pulse delay-2s  ">                             
                              <p class="poppi-sb " > <img src="img/iconos/click_aqui.png" style="padding-right:20px;" ><span>Transmisión en vivo </span> </p>
                              <!-- <?php echo $curs[0]['hora_en_vivo'];?> -->
                          </figcaption>
                        </a> 
                      </div>                      
                    <?php 
                      }// end btn curso en vivo 
                    ?>  
        </div>
<?php
    $ses = executesql("SELECT * FROM sesiones WHERE estado_idestado = 1 AND id_curso = ".$curs[0]['id_curso']." ORDER BY ORDEN DESC");
    $z=1;
    $general=1;
    $loe=1;
    if(!empty($ses)){
        // echo '<div class="calco"><ul class="accordion" style="margin-bottom:25px !important" data-accordion data-allow-all-closed="true"  >';
        echo '<div class="calco"><ul class="accordion" style="margin-bottom:25px !important" data-accordion  data-accordion data-multi-expand="true"  >';
        foreach($ses as $sesi){

						if($z == 1){
							$primera_sesion=$sesi["id_sesion"];  /* util para listar la primera clase, por defecto */
						}
						$estado_clases_modulos="completas";
						// validamos las clases finalizadas .. 
						$modulo_completo=executesql("SELECT estado_fin FROM avance_de_cursos_clases WHERE id_curso = '".$curs[0]['id_curso']."' and id_sesion = '".$sesi['id_sesion']."' and id_suscrito='".$_SESSION['suscritos']['id_suscrito']."' ");
						if(!empty($modulo_completo)){ 
							foreach($modulo_completo as $recorro_clase_vista){
								if($recorro_clase_vista['estado_fin']=='2'){
									// si encuentro una clase que aun no esta finalizada ya no muestro el check verde. 
									$estado_clases_modulos="falta";
								}
							}	
						}else{
							$estado_clases_modulos="falta";
							// echo "<small>error val() modulos completos</small>";
							echo "<script>console.log('error val() modulos completos sin clase al momento de la compra .. '); </script>";
						}
			// validamos las clases finalizadas .. 
?>
            <!-- <li class="accordion-item   " data-accordion-item>  *** no despliega el modulo de clase -->
            <li class="accordion-item is-active  <?php   echo ( isset($_GET['task3']) && $_GET['task3']==$sesi['titulo_rewrite']) ? 'is-active' : '' ?>" data-accordion-item>  <!-- -->
                <!-- 
                    <a href="#" class="accordion-title <?php //echo ($estado_clases_modulos=="completas")?'comprobado':'';?>  poppi-b"><i class="fa fa-arrow-right"></i><?php echo $sesi['titulo'] ?></a>
                -->
                <a href="#" class="accordion-title <?php echo ($estado_clases_modulos=="completas")?'comprobado':'';?>  poppi-sb"><img src="img/icono_sesion_clase.png" class=" _icono_sesion "><?php echo $sesi['titulo'] ?> <br><?php echo $detal['descripcion'] ?></a>
                
                <div class="accordion-content" data-tab-content>
<?php            
                // Listamos las clases por sesion 
                $n_intercalado_color_fondo=1;
                $det = executesql("SELECT * FROM detalle_sesiones WHERE estado_idestado = 1 AND id_sesion = ".$sesi['id_sesion']." ORDER BY orden asc ");
                if(!empty($det)){ echo '<div class="lista">';
                    foreach($det as $deta){
                        if( $n_intercalado_color_fondo ==3 ){
                            $n_intercalado_color_fondo =1;  // para sombrear intercalado 
                        }

                        $edc2=executesql("SELECT estado_fin FROM avance_de_cursos_clases WHERE id_curso = '".$curs[0]['id_curso']."' and id_detalle = '".$deta['id_detalle']."' and id_sesion='".$sesi['id_sesion']."' and id_suscrito='".$_SESSION['suscritos']['id_suscrito']."' ");
                        // $isActive = (isset($_GET['task4']) && $deta['titulo_rewrite'] == $_GET['task4']) ? 'active' : '';

?>
                        <div class=" _contiene_clase  _color_fondo_clase_<?php  echo $n_intercalado_color_fondo; ?><?php echo $isActive; ?> ">
                        <!-- <p class="poppi texto rel <?php echo $isActive; ?>"> -->

                                <p class="poppi texto rel   <?php echo (isset($_GET['task4']) && $deta['titulo_rewrite']==$_GET['task4']) ? 'acti' : '' ?>">
                                    <?php echo (isset($_GET['task4']) && $deta['titulo_rewrite']==$_GET['task4']) ?
                                        '<i class="fas fa-check"></i>' 
                                        : '<i class="fa'.((empty($edc2) || ($edc2[0]['estado_fin']==2)) ?
                                            'r' 
                                            : 's').' fa-circle"></i>' ?>
                                    <?php echo $deta['titulo'] ?>
                                </p> 
                                
                                <!-- SE FRAGMENTE LA CLASE POR ETAPAS -->
                                <div class=" _listado_de_eventos_por_clase ">
                                    <a id="llama<?php echo $loe; ?>" href="<?php echo 'perfil/'.$_GET['task'].'/'.$_GET['task2'].'/'.$sesi['titulo_rewrite'].'/'.$deta['titulo_rewrite'] ?>">
                              
                                    
                                <?php 
                                    if( $deta['lleva_video'] == 1){  
                                        if( !empty($deta['externo']) ){ // si link externo                            
                                ?> 
                                        <p class="poppi texto rel  " ><i class="far fa-circle "></i> CLASE EN VIVO  </p>
                                    <?php }else{ ?>
                                        <p class="poppi texto rel  " ><i class="far fa-star"></i> <?php echo htmlspecialchars(trim(strip_tags($deta['descripcion'])), ENT_QUOTES, 'UTF-8'); ?></p>
                                        <p class="poppi texto rel  " ><i class="far fa-circle "></i> VIDEO - <?php echo $deta['duracion']; ?> min </p>
                                    <?php }  ?>
                                    
                                    
                                <?php }else{ ?>
                                        <p class="poppi texto rel  " ><i class="far fa-circle "></i> Introducción </p>
                                <?php }?>

                                    </a>
                        <?php 
                        // recursos listado				
		                $recur = executesql("SELECT * FROM archivos_detalle_sesion_virtuals WHERE estado_idestado = 1 AND id_detalle = '".$deta['id_detalle']."'");
		                if(!empty($recur)){ 
			                foreach ($recur as $recurso){ ?>
                                    <a   href="<?php echo 'perfil/'.$_GET['task'].'/'.$_GET['task2'].'/'.$sesi['titulo_rewrite'].'/'.$deta['titulo_rewrite'].'/'.$recurso['idimagen'] ?>">
                                        <p class="poppi texto rel  " ><i class="far fa-circle "></i> Material - PDF</p>
                                    </a>

                    <?php }
                        } 
                    ?> 
                    
                                    <p class="poppi texto rel  hide " ><i class="far fa-circle "></i> Cuestionario  </p>
                                </div>
                                <!-- END FRAGMENTACION -->
                        </div>


<?php
					if(isset($_GET['task4']) && $deta['titulo_rewrite']==$_GET['task4']){
						$general = $loe;				
					}
					$loe++;
                    $z++;

                    $n_intercalado_color_fondo++;
                } // end for clases 
							echo '</div>'; }
?>
                </div>
            </li>
<?php
        } /* END for sesiones */
        echo '</ul></div>';
    } // end listado de modulos
?>
    </div>

