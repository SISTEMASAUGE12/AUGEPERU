<?php error_reporting(E_ALL ^ E_NOTICE);
include ("auten.php");

if($_GET["task"]=='insert' || $_GET["task"]=='update'){
    $bd=new BD;
    $where = ($_GET["task"]=='update') ? "and idcategoria!='".$_POST["idcategoria"]."'" : '';
    $urlrewrite=armarurlrewrite($_POST["titulo"]);
    $urlrewrite=armarurlrewrite($urlrewrite,1,"categoria_archivos_blog","idcategoria","titulo_rewrite",$where);
	
    $campos=array('publicacion_idpublicacion','titulo',array('titulo_rewrite',$urlrewrite),'estado_idestado'); /*inserto campos principales*/
    if($_GET["task"]=='insert'){
        $_POST['orden'] = _orden_noticia("","categoria_archivos_blog","");
        $_POST['fecha_registro'] = fecha_hora(2);
		    $bd->inserta_(arma_insert('categoria_archivos_blog',array_merge($campos,array('orden','fecha_registro')),'POST'));/*inserto hora -orden y guardo imag*/
    }else{
		$bd->actualiza_(armaupdate('categoria_archivos_blog',$campos," idcategoria='".$_POST["idcategoria"]."'",'POST'));/*actualizo*/
    }
	
    $bd->close();
    gotoUrl("index.php?page=".$_POST["nompage"]."&publicacion_idpublicacion=".$_POST["publicacion_idpublicacion"]."&module=".$_POST["nommodule"]."&parenttab=".$_POST["nomparenttab"]);
	
}elseif($_GET["task"]=='new' || $_GET["task"]=='edit'){
    if($_GET["task"]=='edit'){
        $data_servicio=executesql("select * from categoria_archivos_blog where idcategoria='".$_GET["idcategoria"]."'",0);
    }
?>
<!-- CK EDITOR -->
<script src="ckeditor/ckeditor.js"></script>
<script src="ckeditor/sample.js"></script>
<script src="ckfinder/ckfinder.js"></script>
<section class="content"><div class="row"><div class="col-md-12"><div class="box box-info">
    <div class="box-header with-border">
        <h4 class="box-title"><?php echo ($_GET["task"]=="edit") ? 'Editar' : 'Agregando'; ?> Categoría de archivos</h4>
    </div><!-- /.box-header -->
<?php $task_=$_GET["task"]; ?>
    <!-- form start -->
    <form id="registro" action="categoria_archivos.php?task=<?php echo ($task_=='edit') ?  "update" : "insert"; ?>" class="form-horizontal" method="POST" enctype="multipart/form-data" onsubmit="return aceptar()">
<?php 
if($task_=='edit') create_input("hidden","idcategoria",$data_servicio["idcategoria"],"",$table,"");
create_input("hidden","urlfailed",basename($_SERVER['REQUEST_URI']),"",$table,"");  
create_input("hidden","urlgo",$link_catearc,"",$table,"");
create_input("hidden","nompage",$_GET["page"],"",$table,""); 
create_input("hidden","publicacion_idpublicacion",$_GET["publicacion_idpublicacion"],"",$table,""); 
create_input("hidden","nommodule",$_GET["module"],"",$table,"");
create_input("hidden","nomparenttab",$_GET["parenttab"],"",$table,"");
?>
        <div class="box-body">
            <div class="form-group">
                <label class="col-sm-2 control-label">Estado</label>
                <div class="col-sm-4"><?php crearselect("estado_idestado","select * from estado where idestado in('1','2') order by 2 desc",'class="form-control"',$data_servicio["estado"],""); ?></div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Título</label>
                <div class="col-sm-8"><?php create_input("text","titulo",$data_servicio["titulo"],"form-control",$table,"",$agregado); ?></div>
            </div>
				</div>
        <div class="box-footer"><div class="form-group"><div class="col-sm-10 pull-right">
            <input  type="submit"  class="btn bg-blue btn-flat" id="btnguardar" value="Guardar">
            <button type="button" class="btn bg-red btn-flat" onclick="javascript:gotourl('<?php echo $link_catearc; ?>');">Cancelar</button>
        </div></div></div>
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
</div></div></div></section><!-- /.content -->
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
    $idcategoria = !isset($_GET['id']) ? implode(',', $_GET['chkDel']) : $_GET['id'];

    $bd->actualiza_("DELETE FROM categoria_archivos_blog WHERE idcategoria IN(".$idcategoria.")");
    $bd->Commit();
    $bd->close();

}elseif($_GET["task"]=='uestado'){
    $bd = new BD;
    $bd->Begin();
    $idcategoria = !isset($_GET['id']) ? $_GET['estado_idestado'] : $_GET['id'];
    $idcategoria = is_array($idcategoria) ? implode(',',$idcategoria) : $idcategoria;
    $preguntas = executesql("SELECT * FROM categoria_archivos_blog WHERE idcategoria IN (".$idcategoria.")");
  
    if(!empty($preguntas)) foreach($preguntas as $reg => $item)
        if($item['estado_idestado']==1){ $state = 2;
        }elseif($item['estado_idestado']==2){ $state = 1;
        }
  
    $bd->actualiza_("UPDATE categoria_archivos_blog SET estado_idestado=".$state." WHERE idcategoria=".$idcategoria."");
    echo $state;
    $bd->Commit();
    $bd->close();
	
}elseif($_GET["task"]=='finder'){
    $sql = "SELECT cv.*, ld.titulo as blog, e.nombre AS estado FROM categoria_archivos_blog cv 
		INNER JOIN publicacion ld ON ld.idpublicacion=cv.publicacion_idpublicacion  
		INNER JOIN estado e ON cv.estado_idestado=e.idestado   
		WHERE cv.publicacion_idpublicacion =".$_GET['publicacion_idpublicacion']. " "; 
									
    if(!empty($_GET['criterio_mostrar'])) $porPagina=$_GET['criterio_mostrar'];
    if(!empty($_GET['criterio_usu_per'])){
        $stringlike=fn_filtro(substr($_GET['criterio_usu_per'], 0, 16));
        $sql.= " AND ( cv.titulo LIKE '%".$stringlike."%' or ld.titulo LIKE '%".$stringlike."%' )";
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
    $mantenerVar=array("publicacion_idpublicacion","criterio_mostrar","task","criterio_usu_per","criterio_ordenar_por","criterio_orden");
    $paging->mantenerVar($mantenerVar);
    $paging->porPagina(fn_filtro((int)$porPagina));
    $paging->ejecutar();
    $paging->pagina_proceso="categoria_archivos.php";
?>
    <table id="example1" class="table table-bordered table-striped">
        <thead><tr role="row">
            <th class="unafbe" width="20"><input type="checkbox" id="chkDel" class="all"></th>
            <th class="sort">CATEGORIA</th>
            <th class="sort">BLOG</th>
            <th class="sort cnone">ESTADO</th>
            <th class="unafbe" width="160">Opciones</th>
        </tr></thead>
        <tbody id="sort">
<?php $i=0;
while ($detalles = $paging->fetchResultado()): 
	$i++;
?>
            <tr>
                <td><input type="checkbox" name="chkDel[]" class="chkDel" value="<?php echo $detalles["idcategoria"]; ?>"></td>
                <td><?php echo $detalles["titulo"]; ?></td>
                <td><?php echo $detalles["blog"]; ?></td>
                <td class="cnone"><a href="javascript: fn_estado('<?php echo $detalles["idcategoria"]; ?>')"><?php echo $detalles["estado"]; ?></a></td>
                <td><div class="btn-eai btns btr text-center ">
                    <a href="<?php echo $_SESSION["base_url"].'&task=edit&idcategoria='.$detalles["idcategoria"]; ?>" title="Editar"  style="color:#fff;"><i class="fa fa-edit"></i> editar</a>
                    <a href="index.php?page=archivos_categoria_blogs&publicacion_idpublicacion=<?php echo $detalles['publicacion_idpublicacion']; ?>&categoria_idcategoria=<?php echo $detalles['idcategoria']; ?>&module=<?php echo $_GET['module']; ?>&parenttab=<?php echo $_GET['parenttab']; ?>"  style="color:#fff;" title="Agregar preguntas"><i class="fa fa-file-pdf-o"></i> <span> Archivos</span></a> 			
                </div></td>
            </tr>
<?php endwhile; ?>
        </tbody>
    </table>
<div class="pagination"><?php echo $paging->fetchNavegacion(); ?></div>
<script>
$(function(){
  checked();
  sorter();
  reordenar('categoria_archivos.php');
});
var mypage = "categoria_archivos.php";
</script>
<?php }else{ ?>
<div class="box-body"><div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
    <form action="javascript: fn_buscar();" id="frm_buscar" name="frm_buscar">
        <input type="hidden" name="publicacion_idpublicacion" value="<?php echo $_GET['publicacion_idpublicacion']; ?>">
        <input type="hidden" name="module" value="<?php echo $_GET['module']; ?>">
        <input type="hidden" name="parenttab" value="<?php echo $_GET['parenttab']; ?>">
        <div class="bg-gray-light">      
            <div class="col-sm-12"><h3 style='margin-top:0;padding-top:0;padding-bottom:10px;' ><small> <b style='color:#555;'>Categoría de archivos blog</b></small></h3></div>
			<div class="col-sm-2"><div class="btn-eai">
				<a href="<?php echo $link_catearc."&task=new"; ?>" title="Agregar" style="color:#fff;"><i class="fa fa-file" style="padding-right:5px;"></i>Agregar</a> 
            </div></div>
			<div class="col-sm-4 ">          
                <?php create_input('text','criterio_usu_per','',"form-control pull-right",$table,'placeholder="Buscar .."'); ?>
            </div>
            <div class="col-sm-2 ">          
                <?php select_sql("nregistros"); ?>
            </div>
            <div class="col-sm-2 criterio_mostrar"><div class="btn-eai"> 
				<a href="index.php?page=novedades&module=<?php echo $_GET["module"]; ?>&parenttab=<?php echo $_GET["parenttab"]; ?>" title="Regresar << " style="color:#fff;"><i class="fa fa-file" style="padding-right:5px;"></i>  Regresar</a> 
            </div></div>
            <div class="break"></div>
        </div>
    </form>
    <div class="row"><div class="col-sm-12">
        <div id="div_listar"></div>
        <div id="div_oculto" style="display: none;"></div>
    </div></div>
</div></div>
<script>
var us = "categoria_archivo";
var link = "categoria_archivo";
var ar = "la";
var l = "a";
var l2 = "a";
var pr = "La";
var id = "idcategoria";
var mypage = "categoria_archivos.php";
</script>
<?php } ?>