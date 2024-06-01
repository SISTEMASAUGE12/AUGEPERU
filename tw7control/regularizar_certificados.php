<?php error_reporting(E_ALL ^ E_NOTICE);
include ("auten.php");

$bd=new BD;

$certificados=executesql(" select * from certificados where estado_idestado=1 ");
if( $certificados ){
    foreach( $certificados as $data){
        $_POST["id_certificado"]= $data["id_certificado"];
        $_POST["id_curso"]= $data["id_curso"];
        $_POST["fecha_registro"]= $data["fecha_registro"];
        $_POST["orden"]= 1;
        $_POST["estado_idestado"]= 1;

        $campos=array('id_certificado','id_curso','fecha_registro','orden','estado_idestado'); /*inserto campos principales*/
        $bd->inserta_(arma_insert('certificados_x_cursos',$campos,'POST'));
    }
}

//regularizar_certificados 
?>