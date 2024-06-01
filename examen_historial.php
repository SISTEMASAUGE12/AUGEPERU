
<main id="examen">
<?php
		
         $_sql_examen_desarrollados= "SELECT sxe.*, e.titulo, e.titulo_rewrite as examen_rewrite , e.total_preguntas FROM suscritos_x_examenes sxe INNER JOIN examenes e ON sxe.id_examen = e.id_examen WHERE sxe.estado_idestado=1 and sxe.id_suscrito=".$_SESSION["suscritos"]["id_suscrito"]."   and sxe.nota >= 0 ORDER BY sxe.ide DESC"; 
?>

	<div class="callout callout-3"><div class="row rel">
   		<div class="large-12 columns">
    		<h1 class="poppi-sb color1 rel anticon"><em>Exámen Online:</em>Historial de exámenes<a href="perfil/examenes" class="osansb"><< Retornar</a></h1>
    		<a id="bt1" onclick="cambio_boton('bt1')" class="bt">Resumen Estadístico</a>
    		<a id="bt2" onclick="cambio_boton('bt2')" class="bt act">Historial de Exámenes</a>
		</div>
	</div><div class="row rel">
    	<div id="cua1" class="large-12 columns nothing">
<?php 

        $sxe = executesql($_sql_examen_desarrollados);
		if(!empty($sxe)){ 
			foreach($sxe as $exa_susc){
                $sql_rptas_cliente="SELECT COUNT(r.id_rpta) as total, SUM(e.puntos) as punto FROM respuestas r INNER JOIN preguntas e ON r.id_pregunta = e.id_pregunta INNER JOIN suscritos_x_examenes_rptas ser ON r.id_rpta = ser.id_rpta  WHERE r.estado_idestado=1 and ser.id_suscrito=".$_SESSION["suscritos"]["id_suscrito"]." AND ser.id_examen=".$exa_susc['id_examen']." AND r.estado_rpta = 1 and ser.id_sxe='".$exa_susc["ide"]."' ";
                        // echo $sql_rptas_cliente;
                $rpta_c = executesql($sql_rptas_cliente);

                $sql_datos_general="SELECT COUNT(e.id_examen) as total_de_preguntas, SUM(e.puntos) as punto FROM preguntas e INNER JOIN suscritos_x_examenes ser ON e.id_examen = ser.id_examen WHERE  ser.estado_idestado=1 and ser.id_suscrito=".$_SESSION["suscritos"]["id_suscrito"]." AND ser.id_examen=".$exa_susc['id_examen']." and ser.ide='".$exa_susc["ide"]."' ";
                        // echo $sql_datos_general;
                        $rpta_t = executesql($sql_datos_general);

                $sql_minutos="SELECT minutos FROM suscritos_x_examenes WHERE estado_idestado=1 and id_suscrito=".$_SESSION["suscritos"]["id_suscrito"]." AND id_examen=".$exa_susc['id_examen']." and ide='".$exa_susc["ide"]."'  ";
                // echo $sql_minutos;
                $min_exa = executesql($sql_minutos);
                $porcentaje = round( ($exa_susc['nota']*100) / $rpta_t[0]['punto'],2);  /* NOTA * 100 dividido  TOTAL DE PUNTOS */
					
?>

		<div class="large-4 medium-6 float-left columns"><div class="h-examen">

            <?php    $link_examen_desarrollado= 'perfil/examenes/'.$exa_susc['examen_rewrite'].'/resultado'.'/'.$exa_susc['ide']; ?>
			<div class="text-center"><p class="poppi-b titu">Ver Examen Desarrollado <i class="fa fa-check"></i> </p></div>

			<div class="regisapar">
				<span class="poppi lleva_titulo_examen "><b class="poppi-sb"><i class="fa fa-server"></i> EXAMEN: </b><?php echo 'cod:'.$exa_susc['ide'].': '.$exa_susc['titulo']; ?></span>
				<span class="poppi"><b class="poppi-sb"><i class="fas fa-calendar-alt"></i> FECHA: </b><?php echo date('d/m/Y',strtotime($exa_susc['fecha_registro'])); ?></span>
				<span class="poppi"><b class="poppi-sb"><i class="fas fa-calendar-alt"></i> HORA: </b><?php echo date('H:i:s',strtotime($exa_susc['fecha_registro'])); ?></span>
			</div>
			<div class="fina">
                <table class="table tableec"><tbody>
                    <tr>
                        <td><span class="per"><i class="fas fa-pencil-alt"></i> Total Preguntas: </span></td>
                        <td><span><b><?php echo $rpta_t[0]['total_de_preguntas']; ?></b></span></td> <!-- este dato es mas certero, aya que recorre la tabla de perguntas x exmamn -->
                    </tr>
                    <tr>
                        <td><span class="per"><i class="fa fa-check"></i> Preguntas Correctas: </span></td>
                        <td><span><b><?php echo $rpta_c[0]['total'] ?></b></span></td>
                    </tr>
                    <tr>
                        <td><span class="per"><i class="fa fa-times"></i> Preguntas Incorrectas: </span></td>
                        <td><span><b><?php echo $rpta_t[0]['total_de_preguntas']-$rpta_c[0]['total'] ?></b></span></td>
                    </tr>
                    <tr>
                        <td><span class="per"><i class="far fa-clock"></i> Tiempo Desarrollo: </span></td>
                        <td><span><b><?php echo $min_exa[0]['minutos'] ?> minutos</b></span></td>
                    </tr>
                    <tr>
                        <td><span class="per"><i class="fas fa-th-large"></i> Puntos Total: </span></td>
                        <td><span><b><?php echo !empty($rpta_t[0]['punto']) ? $rpta_t[0]['punto'] : '0' ?></b></span></td>
                    </tr>
                    <tr>
                        <td><span class="per"><i class="fas fa-th"></i> Puntaje Obtenido: </span></td>
                        <td><span><b><?php echo $exa_susc['nota'] ?></b></span></td>
                    </tr>
                    <tr>
                        <td><span class="per"><i class="fas fa-star"></i> Porcentaje: </span></td>
                        <td><span><b><?php echo $porcentaje ?>% del 100%</b></span></td>
                    </tr>
			    </tbody></table>
                <a href="<?php echo $link_examen_desarrollado; ?>" class=" boton poppi-sb "> ver desarrollo </a>
            </div>
		</div></div>
<?php
		} }
