<?php
function agregaralog(){}

function fn_filtro($cadena) {
	$bd = new BD();
	if($bd->status==BD::CERRADA) $bd->open();
	$conn = $bd->cn;
	
	/*
	if(get_magic_quotes_gpc() != 0) {
	}
*/

	// $cadena = stripslashes($cadena);
	return @mysqli_real_escape_string($conn,$cadena);
	
	//return sprintf($cadena);
}
function conversorSegundosHoras($tiempo_en_minutos) {
    $horas = floor($tiempo_en_minutos / 60);
    $minutos = floor($tiempo_en_minutos - ($horas * 60));

    $hora_texto = "";
    if($horas>0){
    		if($horas>9) $hora_texto .= $horas.":";
    		else $hora_texto .= "0".$horas.":";
    }else{
    		$hora_texto .= "00:";
    }

    if($minutos>0){
        if($minutos>9) $hora_texto .= $minutos.":";
    		else $hora_texto .= "0".$minutos.":";
    }else{
    		$hora_texto .= "00:";
    }

    $hora_texto .= "00";

    return $hora_texto;
}
function arma_insert($tablename,$campos,$method="POST"){
		$sql_insert="insert into $tablename(";
		$query = ''; $insertdata='';
			foreach ($campos as $estructura){
					$campo = is_array($estructura) ? $estructura[0] : $estructura;
					if (!$query){
						$query = "`$campo`"; 
					}else{
						$query .= ", `$campo`";
					}
					if(is_array($estructura)) 
            $DATA_campo = fn_filtro($estructura[1]);
          else
            $DATA_campo = ($method=='POST') ? fn_filtro($_POST[$campo]) : fn_filtro($_GET[$campo]);

					if (!$insertdata){
						$insertdata = "'".$DATA_campo."'"; 
					}else{
						$insertdata.= ",'".$DATA_campo."'";
					}				
			}
		$sql_insert.=$query.") values(".$insertdata.");";
		return $sql_insert;
}

function armaupdate($tablename,$campos,$where,$method="POST"){
	$sql_update="update $tablename set ";
	$query = ''; $insertdata='';
		foreach ($campos as $estructura){
			if(is_array($estructura)){
        $campo=$estructura[0];
        $valor_campo=fn_filtro($estructura[1]);
      }else{
        $campo=$estructura;	
        $valor_campo=($method=='POST') ? fn_filtro($_POST[$campo]) : fn_filtro($_GET[$campo]);
      }
			$valdatacampo=($valor_campo=="NULL") ? $valor_campo : "'".$valor_campo."'";	

			if (!$query){
				$query = "`$campo`=".$valdatacampo; 
			}else{
				$query.= ", `$campo`=".$valdatacampo;
			}
	}
	$sql_update.=$query." where ".$where;
	return $sql_update;
}

function _orden_noticia($orden, $tabla="publicacion", $where=''){
	if($orden>0){
		$r_orden=$orden;
	}else{
		$bd = new BD();
		$query="select orden from ".$tabla;
		if($where!=''){ $query.=" where ".$where; }
		$query.=" order by orden desc";
		//echo $query;
		
		$afectada=$bd->Execute($query);
		$r_orden=!empty($afectada)?$afectada[0]['orden']+1: 1;
		// $r_orden=($afectada[0]['orden']+1);
	}
	return $r_orden;
}

function _orden_noticia_destacada($orden, $tabla="publicacion", $where=''){
	if($orden>0){
		$r_orden=$orden;
	}else{
		$bd = new BD();
		$query="select orden_destacado from ".$tabla;
		if($where!=''){ $query.=" where ".$where; }
		$query.=" order by orden_destacado desc";
		//echo $query;
		$afectada=$bd->Execute($query);
		$r_orden=!empty($afectada)?$afectada[0]['orden_destacado']+1:1;
		// $r_orden=($afectada[0]['orden']+1);
	}
	return $r_orden;
}

