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


// $cadena = "00775505";
// $cadena = (string)((int)($cadena));
// echo $cadena;

?>
<!-- FORMULARIO PARA ESTE EJERCICIO -->
<div class="container">
<h2 style="padding-top:10px;"> 
	<b>Vouchers BCP </b>: <?php echo fecha_hora(1); ?>  </br>
	<small>Cargar archivo *excel depurado y selecciona el rango de fecha a consultar.  </br> 
		<span style="color:red;">* recomendación: verificar por día. </span> 
	</small>
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
		
		$array_no_estan_en_excel=  array(); // para excel descarga 
		$_POST['estado_idestado']=1;
		$_POST['fecha_registro']=fecha_hora(2);

		echo '<div  class="col-xs-12 "><h4 style="border-bottom:2px solid #333;">Respuesta del: '.$_POST["fechabus_1"].' al '.$_POST["fechabus_2"].' </h4></div>';

		//cargamos el fichero
		$archivo = $_FILES['excel']['name'];
		$tipo = $_FILES['excel']['type'];
		$destino = "bcp_".$archivo;//Le agregamos un prefijo para identificarlo el archivo cargado

	
		if (copy($_FILES['excel']['tmp_name'],$destino)) echo "Archivo Cargado Con Éxito <hr><hr>";
		else echo "Error Al Cargar el Archivo <hr><hr>";
		

				
		if (file_exists ("bcp_".$archivo)){ 
			/** Llamamos las clases necesarias PHPEcel */
			require_once('classes/PHPExcel.php');
			require_once('classes/PHPExcel/Reader/Excel2007.php');					
			// Cargando la hoja de excel
			$objReader = new PHPExcel_Reader_Excel2007();
			$objPHPExcel = $objReader->load("bcp_".$archivo);
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
				$_DATOS_EXCEL[$i]['detalle'] = $objPHPExcel->getActiveSheet()->getCell('C'.$i)->getCalculatedValue();
				// $_DATOS_EXCEL[$i]['importe'] = $objPHPExcel->getActiveSheet()->getCell('C'.$i)->getCalculatedValue();
				// $_DATOS_EXCEL[$i]['codigo_operacion'] = $objPHPExcel->getActiveSheet()->getCell('E'.$i)->getCalculatedValue();

				$_DATOS_EXCEL[$i]['importe'] = $objPHPExcel->getActiveSheet()->getCell('D'.$i)->getCalculatedValue();
				$_DATOS_EXCEL[$i]['codigo_operacion'] = $objPHPExcel->getActiveSheet()->getCell('G'.$i)->getCalculatedValue();
				
				// $_DATOS_EXCEL[$i]['dni'] = 1;
			}		
			$errores=0;
			$okeys=0;
			
			$encontrados_excel=0;
			$no_encontrados_excel=0;
			$no_encontrados_bd=0;


			foreach($_DATOS_EXCEL as $campo => $valor){   // recorremos excel y sus valores 

				$_POST['fecha_banco']='';
				$_POST['importe']='';
				$_POST['detalle']='';
				$_POST['codigo_operacion']='';
				$existe='';
				
				foreach ($valor as $campo2 => $valor2){
					// $campo == "activo" ? $sql.= $valor2."');" : $sql.= $valor2."','";
					$_POST[$campo2]=$valor2;	
				}
				

				if ( $_POST['importe'] >0 && !empty($_POST["codigo_operacion"]) ){ 
					
					$codigo_1= (string)((int)($_POST["codigo_operacion"]));
			
					if(is_numeric($codigo_1)){ // sino es numerico quitamos ultimo carecter que es un vacio o caractere especial 
						$codigo_operacion= $codigo_1;
						// echo 'B'.$codigo_operacion;
						
					}else if(is_numeric($codigo_2)){ // sino es numerico quitamos ultimo carecter que es un vacio o caractere especial 
						$codigo_operacion= $codigo_2;
						// echo 'c';
						
					}
					// echo '=>'.$codigo_operacion;
			
					
					$sql_validate="select * from vouchers WHERE id_banco='8' and  DATE(fecha_registro)  BETWEEN  DATE('".$_POST['fechabus_1']."')  and DATE('".$_POST['fechabus_2']."')  and codigo_operacion='".$codigo_operacion."' order by id_vouchers desc  ";
					
					// echo $sql_validate;
					$existe_voucher=executesql($sql_validate);		
					if( !empty($existe_voucher) ){
						echo " <p style='color:blue;background:yellow;padding:5px ;'>VOUCHER ENCONTRADO COD: ".$_POST['codigo_operacion']." - IMPORTE: ".$_POST['importe']." ::: 
						<b>VENTA: </b> ".$existe_voucher[0]['id_pedido']."  - ESTADO: ".(($existe_voucher[0]['estado_idestado']==1)?'APROBADO':'ENPROCESO / RECHAZADO'). "</p>";
						$encontrados_excel+=1;
						
						// capturo los datos de voucher que no estan en sistema para generar un nuevo archivo excel 
						$array_contenido=array($codigo_operacion); // capturo
						$array_no_estan_en_excel= array_merge($array_no_estan_en_excel, $array_contenido ); // agrego

					}else{
						echo " <p style='color:red;'>VOUCHER NO EXISTE EN BD. COD: ".$_POST['codigo_operacion'].' - IMPORTE: '.$_POST['importe'].' </p>';
						$no_encontrados_excel+=1;					
						$data_excel_no_sistema.= "<tr><td>".$_POST['fecha_banco']."</td><td>".$_POST['detalle']."</td><td>".$_POST['codigo_operacion']."</td><td>".$_POST['importe']."</td></tr>";
					}

					$okeys+=1;

				}else{
					// echo " <p>NO VALIDO COD: ".$_POST['codigo_operacion'].' - IMPORTE: '.$_POST['importe'].' </p>';
					$errores+=1;
				}

					
			}	// end for excel 
			
			
			// echo var_dump($array_no_estan_en_excel);
			// echo implode(',',$array_no_estan_en_excel);
			$sql_resagados_de_bd=" select v.*, u.nomusuario as usuario FROM vouchers v 
														INNER JOIN pedidos p ON v.id_pedido=p.id_pedido
														INNER JOIN usuario u ON p.idusuario=u.idusuario 
														WHERE v.estado_idestado=1 and v.id_banco=8 and  DATE(v.fecha_registro)  BETWEEN  DATE('".$_POST['fechabus_1']."')  and DATE('".$_POST['fechabus_2']."') 
																	and v.codigo_operacion NOT IN ('".implode(',',$array_no_estan_en_excel)."') ";
			 // echo $sql_resagados_de_bd;

			$restantes_del_sistema=executesql($sql_resagados_de_bd); 
			if( !empty($restantes_del_sistema) ){
				foreach($restantes_del_sistema as $no_excel){
					$data_sistema_no_en_excel.= "<tr><td>BCP</td> <td>".$no_excel['fecha_registro']."</td><td>".$no_excel['id_pedido']."</td><td>".$no_excel['codigo_operacion']."</td><td>".$no_excel['total']."</td><td>".$no_excel['usuario']."</td></tr>";
				}
			}
			$sistema_no_encontrados_excel= count($restantes_del_sistema);




			echo "
				<hr>
				<div class='col-xs-12'>
					<div class='form-group'><strong><center>
						<span style='color:blue;'> VOUCHER ENCONTRADOS DEL EXCEL EN SISTEMA: ".$encontrados_excel." </span> </BR> 
						<form action='val_excel_bcp_1_excel_no_encontrado_en_sistema.php' method='post'> ";												
						create_input("hidden","data_excel_no_sistema",$data_excel_no_sistema,"form-control",'',"",'');

			echo "	<span style='color:red;'> VOUCHERS NO ENCONTRADOS DEL EXCEL EN SISTEMA: ".$no_encontrados_excel."
									<button >	[Click para descargar excel] </button> 
							</span> 
						</form> 
						</BR> 

						<form action='val_excel_bcp_2_del_sistema_no_encontrado_en_excel.php' method='post'> ";

						create_input("hidden","data_sistema_no_en_excel",$data_sistema_no_en_excel,"form-control",'',"",'');
			echo "	<span style='color:#fff;background:red;padding:5px 9px;'> VOUCHERS EN SISTEMA NO ENCONTRADOS EN EXCEL: ".$sistema_no_encontrados_excel."
									<button style='color:red;' class='' onClick='fn_excel_sistema_no_excel()' >	[Click para descargar excel] </button> 
							</span>
						</form>
						</BR> 
					</center></strong></div>
				</div>
				<hr>
				<div class='col-xs-12'>
							<div class='form-group'><strong><center>ARCHIVO IMPORTADO CON EXITO, </br> EN TOTAL $okeys VOUCHERS CONSULTADOS VALIDOS Y $errores VOUCHERS NO VALIDOS </center></strong></div>
				</div>
			";

			//Borramos el archivo que esta en el servidor con el prefijo bcp_
			unlink($destino);
						
			
		}else{	//si por algun motivo no cargo el archivo bcp_ 
			echo "<div class='col-xs-12'> <h3 style='color:red;'> Primero debes cargar el archivo con extencion .xlsx </h3> </div> ";
		} /* end si existe el archivo */

	}else{	//si por algun motivo no cargo el archivo bcp_ 
		echo "<div class='col-xs-12'> <h3 style='color:red;'>Primero ingresa el rango de fechas a validar! </h3> </div> ";
	} /* end si existe el archivo */

} /* si se acgivo el upload */
?>

<?php 
 echo '</div>';
include ("footer.php");
?>




