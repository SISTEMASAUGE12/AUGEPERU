<?php 
include_once('auten.php'); 

    $ubic   = 'index.php?page=contacto&module=Contacto&parenttab=';//sino existe la sesion me manda aqui
if(isset($_SESSION['activate_protection']) && $_SESSION['activate_protection'][0] == true)
{
  $tipo_form = $_SESSION['activate_protection'][1]; 
  if($tipo_form == 1)
  {
    $sql = " 
		select s.idusuario, s.id_especialidad, s.fecha_atendido, wxl.*, w.titulo as webinar, w.titulo_rewrite as webinar_rew FROM webinars_x_leads wxl 
		LEFT JOIN webinars w ON wxl.id_webinar=w.id_webinar  
		LEFT JOIN suscritos s ON wxl.email= s.email   
		where wxl.id_webinar=".$_SESSION['activate_protection'][2]." and wxl.id_suscrito=0 and (s.idusuario ='' or s.idusuario is NULL)  order by wxl.orden desc ";
		
		// echo $sql;		
		// cietnes nuevos. limpios , que no tienen un usuario asignado ; el otro exlce  es q si tenian un usuario asignado talcvez x el algoritmo automatico; y a esos en el otro excel se les reseteo usuario a null .


	
		$exsql    = executesql($sql);


  	  	$name_archivo  = 'Reporte_Leads_webinar_'.$exsql[0]['webinar_rew'];
    	$title  = 'Reporte de Leads NUEVOS - no extan en el sistema : '.$exsql[0]['webinar'];
		$cols   = array('NOMBRE','EMAIL','CELULAR','TIPO');
		$rows   = array('nombre_completo','email','telefono','tipo');
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
			if($row["tipo"] == 1){
				$row["tipo"]="NOMBRADO";
			}elseif($row["tipo"] == 2){
				$row["tipo"]="CONTRATADO";
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
  }
}
echo '<script>window.location.href="'.$ubic.'";</script>';
?>