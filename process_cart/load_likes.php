<?php include("../auten.php");//se cargan los likes del suscrito
$bd=new BD;
$ides_product[]="";
$nro_product=0;$nro_pedidos=0;

//Add favorit destino  
if(!empty($_SESSION["suscritos"]["id_suscrito"])){
  $rpta="isset";
  $_POST["id_suscrito"]=$_SESSION["suscritos"]["id_suscrito"];
//validacion productos
  $validar=executesql("select * from favoritos_productos where id_suscrito='".$_POST["id_suscrito"]."'");
  if(!empty($validar)){ 
    foreach($validar as $row){
      $ides_product[]=array($row["id_producto"]);//el tipo lo sco desde sql inner join productos
    }
  }  
  
//total de favoritos productos y pedidos ,  x suscritos
  $ide=$_SESSION["suscritos"]["id_suscrito"];  
  $pedido=executesql("select count(*) as npedido from pedidos where id_suscrito='".$ide."' and estado_idestado=1 ",0);
  $nro_pedidos=$pedido["npedido"];
  $f_produc=executesql("select count(*) as n_pro from favoritos_productos fv INNER JOIN productos p ON fv.id_producto=p.id_producto where id_suscrito='".$ide."' ",0);
  $nro_product=$f_produc["n_pro"];  
    
}else{
  $rpta="no";//sino exite sesion
}
// $bd->close();
echo json_encode(array(
  "rpta" => $rpta, 
  "content_product" => $ides_product,
  "nro_product" => $nro_product,
  "nro_pedidos" => $nro_pedidos
  )
);  
?>