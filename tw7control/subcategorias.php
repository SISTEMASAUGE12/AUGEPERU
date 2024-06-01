<?php error_reporting(E_ALL ^ E_NOTICE);
include_once("auten.php");

if($_GET["task"]=='neworden'){
  $bd=new BD;
  $orden_actual=$_GET["orden"];
  $orden_nuevo=$_GET["nuevoorden"]; 
  $id_del_registro_actual=$_GET["id_sub"];
  $criterio_Orden ="";
  nuevoorden($orden_actual, $orden_nuevo, $id_del_registro_actual, "subcategorias", "id_sub", $criterio_Orden);    
  $bd->close();
	
}elseif($_GET["task"]=='insert' || $_GET["task"]=='update'){
  
	$bd=new BD;
  $where=($_GET["task"]=='update') ? " and id_sub!='".$_POST["id_sub"]."'" : "";
  $urlrewrite=armarurlrewrite($_POST["titulo"]);
  $urlrewrite=armarurlrewrite($urlrewrite,1,"subcategorias","id_sub","titulo_rewrite",$where);
  $norden=_orden_noticia("","subcategorias","");
  $campos=array('id_cat',"titulo",array("titulo_rewrite",$urlrewrite),"estado_idestado");
	$_POST['idusuario']=$_SESSION["visualiza"]["idusuario"];


  if($_GET["task"]=='insert'){	
    $_POST['fecha_registro']=fecha_hora(2);
		
		// echo var_dump(arma_insert('subcategorias',array_merge($campos,array(array("orden",$norden),'fecha_registro')),'POST'));
		// exit();
		
    $_POST["id_sub"]=$bd-> inserta_(arma_insert('subcategorias',array_merge($campos,array(array("orden",$norden),'fecha_registro','idusuario')),'POST'));    
		
  }else{
    $bd->actualiza_(armaupdate('subcategorias',array_merge($campos)," id_sub='".$_POST["id_sub"]."'",'POST'));/*actualizo*/
  } 
  
  $bd->close();
  gotoUrl("index.php?page=".$_POST["nompage"]."&id_tipo=".$_POST["id_tipo"]."&module=".$_POST["nommodule"]."&parenttab=".$_POST["nomparenttab"]);
  
	
}elseif($_GET["task"]=='new' || $_GET["task"]=='edit'){
  if($_GET["task"]=='edit'){
   $usuario=executesql("select * from subcategorias where id_sub='".$_GET["id_sub"]."'",0);
  }
?>
<section class="content">
  <div class="row"><div class="col-md-12">         
    <div class="box box-info">
      <div class="box-header with-border">
        <h3 class="box-title"><?php echo ($_GET["task"]=="edit") ? 'Editar' : 'Nueva'; ?> Subcategorías</h3>
        <p style="color:red;">*Ubicacion:  Esta configuración afecta a la pagian de cursos, sirve para segmentar y ordenar los cursos/libros a vender </p>

      </div>
<?php $task_=$_GET["task"]; ?>
      <form action="subcategorias.php?task=<?php echo ($task_=='edit') ?  "update" : "insert"; ?>" class="form-horizontal" method="POST" enctype="multipart/form-data" autocomplete="OFF" onsubmit="return aceptar()">
<?php
if($task_=='edit') create_input("hidden","id_sub",$usuario["id_sub"],"",$table,"");
create_input("hidden","urlfailed",basename($_SERVER['REQUEST_URI']),"",$table,"");  
create_input("hidden","urlgo",$link_lleva_tipo,"",$table,"");
create_input("hidden","id_tipo",$_GET["id_tipo"],"",$table,"");
create_input("hidden","nompage",$_GET["page"],"",$table,""); 
create_input("hidden","nommodule",$_GET["module"],"",$table,"");
create_input("hidden","nomparenttab",$_GET["parenttab"],"",$table,"");
?>
      <div class="box-body">
        <div class="form-group">
          <label for="inputEmail3" class="col-sm-2 control-label">Estado</label>
          <div class="col-sm-6">
            <?php crearselect("estado_idestado","select * from estado",'class="form-control"',$usuario["estado_idestado"],""); ?>
          </div>
        </div>
				<div class="form-group">
          <label for="inputEmail3" class="col-sm-2 control-label">Categoria</label>
          <div class="col-sm-6">
            <?php crearselect("id_cat","select id_cat, titulo  from categorias where estado_idestado=1 and id_tipo='".$_GET["id_tipo"]."' order by titulo asc ",'class="form-control" required',$usuario["id_cat"]," -- selecione  --"); ?>
          </div>
        </div>        
        <div class="form-group">
          <label for="inputPassword3" class="col-sm-2 control-label">titulo</label>
          <div class="col-sm-6">
            <?php create_input("text","titulo",$usuario["titulo"],"form-control",$table,"required",$agregado); ?>
          </div>
        </div>

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
	// var nam6=document.getElementById("imagen").value;
	
	if(nam1 !=''){									
		alert("Registrando  .. click en aceptar y esperar..");							
		document.getElementById("btnguardar").disabled=true;			
	}else{		
		alert("Recomendación: Ingresa al menos el titulo  :)");
		return false; //el formulario no se envia		
	}
	
}				
</script>
			</form>    </div><!-- /.box -->
  </div></div><!--row / col12 -->