function nuevoorden($orden_actual, $orden_nuevo, $tipo, $id_del_registro_actual, $tabla, $campoid, $criterio_Orden){
	$bd=new BD;
	$bd->Begin();
	
	if($tipo=="asc"){
		$sqlorden="select * from ".$tabla." where orden>'".$orden_actual."' ".$criterio_Orden." order by orden asc";
		$data_detalle=executesql($sqlorden,0);
			
	}elseif($tipo=="desc"){
		$sqlorden="select * from ".$tabla." where orden<'".$orden_actual."' ".$criterio_Orden." order by orden desc";
		$data_detalle=executesql($sqlorden,0);

	}else{
		$sqlorden="select * from ".$tabla." where orden='".$orden_nuevo."' ".$criterio_Orden;
		$data_detalle=executesql($sqlorden,0);
	
	}
		$orden_del_registro_anterior=$data_detalle["orden"];
		$id_del_registro_anterior=$data_detalle[$campoid];
		//echo $sqlorden."\n\n";
	
	if($id_del_registro_anterior!=''){
		$campos=array(array("orden",$orden_del_registro_anterior));	
		$query=armaupdate($tabla,$campos,$campoid."='".$id_del_registro_actual."' ".$criterio_Orden,"");
		//echo $query."\n\n";
		$bd->actualiza_($query);	
		
		$campos=array(array("orden",$orden_actual));	
		$query=armaupdate($tabla,$campos,$campoid."='".$id_del_registro_anterior."' ".$criterio_Orden,"");
		//echo $query."\n\n";
		$bd->actualiza_($query);			
	}
	$bd->Commit();
}



function orden_detacado($orden_actual, $orden_nuevo, $tipo, $id_del_registro_actual, $tabla, $campoid, $criterio_Orden){
	$bd=new BD;
	$bd->Begin();
	
	if($tipo=="asc"){
		$sqlorden="select * from ".$tabla." where orden_detacado>'".$orden_actual."' ".$criterio_Orden." order by orden_detacado asc";
		$data_detalle=executesql($sqlorden,0);
			
	}elseif($tipo=="desc"){
		$sqlorden="select * from ".$tabla." where orden_detacado<'".$orden_actual."' ".$criterio_Orden." order by orden_detacado desc";
		$data_detalle=executesql($sqlorden,0);

	}else{
		$sqlorden="select * from ".$tabla." where orden_detacado='".$orden_nuevo."' ".$criterio_Orden;
		$data_detalle=executesql($sqlorden,0);
	
	}
		$orden_del_registro_anterior=$data_detalle["orden_detacado"];
		$id_del_registro_anterior=$data_detalle[$campoid];
		//echo $sqlorden."\n\n";
	
	if($id_del_registro_anterior!=''){
		$campos=array(array("orden_detacado",$orden_del_registro_anterior));	
		$query=armaupdate($tabla,$campos,$campoid."='".$id_del_registro_actual."' ".$criterio_Orden,"");
		//echo $query."\n\n";
		$bd->actualiza_($query);	
		
		$campos=array(array("orden_detacado",$orden_actual));	
		$query=armaupdate($tabla,$campos,$campoid."='".$id_del_registro_anterior."' ".$criterio_Orden,"");
		//echo $query."\n\n";
		$bd->actualiza_($query);			
	}
	$bd->Commit();
}





