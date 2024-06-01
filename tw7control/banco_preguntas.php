<?php error_reporting(E_ALL ^ E_NOTICE);
include ("auten.php");

if($_GET["task"]=='neworden'){
  $bd=new BD;
  $orden_actual=$_GET["orden"];
  $orden_nuevo=$_GET["nuevoorden"];
  $tipo=$_GET["tipo"];  
  $id_del_registro_actual=$_GET["id_banco"];
  $criterio_Orden =" ";
  nuevoorden($orden_actual, $orden_nuevo, $tipo, $id_del_registro_actual, "banco_preguntas", "id_banco", $criterio_Orden);    
  $bd->close();

}elseif($_GET["task"]=='insert' || $_GET["task"]=='update'){
  
  $bd=new BD;
  
  $campos=array('id_cate','b_pregunta','b_resp1','valor1','b_resp2','valor2','b_resp3','valor3','b_resp4','valor4','b_resp5','valor5','b_solucion','b_puntaje');    
  if($_GET["task"]=='insert'){
    if(isset($_FILES['imagen']) && !empty($_FILES['imagen']['name'])){
      $_POST['imagen'] = carga_imagen('files/images/banco_preguntas/','imagen','','600','450');
      $campos = array_merge($campos,array('imagen'));
    }
    if(isset($_FILES['img2solu']) && !empty($_FILES['img2solu']['name'])){
      $_POST['img2solu'] = carga_imagen('files/images/banco_preguntas/','img2solu','','600','450');
      $campos = array_merge($campos,array('img2solu'));
    }		
    $_POST['orden'] = _orden_noticia("","banco_preguntas","");		
		// echo var_dump(arma_insert('banco_preguntas',array_merge($campos,array('codigo','fecha_registro','orden')),'POST'));
		// exit();
    $_POST["id_banco"]=$bd->inserta_(arma_insert('banco_preguntas',array_merge($campos,array('orden')),'POST'));
		
  }else{
    if(isset($_FILES['imagen']) && !empty($_FILES['imagen']['name'])){
      $path = 'files/images/banco_preguntas/'.$_POST['imagen_ant'];
      if( file_exists($path) && !empty($_POST['imagen_ant']) ) unlink($path);    
      $_POST['imagen'] = carga_imagen('files/images/banco_preguntas/','imagen','');
      $campos = array_merge($campos,array('imagen'));
    }
    if(isset($_FILES['img2solu']) && !empty($_FILES['img2solu']['name'])){
      $path = 'files/images/banco_preguntas/'.$_POST['img2solu_ant'];
      if( file_exists($path) && !empty($_POST['img2solu_ant']) ) unlink($path);    
      $_POST['img2solu'] = carga_imagen('files/images/banco_preguntas/','img2solu','');
      $campos = array_merge($campos,array('img2solu'));
    }

    
    echo var_dump(armaupdate('banco_preguntas',$campos," id_banco='".$_POST["id_banco"]."'",'POST'));
    exit();


    $bd->actualiza_(armaupdate('banco_preguntas',$campos," id_banco='".$_POST["id_banco"]."'",'POST'));/*actualizo*/
  }

  $bd->close();
  gotoUrl("index.php?page=".$_POST["nompage"]."&module=".$_POST["nommodule"]."&parenttab=".$_POST["nomparenttab"]);

}elseif($_GET["task"]=='new' || $_GET["task"]=='edit'){
  if($_GET["task"]=='edit'){
     $data_producto=executesql("select * from banco_preguntas where id_banco='".$_GET["id_banco"]."'",0);
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
              <h3 class="box-title">Banco de preguntas </h3>
            </div>
<?php $task_=$_GET["task"]; ?>            
            <form id="registro" action="banco_preguntas.php?task=<?php echo ($task_=='edit') ?  "update" : "insert"; ?>" class="form-horizontal" method="POST" enctype="multipart/form-data" onsubmit="return aceptar()">
<?php 
if($task_=='edit') create_input("hidden","id_banco",$data_producto["id_banco"],"",$table,"");
create_input("hidden","urlfailed",basename($_SERVER['REQUEST_URI']),"",$table,"");  
create_input("hidden","urlgo",$link2,"",$table,"");
create_input("hidden","nompage",$_GET["page"],"",$table,""); 
create_input("hidden","nommodule",$_GET["module"],"",$table,"");
create_input("hidden","nomparenttab",$_GET["parenttab"],"",$table,"");
?>
              <div class="box-body">
                <div class="form-group">
                  <label for="inputEmail3" class="col-md-2 col-sm-2 control-label">Categoría</label>
                  <div class="col-sm-3">
                    <?php crearselect("id_cate","select * from categoria_examenes where estado_idestado = 1 order by id_cate desc",'class="form-control"',$data_producto["id_cate"],""); ?>
                  </div>                  
                </div>
								<div class="form-group">
                  <label for="inputPassword3" class="col-md-2 col-sm-2 control-label">Título</label>
                  <div class="col-sm-6">
                    <?php create_input("text","b_pregunta",$data_producto["b_pregunta"],"form-control",$table,"",$agregado); ?>
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputPassword3" class="col-md-2 col-sm-2 control-label">Respuesta 1</label>
                  <div class="col-sm-6">
                    <?php create_input("text","b_resp1",$data_producto["b_resp1"],"form-control",$table,"",$agregado); ?>
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputPassword3" class="col-md-2 col-sm-2 control-label">Valor 1</label>
                  <div class="col-sm-6">
                    <?php create_input("text","valor1",$data_producto["valor1"],"form-control",$table,"",$agregado); ?>
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputPassword3" class="col-md-2 col-sm-2 control-label">Respuesta 2</label>
                  <div class="col-sm-6">
                    <?php create_input("text","b_resp2",$data_producto["b_resp2"],"form-control",$table,"",$agregado); ?>
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputPassword3" class="col-md-2 col-sm-2 control-label">Valor 2</label>
                  <div class="col-sm-6">
                    <?php create_input("text","valor2",$data_producto["valor2"],"form-control",$table,"",$agregado); ?>
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputPassword3" class="col-md-2 col-sm-2 control-label">Respuesta 3</label>
                  <div class="col-sm-6">
                    <?php create_input("text","b_resp3",$data_producto["b_resp3"],"form-control",$table,"",$agregado); ?>
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputPassword3" class="col-md-2 col-sm-2 control-label">Valor 3</label>
                  <div class="col-sm-6">
                    <?php create_input("text","valor3",$data_producto["valor3"],"form-control",$table,"",$agregado); ?>
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputPassword3" class="col-md-2 col-sm-2 control-label">Respuesta 4</label>
                  <div class="col-sm-6">
                    <?php create_input("text","b_resp4",$data_producto["b_resp4"],"form-control",$table,"",$agregado); ?>
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputPassword3" class="col-md-2 col-sm-2 control-label">Valor 4</label>
                  <div class="col-sm-6">
                    <?php create_input("text","valor4",$data_producto["valor4"],"form-control",$table,"",$agregado); ?>
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputPassword3" class="col-md-2 col-sm-2 control-label">Respuesta 5</label>
                  <div class="col-sm-6">
                    <?php create_input("text","b_resp5",$data_producto["b_resp5"],"form-control",$table,"",$agregado); ?>
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputPassword3" class="col-md-2 col-sm-2 control-label">Valor 5</label>
                  <div class="col-sm-6">
                    <?php create_input("text","valor5",$data_producto["valor5"],"form-control",$table,"",$agregado); ?>
                  </div>
                </div>

								<div class="form-group">
                  <label for="inputPassword3" class="col-md-2 col-sm-2 control-label">Solución</label>
                  <div class="col-sm-6">
                    <?php create_input("text","b_solucion",$data_producto["b_solucion"],"form-control",$table," requerid ",$agregado); ?>
                  </div>
                </div>
								
								<div class="form-group">
                  <label for="inputPassword3" class="col-md-2 col-sm-2 control-label">Puntaje:</label>
                  <div class="col-sm-6">
                    <?php create_input("text","b_puntaje",$data_producto["b_puntaje"],"form-control",$table,"onkeypress='javascript:return soloNumeros_precio(event,0);'",$agregado); ?>
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
      }
    };
