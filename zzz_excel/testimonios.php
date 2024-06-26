<?php  header('Content-Type: text/html; charset=UTF-8');
error_reporting(E_ALL);
session_start();

require("../tw7control/class/functions.php");
require("../tw7control/class/class.bd.php"); 
require("../tw7control/class/class.upload.php");
$bd=new BD;

require_once("header.php");
date_default_timezone_set("America/Lima");
ini_set("memory_limit", '12016M');
// phpinfo();

?>
<!-- FORMULARIO PARA ESTE EJERCICIO -->
<div class="container">
<h2 style="padding-top:40px;">Cargar e importar archivo excel a Base de Datos: Testimonios: educaauge.com</h2>
<form name="importa" method="post" action="" enctype="multipart/form-data" >
	<div class="col-sm-4">
		<?php crearselect("id_cate","select * from categorias_testimonios_v2_s where estado_idestado=1 order by orden asc",'class="form-control"',''," -- categoria --"); ?>
	</div>
							
  <div class="col-xs-4">
    <div class="form-group">
      <input type="file" class="filestyle" data-buttonText="Seleccione archivo" name="excel">
    </div>
  </div>
  <div class="col-xs-2">
    <input class="btn btn-default btn-file" type='submit' name='enviar'  value="Importar"  />
  </div>
  <input type="hidden" value="upload" name="action" />
  <input type="hidden" value="usuarios" name="mod">
  <input type="hidden" value="masiva" name="acc">
</form>

<!-- PROCESO DE CARGA Y PROCESAMIENTO DEL EXCEL-->
<?php 
extract($_POST);
if (isset($_POST['action'])) {
$action=$_POST['action'];
}

