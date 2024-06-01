<?php error_reporting(E_ALL ^ E_NOTICE);
include ("auten.php");

if($_GET["task"]=='insert' || $_GET["task"]=='update'){
    $bd=new BD;
    $where = ($_GET["task"]=='update') ? "and idarchivo!='".$_POST["idarchivo"]."'" : '';
    $urlrewrite=armarurlrewrite($_POST["titulo"]);
    $urlrewrite=armarurlrewrite($urlrewrite,1,"archivos_blog","idarchivo","titulo_rewrite",$where);
	
    $campos=array('categoria_idcategoria','publicacion_idpublicacion','titulo',array('titulo_rewrite',$urlrewrite),'estado_idestado'); /*inserto campos principales*/
    if($_GET["task"]=='insert'){
        $_POST['orden'] = _orden_noticia("","archivos_blog","");
		    $_POST['fecha_registro'] = fecha_hora(2);
        if(isset($_FILES['archivo']) && !empty($_FILES['archivo']['name'])){
            $_POST['archivo'] = carga_imagen('files/files/blog_recursos/'.$_POST["publicacion_idpublicacion"],'archivo','','','');
            $campos = array_merge($campos,array('archivo'));
        }
		
        $bd->inserta_(arma_insert('archivos_blog',array_merge($campos,array('orden','fecha_registro')),'POST'));/*inserto hora -orden y guardo imag*/
    }else{
		if(isset($_FILES['archivo']) && !empty($_FILES['archivo']['name'])){
        $path = 'files/files/blog_recursos/'.$_POST["publicacion_idpublicacion"].$_POST['archivo_ant'];
        if(file_exists($path) && !empty($_POST['archivo_ant'])) unlink($path);
            $_POST['archivo'] = carga_imagen('files/files/blog_recursos/'.$_POST["publicacion_idpublicacion"],'archivo','','','');
            $campos = array_merge($campos,array('archivo'));
        }
		
        $bd->actualiza_(armaupdate('archivos_blog',$campos," idarchivo='".$_POST["idarchivo"]."'",'POST'));/*actualizo*/
    }
	
    $bd->close();
    gotoUrl("index.php?page=".$_POST["nompage"]."&categoria_idcategoria=".$_POST["categoria_idcategoria"]."&publicacion_idpublicacion=".$_POST["publicacion_idpublicacion"]."&module=".$_POST["nommodule"]."&parenttab=".$_POST["nomparenttab"]);
	
}elseif($_GET["task"]=='new' || $_GET["task"]=='edit'){
    if($_GET["task"]=='edit'){ $data_servicio=executesql("select * from archivos_blog where idarchivo='".$_GET["idarchivo"]."'",0); }
?>
<!-- CK EDITOR -->
<script src="ckeditor/ckeditor.js"></script>
<script src="ckeditor/sample.js"></script>
<script src="ckfinder/ckfinder.js"></script>
<section class="content"><div class="row"><div class="col-md-12"><div class="box box-info">
    <div class="box-header with-border">	
        <h4 class="box-title"><?php echo ($_GET["task"]=="edit") ? 'Editar' : 'Agregando'; ?> Archivos</h4>
    </div><!-- /.box-header -->
<?php $task_=$_GET["task"]; ?>
    <!-- form start -->
    <form id="registro" action="archivos_categoria_blogs.php?task=<?php echo ($task_=='edit') ?  "update" : "insert"; ?>" class="form-horizontal" method="POST" enctype="multipart/form-data" onsubmit="return aceptar()">
<?php 
if($task_=='edit') create_input("hidden","idarchivo",$data_servicio["idarchivo"],"",$table,"");
create_input("hidden","urlfailed",basename($_SERVER['REQUEST_URI']),"",$table,"");  
create_input("hidden","urlgo",$link_blog_archivo,"",$table,"");
create_input("hidden","nompage",$_GET["page"],"",$table,""); 
create_input("hidden","publicacion_idpublicacion",$_GET["publicacion_idpublicacion"],"",$table,""); 
create_input("hidden","categoria_idcategoria",$_GET["categoria_idcategoria"],"",$table,""); 
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
            <div class="form-group">
                <label class="col-sm-2 control-label">Archivo</label>
                <div class="col-sm-6">
                    <input type="file" name="archivo" id="archivo" class="form-control">
                    <?php create_input("hidden","archivo_ant",$data_servicio["archivo"],"",$table,$agregado); 
                      if($data_servicio["archivo"]!=""){ 
                    ?>
                    <a href="<?php echo "files/files/blog_recursos/".$data_servicio["publicacion_idpublicacion"].'/'.$data_servicio["archivo"]; ?>" target="_blank"><img src="icon-pdf.jpg" alt="<?php echo $data_servicio["titulo"]; ?>" width="50"></a>
                    <?php } ?> 
                </div>
            </div> 		
        </div>
        <div class="box-footer"><div class="form-group"><div class="col-sm-10 pull-right">
            <input  type="submit"  class="btn bg-blue btn-flat" id="btnguardar" value="Guardar">
            <button type="button" class="btn bg-red btn-flat" onclick="javascript:gotourl('<?php echo $link_blog_archivo; ?>');">Cancelar</button>
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
    $idarchivo = !isset($_GET['id']) ? implode(',', $_GET['chkDel']) : $_GET['id'];
    $categoria = executesql("SELECT archivo FROM archivos_blog WHERE idarchivo IN(".$ide.")");
    if(!empty($categoria)){ foreach($categoria as $row){
        $pfile = 'files/files/blog_recursos/'.$_POST["publicacion_idpublicacion"].$row['archivo']; 
        if(file_exists($pfile) && !empty($row['archivo'])) unlink($pfile);
    } }
    $bd->actualiza_("DELETE FROM archivos_blog WHERE idarchivo IN(".$idarchivo.")");
    $bd->Commit();
    $bd->close();

}elseif($_GET["task"]=='uestado'){
    $bd = new BD;
    $bd->Begin();
    $idarchivo = !isset($_GET['id']) ? $_GET['estado_idestado'] : $_GET['id'];
    $idarchivo = is_array($idarchivo) ? implode(',',$idarchivo) : $idarchivo;
    $archivos_blog = executesql("SELECT * FROM archivos_blog WHERE idarchivo IN (".$idarchivo.")");
    if(!empty($archivos_blog)) foreach($archivos_blog as $reg => $item)
        if($item['estado_idestado']==1){ $state = 2;
        }elseif($item['estado_idestado']==2){ $state = 1;
        }
    $bd->actualiza_("UPDATE archivos_blog SET estado_idestado=".$state." WHERE idarchivo=".$idarchivo."");
    echo $state;
    $bd->Commit();
    $bd->close();
	
}elseif($_GET["task"]=='finder'){
    $sql = "SELECT cv.*, x.titulo as examen, p.titulo as pregunta, e.nombre AS estado FROM archivos_blog cv 
	INNER JOIN categoria_archivos_blog p ON p.idcategoria=cv.categoria_idcategoria  
	INNER JOIN publicacion x ON x.idpublicacion=cv.publicacion_idpublicacion  
	INNER JOIN estado e ON cv.estado_idestado=e.idestado   
	WHERE cv.publicacion_idpublicacion =".$_GET['publicacion_idpublicacion']."  and cv.categoria_idcategoria =".$_GET['categoria_idcategoria']." "; 
									
    if(!empty($_GET['criterio_mostrar'])) $porPagina=$_GET['criterio_mostrar'];
    if(!empty($_GET['criterio_usu_per'])){
        $stringlike=fn_filtro(substr($_GET['criterio_usu_per'], 0, 16));
        $sql.= " AND ( cv.titulo LIKE '%".$stringlike."%' or x.titulo LIKE '%".$stringlike."%' or p.titulo LIKE '%".$stringlike."%' )";
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
    $mantenerVar=array("categoria_idcategoria",'publicacion_idpublicacion',"criterio_mostrar","task","criterio_usu_per","criterio_ordenar_por","criterio_orden");
    $paging->mantenerVar($mantenerVar);
    $paging->porPagina(fn_filtro((int)$porPagina));
    $paging->ejecutar();
    $paging->pagina_proceso="archivos_categoria_blogs.php";
?>
<table id="example1" class="table table-bordered table-striped">
    <thead><tr role="row">
        <th class="sort">TITULO</th>
        <th class="sort">CATEGORIA</th>
        <th class="sort">BLOG</th>
        <th class="sort">ARCHIVO</th>
        <th class="sort cnone">ESTADO</th>
        <th class="unafbe">Opciones</th>
    </tr></thead>
    <tbody id="sort">
<?php $i=0;
while ($detalles = $paging->fetchResultado()): 
	$i++;
?>
        <tr  style="<?php echo $fondo_entregar; ?>" >
            <td><?php echo $detalles["titulo"]; ?></td>
            <td><?php echo $detalles["pregunta"]; ?></td>
            <td><?php echo $detalles["examen"]; ?></td>
            <td>
            <?php if(!empty($detalles["archivo"])){ ?>
                <a href="<?php echo "files/files/blog_recursos/".$detalles["publicacion_idpublicacion"].'/'.$detalles["archivo"]; ?>" target="_blank"><img src="icon-pdf.jpg" alt="<?php echo $detalles["titulo"]; ?>" class="img-responsive"></a>
            <?php }else{ echo "Not Archivo."; } ?>
            </td>
            <td class="cnone"><a href="javascript: fn_estado('<?php echo $detalles["idarchivo"]; ?>')"><?php echo $detalles["estado"]; ?></a></td>
            <td><div class="btn-eai btns btr text-center">
                <a href="<?php echo $_SESSION["base_url"].'&task=edit&idarchivo='.$detalles["idarchivo"]; ?>" title="Editar"  style="color:#fff;"><i class="fa fa-edit"></i> editar</a>				
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
  reordenar('archivos_categoria_blogs.php');
});
var mypage = "archivos_categoria_blogs.php";
</script>
<?php }else{ ?>
<div class="box-body"><div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
    <form action="javascript: fn_buscar();" id="frm_buscar" name="frm_buscar">
        <input type="hidden" name="publicacion_idpublicacion" value="<?php echo $_GET['publicacion_idpublicacion']; ?>">
        <input type="hidden" name="categoria_idcategoria" value="<?php echo $_GET['categoria_idcategoria']; ?>">
        <input type="hidden" name="module" value="<?php echo $_GET['module']; ?>">
        <input type="hidden" name="parenttab" value="<?php echo $_GET['parenttab']; ?>">
        <div class="bg-gray-light">      
            <div class="col-sm-12">
				<h3 style='margin:0;'><small><b style='color:#333;'>Archivos:</b> </small></h3>
            </div>
			<div class="col-sm-2"><div class="btn-eai">
                <a href="<?php echo $link_blog_archivo."&task=new"; ?>" title="Agregar" style="color:#fff;"><i class="fa fa-file" style="padding-right:5px;"></i>Agregar</a> 
            </div></div>
            <div class="col-sm-4 "><?php create_input('text','criterio_usu_per','',"form-control pull-right",$table,'placeholder="Buscar .."'); ?></div>
            <div class="col-sm-2"><?php select_sql("nregistros"); ?></div>
            <div class="col-sm-2 criterio_mostrar"><div class="btn-eai"> 
				<a href="index.php?page=categoria_archivos&publicacion_idpublicacion=<?php echo $_GET["publicacion_idpublicacion"]; ?>&module=<?php echo $_GET["module"]; ?>&parenttab=<?php echo $_GET["parenttab"]; ?>" title="Regresar << " style="color:#fff;"><i class="fa fa-file" style="padding-right:5px;"></i>  Regresar</a> 
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
var us = "archivos_categoria_blog";
var link = "archivos_categoria_blog";
var ar = "la";
var l = "a";
var l2 = "a";
var pr = "La";
var id = "idarchivo";
var mypage = "archivos_categoria_blogs.php";
</script>
<?php } ?>