
<?php 
    include('qr/phpqrcode/qrlib.php'); 
    $codesDir = "qr/codes/";   
    $codeFile = date('d-m-Y-h-i-s').'.png';
    $_POST['ecc']='H'; // calidadd imagen , H -M Q -L (low - peor baja)
    $_POST['size']=3; // [1-5] // rango de tamaño
    $_POST['contenido_a_codificar']= 'https://www.tuweb7.com/portafolio';

    QRcode::png($_POST['contenido_a_codificar'], $codesDir.$codeFile, $_POST['ecc'], $_POST['size']); // crea la imagen qr y la guarda en la ruta asignada 
    echo $imagen_qr= '<img class="img-thumbnail" src="'.$codesDir.$codeFile.'" />';
    

?>
   