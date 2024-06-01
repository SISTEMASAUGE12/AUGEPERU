<?php 
// data puntual
$alumn = executesql("SELECT * FROM suscritos_x_cursos WHERE estado_idestado = 1 AND id_curso = '".$curso[0]['id_curso']."'");

if( !empty($curso[0]['id_pro']) ){
$profe = executesql("SELECT * FROM profesores WHERE id_profesor IN (".$curso[0]['id_pro'].") ");
}
$fecha= date('m\/Y ',strtotime($curso[0]['fecha_actualizacion']));
$mes= date('m',strtotime($curso[0]['fecha_actualizacion']));
$mes_actual = date("m");


// si tiene dependientes .. capturamos y agrupamos en HTML para el carrito ..
$_data_cursos_dependientes="";
if( !empty($curso[0]['cursos_dependientes']) ){
	// $sql_dependientes="select c.*, p.titulo as profe from cursos c INNER JOIN profesores p ON c.id_pro=p.id_profesor where c.estado_idestado=1 and c.id_curso IN (".$curso[0]['cursos_dependientes'].") order by c.titulo asc ";
	$sql_dependientes="select c.* from cursos c  where c.estado_idestado=1 and c.id_curso IN (".$curso[0]['cursos_dependientes'].") order by c.titulo asc ";

	$dependientes=executesql($sql_dependientes);
	if( !empty($dependientes) ){
		foreach( $dependientes as $anexo ){
			$_data_cursos_dependientes.="<div class='detalle'><figure class='img-cesta rel'><img src='tw7control/files/images/capa/".$anexo["imagen"]."'><div class='capa abs'></div></figure><div class='delete_curso text-center '></div><div class='titulo'><p class='poppi-b color1'>".$anexo["titulo"]."</p></div></div>";
			
		}
	}
}


// si tiene especiales .. capturamos y agrupamos en HTML para el carrito ..
$_data_ides_especialidades="";
$_data_cursos_especiales="";
if( !empty($curso[0]['cursos_especialidades']) ){ 
	
	$sql_especiales="select c.* from cursos c 
										INNER JOIN especialidades esp ON c.id_especialidad=esp.id_especialidad 
										WHERE c.estado_idestado=1 and c.id_curso IN (".$curso[0]['cursos_especialidades'].") and esp.id_especialidad='".$especialidad_del_cliente."' 
										ORDER by c.titulo asc ";
									
	$especiales=executesql($sql_especiales);
	if( !empty($especiales) ){
		$n_esp=0;
		foreach( $especiales as $anexo_especiales ){
			if($n_esp==0){
				$_data_ides_especialidades=$anexo_especiales['id_curso'];
			}else{
				$_data_ides_especialidades=$_data_ides_especialidades.','.$anexo_especiales['id_curso'];				
			}
			
			$_data_cursos_especiales.="<div class='detalle'><figure class='img-cesta rel'><img src='tw7control/files/images/capa/".$anexo_especiales["imagen"]."'><div class='capa abs'></div></figure><div class='delete_curso text-center '></div><div class='titulo'><p class='poppi-b color1'>".$anexo_especiales["titulo"]."</p></div></div>";	
			$n_esp++;   
			
		}
	}
}



?>