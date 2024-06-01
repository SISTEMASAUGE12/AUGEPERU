<?php 
$pagina='registro';
 include('auten.php');
$meta = array(
    'title' => 'Registro | AugePerú.com',
    'description' => ''
);
include ('inc/header-login.php');

// if ( !isset($_SESSION["suscritos"]["id_suscrito"])) {

?>
<main id="registro" class="maina">
    <div class="callout callout-2"><div class="row row2">
        <div id="fb-root"></div>
        <script async defer crossorigin="anonymous" src="https://connect.facebook.net/es_ES/sdk.js#xfbml=1&version=v6.0&appId=192358075687241&autoLogAppEvents=1"></script>
        <meta name="google-signin-client_id" content="889922707584-vra1hc9mdn321p2m1ieouc6rijqfnr9i.apps.googleusercontent.com">
        <script src="https://apis.google.com/js/platform.js?onload=onLoadGoogleCallback" async defer></script>
        <script src="js/login_facebook.js?ud=<?php echo $unix_date; ?>"></script>
        <script src="js/login_google.js?ud=<?php echo $unix_date; ?>"></script>
				
        <div id="registrar-modal" class="modal"><div class="sesion"><div class="modal-content">
        <div class="modal-body formu">
        <div class="mitad1 large-6 medium-6 columns nothing">
            <img class="yap" src="img/registro.jpg">
            <div class="capa text-center">
                <blockquote class="poppi-sb color-blanco">Regístrate</blockquote>
                <span class="poppi color-blanco">Crea un cuenta y accede a los cursos y beneficios del GRUPO AUGE </br> </br> 
									<small>Para evitar inconvenientes con tus compras te recomendamos usar un solo registro usa Facebook ó Google (un correo)</small>
								</span>
               
            </div>
        </div>
        <div class=" large-6 medium-6 columns nothing mitad2 modal_registro_cliente" style="padding-top:49px;">
				<!-- 
						-->
								<h3 class="texto poppi-sb text-center " style="color:#CA3A2B!important;padding-bottom:16px;font-size:35px;line-height:45px;">Crea una Cuenta en AUGE</h3>
								<p class="poppi" style="padding-bottom:50px;"> Para evitar inconvenientes con tus compras te recomendamos usar un solo registro usa Facebook ó Google (un correo) </p>
                <div class="numer" style="margin-bottom:50px;display:none;">
                    <div class="numero roboto activo">1</div>
                    <div class="borde"><div class="linea"></div></div>
                    <div class="numero roboto">2</div>
                    <div class="borde"><div class="linea"></div></div>
                    <div class="numero roboto">3</div>
                    <div class="borde"><div class="linea"></div></div>
                    <div class="numero roboto">4</div>
                </div>
                        <!--
            <a class="btn-facebook poppi-sb"><img src="img/iconos/face.png">Regístrate con Facebook</a>
            <a class="btn-google poppi-sb"><img src="img/iconos/google.png">Regístrate con google</a>
                        -->
										<div class="text-center contiene-btn-facebook ">
                        <div class="fb-login-button btn-facebook  poppi-sb text-center "  data-onlogin="checkLoginState();" data-scope="public_profile,email" data-size="large" data-button-type="continue_with" data-layout="rounded" data-auto-logout-link="false" data-use-continue-as="false" data-width=""></div>
										</div>
                        <?php if($login_button != ''){  echo $login_button; }  //login Google ?>

<!--
            <p class="color4 poppi" style="padding-bottom:25px">o crea una cuenta con tu correo electrónico</p>
            <div class="modal-inner"><div class="credentials-box">
                <form  class="general" method="post" enctype="multipart/form-data">
                    <fieldset class="rel"><label class="rederror  label_reg_email hide">Ingresa un correo valido .. </label><input type="email" name="email_reg" requerid placeholder="Correo Electrónico"></fieldset>
                    <fieldset class="rel"><label class="rederror label_reg_clave hide ">Ingrese un clave mayor a 7 dígitos .. </label><input requerid type="password" name="clave_reg" placeholder="Contraseña"></fieldset>
                    <fieldset class="rel"><label class="rederror label_reg_clave_2 hide ">Ingrese un clave mayor a 7 dígitos .. </label><input requerid type="password" name="clave_reg_2" placeholder="Repete la contraseña"></fieldset>
                    <p class="color4 poppi" style="font-size:11px;line-height:15px;padding:0 0 12px;">No olvides esta contraseña la necesitarás para acceder a tu aula virtual</p>
                    <fieldset class="rel text-center ">
											<input name="cbilibros" type="checkbox" required checked="checked" />Acepto recibir mensajes promocionales sobre Educaauge.com

												<div class="g-recaptcha" data-sitekey="6LfUxLcdAAAAAHwBF9sOotrRnU1zOQpETNnSENXH"></div>
                        <a class="btn_registrar_alumno boton poppi-sb disabled" style="margin:40px auto 10px;">Iniciar registro</a>
										
                        <div class='hide monset pagoespera ' id='rptapago'>Procesando ...</div>
												<script src='https://www.google.com/recaptcha/api.js?hl=es'></script>
                    </fieldset>
                </form>
            </div></div>
-->

            <p class="color4 poppi text-center">¿Tienes cuenta? <a href="iniciar-sesion" class="poppi-b">Inicia sesión</a></p>
            <span class="text-center termino poppi texto">Al registrarte aceptas nuestra  <a class="poppi-b">política de privacidad</a></span>
        </div>
    </div>
</div></div></div>
    </div></div>
</main>
<?php 

// }else{ 
	// header('Location: perfil/mis-cursos');
// } //if sesion suscrito

include ('inc/footer.php'); ?>