</script>
<?php 

}elseif($_GET["task"]=='uestado'){
  $bd = new BD;
  $bd->Begin();
  $id_banco = !isset($_GET['id']) ? $_GET['estado_idestado'] : $_GET['id'];
  $id_banco = is_array($id_banco) ? implode(',',$id_banco) : $id_banco;
  $preguntas = executesql("SELECT * FROM banco_preguntas WHERE id_banco IN (".$id_banco.")");
  if(!empty($preguntas))
    foreach($preguntas as $reg => $item)
      if ($item['estado_idestado']==1) {
        $state = 2;
      }elseif ($item['estado_idestado']==2) {
        $state = 1;
      }
  $bd->actualiza_("UPDATE banco_preguntas SET estado_idestado=".$state." WHERE id_banco=".$id_banco."");
  echo $state;
  $bd->Commit();
  $bd->close();

}elseif($_GET["task"]=='drop' || $_GET["task"]=='dropselect'){  
  $bd = new BD;
  $bd->Begin();
  $id_examen = !isset($_GET['id_banco']) ? implode(',', $_GET['chkDel']) : $_GET['id_banco'];
  $banco_preguntas = executesql("SELECT * FROM banco_preguntas WHERE id_banco IN(".$id_banco.")");
  if(!empty($banco_preguntas)){
    foreach($banco_preguntas as $row){
      // $pfile = 'files/images/banco_preguntas/'.$row['imagen']; if(file_exists($pfile) && !empty($row['imagen'])){ unlink($pfile); }
    }
  }

  $bd->actualiza_("DELETE FROM banco_preguntas WHERE id_banco IN(".$id_banco.")");
  $bd->Commit();
  $bd->close();

}elseif($_GET["task"]=='ordenar'){

  $bd = new BD;
  $_GET['order'] = array_reverse($_GET['order']);
  foreach ($_GET['order'] as $order => $item) {
    $orden = $orden + 1;
    $bd->actualiza_("UPDATE banco_preguntas SET orden= ".$orden." WHERE id_banco = ".$item."");
  }
  $bd->Commit();
  $bd->close();

}elseif($_GET["task"]=='finder'){
	
		
	$sql='';
	if( !empty($_GET["id_cate"]) ){
		
				$sql = "SELECT  bp.*, ce.titulo as categoria FROM banco_preguntas bp
                 INNER JOIN categoria_examenes ce ON ce.id_cate = bp.id_cate 
                 WHERE bp.estado_idestado=1 "; 
                 
				if(isset($_GET['criterio_mostrar'])) $porPagina=$_GET['criterio_mostrar'];
				if(isset($_GET['criterio_usu_per']) && !empty($_GET['criterio_usu_per'])){
					$stringlike=fn_filtro(substr($_GET['criterio_usu_per'], 0, 16));
					$sql.= " and  ( bp.b_pregunta LIKE '%".$stringlike."%'  )  ";
				}
				//if(!empty($_GET['fechabus_1']) && !empty($_GET['fechabus_2'])) {
				//		$sql .= " AND DATE(c.fecha_registro)  BETWEEN  DATE('".$_GET['fechabus_1']."')  and DATE('".$_GET['fechabus_2']."')  ";		
				//}
				
				if( isset($_GET['id_cate']) && !empty($_GET['id_cate']) ) $sql.=" and bp.id_cate='".$_GET["id_cate"]."' ";

				if(isset($_GET['criterio_ordenar_por'])) $sql.= sprintf(" order by %s %s", fn_filtro($_GET['criterio_ordenar_por']), fn_filtro($_GET['criterio_orden']));
				$sql.= "  ORDER BY bp.orden DESC   ";
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
				$paging->pagina_proceso="banco_preguntas.php";
	
	}
	
?>
            <table id="example1" class="table table-bordered table-striped">
              			<tbody id="sort">
                <tr role="row">
                  <th class="sort">ID</th>
                  <th class="sort cnone ">CATEGORÍA</th>
                  <th class="sort">PREGUNTA</th>
                  <th class="sort cnone ">SOLUCIÓN</th>  
                  <th class="sort cnone ">PUNTAJE</th> 
                  <th class="unafbe " width="100">Opciones</th>
                </tr>

<?php 
		while ($detalles = $paging->fetchResultado()): 
		
?>
								<tr>
                  <td><?php echo $detalles["id_banco"]; ?></td>
                  <td class="sort cnone "><?php echo $detalles["categoria"]; ?></td>
                  <td><?php echo $detalles["b_pregunta"]; ?></td>
                  <td class="sort cnone " ><?php echo $detalles["b_solucion"]; ?></td> 
                  <td class="sort cnone " ><?php echo $detalles["b_puntaje"]; ?></td>                         
                  <td  width="150" >
                    <div class="btn-eai  text-center btns btr">	
                      <?php  if( $detalles["estado_idestado"] ==1){ ?>	 					
                        <a href="javascript: fn_estado('<?php echo $detalles["id_banco"]; ?>')" style="background:red;"><i class="fa fa-trash-o"></i></a>
                        <?PHP } ?>			
                        <!-- 
                      -->

											<a href="index.php?page=banco_preguntas&module=Ver&parenttab=banco_preguntas
												<?php echo $_SESSION["base_url"].'&task=edit&id_banco='.$detalles["id_banco"]; ?>" style="color:#fff;"><i class="fa fa-edit"></i> <span>editar</span>
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
  // sorter();
  // reordenar('banco_preguntas.php');
});
var mypage = "banco_preguntas.php";
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
								<div class="col-sm-4 criterio_buscar" style="padding-bottom:8px;">
									<?php crearselect("id_cate", "select id_cate, titulo from categoria_examenes where estado_idestado=1 order by titulo asc", 'class="form-control"  style="border:1px solid #CA3A2B;" ', '', " Filtra por categoria de examenes"); ?>
								</div>
								
								<!-- 
							  <div class="col-sm-7 criterio_mostrar">
									<div class="lleva_flechas" style="position:relative;">
										<?php create_input('hidden', 'fechabus_1', '', "form-control pull-right", $table, ''); ?>
									</div>
									<div class="lleva_flechas" style="position:relative;">
										<?php create_input('hidden', 'fechabus_2', '', "form-control pull-right", $table, ''); ?>
									</div>
										<button>Buscar</button>
								</div>  
								-->
								
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
var link = "banco_pregunta";
var us = "banco_pregunta";
var ar = "la";
var l = "a";
var l2 = "a";
var pr = "La";
var id = "id_banco";
var mypage = "banco_preguntas.php";
</script>

<?php } ?>