<?php include('auten.php');
if(!isset($_SESSION["suscritos"]["id_suscrito"])){ header('Location: '.$url); }
$pagina='perfil';
$meta = array(
    'title' => 'Auge: Perfil',
    'description' => ''
);
include ('inc/header.php');
$suscri = executesql("SELECT s.*, e.titulo FROM suscritos s INNER JOIN especialidades e ON s.id_especialidad = e.id_especialidad WHERE s.id_suscrito = '".$_SESSION['suscritos']['id_suscrito']."'",0);
?>
<main id="perfil">
<!-- Si ven el curso detalle en el perfil -->
<?php
// Mis cursos : ** _detalle_curso 
    if(isset($_GET['task']) && ($_GET['task']=='mis-cursos') && isset($_GET['task2']) && !empty($_GET['task2'])){
        // $curs = executesql("SELECT * FROM cursos WHERE estado_idestado=1 and titulo_rewrite = '".$_GET['task2']."'",0);
        
				// validamos si el curso le pertenece al alumno logeado. 
				$sql_cc="SELECT c.*, sc.estado_idestado as estado_asignacion,  sc.estado as condicion_curso FROM suscritos_x_cursos sc INNER JOIN cursos c ON sc.id_curso=c.id_curso WHERE  c.titulo_rewrite = '".$_GET['task2']."' and sc.id_suscrito='".$_SESSION['suscritos']['id_suscrito']."' "; 
				$curs = executesql($sql_cc,0);
?>
    <div class="callout callout-2 detalle_de_curso_comprado "><div class="row row3">
<?php if(!empty($curs)){   // si le pertenece el curso 
					if($curs["condicion_curso"]=="2" ){ ?>		
				<div class="large-12 columns rptas_error "><h4 class="color1 poppi-b">Aún esta pendiente la aprobación del pago.  </h4></div>
					<?php }elseif($curs["condicion_curso"]=="3" ){ ?>
				<div class="large-12 columns rptas_error"><h4 class="color1 poppi-b">El pago fue rechazado, comunícate con nosotros por WhatsApp.  </h4></div>
					<?php }elseif($curs["estado_asignacion"]=="2"){ ?>
				<div class="large-12 columns rptas_error"><h4 class="color1 poppi-b">Esta asignación ha sido deshabilitada!  </h4></div>
				<?php 
							}elseif($curs["estado_asignacion"]=="1" && $curs["condicion_curso"]=="1"){ 
				// si asignacion esta vigente y el pago fue aprobado mueestro contenido curso .
				
				?>
					
        <div class="large-12 columns">
            <h3 class="color1 poppi-b"><?php echo $curs['titulo'] ?><span>30%</span></h3>
        </div>
        <div class="large-4 medium-4 columns">
<?php
        $ses = executesql("SELECT * FROM sesiones WHERE estado_idestado = 1 AND id_curso = ".$curs['id_curso']." ORDER BY ORDEN ASC");
        $z=1;
        if(!empty($ses)){
            echo '<ul class="accordion" style="margin-top:25px" data-accordion>';
            foreach($ses as $sesi){
?>
            <li class="accordion-item <?php echo ( isset($_GET['task3']) && $_GET['task3']==$sesi['titulo_rewrite']) ? 'is-active' : '' ?>" data-accordion-item>
                <a href="#" class="accordion-title comprobado poppi-b"><?php echo $sesi['titulo'] ?></a>
                <div class="accordion-content" data-tab-content>
<?php
                    $det = executesql("SELECT * FROM detalle_sesiones WHERE estado_idestado = 1 AND id_sesion = ".$sesi['id_sesion']." ORDER BY orden DESC");
                    if(!empty($det)){ echo '<div class="lista">'; foreach($det as $deta){
?>
                    <a href="perfil/<?php echo $_GET['task'].'/'.$_GET['task2'].'/'.$sesi['titulo_rewrite'].'/'.$deta['titulo_rewrite'] ?>"><p class="poppi texto rel"><?php echo $z.'. '.$deta['titulo'] ?></p></a>
<?php
                    $z++;
                    } echo '</div>'; }
?>
                </div>
            </li>
<?php
            }
            echo '</ul>';
        } // end listado de modulos
?>
        </div>

        <div class="large-8 medium-8 columns">
<?php
			if(isset($_GET['task4']) && !empty($_GET['task4'])){
        if($curs['modalidad']==2 ) { 
					echo '<p class="poppi-sb color1 text-center rel">'.date('d\/m\/Y ',strtotime($curs['fecha_inicio'])).' '.date("g:i a",strtotime($curs['hora_inicio'])).'<img class="float-right" style="position:absolute;right:0;top:-20px;" src="img/iconos/live.png"></p>';
				}
				
        $detal = executesql("SELECT * FROM detalle_sesiones WHERE estado_idestado = 1 AND titulo_rewrite = '".$_GET['task4']."'",0);
        if(!empty($detal["link"])){
					?>
            <div class="rel">
								<iframe src="	<?php echo $detal['link']; ?>"  frameborder="0" allow="autoplay; fullscreen" allowfullscreen></iframe>
						</div>
<?php
        }else{
            echo '<div class="cuadro-virtual text-center">
                <span class="poppi-bi">Esta clase se realizará en VIVO a través de la plataforma ZOOM.<br>Unicamente tiene que ingresar a esta sección para participar de la sesión</span>'.(!empty($detal["externo"]) ? '<a href="'.$detal["externo"].'" class="boton poppi-sb">Ingresar Aquí</a>' : '').'

            </div>';
        }
        echo !empty($detal['descripcion']) ? '<div class="detalle">'.$detal['descripcion'].'</div>' : '';
?>
	<!-- Recursos -->
<?php
				$recur = executesql("SELECT * FROM archivos_detalle_sesion_virtuals WHERE estado_idestado = 1 AND id_detalle = '".$detal['id_detalle']."'");
				if(!empty($recur)){ 
					echo '<h4 class="poppi-b color1 recur">Recursos</h4> <ul class="accordion" style="margin-top:25px" data-accordion data-allow-all-closed="true">';
					foreach ($recur as $recurso){
?>
						<li class="accordion-item" data-accordion-item >
						<a href="#" class="accordion-title titu-rec poppi-b"><?php echo $recurso['titulo'] ?></a>
						<div class="accordion-content" data-tab-content>
<?php
							echo !empty($recurso['descripcion']) ? '<div class="detalle">'.$recurso['descripcion'].'</div>' : '';
							echo !empty($recurso['archivo']) ? '<span class="poppi color1 arch">Archivo: <a target="_blank" href="tw7control/files/files/'.$detal['id_detalle'].'/'.$recurso['archivo'].'"><img src="tw7control/dist/img/icons/archivo.jpg"></a></span>' : '';
							echo '</div></li>';
					} 
					echo '</ul>'; }
  			} // if_recursos 
				
			}// si existe task4 para detalle clase
?>
			</div> <!-- L8 -->
<?php 
		}else{ // Si no le compro el curso .. rpta al chistoso  ?>	
				<div class="large-12 columns">
					<h4 class="color1 poppi-b">No tienes acceso a este curso, te invitamos a <a href=''>[ conócelo aquí] </a> </h4>
        </div>		
<?php } //enf valiacion si curso es del alumno logeado  ?>											
    </div></div>
		
		
<?php 
// perfil global
}else{ // sino hay task4 
?>
    <div class="callout callout-1"><div class="row row3">
        <div class="large-12 columns">
            <h1 class="poppi-b color1"><?php echo $suscri['nombre'].' '.$suscri['ap_pa'].' '.$suscri['ap_ma'] ?></h1>
            <span class="color1 poppi-sb espe"><?php echo $suscri['titulo'] ?></span>
        </div>
        <div class="large-3 medium-4 columns">
            <ul class="accordion" data-accordion>
                <li class="accordion-item nod <?php echo (isset($_GET['task']) && $_GET['task']=='mis-datos') ? 'is-active' : '' ?>" data-accordion-item>
                    <a href="perfil/mis-datos" class="accordion-title poppi-b">Mi perfil</a>
                </li>
                <li class="accordion-item nod <?php echo (isset($_GET['task']) && $_GET['task']=='mis-cursos') ? 'is-active' : '' ?>" data-accordion-item>
                    <a href="perfil/mis-cursos" class="accordion-title poppi-b">Mis cursos</a>
                </li>
            </ul>
            <ul class="accordion" data-accordion>
                <li class="accordion-item" data-accordion-item>
                    <a href="#" class="accordion-title poppi-b">Certificados</a>
                    <div class="accordion-content" data-tab-content></div>
                </li>
                <li class="accordion-item nod <?php echo (isset($_GET['task']) && $_GET['task']=='actualizar-clave') ? 'is-active' : '' ?>" data-accordion-item>
										<a href="perfil/actualizar-clave" class="accordion-title poppi-b">Clave de acceso</a>
								</li>
            </ul>
        </div>
        <div class="large-9 medium-8 columns">
<?php
        if(isset($_GET['task']) && $_GET['task']=='mis-cursos'){
					// Listado de cursos comprados ..
?>
            <blockquote class="color1 poppi-sb">Mis cursos</blockquote>
<?php
            $suscur = executesql("SELECT * FROM suscritos_x_cursos WHERE id_suscrito = '".$_SESSION['suscritos']['id_suscrito']."'");
            if(!empty($suscur)){ foreach ($suscur as $data_asignacion){
                $detalles = executesql("SELECT * FROM cursos WHERE id_curso = '".$data_asignacion['id_curso']."'",0);
                $titulo=$detalles['titulo'];
                $link='perfil/mis-cursos/'.$detalles['titulo_rewrite'];
                $imgproduct= 'tw7control/files/images/capa/'.$detalles['imagen'];
								
                echo '<div class="large-4 float-left medium-4 columns nothing mis_cursos ">';
									include('inc/curso2.php');
                echo '</div>';
            } }else{  
									echo '<div class="text-center" style="padding:40px 15px;">Aún no has comprado cursos .. </div>';
						}
						
			// Actualizar datos de perfil ..			
        }elseif(isset($_GET['task']) && $_GET['task']=='mis-datos'){
?>
            <form id="ajax-perfil-form"  method="post" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?php echo $suscri['id_suscrito'] ?>">
                <fieldset class="rel">
                    <label class="poppi-sb color1">Nombre:</label>
                    <input type="text" class="poppi" id="nombre" name="nombre" value="<?php echo $suscri['nombre'] ?>">
                </fieldset>
                <fieldset class="rel">
                    <label class="poppi-sb color1">Apellido Paterno:</label>
                    <input type="text" class="poppi" id="ap_pa" name="ap_pa" value="<?php echo $suscri['ap_pa'] ?>">
                </fieldset>
                <fieldset class="rel">
                    <label class="poppi-sb color1">Apellido Materno:</label>
                    <input type="text" class="poppi" id="ap_ma" name="ap_ma" value="<?php echo $suscri['ap_ma'] ?>">
                </fieldset>
                
                <fieldset class="rel">
                    <label class="poppi-sb color1">Teléfono:</label>
                    <input type="text" class="poppi" name="telefono" id="telefono" maxlength=9 onkeypress="javascript:return soloNumeros(event,0);" value="<?php echo $suscri['telefono'] ?>">
                </fieldset>
                <fieldset class="rel">
                    <label class="poppi-sb color1">DNI:</label>
                    <input type="text" class="poppi" id="dni" name="dni" onkeypress="javascript:return soloNumeros(event,0);" minlength="8" maxlength="8" value="<?php echo $suscri['dni'] ?>">
                </fieldset>
                <fieldset class="rel">
                    <label class="poppi-sb color1">Ciudad:</label>
                    <input type="text" class="poppi" id="ciudad" name="ciudad" value="<?php echo $suscri['ciudad'] ?>">
                </fieldset>
                <fieldset class="rel">
                    <label class="poppi-sb color1">Dirección:</label>
                    <input type="text" class="poppi" id="direccion" name="direccion" value="<?php echo $suscri['direccion'] ?>">
                </fieldset>
                <fieldset class="rel">
                    <button class="boton poppi-sb">Actualizar</button>
                    <div class="callout primary hide" id="reportInfo">Procesando datos...</div>
                    <div class="callout alert hide" id="reportError">No se pudo actualizar.</div>
                    <div class="callout success hide" id="reportSuccess">Datos actualizados...</div>
                </fieldset>
            </form>
<?php		
				// actualizar cambiar_clave ..
				}elseif(isset($_GET['task']) && $_GET['task']=='actualizar-clave'){ ?>
						    <form  id="ajax-actualizaclave-form"  method="post" enctype="multipart/form-data">
                <input type="hidden" name="id_alumno" value="<?php echo $suscri['id_suscrito'] ?>">
                <fieldset class="rel">
                    <label class="poppi-sb color1">Correo: <?php echo $suscri['email']; ?></label>
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
        }
?>
        </div> <!-- L9 contenedor -->
    </div></div>
<?php
    }// if global
?>
</main>
<?php include ('inc/footer.php'); ?>