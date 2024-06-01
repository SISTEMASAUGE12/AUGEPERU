<?php  error_reporting(0);
session_start();
include_once("../intranet/class/functions.php");
include_once("../intranet/class/class.bd.php"); 
$bd=new BD;
$result_destino="perdon";

//like++
if(!empty($_POST["destinoenvio"])){  
  $recibido=$_POST["destinoenvio"];  
}else{

}

if(!empty($_POST["destinoenvio"]) ){
	
  if(!empty($_SESSION["suscritos"]["id_suscrito"])){
		
		if($_POST["destinoenvio"]=='3'){
			//si agrega tiendas craer una tabala y recorrerarlas aquí
			$msj.= '<option value=""  selected="selected">-- Seleccionar tienda (*) --</option>';
			$options.= '<option value="1000">Av. Próceres de la Independencia #2490 - SJL</option> ';
			$options.= '<option value="1001">Av Canto Grande. Prdro 19 de las Flores (al costado de plaza vea) SJL</option> ';
			$result_destino= $msj.$options;
		}else{
			$sql="select * from precio_envios where estado_idestado=1 and tipo=".$recibido." order by titulo asc";				
			$nombre='id_envio';
			$sqlQuery=$sql;
			$agregados='class="seleccionando_destino" ';
			$buscado="";
			if($recibido==1){			
				$optioninicial="-- Seleccione provincia (*) --";				
			}else{
				$optioninicial="-- Seleccione distrito (*) --";							
			}		
			$bd = new BD();		
			$result = executesql($sqlQuery);
			// $msj= '<select name="'.$nombre.'" id="'.strtr($nombre,array('[]' =>'')).'" '.$agregados.'>';//ese array sirve para marcar los campos ya selecionados. al momento ed editar		
			if($optioninicial!="") $msj.= '<option value=""  selected="selected">'.$optioninicial.'</option>';
			$buscado=!is_array($buscado) ? array($buscado) : $buscado;
			if(!empty($result)){
				$options='';
				foreach($result as $row){ 	
					$valor=(!empty($row["costo_promo"]) && $row["costo_promo"]!='0.00')?$row["costo_promo"]:$row["precio"];
					// $options.= '<option id="valorenvio_'.$valor.'" class="valordelenvio" value="'.$row["id_envio"].'" >'.$row["titulo"].'</option> ';
					$options.= '<option value="'.$row["id_envio"].'" >'.$row["titulo"].'</option> ';
				}
			}		
			$result_destino= $msj.$options;
			
		}
		
  }else{ //para no suscritos
      $result_destino="Por favor inicie sesión...";      
  } 
  $bd->close();
  echo json_encode(array(    
    "result_destino" => $result_destino  
  )); 
}   
?>