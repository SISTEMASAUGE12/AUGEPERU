
<!-- Data Pedido principal... -->
                <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                  <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingOne">
                      <h4 class="panel-title">
                        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        PASO 0: Configuración y SEO  <small style="color:red;">*OBLIGATORIO</small>
                        </a>
                      </h4>
                    </div>
                    <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                      <div class="panel-body">
																					<input type="hidden" name="tipo" value="<?php echo $_GET["tipo"];?>">
                <div class="form-group">
                  <label for="inputEmail3" class="col-md-2 col-sm-2 control-label">Estado</label>
                  <div class="col-sm-3">
                    <?php crearselect("estado_idestado","select * from estado where idestado in('1','2') order by 2 desc",'class="form-control"',$data_producto["estado_idestado"],""); ?>
                  </div>                 
                </div>
								<div class="form-groupc hiden hide " >
                  <label for="inputEmail3" class="col-md-2 col-sm-2 control-label">Curso</label>
                  <div class="col-sm-6">
                    <?php crearselect("id_curso","select id_curso, CONCAT(codigo,' - ',titulo) titulo_curso from cursos where estado_idestado=1 and id_tipo_curso=1 and (id_tipo !=0 and id_tipo !=2 and id_tipo !=3) order by codigo  asc",'class="form-control"',$data_producto["id_curso"],""); ?>
                  </div>                 
                </div>
								<div class="form-group">
                  <label for="inputPassword3" class="col-md-2 col-sm-2 control-label">Nombre del link webinar (* URL) </label>
                  <div class="col-sm-6">
                    <?php create_input("text","titulo",$data_producto["titulo"],"form-control",$table,"",$agregado); ?>
										<label for="inputPassword3" class="co control-label"> <small style="color:red;">( ejem: auge.com/matematica ) * este nombre es único, no repetir</small></label>
                  </div>
                </div>
			

							<div class="form-group">		
								<label for="inputPassword3" class="col-md-2 col-sm-2 control-label">Etiqueta Titulo SEO</label>
								<div class="col-sm-6">
									<?php create_input("text","titulo_seo",$data_producto["titulo_seo"],"form-control",$table,"",$agregado); ?>
								</div>
							</div>
							
							<div class="form-group">
								<label for="inputPassword3" class="col-md-2 col-sm-2 control-label">Imágen Share (400px ancho * 400px alto )</label>
								<div class="col-sm-6">
									<input type="file" name="imagen" id="imagen" class="form-control">
									<?php create_input("hidden","imagen_ant",$data_producto["imagen"],"",$table,$agregado); 
										if($data_producto["imagen"]!=""){ 
									?>
										<img src="<?php echo "files/images/webinars/".$data_producto["imagen"]; ?>" width="200" class="mgt15">
									<?php } ?> 
								</div>
							</div>		


							<div class="form-group">
								<label for="inputPassword3" class="col-md-2 col-sm-2 control-label"> Color fondo Etiqueta:</label>
								<div class="col-sm-6">
									<?php create_input("text","color_fondo_boton_link",$data_producto["color_fondo_boton_link"],"form-control color-picker",$table," ",' maxlength="7" size="7"'); ?>
								</div>
							</div>
							
							<div class="form-group">
								<label for="inputPassword3" class="col-md-2 col-sm-2 control-label"> Color texto Etiqueta:</label>
								<div class="col-sm-6">
									<?php create_input("text","color_boton_link",$data_producto["color_boton_link"],"form-control color-picker",$table," ",' maxlength="7" size="7"'); ?>

								</div>
							</div>
							<div class="form-group">
								<label for="inputPassword3" class="col-md-2 col-sm-2 control-label">Texto Etiqueta 1:</label>
								<div class="col-sm-6">
									<?php create_input("text","etiqueta_registro_1",$data_producto["etiqueta_registro_1"],"form-control color-picker",$table," ",''); ?>

								</div>
							</div>

							<div class="form-group">
								<label for="inputPassword3" class="col-md-2 col-sm-2 control-label">TAG / ETIQUETA INFUSION SOFT:</label>
								<div class="col-sm-6">
									<?php create_input("text","etiqueta_infusion",$data_producto["etiqueta_infusion"],"form-control",$table,"",$agregado); ?>
								</div>
							</div>

							<h3 style="padding-top:30px;">Boton principal acción: [+ info, algun link en especial]</h3>								
								<div class="form-group">
									<label for="inputPassword3" class="col-md-2 col-sm-2 control-label"> Titulo Boton acción: </label>
									<div class="col-sm-10">
										<?php create_input("text","titulo_boton_action",$data_producto["titulo_boton_action"],"form-control",$table,"",$agregado); ?>
									</div>
								</div>
								<div class="form-group hiden hide ">
									<label for="inputPassword3" class="col-md-2 col-sm-2 control-label">Link boton acción:</label>
									<div class="col-sm-10">
										<?php create_input("text","link_boton_action",$data_producto["link_boton_action"],"form-control",$table,"",$agregado); ?>
									</div>
								</div>

								<p>*Call to action casi al final de la pagina: </p>
								<div class="form-group">
									<label for="inputPassword3" class="col-md-2 col-sm-2 control-label"> Frase arriba del boton 2 alterno Boton acción: </label>
									<div class="col-sm-10">
										<?php create_input("text","titulo_boton_action_2",$data_producto["titulo_boton_action_2"],"form-control",$table,"",$agregado); ?>
									</div>
								</div>								
								<div class="form-group">
									<label for="inputPassword3" class="col-md-2 col-sm-2 control-label"> Titulo 2 alterno Boton acción: </label>
									<div class="col-sm-10">
										<?php create_input("text","titulo_boton_action_3",$data_producto["titulo_boton_action_3"],"form-control",$table,"",$agregado); ?>
									</div>
								</div>
								
							<?php /*	
							<h3 style="padding-top:30px;">Boton adicional: para grupo telegram, whatsApp, facebook, etc</h3>		
							<div class="form-group">
								<label for="inputPassword3" class="col-md-2 col-sm-2 control-label">Titulo de boton</label>
								<div class="col-sm-6">
									<?php create_input("text","titulo_boton_link",$data_producto["titulo_boton_link"],"form-control",$table,"",$agregado); ?>
								</div>
							</div>
							<div class="form-group">
								<label for="inputPassword3" class="col-md-2 col-sm-2 control-label">Link de boton </label>
								<div class="col-sm-6">
									<?php create_input("text","link_boton_2",$data_producto["link_boton_2"],"form-control",$table,"",$agregado); ?>
								</div>
							</div>
							*/ ?> 

					<?php /* 
							<h3 style="padding-top:30px;">MARCA COMO FINALIZADO EL  WEBINAR EN VIVO:</h3>								
							<div class="form-group">
								<label for="inputPassword3" class="col-md-3 col-sm-2 control-label">FINALIZO EL WEBIANR EN VIVO?</label>
								<div class="col-sm-6">
									<select id="acabo_webinar_en_vivo" name="acabo_webinar_en_vivo" class="form-control "    >  <!-- saco valor desde la BD -->
												<option value="2"  <?php echo ($data_producto['acabo_webinar_en_vivo'] == 2) ? 'selected' : '' ;?>>AUN EN VIVO</option>
												<option value="1" <?php echo ($data_producto['acabo_webinar_en_vivo'] == 1) ? 'selected' : '' ;?>>FINALIZO</option>  
									</select>
									<p style="color:red;">* Si permitira mostrar la carta corta de manera inmediata. </p>
								</div>
							</div>						
					*/ ?>						
												
                      </div>
                    </div>
                  </div>