function armarurlrewrite($texto,$repetido=0,$tbl='',$fieldID='',$fieldRew='',$where=''){
	$vocalti= array ("á","é","í","ó","ú","Á","É","Í","Ó","Ú","ñ","Ñ","À","È","Ì","Ò","Ù","à","è","ì","ò","ù","ç","Ç","â","ê","î","ô","û","Â","Ê","Î","Ô","Û","ü","ö","Ö","ï","ä","ë","Ü","Ï","Ä","Ë", "'", " ");
  $vocales= array ("a","e","i","o","u","A","E","I","O","U","n","N","A","E","I","O","U","a","e","i","o","u","c","C","a","e","i","o","u","A","E","I","O","U","u","o","O","i","a","e","U","I","A","E", "", "-");
    $cadena=str_replace($vocalti,$vocales,$texto);
	//echo $cadena;
	$cadena = strtolower($cadena);
  $find = array('/[^a-z0-9\-<>]/', '/[\-]+/', '/<[^>]*>/'); 
  $repl = array('', '-', ''); 
	$cadena =  preg_replace($find, $repl, $cadena); 
	//$texto=strtolower($cadena);
	
	if($repetido==1)
  {
    $i = 1;
    $resp = false;
    do
    {
      $resultado = executesql("SELECT count(".$fieldID.") as cont FROM ".$tbl." WHERE ".$fieldRew."='".$texto."' ".$where);
      
      if($resultado[0]['cont']<=0)
        $resp = true;
      else
      { 
        if (strpos($texto,'_') !== false)
        {
          $dividir = explode('_',$texto);
          $texto = strtr($texto,array( '_'.end($dividir) => '_'.$i ));
        }
        else $texto = $texto.'_'.$i;
        $resp = false;
        $i++; 
      }
    }
    while(!$resp);
    $cadena = $texto;
  }

  return $cadena; 
}

function get_public_ip(){
  $externalContent = file_get_contents('http://checkip.dyndns.com/');
  preg_match('/Current IP Address: \[?([:.0-9a-fA-F]+)\]?/', $externalContent, $m);
  $externalIp = $m[1];
  return $externalIp;
}

function fecha_hora($i){
	//$ahora = @getdate();
	date_default_timezone_set('America/Lima');
	if($i==0){
		//$str = formatNum2($ahora["hours"]+1,"hour") . ":" . formatNum2($ahora["minutes"],"minute") . ":" . $ahora["seconds"];
		$str = @date("H:i:s");
	}elseif($i==1){
		//$str = $ahora["year"]."-".formatNum2($ahora["mon"],"month"). "-" .formatNum2($ahora["mday"],"day") ;
		$str = @date("Y-m-d");
	}elseif($i==2){
		//$str = $ahora["year"]."-".formatNum2($ahora["mon"],"month"). "-" .formatNum2($ahora["mday"],"day") ;
		$str = @date("Y-m-d");
		$str1 = @date("H:i:s");
		//$str1 = formatNum2($ahora["hours"]+1,"hour") . ":" . formatNum2($ahora["minutes"],"minute") . ":" . $ahora["seconds"];
		$str=$str." ".$str1;
	}
	return $str;
}

function executesql($sql,$tipo=1){
	$bd = new BD();
	$position = $bd->Execute($sql);
	
	if(intval($tipo)==0){
		$position = $position[0];
	}
	return $position;
}




function create_input($tipo,$campo,$value,$class,$table,$agregados){
	switch($tipo):
		case "text":
		echo '<input type="text" name="'.$campo.'" id="'.$campo.'" value="'.$value.'" class="'.$class.'" '.$agregados.'/>';
		break;
		
		case "date":
		echo '<input type="date" name="'.$campo.'" id="'.$campo.'" value="'.$value.'" class="'.$class.'" '.$agregados.'/>';
		break;
		
		case "checkbox":
		echo '<input type="checkbox" name="'.$campo.'" id="'.$campo.'" value="'.$value.'" class="'.$class.'"  '.$agregados.' />';
		break;
		
		case "textarea":
		echo '<textarea name="'.$campo.'" id="'.$campo.'" class="'.$class.'" '.$agregados.'>'.$value.'</textarea>';
		break;	
		
		case "hidden":
		echo '<input type="hidden" name="'.$campo.'" id="'.$campo.'" class="'.$class.'" value="'.$value.'" '.$agregados.'/>';
		break;
		
		
		case "password":
		echo '<input type="password" name="'.$campo.'" id="'.$campo.'" class="'.$class.'" value="'.$value.'" '.$agregados.'/>';
		break;		
		
		case "file":
		echo '<input type="file" name="'.$campo.'" id="'.$campo.'" class="'.$class.'"'. $agregados.'/>';
		break;

		case "number":
		echo '<input type="number" name="'.$campo.'" id="'.$campo.'" class="'.$class.'"'. $agregados.'/>';
		break;

		case "email":
		echo '<input type="email" name="'.$campo.'" id="'.$campo.'" class="'.$class.'"'. $agregados.'/>';
		break;
				
		default:
		
		break;	
	endswitch; 
}


