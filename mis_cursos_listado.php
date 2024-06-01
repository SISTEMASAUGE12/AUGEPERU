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
                $imgproduct=  !empty($detalles['imagen2'])?'tw7control/files/images/capa/'.$detalles['imagen2']:'img/curso_sin_imagen_generica_2.jpg';
                // $imgproduct=  'img/curso_sin_imagen_generica_2.jpg';
                
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
        
                ?>
                <div class="large-4 medium-4 columns  end "><div class="curso_land row ">                  
                  <div class="titu   text-center large-12 columns ">
                    <a href="<?php echo $link;?>" class=" ">
                      <h2 class="poppi-b  "><?php echo  short_name($titulo,100);?></h2>                                     
                    </a>
                    <div class="contiene_ ">  
                      <a href="<?php echo $link;?>" class=" ">       
                        <div class="progresar">
                          <div class="tar"><div style="width:<?php echo $porc.'%';?>"></div></div>					
                          <p class="poppi-sb color1 "> <?php echo $porc; ?>% </p>
                        </div> 
                      </a> 
                    </div>           
                    
                    <?php 
                    /*
                    if( !empty( $detalles['archivo']) ){ ?>
                    <div class="bota text-right float-left _malla_curricular ">
                      <a href="tw7control/files/images/cursos/<?php echo $detalles['archivo']; ?>" target="_blank" class="  poppi color1 boton "  title="próximamente disponible .. ">
                        Descarga tu malla </br>curricular
                      </a>                  
                    </div>                  
                    <?php }
                    */
                     ?> 

                      <div class="bota text-center  ">
                  <?php  if($mostrar == "si"){  ?>
                      <a href="<?php echo $link;?>" class="  poppi color1 boton btn_grabadas ">
                        Sesiones grabadas  <img src="img/icono-click-aqui-clase-4.png" style="padding-left:2px;" >
                      </a>
                  <?php }else{
                          echo '<p class=" _vencido ">Plazo de acceso vencido.</p>';
                        } 
                    ?>
                      </div> 
                      
                      <div class="lleva_boton_en_vivo    large-12 columns  ">
                      <?php  
                      if(  $detalles['en_vivo']==1){ /* valido si esta activo el boton */ 
                        $hora_actual = date("H:i"); 
                        $fecha= fecha_hora(1);                         
                        $_nombre_del_dia = get_nombre_dia($fecha);

                        if($mostrar == "si"){
                          $enlace_a_clase= $detalles['enlace_en_vivo'];

                          /** valido por fecha de incio y fecha de fin */
                          if( !empty($detalles["hora_inicio_".$_nombre_del_dia]) & !empty($detalles["hora_fin_".$_nombre_del_dia]) ){ // valido segun el dia y hora                           

                            if( !empty($detalles["horario_".$_nombre_del_dia])  ){ // valido segun el dia, si es que ese dia hay clase. 
                                  // echo  "HOY SI HAY CLASE";
                                  // si fecha catual es mayor a hroa de inciio y la fecha catua les menor a la fecha fin 
                                  if(  $detalles["hora_inicio_".$_nombre_del_dia] < $hora_actual  &&  $detalles["hora_fin_".$_nombre_del_dia] >  $hora_actual  ){  
                        ?>
                                    <a href="<?php echo $enlace_a_clase; ?>" target="_blank">
                                      <figcaption class="en_vivo text-center animated infinite pulse delay-2s  ">
                                        <p class="poppi " ><span>Transmisión en vivo </span> <img src="img/iconos/icono_en_vivo.png" style="padding-left:8px;" ></p> 
                                      </figcaption>
                                    </a>                         
                        <?php 
                                  }else if( $detalles["hora_fin_algoritmo"] <  $hora_actual  ){ 
                                      echo ' <p class="poppi " ><span> La clase finalizo '.$detalles["hora_fin_algoritmo"].' </span> </p>';
                                  } // end si esta dentro del rango de hora incio y hora fin 
                           
                            }else{
                              echo ' <p class="poppi " ><span> Hoy no hay clase en vivo </span> </p>';
                            }


                          
                          } // end si existe hora definidas 
                 
                          /** END validacion de hora inicio -fin  */

                        }// end opsion de mostrar link si curso esta vigente 
                      
                      }// end btn curso en vivo 
                      ?>  
                      </div>     
                      <!--  end vivo-->                   


                  </div>      <!-- end TITU  -->                                                                                                                  
                  <div class="ima poppi-b  large-12 columns nothing ">
                    <a href="<?php echo $link;?>" class=" ">
                      <figure>
                        <img src="<?php echo $imgproduct; ?>" alt="">
                      </figure>
                    </a>
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
      <blockquote class="color1 poppi-sb text-center" style="padding-bottom:20px;"><small> No tienes cursos en esta sección. </small>
    </div>
    <div class=" mensaje_aun_sin_compra ">
      <p>Si has comprado un curso y no aparece aquí, asegurate de que tu compra ya fue aprobada. Comunícate con nuestra área de atención al cliente.</a></p>
    </div>
<?php
}
?>
