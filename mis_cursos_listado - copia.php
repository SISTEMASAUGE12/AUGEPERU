<?php 

$fecha_actual = fecha_hora(1);

  if(!empty($suscur)){

    foreach ($suscur as $data_asignacion){  // recorro los cursos 
      $sql_x="SELECT * FROM cursos WHERE (id_tipo=1 or id_tipo=4) and  id_curso = '".$data_asignacion['id_curso']."' ";
      
      $data_curso = executesql($sql_x);
      if(!empty($data_curso)){ 
        foreach($data_curso as $detalles){

          if( empty($detalles['cursos_dependientes']) ){  /* si no es el pack mostramos el curso al cliente, */
                
              /** VALIDACION DE CURSOA CTIVO POR PERIDO DE MESES  */
              $mostrar='si';
              // si tiene una fecha limite de validez ..
              if(!empty($data_asignacion['validez_meses']) && ($data_asignacion['validez_meses'] > 0 || $data_asignacion['validez_meses']=='---' )){  /* si no asigna dato de vence en cursos, se asigna un periodo de 1 año .*/
                // fecha limite de acceso : vencimiento

                // ---  =>> 3 flecahs significa acceso concesido ilimitadoi? fue una idea pero creo que nose va lograr a utilixzar por calculo de fechas de vencimiento 

                  $fecha_compra = $data_asignacion['fecha_registro'];
                  $meses_disponibles = $data_asignacion['validez_meses'];
                  //sumo  meses de plazo 
                  $fecha_limite= date("Y-m-d",strtotime($fecha_compra."+ ".$meses_disponibles." month")); 
                  
                  // echo $fecha_actual.' > '.$fecha_limite ; validez_meses
                  
                  if( $fecha_actual > $fecha_limite ){
                    /* actualizamos estado de la asignacaion como vencido plazo:  */ 
                    $mostrar="no";
                    // echo "SI";
                    
                    // /* actualizamos la condicion del curso a 2 --> plazo_vencido */
                    $_POST['condicion']=2;
                    $campos=array('condicion');
                    $bd=new BD;
                    $bd->actualiza_(armaupdate('suscritos_x_cursos',$campos," ide='".$data_asignacion["ide"]."'",'POST'));/*actualizo*/
                
                  }
              }
              /** END VALIDACION DE CURSOA CTIVO POR PERIDO DE MESES  */




                /* detalles del curso a mostrar  */
                $titulo=$detalles['titulo'];
                $link='perfil/mis-cursos/'.$detalles['titulo_rewrite'];
                // $imgproduct= 'tw7control/files/images/capa/'.$detalles['imagen'];
                $imgproduct= 'tw7control/files/images/capa/'.$detalles['imagen2'];
                
                $si_fina = executesql("SELECT * FROM suscritos_x_cursos WHERE estado_idestado = 1 AND id_curso = '".$detalles['id_curso']."' and  id_suscrito = '".$_SESSION['suscritos']['id_suscrito']."'  "); 
                $porc='';
                if($si_fina[0]['finalizado']!=1){
                  $sql_tot_cla="SELECT count(*) as total_clases FROM avance_de_cursos_clases WHERE id_curso = '".$detalles['id_curso']."' and id_suscrito='".$_SESSION['suscritos']['id_suscrito']."' "; 
                  $tot_n_cla = executesql($sql_tot_cla);

                  $final = executesql("SELECT count(*) as total_finalizadas FROM avance_de_cursos_clases WHERE id_curso = '".$detalles['id_curso']."' and id_suscrito='".$_SESSION['suscritos']['id_suscrito']."'  and estado_fin=1 ");
                  if(!empty($tot_n_cla) && $tot_n_cla[0]['total_clases']>0){
                    if(!empty($final)){
                      $porc = round(($final[0]['total_finalizadas']*100)/$tot_n_cla[0]['total_clases']);
                      if($porc =='100'){
                        $bd=new BD;
                        $_POST['finalizado']=1;
                        $campos=array('finalizado');
                        $bd->actualiza_(armaupdate('suscritos_x_cursos',$campos," ide='".$si_fina[0]["ide"]."'",'POST'));/*actualizo*/
                      }
                    }
                  }else{
                    $porc='0';
                  }
                }else{
                  $porc='100';
                }

                //echo '<div class="large-3 float-left medium-6 columns rel  end mis_cursos ">';
                //	include('inc/curso2.php');
                //echo '</div>';
                ?>
                <div class="large-12 columns"><div class="curso_land">
                  <div class="ima poppi-b ">
                    <img src="<?php echo $imgproduct; ?>" alt="<?php echo $detalles['titulo']; ?>">
                    <b><?php echo $detalles['codigo']; ?></b>
                  </div>

                  <div class="titu"><div class="contiene_ ">
              <?php              
                  if( $detalles['en_vivo']==1){ /* valido si esta activo el boton */
                  
                ?> 
                      <!-- 
                      <div class="medium-12 columns ">
                        <div class="medium-4 columns "><p>Fecha de inicio<?php echo $detalles['horario_inicio']; ?></p></div>
                        <div class="medium-4 columns "><p class="color1">HORARIO EN VIVO</p></div>
                        <div class="medium-4 columns "><p>Fecha final<?php echo $detalles['horario_final']; ?></p></div>
                      </div>
                      -->
                      
                      <div class="table-scroll ">
                        <table class="unstriped "> 
                          <thead>
                            <tr class="cabezera_tabla ">
                              <th colspan="3">Fecha de inicio: <?php echo $detalles['horario_inicio']; ?></th>
                              <th colspan="2" class="color2 ">HORARIO EN VIVO</th>
                              <th colspan="3">Fecha fin: <?php echo $detalles['horario_final']; ?></th>
                            </tr>
                            <tr>
                              <th >HORA</th>
                            <?php if(!empty($detalles['horario_lunes']) ){ ?> 
                                <th>LUNES</th>
                              <?php } ?>

                            <?php if(!empty($detalles['horario_martes'])) { ?> 
                                <th >MARTES</th>
                              <?php } ?>

                            <?php if(!empty($detalles['horario_miercoles']) ){ ?> 
                                <th >MIERCOLES</th>
                              <?php } ?>

                            <?php if(!empty($detalles['horario_jueves']) ){ ?> 
                                <th >JUEVES</th>
                              <?php } ?>

                            <?php if(!empty($detalles['horario_viernes']) ){ ?> 
                                <th >VIERNES</th>
                              <?php } ?>

                            <?php if(!empty($detalles['horario_sabado']) ){ ?> 
                                <th >SABADO</th>
                              <?php } ?>

                            <?php if(!empty($detalles['horario_domingo']) ){ ?> 
                                <th >DOMINGO</th>
                              <?php } ?>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                              <td><?php echo $detalles['horario_hora']; ?> </td>
                              
                          <?php if(!empty($detalles['horario_lunes']) ){ ?> 
                              <td><?php echo $detalles['horario_lunes']; ?> </td>
                            <?php } ?>

                          <?php if(!empty($detalles['horario_martes']) ){ ?> 
                              <td><?php echo $detalles['horario_martes']; ?> </td>
                            <?php } ?>

                          <?php if(!empty($detalles['horario_miercoles']) ){ ?> 
                              <td><?php echo $detalles['horario_miercoles']; ?> </td>
                            <?php } ?>

                          <?php if(!empty($detalles['horario_jueves']) ){ ?> 
                              <td><?php echo $detalles['horario_jueves']; ?> </td>
                            <?php } ?>
                            
                          <?php if(!empty($detalles['horario_viernes']) ){ ?> 
                              <td><?php echo $detalles['horario_viernes']; ?> </td>
                            <?php } ?>

                          <?php if( !empty($detalles['horario_sabado']) ){ ?> 
                              <td><?php echo $detalles['horario_sabado']; ?> </td>
                            <?php } ?>

                          <?php if( !empty($detalles['horario_domingo']) ){ ?> 
                              <td><?php echo $detalles['horario_domingo']; ?> </td>
                            <?php } ?>
                              
                            </tr>
                          </tbody>
                        </table>
                      </div>

                      <h2 class="poppi-b text-center "><?php echo $titulo;?></h2>
                      
          <?php }else{ /* si es grabado */  ?> 
                      <h2 class="poppi-b ptoppp"><?php echo  $detalles['codigo'].' </br> '.$titulo;?></h2>
          <?php } ?> 
                      <p style="padding-top:4px;"> Fecha de compra: <?php echo $data_asignacion['fecha_registro']; ?> --  <b>validez:</b> <?php echo $data_asignacion['validez_meses']; ?> meses </p>                      
                      <p> Tienes acceso a este curso hasta: <?php echo $fecha_limite; ?> </p>                      
                  </div></div>


                  <div class="progresar">
                    <p class="poppi">Progreso: <b class="poppi-b"><?php echo $porc; ?>%</b></p>
                    <div class="tar"><div style="width:<?php echo $porc.'%';?>"></div></div>					
                    <?php

                      $sql="SELECT * FROM clases_en_vivos WHERE estado_idestado=1 and id_curso='".$detalles['id_curso']."' and estado_idestado=1 order by orden desc limit 0,1 ";
                      $clases_en_vivos = executesql($sql);

                      if( !empty( $clases_en_vivos ) || $detalles['en_vivo']==1){ /* valido si esta activo el boton */
                            
                        if( !empty( $clases_en_vivos) ){  // en vivo desde vimeo 
                            $enlace_a_clase= 'https://www.educaauge.com/clase_vivo/'.$clases_en_vivos[0]["titulo_rewrite"];
                        }else if(!empty($detalles['enlace_en_vivo']) && !empty($detalles['hora_en_vivo']) ){   // zoom 
                          $enlace_a_clase= $detalles['enlace_en_vivo'];
                        }

                    ?>

                        <div class="lleva_boton_en_vivo ">
                    <?php  if($mostrar == "si"){  ?>
                          <a href="<?php echo $enlace_a_clase; ?>" target="_blank">
                            <figcaption class="en_vivo text-center animated infinite pulse delay-2s  ">
                                <img src="img/iconos/click_aqui.png">
                                <b class="float-le " style="padding-right:20px;"><span>Transmisión en vivo </span> </b> <?php echo $detalles['hora_en_vivo'];?>
                            </figcaption>
                          </a> 
                    <?php 
                      }else{ // end opsion de mostrar link si curso esta vigente 
                        echo '<p class=" _vencido ">Plazo de acceso vencido.</p>';
                      }// end opsion de mostrar link si curso esta vigente 
                    ?>
                      </div>

                      
                    <?php 
                      }// end btn curso en vivo 
                    ?>
                    
                  </div>
                  <!-- 
                  <div class="bota"><a href="<?php echo $link;?>" class="boton poppi-sb"> INGRESAR</a></div>
                  
                    -->
                    <div class="bota">
                  <?php  if($mostrar == "si"){  ?>
                      <a href="<?php echo $link;?>" class="boton poppi-sb">
                        <img src="img/iconos/icon-mis-cursos.png"> SESIONES GRABADAS
                      </a>
                  <?php }else{
                          echo '<p class=" _vencido ">Plazo de acceso vencido.</p>';

                        } 
                    ?>
                    </div>

                </div></div>
                
        <?php
          }/* end si no es pack:: mostramos el curso :: los pack, estan ocultos xq salen sin contenido */
          
        } /* end for data curso */
      }  /* end if curso */
  
  } /* end for suscritoz_x_cursos */
  
}else{
      // echo '<div class="text-center" style="padding:40px 15px;">Aún no has comprado cursos .. </div>';
?>
    <div class=" aun_sin_compra ">
      <div class="text-center" ><img src="img/cliente_sin_compras.png" alt="compra cursos en educauage" class="text-center" style="width:60px;"></div>
      <blockquote class="color1 poppi-sb text-center" style="padding-bottom:20px;"><small>Aún no has comprado ningún curso en EducaAuge</small>
      </br><a href="https://www.educaauge.com/curso/todos" title="compra cursos aqui">Comienza a aprender </a></blockquote>
    </div>
    <div class=" mensaje_aun_sin_compra ">
      <p>Si has comprado un curso y no aparece aquí, asegurate de que tu compra ya fue aprobada. <a href="https://www.educaauge.com/perfil/mis-pedidos" title="ver mis ocmpras">Visita el listado de tus compras aquí</a></p>
    </div>
<?php
}
?>
