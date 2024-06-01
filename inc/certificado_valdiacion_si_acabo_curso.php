<?php 


$habilitado_para_solicitar_envio=1;  /* si acabo todos los cursos e la canastilla relacionado a este certificado, peude solicitar la entrega del certificado */




/* Determino la variable: extraigo si tiene canastilla de cursos o es un curso unico .. */
if( !empty($detalles['cursos_canasta']) ){  /* si tiene canastilla de cursos, aplicamos validación por canastilla */
	$array_factor=explode(',',$detalles['cursos_canasta']);  /* 1  o más resultados */
	// echo var_dump( $array_factor);
		
}else{
	$array_factor=explode(',',$detalles['id_curso']);  /* solo hay un resultado */
	// echo var_dump( $array_factor);
	
}

// mostrar click un alert de los cursos que les falata comprar - culminar para poder solicitar el certificado ..

foreach ($array_factor as $valor_id){  /* recorro valores del array */
	$sql_si_culmino_curso="SELECT sxx.finalizado, CONCAT(ccc.codigo,' ', ccc.titulo) as cursillo FROM suscritos_x_cursos sxx INNER JOIN cursos ccc ON sxx.id_curso=ccc.id_curso WHERE sxx.estado_idestado = 1 AND sxx.id_curso ='".$valor_id."' and  sxx.id_suscrito = '".$_SESSION['suscritos']['id_suscrito']."'  ";
	// echo $sql_si_culmino_curso;
	$si_finalizado = executesql($sql_si_culmino_curso); 

	/* Recorro si finalizo todos los cursos o los de la canastilla */
	if( !empty($si_finalizado) ){  /* si tiene el curso comprado, pregunto si ya lo finalizo */

			if( $si_finalizado[0]['finalizado'] == 2 ){  /* si aun no lo finaliza, ya se bloquea todo el proceso de solicitar entrega */
				$curso_comprado_pen=executesql("select codigo,titulo,en_vivo_finalizado from cursos where estado_idestado=1 and id_curso='".$valor_id."' ");
				
				/* CASO ESPECIAL PARA LOS CURSOS EN VIVO */
				/* cuendo este curso, se marque como en_vivo_finalizado ==1 ; ya debe permisirse el boton de solicitar certificado al docente. */
				/* consulto por este atributo: en_vivo_finalizado */
				if( $curso_comprado_pen[0]['en_vivo_finalizado'] == 1){ /* Si el curso en_vivo; ya se marco como finalizado:: desde cursos.php */
					$mensajillo_comprados_finalizados.= $curso_comprado_pen[0]["codigo"].' - '.$curso_comprado_pen[0]["titulo"]." - <b style='color:green;'>finalizado</b> </br> ";
					
				}else{
					/*  aun no finalizan .. */
					$habilitado_para_solicitar_envio++;				
					$mensajillo_comprados_pen.= $curso_comprado_pen[0]["codigo"].' - '.$curso_comprado_pen[0]["titulo"]." -  Pendiente por finalizar </br> ";
					// $mensajillo_comprados_pen.= " Pendiente: Debes finalizar este curso. </br> ";
				}
				
				
			}else{
				/* cursos finalizados */
				$curso_comprado_fin=executesql("select * from cursos where estado_idestado=1 and id_curso='".$valor_id."' ",0);
				$mensajillo_comprados_finalizados.= $curso_comprado_fin["codigo"].' - '.$curso_comprado_fin["titulo"]." - <b style='color:green;'>finalizado</b> </br> ";
			}
			
			
	}else{  /* le falta comprar este curso .. */
		$habilitado_para_solicitar_envio++;
		$curso_pen=executesql("select * from cursos where estado_idestado=1 and id_curso='".$valor_id."' ",0);
		$mensajillo.= $curso_pen["codigo"]." - ".$curso_pen["titulo"]." - <b style='color:red;'> pendiente de compra </b> </br> ";
	}
	
}  /* end for validate culminacion de cursos . . */
// echo $habilitado_para_solicitar_envio;


?>