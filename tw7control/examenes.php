<?php error_reporting(E_ALL ^ E_NOTICE);
include ("auten.php");

if($_GET["task"]=='neworden'){
  $bd=new BD;
  $orden_actual=$_GET["orden"];
  $orden_nuevo=$_GET["nuevoorden"];
  $tipo=$_GET["tipo"];  
  $id_del_registro_actual=$_GET["id_examen"];
  $criterio_Orden =" ";
  nuevoorden($orden_actual, $orden_nuevo, $tipo, $id_del_registro_actual, "examenes", "id_examen", $criterio_Orden);    
  $bd->close();

}elseif($_GET["task"]=='clonar_examen'){
  $bd=new BD;
  
  $array_categorias = explode(",", $_POST["categorias"]);
  $sql_preguntas_a_clonar= " select * from preguntas where id_examen='".$_POST["id_examen_clonado"]."' and id_cate IN  (".implode(',',$array_categorias).") and  estado_idestado=1 ORDER BY id_pregunta ASC ";

  $urlrewrite=armarurlrewrite($_POST["titulo_clonacion"]);
  $urlrewrite=armarurlrewrite($urlrewrite,1,"examenes","id_examen","titulo_rewrite",'');
  $_POST['idusuario']=$_SESSION["visualiza"]["idusuario"];
  $_POST["titulo"]=$_POST["titulo_clonacion"];
  $_POST["estado_idestado"]=1;// clonado
  $_POST["tipo_creacion"]=3;// clonado
  $_POST["fecha_registro"]= fecha_hora(2);// clonado
  $_POST['orden'] = _orden_noticia("","examenes","");

  $campos=array('titulo','idusuario','tipo_creacion','estado_idestado','orden');
  $_POST["id_examen"]=$bd->inserta_(arma_insert('examenes',array_merge($campos,array('fecha_registro')),'POST'));


  /**  clonamos preguntas , segun las categorias seleecionadadas */
  $preguntas_a_clonar= executesql($sql_preguntas_a_clonar);
  if( !empty($preguntas_a_clonar) ){
    $_POST['orden_en_examen']=0;

    foreach( $preguntas_a_clonar as $pregunta){
      /** clonando todas las opreguntas  */
      $_POST["titulo"]=$pregunta["titulo"];
      $_POST["titulo_rewrite"]=$pregunta["titulo_rewrite"];
      $_POST["descripcion"]=$pregunta["descripcion"];
      $_POST["puntos"]=$pregunta["puntos"];
      $_POST["imagen"]=$pregunta["imagen"];
      $_POST["imagen_pre_2"]=$pregunta["imagen_pre_2"];
      $_POST["imagen2"]=$pregunta["imagen2"];
      $_POST["solucion"]=$pregunta["solucion"];
      $_POST["solucion_es_video"]=$pregunta["solucion_es_video"];
      $_POST["estado_idestado"]=$pregunta["estado_idestado"];
      $_POST["fecha_registro"]= fecha_hora(2);
      $_POST["id_cate"]=$pregunta["id_cate"];
      $_POST["origen_en"]=3;
      //$_POST['orden'] = _orden_noticia("","preguntas","");
      $_POST['orden_en_examen']++;


      $campos_bancos=array('id_examen','id_cate','origen_en','titulo','titulo_rewrite','puntos','descripcion','imagen','imagen_pre_2','imagen2','solucion','solucion_es_video','fecha_registro','estado_idestado','orden_en_examen'); /*inserto campos principales*/            
      $rpta= $_POST["id_pregunta"]=$bd->inserta_(arma_insert('preguntas',$campos_bancos,'POST')); 
      if( $rpta > 0 ){

        // agregamos clonamos las respuestas de las preguntas clonadas 
        $respuestas=executesql(" select * from respuestas where id_pregunta=".$pregunta["id_pregunta"]." and estado_idestado=1  ");
        if( !empty($respuestas) ){
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
            $_POST['orden'] = _orden_noticia("","respuestas","");

                        
            $campos_respuestas=array('id_pregunta','titulo','titulo_rewrite','estado_rpta','fecha_registro','estado_idestado','orden'); // clono las respuestas a la nueva preguntas creada clonada 
         
            $bd->inserta_(arma_insert('respuestas',$campos_respuestas,'POST')); 

          }
        } // end respuestas

      } // end for pregunras      
    } // end preguntas clonada
    echo $rpta=1;

  }else{ // Si  se clono pero no teniap reguntas en las categorias seleccionadas 
    echo $rpta="99";
  }








}elseif($_GET["task"]=='insert' || $_GET["task"]=='update'){
  $bd=new BD;
  $where = ($_GET["task"]=='update') ? "and id_examen!='".$_POST["id_examen"]."'" : '';
  $urlrewrite=armarurlrewrite($_POST["titulo"]);
  $urlrewrite=armarurlrewrite($urlrewrite,1,"examenes","id_examen","titulo_rewrite",$where);

		$_POST['idusuario']=$_SESSION["visualiza"]["idusuario"];

	if( !isset($_POST['id_especialidad']) || empty($_POST['id_especialidad']) ){
		$_POST['id_especialidad']=0;
  }
	

	$_POST['fecha_actualizacion'] = fecha_hora(2);
	
  if( empty($_POST['fecha_cierre']) ){  $_POST['fecha_cierre'] = fecha_hora(2); }
  // $_POST['fecha_cierre'] = fecha_hora(2);

  if(empty($_POST['precio'])) $_POST['precio']='0.00'; 
	if(empty($_POST['costo_promo'])) $_POST['costo_promo']='0.00';

  $campos=array('id_cate','id_especialidad','privacidad','titulo', array('titulo_rewrite',$urlrewrite),'minutos','total_preguntas','cant_intentos','estado_examen','fecha_cierre','fecha_actualizacion','estado_idestado','precio','costo_promo','etiqueta','breve_detalle'); 
	
  if($_GET["task"]=='insert'){
    if(isset($_FILES['imagen']) && !empty($_FILES['imagen']['name'])){
      $_POST['imagen'] = carga_imagen('files/images/examenes/','imagen','','2','2');
      $campos = array_merge($campos,array('imagen'));
    }
		
    $_POST['orden'] = _orden_noticia("","examenes","");
    $_POST['fecha_registro'] = fecha_hora(2);
		

    // data para generar el examen aleatorio. 
    if( isset($_POST["tipo_creacion"]) && !empty($_POST["tipo_creacion"])){
          // $sacamos las preguntas aleatorias del banco
          $_aleatorios = array();

          if( !empty($_POST["n_preguntas_comprension"]) && $_POST["n_preguntas_comprension"] > 0 ){ //  primero comprension , luego RM
              $campos = array_merge($campos, array("n_preguntas_comprension") );
              $_aleatorios = array_merge($_aleatorios, array(  array("id_cate='199'", $_POST["n_preguntas_comprension"])  ));
          }
          
          if( !empty($_POST["n_preguntas_rm"]) && $_POST["n_preguntas_rm"] > 0 ){
              $campos = array_merge($campos, array("n_preguntas_rm") );
              $_aleatorios = array_merge($_aleatorios, array(  array("id_cate='198'", $_POST["n_preguntas_rm"])  ));
          }


          if( !empty($_POST["n_preguntas_conocimientos"]) && $_POST["n_preguntas_conocimientos"] > 0 ){
              $campos = array_merge($campos, array("n_preguntas_conocimientos") );
              $_aleatorios = array_merge($_aleatorios,array(  array("id_cate='200'", $_POST["n_preguntas_conocimientos"])  ));
          }
          /** END preguntas de arriba son fijas siempre iran  */

          /* INIT PREGUNTAS SEGUN ESPECIALIDAD DEL EXAMEN A VNDER MARCADO  */
          if( !empty($_POST["id_cate"]) && $_POST["n_preguntas_segun_especialidad"] > 0 ){

              if( $_POST["id_cate"] == 201 ){
                  $_POST["n_preguntas_inicial"] = $_POST["n_preguntas_segun_especialidad"]; 
                  $campos = array_merge($campos, array("n_preguntas_inicial") );
                  $_aleatorios = array_merge($_aleatorios, array(  array("id_cate='201'", $_POST["n_preguntas_inicial"])  ));

              }else if( $_POST["id_cate"] == 202 ){
                  $_POST["n_preguntas_primaria"] = $_POST["n_preguntas_segun_especialidad"]; 
                  $campos = array_merge($campos, array("n_preguntas_primaria") );
                  $_aleatorios = array_merge($_aleatorios, array(  array("id_cate='202'", $_POST["n_preguntas_primaria"])  ));
                  
              }else if( $_POST["id_cate"] == 203 ){
                  $_POST["n_preguntas_mate"] = $_POST["n_preguntas_segun_especialidad"]; 
                  $campos = array_merge($campos, array("n_preguntas_mate") );
                  $_aleatorios = array_merge($_aleatorios, array(  array("id_cate='203'", $_POST["n_preguntas_mate"])  ));


              }else if( $_POST["id_cate"] == 204 ){
                  $_POST["n_preguntas_comu"] = $_POST["n_preguntas_segun_especialidad"]; 
                  $campos = array_merge($campos, array("n_preguntas_comu") );
                  $_aleatorios = array_merge($_aleatorios, array(  array("id_cate='204'", $_POST["n_preguntas_comu"])  ));

              }else if( $_POST["id_cate"] == 205 ){
                  $_POST["n_preguntas_ingles"] = $_POST["n_preguntas_segun_especialidad"]; 
                  $campos = array_merge($campos, array("n_preguntas_ingles") );
                  $_aleatorios = array_merge($_aleatorios, array(  array("id_cate='205'", $_POST["n_preguntas_ingles"])  ));

              }else if( $_POST["id_cate"] == 206 ){
                  $_POST["n_preguntas_arte"] = $_POST["n_preguntas_segun_especialidad"]; 
                  $campos = array_merge($campos, array("n_preguntas_arte") );
                  $_aleatorios = array_merge($_aleatorios, array(  array("id_cate='206'", $_POST["n_preguntas_arte"])  ));

              }else if( $_POST["id_cate"] == 207 ){
                  $_POST["n_preguntas_religion"] = $_POST["n_preguntas_segun_especialidad"]; 
                  $campos = array_merge($campos, array("n_preguntas_religion") );
                  $_aleatorios = array_merge($_aleatorios, array(  array("id_cate='207'", $_POST["n_preguntas_religion"])  ));

              }else if( $_POST["id_cate"] == 208 ){
                  $_POST["n_preguntas_trabajo"] = $_POST["n_preguntas_segun_especialidad"];
                  $campos = array_merge($campos, array("n_preguntas_trabajo") );
                  $_aleatorios = array_merge($_aleatorios,array(  array("id_cate='208'", $_POST["n_preguntas_trabajo"])  )); 

              }else if( $_POST["id_cate"] == 209 ){
                  $_POST["n_preguntas_sociales"] = $_POST["n_preguntas_segun_especialidad"]; 
                  $campos = array_merge($campos, array("n_preguntas_sociales") );
                  $_aleatorios = array_merge($_aleatorios, array(  array("id_cate='209'", $_POST["n_preguntas_sociales"])  ));

              }else if( $_POST["id_cate"] == 210 ){
                  $_POST["n_preguntas_dpcc"] = $_POST["n_preguntas_segun_especialidad"]; 
                  $campos = array_merge($campos, array("n_preguntas_dpcc") );
                  $_aleatorios = array_merge($_aleatorios, array(  array("id_cate='210'", $_POST["n_preguntas_dpcc"])  ));

              }else if( $_POST["id_cate"] == 211 ){
                  $_POST["n_preguntas_tecno"] = $_POST["n_preguntas_segun_especialidad"]; 
                  $campos = array_merge($campos, array("n_preguntas_tecno") );        
                  $_aleatorios = array_merge($_aleatorios,array(  array("id_cate='211'", $_POST["n_preguntas_tecno"])  ));
              
              }else if( $_POST["id_cate"] == 212 ){
                  $_POST["n_preguntas_fisica"] = $_POST["n_preguntas_segun_especialidad"]; 
                  $campos = array_merge($campos, array("n_preguntas_fisica") );        
                  $_aleatorios = array_merge($_aleatorios,  array(  array("id_cate='212'", $_POST["n_preguntas_fisica"])  ));
              
              }else if( $_POST["id_cate"] == 213 ){
                  $_POST["n_preguntas_ept"] = $_POST["n_preguntas_segun_especialidad"]; 
                  $campos = array_merge($campos, array("n_preguntas_ept") );        
                  $_aleatorios = array_merge($_aleatorios,  array(  array("id_cate='213'", $_POST["n_preguntas_ept"])  ));
                  
              }else if( $_POST["id_cate"] == 214 ){
                  $_POST["n_preguntas_innova"] = $_POST["n_preguntas_segun_especialidad"]; 
                  $campos = array_merge($campos, array("n_preguntas_innova") );        
                  $_aleatorios = array_merge($_aleatorios,  array(  array("id_cate='214'", $_POST["n_preguntas_innova"])  ));
              
              
              }
          }
        
      

    }  // end examen aleatorio 
		

     // echo var_dump(arma_insert('examenes',array_merge($campos,array('fecha_registro','orden','idusuario')),'POST'));
     // exit();

    $_POST["id_examen"]=$bd->inserta_(arma_insert('examenes',array_merge($campos,array('fecha_registro','orden','idusuario')),'POST'));

    if( $_POST["id_examen"] > 0 && ( isset($_POST["tipo_creacion"]) && !empty($_POST["tipo_creacion"]) ) ){
      include("examenes_crear_algoritmo.php");
    }
		

  }else{

    if(isset($_FILES['imagen']) && !empty($_FILES['imagen']['name'])){
      $path = 'files/images/examenes/'.$_POST['imagen_ant'];
      if( file_exists($path) && !empty($_POST['imagen_ant']) ) unlink($path);    
      $_POST['imagen'] = carga_imagen('files/images/examenes/','imagen','','2','2');
      $campos = array_merge($campos,array('imagen'));
    }


    $bd->actualiza_(armaupdate('examenes',$campos," id_examen='".$_POST["id_examen"]."'",'POST'));/*actualizo*/
  }

  $bd->close();
  //gotoUrl("index.php?page=".$_POST["nompage"]."&module=".$_POST["nommodule"]."&parenttab=".$_POST["nomparenttab"]);
  gotoUrl("index.php?page=preguntas&id_examen=".$_POST["id_examen"]."&module=Examenes&parenttab=Examenes");

  
}elseif($_GET["task"]=='new' || $_GET["task"]=='edit'){
  if($_GET["task"]=='edit'){
     $data_producto=executesql("select * from examenes where id_examen='".$_GET["id_examen"]."'",0);
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
              <h3 class="box-title">Examenes </h3>
            </div>
<?php $task_=$_GET["task"]; ?>            
            <form id="registro" action="examenes.php?task=<?php echo ($task_=='edit') ?  "update" : "insert"; ?>" class="form-horizontal" method="POST" enctype="multipart/form-data" onsubmit="return aceptar()">
<?php 
if($task_=='edit') create_input("hidden","id_examen",$data_producto["id_examen"],"",$table,"");
create_input("hidden","urlfailed",basename($_SERVER['REQUEST_URI']),"",$table,"");  
create_input("hidden","urlgo",$link2,"",$table,"");
create_input("hidden","nompage",$_GET["page"],"",$table,""); 
create_input("hidden","nommodule",$_GET["module"],"",$table,"");
create_input("hidden","nomparenttab",$_GET["parenttab"],"",$table,"");
?>
              <div class="box-body  "  >
                <div class="form-group">
                  <label for="inputEmail3" class="col-md-2 col-sm-2 control-label">Estado</label>
                  <div class="col-sm-3">
                    <?php crearselect("estado_idestado","select * from estado where idestado in('1','2') order by 2 desc",'class="form-control"',$data_producto["estado_idestado"],""); ?>
                  </div>                  
                </div>

                <?php 
                if( isset($_GET["tipo_creacion"]) && !empty($_GET["tipo_creacion"]) ){    // si es aleatorio 
                  create_input("hidden","tipo_creacion",$_GET["tipo_creacion"],"",$table,"");
                } ?>


                
                <div class="form-group">
									<label for="inputPassword3" class="col-md-2 col-sm-2 control-label">Estado examen:</label>
									<div class="col-sm-3">
										<select id="estado_examen" name="estado_examen" class="form-control" requerid >  <!-- saco valor desde la BD -->
											<option value="1" <?php echo ($data_producto['estado_examen'] == 1) ? 'selected' : '' ;?>>Abierto</option>  
											<option value="2"  <?php echo ($data_producto['estado_examen'] == 2) ? 'selected' : '' ;?>>Cerrado</option>
										</select>
                  </div>
								</div>

                <div class="form-group">
                  <label for="inputEmail3" class="col-md-2 col-sm-2 control-label">Categoría Examen </label>
                  <div class="col-sm-3">
                    <?php crearselect("id_cate","select * from categoria_examenes where estado_idestado = 1 order by id_cate desc",'class="form-control"',$data_producto["id_cate"]," -- selecciona categoria examen --"); ?>
                  </div>                  
                </div>
								
								<div class="form-group">
									<label for="inputPassword3" class="col-md-2 col-sm-2 control-label">Privacidad del examen:</label>
									<div class="col-sm-3">
										<select id="privacidad" name="privacidad" class="form-control"  >  <!-- saco valor desde la BD -->
											<option value="1" <?php echo ($data_producto['privacidad'] == 1) ? 'selected' : '' ;?>>EXAMEN DE CURSO</option>  
											<option value="2" <?php echo ($data_producto['privacidad'] == 2) ? 'selected' : '' ;?>>GRAATUITOS (* gratis)</option>
											<option value="3" <?php echo ($data_producto['privacidad'] == 3) ? 'selected' : '' ;?>> PARA VENDER </option>
										</select>
									</div>
									
                  <div class="lleva_especialidad   ">
										<label for="inputEmail3" class="col-md-2 col-sm-2 control-label">ESPECIALIDADES</label>
										<div class="col-sm-3">
											<?php crearselect("id_especialidad","select * from especialidades where estado_idestado=1 order by titulo asc ",'class="form-control"',$data_producto["id_especialidad"]," --  seleecione solo si es  gratuito--"); ?>
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
                  <label for="inputPassword3" class="col-md-2 col-sm-2 control-label">breve_detalle</label>
                  <div class="col-sm-10">
                    <?php create_input("text","breve_detalle",$data_producto["breve_detalle"],"form-control",$table,"",$agregado); ?>
                  </div>
                </div>
								<div class="form-group">
                  <label for="inputPassword3" class="col-md-2 col-sm-2 control-label">Etiqueta</label>
                  <div class="col-sm-6">
                    <?php create_input("text","etiqueta",$data_producto["etiqueta"],"form-control",$table,"",$agregado); ?>
                  </div>
                </div>

								<div class="form-group">
                  <label for="inputPassword3" class="col-md-2 col-sm-2 control-label">intentos:</label>
                  <div class="col-sm-6">
                    <?php create_input("text","cant_intentos",$data_producto["cant_intentos"],"form-control",$table,"onkeypress='javascript:return soloNumeros_precio(event,0);' requerid ",$agregado); ?>
                  </div>
                </div>
								
								<div class="form-group">
                  <label for="inputPassword3" class="col-md-2 col-sm-2 control-label"># preguntas:</label>
                  <div class="col-sm-6">
                    <?php create_input("text","total_preguntas",$data_producto["total_preguntas"],"form-control",$table,"onkeypress='javascript:return soloNumeros_precio(event,0);' requerid ",$agregado); ?>
                  </div>
                </div>
								
								<div class="form-group">
                  <label for="inputPassword3" class="col-md-2 col-sm-2 control-label">Minutos:</label>
                  <div class="col-sm-6">
                    <?php create_input("text","minutos",$data_producto["minutos"],"form-control",$table,"onkeypress='javascript:return soloNumeros_precio(event,0);'",$agregado); ?>
                  </div>
                </div>
								
								<div class="form-group">
                  <label for="inputPassword3" class="col-md-2 col-sm-2 control-label">Fecha de cierre:</label>
                  <div class="col-sm-6">
                    <?php create_input("date","fecha_cierre",$data_producto["fecha_cierre"],"form-control",$table,"",$agregado); ?>
                  </div>
                </div>
                
                <div class="form-group">								
								<label for="inputPassword3" class="col-md-2 col-sm-2 control-label">Precio Ahora S/. (* oferta )</label>
								<div class="col-md-3 col-sm-3">
									<?php create_input("text","costo_promo",$data_producto["costo_promo"],"form-control",$table,"onkeypress='javascript:return soloNumeros_precio(event,2);'"); ?>
								</div>
							</div>
							
							<div class="form-group">					
								<label for="inputPassword3" class="col-md-2 col-sm-2 control-label">Precio normal S/. </label>
								<div class="col-md-2 col-sm-2">
									<?php create_input("text","precio",$data_producto["precio"],"form-control",$table,"onkeypress='javascript:return soloNumeros_precio(event,2);'"); /* el 2 permite poner  decmales */?> 
								</div>
							</div>
              
              <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Imagen: 										<span class="red">268px ancho * 212px alto</span></label> </label>
                  <div class="col-sm-6">
                    <input type="file" name="imagen" id="imagen" class="form-control">
                    <?php create_input("hidden","imagen_ant",$data_producto["imagen"],"",$table,$agregado); 
                      if($data_producto["imagen"]!=""){ 
                    ?>
                      <img src="<?php echo "files/images/examenes/".$data_producto["imagen"]; ?>" width="200" class="mgt15">
                    <?php } ?> 
                  </div>
                </div>

              <?php if( isset($_GET["tipo_creacion"]) && !empty($_GET["tipo_creacion"]) ){    // si es aleatorio  ?>
                <h3 style="font-weight:800;padding-top:25px;">Completa la cantidad de preguntas que tendra cada categoria:</h3>
                <div class="form-group">
                  <label for="inputPassword3" class="col-md-2 col-sm-2 control-label"># preguntas Razonamiento matemático:</label>
                  <div class="col-sm-6">
                    <?php create_input("text","n_preguntas_rm",$data_producto["n_preguntas_rm"],"form-control",$table,"onkeypress='javascript:return soloNumeros_precio(event,0);' ",$agregado); ?>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputPassword3" class="col-md-2 col-sm-2 control-label"># preguntas Comprensión Lectora:</label>
                  <div class="col-sm-6">
                    <?php create_input("text","n_preguntas_comprension",$data_producto["n_preguntas_comprension"],"form-control",$table,"onkeypress='javascript:return soloNumeros_precio(event,0);' ",$agregado); ?>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputPassword3" class="col-md-2 col-sm-2 control-label"># preguntas Conocimientos Pedagógicos:</label>
                  <div class="col-sm-6">
                    <?php create_input("text","n_preguntas_conocimientos",$data_producto["n_preguntas_conocimientos"],"form-control",$table,"onkeypress='javascript:return soloNumeros_precio(event,0);' ",$agregado); ?>
                  </div>
                </div>


              
                <div class="form-group">
                  <label for="inputPassword3" class="col-md-2 col-sm-2 control-label"># preguntas segun categoria  :</label>
                  <div class="col-sm-6">
                    <?php create_input("text","n_preguntas_segun_especialidad",'',"form-control",$table,"onkeypress='javascript:return soloNumeros_precio(event,0);' ",$agregado); ?>
                  </div>
                </div>
               
                

              <?php } ?>

           
              </div>
              <div class="box-footer">
                <div class="form-group">
                  <div class="col-sm-10 pull-right">
                    <input  type="submit"  class="btn bg-blue btn-flat" id="btnguardar" value="Guardar">
                    <button type="button" class="btn bg-red btn-flat" onclick="javascript:gotourl('<?php echo $link2; ?>');">Cancelar</button>
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
        archivo:{ required:false,accept:'pdf,docs,doc,jpg,png' }
      }
    };
