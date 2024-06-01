<?php 
include('auten.php');

$pagina='registro';
$meta = array(
	'title' => 'Registro v2 | Educa Auge .com',
	'description' => ''
);

if( isset($_GET["task"]) && $_GET["task"]=='buscardni'){
	$id=''; $nombre='';  $ap_pa='';  $ap_ma=''; $rpta=2;
	
	$sql_reniec="SELECT * FROM suscritos WHERE dni ='".$_GET["dni"]."' ";
	// echo $sql_reniec;

	$exsql = executesql($sql_reniec);
	if(!empty($exsql)){
		foreach($exsql as $row){
			$id = $row['id_suscrito'];
			$nombre = $row['nombre'];
			$ap_pa = $row['ap_pa'];
			$ap_ma = $row['ap_ma'];
			$rpta = 1;
		} 
	}
	  
  
	echo json_encode(array(
	  'res' => $rpta,
	  'id' => $id,
	  "nombre" => $nombre,
	  "ap_pa" => $ap_pa,
	  "ap_ma" => $ap_ma
	));

}else{ 

include ('inc/header-registro.php');

/*

if( !empty($_GET["rewrite"]) ){
	// $data_magisterio=executesql("select * from data_docente_magisterios where dni='".$_GET["rewrite"]."' ");
	
	
	$data_magisterio=executesql("select * from excel_leads where dni='".$_GET["rewrite"]."' ");
	
	// $data_magisterio[0]["dni"]='';
	// $data_magisterio[0]["nombre"]='';
	// $data_magisterio[0]["ap_pa"]='';
	// $data_magisterio[0]["ap_ma"]='';
	// $data_magisterio[0]["telefono"]='';
	// $data_magisterio[0]["email"]='';

}else 
*/

?>
<main id="registro" class=" ">
    <div class="callout callout-1"><div class="row row2">
		<!-- 
        <div class="large-6 medium-6 columns nothing"><img class="img-r" src="img/registro.jpg"></div>
				-->
        <div class="medium-6  medium-centered columns"><div class="centrar"><form id="form-regis">
						<h3 class="color5 text-center poppi-sb" style="font-size:30px;line-height:38px;">Regístrate aquí</h3>
            <div id="cuerpo4" >
                <div class="numer" style="display:none;" >
                    <div class="numero roboto activo">1</div>
                    <div class="borde"><div class="linea activo"></div></div>
                    <div class="numero roboto activo">2</div>
                    <div class="borde"><div class="linea activo"></div></div>
                    <div class="numero roboto activo">3</div>
                    <div class="borde"><div class="linea activo"></div></div>
                    <div class="numero roboto activo">4</div>
                </div>
                <div class="form">
                    <div class="datos">
												
						<!-- ** modificado reduccion __ -->
						<p class="color1 poppi-sb" style="padding:15px 0;">Selecciona tu país: </p>
                        <div class="celu">
                            <div class="select-sim" id="select-color">
                                <div class="options">
								<!-- 
                                    <div class="option">
                                        <input type="radio" name="bandera" value="" id="color-" checked />
                                        <label for="color-"><img src="img/peru.jpg" alt="" /></label>
                                    </div>
								-->
						<?php 
							$paises=executesql("select * from paises order by id_pais asc ");  
							foreach($paises as $row){
						?>
									<div class="option">
										<input type="radio" name="id_pais" value="<?php echo $row["id_pais"];?>" <?php echo ($row["id_pais"]==1)?' checked ':'';?> id="color-<?php echo $row["id_pais"];?>"  />
										<label for="color-<?php echo $row["id_pais"];?>">
											<img src="tw7control/files/images/paises/<?php echo $row["imagen"];?>">
											<span><?php echo $row["prefijo"];?></span>
										</label>
									</div>
						<?php 
							}
						?>
								</div>
                            </div> <!-- end select sim -->
							<input type="text" required class="poppi" name="telefono" id="telefono" onkeypress="javascript:return soloNumeros(event,0);"  placeholder="Número de celular"  value="<?php echo !empty($data_magisterio[0]["telefono"])?$data_magisterio[0]["telefono"]:''; ?>">
						</div> <!--  end class celu -->

						
						<!-- 
						<input type="text" class="poppi" required name="dni" id="dni" value="<?php echo !empty($data_magisterio[0]["dni"])?$data_magisterio[0]["dni"]:''; ?>" placeholder="Número de DNI/cédula">
						-->
						
						<div class=" div_dni_cliente_reniec rel  ">
							<label class="label_dni color1  poppi-sb control-label ">Ingresa el DNI/cédula cliente: <small style="color:red;font-size:10px;"></small></label>
							<input type="text" class="poppi" required name="dni" id="dni" value="<?php echo !empty($_GET["rewrite"])?$_GET["rewrite"]:''; ?>" placeholder="Número de DNI/cédula" maxLength="8" minLength="8">
							<a class="btn bg-blue btn-flat btn_buscar_dni  "  onclick="busque_cliente();">buscar</a>
							<?php create_input("hidden","api_dni",'',"form-control",''," required ",' required '); ?>
						</div>


						<fieldset id="field_client" >
							<!-- 
							<input type="text" class="poppi" required name="nombre" id="nombre" placeholder="Nombres" value="<?php echo !empty($data_magisterio[0]["nombre"])?$data_magisterio[0]["nombre"]:''; ?>">
						-->
							<input type="text" class="poppi" required name="nombre" id="nombre" placeholder="Nombres" >
							<?php create_input("hidden","api_nombre",'',"form-control ",''," required ",'   '); ?>
							
							<input type="text" class="poppi" required name="ap_pa" id="ap_pa" placeholder="Apellido paterno" >
							<?php create_input("hidden","api_ap_pa",'',"form-control ",''," required ",'   '); ?>

							<input type="text" class="poppi" required name="ap_ma" id="ap_ma" placeholder="Apellido materno" >
							<?php create_input("hidden","api_ap_ma",'',"form-control ",''," required ",'   '); ?>


							
							<?php crearselect("id_especialidad","select id_especialidad, titulo  from especialidades where estado_idestado=1 order by orden desc ",'class="poppi " required',''," Selecciona tu especialidad "); ?>

							<?php // crearselect("id_escala_mag","select id_escala_mag, titulo  from escala_magisteriales where estado_idestado=1 order by titulo asc ",'class="poppi " required ',''," Selecciona tu escala magisterial "); ?>		

							<?php crearselect("id_tipo_cliente","select id_tipo_cliente, titulo  from tipo_clientes where estado_idestado=1 order by titulo asc ",'class="poppi " required ','',"  Eres docente nombrado ? "); ?>												
							
							<input type="text" class="poppi" required name="email" id="email" placeholder="Correo electrónico"  value="<?php echo !empty($data_magisterio[0]["email"])?$data_magisterio[0]["email"]:''; ?>">
													
							<input type="password" class="poppi" required name="clave" id="clave" placeholder="Crea tu propia contraseña">
						</fieldset>
                    </div> <!-- end * datos -->
							
					<script>	
						document.getElementById("field_client").disabled=true;
					</script>

                    <div class="final ">
											<fieldset class="rel text-center ">
												<input id="consentimiento" name="consentimiento" type="checkbox" class="acepta_politicas " required checked="checked" /><span>Acepto recibir mensajes promocionales sobre Educaauge.com</span>						
													<div class="g-recaptcha" data-sitekey="6LfUxLcdAAAAAHwBF9sOotrRnU1zOQpETNnSENXH"></div>
													<a id="finalizar" class="boton poppi-sb btn_finalizar_reniec " style="margin-top:20px;">Finalizar Registro</a>
													<div id='rptapago_2' class='hide poppi pagoespera ' >Procesando ...</div>
													<script src='https://www.google.com/recaptcha/api.js?hl=es'></script>
											
											
											<!-- 
											<a id="finalizar" class="boton poppi-sb" style="margin-top:30px;">Finalizar Registro</a>
											<div class='hide monset pagoespera ' id='rptapago'>Procesando ...</div>
											-->
											
											<!--  
											<p style="padding:35px 0 60px;">* Si tu DNI/CÉDULA ya figura como registrado por favor ingresa con tu otro correo, si no te acuerdas con qué correo te has registrado, coloca tu DNI / CÉDULA y te aparecerá tu correo correcto:  <a href="<?php echo $url; ?>" class="btn ">Click aquí</a> </br>
											
											</p>
											-->
											
											<p class="color4 poppi text-center" style="padding-top:25px;font-size: 16px;">¿Ya tienes una cuenta? <a  class="poppi-b llama_al_login color4 " style="color:#CA3A2B!important;">Iniciar sesión</a></p>


                    </div>


                </div>
            </div>
        </form></div></div>
    </div></div>
</main>
<?php


// include ('inc/footer.php'); 
include ('inc/footer_2.php'); 
?>
<script>
link='registrate_v2';

</script>
<script src="tw7control/js/buscar_reniec_reg_cliente_2023.js?ud=<?php echo $unix_date ; ?>"></script>

<?php } // end natural  ?> 