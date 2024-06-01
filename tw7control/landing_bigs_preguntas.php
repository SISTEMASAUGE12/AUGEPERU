<?php
error_reporting(E_ALL ^ E_NOTICE);
include ("auten.php");

if($_GET["task"]=='insert' || $_GET["task"]=='update'){
  $bd=new BD;
	$where = ($_GET["task"]=='update') ? "and id_silabo!='".$_POST["id_silabo"]."'" : '';
	$urlrewrite=armarurlrewrite($_POST["titulo"]);
  $urlrewrite=armarurlrewrite($urlrewrite,1,"landing_bigs_preguntas","id_silabo","titulo_rewrite",$where);
	
	$campos=array('id_big','titulo',array('titulo_rewrite',$urlrewrite),'descripcion','modulo','estado_idestado'); /*inserto campos principales*/
  
	if($_GET["task"]=='insert'){
		
		if(isset($_FILES['imagen']) && !empty($_FILES['imagen']['name'])){
      $_POST['imagen'] = carga_imagen('files/images/landing_bigs_preguntas/','imagen','','414','240');
      $campos = array_merge($campos,array('imagen'));
    }
		
    $_POST['orden'] = _orden_noticia("","landing_bigs_preguntas","");
    $bd->inserta_(arma_insert('landing_bigs_preguntas',array_merge($campos,array('orden')),'POST'));/*inserto hora -orden y guardo imag*/
		
		
  }else{
		
		if(isset($_FILES['imagen']) && !empty($_FILES['imagen']['name'])){
      $path = 'files/images/landing_bigs_preguntas/'.$_POST['imagen_ant'];
      if( file_exists($path) && !empty($_POST['imagen_ant']) ) unlink($path);    
      $_POST['imagen'] = carga_imagen('files/images/landing_bigs_preguntas/','imagen','','414','240');
      $campos = array_merge($campos,array('imagen'));
    }
    $bd->actualiza_(armaupdate('landing_bigs_preguntas',$campos," id_silabo='".$_POST["id_silabo"]."'",'POST'));/*actualizo*/
		
  }
	
  $bd->close();
  gotoUrl("index.php?page=".$_POST["nompage"]."&id_big=".$_POST["id_big"]."&module=".$_POST["nommodule"]."&parenttab=".$_POST["nomparenttab"]);
	
}elseif($_GET["task"]=='new' || $_GET["task"]=='edit'){
  if($_GET["task"]=='edit'){
     $data_servicio=executesql("select * from landing_bigs_preguntas where id_silabo='".$_GET["id_silabo"]."'",0);
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
				 <?php   $sql_x=" select * from landings_bigs where id_big='".$_GET["id_big"]."' "; 
						$datoscurso=executesql($sql_x,0); 
					?>				
          <h4 class="box-title"><?php echo ($_GET["task"]=="edit") ? 'Editar' : 'Agregando'; ?> 
						<b>Landing BIG:</b> </br>
						Preguntas frecuentes del evento: <b>
						<?php echo $datoscurso["titulo"]; ?> </b>
					</h4>
        </div><!-- /.box-header -->
<?php $task_=$_GET["task"]; ?>
        <!-- form start -->
        <form id="registro" action="landing_bigs_preguntas.php?task=<?php echo ($task_=='edit') ?  "update" : "insert"; ?>" class="form-horizontal" method="POST" enctype="multipart/form-data" onsubmit="return aceptar()">
<?php 
if($task_=='edit') create_input("hidden","id_silabo",$data_servicio["id_silabo"],"",$table,"");
create_input("hidden","urlfailed",basename($_SERVER['REQUEST_URI']),"",$table,"");  
create_input("hidden","urlgo",$link_agenda_landing,"",$table,"");
create_input("hidden","nompage",$_GET["page"],"",$table,""); 
create_input("hidden","id_big",$_GET["id_big"],"",$table,""); 
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
              <label for="inputPassword3" class="col-sm-2 control-label">Título pregunta</label>
              <div class="col-sm-8">
                <?php create_input("text","titulo",$data_servicio["titulo"],"form-control",$table,"",$agregado); ?>
              </div>
            </div>

            <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">respuesta</label>
                <div class="col-sm-10">
                  <?php create_input("textarea","descripcion",$data_servicio["descripcion"],"",$table,' style="height:230px;" ');  ?>
                  
                </div>
            </div>



                <?php /* 
						<div class="form-group">
							<label for="inputPassword3" class="col-md-2 col-sm-2 control-label">Imágen  (414px ancho * 240px alto )</label>
							<div class="col-sm-6">
								<input type="file" name="imagen" id="imagen" class="form-control">
								<?php create_input("hidden","imagen_ant",$data_servicio["imagen"],"",$table,$agregado); 
									if($data_servicio["imagen"]!=""){ 
								?>
									<img src="<?php echo "files/images/landing_bigs_preguntas/".$data_servicio["imagen"]; ?>" width="200" class="mgt15">
								<?php } ?> 
							</div>
						</div>		
								*/ ?>				
								
          </div>
              <div class="box-footer">
                <div class="form-group">
                  <div class="col-sm-10 pull-right">
                    <input  type="submit"  class="btn bg-blue btn-flat" id="btnguardar" value="Guardar">
                    <button type="button" class="btn bg-red btn-flat" onclick="javascript:gotourl('<?php echo $link_agenda_landing; ?>');">Cancelar</button>
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
  $ide = !isset($_GET['id_silabo']) ? implode(',', $_GET['chkDel']) : $_GET['id_silabo'];
 

  $bd->actualiza_("DELETE FROM landing_bigs_preguntas WHERE id_silabo IN (".$ide.")");
  $bd->Commit();
  $bd->close();

}elseif($_GET["task"]=='uestado'){
  $bd = new BD;
  $bd->Begin();
  $ide = !isset($_GET['id']) ? $_GET['estado_idestado'] : $_GET['id'];
  $ide = is_array($ide) ? implode(',',$ide) : $ide;
  $landing_bigs_preguntas = executesql("SELECT * FROM landing_bigs_preguntas WHERE id_silabo IN (".$ide.")");
  if(!empty($landing_bigs_preguntas))
    foreach($landing_bigs_preguntas as $reg => $item)
      if ($item['estado_idestado']==1) {
        $state = 2;
      }elseif ($item['estado_idestado']==2) {
        $state = 1;
      }
  $bd->actualiza_("UPDATE landing_bigs_preguntas SET estado_idestado=".$state." WHERE id_silabo=".$ide."");
  echo $state;
  $bd->Commit();
  $bd->close();
	
}elseif($_GET["task"]=='finder'){
  $sql = "SELECT cv.*,e.nombre AS estado FROM landing_bigs_preguntas cv INNER JOIN estado e ON cv.estado_idestado=e.idestado "; 
  if(!empty($_GET['criterio_mostrar'])) $porPagina=$_GET['criterio_mostrar'];
  if(!empty($_GET['criterio_usu_per'])){
    $stringlike=fn_filtro(substr($_GET['criterio_usu_per'], 0, 16));
    $sql.= " AND (cv.titulo LIKE '%".$stringlike."%')";
  }
  
	$sql.= " AND cv.id_big =".$_GET['id_big'];
  if(!empty($_GET['criterio_ordenar_por'])) $sql.= sprintf(" order by %s %s", fn_filtro($_GET['criterio_ordenar_por']), fn_filtro($_GET['criterio_orden']));
  $sql.= " ORDER BY cv.orden desc ";
  $paging = new PHPPaging;
  $paging->agregarConsulta($sql); 
  $paging->div('div_listar');
  $paging->modo('desarrollo'); 
  $numregistro=1; 
  if($numregistro) $paging->porPagina(fn_filtro((int)$numregistro));
  $paging->verPost(true);
  $mantenerVar=array("id_big","criterio_mostrar","task","criterio_usu_per","criterio_ordenar_por","criterio_orden");
  $paging->mantenerVar($mantenerVar);
  $paging->porPagina(fn_filtro((int)$porPagina));
  $paging->ejecutar();
  $paging->pagina_proceso="landing_bigs_preguntas.php";

?>


<table id="example1" class="table table-bordered table-striped">
  <thead>
    <tr role="row">
      <th class="unafbe" width="20"><input type="checkbox" id="chkDel" class="all"></th>
      <th class="sort">ORDEN</th>
      <th class="sort"> titulo</th>
      <th class="sort cnone">ESTADO</th>
      <th class="unafbe btn_varios">Opciones</th>
    </tr>
  </thead>
  <tbody id="sort">
<?php while ($detalles = $paging->fetchResultado()): ?>
    <tr>
      <td><input type="checkbox" name="chkDel[]" class="chkDel" value="<?php echo $detalles["id_silabo"]; ?>"></td>
      <td><?php echo $detalles["orden"]; ?></td>
      <td><?php echo $detalles["titulo"]; ?></td>
      <td class="cnone"><a href="javascript: fn_estado('<?php echo $detalles["id_silabo"]; ?>')"><?php echo $detalles["estado"]; ?></a></td>
      <td>
        <div class="btn-eai btns btr btn_varios text-center ">
          <a href="<?php echo $_SESSION["base_url"].'&task=edit&id_silabo='.$detalles["id_silabo"]; ?>" title="Editar"  style="color:#fff;"><i class="fa fa-edit"></i> editar</a>
					<?php  if($_SESSION["visualiza"]["idtipo_usu"] ==1){ ?>
				 <a href="javascript: fn_eliminar('<?php echo $detalles["id_silabo"]; ?>')" style="color:#fff;" title="Eliminar Sessión"><i class="fa fa-trash-o"></i></a>
				 <?php } ?> 									

<!--          
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
  reordenar('landing_bigs_preguntas.php');
});
var mypage = "landing_bigs_preguntas.php";
</script>
<?php }else{ ?>
<div class="box-body">
  <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
    <form action="javascript: fn_buscar();" id="frm_buscar" name="frm_buscar">
      <input type="hidden" name="id_big" value="<?php echo $_GET['id_big']; ?>">
      <input type="hidden" name="module" value="<?php echo $_GET['module']; ?>">
      <input type="hidden" name="parenttab" value="<?php echo $_GET['parenttab']; ?>">
      <div class="bg-gray-light">      
        <div class="col-sm-12">
          <?php    $sql_x=" select * from landings_bigs where id_big='".$_GET["id_big"]."' "; 
						$datoscurso=executesql($sql_x,0);
						// $volver_al_curso="index.php?page=cursos&module=".$_GET["module"]."&parenttab=".$_GET["parenttab"]."";

						echo "<h3 style='margin:0;' ><small> <b style='color:#333;'> Preguntas frecuentes :</b> </small></h3>";
						echo "<h3 style='margin-top:0;padding-top:0;padding-bottom:10px;' ><small> <b style='color:#555;'>Evento</b> : ".$datoscurso["id_big"].' - '.$datoscurso["titulo"]." </small></h3>";
					?>
        </div>
				
				<div class="col-sm-2">
          <div class="btn-eai">
            <a href="<?php echo $link_agenda_landing."&task=new"; ?>" title="Agregar" style="color:#fff;"><i class="fa fa-file" style="padding-right:5px;"></i>Agregar</a> 
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
var us = "pregunta";
var link = "landing_bigs_pregunta";
var ar = "la";
var l = "a";
var l2 = "a";
var pr = "La";
var id = "id_silabo";
var mypage = "landing_bigs_preguntas.php";
</script>
<?php } ?>