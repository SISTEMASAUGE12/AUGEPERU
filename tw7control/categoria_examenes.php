<?php error_reporting(E_ALL ^ E_NOTICE);
include ("auten.php");

if($_GET["task"]=='neworden'){
  $bd=new BD;
  $orden_actual=$_GET["orden"];
  $orden_nuevo=$_GET["nuevoorden"];
  $tipo=$_GET["tipo"];  
  $id_del_registro_actual=$_GET["id_cate"];
  $criterio_Orden =" ";
  nuevoorden($orden_actual, $orden_nuevo, $tipo, $id_del_registro_actual, "categoria_examenes", "id_cate", $criterio_Orden);    
  $bd->close();

}elseif($_GET["task"]=='insert' || $_GET["task"]=='update'){
  $bd=new BD;
	$_POST["estado"]='A'; /* no se utiliza en nada para este nuevo flujo de la web */
  
  $where = ($_GET["task"]=='update') ? "and id_cate!='".$_POST["id_cate"]."'" : '';
  $urlrewrite=armarurlrewrite($_POST["titulo"]);
  $urlrewrite=armarurlrewrite($urlrewrite,1,"categoria_examenes","id_cate","titulo_rewrite",$where);


  $campos=array('titulo','mostrar_en_la_web',array('titulo_rewrite',$urlrewrite), 'estado','estado_idestado'); 

  if($_GET["task"]=='insert'){
    if(isset($_FILES['imagen']) && !empty($_FILES['imagen']['name'])){
      $_POST['imagen'] = carga_imagen('files/images/categoria_examenes/','imagen','','268','137');
      $campos = array_merge($campos,array('imagen'));
    }

    $_POST["id_cate"]=$bd->inserta_(arma_insert('categoria_examenes',$campos,'POST'));
		
  }else{
    
    if(isset($_FILES['imagen']) && !empty($_FILES['imagen']['name'])){
      $path = 'files/images/examenes/'.$_POST['imagen_ant'];
      if( file_exists($path) && !empty($_POST['imagen_ant']) ) unlink($path);    
      $_POST['imagen'] = carga_imagen('files/images/categoria_examenes/','imagen','','268','137');
      $campos = array_merge($campos,array('imagen'));
    }

    //echo var_dump(armaupdate('categoria_examenes',$campos," id_cate='".$_POST["id_cate"]."'",'POST'));
    //exit();

    $bd->actualiza_(armaupdate('categoria_examenes',$campos," id_cate='".$_POST["id_cate"]."'",'POST'));/*actualizo*/
  }

  $bd->close();
  gotoUrl("index.php?page=".$_POST["nompage"]."&module=".$_POST["nommodule"]."&parenttab=".$_POST["nomparenttab"]);

}elseif($_GET["task"]=='new' || $_GET["task"]=='edit'){
  if($_GET["task"]=='edit'){
     $data_producto=executesql("select * from categoria_examenes where id_cate='".$_GET["id_cate"]."'",0);
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
              <h3 class="box-title">Categoría</h3>
            </div>
<?php $task_=$_GET["task"]; ?>            
            <form id="registro" action="categoria_examenes.php?task=<?php echo ($task_=='edit') ?  "update" : "insert"; ?>" class="form-horizontal" method="POST" enctype="multipart/form-data" onsubmit="return aceptar()">
<?php 
if($task_=='edit') create_input("hidden","id_cate",$data_producto["id_cate"],"",$table,"");
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
						
<?php /* 
								<div class="form-group">
									<label for="inputPassword3" class="col-md-2 col-sm-2 control-label">Estado examen:</label>
									<div class="col-sm-3">
										<select id="estado" name="estado" class="form-control" requerid >  <!-- saco valor desde la BD -->
											<option value="" >-- selecciona --</option>  
											<option value="1" <?php echo ($data_producto['estado'] == 'A') ? 'selected' : '' ;?>>A</option>  
											<option value="2"  <?php echo ($data_producto['estado'] == 'E') ? 'selected' : '' ;?>>E</option>
										</select>
                  </div>
								</div>
									*/ ?>	
									
								<div class="form-group">
                  <label for="inputPassword3" class="col-md-2 col-sm-2 control-label">Título</label>
                  <div class="col-sm-6">
                    <?php create_input("text","titulo",$data_producto["titulo"],"form-control",$table,"",$agregado); ?>
                  </div>
                </div>  
                
                <div class="form-group">
									<label for="inputPassword3" class="col-md-2 col-sm-2 control-label">Mostar categoria en la web (si/no):</label>
									<div class="col-sm-3">
										<select id="mostrar_en_la_web" name="mostrar_en_la_web" class="form-control" requerid >  <!-- saco valor desde la BD -->
											<option value="1" <?php echo ($data_producto['mostrar_en_la_web'] == 1) ? 'selected' : '' ;?>>SI  </option>  
											<option value="2"  <?php echo ($data_producto['mostrar_en_la_web'] == 2) ? 'selected' : '' ;?>>NO</option>
										</select>
                  </div>
								</div>


                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Imagen: 										<span class="red">268px ancho * 137px alto</span></label> </label>
                  <div class="col-sm-6">
                    <input type="file" name="imagen" id="imagen" class="form-control">
                    <?php create_input("hidden","imagen_ant",$data_producto["imagen"],"",$table,$agregado); 
                      if($data_producto["imagen"]!=""){ 
                    ?>
                      <img src="<?php echo "files/images/categoria_examenes/".$data_producto["imagen"]; ?>" width="200" class="mgt15">
                    <?php } ?> 
                  </div>
                </div>

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
  $id_cate = !isset($_GET['id_cate']) ? implode(',', $_GET['chkDel']) : $_GET['id_cate'];

  $bd->actualiza_("DELETE FROM categoria_examenes WHERE id_cate IN(".$id_cate.")");
  $bd->Commit();
  $bd->close();


}elseif($_GET["task"]=='ordenar'){

  $bd = new BD;
  $_GET['order'] = array_reverse($_GET['order']);
  foreach ($_GET['order'] as $order => $item) {
    $orden = $orden + 1;

   $_sql_orden="UPDATE categoria_examenes SET orden= ".$orden." WHERE id_cate = ".$item."";

    $bd->actualiza_($_sql_orden);
  }
  $bd->Commit();
  $bd->close();

}elseif($_GET["task"]=='uestado'){

  $bd = new BD;
  $bd->Begin();
  $id_cate = !isset($_GET['id_cate']) ? $_GET['estado_idestado'] : $_GET['id_cate'];
  $id_cate = is_array($id_cate) ? implode(',',$id_cate) : $id_cate;
  $categoria_examenes = executesql("SELECT * FROM categoria_examenes WHERE id_cate IN (".$id_cate.")");
  if(!empty($categoria_examenes))
    foreach($categoria_examenes as $reg => $item)
      if ($item['estado_idestado']==1) {
        $state = 2;
      }elseif ($item['estado_idestado']==2) {
        $state = 1;
      }
  $bd->actualiza_("UPDATE categoria_examenes SET estado_idestado=".$state." WHERE id_cate=".$id_cate."");
  echo $state;
  $bd->Commit();
  $bd->close();

}elseif($_GET["task"]=='finder'){
	$array= array();
	$meses=array('Jan'=>'Enero','Feb'=>'Febrero','Mar'=>'Marzo','Apr'=>'Abril','May'=>'Mayo','Jun'=>'Junio','Jul'=>'Julio','Aug'=>'Agosto','Sep'=>'Septiembre','Oct'=>'Octubre','Nov'=>'Noviembre','Dec'=>'Diciembre');
	
  $sql = "SELECT  c.*, e.nombre as estado FROM categoria_examenes c INNER JOIN estado e ON c.estado_idestado=e.idestado where c.estado_idestado=1 "; 
  if(isset($_GET['criterio_mostrar'])) $porPagina=$_GET['criterio_mostrar'];
  if(isset($_GET['criterio_usu_per']) && !empty($_GET['criterio_usu_per'])){
    $stringlike=fn_filtro(substr($_GET['criterio_usu_per'], 0, 16));
    $sql.= " and  ( c.titulo LIKE '%".$stringlike."%'  )  ";
		
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
  $paging->porPagina(1000);
  $paging->ejecutar();
  $paging->pagina_proceso="categoria_examenes.php";
?>
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr role="row"> 
                  <th class="sort">ID </th>
                  <th class="sort">TÍTULO </th>
                  <th class="sort cnone" width="60">ESTADO</th>
                  <th class="unafbe" width="100">OPCIONES</th>
                </tr>
              </thead>
              			<tbody id="sort">

<?php 
		while ($detalles = $paging->fetchResultado()):
?>
							
              <tr id="order_<?php echo $detalles["id_cate"]; ?>">
                  <td><?php echo $detalles["id_cate"]; ?></td>
                  <td><?php echo $detalles["titulo"]; ?></td>
                  <td class="cnone"><a href="javascript: fn_estado('<?php echo $detalles["id_cate"]; ?>')"><?php echo $detalles["estado"]; ?></a></td>
                  <td>
                    <div class="btn-eai  text-center btns btr   ">				
											<a href="index.php?page=categoria_examenes&module=Ver&parenttab=categoria_examenes
												<?php echo $_SESSION["base_url"].'&task=edit&id_cate='.$detalles["id_cate"]; ?>" style="color:#fff;"><i class="fa fa-edit"></i> <span>editar</span>
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
  // checked();
  sorter();
   reordenar('categoria_examenes.php');
});
var mypage = "categoria_examenes.php";
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
                    <a href="<?php echo $link2."&task=new"; ?>" style="color:#fff;"><i class="fa fa-file"></i> Agregar </a>                    
                  </div>
                </div>
							
                <div class="col-sm-3 criterio_buscar">
                  <?php create_input('text','criterio_usu_per','',"form-control pull-right",$table,'placeholder="Buscar .."'); ?>
                </div>
							  <div class="col-sm-7 criterio_mostrar">
									<div class="lleva_flechas" style="position:relative;">
										<?php create_input('hidden', 'fechabus_1', '', "form-control pull-right", $table, ''); ?>
									</div>
									<div class="lleva_flechas" style="position:relative;">										<?php create_input('hidden', 'fechabus_2', '', "form-control pull-right", $table, ''); ?>
									</div>
										<button>Buscar</button>
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
var link = "categoria_examene";
var us = "examen";
var ar = "la";
var l = "a";
var l2 = "a";
var pr = "La";
var id = "id_cate";
var mypage = "categoria_examenes.php";
</script>

<?php } ?>