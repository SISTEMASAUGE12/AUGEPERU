<?php include('auten.php');
$pagina='login_v2';
$meta = array(
    'title' => 'Iniciar sesion | EducaAuge.com',
    'description' => ''
);
include ('inc/header.php');
//include ('inc/header-registro.php'); 

if ( !isset($_SESSION["suscritos"]["id_suscrito"])) {

?>
<main id="registro" class=" ">
    <div class="callout callout-2 login_v2"  ><div class="row row2">
		<?php /*
        <script src="js/login_facebook.js?ud=<?php echo $unix_date; ?>"></script>
        <div id="fb-root"></div>
        <script async defer crossorigin="anonymous" src="https://connect.facebook.net/es_ES/sdk.js#xfbml=1&version=v6.0&appId=192358075687241&autoLogAppEvents=1"></script>
        <meta name="google-signin-client_id" content="889922707584-vra1hc9mdn321p2m1ieouc6rijqfnr9i.apps.googleusercontent.com">
        <script src="https://apis.google.com/js/platform.js?onload=onLoadGoogleCallback" async defer></script>
        <script src="js/login_google.js?ud=<?php echo $unix_date; ?>"></script>
*/ ?> 
        <div id="login-modal" class="modal"><div class="sesion login_v2"><div class="modal-content">
        <div class="modal-body formu">
          
          <div class="callout   mensaje_flotante " data-closable="slide-out-right">
            <button class="close-button" data-close>&times;</button>
            <blockquote class=" poppi-sb " style="border-bottom:2px solid #f1f1f1;"> Ayuda para iniciar sesión</blockquote>
            <p class=" poppi-sb ">
                Para acceder a tu curso, <b class=" color1">PRIMERO  </b> ingresa el correo electrónico con el que te registraste, <b class=" color1">LUEGO </b>  coloca tu contraseña que es tu n° de <b class=" color1">DNI. </b> Si aun no has creado una cuenta <a href="registrate_v2" class="poppi"><b>registrate aquí.</b> </a>             
            </p>
          </div>

          <div class="mitad1 large-6 medium-6 columns nothing" style="display:none;">
              <img class="yap" src="img/registro.jpg">
              <div class="capa text-center"> 
              </div>
          </div>
          <div class="mitad2 modal_login_cliente" style="width:100%;float:none;">          				           
						<?php /* 
						<div class="text-center contiene-btn-facebook ">
							<div class="fb-login-button btn-facebook poppi-sb text-center "  data-onlogin="checkLoginState();" data-scope="public_profile,email" data-size="large" data-button-type="continue_with" data-layout="rounded" data-auto-logout-link="false" data-use-continue-as="false" data-width=""></div>
						</div>
            <?php if($login_button_ingresar != ''){  echo $login_button_ingresar;   }  //login Google ?>
            */ ?>
						
						<figure class=" text-center hide "><img src="img/logo_color.png"></figure>
						<p class="color4 poppi-b text-center  " style="padding:0  0 20px;">Ingresa con</p>
            <div class="modal-inner"><div class="credentials-box">
                <form   class="general poppi-sb " method="post" enctype="multipart/form-data">
                    <fieldset class="rel"><label class="rederror  label_log_email hide">Ingresa un correo valido .. </label><input type="text" name="email_login" class="roboto" placeholder="Correo Electrónico"></fieldset>
										
                    <fieldset class="rel"><label class="rederror  label_log_clave hide">Ingresa una clave correcta .. </label><input type="password" name="clave_login" class="roboto" placeholder="Contraseña"></fieldset>
                    <fieldset class="rel lleva_btn_ingresar_v2 " style="max-width: 416px;margin: 0 auto; ">
                        <a class="btn_login_alumno boton poppi-sb " style="margin-left:0;border-radius: 5px;max-width: 100%;">Iniciar sesión</a>
                        <div class='hide monset pagoespera ' id='rptapago'>Procesando ...</div>
                    </fieldset>
                </form>
            </div></div>

            <p class="color4 poppi text-center" style="padding-bottom:10px;border-bottom:3px solid #ddd;margin-bottom:25px;"><a href="recuperar" class="poppi-b color4 ">Olvide mi contraseña</a></p>
            <p class="color4 poppi text-center">¿No tienes cuenta? <a href="registrate_v2" class="poppi-b">Regístrate</a></p>
            <!-- 
            <p class=" poppi text-center" style="padding-top:10px;">
								<a href="actualiza-tus-datos" class="poppi-b boton">Actualizar mis datos</a>
						</p>
            -->
            <span class="text-center termino poppi texto">Al registrarte aceptas nuestra  <a class="poppi-b">política de privacidad</a></span>
        </div>
        
        </div>
        </div></div></div>
    </div></div>
</main>
<?php 

}else{ ?>
    <script>   console.log(" redireciono a mis cursos "); location.href ="mis-cursos";</script>
<?php 
} //if sesion suscrito

include ('inc/footer.php'); ?>