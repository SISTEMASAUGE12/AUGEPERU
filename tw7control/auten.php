<?php session_start();
error_reporting(0);
include_once("class/class.bd.php"); 
include_once("class/functions.php");
include_once("class/class.upload.php");
include_once("class/PHPPaging.lib.php");

$unix_date = strtotime(date('Y-m-d H:i:s'));
$_dominio="educaauge.com";




//$link2 = 'index.php?page='.$_GET["page"].'&module='.$_GET["module"].'&parenttab='.$_GET["parenttab"];    
if( isset($_GET["parenttab"])){
  
  
  $link = 'index.php?page='.$_GET["page"].'&idcap='.$_GET["idcap"].'&module='.$_GET["module"].'&parenttab='.$_GET["parenttab"];
  $link2 = 'index.php?page='.$_GET["page"].'&module='.$_GET["module"].'&parenttab='.$_GET["parenttab"];
  $link_lleva_tipo='index.php?page='.$_GET["page"].'&id_tipo='.$_GET["id_tipo"].'&module='.$_GET["module"].'&parenttab='.$_GET["parenttab"];
  $link_pedidos='index.php?page='.$_GET["page"].'&tipo_pago='.$_GET["tipo_pago"].'&module='.$_GET["module"].'&parenttab='.$_GET["parenttab"];
  
  
  $link_info_webinar = 'index.php?page='.$_GET["page"].'&module='.$_GET["module"].'&parenttab='.$_GET["parenttab"]."&id_webinar=".$_GET["id_webinar"];
  
  $link_expositores_landing_bigs = 'index.php?page='.$_GET["page"].'&module='.$_GET["module"].'&parenttab='.$_GET["parenttab"]."&id_big=".$_GET["id_big"];
  $link_info_landing_bigs = 'index.php?page='.$_GET["page"].'&module='.$_GET["module"].'&parenttab='.$_GET["parenttab"]."&id_big=".$_GET["id_big"];
  $link_agenda_landing = 'index.php?page='.$_GET["page"].'&module='.$_GET["module"].'&parenttab='.$_GET["parenttab"]."&id_big=".$_GET["id_big"];
  
  
  
  $link_tutoriales = 'index.php?page='.$_GET["page"].'&module='.$_GET["module"].'&parenttab='.$_GET["parenttab"]."&tipo=".$_GET["tipo"];
  
  $link_sesion = 'index.php?page='.$_GET["page"].'&module='.$_GET["module"].'&parenttab='.$_GET["parenttab"]."&id_curso=".$_GET["id_curso"];
  $link_detalle = 'index.php?page='.$_GET["page"].'&module='.$_GET["module"].'&parenttab='.$_GET["parenttab"]."&id_sesion=".$_GET["id_sesion"];
  $link_detalle_archivos = 'index.php?page='.$_GET["page"].'&module='.$_GET["module"].'&parenttab='.$_GET["parenttab"]."&id_detalle=".$_GET["id_detalle"];

  $link_asignar_curso = 'index.php?page='.$_GET["page"]."&id_curso=".$_GET["id_curso"].'&module='.$_GET["module"].'&parenttab='.$_GET["parenttab"];
  $link_biblioteca = 'index.php?page='.$_GET["page"]."&id_suscrito=".$_GET["id_suscrito"].'&module='.$_GET["module"].'&parenttab='.$_GET["parenttab"];
  
  $link_landing = 'index.php?page='.$_GET["page"]."&id_landing=".$_GET["id_landing"].'&module='.$_GET["module"].'&parenttab='.$_GET["parenttab"];
  $link_lleva_suscrito = 'index.php?page='.$_GET["page"]."&id_suscrito=".$_GET["id_suscrito"].'&module='.$_GET["module"].'&parenttab='.$_GET["parenttab"];
  
  $link_examen = 'index.php?page='.$_GET["page"]."&id_examen=".$_GET["id_examen"].'&module='.$_GET["module"].'&parenttab='.$_GET["parenttab"];
  $link_pregunta = 'index.php?page='.$_GET["page"]."&id_examen=".$_GET["id_examen"]."&id_pregunta=".$_GET["id_pregunta"].'&module='.$_GET["module"].'&parenttab='.$_GET["parenttab"];
  $link_catearc = 'index.php?page='.$_GET["page"]."&publicacion_idpublicacion=".$_GET["publicacion_idpublicacion"].'&module='.$_GET["module"].'&parenttab='.$_GET["parenttab"];
  $link_blog_archivo = 'index.php?page='.$_GET["page"]."&publicacion_idpublicacion=".$_GET["publicacion_idpublicacion"]."&categoria_idcategoria=".$_GET["categoria_idcategoria"].'&module='.$_GET["module"].'&parenttab='.$_GET["parenttab"];

}






if($_GET['task']=='cargar_sucursales_x_dpto'){  
  $array[] = array('id' => '', 'value' => 'Seleccione');
  $sql = "select id_sucursal, concat(nombre,' - ',direccion) as nombre from agencias_sucursales where id_agencia=".$_GET['variable']." and iddpto=".$_GET['variable_dpto']." order by nombre asc";
  $exsql = executesql($sql);
  if(!empty($exsql)) foreach($exsql as $row) $array[] = array('id' => $row[0], 'value' => $row[1]);
  echo json_encode($array);
  exit();
}


if($_GET['task']=='cargar_sucursales'){  
  $array[] = array('id' => '', 'value' => 'Seleccione');
  $sql = "select id_sucursal, concat(nombre,' - ',direccion) as nombre from agencias_sucursales where id_agencia=".$_GET['variable']." order by nombre asc";
  $exsql = executesql($sql);
  if(!empty($exsql)) foreach($exsql as $row) $array[] = array('id' => $row[0], 'value' => $row[1]);
  echo json_encode($array);
  exit();
}



