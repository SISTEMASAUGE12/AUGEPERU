<!-- 
			-->
			<div id="compi" style="padding-top:50px;" >
				<div class="float-  text-center ">
					<a href="https://educaauge.com/augeperu-telegram/" target="_blank">
						<p class="poppi-sb  "    style="background: #EE0005 !important;color: #fff;padding: 15px;border-radius:20px;" >Unete a nuestro grupo exclusivo de TELEGRAM </br> para que no te pierdas ninguna de nuestras </br>conferencias, allí te enviaremos el link de acceso a</br> nuestras  conferencias GRATUITAS</p>
						<img src="img/unete_telegram_1.png">
					</a>
				</div>
				<?php 
						// echo '-->'.$curso[0]["link_grupo_wasap"];
						if( !empty($curso[0]["link_grupo_wasap"]) ){ /* se muestra boton wsp, si el curso tiene un link registrado::: */ ?>
				<div class=" text-center ">
					<a href="<?php echo $curso[0]["link_grupo_wasap"]; ?>" target="_blank">
						<img src="img/iconos/unete_wasap_2.png">
					</a>
				</div>
				<?php } ?>
				
				
				<ul class="no-bullet poppi float-right color1" style="padding-top:60px;">
						<li class="poppi"><em style="display:inline-block;padding-right:10px;">Compartir: </em> 
						<a title="Twitter" href="javascript: void(0);" onclick="window.open('https://twitter.com/intent/tweet?text=&url='+window.document.URL+'','ventanacompartir', 'toolbar=0, status=0, width=650, height=450');"><img src="img/iconos/twitter-b.png"></a> <a title="Facebook" href="javascript: void(0);" onclick="window.open('http://www.facebook.com/sharer.php?u='+window.document.URL+'','ventanacompartir', 'toolbar=0, status=0, width=650, height=450');"><img src="img/iconos/face-b.png"></a> <a title="Telegram" href="javascript: void(0);" onclick="window.open('https://telegram.me/share/url?url='+window.document.URL+'','ventanacompartir', 'toolbar=0, status=0, width=650, height=450');"><img src="img/iconos/telegram-b.png"></a> <a href="https://api.whatsapp.com/send/?phone&text=<?php echo 'https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'] ?>" target="_blank"><img src="img/iconos/wsp-b.png" style="margin-top:;"></a></li>
				</ul>
			</div>