function crearselect($nombre,$sqlQuery,$agregados,$buscado="",$optioninicial=""){
	$bd = new BD();
	$res = $bd->Execute($sqlQuery);
	echo '<select name="'.$nombre.'" id="'.strtr($nombre,array('[]' =>'')).'" '.$agregados.'>';//ese array sirve para marcar los campos ya selecionados. al momento ed editar
  
  // if($optioninicial!="") echo '<option value=""  selected="selected">'.$optioninicial.'</option>';
  if($optioninicial!="") echo '<option value=""  >'.$optioninicial.'</option>';
	$buscado=!is_array($buscado) ? array($buscado) : $buscado;
  if(count($res)>0){
	foreach($res as $k=>$v){
		$selected=in_array($v[0],$buscado) ? " selected='selected'" :" ";
		echo '<option value="'.$v[0].'" '.$selected.'>'.$v[1].'</option>';
	}
	}else{/*echo '<option value="0" selected="selected">Data no disponible</option>';*/}
	echo "</select>";
}


function select_sql($tipo){
	if($tipo=='orden'){
	echo '<select name="criterio_orden" id="criterio_orden" class="form-control pull-right">
	<option value="desc">Descendente</option>
	<option value="asc">Ascendente</option>
	</select>';
	}elseif($tipo=='nregistros'){
	echo '<select name="criterio_mostrar" id="criterio_mostrar" class="form-control pull-right">
	<option value="100" selected>100</option>
	<option value="400">400</option>
	<option value="500">500</option>
	<option value="15000">15 000</option>
	</select>';
	}
}

function gotoUrl($url){
	 echo '<script>window.location.href="'.$url.'";</script>';

	 /*
	echo $variable = "Location: https://www.educaauge.com/tw7control/".$url;
	header($variable);

    exit;  // Asegúrate de llamar
	*/
}

function codigo_AUTO($letrasini,$nomItem){
	$nom1=trim(strtoupper($nomItem));
	$nomCorto=substr($nom1,0,3);
	$cod = "0".rand(100,999);
	$codItem=$letrasini."-".$nomCorto.$cod;
	return $codItem;
}

function RAN_CLAVE($letrasini,$nomItem){
	$nom1=trim($nomItem);
	$nomCorto=substr($nom1,0,5);
	$cod = rand(100,999);
	$codItem= $nomCorto.$cod;
	return $codItem;
}

function REN_IMG($nomItem){
	$nom1=trim($nomItem);
	$nomCorto=end(explode(".", strtolower($nom1)));
	$cod = rand(0,999999);
	$nme = substr($nom1,0,strlen($nom1)-(strlen($nomCorto)+1));
	$codItem= $nme."_".$cod.'.'.$nomCorto;
	return $codItem;
}

function extension($str){
  return end(explode(".", strtolower($str)));
}


/* imagenes & Archivos */

function rand_str($length=32,$chars='')
{
	if(strlen($chars) <= 0) $chars='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890';
	$string = '';
	for ($i=0; $i<$length; $i++) $string .= substr($chars, rand(0, strlen($chars)-1), 1);
	return $string;
}

/* si recorta

function carga_imagen($dirimage,$file,$file_ant,$x,$y,$ratio=true)
{
	$generic_name = (string) strtoupper(rand_str(4).date("s"));
	if($_FILES[$file]["size"]>0)
	{
		$handle = new Upload($_FILES[$file]);
		if ($handle->uploaded)
		{
			$handle->file_overwrite     = false;
			$handle->file_new_name_body	= $generic_name;
			if(!empty($x) && !empty($y)) $handle->image_resize = true;
			
			if(!empty($x)) 
			{
				if($ratio) $handle->image_ratio_y = true;
				$handle->image_x			= $x;
			}
			if(!empty($y)) 
			{
        if($ratio) $handle->image_ratio_x = true;
        $handle->image_y			= $y;
			}
		  // $handle->image_convert  = 'jpg';
			$handle->jpeg_quality		= 85; 
			$handle->Process($dirimage);
			if ($handle->processed)  $imagen_upload=$handle->file_dst_name;
			$handle-> Clean();
		}
	}
	else $imagen_upload=$file_ant;
	
	return $imagen_upload;
}

*/


