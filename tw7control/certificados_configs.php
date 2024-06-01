<?php
error_reporting(E_ALL ^ E_NOTICE);
include ("auten.php");

if($_GET["task"]=='insert' || $_GET["task"]=='update'){
  $bd=new BD;	
	$campos=array('detalle','titulo','resolucion','persona_1','cargo_1','persona_2','cargo_2','estado_idestado'); /*inserto campos principales*/


  if($_GET["task"]=='insert'){
    
    if(isset($_FILES['imagen']) && !empty($_FILES['imagen']['name'])){
      $_POST['imagen'] = carga_imagen('files/images/certificados_configs/','imagen','','130','80');
      $campos = array_merge($campos,array('imagen'));
    }
		if(isset($_FILES['imagen_2']) && !empty($_FILES['imagen_2']['name'])){
      $_POST['imagen_2'] = carga_imagen('files/images/certificados_configs/','imagen_2','','130','80');
      $campos = array_merge($campos,array('imagen_2'));
    }
		

		$_POST['orden'] = 1;
    $_POST['fecha_registro'] = fecha_hora(2);
		$campos=array_merge($campos,array('orden','fecha_registro'));
		
		 // echo var_dump(arma_insert('certificados_configs',$campos,'POST'));
		 // exit();


	  $insertado = $_POST["id_config"] =$bd->inserta_(arma_insert('certificados_configs',$campos,'POST'));/*inserto hora -orden y guardo imag*/
		
		
 
 }else{
		 if(isset($_FILES['imagen']) && !empty($_FILES['imagen']['name'])){
      $path = 'files/images/certificados_configs/'.$_POST['imagen_ant'];
      if( file_exists($path) && !empty($_POST['imagen_ant']) ) unlink($path);    
      $_POST['imagen'] = carga_imagen('files/images/certificados_configs/','imagen','','130','80');
      $campos = array_merge($campos,array('imagen'));
    }
    
    if(isset($_FILES['imagen_2']) && !empty($_FILES['imagen_2']['name'])){
      $path = 'files/images/certificados_configs/'.$_POST['imagen_ant_2'];
      if( file_exists($path) && !empty($_POST['imagen_ant_2']) ) unlink($path);    
      $_POST['imagen_2'] = carga_imagen('files/images/certificados_configs/','imagen_2','','130','80');
      $campos = array_merge($campos,array('imagen_2'));
    }
    $bd->actualiza_(armaupdate('certificados_configs',$campos," id_config='".$_POST["id_config"]."'",'POST'));/*actualizo*/
  }

  $bd->close();
  gotoUrl("index.php?page=".$_POST["nompage"]."&id_curso=".$_POST["id_curso"]."&module=".$_POST["nommodule"]."&parenttab=".$_POST["nomparenttab"]);
	

}elseif($_GET["task"]=='new' || $_GET["task"]=='edit'){
  if($_GET["task"]=='edit'){
     $data_producto=executesql("select * from certificados_configs where id_config='".$_GET["id_config"]."'",0);
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
          <h4 class="box-title"><?php echo ($_GET["task"]=="edit") ? 'Editar' : 'Agregando'; ?>Valores Certificado PDF </b> </h4>
        </div><!-- /.box-header -->
<?php $task_=$_GET["task"]; ?>
        <!-- form start -->
        <form id="registro" action="certificados_configs.php?task=<?php echo ($task_=='edit') ?  "update" : "insert"; ?>" class="form-horizontal" method="POST" enctype="multipart/form-data" onsubmit="return aceptar()">
<?php 
if($task_=='edit') create_input("hidden","id_config",$data_producto["id_config"],"",$table,"");
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
              <label for="inputPassword3" class="col-sm-2 control-label"> Resolución</label>
              <div class="col-sm-8">
                <?php create_input("text","resolucion",$data_producto["resolucion"],"form-control",$table,"",$agregado); ?>
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
            <label for="inputPassword3" class="col-sm-2 control-label"> Persona 1 (izquierda)</label>
            <div class="col-sm-8">
              <?php create_input("text","persona_1",$data_producto["persona_1"],"form-control",$table,"",$agregado); ?>
            </div>
          </div>
          <div class="form-group">
            <label for="inputPassword3" class="col-sm-2 control-label"> Cargo 1 (izquierda)</label>
            <div class="col-sm-8">
              <?php create_input("text","cargo_1",$data_producto["cargo_1"],"form-control",$table,"",$agregado); ?>
            </div>
          </div>
          <div class="form-group">
							<label for="inputPassword3" class="col-sm-2 control-label">Imagen: </br>
								<span class="red"> 130px ancho * 80px alto </span>
							</label>
							<div class="col-sm-6">
								<input type="file" name="imagen" id="imagen" class="form-control">
								<?php create_input("hidden","imagen_ant",$data_producto["imagen"],"",$table,$agregado); 
									if($data_producto["imagen"]!=""){ 
								?>
									<img src="<?php echo "files/images/certificados_configs/".$data_producto["imagen"]; ?>" width="200" class="mgt15">
								<?php } ?> 
							</div>
          </div>
								

          <div class="form-group">
            <label for="inputPassword3" class="col-sm-2 control-label"> Persona 2 (derecha)</label>
            <div class="col-sm-8">
              <?php create_input("text","persona_2",$data_producto["persona_2"],"form-control",$table,"",$agregado); ?>
            </div>
          </div>
          <div class="form-group">
            <label for="inputPassword3" class="col-sm-2 control-label"> Cargo 2 (derecha)</label>
            <div class="col-sm-8">
              <?php create_input("text","cargo_2",$data_producto["cargo_2"],"form-control",$table,"",$agregado); ?>
            </div>
          </div>
          <div class="form-group">
							<label for="inputPassword3" class="col-sm-2 control-label">Imagen 2: </br>
								<span class="red">130px ancho * 80px alto</span>
							</label>
							<div class="col-sm-6">
								<input type="file" name="imagen_2" id="imagen_2" class="form-control">
								<?php create_input("hidden","imagen_ant_2",$data_producto["imagen_2"],"",$table,$agregado); 
									if($data_producto["imagen_2"]!=""){ 
								?>
									<img src="<?php echo "files/images/certificados_configs/".$data_producto["imagen_2"]; ?>" width="200" class="mgt15">
								<?php } ?> 
							</div>
          </div>
								
						
							
								
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
  $id_curso2 = executesql("SELECT video FROM detalle_certificados_configs WHERE id_config IN(".$ide.")");
  if(!empty($id_curso2)){
    foreach($id_curso2 as $row2){
      $pfile2 = 'files/video/'.$row2['id_config'].'/'.$row2['video'];
      if(file_exists($pfile2) && !empty($row2['video'])){ unlink_sesion($pfile2); }
    }
  }
  $bd->actualiza_("DELETE FROM certificados_configs WHERE id_config IN(".$ide.")");
  $bd->Commit();
  $bd->close();

}elseif($_GET["task"]=='uestado'){
  $bd = new BD;
  $bd->Begin();
  $ide = !isset($_GET['id']) ? $_GET['estado_idestado'] : $_GET['id'];
  $ide = is_array($ide) ? implode(',',$ide) : $ide;
  $certificados_configs = executesql("SELECT * FROM certificados_configs WHERE id_config IN (".$ide.")");
  if(!empty($certificados_configs))
    foreach($certificados_configs as $reg => $item)
      if ($item['estado_idestado']==1) {
        $state = 2;
      }elseif ($item['estado_idestado']==2) {
        $state = 1;
      }
  $bd->actualiza_("UPDATE certificados_configs SET estado_idestado=".$state." WHERE id_config=".$ide."");
  echo $state;
  $bd->Commit();
  $bd->close();
	



	
}elseif($_GET["task"]=='finder'){
		$sql = "SELECT cv.*,e.nombre AS estado 
    FROM certificados_configs cv 
    INNER JOIN estado e ON cv.estado_idestado=e.idestado 
				WHERE cv.estado_idestado != 100 
	"; 
  if(!empty($_GET['criterio_mostrar'])) $porPagina=$_GET['criterio_mostrar'];


  if( isset($_GET['criterio_usu_per']) && !empty($_GET['criterio_usu_per'])  ){
    $stringlike=fn_filtro(substr($_GET['criterio_usu_per'], 0, 16));
    $sql.= " AND (cv.titulo LIKE '%".$stringlike."%' or cv.persona_1 LIKE '%".$stringlike."%'  or cv.persona_2 LIKE '%".$stringlike."%' or cv.resolucion LIKE '%".$stringlike."%' )";
  }
  
	// $sql.= " AND cv.id_curso =".$_GET['id_curso'];

  if(!empty($_GET['criterio_ordenar_por'])) $sql.= sprintf(" order by %s %s", fn_filtro($_GET['criterio_ordenar_por']), fn_filtro($_GET['criterio_orden']));
	$sql.= " ORDER BY cv.id_config desc ";


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
  $paging->pagina_proceso="certificados_configs.php";
?>
<table id="example1" class="table table-bordered table-striped">
  <thead>
    <tr role="row">
      <th class="unafbe" width="20"><input type="checkbox" id="chkDel" class="all"></th>
      <th class="sort">TITULO</th>      
      <th class="sort">PERSONA 1</th>
      <th class="sort">CARGO</th>
      <th class="sort">PERSONA 2</th>
      <th class="sort">CARGO 2</th>
      <th class="sort cnone">ESTADO</th>
      <th class="unafbe ">Opciones</th>
    </tr>
  </thead>
  <tbody id="sort">
<?php while ($detalles = $paging->fetchResultado()): ?>
    <tr>
      <td><input type="checkbox" name="chkDel[]" class="chkDel" value="<?php echo $detalles["id_config"]; ?>"></td>
      <td><?php echo $detalles["id_config"].' - '.$detalles["titulo"]; ?></td>
      <td><?php echo $detalles["persona_1"]; ?></td>
      <td><?php echo $detalles["cargo_1"]; ?></td>
      <td><?php echo $detalles["persona_2"]; ?></td>
      <td><?php echo $detalles["cargo_2"]; ?></td>
      <td class="cnone"><a href="javascript: fn_estado('<?php echo $detalles["id_config"]; ?>')"><?php echo $detalles["estado"]; ?></a></td>
      <td>
        <div class="btn-eai btns btr  text-center ">
          <a href="<?php echo $_SESSION["base_url"].'&task=edit&id_config='.$detalles["id_config"]; ?>" title="Editar"  style="color:#fff;"><i class="fa fa-edit"></i> editar</a>
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
  reordenar('certificados_configs.php');
});
var mypage = "certificados_configs.php";
</script>
<?php }else{ ?>
<div class="box-body">
  <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
    <form action="javascript: fn_buscar();" id="frm_buscar" name="frm_buscar">
      <input type="hidden" name="module" value="<?php echo $_GET['module']; ?>">
      <input type="hidden" name="parenttab" value="<?php echo $_GET['parenttab']; ?>">
      <div class="bg-gray-light">        
				
      <!-- habilitar y validar que los certificados generados antes no se afecten con los nuevos 
				<div class="col-sm-2">
          <div class="btn-eai">
            <a href="<?php echo $link_sesion."&task=new"; ?>" title="Agregar" style="color:#fff;"><i class="fa fa-file" style="padding-right:5px;"></i>Agregar</a> 
          </div>
        </div>
-->
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
var id = "id_config";
var mypage = "certificados_configs.php";
</script>
<?php } ?>