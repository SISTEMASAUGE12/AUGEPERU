      <div class="row">
        <div class="col-12 col-sm-6 col-md-4"><div class="info-box">
          <span class="info-box-icon bg-info elevation-1" style="background:#ff4b00;    padding-top: 15px;"><i class="fa fa-user-plus"></i></span>
          <div class="info-box-content">
            <span class="info-box-text" >Usuarios Registrados</span>
<?php
            $sql1 = executesql('SELECT * FROM suscritos');
            $total1 = count($sql1);
?>
            <span class="info-box-number" style="font-size:20px"><?php echo $total1 ?></span>
          </div>
        </div></div>
				
        <div class="col-12 col-sm-6 col-md-4"><div class="info-box mb-3">
          <span class="info-box-icon bg-danger elevation-1" style="background:#13bb37;    padding-top: 15px;"><i class="fa fa-ticket  "></i></span>
          <div class="info-box-content">
            <span class="info-box-text" >Usuarios con compras</span>
<?php
            $sql2 = executesql("SELECT s.id_suscrito, count(s.id_suscrito) c FROM pedidos p INNER JOIN suscritos s ON p.id_suscrito=s.id_suscrito WHERE p.estado_pago = 1 GROUP BY s.id_suscrito HAVING c >= 1");
            $total2 = count($sql2);
?>
            <span class="info-box-number" style="font-size:20px"><?php echo $total2 ?></span>
          </div>
        </div></div>
				
			 <div class="col-12 col-sm-6 col-md-4"><div class="info-box mb-3">
			 
          <span class="info-box-icon bg-warning elevation-1" style="padding-top:15px;"><i class="fa fa-user "></i></span>
          <div class="info-box-content">
            <span class="info-box-text">Usuarios sin compras</span>
<?php
            // $sql61 = executesql("SELECT s.id_suscrito, count(s.id_suscrito) c FROM pedidos p INNER JOIN suscritos s ON p.id_suscrito=s.id_suscrito WHERE p.estado_pago = 1 GROUP BY s.id_suscrito HAVING c >= 1");
            // if(!empty($sql61)){ 
              // foreach($sql61 as $row61){
                // $conte = $row61['id_suscrito'].',';
              // }
              // $ulti = substr($conte, 0, -1);
              // $sql62 = executesql("SELECT * FROM suscritos WHERE id_suscrito NOT IN (".$ulti.")");
            // }else{
              // $sql62 = executesql("SELECT * FROM suscritos");
            // }
            // $total6 = count($sql62);
						
						/* La simple */
            $total6 = $total1-$total2;
?>
            <span class="info-box-number"><?php echo $total6 ?></span>
          </div>
        </div></div>
				
        <div class="col-12 col-sm-6 col-md-4"><div class="info-box mb-3">
          <span class="info-box-icon bg-warning elevation-1"  style="background:#4788ff;    padding-top: 15px;"><i class="fa fa-book"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">Coautorías vendidas</span>
<?php
            $sql4 = executesql("SELECT * FROM solicitudes_coautorias WHERE estado_idestado=1 and estado = '1'");
            $total4 = count($sql4);
?>
            <span class="info-box-number"><?php echo $total4 ?></span>
          </div>
        </div></div>
				
        <div class="col-12 col-sm-6 col-md-4"><div class="info-box mb-3">
          <span class="info-box-icon bg-warning elevation-1"  style="background:#4788ff;    padding-top: 15px;"><i class="fa fa-pencil"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">cursos registrados</span>
<?php
            $sql5 = executesql("SELECT * FROM cursos where estado_idestado=1 ");
            $total5 = count($sql5);
?>
            <span class="info-box-number"><?php echo $total5 ?></span>
          </div>
        </div></div>
				
				
        <div class="col-12 col-sm-6 col-md-4"><div class="info-box mb-3">
          <span class="info-box-icon bg-success elevation-1" style="background:#4788ff;    padding-top: 15px;" ><i class="fa fa-book"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">Libros vendidos</span>
