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

}elseif($_GET["task"]=='insert' || $_GET["task"]=='update'){
  $bd=new BD;
  $where = ($_GET["task"]=='update') ? "and id_curso!='".$_POST["id_curso"]."'" : '';
  $urlrewrite=armarurlrewrite($_POST["titulo"]);
  $urlrewrite=armarurlrewrite($urlrewrite,1,"cursos","id_curso","titulo_rewrite",$where);


	$_POST['fecha_actualizacion'] = fecha_hora(2);
	if(empty($_POST['validez_meses'])) $_POST['validez_meses']='0';
  
	$campos=array('id_tipo','id_pro','tipo','titulo', array('titulo_rewrite',$urlrewrite),"breve_detalle","precio",'modalidad',"link_video",'descripcion','estado_idestado','fecha_actualizacion','validez_meses'); 
	if($_POST['modalidad'] == 2){
			if(!empty($_POST['fecha_inicio'])) $campos = array_merge($campos,array('fecha_inicio'));
			if(!empty($_POST['hora_inicio'])) $campos = array_merge($campos,array('hora_inicio')); 
	}
	
	if($_POST['en_vivo'] == 1){
			if(!empty($_POST['enlace_en_vivo'])) $campos = array_merge($campos,array('enlace_en_vivo'));
			if(!empty($_POST['hora_en_vivo'])) $campos = array_merge($campos,array('hora_en_vivo'));
		
	}else{
		$_POST['en_vivo']=2;
	}

	$campos = array_merge($campos,array('en_vivo'));
	if(empty($_POST['costo_promo'])) $_POST['costo_promo']='0.00';
	if(!empty($_POST['costo_promo'])){
		$campos = array_merge($campos,array('costo_promo'));
		if(!empty($_POST['fecha_fin_promo'])){
			$campos = array_merge($campos,array('fecha_fin_promo'));
		}
	}
	
	//cursos_dependientes 
	if (isset($_POST['cursos_dependientes']) && is_array($_POST['cursos_dependientes'])){
      $campos= array_merge($campos,array(array('cursos_dependientes',implode(',',$_POST['cursos_dependientes']))));
  } 
	
	
  if($_GET["task"]=='insert'){
    if(isset($_FILES['imagen']) && !empty($_FILES['imagen']['name'])){
      $_POST['imagen'] = carga_imagen('files/images/capa/','imagen','');
      $campos = array_merge($campos,array('imagen'));
    }
		
		//Generando - Cod venta
$end_venta=executesql("select * from cursos order by orden desc limit 0,1");
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
    $_POST['fecha_registro'] = fecha_hora(2);
		
		// echo var_dump(arma_insert('cursos',array_merge($campos,array('codigo','fecha_registro','orden')),'POST'));
		// exit();
		
    $_POST["id_curso"]=$bd->inserta_(arma_insert('cursos',array_merge($campos,array('codigo','fecha_registro','orden')),'POST'));
		
  }else{
    if(isset($_FILES['imagen']) && !empty($_FILES['imagen']['name'])){
      $path = 'files/images/capa/'.$_POST['imagen_ant'];
      if( file_exists($path) && !empty($_POST['imagen_ant']) ) unlink($path);    
      $_POST['imagen'] = carga_imagen('files/images/capa/','imagen','');
      $campos = array_merge($campos,array('imagen'));
    }
		
    // if(isset($_FILES['archivo']) && !empty($_FILES['archivo']['name'])){
      // $path = 'files/files/'.$_POST['archivo_ant'];
      // if( file_exists($path) && !empty($_POST['archivo_ant']) ) unlink($path);    
      // $_POST['archivo'] = carga_imagen('files/files/','archivo','');
      // $campos = array_merge($campos,array('archivo'));
    // }
		
		// echo var_dump(armaupdate('cursos',$campos," id_curso='".$_POST["id_curso"]."'",'POST'));
		// exit();
		
		
    $bd->actualiza_(armaupdate('cursos',$campos," id_curso='".$_POST["id_curso"]."'",'POST'));/*actualizo*/
  }
	
	
	$bd->actualiza_("DELETE FROM categoria_subcate_cursos WHERE id_curso='".$_POST["id_curso"]."'");
  if(isset($_POST['subcategorias'])){
		$_POST['fecha_registro'] = fecha_hora(2);
    foreach($_POST['subcategorias'] as $v){
      $division = explode('_',$v);
      $_POST["id_cat"] = $division[0]; $_POST["id_sub"] = $division[1];
      $bd->inserta_(arma_insert('categoria_subcate_cursos',array('id_tipo','id_cat','id_sub','id_curso','fecha_registro'),'POST'));
    }
	}
	
	
  $bd->close();
  gotoUrl("index.php?page=".$_POST["nompage"]."&id_tipo=".$_POST["id_tipo"]."&module=".$_POST["nommodule"]."&parenttab=".$_POST["nomparenttab"]);

}elseif($_GET["task"]=='new' || $_GET["task"]=='edit'){
  if($_GET["task"]=='edit'){
     $data_producto=executesql("select * from cursos where id_curso='".$_GET["id_curso"]."'",0);
  }
?>
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
                  <label for="inputEmail3" class="col-md-2 col-sm-2 control-label">Estado</label>
                  <div class="col-sm-3">
                    <?php crearselect("estado_idestado","select * from estado where idestado in('1','2') order by 2 desc",'class="form-control"',$data_producto["estado_idestado"],""); ?>
                  </div>
                  <label for="inputPassword3" class="col-md-2 col-sm-2 control-label">Modalidad:</label>
									<div class="col-sm-3">
										<select id="modalidad" name="modalidad" class="form-control" requerid >  <!-- saco valor desde la BD -->
											<option value="" >-- selecciona --</option>  
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
                </div>
								
						
								
								<div class="form-group">
									<label for="inputPassword3" class="col-md-2 col-sm-2 control-label">Destacado:</label>
									<div class="col-sm-3">
										<select id="tipo" name="tipo" class="form-control" requerid >  <!-- saco valor desde la BD -->
											<option value="2"  <?php echo ($data_producto['tipo'] == 2) ? 'selected' : '' ;?>>NO</option>
											<option value="1" <?php echo ($data_producto['tipo'] == 1) ? 'selected' : '' ;?>>SI</option>  
										</select>
									</div>
                  <label for="inputEmail3" class="col-md-2 col-sm-2 control-label">Profesor</label>
                  <div class="col-sm-3">
                    <?php crearselect("id_pro","select * from profesores where estado_idestado=1 order by titulo asc ",'class="form-control"',$data_producto["id_pro"]," -- seleccione--"); ?>
                  </div>
                </div>
							
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
			


								<div class="form-group">
                  <label for="inputPassword3" class="col-md-2 col-sm-2 control-label">Título</label>
                  <div class="col-sm-6">
                    <?php create_input("text","titulo",$data_producto["titulo"],"form-control",$table,"",$agregado); ?>
                  </div>
                </div>
								
								
								<div class="form-group">
                  <label for="inputPassword3" class="col-md-2 col-sm-2 control-label">Resumen breve:</label>
                  <div class="col-sm-6">
                    <?php create_input("textarea","breve_detalle",$data_producto["breve_detalle"],"form-control",$table,"",$agregado); ?>
                  </div>
                </div>
								
							<div class="form-group">
								<label for="inputPassword3" class="col-md-2 col-sm-2 control-label">Precio S/. </label>
								<div class="col-md-2 col-sm-2">
									<?php create_input("text","precio",$data_producto["precio"],"form-control",$table,"onkeypress='javascript:return soloNumeros_precio(event,2);'"); /* el 2 permite poner  decmales */?> 
								</div>
								
							</div>
							
							<div class="form-group">
								<label for="inputPassword3" class="col-md-2 col-sm-2 control-label">Fecha límite de promo: </label>
								<div class="col-md-3 col-sm-3">
									<?php create_input("date","fecha_fin_promo",$data_producto["fecha_fin_promo"],"form-control",$table,""); /* el 2 permite poner  decmales */?> 
								</div>
								<label for="inputPassword3" class="col-md-2 col-sm-2 control-label">Precio promo S/.</label>
								<div class="col-md-3 col-sm-3">
									<?php create_input("text","costo_promo",$data_producto["costo_promo"],"form-control",$table,"onkeypress='javascript:return soloNumeros_precio(event,2);'"); ?>
								</div>
							</div>
							
								<div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Descripción</label>
                  <div class="col-sm-10">
                    <?php create_input("textarea","descripcion",$data_producto["descripcion"],'  ',$table,'style="height:650px!important;"');  ?>
                    <script>
                    var editor11 = CKEDITOR.replace('descripcion');
                    CKFinder.setupCKEditor( editor11, 'ckfinder/' );
                    </script> 
                  </div>
                </div>
								
							
                <div class="form-group">
                  <label for="inputPassword3" class="col-md-2 col-sm-2 control-label">Imágen</label>
                  <div class="col-sm-6">
                    <input type="file" name="imagen" id="imagen" class="form-control">
                    <?php create_input("hidden","imagen_ant",$data_producto["imagen"],"",$table,$agregado); 
                      if($data_producto["imagen"]!=""){ 
                    ?>
                      <img src="<?php echo "files/images/capa/".$data_producto["imagen"]; ?>" width="200" class="mgt15">
                    <?php } ?> 
                  </div>
                </div>
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
								
								<div class="form-group">
									<label for="inputPassword3" class="col-md-2 col-sm-2 control-label">En vivo?</label>
									<div class="col-sm-3">
										<select id="en_vivo" name="en_vivo" class="form-control"  >  <!-- saco valor desde la BD -->
											<option value="2" <?php echo ($data_producto['en_vivo'] == 2) ? 'selected' : '' ;?>>NO</option>
											<option value="1" <?php echo ($data_producto['en_vivo'] == 1) ? 'selected' : '' ;?>>SI</option>  
										</select>
									</div>
                </div>
								
								
								<div class="form-group data_curso_en_vivo <?php echo (!empty($_GET["id_curso"]) && $data_producto['en_vivo'] == 1) ?'detalle_editar':' hide ';?>  " style="    		background: #efefef;padding: 20px;border-radius: 6px;margin-bottom:25px;">
                  <label for="inputPassword3" class="col-md-12  control-label" style="text-align:left;padding:10px 5px;padding-left:70px;">(*) Ingresa Enlace y hora del en vivo: </label>
                  <label for="inputPassword3" class="col-md-2 col-sm-2 control-label">Link en vivo : </label>
                  <div class="col-sm-3">
                    <?php create_input("text","enlace_en_vivo",$data_producto["enlace_en_vivo"],"form-control",$table,"",$agregado); ?>
                  </div>
               
                  <label for="inputPassword3" class="col-md-2 col-sm-2 control-label">Hora en vivo: </label>
                  <div class="col-sm-3">
                    <?php create_input("text","hora_en_vivo",$data_producto["hora_en_vivo"],"form-control",$table,"",$agregado); ?>
                  </div>
                </div>
								
								
								
								
					 
				<?php if(isset($_GET["id_tipo"]) && $_GET["id_tipo"]!=5){ // cara curso gratis esto no aplica --.. ?>	 
							<div class="form-group">
									<label for="inputEmail3" class="col-md-2 col-sm-2 control-label">Cursos dependientes: </label>
									<div class="col-sm-9">
										 <?php 
                $cursos_dependientes=array();
                $array= $data_producto["cursos_dependientes"];
                if(!empty($array)) $cursos_dependientes= explode(',',$array);
								
								if( isset($_GET["task"]) && $_GET["task"]=='edit'){ 
								
								 	$_sql_dependientes=		"select c.id_curso, CONCAT(tp.titulo,' - ',c.titulo) as curso from cursos c INNER JOIN tipo_cursos tp ON c.id_tipo=tp.id_tipo WHERE c.estado_idestado=1 and tp.estado_idestado=1  AND c.id_curso NOT IN (".$data_producto["id_curso"].") ORDER BY  tp.titulo, c.titulo ASC "; 
								}else{
									$_sql_dependientes= "select c.id_curso, CONCAT(tp.titulo,' - ',c.titulo) as curso from cursos c INNER JOIN tipo_cursos tp ON c.id_tipo=tp.id_tipo WHERE c.estado_idestado=1 and tp.estado_idestado=1 ORDER BY  tp.titulo, c.titulo ASC " ;
								}
								
                ?>
               <?php crearselect("cursos_dependientes[]",$_sql_dependientes,'class="form-control"  style="height:300px;" multiple',$cursos_dependientes); ?>
									</div>
							</div>
			<?php } ?> 
					 
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
      $pfile = 'files/files/'.$row['archivo']; if(file_exists($pfile) && !empty($row['archivo'])){ unlink($pfile); }
    }
  }

  $bd->actualiza_("DELETE FROM archivos WHERE id_curso IN(".$ide.")");
  $bd->actualiza_("DELETE FROM cursos WHERE id_curso IN(".$ide.")");
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
	
  $sql = "SELECT YEAR(c.fecha_registro) as anho, MONTH(c.fecha_registro) as mes,  csc.id_cat,csc.id_sub, c.*, e.nombre as estado 
		FROM cursos c  
	 INNER JOIN categoria_subcate_cursos csc ON csc.id_curso=c.id_curso 
	 INNER JOIN categorias ctg ON ctg.id_cat=csc.id_cat  
	 INNER JOIN subcategorias sub ON csc.id_sub=sub.id_sub  
	 INNER JOIN estado e ON c.estado_idestado=e.idestado  
	 WHERE  c.id_tipo='".$_GET["id_tipo"]."'     
	 "; 
  if(isset($_GET['criterio_mostrar'])) $porPagina=$_GET['criterio_mostrar'];
  if(isset($_GET['criterio_usu_per']) && !empty($_GET['criterio_usu_per'])){
    $stringlike=fn_filtro(substr($_GET['criterio_usu_per'], 0, 16));
    $sql.= " and  ( c.titulo LIKE '%".$stringlike."%' or  c.codigo LIKE '%".$stringlike."%' )  ";
  }else{
		if( empty($_GET['fechabus_1']) && empty($_GET['fechabus_2']) ) {
			$sql .= " AND DATE(c.fecha_registro) = '" . fecha_hora(1) . "'";
		}	
	}
	
	if(!empty($_GET['id_cat'])) {
		$sql .= " AND csc.id_cat = '".$_GET['id_cat']."'";
	}
	
	if(!empty($_GET['id_sub'])) {
		$sql .= " AND csc.id_sub = '".$_GET['id_sub']."'";
	}
	
	if(!empty($_GET['fechabus_1']) && !empty($_GET['fechabus_2'])) {
			$sql .= " AND DATE(c.fecha_registro)  BETWEEN  DATE('".$_GET['fechabus_1']."')  and DATE('".$_GET['fechabus_2']."')  ";		
	}
	
	
  if(isset($_GET['criterio_ordenar_por'])) $sql.= sprintf(" order by %s %s", fn_filtro($_GET['criterio_ordenar_por']), fn_filtro($_GET['criterio_orden']));
  $sql.= " Group BY c.id_curso ORDER BY c.orden DESC   ";
	
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
  // $paging->porPagina(fn_filtro((int)$porPagina));
  $paging->porPagina(1000);
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
                  <th class="sort"  width="70">DíA </th>
                  <th class="sort"  width="70">COD </th>
                  <th class="sort">TÍTULO </th>
                  <th class="unafbe cnone" width="50">IMÁGEN</th>                  
                  <th class="sort cnone" width="80">DESTACADO</th>
                  <th class="sort cnone" width="120">MODALIDAD</th>
                  <th class="sort cnone" width="120">ACTUALIZADO</th>
                  <th class="sort cnone" width="60">ESTADO</th>
                  <th class="unafbe btn_varios">Opciones</th>
                </tr>
