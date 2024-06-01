<?php
 error_reporting(E_ALL); session_start();
$hora = time();
header("Pragma: public");  
header("Expires: 0");  
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");  
header("Content-Type: application/force-download");  
header("Content-Type: application/octet-stream");  
header("Content-Type: application/download");  
header("Content-Disposition: attachment;filename=reporte_Clientes_del_curso__".$hora.".xls ");  
header("Content-Transfer-Encoding: binary ");

include_once("class/functions.php");
include_once("class/class.bd.php");

set_time_limit(950);
ini_set('memory_limit', '990M');

$style='mso-number-format:"@";'

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
</head>

<body>
     
<!-- DIV DONDE SE MOSTRARÁ  LA TABLA DE CONTENIDOS -->
     <!--  <div id="contenido"></div> -->
      

<table cellspacing="0" cellpadding="0" width="100%" style="font-size:12px;">
<tr>
<td colspan="16" align="center"><b><font size="+2">Data CLIENTES POR CURSO</font></b></td>
</tr>
                        <tr>
                            <td style='background:#CCC; color:#000'>N.</td>
                            <td style='background:#CCC; color:#000'>FECHA</td>
                            <td style='background:#CCC; color:#000'>COD. CURSO </td>
                            <td style='background:#CCC; color:#000'>CURSO </td>
                            <td style='background:#CCC; color:#000'> ESPECIALIDAD </td>
                            <td style='background:#CCC; color:#000'>DNI</td>
                            <td style='background:#CCC; color:#000'>CLIENTE</td>
                            <td style='background:#CCC; color:#000'>EMAIL</td>						
                            <td style='background:#CCC; color:#000'>CELULAR</td>						
                            <td style='background:#CCC; color:#000'>ID COMPRA</td>						
                            <td style='background:#CCC; color:#000'>S/ TOTAL</td>						
                            <td style='background:#CCC; color:#000'>ASIGNADO POR</td>						
                            <td style='background:#CCC; color:#000'>ESTADO ASIGNACION</td>						
														<!-- 
                            <td style='background:#CCC; color:#000'>Usuario</th>
														-->
                        </tr>


<?php
	 /*consultamos los datos*/
  // echo $_POST["sql"];

	$data=executesql($_GET["sql"]);  // viene del success 

  if( !empty($data) )   {
		$titee=0;
    
foreach($data as $cliente) {
	$titee = $titee + 1;
  // $datos1 = $ros -> id_doce;
  // $datos2 = $cliente["nombre"];

  if($cliente["estado_idestado"]==2){ $cliente["estado_idestado"]= "Deshabilitado";
  }elseif($cliente["estado_idestado"]==1){ $cliente["estado_idestado"]= "Habilitado";
  }else{ $cliente["estado"]= "#no fount."; 
  }
  
  
  if($cliente["id_pedido"] == 0){  // SI FUE ASIGNADO DIRECTAMENTE 

    if( !empty($cliente["idusuario"])){  // se registra apartir del 22/0872022
      $usuario=executesql("select nomusuario from usuario where idusuario='".$cliente['idusuario']."' ");
      $cliente["nombre_corto"]=  $usuario[0]['nomusuario']." -  directamente ";
      
    }else{
      $cliente["nombre_corto"]= "ADMIN/gestion -  directamente ";
      
    }

  }else{

    $cliente["nombre_corto"]= $cliente["nombre_corto"].'  - '; 

    if($cliente["tipo_pago"] == 1){  // SI FUE ASIGNADO DIRECTAMENTE 
      $cliente["nombre_corto"].= "Transferencia";
    }else if($cliente["tipo_pago"] == 2){  // SI FUE ASIGNADO DIRECTAMENTE 
      $cliente["nombre_corto"].=  "Online";
    }else if($cliente["tipo_pago"] == 4){  // SI FUE ASIGNADO DIRECTAMENTE 
      $cliente["nombre_corto"].=  "PAGO MANUAL ";
    }else if($cliente["tipo_pago"] == 3){  // SI FUE ASIGNADO DIRECTAMENTE 
      $cliente["nombre_corto"].= "PAGO EFECTIVO";
    }else {
      $cliente["nombre_corto"].=  ' -- '; 
    }
  
  }

  echo "<tr>";
  echo "<td>$titee</td>";
  echo "<td>".$cliente['fecha_registro']."</td>";
  echo "<td>".$cliente['codigo']."</td>";
  echo "<td>".$cliente['curso']."</td>";
  echo "<td>".$cliente['especialidad']."</td>";

  echo "<td style='$style' >".$cliente['dni']."</td>";
  echo "<td>".$cliente['suscritos']."</td>";
  echo "<td>".$cliente['email']."</td>";
  echo "<td>".$cliente['telefono']."</td>";
  echo "<td>".$cliente['id_pedido']."</td>";
  echo "<td>".$cliente['total']."</td>";
  echo "<td>".$cliente['nombre_corto']."</td>";
  echo "<td>".$cliente['estado_idestado']."</td>";
 
   echo '</tr>';
  } // end for 

  }else{
	  echo "<h3>No Hay Informaci&oacute;n en la Busqueda</h3>";
  }
 ?>
</table>

</body>
</html>