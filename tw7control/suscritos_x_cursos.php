<?php error_reporting(E_ALL ^ E_NOTICE);  include ("auten.php");

if($_GET["task"]=='insert' || $_GET["task"]=='update'){
  $bd=new BD;  
	$campos=array('id_suscrito','id_curso');  
	
	if($_GET["task"]=='insert'){
		$_POST['idusuario'] = $_SESSION["visualiza"]["idusuario"];				

		$data_curso=executesql("select * from cursos where id_curso='".$_POST["id_curso"]."' ",0);
		$_POST['id_tipo']=$data_curso['id_tipo'];
		$_POST['validez_meses']=( !empty($data_curso['validez_meses']) && $data_curso['validez_meses'] > 0 )?$data_curso['validez_meses']:'12';
		
   		//  $_POST['orden'] = _orden_noticia("","suscritos_x_cursos","");
   		 $_POST['orden'] = 1;
		$_POST['fecha_registro'] = fecha_hora(2);
		$_POST['estado'] = 1;
		$_POST['estado_idestado'] = 1;
		$_POST['id_pedido']='000';
		
		$_POST['dependiente'] = 2;

		// intercambianos valores xq en tabla suscrito_x_cursos esta invertido los valores 1. es si es epsecialida y 2. es genral 
		if( $data_curso['id_tipo_curso'] == 2 ){
			$especialidades=1; 			
		}else if( $data_curso['id_tipo_curso'] == 1 ){
			$especialidades=2; 
		}

		$_POST['especialidades'] = $especialidades;

		$campos=array_merge($campos,array('idusuario','id_pedido','orden','id_tipo','validez_meses','fecha_registro','estado','dependiente','especialidades','estado_idestado'));
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
		
		/* aca se recorre al curso, si tiene dependientes o especialidades los agregamos al usuario */
		include("inc/inc_cursos_dependientes_y_especialidades.php"); 
		
		
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
<script type="text/javascript" src="js/buscar-autocompletado.js?ud=<?php echo $unix_date; ?>"></script>
<section class="content">
  <div class="row"><div class="col-md-12">         
    <div class="box box-info">
      <div class="box-header with-border">
        <h3 class="box-title">Asignar alumnos a Curso</h3>
      </div>
<?php $task_=$_GET["task"]; ?>
      <form action="suscritos_x_cursos.php?task=<?php echo ($task_=='edit') ?  "update" : "insert"; ?>" class="form-horizontal" method="POST" enctype="multipart/form-data" autocomplete="OFF" onsubmit="return aceptar()">
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
					<div class="col-sm-12"><h3>Datos del cliente:</h3></div>
					<div class="col-sm-4">
						<label for="inputPassword3" class=" control-label">DNI</label>
						<?php 
						create_input("text","dni",$data_producto["dni"],"form-control",$table,"required  placeholder='Ingresa DNI o correo cliente' autocomplete='off' onkeyup='autocompletar()' ",''); 	
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
						<label for="inputPassword3" class=" control-label">Especialidad:</label>
						<?php create_input("text","id_especialidad",$data_producto["id_especialidad"],"form-control",$table,"disabled",$agregado); ?>
					</div>
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
            <input  type="submit"  class="btn bg-blue btn-flat" id="btnguardar" value="Asignar Curso">
				
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
		alert("Recomendación: Selecciona un cliente! )");
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
	
  $sql.= "SELECT d.*,YEAR(d.fecha_registro) as anho, MONTH(d.fecha_registro) as mes,  s.nombre as suscrito,  CONCAT(s.ap_pa,' ',s.ap_ma) as apellidos ,  CONCAT(s.nombre,' ',s.ap_pa,' ',s.ap_ma )as suscritos , s.dni as dni, s.email as email, s.telefono as telefono, e.nombre AS estado ,  c.titulo as curso, c.codigo as codigo,  esp.titulo as especialidad , pes.total , u.nombre_corto , pes.tipo_pago  
		FROM suscritos_x_cursos d  
		INNER JOIN suscritos s  ON s.id_suscrito=d.id_suscrito  
		LEFT JOIN pedidos pes ON d.id_pedido=pes.id_pedido  
		LEFT JOIN usuario u ON pes.idusuario=u.idusuario 
		INNER JOIN cursos c ON d.id_curso=c.id_curso 
		INNER JOIN especialidades esp ON s.id_especialidad=esp.id_especialidad  
		INNER JOIN estado e ON d.estado_idestado=e.idestado  
		WHERE d.id_curso='".$_GET['id_curso']."' and d.estado_idestado=1  ";  // solo activos 
	
    if (isset($_GET['criterio_mostrar'])) $porPagina=$_GET['criterio_mostrar'];
  if(isset($_GET['criterio_usu_per']) && !empty($_GET['criterio_usu_per'])){
    $stringlike=fn_filtro(substr($_GET['criterio_usu_per'], 0, 16));
    $sql.= " and (s.nombre LIKE '%".$stringlike."%' or s.email LIKE '%".$stringlike."%' or s.telefono LIKE '%".$stringlike."%' or s.dni LIKE '%".$stringlike."%' ) "; // es ara buscar escribiend titulos 
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
  $paging->pagina_proceso="suscritos_x_cursos.php";
?>

    <table id="example1" class="table table-bordered table-striped">
				<!-- *EXCEL -->
				<?php  /*  Fechas para excel */ 
			$fecha_excel_inicio= !empty($_GET["fechabus_1"])?$_GET["fechabus_1"]:fecha_hora(1); 
		?>
		<input type="hidden" name="sql_excel" id="sql_excel" value="<?php echo $sql; ?>">
		<a href="javascript:fn_exportar('tipo_form=1&fecha_filtro_inicio=<?php echo $fecha_excel_inicio;?>&fecha_filtro_fin=<?php echo $_GET["fechabus_2"];?>','clientes_cursos');" class="btn btn-primary excel "  > Excel</a>
		


      <tbody id="sort">
<?php  // total solo activos 
			$total_clientes=executesql("select count(*) as total_matriculados from suscritos_x_cursos	WHERE id_curso='".$_GET['id_curso']."'  and estado_idestado=1 and estado=1 ");
			if( !empty($total_clientes) ){
				echo "<b>Total matriculados: ".$total_clientes[0]['total_matriculados']. "</b> </br>";
			}else{
				echo "<b>Total matriculados: 0 </b> </br>";
				
			}

		while ($detalles = $paging->fetchResultado()): 
			if(!in_array(array('mes' => $detalles['mes'], 'anho' => $detalles['anho']), $array)){
				$array[] = array('mes' => $detalles['mes'], 'anho' => $detalles['anho']);
?>
				<tr class="lleva-mes">
					<td colspan="9"><h6><?php echo strtoupper(strtr(date('M Y',strtotime($detalles['fecha_registro'])),$meses)); ?></h6></td>
				</tr>			
				<tr role="row">
          <th width="30">Día</th>
          <th class="sort cnone">Especialidad</th>
          <th class="sort cnone">Email</th>
          <th class="sort  unafbe">Alumno</th> 
          <th class="sort  unafbe">APE</th> 
          <th class="sort cnone">DNI</th>
          <th class="sort cnone">Telefono</th>
          <th class="sort cnone">ASIGNADO POR</th>
          <th class="sort  unafbe">Estado</th>                                      
        </tr>
<?php }//if meses ?>
				<tr>
					<td><?php echo !empty($detalles['fecha_registro']) ? date('d',strtotime($detalles['fecha_registro'])) : '...'; ?></td>				       
          <td ><?php echo $detalles["especialidad"]; ?></td>
          <td ><?php echo $detalles["email"]; ?></td>
          <td ><?php echo $detalles["suscrito"]; ?></td>
          <td ><?php echo $detalles["apellidos"]; ?></td>
          <td ><?php echo $detalles["dni"]; ?></td>
          <td ><?php echo $detalles["telefono"]; ?></td>                     
		  <td class="cnone">
          <?php 
          if($detalles["id_pedido"] == 0){  // SI FUE ASIGNADO DIRECTAMENTE 
			
			if( !empty($detalles["idusuario"])){  // se registra apartir del 22/0872022
				$usuario=executesql("select nomusuario from usuario where idusuario='".$detalles['idusuario']."' ");
				echo $usuario[0]['nomusuario']." - </br> directamente ";
				
			}else{
				echo "ADMIN/gestion - </br> directamente ";
				
			}
			
          }else{
            echo $detalles["nombre_corto"].' </BR> - '; 

            if($detalles["tipo_pago"] == 1){  // SI FUE ASIGNADO DIRECTAMENTE 
              echo "Transferencia";
            }else if($detalles["tipo_pago"] == 2){  // SI FUE ASIGNADO DIRECTAMENTE 
              echo "Online";
            }else if($detalles["tipo_pago"] == 4){  // SI FUE ASIGNADO DIRECTAMENTE 
              echo "PAGO MANUAL ";
            }else if($detalles["tipo_pago"] == 3){  // SI FUE ASIGNADO DIRECTAMENTE 
              echo "PAGO EFECTIVO";
            }else{
              echo ' -- '; 
            }
          }
          
          ?>
        </td>                     
          <td class="cnone"><a href="javascript: fn_estado('<?php echo $detalles["ide"]; ?>')"><?php echo $detalles["estado"]; ?></a></td>               

				
					
        </tr>
<?php endwhile; ?>
      </tbody>
    </table>
    <div class="pagination"><?php echo $paging->fetchNavegacion(); ?></div>
<script>
$(function(){

});
</script>
<?php }else{ ?>
  <div class="box-body">
    <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
      <form action="javascript: fn_buscar();" id="frm_buscar" name="frm_buscar">
        <input type="hidden" name="id_curso" value="<?php echo $_GET['id_curso'];?>">
				<div class="bg-gray-light">          
          <div class="break"></div>
          <div class="col-sm-12 criterio_buscar">   
			<?php 
					$sql = "SELECT * FROM cursos  WHERE id_curso='".$_GET['id_curso']."'	"; 
					$titu=executesql($sql);
					echo "<h3 style='padding:0 0 20px;margin-top:0;font-size:15px;'>Curso: ".$titu[0]['codigo'].' - '.$titu[0]['titulo']."</h3>";
			?>
					</div>

          <div class="col-sm-2 criterio_buscar">            
						<div class="btn-eai">
							<a href="<?php echo $link_asignar_curso."&task=new";?>" title="Asignar alumno" style="color:#fff;"><i class="fa fa-file" style="padding-right:5px;"></i> Asignar</a> 
						</div>
					</div>
<!-- 
					-->
					
          <div class="col-sm-4 criterio_buscar">            
            <?php create_input('text','criterio_usu_per','',"form-control pull-right",$table,"placeholder='Buscar:'"); ?>
          </div>
          <div class="col-sm-2 criterio_mostrar">            
            <?php select_sql("nregistros"); ?>
          </div>
					<div class="col-sm-2 criterio_mostrar"><div class="btn-eai">            
						<a href="index.php?page=cursos&id_tipo=<?php echo $titu[0]["id_tipo"]; ?>&module=<?php echo $_GET["module"]; ?>&parenttab=<?php echo $_GET["parenttab"]; ?>" title="Regresar << " style="color:#fff;"><i class="fa fa-file" style="padding-right:5px;"></i>  Regresar</a> 
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
var link = "suscritos_x_curso";/*la s final se agrega en js fuctions*/
var us = "asignacion";/*sirve para mensaje en ventana eliminar*/
var l = "o";
var l2 = "a";/* est+ _ x {e,a,o ,etc}sirve para mensaje en ventana eliminar*/
var pr = "la";
var ar = "la";
var id = "ide";
var mypage = "suscritos_x_cursos.php";
</script>
<?php } ?>