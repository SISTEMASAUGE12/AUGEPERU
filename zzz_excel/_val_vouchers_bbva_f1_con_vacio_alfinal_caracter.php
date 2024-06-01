<?php  header('Content-Type: text/html; charset=UTF-8');
error_reporting(0);
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
<h2 style="padding-top:10px;"> 
	<b>Vouchers BBVA </b>: <?php echo fecha_hora(1); ?>  </br>
	<small>Cargar archivo *excel depurado y selecciona el rango de fecha a consultar. </br> 
	<span style="color:red;">* recomendación: verificar por día. </span> 
</h2>
<form name="importa" method="post" action="" enctype="multipart/form-data" >
	<div class="col-sm-3 ">
		<div class="lleva_flechas" style="position:relative;">
			<label>Desde:</label>
			<?php create_input('date', 'fechabus_1', '', "form-control pull-right", '', ''); ?>
		</div>
	</div>
	<div class="col-sm-3 ">
		<div class="lleva_flechas" style="position:relative;">
			<label>Hasta:</label>
			<?php create_input('date', 'fechabus_2', '', "form-control pull-right", '', ''); ?>
		</div>	
	</div>
	
  <div class="col-xs-4">
		<div class="form-group">
			<label>Archivo .xlsx </label>
			<input type="file" class="filestyle" data-buttonText="Seleccione archivo" name="excel">
    </div>
  </div>
  <div class="col-xs-2">
		<label> </label>
    <input class="btn btn-default btn-file" type='submit' name='enviar' style="background:red;color:#fff; padding: 10px 20px;" value="VALIDAR"  />
  </div>
  <input type="hidden" value="upload" name="action" />
  <input type="hidden" value="usuarios" name="mod">
  <input type="hidden" value="masiva" name="acc">
	<hr>
	<hr>
</form>

<!-- PROCESO DE CARGA Y PROCESAMIENTO DEL EXCEL-->
<?php 
extract($_POST);
if (isset($_POST['action'])) {
$action=$_POST['action'];
}

