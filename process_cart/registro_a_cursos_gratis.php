<?php 
/* SI se resigsto por el curso_gratis, registro suscrito_x_curso_gratis: leads */
if( (isset($_SESSION["suscritos"]["id_suscrito"]) && $_SESSION["suscritos"]["id_suscrito"] > 0 ) && isset($_SESSION["url"]) && ($_SESSION["url"]=='pagina_cursos_gratis')  ){  /* sol osi vienes desde curso_gratis */
	
	
	$_POST["estado_idestado"]=1;
	$_POST["id_suscrito"]=$_SESSION["suscritos"]["id_suscrito"];
	$_POST["email"]=$_SESSION["suscritos"]["email"];
	
	$_POST["id_gratis"]=$_SESSION["url_gratis"]["id_gratis"];
	$_POST["id_curso"]=$_SESSION["url_gratis"]["id_curso"];
	$_POST["id_tipo"]=4; /* 4:: cursos gratis */
	$_POST["fecha_registro"]=fecha_hora(2);
	$_POST['orden'] = _orden_noticia("","suscritos_x_cursos","");

  $_POST['hora'] = fecha_hora(0);
  $_POST['id_pedido'] = '000';
  $_POST['validez_meses'] = 12;
  $_POST['gratis'] = 1;
  $_POST['estado'] = 1; // entra aprovado directo, curso gratis 
	

	

	$validate=executesql("select * from suscritos_x_cursos where estado_idestado=1 and id_suscrito='".$_POST["id_suscrito"]."' and id_curso='".$_POST["id_curso"]."' ");
	if( !empty($validate) ){
		/* ya no registro creo su sesion de ingreso */
			$_SESSION["curso_gratis"]["rewrite"]=$_SESSION["url_gratis"]["rewrite"];  /* capturo REWRITE Y EN JS lo concateno con la palabra curso_gratis/ ... para el redireccionamiento */
			$_SESSION["curso_gratis"]["nombre"]=$_SESSION["suscritos"]["email"];
		
	}else{
		/* registro */
		
		$campos=array('id_suscrito','id_curso','id_tipo','id_pedido','gratis','orden','fecha_registro','validez_meses','estado','estado_idestado');
		
		// echo var_dump(arma_insert('suscritos_x_cursos',$campos,'POST'));		
		// exit();
		
			
		$_POST['ide']=$bd->inserta_(arma_insert('suscritos_x_cursos',$campos,'POST'));
		
		
		// asigno clases por curso del _ alumnos con estado pendiente: estado:2 pendiente, 1. finalizada ..
		// asigno clases por curso del _ alumnos con estado pendiente: estado:2 pendiente, 1. finalizada ..
		$_POST['orden'] = _orden_noticia("","avance_de_cursos_clases","");
		$_POST['estado_idestado']='1';
		$_POST['estado_fin']='2';
		// recorremos las clases del curso ..
		$sql_n_clase="select d.id_detalle,d.id_sesion from detalle_sesiones d 
												INNER JOIN sesiones s  ON s.id_sesion=d.id_sesion 
												INNER JOIN cursos c  ON c.id_curso=s.id_curso 
												WHERE d.estado_idestado=1 and c.id_curso='". $_POST['id_curso']."' ";
		$n_clases=executesql($sql_n_clase);
		if( !empty($n_clases)){
			foreach($n_clases as $rowe){
				// recorremos y agregamos 
					$_POST['id_detalle']=$rowe['id_detalle'];
					$_POST['id_sesion']=$rowe['id_sesion'];
					$campos=array('id_suscrito','id_curso','id_sesion','id_detalle','id_pedido','orden','fecha_registro','estado_fin','estado_idestado');
					$bd->inserta_(arma_insert('avance_de_cursos_clases',$campos,'POST'));								
			}
		}
						
      $bd->close();
    
		if( $_POST['ide'] > 0){
			$_SESSION["curso_gratis"]["rewrite"]=$_SESSION["url_gratis"]["rewrite"];
			$_SESSION["curso_gratis"]["nombre"]=$_SESSION["suscritos"]["email"];
		}
		
		
	} /* end registro al curso */
}

?>