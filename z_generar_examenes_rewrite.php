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
				 
				if( !empty($data['titulo']) ){
					
					$where = '';
					$urlrewrite=armarurlrewrite($data["titulo"]);
					$urlrewrite=armarurlrewrite($urlrewrite,1,"examenes","id_examen","titulo_rewrite",$where);

				
					$_POST["titulo_rewrite"]=$urlrewrite;
					$campos=array("titulo_rewrite");
					$bd->actualiza_(armaupdate('examenes',$campos," id_examen='".$data["id_examen"]."'",'POST'));/*actualizo*/		
					
				}
				 
				
		}
	}
	
	
	// echo var_dump();
	// exit();
	
  $bd->Commit();
  $bd->close();

?>