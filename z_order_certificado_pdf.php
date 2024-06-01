<?php error_reporting(E_ALL ^ E_NOTICE);
include ("auten.php");

  $bd = new BD;
  $bd->Begin();
 

/* Recorro las preguntas del bnaco seleecionadas */
	$sql=" select * from suscritos_x_certificados WHERE  estado=1 and  estado_idestado=1 order by ide asc ";
	$leads_wwebi=executesql($sql);
	if( !empty($leads_wwebi) ){
		foreach($leads_wwebi as $data){
				 $orden=0;
				$data= executesql(" select * from  suscritos_x_certificados where id_certificado='".$data["id_certificado"]."' and  order_pdf is NULL  and estado=1 and  estado_idestado=1  ");
				if( !empty($data) ){
						foreach( $data as $row){
							$_POST["order_pdf"]=  $orden +1 ;
							$campos=array("order_pdf");
							$bd->actualiza_(armaupdate('suscritos_x_certificados',$campos," ide='".$row["ide"]."'",'POST'));/*actualizo*/		
							$orden++;
						}
				}



			
		}
	}
	
	
	// echo var_dump();
	// exit();
	
  $bd->Commit();
  $bd->close();

?>