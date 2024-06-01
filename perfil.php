<?php include('auten.php');
if(!isset($_SESSION["suscritos"]["id_suscrito"])){ header('Location: '.$url); }
$pagina='perfil';
$meta = array(
    'title' => 'Auge: Perfil',
    'description' => ''
);
if(isset($_GET['task']) && ($_GET['task']=='mis-cursos') && isset($_GET['task2']) && !empty($_GET['task2'])){
    include ('inc/header-perfil-curso.php');
}elseif(isset($_GET['task']) && ($_GET['task']=='examenes') && isset($_GET['task2']) && !empty($_GET['task2'])){
    $pagina='examen';
    // include ('inc/header-examen.php');
    include ('inc/header.php');
}else{
    include ('inc/header.php');
}

/* Lo movi al auten.php */
// $suscri = executesql("SELECT s.*, e.titulo FROM suscritos s INNER JOIN especialidades e ON s.id_especialidad = e.id_especialidad WHERE s.id_suscrito = '".$_SESSION['suscritos']['id_suscrito']."' ");
?>

<main id="perfil"  class=" <?php if(isset($_SESSION["suscritos"]["id_suscrito"]) && !empty($_SESSION["suscritos"]["id_suscrito"])){ echo "logeado"; }?> <?php if(isset($_GET["task"]) && ($_GET["task"]=='mis-cursos')){ echo "logeado2"; }?> ">
<!-- Si ven el curso detalle en el perfil -->

