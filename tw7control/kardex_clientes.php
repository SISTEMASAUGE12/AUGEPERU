<?php error_reporting(E_ALL ^ E_NOTICE);  include ("auten.php");

if($_GET["task"]=='insert' || $_GET["task"]=='update'){
	  $bd=new BD;

	$campos=array('motivo','id_tipo_atencion','id_tipo_intera','descripcion','curso','precio','id_nivel','id_tipo_recordatorio');  
	if( $_POST["id_tipo_recordatorio"] > 1  &&  !empty($_POST["fecha_recordatorio"]) ){ /* si marco algun recordatorio */
		$campos=array_merge($campos, array('fecha_recordatorio','hora_recordatorio'));
	}
	
	if($_GET["task"]=='insert'){
		$_POST['idusuario'] = $_SESSION["visualiza"]["idusuario"];
		$_POST['estado_idestado'] = 1;
		$_POST['fecha_registro'] = fecha_hora(2);
	
		$campos=array_merge($campos,array('idusuario','id_suscrito','fecha_registro','estado_idestado') );  
	
		// echo var_dump(arma_insert('kardex_clientes',$campos,'POST'));
		// exit();
		
    $bd->inserta_(arma_insert('kardex_clientes',$campos,'POST'));
		
  }else{ 
    // $campos=array('nota');  
		// echo var_dump(armaupdate('kardex_clientes',$campos," id_kar_cli='".$_POST["id_kar_cli"]."'",'POST'));
		$bd->actualiza_(armaupdate('kardex_clientes',$campos," id_kar_cli='".$_POST["id_kar_cli"]."'",'POST'));
		
	} 
  $bd->close();
  gotoUrl("index.php?page=".$_POST["nompage"]."&module=".$_POST["nommodule"]."&parenttab=".$_POST["nomparenttab"]);	


}elseif($_GET["task"]=='new'|| $_GET["task"]=='edit' ){
  if($_GET["task"]=='edit'){
			$sql_c= "select k.*, s.nombre, s.ap_pa, s.ap_ma, s.dni, s.telefono from kardex_clientes k LEFT JOIN suscritos s ON k.id_suscrito=s.id_suscrito where id_kar_cli='".$_GET["id_kar_cli"]."' ";
			
    $data_producto=executesql($sql_c,0);
  }
?>
<script type="text/javascript" src="js/buscar-autocompletado.js?ud=<?php echo $unix_date; ?>"></script>
<section class="content">
  <div class="row"><div class="col-md-12">         
    <div class="box box-info">
      <div class="box-header with-border">
        <h3 class="box-title">Lead:: Seguimiento de cliente</h3>
      </div>
<?php $task_=$_GET["task"]; ?>
      <form action="kardex_clientes.php?task=<?php echo ($task_=='edit') ?  "update" : "insert"; ?>" class="form-horizontal" method="POST" enctype="multipart/form-data" autocomplete="OFF" onsubmit="return aceptar()">
<?php
if($task_=='edit') create_input("hidden","id_kar_cli",$data_producto["id_kar_cli"],"",$table,"");
create_input("hidden","urlfailed",basename($_SERVER['REQUEST_URI']),"",$table,"");  
create_input("hidden","urlgo",$link2,"",$table,"");
create_input("hidden","nompage",$_GET["page"],"",$table,""); 
create_input("hidden","nommodule",$_GET["module"],"",$table,"");
create_input("hidden","nomparenttab",$_GET["parenttab"],"",$table,"");
?>
      <div class="box-body">        				
								
<?php 
if($task_=='edit'){ 
			create_input("hidden","id_suscrito",$data_producto["id_suscrito"],"form-control",$table,"",$agregado); 
?>
					<div class="col-sm-12">
						<label for="inputPassword3" class=" control-label">Cliente:</label>
						<?php echo $data_producto["dni"].' - '.$data_producto["nombre"].' '.$data_producto["ap_pa"].' '.$data_producto["ap_ma"].' -  telefono: '.$data_producto["telefono"] ?>
					</div>								
<?php }else{  ?>

				<div class="form-group">
					<div class="col-sm-12"><h3>Datos del cliente:</h3></div>
					<div class="col-sm-4">
						<label for="inputPassword3" class=" control-label">DNI</label>
						<?php 
						create_input("text","dni",$data_producto["dni"],"form-control",$table,"required  placeholder='Ingresa DNI o correo cliente' autocomplete='off' onkeyup='autocompletar()' ",''); 	
						?>
						<ul id="listadobusqueda_cliente" class="no-bullet"></ul>
					</div>
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
<?php } ?>
			
				<div class="form-group">
					<div class="col-sm-12 "  style="padding-bottom:10px;">
						<label for="inputassword3" class="col- control-label">Titulo:</label>
						<?php create_input("text","motivo",$data_producto["motivo"],"form-control",$table,"  ",$agregado); ?>
					</div>
					<div class="col-sm-12 "  style="padding-bottom:10px;">
						<label for="inputPassword3" class="col- control-label">Tipo de atención:</label>
						<?php crearselect("id_tipo_atencion","select * from tipo_atenciones where estado_idestado=1 order by titulo asc",'class="form-control"',$data_producto["id_tipo_atencion"]," -- seleccione atencion --"); ?>
					</div>
					<div class="col-sm-12 "  style="padding-bottom:10px;">
						<label for="inputPassword3" class="col- control-label">Tipo de interacción:</label>
						<?php crearselect("id_tipo_intera","select * from tipo_interacciones where estado_idestado=1 order by titulo asc ",'class="form-control"',$data_producto["id_tipo_intera"]," -- seleccione interacción -- "); ?>
					</div>
					<div class="col-sm-12 "  style="padding-bottom:10px;">  
						<label for="inputPassword3" class="col- control-label">Comentario:</label>
						<?php create_input("textarea","descripcion",$data_producto["descripcion"],"form-control",$table," ",$agregado); ?>
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-12 "  style="padding-bottom:10px;">
						<label for="inputPassword3" class="col- control-label">Nivel de interes:</label>
						<?php crearselect("id_nivel","select * from kardex_niveles_de_interes where estado_idestado=1 order by titulo asc ",'class="form-control"',$data_producto["id_nivel"]," -- seleccione nivel interes -- "); ?>
					</div>
					<div class="col-sm-6 "  style="padding-bottom:10px;">
						<label for="inputassword3" class="col- control-label">Codigo de Curso interesado:</label>
						<?php create_input("text","curso",$data_producto["curso"],"form-control",$table,"  ",$agregado); ?>
					</div>
					<div class="col-sm-6 "  style="padding-bottom:10px;">
						<label for="inputPassword3" class="col- control-label">Precio curso<small>(ofrecido) </small>:</label>
						<?php create_input("text","precio",$data_producto["precio"],"form-control",$table," onkeypress='javascript:return soloNumeros_precio(event,2);' ",$agregado); ?>
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-12 "  style="padding-bottom:10px;">
						<label for="inputPassword3" class="col- control-label">Tipo de recordatorio:</label>
						<?php crearselect("id_tipo_recordatorio","select * from tipo_recortadorios where estado_idestado=1 order by id_tipo_recordatorio asc ",'class="form-control"',$data_producto["id_tipo_recordatorio"],""); ?>
					</div>
					
					<div class="col-sm-12">
						<label for="inputPassword3" class="col-md- control-label">Fecha recordatorio : </label>
						<?php create_input("date","fecha_recordatorio",$data_producto["fecha_recordatorio"],"form-control",$table,"",$agregado); ?>
					</div>
				
					<div class="col-sm-12 ">
						<label for="inputPassword3" class="col-md- control-label">Hora recordatorio: </label>
						<input type="time" name="hora_recordatorio" id="hora_recordatorio" value="<?php echo $data_producto["hora_recordatorio"]; ?>">
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
  $id_kar_cli = !isset($_GET['id']) ? $_GET['estado_idestado'] : $_GET['id'];
  $id_kar_cli = is_array($id_kar_cli) ? implode(',',$id_kar_cli) : $id_kar_cli;
  $kardex_clientes = executesql("SELECT * FROM kardex_clientes WHERE id_kar_cli IN (".$id_kar_cli.")");
  if(!empty($kardex_clientes))
    foreach($kardex_clientes as $reg => $item)
      if ($item['estado_idestado']==1) {
        $state = 2;
      }elseif ($item['estado_idestado']==2) {
        $state = 1;
      }
  $bd->actualiza_("UPDATE kardex_clientes SET estado_idestado=".$state." WHERE id_kar_cli=".$id_kar_cli."");
  echo $state;
  $bd->Commit();
  $bd->close();
	
	
}elseif($_GET["task"]=='finder'){
	$array= array();
	$meses=array('Jan'=>'Enero','Feb'=>'Febrero','Mar'=>'Marzo','Apr'=>'Abril','May'=>'Mayo','Jun'=>'Junio','Jul'=>'Julio','Aug'=>'Agosto','Sep'=>'Septiembre','Oct'=>'Octubre','Nov'=>'Noviembre','Dec'=>'Diciembre');
	
  $sql.= "SELECT d.*,YEAR(d.fecha_registro) as anho, MONTH(d.fecha_registro) as mes,  s.nombre as suscrito,  CONCAT(s.ap_pa,' ',s.ap_ma) as apellidos , s.dni as dni, s.email as email, s.telefono as telefono, e.nombre AS estado , n.titulo as nivel, ta.titulo as tipo_atencion, ti.titulo as tipo_interaccion, tr.titulo as recordatorio  
		FROM kardex_clientes d  
		INNER JOIN tipo_atenciones ta ON d.id_tipo_atencion =ta.id_tipo_atencion  
		INNER JOIN suscritos s  ON s.id_suscrito=d.id_suscrito  
		INNER JOIN kardex_niveles_de_interes n ON d.id_nivel =n.id_nivel   
		INNER JOIN tipo_interacciones ti ON d.id_tipo_intera =ti.id_tipo_intera  
		INNER JOIN tipo_recortadorios tr ON d.id_tipo_recordatorio =tr.id_tipo_recordatorio   
		INNER JOIN estado e ON d.estado_idestado=e.idestado 
		WHERE d.estado_idestado=e.idestado  ";

		// WHERE d.idusuario='".$_SESSION["visualiza"]["idusuario"]."'  "; 
		if( $_SESSION["visualiza"]["idtipo_usu"] !=1 ){
			$sql.=" and d.idusuario='".$_SESSION["visualiza"]["idusuario"]."'   ";
		}

    if (isset($_GET['criterio_mostrar'])) $porPagina=$_GET['criterio_mostrar'];
  if(isset($_GET['criterio_usu_per']) && !empty($_GET['criterio_usu_per'])){
    $stringlike=fn_filtro(substr($_GET['criterio_usu_per'], 0, 16));
    $sql.= " and (s.nombre LIKE '%".$stringlike."%' or s.email LIKE '%".$stringlike."%' or s.telefono LIKE '%".$stringlike."%' or s.dni LIKE '%".$stringlike."%' ) "; // es ara buscar escribiend titulos 
  }

  if(!empty($_GET['id_suscrito']) ) {
	$sql .= " AND d.id_suscrito='".$_GET['id_suscrito']."'  ";		
}


  if(isset($_GET['criterio_ordenar_por'])) $sql.= sprintf(" order by %s %s", fn_filtro($_GET['criterio_ordenar_por']), fn_filtro($_GET['criterio_orden']));
   $sql.= " ORDER BY d.id_kar_cli DESC";
	 
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
  $paging->porPagina(fn_filtro((int)$porPagina));
  $paging->ejecutar();
  $paging->pagina_proceso="kardex_clientes.php";
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
          <th class="sort  ">CLIENTE</th>
          <th class="sort cnone">MOTIVO</th>
          <th class="sort cnone">ATENCION</th>
          <th class="sort cnone">NIVEL</th>
          <th class="sort cnone">DETALLE</th>
          <th class="sort cnone">INTERACCION</th>
          <th class="sort cnone">RECORDATORIO</th>
          <th class="sort cnone">FECHA REC</th>
          <th class="sort cnone">HORA REC</th>
          <th class="sort  cnone unafbe">Estado</th>                                      
          <th class="sort  unafbe">OPC</th>                                      
        </tr>
<?php }//if meses ?>
				<tr>
					<td><?php echo !empty($detalles['fecha_registro']) ? date('d',strtotime($detalles['fecha_registro'])) : '...'; ?></td>				       
          <td ><?php echo $detalles["dni"].' - '.$detalles["suscrito"].' '.$detalles["apellidos"].' </br> '.$detalles["email"].' -'.$detalles["telefono"]; ?></td>
          <td class="sort cnone" ><?php echo $detalles["motivo"]; ?></td>
          <td  class="sort cnone" ><?php echo $detalles["tipo_atencion"]; ?></td>
          <td  class="sort cnone" ><?php echo $detalles["nivel"]; ?></td>
          <td class="sort cnone" ><?php echo $detalles["descripcion"]; ?></td>
          <td class="sort cnone" ><?php echo $detalles["tipo_interaccion"]; ?></td>                     
          <td class="sort cnone" ><?php echo $detalles["recordatorio"]; ?></td>                     
          <td class="sort cnone" ><?php echo $detalles["fecha_recordatorio"]; ?></td>                     
          <td class="sort cnone"  ><?php echo $detalles["hora_recordatorio"]; ?></td>                     
                    
          <td class="cnone"><a href="javascript: fn_estado('<?php echo $detalles["id_kar_cli"]; ?>')"><?php echo $detalles["estado"]; ?></a></td>               

					<td>
							<a href="index.php?page=kardex_clientes&task=edit&&id_kar_cli=<?php echo $detalles['id_kar_cli']; ?>&module=<?php echo $_GET['module']; ?>&parenttab=<?php echo $_GET['parenttab']; ?>"  style="background:blue;padding:6px;color:#fff;border-radius:8px;" title="editar"><span> ver</span>
							</a> 
					</td>  
					
        </tr>