<!-- Data detalle pedido... -->                  
                  <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingTwo">
                      <h4 class="panel-title">
                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                          PASO 1: Página inicial - Formulario de Registro. <small style="color:red;">*OBLIGATORIO</small>
                        </a>
                      </h4>
                    </div>
                    <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                      <div class="panel-body">

														<div class="form-group">
															<label for="inputPassword3" class="col-md-2 col-sm-2 control-label">Banner (1600px * 650px alto)</label>
															<div class="col-sm-6">
																<input type="file" name="banner" id="banner" class="form-control">
																<?php create_input("hidden","imagen_ant_banner",$data_producto["banner"],"",$table,$agregado); 
																	if($data_producto["banner"]!=""){ 
																		?>
																	<img src="<?php echo "files/images/webinars/".$data_producto["banner"]; ?>" width="200" class="mgt15">
																	<?php } ?> 
															</div>
														</div>

													<div class="form-group">
														<label for="inputPassword3" class="col-md-2 col-sm-2 control-label">Título banner</label>
														<div class="col-sm-10">
															<?php create_input("textarea","titulo_1",$data_producto["titulo_1"],"form-control",$table,"",$agregado); ?>
															<script>
																var editor11_titulo_1 = CKEDITOR.replace('titulo_1');
																CKFinder.setupCKEditor( editor11_titulo_1, 'ckfinder/' );
															</script> 
														</div>
													</div>

													<div class="form-group">
														<label for="inputPassword3" class="col-md-2 col-sm-2 control-label">Texto en caja banner</label>
														<div class="col-sm-10">
															<?php create_input("textarea","detalle_1",$data_producto["detalle_1"],"form-control",$table,"",$agregado); ?>
															<script>
																var editor11_caja_1 = CKEDITOR.replace('detalle_1');
																CKFinder.setupCKEditor( editor11_caja_1, 'ckfinder/' );
															</script> 
														</div>
													</div>

													<div class="form-group">
														<label for="inputPassword3" class="col-md-2 col-sm-2 control-label">imagen 1 (400px ancho * 240px alto)</label>
														<div class="col-sm-6">
															<input type="file" name="imagen_1" id="imagen_1" class="form-control">
															<?php create_input("hidden","imagen_ant_1",$data_producto["imagen_1"],"",$table,$agregado); 
																if($data_producto["imagen_1"]!=""){ 
																	?>
																<img src="<?php echo "files/images/webinars/".$data_producto["imagen_1"]; ?>" width="200" class="mgt15">
																<?php } ?> 
															</div>
														</div>
														
			

													<h3 style="font-size:27px;line-height:37px;padding-bottom:30px;"><b>Callout 1 <small>breve detalle</small></b></h3>
													<div class="form-group">
														<label for="inputPassword3" class="col-md-2 col-sm-2 control-label">imagen  callout_1 Pc(900px ancho * 300px alto)</label>
														<div class="col-sm-6">
															<input type="file" name="img_callout_1" id="img_callout_1" class="form-control">
															<?php create_input("hidden","imagen_ant_img_callout_1",$data_producto["img_callout_1"],"",$table,$agregado); 
																if($data_producto["img_callout_1"]!=""){ 
															?>
																<img src="<?php echo "files/images/webinars/".$data_producto["img_callout_1"]; ?>" width="200" class="mgt15">
															<?php } ?> 
														</div>
													</div>

													<div class="form-group">
														<label for="inputPassword3" class="col-md-2 col-sm-2 control-label">imagen  callout_1 mobil(310px ancho * 630px alto o + )</label>
														<div class="col-sm-6">
															<input type="file" name="img_callout_1_m" id="img_callout_1_m" class="form-control">
															<?php create_input("hidden","imagen_ant_img_callout_1_m",$data_producto["img_callout_1_m"],"",$table,$agregado); 
																if($data_producto["img_callout_1_m"]!=""){ 
															?>
																<img src="<?php echo "files/images/webinars/".$data_producto["img_callout_1_m"]; ?>" width="200" class="mgt15">
															<?php } ?> 
														</div>
													</div>
													</hr>

													<h3 style="font-size:27px;line-height:37px;padding-bottom:30px;"><b>Callout 2  <small>Breve intro </small></b></h3>
													<div class="form-group">
														<label for="inputPassword3" class="col-md-2 col-sm-2 control-label">Título cuerpo</label>
														<div class="col-sm-6">
															<?php create_input("text","titulo_2",$data_producto["titulo_2"],"form-control",$table,"",$agregado); ?>
														</div>
													</div>

													<div class="form-group">
														<label for="inputPassword3" class="col-sm-2 control-label">Breve Descripción</label>
														<div class="col-sm-10">
															<?php create_input("textarea","detalle_2",$data_producto["detalle_2"],'  ',$table,'style="height:650px!important;"');  ?>
															<script>
															var editor11 = CKEDITOR.replace('detalle_2');
															CKFinder.setupCKEditor( editor11, 'ckfinder/' );
															</script> 
														</div>
													</div>
													
													<div class="form-group">
														<label for="inputPassword3" class="col-md-2 col-sm-2 control-label">imagen callout 2 (367px ancho * 346px alto)</label>
														<div class="col-sm-6">
															<input type="file" name="imagen_2" id="imagen_2" class="form-control">
															<?php create_input("hidden","imagen_ant_2",$data_producto["imagen_2"],"",$table,$agregado); 
																if($data_producto["imagen_2"]!=""){ 
															?>
																<img src="<?php echo "files/images/webinars/".$data_producto["imagen_2"]; ?>" width="200" class="mgt15">
															<?php } ?> 
														</div>
													</div>
													
													<h3 style="font-size:27px;line-height:37px;padding-bottom:30px;"><b>Callout 3 <small> + numeros, cifras </small></b></h3>
													<div class="form-group">
														<label for="inputPassword3" class="col-md-2 col-sm-2 control-label">imagen  callout_3 PC (960px ancho * 190px alto)</label>
														<div class="col-sm-6">
															<input type="file" name="img_callout_3" id="img_callout_3" class="form-control">
															<?php create_input("hidden","imagen_ant_img_callout_3",$data_producto["img_callout_3"],"",$table,$agregado);  
																if($data_producto["img_callout_3"]!=""){ 
															?>
																<img src="<?php echo "files/images/webinars/".$data_producto["img_callout_3"]; ?>" width="200" class="mgt15">
															<?php } ?> 
														</div>
													</div>

													<div class="form-group">
														<label for="inputPassword3" class="col-md-2 col-sm-2 control-label">imagen  callout_3 mobil(300px ancho * 320px alto)</label>
														<div class="col-sm-6">
															<input type="file" name="img_callout_3_m" id="img_callout_3_m" class="form-control">
															<?php create_input("hidden","imagen_ant_img_callout_3_m",$data_producto["img_callout_3_m"],"",$table,$agregado); 
																if($data_producto["img_callout_3_m"]!=""){ 
															?>
																<img src="<?php echo "files/images/webinars/".$data_producto["img_callout_3_m"]; ?>" width="200" class="mgt15">
															<?php } ?> 
														</div>
													</div>
													
													<div class="form-group">
														<label for="inputPassword3" class="col-md-2 col-sm-2 control-label">Texto debajo de imagen</label>
														<div class="col-sm-10">
															<?php create_input("text","callout_3_texto_1",$data_producto["callout_3_texto_1"],"form-control",$table,"",$agregado); ?>
														</div>
													</div>

													<div class="form-group">
														<label for="inputPassword3" class="col-md-2 col-sm-2 control-label">Texto en caja </label>
														<div class="col-sm-10">
															<?php create_input("text","callout_3_texto_2",$data_producto["callout_3_texto_2"],"form-control",$table,"",$agregado); ?>
														</div>
													</div>
													<!-- end callout -3 -->

													<h3 style="font-size:27px;line-height:37px;padding-bottom:30px;"><b>Callout 4 <small>Que vas a descubrir</small></b></h3>
													<div class="form-group">
														<label for="inputPassword3" class="col-md-2 col-sm-2 control-label">imagen  callout_4 izquierda (530px ancho * 510px alto)</label>
														<div class="col-sm-6">
															<input type="file" name="img_callout_4" id="img_callout_4" class="form-control">
															<?php create_input("hidden","imagen_ant_img_callout_4",$data_producto["img_callout_4"],"",$table,$agregado);  
																if($data_producto["img_callout_4"]!=""){ 
															?>
																<img src="<?php echo "files/images/webinars/".$data_producto["img_callout_4"]; ?>" width="200" class="mgt15">
															<?php } ?> 
														</div>
													</div>

													<div class="form-group">
														<label for="inputPassword3" class="col-md-2 col-sm-2 control-label">imagen  callout_4 derecha (530px ancho * 510px alto)</label>
														<div class="col-sm-6">
															<input type="file" name="img_callout_4_2" id="img_callout_4_2" class="form-control">
															<?php create_input("hidden","imagen_ant_img_callout_4_2",$data_producto["img_callout_4_2"],"",$table,$agregado); 
																if($data_producto["img_callout_4_2"]!=""){ 
															?>
																<img src="<?php echo "files/images/webinars/".$data_producto["img_callout_4_2"]; ?>" width="200" class="mgt15">
															<?php } ?> 
														</div>
													</div>
													
													<div class="form-group">
														<label for="inputPassword3" class="col-md-2 col-sm-2 control-label">Titulo </label>
														<div class="col-sm-10">
															<?php create_input("text","callout_4_texto_1",$data_producto["callout_4_texto_1"],"form-control",$table,"",$agregado); ?>
														</div>
													</div>

													</hr><!-- end callout-4 -->

													<h3 style="font-size:27px;line-height:37px;padding-bottom:30px;"><b>Callout 5 <small>Fecha y hora del evento</small></b></h3>
													<div class="form-group">
														<label for="inputPassword3" class="col-md-2 col-sm-2 control-label">Titulo </label>
														<div class="col-sm-10">
															<?php create_input("text","callout_5_texto_1",$data_producto["callout_5_texto_1"],"form-control",$table,"",$agregado); ?>
														</div>
													</div>
													<div class="form-group">
														<label for="inputPassword3" class="col-md-2 col-sm-2 control-label">Frase debajo del Titulo </label>
														<div class="col-sm-10">
															<?php create_input("text","callout_5_texto_2",$data_producto["callout_5_texto_2"],"form-control",$table,"",$agregado); ?>
														</div>
													</div>

													<div class="form-group">
														<label for="inputPassword3" class="col-md-2 col-sm-2 control-label">imagen  callout_5 izquierda (300px ancho * 120px alto)</label>
														<div class="col-sm-6">
															<input type="file" name="img_callout_5" id="img_callout_5" class="form-control">
															<?php create_input("hidden","imagen_ant_img_callout_5",$data_producto["img_callout_5"],"",$table,$agregado);  
																if($data_producto["img_callout_5"]!=""){ 
															?>
																<img src="<?php echo "files/images/webinars/".$data_producto["img_callout_5"]; ?>" width="200" class="mgt15">
															<?php } ?> 
														</div>
													</div>

													<div class="form-group">
														<label for="inputPassword3" class="col-md-2 col-sm-2 control-label">imagen  callout_5 derecha (300px ancho * 120px alto)</label>
														<div class="col-sm-6">
															<input type="file" name="img_callout_5_2" id="img_callout_5_2" class="form-control">
															<?php create_input("hidden","imagen_ant_img_callout_5_2",$data_producto["img_callout_5_2"],"",$table,$agregado); 
																if($data_producto["img_callout_5_2"]!=""){ 
															?>
																<img src="<?php echo "files/images/webinars/".$data_producto["img_callout_5_2"]; ?>" width="200" class="mgt15">
															<?php } ?> 
														</div>
													</div>
													</hr><!-- end callout-5 -->
												
													
													<h3 style="font-size:27px;line-height:37px;padding-bottom:30px;"><b>Callout 6 <small>Entrenadores / expositores</small></b></h3>
													<div class="form-group">
														<label for="inputPassword3" class="col-md-2 col-sm-2 control-label">Titulo </label>
														<div class="col-sm-10">
															<?php create_input("text","callout_6_texto_1",$data_producto["callout_6_texto_1"],"form-control",$table,"",$agregado); ?>
														</div>
													</div>
													<div class="form-group">
														<label for="inputPassword3" class="col-md-2 col-sm-2 control-label">Frase debajo del Titulo </label>
														<div class="col-sm-10">
															<?php create_input("text","callout_6_texto_2",$data_producto["callout_6_texto_2"],"form-control",$table,"",$agregado); ?>
														</div>
													</div>
													<?php /* 
													<div class="form-group">
														<label for="inputPassword3" class="col-md-2 col-sm-2 control-label">Ponente encargado: </label>
														<div class="col-sm-6">
															<?php create_input("text","encargado_webi",$data_producto["encargado_webi"],"form-control",$table,"",$agregado); ?>
														</div>
													</div>
													<div class="form-group">
														<label for="inputPassword3" class="col-md-2 col-sm-2 control-label">imagen ponente (120px ancho * 120px alto)</label>
														<div class="col-sm-6">
															<input type="file" name="imagen_ponente" id="imagen_ponente" class="form-control">
															<?php create_input("hidden","ant_imagen_ponente",$data_producto["imagen_ponente"],"",$table,$agregado); 
																if($data_producto["imagen_ponente"]!=""){ 
															?>
																<img src="<?php echo "files/images/webinars/".$data_producto["imagen_ponente"]; ?>" width="200" class="mgt15">
															<?php } ?> 
														</div>
													</div>
*/ ?> 

													</hr><!-- end callout-6 -->
												
													
													<h3 style="font-size:27px;line-height:37px;padding-bottom:30px;"><b>Callout 7 <small>Que va recibir del evento</small></b></h3>
													<div class="form-group">
														<label for="inputPassword3" class="col-md-2 col-sm-2 control-label">Titulo </label>
														<div class="col-sm-10">
															<?php create_input("text","callout_7_texto_1",$data_producto["callout_7_texto_1"],"form-control",$table,"",$agregado); ?>
														</div>
													</div>
													<div class="form-group">
														<label for="inputPassword3" class="col-md-2 col-sm-2 control-label">Frase debajo del Titulo </label>
														<div class="col-sm-10">
															<?php create_input("text","callout_7_texto_2",$data_producto["callout_7_texto_2"],"form-control",$table,"",$agregado); ?>
														</div>
													</div>

													<div class="form-group">
														<label for="inputPassword3" class="col-md-2 col-sm-2 control-label">imagen  callout_7 PC ( 930px ancho * opcional alto)</label>
														<div class="col-sm-6">
															<input type="file" name="img_callout_7" id="img_callout_7" class="form-control">
															<?php create_input("hidden","imagen_ant_img_callout_7",$data_producto["img_callout_7"],"",$table,$agregado);  
																if($data_producto["img_callout_7"]!=""){ 
															?>
																<img src="<?php echo "files/images/webinars/".$data_producto["img_callout_7"]; ?>" width="200" class="mgt15">
															<?php } ?> 
														</div>
													</div>

													<div class="form-group">
														<label for="inputPassword3" class="col-md-2 col-sm-2 control-label">imagen  callout_7 movil (360px ancho * opcional alto)</label>
														<div class="col-sm-6">
															<input type="file" name="img_callout_7_2" id="img_callout_7_2" class="form-control">
															<?php create_input("hidden","imagen_ant_img_callout_7_2",$data_producto["img_callout_7_2"],"",$table,$agregado); 
																if($data_producto["img_callout_7_2"]!=""){ 
															?>
																<img src="<?php echo "files/images/webinars/".$data_producto["img_callout_7_2"]; ?>" width="200" class="mgt15">
															<?php } ?> 
														</div>
													</div>
													<!-- end call 7 -->

													<h3 style="font-size:27px;line-height:37px;padding-bottom:30px;"><b>Callout 8: <small>Precios</small> </b></h3>
													<div class="form-group">
														<label for="inputPassword3" class="col-md-2 col-sm-2 control-label">Titulo </label>
														<div class="col-sm-10">
															<?php create_input("text","callout_8_texto_1",$data_producto["callout_8_texto_1"],"form-control",$table,"",$agregado); ?>
														</div>
													</div>
													<div class="form-group">
														<label for="inputPassword3" class="col-md-2 col-sm-2 control-label">Frase debajo del Titulo </label>
														<div class="col-sm-10">
															<?php create_input("text","callout_8_texto_2",$data_producto["callout_8_texto_2"],"form-control",$table,"",$agregado); ?>
														</div>
													</div>

													<div class="form-group">
														<label for="inputPassword3" class="col-md-2 col-sm-2 control-label">imagen  callout_8 PC ( 880px ancho * 550px alto)</label>
														<div class="col-sm-6">
															<input type="file" name="img_callout_8" id="img_callout_8" class="form-control">
															<?php create_input("hidden","imagen_ant_img_callout_8",$data_producto["img_callout_8"],"",$table,$agregado);  
																if($data_producto["img_callout_8"]!=""){ 
															?>
																<img src="<?php echo "files/images/webinars/".$data_producto["img_callout_8"]; ?>" width="200" class="mgt15">
															<?php } ?> 
														</div>
													</div>
													
													<div class="form-group">
														<label for="inputPassword3" class="col-md-2 col-sm-2 control-label">Texto frase arriba de los botones  </label>
														<div class="col-sm-10">
															<?php create_input("text","callout_8_texto_3",$data_producto["callout_8_texto_3"],"form-control",$table,"",$agregado); ?>
														</div>
													</div>

													<div class="form-group">
														<label for="inputPassword3" class="col-md-2 col-sm-2 control-label">Texto boton Gratis  </label>
														<div class="col-sm-10">
															<?php create_input("text","callout_8_texto_4",$data_producto["callout_8_texto_4"],"form-control",$table,"",$agregado); ?>
														</div>
													</div>
													<div class="form-group">
														<label for="inputPassword3" class="col-md-2 col-sm-2 control-label">imagen  callout_8 movil - arriba de boton gratis (300px ancho * 500px alto)</label>
														<div class="col-sm-6">
															<input type="file" name="img_callout_8_m_1" id="img_callout_8_m_1" class="form-control">
															<?php create_input("hidden","imagen_ant_img_callout_8_m_1",$data_producto["img_callout_8_m_1"],"",$table,$agregado); 
																if($data_producto["img_callout_8_m_1"]!=""){ 
															?>
																<img src="<?php echo "files/images/webinars/".$data_producto["img_callout_8_m_1"]; ?>" width="200" class="mgt15">
															<?php } ?> 
														</div>
													</div>

													<div class="form-group">
														<label for="inputPassword3" class="col-md-2 col-sm-2 control-label">Texto boton con PRECIO  </label>
														<div class="col-sm-10">
															<?php create_input("text","callout_8_texto_5",$data_producto["callout_8_texto_5"],"form-control",$table,"",$agregado); ?>
														</div>
													</div>
													<div class="form-group">
														<label for="inputPassword3" class="col-md-2 col-sm-2 control-label">LINK boton con PRECIO  </label>
														<div class="col-sm-10">
															<?php create_input("text","callout_8_texto_6",$data_producto["callout_8_texto_6"],"form-control",$table,"",$agregado); ?>
														</div>
													</div>
													<div class="form-group">
														<label for="inputPassword3" class="col-md-2 col-sm-2 control-label">imagen  callout_8 movil - arriba de boton precio (300px ancho * 500px alto)</label>
														<div class="col-sm-6">
															<input type="file" name="img_callout_8_m_2" id="img_callout_8_m_2" class="form-control">
															<?php create_input("hidden","imagen_ant_img_callout_8_m_2",$data_producto["img_callout_8_m_2"],"",$table,$agregado); 
																if($data_producto["img_callout_8_m_2"]!=""){ 
															?>
																<img src="<?php echo "files/images/webinars/".$data_producto["img_callout_8_m_2"]; ?>" width="200" class="mgt15">
															<?php } ?> 
														</div>
													</div>
													<!--  end call 8 -->

													
                      </div>
                    </div>
                  </div>
                
