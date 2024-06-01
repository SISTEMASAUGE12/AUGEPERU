<?php include("../auten.php");
$bd=new BD;
$msj="";
$quitar="f-1";
$add="f-2";
$nro_product=0;$nro_pedidos=0;

//like++
if(!empty($_POST["id_producto"])){
  $tabla="productos";
  $id_tabla="id_producto";
  $recibido=$_POST["id_producto"];
  $tabla_favori="favoritos_productos";
}else{

}

if(!empty($_POST["id_producto"]) ){
  $numero=executesql("select likes from ".$tabla." where ".$id_tabla."='".$recibido."'");
  $_POST["likes"] = $numero[0]["likes"];    

  //Add favorit  
  if(!empty($_SESSION["suscritos"]["id_suscrito"])){
    $_POST["id_suscrito"]=$_SESSION["suscritos"]["id_suscrito"];
  //validacion
    $validar=executesql("select * from ".$tabla_favori." where id_suscrito='".$_POST["id_suscrito"]."' and  ".$id_tabla."='".$recibido."' ");
    if(!empty($validar)){ //deslike
      $msj="Se quito de favoritos.";  
      $quitar="f-2";
      $add="f-1";
      $bd->actualiza_("delete from ".$tabla_favori." where id_suscrito='".$_POST["id_suscrito"]."' and ".$id_tabla."='".$recibido."' ");
    }else{ //likes++
      $msj="Se añadio a favoritos.";  
      $_POST["likes"]++;
      $campos_favorit=array("id_suscrito","".$id_tabla."");//fav++
      $insertado=$bd->inserta_(arma_insert($tabla_favori,$campos_favorit,"POST"));
    }

//total de favoritos productos y pedidos
  $ide=$_SESSION["suscritos"]["id_suscrito"];
  
  $pedido=executesql("select count(*) as npedido from pedidos where id_suscrito='".$ide."' and estado_idestado=1 ",0);
  $nro_pedidos=$pedido["npedido"];
  $f_produc=executesql("select count(*) as n_pro from favoritos_productos fv INNER JOIN productos p ON fv.id_producto=p.id_producto where id_suscrito='".$ide."' ",0);
  $nro_product=$f_produc["n_pro"];    
    
  }else{ //para no suscritos
    if(isset($_POST["pintado"])){
      if($_POST["pintado"]=="yes"){ //aqui puede deslikear y restar likes,etc
      }
    }else{$_POST["likes"]++; }
  }

  $bd->actualiza_(armaupdate($tabla,array("likes")," ".$id_tabla."='".$recibido."'",'POST'));//update like
  $bd->close();
  echo json_encode(array(
    "rpta" => $_POST["likes"], 
    "msj" => $msj,
    "quitar" => $quitar,
    "add" => $add,
    "nro_product" => $nro_product,
    "nro_pedidos" => $nro_pedidos
  )); 
}   
?>