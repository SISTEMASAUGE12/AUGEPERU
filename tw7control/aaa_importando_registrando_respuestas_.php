<?php error_reporting(E_ALL ^ E_NOTICE);
include ("auten.php");

  $bd = new BD;
  $bd->Begin();
  $i=1;
	/* Recorro las preguntas del bnaco seleecionadas */
	$sql="SELECT id_rpta FROM respuestas WHERE estado_rpta is NULL";
// echo $sql;
// exit();
	$ides = '';
	$banco_preguntas = executesql($sql);
	if(!empty($banco_preguntas)){ foreach($banco_preguntas as $data){
		$ides.=$data['id_rpta'].',';
	} }
	
	echo $ides;
	// echo var_dump();
	// exit();
	
  $bd->Commit();
  $bd->close();

?>