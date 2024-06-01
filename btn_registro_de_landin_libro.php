<?php
include_once("auten.php");

$url = 'https://' . $_SERVER['SERVER_NAME'] . '' . (($_SERVER['SERVER_NAME'] == 'localhost') ? ':88/mori/tuweb7/w2019/withlove/' : '/');

if ($_POST['action'] == 'registro') {

    
    $nombre =  utf8_decode(addslashes($_POST['nombre_completo']));
    $email =  utf8_decode(addslashes($_POST['email']));
    $telefono =  utf8_decode(addslashes($_POST['telefono']));
    $fecha_registro = date('Y-m-d H:i:s');


    $datos_formulario = array(
        'nombres' => $nombre,
        'numero' => $telefono,
        'email' => $email,      
        'fecha_de_registro' => $fecha_registro
    );

    $bd = new BD;

    $bd->open();

    $sql_insert = insert_table("landin_x_libro", $datos_formulario);

    $result = $bd->ExecuteQuery($sql_insert);
    // Imprimir la consulta de inserción
    //echo $sql_insert;
    if ($result !== false) {
        header("Location: https://bit.ly/3Uw3Nrb");
    } else {
        echo "<script>alert('Hubo un error. Intenta de nuevo.'); window.location.reload();</script>";
    }
    
    $bd->close();
}
