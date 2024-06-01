<?php error_reporting(E_ALL ^ E_NOTICE);
include ("auten.php");

if($_GET["task"]=='neworden'){
  $bd=new BD;
  $orden_actual=$_GET["orden"];
  $orden_nuevo=$_GET["nuevoorden"];
  $tipo=$_GET["tipo"];  
  $id_del_registro_actual=$_GET["id_curso"];
  $criterio_Orden =" ";
  nuevoorden($orden_actual, $orden_nuevo, $tipo, $id_del_registro_actual, "cursos", "id_curso", $criterio_Orden);    
  $bd->close();

}elseif($_GET["task"]=='curso_envivo'){
  $bd=new BD;
	
	// if( !empty($_POST['enlace_en_vivo']) && !empty($_POST['hora_en_vivo']) ){
		// $_POST['en_vivo']=1;
	// }else{
		// $_POST['en_vivo']=2;		
	// }
	
	// $campos=array('en_vivo','enlace_en_vivo','hora_en_vivo');
	$campos=array('en_vivo','enlace_en_vivo','hora_en_vivo','horario_inicio','horario_final','horario_hora','horario_lunes','horario_martes','horario_miercoles','horario_jueves','horario_viernes','horario_sabado','horario_domingo');
	

	// $campos=array('en_vivo');
	// if(!empty($_POST['enlace_en_vivo'])) $campos = array_merge($campos,array('enlace_en_vivo'));
	// if(!empty($_POST['hora_en_vivo'])) $campos = array_merge($campos,array('hora_en_vivo'));
	
	// echo var_dump(armaupdate('cursos',$campos," id_curso='".$_POST["id_curso"]."'",'POST'));
	// exit();
	
	$hola=$bd->actualiza_(armaupdate('cursos',$campos," id_curso='".$_POST["id_curso"]."'",'POST'));/*actualizo*/
		
  $bd->close();
	if($hola>0){
			echo $rpta=1;
	}
  // gotoUrl("index.php?page=".$_POST["nompage"]."&id_tipo=".$_POST["id_tipo"]."&module=".$_POST["nommodule"]."&parenttab=".$_POST["nomparenttab"]);


}elseif($_GET["task"]=='insert' || $_GET["task"]=='update'){
  $bd=new BD;
  $where = ($_GET["task"]=='update') ? "and id_curso!='".$_POST["id_curso"]."'" : '';
  $urlrewrite=armarurlrewrite($_POST["titulo"]);
  $urlrewrite=armarurlrewrite($urlrewrite,1,"cursos","id_curso","titulo_rewrite",$where);


	$_POST['fecha_actualizacion'] = fecha_hora(2);
	if(empty($_POST['validez_meses'])) $_POST['validez_meses']='0';
	if(empty($_POST['tag'])) $_POST['tag']='0';
  
		$_POST['idusuario']=$_SESSION["visualiza"]["idusuario"];

	
	$campos=array('tag','tag_trafico','id_tipo','titulo_trafico','id_tipo_curso','tipo','titulo', array('titulo_rewrite',$urlrewrite),"breve_detalle","precio",'modalidad',"link_video",'descripcion','estado_idestado','fecha_actualizacion','validez_meses','visibilidad','en_vivo_finalizado','etiqueta_fondo','etiqueta'); 

	
	$campos=array_merge($campos,array('link_grupo_wasap','fecha_de_inicio_texto','n_sesiones','inicio','frecuencia','horario','modalidad_texto','duracion','beneficios','inversion','matricula','certificacion','modulos'));
	
	
	if(isset($_POST['id_pro']) && is_array($_POST['id_pro'])){	
      $campos= array_merge($campos,array( array('id_pro',implode(',',$_POST['id_pro'])) ));
  } 
	
	// echo var_dump($campos);
	// exit();
	
	
	if($_POST['modalidad'] == 2){
			if(!empty($_POST['fecha_inicio'])) $campos = array_merge($campos,array('fecha_inicio'));
			if(!empty($_POST['hora_inicio'])) $campos = array_merge($campos,array('hora_inicio')); 
	}
	
	// if($_POST['en_vivo'] == 1){
			// if(!empty($_POST['enlace_en_vivo'])) $campos = array_merge($campos,array('enlace_en_vivo'));
			// if(!empty($_POST['hora_en_vivo'])) $campos = array_merge($campos,array('hora_en_vivo'));
		
	// }else{
		// $_POST['en_vivo']=2;
	// }
	// $campos = array_merge($campos,array('en_vivo'));


	if(empty($_POST['precio'])) $_POST['precio']='0.00'; 
	if(empty($_POST['costo_promo'])) $_POST['costo_promo']='0.00';
	if(empty($_POST['precio_online'])) $_POST['precio_online']='0.00';
	
	if(!empty($_POST['costo_promo'])){
		$campos = array_merge($campos,array('costo_promo'));
		if(!empty($_POST['fecha_fin_promo'])){
			$campos = array_merge($campos,array('fecha_fin_promo'));
		}
	}
	
	if(!empty($_POST['precio_online'])){
		$campos = array_merge($campos,array('precio_online'));
		// if(!empty($_POST['fecha_fin_promo'])){
			// $campos = array_merge($campos,array('fecha_fin_promo'));
		// }
	}
	
	// echo $_POST['cursos_dependientes'];
	// exit();
	
	//cursos_dependientes 
	// if (isset($_POST['cursos_dependientes']) && is_array($_POST['cursos_dependientes'])){
      // $campos= array_merge($campos,array(array('cursos_dependientes',implode(',',$_POST['cursos_dependientes']))));
  // }

	if (isset($_POST['id_especialidad']) ){
      $campos= array_merge($campos,array('id_especialidad'));
  } 
	
	// echo $_POST['id_especialidad']; 
	
	
	if (isset($_POST['cursos_dependientes']) ){
      $campos= array_merge($campos,array('cursos_dependientes'));
  } 
	
	if (isset($_POST['cursos_canasta']) ){
      $campos= array_merge($campos,array('cursos_canasta'));
  } 
	
	// if (isset($_POST['cursos_dependientes']) ){
      // $campos= array_merge($campos,array('cursos_dependientes'));
  // } 
	
	
  if($_GET["task"]=='insert'){
    if(isset($_FILES['imagen']) && !empty($_FILES['imagen']['name'])){
      $_POST['imagen'] = carga_imagen('files/images/capa/','imagen','','287','157');
      $campos = array_merge($campos,array('imagen'));
    }
    if(isset($_FILES['imagen2']) && !empty($_FILES['imagen2']['name'])){
      $_POST['imagen2'] = carga_imagen('files/images/capa/','imagen2','','813','450');
      $campos = array_merge($campos,array('imagen2'));
    }
		

//Generando - Cod venta
$end_venta=executesql("select * from cursos order by id_curso desc limit 0,1");
// "CH".1000000.1=> sumar el ultimo valor o count mejor dicho  y sumarle 1 , luegio sumarlo con los 100000 y concatenar y listo guardar .. 
if(!empty($end_venta)){
  $ultima_venta=$end_venta[0]["id_curso"]+1;  
}else{
  $ultima_venta=1;  
}

IF($ultima_venta<10){
  $_POST["codigo"]= "CU0000".$ultima_venta;
}ELSE IF($ultima_venta<100){
  $_POST["codigo"]= "CU000".$ultima_venta;
}ELSE IF($ultima_venta<1000){
  $_POST["codigo"]= "CU00".$ultima_venta;
}ELSE IF($ultima_venta<10000){
  $_POST["codigo"]= "CU0".$ultima_venta;
}ELSE IF($ultima_venta<100000){
  $_POST["codigo"]= "CU".$ultima_venta;
}


    // if(isset($_FILES['archivo']) && !empty($_FILES['archivo']['name'])){
      // $_POST['archivo'] = upload_files('files/files/','archivo','',0);
      // $campos = array_merge($campos,array('archivo'));
    // }
    $_POST['orden'] = _orden_noticia("","cursos","");
				
		if($_POST['tipo']==1){
			$_POST['orden_destacado'] = _orden_noticia_destacada("","cursos","");
			$campos=array_merge($campos,array('orden_destacado'));
		}	
				
    $_POST['fecha_registro'] = fecha_hora(2);
		$campos=array_merge($campos,array('codigo','fecha_registro','orden','idusuario'));
		
		
		// echo var_dump(arma_insert('cursos',$campos,'POST'));
		// exit();
		
    $_POST["id_curso"]=$bd->inserta_(arma_insert('cursos',$campos,'POST'));
		
  }else{
    if(isset($_FILES['imagen']) && !empty($_FILES['imagen']['name'])){
      $path = 'files/images/capa/'.$_POST['imagen_ant'];
      if( file_exists($path) && !empty($_POST['imagen_ant']) ) unlink($path);    
      $_POST['imagen'] = carga_imagen('files/images/capa/','imagen','','287','157');
      $campos = array_merge($campos,array('imagen'));
    }

    if(isset($_FILES['imagen2']) && !empty($_FILES['imagen2']['name'])){
      $path = 'files/images/capa/'.$_POST['imagen2_ant'];
      if( file_exists($path) && !empty($_POST['imagen2_ant']) ) unlink($path);    
      $_POST['imagen2'] = carga_imagen('files/images/capa/','imagen2','','813','450');
      $campos = array_merge($campos,array('imagen2'));
    }

		// echo var_dump(armaupdate('cursos',$campos," id_curso='".$_POST["id_curso"]."'",'POST'));
		// exit();
		
		
    $bd->actualiza_(armaupdate('cursos',$campos," id_curso='".$_POST["id_curso"]."'",'POST'));/*actualizo*/
  }
	
	
	// $bd->actualiza_("DELETE FROM categoria_subcate_cursos WHERE id_curso='".$_POST["id_curso"]."'");
  // if(isset($_POST['subcategorias'])){
		// $_POST['fecha_registro'] = fecha_hora(2);
    // foreach($_POST['subcategorias'] as $v){
      // $division = explode('_',$v);
      // $_POST["id_cat"] = $division[0]; $_POST["id_sub"] = $division[1];
      // $bd->inserta_(arma_insert('categoria_subcate_cursos',array('id_tipo','id_cat','id_sub','id_curso','fecha_registro'),'POST'));
    // }
	// }

	$_POST['fecha_registro'] = fecha_hora(2);
	$sql_x="DELETE FROM categoria_subcate_cursos WHERE id_curso='".$_POST["id_curso"]."'"; 
	$bd->actualiza_($sql_x);
	
		// echo var_dump(arma_insert('categoria_subcate_cursos',array('id_tipo','id_cat','id_sub','id_curso','fecha_registro'),'POST'));
	// exit();	
	$bd->inserta_(arma_insert('categoria_subcate_cursos',array('id_tipo','id_cat','id_sub','id_curso','fecha_registro'),'POST'));

  $bd->close();
  gotoUrl("index.php?page=".$_POST["nompage"]."&id_tipo=".$_POST["id_tipo"]."&module=".$_POST["nommodule"]."&parenttab=".$_POST["nomparenttab"]);

}elseif($_GET["task"]=='new' || $_GET["task"]=='edit'){
  if($_GET["task"]=='edit'){
     $data_producto=executesql("select * from cursos where id_curso='".$_GET["id_curso"]."'",0);
  }
?>
<script type="text/javascript" src="js/buscar_cursos_dependientes.js?ud=<?php echo $unix_date; ?>"></script>
<script type="text/javascript" src="js/buscar_cursos_canasta.js?ud=<?php echo $unix_date; ?>"></script>

<script src="ckeditor/sample.js"></script>
<script src="ckeditor/ckeditor.js"></script>
<script src="ckfinder/ckfinder.js"></script>

<section class="content">
  <div class="row">
    <div class="col-md-12">          
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Cursos </h3>
            </div>
<?php $task_=$_GET["task"]; ?>            
            <form id="registro" action="cursos.php?task=<?php echo ($task_=='edit') ?  "update" : "insert"; ?>" class="form-horizontal" method="POST" enctype="multipart/form-data" onsubmit="return aceptar()">
<?php 
if($task_=='edit') create_input("hidden","id_curso",$data_producto["id_curso"],"",$table,"");
create_input("hidden","urlfailed",basename($_SERVER['REQUEST_URI']),"",$table,"");  
create_input("hidden","urlgo",$link_lleva_tipo,"",$table,"");
create_input("hidden","id_tipo",$_GET["id_tipo"],"",$table,""); 
create_input("hidden","nompage",$_GET["page"],"",$table,""); 
create_input("hidden","nommodule",$_GET["module"],"",$table,"");
create_input("hidden","nomparenttab",$_GET["parenttab"],"",$table,"");
?>
              <div class="box-body   <?php echo !empty($_GET["id_curso"])?'detalle_editar':'';?>  "   >
								<input type="hidden" name="tipo" value="<?php echo $_GET["tipo"];?>">
                <div class="form-group">
                  <label for="inputEmail3" class="col-md-2 col-sm-2 control-label">CODIGO: <?php echo $data_producto['codigo']; ?></label>
								</div>
								<div class="form-group">
                  <label for="inputEmail3" class="col-md-2 col-sm-2 control-label">Estado</label>
                  <div class="col-sm-3">
                    <?php crearselect("estado_idestado","select * from estado where idestado in('1','2') order by 2 desc",'class="form-control"',$data_producto["estado_idestado"],""); ?>
                  </div>
                  <label for="inputPassword3" class="col-md-2 col-sm-2 control-label">Visibilidad:</label>
									<div class="col-sm-3">
										<select id="visibilidad" name="visibilidad" class="form-control" requerid >  <!-- saco valor desde la BD -->
											<option value="1" <?php echo ($data_producto['visibilidad'] == 1) ? 'selected' : '' ;?>>SI</option>  
											<option value="2"  <?php echo ($data_producto['visibilidad'] == 2) ? 'selected' : '' ;?>>OCULTO</option>
										</select>
									</div>
                </div>
								
								<div class="form-group">
									<label for="inputPassword3" class="col-md-2 col-sm-2 control-label">Destacado:</label>
									<div class="col-sm-3">
										<select id="tipo" name="tipo" class="form-control" requerid >  <!-- saco valor desde la BD -->
											<option value="2"  <?php echo ($data_producto['tipo'] == 2) ? 'selected' : '' ;?>>NO</option>
											<option value="1" <?php echo ($data_producto['tipo'] == 1) ? 'selected' : '' ;?>>SI</option>  
										</select>
									</div>
                 <label for="inputPassword3" class="col-md-2 col-sm-2 control-label">Modalidad:</label>
									<div class="col-sm-3">
										<select id="modalidad" name="modalidad" class="form-control" requerid >  <!-- saco valor desde la BD -->
											<option value="1" <?php echo ($data_producto['modalidad'] == 1) ? 'selected' : '' ;?>>Grabado</option>  
											<option value="2"  <?php echo ($data_producto['modalidad'] == 2) ? 'selected' : '' ;?>>En vivo</option>
										</select>
									</div>
									
									
                </div>
								
							
								<div class="form-group data_clase_vivo <?php echo (!empty($_GET["id_curso"]) && $data_producto['modalidad'] == 2) ?'detalle_editar':' hide ';?>  " style="    		background: #efefef;padding: 20px;border-radius: 6px;margin-bottom:25px;">
                  <label for="inputPassword3" class="col-md-12  control-label" style="text-align:left;padding:10px 5px;padding-left:70px;">(*) Ingresa Fecha y hora de inicio: </label>
                  <label for="inputPassword3" class="col-md-2 col-sm-2 control-label">Fecha inicio: </label>
                  <div class="col-sm-3">
                    <?php create_input("date","fecha_inicio",$data_producto["fecha_inicio"],"form-control",$table,"",$agregado); ?>
                  </div>
               
                  <label for="inputPassword3" class="col-md-2 col-sm-2 control-label">Hora inicio: </label>
                  <div class="col-sm-3">
                    <?php create_input("text","hora_inicio",$data_producto["hora_inicio"],"form-control",$table,"",$agregado); ?>
                  </div>

									<div class="col-md-12 "  style="margin-top:25px;">
										<label  class="col-md-12  control-label" style="text-align:left;padding:10px 5px;padding-left:10px;">
											Marcar como finalizado en_vivo: </br>
											<small class="red">* Si el curso en vivo, ya finalizó. No olvides cambiar este curso a Modalidad: <b>GRABADA</b></br>* Esto permitira a los Docentes solicitar la entrega de su certificado.</small>
										</label>
										<div class="col-md-4 " >
											<select id="en_vivo_finalizado" name="en_vivo_finalizado" class="form-control " requerid >  <!-- saco valor desde la BD -->
												<option value="2"  <?php echo ($data_producto['en_vivo_finalizado'] == 2) ? 'selected' : '' ;?>>NO</option>
												<option value="1" <?php echo ($data_producto['en_vivo_finalizado'] == 1) ? 'selected' : '' ;?>>SI</option>  
											</select>    
										</div>
									</div>
										
                </div>
								
																		
								<div class="form-group">
                  <label for="inputEmail3" class="col-md-2 col-sm-2 control-label">Profesor </br> <small>*Mantener presionado la tecla: ctrl y dar click en nombre de los docentes a seleccionar  </small></label>
                  <div class="col-sm-3">
                    <?php 
										// crearselect("id_pro","select * from profesores where estado_idestado=1 order by titulo asc ",'class="form-control"',$data_producto["id_pro"]," -- seleccione--"); 
										
										 
									$id_pro=array();
									$array= $data_producto["id_pro"];
									if(!empty($array)) $id_pro= explode(',',$array);
									crearselect("id_pro[]","select id_profesor, titulo from profesores  where estado_idestado='1' ORDER BY  titulo ASC ",'class="form-control"  style="height:300px;" multiple ',$id_pro); 
										
										?>
                  </div>
									
									
								
                </div>
		
	<?php /*	
								<div class="form-group">
									<label for="inputEmail3" class="col-md-2 col-sm-2 control-label">Categorías / Subcategorías</label>
									<div class="col-sm-6">
										<select name="subcategorias[]" multiple="multiple" class="form-control" size="10">
			<?php
				$exsql1 = executesql("SELECT s.id_sub,s.titulo as subcategoria,c.id_cat,c.titulo as categorias FROM subcategorias s RIGHT JOIN categorias c ON s.id_cat=c.id_cat  where c.id_tipo='".$_GET["id_tipo"]."'  ORDER BY c.titulo asc,s.titulo asc");
				$grp1   = $grp2 = array();
				foreach($exsql1 as $row) $grp1[$row['categorias']][$row['id_cat'].'_'.$row['id_sub']] = $row['subcategoria'];
				
				$exsql2 = executesql("SELECT * FROM categoria_subcate_cursos WHERE id_curso='".$data_producto["id_curso"]."'");
				foreach($exsql2 as $row) $grp2[] = $row['id_sub'];
				foreach($grp1 as $label => $opt)
				{
			?>
											<optgroup label="<?php echo $label; ?>">
			<?php
					foreach($grp1[$label] as $id => $name)
					{
						if(!empty($name))
						{
							$selected = in_array(end(explode('_',$id)),$grp2) ? ' selected="selected"' : '';
			?>
												<option value="<?php echo $id; ?>"<?php echo $selected; ?>><?php echo $name; ?></option>
			<?php }
					}
			?>
											</optgroup>
			<?php 
				}
			?>
										</select>
									</div>
								</div>
			
*/ ?>
								
								
								
								 
					<div class="form-group">
							<?php
								if($task_=='edit'){ 
									$exsql2 = executesql("SELECT * FROM categoria_subcate_cursos WHERE id_curso='".$data_producto["id_curso"]."'");
									$id_cat=$exsql2[0]['id_cat'];
									$id_sub=$exsql2[0]['id_sub'];										
								}
							?>
					
						<label for="inputPassword3" class="col-md-2 col-sm-2 control-label">Categoría</label>
						<div class="col-sm-3 criterio_buscar">
									<?php crearselect("id_cat", "select id_cat,titulo from categorias where id_tipo='".$_GET["id_tipo"]."' and estado_idestado=1 order by titulo asc", 'class="form-control" requerid  onchange="javascript:display(\'cursos.php\',this.value,\'cargar_subcategorias\',\'id_sub\')"', $id_cat, "-- categorias --"); ?>
						</div>
							
						<label for="inputPassword3" class="col-md-2 col-sm-2 control-label">SubCategoría</label>
						<div class="col-sm-3 criterio_buscar">	

							<?php if($task_=='edit'){ 
										$sql="select id_sub,titulo from subcategorias WHERE id_cat='".$id_cat."' "; 
							?>
								<select name="id_sub" id="id_sub" class="form-control" >
									<option value="" >-- subcateg. --</option>
									<?php 
											$listaprov=executesql($sql);
											foreach($listaprov as $data){ ?>
										<option value="<?php echo $data['id_sub']; ?>" <?php echo ($data['id_sub']==$id_sub)?'selected':'';?>> <?php echo $data['titulo']?></option>
											<?php } ?>
								</select>
							
							<?php }else{ ?>
							<select name="id_sub" id="id_sub" class="form-control" ><option value="" selected="selected">-- subcateg. --</option></select>
							<?php } ?>
						</div>
					</div>      


								<div class="form-group">
									<label for="inputPassword3" class="col-md-2 col-sm-2 control-label">TIPO:</label>
									<div class="col-sm-3">
										<select id="id_tipo_curso" name="id_tipo_curso" class="form-control"  >  <!-- saco valor desde la BD -->
											<option value="1" <?php echo ($data_producto['id_tipo_curso'] == 1) ? 'selected' : '' ;?>>GENERALES</option>  
											<option value="2" <?php echo ($data_producto['id_tipo_curso'] == 2) ? 'selected' : '' ;?>>ESPECIALIDAD</option>
										</select>
									</div>
									
                  <div class="lleva_especialidad <?php echo (!empty($_GET["id_curso"]) && $data_producto['id_tipo_curso'] == 2) ?'detalle_editar':' hide ';?>  ">
										<label for="inputEmail3" class="col-md-2 col-sm-2 control-label">ESPECIALIDADES</label>
										<div class="col-sm-3">
											<?php crearselect("id_especialidad","select * from especialidades where estado_idestado=1 order by titulo asc ",'class="form-control"',$data_producto["id_especialidad"],""); ?>
										</div>
                  </div>
                
                </div>
								

				<div class="form-group">
                  <label for="inputPassword3" class="col-md-2 col-sm-2 control-label">Título</label>
                  <div class="col-sm-6">
                    <?php create_input("text","titulo",$data_producto["titulo"],"form-control",$table,"",$agregado); ?>
                  </div>
                </div>

				<div class="form-group">
                  <label for="inputPassword3" class="col-md-2 col-sm-2 control-label">Título landing tráfico</label>
                  <div class="col-sm-6">
                    <?php create_input("text","titulo_trafico",$data_producto["titulo_trafico"],"form-control",$table,"  ",$agregado); ?>
                  </div>
                </div>
								
				<div class="form-group">
                  <label for="inputPassword3" class="col-md-2 col-sm-2 control-label">ID TAG InfusionSoft *venta</label>
                  <div class="col-sm-6">
                    <?php create_input("text","tag",$data_producto["tag"],"form-control",$table,"",$agregado); ?>
                  </div>
                </div>
								
				<div class="form-group">
                  <label for="inputPassword3" class="col-md-2 col-sm-2 control-label">ID TAG InfusionSoft *trafico</label>
                  <div class="col-sm-6">
                    <?php create_input("text","tag_trafico",$data_producto["tag_trafico"],"form-control",$table,"",$agregado); ?>
                  </div>
                </div>
								
								
								<div class="form-group">
                  <label for="inputPassword3" class="col-md-2 col-sm-2 control-label">Link grupo de WhatsApp </label>
                  <div class="col-sm-6">
                    <?php create_input("text","link_grupo_wasap",$data_producto["link_grupo_wasap"],"form-control",$table,"",$agregado); ?>
                  </div>
                </div>
								
								<div class="form-group">
                  <label for="inputPassword3" class="col-md-2 col-sm-2 control-label">Fecha de inicio (* texto) </label>
                  <div class="col-sm-6">
                    <?php create_input("text","fecha_de_inicio_texto",$data_producto["fecha_de_inicio_texto"],"form-control",$table,"",$agregado); ?>
                  </div>
                </div>
								<div class="form-group">
                  <label for="inputPassword3" class="col-md-2 col-sm-2 control-label">Número de sesiones: </label>
                  <div class="col-sm-6">
                    <?php create_input("text","n_sesiones",$data_producto["n_sesiones"],"form-control",$table,"",$agregado); ?>
                  </div>
                </div>
								
								<div class="form-group">
                  <label for="inputPassword3" class="col-md-2 col-sm-2 control-label">Etiqueta:</label>
                  <div class="col-sm-6">
                    <?php create_input("text","etiqueta",$data_producto["etiqueta"],"form-control",$table,"",$agregado); ?>
                  </div>
                </div>
								
								<div class="form-group">
                  <label for="inputPassword3" class="col-md-2 col-sm-2 control-label"> Color fondo Etiqueta:</label>
                  <div class="col-sm-6">
										<?php create_input("text","etiqueta_fondo",$data_producto["etiqueta_fondo"],"form-control color-picker",$table," ",' maxlength="7" size="7"'); ?>

                  </div>
                </div>
								
								
							<div class="form-group">
								<label for="inputPassword3" class="col-md-2 col-sm-2 control-label">Precio Antes S/. </label>
								<div class="col-md-2 col-sm-2">
									<?php create_input("text","precio",$data_producto["precio"],"form-control",$table,"onkeypress='javascript:return soloNumeros_precio(event,2);'"); /* el 2 permite poner  decmales */?> 
								</div>
								
							</div>
							
							<div class="form-group">
								<label for="inputPassword3" class="col-md-2 col-sm-2 control-label">Fecha límite de promo: </label>
								<div class="col-md-3 col-sm-3">
									<?php create_input("date","fecha_fin_promo",$data_producto["fecha_fin_promo"],"form-control",$table,""); /* el 2 permite poner  decmales */?> 
								</div>
								<label for="inputPassword3" class="col-md-2 col-sm-2 control-label">Precio Ahora S/. (* oferta )</label>
								<div class="col-md-3 col-sm-3">
									<?php create_input("text","costo_promo",$data_producto["costo_promo"],"form-control",$table,"onkeypress='javascript:return soloNumeros_precio(event,2);'"); ?>
								</div>
							</div>
							
							<div class="form-group hide "> <!-- oculto momentaneatee -->
								<label for="inputPassword3" class="col-md-2 col-sm-2 control-label"><b style="color:red;">Precio ONLINE S/. </b> </label>
								<div class="col-md-2 col-sm-2">
									<?php create_input("text","precio_online",$data_producto["precio_online"],"form-control",$table,"onkeypress='javascript:return soloNumeros_precio(event,2);'"); /* el 2 permite poner  decmales */?> 
								</div>
								
							</div>
							
                <div class="form-group">
                  <label for="inputPassword3" class="col-md-2 col-sm-2 control-label">
										Imágen Grande<br/>
										<span class="red">813px ancho * 450px alto</span></label>
                  <div class="col-sm-6">
                    <input type="file" name="imagen2" id="imagen2" class="form-control">
                    <?php create_input("hidden","imagen2_ant",$data_producto["imagen2"],"",$table,$agregado); 
                      if($data_producto["imagen2"]!=""){ 
                    ?>
                      <img src="<?php echo "files/images/capa/".$data_producto["imagen2"]; ?>" width="200" class="mgt15">
                    <?php } ?> 
                  </div>
                </div>
								
                <div class="form-group">
                  <label for="inputPassword3" class="col-md-2 col-sm-2 control-label">
										Imágen mini - listado de cursos<small>(*mascara video)</small><br/>
										<span class="red">287px ancho * 157px alto</span></label>
                  <div class="col-sm-6">
                    <input type="file" name="imagen" id="imagen" class="form-control">
                    <?php create_input("hidden","imagen_ant",$data_producto["imagen"],"",$table,$agregado); 
                      if($data_producto["imagen"]!=""){ 
                    ?>
                      <img src="<?php echo "files/images/capa/".$data_producto["imagen"]; ?>" width="200" class="mgt15">
                    <?php } ?> 
                  </div>
                </div>
							<?php /* 
								*/ ?>
								
								<div class="form-group">
                  <label for="inputPassword3" class="col-md-2 col-sm-2 control-label">Link video trailer</label>
                  <div class="col-sm-6">
                    <?php create_input("text","link_video",$data_producto["link_video"],"form-control",$table,"",$agregado); ?>
                  </div>
                </div>
								<div class="form-group">
									<label for="inputPassword3" class="col-md-2 col-sm-2 control-label">Número de meses válido: </br> (visible para el cliente) </label>
									<div class="col-md-2 col-sm-2">
										<?php create_input("text","validez_meses",$data_producto["validez_meses"],"form-control",$table,"onkeypress='javascript:return soloNumeros_precio(event,0);'"); /* el 2 permite poner  decmales */?> 
									</div>									
								</div> 
								
								<div class="form-group hide ">
									<label for="inputPassword3" class="col-md-2 col-sm-2 control-label">En vivo?</label>
									<div class="col-sm-3">
										<select id="en_vivo" name="en_vivo"  disabled class="form-control"  >  <!-- saco valor desde la BD -->
											<option value="2" <?php echo ($data_producto['en_vivo'] == 2) ? 'selected' : '' ;?>>NO</option>
											<option value="1" <?php echo ($data_producto['en_vivo'] == 1) ? 'selected' : '' ;?>>SI</option>  
										</select>
									</div>
                </div>
								
								<!--  TEXTO -->
								
									
								<div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Presentación</label>
                  <div class="col-sm-10">
                    <?php create_input("textarea","descripcion",$data_producto["descripcion"],'  ',$table,'style="height:650px!important;"');  ?>
                    <script>
                    var editor11 = CKEDITOR.replace('descripcion');
                    CKFinder.setupCKEditor( editor11, 'ckfinder/' );
                    </script> 
                  </div>
                </div>

								<div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Inicio</label>
                  <div class="col-sm-10">
                    <?php create_input("textarea","inicio",$data_producto["inicio"],'  ',$table,'style="height:650px!important;"');  ?>
                    <script>
                    var editor11_1 = CKEDITOR.replace('inicio');
                    CKFinder.setupCKEditor( editor11_1, 'ckfinder/' );
                    </script> 
                  </div>
                </div>
								
								<div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Frecuencia: </label>
                  <div class="col-sm-10">
                    <?php create_input("textarea","frecuencia",$data_producto["frecuencia"],'  ',$table,'style="height:650px!important;"');  ?>
                    <script>
                    var editor11_2 = CKEDITOR.replace('frecuencia');
                    CKFinder.setupCKEditor( editor11_2, 'ckfinder/' );
                    </script> 
                  </div>
                </div>
								
								<div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Horario: </label>
                  <div class="col-sm-10">
                    <?php create_input("textarea","horario",$data_producto["horario"],'  ',$table,'style="height:650px!important;"');  ?>
                    <script>
                    var editor11_3 = CKEDITOR.replace('horario');
                    CKFinder.setupCKEditor( editor11_3, 'ckfinder/' );
                    </script> 
                  </div>
                </div>
								
								<div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Modalidad: </label>
                  <div class="col-sm-10">
                    <?php create_input("textarea","modalidad_texto",$data_producto["modalidad_texto"],'  ',$table,'style="height:650px!important;"');  ?>
                    <script>
                    var editor11_4 = CKEDITOR.replace('modalidad_texto');
                    CKFinder.setupCKEditor( editor11_4, 'ckfinder/' );
                    </script> 
                  </div>
                </div>
								
								<div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Duración: </label>
                  <div class="col-sm-10">
                    <?php create_input("textarea","duracion",$data_producto["duracion"],'  ',$table,'style="height:650px!important;"');  ?>
                    <script>
                    var editor11_5 = CKEDITOR.replace('duracion');
                    CKFinder.setupCKEditor( editor11_5, 'ckfinder/' );
                    </script> 
                  </div>
                </div>
								
								<div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Beneficios </label>
                  <div class="col-sm-10">
                    <?php create_input("textarea","beneficios",$data_producto["beneficios"],'  ',$table,'style="height:650px!important;"');  ?>
                    <script>
                    var editor11_6 = CKEDITOR.replace('beneficios');
                    CKFinder.setupCKEditor( editor11_6, 'ckfinder/' );
                    </script> 
                  </div>
                </div>
								
								<div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Inversión </label>
                  <div class="col-sm-10">
                    <?php create_input("textarea","inversion",$data_producto["inversion"],'  ',$table,'style="height:650px!important;"');  ?>
                    <script>
                    var editor11_7 = CKEDITOR.replace('inversion');
                    CKFinder.setupCKEditor( editor11_7, 'ckfinder/' );
                    </script> 
                  </div>
                </div>
									
								<div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Matrícula: </label>
                  <div class="col-sm-10">
                    <?php create_input("textarea","matricula",$data_producto["matricula"],'  ',$table,'style="height:650px!important;"');  ?>
                    <script>
                    var editor11_77 = CKEDITOR.replace('matricula');
                    CKFinder.setupCKEditor( editor11_77, 'ckfinder/' );
                    </script> 
                  </div>
                </div>
									
								<div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Certificación </label>
                  <div class="col-sm-10">
                    <?php create_input("textarea","certificacion",$data_producto["certificacion"],'  ',$table,'style="height:650px!important;"');  ?>
                    <script>
                    var editor11_8 = CKEDITOR.replace('certificacion');
                    CKFinder.setupCKEditor( editor11_8, 'ckfinder/' );
                    </script> 
                  </div>
                </div>
								
								<div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Módulos  (*texto)</label>
                  <div class="col-sm-10">
                    <?php create_input("textarea","modulos",$data_producto["modulos"],'  ',$table,'style="height:650px!important;"');  ?>
                    <script>
                    var editor11_9 = CKEDITOR.replace('modulos');
                    CKFinder.setupCKEditor( editor11_9, 'ckfinder/' );
                    </script> 
                  </div>
                </div>
								
								
								
								
								
								<div class="form-group">
                  <label for="inputPassword3" class="col-md-2 col-sm-2 control-label">Dirigido a:</label>
                  <div class="col-sm-6">
                    <?php create_input("textarea","breve_detalle",$data_producto["breve_detalle"],"form-control",$table,"",$agregado); ?>
                  </div>
                </div>
								
								<!-- *** END TEXTO -->
								
								
								
				<?php if(isset($_GET["id_tipo"]) && $_GET["id_tipo"]!=4){ // cara curso gratis esto no aplica --.. ?>	 

				<div class="form-group">
					<div class="col-sm-12"><h3>Cursos para Packs:</h3></div>
					<div class="col-sm-10 ">
						<label for="inputPassword3" class=" control-label">Buscar curso:</label>
						<?php 
						create_input("text","titulo_curso",$data_producto["titulo_curso"],"form-control",$table," autocomplete='off' onkeyup='autocompletar()' ",''); 	
						?>
						<ul id="listadobusqueda_curso_dependientes" class="no-bullet"></ul>
					</div>
				</div>
				
        <div class="form-group data_dependientes" style="  ">	
					<div class="col-sm-12 " style="background: #ddd;padding: 5px 10px 10px;border-radius: 6px;">
						<div class="col-sm-3">
							<label for="inputPassword3" class=" control-label">Tipo:</label>
							<?php 
							create_input("hidden","cursos_dependientes",$data_producto["cursos_dependientes"],"form-control",$table,"",$agregado); 
							?>
						</div>					
						<div class="col-sm-7">
								<label for="inputPassword3" class=" control-label">Curso: </label>
						</div>
					</div>	
					
					<div id="cakes"  class="form-group resultados" style="margin-bottom:0;">	
							<!-- sale data desde js .. -->
							
					</div>
					
					<div class="form-group ">	
						<!-- sale data PHP los que ya tenia asigandos .. -->
						<?php 
						if(!empty($data_producto["cursos_dependientes"])){ 
								$sql_depen="select c.*, tp.titulo as tipo_curso FROM  cursos c INNER JOIN tipo_cursos tp ON c.id_tipo=tp.id_tipo WHERE c.id_curso IN (".$data_producto["cursos_dependientes"].") order by tp.titulo asc,  c.titulo asc  ";
								$cursos_depen_actuales=executesql($sql_depen);
								if(!empty($cursos_depen_actuales)){
									foreach($cursos_depen_actuales as $depen){
										echo '<div id="depen'.$depen["id_curso"].'" class="col-sm-12" style="margin-bottom:5px;background:#f1f1f1;"><div class="col-sm-3"><input type="text" id="nombre_curso"  name="nombre_curso" disabled class="form-control" value="'.$depen["tipo_curso"].' "></div><div class="col-sm-7"><input type="text" id="nombre_curso"  name="nombre_curso" disabled class="form-control" value="'.$depen["codigo"].'-'.$depen["titulo"].' "></div><div class="col-sm-2"><a class="quitar_depen" href="javascript:quitar_dependiente('.$depen["id_curso"].')">quitar</a></div>  </div>';
									}
								}else{ 
									// echo "no tiene aun";
								}
						}else{ 
							// echo "no tiene aun";
						}
						?>
							
					</div>					
				</div> <!-- *contenedor general listado dependientes -->	
			<?php } ?> 
					 
					 
<?php  /*  *# CANASTA  */
			 
			 if(isset($_GET["id_tipo"]) && $_GET["id_tipo"]!=5){ // para curso gratis esto no aplica --.. ?>	 

				<div class="form-group">
					<div class="col-sm-12"><h3>Canasta de cursos: <small>*Seleccione los cursos que se complementan para la emisión de certificados </small></h3></div>
					<div class="col-sm-10 ">
						<label for="inputPassword3" class=" control-label">Buscar curso:</label>
						<?php 
						create_input("text","titulo_curso_canasta",$data_producto["titulo_curso_canasta"],"form-control",$table," autocomplete='off' onkeyup='autocompletar_canasta()' ",''); 	
						?>
						<!--
						<ul id="listadobusqueda_curso_dependientes" class="no-bullet"></ul>
						-->
						<ul id="listadobusqueda_curso_canastas" class="no-bullet"></ul>
					</div>
				</div>
			
        <div class="form-group data_dependientes" style="  ">	
					<div class="col-sm-12 " style="background: #ddd;padding: 5px 10px 10px;border-radius: 6px;">
						<div class="col-sm-3">
							<label for="inputPassword3" class=" control-label">Tipo:</label>
							<?php 
							create_input("hidden","cursos_canasta",$data_producto["cursos_canasta"],"form-control",$table,"",$agregado); 
							?>
						</div>					
						<div class="col-sm-7">
								<label for="inputPassword3" class=" control-label">Curso: </label>
						</div>
					</div>	
					
					<div id="cakes_canasta" class="form-group resultados_canasta" style="margin-bottom:0;">	
							<!-- sale data desde  CANASTA js .. -->		
					</div>
					
					<div class="form-group ">	
						<!-- sale data PHP los que ya tenia asigandos .. -->
						<?php 
						if(!empty($data_producto["cursos_canasta"])){ 
						
								$sql_canasta="select c.*, tp.titulo as tipo_curso FROM  cursos c INNER JOIN tipo_cursos tp ON c.id_tipo=tp.id_tipo WHERE c.id_curso IN (".$data_producto["cursos_canasta"].") order by tp.titulo asc,  c.titulo asc  ";
								$cursos_canasta_actuales=executesql($sql_canasta);
								if(!empty($cursos_canasta_actuales)){
									foreach($cursos_canasta_actuales as $canasta){
										echo '<div id="canasta'.$canasta["id_curso"].'" class="col-sm-12" style="margin-bottom:5px;background:#f1f1f1;"><div class="col-sm-3"><input type="text" id=""  name="" disabled class="form-control" value="'.$canasta["tipo_curso"].' "></div><div class="col-sm-7"><input type="text" id="nombre_curso"  name="nombre_curso" disabled class="form-control" value="'.$canasta["codigo"].'-'.$canasta["titulo"].' "></div><div class="col-sm-2"><a class="quitar_canasta" href="javascript:quitar_canasta('.$canasta["id_curso"].')">quitar</a></div>  </div>';
									}
								}else{ 
									// echo "no tiene aun";
								}
						}else{ 
							// echo "no tiene aun";
						}
						?>
							
					</div>					
				</div> <!-- *contenedor general listado canasta -->	
			<?php } ?> 
	
<?php 	
	/* END CANASTA */ 
	?>				 
					 
					 
              </div>
              <div class="box-footer">
                <div class="form-group">
                  <div class="col-sm-10 pull-right">
                    <input  type="submit"  class="btn bg-blue btn-flat" id="btnguardar" value="Guardar">
                    <button type="button" class="btn bg-red btn-flat" onclick="javascript:gotourl('<?php echo $link_lleva_tipo; ?>');">Cancelar</button>
                  </div>
                </div>
              </div>
							
<script>	
function aceptar(){
	var nam1=document.getElementById("titulo").value;		
	
	if(nam1 !='' ){									
		alert("Registrando ... Click en Aceptar & espere unos segundos. ");							
		document.getElementById("btnguardar").disabled=true;			
	}else{		
		alert("Recomendación: Ingrese título)");
		return false; //el formulario no se envia		
	}
	
}		


// if( $('.detalle_editar').length ){
					// $('.data_clase_vivo').removeClass('hide');
	
// }



// si lleva especialidades ...
if (document.getElementById("id_tipo_curso")) {
		var select_tipo = document.getElementById('id_tipo_curso');
		console.log('holaaaa lleva especialidad');
		select_tipo.addEventListener('change', function () {
				var selectedOption = this.options[select_tipo.selectedIndex];
				console.log(selectedOption.value + ': ' + selectedOption.text);
				
				if(selectedOption.value == "2"){
					// alert("jjjj");
					$('.lleva_especialidad').removeClass('hide');
				}else{
					$('.lleva_especialidad').addClass('hide');
					document.getElementById('id_especialidad').value="";
					
				}
		});
}


if (document.getElementById("modalidad")) {
		var select = document.getElementById('modalidad');
		console.log('holaaaa');
		select.addEventListener('change', function () {
				var selectedOption = this.options[select.selectedIndex];
				console.log(selectedOption.value + ': ' + selectedOption.text);
				
				if(selectedOption.value == "2"){
					// alert("jjjj");
					$('.data_clase_vivo').removeClass('hide');
				}else{
					$('.data_clase_vivo').addClass('hide');
					document.getElementById('fecha_inicio').value="";
					document.getElementById('hora_inicio').value="";
					
				}
		});
}

// en vivo del perfil - mis cursos
if (document.getElementById("en_vivo")) {
		var select_2 = document.getElementById('en_vivo');
		console.log('holaaaa envivo 2 ');
		select_2.addEventListener('change', function () {
				var selectedOption = this.options[select_2.selectedIndex];
				console.log(selectedOption.value + ': ' + selectedOption.text);
				
				if(selectedOption.value == "1"){
					// alert("jjjj");
					$('.data_curso_en_vivo').removeClass('hide');
				}else{
					$('.data_curso_en_vivo').addClass('hide');
					document.getElementById('enlace_en_vivo').value="";
					document.getElementById('hora_en_vivo').value="";
					
					document.getElementById('horario_inicio').value="";
					document.getElementById('horario_final').value="";
					document.getElementById('horario_hora').value="";
					document.getElementById('horario_lunes').value="";
					document.getElementById('horario_martes').value="";
					document.getElementById('horario_miercoles').value="";
					document.getElementById('horario_jueves').value="";
					document.getElementById('horario_viernes').value="";
					document.getElementById('horario_sabado').value="";
					document.getElementById('horario_domingo').value="";
					
					
				}
		});
}


</script>	
            </form>
          </div><!-- /.box -->
        </div><!--/.col (right) -->
  </div>
</section><!-- /.content -->
<script type="text/javascript">
var customValidate = {
      rules:{
        archivo:{ required:false,accept:'pdf,docs,doc,jpg,png' }
      }
    };
</script>
<?php
}elseif($_GET["task"]=='drop' || $_GET["task"]=='dropselect'){  
  $bd = new BD;
  $bd->Begin();
  $ide = !isset($_GET['id_curso']) ? implode(',', $_GET['chkDel']) : $_GET['id_curso'];
  $cursos = executesql("SELECT * FROM cursos WHERE id_curso IN(".$ide.")");
  if(!empty($cursos)){
    foreach($cursos as $row){
      $pfile = 'files/images/capa/'.$row['imagen']; if(file_exists($pfile) && !empty($row['imagen'])){ unlink($pfile); }
      $pfile = 'files/images/capa/'.$row['imagen2']; if(file_exists($pfile) && !empty($row['imagen2'])){ unlink($pfile); }
      $pfile = 'files/files/'.$row['archivo']; if(file_exists($pfile) && !empty($row['archivo'])){ unlink($pfile); }
			
			/* ELIMINAOS LAS CLASES DE LAS SESIONES */
			 $seesiones = executesql("SELECT * FROM sesiones WHERE id_curso IN(".$ide.")");
				if(!empty($seesiones)){
					foreach($seesiones as $row_sesi){
						
						/* elominaro archivos .- reucrsos  de las clases */
						$clases = executesql("SELECT * FROM detalle_sesiones WHERE id_sesion IN(".$row_sesi["id_sesion"].")");
						if(!empty($clases)){
							foreach($clases as $row_clase){
								
								$pfile = 'files/files/'.$row_clase['id_detalle']; if(file_exists($pfile) && !empty($row_clase['id_detalle'])){ rrmdir($pfile); }
								$bd->actualiza_("DELETE FROM archivos_detalle_sesion_virtuals WHERE id_detalle IN(".$row_clase["id_detalle"].")");
								
								/* files */
								// $clases = executesql("SELECT * FROM archivos_detalle_sesion_virtuals WHERE id_detalle IN(".$row_clase["id_detalle"].")");
								// if(!empty($clases)){
									// foreach($clases as $row_archivo){
										// $pfile = 'files/files/'.$row_archivo['id_detalle'].'/'.$row_archivo['archivo']; if(file_exists($pfile) && !empty($row_archivo['archivo'])){ unlink($pfile); }
									// }
									// $bd->actualiza_("DELETE FROM archivos_detalle_sesion_virtuals WHERE id_detalle IN(".$row_clase["id_detalle"].")");
								// }
								
								
							} /* for clases */
							$bd->actualiza_("DELETE FROM detalle_sesiones WHERE id_sesion IN(".$row_sesi["id_sesion"].")");
						} /* end archivos de clase */
						
						
					}
				} /* end delete clases */
			
			
    }
  }

  $bd->actualiza_("DELETE FROM sesiones WHERE id_curso IN(".$ide.")");
  $bd->actualiza_("DELETE FROM cursos WHERE id_curso IN(".$ide.")");
  $bd->Commit();
  $bd->close();

}elseif($_POST["task"]=='reordenar_con_post'){

  $bd = new BD;
  $_POST['order'] = array_reverse($_POST['order']);
  foreach ($_POST['order'] as $order => $item) {
    $orden = $orden + 1;
    $bd->actualiza_("UPDATE cursos SET orden= ".$orden." WHERE id_curso = ".$item."");
  }
  $bd->Commit();
  $bd->close();
	
	
}elseif($_GET["task"]=='ordenar'){

  $bd = new BD;
  $_GET['order'] = array_reverse($_GET['order']);
  foreach ($_GET['order'] as $order => $item) {
    $orden = $orden + 1;
    $bd->actualiza_("UPDATE cursos SET orden= ".$orden." WHERE id_curso = ".$item."");
  }
  $bd->Commit();
  $bd->close();

}elseif($_GET["task"]=='uestado'){

  $bd = new BD;
  $bd->Begin();

  $ide = !isset($_GET['id_curso']) ? $_GET['estado_idestado'] : $_GET['id_curso'];
  $ide = is_array($ide) ? implode(',',$ide) : $ide;
  $cursos = executesql("SELECT * FROM cursos WHERE id_curso IN (".$ide.")");

  if(!empty($cursos))
    foreach($cursos as $reg => $item)
      if ($item['estado_idestado']==1) {
        $state = 2;
      }elseif ($item['estado_idestado']==2) {
        $state = 1;
      }
  $bd->actualiza_("UPDATE cursos SET estado_idestado=".$state." WHERE id_curso=".$ide."");
  echo $state;
  $bd->Commit();
  $bd->close();
	

}elseif($_GET["task"]=='finder'){
	$array= array();
	$meses=array('Jan'=>'Enero','Feb'=>'Febrero','Mar'=>'Marzo','Apr'=>'Abril','May'=>'Mayo','Jun'=>'Junio','Jul'=>'Julio','Aug'=>'Agosto','Sep'=>'Septiembre','Oct'=>'Octubre','Nov'=>'Noviembre','Dec'=>'Diciembre');
	
  // $sql = "SELECT YEAR(c.fecha_registro) as anho, MONTH(c.fecha_registro) as mes,  csc.id_cat,csc.id_sub, c.*, e.nombre as estado, u.nomusuario as usuario 
		// FROM cursos c 
			// LEFT join usuario u ON u.idusuario=c.idusuario 		
	 // INNER JOIN categoria_subcate_cursos csc ON csc.id_curso=c.id_curso 
	 // INNER JOIN categorias ctg ON ctg.id_cat=csc.id_cat  
	 // INNER JOIN subcategorias sub ON csc.id_sub=sub.id_sub  
	 // INNER JOIN estado e ON c.estado_idestado=e.idestado  
	 // WHERE  c.id_tipo='".$_GET["id_tipo"]."'  
	 // "; 
   
	 $sql = "SELECT YEAR(c.fecha_registro) as anho, MONTH(c.fecha_registro) as mes,  csc.id_cat,csc.id_sub, c.*, e.nombre as estado, u.nomusuario as usuario 
		FROM cursos c 
			LEFT join usuario u ON u.idusuario=c.idusuario 		
	 LEFT JOIN categoria_subcate_cursos csc ON csc.id_curso=c.id_curso 
	 LEFT JOIN categorias ctg ON ctg.id_cat=csc.id_cat  
	 LEFT JOIN subcategorias sub ON csc.id_sub=sub.id_sub  
	 INNER JOIN estado e ON c.estado_idestado=e.idestado  
	 WHERE  c.id_tipo='".$_GET["id_tipo"]."'  
	 "; 
   
  if(isset($_GET['criterio_mostrar'])) $porPagina=$_GET['criterio_mostrar'];
	
  if(isset($_GET['criterio_usu_per']) && !empty($_GET['criterio_usu_per'])){
    $stringlike=fn_filtro(substr($_GET['criterio_usu_per'], 0, 16));
    $sql.= " and  ( c.titulo LIKE '%".$stringlike."%' or  c.codigo LIKE '%".$stringlike."%' )  ";
  }else{
		// if( empty($_GET['fechabus_1']) && empty($_GET['fechabus_2']) ) {
			// $sql .= " AND DATE(c.fecha_registro) = '" . fecha_hora(1) . "'";
		// }	
	}

	
	
	if(!empty($_GET['id_cat'])) {
		$sql .= " AND csc.id_cat = '".$_GET['id_cat']."'";
	}
	
	if(!empty($_GET['id_sub'])) {
		$sql .= " AND csc.id_sub = '".$_GET['id_sub']."'";
	}
	
	if(!empty($_GET['id_especialidad'])) {
		$sql .= " AND c.id_especialidad = '".$_GET['id_especialidad']."'";
	}
	
	if(!empty($_GET['visibilidad'])) {
		$sql .= " AND c.visibilidad = '".$_GET['visibilidad']."' ";
	}
	
	if(!empty($_GET['id_tipo_curso'])) {
		$sql .= " AND c.id_tipo_curso = '".$_GET['id_tipo_curso']."' ";
	}
	
	if(!empty($_GET['fechabus_1']) && !empty($_GET['fechabus_2'])) {
			$sql .= " AND DATE(c.fecha_registro)  BETWEEN  DATE('".$_GET['fechabus_1']."')  and DATE('".$_GET['fechabus_2']."')  ";		
	}
	
  if(isset($_GET['criterio_ordenar_por'])) $sql.= sprintf(" order by %s %s", fn_filtro($_GET['criterio_ordenar_por']), fn_filtro($_GET['criterio_orden']));
  
	// $sql.= " Group BY c.id_curso ORDER BY c.orden DESC  ";
	$sql.= "  ORDER BY c.orden DESC  ";
		
	// echo $sql; 
 
  $paging = new PHPPaging;
  $paging->agregarConsulta($sql); 
  $paging->div('div_listar');
  $paging->modo('desarrollo'); 
  $numregistro=1; 
  if($numregistro) $paging->porPagina(fn_filtro((int)$numregistro));
  $paging->verPost(true);
  $mantenerVar=array("criterio_mostrar","task","criterio_usu_per","criterio_ordenar_por","criterio_orden");
  $paging->mantenerVar($mantenerVar);
  $paging->porPagina(fn_filtro((int)$porPagina));

	// if(empty($_GET['fechabus_1']) && empty($_GET['fechabus_2']) && empty($_GET['criterio_usu_per']) && empty($_GET['id_cat']) && empty($_GET['visibilidad']) && empty($_GET['id_tipo_curso']) && empty($_GET['id_especialidad']) ){
		// /* cargar por defecto los ultimos 10 cursos registrados ..
		// $sql.= " LIMIT 0,10   "; */ 
		
		// $paging->porPagina(10);		
	// }else{
		// $paging->porPagina(200);		
	// }
	
	
  $paging->ejecutar();
  $paging->pagina_proceso="cursos.php";
?>
            <table id="example1" class="table table-bordered table-striped">
              <tbody id="sort">
<?php 
		while ($detalles = $paging->fetchResultado()): 
			if(!in_array(array('mes' => $detalles['mes'], 'anho' => $detalles['anho']), $array)){
				$array[] = array('mes' => $detalles['mes'], 'anho' => $detalles['anho']);
?>
				<tr class="lleva-mes">
					<td colspan="9"><h6><?php echo strtoupper(strtr(date('M Y',strtotime($detalles['fecha_registro'])),$meses)); ?></h6></td>
				</tr>							
							
                <tr role="row">
                  <th class="sort"  width="20">DíA </th>
									<!-- 
									-->
                  <th class="sort cnone "  style="width:20px">orden </th>
                  <th class="sort"  width="70">COD </th>
                  <th class="sort">TÍTULO </th>
                  <th class="sort cnone" width="80">MODALIDAD</th>
                  <th class="sort cnone" width="50">Precio</th>
                  <th class="sort cnone" width="40">VISIBLE</th>
                  <th class="sort cnone" width="100">ACTUA</th>
                  <th class="sort cnone" width="30">ESTADO</th>
                  <th class="unafbe cnone" width="60">ENVIVO</th>                  
                  <th class="unafbe cnone" width="60">SÍLABOS</th>                  
                  <th class="unafbe cnone" width="60">ESPECIALIDAD</th>                  
                  <th class="unafbe cnone" width="60">USUARIO</th>                  
                  <th class="unafbe btn_varios">Opciones</th>
                </tr>
<?php }//if meses ?>

								<tr id="order_<?php echo $detalles["id_curso"]; ?>">
									<td><?php echo !empty($detalles['fecha_registro']) ? date('d',strtotime($detalles['fecha_registro'])) : '...'; ?></td>
						<!-- 
							-->									
									<td class=" cnone " style="width:20px"><?php echo $detalles["orden"]; ?></td>    
									<td ><?php echo $detalles["codigo"]; ?></td>    
                  <td>
										<?php echo $detalles["titulo"]; ?> </br>
										<span style="color:green;">TAG: </span> <?php echo $detalles["tag"]; ?></br>
										<span style="color:green;">TAG_trafico: </span> <?php echo $detalles["tag_trafico"]; ?></br>
										<a href="https://www.educaauge.com/unete/<?php echo $detalles["titulo_rewrite"]; ?>" target="_blank">[link trafico]</a>
									</td>                                
                  <td class="cnone"><?php echo ($detalles['modalidad']==1)?'GRABADO':'EN VIVO'; ?></td>
                  <td class="cnone text-center">
									<?php 
										$fecha_actual = strtotime(date("d-m-Y"));
										$fecha_entrada = strtotime($detalles["fecha_fin_promo"]);
										
										if($fecha_actual < $fecha_entrada  &&  (!empty($detalles["costo_promo"]) && $detalles["costo_promo"]!="0.00") ){
											echo $precio=$detalles["costo_promo"];
										}else{
											echo $precio=$detalles["precio"];
										}
										// echo ($detalles['costo_promo']> '0.00')?$detalles['costo_promo']:$detalles['precio'];
									?>
										</bt>
										<span style="color:red;"><?php echo $detalles["precio_online"]; ?></span>
									</td>
                  <td class="cnone text-center"><?php echo ($detalles['visibilidad']==1)?'SI':'OCULTO'; ?></td>
                  <td class="cnone"><?php echo fecha($detalles['fecha_actualizacion']); ?></td>
                  <td class="cnone"><a href="javascript: fn_estado('<?php echo $detalles["id_curso"]; ?>')"><?php echo $detalles["estado"]; ?></a></td>
                  <td class=" cnone ">
                    <div class="btn-eai  text-center btns btr  ">				
											<button type="button" class=" btn_envivo " style="background:<?php echo ($detalles["en_vivo"]==1)?'green':'#ddd;color:#333;';  ?>" data-toggle="modal" data-target="<?php echo '#image_'.$detalles["id_curso"];  ?>" > 
															envivo
											</button>
										</div>
									</td>
				
									<td class=" cnone ">
											<a href="index.php?page=silabos&id_curso=<?php echo $detalles['id_curso']; ?>&module=<?php echo $_GET['module']; ?>&parenttab=<?php echo $_GET['parenttab']; ?>"  style="background:blue;padding:6px;color:#fff;border-radius:8px;" title="Agregar silabos"><span> sílabos</span>
											</a> 
									</td>
									
									<td class=" cnone ">
									<?php if( $detalles['id_tipo_curso'] !=2 ){ ?>
                    <div class="btn-eai  text-center btns btr  ">				
											<a href="index.php?page=cursos_especialidades&module=<?php echo $_GET["module"];?>&parenttab=<?php echo $_GET["parenttab"];?><?php echo '&task=edit&id_curso='.$detalles["id_curso"].'&id_sub='.$detalles["id_sub"]; ?>" style="color:#fff;"><span>especialidades </span>
											</a> 
										</div>
									<?php }else{ echo "--"; } ?>
									</td>
									
									
                  <td class=" cnone "><span style="color:#000;"><?php echo $detalles["usuario"]; ?></span></td>
									
									<td>
                    <div class="btn-eai  text-center btns btr   btn_varios ">				
											<a href="index.php?page=cursos&module=Ver&parenttab=cursos
													<?php echo $_SESSION["base_url"].'&task=edit&id_curso='.$detalles["id_curso"]; ?>" style="color:#fff;"><i class="fa fa-edit"></i> <span>edit</span>
											</a>
											<a href="index.php?page=pestanhas&id_curso=<?php echo $detalles['id_curso']; ?>&module=<?php echo $_GET['module']; ?>&parenttab=<?php echo $_GET['parenttab']; ?>"  style="color:#fff;" title="Agregar pestaña">
												<!-- <i class="fa fa-eye"></i> --><span> info</span>
											</a> 	
											<a href="index.php?page=certificados&id_curso=<?php echo $detalles['id_curso']; ?>&module=<?php echo $_GET['module']; ?>&parenttab=<?php echo $_GET['parenttab']; ?>"  style="color:#fff;" title="Agregar modulo">
												 <span> certificados</span>
											</a> 		
											<a href="index.php?page=sesiones&id_curso=<?php echo $detalles['id_curso']; ?>&module=<?php echo $_GET['module']; ?>&parenttab=<?php echo $_GET['parenttab']; ?>"  style="color:#fff;" title="Agregar modulo">
												<i class="fa fa-plus-circle"></i> <span> modulos</span>
											</a> 		  
											<a href="index.php?page=suscritos_x_cursos&id_curso=<?php echo $detalles['id_curso']; ?>&module=<?php echo $_GET['module']; ?>&parenttab=<?php echo $_GET['parenttab']; ?>" title="Ver Alumnos" style="color:#fff;">
												<i class="fa fa-user"></i>  <span>cli </span>
											</a> 	
											<a href="index.php?page=curso_trailers&id_curso=<?php echo $detalles['id_curso']; ?>&module=<?php echo $_GET['module']; ?>&parenttab=<?php echo $_GET['parenttab']; ?>"  style="color:#fff;" title="Agregar video trailer">
												<i class="fa fa-video"></i> <span> videos</span>
											</a> 	
									<?php  if($_SESSION["visualiza"]["idtipo_usu"] ==1){ ?>
									<!-- 
                      <a href="javascript: fn_eliminar('<?php echo $detalles["id_curso"]; ?>')" style="background:red;"><i class="fa fa-trash-o"></i></a>
											-->
									<?php } ?> 

                    </div>
                  </td>
                </tr>
		
<!--  Btn en vivo -->		
		<div id="<?php echo 'image_'.$detalles['id_curso']; ?>" class="modal  bd-example-modal-lg  modal_images modal_images_practico " tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display:none;">
			<div class="modal-dialog modal-lg">
				<div class="modal-content text-center">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLongTitle"><b>En vivo: </b> </h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top:-20px;">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					
						<fieldset>
						<div class="form-group data_curso_en_vivo text-left " style=" max-width:600px;background: #efefef;padding: 20px;border-radius: 6px;margin-bottom:25px;">
							<label for="inputPassword3" class="col-md-12  control-label" style="text-align:left;padding:10px 5px 30px;">
									<b>(*) Ingresa Enlace y hora del en vivo: </b> <?php echo $detalles['titulo']; ?>
							</label>
							<label for="inputPassword3" class="col-md-12 control-label">Estado: </label>
							<div class="col-sm-12">
								<select id="en_vivo_<?php echo $detalles['id_curso'];?>" name="en_vivo_<?php echo $detalles['id_curso'];?>" class="form-control" requerid >  <!-- saco valor desde la BD -->
											<option value="" >-- estado del en_vivo --</option>  
											<option value="1" <?php echo ($detalles['en_vivo']==1)?'selected':'';?> >ACTIVO</option>  
											<option value="2" <?php echo ($detalles['en_vivo']==2)?'selected':'';?>>DESACTIVADO </option>
									</select>
							</div>
							
							<label for="inputPassword3" class="col-md-12 control-label">Link en vivo : </label>
							<div class="col-sm-12">
								<?php create_input("text","enlace_en_vivo_".$detalles['id_curso'],$detalles["enlace_en_vivo"],"form-control",$table,"  ",$agregado); ?>
							</div>
						
							<label for="inputPassword3" class="col-md-12  control-label">Hora en vivo: [boton verde ]</label>
							<div class="col-sm-12">
								<?php create_input("text","hora_en_vivo_".$detalles['id_curso'],$detalles["hora_en_vivo"],"form-control",$table,"  ",$agregado); ?>
							</div>
							
							<div class="col-sm-12 " style="padding:9px; 0">
								<h4 style=""><b>DATA Horario</b></h4>
							</div>
							
							<div class="col-sm-6" style="padding-bottom:9px;">
								<label for="inputPassword3" class="col-md-12  control-label">Fecha de inicio:</label>
								<?php create_input("text","horario_inicio_".$detalles['id_curso'],$detalles["horario_inicio"],"form-control",$table,"  ",$agregado); ?>
							</div>
							
							<div class="col-sm-6" style="padding-bottom:9px;">
								<label for="inputPassword3" class="col-md-12  control-label">Fecha termino:</label>
								<?php create_input("text","horario_final_".$detalles['id_curso'],$detalles["horario_final"],"form-control",$table,"  ",$agregado); ?>
							</div>
							
				
							
							<div class="col-sm-6 " style="padding-bottom:9px;">
								<label for="inputPassword3" class="col-md-12  control-label">Rango de Hora: ejem[7 - 9pm]</label>
								<?php create_input("text","horario_hora_".$detalles['id_curso'],$detalles["horario_hora"],"form-control",$table,"  ",$agregado); ?>
							</div>
							
							<div class="col-sm-6 " style="padding-bottom:9px;">
								<label for="inputPassword3" class="col-md-12  control-label">Lunes: ejem[mate_]</label>
								<?php create_input("text","horario_lunes_".$detalles['id_curso'],$detalles["horario_lunes"],"form-control",$table,"  ",$agregado); ?>
							</div>
							<div class="col-sm-6 " style="padding-bottom:9px;">
								<label for="inputPassword3" class="col-md-12  control-label">Martes: ejem[mate_2]</label>
								<?php create_input("text","horario_martes_".$detalles['id_curso'],$detalles["horario_martes"],"form-control",$table,"  ",$agregado); ?>
							</div>
							<div class="col-sm-6 " style="padding-bottom:9px;">
								<label for="inputPassword3" class="col-md-12  control-label">Miercoles: ejem[mate_3]</label>
								<?php create_input("text","horario_miercoles_".$detalles['id_curso'],$detalles["horario_miercoles"],"form-control",$table,"  ",$agregado); ?>
							</div>
							<div class="col-sm-6 " style="padding-bottom:9px;">
								<label for="inputPassword3" class="col-md-12  control-label">Jueves: ejem[mate_4]</label>
								<?php create_input("text","horario_jueves_".$detalles['id_curso'],$detalles["horario_jueves"],"form-control",$table,"  ",$agregado); ?>
							</div>
							<div class="col-sm-6 " style="padding-bottom:9px;">
								<label for="inputPassword3" class="col-md-12  control-label">Viernes: ejem[mate5]</label>
								<?php create_input("text","horario_viernes_".$detalles['id_curso'],$detalles["horario_viernes"],"form-control",$table,"  ",$agregado); ?>
							</div>
							<div class="col-sm-6 " style="padding-bottom:9px;">
								<label for="inputPassword3" class="col-md-12  control-label">Sábado: ejem[mate_6]</label>
								<?php create_input("text","horario_sabado_".$detalles['id_curso'],$detalles["horario_sabado"],"form-control",$table,"  ",$agregado); ?>
							</div>
							<div class="col-sm-6 " style="padding-bottom:9px;">
								<label for="inputPassword3" class="col-md-12  control-label">Domingo: ejem[mate_7]</label>
								<?php create_input("text","horario_domingo_".$detalles['id_curso'],$detalles["horario_domingo"],"form-control",$table,"  ",$agregado); ?>
							</div>
							

						</div>
						
						<div class="box-footer">
								<label for="" class="col-md-12  control-label  rpta_envivo hide" style="color:green;font-weigth:800;font-size:16px;line-height:22px;padding:30px 0 90px;">..</label>
								<div class="col-sm-12 pull-center">
									<a  href="javascript:en_vivo(<?php echo $detalles['id_curso']; ?>);" class="btn bg-blue btn-flat <?php echo 'btnguardar_envivo_'.$detalles['id_curso']; ?> " >Guardar</a>
									<button type="button" class="btn bg-red btn-flat" data-dismiss="modal" aria-label="Close" >Cerrar</button>
								</div>
						</div>
					</fieldset>
<?php 					
echo "<script>	


</script>	 ";
	?> 										
				
					</div>
				</div>
			</div>
		</div>								
<!--  Btn en vivo -->		
<!--  Btn en vivo -->		
								
<?php endwhile; ?>
              </tbody>
            </table>
            <div class="pagination"><?php echo $paging->fetchNavegacion(); ?></div>
<?php 
/* Si hay filtros se blokea el ordenar, porque va afectar a todas los resultado, */
if(empty($_GET['criterio_usu_per']) && empty($_GET['id_cat']) && empty($_GET['id_sub']) && empty($_GET['id_especialidad']) && empty($_GET['visibilidad']) && empty($_GET['id_tipo_curso']) && empty($_GET['fechabus_1']) && empty($_GET['fechabus_2']) ){
?>						
	<script>
	$(function(){
		checked();
		sorter();
		// reordenar('cursos.php');
		reordenar_con_post('cursos.php');
	});
	var mypage = "cursos.php";
	</script>
<?php } ?>


<?php }else{ ?>
        <div class="box-body">
          <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
            <form action="javascript: fn_buscar();" id="frm_buscar" name="frm_buscar">
							<input type="hidden" name="id_tipo" value="<?php echo $_GET["id_tipo"];?>">
							<input type="hidden" name="module" value="<?php echo $_GET["module"];?>">
							<input type="hidden" name="parenttab" value="<?php echo $_GET["parenttab"];?>">
              <div class="bg-gray-light">
									<div class="col-md-12 criterio_mostrar" style="margin-bottom:10px;">
									<div class="col-md-2">
										<div class="btn-eai">
											<a href="<?php echo $link_lleva_tipo."&task=new"; ?>" style="color:#fff;"><i class="fa fa-file"></i> Agregar </a>                    
										</div>
									</div>
									<div class="col-sm-8 criterio_buscar">
										<div class="col-sm-7 criterio_buscar" style="padding-bottom:8px;">
											<?php crearselect("id_cat", "select id_cat, titulo from categorias where id_tipo='".$_GET["id_tipo"]."' order by titulo asc", 'class="form-control"  style="border:1px solid #CA3A2B;" onchange="javascript:display(\'cursos.php\',this.value,\'cargar_subcategorias\',\'id_sub\')"', '', " Todas las  categorias "); ?>
										</div>
											
										<div class="col-sm-5 criterio_buscar" style="padding-bottom:8px;">
											<select name="id_sub" id="id_sub" class="form-control" ><option value="" selected="selected">-- subcategorías. --</option></select>
										</div>
										<div class="break" style="padding:1px 0;"></div>

										<label class="col-sm-1  text-right" style="padding-top: 8px;">Busca por: </label>
										<div class="col-sm-6 criterio_buscar">
											<?php create_input('text','criterio_usu_per','',"form-control pull-right",$table,'   '); ?>
										</div>
										<div class="col-sm-3 criterio_mostrar">          
											<?php select_sql("nregistros"); ?>
										</div>
										<div class="col-sm-1 criterio_mostrar">
												<button class="btn_action_buscar ">B<span>uscar</span></button>
										</div> 
										
									</div>
							<!-- 
								-->
									
									<?php /*
									<div class="col-sm-2 criterio_buscar">
											<?php crearselect("id_especialidad", "select id_especialidad, titulo from especialidades Order by titulo asc", 'class="form-control"  ', '', "-- especialidad --"); ?>
									</div>
									
									
									<div class="col-md-6 criterio_mostrar" style="margin-bottom:10px;">
										<div class="lleva_flechas" style="position:relative;">
											<label>Desde:</label>
											<?php create_input('date', 'fechabus_1', '', "form-control pull-right", $table, ''); ?>
										</div>
										<div class="lleva_flechas" style="position:relative;">
											<label>Hasta:</label>
											<?php create_input('date', 'fechabus_2', '', "form-control pull-right", $table, ''); ?>
										</div>
											<button>Buscar</button>
									</div>  
								</div>
			
                
                <div class="col-sm-2 criterio_buscar">
                </div>
                <div class="col-sm-4 criterio_buscar">
                  <?php create_input('text','criterio_usu_per','',"form-control pull-right",$table,'placeholder="Buscar .."'); ?>
                </div>
					
								<div class="col-md-2 criterio_mostrar" style="margin-bottom:10px;">
									<select id="visibilidad" name="visibilidad" class="form-control" requerid >  <!-- saco valor desde la BD -->
											<option value="" >-- visibilidad --</option>  
											<option value="1" >SI</option>  
											<option value="2" >OCULTO</option>
										</select>
								</div> 
							*/ ?>
									<div class="col-md-2 criterio_mostrar" style="margin-top:0;">
										<select id="id_tipo_curso" name="id_tipo_curso" class="form-control" requerid >  <!-- saco valor desde la BD -->
												<option value="" >-- tipo --</option>  
												<option value="1" >GENERAL</option>  
												<option value="2" >ESPECIALIDADES</option>
											</select>
									</div>  
									
									
								
								
							</div>
              
              </div>
            </form>
            <div class="row">
              <div class="col-sm-12">
                <div id="div_listar"></div>
                <div id="div_oculto" style="display: none;"></div>
              </div>
            </div>
            </div>
        </div>

<script>
var link = "curso";
var us = "curso";
var ar = "la";
var l = "o";
var l2 = "e";
var pr = "El";
var id = "id_curso";
var mypage = "cursos.php";
</script>

<?php } ?>