function carga_imagen($dirimage,$file,$file_ant,$x,$y,$ratio=true)
{
	$generic_name = (string) strtoupper(rand_str(4).date("s"));
	if($_FILES[$file]["size"]>0)
	{
		$handle = new Upload($_FILES[$file]);
		if ($handle->uploaded)
		{
			$handle->file_overwrite     = false;
			$handle->file_new_name_body	= $generic_name;
			//if(!empty($x) && !empty($y)) $handle->image_resize = true;
			/*
			if(!empty($x)) {
				if($ratio) $handle->image_ratio_y = true;
				$handle->image_x			= $x;
			}
			if(!empty($y)) {
        		if($ratio) $handle->image_ratio_x = true;
        		$handle->image_y			= $y;
			}
*/
		  // $handle->image_convert  = 'jpg';
			// $handle->jpeg_quality		= 85; 

			$handle->Process($dirimage);
			if ($handle->processed)  $imagen_upload=$handle->file_dst_name;
			$handle-> Clean();
		}
	}
	else $imagen_upload=$file_ant;
	
	return $imagen_upload;
}




function upload_files($ruta,$archivo,$archivo_encaso_vacio,$reemplazo=1){
	$generic_name = (string) strtoupper(rand_str(4).date("s"));
	if( ($_FILES[$archivo]['size'] < 1000000000) && ($_FILES[$archivo]['size']>0) ){
    $NOM_file	= armarurlrewrite(basename($_FILES[$archivo]['name'],".pdf")).".pdf";
		$destino 	= $ruta . $NOM_file;	
    if(file_exists($destino)){
      $prefijo	= substr(md5(uniqid(rand())),0,6);
      $NOM_file	= $prefijo . '_' . $NOM_file;
      $destino 	= $ruta . $NOM_file;	
    }
		$file_uploader = move_uploaded_file($_FILES[$archivo]['tmp_name'],$destino) ? $NOM_file : $archivo_encaso_vacio;
		return $file_uploader;	
	}else return $archivo_encaso_vacio;
}



/* paginacion Intranet*/
function pagina_actual(){
	return basename($_SERVER['REQUEST_URI']);
}

