<?php error_reporting(E_ALL ^ E_NOTICE);
include ("auten.php");

  $bd = new BD;
  $bd->Begin();
  $i=1;
	/* Recorro las preguntas del bnaco seleecionadas */
	$sql="SELECT id_pregunta, titulo FROM preguntas2 WHERE id_pregunta BETWEEN 15243 AND 71100";
// echo $sql;
// exit();

	
	$banco_preguntas=executesql($sql);
	if( !empty($banco_preguntas) ){

		foreach($banco_preguntas as $data){
			
			$_POST['orden'] = $data['id_pregunta'];
			$urlrewrite=armarurlrewrite($data["titulo"]);
			$_POST['titulo_rewrite']=$urlrewrite=armarurlrewrite($urlrewrite,1,"preguntas2","id_pregunta","titulo_rewrite",'');
			
			$campos=array('titulo_rewrite','orden');
			$bd->actualiza_(armaupdate('preguntas2',$campos," id_pregunta='".$data["id_pregunta"]."'",'POST'));/*inserto hora -orden y guardo imag*/
			
			echo $i.'<br>';
			// echo var_dump(arma_insert('examenes',$campos,'POST'));
			// exit();
			
			
			/* Registramos las rptas de las pregunta */
			
			/* RPTA #1 */
			// if( !empty($data['b_resp1']) ){
				// $_POST['titulo']=$data['b_resp1'];
				// $_POST['orden'] = _orden_noticia("","respuestas","");
				// $urlrewrite=armarurlrewrite($_POST["titulo"]);
				// $_POST['titulo_rewrite']=$urlrewrite=armarurlrewrite($urlrewrite,1,"respuestas","id_rpta","titulo_rewrite",'');
				// if($data['valor1'] == 'Si' || $data['valor1'] == 'si' || $data['valor1'] == 'SI'){
					// $_POST['estado_rpta']=1;				
				// }else{
					// $_POST['estado_rpta']=2;
				// }
				// $campos_rptas=array('id_pregunta','id_examen','titulo',array('titulo_rewrite',$urlrewrite),'estado_rpta','fecha_actualizacion','orden','fecha_registro','estado_idestado'); /*inserto campos principales*/
				// $bd->inserta_(arma_insert('respuestas',$campos_rptas,'POST'));/*inserto hora -orden y guardo imag*/
			// }
			
			$i++;
		}
	}
	
	
	// echo var_dump();
	// exit();
	
  $bd->Commit();
  $bd->close();

?>