<?php 
if(isset($_GET["task"]) && $_GET["task"]=='uestado_clase'){
	$bd = new BD;
	$bd->Begin();
	$ide = !isset($_GET['id_detalle']) ? $_GET['id_detalle'] : $_GET['id_detalle'];
	$ide = is_array($ide) ? implode(',',$ide) : $ide;
	$usuario = executesql("SELECT estado_fin FROM avance_de_cursos_clases WHERE id_detalle IN (".$ide.")  and id_suscrito='".$_SESSION["suscritos"]["id_suscrito"]."' ");
	if(!empty($usuario)) foreach($usuario as $reg => $item)
		if($item['estado_fin']==2) {
			$state = 1;
		}
		$num_afect=$bd->actualiza_("UPDATE avance_de_cursos_clases SET estado_fin=".$state." WHERE id_detalle=".$ide." and id_suscrito='".$_SESSION["suscritos"]["id_suscrito"]."'  ");
		echo $state;
		$bd->Commit();
		$bd->close();

// Mis cursos : ** _detalle_curso
}elseif(isset($_GET['task']) && ($_GET['task']=='mis-cursos') && isset($_GET['task2']) && !empty($_GET['task2'])){

// marcar clase como finalizada ..
	include('detalle_clase_cursos_perfil.php');
	
// Mis cursos : ** _detalle_curso
}elseif(isset($_GET['task']) && ($_GET['task']=='examenes') && isset($_GET['task2']) && !empty($_GET['task2'])){

// marcar clase como finalizada ..
    include('examen_listado_desarollo.php');

// perfil global
}else{ // sino hay task4
?>
    <div class="callout callout-1"><div class="row <?php echo ($_GET['task']=='examenes') ? '' : 'row3 row-docen' ?>">
    	<?php if($_GET['task']!='examenes'){ ?>
        <div class="large- large-2 medium-4 columns nothing menu_del_perfil ">
            <ul class="accordion" data-accordion>
				<!-- 
                <li class="accordion-item nod <?php echo (isset($_GET['task']) && $_GET['task']=='mis-datos') ? 'is-active' : '' ?>" data-accordion-item>
                    <a href="perfil/mis-datos" class="accordion-title poppi-b">Mi perfil</a>
                </li>
		-->
                <li class="accordion-item nod <?php echo (isset($_GET['task']) && $_GET['task']=='mis-pedidos') ? 'is-active' : '' ?>" data-accordion-item>
                    <a href="perfil/mis-pedidos" class="accordion-title poppi-b">Mis compras</a>
                </li>
                <li class="accordion-item nod <?php echo (isset($_GET['task']) && $_GET['task']=='mis-cursos') ? 'is-active' : '' ?>" data-accordion-item>
                    <a href="mis-cursos" class="accordion-title poppi-b">Mis cursos</a>
                </li>
				<li class="accordion-item nod <?php echo (isset($_GET['task']) && $_GET['task']=='mis-cursos') ? 'is-active' : '' ?>" data-accordion-item>
                    <a href="mis-libros" class="accordion-title poppi-b">Mis Libros</a>
                </li>
            </ul>
            <ul class="accordion" data-accordion>
                <li class="accordion-item nod  <?php echo (isset($_GET['task']) && $_GET['task']=='certificados') ? 'is-active' : '' ?>" data-accordion-item>
                    <a href="certificados" class="accordion-title poppi-b">Certificados</a>
                </li>
                <li class="accordion-item nod <?php echo (isset($_GET['task']) && $_GET['task']=='actualizar-clave') ? 'is-active' : '' ?>" data-accordion-item>
					<a href="perfil/actualizar-clave" class="accordion-title poppi-b">Clave de acceso</a>
				</li>		
				<!-- 
				<li class="accordion-item nod  <?php echo (isset($_GET['task']) && $_GET['task']=='tutoriales') ? 'is-active' : '' ?>" data-accordion-item>
					<a href="perfil/tutoriales" class="accordion-title poppi-b">Aprende a Usar tu aula Virtual</a>
				</li>
				-->
                <li class="accordion-item nod <?php echo (isset($_GET['task']) && $_GET['task']=='actualizar-clave') ? 'is-active' : '' ?>" data-accordion-item>
					<a href="perfil/examenes" class="accordion-title poppi-b">Examenes</a>
				</li>
            </ul>
        </div>

	<?php } ?>

        <div class="<?php echo ($_GET['task']=='examenes')? 'large-12' : 'large-9 large-10 medium-8' ?> columns content_perfil ">
<?php  if( isset($_GET['task']) &&  $_GET['task'] != 'certificados' &&  $_GET['task'] != 'tutoriales'){ ?>
					<div class="" <?php echo $_GET['task']=='examenes' ? 'style="display:none"' : '' ?>>
            <h1 class="poppi-b color1"> <?php echo !empty($suscri[0]['nombre'])? $suscri[0]['nombre'].' '.$suscri[0]['ap_pa'].' '.$suscri[0]['ap_ma'] :' Completa tus datos ..'; ?></h1>
						
			<?php 
			// if( empty($suscri[0]['ap_pa']) || empty($suscri[0]['ap_ma'])  || empty($suscri[0]['direccion']) || empty($suscri[0]['ciudad'])  || empty($suscri[0]['dni'])  || empty($suscri[0]['telefono'])  ){ 
			if( empty($suscri[0]['ap_pa']) || empty($suscri[0]['ap_ma'])  || empty($suscri[0]['dni'])  || empty($suscri[0]['telefono'])  ){ 
			?>
					<!-- <a href="perfil/mis-datos" style="position: absolute;right: 3%;top: 43px;background:#0FD5B2;border-radius:75px;font-size:17px;line-height:18px;padding:17px 37px;color:#000;">TU PERFIL ESTA INCOMPLETO</a> -->
					<a href="actualiza-tus-datos/<?php echo $suscri[0]['id_suscrito']; ?>" style="position: absolute;right: 3%;top: 43px;background:#0FD5B2;border-radius:75px;font-size:17px;line-height:18px;padding:17px 37px;color:#000;">TU PERFIL ESTA INCOMPLETO</a>
			<?php } ?>
						
            <span class="color1 poppi-sb espe"> <?php echo !empty($suscri[0]['titulo'])?$suscri[0]['titulo']:'Completa tus datos ..'; ?></span>
					</div>

<?php
				}// certificaion no sale esto

        if(isset($_GET['task']) && $_GET['task']=='mis-cursos'){
					// Listado de cursos comprados ..
?>
            <blockquote class="color1 poppi-sb">Mis cursos</blockquote>
<?php
            $suscur = executesql("SELECT * FROM suscritos_x_cursos WHERE estado_idestado=1 and id_tipo=1 and condicion=1 and estado=1 and id_suscrito = '".$_SESSION['suscritos']['id_suscrito']."' ");
            if(!empty($suscur)){ 
				foreach ($suscur as $data_asignacion){
					$detalles = executesql("SELECT * FROM cursos WHERE id_curso = '".$data_asignacion['id_curso']."'",0);
					$titulo=$detalles['titulo'];
					$link='perfil/mis-cursos/'.$detalles['titulo_rewrite'];
					$imgproduct= 'tw7control/files/images/capa/'.$detalles['imagen'];

					echo '<div class="large-4 float-left medium-6 columns nothing mis_cursos ">';
						include('inc/curso2.php');
					echo '</div>';

            	}
			}else{
				echo '<div class="text-center" style="padding:40px 15px;">Aún no has comprado cursos .. </div>';
			}

	//** Mis pedidos *******
    }elseif(!empty($_GET["task"]) && $_GET["task"]=="mis-pedidos"){ 
			
			$sql_pedidos="select * from pedidos where estado_idestado=1 and id_suscrito='".$ide_suscrito."'";
			$pedidos=executesql($sql_pedidos);
			
			// detalle de pedidos
			// detalle de pedidos
			if(!empty($_GET["task"]) && $_GET["task"]=="mis-pedidos" && !empty($_GET["task2"]) ){  // detalle de pedidos
				$sql_pedidos.=" and id_pedido='".$_GET["task2"]."' ";
				$pedidos=executesql($sql_pedidos);
			// detalle pedidos ?>
				<h4 class="poppi color-1 bold text-left detped" >Detalle Compra: <?php echo $_GET["task2"];?></h4>
			
			<?php if(!empty($pedidos)){ ?>
				<div class="row detallepedido poppi mispedidos">
					<div class="medium-6 columns end">
						<h6 class="estado<?php echo $pedidos[0]["estado_pago"];?> "> 
								Estado: 
							<?php 
								if($pedidos[0]["estado_pago"]==2){ echo "Pago por confirmar ";
								}elseif($pedidos[0]["estado_pago"]==3){ 
									echo "Compra Rechazado";
									if( $pedidos[0]["tipo_pago"]==3 ){  /* si pago con efectivo, expiro la compra */
										echo "</br> El código CIP  generado a <b>expirado</b>";
									
									}else{
										/* sino rechazo el cliente */
										echo "</br>Motivo: AUGE PERÚ, rechazo el pago. ";
									}
									
								}elseif($pedidos[0]["estado_pago"]==1){ echo "Aprobado";
								}
							?>
						</h6>
				<?php /*		
						<h5 class="poppi color-1 bold"><img src="img/iconos/ico-pedidos.png" style="padding-right:9px;">
						<?php echo ($pedidos[0]["id_envio"] == 1000)?'Recojo en tienda':'Envío a domicilio';?>	
						</h5>
						<p><?php  $envio=executesql(" select * from precio_envios where estado_idestado=1 and id_envio='".$pedidos[0]["id_envio"]."' ");
										if($pedidos[0]["id_envio"] == 1000){ 
											
										}else if($pedidos[0]["id_envio"] <= 24){ 
												echo "Dpto: ".$envio[0]['titulo'];
										}elseif($pedidos[0]["id_envio"] > 24 && $pedidos[0]["id_envio"] < 1233){
												echo "Lima: ".$envio[0]['titulo'];
										}elseif($pedidos[0]["id_envio"] > 1232 ){
												echo "Lambayeque: ".$envio[0]['titulo'];
											
										}
								?>
						</p>
						<p> Dirección: <?php if(!empty($pedidos[0]["direccion"])){ 
												echo $pedidos[0]["direccion"];
											}else{
												echo $perfil[0]["direccion"].'</br> Referencia:'.$perfil[0]["referencia"].'</br> Ciudad:'.$perfil[0]["ciudad"];
											}
						?>
						</p>
						<p></br> Comentario pedido: </br> <?php 	echo $pedidos[0]["comentario"];?>	</br></br></p>

					<?php if($pedidos[0]["id_envio"] != 1000){  ?>
						<p>Referencia: <?php echo $pedidos[0]["referencia"]; ?></p>
						
						<h5 class="poppi color-1 bold"><img src="img/iconos/ico-pedidos.png" style="padding-right:9px;">Datos Delivery</h5>
						<!-- 
						<p>Fch. entrega: <?php echo $pedidos[0]["fecha_del"]; ?></p>
						-->
						<p>Recibe:<?php echo $pedidos[0]["nombre_anexo"].' '.$pedidos[0]["apellidos_anexo"]; ?></p>
						<p>Tlf/Cel:<?php echo $pedidos[0]["telefono_anexo"].'  - '.$pedidos[0]["celular_anexo"]; ?></p>
					<?php } ?>
					*/ ?>
						
					</div>   
					
					<div class="medium-6 columns end">
						<div class="contiene ">
							<h6 class="poppi color-2 bold">RESUMEN DE COMPRA </h6>
							<p class="preccc">Subtotal <span>S/ <?php echo $pedidos[0]["subtotal"];?></span></p>
							<p>Envío  <span>S/ <?php echo !empty($pedidos[0]["envio"])?$pedidos[0]["envio"]:'0.00';?></span></p>						
							<h6 class="preccc">TOTAL <span>S/ <?php echo $pedidos[0]["total"];?></span></h6>
						</div>   
						<div class="contiene">
							<h6 class="poppi met">MÉTODO DE PAGO  </h6>
							<p style="border:0;">
									<?php 
										if($pedidos[0]["tipo_pago"]==3){ 
											echo ' Pago Efectivo </br> <b>Codigo CIP: </b> <span class="color2" >'.$pedidos[0]["codreferencia"].' </span>';
										}else if($pedidos[0]["tipo_pago"]==2){ 
											echo ' Pago con tarjeta </br> <b>Codigo referencia: </b> <span class="color2" >'.$pedidos[0]["codreferencia"].' </span>';
										}else if($pedidos[0]["tipo_pago"]==4 ){ 
											echo ' Venta manual </br> <b>Codigo referencia: </b> <span class="color2" >'.$pedidos[0]["codreferencia"].' </span>';
										}else{
												echo 'Offline: Deposito </br> <b>Codigo referencia: </b> <span class="color2" >'.$pedidos[0]["codigo_ope_off"].' </span>'; 
										}?>
							</p>					
							</p>					
						</div>   					
					</div>   
			<?php   
		$sql_lineapedidos="select lp.*, p.codigo as cod_curso, p.titulo as name_producto, p.titulo_rewrite as titulo_rewrite, p.imagen  
		FROM linea_pedido lp 
			INNER JOIN cursos p ON lp.id_curso=p.id_curso  
		WHERE lp.estado_idestado=1 and lp.id_pedido='".$pedidos[0]["id_pedido"]."'
		GROUP by lp.id_curso			";
		
				// echo $sql_lineapedidos; 
				
			$lineapedido=executesql($sql_lineapedidos);
			
				if(!empty($lineapedido)){
					 foreach($lineapedido as $linea){ 
							
							$link_linea='perfil/mis-cursos/'.$linea['titulo_rewrite'];
							$img_linea= 'tw7control/files/images/capa/'.$linea['imagen'];
							
					?>
					<div class="medium-12 columns linea_pedido end"><a href="<?php echo $link_linea;?>" target="_blank">										
						<figure class="regalo"><img src="<?php echo $img_linea;?>"></figure> 
						<div class="data">
							<blockquote class="color-1 bold"><?php echo $linea["cod_curso"].' - '.$linea["name_producto"];?> </blockquote>
							<p class=" texto ">Cantidad: <span><?php echo $linea["cantidad"];?> </span></p>
							<p class=" texto ">Precio: <span>s/ <?php echo $linea["precio"];?> </span> </p>
							<p class=" texto  ">Subtotal: <span>s/ <?php echo $linea["subtotal"];?> </span></p>												
						</div>  					
					</a></div>
			<?php 	}
				}else{
					echo '<div class="medium-12 columns end"><p>Lo sentimos no se encontró detalle de pedido .. </br>Comunícate con nosotros </p></div> ';
				}  
			?>
				</div>
				
	<?php 
		}else{ 
			echo '<div class="medium-12 columns end"><p>Lo sentimos pedido no registrado ..</p></div> ';
		} 
	?>
				
			
<?php 
	// Listado pedidos 
	// Listado pedidos 
			}else{ 	// Listado pedidos
						// Listado pedidos
				if(!empty($pedidos)){ ?>
        <!--  <div class="fondo banner-1"></div> -->
				<h4 class="poppi color-2 bold text-center" style="padding:45px 0;padding-left:15px;">Mis Compras:</h4>
				<div id="listado_pedidos" class="load-content"><p class="text-center" style="padding-top:100px;">Espere mientras listado se va cargando ...   </p></div>
				
<?php 	}else{//si no tiene pedidos . ?>
				<div class="text-center poppi cero-registro">
					<p class="texto em ">Aún no registras pedidos con nosotros .. </p>
				</div>
<?php 	}//end listado pedidos  
      }


/*
	// Actualizar datos de perfil .. suspendido temporal ir a actualizar datos 

	}elseif(isset($_GET['task']) && $_GET['task']=='mis-datos'){

?>
            <form id="ajax-perfil-form"  method="post" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?php echo !empty($suscri[0]['id_suscrito'])?$suscri[0]['id_suscrito']:''; ?>">
                <fieldset class="rel">
                    <label class="poppi-sb color1">Nombre:</label>
                    <input type="text" class="poppi" id="nombre" name="nombre" value="<?php echo !empty($suscri[0]['nombre'])?$suscri[0]['nombre']:'Completa tus datos ..'; ?>">
                </fieldset>
                <fieldset class="rel">
                    <label class="poppi-sb color1">Apellido Paterno:</label>
                    <input type="text" class="poppi" id="ap_pa" name="ap_pa" value="<?php echo !empty($suscri[0]['ap_pa'])?$suscri[0]['ap_pa']:'Completa tus datos ..'; ?>">
                </fieldset>
                <fieldset class="rel">
                    <label class="poppi-sb color1">Apellido Materno:</label>
                    <input type="text" class="poppi" id="ap_ma" name="ap_ma" value="<?php echo !empty($suscri[0]['ap_ma'])?$suscri[0]['ap_ma']:'Completa tus datos ..'; ?>">
                </fieldset>

								<fieldset class="rel">
                    <label class="poppi-sb color1">Especialidad:</label>
                     <?php crearselect("id_especialidad","select * from especialidades where estado_idestado=1 order by titulo asc",'class="" required',$suscri[0]["id_especialidad"],"-- seleccione--"); ?>
                </fieldset>

								<fieldset class="rel">
                    <label class="poppi-sb color1">Escala magisterial:</label>
                     <?php crearselect("id_escala_mag","select * from escala_magisteriales where estado_idestado=1 order by titulo asc",'class="form-control" required',$suscri[0]["id_escala_mag"],"-- seleccione--"); ?>
                </fieldset>

                <fieldset class="rel">
                    <label class="poppi-sb color1">Teléfono:</label>
                    <input type="text" class="poppi" name="telefono" id="telefono" maxlength=9 onkeypress="javascript:return soloNumeros(event,0);" value="<?php echo !empty($suscri[0]['telefono'])?$suscri[0]['telefono']:'Completa tus datos ..';  ?>">
                </fieldset>
                <fieldset class="rel">
                    <label class="poppi-sb color1">DNI:</label>
                    <input type="text" class="poppi" id="dni" name="dni" onkeypress="javascript:return soloNumeros(event,0);" minlength="8" maxlength="8" value="<?php echo !empty($suscri[0]['dni'])?$suscri[0]['dni']:'Completa tus datos ..';  ?>">
                </fieldset>
                <fieldset class="rel">
                    <label class="poppi-sb color1">Ciudad:</label>
                    <input type="text" class="poppi" id="ciudad" name="ciudad" value="<?php echo !empty($suscri[0]['ciudad'])?$suscri[0]['ciudad']:'Completa tus datos ..';  ?>">
                </fieldset>
                <fieldset class="rel">
                    <label class="poppi-sb color1">Dirección:</label>
                    <input type="text" class="poppi" id="direccion" name="direccion" value="<?php echo !empty($suscri[0]['direccion'])?$suscri[0]['direccion']:'Completa tus datos ..';  ?>">
                </fieldset>
								<fieldset class="rel">
                    <label class="poppi-sb color1">Email:</label>
                    <input type="text" class="poppi" disabled id="ji" name="ji" value="<?php echo !empty($suscri[0]['email'])?$suscri[0]['email']:'Completa tus datos ..';  ?>" alt="El correo no es editable ..">
                </fieldset>
                <fieldset class="rel">
                    <button class="boton poppi-sb">Actualizar</button>
                    <div class="callout primary hide" id="reportInfo">Procesando datos...</div>
                    <div class="callout alert hide" id="reportError">No se pudo actualizar.</div>
                    <div class="callout success hide" id="reportSuccess">Datos actualizados...</div>
                </fieldset>
            </form>
<?php
 // end mis datos - mi perfil */


				// actualizar cambiar_clave ..
				}elseif(isset($_GET['task']) && $_GET['task']=='actualizar-clave'){ ?>
						<form  id="ajax-actualizaclave-form"  method="post" enctype="multipart/form-data">
                <input type="hidden" name="id_alumno" value="<?php echo !empty($suscri[0]['id_suscrito'])?$suscri[0]['id_suscrito']:'';  ?>">
                <fieldset class="rel">
                    <label class="poppi-sb color1">Correo: <?php echo !empty($suscri[0]['email'])?$suscri[0]['email']:'Completa tus datos ..'; ; ?></label>
                </fieldset>
								<fieldset class="rel">
                    <label class="poppi-sb color1">Nueva clave:</label>
                    <input type="password" class="poppi" id="clave" name="clave" >
                </fieldset>
                <fieldset class="rel">
                    <button class="boton poppi-sb">Actualizar</button>
                    <div class="callout primary hide" id="reportInfo">Procesando datos...</div>
                    <div class="callout alert hide" id="reportError">No se pudo actualizar.</div>
                    <div class="callout success hide" id="reportSuccess">OK! Clave actualizada ...</div>
                </fieldset>
            </form>
<?php
				}elseif(isset($_GET['task']) && $_GET['task']=='certificados'){
							include('certificacion.php');
				
				}elseif(isset($_GET['task']) && $_GET['task']=='tutoriales'){
?>
					 <div class="">
            <h1 class="poppi-b color1" style="padding-bottom:80px;">APRENDE A UTILIZAR TU AULA VIRTUAL</h1>
						<!-- 
            <span class="color1 poppi-sb espe">APRENDE A UTILIZAR TU AULA VIRTUAL</span>
						-->
					</div>
					<ul class="accordion" data-accordion data-allow-all-closed="true"  >
<?php 			  $tutorial=executesql("select * from tutoriales where estado_idestado=1 order by orden asc ");
							if( !empty($tutorial) ){
								foreach($tutorial as $detalle_tutorial){
?>
								<li class="accordion-item" data-accordion-item>
										<a href="#" class="accordion-title poppi-b"><?php echo $detalle_tutorial["titulo"]; ?></a>
										<div class="accordion-content" data-tab-content><div class="descripcion">
												<div class="poppi texto rel detalle_tutorial">
													<!-- <img src="img/iconos/check.png"> -->
													<?php
														if(!empty($detalle_tutorial["link"])){
															$dat = $detalle_tutorial["link"];
															$trovi = explode("=", $dat);
															$codiyou = substr($trovi[1],0,11); 
													?>
													<iframe src="https://www.youtube.com/embed/<?php echo $codiyou ?>" frameborder="0" class="alto_you" width="100%" allowfullscreen></iframe>
													<?php 
														} // si lleva video 
													echo $detalle_tutorial["descripcion"]; ?>
												</div>
										</div></div>
								</li>
<?php  				} }// for ?>
						</ul>
<?php 
				}elseif(isset($_GET['task']) && $_GET['task']=='examenes'){
					include('examen_listado_comprados.php');
				}else{ ?>

					<div class="">
            <span class="color1 poppi-sb bienve">	!Felicidades¡. Ya tienes una cuenta en AUGE PERU, ahora puedes entrar a cursos y comprar de forma segura</span>
			<?php
				//if( empty($suscri[0]['ap_pa']) || empty($suscri[0]['ap_ma'])  || empty($suscri[0]['direccion']) || empty($suscri[0]['ciudad'])  || empty($suscri[0]['dni'])  || empty($suscri[0]['telefono'])  ){
				if( empty($suscri[0]['ap_pa']) || empty($suscri[0]['ap_ma'])  || empty($suscri[0]['dni'])  || empty($suscri[0]['telefono'])  ){
			?>
							<div class="text-center">
								<a href="actualiza-tus-datos/<?php echo $suscri[0]['id_suscrito']; ?>" class="" style="background:#0FD5B2;border-radius:75px;font-size:17px;line-height:18px;padding:17px 37px;color:#000;">TU PERFIL ESTA INCOMPLETO</a>
							</div>	
			<?php	} ?> 
					</div>

<?php				}
?>
        </div> <!-- L9 contenedor -->
    </div></div>
<?php
    }// if global
?>
</main>
<?php include ('inc/footer.php'); ?>