function armapaginacion($sql,$div,$modo,$numregistro,$mantenervariable,$cabeceras,$opciones,$table_primary,$porPagina){
/*	@header ("Expires: Fri, 14 Mar 1980 20:53:00 GMT"); //la pagina expira en fecha pasada
	@header ("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); //ultima actualizacion ahora cuando la cargamos
	@header ("Cache-Control: no-cache, must-revalidate"); //no guardar en CACHE
	@header ("Pragma: no-cache"); //PARANOIA, NO GUARDAR EN CACHE*/

	include_once  "class/class.bd.php";
	include_once  "class/functions.php";
	include_once "class/PHPPaging.lib.php";	
	
	$paging = new PHPPaging;
	$paging->agregarConsulta($sql); 
	$paging->div($div);
	$paging->modo($modo); 
	if($numregistro) $paging->porPagina(fn_filtro((int)$numregistro));
	$paging->verPost(true);
	$paging->mantenerVar($mantenervariable);
	$paging->porPagina(fn_filtro((int)$porPagina));
	$paging->ejecutar();
	$paging->pagina_proceso=basename($_SERVER['PHP_SELF']);
		
	echo '<div class="pagination">'.$paging->fetchNavegacion().'</div>';
	echo '<table cellspacing="1" class="lista" id="grilla" width="100%">';
	echo '<thead><tr>';
	foreach($cabeceras as $headers):
		//echo $headers[3];
		echo '<th>'.$headers[3].'</th>';
	endforeach;
		echo "<th width=\"1%\">Opciones</th>"; 
	echo '</tr></thead>';
	echo '<tbody>';
        while ($rs_per = $paging->fetchResultado()){
        echo '<tr id="tr_'.$rs_per[0].'" ';
		echo $i++%2==0 ? ' class="even"' : ' class="odd"';
		echo '>';
			foreach($cabeceras as $head):
				echo '<td>'.$rs_per[$head[2]].'</td>';
			endforeach;
			
				echo '<td>';
			
				/***/
				$bd=new BD;
				$indexs_tables=$bd->Execute('SHOW INDEX FROM '.$table_primary);
				$url_complemento='';
				foreach($indexs_tables as $indices){
					$url_complemento.=$indices['Column_name']."=".$rs_per[$indices['Column_name']]."&";
				}
				/***/
				
				foreach($opciones as $opt):
				//echo $opt[2];
					switch($opt[0]):
						case ($opt[0]=='drop'):
							if($opt[2]==0){
								echo '<a href=\'javascript: fn_eliminar("'.$rs_per[0].'");\'"><img src="images/delete.png" /></a>';
							}else{
								$url_t=$_SESSION["base_url"].'&task=drop&'.$url_complemento;
								echo '<a href="'.$url_t.'" title="'.$opt[1].'"><img src="images/delete.png" /></a>';
							}
						break;
						
						case ($opt[0]=='edit'):
							if($opt[2]==0){
								echo '<a href=\'javascript: fn_mostrar_frm_modificar("'.$rs_per[0].'");\'"><img src="images/page_edit.png" /></a>';
							}else{
								$url_t=$_SESSION["base_url"].'&task=edit&'.$url_complemento;
								echo '<a href="'.$url_t.'"  title="'.$opt[1].'"><img src="images/page_edit.png" /></a>';
							}
						break;
						
						default:
							$url_t=$_SESSION["base_url"].'&task='.$opt[0].'&'.$url_complemento;
							//echo "<a href=\"\"><img src=\"images/page_edit.png\" /></a>";
							echo '<a href="'.$url_t.'" title="'.$opt[1].'">Precios de Venta</a>';
						break;
						
					endswitch;
					
			 endforeach;
        echo '</tr>';
	 } 
	echo '</tbody>';
	echo '</table>';
	echo '<div class="pagination">'.$paging->fetchNavegacion().'</div>';
}


// FECHA
function fecha($fec1,$mesabr=false,$formato = ' | '){ //de | del
	setlocale(LC_ALL,"es_ES@euro","es_ES","esp");
	$d1 = $fec1;
	$fmtt = $mesabr ? "%b" : "%B";
	$fmt = explode('|', $formato);
	//$fecha = $d."/".ucfirst(substr($m,0,3))."/".$a;
	$fecha = strftime("%d".$fmt[0].$fmtt.$fmt[1]."%Y", strtotime($d1));
	return $fecha;
	// fecha($item['fecha'],true,'/|/');
}

// CADENA
function repl($txt){
  $v1 = array(' | ','á','é','í','ó','ú',' ');
  $v2 = array('-','a','e','i','o','u','-');
  $tx1 = str_replace($v1,$v2,$txt);
  $cdn = strtolower($tx1);
  return $cdn;
}






/* paginacion Prensa , etc*/

function configurar_paginador($custom = array())
{
  include_once("PHPPaging.lib.php"); 

  if(!isset($custom['sql'])) $custom['sql'] = '';
  if(!isset($custom['div'])) $custom['div'] = 'listado';
  if(!isset($custom['params'])) $custom['params'] = array();
  if(!isset($custom['pages'])) $custom['pages'] = 1;

  $paging = new PHPPaging;
  $paging->agregarConsulta($custom['sql']); 
  $paging->div($custom['div']);
  $paging->estilo           = '';
  $paging->mostrarResto     = '<li>{n}</li>';
  $paging->mostrarActual    = '<li class="current">{n}</li>';
  $paging->linkSeparador    = '';
  $paging->mostrarAnterior  = '&laquo;';
  $paging->mostrarSiguiente = '&raquo;';
  $paging->modo('reporte');
  $paging->verPost(true);
  $paging->mantenerVar($custom['params']);
  $paging->porPagina($custom['pages']);
  $paging->ejecutar();
  $paging->pagina_proceso=$custom['div'].".php";

  return $paging;
}


