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


		$cols   = array('USUARIO','BANCO','CUENTA','VENTAS PROPIAS','S/ COMISION PROPIAS','# COMPARTIDAS','S/ COMPARTIDAS','S/ TOTAL COMISION');
		$rows   = array('usuario','banco','cuenta_banco','n_ventas','comision','n_compartidas','total_comision_compartida','total_comision_neta');
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
			
			$row["comision"]= $comision_total_propia= 	$row["n_ventas"]*	$row["comision"]; // comision total propias
			
			// compartidas 
			$sql_compartidas="select sum(pc.estado_idestado) as n_compartidas, sum(pc.comision) as total_comision_compartida 
			FROM pedidos_compartidos pc 
			WHERE pc.estado_idestado=1 and pc.idusuario='".$row["idusuario"]."' ";


			if(!empty( $_SESSION['activate_protection']['fecha_filtro_inicio']) && !empty($_SESSION['activate_protection']['fecha_filtro_fin'])) {
			$sql_compartidas .= " AND DATE(pc.fecha_registro)  BETWEEN  DATE('".$_SESSION['activate_protection']['fecha_filtro_inicio']."')  and DATE('".$_SESSION['activate_protection']['fecha_filtro_fin']."')  ";		
			}

			// echo $sql_compartidas;	
			$ventas_compartidas=executesql($sql_compartidas);
			if(!empty($ventas_compartidas)){
				$row["n_compartidas"]= 	$ventas_compartidas[0]["n_compartidas"];
				$row["total_comision_compartida"]= 	$ventas_compartidas[0]["total_comision_compartida"];
				$row["total_comision_neta"]= 	$ventas_compartidas[0]["total_comision_compartida"]+$comision_total_propia;

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