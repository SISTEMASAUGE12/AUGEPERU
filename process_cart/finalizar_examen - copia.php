<?php error_reporting(E_ALL);
session_start();
include_once("../tw7control/class/functions.php");
include_once("../tw7control/class/class.bd.php");
$bd=new BD;

$suscrito 	= utf8_encode(utf8_decode($_POST['suscrito']));
$minuto 	= utf8_encode(utf8_decode($_POST['minuto']));
$ulr_resul 	= utf8_encode(utf8_decode($_POST['link_espe']));
$minuto2 	= utf8_encode(utf8_decode($_POST['minuto2']));
$examen 	= utf8_encode(utf8_decode($_POST['examen']));
$total_preguntas 	= utf8_encode(utf8_decode($_POST['total_preguntas']));
$fecha 		= fecha_hora(2);
$nota 		= 0;

//Examen x suscritos ..
//$sql_e="SELECT * FROM suscritos_x_examenes WHERE id_suscrito=".$suscrito." AND id_examen=".$examen;
// echo $sql_e;
// exit();

/* Validate para registrar solo 1 examen, y actualizarlo segun los intentos. */
// $exa = executesql($sql_e);
// if(empty($exa)){
	// $orden = _orden_noticia("","suscritos_x_examenes","");
	// $campo_examen = array(array('id_suscrito',$suscrito),array('id_examen',$examen),array('fecha_registro',$fecha),array('fecha_actualizacion',$fecha),array('orden',$orden),array('estado_idestado',1));
	// $bd->inserta_(arma_insert('suscritos_x_examenes',$campo_examen,'POST'));
// }else{
	// $campo_examen = array(array('fecha_actualizacion',$fecha));
	// $bd->actualiza_(armaupdate('suscritos_x_examenes',$campo_examen," id_suscrito='".$suscrito."' AND id_examen='".$examen."'",'POST'));
// }
// end Examen x suscritos ..

/* Cada intento realizado lo registramos */
$orden = _orden_noticia("","suscritos_x_examenes","");
$campo_examen = array(array('id_suscrito',$suscrito),array('id_examen',$examen),array('fecha_registro',$fecha),array('fecha_actualizacion',$fecha),array('orden',$orden),array('estado_idestado',1));
$id_intento=$_POST['id_sxe']=$bd->inserta_(arma_insert('suscritos_x_examenes',$campo_examen,'POST'));
	
	
// sacamos las preguntas y rptas del cliente 
$pregunta = executesql("SELECT * FROM preguntas WHERE id_examen = '".$examen."' ORDER BY orden ASC");

if(!empty($pregunta)){ 
	$contador_numero_de_pregunta = 1;
	foreach($pregunta as $preguntas){
		if($contador_numero_de_pregunta > $total_preguntas){
			// funcion  finalizar .. 			
			// si 3 == 3
		}else{
			$pregunta 	= utf8_encode(utf8_decode($_POST['pregunta'.$contador_numero_de_pregunta]));
			if(isset($_POST['preg'.$contador_numero_de_pregunta])){
			$preg 		= utf8_encode(utf8_decode($_POST['preg'.$contador_numero_de_pregunta]));
			}else{
				$preg = '';
			}
				
			// Registramos respuestas .. 
			$contiene=$pregunta.'_'.$pregunta;
				
			//$examenes_rptas = executesql("SELECT * FROM suscritos_x_examenes_rptas WHERE id_suscrito=".$suscrito." AND id_examen=".$examen." AND id_pregunta=".$pregunta." AND id_rpta=".$preg);
			//if(empty($examenes_rptas)){
				// si no esite la registramos
				$orden 		= _orden_noticia("","suscritos_x_examenes_rptas","");
				$campos1 = array('id_sxe',array('id_suscrito',$suscrito),array('id_examen',$examen),array('id_pregunta',$pregunta),array('id_rpta',$preg),array('fecha_registro',$fecha),array('fecha_actualizacion',$fecha),array('orden',$orden),array('estado_idestado',1));
				$bd->inserta_(arma_insert('suscritos_x_examenes_rptas',$campos1,'POST'));
					
			//}else{
				// si ya exite solo actualizamos el resultado marcado por cliente
				//$campos1 = array(array('id_rpta',$preg),array('fecha_actualizacion',$fecha));
				//$bd->actualiza_(armaupdate('suscritos_x_examenes_rptas',$campos1," id_suscrito='".$suscrito."' AND id_examen='".$examen."' AND id_pregunta=".$pregunta,'POST'));
			//}
				
			// si la rpta es correcta .. calculamos nota ..
			// $pun1 = executesql("SELECT estado_rpta FROM respuestas WHERE id_rpta=".$preg." AND id_pregunta=".$pregunta." AND id_examen=".$examen,0);
			$pun1 = executesql("SELECT estado_rpta FROM respuestas WHERE id_rpta='".$preg."' AND id_pregunta=".$pregunta);
			// $nota = $nota + (($pun1['estado_rpta']==1) ? 1 : 0);					
			$nota = $nota + ((!empty($pun1) && $pun1[0]['estado_rpta']==1) ? $preguntas['puntos'] : 0);					
				
		}
		$contador_numero_de_pregunta++;
	}// for 
}

$res_m = substr($minuto, -5, 2);
$cantidad = strlen($minuto);
if($cantidad==8){
	$res_h = substr($minuto, -8, 2);
}elseif($cantidad==7){
	$res_h = substr($minuto, -7, 1);
}
$total_minu = ($res_h*60)+$res_m;
$min = $minuto2 - $total_minu;
$campos_examen = array(array('nota',$nota),array('fecha_actualizacion',$fecha),array('minutos',$min));
$bd->actualiza_(armaupdate('suscritos_x_examenes',$campos_examen," id_suscrito='".$suscrito."' AND id_examen='".$examen."' AND ide='".$id_intento."' ",'POST'));

$result = $ulr_resul.'/resultado';

$bd->close();
echo json_encode(array(
    "result" => $result
));
?>