<?php 

error_reporting(E_ALL ^ E_NOTICE);
include ("auten.php");

		$tag_id_campana_shop=''; // Infusion soft api 
		require_once '../vendor/autoload.php';
		require('../vendor/infusionsoft/php-sdk/src/Infusionsoft/Api/ContactService.php');
		//  Infusion
		
$sql="select s.email, c.tag, s.nombre, s.ap_pa, s.ap_ma, s.telefono 
from suscritos_x_cursos sxc 
LEFT JOIN cursos c ON sxc.id_curso=c.id_curso 
LEFT JOIN suscritos s ON sxc.id_suscrito=s.id_suscrito 
where sxc.estado=1 and c.tag!='' and s.email !=''
order by sxc.ide asc
limit 0,500 " ;
		// echo $sql;
		$correo_cliente_api='';

		$recorrer=executesql($sql);
		foreach( $recorrer as $data){
			$tag_id_campana_shop= $data["tag"]; // tag curso
			
			if( $correo_cliente_api != $data["email"] ){

			
					$correo_cliente_api=$_POST['correo']= $data["email"];
						
					
					// 1. API INFUSION CLIENTE: Obtener ID si ya existe o registrar sino esta en infusion aun  
					if( !empty($correo_cliente_api) ){ // si es pago tarjeta y  tenemos correo del cliente  									
						$tagId=2100;	
						$registro_desde="compras_antes_de_integrar_infusion_a_todas_las_ventas";
						$_POST['FirstName']= $data["nombre"];
						$_POST['LastName']= $data["ap_pa"].' '.$data["ap_ma"];
						$_POST['StreetAddress1']='';
						$_POST['Phone1']= $data["telefono"];					
						$_POST['correo']=$data["email"];																				
						include('../inc_api_infusion_compro_curso.php');
					}
		}	 // end validacion del correo reperitdo 
				// // API INFUSION 
					/** end api infusion  */				
																															
										
					// /* 2. API INFUSION ADD TAG CURSO COMPRADO */
					if( !empty($tag_id_campana_shop) && $tag_id_campana_shop > 0  ){ /* si es pago tarjeta y  se detecto los cursos de campaña se activa esta parte */
						include('../inc_api_infusion_compro_curso_todos_tags.php');
					}
						
		
		} // for 								
?>