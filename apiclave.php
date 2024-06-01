<?php //okey
include_once("tw7control/class/functions.php");
include_once("tw7control/class/class.bd.php");

$bd = new BD;
$bd->Begin();


$sql=" select * from suscritos where  clave ='80da5d337bf9606dd59f3480a125201e'   ORDER by orden asc ";  /* token diario generate */
$suscritos =executesql($sql);

foreach( $suscritos as  $row){
    $_POST['clave']= md5($row["dni"]);

    $token_array=array('clave');		
    $bd->actualiza_(armaupdate('suscritos',$token_array," id_suscrito='".$_POST["id_suscrito"]."'",'POST'));/*actualizo*/

		
}
  
		// if($insertado >0){
			// /* insertado en Bd*/
		// }