if (isset($action)== "upload"  ){
	if ( !empty($_POST["fechabus_1"]) && !empty($_POST["fechabus_2"]) ){
	
	$_POST['estado_idestado']=1;
	$_POST['fecha_registro']=fecha_hora(2);

	//cargamos el fichero
	$archivo = $_FILES['excel']['name'];
	$tipo = $_FILES['excel']['type'];
	$destino = "bbva_".$archivo;//Le agregamos un prefijo para identificarlo el archivo cargado
	if (copy($_FILES['excel']['tmp_name'],$destino)) echo "Archivo Cargado Con Éxito <hr><hr>";
	else echo "Error Al Cargar el Archivo <hr><hr>";
			
	if (file_exists ("bbva_".$archivo)){ 
			/** Llamamos las clases necesarias PHPEcel */
			require_once('classes/PHPExcel.php');
			require_once('classes/PHPExcel/Reader/Excel2007.php');					
			// Cargando la hoja de excel
			$objReader = new PHPExcel_Reader_Excel2007();
			$objPHPExcel = $objReader->load("bbva_".$archivo);
			$objFecha = new PHPExcel_Shared_Date();       
			// Asignamon la hoja de excel activa
			$objPHPExcel->setActiveSheetIndex(0);
			// $objPHPExcel->setActiveSheetIndexByName('Hoja 1');

			// Importante - conexión con la base de datos 


			// Rellenamos el arreglo con los datos  del archivo xlsx que ha sido subido
			$columnas = $objPHPExcel->setActiveSheetIndex(0)->getHighestColumn();
			$filas = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();

			//Creamos un array con todos los datos del Excel importado
			for ($i=1;$i<=$filas;$i++){  // $i numero de linea de donde desea empiece el recorrido 
				$_DATOS_EXCEL[$i]['fecha_banco'] = $objPHPExcel->getActiveSheet()->getCell('A'.$i)->getCalculatedValue();
				$_DATOS_EXCEL[$i]['importe'] = $objPHPExcel->getActiveSheet()->getCell('C'.$i)->getCalculatedValue();
				$_DATOS_EXCEL[$i]['codigo_operacion'] = $objPHPExcel->getActiveSheet()->getCell('E'.$i)->getCalculatedValue();
				
				// $_DATOS_EXCEL[$i]['dni'] = 1;
			}		
			$errores=0;
			$okeys=0;


			foreach($_DATOS_EXCEL as $campo => $valor){
				// $sql = "INSERT INTO excel  (nombres,apellidos,genero,carrera,edad,email,dni)  VALUES ('";
				// foreach ($valor as $campo2 => $valor2){
					// $campo2 == "dni" ? $sql.= $valor2."');" : $sql.= $valor2."','";
				// }
				// $result = mysqli_query($con, $sql);
				// if (!$result){
						// echo "Error al insertar registro ".$campo;$errores+=1;
				// }
				
				$_POST['importe']='';
				$_POST['codigo_operacion']='';
				$existe='';
				
				
				foreach ($valor as $campo2 => $valor2){
					// $campo == "activo" ? $sql.= $valor2."');" : $sql.= $valor2."','";
					$_POST[$campo2]=$valor2;	
				}
				

			/*
				$si_ya_existe=executesql("select * from suscritos where dni='".$_POST['dni']."' and estado_idestado=1  ");
				
				if( empty($si_ya_existe) ){   // sino existe lo registramos 
					$campos=array('idusuario','nombre','telefono','email','estado_idestado','fecha_registro');
					$result= $bd->inserta_(arma_insert('suscritos',$campos,'POST'));
					if ($result >0){
						echo " <p>Registro CORRECTO ".$campo.' </p>';
						$okeys+=1;
					}else{
						$errores+=1;
					}

				}
				*/
				

				if ( $_POST['importe'] >0){ 

					$codigo_1=substr($_POST["codigo_operacion"], 0, -1);  // quitamos el ultimo caracter 
					$codigo_2=substr($_POST["codigo_operacion"], 0, -2); // quitamos 2 caretere al final 


					if (is_numeric($_POST["codigo_operacion"])) {
						$codigo_operacion= $_POST["codigo_operacion"];
						// echo 'A';
						
					}else if(is_numeric($codigo_1)){ // sino es numerico quitamos ultimo carecter que es un vacio o caractere especial 
						$codigo_operacion= $codigo_1;
						// echo 'B';
						
					}else if(is_numeric($codigo_2)){ // sino es numerico quitamos ultimo carecter que es un vacio o caractere especial 
						$codigo_operacion= $codigo_2;
						// echo 'c';
						
					}

			
					// echo '=>'.$codigo_operacion;


					

					$sql_validate="select * from vouchers WHERE id_banco='9' and  DATE(fecha_registro)  BETWEEN  DATE('".$_POST['fechabus_1']."')  and DATE('".$_POST['fechabus_2']."')  and codigo_operacion='".$codigo_operacion."' order by id_vouchers desc  ";

					// echo $sql_validate;
					$existe_voucher=executesql($sql_validate);		
					if( !empty($existe_voucher) ){
						echo " <p style='color:blue;background:yellow;padding:5px ;'>VOUCHER ENCONTRADO COD: ".$_POST['codigo_operacion']." - IMPORTE: ".$_POST['importe']." ::: 
						<b>VENTA: </b> ".$existe_voucher[0]['id_pedido']."  - ESTADO: ".(($existe_voucher[0]['id_pedido']==1)?'APROBADO':'ENPROCESO / RECHAZADO'). "</p>";
						
					}else{
						echo " <p style='color:red;'>VOUCHER NO EXISTE EN BD. COD: ".$_POST['codigo_operacion'].' - IMPORTE: '.$_POST['importe'].' </p>';

					}

					$okeys+=1;
				}else{
					// echo " <p>NO VALIDO COD: ".$_POST['codigo_operacion'].' - IMPORTE: '.$_POST['importe'].' </p>';
					$errores+=1;
				}

					
			}	
								/////////////////////////////////////////////////////////////////////////	
								
								
			echo "<hr>
			<div class='col-xs-12'>
						<div class='form-group'><strong><center>ARCHIVO IMPORTADO CON EXITO, </br> EN TOTAL $okeys VOUCHERS CONSULTADOS VALIDOS Y $errores VOUCHERS NO VALIDOS </center></strong></div>
			</div>  ";

			//Borramos el archivo que esta en el servidor con el prefijo bbva_
			unlink($destino);
						
			
		}else{	//si por algun motivo no cargo el archivo bbva_ 
			echo "<div class='col-xs-12'> <h3 style='color:red;'> Primero debes cargar el archivo con extencion .xlsx </h3> </div> ";
		} /* end si existe el archivo */

	}else{	//si por algun motivo no cargo el archivo bbva_ 
		echo "<div class='col-xs-12'> <h3 style='color:red;'>Primero ingresa el rango de fechas a validar! </h3> </div> ";
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
