<?php 
$pagina='registro';
include('auten.php');
$meta = array(
    'title' => 'Completa el Registro | Educa Auge .com',
    'description' => ''
);
include ('inc/header-registro.php');

if ( isset($_SESSION["suscritos"]["id_suscrito"])) {

$data_suscrito=executesql("select * from suscritos where id_suscrito='".$_SESSION["suscritos"]["id_suscrito"]."' ",0);
// como ya se registro, cnosulta con id_suscrito y jala los datos que ya tiene.
	if(!empty($data_suscrito)){

?>
<main id="registro" class="maina">
    <div class="callout callout-1"><div class="row row2">
        <div class="large-6 medium-6 columns nothing"><img class="img-r" src="img/registro.jpg"></div>
        <div class="large-6 medium-6 columns"><div class="centrar"><form id="form-regis">
						<h3 class="color5 text-center poppi-sb" style="font-size:30px;line-height:38px;">Para poder ofrecerte el mejores servicios, necesitamos que ingreses los siguientes datos</h3>
						
						<div id="cuerpo1" style="display:none;">
                <div class="numer">
                    <div class="numero roboto activo">1</div>
                    <div class="borde"><div class="linea"></div></div>
                    <div class="numero roboto">2</div>
                    <div class="borde"><div class="linea"></div></div>
                    <div class="numero roboto">3</div>
                    <div class="borde"><div class="linea"></div></div>
                    <div class="numero roboto">4</div>
                </div>
                <div class="form">
                    <p class="color1 poppi-sb">Tus datos personales</p>
                    <div class="datos">
                        <fieldset><input type="text" class="poppi" name="ap_pa" id="ap_pa" placeholder="Apellido paterno" value="<?php echo $data_suscrito["ap_pa"]; ?>"></fieldset>
                        <fieldset><input type="text" class="poppi" name="ap_ma" id="ap_ma" placeholder="Apellido materno" value="<?php echo $data_suscrito["ap_ma"]; ?>"></fieldset>
                        <!-- * esto esta en  registro corto modificado
												<fieldset><input type="text" class="poppi" name="dni" id="dni" onkeypress="javascript:return soloNumeros(event,0);" value="<?php echo $data_suscrito["dni"]; ?>" placeholder="Número de DNI"></fieldset>
												-->
                    </div>
                    <a id="siguiente1" class="boton poppi-sb">Enviar datos</a>
                </div>
            </div>
            <div id="cuerpo2" style="display:none;">
                <div class="numer">
                    <div class="numero roboto activo">1</div>
                    <div class="borde"><div class="linea activo"></div></div>
                    <div class="numero roboto activo">2</div>
                    <div class="borde"><div class="linea"></div></div>
                    <div class="numero roboto">3</div>
                    <div class="borde"><div class="linea"></div></div>
                    <div class="numero roboto">4</div>
                </div>
                <div class="form">
                    <p class="color1 poppi-sb">Tus datos de contacto</p>
                    <div class="datos">
                       
                    </div>
                    <a id="siguiente2" class="boton poppi-sb">Enviar datos</a>
                </div>
            </div>
            <div id="cuerpo3" style="display:none;">
                <div class="numer">
                    <div class="numero roboto activo">1</div>
                    <div class="borde"><div class="linea activo"></div></div>
                    <div class="numero roboto activo">2</div>
                    <div class="borde"><div class="linea activo"></div></div>
                    <div class="numero roboto activo">3</div>
                    <div class="borde"><div class="linea"></div></div>
                    <div class="numero roboto">4</div>
                </div>
                <div class="form">
                    <p class="color1 poppi-sb">Tu profesión</p>
                    <div class="datos">
										<!--
                        <fieldset><select class="poppi" name="especialidad" id="especialidad">
                            <option value="">Selecciona tu especialidad</option>
                            <option value="1">Especialidad 1</option>
                        </select></fieldset>
                        <fieldset><select class="poppi" name="escala" id="escala">
                            <option value="">Selecciona tu escala magisterial</option>
                            <option value="1">Escala 1</option>
                        </select></fieldset>
										-->

										
												<fieldset><?php crearselect("id_escala_mag","select id_escala_mag, titulo  from escala_magisteriales where estado_idestado=1 order by titulo asc ",'class="poppi "',$data_suscrito["id_escala_mag"]," Selecciona tu escala magisterial "); ?></fieldset>


                    </div>
                    <a id="siguiente3" class="boton poppi-sb">Enviar datos</a>
                </div>
            </div>
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
									
										<div style="display:none;" >
												<fieldset><?php crearselect("id_pais_2","select id_pais, nombre  from paises where estado_idestado=1 order by nombre asc ",'class="poppi "',$data_suscrito["id_pais"]," Pais "); ?></fieldset>
												<fieldset><input type="text" class="poppi" name="ciudad" id="ciudad" placeholder="Ciudad" value="<?php echo $data_suscrito["ciudad"]; ?>"></fieldset>
												<fieldset><input type="text" class="poppi" name="direccion" id="direccion" value="<?php echo $data_suscrito["direccion"]; ?>" placeholder="Dirección"></fieldset>
												
										</div>
										<!-- 
												-->
												
												
												<!-- ** modificado reduccion __ -->
												<fieldset><input type="text" class="poppi" name="nombre" id="nombre" placeholder="Nombres" value="<?php echo $data_suscrito["nombre"]; ?>" ></fieldset>
												
												<!-- 
												<fieldset><input type="text" class="poppi" name="dni" id="dni" maxlength="8" onkeypress="javascript:return soloNumeros(event,0);" value="<?php echo $data_suscrito["dni"]; ?>" placeholder="Número de DNI/cédula"></fieldset>
												-->
												<fieldset><input type="text" class="poppi" name="dni" id="dni"  value="<?php echo $data_suscrito["dni"]; ?>" placeholder="Número de DNI/cédula"></fieldset>
												
												
												<fieldset><?php crearselect("id_especialidad","select id_especialidad, titulo  from especialidades where estado_idestado=1 order by orden desc ",'class="poppi "',$data_suscrito["id_especialidad"]," Selecciona tu especialidad "); ?></fieldset>

												<p class="color1 poppi-sb" style="padding:15px 0;">Selecciona tu país: </p>
                        <fieldset class="celu">
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
                            </div>
                            <input type="text" class="poppi" name="telefono" id="telefono" onkeypress="javascript:return soloNumeros(event,0);" value="<?php echo $data_suscrito["telefono"]; ?>" placeholder="Número de celular">
                        </fieldset>
                        <fieldset <?php  !empty($data_suscrito["email"])?'style="opacity: 0;"':''; ?> ><input type="text" class="poppi" name="email" id="email" value="<?php echo $data_suscrito["email"]; ?>" placeholder="Correo electrónico"></fieldset>
												

                    </div>

                    <a id="finalizar" class="boton poppi-sb" style="margin-top:30px;">Finalizar Registro</a>

										<div class='hide monset pagoespera ' id='rptapago'>Procesando ...</div>
										
										<p style="padding:35px 0 60px;">* Si tu DNI/CÉDULA ya figura como registrado por favor ingresa con tu otro correo, si no te acuerdas con qué correo te has registrado, coloca tu DNI / CÉDULA y te aparecerá tu correo correcto:  <a href="<?php echo $url; ?>" class="btn ">Click aquí</a> </br>
										<!--
										Si tu problema persiste envía un correo a <span class="solor-1"><a href="mailto:informes@educaauge.com"><b>informes@educaauge.com</b></a></span>  </br> 
										con el <b>Asunto: Problema Registro DNI [tu dni] </b>
										-->
										</p>


                </div>
            </div>
        </form></div></div>
    </div></div>
</main>
<?php
	} // si existe data suscrito registrada
} //if sesion suscrito

include ('inc/footer.php'); 
?>