<?php
include_once("auten.php");

$url = 'https://' . $_SERVER['SERVER_NAME'] . '' . (($_SERVER['SERVER_NAME'] == 'localhost') ? ':88/mori/tuweb7/w2019/withlove/' : '/');


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    $cliente = $data['cliente'];
    $registros = $data['registros'];
    $fecha_registro = date('Y-m-d H:i:s');


    $bd = new BD;

    $bd->open();

    foreach ($registros as $registro) {

        $especialidad = $registro['especialidad'];
        $numero = $registro['numero'];
        $nombres = $registro['nombres'];
        $email = $registro['email'];
        $ciudad = $registro['ciudad'];
        $condicion = $registro['condicion'];

        $datos_formulario = array(
            'nombres' => $nombres,
            'numero' => $telefono,
            'email' => $email,
            'condicion' => $condicion,
            'ciudad' => $ciudad,
            'especialidad' => $especialidad,      
            'fecha_de_registro' => $fecha_registro,   
            'id_cliente' => $cliente,
        );

        

    $sql_insert = insert_table("contactos_referidos", $datos_formulario);

    $result = $bd->ExecuteQuery($sql_insert);
    
    
    
    }


    echo json_encode(['status' => 'success', 'message' => 'Referidos registrados correctamente']);

    $bd->close();
}





