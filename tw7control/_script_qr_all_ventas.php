<?php 
error_reporting(E_ALL ^ E_NOTICE);
include_once("auten.php");
include('qr/phpqrcode/qrlib.php'); 


$codesDir = "qr/codes/certificados/";   
$codeFile = 'rq_piblicidad_auge.png';
$_POST['ecc']='H'; // calidadd imagen , H -M Q -L (low - peor baja)
$_POST['size']=3; // [1-5] // rango de tamaño
$_POST['contenido_a_codificar']= "https://api.whatsapp.com/send?phone=51957668571&text=%22%C2%A1Hola!%20Estoy%20muy%20interesado%20en%20conocer%20m%C3%A1s%20sobre%20los%20cursos%20de%20Grupo%20AUGE.%20%C2%BFPodr%C3%ADan%20enviarme%20m%C3%A1s%20informaci%C3%B3n?%20%C2%A1Gracias!%22";

QRcode::png($_POST['contenido_a_codificar'], $codesDir.$codeFile, $_POST['ecc'], $_POST['size']); // crea la imagen qr y la guarda en la ruta asignada 
// echo $imagen_qr= '<img class="img-thumbnail" src="'.$codesDir.$codeFile.'" />';
/** END QR */


/*

    $sql=" SELECT * FROM solicitudes WHERE estado !=3 ORDER BY `solicitudes`.`ide` DESC ";
    $solicitudes=executesql($sql);

    foreach( $solicitudes as $data ){
        $codesDir = "qr/codes/certificados/";   
        $codeFile = $data["ide"].'.png';
        $_POST['ecc']='H'; // calidadd imagen , H -M Q -L (low - peor baja)
        $_POST['size']=3; // [1-5] // rango de tamaño
        $_POST['contenido_a_codificar']= 'https://www.educaauge.com/diplomas/'.$data["ide"];
    
        QRcode::png($_POST['contenido_a_codificar'], $codesDir.$codeFile, $_POST['ecc'], $_POST['size']); // crea la imagen qr y la guarda en la ruta asignada 
        // echo $imagen_qr= '<img class="img-thumbnail" src="'.$codesDir.$codeFile.'" />';
        // END QR 
        
    }

 */ 
   
?>
   