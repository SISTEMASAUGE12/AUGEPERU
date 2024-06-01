<?php error_reporting(E_ALL);session_start(); 
include_once("../intranet/class/functions.php");
// include_once("../intranet/class/class.bd.php"); 
if(isset($_POST["lleva"]) && !empty($_POST["lleva"]) ){
	
	$result_dedica="";
  $recibido=$_POST["lleva"];  
	if($recibido=='si'){
		if(!empty($_SESSION["suscritos"]["id_suscrito"])){		
								
				$text_basico='</br></br><table style="text-align:center!important;margin: auto;width:320px;"><tr><td  style="font-weight:800!important;"><br /><br />Ingresa un título aquí<br /><br /><br /><br /></td></tr><tr><td style=""><br /><br /><br /><br /><br />Ingresa un bonito mensaje aquí<br /><br /><br /><br /><br /></td></tr><tr><td style=""><br /><br />Ingresa tu firma aquí<br /><br /></td></tr></br></table></br></br>';
										
				$result_dedica=" 						
				<script src='intranet/ckeditor/sample.js'></script>
				<script src='intranet/ckeditor/ckeditor.js'></script>
				<script src='intranet/ckfinder/ckfinder.js'></script>	
				
				<script>
					document.getElementById('dedicatoria').value='".$text_basico."';		
					var editor11 = CKEDITOR.replace('dedicatoria',{toolbar:[['Bold','Italic','Underline','-','BulletedList']]});
					CKFinder.setupCKEditor( editor11, 'ckfinder/' );
				</script> 
				";
				// $result_dedica="Por favor inicie sesión..."; 
			
		}else{ $result_dedica="Por favor inicie sesión...";      } 
	}else{ $result_dedica="";      } 
  
 
} 

 echo json_encode(array(    
    "res" => 'ok',
    "result_dedica" => $result_dedica  
  )); 
 ?>