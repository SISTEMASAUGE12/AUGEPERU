<?php include('auten.php'); 
$pagina='registro';

$meta = array(
    'title' => 'Actualiza tus datos | EducaAuge.com',
    'description' => ''
);
include ('inc/header-actualiza-datos.php');
//hola
?>

<main id="registro">
	<div class="callout banners callout-1"><div class="fondo fondo-claro "><div class="row">
<?php 
if(isset($_GET["rewrite"])  && !empty($_GET["rewrite"]) && !empty($_SESSION["suscritos"]["id_suscrito"]) ){ 
	$sql="select * from suscritos where id_suscrito='".$_SESSION["suscritos"]["id_suscrito"]."' ";
	
	// echo $sql;

	$data_suscrito=executesql($sql,0);
?>	
	<form id="ingresa_tus_datos" method="post">
		<div class="medium-6 medium-centered columns"><div class="confi">
				<div  class="poppi contiene_formuario input_left text-left ">
					<h3 class="poppi-b text-center ">INGRESA TUS DATOS</h3>
					<div class="rel">
						<label>DNI o cédula</label>
						<input name="dni" id="dni" required placeholder="Ingresa tu dni o cédula" value="<?php echo $data_suscrito["dni"];?>" onkeypress="javascript:return soloNumeros(event,0);" >
					</div>

					<div class="rel">
						<label>Nombres completos</label>
						<input name="nombre" id="nombre" required placeholder="Ingresa tu nombre completo" value="<?php echo $data_suscrito["nombre"];?>">
					</div>
					
					<div class="rel">
						<label>Apellido paterno</label>
						<input name="ap_pa" id="ap_pa" required placeholder="Ingresa tu Apellido paterno" value="<?php echo $data_suscrito["ap_pa"];?>">
					</div>
					
					<div class="rel">
						<label>Apellido materno</label>
						<input name="ap_ma" id="ap_ma" required placeholder="Ingresa tu Apellido Materno" value="<?php echo $data_suscrito["ap_ma"];?>">
					</div>
					
					<div class="rel">
						<label>Email</label>
						<input type="hidden"  name="email_origen" id="email_origen"  placeholder="email origen antes de que intente cambiar " value="<?php echo $data_suscrito["email"];?>">
						<input  type="email" name="email" id="email" required placeholder="Ingresa tu email " value="<?php echo $data_suscrito["email"];?>">
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
							<input class="poppi telefono " required name="telefono" id="telefono" onkeypress="javascript:return soloNumeros(event,0);" value="<?php echo $data_suscrito["telefono"]; ?>" placeholder="Número de celular">
						</div>
					</div>
					
					<div class="rel">
						<label style="padding-top:25px;">Contraseña</label>
						<input name="clave" id="clave" type="password" class="clave" required placeholder="Crea tu propia contraseña " >
					</div>
					
					<div class="rel">
						<label>Repite la Contraseña</label>
						<input name="clave2" id="clave2" type="password" class="clave" required placeholder="Repite la contraseña " >
					</div>
					
					
					<button id="btn_actualizar_datos_registro" class="btn_2  bold " style="margin-top:30px;">ACTUALIZAR DATOS</button>
				</div>
				<!--
				<div class='hide monset pagoespera ' id='rptapago'>Procesando ...</div>
					-->
				<div class="hide" id="registroInfo" >Procesando ...</div>
				<div class="hide" id="registroSuccess" >Gracias, datos actualizados .</div>
				<div class="hide" id="registroError" >Lo sentimos se perdio la conexion con el servidor ...</div>
				<div class="hide" id="registroYaexiste">Correo de Usuario ya registrado...</div>
				<div class="hide" id="registroGmail">Debes ingresar un correo @gmail.com </div>
				
				<p class="poppi color1 text-center">Estimado docente EducaAuge solicita la actualización de tus datos.</p>
			</form>
		</div></div>
		
		
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