<?php
            $sql3 = executesql("SELECT * FROM suscritos_x_cursos WHERE estado_idestado=1 and  estado=1 and id_tipo=2  ");
            $total3 = count($sql3);
?>
            <span class="info-box-number"><?php echo $total3 ?></span>
          </div>
        </div></div>
        
        <div class="col-12 col-sm-6 col-md-4"><div class="info-box mb-3">
          <span class="info-box-icon bg-success elevation-1" style="background:#4788ff;    padding-top: 15px;" ><i class="fa fa-certificate"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">Certificados vendidos</span>
<?php
            $sql3 = executesql("SELECT * FROM solicitudes WHERE estado_idestado=1 and estado = '1'");
            $total3 = count($sql3);
?>
            <span class="info-box-number"><?php echo $total3 ?></span>
          </div>
        </div></div>

        <div class="col-12 col-sm-6 col-md-4"><div class="info-box mb-3">
          <span class="info-box-icon bg-success elevation-1" style="background:yellow;    padding-top: 15px;" ><i class="fa fa-calculator"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">exámenes vendidos</span>
<?php
            /* $sql3 = executesql("SELECT * FROM suscritos_x_examenes  sxe LEFT JOIN examenes e ON sxe.id_examen=e.id_examen   WHERE  e.privacidad=3 and sxe.estado_idestado=1 and sxe.estado = '1' "); */ 
            $sql3 = executesql( " SELECT lp.*,YEAR(lp.fecha_registro) as anho, MONTH(lp.fecha_registro) as mes, e.nombre AS estado ,s.email as email,  CONCAT(s.nombre,' ',s.ap_pa,' ',s.ap_ma )as suscritos , s.dni as dni, s.telefono, pp.codigo as codped, pp.tipo_pago, ce.id_examen, ce.titulo as examen, ce.precio as precioc 
            FROM linea_pedido lp 
            LEFT JOIN pedidos pp ON pp.id_pedido = lp.id_pedido  
            INNER JOIN estado e ON pp.estado_idestado=e.idestado 
            INNER JOIN suscritos s ON pp.id_suscrito=s.id_suscrito
            LEFT JOIN examenes  ce ON lp.id_curso=ce.id_examen
            WHERE lp.talla = '7777'  and ce.privacidad=3 ");
            $total3 = count($sql3);
?>
            <span class="info-box-number"><?php echo $total3 ?></span>
          </div>
        </div></div>
				

      </div> <!-- * en cuadros total de elemntos vendidos -->

			
      <div class="row">
        <div class="col-md-6"><div class="card">
          <div class="card-header">
            <h5 class="card-title">Los 6 cursos más comprados</h5>
          </div>
          <div class="card-body p-0"><div class="table-responsive"><table class="table m-0">
            <thead><tr>
              <th>Código</th>
              <th>Curos</th>
              <th>Total</th>
            </tr></thead>
            <tbody>
<?php
          $sql7 = executesql("SELECT lp.id_curso, count(lp.id_curso) c FROM linea_pedido lp INNER JOIN pedidos p ON p.id_pedido = lp.id_pedido INNER JOIN cursos c ON lp.id_curso = c.id_curso WHERE p.estado_pago = 1 AND c.id_tipo = 1 GROUP BY lp.id_curso HAVING c >= 1");
          if(!empty($sql7)){ foreach ($sql7 as $key => $row) {
            $aux[$key] = $row['c'];
          } }
          array_multisort($aux, SORT_DESC, $sql7);
          $sql7 = array_slice($sql7, 0, 6);
          foreach ($sql7 as $key => $row){
            $hoa = executesql("SELECT codigo,titulo FROM cursos WHERE id_curso =".$row['id_curso'],0);
?>
              <tr>
                <td><b><?php echo $hoa['codigo'] ?></b></td>
                <td><?php echo $hoa['titulo'] ?></td>
                <td><span class="badge badge-success"><?php echo $row['c'] ?></span></td>
              </tr>
<?php
            } 
?>
            </tbody>
          </table></div></div>
        </div></div>
				

        <div class="col-md-6"><div class="card">
          <div class="card-header border-transparent">
            <h3 class="card-title">Últimas 6 compras realizadas</h3>
          </div>
          <div class="card-body p-0"><div class="table-responsive"><table class="table m-0">
            <thead><tr>
              <th>Fech</th>
              <th>Cod.</th>
              <th>Tipo</th>
              <th>DNI</th>
              <th>Cliente</th>
              <th>Total</th>
            </tr></thead>
            <tbody>
<?php
            $sql9 = executesql("SELECT p.*, CONCAT(s.nombre,' ',s.ap_pa,' ',s.ap_ma) as suscritos, s.dni FROM pedidos p INNER JOIN suscritos s ON p.id_suscrito=s.id_suscrito WHERE p.estado_pago= 1 and p.estado_idestado=1 ORDER BY p.fecha_registro DESC LIMIT 0,6 ");
            if(!empty($sql9)){ foreach($sql9 as $row9){
								if( $row9["tipo_pago"] ==1){
									$tipo_compra="Deposito";
								}else if( $row9["tipo_pago"] ==2){
									$tipo_compra="Tarjeta";
								}else if( $row9["tipo_pago"] ==3){
									$tipo_compra="PagoEfectivo";
									
								}else if( $row9["tipo_pago"] ==4 ){
									$tipo_compra="Venta_Manual";
									
								}else{ 
									$tipo_compra="_error_";
								}
?>
              <tr>
                <td><b><?php echo $row9['fecha_registro'] ?></b></td>
                <td><b><?php echo $row9['codigo'] ?></b></td>
                <td><b><?php echo $tipo_compra; ?></b></td>
                <td><?php echo $row9['dni'] ?></td>
                <td><?php echo $row9['suscritos'] ?></td>
                <td><span class="badge badge-success"><?php echo $row9['total'] ?></span></td>
              </tr>
<?php
            } }
?>
            </tbody>
          </table></div></div>
        </div></div>
				

        <div class="clearfix"></div>
        <div class="col-md-6"><div class="card">
          <div class="card-header">
            <h5 class="card-title">Últimos 10 clientes registrados</h5>
          </div>
          <div class="card-body p-0"><div class="table-responsive"><table class="table m-0">
            <thead><tr>
              <th>DNI</th>
              <th>Cliente</th>
            </tr></thead>
            <tbody>
<?php
            $sql9 = executesql("SELECT dni, CONCAT(nombre,' ',ap_pa,' ',ap_ma) as suscritos FROM suscritos WHERE estado_idestado= 1 ORDER BY id_suscrito  DESC LIMIT 0,10");
            if(!empty($sql9)){ foreach($sql9 as $row9){
?>
              <tr>
                <td><b><?php echo $row9['dni'] ?></b></td>
                <td><?php echo $row9['suscritos'] ?></td>
              </tr>
<?php
            } }
?>
            </tbody>
          </table></div></div>
        </div></div>
				
        <div class="col-md-6"><div class="card">
          <div class="card-header">
            <h5 class="card-title">Últimos 10 cursos creados</h5>
          </div>
          <div class="card-body p-0"><div class="table-responsive"><table class="table m-0">
            <thead><tr>
              <th>Código</th>
              <th>Curso</th>
            </tr></thead>
            <tbody>
<?php
            $sql10 = executesql("SELECT codigo, titulo FROM cursos WHERE id_tipo=1 ORDER BY orden DESC LIMIT 0,10");
            if(!empty($sql10)){ foreach($sql10 as $row10){
?>
              <tr>
                <td><b><?php echo $row10['codigo'] ?></b></td>
                <td><?php echo $row10['titulo'] ?></td>
              </tr>
<?php
            } }
?>
            </tbody>
          <!-- ./card-body -->
          </table></div></div>
        </div></div>



      </div>
			
			