<?php error_reporting(E_ALL ^ E_NOTICE);
include ("auten.php");

if($_GET["task"]=='insert' || $_GET["task"]=='update'){
  $bd=new BD;
	$where = ($_GET["task"]=='update') ? "and ide!='".$_POST["ide"]."'" : '';
	$urlrewrite=armarurlrewrite($_POST["titulo"]);
  $urlrewrite=armarurlrewrite($urlrewrite,1,"modulos_landings","ide","titulo_rewrite",$where);
	
$campos=array('id_landing','titulo',array('titulo_rewrite',$urlrewrite),'descripcion','estado_idestado'); /*inserto campos principales*/
  if($_GET["task"]=='insert'){
    $_POST['orden'] = _orden_noticia("","modulos_landings","");
		$_POST['fecha_registro'] = fecha_hora(2);

    $bd->inserta_(arma_insert('modulos_landings',array_merge($campos,array('orden','fecha_registro')),'POST'));/*inserto hora -orden y guardo imag*/
  }else{
    $bd->actualiza_(armaupdate('modulos_landings',$campos," ide='".$_POST["ide"]."'",'POST'));/*actualizo*/
  }
  $bd->close();
  gotoUrl("index.php?page=".$_POST["nompage"]."&id_landing=".$_POST["id_landing"]."&module=".$_POST["nommodule"]."&parenttab=".$_POST["nomparenttab"]);
	
}elseif($_GET["task"]=='new' || $_GET["task"]=='edit'){
  if($_GET["task"]=='edit'){
     $data_servicio=executesql("select * from modulos_landings where ide='".$_GET["ide"]."'",0);
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
				 <?php   $sql_x=" select * from landings where id_landing='".$_GET["id_landing"]."' "; 
						$datoscurso=executesql($sql_x,0); 
					?>				
          <h4 class="box-title"><?php echo ($_GET["task"]=="edit") ? 'Editar' : 'Agregando'; ?> Contenido del Landing: <b><?php echo $datoscurso["titulo"]; ?> </b> </h4>
        </div><!-- /.box-header -->
<?php $task_=$_GET["task"]; ?>
        <!-- form start -->
        <form id="registro" action="modulos_landings.php?task=<?php echo ($task_=='edit') ?  "update" : "insert"; ?>" class="form-horizontal" method="POST" enctype="multipart/form-data" onsubmit="return aceptar()">
<?php 
if($task_=='edit') create_input("hidden","ide",$data_servicio["ide"],"",$table,"");
create_input("hidden","urlfailed",basename($_SERVER['REQUEST_URI']),"",$table,"");  
create_input("hidden","urlgo",$link_landing,"",$table,"");
create_input("hidden","nompage",$_GET["page"],"",$table,""); 
create_input("hidden","id_landing",$_GET["id_landing"],"",$table,""); 
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
              <label for="inputPassword3" class="col-sm-2 control-label">Título</label>
              <div class="col-sm-8">
                <?php create_input("text","titulo",$data_servicio["titulo"],"form-control",$table,"",$agregado); ?>
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
								
          </div>
              <div class="box-footer">
                <div class="form-group">
                  <div class="col-sm-10 pull-right">
                    <input  type="submit"  class="btn bg-blue btn-flat" id="btnguardar" value="Guardar">
                    <button type="button" class="btn bg-red btn-flat" onclick="javascript:gotourl('<?php echo $link_landing; ?>');">Cancelar</button>
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
  $id_curso2 = executesql("SELECT video FROM detalle_pestanhas WHERE ide IN(".$ide.")");
  if(!empty($id_curso2)){
    foreach($id_curso2 as $row2){
      // $pfile2 = 'files/video/'.$row2['ide'].'/'.$row2['video'];
      // if(file_exists($pfile2) && !empty($row2['video'])){ unlink_sesion($pfile2); }
    }
  }
  $bd->actualiza_("DELETE FROM modulos_landings WHERE ide IN(".$ide.")");
  $bd->Commit();
  $bd->close();

}elseif($_GET["task"]=='uestado'){
  $bd = new BD;
  $bd->Begin();
  $ide = !isset($_GET['id']) ? $_GET['estado_idestado'] : $_GET['id'];
  $ide = is_array($ide) ? implode(',',$ide) : $ide;
  $modulos_landings = executesql("SELECT * FROM modulos_landings WHERE ide IN (".$ide.")");
  if(!empty($modulos_landings))
    foreach($modulos_landings as $reg => $item)
      if ($item['estado_idestado']==1) {
        $state = 2;
      }elseif ($item['estado_idestado']==2) {
        $state = 1;
      }
  $bd->actualiza_("UPDATE modulos_landings SET estado_idestado=".$state." WHERE ide=".$ide."");
  echo $state;
  $bd->Commit();
  $bd->close();
	
}elseif($_GET["task"]=='finder'){
  $sql = "SELECT cv.*,e.nombre AS estado FROM modulos_landings cv 
										INNER JOIN landings ld ON ld.id_landing=cv.id_landing  
										INNER JOIN estado e ON cv.estado_idestado=e.idestado   
									WHERE cv.id_landing =".$_GET['id_landing']. " "; 
									
  if(!empty($_GET['criterio_mostrar'])) $porPagina=$_GET['criterio_mostrar'];
  if(!empty($_GET['criterio_usu_per'])){
    $stringlike=fn_filtro(substr($_GET['criterio_usu_per'], 0, 16));
    $sql.= " AND (cv.titulo LIKE '%".$stringlike."%')";
  }
  
  if(!empty($_GET['criterio_ordenar_por'])) $sql.= sprintf(" order by %s %s", fn_filtro($_GET['criterio_ordenar_por']), fn_filtro($_GET['criterio_orden']));
  $sql.= " ORDER BY cv.orden ASC";
  $paging = new PHPPaging;
  $paging->agregarConsulta($sql); 
  $paging->div('div_listar');
  $paging->modo('desarrollo'); 
  $numregistro=1; 
  if($numregistro) $paging->porPagina(fn_filtro((int)$numregistro));
  $paging->verPost(true);
  $mantenerVar=array("id_landing","criterio_mostrar","task","criterio_usu_per","criterio_ordenar_por","criterio_orden");
  $paging->mantenerVar($mantenerVar);
  $paging->porPagina(fn_filtro((int)$porPagina));
  $paging->ejecutar();
  $paging->pagina_proceso="modulos_landings.php";
?>
<table id="example1" class="table table-bordered table-striped">
  <thead>
    <tr role="row">
      <th class="unafbe" width="20"><input type="checkbox" id="chkDel" class="all"></th>
      <th class="sort">Pestaña</th>
      <th class="sort cnone">ESTADO</th>
      <th class="unafbe btn_varios">Opciones</th>
    </tr>
  </thead>
  <tbody id="sort">
<?php while ($detalles = $paging->fetchResultado()): ?>
    <tr>
      <td><input type="checkbox" name="chkDel[]" class="chkDel" value="<?php echo $detalles["ide"]; ?>"></td>
      <td><?php echo $detalles["titulo"]; ?></td>
      <td class="cnone"><a href="javascript: fn_estado('<?php echo $detalles["ide"]; ?>')"><?php echo $detalles["estado"]; ?></a></td>
      <td>
        <div class="btn-eai btns btr btn_varios text-center ">
          <a href="<?php echo $_SESSION["base_url"].'&task=edit&ide='.$detalles["ide"]; ?>" title="Editar"  style="color:#fff;"><i class="fa fa-edit"></i> editar</a>
<!--          
				 <a href="javascript: fn_eliminar('<?php echo $detalles["ide"]; ?>')" style="color:#fff;" title="Eliminar Sessión"><i class="fa fa-trash-o"></i></a>
--> 
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
  reordenar('modulos_landings.php');
});
var mypage = "modulos_landings.php";
</script>
<?php }else{ ?>
<div class="box-body">
  <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
    <form action="javascript: fn_buscar();" id="frm_buscar" name="frm_buscar">
      <input type="hidden" name="id_landing" value="<?php echo $_GET['id_landing']; ?>">
      <input type="hidden" name="module" value="<?php echo $_GET['module']; ?>">
      <input type="hidden" name="parenttab" value="<?php echo $_GET['parenttab']; ?>">
      <div class="bg-gray-light">      
        <div class="col-sm-12">
          <?php   $sql_x=" select * from landings where id_landing='".$_GET["id_landing"]."' "; 
						$datoscurso=executesql($sql_x,0);
						// $volver_al_curso="index.php?page=landings&module=".$_GET["module"]."&parenttab=".$_GET["parenttab"]."";

						echo "<h3 style='margin:0;' ><small> <b style='color:#333;'>Pestañas :</b> </small></h3>";
						echo "<h3 style='margin-top:0;padding-top:0;padding-bottom:10px;' ><small> <b style='color:#555;'>Landing</b> : ".$datoscurso["titulo"]." </small></h3>";
					?>
        </div>
				
				<div class="col-sm-2">
          <div class="btn-eai">
            <a href="<?php echo $link_landing."&task=new"; ?>" title="Agregar" style="color:#fff;"><i class="fa fa-file" style="padding-right:5px;"></i>Agregar</a> 
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
var us = "sección";
var link = "modulos_landing";
var ar = "la";
var l = "a";
var l2 = "a";
var pr = "La";
var id = "ide";
var mypage = "modulos_landings.php";
</script>
<?php } ?>