<!-- Data Gracias por registrarte ... -->                  
                  <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingThree">
                      <h4 class="panel-title">
                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                         PASO 2:  Datos Gracias por registrarte  <small style="color:red;">*OBLIGATORIO</small>
                        </a>
                      </h4>
                    </div>
                    <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                      <div class="panel-body">

													
												<div class="form-group">
													<label for="inputPassword3" class="col-md-2 col-sm-2 control-label">Banner Gracias(1600px * 650px alto)</label>
													<div class="col-sm-6">
														<input type="file" name="banner_2" id="banner_2" class="form-control">
														<?php create_input("hidden","imagen_ant_banner_2",$data_producto["banner_2"],"",$table,$agregado); 
														if($data_producto["banner_2"]!=""){ 
															?>
														<img src="<?php echo "files/images/webinars/".$data_producto["banner_2"]; ?>" width="200" class="mgt15">
														<?php } ?> 
													</div>
												</div>
																										
													<div class="form-group">
														<label for="inputPassword3" class="col-md-2 col-sm-2 control-label">Titulo </label>
														<div class="col-sm-6">
															<?php create_input("text","titulo_gracias",$data_producto["titulo_gracias"],"form-control",$table,"",$agregado); ?>
														</div>
													</div>	
													<?php /*
													<div class="form-group">
														<label for="inputPassword3" class="col-md-2 col-sm-2 control-label">Imagen (700px ancho * 500px alto)</label>
														<div class="col-sm-6">
															<input type="file" name="imagen_gracias" id="imagen_gracias" class="form-control">
															<?php create_input("hidden","imagen_ant_gracias",$data_producto["imagen_gracias"],"",$table,$agregado); 
																if($data_producto["imagen_gracias"]!=""){ 
															?>
																<img src="<?php echo "files/images/webinars/".$data_producto["imagen_gracias"]; ?>" width="200" class="mgt15">
															<?php } ?> 
														</div>
													</div>
													*/ ?> 
													
									
													<div class="form-group">
														<label for="inputPassword3" class="col-md-2 col-sm-2 control-label">Link de grupo de whatsApp </label>
														<div class="col-sm-6">
															<?php create_input("text","gracias_link_wsp",$data_producto["gracias_link_wsp"],"form-control",$table,"",$agregado); ?>
														</div>
													</div>
									
													<div class="form-group">
														<label for="inputPassword3" class="col-md-2 col-sm-2 control-label"># whatsapp texto</label>
														<div class="col-sm-6">
															<?php create_input("text","gracias_cel",$data_producto["gracias_cel"],"form-control",$table,"",$agregado); ?>
														</div>
													</div>
									
													<div class="form-group">
														<label for="inputPassword3" class="col-md-2 col-sm-2 control-label">Email de contacto </label>
														<div class="col-sm-6">
															<?php create_input("text","gracias_email",$data_producto["gracias_email"],"form-control",$table,"",$agregado); ?>
														</div>
													</div>
													
													
													
                      </div>
                    </div>
                  </div>
									
								               

									

									
									
                </div>