</script>
<?php 

}elseif($_GET["task"]=='drop' || $_GET["task"]=='dropselect'){  
  $bd = new BD;
  $bd->Begin();
  $id_examen = !isset($_GET['id_examen']) ? implode(',', $_GET['chkDel']) : $_GET['id_examen'];
  $examenes = executesql("SELECT * FROM preguntas WHERE id_examen IN(".$id_examen.")");
  if(!empty($examenes)){
    foreach($examenes as $row){
      $pfile = 'files/images/preguntas/'.$row['imagen'];  if(file_exists($pfile) && !empty($row['imagen'])){ unlink($pfile); }
      $pfile = 'files/images/preguntas/'.$row['imagen2'];  if(file_exists($pfile) && !empty($row['imagen2'])){ unlink($pfile); }
      $pfile = 'files/images/preguntas/'.$row['imagen_pre_2'];  if(file_exists($pfile) && !empty($row['imagen_pre_2'])){ unlink($pfile); }
			
			$bd->actualiza_("DELETE FROM respuestas WHERE id_pregunta IN(".$row['id_pregunta'].")");
    }
  }

  $bd->actualiza_("DELETE FROM preguntas WHERE id_examen IN(".$id_examen.")");
  $bd->actualiza_("DELETE FROM examenes WHERE id_examen IN(".$id_examen.")");
  $bd->Commit();
  $bd->close();

}elseif($_GET["task"]=='ordenar'){

  $bd = new BD;
  $_GET['order'] = array_reverse($_GET['order']);
  foreach ($_GET['order'] as $order => $item) {
    $orden = $orden + 1;
    $bd->actualiza_("UPDATE examenes SET orden= ".$orden." WHERE id_examen = ".$item."");
  }
  $bd->Commit();
  $bd->close();

}elseif($_GET["task"]=='uestado'){

  $bd = new BD;
  $bd->Begin();
  $id_examen = !isset($_GET['id_examen']) ? $_GET['estado_idestado'] : $_GET['id_examen'];
  $id_examen = is_array($id_examen) ? implode(',',$id_examen) : $id_examen;
  $examenes = executesql("SELECT * FROM examenes WHERE id_examen IN (".$id_examen.")");
  if(!empty($examenes))
    foreach($examenes as $reg => $item)
      if ($item['estado_idestado']==1) {
        $state = 2;
      }elseif ($item['estado_idestado']==2) {
        $state = 1;
      }
  $bd->actualiza_("UPDATE examenes SET estado_idestado=".$state." WHERE id_examen=".$id_examen."");
  echo $state;
  $bd->Commit();
  $bd->close();


}elseif($_GET["task"]=='finder'){
	$array= array();
	$meses=array('Jan'=>'Enero','Feb'=>'Febrero','Mar'=>'Marzo','Apr'=>'Abril','May'=>'Mayo','Jun'=>'Junio','Jul'=>'Julio','Aug'=>'Agosto','Sep'=>'Septiembre','Oct'=>'Octubre','Nov'=>'Noviembre','Dec'=>'Diciembre');
	
	$sql='';
		
			$sql = "SELECT  c.*, YEAR(c.fecha_registro) as anho, MONTH(c.fecha_registro) as mes, e.nombre as estado, ce.titulo as categoria,  u.nomusuario as usuario 
			FROM examenes c 
			LEFT join usuario u ON u.idusuario= c.idusuario 
			INNER JOIN estado e ON c.estado_idestado=e.idestado
			LEFT JOIN categoria_examenes ce ON ce.id_cate = c.id_cate 
      WHERE c.estado_idestado=1 
      "; 
			
			
			if(isset($_GET['criterio_mostrar'])) $porPagina=$_GET['criterio_mostrar'];
			if(isset($_GET['criterio_usu_per']) && !empty($_GET['criterio_usu_per'])){
				$stringlike=fn_filtro(substr($_GET['criterio_usu_per'], 0, 16));
				$sql.= " and  ( c.id_examen LIKE '%".$stringlike."%' or c.titulo LIKE '%".$stringlike."%'  )  ";
		 
		 // }else{
				// if( empty($_GET['fechabus_1']) && empty($_GET['fechabus_2']) ) {
					// $sql .= " AND DATE(c.fecha_registro) = '" . fecha_hora(1) . "'";
				// }
			}
			
			if( isset($_GET['privacidad']) && !empty($_GET['privacidad']) ) $sql.=" and c.privacidad='".$_GET["privacidad"]."' ";

			if( isset($_GET['id_cate']) && !empty($_GET['id_cate']) ) $sql.=" and c.id_cate='".$_GET["id_cate"]."' ";

			if(!empty($_GET['fechabus_1']) && !empty($_GET['fechabus_2'])) {
					$sql .= " AND DATE(c.fecha_registro)  BETWEEN  DATE('".$_GET['fechabus_1']."')  and DATE('".$_GET['fechabus_2']."')  ";		
			}
			if(isset($_GET['criterio_ordenar_por'])) $sql.= sprintf(" order by %s %s", fn_filtro($_GET['criterio_ordenar_por']), fn_filtro($_GET['criterio_orden']));
			$sql.= "  ORDER BY c.orden DESC   ";
			
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
			$paging->porPagina(100);
			$paging->ejecutar();
			$paging->pagina_proceso="examenes.php";
				
	
	
?>
            <table id="example1" class="table table-bordered table-striped">
              			<tbody id="sort">

<?php 

      $ultima_categoria_examen= executesql(" select * from categoria_examenes where estado_idestado=1 order by id_cate desc ");
      $id_ultima_categoria_examen= $ultima_categoria_examen[0]["id_cate"];


		while ($detalles = $paging->fetchResultado()): 
			if(!in_array(array('mes' => $detalles['mes'], 'anho' => $detalles['anho']), $array)){
				$array[] = array('mes' => $detalles['mes'], 'anho' => $detalles['anho']);
?>
				<tr class="lleva-mes">
					<td colspan="9"><h6><?php echo strtoupper(strtr(date('M Y',strtotime($detalles['fecha_registro'])),$meses)); ?></h6></td>
				</tr>							
							
                <tr role="row"> 
                  <th class="sort">DÍA </th>                
                  <th class="sort">COD. </th>
                  <th class=" ">EXAMEN </th>
                  <th class="sort cnone ">PRIVACIDAD </th>
                  <th class="sort cnone ">CATEGORÍA </th>
                  <th class="sort cnone ">intentos</th>                
                  <th class="sort"># ¿? </th>                
                  <th class="sort cnone ">MIN </th>                
                  <th class="sort cnone ">CIERRE </th>                
                  <th class="sort cnone ">STATUS </th>                
                  <th class="sort cnone" width="60">ESTADO</th>
                  <th class="unafbe cnone ">USUARIO</th>
                  <th class="unafbe btn_varios">Opciones</th>
                </tr>
<?php }//if meses ?>
								<tr>
									<td><?php echo !empty($detalles['fecha_registro']) ? date('d',strtotime($detalles['fecha_registro'])) : '...'; ?></td>
                  <td><?php echo $detalles["id_examen"]; ?></td>
                  <td><?php echo $detalles["titulo"]; ?></td>
                  <td class="sort cnone " >
                      <?php 
                      if($detalles["privacidad"]==1){
                        ECHO 'EXAMEN DE CURSO';
                      }else if($detalles["privacidad"]==2){
                        ECHO 'GRATUITOS';
                      }else if($detalles["privacidad"]==3){
                        ECHO "PARA VENDER";
                      } 
                       ?>
                    </td>
                  <td class="sort cnone " ><?php echo $detalles["categoria"]; ?></td>
                  <td class="sort cnone " ><?php echo $detalles["cant_intentos"]; ?></td>
                  <td><?php echo $detalles["total_preguntas"]; ?></td>                                 
                  <td class="sort cnone " ><?php echo $detalles["minutos"]; ?></td>                                 
                  <td class="sort cnone " ><?php echo $detalles["fecha_cierre"]; ?></td>                                 
                  <td class="sort cnone " ><?php echo ($detalles["estado_examen"]==1)?'ABIERTO':'CERRADO'; ?></td>                                 
                                                 
                  <td class="cnone"><a href="javascript: fn_estado('<?php echo $detalles["id_examen"]; ?>')"><?php echo $detalles["estado"]; ?></a></td>
                  <td class="sort cnone " ><?php echo $detalles["usuario"]; ?></td>                                 
                  <td>
                    <div class="btn-eai  text-center btns btr   btn_varios ">				
											<a href="index.php?page=examenes&module=Ver&parenttab=examenes
												<?php echo $_SESSION["base_url"].'&task=edit&id_examen='.$detalles["id_examen"]; ?>" style="color:#fff;"><i class="fa fa-edit"></i> <span>editar</span>
											</a> 
											<a href="index.php?page=preguntas&id_examen=<?php echo $detalles['id_examen']; ?>&module=<?php echo $_GET['module']; ?>&parenttab=<?php echo $_GET['parenttab']; ?>"  style="color:#fff;" title="Agregar preguntas">
												<i class="fa fa-eye"></i> <span> preguntas</span>
											</a> 	
											
                      <button type="button" class=" btn_envivo " style="background:purple;margin:0 7px;" data-toggle="modal" data-target="<?php echo '#image_'.$detalles["id_examen"];  ?>" > 
                        <b>CLONAR</b>
											</button>
											
										<?php  if($_SESSION["visualiza"]["idtipo_usu"] ==1){ ?>
                      <a href="javascript: fn_eliminar('<?php echo $detalles["id_examen"]; ?>')"><i class="fa fa-trash-o"></i></a>
										<?php } ?> 
											
                    </div>
                  </td>


<!--  Btn en flkotante cocloanr examne  -->		
<div id="<?php echo 'image_'.$detalles['id_examen']; ?>" class="modal  bd-example-modal-lg  modal_images modal_images_practico " tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display:none;">
  <div class="modal-dialog modal-lg"><div class="modal-content text-center">
					  <!-- jQuery 2.1.4 -->
    <script src="dist/js/jQuery-2.1.4.min.js"></script>
    <!-- SCRIPTS -->
    <script src="dist/js/jquery-ui.js"></script>
    <script src="dist/js/app.min.js"></script>
    <script src="dist/js/bootstrap.min.js"></script>
    <script src="dist/js/functions.js?ud=1713481449"></script>
    
          <div class="modal-header">
						<h5 class="modal-title" id="exampleModalLongTitle"><b>CLONANDO EXAMEN : </b>  <?php echo $detalles["id_examen"]; ?> - <?php echo $detalles["titulo"]; ?></h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top:-20px;"><span aria-hidden="true">&times;</span></button>
					</div>
            <?php 
              $titulo_clonado= "titulo_".$detalles['id_examen'];  
            ?>                           
						<div class="form-group data_curso_en_vivo text-left " style=" max-width:800px;background: #efefef;padding: 20px;border-radius: 6px;margin-bottom:25px;">							
              
                  <?php create_input('hidden','task',"task_clonar_examen","form-control pull-right",'',''); ?>
                  <?php create_input('hidden','id_examen_a_clonar',$detalles['id_examen'],"form-control pull-right",'',''); ?>

                  <div class="col-sm-12 ">
                    <label for="inputPassword3" class="col-md-12  control-label">Titulo del nuevo examen:  </label>
                    <div class="col-sm-12">
                      <input type="text" name="<?php echo $titulo_clonado; ?>" id="<?php echo $titulo_clonado; ?>"  required class="form-control ">
                    </div>
                    <h4 STYLE=" padding:20px 15px 5px;display:flex;">Selecciona la categorias de las preguntas a clonar: </h4>
                  </div>

            <?php $act=executesql("select id_cate, titulo from categoria_examenes  where estado_idestado='1' ORDER BY  orden desc  "); 
                  if(!empty($act)){ 
                    foreach($act as $acti){ 
            ?>
                  <div class="col-sm-12" style="padding:0 50px ;">
                    <input type="checkbox" name="categorias_<?php echo $detalles["id_examen"]; ?>[]" value="<?php echo $acti["id_cate"];?>" id="checkbox_<?php echo $detalles["id_examen"]; ?>-<?php echo $acti["id_cate"]; ?>" >
                    <label class="rel lleva_check " for="checkbox_<?php echo $detalles["id_examen"]; ?>-<?php echo $acti["id_cate"];?>" >
                      <?php echo $acti["titulo"];?>   -  <?php echo $acti["id_cate"];?>
                    </label>
                  </div>

            <?php			} 
                  }	
            ?>
							<!-- END categorias  -->																																
						</div>						
						<div class="box-footer">
								<label for="" class="col-md-12  control-label  rpta_envivo hide" style="color:green;font-weigth:800;font-size:16px;line-height:22px;padding:30px 0 90px;">..</label>
								<div class="col-sm-12 pull-center">
									<a  href="javascript:clonar_examen(<?php echo $detalles['id_examen']; ?>,<?php echo $id_ultima_categoria_examen; ?>);" class="btn bg-blue btn-flat " id="btn_clonar_<?php echo $detalles["id_examen"]; ?>">OK CLONAR</a> 									
									<button class="btn bg-red btn-flat" data-dismiss="modal" aria-label="Close" >Cerrar</button>
								</div>
						</div>		           
        <style>
          input [type="time"]{margin-bottom: 10px;}
          .lleva_check{cursor: pointer;}
          .data_curso_en_vivo  .col-sm-6{margin-bottom: 10px;}								
        </style>

    </div></div>
</div>								
<!--  Btn en clonar examen flotante  -->	


                </tr>
<?php endwhile; ?>
              </tbody>
            </table>
            <div class="pagination"><?php echo $paging->fetchNavegacion(); ?></div>
<script>
$(function(){
  // checked();
  // sorter();
  // reordenar('examenes.php');
});
var mypage = "examenes.php";
</script>

<?php }else{ ?>
        <div class="box-body">
          <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
            <form action="javascript: fn_buscar();" id="frm_buscar" name="frm_buscar">
							<input type="hidden" name="module" value="<?php echo $_GET["module"];?>">
							<input type="hidden" name="parenttab" value="<?php echo $_GET["parenttab"];?>">
              <div class="bg-gray-light">
                <div class="col-md-2">
                  <div class="btn-eai">
                    <a href="<?php echo $link2."&task=new"; ?>" style="color:#fff;"><i class="fa fa-file"></i> Agregar Manual</a>                    
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="btn-eai">
                    <a href="<?php echo $link2."&task=new&tipo_creacion=2"; ?>" style="color:#fff;background:green;"><i class="fa fa-file"></i> Crear aleatorio</a>                    
                  </div>
                </div>
							
                <div class="col-sm-2  criterio_buscar">                  
									<select id="privacidad" name="privacidad" class="form-control"  >  <!-- saco valor desde la BD -->
										<option value=""> -- tipo examen --</option>  
										<option value="2"> GRATIS</option>  
										<option value="1" > POR LA COMPRA DE CURSO</option>											
										<option value="3" > A LA VENTA</option>											
									</select>
								</div>	

                <div class="col-sm-3 criterio_buscar">
                  <?php create_input('text','criterio_usu_per','',"form-control pull-right",$table,'placeholder="Buscar .."'); ?>
                </div>
								  <div class="col-sm-2 criterio_buscar" style="padding-bottom:8px;">
											<?php crearselect("id_cate", "select id_cate, titulo from categoria_examenes where estado_idestado=1 order by titulo asc", 'class="form-control"  style="border:1px solid #CA3A2B;" ', '', " Filtra por categoria de examenes"); ?>
								</div>
								
								<!--
							  <div class="col-sm-7 criterio_mostrar">
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
								-->
								
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
var link = "examene";
var us = "examen";
var ar = "la";
var l = "a";
var l2 = "a";
var pr = "La";
var id = "id_examen";
var mypage = "examenes.php";
</script>

<?php } ?>