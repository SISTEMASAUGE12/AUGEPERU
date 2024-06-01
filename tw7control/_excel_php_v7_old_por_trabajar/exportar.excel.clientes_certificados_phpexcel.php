<?php 
include_once('auten.php'); 

    $ubic   = 'index.php?page=contacto&module=Contacto&parenttab=';//sino existe la sesion me manda aqui
if(isset($_SESSION['activate_protection']) && $_SESSION['activate_protection'][0] == true)
{
   $tipo_form = $_SESSION['activate_protection'][1]; 
	
  if($tipo_form == 1)
  {
    
		$sql=$_SESSION['activate_protection']['sql']; 	
		// echo $sql;
	// exit(); 
		$exsql    = executesql($sql);

    $name_archivo  = 'Reporte_clientes_certificados_'.$_SESSION['activate_protection']['fecha_filtro_inicio'].'_al_'.$_SESSION['activate_protection']['fecha_filtro_fin'];
    $title  = 'Reporte de Clientes de Certificados: '.$_SESSION['activate_protection']['fecha_filtro_inicio'].' al '.$_SESSION['activate_protection']['fecha_filtro_fin'];


		$cols   = array('FECHA','CODIGO','CERTIFICADO','ESPECIALIDAD','DNI','CLIENTE','EMAIL','CELULAR','ID COMPRA','S/total','ASIGNADO POR','ESTADO ASIGNACION','DPTO','PROV','DISTRITO','DIRECCION DESTINO','AGENCIA');
		$rows   = array('fecha_registro','codigo','certificado','especialidad','dni','suscritos','email','telefono','id_pedido','total','nombre_corto','estado_idestado','iddpto','idprvc','iddist','direccion_solicitud','agencia');
  }
	
  $tc_l1    = count($cols)-1;
	if(!empty($exsql))
	{
    require 'class/PHPExcel.php';
		$objPHPExcel = new PHPExcel();
		
		$objPHPExcel->getProperties()
			->setCreator('Tuweb7')
			->setLastModifiedBy('Tuweb7')
			->setTitle($title);

		$letter = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
		for($x=0;$x<=$tc_l1; $x++) $objPHPExcel->getActiveSheet()->getColumnDimension($letter[$x])->setAutoSize(true); //->setWidth(5);
		
		$objPHPExcel->getActiveSheet()->getStyle('A1:'.$letter[$tc_l1].'1')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('A1:'.$letter[$tc_l1].'1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$objPHPExcel->getActiveSheet(0)->setCellValue('A1', mb_convert_case($title,MB_CASE_UPPER,'UTF-8'));

    foreach($cols as $i => $v) $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,3,$v);

		$objPHPExcel->getActiveSheet(0)->mergeCells('A1:'.$letter[$tc_l1].'1');
		
		$styleFont    = array('font' => array('color' => array('rgb' => '333333'),'size' => 11));
    $styleGetFill = array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => 'F2F2F2') );
		for($x=0;$x<=$tc_l1; $x++)
		{
			$objPHPExcel->getActiveSheet()->getStyle($letter[$x]. 3)->getFill()->applyFromArray($styleGetFill);
			$objPHPExcel->getActiveSheet()->getStyle($letter[$x])->applyFromArray($styleFont);
		}
		$styleBorder  = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000'))));
		$objPHPExcel->getActiveSheet()->getStyle('A3:'.$letter[$tc_l1].'3')->applyFromArray($styleBorder);
		
		$i = 4;
    foreach($exsql as $k1 => $row)
    {
			
			$row["dni"] = strval($row["dni"]);


			if($row["estado_idestado"]==2){ 
				$row["estado_idestado"]= "Deshabilitado";
			}elseif($row["estado_idestado"]==1){ 
				$row["estado_idestado"]= "Habilitado";
			}else{ 
				$row["estado"]= "#no fount."; 
			}
			
			
			if($row["id_pedido"] == 0){  // SI FUE ASIGNADO DIRECTAMENTE 

					if( !empty($row["idusuario"])){  // se registra apartir del 22/0872022
						$usuario=executesql("select nomusuario from usuario where idusuario='".$row['idusuario']."' ");
						$row["nombre_corto"]=  $usuario[0]['nomusuario']." -  directamente ";
						
					}else{
						$row["nombre_corto"]= "ADMIN/gestion -  directamente ";
						
					}
		
			}else{
						$row["nombre_corto"]= $row["nombre_corto"].'  - '; 
			
						if($row["tipo_pago"] == 1){  // SI FUE ASIGNADO DIRECTAMENTE 
							$row["nombre_corto"].= "Transferencia";
						}else if($row["tipo_pago"] == 2){  // SI FUE ASIGNADO DIRECTAMENTE 
							$row["nombre_corto"].=  "Online";
						}else if($row["tipo_pago"] == 4){  // SI FUE ASIGNADO DIRECTAMENTE 
							$row["nombre_corto"].=  "PAGO MANUAL ";
						}else if($row["tipo_pago"] == 3){  // SI FUE ASIGNADO DIRECTAMENTE 
							echo "PAGO EFECTIVO";
						}else {
							$row["nombre_corto"].=  ' -- '; 
						}
			}
			


			// seguimiento. 
			$segui=executesql("select * from solicitudes where estado_idestado=1 and id_pedido='".$row["id_pedido"]."' and id_certificado='".$row["id_certificado"]."' ");

			if( !empty($segui[0]["direccion"]) ){
				$row["direccion_solicitud"]=  $segui[0]['direccion'];	
				
			}else{
				$row["direccion_solicitud"]=  ' puede ser una venta no manual';	

			}
		
			if( !empty($segui[0]["agencia"]) ){
				$row["agencia"]=  $segui[0]['agencia'];	
				
			}else{
				$row["agencia"]=  ' puede ser una venta no manual';	

			}
		
		
			if( !empty($segui[0]["iddpto"]) ){
				$dpto=executesql("select titulo from dptos where iddpto='".$segui[0]['iddpto']."' ");
				$row["iddpto"]=  $dpto[0]['titulo'];	
				
			}else{
				$row["iddpto"]=  ' - no tiene ubigeo enviado, puede ser una venta no manual';	

			}
		

			if( !empty($segui[0]["idprvc"]) ){
				$prvc=executesql("select titulo from prvc where idprvc='".$segui[0]['idprvc']."' ");
				$row["idprvc"]=  $prvc[0]['titulo'];	
				
			}else{
				$row["idprvc"]=  ' - no tiene ubigeo enviado, puede ser una venta no manual';	

			}
		

			if( !empty($segui[0]["iddist"]) ){							
				$dist=executesql("select titulo from dist where iddist='".$segui[0]['iddist']."' ");
				$row["iddist"]=  $dist[0]['titulo'];		
				
			}else{
				$row["iddist"]=  ' - no tiene ubigeo enviado, puede ser una venta no manual';	

			}
		
		
			


				
      foreach($rows as $k2 => $v)
      {
        if(is_array($v))
        {
          if(isset($v[1]['fecha']))
            $a_mostrar = date($v[1]['fecha'],strtotime($row[$v[0]]));
          elseif(isset($v[1]['opciones']))
            $a_mostrar = $v[1]['opciones'][$row[$v[0]]];
        }
        else
          $a_mostrar = $row[$v];

        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($k2,$i,$a_mostrar);
      }

			$objPHPExcel->getActiveSheet()->getStyle('A'.$i.':'.$letter[$tc_l1].$i)->applyFromArray($styleBorder);
			$objPHPExcel->getActiveSheet()->getStyle('A'.$i.':'.$letter[$tc_l1].$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
			$objPHPExcel->getActiveSheet()->setBreak('A'.$i, PHPExcel_Worksheet::BREAK_ROW );

			++$i;
    }
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="'.$name_archivo.'.xlsx"');
    header('Cache-Control: max-age=0');

    $objWriter=PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel2007');
    $objWriter->save('php://output');
    exit;
		
  }else{ /* si la consulta devuvle vacia .. */ 
		echo "Cero registros encontrados ";
    exit;
	}
}
echo '<script>window.location.href="'.$ubic.'";</script>';
?>