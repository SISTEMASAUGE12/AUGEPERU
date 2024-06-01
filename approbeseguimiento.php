<?php 
$pagina='perfil_home_2';
include('auten.php');
$meta = array(
    'title' => ' Aprobando datos para mi certificado | Educa Auge',
    'description' => ''
);
include ('inc/header.php');

//echo '=>'.$_SESSION['suscritos']['id_suscrito']; 

$suscri = executesql("SELECT s.*, e.titulo FROM suscritos s INNER JOIN especialidades e ON s.id_especialidad = e.id_especialidad WHERE s.id_suscrito = '".$_SESSION['suscritos']['id_suscrito']."' ");
?>

<main id="perfil" class="margin_interno ">
<!-- Si ven el curso detalle en el perfil -->
<?php 

if( isset($_GET['rewrite']) && !empty($_GET['rewrite']) ){  // ID
    if(isset($_GET["rewrite2"]) && !empty($_GET['rewrite2'])){ /* ventana emergente de gracias por compra */ 
      // actualizamos estado 
      $bd=new BD;

        $_POST["id_suscrito"]= $_GET["rewrite"];
        $_POST["ide"]= $_GET["rewrite2"];
        $_POST["fecha_validacion_api"]= fecha_hora(2);
        $_POST["estado_api"]= 1;

        $campos=array('fecha_validacion_api','estado_api'); /*inserto campos principales*/
        $bd->actualiza_(armaupdate('solicitudes',$campos," ide='".$_POST["ide"]."' and  id_suscrito='".$_POST["id_suscrito"]."' ",'POST'));/*actualizo*/
        $bd->close();
 ?>

<!-- 
<div class="success callout" data-closable="slide-out-right">
  <p>You can close me too, and I close using a Motion UI animation.</p>
  <button class="close-button" aria-label="Dismiss alert" type="button" data-close>
    <span aria-hidden="true">&times;</span>
  </button>
</div>
-->

	<div class="callout callout-inicio-3" style="padding:120px;"> <div class="row text-center "><div class="large-12 medium-12 columns content_perfil ">
		<img src="img/check_estado_api_certificado_ok.png">
		<h4 class="color1 poppi-sb text-center"> <br> VÁLIDACIÓN DE DATOS PARA CERTIFICADO APROBADO EXITOSAMENTE</h4>
			
	</div></div></div>

<?php 
  }else{
      echo " 2:: LINK INVÁLIDO ";
  } 

}else{
		echo " LINK INVÁLIDO ";
} 
?>

</main>
<?php include ('inc/footer.php'); ?>