if (isset($action)== "upload"){
	
$_POST['estado_idestado']=1;
$_POST['fecha_registro']=fecha_hora(2);

//cargamos el fichero
$archivo = $_FILES['excel']['name'];
$tipo = $_FILES['excel']['type'];
$destino = "testi_".$archivo;//Le agregamos un prefijo para identificarlo el archivo cargado
if (copy($_FILES['excel']['tmp_name'],$destino)) echo "Archivo Cargado Con Éxito";
else echo "Error Al Cargar el Archivo";
		
if (file_exists ("testi_".$archivo)){ 
/** Llamamos las clases necesarias PHPEcel */
require_once('classes/PHPExcel.php');
require_once('classes/PHPExcel/Reader/Excel2007.php');					
// Cargando la hoja de excel
$objReader = new PHPExcel_Reader_Excel2007();
$objPHPExcel = $objReader->load("testi_".$archivo);
$objFecha = new PHPExcel_Shared_Date();       
// Asignamon la hoja de excel activa
$objPHPExcel->setActiveSheetIndex(0);

// Importante - conexión con la base de datos 


// Rellenamos el arreglo con los datos  del archivo xlsx que ha sido subido
$columnas = $objPHPExcel->setActiveSheetIndex(0)->getHighestColumn();
$filas = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();

//Creamos un array con todos los datos del Excel importado
for ($i=2;$i<=$filas;$i++){
	$_DATOS_EXCEL[$i]['dni'] = $objPHPExcel->getActiveSheet()->getCell('A'.$i)->getCalculatedValue();
	$_DATOS_EXCEL[$i]['region'] = $objPHPExcel->getActiveSheet()->getCell('B'.$i)->getCalculatedValue();
	$_DATOS_EXCEL[$i]['ugel'] = $objPHPExcel->getActiveSheet()->getCell('C'.$i)->getCalculatedValue();
	$_DATOS_EXCEL[$i]['ap_pa'] = $objPHPExcel->getActiveSheet()->getCell('D'.$i)->getCalculatedValue();
	$_DATOS_EXCEL[$i]['ap_ma'] = $objPHPExcel->getActiveSheet()->getCell('E'.$i)->getCalculatedValue();
	$_DATOS_EXCEL[$i]['nombre']= $objPHPExcel->getActiveSheet()->getCell('F'.$i)->getCalculatedValue();
	
	$_DATOS_EXCEL[$i]['competencia']= $objPHPExcel->getActiveSheet()->getCell('G'.$i)->getCalculatedValue();
	$_DATOS_EXCEL[$i]['puntaje_prueba'] = $objPHPExcel->getActiveSheet()->getCell('H'.$i)->getCalculatedValue();
	$_DATOS_EXCEL[$i]['puntaje_trayectoria'] = $objPHPExcel->getActiveSheet()->getCell('I'.$i)->getCalculatedValue();
	$_DATOS_EXCEL[$i]['bonificacion_discapacidad'] = $objPHPExcel->getActiveSheet()->getCell('J'.$i)->getCalculatedValue();
	$_DATOS_EXCEL[$i]['puntaje_final'] = $objPHPExcel->getActiveSheet()->getCell('K'.$i)->getCalculatedValue();
	$_DATOS_EXCEL[$i]['escala'] = $objPHPExcel->getActiveSheet()->getCell('L'.$i)->getCalculatedValue();
	// $_DATOS_EXCEL[$i]['dni'] = 1;
}		
$errores=0;


foreach($_DATOS_EXCEL as $campo => $valor){
	// $sql = "INSERT INTO excel  (nombres,apellidos,genero,carrera,edad,email,dni)  VALUES ('";
	// foreach ($valor as $campo2 => $valor2){
		// $campo2 == "dni" ? $sql.= $valor2."');" : $sql.= $valor2."','";
	// }
	// $result = mysqli_query($con, $sql);
	// if (!$result){
			// echo "Error al insertar registro ".$campo;$errores+=1;
	// }
	
	$_POST['dni']='';
	$_POST['region']='';
	$_POST['ugel']='';
	$_POST['ap_pa']='';
	$_POST['ap_ma']='';
	$_POST['nombre']='';
	$_POST['competencia']='';
	$_POST['puntaje_prueba']='';
	$_POST['puntaje_trayectoria']='';
	$_POST['bonificacion_discapacidad']='';
	$_POST['puntaje_final']='';
	$_POST['escala']='';
	$existe='';
	

	foreach ($valor as $campo2 => $valor2){
		// $campo == "activo" ? $sql.= $valor2."');" : $sql.= $valor2."','";
		$_POST[$campo2]=$valor2;	
	}
	
	$_POST["titulo"]=$_POST["nombre"].' '.$_POST["ap_pa"].' '.$_POST["ap_ma"];
	$urlrewrite=armarurlrewrite($_POST["titulo"]);
  $_POST['titulo_rewrite']=armarurlrewrite($urlrewrite,1,"testimonios_v2_s","id_testimonio","titulo_rewrite",'');

	
	$campos=array('id_cate','titulo','titulo_rewrite','dni','region','ugel','ap_pa','ap_ma','nombre','competencia','puntaje_prueba','puntaje_trayectoria','puntaje_final','bonificacion_discapacidad','escala','estado_idestado','fecha_registro');
	$result= $bd->inserta_(arma_insert('testimonios_v2_s',$campos,'POST'));
	if ($result >0){
		echo " <p>Registro CORRECTO ".$campo.' </p>';
		$errores+=1;
	}
	
		
}	
					/////////////////////////////////////////////////////////////////////////	
					
					
echo "<hr> <div class='col-xs-12'>
    	<div class='form-group'><strong><center>ARCHIVO IMPORTADO CON EXITO, EN TOTAL $campo REGISTROS Y $errores ERRORES</center></strong></div>
</div>  ";

//Borramos el archivo que esta en el servidor con el prefijo testi_
unlink($destino);
			
				
				
	}else{	//si por algun motivo no cargo el archivo testi_ 
		echo "Primero debes cargar el archivo con extencion .xlsx";
	} /* end si existe el archivo */
} /* si se acgivo el upload */
?>

<?php 

/* mostrar listado de registros que se contenia el excel */
			// if (isset($action)) {
// $filas = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();
				// }
			// if (isset($filas)) {
// $columnas = $objPHPExcel->setActiveSheetIndex(0)->getHighestColumn();
				// }
			// if (isset($filas)) {
// $filas = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();
				// }

// if (isset($action)== "upload"){
// echo '<table border="1" class="table">';
	// echo '<thead>';
		// echo '<tr>'; 
			// echo '<th>Nombres</th>'; 
			// echo '<th>Apellidos</th>';
				// echo '<th>Genero</th>';
				// echo '<th>Edad</th>';
				// echo '<th>Carrera</th>';
				// echo '<th>E-Mail</th>';

			// echo '</tr> ';
		// echo '</thead> ';
		// echo '<tbody> ';

// $count=0;
// foreach ($objPHPExcel->setActiveSheetIndex(0)->getRowIterator() as $row) {
    // $count++;
    // $cellIterator = $row->getCellIterator();
    // $cellIterator->setIterateOnlyExistingCells(false);
    // echo '<tr>';
    // foreach ($cellIterator as $cell) {
        // if (!is_null($cell)) {
            // $value = $cell->getCalculatedValue();
            // echo '<td>';
            // echo $value . ' ';
            // echo '</td>';
        // }
    // }
    // echo '</tr>';
// }
  // echo '</tbody>';
  // echo '</table>';
// }


 echo '</div>';
include ("footer.php");
?>
