<?php include('auten.php');
$pagina='registro';
$meta = array(
    'title' => 'Recuperar Contraseña | EducaAuge.com',
    'description' => ''
);
include ('inc/header-registro.php');
?>
<main id="registro" class="maina">
<?php
    if (isset($_GET['rewrite']) && !empty($_GET['rewrite'])){
    $cant = strlen($_GET['rewrite']);
    $res = $cant - 45;
    $rewrite = substr($_GET['rewrite'], -$res,$res);
		// echo "SELECT * FROM suscritos WHERE id_suscrito = '".$rewrite."'"; 
		// echo "SELECT * FROM suscritos WHERE id_suscrito = '".$rewrite."'"; 
    $recupe = executesql("SELECT * FROM suscritos WHERE id_suscrito='".$rewrite."'");
?>
    <div class="callout callout-2 recuperar"><div class="row row2">
        <div class="large-6 medium-6 columns nothing hide"><img class="img-r" src="img/registro.jpg"></div>
        <div class=" medium-8 medium-centered columns" style="float:none;"><div class="centrar"><form id="form-recu2" action="sendmessage.php" method="post" enctype="multipart/form-data">
            <h3 class="texto poppi-sb text-center" >Recupera tu clave</h3>
            <div class="cuerpo text-center">
								<p>Revisa tu bandeja de entrada o correo de spam/correo no deseados</p>
                <fieldset class="rel"><input type="text" class="poppi" name="correo" placeholder="Correo electrónico" value="<?php echo $recupe[0]['email'] ?>" readonly></fieldset>
                <fieldset class="rel"><input type="password" class="poppi" id="clave" name="clave" placeholder="Clave"></fieldset>
                <fieldset class="rel"><input type="password" class="poppi" name="clave2" placeholder="Repite la clave"></fieldset>
                <p class="poppi texto">No olvide su clave de acceso</p>
                <button class="boton">Actualizar clave</button><div class="callout primary hide" id="actuaInfo">Procesando datos...</div>
                <div class="callout alert hide" id="actuaError">No se pudo actualizar la clave, intentelo otra vez</div>
                <div class="callout success hide" id="actuaSuccess">Clave actualizada correctamente...</div>
            </div>
        </form></div></div>
    </div></div>
<?php
    }else{
?>
    <div class="callout callout-2 recuperar "><div class="row row2">
        <div class="large-6 medium-6 columns nothing hide "><img class="img-r" src="img/registro.jpg"></div>
        <div class=" medium-8 medium-centered columns" style="float:none;"><div class="centrar"><form id="form-recu" action="sendmessage.php" method="post" enctype="multipart/form-data">
            <h3 class="texto poppi-sb text-center"  >Recupera tu clave.</h3>
            <div class="cuerpo text-center">
								<p class="poppi ">Revisa tu bandeja de entrada o correo de spam/correo no deseados</p>
                <fieldset class="rel"><input type="text" class="poppi" name="correo" placeholder="Correo electrónico"></fieldset>
                <p class="poppi texto">Le envíaremos un enlace a su correo electrónico, para crear una clave nueva.</p>
                <button class="boton">Recuperar clave</button><div class="callout primary hide" id="reportInfo">Procesando datos...</div>
                <div class="callout alert hide" id="reportError">Correo no registrado</div>
                <div class="callout success hide" id="reportSuccess">Correo enviado correctamente...</div>
            </div>
        </form></div></div>
    </div></div>
<?php } ?>
</main>
<?php include ('inc/footer.php'); ?>