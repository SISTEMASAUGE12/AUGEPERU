<?php error_reporting(E_ALL ^ E_NOTICE);
include ("auten.php");

  $bd = new BD;
  $bd->Begin();
 
/* Recorro las preguntas del bnaco seleecionadas */
$sql="select * from webinars_x_leads WHERE ide BETWEEN 6826 and 7147 order by orden asc ";

	
	$leads_wwebi=executesql($sql);
	if( !empty($leads_wwebi) ){
			$_POST["estado_idestado"]=1;
			$_POST["fecha_registro"]=fecha_hora(1);
			$_POST["orden"]=_orden_noticia("","suscritos","");

		foreach($leads_wwebi as $data){
			
			
				$sql_x= "select * from suscritos where email='".$data["email"]."' "; 
				$vallogingoo=executesql($sql_x);
				
				// si no existe un liente con este mail, lo registramos 
				if(empty($vallogingoo)){
					
					echo "aaa";
					
					$_POST["email"]=$data["email"];
					$_POST["telefono"]=$data["telefono"];
					$_POST["nombre"]=$data["nombre_completo"];
					
					// Registramos nuevo cliente 
					// si no existe cleinte, registramos nuevo cliente 
					$_POST['clave']=md5($_POST['email']);
					$campos=array("email","clave",'telefono','nombre',"fecha_registro","orden","estado_idestado");
					// echo var_dump(arma_insert("suscritos",$campos,"POST"));
					// exit();
					
					$insertado=$bd->inserta_(arma_insert("suscritos",$campos,"POST"));
					
					
				}
			
		}
	}
	
	
	// echo var_dump();
	// exit();
	
  $bd->Commit();
  $bd->close();

?>