?>
		</div>
		<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    	<script type="text/javascript">
      		google.charts.load('current', {'packages':['corechart']});
      		google.charts.setOnLoadCallback(drawVisualization);

      		function drawVisualization() {
        	// Some raw data (not necessarily accurate)
        	var data = google.visualization.arrayToDataTable([
         	['Examenes', 'Preguntas Correctas', 'Preguntas Incorrectas', 'Cantidad Preguntas'],
<?php
			$sxe = executesql("SELECT sxe.*, e.titulo, e.total_preguntas FROM suscritos_x_examenes sxe INNER JOIN examenes e ON sxe.id_examen = e.id_examen WHERE sxe.id_suscrito=".$_SESSION["suscritos"]["id_suscrito"]." ORDER BY sxe.ide DESC LIMIT 0,5");
			if(!empty($sxe)){ 
				foreach($sxe as $exa_susc){
					$rpta_c = executesql("SELECT COUNT(r.id_rpta) as total, SUM(e.puntos) as punto FROM respuestas r INNER JOIN preguntas e ON r.id_pregunta = e.id_pregunta INNER JOIN suscritos_x_examenes_rptas ser ON r.id_rpta = ser.id_rpta WHERE ser.id_suscrito=".$_SESSION["suscritos"]["id_suscrito"]." AND ser.id_examen=".$exa_susc['id_examen']." AND r.estado_rpta = 1 and ser.id_sxe='".$exa_susc["ide"]."' ");
?>
		 	['<?php echo $exa_susc['titulo']; ?>',  <?php echo $rpta_c[0]['total'] ?>, <?php echo $exa_susc['total_preguntas']-$rpta_c[0]['total'] ?>, <?php echo $exa_susc['total_preguntas'] ?>],
<?php
			}}
?>
	  		]);

        	var options = {
      		title : 'Tus 5 Ultimos Examenes Desarrollados por  / Pregunta',
      		vAxis: {title: ''},
      		hAxis: {title: 'Examenes'},
      		seriesType: 'bars',
      		series: {3: {type: 'line'}}
    		};

    		var chart = new google.visualization.ComboChart(document.getElementById('chart_div'));
    		chart.draw(data, options);
  			}
    	</script>
    	<script type="text/javascript">
			google.load("visualization", "1", {packages:["corechart"]});
			google.setOnLoadCallback(drawChart2);
			function drawChart2() {
			var data = google.visualization.arrayToDataTable([
			['Examenes', 'Puntos Obtenidos', 'Porcentaje (%)', 'Puntos Total'],
<?php
			$sxe = executesql("SELECT sxe.*, e.titulo, e.total_preguntas FROM suscritos_x_examenes sxe INNER JOIN examenes e ON sxe.id_examen = e.id_examen WHERE sxe.id_suscrito=".$_SESSION["suscritos"]["id_suscrito"]." ORDER BY sxe.ide DESC LIMIT 0,5");
			if(!empty($sxe)){ 
				foreach($sxe as $exa_susc){
					$rpta_c = executesql("SELECT COUNT(r.id_rpta) as total, SUM(e.puntos) as punto FROM respuestas r INNER JOIN preguntas e ON r.id_pregunta = e.id_pregunta INNER JOIN suscritos_x_examenes_rptas ser ON r.id_rpta = ser.id_rpta WHERE ser.id_suscrito=".$_SESSION["suscritos"]["id_suscrito"]." AND ser.id_examen=".$exa_susc['id_examen']." AND r.estado_rpta = 1 and ser.id_sxe='".$exa_susc["ide"]."' ");
					$rpta_t = executesql("SELECT COUNT(e.id_examen) as total, SUM(e.puntos) as punto FROM preguntas e WHERE e.id_examen=".$exa_susc['id_examen']);
					
					$porcentaje = round(($exa_susc['nota']*100)/$rpta_t[0]['total'] ,2);  /*  nota */
?>
		 	['<?php echo $exa_susc['titulo']; ?>', <?php echo !empty($rpta_c[0]['punto']) ? $rpta_c[0]['punto'] : '0' ?>, <?php echo $porcentaje ?>, <?php echo $rpta_t[0]['punto'] ?>],
<?php
			} }
?>
			]);

			var options = {
			title: 'Tus 5 Ultimos Examenes Desarrollados por  / Puntos',
			hAxis: {title: 'Examenes',  titleTextStyle: {color: '#333'}},
			vAxis: {minValue: 0}
			};

			var chart = new google.visualization.AreaChart(document.getElementById('chart_div2'));
			chart.draw(data, options);
			}

    	</script>
    	<script type="text/javascript">
      		google.charts.load('current', {'packages':['corechart']});
      		google.charts.setOnLoadCallback(drawVisualization);

      		function drawVisualization() {
        	// Some raw data (not necessarily accurate)
        	var data = google.visualization.arrayToDataTable([
         	['Examenes', 'Preguntas Correctas', 'Preguntas Incorrectas', 'Cantidad Preguntas', 'Puntos Obtenidos', 'Porcentaje (%)', 'Puntos Total'],
<?php
			$sxe = executesql("SELECT sxe.*, e.titulo, e.total_preguntas FROM suscritos_x_examenes sxe INNER JOIN examenes e ON sxe.id_examen = e.id_examen WHERE sxe.id_suscrito=".$_SESSION["suscritos"]["id_suscrito"]." ORDER BY sxe.ide DESC LIMIT 0,5");
			if(!empty($sxe)){ 
				foreach($sxe as $exa_susc){
					$rpta_c = executesql("SELECT COUNT(r.id_rpta) as total, SUM(e.puntos) as punto FROM respuestas r INNER JOIN preguntas e ON r.id_pregunta = e.id_pregunta INNER JOIN suscritos_x_examenes_rptas ser ON r.id_rpta = ser.id_rpta WHERE ser.id_suscrito=".$_SESSION["suscritos"]["id_suscrito"]." AND ser.id_examen=".$exa_susc['id_examen']." AND r.estado_rpta = 1 and ser.id_sxe='".$exa_susc["ide"]."' ");
					$rpta_t = executesql("SELECT COUNT(e.id_examen) as total, SUM(e.puntos) as punto FROM preguntas e WHERE e.id_examen=".$exa_susc['id_examen']);
					
					$porcentaje = round(($exa_susc['nota']*100)/$rpta_t[0]['total'],2);  /*  nota */
?>
		 	['<?php echo $exa_susc['titulo']; ?>', <?php echo $rpta_c[0]['total'] ?>, <?php echo $exa_susc['total_preguntas']-$rpta_c[0]['total'] ?>, <?php echo $exa_susc['total_preguntas'] ?>, <?php echo !empty($rpta_c[0]['punto']) ? $rpta_c[0]['punto'] : '0' ?>, <?php echo $porcentaje ?>, <?php echo $rpta_t[0]['punto'] ?>],
<?php
			} }
?>
	  		]);

        	var options = {
      		title : 'Tus 5 Ultimos Examenes Desarrollados por  / General',
      		vAxis: {title: 'Cups'},
      		hAxis: {title: 'Examenes'},
      		seriesType: 'bars',
      		series: {5: {type: 'line'}}
    		};

    		var chart = new google.visualization.ComboChart(document.getElementById('chart_div3'));
    		chart.draw(data, options);
  			}
    	</script>
    	<div id="cua2" class="large-12 columns nothing ale">
		<div class="large-12 columns"><div id="chart_div" class="charta"></div></div>
    	
		<div class="large-12 columns"><div id="chart_div2" class="charta"></div></div>

		<div class="large-12 columns"><div id="chart_div3" class="charta"></div></div>
		</div>
	</div></div>
</main>
