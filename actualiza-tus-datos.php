<?php include('auten.php'); 
$pagina='registro';

$meta = array(
    'title' => 'Actualiza tus datos | EducaAuge.com',
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

include ('inc/header-actualiza-datos.php');
//hola
?>

<main id="registro">
	<div class="callout banners callout-1"><div class="fondo fondo-claro "><div class="row">
<?php 
// if(isset($_GET["rewrite"])  && !empty($_GET["rewrite"]) && !empty($_SESSION["suscritos"]["id_suscrito"]) ){ 

if( isset($_GET["rewrite"])  && !empty($_GET["rewrite"])  ){ 
	$sql="select * from suscritos where id_suscrito='".$_GET["rewrite"]."' ";
	
	// echo $sql;

	$data_suscrito=executesql($sql,0);
?>	
	<form id="ingresa_tus_datos" method="post">
		<div class="medium-6 medium-centered columns"><div class="confi">
				<div  class="poppi contiene_formuario input_left text-left ">
					<h3 class="poppi-b text-center ">INGRESA TUS DATOS</h3>
					<div class="rel">
						<label>País</label>
						<div class="celu">
							<div class="select-sim" id="select-color">
								<div class="options">
							<?php $paises=executesql("select * from paises order by id_pais asc ");  
							foreach($paises as $row){
							?>
									<div class="option">
										<input type="radio" name="id_pais" value="<?php echo $row["id_pais"];?>" <?php echo ($row["id_pais"]==$data_suscrito["id_pais"])?' checked ':'';?> id="color-<?php echo $row["id_pais"];?>"  />
										<label for="color-<?php echo $row["id_pais"];?>">
											<img src="tw7control/files/images/paises/<?php echo $row["imagen"];?>">
											<span><?php echo $row["prefijo"];?></span>
										</label>
									</div>
								<?php } ?>
								</div>
							</div>
							<input class="poppi telefono " required name="telefono" id="telefono" onkeypress="javascript:return soloNumeros(event,0);" value="<?php echo substr($data_suscrito["telefono"],-9); ?>" placeholder="Número de celular">
						</div>
					</div>
					
					<div class=" div_dni_cliente_reniec rel  ">
						<label class="label_dni color1  poppi-sb control-label ">Ingresa el DNI/cédula cliente: <small style="color:red;font-size:10px;"></small></label>
						<input type="text" class="poppi" required name="dni" id="dni" disabled  value="<?php echo $data_suscrito["dni"];?>" placeholder="Número de DNI/cédula" maxLength="8" minLength="8">
						<a class="btn bg-blue btn-flat btn_buscar_dni  "  onclick="buscar_dni_reniec(<?php echo $data_suscrito['dni']; ?>); ">buscar</a> <!--  directo a consultar con reniec -->
						<?php create_input("hidden","api_dni",$data_suscrito['dni'],"form-control",''," required ",' required '); ?>
					</div>
					
					
					<fieldset id="field_client" >
						<div class="rel">
							<label>Nombres completos</label>
							<input name="nombre" id="nombre" required disabled placeholder="Ingresa tu nombre completo" value="<?php echo $data_suscrito["nombre"];?>">
							<?php create_input("hidden","id_suscrito",$data_suscrito["id_suscrito"],"form-control ",''," required ",'   '); ?>
							<?php create_input("hidden","api_nombre",$data_suscrito["nombre"],"form-control ",''," required ",'   '); ?>
							
						</div>
						
						<div class="rel">
							<label>Apellido paterno</label> 
							<input name="ap_pa" id="ap_pa" required disabled placeholder="Ingresa tu Apellido paterno" value="<?php echo $data_suscrito["ap_pa"];?>">
							<?php create_input("hidden","api_ap_pa",$data_suscrito["ap_pa"],"form-control ",''," required ",'   '); ?>
						</div>
						
						<div class="rel">
							<label>Apellido materno</label>
							<input name="ap_ma" id="ap_ma" required  disabled placeholder="Ingresa tu Apellido Materno" value="<?php echo $data_suscrito["ap_ma"];?>">
							<?php create_input("hidden","api_ap_ma",$data_suscrito["ap_ma"],"form-control ",''," required ",'   '); ?>
						</div>
						
						<div class="rel">
							<label>Email</label>
							<input type="hidden"  name="email_origen" id="email_origen"  placeholder="email origen antes de que intente cambiar " value="<?php echo $data_suscrito["email"];?>">
							<input  type="hidden" name="email" id="email" required   placeholder="Ingresa tu email " value="<?php echo $data_suscrito["email"];?>">
							<input  type="email" name="email_ver" id="email_ver" required disabled  placeholder="Ingresa tu email " value="<?php echo $data_suscrito["email"];?>">
						</div>
						
						<div class="rel">
							<label>Especialidad</label>
							<?php crearselect("id_especialidad","select id_especialidad, titulo  from especialidades where estado_idestado=1 order by orden desc ",'class="poppi "',$data_suscrito["id_especialidad"]," Selecciona tu especialidad "); ?>
						</div>
						
						<div class="rel">
							<label>Escala Magisterial</label>
							<?php crearselect("id_escala_mag","select id_escala_mag, titulo  from escala_magisteriales where estado_idestado=1 order by orden desc ",'class="poppi "',$data_suscrito["id_escala_mag"]," Selecciona tu escala "); ?>
						</div>		
														
						<div class="rel">
							<label>Seleciona si eres docente Nombrado o no:</label>
							<?php 							
							crearselect("id_tipo_cliente","select id_tipo_cliente, titulo  from tipo_clientes where estado_idestado=1 order by titulo asc ",'class="poppi " required ',$data_suscrito["id_tipo_cliente"],"  Eres docente nombrado ? "); ?>
						</div>									
						
						<div class="rel">
							<label style="padding-top:25px;">Contraseña</label>
							<input name="clave" id="clave" type="password" class="clave" required placeholder="Crea tu propia contraseña " >
						</div>
						
						<div class="rel">
							<label>Repite la Contraseña</label>
							<input name="clave2" id="clave2" type="password" class="clave" required placeholder="Repite la contraseña " >
						</div>
					</fieldset>				
					<button id="btn_actualizar_datos_registro" class="btn_2  bold  btn_finalizar_reniec " style="margin-top:30px;">ACTUALIZAR DATOS</button>
				</div>			
				<div class="hide" id="registroInfo" >Procesando ...</div>
				<div class="hide" id="registroSuccess" >Gracias, datos actualizados .</div>
				<div class="hide" id="registroError" >Lo sentimos se perdio la conexion con el servidor ...</div>
				<div class="hide" id="registroYaexiste">Correo de Usuario ya registrado...</div>
				<div class="hide" id="registroGmail">Debes ingresar un correo @gmail.com </div>
				
				<p class="poppi color1 text-center">Estimado docente EducaAuge solicita la actualización de tus datos.</p>
			</div></div>
		</form>
		
		
<?php 
}else{ ?>		
		<div class="medium-6 medium-centered columns"><div class="confi">
				<div class="poppi contiene_formuario text-center ">
					<h3 class="poppi-b">REGÍSTRATE	</h3>
					<label>Ingresa tu dni/cédula o correo</label>
					<input name="data" id="data" required placeholder="Ingresa tu dni/cédula o correo">
					<button id="consultar_datos_registro" class="btn_2  bold ">CONSULTAR</button>
				</div>
				<!-- 
				<p class="poppi color1 text-center">Estimado docente EducaAuge solicita la actualización de tus datos.</p>
				-->
				<div class='hide monset pagoespera ' id='rptapago_1'>Procesando ...</div>
		</div></div>
<?php } ?>		

	</div></div></div>
</main>
<?php include ('inc/footer_2.php'); ?>

<script>
link='actualiza-tus-datos';

</script>
<script src="tw7control/js/buscar_reniec_reg_cliente_2023.js?ud=<?php echo $unix_date ; ?>"></script>

<?php } // end natural  ?> 