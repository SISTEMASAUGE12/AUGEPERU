<?php error_reporting(E_ALL ^ E_NOTICE);
include ("auten.php");

  $bd = new BD;
  $bd->Begin();
 
/* Recorro las preguntas del bnaco seleecionadas */
$sql="select * from cursos WHERE id_tipo=1 and  estado_idestado=1 order by orden asc ";

	
	$leads_wwebi=executesql($sql);
	if( !empty($leads_wwebi) ){

		foreach($leads_wwebi as $data){
			
		
				$_POST["id_curso"]=$data["id_curso"];
				$_POST["id_suscrito"]='27';
				$_POST["id_tipo"]='1';
				$_POST["id_pedido"]='0';
				$_POST["validez_meses"]='12';
				$_POST["estado"]='1';
				$_POST["gratis"]='2';
				$_POST["fecha_registro"]=fecha_hora(2);
				$_POST["estado_idestado"]='1';
				
		$campos=array("id_curso",'id_suscrito','id_tipo','id_pedido','validez_meses','estado','gratis','fecha_registro','estado_idestado');
					// echo var_dump(arma_insert("suscritos",$campos,"POST"));
					// exit();
					
										$insertado=$bd->inserta_(arma_insert("suscritos_x_cursos",$campos,"POST"));

					
					// $bd->actualiza_(armaupdate('examenes',$campos," id_examen='".$data["id_examen"]."'",'POST'));/*actualizo*/
					
					
			
		}
	}
	
	
	// echo var_dump();
	// exit();
	
  $bd->Commit();
  $bd->close();

?>