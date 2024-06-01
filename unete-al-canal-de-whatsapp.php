<?php include('auten.php');
$pagina='canal-whatsapp';
$meta = array(
    'title' => 'Únete a nuestro canal de WhatsApp | EducaAuge.com',
    'description' => ''
);
include ('inc/header.php');
//include ('inc/header-registro.php');


$paginas_redes=executesql(" select * from paginas_redes where estado_idestado=1 and id_pagina=4 "); 
?>
<main id="canal_whatsapp" class=" ">
    <div class="callout callout-1  "><div class="row text-center ">
     
      <div class=" medium-6 columns ">
        <h1 class=" poppi-b"> <?php echo $paginas_redes[0]['titulo']; ?> </h1>
        <h3 class=" poppi-sb "> <?php echo $paginas_redes[0]['texto_1']; ?></h3>
        <div class=" large-12 columns lleva_btn_canal ">          
          <a href="<?php echo $link_grupo_wasap; ?>" title="  canal_wsp_flota" target="_blank" class=" canal_wsp_flota  poppi  "  >
            <img src="img/iconos/wspf.png" alt="Únete a nuestro  canal de whatsApp ">Canal de WhatsApp <img src="img/iconos/mano_click.png" class="click_mano ">
          </a>
        </div>
      </div>
      <div class=" medium-6 columns text-center ">
        <figure><img src="tw7control/files/images/paginas_redes/<?php echo $paginas_redes[0]['imagen']; ?>"></figure>
      </div>
    </div></div>

    <div class="callout callout-2  "><div class="row text-center ">
      <div class=" medium-11  medium-centered  columns text-center  ">
          <h3 clasS=" poppi-b ">  <?php echo $paginas_redes[0]['titulo_iconos']; ?></h3>  
  
        <div class=" medium-6 columns ">
          <p  class=" rel  poppi  "  >
            <img src="tw7control/files/images/paginas_redes/<?php echo $paginas_redes[0]['imagen_6']; ?>" >
            <?php echo $paginas_redes[0]['texto_2']; ?>
          </p>
        </div>
        <div class=" medium-6 columns ">
          <p  class=" rel  poppi  "  >
            <img src="tw7control/files/images/paginas_redes/<?php echo $paginas_redes[0]['imagen_7']; ?>" >
            <?php echo $paginas_redes[0]['texto_3']; ?>
          </p>
        </div>
        <div class=" medium-6 columns ">
          <p  class=" rel  poppi  "  >
            <img src="tw7control/files/images/paginas_redes/<?php echo $paginas_redes[0]['imagen_8']; ?>" >
            <?php echo $paginas_redes[0]['texto_4']; ?>
          </p>
        </div>
        <div class=" medium-6 columns ">
          <p  class=" rel  poppi  "  >
            <img src="tw7control/files/images/paginas_redes/<?php echo $paginas_redes[0]['imagen_9']; ?>" >
            <?php echo $paginas_redes[0]['texto_5']; ?>         
          </p>
        </div>

        <div class=" medium-12 columns lleva_btn_canal ">
          <a href="<?php echo $link_grupo_wasap; ?>" title="  canal_wsp_flota" target="_blank" class=" canal_wsp_flota  poppi  "  >
            <img src="img/iconos/wspf.png" alt="Únete a nuestro  canal de whatsApp ">Canal de WhatsApp <img src="img/iconos/mano_click.png" class="click_mano ">
          </a>
        </div>
      </div>
      
    </div></div>

    <div class="callout callout-3  "><div class="row text-center ">
      <div class=" medium-12 columns text-center  ">
        <h3 clasS=" poppi-b color-1 "> <?php echo $paginas_redes[0]['titulo_2']; ?></h3>  
      </div>
  
      <div class=" medium-6 columns ">
        <p  class=" rel  poppi  "  >
        <?php echo $paginas_redes[0]['texto_6']; ?>      
        </p>
      </div>
      <div class=" medium-6 columns ">
        <img src="tw7control/files/images/paginas_redes/<?php echo $paginas_redes[0]['imagen_2']; ?>" >
      </div>
      <div class=" medium-12 columns text-center  ">
        <blockquote clasS=" poppi-sb color-1 "><?php echo $paginas_redes[0]['texto_7']; ?> </blockquote>  
      </div>
      <div class=" medium-6 columns ">
        <img src="tw7control/files/images/paginas_redes/<?php echo $paginas_redes[0]['imagen_3']; ?>" >
      </div>
      <div class=" medium-6 columns ">
        <p  class=" rel  poppi  "  >
        <?php echo $paginas_redes[0]['texto_8']; ?>  
        </p>
      </div>
     
    </div></div>


    <div class="callout callout-4  poppi "><div class="row text-center "><div class=" medium-9 medium-centered  columns text-center  ">
      
        <h3 clasS=" poppi-sb color-1 ">   <?php echo $paginas_redes[0]['titulo_3']; ?> </h3>  
      <div class=" large-12 columns _paso_1 ">
        <blockquote class=" poppi-b ">PASO 1</blockquote>
        <p class=" text-center "> <?php echo $paginas_redes[0]['texto_9']; ?></p>
        <div class=" medium-6 columns  ">
          <a href="<?php echo $paginas_redes[0]['enlace_2']; ?>" target="_blank"> <img src="tw7control/files/images/paginas_redes/<?php echo $paginas_redes[0]['imagen_4']; ?>"> </a>
        </div>
        <div class=" medium-6 columns  ">
          <a href="<?php echo $paginas_redes[0]['enlace_3']; ?>" target="_blank"><img src="tw7control/files/images/paginas_redes/<?php echo $paginas_redes[0]['imagen_5']; ?>"></a>
        </div>

      </div>
      
      <div class=" large-12 columns _paso_2 ">
        <blockquote class=" blanco poppi-b ">PASO 2</blockquote>
        <p class="blanco  text-center "><?php echo $paginas_redes[0]['texto_10']; ?> </p>
        <div class=" medium-12 columns lleva_btn_canal ">
          <a href="<?php echo $link_grupo_wasap; ?>" title="  canal_wsp_flota" target="_blank" class=" canal_wsp_flota  poppi  "  >
            <img src="img/iconos/wspf.png" alt="Únete a nuestro  canal de whatsApp ">Canal de WhatsApp <img src="img/iconos/mano_click.png" class="click_mano ">
          </a>
        </div>

      </div>
      
      
      
    </div></div></div>





</main>
<?php 
include ('inc/footer.php'); ?>