<?php error_reporting(E_ALL ^ E_NOTICE);  include ("auten.php");

if($_GET["task"]=='insert' || $_GET["task"]=='update'){
  $bd=new BD;  
	$campos=array('id_suscrito','id_curso');  	     	  
	if($_GET["task"]=='insert'){
    $_POST['orden'] = _orden_noticia("","suscritos_x_cursos","");
		$_POST['fecha_registro'] = fecha_hora(2);
		$_POST['estado'] = 1;
		$_POST['estado_idestado'] = 1;
		$_POST['id_pedido']='000';
		
		$campos=array_merge($campos,array('id_pedido','orden','fecha_registro','estado','estado_idestado'));
    $bd->inserta_(arma_insert('suscritos_x_cursos',$campos,'POST'));
		
		// asigno clases por curso del _ alumnos con estado pendiente: estado:2 pendiente, 1. finalizada ..
		// asigno clases por curso del _ alumnos con estado pendiente: estado:2 pendiente, 1. finalizada ..
		$_POST['orden'] = _orden_noticia("","avance_de_cursos_clases","");
		$_POST['estado_idestado']='1';
		$_POST['estado_fin']='2';
		$_POST['id_pedido']='000';
		// recorremos las clases del curso ..
		$sql_n_clase="select d.id_detalle,d.id_sesion from detalle_sesiones d 
												INNER JOIN sesiones s  ON s.id_sesion=d.id_sesion 
												INNER JOIN cursos c  ON c.id_curso=s.id_curso 
												WHERE d.estado_idestado=1 and c.id_curso='". $_POST['id_curso']."' ";
		$n_clases=executesql($sql_n_clase);
		if( !empty($n_clases)){
			foreach($n_clases as $rowe){
				// recorremos y agregamos 
					$_POST['id_detalle']=$rowe['id_detalle'];
					$_POST['id_sesion']=$rowe['id_sesion'];
					$campos=array('id_suscrito','id_curso','id_sesion','id_detalle','id_pedido','orden','fecha_registro','estado_fin','estado_idestado');
					$bd->inserta_(arma_insert('avance_de_cursos_clases',$campos,'POST'));								
			}
		}
		
		
		
  }else{ 
    $campos=array('nota');  
		$bd->actualiza_(armaupdate('suscritos_x_cursos',$campos," ide='".$_POST["ide"]."'",'POST'));
	} 
  $bd->close();
  gotoUrl("index.php?page=".$_POST["nompage"]."&id_curso=".$_POST["id_curso"]."&module=".$_POST["nommodule"]."&parenttab=".$_POST["nomparenttab"]);	

}elseif($_GET["task"]=='new'|| $_GET["task"]=='edit' ){
  if($_GET["task"]=='edit'){
    $data_producto=executesql("select d.*, s.nombre as suscrito, s.dni as dni, s.email as email, s.telefono as telefono, e.nombre AS estado  from suscritos_x_cursos d INNER JOIN suscritos s  ON s.id_suscrito=d.id_suscrito  INNER JOIN estado e ON d.estado_idestado=e.idestado where ide='".$_GET["ide"]."' ",0);
  }
?>
<script type="text/javascript" src="js/buscar-autocompletado.js"></script>
<section class="content">
  <div class="row"><div class="col-md-12">         
    <div class="box box-info">
      <div class="box-header with-border">
        <h3 class="box-title">Asignar alumnos a Curso</h3>
      </div>
<?php $task_=$_GET["task"]; ?>
      <form action="suscritos_lista_de_cursos.php?task=<?php echo ($task_=='edit') ?  "update" : "insert"; ?>" class="form-horizontal" method="POST" enctype="multipart/form-data" autocomplete="OFF" onsubmit="return aceptar()">
<?php
if($task_=='edit') create_input("hidden","ide",$data_producto["ide"],"",$table,"");
create_input("hidden","urlfailed",basename($_SERVER['REQUEST_URI']),"",$table,"");  
create_input("hidden","urlgo",$link_asignar_curso,"",$table,"");
create_input("hidden","id_curso",$_GET["id_curso"],"",$table,""); 
create_input("hidden","nompage",$_GET["page"],"",$table,""); 
create_input("hidden","nommodule",$_GET["module"],"",$table,"");
create_input("hidden","nomparenttab",$_GET["parenttab"],"",$table,"");
?>
      <div class="box-body">        				
								
				<div class="form-group">
					<div class="col-sm-12"><h3>Datos del Alumno:</h3></div>
					<div class="col-sm-4">
						<label for="inputPassword3" class=" control-label">DNI</label>
						<?php 
						create_input("text","dni",$data_producto["dni"],"form-control",$table,"required onkeypress='javascript:return soloNumeros(event,0);' maxlength=8 autocomplete='off' onkeyup='autocompletar()' ",''); 	
						?>
						<ul id="listadobusqueda_cliente" class="no-bullet"></ul>
					</div>
<?php /* 
if($task_=='edit'){ ?>
					<div class="col-sm-2">
						<label for="inputPassword3" class=" control-label">Nota de Examen:</label>
						<?php create_input("text","nota",$data_producto["nota"],"form-control",$table," maxlength=5 onkeypress='javascript:return soloNumeros(event,2);'"," "); ?>
					</div>								
<?php } 

*/ ?>
				</div>
        <div class="form-group">					
          <div class="col-sm-5">
              <label for="inputPassword3" class=" control-label">Nombre: </label>
              <?php create_input("text","nombre",$data_producto["suscrito"],"form-control",$table,"disabled",$agregado); ?>
          </div>
					<div class="col-sm-3">
						<label for="inputPassword3" class=" control-label">Estado</label>
						<?php 
						create_input("text","estado",$data_producto["estado"],"form-control",$table,"disabled",$agregado); 
						create_input("hidden","id_suscrito",$data_producto["id_suscrito"],"form-control",$table,"",$agregado); 
						?>
					</div>					
				</div>	                

				<div class="form-group">
					<div class="col-sm-5">
						<label for="inputPassword3" class=" control-label">Email</label>
						<?php create_input("text","email",$data_producto["email"],"form-control",$table,"disabled",$agregado); ?>
					</div>
					<div class="col-sm-2">
						<label for="inputPassword3" class=" control-label">Telèfono</label>
						<?php create_input("text","telefono",$data_producto["telefono"],"form-control",$table,"disabled","onkeypress='javascript:return soloNumeros(evt,0);'"); ?>
					</div>								
				</div>			
			
			</div>
			<div class="box-footer">
        <div class="form-group">
          <div class="col-sm-10 pull-right">
					<?php  if($task_=='new'){ ?>
            <input  type="submit"  class="btn bg-blue btn-flat" id="btnguardar" value="Asignar Curso">
					<?php }else{ ?>            
            <input  type="submit"  class="btn bg-blue btn-flat" id="btnguardar" value="Registrar Nota">
          <?php } ?>
            <button type="button" class="btn bg-red btn-flat" onclick="javascript:gotourl('<?php echo $link_asignar_curso; ?>');">Cancelar</button>
          </div>
        </div>
      </div>  


<script>	
function aceptar(){
	var nam1=document.getElementById("dni").value;	
	var nam2=document.getElementById("id_suscrito").value;	
	
	if(nam1 !='' && nam2 !='' && nam2 >0 ){									
		alert("Asignando  .. Aceptar y espere unos segundos ..");							
		document.getElementById("btnguardar").disabled=true;			
	}else{		
		alert("Recomendación: Selecciona un plan y empresa.. )");
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
  $ide = !isset($_GET['id']) ? $_GET['estado_idestado'] : $_GET['id'];
  $ide = is_array($ide) ? implode(',',$ide) : $ide;
  $suscritos_x_cursos = executesql("SELECT * FROM suscritos_x_cursos WHERE ide IN (".$ide.")");
  if(!empty($suscritos_x_cursos))
    foreach($suscritos_x_cursos as $reg => $item)
      if ($item['estado_idestado']==1) {
        $state = 2;
      }elseif ($item['estado_idestado']==2) {
        $state = 1;
      }
  $bd->actualiza_("UPDATE suscritos_x_cursos SET estado_idestado=".$state." WHERE ide=".$ide."");
  echo $state;
  $bd->Commit();
  $bd->close();
	
	
}elseif($_GET["task"]=='finder'){
	$array= array();
	$meses=array('Jan'=>'Enero','Feb'=>'Febrero','Mar'=>'Marzo','Apr'=>'Abril','May'=>'Mayo','Jun'=>'Junio','Jul'=>'Julio','Aug'=>'Agosto','Sep'=>'Septiembre','Oct'=>'Octubre','Nov'=>'Noviembre','Dec'=>'Diciembre');
	
  $sql.= "SELECT d.*,YEAR(d.fecha_registro) as anho, MONTH(d.fecha_registro) as mes, e.nombre AS estado_general, c.titulo as curso, c.codigo as cod_curso  
					FROM suscritos_x_cursos d  
					INNER JOIN cursos c  ON c.id_curso=d.id_curso   
					INNER JOIN estado e ON d.estado_idestado=e.idestado 
					WHERE d.id_suscrito='".$_GET['id_suscrito']."' "; 
	
	if (isset($_GET['criterio_mostrar'])) $porPagina=$_GET['criterio_mostrar'];
  if(isset($_GET['criterio_usu_per']) && !empty($_GET['criterio_usu_per'])){
    $stringlike=fn_filtro(substr($_GET['criterio_usu_per'], 0, 16));
    $sql.= " and (c.titulo LIKE '%".$stringlike."%' ) "; // es ara buscar escribiend titulos 
  }
  if(isset($_GET['criterio_ordenar_por'])) $sql.= sprintf(" order by %s %s", fn_filtro($_GET['criterio_ordenar_por']), fn_filtro($_GET['criterio_orden']));
   $sql.= " ORDER BY d.fecha_registro DESC";
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
  $paging->pagina_proceso="suscritos_lista_de_cursos.php";
?>
    <table id="example1" class="table table-bordered table-striped">
      <tbody id="sort">
<?php 
		while ($detalles = $paging->fetchResultado()): 
			if(!in_array(array('mes' => $detalles['mes'], 'anho' => $detalles['anho']), $array)){
				$array[] = array('mes' => $detalles['mes'], 'anho' => $detalles['anho']);
?>
				<tr class="lleva-mes">
					<td colspan="9"><h6><?php echo strtoupper(strtr(date('M Y',strtotime($detalles['fecha_registro'])),$meses)); ?></h6></td>
				</tr>			
				<tr role="row">
          <th width="30">Día</th>
          <th class="sort cnone">CURSO</th>
          <th class="sort  unafbe">Estado</th>                                      
        </tr>
<?php }//if meses ?>
				<tr>
					<td><?php echo !empty($detalles['fecha_registro']) ? date('d',strtotime($detalles['fecha_registro'])) : '...'; ?></td>				       
          <td ><?php echo $detalles["cod_curso"].' - '.$detalles["curso"]; ?></td>                  
                    
          <td class="cnone">
            <?php if( $detalles["estado"] ==3 ){ ?>
              <a style="color:red!important;"> Rechazado/anulado</a>

            <?php }else{ ?>
              <a href="javascript: fn_estado('<?php echo $detalles["ide"]; ?>')"><?php echo $detalles["estado_general"]; ?></a>
            <?php } ?>
          </td>               
  
					
        </tr>
<?php endwhile; ?>
      </tbody>
    </table>
    <div class="pagination"><?php echo $paging->fetchNavegacion(); ?></div>
<script>
$(function(){
  // reordenar('suscritos_lista_de_cursos.php');
  // checked();
  // sorter();
});
</script>
<?php }else{ ?>
  <div class="box-body">
    <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
      <form action="javascript: fn_buscar();" id="frm_buscar" name="frm_buscar">
        <input type="hidden" name="id_suscrito" value="<?php echo $_GET['id_suscrito'];?>">
				<div class="bg-gray-light">          
          <div class="break"></div>
          <div class="col-sm-12 criterio_buscar">   
			<?php 
					$sql = "SELECT * FROM suscritos  WHERE id_suscrito='".$_GET['id_suscrito']."'	"; 
					$titu=executesql($sql);
					echo "<h3 style='padding:0 0 20px;margin-top:0;font-size:15px;'><b>Listado de cursos del cliente:</b> DNI:".$titu[0]['dni'].' - EMAIL: '.$titu[0]['email'].' </BR>'.$titu[0]['nombre'].' '.$titu[0]['ap_pa'].' '.$titu[0]['ap_ma']."</h3>";
			?>
					</div>


          <div class="col-sm-4 criterio_buscar">            
            <?php create_input('text','criterio_usu_per','',"form-control pull-right",$table,"placeholder='Buscar:'"); ?>
          </div>
          <div class="col-sm-2 criterio_mostrar">            
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
var link = "suscritos_lista_de_curso";/*la s final se agrega en js fuctions*/
var us = "curso";/*sirve para mensaje en ventana eliminar*/
var l = "o";
var l2 = "a";/* est+ _ x {e,a,o ,etc}sirve para mensaje en ventana eliminar*/
var pr = "el";
var ar = "la";
var id = "ide";
var mypage = "suscritos_lista_de_cursos.php";
</script>
<?php } ?>