if($_GET['task']=='cargar_certificados_del_curso'){
  $array[] = array('id' => '', 'value' => 'Seleccione');
  $sql = "select id_certificado, CONCAT(id_certificado,' - ',titulo) as titulo_certi  from certificados where id_curso=".$_GET['variable']." order by titulo asc";
  $exsql = executesql($sql);
  if(!empty($exsql)) foreach($exsql as $row) $array[] = array('id' => $row[0], 'value' => $row[1]);
  echo json_encode($array);
  exit();
}


if($_GET['task']=='cargar_subcategorias'){
  $array[] = array('id' => '', 'value' => 'Seleccione');
  $sql = "select id_sub,titulo from subcategorias where id_cat=".$_GET['variable']." order by titulo asc";
  $exsql = executesql($sql);
  if(!empty($exsql)) foreach($exsql as $row) $array[] = array('id' => $row[0], 'value' => $row[1]);
  echo json_encode($array);
  exit();
}


// if($_GET['task']=='cargar_prov'){
  // $array[] = array('id' => '', 'value' => 'Seleccione');
  // $sql = "select idprvc,titulo from prvc where dptos_iddpto=".$_GET['variable']." order by titulo asc";
  // $exsql = executesql($sql);
  // if(!empty($exsql)) foreach($exsql as $row) $array[] = array('id' => $row[0], 'value' => $row[1]);
  // echo json_encode($array);
  // exit();
// }elseif($_GET['task']=='cargar_prov2'){
  // $array[] = array('id' => '', 'value' => '-- Prov. --');
  // $sql = "select idprvc,titulo from prvc where dptos_iddpto=".$_GET['variable']." order by titulo asc";
  // $exsql = executesql($sql);
  // if(!empty($exsql)) foreach($exsql as $row) $array[] = array('id' => $row[0], 'value' => $row[1]);
  // echo json_encode($array);
  // exit();
// }elseif($_GET['task']=='cargar_dist2'){
  // $array[] = array('id' => '', 'value' => '-- Dist. --');
  // $sql = "select iddist,titulo from dist where prvc_idprvc=".$_GET['variable']." order by titulo asc";
  // $exsql = executesql($sql);
  // if(!empty($exsql)) foreach($exsql as $row) $array[] = array('id' => $row[0], 'value' => $row[1]);
  // echo json_encode($array);
  // exit();
// }


if($_GET['task']=='cargar_prov2'){
  $array[] = array('id' => '', 'value' => '-- Prov. --');
  $sql = "select idprvc,titulo from prvc where dptos_iddpto=".$_GET['variable']." order by titulo asc";
  $exsql = executesql($sql);
  if(!empty($exsql)) foreach($exsql as $row) $array[] = array('id' => $row[0], 'value' => $row[1]);
  echo json_encode($array);
  exit();
}elseif($_GET['task']=='cargar_dist2'){
  $array[] = array('id' => '', 'value' => '-- Dist. --');
  $sql = "select iddist,titulo from dist where prvc_idprvc=".$_GET['variable']." order by titulo asc";
  $exsql = executesql($sql);
  if(!empty($exsql)) foreach($exsql as $row) $array[] = array('id' => $row[0], 'value' => $row[1]);
  echo json_encode($array);
  exit();
}


if(isset($_GET['task']) && $_GET['task'] == 'cargar_prov') {
    $array=[];
    // $array = array('id' => '', 'value' => 'Seleccione');
    $sql = "select idprvc,titulo from prvc where dptos_iddpto=" . $_GET['variable'] . " order by titulo asc";
    $exsql = executesql($sql);
		$array[] = array('id' => '', 'value' => 'Seleccione provincia');
    if (!empty($exsql)) foreach ($exsql as $row) $array[] = array('id' => $row[0], 'value' => $row[1]);
    echo json_encode($array);
    exit();
		
}elseif (isset($_GET['task']) && $_GET['task'] == 'cargar_dist') {
    $array_dist=[];
    // $array_dist = array('id' => '', 'value' => 'Seleccione');
    $sql = "select iddist,titulo from dist where prvc_idprvc=" . $_GET['variable'] . " order by titulo asc";
    $exsql = executesql($sql);
		
		$array_dist[] = array('id' => '', 'value' => 'Seleccione distrito');
    if (!empty($exsql)) foreach ($exsql as $row) $array_dist[] = array('id' => $row[0], 'value' => $row[1]);
    echo json_encode($array_dist);
    exit();
}


/* recalculo comiision administrable  */
$comisiones=executesql("select * from data_comisiones where estado_idestado=1 order by id_data desc ");
if( !empty($comisiones) ){
  $_SESSION["visualiza"]["comision"]= $comisiones[0]["comision_propia"];
  $_SESSION["visualiza"]["compartida_el_que_ayudo"] = $comisiones[0]["compartida_el_que_ayudo"];
  $_SESSION["visualiza"]["compartida_el_dueno_cliente_oficina"] = $comisiones[0]["compartida_el_dueno_cliente_oficina"];
  $_SESSION["visualiza"]["compartida_el_dueno_cliente_externo"] = $comisiones[0]["compartida_el_dueno_cliente_externo"];
  
}else{
  $_SESSION["visualiza"]["comision"]=$users[0]["comision"];
  $_SESSION["visualiza"]["compartida_el_que_ayudo"]= 1;
  $_SESSION["visualiza"]["compartida_el_dueno_cliente_oficina"]= 1;
  $_SESSION["visualiza"]["compartida_el_dueno_cliente_externo"]= 1; 

}
/* recalculo comiision administrable  */



?>