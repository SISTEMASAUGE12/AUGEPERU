
<!-- Data Pedido principal... -->
		<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
			<div class="panel panel-default">
					<div class="panel-heading" role="tab" id="headingOne">
						<h4 class="panel-title">
							<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
							PASO 1: Configuración Webinar y SEO  <small style="color:red;">*OBLIGATORIO</small>
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
								<div class="form-group">
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
								<?php /* 
								<div class="form-group">
                  <label for="inputPassword3" class="col-md-2 col-sm-2 control-label">Fecha Webinar: </label>
                  <div class="col-sm-6">
                    <?php create_input("date","fecha_inicio",$data_producto["fecha_inicio"],"form-control",$table,"",$agregado); ?>
                  </div>
                </div>
								
								<div class="form-group">
                  <label for="inputPassword3" class="col-md-2 col-sm-2 control-label">Hora Inicio: </label>
                  <div class="col-sm-6">
										<input type="time" id="hora_inicio" name="hora_inicio" value="<?php echo $data_producto["hora_inicio"]; ?>" >
                  </div>
                </div>
								
								<!-- 
								-->
								<h3 style="padding-top:30px;">Link de video principal: en el momento del webinar</h3>
								<div class="form-group">
                  <label for="inputPassword3" class="col-md-2 col-sm-2 control-label">Link video webinar vimeo (* en vivo):</label>
                  <div class="col-sm-6">
                    <?php create_input("text","link_video",$data_producto["link_video"],"form-control",$table,"",$agregado); ?>
                  </div>
                </div>
								<div class="form-group">
                  <label for="inputPassword3" class="col-md-2 col-sm-2 control-label">Link Chat vimeo:</label>
                  <div class="col-sm-6">
                    <?php create_input("text","link_chat",$data_producto["link_chat"],"form-control",$table,"",$agregado); ?>
                  </div>
                </div>
								
								<h3>Link externo:	</h3>
								<div class="form-group">
                  <label for="inputPassword3" class="col-md-2 col-sm-2 control-label">Frase de video webinar externo: </label>
                  <div class="col-sm-6">
                    <?php create_input("text","texto_link_externo",$data_producto["texto_link_externo"],"form-control",$table,"",$agregado); ?>
                  </div>
                </div>
								<div class="form-group">
                  <label for="inputPassword3" class="col-md-2 col-sm-2 control-label">Link video webinar externo: (* en vivo)</label>
                  <div class="col-sm-6">
                    <?php create_input("text","link_externo",$data_producto["link_externo"],"form-control",$table,"",$agregado); ?>
                  </div>
                </div>
								
								<div class="form-group">
                  <label for="inputPassword3" class="col-md-2 col-sm-2 control-label">Imágen para Video externo </br><small style="color:red;">716px ancho * 400px alto</small></label>
                  <div class="col-sm-6">
                    <input type="file" name="imagen_3" id="imagen_3" class="form-control">
                    <?php create_input("hidden","imagen_ant_3",$data_producto["imagen_3"],"",$table,$agregado); 
                      if($data_producto["imagen_3"]!=""){ 
                    ?>
                      <img src="<?php echo "files/images/webinars/".$data_producto["imagen_3"]; ?>" width="200" class="mgt15">
                    <?php } ?> 
                  </div>
                </div>
								

								<h3 style="padding-top:30px;">Boton principal acción: [+ info, algun link en especial]</h3>								
								<div class="form-group">
									<label for="inputPassword3" class="col-md-2 col-sm-2 control-label"> Titulo Boton acción: *btn rojo principal</label>
									<div class="col-sm-6">
										<?php create_input("text","titulo_boton_action",$data_producto["titulo_boton_action"],"form-control",$table,"",$agregado); ?>
									</div>
								</div>
								<div class="form-group">
									<label for="inputPassword3" class="col-md-2 col-sm-2 control-label">Link boton acción:</label>
									<div class="col-sm-6">
										<?php create_input("text","link_boton_action",$data_producto["link_boton_action"],"form-control",$table,"",$agregado); ?>
									</div>
								</div>

								*/ ?>
								<div class="form-group">
									<label for="inputPassword3" class="col-md-2 col-sm-2 control-label">Titulo SEO</label>
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
									<label for="inputPassword3" class="col-md-2 col-sm-2 control-label">TAG / ETIQUETA INFUSION SOFT:</label>
									<div class="col-sm-6">
										<?php create_input("text","etiqueta_infusion",$data_producto["etiqueta_infusion"],"form-control",$table,"",$agregado); ?>
									</div>
								</div>
								
								<div class="form-group">
									<label for="inputPassword3" class="col-md-2 col-sm-2 control-label">Link de grupo de whatsApp </label>
									<div class="col-sm-6">
										<?php create_input("text","gracias_link_wsp",$data_producto["gracias_link_wsp"],"form-control",$table,"",$agregado); ?>
									</div>
								</div>


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
                          PASO 2: Página inicial - Formulario de Registro. <small style="color:red;">*OBLIGATORIO</small>
                        </a>
                      </h4>
                    </div>
                    <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                      <div class="panel-body">
													<div class="form-group">
														<label for="inputPassword3" class="col-md-2 col-sm-2 control-label">Ante Título banner</label>
														<div class="col-sm-6">
															<?php create_input("text","ante_titulo",$data_producto["ante_titulo"],"form-control",$table,"",$agregado); ?>
														</div>
													</div>
													<div class="form-group">
														<label for="inputPassword3" class="col-md-2 col-sm-2 control-label">Título banner</label>
														<div class="col-sm-6">
															<?php create_input("text","titulo_1",$data_producto["titulo_1"],"form-control",$table,"",$agregado); ?>
														</div>
													</div>
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
														<label for="inputPassword3" class="col-md-2 col-sm-2 control-label">Banner 2(1600px * 650px alto)</label>
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
														<label for="inputPassword3" class="col-md-2 col-sm-2 control-label">Link vimeo *en registro </label>
														<div class="col-sm-6">
															<?php create_input("text","link_vimeo_formulario",$data_producto["link_vimeo_formulario"],"form-control",$table,"",$agregado); ?>
															<p>LInk resumen o invitando a registrarse en el webinar </p>
														</div>
													</div>
													
													<div class="form-group">
														<label for="inputPassword3" class="col-md-2 col-sm-2 control-label">imagen 1 (370px ancho * 340px alto)</label>
														<div class="col-sm-6">
															<input type="file" name="imagen_1" id="imagen_1" class="form-control">
															<?php create_input("hidden","imagen_ant_1",$data_producto["imagen_1"],"",$table,$agregado); 
																if($data_producto["imagen_1"]!=""){ 
															?>
																<img src="<?php echo "files/images/webinars/".$data_producto["imagen_1"]; ?>" width="200" class="mgt15">
															<?php } ?> 
														</div>
													</div>
													<!-- 
													<div class="form-group">
														<label for="inputPassword3" class="col-md-2 col-sm-2 control-label">SubTítulo banner</label>
														<div class="col-sm-6">
															<?php create_input("text","detalle_1",$data_producto["detalle_1"],"form-control",$table,"",$agregado); ?>
														</div>
													</div>
													-->
													
													<div class="form-group">
														<label for="inputPassword3" class="col-md-2 col-sm-2 control-label">Titulo del formulario</label>
														<div class="col-sm-6">
															<?php create_input("text","titulo_formulario",$data_producto["titulo_formulario"],"form-control",$table,"",$agregado); ?>
														</div>
													</div>

													<div class="form-group">
														<label for="inputPassword3" class="col-md-2 col-sm-2 control-label">Titulo del Boton formulario</label>
														<div class="col-sm-6">
															<?php create_input("text","boton_formulario",$data_producto["boton_formulario"],"form-control",$table,"",$agregado); ?>
														</div>
													</div>

													<div class="form-group">
														<label for="inputPassword3" class="col-md-2 col-sm-2 control-label">Etiqueta 1</label>
														<div class="col-sm-6">
															<?php create_input("text","etiqueta_registro_1",$data_producto["etiqueta_registro_1"],"form-control",$table,"",$agregado); ?>
														</div>
													</div>
													<div class="form-group">
														<label for="inputPassword3" class="col-md-2 col-sm-2 control-label">Etiqueta 2</label>
														<div class="col-sm-6">
															<?php create_input("text","etiqueta_registro_2",$data_producto["etiqueta_registro_2"],"form-control",$table,"",$agregado); ?>
														</div>
													</div>
													<div class="form-group">
														<label for="inputPassword3" class="col-md-2 col-sm-2 control-label">Fecha de inicio * en texto</label>
														<div class="col-sm-6">
															<?php create_input("text","fecha_en_texto",$data_producto["fecha_en_texto"],"form-control",$table,"",$agregado); ?>
														</div>
													</div>
													<div class="form-group">
														<label for="inputPassword3" class="col-md-2 col-sm-2 control-label">Hora de inicio *en texto</label>
														<div class="col-sm-6">
															<?php create_input("text","hora_en_texto",$data_producto["hora_en_texto"],"form-control",$table,"",$agregado); ?>
														</div>
													</div>
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
													
												---
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
														<label for="inputPassword3" class="col-md-2 col-sm-2 control-label">imagen final (700px ancho * 500px alto)</label>
														<div class="col-sm-6">
															<input type="file" name="imagen_2" id="imagen_2" class="form-control">
															<?php create_input("hidden","imagen_ant_2",$data_producto["imagen_2"],"",$table,$agregado); 
																if($data_producto["imagen_2"]!=""){ 
															?>
																<img src="<?php echo "files/images/webinars/".$data_producto["imagen_2"]; ?>" width="200" class="mgt15">
															<?php } ?> 
														</div>
													</div>
													
													
													<div class="form-group">
														<label for="inputPassword3" class="col-md-2 col-sm-2 control-label">Título boton PDF *incio </label>
														<div class="col-sm-6">
															<?php create_input("text","pdf_1_titulo",$data_producto["pdf_1_titulo"],"form-control",$table,"",$agregado); ?>
														</div>
													</div>
													
													<!-- 
													<div class="form-group">
														<label for="inputPassword3" class="col-md-2 col-sm-2 control-label">PDF 1:  (en registro)</label>
														<div class="col-sm-6">
															<input type="file" name="pdf_1" id="pdf_1" class="form-control">
															<?php create_input("hidden","imagen_ant_pdf_1",$data_producto["pdf_1"],"",$table,$agregado); 
																if($data_producto["pdf_1"]!=""){ 
															?>
																<a href="<?php echo "files/images/webinars/".$data_producto["pdf_1"]; ?>" target="_blank"> <img src="dist/img/icons/icon-pdf.jpg"> </a>
															<?php } ?> 
														</div>
													</div>
																-->
													
                      </div>
                    </div>
                  </div>
                
