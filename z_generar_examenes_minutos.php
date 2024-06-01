<?php error_reporting(E_ALL ^ E_NOTICE);
include ("auten.php");

  $bd = new BD;
  $bd->Begin();
 
 // select * from examenes WHERE  id_examen BETWEEN 1742 and 1840 and estado_idestado=1 and total_preguntas is NULL  order by orden asc 
 
 
 
 
/* Recorro las preguntas del bnaco seleecionadas */
	$sql="select * from examenes WHERE id_examen BETWEEN 1742 and 1840 and  estado_idestado=1 order by orden asc ";
	$leads_wwebi=executesql($sql);
	if( !empty($leads_wwebi) ){
		foreach($leads_wwebi as $data){
				 
				if( !empty($data['hora_limite']) ){
					// $horaEntrada = '03:00:00';	
					$horaEntrada = $data['hora_limite'];	
					//realizamos una partición que separe la parte de la hora y la parte de los minutos
					$v_HorasPartes = explode(":", $horaEntrada);
					//la parte de la hora la multiplicamos por 60 para pasarla a minutos y así realizar la suma de los minutos totales
					$minutosTotales= ($v_HorasPartes[0] * 60) + $v_HorasPartes[1];
					// echo $minutosTotales;
					
				}else{
					$minutosTotales='19';
					
				}
				 
				$_POST["minutos"]=$minutosTotales;
				$campos=array("minutos");
				$bd->actualiza_(armaupdate('examenes',$campos," id_examen='".$data["id_examen"]."'",'POST'));/*actualizo*/		
				
		}
	}
	
	
	// echo var_dump();
	// exit();
	
  $bd->Commit();
  $bd->close();

?>