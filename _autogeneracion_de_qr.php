
              <?php 
    include('qr/phpqrcode/qrlib.php'); 

    for( $i=0; $i<4;$i++    ){
        $codesDir = "qr/codes/";   
        $codeFile = $i.'.png';
        $_POST['ecc']='H'; // calidadd imagen , H -M Q -L (low - peor baja)
        $_POST['size']=3; // [1-5] // rango de tamaño
        $_POST['contenido_a_codificar']= 'https://www.tuweb7.com/portafolio';
    
        QRcode::png($_POST['contenido_a_codificar'], $codesDir.$codeFile, $_POST['ecc'], $_POST['size']); 
        echo $imagen_qr= '<img class="img-thumbnail" src="'.$codesDir.$codeFile.'" />';
        

    }

  

?>
   