<?php }//if meses ?>

								<tr>
									<td><?php echo !empty($detalles['fecha_registro']) ? date('d',strtotime($detalles['fecha_registro'])) : '...'; ?></td>
                  <td><?php echo $detalles["codigo"]; ?></td>                
                  <td><?php echo $detalles["titulo"]; ?></td>                
                  <td class="cnone">
                    <?php if(!empty($detalles["imagen"])){ ?>
                    <img src="<?php echo "files/images/capa/".$detalles["imagen"]; ?>" alt="<?php echo $detalles["titulo"]; ?>" class="img-responsive">
                    <?php }else{ echo "Not Image."; } ?>
                  </td>
                  <td class="cnone text-center"><?php echo ($detalles['tipo']==1)?'SI':'NO'; ?></td>
                  <td class="cnone"><?php echo ($detalles['modalidad']==1)?'GRABADO':'EN VIVO'; ?></td>
                  <td class="cnone"><?php echo fecha($detalles['fecha_actualizacion']); ?></td>
                  <td class="cnone"><a href="javascript: fn_estado('<?php echo $detalles["id_curso"]; ?>')"><?php echo $detalles["estado"]; ?></a></td>
                  <td>
                    <div class="btn-eai  text-center btns btr   btn_varios ">				
											<a href="index.php?page=cursos&module=Ver&parenttab=cursos
													<?php echo $_SESSION["base_url"].'&task=edit&id_curso='.$detalles["id_curso"]; ?>" style="color:#fff;"><i class="fa fa-edit"></i> <span>editar</span>
											</a>
											<a href="index.php?page=pestanhas&id_curso=<?php echo $detalles['id_curso']; ?>&module=<?php echo $_GET['module']; ?>&parenttab=<?php echo $_GET['parenttab']; ?>"  style="color:#fff;" title="Agregar pestaña">
												<i class="fa fa-eye"></i> <span> información</span>
											</a> 	
											<a href="index.php?page=sesiones&id_curso=<?php echo $detalles['id_curso']; ?>&module=<?php echo $_GET['module']; ?>&parenttab=<?php echo $_GET['parenttab']; ?>"  style="color:#fff;" title="Agregar modulo">
												<i class="fa fa-plus-circle"></i> <span> modulos</span>
											</a> 		  
											<a href="index.php?page=suscritos_x_cursos&id_curso=<?php echo $detalles['id_curso']; ?>&module=<?php echo $_GET['module']; ?>&parenttab=<?php echo $_GET['parenttab']; ?>" title="Asignar Alumnos" style="color:#fff;">
												<i class="fa fa-user"></i>  <span>alumnos </span>
											</a> 	
					
                    </div>
                  </td>
                </tr>
