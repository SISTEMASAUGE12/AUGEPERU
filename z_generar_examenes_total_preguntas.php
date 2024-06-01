<?php error_reporting(E_ALL ^ E_NOTICE);
include ("auten.php");

  $bd = new BD;
  $bd->Begin();
 
$sql="select * from examenes WHERE  id_examen BETWEEN 1742 and 1840 and estado_idestado=1 and total_preguntas is NULL  order by orden asc  ";

	
	$leads_wwebi=executesql($sql);
	if( !empty($leads_wwebi) ){

		foreach($leads_wwebi as $data){
			
			
				$sql_x= "SELECT count(*) as total_preguntas FROM `preguntas` WHERE id_examen ='".$data["id_examen"]."' "; 
				// exit();
				
				$vallogingoo=executesql($sql_x,0);
				
				// si no existe un liente con este mail, lo registramos 
				if( !empty($vallogingoo)){
					$_POST["total_preguntas"]=$vallogingoo["total_preguntas"];
				
				}else{
					$_POST["total_preguntas"]=0;
					
				}
				
					$campos=array("total_preguntas");
					// echo var_dump(arma_insert("suscritos",$campos,"POST"));
					// exit();
					
					$bd->actualiza_(armaupdate('examenes',$campos," id_examen='".$data["id_examen"]."'",'POST'));/*actualizo*/
					
					
			
		}
	}
	
	
	// echo var_dump();
	// exit();
	
  $bd->Commit();
  $bd->close();

?>