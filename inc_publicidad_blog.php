<?php 
$publicidades= executesql("select * from publicidades where estado_idestado=1  ");  
if( !empty($publicidades) ){ ?>
    <blockquote>Publicidad:</blockquote>
    <div class=" _lleva_publicidad ">
        <div class=" _publicidad_pc ">
            <ul class=" carousel-1 no-bullet   "> 			
			<?php 
				foreach( $publicidades as $linea ){ 
					if( !empty( $linea["imagen"])  ){
						$img_publi='tw7control/files/images/publicidades/'.$linea["imagen"];
						$img_publi_movil='tw7control/files/images/publicidades/'.$linea["imagen_2"];
?>
				<li class="  ">
					<a href="<?php echo $linea["link"]; ?>" target="_blank">
						 <figure><img src="<?php echo $img_publi; ?>"></figure>
					</a>
				</li>										
<?php
					}
				} // ened for publicidad 	
			?>
            </ul>
        </div>
  
        <div class=" _publicidad_movil ">
            <ul class=" carousel-1 no-bullet  "> 			
			<?php 
				foreach( $publicidades as $linea ){ 
					if( !empty( $linea["imagen"])  ){
						$img_publi='tw7control/files/images/publicidades/'.$linea["imagen"];
						$img_publi_movil='tw7control/files/images/publicidades/'.$linea["imagen_2"];
?>		
				<li class="   ">
					<a href="<?php echo $linea["link"]; ?>" target="_blank">
						 <figure><img src="<?php echo $img_publi_movil; ?>"></figure>
					</a>
				</li>
						
<?php
					}
				} // ened for publicidad 	
			?>
				</ul>
        </div>

    </div>
<?php } // end piblicicad if ?>