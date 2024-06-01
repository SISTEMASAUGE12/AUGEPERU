<!-- login face & google -->
<?php if (!isset($_SESSION["suscritos"]["id_suscrito"]) || empty($_SESSION["suscritos"]["id_suscrito"]) ) { ?>
    <script src="js/login_facebook.js?ud=<?php echo $unix_date ; ?>"></script>
    <div id="fb-root"></div>
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/es_ES/sdk.js#xfbml=1&version=v6.0&appId=192358075687241&autoLogAppEvents=1"></script>
    <meta name="google-signin-client_id" content="889922707584-vra1hc9mdn321p2m1ieouc6rijqfnr9i.apps.googleusercontent.com">
    <script src="https://apis.google.com/js/platform.js?onload=onLoadGoogleCallback" async defer></script>
    <script src="js/login_google.js?ud=<?php echo $unix_date ; ?>"></script>
<!-- login face & google -->

		<input type="hidden" name="link_go" value="<?php echo !empty($_SESSION["url"])?'reload':'';?>">


<div id="login-modal" class="modal" style="display:none;"><div class="sesion"><div class="modal-content">
    <div class="modal-body formu">
        <div class="mitad1">
            <img class="yap" src="img/login.png">
            <div class="capa text-center">
                <img src="img/logo.png">
                <a class="close close1"><img src="img/iconos/cerrar2.png"></a>
                <blockquote class="poppi-sb color-blanco">¡Bienvenido!</blockquote>
                <span class="poppi color-blanco">Inicia sesión para disfrutar de tus cursos</span>
            </div>
        </div>
        <div class="mitad2 modal_login_cliente">
            <a class="close montb close1"><img src="img/iconos/cerrar.png"></a>
            <blockquote class="poppi-sb yeb texto">¡Bienvenido!</blockquote>
            <span class="poppi yeb texto">Inicia sesión para disfrutar de tus cursos</span>
			<!--
            <a class="btn-facebook poppi-sb"><img src="img/iconos/face.png">Ingresa con Facebook</a>
            <a class="btn-google poppi-sb"><img src="img/iconos/google.png">Ingresa con google</a>
			-->

						<div class="fb-login-button btn-facebook poppi-sb text-center "  data-onlogin="checkLoginState();" data-scope="public_profile,email" data-size="large" data-button-type="continue_with" data-layout="rounded" data-auto-logout-link="false" data-use-continue-as="false" data-width=""></div>

						<?php if($login_button_ingresar != ''){  echo $login_button_ingresar;	}  //login Google ?>

            <p class="color4 poppi text-center">o ingresa con</p>
            <div class="modal-inner"><div class="credentials-box">
                <form id="frm3"  class="general" method="post" enctype="multipart/form-data">
                    <fieldset class="rel"><label class="rederror  label_log_email hide">Ingresa un correo valido .. </label><input type="text" name="email_login" class="roboto" placeholder="Correo Electrónico"></fieldset>
                    <fieldset class="rel"><label class="rederror  label_log_clave hide">Ingresa una clave correcta .. </label><input type="password" name="clave_login" class="roboto" placeholder="Contraseña"></fieldset>
                    <fieldset class="rel">
												 <a class="btn_login_alumno boton poppi-sb disabled">Ingresar</a>
                        <div class='hide monset pagoespera ' id='rptapago'>Procesando ...</div>

                    </fieldset>
                </form>
            </div></div>
            <p class="color4 poppi text-center">¿No tienes cuenta? <a id="crear" class="poppi-b">Regístrate</a></p>
            <p class="color4 poppi text-center">¿Olvistaste tu contraseña? <a href="recuperar" class="poppi-b">Recuperar</a></p>
            <span class="text-center termino poppi texto">Al registrarte aceptas nuestra  <a href="politicas-de-privacidad" target="_blank" class="poppi-b">política de privacidad</a></span>
        </div>
    </div>
</div></div></div>
<div id="registrar-modal" class="modal" style="display: none;"><div class="sesion"><div class="modal-content">
    <div class="modal-body formu">
        <div class="mitad1">
            <img class="yap" src="img/login.png">
            <div class="capa text-center">
                <img src="img/logo.png">
                <a class="close close2"><img src="img/iconos/cerrar2.png"></a>
                <blockquote class="poppi-sb color-blanco">Regístrate</blockquote>
                <span class="poppi color-blanco">Obtén los mejores cursos desde la comodidad de tu casa.</span>
            </div>
        </div>
        <div class="mitad2 modal_registro_cliente ">
            <a class="close close2"><img src="img/iconos/cerrar.png"></a>
            <blockquote class="poppi-sb yeb texto">Regístrate</blockquote>
            <span class="poppi yeb texto">Obtén los mejores cursos desde la comodidad de tu casa.</span>
						<!--
            <a class="btn-facebook poppi-sb"><img src="img/iconos/face.png">Regístrate con Facebook</a>
            <a class="btn-google poppi-sb"><img src="img/iconos/google.png">Regístrate con google</a>
						-->
						<div class="fb-login-button btn-facebook poppi-sb text-center "  data-onlogin="checkLoginState();" data-scope="public_profile,email" data-size="large" data-button-type="continue_with" data-layout="rounded" data-auto-logout-link="false" data-use-continue-as="false" data-width=""></div>
						<?php if($login_button != ''){  echo $login_button;	}  //login Google ?>


            <p class="color4 poppi text-center">o continúa con</p>
            <div class="modal-inner"><div class="credentials-box">
                <form  class="general" method="post" enctype="multipart/form-data">
                    <fieldset class="rel"><label class="rederror  label_reg_email hide">Ingresa un correo valido .. </label><input type="email" name="email_reg"  placeholder="Correo Electrónico"></fieldset>
                    <fieldset class="rel"><label class="rederror label_reg_clave hide ">Ingrese un clave mayor a 7 dígitos .. </label><input type="password" name="clave_reg" placeholder="Contraseña"></fieldset>
                    <fieldset class="rel">
                        <a class="btn_registrar_alumno boton poppi-sb disabled">Registrate</a>
                        <div class='hide monset pagoespera ' id='rptapago'>Procesando ...</div>
                    </fieldset>
                </form>
            </div></div>
            <p class="color4 poppi text-center">¿Tienes cuenta? <a id="entrar" class="poppi-b">Inicia sesión</a></p>
            <span class="text-center termino poppi texto">Al registrarte aceptas nuestra  <a href="politicas-de-privacidad" target="_blank" class="poppi-b">política de privacidad</a></span>
        </div>
    </div>
</div></div></div>

<?php } // end validacion si existe session ?>