<?php endwhile; ?>
      </tbody>
    </table>
    <div class="pagination"><?php echo $paging->fetchNavegacion(); ?></div>
<script>
$(function(){
  // reordenar('kardex_clientes.php');
  checked();
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
					echo "<h3 style='padding:0 0 20px;margin-top:0;font-size:15px;'> <b>Kardex:: Seguimiento de clientes: </b></br></h3>";
			?>
					</div>

          <div class="col-sm-2 criterio_buscar">            
						<div class="btn-eai">
							<a href="<?php echo $link2."&task=new";?>" title="Registrar seguimiento " style="color:#fff;"><i class="fa fa-file" style="padding-right:5px;"></i> Registrar</a> 
						</div>
					</div>
          <div class="col-sm-4 criterio_buscar">            
            <?php create_input('text','criterio_usu_per','',"form-control pull-right",$table,"placeholder='Buscar:'"); ?>
          </div>
					<div class="col-sm-2 criterio_buscar">            
						<div class="btn-eai">
							<button>Buscar</button> 
						</div>
					</div>
          <div class="col-sm-2 criterio_mostrar">            
            <?php select_sql("nregistros"); ?>
          </div>
					<div class="col-sm-2 criterio_mostrar"><div class="btn-eai">            
						<a href="index.php?page=suscriptores&module=ver/registrar&parenttab=Mis%20Clientes" title="Regresar << " style="color:#fff;"><i class="fa fa-file" style="padding-right:5px;"></i>  Regresar</a> 
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
var link = "kardex_cliente";/*la s final se agrega en js fuctions*/
var us = "kardex";/*sirve para mensaje en ventana eliminar*/
var l = "o";
var l2 = "a";/* est+ _ x {e,a,o ,etc}sirve para mensaje en ventana eliminar*/
var pr = "la";
var ar = "la";
var id = "id_kar_cli";
var mypage = "kardex_clientes.php";
</script>
<?php } ?>