<?php endwhile; ?>
              </tbody>
            </table>
            <div class="pagination"><?php echo $paging->fetchNavegacion(); ?></div>
<script>
$(function(){
  checked();
  sorter();
  reordenar('cursos.php');
});
var mypage = "cursos.php";
</script>

<?php }else{ ?>
        <div class="box-body">
          <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
            <form action="javascript: fn_buscar();" id="frm_buscar" name="frm_buscar">
							<input type="hidden" name="id_tipo" value="<?php echo $_GET["id_tipo"];?>">
							<input type="hidden" name="module" value="<?php echo $_GET["module"];?>">
							<input type="hidden" name="parenttab" value="<?php echo $_GET["parenttab"];?>">
              <div class="bg-gray-light">
								<div class="col-sm-12 criterio_mostrar" style="margin-bottom:10px;">
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

                <div class="col-md-2">
                  <div class="btn-eai">
                    <a href="<?php echo $link_lleva_tipo."&task=new"; ?>" style="color:#fff;"><i class="fa fa-file"></i> Agregar </a>                    
                  </div>
                </div>
                <div class="col-sm-4 criterio_buscar">
                  <?php create_input('text','criterio_usu_per','',"form-control pull-right",$table,'placeholder="Buscar .."'); ?>
                </div>
								<div class="col-sm-3 criterio_buscar">
										<?php crearselect("id_cat", "select id_cat, titulo from categorias where id_tipo='".$_GET["id_tipo"]."' order by titulo asc", 'class="form-control"  onchange="javascript:display(\'cursos.php\',this.value,\'cargar_subcategorias\',\'id_sub\')"', '', "-- categorias --"); ?>
								</div>
								<div class="col-sm-3 criterio_buscar">
										<select name="id_sub" id="id_sub" class="form-control" ><option value="" selected="selected">-- subcateg. --</option></select>
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
var l = "a";
var l2 = "a";
var pr = "La";
var id = "id_curso";
var mypage = "cursos.php";
</script>

<?php } ?>