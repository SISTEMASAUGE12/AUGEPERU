
<?PHP 
$ajustes_mostrar_login=executesql(" select * from ajustes where mostrar_formularios_registro_en_banners=1 ");
if( !empty($ajustes_mostrar_login) && !isset($_SESSION["suscritos"]["id_suscrito"]) ){  /*  si esta activado mostrar formularios en banner  */ 
?>
<div class=" lleva_formulario_banner ">

	<form id="form-regis"  class="cotizar_index" method="post" enctype="multipart/form-data">
		<fieldset><div class="row text-left"  style="top:8px;">
			<!-- 
			<p class=" poppi-sb bold text-center _titulo_form_registro " style="">¡Recibe información, precios y becas!
				</br> <span  class="poppi " style="color:#333;font-weight:400;">Al enviar tu información, uno de nuestros asesores académicos te contactará.</span>
			</p>
		-->
			<p class=" poppi-sb   text-center  color2  _titulo_form_registro " style=""> Regístrate para más información</p>
			
			<?php 
			// PARA EL JS. DETERMINA SI SE MUESTRA LOS MENSAJE DE DATOS YA EXISTEN O NO; NO: PARA EL CASO DE TRAFICO, SI YA EXISTE NO REGISTRANOS PERO REDIRECCIONANMOS ALA LINK DE GRACIAS FALSO. 

			$link_wsp= "_";
			$tag_trafico= "_";
			$viene_desde= "banners";

			if( $pagina=="trafico"){
				$link_wsp= $curso[0]['link_grupo_wasap'];
				$tag_trafico= $curso[0]['tag_trafico'];
				$viene_desde= "trafico";
			}
			?>
			<div class="medium-6 columns">
				<input type="hidden" required name="viene_desde"  value="<?php echo $viene_desde; ?>" >
				<input type="hidden" required name="link_wsp"  value="<?php echo $link_wsp; ?>" >
				<input type="hidden" required name="tag_trafico"  value="<?php echo $tag_trafico; ?>" >
			</div>
			
			<!-- ** modificado reduccion __ -->
			<!-- 
			<p class="color1 poppi-sb" style="padding:15px 0;">Selecciona tu país: </p> 
		-->
			<div class="celu large-12 columns ">
				<div class="select-sim" id="select-color">
					<div class="options">			
			<?php 
				$paises=executesql("select * from paises order by id_pais asc ");  
				foreach($paises as $row){
			?>
						<div class="option">
							<input type="radio" name="id_pais" value="<?php echo $row["id_pais"];?>" <?php echo ($row["id_pais"]==1)?' checked ':'';?> id="color-<?php echo $row["id_pais"];?>"  />
							<label for="color-<?php echo $row["id_pais"];?>" class=" _selecciona_pais ">
								<img src="tw7control/files/images/paises/<?php echo $row["imagen"];?>">
								<span><?php echo $row["prefijo"];?></span>
							</label>
						</div>
			<?php 
				}
			?>
					</div>
				</div> <!-- end select sim -->
				<input type="text" required class="poppi telef_paises " name="telefono" id="telefono" onkeypress="javascript:return soloNumeros(event,0);"  placeholder="Número de celular" >
			</div> <!--  end class celu -->
						
			<div class=" div_dni_cliente_reniec rel large-12 columns  ">
				<!--
					 <label class="label_dni color1  poppi-sb control-label hide  ">Ingresa el DNI/cédula cliente: <small style="color:red;font-size:10px;"></small></label>
					 <label class="label_dni color1  poppi-sb control-label    ">  <small style="color:red;font-size:10px;"></small></label>
				-->
				<input type="text" class="poppi" required name="dni" id="dni" placeholder="Número de DNI/cédula" maxLength="8" minLength="8">
				<!-- <a class="  bg-blue btn-flat btn_buscar_dni  "  onclick="busque_cliente();">buscar</a> -->
				<?php create_input("hidden","api_dni",'',"form-control",''," required ",' required '); ?>
			</div>

			<fieldset id="field_client" >
				<div class="medium-6 columns">
					<input type="text" required name="nombre"  id="nombre" placeholder="Nombres">
					<?php create_input("hidden","api_nombre",'',"form-control ",''," required ",'   '); ?>

				</div>
				<div class="medium-6 columns">
					<input type="text" required name="ap_pa"  id="ap_pa" placeholder="Apellidos">
					<input type="hidden" required name="ap_ma"  id="ap_ma" placeholder="Apellidos">
					<?php create_input("hidden","api_ap_pa",'',"form-control ",''," required ",'   '); ?>		
					<?php create_input("hidden","api_ap_ma",'',"form-control ",''," required ",'   '); ?>


				</div>
			

				<div class="medium-12 columns">
					<input type="email" required name="email"  placeholder="Correo electrónico">
				</div>
				<div class="large-12 columns">									
					<?php crearselect("id_especialidad", "select id_especialidad,titulo from especialidades where estado_idestado=1 order by titulo asc", 'class="form-control" required ', '', "Selecciona tu especialidad"); ?>
				</div>
				<div class="large-12 columns">									
					<select name="id_tipo_cliente" id="id_tipo_cliente" class="form-control" required="">
						<option value="" STYLE="text-transform:uppercase;"> Selecciona tu condicion laboral </option>
						<option value="2">Contratado</option>
						<option value="1">Nombrado</option>
					</select>				
				</div>
			</fieldset>


			<div class="final ">
				<fieldset class="rel text-center ">
					<div class=" lleva_check text-left ">
						<input id="consentimiento" name="consentimiento" type="checkbox" class="acepta_politicas solo_marcar_un_check consentimiento_si " required    />
						<span style="color:#444;">Acepto las póliticas de privacidad y los términos y condiciones</span>	
					</div>
					<div  class=" lleva_check text-left " >
						<input id="consentimiento_no" name="consentimiento_no" type="checkbox" class="acepta_politicas solo_marcar_un_check  consentimiento_no "     />
						<span style="color:#444;">No Acepto</span>	
					</div>

					<div class="g-recaptcha text-center " data-sitekey="6LfUxLcdAAAAAHwBF9sOotrRnU1zOQpETNnSENXH"></div>
					<a id="finalizar_portada_leads" class="btn  poppi-sb  " style="margin-top:0;color:#fff;"> Enviar</a>
					
					<div id='rptapago_portada' class='hide  rptapago__ poppi pagoespera ' >Procesando ...</div>
					<script src='https://www.google.com/recaptcha/api.js?hl=es'></script>
				</fieldset>
			</div>
		</div></fieldset>
	</form>

<script>	
	// document.getElementById("field_client").disabled=true;

	let Checked = null;
	//The class name can vary
	for (let CheckBox of document.getElementsByClassName('solo_marcar_un_check')){
		CheckBox.onclick = function(){
			if(Checked!=null){
				Checked.checked = false;
				Checked = CheckBox;
			}
			Checked = CheckBox;
		}
	}



</script>
<script>
	link='registrate_v2';
</script>
<script src="tw7control/js/buscar_reniec_reg_cliente_2024_sin_validar.js?ud=<?php echo $unix_date ; ?>"></script>

</div>

<?php } // end execute ajustes:: mostrar_formularios_registro_en_banners ?>
