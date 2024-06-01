<?php // validamos si el curso le pertenece al alumno logeado.
$sql_cc="SELECT c.*, sc.estado_idestado as estado_asignacion,  sc.estado as condicion_curso , sc.condicion 
	FROM suscritos_x_cursos sc 
	INNER JOIN cursos c ON sc.id_curso=c.id_curso
	WHERE  sc.estado=1   and c.titulo_rewrite = '".$_GET['task2']."' and sc.id_suscrito='".$_SESSION['suscritos']['id_suscrito']."' 
	ORDER BY  sc.orden desc limit 0,1 ";
					
// si el curso se encuentra deshabilitado en el futuro esto no afecta a los ya comprados, igual se visualiza el contenido y clases	

// echo $sql_cc; 

$curs = executesql($sql_cc);
?>
<div class="callout callout-2 detalle_de_curso_comprado "><div class="row row3 row-docen">
<?php 
if(!empty($curs)){   // si le pertenece el curso 

	if($curs[0]["condicion"]=="2" ){	
?>
	<div class="large-12 columns rptas_error "><h4 class="color1 poppi-b">Plazo de acceso vencido para acceder a este curso. </br> Recuerda que el tiempo de acceso válido es un plazo de 6 meses desde la fecha de compra.</h4></div>

<?php 
	}else if($curs[0]["condicion_curso"]=="2" ){	
?>		
	<div class="large-12 columns rptas_error "><h4 class="color1 poppi-b">Aún esta pendiente la aprobación del pago.</h4></div>
<?php 
	}elseif($curs[0]["condicion_curso"]=="3" ){ 
?>
	<div class="large-12 columns rptas_error"><h4 class="color1 poppi-b">El pago fue rechazado, comunícate con nosotros por WhatsApp.  </h4></div>
<?php 
	}elseif($curs[0]["estado_asignacion"]=="2"){
?>
	<div class="large-12 columns rptas_error"><h4 class="color1 poppi-b">Esta asignación ha sido deshabilitada!  </h4></div>
<?php 
	}elseif($curs[0]["estado_asignacion"]=="1" && $curs[0]["condicion_curso"]=="1"){
	// si asignacion esta vigente y el pago fue aprobado mueestro contenido curso .
	// y=(AB*100)/x  --> formula  
	// => x = total de clases
	// => y =porcentaje
	// AB= clases finalizadas. 
	// marcamos el curso como finalizado
	$si_finalizado = executesql("SELECT ide,finalizado FROM suscritos_x_cursos WHERE estado_idestado = 1 AND id_curso = '".$curs[0]['id_curso']."' and  id_suscrito = '".$_SESSION['suscritos']['id_suscrito']."'  ");
	if($si_finalizado[0]['finalizado']!=1){
		// calculo total de clases 
		// ... calculo total de clases 
		$total_n_clases = executesql("SELECT count(*) as total_clases FROM avance_de_cursos_clases WHERE id_curso = '".$curs[0]['id_curso']."' and id_suscrito='".$_SESSION['suscritos']['id_suscrito']."' ");
		if(!empty($total_n_clases) && $total_n_clases[0]['total_clases'] > 0 ){
			// clases finalizadas 
			$finalizadas = executesql("SELECT count(*) as total_finalizadas FROM avance_de_cursos_clases WHERE id_curso = '".$curs[0]['id_curso']."' and id_suscrito='".$_SESSION['suscritos']['id_suscrito']."'  and estado_fin=1 ");
			$porcentaje= round( ($finalizadas[0]['total_finalizadas']*100)/$total_n_clases[0]['total_clases']);
			if($porcentaje =='100'){
				// marcamoscurso como finalizado el curso ..
				$bd=new BD;
				$_POST['finalizado']=1;
				$campos=array('finalizado');
				$bd->actualiza_(armaupdate('suscritos_x_cursos',$campos," ide='".$si_finalizado[0]["ide"]."'",'POST'));/*actualizo*/
					// }else{
					// $porcentaje ='0';
			}
		}else{
			// lo compro cuando no tenia clase registradas ..
			$porcentaje ='';
		}
	}else{
		// si esta finalizado = 100%
		$porcentaje='100';
	}
?>			

	<?php include("perfil_clase_curso_menu.php"); ?>
	<?php include("perfil_clase_curso_detalle.php"); ?>

<?php 				
		}// si curso ya esta pago aprobado, estado OK

	}else{ // Si no le compro el curso .. rpta al chistoso  ?>	
	<div class="large-12 columns text-center" style="padding:110px 0;">
		<h4 class="color1 poppi-b">No tienes acceso a este curso, compralo aquí <a href='curso/todos'>[ ver cursos] </a> </h4>
    </div>		
<?php } //enf valiacion si curso es del alumno logeado  ?>				
</div></div>
		
		