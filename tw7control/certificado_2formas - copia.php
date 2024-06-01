<?php
error_reporting(E_ALL ^ E_NOTICE);
include ("auten.php");

if($_GET["task"]=='insert' || $_GET["task"]=='update'){
  $bd=new BD;

	$where = ($_GET["task"]=='update') ? "and id_certificado!='".$_POST["id_certificado"]."'" : '';
	$urlrewrite=armarurlrewrite($_POST["titulo"]);
  $urlrewrite=armarurlrewrite($urlrewrite,1,"certificados","id_certificado","titulo_rewrite",$where);
	
	if(empty($_POST['precio'])) $_POST['precio']='0.00'; 
	if(empty($_POST['costo_promo'])) $_POST['costo_promo']='0.00';
	

  if(isset($_POST['cursos_dependientes'])){ // para la tabla certificados, el primer curso asigando entra aca, posision 0 
    echo $data_string = implode(',',$_POST['cursos_dependientes']); 
    $data_array_cursos = explode(',',$data_string); 

    $_POST["id_curso"] = !empty($data_array_cursos[0])? $data_array_cursos[0] : $data_array_cursos[1]; // esto solo sirve para asignar un curso referencial al certificado, ya que asi existen ventas antiguas a esta nueva version 19-07-2023

    echo '==>'.$_POST["id_curso"]; 

    // exit();

  
  }else{
    echo "Selecciona al menos un curso, para este certificado.. ";
    exit();
  }
  
  // $_POST["id_curso"] = 1;

  $_POST["id_tipo"]=1 ; // para cursos  genberales;

	// $campos=array('id_curso','titulo',array('titulo_rewrite',$urlrewrite),'detalle','precio','costo_promo','estado_idestado'); /*inserto campos principales*/
	$campos=array('id_tipo','id_curso','titulo',array('titulo_rewrite',$urlrewrite),'precio','costo_promo','estado_idestado','certificado_codigo','certificado_libro','certificado_fecha_inicio','certificado_fecha_fin','duracion'); /*inserto campos principales*/

  if($_GET["task"]=='insert'){
		if(isset($_FILES['imagen']) && !empty($_FILES['imagen']['name'])){
      $_POST['imagen'] = carga_imagen('files/images/certificados/','imagen','','1062','760');
      $campos = array_merge($campos,array('imagen'));
    }
		
    if(isset($_FILES['imagen_silabo']) && !empty($_FILES['imagen_silabo']['name'])){
      $_POST['imagen_silabo'] = carga_imagen('files/images/certificados/','imagen_silabo','','1684','1164');
      $campos = array_merge($campos,array('imagen_silabo'));
    }
		
		$_POST['orden'] = 1;
    $_POST['fecha_registro'] = fecha_hora(2);
		$campos=array_merge($campos,array('orden','fecha_registro'));
		
		// echo var_dump(arma_insert('certificados',$campos,'POST'));
		// exit();
		


    $insertado = $_POST["id_certificado"] =$bd->inserta_(arma_insert('certificados',$campos,'POST'));/*inserto hora -orden y guardo imag*/
		
		if($insertado > 1){
			/* reviso si certificados x _ clientes con este id_curso y id_certificado */

			
		} // end insertado 1 
		
 
 }else{
		 if(isset($_FILES['imagen']) && !empty($_FILES['imagen']['name'])){
      $path = 'files/images/certificados/'.$_POST['imagen_ant'];
      if( file_exists($path) && !empty($_POST['imagen_ant']) ) unlink($path);    
      $_POST['imagen'] = carga_imagen('files/images/certificados/','imagen','','1062','760');
      $campos = array_merge($campos,array('imagen'));
    }
		
    if(isset($_FILES['imagen_silabo']) && !empty($_FILES['imagen_silabo']['name'])){
      $path = 'files/images/certificados/'.$_POST['imagen_ant2'];
      if( file_exists($path) && !empty($_POST['imagen_ant2']) ) unlink($path);    
      $_POST['imagen_silabo'] = carga_imagen('files/images/certificados/','imagen_silabo','','1684','1164');
      $campos = array_merge($campos,array('imagen_silabo'));
    }


    $bd->actualiza_(armaupdate('certificados',$campos," id_certificado='".$_POST["id_certificado"]."'",'POST'));/*actualizo*/
  }


  $bd->actualiza_("DELETE FROM certificados_x_cursos WHERE id_certificado='".$_POST["id_certificado"]."'");
  // echo '+'.$_POST['cursos_dependientes'];
  if(isset($_POST['cursos_dependientes'])){
    $data_string= implode(',',$_POST['cursos_dependientes']);  // como llega en una linea, lo comnvierto a string 
    $data_array_cursos =explode(',',$data_string);   // ese string lo convierto a un array separado  (antes estaba en conjunto )
    // echo var_dump($data_array_cursos);
    $longitud_cursos_asignar = count($data_array_cursos);							

    for($i=0; $i<$longitud_cursos_asignar; $i++){
          //saco el valor de cada elemento      
          $_POST["id_curso"] = $data_array_cursos[$i];
          $_POST['orden'] = 1;
          $_POST['estado_idestado']=1;
          $_POST['fecha_registro']=  fecha_hora(2);        
                    
          $campos_detalle=array('id_certificado','id_curso','fecha_registro','orden','estado_idestado'); 
          // echo var_dump(arma_insert("linea_pedido",$campos_detalle,"POST"));
          // exit();
          $bd->inserta_(arma_insert("certificados_x_cursos",$campos_detalle,"POST"));          
    }
	}


  $bd->close();
  gotoUrl("index.php?page=".$_POST["nompage"]."&id_curso=".$_POST["id_curso"]."&module=".$_POST["nommodule"]."&parenttab=".$_POST["nomparenttab"]);
	


}elseif($_GET["task"]=='new' || $_GET["task"]=='edit'){
  if($_GET["task"]=='edit'){
     $data_producto=executesql("select * from certificados where id_certificado='".$_GET["id_certificado"]."'",0);
  }
?>


<script type="text/javascript" src="js/buscar_curso_registro_certificado.js?ud=<?php echo $unix_date; ?>"></script>

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
					
          <h4 class="box-title"><?php echo ($_GET["task"]=="edit") ? 'Editar' : 'Agregando'; ?>Certificado para Cursos GENERALES:  </h4>
        </div><!-- /.box-header -->
<?php $task_=$_GET["task"]; ?>
        <!-- form start -->
        <form id="registro" action="certificado_2formas.php?task=<?php echo ($task_=='edit') ?  "update" : "insert"; ?>" class="form-horizontal" method="POST" enctype="multipart/form-data" onsubmit="return aceptar()">
<?php 
if($task_=='edit') create_input("hidden","id_certificado",$data_producto["id_certificado"],"",$table,"");
create_input("hidden","urlfailed",basename($_SERVER['REQUEST_URI']),"",$table,"");  
create_input("hidden","urlgo",$link_sesion,"",$table,"");
create_input("hidden","nompage",$_GET["page"],"",$table,""); 
create_input("hidden","id_curso",$_GET["id_curso"],"",$table,""); 
create_input("hidden","nommodule",$_GET["module"],"",$table,"");
create_input("hidden","nomparenttab",$_GET["parenttab"],"",$table,"");
?>
          <div class="box-body">
            <div class="form-group">
              <label for="inputEmail3" class="col-sm-2 control-label">Estado</label>
              <div class="col-sm-4">
                <?php crearselect("estado_idestado","select * from estado where idestado in('1','2') order by 2 desc",'class="form-control"',$data_producto["estado"],""); ?>
              </div>
            </div>
            <div class="form-group">
              <label for="inputPassword3" class="col-sm-2 control-label">Título</label>
              <div class="col-sm-8">
                <?php create_input("text","titulo",$data_producto["titulo"],"form-control",$table,"",$agregado); ?>
              </div>
            </div>
            <div class="form-group">
              <label for="inputPassword3" class="col-sm-2 control-label">certificado_codigo</label>
              <div class="col-sm-8">
                <?php create_input("text","certificado_codigo",$data_producto["certificado_codigo"],"form-control",$table,"",$agregado); ?>
              </div>
            </div>
            <div class="form-group">
              <label for="inputPassword3" class="col-sm-2 control-label">duracion horas : </label>
              <div class="col-sm-8">
                <?php create_input("text","duracion",$data_producto["duracion"],"form-control",$table,"",$agregado); ?>
              </div>
            </div>
            
            <div class="form-group">
              <label for="inputPassword3" class="col-sm-2 control-label">Libro: </label>
              <div class="col-sm-8">
                <?php create_input("text","certificado_libro",$data_producto["certificado_libro"],"form-control",$table,"",$agregado); ?>
              </div>
            </div>
            
            <div class="form-group">
              <label for="inputPassword3" class="col-md-2 col-sm-2 control-label"> Certificado fecha_inicio </label>
              <div class="col-sm-6">
                <?php create_input("text","certificado_fecha_inicio",$data_producto["certificado_fecha_inicio"],"form-control",$table,"",$agregado); ?>
              </div>
            </div>
								
				    <div class="form-group">
              <label for="inputPassword3" class="col-md-2 col-sm-2 control-label"> Certificado fecha_fin </label>
              <div class="col-sm-6">
                <?php create_input("text","certificado_fecha_fin",$data_producto["certificado_fecha_fin"],"form-control",$table,"",$agregado); ?>
              </div>
            </div>
							

            <?php /* 		
						<div class="form-group">
              <label for="inputPassword3" class="col-sm-2 control-label">Breve detalle</label>
              <div class="col-sm-6">
                <?php create_input("textarea","detalle",$data_producto["detalle"],"",$table,$agregado);  ?>
                
								</div>
              </div>
                */ ?>

					  <div class="form-group">
							<label for="inputPassword3" class="col-sm-2 control-label">Imagen fondo: </br>
								<span class="red">1062px ancho * 760px alto  </span>
							</label>
							<div class="col-sm-6">
								<input type="file" name="imagen" id="imagen" class="form-control">
								<?php create_input("hidden","imagen_ant",$data_producto["imagen"],"",$table,$agregado); 
									if($data_producto["imagen"]!=""){ 
								?>
									<img src="<?php echo "files/images/certificados/".$data_producto["imagen"]; ?>" width="200" class="mgt15">
								<?php } ?> 
							</div>
						</div>
								
					  <div class="form-group">
							<label for="inputPassword3" class="col-sm-2 control-label">Imagen Silabo: </br>
								<span class="red">120px ancho * 820px alto  </span>
							</label>
							<div class="col-sm-6">
								<input type="file" name="imagen_silabo" id="imagen_silabo" class="form-control">
								<?php create_input("hidden","imagen_ant2",$data_producto["imagen_silabo"],"",$table,$agregado); 
									if($data_producto["imagen_silabo"]!=""){ 
								?>
									<img src="<?php echo "files/images/certificados/".$data_producto["imagen_silabo"]; ?>" width="200" class="mgt15">
								<?php } ?> 
							</div>
						</div>
								
							<div class="form-group">
								<label for="inputPassword3" class="col-md-2 col-sm-2 control-label">Precio S/. </label>
								<div class="col-md-2 col-sm-2">
									<?php create_input("text","precio",$data_producto["precio"],"form-control",$table,"onkeypress='javascript:return soloNumeros_precio(event,2);'"); /* el 2 permite poner  decmales */?> 
								</div>
								
							</div>
							
							<div class="form-group">
								<label for="inputPassword3" class="col-md-2 col-sm-2 control-label">Precio promo S/.</label>
								<div class="col-md-3 col-sm-3">
									<?php create_input("text","costo_promo",$data_producto["costo_promo"],"form-control",$table,"onkeypress='javascript:return soloNumeros_precio(event,2);'"); ?>
								</div>
							</div>
						
              
              								
              <div class="form-group" style="  padding-left:40px;" >
													<label for="inputEmail3" class="col-sm-4 control-label" style="float:none;text-align:left;">Selecciona los Cursos asociados:</label>
													<label for="inputEmail3" class="col-sm-12 control-label" style="float:none;text-align:left;"></br> <small>Escribe el codigo o nombre del curso a vender y selecciona con un click</small> </br></br></label>
													
																						

													<div class="form-group" style="   " >
														<div class="col-sm-10 ">
															<label for="inputPassword3" class=" control-label">Buscar curso:</label>
															<?php 
															create_input("text","titulo_curso",$data_producto["titulo_curso"],"form-control",$table," autocomplete='off' onkeyup='autocompletar_curso_venta()' ",''); 	
															?>
															<ul id="listadobusqueda_curso_dependientes" class="no-bullet"></ul>
														</div>
													</div>

													<div class="form-group data_dependientes" style="   ">	
														<div class="col-sm-12 " style="background: #ddd;padding: 5px 10px 10px;border-radius: 6px;">
															<div class="col-sm-3">
																<label for="inputPassword3" class=" control-label">Tipo:</label>
                         
                            <?php //   ?>
                            
                           
                              <input name="cursos_dependientes[]" id="cursos_dependientes" type="hidden">

                                
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
                                  if($task_=='edit')  {                             
                              ?>
                                  <script>
                                    let array_edit = []; 
                                  </script>
                              <?php
                                    $sql_data=" select c.*, tp.titulo as tipo_curso , cxc.* 
                                    from certificados_x_cursos cxc 
                                    INNER JOIN cursos c ON cxc.id_curso=c.id_curso 
                                    INNER JOIN tipo_cursos tp ON c.id_tipo=tp.id_tipo
                                    where id_certificado='".$data_producto["id_certificado"]."' 
                                    order by tp.titulo asc,  c.titulo asc ";

                                    $cursos_depen_actuales=executesql($sql_data);

                                    if(!empty($cursos_depen_actuales)){
                                      $cursos_dependientes = '';
                                      $contador=0;
                                      $total_cursos = count($cursos_depen_actuales);


                                      foreach($cursos_depen_actuales as $depen){
                                        
                                        echo "<script>array_edit.push(". $depen["id_curso"].");</script>";
                                   
                                        /*
                                        if( $contador == 0){
                                          $cursos_dependientes .= $depen["id_curso"];
                                        }else if( $contador < $total_cursos ){
                                          $cursos_dependientes .= ','.$depen["id_curso"];

                                        }   
                                        */                                  

                                        echo '<div id="depen'.$depen["id_curso"].'" class="col-sm-12" style="margin-bottom:5px;background:#f1f1f1;"><div class="col-sm-3"><input type="text" id="nombre_curso"  name="nombre_curso" disabled class="form-control" value="'.$depen["tipo_curso"].' "></div><div class="col-sm-7"><input type="text" id="nombre_curso"  name="nombre_curso" disabled class="form-control" value="'.$depen["codigo"].'-'.$depen["titulo"].' "></div><div class="col-sm-2"><a class="quitar_depen" href="javascript:quitar_dependiente('.$depen["id_curso"].')">quitar</a></div>  </div>';

                                        $contador++;
                                      }

                                    }else{ 
                                      // echo "no tiene aun";
                                    }

                                  ?>
                                    <script>				// asignamos al array los id que ya tenia registrados 
                                      document.getElementById("cursos_dependientes").value=array_edit;
                                      console.log('Listando ides que ya tenia ');
                                      console.log(document.getElementById("cursos_dependientes").value);
                                    </script>
                                    <?php                                                                       

                                  } // end edit 
                              
                              ?>																								
														</div>		
                            
													</div> <!-- *contenedor general listado dependientes -->

								</div> <!--  ** end colapse de ventas -->
				
							
								
          </div>
              <div class="box-footer">
                <div class="form-group">
                  <div class="col-sm-10 pull-right">
                    <input  type="submit"  class="btn bg-blue btn-flat" id="btnguardar" value="Guardar">
                    <button type="button" class="btn bg-red btn-flat" onclick="javascript:gotourl('<?php echo $link_sesion; ?>');">Cancelar</button>
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
  $ide = !isset($_GET['id']) ? implode(',', $_GET['chkDel']) : $_GET['id'];
  $id_curso2 = executesql("SELECT video FROM detalle_certificados WHERE id_certificado IN(".$ide.")");
  if(!empty($id_curso2)){
    foreach($id_curso2 as $row2){
      $pfile2 = 'files/video/'.$row2['id_certificado'].'/'.$row2['video'];
      if(file_exists($pfile2) && !empty($row2['video'])){ unlink_sesion($pfile2); }
    }
  }
  $bd->actualiza_("DELETE FROM detalle_certificados WHERE id_certificado IN(".$ide.")");
  $bd->actualiza_("DELETE FROM certificados WHERE id_certificado IN(".$ide.")");
  $bd->Commit();
  $bd->close();

}elseif($_GET["task"]=='uestado'){
  $bd = new BD;
  $bd->Begin();
  $ide = !isset($_GET['id']) ? $_GET['estado_idestado'] : $_GET['id'];
  $ide = is_array($ide) ? implode(',',$ide) : $ide;
  $certificados = executesql("SELECT * FROM certificados WHERE id_certificado IN (".$ide.")");
  if(!empty($certificados))
    foreach($certificados as $reg => $item)
      if ($item['estado_idestado']==1) {
        $state = 2;
      }elseif ($item['estado_idestado']==2) {
        $state = 1;
      }
  $bd->actualiza_("UPDATE certificados SET estado_idestado=".$state." WHERE id_certificado=".$ide."");
  echo $state;
  $bd->Commit();
  $bd->close();
	



	
}elseif($_GET["task"]=='finder'){
		$sql = "SELECT cv.*,e.nombre AS estado , c.titulo as curso 
    FROM certificados cv 
    INNER JOIN cursos c ON cv.id_curso= c.id_curso  
    INNER JOIN estado e ON cv.estado_idestado=e.idestado 
				WHERE cv.estado_idestado != 100  and cv.id_tipo=1 
	"; 
  if(!empty($_GET['criterio_mostrar'])) $porPagina=$_GET['criterio_mostrar'];


  if( isset($_GET['criterio_usu_per']) && !empty($_GET['criterio_usu_per'])  ){
    $stringlike=fn_filtro(substr($_GET['criterio_usu_per'], 0, 16));
    $sql.= " AND (cv.titulo LIKE '%".$stringlike."%' or c.id_curso LIKE '%".$stringlike."%'  or c.titulo LIKE '%".$stringlike."%' or cv.id_certificado LIKE '%".$stringlike."%' )";
  }
  
	// $sql.= " AND cv.id_curso =".$_GET['id_curso'];

  if(!empty($_GET['criterio_ordenar_por'])) $sql.= sprintf(" order by %s %s", fn_filtro($_GET['criterio_ordenar_por']), fn_filtro($_GET['criterio_orden']));
	$sql.= " ORDER BY cv.id_certificado desc ";


  // echo $sql;
	
  $paging = new PHPPaging;
  $paging->agregarConsulta($sql); 
  $paging->div('div_listar');
  $paging->modo('desarrollo'); 
  $numregistro=1; 
  if($numregistro) $paging->porPagina(fn_filtro((int)$numregistro));
  $paging->verPost(true);
  $mantenerVar=array("id_curso","criterio_mostrar","task","criterio_usu_per","criterio_ordenar_por","criterio_orden");
  $paging->mantenerVar($mantenerVar);
  $paging->porPagina(fn_filtro((int)$porPagina));
  $paging->ejecutar();
  $paging->pagina_proceso="certificado_2formas.php";
?>
<table id="example1" class="table table-bordered table-striped">
  <thead>
    <tr role="row">
      <th class="unafbe" width="20"><input type="checkbox" id="chkDel" class="all"></th>
      <th class="sort">TITULO</th>
      
      <th class="sort">CODIGO</th>
      <th class="sort">LIBRO</th>
      <th class="sort">PRECIO</th>
      <th class="sort">PROMO</th>
      <th class="sort">CURSO</th>
      <th class="sort">#CURSOS</th>
      <th class="sort">IMAGEN</th>
      <th class="sort">IMG SILABO</th>
      <th class="sort cnone">ESTADO</th>
      <th class="unafbe ">Opciones</th>
    </tr>
  </thead>
  <tbody id="sort">
<?php while ($detalles = $paging->fetchResultado()): ?>
    <tr>
      <td><input type="checkbox" name="chkDel[]" class="chkDel" value="<?php echo $detalles["id_certificado"]; ?>"></td>
      <td><?php echo $detalles["id_certificado"].' - '.$detalles["titulo"]; ?></td>
      <td><?php echo $detalles["certificado_codigo"]; ?></td>
      <td><?php echo $detalles["certificado_libro"]; ?></td>
      <td><?php echo $detalles["precio"]; ?></td>
      <td><?php echo $detalles["costo_promo"]; ?></td>
      <td><?php echo $detalles["id_curso"].' - '.$detalles["curso"]; ?></td>
      <td><?php 
        $num_cursos_asociados=executesql(" select * from certificados_x_cursos where id_certificado='".$detalles["id_certificado"]."' ");
        echo  count($num_cursos_asociados);
      ?></td>
      <td class="cnone">
          <?php
           if( !empty( $detalles["imagen"])){
            echo "SI";

           }else{ 
            echo "NO";
            }
        ?>

      </td>
      <td class="cnone">
          <?php
           if( !empty( $detalles["imagen_silabo"])){
            echo "SI";

           }else{ 
            echo "NO";
            }
        ?>

      </td>
      <td class="cnone"><a href="javascript: fn_estado('<?php echo $detalles["id_certificado"]; ?>')"><?php echo $detalles["estado"]; ?></a></td>
      <td>
        <div class="btn-eai btns btr  text-center ">
          <a href="<?php echo $_SESSION["base_url"].'&task=edit&id_certificado='.$detalles["id_certificado"]; ?>" title="Editar"  style="color:#fff;"><i class="fa fa-edit"></i> editar</a>
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
  reordenar('certificado_2formas.php');
});
var mypage = "certificado_2formas.php";
</script>
<?php }else{ ?>
<div class="box-body">
  <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
    <form action="javascript: fn_buscar();" id="frm_buscar" name="frm_buscar">
      <input type="hidden" name="module" value="<?php echo $_GET['module']; ?>">
      <input type="hidden" name="parenttab" value="<?php echo $_GET['parenttab']; ?>">
      <div class="bg-gray-light">        
				
				<div class="col-sm-2">
          <div class="btn-eai">
            <a href="<?php echo $link_sesion."&task=new"; ?>" title="Agregar" style="color:#fff;"><i class="fa fa-file" style="padding-right:5px;"></i>Agregar</a> 
          </div>
        </div>
        <div class="col-sm-4 ">          
          <?php create_input('text','criterio_usu_per','',"form-control pull-right",$table,'placeholder="Buscar .."'); ?>
        </div>
        <div class="col-sm-2 ">          
          <?php select_sql("nregistros"); ?>
        </div>
        <div class="col-sm-2">          
					<a href="javascript:history.go(-1)" class="pull-right">&laquo; RETORNAR</a>
        </div>
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
var us = "certificado";
var link = "certificado_2forma";
var ar = "la";
var l = "a";
var l2 = "a";
var pr = "La";
var id = "id_certificado";
var mypage = "certificado_2formas.php";
</script>
<?php } ?>