<?php error_reporting(E_ALL ^ E_NOTICE);  include ("auten.php");

if($_GET["task"]=='insert'){
  $bd=new BD;  

	// recorro todos lso curso  de especialidad y los asignamos al cliente enviado ...
	$cursos_especialidades=executesql(" select * from cursos where estado_idestado=1 and id_tipo_curso=2 order by id_curso asc ");	
	if( !empty($cursos_especialidades) ){
		foreach($cursos_especialidades as $especialidad){
			$_POST['id_curso']= $especialidad["id_curso"];

			/* valido si ya lo tiene  */
			$sql_valida_si_curso="select * from suscritos_x_cursos where id_suscrito='".$_POST["id_suscrito"]."' and id_curso ='".$_POST["id_curso"]."' and estado!=3 ";
					// $sql_valida_si_curso;  // si el curso diferente de rechasdo, ya lo ha comrpado 

			$validamos_si_ya_tiene_curso=executesql($sql_valida_si_curso);
			if( empty($validamos_si_ya_tiene_curso) ){  // si no lo tiene agregamos 
					
				

				$campos=array('id_suscrito','id_curso');  				
				if($_GET["task"]=='insert'){
					
					$data_curso=executesql("select * from cursos where id_curso='".$_POST["id_curso"]."' ",0);
					$_POST['id_tipo']=$data_curso['id_tipo'];
					$_POST['validez_meses']=( !empty($data_curso['validez_meses']) && $data_curso['validez_meses'] > 0 )?$data_curso['validez_meses']:'12';
					
					//$_POST['orden'] = _orden_noticia("","suscritos_x_cursos","");
					$_POST['orden'] =1;
					$_POST['fecha_registro'] = fecha_hora(2);
					$_POST['estado'] = 1;
					$_POST['estado_idestado'] = 1;
					$_POST['id_pedido']='000';
					$_POST['dependiente'] = 2;

					$campos=array_merge($campos,array('id_pedido','orden','id_tipo','validez_meses','fecha_registro','estado','dependiente','estado_idestado'));
					$bd->inserta_(arma_insert('suscritos_x_cursos',$campos,'POST'));
					
					// asigno clases por curso del _ alumnos con estado pendiente: estado:2 pendiente, 1. finalizada ..
					// asigno clases por curso del _ alumnos con estado pendiente: estado:2 pendiente, 1. finalizada ..
					//$_POST['orden'] = _orden_noticia("","avance_de_cursos_clases","");
					$_POST['orden'] = 1;
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
					//include("inc/inc_cursos_dependientes_y_especialidades.php"); 
				
				}/** end if insert  */

			} /** end validacion si tiene ya el curso   */
		} /** end for  */
	} /** end si existe especilidades  */ 

  $bd->close();
  gotoUrl("index.php?page=".$_POST["nompage"]."&module=".$_POST["nommodule"]."&parenttab=".$_POST["nomparenttab"]);	

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
        <h3 class="box-title">Asignar Todas las especialidades a un Cliente: <b style="color:red;">*advertencia</b></h3>
      </div>
<?php $task_=$_GET["task"]; ?>
      <form action="suscritos_x_cursos_todos_especialidades.php?task=<?php echo ($task_=='edit') ?  "update" : "insert"; ?>" class="form-horizontal" method="POST" enctype="multipart/form-data" autocomplete="OFF" onsubmit="return aceptar()">
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
		alert("Recomendación: Selecciona un plan y empresa.. )");
		return false; //el formulario no se envia		
	}
	
}				
</script>	


			</form>    </div><!-- /.box -->
  </div></div><!--row / col12 -->
</section><!-- /.content -->
<?php

 }else{ ?>
  <div class="box-body">
    <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
      <form action="javascript: fn_buscar();" id="frm_buscar" name="frm_buscar">
				<div class="bg-gray-light">          
          <div class="break"></div>
          <div class="col-sm-12 criterio_buscar">   
			<?php 
					echo "<h3 style='padding:0 0 20px;margin-top:0;font-size:15px;'>Agregar a un cliente, todos los cursos de ESPECIALIDAD: <b style='color:red;'>* advertencia</b> </h3>";
			?>
					</div>

          <div class="col-sm-2 criterio_buscar">            
						<div class="btn-eai">
							<a href="<?php echo $link_asignar_curso."&task=new";?>" title="Asignar alumno" style="color:#fff;"><i class="fa fa-file" style="padding-right:5px;"></i> Asignar</a> 
						</div>
					</div>

					
        </div>
      </form>
      <div class="row">
       
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
var mypage = "suscritos_x_cursos_todos_especialidades.php";
</script>
<?php } ?>