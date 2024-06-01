<?php error_reporting(E_ALL ^ E_NOTICE);
include ("auten.php");



if($_GET["task"]=='_add_insertar_pregunta_desde_examen_a_banco'){
  $bd=new BD;
  $pregunta=executesql(" select * from preguntas where id_pregunta=".$_POST["id_pregunta"]." and estado_idestado=1  ");
  if( !empty($pregunta) ){
      
      //  registro una copia en banco de preguntas 
      $_POST["corregido"]=1;	
      // valido que no re se repirta  
      $bancos_validar = executesql(" select * from preguntas_bancos where titulo='".$pregunta[0]["titulo"]."' ");
      if( empty($bancos_validar) ){ // si no existe lo regsitramos en banco preguntas 
          $_POST["titulo"]=$pregunta[0]["titulo"];
          $_POST["titulo_rewrite"]=$pregunta[0]["titulo_rewrite"];
          $_POST["descripcion"]=$pregunta[0]["descripcion"];
          $_POST["puntos"]=$pregunta[0]["puntos"];
          $_POST["imagen"]=$pregunta[0]["imagen"];
          $_POST["imagen_pre_2"]=$pregunta[0]["imagen_pre_2"];
          $_POST["imagen2"]=$pregunta[0]["imagen2"];
          $_POST["solucion"]=$pregunta[0]["solucion"];
          $_POST["solucion_es_video"]=$pregunta[0]["solucion_es_video"];
          $_POST["estado_idestado"]=$pregunta[0]["estado_idestado"];
          $_POST["fecha_registro"]= fecha_hora(2);
          $_POST["id_cate"]=$pregunta[0]["id_cate"];

          $campos_bancos=array('corregido','id_cate','titulo','titulo_rewrite','puntos','descripcion','imagen','imagen_pre_2','imagen2','solucion','solucion_es_video','fecha_registro','estado_idestado'); /*inserto campos principales*/            
          $rpta= $_POST["id_pregunta_banco"]=$bd->inserta_(arma_insert('preguntas_bancos',$campos_bancos,'POST')); 
          if( $rpta > 0 ){

            // agregamos las reespuestas al banco de pregunas -...
            $_sql_res=" select * from respuestas where id_pregunta=".$_POST["id_pregunta"]." and estado_idestado=1  ";

            $respuestas=executesql($_sql_res);
            if( !empty($respuestas) ){
             // echo "existe:: ".$_sql_res;

              foreach( $respuestas as $rptas ){
                $_POST["titulo"]=$rptas["titulo"];
                $_POST["titulo_rewrite"]=$rptas["titulo_rewrite"];
                $_POST["descripcion"]=$rptas["descripcion"];
                $_POST["valor"]=$rptas["valor"];
                $_POST["imagen"]=$rptas["imagen"];
                $_POST["estado_rpta"]=$rptas["estado_rpta"];
                $_POST["estado_idestado"]=$rptas["estado_idestado"];
                $_POST["fecha_registro"]= fecha_hora(2);
                $_POST["imagen"]=$rptas["imagen"];
                
                $_POST["id_pregunta"]=$_POST["id_pregunta_banco"];
                $campos_respuestas=array('id_pregunta','titulo','titulo_rewrite','estado_rpta','fecha_registro','estado_idestado'); 
             
                $bd->inserta_(arma_insert('respuestas_bancos',$campos_respuestas,'POST')); 

              }
            }

            echo $rpta=1;
          }

      }else{
        echo $rpta=3; // ya existe en banco 
      }
      
  } // end si existe la pregunta a clonar 


}else if($_GET["task"]=='insert' || $_GET["task"]=='update'){
  $bd=new BD;
	$where = ($_GET["task"]=='update') ? "and id_pregunta!='".$_POST["id_pregunta"]."'" : '';
	// $urlrewrite=armarurlrewrite($_POST["titulo"]);
  // $urlrewrite=armarurlrewrite($urlrewrite,1,"preguntas","id_pregunta","titulo_rewrite",$where);
	
	$_POST['fecha_actualizacion'] = fecha_hora(2);
	// $dir='files/images/imagenes/'.$_POST['id_examen'].'/';
	$dir='files/images/imagenes/';
	$dir_bancos='files/images/imagenes/';
	
	
	$campos=array('titulo',array('titulo_rewrite',$urlrewrite),'puntos','descripcion','solucion','solucion_es_video','fecha_actualizacion','estado_idestado'); /*inserto campos principales*/
  if($_GET["task"]=='insert'){
    /** valido si la pregunta ya existe en este examen , puede tenerla otro examene , pero repetida en este examen sino . */
    $preguntas_validar = executesql(" select * from preguntas where titulo='".$_POST["titulo"]."' and id_examen='".$_POST["id_examen"]."' and estado_idestado=1  ");
    if( empty($preguntas_validar) ){

          // echo "A";
          // $_POST['orden'] = _orden_noticia("","preguntas","");
          // echo "B";
          $_POST['fecha_registro'] = fecha_hora(2);
          // echo "hola se ";
          
          $campos = array_merge($campos,array('id_cate'));  // solo en insert no se edita 


          if(isset($_FILES['imagen']) && !empty($_FILES['imagen']['name'])){
            $_POST['imagen'] = carga_imagen($dir_bancos,'imagen','','800','400');  // creo una copiar para banco preguntas
            $campos_bancos = array_merge($campos,array('imagen'));
            
            
            $_POST['imagen'] = carga_imagen($dir,'imagen','','800','400');
            $campos = array_merge($campos,array('imagen'));
            
          }
          
          if(isset($_FILES['imagen_pre_2']) && !empty($_FILES['imagen_pre_2']['name'])){
            $_POST['imagen_pre_2'] = carga_imagen($dir,'imagen_pre_2','','800','400');
            $campos = array_merge($campos,array('imagen_pre_2'));
            
            $_POST['imagen_pre_2'] = carga_imagen($dir_bancos,'imagen_pre_2','','800','400'); // creo una copiar para banco preguntas
            $campos_bancos = array_merge($campos_bancos,array('imagen_pre_2'));
          }
          
          /* IMG SOLUCION */
          if(isset($_FILES['imagen2']) && !empty($_FILES['imagen2']['name'])){
            $_POST['imagen2'] = carga_imagen($dir,'imagen2','','800','400');
            $campos = array_merge($campos,array('imagen2'));
            
            $_POST['imagen2'] = carga_imagen($dir_bancos,'imagen2','','800','400'); // creo una copiar para banco preguntas
            $campos_bancos = array_merge($campos_bancos,array('imagen2'));
          }
          
          // echo var_dump(arma_insert('preguntas',array_merge($campos,array('orden','fecha_registro')),'POST'));
          // exit();
          
          $_POST["origen_en"]=2;  // pregunta registrada directamente 
          $id_pregunta=$_POST['orden']= $bd->inserta_(arma_insert('preguntas',array_merge($campos,array('fecha_registro','id_examen','origen_en')),'POST'));/*inserto hora -orden y guardo imag*/
          /* orden == id_pregunta */

          /* update para guardar el orden */
          $bd->actualiza_(armaupdate('preguntas',array('orden')," id_pregunta='".$id_pregunta."'",'POST'));/*actualizo el orden de rpegunta por su id de registro */
          

          /*
          //  registro una copia en banco de preguntas 
          $_POST["corregido"]=1;	
          // valido que no re se repirta  
          $bancos_validar = executesql(" select * from preguntas_bancos where titulo='".$_POST["titulo"]."' ");
          if( empty($bancos_validar) ){ // si no existe lo regsitramos en banco preguntas 
            $bd->inserta_(arma_insert('preguntas_bancos',array_merge($campos_bancos,array('fecha_registro','corregido')),'POST')); 
          }
          */
    
    } // end valicacion si ya existe la pregunta en este examene ya no lo duplico 
        
		
		
  }else{
		
		if(isset($_FILES['imagen']) && !empty($_FILES['imagen']['name'])){
      $path = $dir.$_POST['imagen_ant'];
      // if( file_exists($path) && !empty($_POST['imagen_ant']) ) unlink($path);   // no elimino al alctualizar porque puede etasr siendo usada en banco de pregunta o en clonacion    
      $_POST['imagen'] = carga_imagen($dir,'imagen','','800','400');
      $campos = array_merge($campos,array('imagen'));
    }
		
		if(isset($_FILES['imagen_pre_2']) && !empty($_FILES['imagen_pre_2']['name'])){
      $path = $dir.$_POST['imagen_ant_pre'];
     //  if( file_exists($path) && !empty($_POST['imagen_ant']) ) unlink($path);      // no elimino al alctualizar porque puede etasr siendo usada en banco de pregunta o en clonacion    
      $_POST['imagen_pre_2'] = carga_imagen($dir,'imagen_pre_2','','800','400');
      $campos = array_merge($campos,array('imagen_pre_2'));
    }
		
		/* IMG SOLUCION */
		if(isset($_FILES['imagen2']) && !empty($_FILES['imagen2']['name'])){
      $path = $dir.$_POST['imagen_ant2'];
     // if( file_exists($path) && !empty($_POST['imagen_ant2']) ) unlink($path);      // no elimino al alctualizar porque puede etasr siendo usada en banco de pregunta o en clonacion    
      $_POST['imagen2'] = carga_imagen($dir,'imagen2','','800','400');
      $campos = array_merge($campos,array('imagen2'));
    }
		
    $bd->actualiza_(armaupdate('preguntas',$campos," id_pregunta='".$_POST["id_pregunta"]."'",'POST'));/*actualizo*/
  }
	
  $bd->close();
  gotoUrl("index.php?page=".$_POST["nompage"]."&id_examen=".$_POST["id_examen"]."&module=".$_POST["nommodule"]."&parenttab=".$_POST["nomparenttab"]);
	
}elseif($_GET["task"]=='new' || $_GET["task"]=='edit'){
  if($_GET["task"]=='edit'){
     $data_servicio=executesql("select * from preguntas where id_pregunta='".$_GET["id_pregunta"]."'",0);
  }
?>
<!-- CK EDITOR -->
<script src="ckeditor/ckeditor.js"></script>
<script src="ckeditor/sample.js"></script>
<script src="ckfinder/ckfinder.js"></script>
<section class="content">
  <div class="row">
    <div class="col-md-12">
      <!-- Horizontal Form -->
      <div class="box box-info">
        <div class="box-header with-border">
				 <?php   $sql_x=" select * from examenes where id_examen='".$_GET["id_examen"]."' "; 
						$datoscurso=executesql($sql_x,0); 
					?>				
          <h4 class="box-title"><?php echo ($_GET["task"]=="edit") ? 'Editar' : 'Agregando'; ?> Pregunta: <b><?php echo $datoscurso["titulo"]; ?> </b> </h4>
        </div><!-- /.box-header -->
<?php $task_=$_GET["task"]; ?>
        <!-- form start -->
        <form id="registro" action="preguntas.php?task=<?php echo ($task_=='edit') ?  "update" : "insert"; ?>" class="form-horizontal" method="POST" enctype="multipart/form-data" onsubmit="return aceptar()">
<?php 
if($task_=='edit') create_input("hidden","id_pregunta",$data_servicio["id_pregunta"],"",$table,"");
create_input("hidden","urlfailed",basename($_SERVER['REQUEST_URI']),"",$table,"");  
create_input("hidden","urlgo",$link_examen,"",$table,"");
create_input("hidden","nompage",$_GET["page"],"",$table,""); 
create_input("hidden","id_examen",$_GET["id_examen"],"",$table,""); 
create_input("hidden","nommodule",$_GET["module"],"",$table,"");
create_input("hidden","nomparenttab",$_GET["parenttab"],"",$table,"");
?>
          <div class="box-body">


            <div class="form-group">
              <label for="inputEmail3" class="col-sm-2 control-label">Estado</label>
              <div class="col-sm-4">
                <?php crearselect("estado_idestado","select * from estado where idestado in('1','2') order by 2 desc",'class="form-control"',$data_servicio["estado"],""); ?>
              </div>
            </div>
            
            <div class="form-group">
              <label for="inputEmail3" class="col-sm-2 control-label">Categoria: <span style="color:red;">(*una vez creada la pregunta no se puede editar ) </span> </label>
              <div class="col-sm-4">
                <?php crearselect("id_cate","select * from categoria_examenes where estado_idestado=1 order by orden desc",'class="form-control"',$data_servicio["id_cate"],""); ?>
              </div>
            </div>

            <div class="form-group">
              <label for="inputPassword3" class="col-sm-2 control-label">Título</label>
              <div class="col-sm-8">
                <?php create_input("text","titulo",$data_servicio["titulo"],"form-control",$table,"",$agregado); ?>
              </div>
            </div>
						 <div class="form-group">
              <label for="inputPassword3" class="col-sm-2 control-label">Puntos</label>
              <div class="col-sm-8">
                <?php create_input("text","puntos",$data_servicio["puntos"],"form-control",$table,"",$agregado); ?>
              </div>
            </div>
						
						<div class="form-group">
							<label for="inputPassword3" class="col-sm-2 control-label">Descripción</label>
							<div class="col-sm-10">
								<?php create_input("textarea","descripcion",$data_servicio["descripcion"],"",$table,$agregado);  ?>
								<script>
								var editor11 = CKEDITOR.replace('descripcion');
								CKFinder.setupCKEditor( editor11, 'ckfinder/' );
								</script> 
							</div>
						</div>
					<div class="form-group">
						<label for="inputPassword3" class="col-sm-2 control-label">Imágen pregunta 1: tamaño max. 800px anxho * 400px alto</label>
						<div class="col-sm-6">
							<input type="file" name="imagen" id="imagen" class="form-control">
							<?php create_input("hidden","imagen_ant",$data_servicio["imagen"],"",$table,$agregado); 
								if($data_servicio["imagen"]!=""){ 
							?>
							<!-- 
								<img src="<?php echo "files/images/imagenes/".$data_servicio['id_examen']."/".$data_servicio["imagen"]; ?>" width="200" class="mgt15">
								-->
								<img src="<?php echo "files/images/imagenes/".$data_servicio["imagen"]; ?>" width="200" class="mgt15">
							<?php } ?> 
						</div>
					</div>
					
					<div class="form-group">
						<label for="inputPassword3" class="col-sm-2 control-label">Imágen pregunta adicional: tamaño max. 800px anxho * 400px alto</label>
						<div class="col-sm-6">
							<input type="file" name="imagen_pre_2" id="imagen_pre_2" class="form-control">
							<?php create_input("hidden","imagen_ant_pre",$data_servicio["imagen_pre_2"],"",$table,$agregado); 
								if($data_servicio["imagen_pre_2"]!=""){ 
							?>
							<!-- 
								-->
								<img src="<?php echo "files/images/imagenes/".$data_servicio["imagen_pre_2"]; ?>" width="200" class="mgt15">
							<?php } ?> 
						</div>
					</div>

<!-- ** SOLUCION -->
					<div class="form-group">
						<h3 STYLE="padding-top:35px;">SOLUCIÓN DE PREGUNTA: </h3>
					</div>
					<div class="form-group">
							<label for="inputEmail3" class="col-md-2 col-sm-2 control-label">SOLUCIÓN ES UN VIDEO?</label>				
							<div class="col-sm-3">
								<select id="solucion_es_video" name="solucion_es_video" class="form-control" requerid >  <!-- saco valor desde la BD -->
									<option value="2"  <?php echo ($data_servicio['solucion_es_video'] == 2) ? 'selected' : '' ;?>>NO</option>
									<option value="1" <?php echo ($data_servicio['solucion_es_video'] == 1) ? 'selected' : '' ;?>>SI</option>  
								</select>
							</div>
						</div>
					 <div class="form-group">
              <label for="inputPassword3" class="col-sm-2 control-label">Solución:</label>
              <div class="col-sm-8">
                <?php create_input("textarea","solucion",$data_servicio["solucion"],"form-control lleva_link_vimeo",$table,"",$agregado); ?>
								<iframe frameborder="0" width="100%" height="200" class="video_vimeo "></iframe>
              </div>
            </div>
					<div class="form-group">
						<label for="inputPassword3" class="col-sm-2 control-label">Imágen solución: tamaño max. 800px anxho * 400px alto</label>
						<div class="col-sm-6">
							<input type="file" name="imagen2" id="imagen2" class="form-control">
							<?php create_input("hidden","imagen_ant2",$data_servicio["imagen2"],"",$table,$agregado); 
								if($data_servicio["imagen2"]!=""){ 
							?>
								<img src="<?php echo "files/images/imagenes/".$data_servicio["imagen2"]; ?>" width="200" class="mgt15">
							<?php } ?> 
						</div>
					</div>
               
								
          </div>
              <div class="box-footer">
                <div class="form-group">
                  <div class="col-sm-10 pull-right">
                    <input  type="submit"  class="btn bg-blue btn-flat" id="btnguardar" value="Guardar">
                    <button type="button" class="btn bg-red btn-flat" onclick="javascript:gotourl('<?php echo $link_examen; ?>');">Cancelar</button>
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
</script>	
        </form>
      </div><!-- /.box -->
    </div><!--/.col (right) -->
  </div>
</section><!-- /.content -->
<script type="text/javascript">
var customValidate = {
      rules:{
        titulo:{required:true}
      }
    };
</script>
<?php
}elseif($_GET["task"]=='drop' || $_GET["task"]=='dropselect'){
  $bd = new BD;
  $bd->Begin();
  $id_pregunta = !isset($_GET['id_pregunta']) ? implode(',', $_GET['chkDel']) : $_GET['id_pregunta'];
  
	$sql="SELECT * FROM preguntas WHERE id_pregunta IN(".$id_pregunta.")";
	// echo $sql;
	
	$id_curso2 = executesql($sql);
  if(!empty($id_curso2)){
    foreach($id_curso2 as $row2){
      $pfile1 = 'files/images/imagenes/'.$row2['imagen'];
     // if(file_exists($pfile1) && !empty($row2['imagen'])){ unlink($pfile1); }   // no elimino al alctualizar porque puede etasr siendo usada en banco de pregunta o en clonacion    
			
			$pfile2 = 'files/images/imagenes/'.$row2['imagen2'];
     //  if(file_exists($pfile2) && !empty($row2['imagen2'])){ unlink($pfile2); }    // no elimino al alctualizar porque puede etasr siendo usada en banco de pregunta o en clonacion    
    }
  }
  $sql_delete="DELETE FROM preguntas WHERE id_pregunta IN(".$id_pregunta.")";
	// echo $sql_delete;
	
	$bd->actualiza_($sql_delete);
  $bd->Commit();
  $bd->close();


}elseif($_GET["task"]=='actualizar_puntaje_total'){
  $bd = new BD;
  $bd->Begin();
  $id_examen = $_GET['id_examen'];

  $_POST['puntos'] = $_GET['puntaje'];
  $campos = array('puntos');

  $bd->actualiza_(armaupdate('preguntas',$campos," id_examen='".$id_examen."'",'POST'));
  $bd->Commit();
  $bd->close();

}elseif($_GET["task"]=='actualizar_puntaje'){
  $bd = new BD;
  $bd->Begin();
  $id_pregunta = $_GET['id_pregunta'];

  $_POST['puntos'] = $_GET['puntaje'];
  $campos = array('puntos');

  $bd->actualiza_(armaupdate('preguntas',$campos," id_pregunta='".$id_pregunta."'",'POST'));
  $bd->Commit();
  $bd->close();

}elseif($_GET["task"]=='uestado'){
  $bd = new BD;
  $bd->Begin();
  $id_pregunta = !isset($_GET['id']) ? $_GET['estado_idestado'] : $_GET['id'];
  $id_pregunta = is_array($id_pregunta) ? implode(',',$id_pregunta) : $id_pregunta;
  $preguntas = executesql("SELECT * FROM preguntas WHERE id_pregunta IN (".$id_pregunta.")");
  if(!empty($preguntas))
    foreach($preguntas as $reg => $item)
      if ($item['estado_idestado']==1) {
        $state = 2;
      }elseif ($item['estado_idestado']==2) {
        $state = 1;
      }
  $bd->actualiza_("UPDATE preguntas SET estado_idestado=".$state." WHERE id_pregunta=".$id_pregunta."");
  echo $state;
  $bd->Commit();
  $bd->close();
	
}elseif($_GET["task"]=='finder'){
  $sql = "SELECT cv.*, ld.titulo as examen, e.nombre AS estado, cat.titulo as categoria 
               FROM preguntas cv 
										LEFT JOIN categoria_examenes cat ON cv.id_cate = cat.id_cate  
										INNER JOIN examenes ld ON ld.id_examen=cv.id_examen  
										INNER JOIN estado e ON cv.estado_idestado=e.idestado   
									WHERE cv.id_examen =".$_GET['id_examen']. "  and cv.estado_idestado=1  "; 
									
  if(!empty($_GET['criterio_mostrar'])) $porPagina=$_GET['criterio_mostrar'];

  // if(!empty($_GET['criterio_mostrar'])) $porPagina=15;
  


  if(!empty($_GET['criterio_usu_per'])){
    $stringlike=fn_filtro(substr($_GET['criterio_usu_per'], 0, 16));
    $sql.= " AND ( cv.titulo LIKE '%".$stringlike."%' or ld.titulo LIKE '%".$stringlike."%' or cv.id_pregunta LIKE '%".$stringlike."%' )";
  }
  
  if(!empty($_GET['criterio_ordenar_por'])) $sql.= sprintf(" order by %s %s", fn_filtro($_GET['criterio_ordenar_por']), fn_filtro($_GET['criterio_orden']));
  // $sql.= " ORDER BY cv.orden_en_examen ASC";
  $sql.= " ORDER BY cv.id_pregunta ASC";

  // echo $sql;
  
  $paging = new PHPPaging;
  $paging->agregarConsulta($sql); 
  $paging->div('div_listar');
  $paging->modo('desarrollo'); 
  $numregistro=1; 
  if($numregistro) $paging->porPagina(fn_filtro((int)$numregistro));
  $paging->verPost(true);
  $mantenerVar=array("id_examen","criterio_mostrar","task","criterio_usu_per","criterio_ordenar_por","criterio_orden");
  $paging->mantenerVar($mantenerVar);
  $paging->porPagina(fn_filtro((int)$porPagina));
  $paging->ejecutar();
  $paging->pagina_proceso="preguntas.php";
?>
<table id="example1" class="table table-bordered table-striped">
  <thead>
    <tr role="row">
      <th class="sort" >ID</th>
      <th class="sort" >PREGUNTA</th>
			<!-- 
      <th class="sort">EXAMEN</th>
			-->
      <th class="sort" style="width:60px;">categoria</th>
      <th class="sort" style="width:60px;">PTOS</th>
			<!-- 
      <th class="sort cnone">ACTUALIZAR PUNTAJE</th>
			-->
      <th class="unafbe " style="width:150px;">MIGRAR</th>
      <th class="unafbe " style="width:150px;">Opciones</th>
    </tr>
  </thead>
  <tbody id="sort">
<?php $i=0;
while ($detalles = $paging->fetchResultado()): 
	$i++;
?>
    <tr>
      <td><?php echo $detalles["id_pregunta"]; ?></td>
      <td>
			<?php echo '<p><big>'. '<b>Pregunta '.$i.'.</b> '.$detalles["titulo"].'</big></p> '; ?> 

			<?php echo (!empty($detalles["descripcion"]) )?'<div style="padding:12px 0;">'. '<b>Descripción </b> </br> '.$detalles["descripcion"].'</div> ':' '; ?>
			<?php 
					if( !empty($detalles["imagen"]) ){ 
							echo "<figure class='img_pregunta ' style='padding-top:10px;'><img src='files/images/imagenes/".$detalles["imagen"]."'></figure>";
					} 
					if( !empty($detalles["imagen_pre_2"]) ){ 
							echo "<figure class='img_pregunta ' style='padding-top:15px;'><img src='files/images/imagenes/".$detalles["imagen_pre_2"]."'></figure>";
					} 
			?>
			
			<!-- Respueats -->
			<?php 
      /* ocultdo 20-'05-2024 -Z para que carge mas rapido 
				$rptas=executesql(" select * from respuestas where id_pregunta='".$detalles["id_pregunta"]."' ");
				if( !empty($rptas) ){ 
          $y=0;
					echo "<p style='padding:15px 0;'><b>Respuestas:</b></p> <div class='listado_rptas' style='padding-bottom:5px;margin-bottom:20px;border-bottom:2px solid #333;' >";
					
					foreach($rptas as $date){
							$y++; 
						?>
							<p style="padding-bottom:9px;position:relative;padding-left:16px;" >
								<?php if( ($date["estado_rpta"] == 1) ){ 
												echo '<span style="background:green;height:10px;width:10px;border-radius:50%;left:0;top:7px;position:absolute;"></span>';
											}else{
												echo '<span style="background:red;height:10px;width:10px;border-radius:50%;left:0;top:7px;position:absolute;"></span>';
											}	
										
										echo '<b>'.$y.'.</b> '.$date["titulo"]; ?>
							</p>
						<?php 
					} // end for
					echo "</div> <!-- list rptas -->";
				}

        */
			?>
			
			</td>
			<!-- 
      <td><?php echo $detalles["examen"]; ?></td>
			-->
      <td><?php echo $detalles["categoria"]; ?></td>
      <td><?php echo $detalles["puntos"]; ?></td>
			<!-- 
      <td class="cnone"><a href="javascript: actualizar_puntaje('<?php echo $detalles["id_pregunta"]; ?>')">Actualizar</a></td>
			-->

      <td class=" cnone ">
          <div class="btn-eai  text-center btns btr  ">				
            <?php if($detalles["origen_en"]==2) {  
                    $sql_xd = " select * from respuestas where id_pregunta=".$detalles["id_pregunta"]." and estado_idestado=1   "; 
                    $tiene_preguntas = executesql($sql_xd);
                    // echo count($tiene_preguntas); 
                    if( !empty($tiene_preguntas) && count($tiene_preguntas) >= 2 ){
            ?>
                <button type="button" class=" btn_envivo " style="background:blue;color:#fff;" data-toggle="modal" data-target="<?php echo '#image_'.$detalles["id_pregunta"];  ?>" > 
                  migrar a banco
                </button>
            <?php   }
                  }  
            ?>
          </div>
      </td>
            
      <!--  Btn en migrar pregunta  -->	
      <div id="<?php echo 'image_'.$detalles['id_pregunta']; ?>" class="modal  bd-example-modal-lg  modal_images modal_images_practico " tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display:none;">
        <div class="modal-dialog modal-lg">
          <div class="modal-content text-center">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLongTitle"><b>Migrar pregunta hacia el Banco de pregunta: </b> </h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top:-20px;">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            
            <fieldset>				
              <div class="box-footer">
                  <label for="" class="col-md-12  control-label  rpta_envivo hide" style="color:green;font-weigth:800;font-size:16px;line-height:22px;padding:30px 0 90px;">..</label>
                  <div class="col-sm-12 pull-center">
                    <a  href="javascript:_add_insertar_pregunta_desde_examen_a_banco(<?php echo $detalles['id_pregunta']; ?>);" class="btn bg-blue btn-flat <?php echo 'btnguardar_envivo_'.$detalles['id_pregunta']; ?> " >OK MIGRAR</a>
                    <button type="button" class="btn bg-red btn-flat" data-dismiss="modal" aria-label="Close" >Cerrar</button>
                  </div>
              </div>
            </fieldset>
                          
          </div>
        </div>
      </div>								
      <!--  Btn en vivo -->		
      <!--  Btn en migrar pregunta  -->	



      <td>
        <div class="btn-eai btns btr  text-center "  style="width:150px;" >
          <a href="<?php echo $_SESSION["base_url"].'&task=edit&id_pregunta='.$detalles["id_pregunta"]; ?>" title="Editar" 
					style="color:#fff;"> editar</a>
					
					<a href="index.php?page=respuestas&id_examen=<?php echo $detalles['id_examen']; ?>&id_pregunta=<?php echo $detalles['id_pregunta']; ?>&module=<?php echo $_GET['module']; ?>&parenttab=<?php echo $_GET['parenttab']; ?>"  style="color:#fff;" title="ver Respuestas">
						 <span> rptas</span>
					</a> 	
          <?php  if( $detalles["estado_idestado"] ==1){ ?>	 					
          <a href="javascript: fn_estado('<?php echo $detalles["id_pregunta"]; ?>')" style="background:red;"><i class="fa fa-trash-o"></i></a>
          <?PHP } ?>

			<?php  if($_SESSION["visualiza"]["idtipo_usu"] ==1){ ?>	 					
        <!-- 
					<a href="javascript: fn_eliminar('<?php echo $detalles["id_pregunta"]; ?>')" style="background:red;"><i class="fa fa-trash-o"></i></a>
      -->
				 <?php } ?> 									

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
  // reordenar('preguntas.php');
});
var mypage = "preguntas.php";
</script>
<?php }else{ ?>
<div class="box-body">
  <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
    <form action="javascript: fn_buscar();" id="frm_buscar" name="frm_buscar">
      <input type="hidden" name="id_examen" value="<?php echo $_GET['id_examen']; ?>">
      <input type="hidden" name="module" value="<?php echo $_GET['module']; ?>">
      <input type="hidden" name="parenttab" value="<?php echo $_GET['parenttab']; ?>">
      <div class="bg-gray-light">      
        <div class="col-sm-12" style="padding-bottom:20px;">
          <?php  
						 $sql_x=" select p.*, x.titulo as examen, x.total_preguntas from preguntas p INNER JOIN examenes x ON p.id_examen=x.id_examen where p.id_examen='".$_GET["id_examen"]."' and p.estado_idestado=1  "; 
						$datoscurso=executesql($sql_x);
						// $volver_al_curso="index.php?page=examenes&module=".$_GET["module"]."&parenttab=".$_GET["parenttab"]."";

						echo "<h3 style='margin:0;' ><small> <b style='color:#333;'>Preguntas :</b> </small></h3>";
					?>
						<h3 style='margin-top:0;padding-top:0;padding-bottom:10px;' ><small> <b style='color:#555;'><a href="index.php?page=examenes&module=<?php echo $_GET["module"]; ?>&parenttab=<?php echo $_GET["parenttab"]; ?>">EXAMEN</b> </a>: <?php echo $datoscurso[0]["id_examen"].' - '.$datoscurso[0]["examen"];?>  </small></h3>
						<?php  
							$total_preguntas=0;
							$total_puntos=0;
							foreach($datoscurso as $npreguntas){ 
								if($npreguntas['estado_idestado'] == 1){ $total_preguntas++;} // cuento preguntas habiles 
								if($npreguntas['puntos'] >0 ){ $total_puntos=$total_puntos + $npreguntas['puntos'] ;} // cuento preguntas habiles 
							}
						?>
						<p><b># preguntas: </b><?php echo $total_preguntas; ?></p>
						<p><b>Total puntos: </b><?php echo $total_puntos; ?></p>
        </div>
				
				<div class="col-sm-2 ">
          <div class="btn-eai">
					<?php 
						 if(empty($datoscurso) || ($total_preguntas <  $datoscurso[0]["total_preguntas"]) ){ 
					?>
				<a href="<?php echo $link_examen."&task=new"; ?>" title="Agregar" style="color:#fff;"><i class="fa fa-file" style="padding-right:5px;"></i>Agregar</a> 
					<?php 
						}  // maximo de preuntas 20. 
					?> 
					
					</div>
        </div>
					<div class="col-md-2">
            <!--
						<div class="btn-eai">
							<a href="index.php?page=banco_preguntas_examenes&module=<?php echo $_GET["module"];?>&parenttab=<?php echo $_GET["parenttab"];?><?php echo '&task=edit&id_examen='.$_GET["id_examen"].'&id_especialidad='.$detalles["id_examen"]; ?>" style="color:#fff;"><span>Banco preguntas </span>
							</a>                  
						</div>
            -->
					</div>
          <div class="col-md-2">
            <div class="btn-eai">
              <a href="javascript: actualizar_puntaje_total('<?php echo $_GET["id_examen"]; ?>')" style="color:#fff;background:green;"><span>Actualizar puntaje </span>
              </a>                  
            </div>
          </div>
          <div class="col-sm-4 ">          
          <?php create_input('text','criterio_usu_per','',"form-control pull-right",$table,'placeholder="Buscar .."'); ?>
        </div>
        <div class="col-sm-1 hide ">          
          <?php select_sql("nregistros"); ?>
        </div>
				<!-- 
				-->
       <div class="col-sm-1 criterio_mostrar"><div class="btn-eai">            
						<a href="index.php?page=examenes&module=<?php echo $_GET["module"]; ?>&parenttab=<?php echo $_GET["parenttab"]; ?>" title="Regresar << " style="color:#fff;"> volver</a> 
          </div></div>
        <div class="break"></div>
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
var us = "pregunta";
var link = "pregunta";
var ar = "la";
var l = "a";
var l2 = "a";
var pr = "La";
var id = "id_pregunta";
var mypage = "preguntas.php";
</script>
<?php } ?>