<!-- login face & google -->
<?php if (!isset($_SESSION["suscritos"]["id_suscrito"]) || empty($_SESSION["suscritos"]["id_suscrito"]) ) { ?>
<!-- login face & google 
    <script src="js/login_facebook.js?ud=<?php // echo $unix_date ; ?>"></script>
    <div id="fb-root"></div>
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/es_ES/sdk.js#xfbml=1&version=v6.0&appId=192358075687241&autoLogAppEvents=1"></script>
    <meta name="google-signin-client_id" content="889922707584-vra1hc9mdn321p2m1ieouc6rijqfnr9i.apps.googleusercontent.com">
    <script src="https://apis.google.com/js/platform.js?onload=onLoadGoogleCallback" async defer></script>
    <script src="js/login_google.js?ud=<?php // echo $unix_date ; ?>"></script>

-->

		<input type="hidden" name="link_go" value="<?php echo !empty($_SESSION["url"])?'reload':'';?>">


		<div id="login-modal"  class="modal"  style="display:none;" ><div class="sesion modal_login_v2"><div class="modal-content">
			<div class="modal-body formu">
        <div class="mitad1 large-6 medium-6 columns nothing" style="display:none;">
            <img class="yap" src="img/registro.jpg">
            <div class="capa text-center">
								<!-- 
                <blockquote class="poppi-sb color-blanco">¡Bienvenido!</blockquote>
                <span class="poppi color-blanco">Inicia sesión para disfrutar de tus cursos</span>
								
								 <a href="recuperar" class="boton poppi-sb" style="margin-top:30px">Quiero Recuperar mi clave</a>
								 -->
            </div>
        </div>
        <div class="mitad2 modal_login_cliente" >
				<span class="close poppi close1"> x <!-- <img src="img/iconos/cerrar.png"> --></span>
				<!--
            <blockquote class="poppi-sb  texto">¡Bienvenido!</blockquote>
            <span class="poppi  texto">Inicia sesión para disfrutar de tus cursos</span>
						-->
						<h3 class="texto poppi-sb text-center ">Inicia sesión para disfrutar de tus cursos</h3>
            
						<?php /* 
						<div class="text-center contiene-btn-facebook ">
							<div class="fb-login-button btn-facebook poppi-sb text-center "  data-onlogin="checkLoginState();" data-scope="public_profile,email" data-size="large" data-button-type="continue_with" data-layout="rounded" data-auto-logout-link="false" data-use-continue-as="false" data-width=""></div>
						</div>
            <?php if($login_button_ingresar != ''){  echo $login_button_ingresar;   }  //login Google ?>
            */ ?>
						
						
						<p class="color4 poppi text-center" style="padding-bottom:20px;">Ingresa con</p>
            <div class="modal-inner"><div class="credentials-box">
                <form id="frm3"  class="general" method="post" enctype="multipart/form-data">
                    <fieldset class="rel"><label class="rederror  label_log_email hide">Ingresa un correo valido .. </label><input type="text" name="email_login" class="roboto" placeholder="Correo Electrónico"></fieldset>
                    <fieldset class="rel"><label class="rederror  label_log_clave hide">Ingresa una clave correcta .. </label><input type="password" name="clave_login" class="roboto" placeholder="Contraseña"></fieldset>
                    <fieldset class="rel lleva_btn_ingresar_v2 " style="max-width: 416px;margin: 0 auto; ">
                        <span class="btn_login_alumno boton poppi-sb " style="margin-left:0;border-radius: 4px;max-width: 150px;">Ingresar</span>
                        <div class='hide monset pagoespera ' id='rptapago'>Procesando ...</div>
                    </fieldset>
                </form>
            </div></div>

            <p class="color4 poppi text-right" style="padding-bottom:10px;"><a href="recuperar" class="poppi-b color4 ">Olvide mi contraseña</a></p>
            <p class="color4 poppi text-center">¿No tienes cuenta? <a href="registrate_v2" class="poppi-b">Regístrate</a></p>
            <p class=" poppi text-center" style="padding-top:10px;">
								<a href="actualiza-tus-datos" class="poppi-b boton btn_actualiza ">Actualizar mis datos</a>
						</p>
            <span class="text-center termino poppi texto">Al registrarte aceptas nuestra  <span class="poppi-b">política de privacidad</span></span>
        </div>
			</div>
		</div></div></div>

<?php } // end validacion si existe session ?>