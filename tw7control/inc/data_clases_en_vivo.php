
<!-- Data Pedido principal... -->
                <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                  <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingOne">
                      <h4 class="panel-title">
                        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        PASO 1: Configuración   <small style="color:red;">*OBLIGATORIO</small>
                        </a>
                      </h4>
                    </div>
                    <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                      <div class="panel-body">
							<input type="hidden" name="tipo" value="<?php echo $_GET["tipo"];?>">
                <div class="form-group">
                  <label for="inputEmail3" class="col-md-2 col-sm-2 control-label">Estado Clase:</label>
                  <div class="col-sm-3">
                    <?php crearselect("estado_idestado","select * from estado where idestado in('1','2') order by 2 desc",'class="form-control"',$data_producto["estado_idestado"],""); ?>
                  </div>                 
                </div>
								<div class="form-group">
                  <label for="inputEmail3" class="col-md-2 col-sm-2 control-label">Curso</label>
                  <div class="col-sm-6">
                    <?php crearselect("id_curso","select id_curso, CONCAT(codigo,' - ',titulo) titulo_curso from cursos where estado_idestado=1 and (id_tipo !=0 and id_tipo !=2 and id_tipo !=3) order by codigo  asc",'class="form-control"',$data_producto["id_curso"],""); ?>
                  </div>                 
                </div>
								<div class="form-group">
                  <label for="inputPassword3" class="col-md-2 col-sm-2 control-label">Nombre del link (* URL) </label>
                  <div class="col-sm-6">
                    <?php create_input("text","titulo",$data_producto["titulo"],"form-control",$table,"",$agregado); ?>
										<label for="inputPassword3" class="co control-label"> <small style="color:red;">( ejem: auge.com/matematica ) * este nombre es único, no repetir</small></label>
                  </div>
                </div>
								
				<div class="form-group">
                  <label for="inputPassword3" class="col-md-2 col-sm-2 control-label">Fecha inicio: </label>
                  <div class="col-sm-6">
                    <?php create_input("date","fecha_inicio",$data_producto["fecha_inicio"],"form-control",$table,"",$agregado); ?>
                  </div>
                </div>
								
				<!-- 
								<div class="form-group">
                  <label for="inputPassword3" class="col-md-2 col-sm-2 control-label">Hora Inicio: </label>
                  <div class="col-sm-6">
										<input type="time" id="hora_inicio" name="hora_inicio" value="<?php echo $data_producto["hora_inicio"]; ?>" >
                  </div>
                </div>
								
				-->


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

				<!-- 
				<div class="form-group">
					<label for="inputPassword3" class="col-md-2 col-sm-2 control-label">Banner (1600px * 650px alto)</label>
					<div class="col-sm-6">
						<input type="file" name="banner" id="banner" class="form-control">
						<?php create_input("hidden","imagen_ant_banner",$data_producto["banner"],"",$table,$agregado); 
							if($data_producto["banner"]!=""){ 
						?>
							<img src="<?php echo "files/images/clases_en_vivos/".$data_producto["banner"]; ?>" width="200" class="mgt15">
						<?php } ?> 
					</div>
				</div>
							-->
				<div class="form-group">
					<label for="inputPassword3" class="col-md-2 col-sm-2 control-label">Ponente encargado: </label>
					<div class="col-sm-6">
						<?php create_input("text","encargado_webi",$data_producto["encargado_webi"],"form-control",$table,"",$agregado); ?>
					</div>
				</div>
				
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
					
				<?php  /* 
				<h3>Link externo:	</h3>
				<div class="form-group">
                  <label for="inputPassword3" class="col-md-2 col-sm-2 control-label">Frase de video  externo: </label>
                  <div class="col-sm-6">
                    <?php create_input("text","texto_link_externo",$data_producto["texto_link_externo"],"form-control",$table,"",$agregado); ?>
                  </div>
                </div>
								<div class="form-group">
                  <label for="inputPassword3" class="col-md-2 col-sm-2 control-label">Link video  externo: (* en vivo)</label>
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
                      <img src="<?php echo "files/images/clases_en_vivos/".$data_producto["imagen_3"]; ?>" width="200" class="mgt15">
                    <?php } ?> 
                  </div>
                </div>
				*/ ?>			

				
					
					<div class="form-group">
						<label for="inputPassword3" class="col-md-2 col-sm-2 control-label">Imágen Share (400px ancho * 400px alto )</label>
						<div class="col-sm-6">
							<input type="file" name="imagen" id="imagen" class="form-control">
							<?php create_input("hidden","imagen_ant",$data_producto["imagen"],"",$table,$agregado); 
								if($data_producto["imagen"]!=""){ 
							?>
								<img src="<?php echo "files/images/clases_en_vivos/".$data_producto["imagen"]; ?>" width="200" class="mgt15">
							<?php } ?> 
						</div>
					</div>		
					
					<?php 		/* 	
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
					*/	?>
							
							

							<?php /*
							<h3 style="padding-top:30px;">MARCA COMO FINALIZADO LA CLASE EN VIVO:</h3>								
										
							<div class="form-group">
								<label for="inputPassword3" class="col-md-3 col-sm-2 control-label">FINALIZO EL EN VIVO?</label>
								<div class="col-sm-6">
									<select id="acabo_webinar_en_vivo" name="acabo_webinar_en_vivo" class="form-control "    >  <!-- saco valor desde la BD -->
												<option value="2"  <?php echo ($data_producto['acabo_webinar_en_vivo'] == 2) ? 'selected' : '' ;?>>AUN EN VIVO</option>
												<option value="1" <?php echo ($data_producto['acabo_webinar_en_vivo'] == 1) ? 'selected' : '' ;?>>FINALIZO</option>  
									</select>
									<p style="color:red;">* Si permitira mostrar la carta corta de manera inmediata. </p>
								</div>
								
							</div>						
													
							<div class="form-group">
								<label for="inputPassword3" class="col-md-2 col-sm-2 control-label">TAG / ETIQUETA INFUSION SOFT:</label>
								<div class="col-sm-6">
									<?php create_input("text","etiqueta_infusion",$data_producto["etiqueta_infusion"],"form-control",$table,"",$agregado); ?>
								</div>
							</div>
							 */	?>
												
                      </div>
                    </div>
                  </div>