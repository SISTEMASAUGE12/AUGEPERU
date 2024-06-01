<?php error_reporting(E_ALL ^ E_NOTICE);
include_once("auten.php");

if($_GET["task"]=='neworden'){
  $bd=new BD;
  $orden_actual=$_GET["orden"];
  $orden_nuevo=$_GET["nuevoorden"];
  $tipo=$_GET["tipo"];  
  $id_del_registro_actual=$_GET["id"];
  $criterio_Orden ="";
  nuevoorden($orden_actual, $orden_nuevo, $tipo, $id_del_registro_actual, "horarios_imagenes", "id", $criterio_Orden);    
  $bd->close();

}elseif($_GET["task"]=='insert' || $_GET["task"]=='update'){
  $bd=new BD;
  $norden=_orden_noticia("","horarios_imagenes","");
  $campos=array("titulo",'descripcion','boton','link', 'tipo',"estado_idestado", array("orden",$norden)); 
  if(!empty($_POST["id_especialidad"]) ){
    $campos=array_merge($campos,array("id_especialidad") ); 			
}


  // $campos=array("estado_idestado", array("orden",$norden)); 
  
  if($_GET["task"]=='insert'){
      if(isset($_FILES['imagen']) && !empty($_FILES['imagen']['name'])){
        $_POST['imagen'] = carga_imagen('files/images/horarios_imagenes/','imagen','','1920','696');
        $campos = array_merge($campos,array('imagen'));
      }

      if(isset($_FILES['imagen2']) && !empty($_FILES['imagen2']['name'])){
        $_POST['imagen2'] = carga_imagen('files/images/horarios_imagenes/','imagen2','','1920','696');
        $campos = array_merge($campos,array('imagen2'));
      }
    $bd->inserta_(arma_insert('horarios_imagenes',$campos,'POST'));

  }else{
      if(isset($_FILES['imagen']) && !empty($_FILES['imagen']['name'])){
      $path = 'files/images/horarios_imagenes/'.$_POST['imagen_ant'];
      if( file_exists($path) && !empty($_POST['imagen_ant']) ) unlink($path);    
      $_POST['imagen'] = carga_imagen('files/images/horarios_imagenes/','imagen','','1920','696');
      $campos = array_merge($campos,array('imagen'));
    }

    if(isset($_FILES['imagen2']) && !empty($_FILES['imagen2']['name'])){
      $path = 'files/images/horarios_imagenes/'.$_POST['imagen_ant_2'];
      if( file_exists($path) && !empty($_POST['imagen_ant_2']) ) unlink($path);    
      $_POST['imagen2'] = carga_imagen('files/images/horarios_imagenes/','imagen2','','1920','696');
      $campos = array_merge($campos,array('imagen2'));
    }
     $bd->actualiza_(armaupdate('horarios_imagenes',$campos," id='".$_POST["id"]."'",'POST'));/*actualizo*/
  }
 
  $bd->close();
  gotoUrl("index.php?page=".$_POST["nompage"]."&module=".$_POST["nommodule"]."&parenttab=".$_POST["nomparenttab"]);  
  
}elseif($_GET["task"]=='new' || $_GET["task"]=='edit'){
  if($_GET["task"]=='edit'){
     $data_producto=executesql("select * from horarios_imagenes where id='".$_GET["id"]."'",0);
  }
?>
<section class="content">
  <div class="row">
    <div class="col-md-12">          
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">
                <?php echo ($_GET["task"]=="edit") ? 'Editar' : 'Nueva'; ?> horarios_imagenes</h3>
                <p style="color:red;">* Esta configuración afecta a la portada de la web. Ruta: <?php echo $_dominio; ?></p>

				<!-- <p>(*) Opcional, no indispensable</p>-->
            </div>
<?php $task_=$_GET["task"]; ?>            
            <form id="registro" action="horarios_imagenes.php?task=<?php echo ($task_=='edit') ?  "update" : "insert"; ?>" class="form-horizontal" method="POST"  enctype="multipart/form-data">
<?php 
if($task_=='edit') create_input("hidden","id",$data_producto["id"],"",$table,""); 

create_input("hidden","urlfailed",basename($_SERVER['REQUEST_URI']),"",$table,"");  
create_input("hidden","urlgo",$link2,"",$table,"");
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
                  <label for="inputPassword3" class="col-sm-2 control-label">Título</label>
                  <div class="col-sm-6">
                    <?php create_input("text","titulo",$data_producto["titulo"],"form-control",$table,"",$agregado); ?>
                  </div>
                </div>	

                <div class="form-group">
									<label for="inputPassword3" class="col-md-2 col-sm-2 control-label">TIPO:</label>
									<div class="col-sm-3">
										<select id="tipo" required name="tipo" class="form-control"  >  <!-- saco valor desde la BD -->
											<option value="" > -- SELECCIONE --</option>  
											<option value="1" <?php echo ($data_producto['tipo'] == 1) ? 'selected' : '' ;?>> NOMBRAMIENTO</option>  
											<option value="2" <?php echo ($data_producto['tipo'] == 2) ? 'selected' : '' ;?>>ASCENSO</option>
										</select>
									</div>	
                </div>	

                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Especialidades</label>
                  <div class="col-sm-6">
                    <?php crearselect("id_especialidad","select * from especialidades where estado_idestado=1 order by titulo asc",'class="form-control" required ',$data_producto["id_especialidad"],"-- seleccione especialidad --"); ?>
                  </div>
                </div>		
				

                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">IMAGEN PC</label>
                  <div class="col-sm-6">
                    <input type="file" name="imagen" id="imagen" class="form-control">
                    <?php create_input("hidden","imagen_ant",$data_producto["imagen"],"",$table,$agregado); 
                      if($data_producto["imagen"]!=""){ 
                    ?>
                      <img src="<?php echo "files/images/horarios_imagenes/".$data_producto["imagen"]; ?>" width="200" class="mgt15">
                    <?php } ?> 
                      <small style="color:red">Recomendado: 465 x 465px</small>
                  </div>
                </div>
             
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">IMAGEN movil </label>
                  <div class="col-sm-6">
                    <input type="file" name="imagen2" id="imagen2" class="form-control">
                    <?php create_input("hidden","imagen_ant_2",$data_producto["imagen2"],"",$table,$agregado); 
                      if($data_producto["imagen2"]!=""){ 
                    ?>
                      <img src="<?php echo "files/images/horarios_imagenes/".$data_producto["imagen2"]; ?>" width="200" class="mgt15">
                    <?php } ?> 
                      <small style="color:red">Recomendado: 425px x 330px aproximado</small>
                  </div>
                </div>
                          
						 
						 
						 
						 
              </div>
              <div class="box-footer">
                <div class="form-group">
                  <div class="col-sm-10 pull-right">
                    <button type="submit" class="btn bg-blue btn-flat">Guardar</button>
                    <button type="button" class="btn bg-red btn-flat" onclick="javascript:gotourl('<?php echo $link2; ?>');">Cancelar</button>
                  </div>
                </div>
              </div>
            </form>
          </div><!-- /.box -->
        </div><!--/.col (right) -->
  </div>
</section><!-- /.content -->
<?php
}elseif($_GET["task"]=='drop' || $_GET["task"]=='dropselect'){
  
  $bd = new BD;
  $bd->Begin();
  $ide = !isset($_GET['id']) ? implode(',', $_GET['chkDel']) : $_GET['id'];
  $categoria = executesql("SELECT imagen FROM horarios_imagenes WHERE id IN(".$ide.")");
  if(!empty($categoria)){
    foreach($categoria as $row){
      $pfile = 'files/images/horarios_imagenes/'.$row['imagen']; 
      if(file_exists($pfile) && !empty($row['imagen'])) unlink($pfile);
    }
  }
  $bd->actualiza_("DELETE FROM horarios_imagenes WHERE id IN(".$ide.")"); 
  $bd->Commit();
  $bd->close();

  if($num_afect<=0){echo "Error: eliminando registro"; exit;}

}elseif($_GET["task"]=='ordenar'){
  $bd = new BD;

  $_GET['order'] = array_reverse($_GET['order']);

  foreach ($_GET['order'] as $order => $item) {
    $orden = $orden + 1;
    $num_afect=$bd->actualiza_("UPDATE horarios_imagenes SET orden= ".$orden." WHERE id = ".$item."");
  }

  $bd->close();

}elseif($_GET["task"]=='uestado'){
  $bd = new BD;
  $bd->Begin();
  $ide = !isset($_GET['id']) ? $_GET['estado_idestado'] : $_GET['id'];
  $ide = is_array($ide) ? implode(',',$ide) : $ide;
  $categoria = executesql("SELECT * FROM horarios_imagenes WHERE id IN (".$ide.")");
  if(!empty($categoria))
  foreach($categoria as $reg => $item)
  if ($item['estado_idestado']==1) {
    $state = 2;
  }elseif ($item['estado_idestado']==2) {
    $state = 1;
  }
  $num_afect=$bd->actualiza_("UPDATE horarios_imagenes SET estado_idestado=".$state." WHERE id=".$ide."");
  echo $state;
  $bd->Commit();
  $bd->close();

}elseif($_GET["task"]=='finder'){

  $sql.= "SELECT c.*,e.nombre AS estado FROM horarios_imagenes c INNER JOIN estado e ON c.estado_idestado=e.idestado";
  if (isset($_GET['criterio_mostrar'])) $porPagina=$_GET['criterio_mostrar'];
  if(isset($_GET['criterio_usu_per']) && !empty($_GET['criterio_usu_per'])){
    $stringlike=fn_filtro(substr($_GET['criterio_usu_per'], 0, 16));
    $sql.= " WHERE c.titulo LIKE '%".$stringlike."%'";
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
  $paging->pagina_proceso="horarios_imagenes.php";
?>
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr role="row">
                  <th class="unafbe" width="20"><input type="checkbox" id="chkDel" class="all"></th>
                  
									<th class=" cnone">TITULO</th>
									<th class=" cnone">TIPO</th>
									<th class="unafbe cnone">BANNER</th>
                  <th class="sort cnone">ESTADO</th>
                  <th class="unafbe">Opciones</th>
                </tr>
              </thead>
              <tbody id="sort">
<?php while ($detalles = $paging->fetchResultado()): ?>
                <tr id="order_<?php echo $detalles["id"]; ?>">
                  <td><input type="checkbox" name="chkDel[]" class="chkDel" value="<?php echo $detalles["id"]; ?>"></td>
									<td><?php echo $detalles["titulo"]; ?></td>
									<td><?php  if($detalles["tipo"]==1){ 
                              echo  'NOMBRAMIENTO';
                            }else if($detalles["tipo"]== 2){
                                echo 'ASCENSO'; ; 
                            
                            }else{
                                echo ' --'; ; 
                            }
                            
                           ?>
                  </td>
									<td>
                    <?php if(!empty($detalles["imagen"])){ ?>
                    <img src="<?php echo "files/images/horarios_imagenes/".$detalles["imagen"]; ?>" alt="<?php echo $detalles["nombre"]; ?>" class="img-responsive">
                    <?php }else{ echo "Not Image."; } ?>
                  </td>
				  
                  <td class="cnone"><a href="javascript: fn_estado('<?php echo $detalles["id"]; ?>')"><?php echo $detalles["estado"]; ?></a></td>
                  <td>
                    <div class="btn-eai btr">
                      <a href="<?php echo $_SESSION["base_url"].'&task=edit&id='.$detalles["id"]; ?>" style="color:#fff;"><i class="fa fa-edit" style="padding-right:3px;"></i> editar</a>
                      <a href="javascript: fn_eliminar('<?php echo $detalles["id"]; ?>')"><i class="fa fa-trash-o"></i> </a>
                    </div>
                  </td>
                </tr>
<?php endwhile; ?>
              </tbody>
            </table>
            <div class="pagination"><?php echo $paging->fetchNavegacion(); ?></div>
<script>
$(function(){
  reordenar('horarios_imagenes.php');
  checked();
  sorter();
});
</script>

<?php }else{ ?>
        <div class="box-body">
          <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
            <form action="javascript: fn_buscar();" id="frm_buscar" name="frm_buscar">
              <div class="bg-gray-light">
                <div class="col-sm-3">
                  <div class="btn-eai" >
                    <a href="<?php echo $link2."&task=new"; ?>" style="color:#fff;"><i class="fa fa-file" style="padding-right:8px;"></i> Agregar</a>
										<!-- 
                    <a href="javascript:fn_delete_all();"><i class="fa fa-trash-o"></i></a>
										-->
                  
                  </div>
                </div>
                <div class="col-sm-3 criterio_buscar">
                  <?php create_input('text','criterio_usu_per','',"form-control pull-right",$table,'placeholder="Buscar.."'); ?>
                </div>
                <div class="col-sm-3 criterio_mostrar">
                  <?php select_sql("nregistros"); ?>
                </div>
								<div class="col-sm-1 criterio_mostrar">
										<button class="btn_action_buscar ">B<span>uscar</span></button>
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
var link = "horarios_imagene";
var us = "horario";
var l = "o";
var l2 = "a";
var pr = "La";
var ar = "la";
var id = "id";
var mypage = "horarios_imagenes.php";
</script>
<?php } ?>