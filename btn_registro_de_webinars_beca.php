<?php
include_once("auten.php");

$url = 'https://' . $_SERVER['SERVER_NAME'] . '' . (($_SERVER['SERVER_NAME'] == 'localhost') ? ':88/mori/tuweb7/w2019/withlove/' : '/');

if ($_POST['action'] == 'registro') {

    
    $nombre =  utf8_decode(addslashes($_POST['nombre']));
    $email =  utf8_decode(addslashes($_POST['email']));
    $telefono =  utf8_decode(addslashes($_POST['phone']));
    $tipo =  utf8_decode(addslashes($_POST['tipo']));
    $fecha_registro = date('Y-m-d H:i:s');


    $datos_formulario = array(
        'Nombre' => $nombre,
        'Numero' => $telefono,
        'Email' => $email,      
        'CondicionLaboral' => $tipo,
        'FechaRegistro' => $fecha_registro
    );

    $bd = new BD;

    $bd->open();

    $sql_insert = insert_table("webinars_x_becas", $datos_formulario);

    $result = $bd->ExecuteQuery($sql_insert);
    // Imprimir la consulta de inserción
    //echo $sql_insert;
    if ($result !== false) {
        header("Location: https://api.whatsapp.com/send?phone=+51957668571&text=Hola%20Grupo%20AUGE%20Quiero%20Informaci%C3%B3n");
    } else {
        echo "<script>alert('Hubo un error. Intenta de nuevo.'); window.location.reload();</script>";
    }
    
    $bd->close();
}
