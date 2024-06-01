<?php
include_once("auten.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $condicion = $_POST['condicion'];

    // Validar los datos recibidos
    if (empty($id) || empty($condicion)) {
        echo json_encode(['status' => 'error', 'message' => 'Datos faltantes']);
        exit;
    }

    $bd = new BD;
    $bd->open();

    // Crear la consulta de actualización
    $datos_formulario = array(
        'condicion' => $condicion,
    );

    $sql_update = update_table("docentes_campaña", $datos_formulario, "id = $id");
    $result = $bd->ExecuteQuery($sql_update);

    if ($result) {
        echo json_encode(['status' => 'success', 'message' => 'Referido actualizado correctamente']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error al actualizar el referido']);
    }

    $bd->close();
}


?>
