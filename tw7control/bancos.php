<?php error_reporting(E_ALL ^ E_NOTICE);
include ("auten.php");


if($_GET["task"]=='neworden'){
  $bd=new BD;
  $orden_actual=$_GET["orden"];
  $orden_nuevo=$_GET["nuevoorden"];
  $tipo=$_GET["tipo"];  
  $id_del_registro_actual=$_GET["id_banco"];
  $criterio_Orden =" ";
  nuevoorden($orden_actual, $orden_nuevo, $tipo, $id_del_registro_actual, "bancos", "id_banco", $criterio_Orden);    
  $bd->close();

}elseif($_GET["task"]=='insert' || $_GET["task"]=='update'){
  $bd=new BD;
  $where = ($_GET["task"]=='update') ? "and id_banco!='".$_POST["id_banco"]."'" : '';
  $urlrewrite=armarurlrewrite($_POST["nombre"]);
  $urlrewrite=armarurlrewrite($urlrewrite,1,"bancos","id_banco","nombre_rewrite",$where);

  $campos=array('nombre', array('nombre_rewrite',$urlrewrite),'titular','cuenta','cuenta_cci',"estado_idestado"); 
  
  if($_GET["task"]=='insert'){
    if(isset($_FILES['imagen']) && !empty($_FILES['imagen']['name'])){
      $_POST['imagen'] = carga_imagen('files/images/bancos/','imagen','','100','100');
      $campos = array_merge($campos,array('imagen'));
    }
    
    if(isset($_FILES['imagen_2']) && !empty($_FILES['imagen_2']['name'])){
      $_POST['imagen_2'] = carga_imagen('files/images/bancos/','imagen_2','','179','280');
      $campos = array_merge($campos,array('imagen_2'));
    }
    // if(isset($_FILES['archivo']) && !empty($_FILES['archivo']['name'])){
      // $_POST['archivo'] = upload_files('files/files/','archivo','',0);
      // $campos = array_merge($campos,array('archivo'));
    // }
    $_POST['orden'] = _orden_noticia("","bancos","");
    $_POST['fecha_registro'] = fecha_hora(2);
		
		$bd->inserta_(arma_insert('bancos',array_merge($campos,array('orden','fecha_registro')),'POST'));
		
  }else{
    if(isset($_FILES['imagen']) && !empty($_FILES['imagen']['name'])){
      $path = 'files/images/bancos/'.$_POST['imagen_ant'];
      if( file_exists($path) && !empty($_POST['imagen_ant']) ) unlink($path);    
      $_POST['imagen'] = carga_imagen('files/images/bancos/','imagen','','100','100');
      $campos = array_merge($campos,array('imagen'));
    }
    
    if(isset($_FILES['imagen_2']) && !empty($_FILES['imagen_2']['name'])){
      $path = 'files/images/bancos/'.$_POST['imagen_ant_2'];
      if( file_exists($path) && !empty($_POST['imagen_ant_2']) ) unlink($path);    
      $_POST['imagen_2'] = carga_imagen('files/images/bancos/','imagen_2','','179','280');
      $campos = array_merge($campos,array('imagen_2'));
    }

    // if(isset($_FILES['archivo']) && !empty($_FILES['archivo']['name'])){
      // $path = 'files/files/'.$_POST['archivo_ant'];
      // if( file_exists($path) && !empty($_POST['archivo_ant']) ) unlink($path);    
      // $_POST['archivo'] = carga_imagen('files/files/','archivo','');
      // $campos = array_merge($campos,array('archivo'));
    // }
    $bd->actualiza_(armaupdate('bancos',$campos," id_banco='".$_POST["id_banco"]."'",'POST'));/*actualizo*/
  }

  $bd->close();
  gotoUrl("index.php?page=".$_POST["nompage"]."&module=".$_POST["nommodule"]."&parenttab=".$_POST["nomparenttab"]);

}elseif($_GET["task"]=='new' || $_GET["task"]=='edit'){
  if($_GET["task"]=='edit'){
     $data_producto=executesql("select * from bancos where id_banco='".$_GET["id_banco"]."'",0);
  }
?>
<script src="ckeditor/sample.js"></script>
<script src="ckeditor/ckeditor.js"></script>
<script src="ckfinder/ckfinder.js"></script>

<section class="content">
  <div class="row">
    <div class="col-md-12">          
          <div class="box box-info">
            <div class="box-header with-border"><h3 class="box-title">Medios de pago OFFline </h3></div>
<?php $task_=$_GET["task"]; ?>            
            <form id="registro" action="bancos.php?task=<?php echo ($task_=='edit') ?  "update" : "insert"; ?>" class="form-horizontal" method="POST" enctype="multipart/form-data"  onsubmit="return aceptar()">
<?php 
if($task_=='edit') create_input("hidden","id_banco",$data_producto["id_banco"],"",$table,"");
create_input("hidden","urlfailed",basename($_SERVER['REQUEST_URI']),"",$table,"");  
create_input("hidden","urlgo",$link,"",$table,"");
create_input("hidden","nompage",$_GET["page"],"",$table,""); 
create_input("hidden","nommodule",$_GET["module"],"",$table,"");
create_input("hidden","nomparenttab",$_GET["parenttab"],"",$table,"");
?>
              <div class="box-body">								
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Estado</label>
                  <div class="col-sm-6">
                    <?php crearselect("estado_idestado","select * from estado where idestado in('1','2') order by 2 desc",'class="form-control"',$data_producto["estado_idestado"],""); ?>
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Nombre de entidad: </label>
                  <div class="col-sm-6">
                    <?php create_input("text","nombre",$data_producto["nombre"],"form-control",$table,"",$agregado); ?>
                  </div>
                </div>		
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Nombre del titular: </label>
                  <div class="col-sm-6">
                    <?php create_input("text","titular",$data_producto["titular"],"form-control",$table,"",$agregado); ?>
                  </div>
                </div>	

								<div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">cuenta:</label>
                  <div class="col-sm-6">
                    <?php create_input("text","cuenta",$data_producto["cuenta"],"form-control",$table,"",$agregado); ?>
                  </div>
                </div>	
								<div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">cuenta CCI:</label>
                  <div class="col-sm-6">
                    <?php create_input("text","cuenta_cci",$data_producto["cuenta_cci"],"form-control",$table,"",$agregado); ?>
                  </div>
                </div>	
  
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Imagen banco: 100 x 100px</label>
                  <div class="col-sm-6">
                    <input type="file" name="imagen" id="imagen" class="form-control">
                    <?php create_input("hidden","imagen_ant",$data_producto["imagen"],"",$table,$agregado); 
                      if($data_producto["imagen"]!=""){ 
                    ?>
                      <img src="<?php echo "files/images/bancos/".$data_producto["imagen"]; ?>" width="200" class="mgt15">
                    <?php } ?> 
                  </div>
                </div>
                
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Imagen yape/plin:  179 x 255px</label>
                  <div class="col-sm-6">
                    <input type="file" name="imagen_2" id="imagen_2" class="form-control">
                    <?php create_input("hidden","imagen_ant_2",$data_producto["imagen_2"],"",$table,$agregado); 
                      if($data_producto["imagen_2"]!=""){ 
                    ?>
                      <img src="<?php echo "files/images/bancos/".$data_producto["imagen_2"]; ?>" width="200" class="mgt15">
                    <?php } ?> 
                  </div>
                </div>


              </div>
              <div class="box-footer">
                <div class="form-group">
                  <div class="col-sm-10 pull-right">
                    <input  type="submit"  class="btn bg-blue btn-flat" id="btnguardar" value="Guardar">
                    <button type="button" class="btn bg-red btn-flat" onclick="javascript:gotourl('<?php echo $link; ?>');">Cancelar</button>
                  </div>
                </div>
              </div>
<script>	
function aceptar(){
	var nam1=document.getElementById("nombre").value;		
	
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
  $ide = !isset($_GET['id_banco']) ? implode(',', $_GET['chkDel']) : $_GET['id_banco'];
  
    $sql_="SELECT * FROM bancos WHERE id_banco IN (".$ide.")"; 

  $categoria = executesql($sql_);
  if(!empty($categoria)){
    foreach($categoria as $row){
      $pfile = 'files/images/bancos/'.$row['imagen']; 
      $pfile_2 = 'files/images/bancos/'.$row['imagen_2']; 
      if(file_exists($pfile) && !empty($row['imagen'])) unlink($pfile);
      if(file_exists($pfile_2) && !empty($row['imagen_2'])) unlink($pfile_2);
    }
  }
  
  $sql_delete="DELETE FROM bancos WHERE id_banco IN (".$ide.")";
  
  $bd->actualiza_($sql_delete); 
  $bd->Commit();
  $bd->close();

  if($num_afect<=0){echo "Error: eliminando registro"; exit;}


}elseif($_GET["task"]=='ordenar'){

  $bd = new BD;
  $_GET['order'] = array_reverse($_GET['order']);
  foreach ($_GET['order'] as $order => $item) {
    $orden = $orden + 1;
    $bd->actualiza_("UPDATE bancos SET orden= ".$orden." WHERE id_banco = ".$item."");
  }
  $bd->Commit();
  $bd->close();

}elseif($_GET["task"]=='uestado'){

  $bd = new BD;
  $bd->Begin();

  $ide = !isset($_GET['id_banco']) ? $_GET['estado_idestado'] : $_GET['id_banco'];
  $ide = is_array($ide) ? implode(',',$ide) : $ide;
  $bancos = executesql("SELECT * FROM bancos WHERE id_banco IN (".$ide.")");

  if(!empty($bancos))
    foreach($bancos as $reg => $item)
      if ($item['estado_idestado']==1) {
        $state = 2;
      }elseif ($item['estado_idestado']==2) {
        $state = 1;
      }
  $bd->actualiza_("UPDATE bancos SET estado_idestado=".$state." WHERE id_banco=".$ide."");
  echo $state;
  $bd->Commit();
  $bd->close();

}elseif($_GET["task"]=='finder'){

  $sql = "SELECT p.*, e.nombre as estado FROM bancos p 
	 inner join estado e ON p.estado_idestado=e.idestado 	 "; 
	 
  if(isset($_GET['criterio_mostrar'])) $porPagina=$_GET['criterio_mostrar'];
  if(isset($_GET['criterio_usu_per']) && !empty($_GET['criterio_usu_per'])){
    $stringlike=fn_filtro(substr($_GET['criterio_usu_per'], 0, 16));
    $sql.= " where nombre LIKE '%".$stringlike."%'  or cuenta LIKE '%".$stringlike."%'  or cuenta_cci LIKE '%".$stringlike."%'  ";
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
  $paging->pagina_proceso="bancos.php";
?>
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr role="row">
                  <th class="unafbe" width="20"><input type="checkbox" id="chkDel" class="all"></th>
                  <th class="sort">ID</th>
                  <th class="sort">Entidad</th>
                  <th class="sort">titular</th>
                  <th class="sort">CUENTA</th>
                  <th class="sort">CCI</th>
                  <th class="sort">IMG</th>
                  <th class="sort cnone">ESTADO</th>
									
                  <th class="unafbe" width="130">Opciones</th>
                </tr>
              </thead>
              <tbody id="sort">
<?php while ($cuentas = $paging->fetchResultado()): ?>
                <tr id="order_<?php echo $cuentas["id_banco"]; ?>">
                  <td><input type="checkbox" name="chkDel[]" class="chkDel" value="<?php echo $cuentas["id_banco"]; ?>"></td>
                  <td><?php echo $cuentas["id_banco"]; ?></td>                                               
                  <td><?php echo $cuentas["nombre"]; ?></td>                                               
                  <td><?php echo $cuentas["titular"]; ?></td>                                               
                  <td><?php echo $cuentas["cuenta"]; ?></td>                                               
                  <td><?php echo $cuentas["cuenta_cci"]; ?></td>    
									<td class="cnone">
                    <?php if(!empty($cuentas["imagen"])){ ?>
                    <img src="<?php echo "files/images/bancos/".$cuentas["imagen"]; ?>" alt="<?php echo $cuentas["nombre"]; ?>" class="img-responsive">
                    <?php }else{ echo "Not Image."; } ?>
                  </td>
                  <td class="cnone"><a href="javascript: fn_estado('<?php echo $cuentas["id_banco"]; ?>')"><?php echo $cuentas["estado"]; ?></a></td>
								 <td>
                    <div class="btn-eai btns btr">
                      <a href="<?php echo $_SESSION["base_url"].'&task=edit&id_banco='.$cuentas["id_banco"]; ?>" style="color:#fff;"><i class="fa fa-edit"></i> editar</a>
                      <a href="javascript: fn_eliminar('<?php echo $cuentas["id_banco"]; ?>')"><i class="fa fa-trash-o"></i> </a>

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
  reordenar('bancos.php');
});
var mypage = "bancos.php";
</script>

<?php }else{ ?>
        <div class="box-body">
          <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
            <form action="javascript: fn_buscar();" id="frm_buscar" name="frm_buscar">
							<input type="hidden" name="id_tipo" value="<?php echo $_GET['id_tipo'];?> ">
              <div class="bg-gray-light">
								
                <div class="col-sm-2">
                  <div class="btn-eai" >
                    <a href="<?php echo $link."&task=new"; ?>" style="color:#fff;"><i class="fa fa-file" style="padding-right:8px;"></i> Agregar</a>
										<!-- 
                    <a href="javascript:fn_delete_all();"><i class="fa fa-trash-o"></i></a>
										-->
                  
                  </div>
                </div>
                
                <div class="col-sm-2 criterio_buscar">
                  <?php create_input('text','criterio_usu_per','',"form-control pull-right",$table,'placeholder="Buscar.."'); ?>
                </div>
                <div class="col-sm-2  criterio_mostrar">
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
var us = "bancos";
var link = "banco";
var ar = "la";
var l = "e";
var l2 = "e";
var pr = "La";
var id = "id_banco";
var mypage = "bancos.php";
</script>

<?php } ?>