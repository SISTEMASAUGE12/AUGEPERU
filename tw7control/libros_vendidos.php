<?php error_reporting(E_ALL ^ E_NOTICE);
include ("auten.php");


if($_GET["task"]=='neworden'){
  $bd=new BD;
  $orden_actual=$_GET["orden"];
  $orden_nuevo=$_GET["nuevoorden"];
  $tipo=$_GET["tipo"];  
  $id_del_registro_actual=$_GET["ide"];
  $criterio_Orden =" ";
  nuevoorden($orden_actual, $orden_nuevo, $tipo, $id_del_registro_actual, "libros_vendidos", "ide", $criterio_Orden);    
  $bd->close();

}elseif($_GET["task"]=='insert' || $_GET["task"]=='update'){
  $bd=new BD;
  $campos=array('id_libro','id_suscrito','estado_entrega','fecha_envio'); 
  
  if($_GET["task"]=='insert'){
		$_POST['estado_idestado']=1;
    
    $_POST['orden'] = _orden_noticia("","libros_vendidos","");
    $_POST['fecha_registro'] = fecha_hora(2);

		// echo var_dump(arma_insert('libros_vendidos',array_merge($campos,array('orden','fecha_registro','estado_idestado')),'POST'));
		// exit();
		
    $bd->inserta_(arma_insert('libros_vendidos',array_merge($campos,array('orden','fecha_registro','estado_idestado')),'POST'));
		
		
  }else{
    
    $bd->actualiza_(armaupdate('libros_vendidos',$campos," ide='".$_POST["ide"]."'",'POST'));/*actualizo*/
  }
  $bd->close();
  gotoUrl("index.php?page=".$_POST["nompage"]."&id_suscrito=".$_POST["id_suscrito"]."&module=".$_POST["nommodule"]."&parenttab=".$_POST["nomparenttab"]);

}elseif($_GET["task"]=='new' || $_GET["task"]=='edit'){
  if($_GET["task"]=='edit'){
     $data_producto=executesql("select * from libros_vendidos where ide='".$_GET["ide"]."'",0);
  }
?>
<script src="ckeditor/sample.js"></script>
<script src="ckeditor/ckeditor.js"></script>
<script src="ckfinder/ckfinder.js"></script>

<section class="content">
  <div class="row">
    <div class="col-md-12">          
          <div class="box box-info">
            <div class="box-header with-border"><h3 class="box-title">libros_vendidos </h3></div>
<?php $task_=$_GET["task"]; ?>            
            <form id="registro" action="libros_vendidos.php?task=<?php echo ($task_=='edit') ?  "update" : "insert"; ?>" class="form-horizontal" method="POST" enctype="multipart/form-data"  onsubmit="return aceptar()">
<?php 
if($task_=='edit') create_input("hidden","ide",$data_producto["ide"],"",$table,"");
create_input("hidden","urlfailed",basename($_SERVER['REQUEST_URI']),"",$table,"");  
create_input("hidden","urlgo",$link,"",$table,"");
create_input("hidden","id_suscrito",$_GET["id_suscrito"],"",$table,"");
create_input("hidden","nompage",$_GET["page"],"",$table,""); 
create_input("hidden","nommodule",$_GET["module"],"",$table,"");
create_input("hidden","nomparenttab",$_GET["parenttab"],"",$table,"");
?>
              <div class="box-body">								
               
								
								<div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Estado entrega: </label>
                  <div class="col-sm-6">
                    <select id="estado_entrega" name="estado_entrega" class="form-control" requerid >  <!-- saco valor desde la BD -->
											<option value="" >-- selecciona --</option>  
											<option value="1" <?php echo ($data_producto['estado_entrega'] == 1) ? 'selected' : '' ;?>>Entregado</option>  
											<option value="2"  <?php echo ($data_producto['estado_entrega'] == 2) ? 'selected' : '' ;?>>Pendiente</option>
										</select>
                  </div>
                </div>

								<div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Libro:</label>
                  <div class="col-sm-6">
                    <?php crearselect("id_libro","select id_libro, CONCAT(titulo,' - s/',precio) as titulo from libros where estado_idestado=1 order by titulo asc",'class="form-control"',$data_producto["id_libro"],""); ?>
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Fecha envio:</label>
                  <div class="col-sm-6">
                    <?php create_input("date","fecha_envio",$data_producto["fecha_envio"],"form-control",$table,"",$agregado); ?>
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
  $ide = !isset($_GET['ide']) ? implode(',', $_GET['chkDel']) : $_GET['ide'];
  $libros_vendidos = executesql("SELECT * FROM libros_vendidos WHERE ide IN(".$ide.")");
  if(!empty($libros_vendidos)){
    foreach($libros_vendidos as $row){
      $pfile = 'files/images/libros_vendidos/'.$row['imagen']; if(file_exists($pfile) && !empty($row['imagen'])){ unlink($pfile); }
      // $pfile = 'files/files/'.$row['archivo']; if(file_exists($pfile) && !empty($row['archivo'])){ unlink($pfile); }
    }
  }

  $bd->actualiza_("DELETE FROM libros_vendidos WHERE ide IN(".$ide.")");
  $bd->Commit();
  $bd->close();

}elseif($_GET["task"]=='ordenar'){

  $bd = new BD;
  $_GET['order'] = array_reverse($_GET['order']);
  foreach ($_GET['order'] as $order => $item) {
    $orden = $orden + 1;
    $bd->actualiza_("UPDATE libros_vendidos SET orden= ".$orden." WHERE ide = ".$item."");
  }
  $bd->Commit();
  $bd->close();

}elseif($_GET["task"]=='uestado'){

  $bd = new BD;
  $bd->Begin();

  $ide = !isset($_GET['ide']) ? $_GET['estado_idestado'] : $_GET['ide'];
  $ide = is_array($ide) ? implode(',',$ide) : $ide;
  $libros_vendidos = executesql("SELECT * FROM libros_vendidos WHERE ide IN (".$ide.")");

  if(!empty($libros_vendidos))
    foreach($libros_vendidos as $reg => $item)
      if ($item['estado_idestado']==1) {
        $state = 2;
      }elseif ($item['estado_idestado']==2) {
        $state = 1;
      }
  $bd->actualiza_("UPDATE libros_vendidos SET estado_idestado=".$state." WHERE ide=".$ide."");
  echo $state;
  $bd->Commit();
  $bd->close();

}elseif($_GET["task"]=='finder'){

  $sql = "SELECT p.*, l.titulo as libro, l.precio as precio, e.nombre as estado FROM libros_vendidos p 
	 inner join libros l ON p.id_libro=l.id_libro  
	 inner join estado e ON p.estado_idestado=e.idestado 
	 WHERE p.id_suscrito='".$_GET["id_suscrito"]."' 
	 "; 
  if(isset($_GET['criterio_mostrar'])) $porPagina=$_GET['criterio_mostrar'];
  if(isset($_GET['criterio_usu_per']) && !empty($_GET['criterio_usu_per'])){
    $stringlike=fn_filtro(substr($_GET['criterio_usu_per'], 0, 16));
    $sql.= " and l.titulo LIKE '%".$stringlike."%'  ";
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
  $paging->pagina_proceso="libros_vendidos.php";
?>
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr role="row">
                  <th class="unafbe" width="20"><input type="checkbox" id="chkDel" class="all"></th>
                  <th class="sort">LIBRO</th>
                  <th class="sort">PRECIO</th>
                  <th class="sort cnone">ESTADO ENTREGA</th>
                  <th class="unafbe" width="130">Opciones</th>
                </tr>
              </thead>
              <tbody id="sort">
<?php while ($detalles = $paging->fetchResultado()): ?>
                <tr id="order_<?php echo $detalles["ide"]; ?>">
                  <td><input type="checkbox" name="chkDel[]" class="chkDel" value="<?php echo $detalles["ide"]; ?>"></td>
                  <td><?php echo $detalles["libro"]; ?></td>                                               
                  <td>s/ <?php echo $detalles["precio"]; ?></td>                                               
                  <?php /*
									<td class="cnone">
                    <?php if(!empty($detalles["imagen"])){ ?>
                    <img src="<?php echo "files/images/libros_vendidos/".$detalles["imagen"]; ?>" alt="<?php echo $detalles["titulo"]; ?>" class="img-responsive">
                    <?php }else{ echo "Not Image."; } ?>
                  </td>
*/?>
                  <td class="cnone"><?php echo ($detalles["estado_entrega"]==1)?'ENTREGADO':'PENDIENTE'; ?></td>
                  <td>
                    <div class="btn-eai btns  text-center btr">
                      <a href="<?php echo $_SESSION["base_url"].'&task=edit&ide='.$detalles["ide"]; ?>" style="color:#fff;"><i class="fa fa-edit"></i> editar</a>
											<!-- 
                      <a href="javascript: fn_eliminar('<?php echo $detalles["ide"]; ?>')"><i class="fa fa-trash-o"></i></a>
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
  reordenar('libros_vendidos.php');
});
var mypage = "libros_vendidos.php";
</script>

