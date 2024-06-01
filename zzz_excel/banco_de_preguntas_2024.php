<?php  session_start();
error_reporting(E_ALL); 

header('Content-Type: text/html; charset=UTF-8');
require("../tw7control/class/functions.php");
require("../tw7control/class/class.bd.php"); 
// require("../tw7control/class/class.upload.php");
$bd=new BD;

require_once("header.php");
date_default_timezone_set("America/Lima");
ini_set("memory_limit", '12016M');
// phpinfo();

?>
<!-- FORMULARIO PARA ESTE EJERCICIO -->
<div class="container">
<h2 style="padding-top:0px;">Importar excel a Base de Datos: <b> Banco de preguntas</b> </h2>
<p>* Paso1: seleccione la categoria de las preguntas, luego adjunte el excel, <b>máximo de 100 lineas</b> por archivo. y Esperar que termine la carga. </p>
<form name="importa" method="post" action="" enctype="multipart/form-data" >
	<div class="col-sm-4">
		<?php crearselect("id_cate","select * from categoria_examenes where estado_idestado=1 order by orden asc",'class="form-control"',''," -- categoria de preguntas --"); ?>
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
for ($i=1;$i<=$filas;$i++){  // $i es la posicion de la linea o fila del excel 
	$_DATOS_EXCEL[$i]['titulo'] = $objPHPExcel->getActiveSheet()->getCell('A'.$i)->getCalculatedValue();
	$_DATOS_EXCEL[$i]['puntos'] = $objPHPExcel->getActiveSheet()->getCell('B'.$i)->getCalculatedValue();
	$_DATOS_EXCEL[$i]['imagen'] = $objPHPExcel->getActiveSheet()->getCell('C'.$i)->getCalculatedValue();
	$_DATOS_EXCEL[$i]['imagen_pre_2'] = $objPHPExcel->getActiveSheet()->getCell('D'.$i)->getCalculatedValue();
	$_DATOS_EXCEL[$i]['solucion_es_video'] = $objPHPExcel->getActiveSheet()->getCell('E'.$i)->getCalculatedValue();
	$_DATOS_EXCEL[$i]['solucion']= $objPHPExcel->getActiveSheet()->getCell('F'.$i)->getCalculatedValue();	
	$_DATOS_EXCEL[$i]['imagen2']= $objPHPExcel->getActiveSheet()->getCell('G'.$i)->getCalculatedValue();


	$_DATOS_EXCEL[$i]['titulo_r1'] = $objPHPExcel->getActiveSheet()->getCell('H'.$i)->getCalculatedValue();
	$_DATOS_EXCEL[$i]['estado_rpta_r1'] = $objPHPExcel->getActiveSheet()->getCell('I'.$i)->getCalculatedValue();
	$_DATOS_EXCEL[$i]['imagen_r1'] = $objPHPExcel->getActiveSheet()->getCell('J'.$i)->getCalculatedValue();
	
	
	$_DATOS_EXCEL[$i]['titulo_r2'] = $objPHPExcel->getActiveSheet()->getCell('K'.$i)->getCalculatedValue();
	$_DATOS_EXCEL[$i]['estado_rpta_r2'] = $objPHPExcel->getActiveSheet()->getCell('L'.$i)->getCalculatedValue();
	$_DATOS_EXCEL[$i]['imagen_r2'] = $objPHPExcel->getActiveSheet()->getCell('M'.$i)->getCalculatedValue();
	
	$_DATOS_EXCEL[$i]['titulo_r3'] = $objPHPExcel->getActiveSheet()->getCell('N'.$i)->getCalculatedValue();
	$_DATOS_EXCEL[$i]['estado_rpta_r3'] = $objPHPExcel->getActiveSheet()->getCell('O'.$i)->getCalculatedValue();
	$_DATOS_EXCEL[$i]['imagen_r3'] = $objPHPExcel->getActiveSheet()->getCell('P'.$i)->getCalculatedValue();
	// $_DATOS_EXCEL[$i]['dni'] = 1;
}		
$errores=0;
$reg_ok=0;
$preguntas_repetidas=0;
$lineas_titulo_en_blanco=0;


$_POST['corregido']=1;
$_POST['estado_idestado']=1;
$_POST['fecha_registro']= fecha_hora(2);