// ARCHIVOS

function xtn($ext){
	$ex = extension($ext);
	              
	switch ($ex):
		case 'docx':
		  echo 'word';
		  break;
		case 'doc':
		  echo 'word';
		  break;
		case 'pptx':
		  echo 'pwp';
		  break;
		case 'pdf':
		  echo 'pdf';
		  break;
		case 'xlsx':
		  echo 'excel';
		  break;
		default:
		  echo '';
		  break;
	endswitch;
}

//eliminar directorio con todo adentro
function rrmdir($dir) { 
   if (is_dir($dir)) { 
     $objects = scandir($dir); 
     foreach ($objects as $object) { 
       if ($object != "." && $object != "..") { 
         if (filetype($dir."/".$object) == "dir") rrmdir($dir."/".$object); else unlink($dir."/".$object); 
       } 
     } 
     reset($objects); 
     rmdir($dir); 
   } 
} 


// nombre corto 
function short_name($str,$limit){
	if($limit < 3) $limit=3;
	return(strlen($str) > $limit) ? substr($str,0,$limit - 3) . '...' : $str;	
}


function url_completa($forwarded_host = false) {
    $ssl   = !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on';
    $proto = strtolower($_SERVER['SERVER_PROTOCOL']);
    $proto = substr($proto, 0, strpos($proto, '/')) . ($ssl ? 's' : '' );
    if ($forwarded_host && isset($_SERVER['HTTP_X_FORWARDED_HOST'])) {
        $host = $_SERVER['HTTP_X_FORWARDED_HOST'];
    } else {
        if (isset($_SERVER['HTTP_HOST'])) {
            $host = $_SERVER['HTTP_HOST'];
        } else {
            $port = $_SERVER['SERVER_PORT'];
            $port = ((!$ssl && $port=='80') || ($ssl && $port=='443' )) ? '' : ':' . $port;
            $host = $_SERVER['SERVER_NAME'] . $port;
        }
    }
    $request = $_SERVER['REQUEST_URI'];
    return $proto . '://' . $host . $request;
}

function auto_codigo($letrasini,$nomItem){
	$letrasini="AU";
  $nom1		= trim(strtoupper($nomItem));
	$nomCorto	= substr($nom1,0,4);
	$cod 		= rand(10,999);
	$codItem	= $letrasini.$nomCorto.$cod;
	return $codItem;
}


function get_nombre_dia($fecha){
	$fechats = strtotime($fecha); //pasamos a timestamp                           
	//el parametro w en la funcion date indica que queremos el dia de la semana
	//lo devuelve en numero 0 domingo, 1 lunes,....
	switch (date('w', $fechats)){
		case 0: return "domingo"; break;
		case 1: return "lunes"; break;
		case 2: return "martes"; break;
		case 3: return "miercoles"; break;
		case 4: return "jueves"; break;
		case 5: return "viernes"; break;
		case 6: return "sabado"; break;
	}
}


function insert_table($tabla, $datos) {
	//para convertir los nombres de los campos (array_keys($datos)) en una cadena separada por comas.
    $campos = implode(',', array_keys($datos));

    $valores = "'" . implode("','", array_values($datos)) . "'";
	//para convertir los valores de los campos (array_values($datos)) en una cadena donde cada valor está rodeado por comillas y separados por comas. 
    $sql = "INSERT INTO $tabla ($campos) VALUES ($valores)";
    return $sql; // Devuelve la consulta de inserción construida
}

function update_table($table, $data, $condition) {
    $update = [];
    foreach ($data as $column => $value) {
        $update[] = "$column = '$value'";
    }
    $update_str = implode(", ", $update);
    return "UPDATE $table SET $update_str WHERE $condition";
}



?>