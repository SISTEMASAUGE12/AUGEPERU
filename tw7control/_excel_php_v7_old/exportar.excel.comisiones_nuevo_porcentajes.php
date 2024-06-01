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

		$cols   = array('USUARIO','BANCO','CUENTA','VENTAS PROPIAS	','S/ VENTAS PROPIAS','# COMPARTIDAS','S/ VENTAS COMPARTIDAS','VENTAS CLIENTE ANTIGUO','S/ VENTAS ANTIGUOS',' # CERTIFICADOS ','# LIBROS' ,'TOTAL VENDIDO','TOTAL A PAGAR 1.9%');
		$rows   = array('usuario','banco','cuenta_banco','n_ventas','n_total_soles','suma_vcompar_que_el_realizo','total_venta_soles_compartida','total_ventas_sin_comision','total_ventas_cliente_antiguos','total_ventas_certificados','total_ventas_libros','monto_total_vendido','total_a_pagar'); 
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
			
			// aca sacamos vendas solo ventas propias 	- ventas nuevas		
			$sql_ventas_clientes_nuevos= "	SELECT SUM(tipo_venta) as n_ventas, SUM(total) as n_total_soles, pp.idusuario, uu.nomusuario as usuario, uu.nombre_corto as nombre_corto,  uu.comision, uu.banco, uu.cuenta_banco, uu.tipo_asesora  
				FROM `pedidos` pp 
				LEFT JOIN usuario uu ON pp.idusuario=uu.idusuario 
				where pp.estado_pago=1 and uu.idtipo_usu=4 and pp.tipo_venta=1 and pp.total > 0   and uu.idusuario='".$detalles["idusuario"]." 
			";  


			// venta compartidas

			$sql_compartidas= "	SELECT SUM(pp.estado_idestado) as n_compartidas,  SUM(pp.estado_idestado) as suma_vcompar_que_el_realizo,  SUM(total) as total_venta_soles_compartida, pp.idusuario, uu.nomusuario as usuario, uu.nombre_corto as nombre_corto,  uu.comision, uu.banco, uu.cuenta_banco, uu.tipo_asesora  
							FROM `pedidos` pp 
							LEFT JOIN usuario uu ON pp.idusuario=uu.idusuario 
							where pp.estado_pago=1 and uu.idtipo_usu=4  and pp.estado_idestado=1 and pp.tipo_venta=2  and pp.total > 0 and uu.idusuario='".$detalles["idusuario"]."'  
						";  /* todos los que han comprado, solo salen las aprobadas para facturar */ 


			// ventas clientes antiguos : 
			// solo sumo la de ventas tipo de cursos; nose considerara las ventas de clientes antoguo para certificados ya que se paga una comision aparte por venta de certificado, asi que esas las excluiremos aqui 
			$sql_cliente_antiguo= 'select SUM(pe.tipo_venta=3) as total_ventas_sin_comision, sum(pe.total) as total_ventas_cliente_antiguos from pedidos pe where pe.estado_pago=1 and pe.estado_idestado=1  and pe.idusuario="'.$detalles["idusuario"].'" and pe.total >0  and pe.tipo_venta=3';
				
			// ventas certificados   
			$sql_venta_certificados= 'select SUM(pe.categoria_venta=2) as total_venta_certificados from pedidos pe where pe.estado_pago=1 and pe.categoria_venta=2 and pe.estado_idestado=1  and pe.idusuario="'.$detalles["idusuario"].'" ';
			
			// ventas libros   
			$sql_venta_libros= 'select SUM(pe.id_tipo=2) as total_venta_libros from suscritos_x_cursos pe where pe.estado=1 and pe.id_tipo=2 and pe.estado_idestado=1  and pe.idusuario="'.$detalles["idusuario"].'" ';
				

			if(!empty( $_SESSION['activate_protection']['fecha_filtro_inicio']) && !empty($_SESSION['activate_protection']['fecha_filtro_fin'])) {
				  $sql_ventas_clientes_nuevos .= " AND DATE(pp.fecha_registro)  BETWEEN  DATE('".$_GET['fechabus_1']."')  and DATE('".$_GET['fechabus_2']."')  ";		


				  $sql_compartidas .= " AND DATE(pp.fecha_registro)  BETWEEN  DATE('".$_SESSION['activate_protection']['fecha_filtro_inicio']."')  and DATE('".$_SESSION['activate_protection']['fecha_filtro_fin']."')  ";		

				  $sql_cliente_antiguo .= " AND DATE(pe.fecha_registro)  BETWEEN  DATE('".$_SESSION['activate_protection']['fecha_filtro_inicio']."')  and DATE('".$_SESSION['activate_protection']['fecha_filtro_fin']."')  ";	

				$sql_venta_certificados .= " AND DATE(pe.fecha_registro)  BETWEEN  DATE('".$_SESSION['activate_protection']['fecha_filtro_inicio']."')  and DATE('".$_SESSION['activate_protection']['fecha_filtro_fin']."')  ";		
				
				$sql_venta_libros .= " AND DATE(pe.fecha_registro)  BETWEEN  DATE('".$_SESSION['activate_protection']['fecha_filtro_inicio']."')  and DATE('".$_SESSION['activate_protection']['fecha_filtro_fin']."')  ";		

			}


			$detalles["n_ventas"]=0;
			$detalles["n_total_soles"]=0;
			$detalles["n_compartidas"]=0;
			$detalles["suma_vcompar_que_el_realizo"]=0;
			$total_comision_compartida=0;

			// echo $sql_compartidas;	
			

			$ventas_clientes_nuevos=executesql($sql_ventas_clientes_nuevos);
			if(!empty($ventas_clientes_nuevos)){

				$detalles["n_ventas"]= 	$ventas_clientes_nuevos[0]["n_ventas"];
				$detalles["n_total_soles"]= 	$ventas_clientes_nuevos[0]["n_total_soles"];
			}
			
			
			$ventas_compartidas=executesql($sql_compartidas);
			if(!empty($ventas_compartidas)){

				$detalles["suma_vcompar_que_el_realizo"]= 	$ventas_compartidas[0]["suma_vcompar_que_el_realizo"];
				$total_comision_compartida = $detalles["total_venta_soles_compartida"] = 	$ventas_compartidas[0]["total_venta_soles_compartida"] ;						
			}
			

			// echo $comision cliente antoiguo 
			
			$detalles["total_ventas_cliente_antiguos"] =0;
			$comision_propia=0;
			$ventas_sin_copmision_antiguos=executesql($sql_cliente_antiguo);
			if(!empty($ventas_sin_copmision_antiguos)){
				$detalles["total_ventas_sin_comision"]  = $ventas_sin_copmision_antiguos[0]['total_ventas_sin_comision'];
				$detalles["total_ventas_cliente_antiguos"]  = $ventas_sin_copmision_antiguos[0]['total_ventas_cliente_antiguos'];
			}

			
			// echo $comision venta de certificados  			
			$detalles["total_ventas_certificados"] =0;
			$detalles["total_soles_certificados"] =0;
		
			// echo $comision venta de libros   			
			$detalles["total_ventas_libros"] =0;
			$detalles["total_soles_libros"] =0;


			$venta_certificado=executesql($sql_venta_certificados);
			if(!empty($venta_certificado)){
				$detalles["total_ventas_certificados"]  = $venta_certificado[0]['total_venta_certificados'];
				$detalles["total_soles_certificados"]  = $venta_certificado[0]['total_venta_certificados'] * 1;
				
				// $detalles["total_ventas_certificados"]  = "por_pagar";
				// $detalles["total_soles_certificados"]  = 1;
			}
			
			// LIBROS 
			$venta_libros=executesql($sql_venta_libros); 
			if(!empty($venta_libros)){
				$detalles["total_ventas_libros"]  = $venta_libros[0]['total_venta_libros'];
				$detalles["total_soles_libros"]  = $venta_libros[0]['total_venta_libros'] * 5;  // valor origen es por 5
				
				// $detalles["total_ventas_certificados"]  = "por_pagar";
				// $detalles["total_soles_certificados"]  = 1;
			}
			



			// include("lista_de_comision_actual.php"); // aca sale comiison propia 


			$detalles["monto_total_vendido"]=  $detalles["n_total_soles"]  + 	$total_comision_compartida + $detalles["total_ventas_cliente_antiguos"]; // comison de venta spropias 
			$detalles["total_a_pagar"]=     round($detalles["monto_total_vendido"] * 0.019, 2); // comison de venta spropias 
			
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