foreach($_DATOS_EXCEL as $campo => $valor){

	$_POST['titulo']='';
	$_POST['puntos']=0;
	$_POST['imagen']='';
	$_POST['imagen_pre_2']='';
	$_POST['solucion_es_video']=2; // default no
	$_POST['solucion']='';
	$_POST['imagen2']='';

	$_POST['titulo_r1']='';
	$_POST['estado_rpta_r1']=2;  // default no
	$_POST['imagen_r1']='';
	
	$_POST['titulo_r2']='';
	$_POST['estado_rpta_r2']=2;
	$_POST['imagen_r2']='';
	
	$_POST['titulo_r3']='';
	$_POST['estado_rpta_r3']=2;
	$_POST['imagen_r3']='';

	$existe='';	

	foreach ($valor as $campo2 => $valor2){
		// $campo == "activo" ? $sql.= $valor2."');" : $sql.= $valor2."','";
		$_POST[$campo2]=$valor2;	
	}


	if( !empty($_POST["titulo"]) ){
		 /** valido que no re se repirta  */
		$bancos_validar = executesql(" select * from preguntas_bancos where titulo='".$_POST["titulo"]."' ");
		if( empty($bancos_validar) ){ // si no existe lo regsitramos en banco preguntas 
			 		
			$urlrewrite=armarurlrewrite($_POST["titulo"]);
			$_POST['titulo_rewrite']=armarurlrewrite($urlrewrite,1,"preguntas_bancos","id_pregunta","titulo_rewrite",'');
			
			$campos=array('id_cate','titulo','titulo_rewrite','puntos','imagen','imagen_pre_2','solucion_es_video','solucion','imagen2','corregido','estado_idestado','fecha_registro');
			$id_pregunta=$_POST['orden'] = $_POST['id_pregunta']= $bd->inserta_(arma_insert('preguntas_bancos',$campos,'POST'));/*inserto hora -orden y guardo imag*/
			/* orden == id_pregunta */
			/* update para guardar el orden */
			$bd->actualiza_(armaupdate('preguntas_bancos',array('orden')," id_pregunta='".$id_pregunta."'",'POST'));/*actualizo*/
		
			/** respuestas  */
			$campos_respuesta_1= array('id_pregunta', array('titulo',$_POST['titulo_r1']), array('estado_rpta',$_POST['estado_rpta_r1']),array('imagen',$_POST['imagen_r1']) ,array('orden',2024) ,'estado_idestado','fecha_registro');
			$bd->inserta_(arma_insert('respuestas_bancos',$campos_respuesta_1,'POST'));
			
			/** respuestas 2 */
			$campos_respuesta_2= array('id_pregunta', array('titulo',$_POST['titulo_r2']), array('estado_rpta',$_POST['estado_rpta_r2']),array('imagen',$_POST['imagen_r2']) ,array('orden',2024) ,'estado_idestado','fecha_registro');
			$bd->inserta_(arma_insert('respuestas_bancos',$campos_respuesta_2,'POST'));
			
			/** respuestas 3 */
			$campos_respuesta_3= array('id_pregunta', array('titulo',$_POST['titulo_r3']), array('estado_rpta',$_POST['estado_rpta_r3']),array('imagen',$_POST['imagen_r3']) ,array('orden',2024) ,'estado_idestado','fecha_registro');
			$bd->inserta_(arma_insert('respuestas_bancos',$campos_respuesta_3,'POST'));
		
		
			if ($id_pregunta >0){
				echo " <br><p>Registro CORRECTO de LINEA: ".$campo.' </p>';
				$reg_ok++;

			}else{
				$errores++; 
			}

		}else{ // si ya  la pregunrta:  es repertida en bd 
			$preguntas_repetidas++;	 
		}

	}else{
		$lineas_titulo_en_blanco++; 
	} // end si titulo es != vacio 
	
	
		
}	
					/////////////////////////////////////////////////////////////////////////	
					
					
		echo "<hr> <div class='col-xs-12'>
				<div class='form-group'><strong><center>ARCHIVO IMPORTADO CON EXITO, EN TOTAL se proceso $campo LINEAS DEL EXCEL <br>
				 $reg_ok REGISTROS exitosos <br>
				$preguntas_repetidas preguntas_repetidas <br>
				$lineas_titulo_en_blanco LINEAS EN BLANCO del excel <br>
				$errores ERRORES
				
				</center></strong></div>
		</div>  ";

		//Borramos el archivo que esta en el servidor con el prefijo testi_
		unlink($destino);
											
	}else{	//si por algun motivo no cargo el archivo testi_ 
		echo "Primero debes cargar el archivo con extencion .xlsx";
	} /* end si existe el archivo */
} /* si se acgivo el upload */



 echo '</div>';
include ("footer.php");
?>
