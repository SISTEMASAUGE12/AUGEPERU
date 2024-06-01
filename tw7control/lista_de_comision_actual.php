<?php 
// segun tabla escalada de comision

/*
$sql_rango="SELECT comision FROM `data_comisiones_rangos` WHERE `limite_x` <= ".$detalles["n_ventas"]." and ".$detalles["n_ventas"]." < `limite_y` and estado_idestado=1 order by id_rango desc "; 
$data_rango = executesql($sql_rango);
if( !empty($data_rango) ){
  $comision_propia= $data_rango[0]["comision"] ;

}else{
  $comision_propia= 0 ;
  
}
*/

/** se cambio a 5 soels x venta , excel ya no */
$comision_propia= $detalles["n_ventas"]  *  $_SESSION["visualiza"]["comision"]; // 21/04723 , valor 5 soles x venta 

?>