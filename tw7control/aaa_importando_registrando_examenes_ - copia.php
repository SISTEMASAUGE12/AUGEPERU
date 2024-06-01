<?php error_reporting(E_ALL ^ E_NOTICE);
include ("auten.php");

  $bd = new BD;
  $bd->Begin();
  $ide_bancos =  implode(',', $_POST['chkDel']);
  
	/* Recorro las preguntas del bnaco seleecionadas */
	$sql=" select * from banco_preguntas where id_banco IN (".$ide_bancos.") order by orden desc ";
// echo $sql;
// exit();

	
	$banco_preguntas=executesql($sql);
	if( !empty($banco_preguntas) ){
		$_POST['estado_idestado'] = 1;
		$_POST['fecha_registro'] = fecha_hora(2);
		$_POST['fecha_actualizacion'] = fecha_hora(2);

		foreach($banco_preguntas as $data){
			
			/* registro pregunta y la asigno al examen */
			$_POST['id_banco']=$data['id_banco'];
			$_POST['titulo']=$data['b_pregunta'];
			$_POST['puntos']=$data['b_puntaje'];
			$_POST['imagen']=$data['imagen'];
			$_POST['orden'] = _orden_noticia("","preguntas","");
			$urlrewrite=armarurlrewrite($data["b_pregunta"]);
			$_POST['titulo_rewrite']=$urlrewrite=armarurlrewrite($urlrewrite,1,"preguntas","id_pregunta","titulo_rewrite",'');
			
			$campos=array('id_examen','titulo','titulo_rewrite','puntos','imagen','fecha_actualizacion','orden','fecha_registro','estado_idestado'); /*inserto campos principales*/
			$_POST['id_pregunta']=$bd->inserta_(arma_insert('preguntas',$campos,'POST'));/*inserto hora -orden y guardo imag*/
			
			// echo var_dump(arma_insert('preguntas',$campos,'POST'));
			// exit();
			
			
			/* Registramos las rptas de las pregunta */
			
			/* RPTA #1 */
			if( !empty($data['b_resp1']) ){
				$_POST['titulo']=$data['b_resp1'];
				$_POST['orden'] = _orden_noticia("","respuestas","");
				$urlrewrite=armarurlrewrite($_POST["titulo"]);
				$_POST['titulo_rewrite']=$urlrewrite=armarurlrewrite($urlrewrite,1,"respuestas","id_rpta","titulo_rewrite",'');
				if($data['valor1'] == 'Si' || $data['valor1'] == 'si' || $data['valor1'] == 'SI'){
					$_POST['estado_rpta']=1;				
				}else{
					$_POST['estado_rpta']=2;
				}
				$campos_rptas=array('id_pregunta','id_examen','titulo',array('titulo_rewrite',$urlrewrite),'estado_rpta','fecha_actualizacion','orden','fecha_registro','estado_idestado'); /*inserto campos principales*/
				$bd->inserta_(arma_insert('respuestas',$campos_rptas,'POST'));/*inserto hora -orden y guardo imag*/
			}
			
			/* RPTA #2 */
			if( !empty($data['b_resp2']) ){

				$_POST['titulo']=$data['b_resp2'];
				$_POST['orden'] = _orden_noticia("","respuestas","");
				$urlrewrite=armarurlrewrite($_POST["titulo"]);
				$_POST['titulo_rewrite']=$urlrewrite=armarurlrewrite($urlrewrite,1,"respuestas","id_rpta","titulo_rewrite",'');
				if($data['valor2'] == 'Si'  || $data['valor2'] == 'si' || $data['valor2'] == 'SI' ){
					$_POST['estado_rpta']=1;				
				}else{
					$_POST['estado_rpta']=2;
				}
				$campos_rptas=array('id_pregunta','id_examen','titulo',array('titulo_rewrite',$urlrewrite),'estado_rpta','fecha_actualizacion','orden','fecha_registro','estado_idestado'); /*inserto campos principales*/
				$bd->inserta_(arma_insert('respuestas',$campos_rptas,'POST'));/*inserto hora -orden y guardo imag*/
			}
			
			/* RPTA #3 */
			if( !empty($data['b_resp3']) ){
				$_POST['titulo']=$data['b_resp3'];
				$_POST['orden'] = _orden_noticia("","respuestas","");
				$urlrewrite=armarurlrewrite($_POST["titulo"]);
				$_POST['titulo_rewrite']=$urlrewrite=armarurlrewrite($urlrewrite,1,"respuestas","id_rpta","titulo_rewrite",'');
			if($data['valor3'] == 'Si'  || $data['valor3'] == 'si' || $data['valor3'] == 'SI' ){
					$_POST['estado_rpta']=1;				
				}else{
					$_POST['estado_rpta']=2;
				}
				$campos_rptas=array('id_pregunta','id_examen','titulo',array('titulo_rewrite',$urlrewrite),'estado_rpta','fecha_actualizacion','orden','fecha_registro','estado_idestado'); /*inserto campos principales*/
				$bd->inserta_(arma_insert('respuestas',$campos_rptas,'POST'));/*inserto hora -orden y guardo imag*/
			}
			
			/* RPTA #4 */
			if( !empty($data['b_resp4']) ){
				$_POST['titulo']=$data['b_resp4'];
				$_POST['orden'] = _orden_noticia("","respuestas","");
				$urlrewrite=armarurlrewrite($_POST["titulo"]);
				$_POST['titulo_rewrite']=$urlrewrite=armarurlrewrite($urlrewrite,1,"respuestas","id_rpta","titulo_rewrite",'');
				if($data['valor4'] == 'Si'  || $data['valor4'] == 'si' || $data['valor4'] == 'SI' ){
					$_POST['estado_rpta']=1;				
				}else{
					$_POST['estado_rpta']=2;
				}
				$campos_rptas=array('id_pregunta','id_examen','titulo',array('titulo_rewrite',$urlrewrite),'estado_rpta','fecha_actualizacion','orden','fecha_registro','estado_idestado'); /*inserto campos principales*/
				$bd->inserta_(arma_insert('respuestas',$campos_rptas,'POST'));/*inserto hora -orden y guardo imag*/
			}
			
			/* RPTA #5 */
			if( !empty($data['b_resp5']) ){
				$_POST['titulo']=$data['b_resp5'];
				$_POST['orden'] = _orden_noticia("","respuestas","");
				$urlrewrite=armarurlrewrite($_POST["titulo"]);
				$_POST['titulo_rewrite']=$urlrewrite=armarurlrewrite($urlrewrite,1,"respuestas","id_rpta","titulo_rewrite",'');
				if($data['valor5'] == 'Si'  || $data['valor5'] == 'si' || $data['valor5'] == 'SI' ){
					$_POST['estado_rpta']=1;				
				}else{
					$_POST['estado_rpta']=2;
				}
				$campos_rptas=array('id_pregunta','id_examen','titulo',array('titulo_rewrite',$urlrewrite),'estado_rpta','fecha_actualizacion','orden','fecha_registro','estado_idestado'); /*inserto campos principales*/
				$bd->inserta_(arma_insert('respuestas',$campos_rptas,'POST'));/*inserto hora -orden y guardo imag*/
			}

			/* Bancos _ x _ preguntas */
			$_POST['orden'] = _orden_noticia("","banco_preguntas_examenes","");
			$campos_bancos_x=array('id_banco','id_examen','orden','fecha_registro','estado_idestado'); /*inserto campos principales*/
			$bd->inserta_(arma_insert('banco_preguntas_examenes',$campos_bancos_x,'POST'));/*inserto hora -orden y guardo imag*/
		}
	}
	
	
	// echo var_dump();
	// exit();
	
  $bd->Commit();
  $bd->close();

?>