
    <div id="ventana-emergente-1" class=" modal_gracias ">

        <div style="" class=" _contiene_emergente  ">
                <div class=" _imagen_de_fondo ">
                        <img src="img/comunicado_flotante_2.png">
                </div>
                 <div class="_contiene_emergente_contenido ">
                        <h3 class="poppi-sb color2  "><?php echo $flotantes[0]['titulo']; ?></h3>
            <?php if( !empty($flotantes[0]["link"]) ){ ?>
                        <div class="rel lleva_vimeo  ">
                                <iframe src="<?php echo $flotantes[0]['link']; ?>"  frameborder="0" allow="autoplay; fullscreen" allowfullscreen></iframe>
                        </div>
            <?php }else if(!empty($flotantes[0]["imagen"]) ){  ?>
                    <figure class="lleva_img_flota "><img src="tw7control/files/images/flotantes/<?php echo $flotantes[0]["imagen"];?>"></figure>
            <?php } ?>
                    <div class="des_emegente"><?php echo $flotantes[0]["descripcion"];?></div>
            
                    <?php if( !empty($flotantes[0]["enlace"]) ){ ?>

                    <p class=""><a href="<?php echo $flotantes[0]["enlace"];?>" target="_blank" > click aquí</a></p>
                    <?php } ?>

                    <button class="close-button gracias_close" data-close aria-label="Close modal" type="button">
                      <p> [cerrar] <span aria-hidden="true"> &times;</span> </p>
                    </button>
                </div>
        </div>
    </div>
	
