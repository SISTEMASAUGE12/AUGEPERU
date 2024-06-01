<?php include('inc/header.php'); 

if(!empty($landings_bigs) ){ // consultamos si existe 

    $logo_ban = !empty($landings_bigs[0]['logo_ban']) ? '../tw7control/files/images/landings_bigs/'.$landings_bigs[0]['logo_ban'] :'img/logo_blanco.png';
    $color_fondo_ban = !empty($landings_bigs[0]['color_fondo_ban']) ? $landings_bigs[0]['color_fondo_ban'] :' rgb(28, 28, 28) ';
    $texto_fondo_ban = !empty($landings_bigs[0]['texto_fondo_ban']) ? $landings_bigs[0]['texto_fondo_ban'] :' rgb(255, 255, 255) ';

?>
<!-- * empieza la web -->
<div class="container fullContainer  cornersAll radius0 shadow0 bgNoRepeat emptySection" id="section--89947-189"  style="padding-top: 0; padding-bottom: 45px; outline: none; color: rgb(255, 255, 255); background: <?php echo $color_fondo_ban; ?> !important ; color:  <?php echo $texto_fondo_ban; ?> !important; "  data-animate="fade" >
  <div class="containerInner ui-sortable">

        <div class="row bgCover noBorder " id="row--71824-127" style="padding-top: 20px; padding-bottom: 20px; margin: 0px; outline: none;">
          <div id="col-full-130-140" class="col-md-12 innerContent col_left">
            <div class="col-inner bgCover  noBorder borderSolid border3px cornersAll radius0 shadow0 P0-top P0-bottom P0H noTopMargin" style="padding: 0 10px">
              <div class="de elImageWrapper de-image-block elAlign_center elMargin0 ui-droppable de-editable" id="tmp_image-44826-188" style="margin-top: 0px; outline: none; cursor: pointer;" aria-disabled="false">
                <img src="<?php echo $logo_ban; ?>" class="elIMG ximg" alt="" width=" " tabindex="0">
              </div>
            </div>
          </div>
        </div>

        <div class="row bgCover noBorder borderSolid border3px cornersAll radius0 shadow0 P0-top P0-bottom P0H noTopMargin" id="row--69890"   style="padding-top: 20px; padding-bottom: 0px; margin: 0px auto; outline: none; width: 95%; max-width: 100%;">
          <div id="col-full-136" class="col-md-12 innerContent col_left"   data-animate="fade"   style="outline: none;">
            <div class="col-inner bgCover  noBorder borderSolid border3px cornersAll radius0 shadow0 P0-top P0-bottom P0H noTopMargin" style="padding: 0 10px">
              <div class="de elHeadlineWrapper ui-droppable de-editable text-center " id="tmp_subheadline-45387-106"  data-animate="fade"  data-gramm="false" style="margin-top: 0px; outline: none; cursor: pointer;" >
                <h2 class="ne elHeadline hsSize2 lh3 elMargin0 elBGStyle0 hsTextShadow0 mfs_16  btn_intro " style="text-align: center; font-size: 20px; "  >
                  <b>
                   <?php echo $landings_bigs[0]['ante_titulo']; ?> 
                  </b>
                </h2>  
              </div>
              <!-- 
              <div class="de elHeadlineWrapper ui-droppable de-editable" id="headline-29922-103"  data-animate="fade"  data-gramm="false" style="margin-top: 0px; outline: none; cursor: pointer;" >
                <h2 class="ne elHeadline hsSize2 lh3 elMargin0 elBGStyle0 hsTextShadow0" style="text-align: center; font-size: 18px; color: rgb(255, 255, 255);"  >
                  <i class="fa_prepended fas fa-certificate" contenteditable="false"></i> <?php echo $landings_bigs[0]['ante_titulo_2']; ?>
                </h2>
              </div>
-->
              <div class="de elHeadlineWrapper ui-droppable de-editable" id="tmp_headline1-56650-173"   data-animate="fade"  style="margin-top: 15px; outline: none; cursor: pointer;" >
                <h1 class="ne elHeadline hsSize3 lh4 elMargin0 elBGStyle0 hsTextShadow0 mfs_20 titulo_1" style="text-align: center;  font-size: 50px;"  >
                  <b> <?php echo $landings_bigs[0]['ante_titulo_2']; ?> </b>
                </h1>
              </div>

            </div>
          </div>
        </div>


        <div class="row bgCover noBorder borderSolid border3px cornersAll radius0 shadow0 P0-top P0-bottom P0H noTopMargin" id="row--57240-109"  data-animate="fade" style="padding-top: 5px; padding-bottom: 20px; margin: 0px; outline: none;">
          
            <div id="col-left-121-180" class="       <?php  echo ( $landings_bigs[0]['mostrar_chat'] == 1 ) ?' col-md-8 ':' col-md-12 '; ?> innerContent   ui-resizable"    style="outline: none;">
                <div class=" lleva_vimeo ">
<?php  if(!empty($landings_bigs[0]['link_youtube'])){ 
						
							$video= explode('watch?v=',$landings_bigs[0]['link_youtube']);
							
              // ID VIDEO:: echo $video[1];
              
              $clemb= strpos($video[1],'&');
							$emb=substr($video[1],0,$clemb);
							$embed= (($clemb !==false)?$emb:$video[1]); 

              // rel=0 ; al terminar video no muestra videos relacionados
              // showinfo:1  ; no muestra quien sube video datos del canal
              // controls:0 no muestra controler para adelantar retrocer, volumne, etc 
              //modestbranding =1  ;  no muestra logo de yotube 
              // => ?rel=0&showinfo=0&modestbranding=1
            
        ?>
                  <!--                    
                    <iframe width="100%" class="height-video-you" 
                      src="https://www.youtube.com/embed/<?php echo $embed; ?>?origin=https://www.educaauge.com?rel=0&showinfo=1&modestbranding=0" frameborder="0" allowfullscreen autoplay="1"  >
                    </iframe>      
                  -->
                    <div class="youtube-container">
	                    <iframe src="https://www.youtube.com/embed/<?php echo $embed; ?>?autoplay=1&rel=0&showinfo=1&loop=1&color=white&controls=0&modestbranding=1&playsinline=1&rel=0&enablejsapi=1" title="video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                    </div>


<?php 			}else{ // vimeo ?>
  <iframe src="<?php echo $landings_bigs[0]['link_vimeo_formulario']; ?>" frameborder="0" allowfullscreen="" wmode="opaque" id="fitvid532799" data-ready="true"></iframe>
  <?php 		} ?>

                </div>

                <div class="de elBTN elMargin0   ui-droppable de-editable lleva_btn_principal " id="tmp_button-17385-145"  >
                    <a href="<?php echo $landings_bigs[0]['link_boton_action']; ?>" class="elButton elButtonSize1 elButtonColor1 elButtonRounded elButtonPadding2 elBtnVP_10 elButtonFluid elBtnHP_25 elButtonTxtColor1       elBTN_b_none elButtonCorner60 ea-buttonElevate elButtonShadow2 mfs_14 "  rel="noopener noreferrer" id="undefined-281" style="background-color: #e9402f; ">
                        <span class="elButtonMain">  <?php echo $landings_bigs[0]['titulo_boton_action']; ?>  </span>  
                        <!-- <span class="elButtonSub mfs_10">Doble certificación por el precio de una - Desde $299 USD *</span> -->
                    </a>
                </div>
                
              </div> <!-- end L12 -->
              
      <?php  if( $landings_bigs[0]['mostrar_chat'] == 1 ){  ?>
            <div class="  col-md-4  ">
              <div class="  lleva_chat ">
                <iframe src="https://www.youtube.com/live_chat?v=<?php echo $video[1]; ?>&embed_domain=www.educaauge.com"></iframe>
              </div>
            </div> <!-- end L4 chat  -->
      <?php 		} ?>


        </div>  <!--  end row -1 -->

        <?php  include("inc/cronometro.php"); ?>
        
  <?php /*
        <div class="row bgCover noBorder borderSolid border3px cornersAll radius0 shadow0 P0-top P0-bottom P0H noTopMargin" id="row--57240-109"  data-animate="fade" style="padding-top: 5px; padding-bottom: 20px; margin: 0px; outline: none;">
            <div id="col-left-121-180" class="col-md-12 innerContent   ui-resizable"    style="outline: none;">

                <div class="de elHeadlineWrapper ui-droppable de-editable" id="tmp_headline1-56650-173"   data-animate="fade"  style="margin-top: 15px; outline: none; cursor: pointer;" >
                  <h1   class="ne elHeadline hsSize3 lh4 elMargin0 elBGStyle0 hsTextShadow0 mfs_20" style="text-align: center; color: rgb(255, 255, 255); font-size: 50px;"  >
                    <b> <?php echo $landings_bigs[0]['titulo_1']; ?> </b>
                  </h1>
                </div>
                <div class="de elHeadlineWrapper ui-droppable de-editable" id="headline-81392-189"  data-animate="fade" >
                      <div class="ne elHeadline hsSize1 lh5 elMargin0 elBGStyle0 hsTextShadow0 mfs_16"  >
                        <?php echo $landings_bigs[0]['detalle_2']; ?>      
                      </div>
                </div> <!--  * sobra -->                                
            </div>  <!-- *END col -->



            <div id="col-left-121-180" class="col-md-6 innerContent col_left ui-resizable"    style="outline: none;">
              <div class="col-inner bgCover  noBorder borderSolid border3px cornersAll radius0 shadow0 P0-top P0-bottom P0H noTopMargin" style="padding: 0 10px">
                  
                  <div class="de elVideoWrapper de-video-block elMargin0 ui-droppable elVideoWidth100 de-editable" id="video-84010"  style="margin-top: 0px; outline: none; cursor: pointer;"  data-hide-on="mobile" >               
                      <div class="elVideo" style="display: none;">
                        <div class="fluid-width-video-wrapper" style="padding-top: 56.25%;">
                          <iframe src="<?php echo $landings_bigs[0]['link_vimeo_formulario']; ?>" frameborder="0" allowfullscreen="" wmode="opaque" id="fitvid532799" data-ready="true"></iframe>
                        </div>
                      </div>
                  </div> <!-- * VIMEO movil  -->    
                  
                  <div class="de elHeadlineWrapper ui-droppable de-editable" id="headline-81392-189"  data-animate="fade" >
                    <div class="ne elHeadline hsSize1 lh5 elMargin0 elBGStyle0 hsTextShadow0 mfs_16"  >
                      <?php echo $landings_bigs[0]['detalle_2']; ?>      
                    </div>
                  </div> <!--  * sobra -->

                  <div class="de elBullet elMargin0 ui-droppable mfs_16 de-editable" id="tmp_list-36139-133" style="margin-top: 20px; outline: none; cursor: pointer;" >
                    <ul class="ne elBulletList elBulletListNew elBulletList2 listBorder0"   style="color: rgb(136, 136, 136);">
                      <li style="font-size: 18px;">
                        <i contenteditable="false" class="fa-fw far fa-check-circle" style="color: rgb(81, 190, 241);"></i><b>COSTE DE INSCRIPCIÓN</b><br><strike> <?php echo $landings_bigs[0]['precio_texto_antes']; ?>  </strike> 
                      </li>
                    </ul>
                  </div>

                  <div class="de elHeadlineWrapper ui-droppable de-editable" id="tmp_paragraph-90742-137"  data-animate="fade"  style="margin-top: 0px; outline: none; cursor: pointer;" >
                    <div class="ne elHeadline hsSize1 lh5 elMargin0 elBGStyle0 hsTextShadow0 mfs_16"  style="text-align: left; color: rgb(255, 255, 255); font-size: 62px;" >
                      <b> <?php echo $landings_bigs[0]['precio_texto_ahora']; ?></b>
                    </div>
                  </div>
            
                  <div class="de elBTN elMargin0 elAlign_left ui-droppable de-editable" id="tmp_button-17385-145"   style="margin-top: 30px; outline: none; cursor: pointer;"  >
                    <a href="<?php echo $landings_bigs[0]['link_boton_action']; ?>" class="elButton elButtonSize1 elButtonColor1 elButtonRounded elButtonPadding2 elBtnVP_10 elButtonFluid elBtnHP_25 elButtonTxtColor1       elBTN_b_none elButtonCorner60 ea-buttonElevate elButtonShadow2 mfs_14 "  rel="noopener noreferrer" id="undefined-281" style="background-color: #58be54;">
                        <span class="elButtonMain">  <?php echo $landings_bigs[0]['titulo_boton_action']; ?>  </span>  
                        <!-- <span class="elButtonSub mfs_10">Doble certificación por el precio de una - Desde $299 USD *</span> -->
                    </a>
                  </div>

                  <div class="de elBTN elMargin0 elAlign_left ui-droppable de-editable" id="button-31046"   style="margin-top: 30px; outline: none; cursor: pointer;"  >
                    <a href="<?php echo "../tw7control/files/images/landings_bigs/".$landings_bigs[0]["pdf_1"]; ?>" class="elButton elButtonSize1 elButtonColor1 elButtonRounded elButtonPadding2 elBtnHP_25 elButtonTxtColor1 elButtonCorner60 ea-buttonElevate elButtonShadow2 mfs_14 elButtonFull elBTN_b_2 elBtnVP_15 btn_brochure " rel="noopener noreferrer" id="undefined-281-22" target="_blank">
                      <span class="elButtonMain">  <?php echo $landings_bigs[0]['pdf_1_titulo']; ?>   </span>
                      <span class="elButtonSub mfs_10"></span>
                    </a>
                  </div>
                            
              </div>
            </div> <!--  * end  col-lef-121 -->

            <div id="col-right-119-182" class="col-md-6 innerContent col_right ui-resizable"   data-animate="fade"  data-title="2nd column" style="outline: none;">
              <div class="col-inner bgCover  noBorder borderSolid border3px cornersAll radius0 shadow0 P0-top P0-bottom P0H noTopMargin" style="padding: 0 10px">

                <div class="de elVideoWrapper de-video-block elMargin0 ui-droppable elVideoWidth100 de-editable" id="tmp_video-51962-151" data-de-type="video" data-de-editing="false" data-title="video" data-ce="false"  data-animate="fade"  data-video-type="vimeo" style="margin-top: 0px; outline: none; cursor: pointer;"  data-hide-on="desktop" >
                  <div class="elVideoplaceholder">
                    <div class="elVideoplaceholder_inner"></div>
                  </div>
                  <div class="elVideo" style="display: none;"><div class="fluid-width-video-wrapper" style="padding-top: 56.25%;">
                    <iframe src="<?php echo $landings_bigs[0]['link_vimeo_formulario']; ?>" frameborder="0" allowfullscreen="" wmode="opaque" id="fitvid989487" data-ready="true"></iframe>  <!--  vimeo ok -->
                  </div></div>
                </div>

                <div class="de elBullet elMargin0 ui-droppable mfs_16 de-editable" id="list-81739" style="margin-top: 20px; outline: none; cursor: pointer;" >
                  <ul class="ne elBulletList elBulletListNew elBulletList2 listBorder0"   style="color: rgb(255, 255, 255);">
                    <li style="font-size: 18px;">
                      <i contenteditable="false" class="fa-fw far fa-check-circle" style="color: rgb(81, 190, 241);"></i><b>INICIAN LAS CLASES EN VIVO
                        <br></b>   
                        <?php echo $landings_bigs[0]['fecha_en_texto']; ?> 
                    </li>
                    <li style="font-size: 18px;">
                      <i contenteditable="false" class="fa-fw far fa-check-circle" style="color: rgb(81, 190, 241);"></i>​<b>DURACIÓN
                        </b><br>   <?php echo $landings_bigs[0]['hora_en_texto']; ?> 
                    </li>
                    <li style="font-size: 18px;">
                      <i contenteditable="false" class="fa-fw far fa-check-circle" style="color: rgb(81, 190, 241);"></i><b>   <?php echo $landings_bigs[0]['etiqueta_registro_1']; ?> <br></b>
                    </li>
                  </ul>
                </div>

              <?php  if ( !empty( $landings_bigs[0]['imagen_2']) ){ ?>
                <div class="de elImageWrapper de-image-block elAlign_center elMargin0 ui-droppable de-editable" id="tmp_image-97079-147"   data-animate="fade"  style="margin-top: 15px; outline: none; cursor: pointer;" >
                  <img src="../tw7control/files/images/landings_bigs/<?php echo $landings_bigs[0]['imagen_2']; ?>" class="elIMG ximg" alt="" tabindex="0">
                </div>
              <?php } ?>

              </div>
            </div>  <!-- *end col-right -->
                        
          </div> <!-- end row -->
*/ ?>

  </div> <!-- end containerInner -->
</div> <!--  end fullContainer -->


<?php  // recore penstañas agregadas adicoinales 
$secciones=executesql(" select * from pestanhas_landings_bigs_inicios where estado_idestado=1 and id_big='".$landings_bigs[0]['id_big']."' order by orden asc ");
if( !empty($secciones) ){ 
  foreach( $secciones as $row ){ 
    $lleva_fondo =' wideContainer '; // row centra la info  
    $style_extra='';
    $style_color_titulo='';
    $style_color_texto='';

    if( !empty( $row["color_fondo"] )){
      $lleva_fondo = ' fullContainer ';  // fondo todo ancho 
      $style_extra=' style=" background:'.$row["color_fondo"].';" ';
    }
    if( !empty( $row["color_titulo"] )){
      $style_color_titulo =' style=" color:'.$row["color_titulo"].' !important;" ';
    }
    if( !empty( $row["color_texto"] )){
      $style_color_texto =' style=" color:'.$row["color_texto"].' !important;" ';
    }

?>
    <div class="container   bgNoRepeat emptySection shadow10 radius5  _callout  <?php echo $lleva_fondo; ?> " <?php echo $style_extra; ?>  data-animate="fade" >            
      <div class="containerInner ui-sortable" style="padding-left: 50px; padding-right: 50px;">  
        <div class="row bgCover noBorder borderSolid border3px cornersAll radius0 shadow0 P0-top P0-bottom P0H noTopMargin"  style="padding-top: 20px; padding-bottom: 20px; margin: 0px; outline: none;">          
          <div class="col-md-12 innerContent col_left"   data-animate="fade"   style="outline: none;">            
            <div class="col-inner bgCover  noBorder borderSolid border3px cornersAll radius0 shadow0 P0-top P0-bottom P0H noTopMargin" style="padding: 0 10px">
             
              <div class="de elHeadlineWrapper ui-droppable de-editable" id="tmp_headline1-78726"   data-animate="fade"  style="margin-top: 0px; outline: none; cursor: pointer;" >
                <h1 class="ne elHeadline hsSize3 lh4 elMargin0 elBGStyle0 hsTextShadow0 mfs_20"  <?php echo $style_color_titulo; ?>  >
                  <b><?php echo $row["titulo"]; ?></b>
                </h1>
              </div>
              <div class="de elHeadlineWrapper ui-droppable hiddenElementTools de-editable"  data-animate="fade"  style="margin-top: 30px; outline: none; cursor: pointer;" >
                <div class="ne elHeadline hsSize1 lh5 elMargin0 elBGStyle0 hsTextShadow0 mfs_16" <?php echo $style_color_texto; ?>  >
                  <?php echo $row["descripcion"]; ?>
                </div>
                
                <?php if( !empty($row["imagen"]) ) { ?>
                  <figure class=" text-center "><img src="../tw7control/files/images/landings_bigs/<?php echo $row["id_big"]; ?>/<?php echo $row["imagen"]; ?>"> </figure>
                <?php } ?>
  
                <?php if( !empty($row["link_video"]) ) { ?>
                  <div class="de elVideoWrapper de-video-block elMargin0 ui-droppable elVideoWidth100 de-editable" id="tmp_video-51962-151" data-de-type="video" data-de-editing="false" data-title="video" data-ce="false"  data-animate="fade"  data-video-type="vimeo" style="margin-top: 0px; outline: none; cursor: pointer;"  data-hide-on="desktop" >
                    <div class="elVideoplaceholder">
                      <div class="elVideoplaceholder_inner"></div>
                    </div>
                    <div class="elVideo" style="display: none;"><div class="fluid-width-video-wrapper" style="padding-top: 56.25%;">
                      <iframe src="<?php echo $row['link_video']; ?>" frameborder="0" allowfullscreen="" wmode="opaque" id="fitvid989487" data-ready="true"></iframe>  <!--  vimeo ok -->
                    </div></div>
                  </div>
                <?php } ?>

                <div class="ne elHeadline hsSize1 lh5 elMargin0 elBGStyle0 hsTextShadow0 mfs_16"  <?php echo $style_color_texto; ?>  >
                  <?php echo $row["detalle_2"]; ?>
                </div>

                <?php if( !empty($row["href_boton"])  &&  !empty($row["texto_boton"])  ) { 
                  $fondo_btn='';
                  $texto_btn_color=' style=" display:block;" ';
                  if( !empty($row["color_fondo_btn"] ) ){
                    $fondo_btn=' style=" background:'.$row["color_fondo_btn"].';" ';

                  }  
                  if( !empty($row["color_texto_btn"] ) ){
                    $texto_btn_color=' style=" display:block; color:'.$row["color_texto_btn"].';" ';

                  }  
               ?>
                <div class="de elBTN elAlign_center elMargin0 ui-droppable de-editable"  style="margin-top: 35px; outline: none; cursor: pointer;" >
                  <a href="<?php echo $row["href_boton"]; ?>" target="_blank" class="elButton elButtonSize1 elButtonColor1 elButtonPadding2 elBtnVP_10 elButtonCorner60 elButtonFluid elBtnHP_25 elButtonTxtColor1 elBTN_b_none elBTNone elButtonBlock elButtonShadow2 mfs_14  " <?php echo  $fondo_btn; ?>  rel="noopener noreferrer">
                    <span class="elButtonMain" <?php echo  $texto_btn_color; ?> > <?php echo $row["texto_boton"]; ?> </span>   
                    <span class="elButtonMain  mfs_10" <?php echo  $texto_btn_color; ?>  > <?php echo $row["texto_2_boton"]; ?> </span>
                  </a>
                </div>
              <?php } ?> 


              </div>
            </div>
          </div>
        </div>
      </div> <!--  end containerInner -->

      <!-- linea separador  separadores -->
      <div class="de elSeperator elMargin0 ui-droppable de-editable" data-animate="fade"  style="margin-top: 30px; outline: none; cursor: pointer;" >
        <div class="elDivider elDividerStyle1 padding10-top padding10-bottom"> 
          <div class="elDividerInner" style="border-color: rgb(34, 44, 81);" data-width-border="80" data-align="center" data-height-border="2"></div>
        </div>
      </div> 
      <!-- linea separador  separadores -->

    </div><!-- *end container :: row blanco  -->
<?php 
  }  // end for
}  // end pestañas antes temario
?>



<?php  // silabos modulos 
$secciones=executesql(" select * from silabos_landing_bigs  where estado_idestado=1 and id_big='".$landings_bigs[0]['id_big']."' order by orden asc ");
if( !empty($secciones) ){   
?>
    <div class="container fullContainer noTopMargin _callout _callout_modulos " id="section--59905"  >
      <div class="containerInner ui-sortable">
<?php 
  foreach( $secciones as $row ){     
?>
        <div class="row bgCover noBorder borderSolid border3px cornersAll radius0 shadow0 P0-top P0-bottom P0H noTopMargin" id="row--51398"  data-title="2 column row" style="padding-top: 20px; padding-bottom: 20px; margin: 0px; outline: none;">
            <div id="col-left-111" class="innerContent col_left ui-resizable col-md-2"    >
                <div class="col-inner bgCover  noBorder borderSolid border3px cornersAll radius0 shadow0 P0-top P0-bottom P0H noTopMargin" style="padding: 0 10px">
                    <div class="de elHeadlineWrapper ui-droppable de-editable" id="tmp_subheadline-<?php echo $row["id_silabo"]; ?>"   data-title="sub-headline" data-ce="true"   style="margin-top: 10px; outline: none; cursor: pointer;" aria-disabled="false">
                        <h2 class="ne elHeadline hsSize2 lh3 elMargin0 elBGStyle0 hsTextShadow0" style="text-align: left; font-size: 20px;"   ><b><?php echo $row["modulo"]; ?></b></h2>
                    </div>
                </div>
            </div>
            <div id="col-right-112" class="innerContent col_right ui-resizable col-md-10" data-col="right"  data-title="2nd column" >
                <div class="col-inner bgCover  noBorder borderSolid border3px cornersAll radius0 shadow0 P0-top P0-bottom P0H noTopMargin" style="padding: 0 10px">
                    
                    <div class="de elBTN elMargin0 elAlign_left ui-droppable de-editable" id="tmp_button-<?php echo $row["id_silabo"]; ?>" data-de-type="button"  data-title="button" data-ce="false" data-elbuttontype="2">
                        <a href="#" class="elButton elButtonSize1 elButtonColor1 elButtonRounded elButtonPadding2 elBtnVP_10 elButtonCorner3 elBtnHP_25 elBTN_b_1 elButtonShadowN1 elButtonTxtColor1 elButtonFull"  rel="noopener noreferrer" data-show-button-ids="button-<?php echo $row["id_silabo"]; ?>,tmp_paragraph-<?php echo $row["id_silabo"]; ?>" data-hide-button-ids="tmp_button-<?php echo $row["id_silabo"]; ?>">
                        <span class="elButtonMain"><i class="fa_prepended fas fa-plus" ></i> <?php echo $row["titulo"]; ?></span>
                        <span class="elButtonSub"></span>
                        </a>
                    </div>
                    <div class="de elBTN elMargin0 elAlign_left ui-droppable de-editable" id="button-<?php echo $row["id_silabo"]; ?>" data-de-type="button"  data-title="button" data-ce="false"  style="margin-top: 5px; outline: none; cursor: pointer; display: none;" aria-disabled="false" data-elbuttontype="2">
                        <a href="#" class="elButton elButtonSize1 elButtonColor1 elButtonRounded elButtonPadding2 elBtnVP_10 elButtonCorner3 elBtnHP_25 elBTN_b_1 elButtonShadowN1 elButtonTxtColor1 elButtonFull" style="color: rgb(255, 255, 255);font-weight: 600;font-size: 20px" rel="noopener noreferrer" id="undefined-<?php echo $row["id_silabo"]; ?>" data-show-button-ids="tmp_button-<?php echo $row["id_silabo"]; ?>" data-hide-button-ids="button-<?php echo $row["id_silabo"]; ?>,tmp_paragraph-<?php echo $row["id_silabo"]; ?>">
                        <span class="elButtonMain"><i class="fa_prepended fas fa-minus" ></i> <?php echo $row["titulo"]; ?>. </span>
                        <span class="elButtonSub"></span>
                        </a>
                    </div>
                    <div class="de elHeadlineWrapper ui-droppable de-editable" id="tmp_paragraph-<?php echo $row["id_silabo"]; ?>"   data-title="Paragraph" data-ce="true"  style="margin-top: 30px; outline: none; cursor: pointer; display: none;" aria-disabled="false">
                        <div class="ne elHeadline hsSize1 lh5 elMargin0 elBGStyle0 hsTextShadow0"  style="text-align: left;"  >
                            <?php echo $row["descripcion"]; ?>                                  
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- --* end row bgcover -->              
<?php 
  }  // end for
  ?>
  </div>
</div> <!-- * end callout silabos -->
<?php 
}  // end pestañas antes temario
?>



<?php  // DOCENTES EXPONENTES   
$secciones=executesql(" select * from landing_big_x_expositores  where estado_idestado=1 and id_big='".$landings_bigs[0]['id_big']."' order by orden asc ");
if( !empty($secciones) ){   
?>
<div class="container fullContainer  cornersAll radius0 shadow0 bgNoRepeat emptySection _callout _callout_docentes " id="section--81765"  >
    <div class="containerInner ui-sortable">
        
        <div class="row bgCover noBorder borderSolid border3px cornersAll radius0 shadow0 P0-top P0-bottom P0H noTopMargin" id="row--21767" style=" color: rgb(34, 44, 81);">
          <div id="col-full-133" class="col-md-12 innerContent col_left" >
            <div class="col-inner bgCover  noBorder borderSolid border3px cornersAll radius0 shadow0 P0-top P0-bottom P0H noTopMargin" style="padding: 0 10px">
              <div class="de elHeadlineWrapper ui-droppable de-editable" id="headline-35627"  style="margin-top: 0px; outline: none; cursor: pointer;" >
                <h1 class="ne elHeadline hsSize3 lh4 elMargin0 elBGStyle0 hsTextShadow0 mfs_20" style="text-align: center; font-size: 40px;" >
                    <b>¡ Ya somos más de 50 mil profesores que hemos logrado nuestros objetivos gracias a GRUPO AUGE </b>&nbsp;<b style="color: inherit;">y seremos tus profesores!</b>
                </h1>
              </div>
            </div>
          </div>
        </div> <!-- end row titulo -->

        <div class="row bgCover noBorder borderSolid border3px cornersAll radius0 shadow0 P0-top P0-bottom P0H noTopMargin" id="row--86314"   data-title="4 column row" style="padding-top: 20px; padding-bottom: 20px; margin: 0px; outline: none;">
<?php 
  foreach( $secciones as $row ){     
      $img_docente='../tw7control/files/images/landing_big_x_expositores/'.$row["id_big"].'/'.$row["imagen"];
      $img_doc_logo='../tw7control/files/images/landing_big_x_expositores/'.$row["id_big"].'/'.$row["imagen_2"];
?>
      
            <div id="col-left-100" class="col-md-3 innerContent col_left ui-resizable _lleva_docente " data-col="left"    >
                <div class="col-inner bgCover  noBorder borderSolid border3px cornersAll radius0 shadow0 P0-top P0-bottom P0H noTopMargin" style="padding: 0 10px">
                    <div class="de elImageWrapper de-image-block elAlign_center elMargin0 ui-droppable de-editable" id="tmp_image-77346" data-de-type="img"  data-title="image" data-ce="false"   style="margin-top: 0px; outline: none; cursor: pointer;" >
                        <img src="<?php echo $img_docente; ?>" class="elIMG ximg" alt="" tabindex="0">
                    </div>
                    <div class="de elHeadlineWrapper ui-droppable de-editable" id="tmp_subheadline-42645"   data-title="sub-headline"    data-gramm="false" style="margin-top: 30px; outline: none; cursor: pointer;" >
                        <h2 class="ne elHeadline hsSize2 lh3 elMargin0 elBGStyle0 hsTextShadow0 mfs_18" style="text-align: center; font-size: 20px;" ><b><?php echo $row["titulo"]; ?></b></h2>
                    </div>
                    <div class="de elHeadlineWrapper ui-droppable de-editable" id="tmp_paragraph-88706"   data-title="Paragraph"    style="margin-top: 15px; outline: none; cursor: pointer;" >
                        <div class="ne elHeadline hsSize1 lh5 elMargin0 elBGStyle0 hsTextShadow0" data-bold="inherit" style="text-align: center;" data-gramm="false">
                          <?php echo $row["descripcion"]; ?>
                        </div>
                    </div>
                    <div class="de elImageWrapper de-image-block elAlign_center elMargin0 ui-droppable de-editable" id="tmp_image-17245" data-de-type="img"  data-title="image" data-ce="false"   style="margin-top: 30px; outline: none; cursor: pointer;" >
                        <img src="<?php echo $img_doc_logo; ?>" class="elIMG ximg" alt="" width="" height="22" tabindex="0">
                    </div>
                </div>
            </div> <!-- --end docente -->

<?php 
  }  // end for docentes  antes temario
?>
      </div> <!-- -- end row docentes -->
    </div>
</div> <!-- --end callout docentes -->
<?php 
}  // end pestañas antes temario
?>



<?php  // DOCENTES EXPONENTES   
$testimonios=executesql(" select * from landing_big_x_testimonios  where estado_idestado=1 and id_big='".$landings_bigs[0]['id_big']."' order by orden asc ");
if( !empty($testimonios) ){   
?>
<div class="container fullContainer   cornersAll   bgNoRepeat emptySection  _callout _callout_testimonios " id="section--44673" >
    <div class="containerInner ui-sortable">
        
        <div class="row bgCover noBorder borderSolid border3px cornersAll radius0 shadow0 P0-top P0-bottom P0H noTopMargin" id="row-111" >
            <div id="col-full-141-140-121" class="col-md-12 innerContent col_left" data-col="full"  data-title="1st column" >
                <div class="col-inner bgCover  noBorder borderSolid border3px cornersAll radius0 shadow0 P0-top P0-bottom P0H noTopMargin" style="padding: 0 10px">
                    <div class="de elHeadlineWrapper ui-droppable de-editable" id="tmp_subheadline-74760-122-108"  data-ce="true"  data-gramm="false" style="margin-top: 0px; outline: none; cursor: pointer;" >
                        <h2 class="ne elHeadline hsSize2 lh3 elMargin0 elBGStyle0 hsTextShadow0 mfs_18"  >Conoce nuestros</h2>
                    </div>
                    <div class="de elHeadlineWrapper ui-droppable de-editable" id="tmp_headline1-61985-140-160"  style="margin-top: 15px; outline: none; cursor: pointer;" >
                        <h1 class="ne elHeadline hsSize3 lh4 elMargin0 elBGStyle0 hsTextShadow0 mfs_20" >Casos de éxito</h1>
                    </div>
                </div>
            </div>
        </div>

<?php 
  foreach( $testimonios as $row ){     
      $img_testimonios='../tw7control/files/images/landing_big_x_testimonios/'.$row["id_big"].'/'.$row["imagen"];
?>
        <div class="row bgCover noBorder borderSolid border3px cornersAll shadow0 P0-top P0-bottom P0H noTopMargin radius20 lleva_testimonio " id="row-107"   >
            <div id="col-left-164-141" class="innerContent col_left ui-resizable col-md-7"  >
                <div class="col-inner bgCover  noBorder borderSolid border3px cornersAll radius0 shadow0 P0-top P0-bottom P0H noTopMargin" style="padding: 0 10px">
                    <div class="de elHeadlineWrapper ui-droppable de-editable" id="headline-25651-153"   style="margin-top: 0px; outline: none; cursor: pointer;" >
                        <h2 class="ne elHeadline hsSize2 lh3 elMargin0 elBGStyle0 hsTextShadow0 _detalle "  ><b> <?php echo $row["detalle_1"]; ?>  </b></h2>
                    </div>
                    <div class="de elHeadlineWrapper ui-droppable de-editable" id="headline-97271-176"   style="margin-top: 25px; outline: none; cursor: pointer;" >
                        <h2 class="ne elHeadline hsSize2 lh3 elMargin0 elBGStyle0 hsTextShadow0 mfs_18" >
                          <?php echo $row["descripcion"]; ?>
                        </h2>
                    </div>
                    <div class="de elHeadlineWrapper ui-droppable de-editable" id="headline-89021-114" data-de-type="headline" data-de-editing="false" data-title="Paragraph" data-ce="true" style="margin-top: 15px; outline: none; cursor: pointer;" >
                        <div class="ne elHeadline hsSize1 lh5 elMargin0 elBGStyle0 hsTextShadow0"  style="text-align: left; font-size: 18px;" data-gramm="false" contenteditable="false">
                            <?php echo $row["titulo"]; ?>
                        </div>
                    </div>                            
                </div>
            </div>
            <div id="col-right-177-115" class="innerContent col_right ui-resizable col-md-5"  >
                <div class="col-inner bgCover  noBorder borderSolid border3px cornersAll radius0 shadow0 P0-top P0-bottom P0H noTopMargin" style="padding: 0 10px">
                    <div class="de elImageWrapper de-image-block elAlign_center elMargin0 ui-droppable de-editable" id="tmp_image-37714-152"  style="margin-top: 0px; outline: none; cursor: pointer;" >
                        <img src="<?php echo $img_testimonios; ?>" class="elIMG ximg" alt="" tabindex="0">
                    </div>
                </div>
            </div>
        </div> <!-- * end bgcover tetsimonios -->

<?php 
  }  // end row for testimonios 
?>
    </div> <!-- -- end container tetsimoonios -->
</div> <!-- -- end testimonios callout -->
<?php 
}  // end pestañas antes testimonos 
?>



<?php  // frecuentes preguntas 
$frecuentes=executesql(" select * from landing_bigs_preguntas  where estado_idestado=1 and id_big='".$landings_bigs[0]['id_big']."' order by orden asc ");
if( !empty($frecuentes) ){   
?>
<div class="container fullContainer  cornersAll radius0 shadow0 bgNoRepeat emptySection _callout _callout_frecuentes " id="section--15481" >
    <div class="containerInner ui-sortable">
    
        <div class="row bgCover noBorder borderSolid border3px cornersAll radius0 shadow0 P0-top P0-bottom P0H noTopMargin" id="row--49598"  >
            <div id="col-full-139" class="col-md-12 innerContent col_left"  >
                <div class="col-inner bgCover  noBorder borderSolid border3px cornersAll radius0 shadow0 P0-top P0-bottom P0H noTopMargin" style="padding: 0 10px">
                    <div class="de elHeadlineWrapper ui-droppable de-editable" id="headline-93185" data-de-type="headline"  data-title="headline" data-ce="true"  style="margin-top: 0px; outline: none; cursor: pointer;" aria-disabled="false" data-google-font="">
                        <h1 class="ne elHeadline hsSize3 lh4 elMargin0 elBGStyle0 hsTextShadow0 mfs_20" > ¿Tienes aún dudas? ¡Estamos para ayudarte! </h1>
                    </div>
                    <div class="de elHeadlineWrapper ui-droppable de-editable" id="tmp_subheadline-97903" data-de-type="headline"  data-title="sub-headline" data-ce="true"  data-gramm="false" style="margin-top: 15px; outline: none; cursor: pointer;" aria-disabled="false">
                        <h2 class="ne elHeadline hsSize2 lh3 elMargin0 elBGStyle0 hsTextShadow0"  >
                            Consulta nuestras preguntas frecuentes para resolver tus dudas.
                        </h2>
                    </div>
                </div>
            </div>
        </div>

<?php 
  foreach( $frecuentes as $row ){     
?>
        <div class="row bgCover noBorder borderSolid border3px cornersAll radius0 shadow0 P0-top P0-bottom P0H noTopMargin _lleva_frecuente " id="row--75374"  >
            <div id="col-full-185" class="col-md-12 innerContent col_left"  >
                <div class="col-inner bgCover  noBorder borderSolid border3px cornersAll radius0 shadow0 P0-top P0-bottom P0H noTopMargin" style="padding: 0 10px">
                    
                    <div class="de elBTN elAlign_center elMargin0 ui-droppable de-editable" id="tmp_button_frecuentes_<?php echo $row["id_silabo"]; ?>" data-de-type="button"  data-title="button" data-ce="false"  style="margin-top: 0px; outline: none; cursor: pointer; display: block;" aria-disabled="false" data-elbuttontype="2">
                        <a href="#" class="elButton elButtonSize1 elButtonColor1 elButtonRounded elButtonPadding2 elBtnVP_10 elButtonCorner3 elBtnHP_25 elButtonShadowN1 elButtonTxtColor1 elBTN_b_none elButtonFull" style="" rel="noopener noreferrer" data-show-button-ids="button-72934_frecuentes_<?php echo $row["id_silabo"]; ?>,tmp_paragraph-68582_frecuentes_<?php echo $row["id_silabo"]; ?>" data-hide-button-ids="tmp_button_frecuentes_<?php echo $row["id_silabo"]; ?>" data-tracked="1">
                            <span class="elButtonMain"><i class="fa_prepended fas fa-angle-right" contenteditable="false"></i><?php echo $row["titulo"]; ?></span>
                            <span class="elButtonSub"></span>
                        </a>
                    </div>

                    <div class="de elBTN elAlign_center elMargin0 ui-droppable de-editable" id="button-72934_frecuentes_<?php echo $row["id_silabo"]; ?>" data-de-type="button"  data-title="button" data-ce="false"  style="margin-top: 0px; outline: none; cursor: pointer; display: none;" aria-disabled="false" data-elbuttontype="2">
                        <a href="#" class="elButton elButtonSize1 elButtonColor1 elButtonRounded elButtonPadding2 elBtnVP_10 elButtonCorner3 elBtnHP_25 elButtonShadowN1 elButtonTxtColor1 elBTN_b_none elButtonFull" style="" rel="noopener noreferrer" id="undefined-789" data-show-button-ids="tmp_button_frecuentes_<?php echo $row["id_silabo"]; ?>" data-hide-button-ids="button-72934_frecuentes_<?php echo $row["id_silabo"]; ?>,tmp_paragraph-68582_frecuentes_<?php echo $row["id_silabo"]; ?>" data-tracked="1">
                            <span class="elButtonMain"><i class="fa_prepended fas fa-angle-up" contenteditable="false"></i> <?php echo $row["titulo"]; ?> </span>
                            <span class="elButtonSub"></span>
                        </a>
                    </div>
                    <div class="de elHeadlineWrapper ui-droppable hiddenElementTools de-editable" id="tmp_paragraph-68582_frecuentes_<?php echo $row["id_silabo"]; ?>" data-de-type="headline"  data-ce="true"  style="margin-top: 30px; outline: none; cursor: pointer; display: none;" aria-disabled="false">
                        <div class="ne elHeadline hsSize1 lh5 elMargin0 elBGStyle0 hsTextShadow0"  style="text-align: left;" data-gramm="false" contenteditable="false">
                            <?php echo $row["descripcion"]; ?>                            
                        </div>
                    </div>

                    <div class="de elSeperator elMargin0 ui-droppable de-editable" id="tmp_divider-49933" data-de-type="divider"  data-title="Divider" data-ce="false"  style="margin-top: 10px; outline: none; cursor: pointer;" aria-disabled="false">
                        <div class="elDivider elDividerStyle1 padding10-top padding10-bottom">
                            <div class="elDividerInner" style="border-color: rgb(34, 44, 81);"></div>
                        </div>
                    </div> <!-- end sepatrador -->
                </div>
            </div>
        </div> <!-- end lleva frecuente -->

<?php 
  }  // end for antes frecuentes 
?>
    </div> <!-- --end conteiner frecunetes -->
</div> <!-- -- emnd callout preguntas frecuentes -->
<?php 
}  // end pestañas antes frecuentes 
?>



<?php  // recore penstañas finales adicoinales 
$secciones=executesql(" select * from pestanhas_landings_bigs_finales where estado_idestado=1 and id_big='".$landings_bigs[0]['id_big']."' order by orden asc ");
if( !empty($secciones) ){ 
  foreach( $secciones as $row ){ 
    $lleva_fondo =' wideContainer '; // row centra la info  
    $style_extra='';
    $style_color_titulo='';
    $style_color_texto='';

    if( !empty( $row["color_fondo"] )){
      $lleva_fondo = ' fullContainer ';  // fondo todo ancho 
      $style_extra=' style=" background:'.$row["color_fondo"].';" ';
    }
    if( !empty( $row["color_titulo"] )){
      $style_color_titulo =' style=" color:'.$row["color_titulo"].' !important;" ';
    }
    if( !empty( $row["color_texto"] )){
      $style_color_texto =' style=" color:'.$row["color_texto"].' !important;" ';
    }

?>
    <div class="container   bgNoRepeat emptySection shadow10 radius5  _callout  <?php echo $lleva_fondo; ?> " <?php echo $style_extra; ?>  data-animate="fade" >            
      <div class="containerInner ui-sortable" style="padding-left: 50px; padding-right: 50px;">  
        <div class="row bgCover noBorder borderSolid border3px cornersAll radius0 shadow0 P0-top P0-bottom P0H noTopMargin"  style="padding-top: 20px; padding-bottom: 20px; margin: 0px; outline: none;">          
          <div class="col-md-12 innerContent col_left"   data-animate="fade"   style="outline: none;">            
            <div class="col-inner bgCover  noBorder borderSolid border3px cornersAll radius0 shadow0 P0-top P0-bottom P0H noTopMargin" style="padding: 0 10px">
             
              <div class="de elHeadlineWrapper ui-droppable de-editable" id="tmp_headline1-78726"   data-animate="fade"  style="margin-top: 0px; outline: none; cursor: pointer;" >
                <h1 class="ne elHeadline hsSize3 lh4 elMargin0 elBGStyle0 hsTextShadow0 mfs_20"  <?php echo $style_color_titulo; ?>  >
                  <b><?php echo $row["titulo"]; ?></b>
                </h1>
              </div>
              <div class="de elHeadlineWrapper ui-droppable hiddenElementTools de-editable"  data-animate="fade"  style="margin-top: 30px; outline: none; cursor: pointer;" >
                <div class="ne elHeadline hsSize1 lh5 elMargin0 elBGStyle0 hsTextShadow0 mfs_16" <?php echo $style_color_texto; ?>  >
                  <?php echo $row["descripcion"]; ?>
                </div>
                
                <?php if( !empty($row["imagen"]) ) { ?>
                  <figure class=" text-center "><img src="../tw7control/files/images/landings_bigs/<?php echo $row["id_big"]; ?>/<?php echo $row["imagen"]; ?>"> </figure>
                <?php } ?>
  
                <?php if( !empty($row["link_video"]) ) { ?>
                  <div class="de elVideoWrapper de-video-block elMargin0 ui-droppable elVideoWidth100 de-editable" id="tmp_video-51962-151" data-de-type="video" data-de-editing="false" data-title="video" data-ce="false"  data-animate="fade"  data-video-type="vimeo" style="margin-top: 0px; outline: none; cursor: pointer;margin-top:60px;"  data-hide-on="desktop" >
                    <div class="elVideoplaceholder">
                      <div class="elVideoplaceholder_inner"></div>
                    </div>
                    <div class="elVideo" style="display: none;"><div class="fluid-width-video-wrapper" style="padding-top: 56.25%;">
                      <iframe src="<?php echo $row['link_video']; ?>" frameborder="0" allowfullscreen="" wmode="opaque" id="fitvid989487" data-ready="true"></iframe>  <!--  vimeo ok -->
                    </div></div>
                  </div>
                <?php } ?>

                <div class="ne elHeadline hsSize1 lh5 elMargin0 elBGStyle0 hsTextShadow0 mfs_16"  <?php echo $style_color_texto; ?>  >
                  <?php echo $row["detalle_2"]; ?>
                </div>

              <?php if( !empty($row["href_boton"])  &&  !empty($row["texto_boton"])  ) { 
                  $fondo_btn='';
                  $texto_btn_color='';
                  if( !empty($row["color_fondo_btn"] ) ){
                    $fondo_btn=' style=" background:'.$row["color_fondo_btn"].';" ';

                  }  
                  if( !empty($row["color_texto_btn"] ) ){
                    $texto_btn_color=' style=" color:'.$row["color_texto_btn"].';" ';

                  }  
              ?>
                <div class="de elBTN elAlign_center elMargin0 ui-droppable de-editable"  style="margin-top: 35px; outline: none; cursor: pointer;" >
                  <a href="<?php echo $row["href_boton"]; ?>" target="_blank" class="elButton elButtonSize1 elButtonColor1 elButtonPadding2 elBtnVP_10 elButtonCorner60 elButtonFluid elBtnHP_25 elButtonTxtColor1 elBTN_b_none elBTNone elButtonBlock elButtonShadow2 mfs_14  " <?php echo  $fondo_btn; ?>  rel="noopener noreferrer">
                    <span class="elButtonMain" <?php echo  $texto_btn_color; ?> > <?php echo $row["texto_boton"]; ?> </span>   
                    <span class="elButtonSub mfs_10" <?php echo  $texto_btn_color; ?>  > <?php echo $row["texto_2_boton"]; ?> </span>
                  </a>
                </div>
              <?php } ?>  

              </div>
            </div>
          </div>
        </div>
      </div> <!--  end containerInner -->

      <!-- linea separador  separadores -->
      <div class="de elSeperator elMargin0 ui-droppable de-editable" data-animate="fade"  style="margin-top: 30px; outline: none; cursor: pointer;" >
        <div class="elDivider elDividerStyle1 padding10-top padding10-bottom"> 
          <div class="elDividerInner" style="border-color: rgb(34, 44, 81);" data-width-border="80" data-align="center" data-height-border="2"></div>
        </div>
      </div> 
      <!-- linea separador  separadores -->

    </div><!-- *end container :: row blanco  -->
<?php 
  }  // end for
}  // end pestañas finales 
?>




<?php 
}//  consultamos si existe 
include('inc/footer.php');?>