<!-- Data Gracias por registrarte ... -->                  
                  <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingThree">
                      <h4 class="panel-title">
                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                         PASO 3:  Datos Gracias por registrarte  <small style="color:red;">*OBLIGATORIO</small>
                        </a>
                      </h4>
                    </div>
                    <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                      <div class="panel-body">
													<div class="form-group">
														<label for="inputPassword3" class="col-md-2 col-sm-2 control-label">SubTítulo debajo de Gracias</label>
														<div class="col-sm-6">
															<?php create_input("text","titulo_gracias",$data_producto["titulo_gracias"],"form-control",$table,"",$agregado); ?>
														</div>
													</div>	
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
													<div class="form-group">
														<label for="inputPassword3" class="col-md-2 col-sm-2 control-label">Link video </label>
														<div class="col-sm-6">
															<?php create_input("text","link_gracias",$data_producto["link_gracias"],"form-control",$table,"",$agregado); ?>
															<p>LInk  video, agredeciendo el registrarse en el webinar e invitar a no faltar al inicio del webinar</p>

														</div>
													</div>
													
													<?php /* 
													<div class="form-group">
														<label for="inputPassword3" class="col-md-2 col-sm-2 control-label">Título boton PDF *gracias </label>
														<div class="col-sm-6">
															<?php create_input("text","pdf_2_titulo",$data_producto["pdf_2_titulo"],"form-control",$table,"",$agregado); ?>
														</div>
													</div>
													
													<div class="form-group">
														<label for="inputPassword3" class="col-md-2 col-sm-2 control-label">PDF 2:  (en gracias)</label>
														<div class="col-sm-6">
															<input type="file" name="pdf_2" id="pdf_2" class="form-control">
															<?php create_input("hidden","imagen_ant_pdf_2",$data_producto["pdf_2"],"",$table,$agregado); 
																if($data_producto["pdf_2"]!=""){ 
															?>
																<a href="<?php echo "files/images/webinars/".$data_producto["pdf_2"]; ?>" target="_blank"> <img src="dist/img/icons/icon-pdf.jpg"> </a>
															<?php } ?> 
														</div>
													</div>
													*/ ?>
													
                      </div>
                    </div>
                  </div>
									
