<?php error_reporting(E_ALL ^ E_NOTICE);
include ("auten.php");


if($_GET["task"]=='neworden'){
  $bd=new BD;
  $orden_actual=$_GET["orden"];
  $orden_nuevo=$_GET["nuevoorden"];
  $tipo=$_GET["tipo"];  
  $id_del_registro_actual=$_GET["idelos"];
  $criterio_Orden =" ";
  nuevoorden($orden_actual, $orden_nuevo, $tipo, $id_del_registro_actual, "certificados_periodos", "idelos", $criterio_Orden);    
  $bd->close();

}elseif($_GET["task"]=='insert' || $_GET["task"]=='update'){
  $bd=new BD;
  $campos=array('nombre','fecha_inicio','fecha_fin',"estado_idestado"); 
  
  if($_GET["task"]=='insert'){ 
    $_POST['orden'] = _orden_noticia("","certificados_periodos","");
    $_POST['fecha_registro'] = fecha_hora(2);
		
		$bd->inserta_(arma_insert('certificados_periodos',array_merge($campos,array('orden','fecha_registro')),'POST'));
		
  }else{
   
    $bd->actualiza_(armaupdate('certificados_periodos',$campos," idelos='".$_POST["idelos"]."'",'POST'));/*actualizo*/
  }
  $bd->close();
  gotoUrl("index.php?page=".$_POST["nompage"]."&module=".$_POST["nommodule"]."&parenttab=".$_POST["nomparenttab"]);

}elseif($_GET["task"]=='new' || $_GET["task"]=='edit'){
  if($_GET["task"]=='edit'){
     $data_producto=executesql("select * from certificados_periodos where idelos='".$_GET["idelos"]."'",0);
  }
?>
<script src="ckeditor/sample.js"></script>
<script src="ckeditor/ckeditor.js"></script>
<script src="ckfinder/ckfinder.js"></script>

<section class="content">
  <div class="row">
    <div class="col-md-12">          
          <div class="box box-info">
            <div class="box-header with-border"><h3 class="box-title"> Periodos de certificados  </h3></div>
<?php $task_=$_GET["task"]; ?>            
            <form id="registro" action="certificados_periodos.php?task=<?php echo ($task_=='edit') ?  "update" : "insert"; ?>" class="form-horizontal" method="POST" enctype="multipart/form-data"  onsubmit="return aceptar()">
<?php 
if($task_=='edit') create_input("hidden","idelos",$data_producto["idelos"],"",$table,"");
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
                  <label for="inputPassword3" class="col-sm-2 control-label">Nombre periodo: </label>
                  <div class="col-sm-6">
                    <?php create_input("text","nombre",$data_producto["nombre"],"form-control",$table,"",$agregado); ?>
                  </div>
                </div>		
								
                <div class="form-group">
                   <label for="inputPassword3" class="col-sm-2 control-label">Fecha inicio rango:</label>
                    <div class="col-sm-4">
                      <?php create_input("date","fecha_inicio",$usuario["fecha_inicio"],"form-control",$table," required ",$agregado); ?>
                    </div>
                </div>
                <div class="form-group">
                   <label for="inputPassword3" class="col-sm-2 control-label">Fecha fin rango:</label>
                    <div class="col-sm-4">
                      <?php create_input("date","fecha_fin",$usuario["fecha_fin"],"form-control",$table," required ",$agregado); ?>
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


}elseif($_GET["task"]=='ordenar'){

  $bd = new BD;
  $_GET['order'] = array_reverse($_GET['order']);
  foreach ($_GET['order'] as $order => $item) {
    $orden = $orden + 1;
    $bd->actualiza_("UPDATE certificados_periodos SET orden= ".$orden." WHERE idelos = ".$item."");
  }
  $bd->Commit();
  $bd->close();

}elseif($_GET["task"]=='uestado'){

  $bd = new BD;
  $bd->Begin();

  $ide = !isset($_GET['idelos']) ? $_GET['estado_idestado'] : $_GET['idelos'];
  $ide = is_array($ide) ? implode(',',$ide) : $ide;
  $certificados_periodos = executesql("SELECT * FROM certificados_periodos WHERE idelos IN (".$ide.")");

  if(!empty($certificados_periodos))
    foreach($certificados_periodos as $reg => $item)
      if ($item['estado_idestado']==1) {
        $state = 2;
      }elseif ($item['estado_idestado']==2) {
        $state = 1;
      }
  $bd->actualiza_("UPDATE certificados_periodos SET estado_idestado=".$state." WHERE idelos=".$ide."");
  echo $state;
  $bd->Commit();
  $bd->close();

}elseif($_GET["task"]=='finder'){

  $sql = "SELECT p.*, e.nombre as estado FROM certificados_periodos p 
	 inner join estado e ON p.estado_idestado=e.idestado 	 "; 
	 
  if(isset($_GET['criterio_mostrar'])) $porPagina=$_GET['criterio_mostrar'];
  if(isset($_GET['criterio_usu_per']) && !empty($_GET['criterio_usu_per'])){
    $stringlike=fn_filtro(substr($_GET['criterio_usu_per'], 0, 16));
    $sql.= " where nombre LIKE '%".$stringlike."%'   ";
  }
  if(isset($_GET['criterio_ordenar_por'])) $sql.= sprintf(" order by %s %s", fn_filtro($_GET['criterio_ordenar_por']), fn_filtro($_GET['criterio_orden']));
  $sql.= " ORDER BY idelos DESC";
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
  $paging->pagina_proceso="certificados_periodos.php";
?>
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr role="row">
                  <th class="unafbe" width="20"><input type="checkbox" id="chkDel" class="all"></th>
                  <th class="sort">ID</th>
                  <th class="sort">NOMBRE PERIODO</th>
                  <th class="sort">F. INICIO</th>
                  <th class="sort">F. FIN</th>
                  <th class="sort cnone">ESTADO</th>
									<!-- 
                  <th class="unafbe" width="130">Opciones</th>
									-->
                </tr>
              </thead>
              <tbody id="sort">
<?php while ($cuentas = $paging->fetchResultado()): ?>
                <tr id="order_<?php echo $cuentas["idelos"]; ?>">
                  <td><input type="checkbox" name="chkDel[]" class="chkDel" value="<?php echo $cuentas["idelos"]; ?>"></td>
                  <td><?php echo $cuentas["idelos"]; ?></td>                                               
                  <td><?php echo $cuentas["nombre"]; ?></td>                                               
                  <td><?php echo $cuentas["fecha_inicio"]; ?></td>                                               
                  <td><?php echo $cuentas["fecha_fin"]; ?></td>    
<?php /*									
									<td class="cnone">
                    <?php if(!empty($cuentas["imagen"])){ ?>
                    <img src="<?php echo "files/images/certificados_periodos/".$cuentas["imagen"]; ?>" alt="<?php echo $cuentas["nombre"]; ?>" class="img-responsive">
                    <?php }else{ echo "Not Image."; } ?>
                  </td>
						*/ ?>
                  <td class="cnone"><a href="javascript: fn_estado('<?php echo $cuentas["idelos"]; ?>')"><?php echo $cuentas["estado"]; ?></a></td>
<!--                  
								 <td>
                    <div class="btn-eai btns btr">
                      <a href="<?php echo $_SESSION["base_url"].'&task=edit&idelos='.$cuentas["idelos"]; ?>" style="color:#fff;"><i class="fa fa-edit"></i> editar</a>
                    </div>
										
                  </td>
									-->
                </tr>
<?php endwhile; ?>
              </tbody>
            </table>
            <div class="pagination"><?php echo $paging->fetchNavegacion(); ?></div>
<script>
$(function(){
  checked();
  sorter();
  reordenar('certificados_periodos.php');
});
var mypage = "certificados_periodos.php";
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
var us = "periodo";
var link = "certificados_periodo";
var ar = "la";
var l = "e";
var l2 = "e";
var pr = "La";
var id = "idelos";
var mypage = "certificados_periodos.php";
</script>

<?php } ?>