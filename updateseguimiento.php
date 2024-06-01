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
if( isset($_GET["rewrite"])  && !empty($_GET["rewrite"]) &&  isset($_GET["rewrite2"])  && !empty($_GET["rewrite2"]) ){ 
	$sql="select * from solicitudes where id_suscrito='".$_GET["rewrite"]."' and ide='".$_GET["rewrite2"]."' ";
	
	// echo $sql;

	$data_suscrito=executesql($sql,0);
	if( !empty($data_suscrito) ){ 
?>	
	<form id="update_info_seguimiento" method="post">
		<div class="medium-6 medium-centered columns"><div class="confi">
				<div  class="poppi contiene_formuario input_left text-left ">
					<h3 class="poppi-b text-center " style="font-size: 20px!important;line-height: 30px!important;">
						ACTUALIZA Y VERIFICA TUS DATOS, PARA TU CERTIFICADO </br>
					</h3>
					<input type="hidden" name="id_certi_cliente" id="id_certi_cliente" required  value="<?php echo $_GET["rewrite"];?>" >
					<input type="hidden" name="ide_seguimiento" id="ide_seguimiento" required  value="<?php echo $_GET["rewrite2"];?>" >
					
					<div class="rel">
						<label>DNI o cédula</label>
						<input  type="hidden" name="dni" id="dni" required placeholder="Ingresa tu dni o cédula" value="<?php echo $data_suscrito["dni"];?>" onkeypress="javascript:return soloNumeros(event,0);" >
						<input name="dni_xxx" id="dni_xxx" required disabled placeholder="Ingresa tu dni o cédula" value="<?php echo $data_suscrito["dni"];?>" onkeypress="javascript:return soloNumeros(event,0);" >
					</div>

					<div class="rel">
						<label>Nombres completos</label>
						<!-- ** mostrar los xx para q no puedan editar y ocilyar los de arriba
						<input   type="hidden" name="api_nombre_editado" id="api_nombre_editado" required placeholder="Ingresa tu nombre completo" value="<?php echo $data_suscrito["api_nombre"];?>">
						<input name="api_nombre_editado_xxx" id="api_nombre_editado_xxx" required  disabled placeholder="Ingresa tu nombre completo" value="<?php echo $data_suscrito["api_nombre"];?>"> 
						-->

						<input    name="api_nombre_editado" id="api_nombre_editado" required placeholder="Ingresa tu nombre completo" value="<?php echo $data_suscrito["api_nombre"];?>">
					</div>
					
					<div class="rel">
						<label>Apellido paterno</label>
						<input   name="api_paterno_editado" id="api_paterno_editado" required placeholder="Ingresa tu Apellido paterno" value="<?php echo $data_suscrito["api_paterno"];?>">

						<input class="hide"  disabled name="api_paterno_editado_xxx" id="api_paterno_editado_xxx" required placeholder="Ingresa tu Apellido paterno" value="<?php echo $data_suscrito["api_paterno"];?>">
					</div>
					
					<div class="rel">
						<label>Apellido materno</label>
						<input  name="api_materno_editado" id="api_materno_editado" required placeholder="Ingresa tu Apellido Materno" value="<?php echo $data_suscrito["api_materno"];?>">
						
						<input class="hide" name="api_materno_editado" id="api_materno_editado" required  disabled placeholder="Ingresa tu Apellido Materno" value="<?php echo $data_suscrito["api_materno"];?>">
					
						<p style="padding-top:15px;color:#333;"> * si su nombre y apellido no coincide, comuniquese con nosotros. </p>

					</div>
					
					<?php /*
					<div class="  rel  ">
						<label class="poppi sub texto">Departamento</label>
						<?php crearselect("iddpto","select iddpto, titulo from dptos  order by titulo asc",'class="form-control" required onchange="javascript:display(this.value,\'cargar_prov\',\'idprvc\')"',$data_suscrito["iddpto"],"Seleccionar"); ?>

					</div>
					<div class="  rel  ">
						<label class="poppi sub texto">Provincia</label>						
						<?php 
							$sql = "select idprvc,titulo from prvc WHERE dptos_iddpto='" . $data_suscrito["iddpto"] . "' "; ?>
							<select name="idprvc" id="idprvc" class="form-control"
							onchange="javascript:display('updateseguimiento.php',this.value,'cargar_dist','iddist')">
							<option value="" >-- Prov. --</option>
							<?php $listaprov = executesql($sql);
									foreach ($listaprov as $data) { ?>
											<option value="<?php echo $data['idprvc']; ?>"
											<?php echo ($data['idprvc'] == $data_suscrito["idprvc"]) ? 'selected' : ''; ?> > <?php echo $data['titulo'] ?></option>
											<?php } ?>
							</select>
						<?php  ?>												
					</div>


					<div class="   rel  ">
						<label class="poppi sub texto">Distrito</label>
						<?php 
						$sql = "select iddist,titulo from dist WHERE prvc_idprvc='" . $data_suscrito["idprvc"] . "' "; ?>
						<select name="iddist" id="iddist" class="form-control">
								<option value="" >-- Prov. --</option>
								<?php
								$listaprov = executesql($sql);
								foreach ($listaprov as $data) { ?>
										<option value="<?php echo $data['iddist']; ?>"
														<?php echo ($data['iddist'] == $data_suscrito["iddist"]) ? 'selected' : ''; ?> > <?php echo $data['titulo'] ?></option>
								<?php } ?>
						</select>
					</div>
						

					<div class="rel hide ">
						<label>Dirección envio</label>
						<input name="direccion" id="direccion" required placeholder="Ingresa tu dirección de envio" value="<?php echo $data_suscrito["direccion"];?>">
					</div>
					
					<div class="rel">
						<label>Agencia de envio</label>
						<!-- <input name="agencia" id="agencia" required placeholder="Ingresa tu agencia " value="<?php echo $data_suscrito["agencia"];?>"> -->
						<?php crearselect("id_agencia", "select id_agencia,nombre from agencias where estado_idestado=1 order by nombre asc", 'class="form-control" requerid  onchange="javascript:display(\'updateseguimiento.php\',this.value,\'cargar_sucursales\',\'id_sucursal\')"', $data_suscrito["id_agencia"], "-- Agencia de envio --"); ?>

					</div>
					
					<div class="rel">
						<label>Seleccione la sucursal</label>
						<?php
						 if( !empty($data_suscrito["id_agencia"])  ){  
							$sql="select id_sucursal, concat(nombre,' - ',direccion) as nombre from agencias_sucursales WHERE id_agencia='".$data_suscrito["id_agencia"]."' "; ?>
							<select name="id_sucursal" id="id_sucursal" required class="form-control" >
								<option value="" selected="selected">-- sucursal --</option>
								<?php 
										$listaprov=executesql($sql);
										foreach($listaprov as $data){ ?>
									<option value="<?php echo $data['id_sucursal']; ?>" selected="<?php echo ($data['id_sucursal']==$data_suscrito["id_sucursal"])?'selected':'';?>"> <?php echo $data['nombre']?></option>
										<?php } ?>
							</select>

						<?php }else{ ?> 
							<select name="id_sucursal" id="id_sucursal"  required class="form-control" ><option value="" selected="selected">-- sucursal. --</option></select>
						<?php } ?> 

						<p style="color:red;">* si en caso no encuentra su agencia de destino,  comunicarse con nuestros asesores.  </p>
					</div>
					*/ ?>
					
					<button id="btn_actualizar_datos_registro" class="btn_2  bold " style="margin-top:30px;">ACTUALIZAR DATOS</button>
				</div>
				<!--
				<div class='hide monset pagoespera ' id='rptapago'>Procesando ...</div>
					-->
				<div class="hide" id="registroInfo" >Procesando ...</div>
				<div class="hide" id="registroSuccess" >Gracias, datos actualizados .</div>
				<div class="hide" id="registroError" >Lo sentimos se perdio la conexion con el servidor ...</div>
				
				<p class="poppi color1 text-center">Estimado docente EducaAuge solicita la actualización de tus datos para tu certificado.</p>
			</form>
		</div></div>
		
		
<?php 
	}else{
		/*  sino existe la solicitud, quieren gacer fraude o hackear ma ipulando la URL / */	
?>

		<div class="medium-6 medium-centered columns"><div class="confi">
			<div class="poppi contiene_formuario text-center ">
				<h3 class="poppi-b">ENLACE NO VALIDO -.-	</h3>
				<a href="<?php echo $url; ?>" class="btn_2  bold ">volver al inicio</a>
			</div>				
		</div></div>

<?php 
	}  

}else{ ?>		
		<div class="medium-6 medium-centered columns"><div class="confi">
			<div class="poppi contiene_formuario text-center ">
				<h3 class="poppi-b">ENLACE NO VALIDO	</h3>
				<a href="<?php echo $url; ?>" class="btn_2  bold ">volver al inicio</a>
			</div>				
		</div></div>
<?php } ?>		

	</div></div></div>
</main>
<?php include ('inc/footer_2.php'); ?>