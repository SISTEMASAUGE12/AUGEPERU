<?php
 error_reporting(E_ALL); session_start();
$hora = time();
header("Pragma: public");  
header("Expires: 0");  
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");  
header("Content-Type: application/force-download");  
header("Content-Type: application/octet-stream");  
header("Content-Type: application/download");  
header("Content-Disposition: attachment;filename=DataUsuarios_".$hora.".xls ");  
header("Content-Transfer-Encoding: binary ");

include_once("tw7control/class/functions.php");
include_once("tw7control/class/class.bd.php");

set_time_limit(950);
ini_set('memory_limit', '990M');
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
</head>

<body>
     
<!-- DIV DONDE SE MOSTRARÁ  LA TABLA DE CONTENIDOS -->
     <!--  <div id="contenido"></div> -->
      
      <?php
	 /*consultamos los datos*/
//$sqlt="SELECT d.id_doce, d.nombres, d.dni, d.correo, d.celular, d.especialidad, d.departamento, d.fecha_reg, d.hora_reg, d.usuario, d.estado, d.escala FROM docentes AS d ORDER BY d.id_doce DESC";
 $sql= "SELECT s.*, YEAR(s.fecha_registro) as anho, MONTH(s.fecha_registro) as mes, e.nombre AS estado, CONCAT(s.nombre,' ',s.ap_pa,' ',s.ap_ma )as suscritos, ep.titulo as especialidad    
	FROM suscritos s 
  INNER JOIN estado e ON s.estado_idestado=e.idestado 
  LEFT JOIN especialidades ep ON s.id_especialidad=ep.id_especialidad ";
	$data=executesql($sql);
	
	  ?>
<table cellspacing="0" cellpadding="0" width="100%" style="font-size:12px;">
<tr>
<td colspan="16" align="center"><b><font size="+2">Data Usuarios</font></b></td>
</tr>
                        <tr>
                            <td style='background:#CCC; color:#000'>N.</td>
                            <td style='background:#CCC; color:#000'>Nombres</td>
                            <td style='background:#CCC; color:#000'>Apellido P.</td>
                            <td style='background:#CCC; color:#000'>Apellido M.</td>
                            <td style='background:#CCC; color:#000'>Num. Doc.</td>
                            <td style='background:#CCC; color:#000'>Correos</td>
                            <td style='background:#CCC; color:#000'>Celular</td>
                            <td style='background:#CCC; color:#000'>Especialidad</td>
														<!-- 
                            <td style='background:#CCC; color:#000'>Escala</td>
                            <td style='background:#CCC; color:#000'>Departamento</td>
                            <td style='background:#CCC; color:#000'>Provincia</td>
                            <td style='background:#CCC; color:#000'>Distrito</td>
														-->
                            <td style='background:#CCC; color:#000'>Direccion</td>
														<!-- 
                            <td style='background:#CCC; color:#000'>Agencia</td>
														-->
                            <td style='background:#CCC; color:#000'>Fecha Registro</td>
														<!-- 
                            <td style='background:#CCC; color:#000'>Usuario</th>
														-->
                        </tr>
 <?php
  if( !empty($data) )   {
		$titee=0;
foreach($data as $cliente) {
	$titee = $titee + 1;
  // $datos1 = $ros -> id_doce;
  $datos2 = $cliente["nombre"];
  $datos2A = $cliente["ap_pa"];
  $datos2B = $cliente["ap_ma"];
  $datos3 = $cliente["dni"];
  $datos4 = $cliente["email"];
  $datos5 = $cliente["telefono"];
  $datos6 = $cliente["especialidad"];
  // $datos7 = $ros -> departamento;
  $datos8 = $cliente["fecha_registro"];
  // $datos9 = $ros -> hora_reg;
  // $datos10 = $ros -> usuario;
  // $datos11 = $ros -> estado;
  // $datos12 = $ros -> escala;
  
  // $datos13 = $ros -> depa;
  // $datos14 = $ros -> provi;
  // $datos15 = $ros -> distri;
  $datos16 =$cliente["direccion"];
  // $datos17 = $ros -> dire_agencia;
	  
  echo "<tr>";
  echo "<td>$titee</td>";
  echo "<td>$datos2</td>";
  echo "<td>$datos2A</td>";
  echo "<td>$datos2B</td>";
  echo "<td>$datos3</td>";
  echo "<td>$datos4 </td>";
  echo "<td>$datos5</td>";
  echo "<td>$datos6</td>";
  // echo "<td>$datos12</td>";
  // echo "<td>$datos13</td>";
  // echo "<td>$datos14</td>";
  // echo "<td>$datos15</td>";
  echo "<td>$datos16</td>";
  // echo "<td>$datos17</td>";
  echo "<td>$datos8</td>";
  // echo "<td>$datos10</td>";
   echo '</tr>';
  }
  }else{
	  echo "<h3>No Hay Informaci&oacute;n en la Busqueda</h3>";
	  }
 ?>
</table>

</body>
</html>