</section><!-- /.content -->
<?php


}elseif($_GET["task"]=='uestado'){
  $bd = new BD;
  $bd->Begin();
  $ide = !isset($_GET['id_sub']) ? $_GET['estado_idestado'] : $_GET['id_sub'];
  $ide = is_array($ide) ? implode(',',$ide) : $ide;
  $usuario = executesql("SELECT * FROM subcategorias WHERE id_sub IN (".$ide.")");
  if(!empty($usuario))
  foreach($usuario as $reg => $item)
  if ($item['estado_idestado']==1) {
    $state = 2;
  }elseif ($item['estado_idestado']==2) {
    $state = 1;
  }
  $num_afect=$bd->actualiza_("UPDATE subcategorias SET estado_idestado=".$state." WHERE id_sub=".$ide."");
  echo $state;
  $bd->Commit();
  $bd->close();
	
}elseif($_GET["task"]=='finder'){
   $sql = "SELECT d.*,e.nombre AS estado, m.titulo as marca , u.nomusuario as usuario 
	 FROM subcategorias d 
	 							LEFT join usuario u ON u.idusuario=d.idusuario 

  INNER JOIN categorias m ON m.id_cat=d.id_cat  
	INNER JOIN estado e ON d.estado_idestado=e.idestado  
		 WHERE  m.id_tipo='".$_GET["id_tipo"]."' 
	"; 
    if (isset($_GET['criterio_mostrar'])) $porPagina=$_GET['criterio_mostrar'];
		
  if(isset($_GET['criterio_usu_per']) && !empty($_GET['criterio_usu_per']) ){
    $stringlike=fn_filtro(substr($_GET['criterio_usu_per'], 0, 16));
    $sql.= " AND (d.titulo LIKE '%".$stringlike."%')"; // es ara buscar escribiend titulos 
  }
	 if (!empty($_GET['categ_search'])) {
        $sql .= " AND d.id_cat = " . $_GET['categ_search'];
    }

  if(isset($_GET['criterio_ordenar_por'])) $sql.= sprintf(" order by %s %s", fn_filtro($_GET['criterio_ordenar_por']), fn_filtro($_GET['criterio_orden']));
  $sql.= " ORDER BY orden DESC";
 

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
  $paging->ejecutar();
  $paging->pagina_proceso="subcategorias.php";
?>
    <table id="example1" class="table table-bordered table-striped">
      <thead>
        <tr role="row">
          <th class="unafbe" width="20"><input type="checkbox" id="chkDel" class="all"></th>
          <th class="sort  unafbe">Categoria</th> 
          <th class="sort  unafbe">titulo</th> 
          <th class="sort  cnone "width="70">ESTADO</th>
          <th class="sort cnone  "width="70">USUARIO</th>
          <th class="unafbe" width="100">Opciones</th>
        </tr>
      </thead>
      <tbody id="sort">
<?php while ($detalles = $paging->fetchResultado()): ?>
        <tr id="order_<?php echo $detalles["id_sub"]; ?>">
          <td><input type="checkbox" name="chkDel[]" class="chkDel" value="<?php echo $detalles["id_sub"]; ?>" id="id"></td>
          <td ><?php echo $detalles["marca"]; ?></td>
          <td ><?php echo $detalles["titulo"]; ?></td>                      
          <td class=" cnone "><a href="javascript: fn_estado('<?php echo $detalles["id_sub"]; ?>')"><?php echo $detalles["estado"]; ?></a></td>
          <td class=" cnone " ><?php echo $detalles["usuario"]; ?></td>                      
          <td><div class="btn-eai btr text-center">
         <?php if($_SESSION["visualiza"]["idtipo_usu"]==1 || $_SESSION["visualiza"]["idtipo_usu"]==2){ ?>
              <a href="<?php echo $_SESSION["base_url"].'&task=edit&id_sub='.$detalles["id_sub"]; ?>"><i class="fa fa-edit"></i></a>
         <?php } ?>
          </div></td>
        </tr>
<?php endwhile; ?>
      </tbody>
    </table>
    <div class="pagination"><?php echo $paging->fetchNavegacion(); ?></div>
<script>
$(function(){
  reordenar('subcategorias.php');
  checked();
  sorter();
});
</script>
<?php }else{ ?>
  <div class="box-body">
    <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
      <form action="javascript: fn_buscar();" id="frm_buscar" name="frm_buscar">
				<input type="hidden" name="id_tipo" value="<?php echo $_GET['id_tipo'];?> ">
				<div class="bg-gray-light">
					
					<div class="col-sm-2">
						<div class="btn-eai" >
							<a href="<?php echo $link_lleva_tipo."&task=new"; ?>" style="color:#fff;"><i class="fa fa-file" style="padding-right:8px;"></i> Agregar</a>
							<!-- 
							<a href="javascript:fn_delete_all();"><i class="fa fa-trash-o"></i></a>
							-->
						
						</div>
					</div>
                
          <div class="col-sm-3 criterio_buscar">
							<?php crearselect("categ_search", "select id_cat,titulo from categorias where estado_idestado=1 and id_tipo='".$_GET["id_tipo"]."' order by titulo asc", 'class="form-control" ', '', "-- categorias. --"); ?>
					</div>         
          <div class="col-sm-3 criterio_mostrar">
            <?php create_input('text','criterio_usu_per','',"form-control pull-right",$table,'placeholder="buscar"'); ?>
          </div>
					<div class="col-sm-3 criterio_mostrar">
            <?php select_sql("nregistros"); ?>
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
var link = "subcategoria";/*la s final se agrega en js fuctions*/
var us = "subcategoria";/*sirve para mensaje en ventana eliminar*/
var l = "o";
var l2 = "a";/* est+ _ x {e,a,o ,etc}sirve para mensaje en ventana eliminar*/
var pr = "la";
var ar = "el";
var id = "id_sub";
var mypage = "subcategorias.php";
</script>
<?php } ?>