<?php    /*           
<!-- Data Carta corta ... -->                  
                  <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="four">
                      <h4 class="panel-title">
                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse_four" aria-expanded="false" aria-controls="collapse_four">
                         PASO 4:  Datos Carta   - POST WEBINAR
                        </a>
                      </h4>
                    </div>
                    <div id="collapse_four" class="panel-collapse collapse" role="tabpanel" aria-labelledby="four">
                      <div class="panel-body">
													<div class="form-group">
														<label for="inputPassword3" class="col-md-2 col-sm-2 control-label">Título:</label>
														<div class="col-sm-6">
															<?php create_input("text","titulo_carta",$data_producto["titulo_carta"],"form-control",$table,"",$agregado); ?>
														</div>
													</div>	
													<div class="form-group">
														<label for="inputPassword3" class="col-md-2 col-sm-2 control-label">Imagen (700px ancho * 500px alto)</label>
														<div class="col-sm-6">
															<input type="file" name="imagen_carta" id="imagen_carta" class="form-control">
															<?php create_input("hidden","imagen_ant_carta",$data_producto["imagen_carta"],"",$table,$agregado); 
																if($data_producto["imagen_carta"]!=""){ 
															?>
																<img src="<?php echo "files/images/webinars/".$data_producto["imagen_carta"]; ?>" width="200" class="mgt15">
															<?php } ?> 
														</div>
													</div>
													<div class="form-group">
														<label for="inputPassword3" class="col-md-2 col-sm-2 control-label">Link video </label>
														<div class="col-sm-6">
															<?php create_input("text","link_carta",$data_producto["link_carta"],"form-control",$table,"",$agregado); ?>
															<p>Link resumen del webinar o el mismo link del webinar en vivo </p>
														</div>
													</div>
                      </div>
                    </div>
                  </div>
									
								               
<!-- Data Carta Larga  ... -->                  
                  <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="five_">
                      <h4 class="panel-title">
                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse_five_" aria-expanded="false" aria-controls="collapse_five_">
                         PASO 5: Datos Carta adicionales (larga) -POST WEBINAR 
                        </a>
                      </h4>
                    </div>
                    <div id="collapse_five_" class="panel-collapse collapse" role="tabpanel" aria-labelledby="five_">
                      <div class="panel-body">
												 <div class="form-group">
                          <label for="inputEmail3" class="col-sm-2 control-label">Activar  carta larga</label>
                          <div class="col-sm-8">
                            <select id="activar_carta_2" name="activar_carta_2" class="form-control">  <!-- saco valor desde la BD -->
                              <option value="2"  <?php echo ($data_producto['activar_carta_2'] == 2) ? 'selected' : '' ;?>>NO</option>
                              <option value="1" <?php echo ($data_producto['activar_carta_2'] == 1) ? 'selected' : '' ;?>>SI</option>  
                            </select>
                          </div>
                        </div>
													<div class="form-group">
														<label for="inputPassword3" class="col-md-2 col-sm-2 control-label">Link video vimeo carta larga:</label>
														<div class="col-sm-6">
															<?php create_input("text","link_carta_larga",$data_producto["link_carta_larga"],"form-control",$table,"",$agregado); ?>
															<p>Link video carta larga del webinar o el mismo link del webinar en vivo </p>

														</div>
													</div>	
													<div class="form-group">
														<label for="inputPassword3" class="col-md-2 col-sm-2 control-label">SubTítulo:</label>
														<div class="col-sm-6">
															<?php create_input("text","titulo_carta_2",$data_producto["titulo_carta_2"],"form-control",$table,"",$agregado); ?>
														</div>
													</div>	
													<div class="form-group">
														<label for="inputPassword3" class="col-md-2 col-sm-2 control-label">Imagen Carta larga (700px ancho * 500px alto)</label>
														<div class="col-sm-6">
															<input type="file" name="imagen_carta_2" id="imagen_carta_2" class="form-control">
															<?php create_input("hidden","imagen_ant_carta_2",$data_producto["imagen_carta_2"],"",$table,$agregado); 
																if($data_producto["imagen_carta_2"]!=""){ 
															?>
																<img src="<?php echo "files/images/webinars/".$data_producto["imagen_carta_2"]; ?>" width="200" class="mgt15">
															<?php } ?> 
														</div>
													</div>

												</div>	
                      </div>
                    </div>
										
										*/ ?>

		</div>
