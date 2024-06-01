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

    $name_archivo  = 'Reporte_comisiones__'.$_SESSION['activate_protection']['fecha_filtro_inicio'].'_al_'.$_SESSION['activate_protection']['fecha_filtro_fin'];
    $title  = 'Reporte de Comisiones del: '.$_SESSION['activate_protection']['fecha_filtro_inicio'].' al '.$_SESSION['activate_protection']['fecha_filtro_fin'];


		// $cols   = array('USUARIO','BANCO','CUENTA','VENTAS PROPIAS','# COMPARTIDAS','S/ COMPARTIDAS','S/ TOTAL COMISION');
		// $row   = array('usuario','banco','cuenta_banco','n_ventas','n_compartidas','total_comision_compartida','total_comision_neta');

		$cols   = array('USUARIO','BANCO','CUENTA','VENTAS PROPIAS CURSOS	','# COMPARTIDAS','S/ TOTAL COMISION','COMISIÓN CLIENTE ANTIGUO','VENTAS CERTIFICADOS',' S/ CERTIFICADOS ','TOTAL A PAGAR');
		$rows   = array('usuario','banco','cuenta_banco','n_ventas','n_compartidas','total_comision_neta','comision_cliente_antiguo','total_ventas_certificados','total_soles_certificados','total_a_pagar');
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
    foreach($exsql as $k1 => $detalles)
    {
			
//			$detalles["comision"]= $comision_total_propia= 	$detalles["n_ventas"]*	$detalles["comision"]; // comision total propias
			
			// compartidas 
			$sql_compartidas="select sum(pc.estado_idestado) as n_compartidas, sum(pc.comision) as total_comision_compartida , sum(pc.tipo_compartido=1) as suma_vcompar_externas,  sum(pc.tipo_compartido=2) as suma_vcompar_que_el_realizo
			FROM pedidos_compartidos pc 
			WHERE pc.estado_idestado=1 and pc.idusuario='".$detalles["idusuario"]."' ";


			$sql_cliente_antiguo= 'select SUM(pe.tipo_venta=3) as total_ventas_sin_comision from pedidos pe where pe.estado_pago=1 and pe.estado_idestado=1  and pe.idusuario="'.$detalles["idusuario"].'" ';
				
			
			// ventas certificados   
			$sql_venta_certificados= 'select SUM(pe.categoria_venta=2) as total_venta_certificados from pedidos pe where pe.estado_pago=1 and pe.categoria_venta=2 and pe.estado_idestado=1  and pe.idusuario="'.$detalles["idusuario"].'" ';
						 

			if(!empty( $_SESSION['activate_protection']['fecha_filtro_inicio']) && !empty($_SESSION['activate_protection']['fecha_filtro_fin'])) {
				$sql_compartidas .= " AND DATE(pc.fecha_registro)  BETWEEN  DATE('".$_SESSION['activate_protection']['fecha_filtro_inicio']."')  and DATE('".$_SESSION['activate_protection']['fecha_filtro_fin']."')  ";		

				$sql_cliente_antiguo .= " AND DATE(pe.fecha_registro)  BETWEEN  DATE('".$_SESSION['activate_protection']['fecha_filtro_inicio']."')  and DATE('".$_SESSION['activate_protection']['fecha_filtro_fin']."')  ";	

				$sql_venta_certificados .= " AND DATE(pe.fecha_registro)  BETWEEN  DATE('".$_SESSION['activate_protection']['fecha_filtro_inicio']."')  and DATE('".$_SESSION['activate_protection']['fecha_filtro_fin']."')  ";		

			}


			$detalles["n_compartidas"]=0;
			$total_comision_compartida=0;

			// echo $sql_compartidas;	
			

			$ventas_compartidas=executesql($sql_compartidas);
			if(!empty($ventas_compartidas)){

				$detalles["n_compartidas"]= 	$ventas_compartidas[0]["n_compartidas"];
				// $total_comision_compartida = 	$ventas_compartidas[0]["n_compartidas"] * 1 ;			


				if( $detalles["tipo_asesora"] ==1){ // oficina
					// $_tipo_asesora='5';
					$_tipo_asesora_realizo_ext= $_SESSION["visualiza"]["compartida_el_dueno_cliente_oficina"];

				}else if( $detalles["tipo_asesora"] ==2){ // vendedoras 
					// $_tipo_asesora='8';
					$_tipo_asesora_realizo_ext = $_SESSION["visualiza"]["compartida_el_dueno_cliente_externo"];  // x2 
				}

				$vcomp_realizo= $ventas_compartidas[0]["suma_vcompar_que_el_realizo"] * $_SESSION["visualiza"]["compartida_el_que_ayudo"];
				$vcomp_ext = $ventas_compartidas[0]["suma_vcompar_externas"] * $_tipo_asesora_realizo_ext ; // comision segun tipo: ofi o ventas 


				$total_comision_compartida = 	$vcomp_realizo + $vcomp_ext ;			

			}
			

			// echo $comision cliente antoiguo 
			
			$detalles["comision_cliente_antiguo"] =0;
			$comision_propia=0;
			$ventas_sin_copmision_antiguos=executesql($sql_cliente_antiguo);
			if(!empty($ventas_sin_copmision_antiguos)){
				$detalles["comision_cliente_antiguo"]  = $ventas_sin_copmision_antiguos[0]['total_ventas_sin_comision'];
			}

			
			// echo $comision venta de certificados  			
			$detalles["total_ventas_certificados"] =0;
			$detalles["total_soles_certificados"] =0;

			$venta_certificado=executesql($sql_venta_certificados);
			if(!empty($venta_certificado)){
				$detalles["total_ventas_certificados"]  = $venta_certificado[0]['total_venta_certificados'];
				$detalles["total_soles_certificados"]  = $venta_certificado[0]['total_venta_certificados'] * 1;
				
				// $detalles["total_ventas_certificados"]  = "por_pagar";
				// $detalles["total_soles_certificados"]  = 1;
			}
			



			include("lista_de_comision_actual.php"); // aca sale comiison propia 


			$detalles["total_comision_neta"]=  $comision_propia  + 	$total_comision_compartida; // comison de venta spropias  + ccompartidas 
			$detalles["total_a_pagar"]=  		$detalles["total_comision_neta"]  + 	$detalles["comision_cliente_antiguo"] + $detalles["total_soles_certificados"] ; // comison de venta spropias 
			
      foreach($rows as $k2 => $v)
      {
        if(is_array($v))
        {
          if(isset($v[1]['fecha']))
            $a_mostrar = date($v[1]['fecha'],strtotime($detalles[$v[0]]));
          elseif(isset($v[1]['opciones']))
            $a_mostrar = $v[1]['opciones'][$detalles[$v[0]]];
        }
        else
          $a_mostrar = $detalles[$v];

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