<?php }else{ ?>
        <div class="box-body">
          <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
            <form action="javascript: fn_buscar();" id="frm_buscar" name="frm_buscar">
							<input type="hidden" name="id_suscrito" value="<?php echo $_GET['id_suscrito'];?> ">
              <div class="bg-gray-light">
								
								   <div class="col-sm-12 criterio_buscar">   
			<?php 
					$sql = "SELECT * FROM suscritos  WHERE id_suscrito='".$_GET['id_suscrito']."'	"; 
					$titu=executesql($sql);
					echo "<h3 style='padding:0 0 20px;margin-top:0;font-size:15px;'><b>Libros del cliente:</b> ".$titu[0]['nombre'].' '.$titu[0]['ap_pa'].' '.$titu[0]['ap_ma']."</h3>";
			?>
					</div>
								
                <div class="col-sm-2">
                  <div class="btn-eai" >
                    <a href="<?php echo $link_lleva_suscrito."&task=new"; ?>" style="color:#fff;"><i class="fa fa-file" style="padding-right:8px;"></i> VENDER</a>
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
									<div class="col-sm-2 criterio_mostrar"><div class="btn-eai">            
									<a href="index.php?page=suscriptores&module=<?php echo $_GET["module"]; ?>&parenttab=<?php echo $_GET["parenttab"]; ?>" title="Regresar << " style="color:#fff;"><i class="fa fa-file" style="padding-right:5px;"></i>  Regresar</a> 
								</div></div>
					
								
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
var us = "libro";
var link = "libro";
var ar = "la";
var l = "e";
var l2 = "e";
var pr = "La";
var id = "ide";
var mypage = "libros_vendidos.php";
</script>

<?php } ?>