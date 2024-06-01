<?php error_reporting(E_ALL ^ E_NOTICE);
include_once("auten.php");


if($_GET["task"]=='insert' || $_GET["task"]=='update'){
  $bd=new BD;  
	$campos=array('id_suscrito','id_certificado','id_curso','id_pedido','id_tipo','precio','habilitar_solicitar_directo','estado','estado_entrega');  
	
	$certi=executesql(" select * from certificados where id_certificado='".$_POST["id_certificado"]."' ",0);
	$certi_precio= ($certi["costo_promo"] >0 && !empty($certi["costo_promo"]) )?$certi["costo_promo"] :$certi["precio"];
	

	$_POST['precio'] = $certi_precio;
	$_POST['id_tipo'] = 9999;
	$_POST['id_pedido'] = 0;
	
	// $_POST['estado'] = 1;
	// $_POST['estado_entrega'] = 1;

	
	if($_GET["task"]=='insert'){
		$_POST['estado_idestado'] = 1;
		$_POST['orden'] = _orden_noticia("","suscritos_x_certificados","");
		$_POST['fecha_registro'] = fecha_hora(2);
		
		$campos=array_merge($campos,array('orden','fecha_registro','estado_idestado'));
		
    $bd->inserta_(arma_insert('suscritos_x_certificados',$campos,'POST'));
		
		
	}else{ 
		$bd->actualiza_(armaupdate('suscritos_x_certificados',$campos," ide='".$_POST["ide"]."'",'POST'));
	} 
  $bd->close();
  gotoUrl("index.php?page=".$_POST["nompage"]."&id_suscrito=".$_POST["id_suscrito"]."&module=".$_POST["nommodule"]."&parenttab=".$_POST["nomparenttab"]);	



}elseif($_GET["task"]=='new'|| $_GET["task"]=='edit' ){
  if($_GET["task"]=='edit'){
    $data_producto=executesql("select *  from suscritos_x_certificados  where ide='".$_GET["ide"]."' ",0);
  }
?>

<section class="content">
  <div class="row"><div class="col-md-12">         
    <div class="box box-info">
      <div class="box-header with-border">
        <h3 class="box-title">Asignar certificado a cliente: </h3>
      </div>
<?php $task_=$_GET["task"]; ?>
      <form action="suscriptores_certificados.php?task=<?php echo ($task_=='edit') ?  "update" : "insert"; ?>" class="form-horizontal" method="POST" enctype="multipart/form-data" autocomplete="OFF" onsubmit="return aceptar()">
<?php
if($task_=='edit') create_input("hidden","ide",$data_producto["ide"],"",$table,"");
create_input("hidden","urlfailed",basename($_SERVER['REQUEST_URI']),"",$table,"");  
create_input("hidden","urlgo",$link_lleva_suscrito,"",$table,"");
create_input("hidden","id_suscrito",$_GET["id_suscrito"],"",$table,""); 
create_input("hidden","nompage",$_GET["page"],"",$table,""); 
create_input("hidden","nommodule",$_GET["module"],"",$table,"");
create_input("hidden","nomparenttab",$_GET["parenttab"],"",$table,"");
?>
      <div class="box-body">        				
					
					<div class="form-group">
						<label for="inputPassword3" class="col-md-2 col-sm-2 control-label">PAGO:</label>
						<div class="col-sm-3">
							<select id="estado" name="estado" class="form-control" requerid >  <!-- saco valor desde la BD -->
								<option value="2"  <?php echo ($data_producto['estado'] == 2) ? 'selected' : '' ;?>>NO</option>
								<option value="1" <?php echo ($data_producto['estado'] == 1) ? 'selected' : '' ;?>>SI</option>  
							</select>
						</div>
					 <label for="inputPassword3" class="col-md-2 col-sm-2 control-label">Entrega:</label>
						<div class="col-sm-3">
							<select id="estado_entrega" name="estado_entrega" class="form-control" requerid >  <!-- saco valor desde la BD -->
								<option value="2"  <?php echo ($data_producto['estado_entrega'] == 2) ? 'selected' : '' ;?>>Pendiente</option>
								<option value="1" <?php echo ($data_producto['estado_entrega'] == 1) ? 'selected' : '' ;?>>Entregado</option>  
							</select>
						</div>
						
						
					</div>
			
					<div class="form-group">
						<label for="inputPassword3" class="col-md-2 col-sm-2 control-label">Habilitar boton Solicitar [directo]: </br>
						</label>
						<div class="col-sm-5">
							<select id="habilitar_solicitar_directo" name="habilitar_solicitar_directo" class="form-control" requerid >  <!-- saco valor desde la BD -->
								<option value="2"  <?php echo ($data_producto['habilitar_solicitar_directo'] == 2) ? 'selected' : '' ;?>>NO</option>
								<option value="1" <?php echo ($data_producto['habilitar_solicitar_directo'] == 1) ? 'selected' : '' ;?>>SI</option>  
							</select>
							<small> Esta opción permite habilitar el boton SOLiCITAR, sin tvalidación de culminar las clases u otros casos.</small>
						</div>
					</div>
			
												
					<div class="form-group">
					  <label for="inputEmail3" class="col-sm-2 control-label">CURSO</label>
						<div class="col-sm-3 criterio_buscar">
									<?php crearselect("id_curso", "select id_curso, CONCAT(codigo,' - ',titulo) as titulo_x from cursos  order by codigo asc ", 'class="form-control" requerid  onchange="javascript:display(\'suscriptores_certificados.php\',this.value,\'cargar_certificados_del_curso\',\'id_certificado\')"', $data_producto["id_curso"], "-- curso --"); ?>
						</div>
					</div>
							
					<div class="form-group">
					  <label for="inputEmail3" class="col-sm-2 control-label">CERTIFICADO</label>
					  <div class="col-sm-6">
						<?php if($task_=='edit'){  
				$sql="select id_certificado,CONCAT(id_certificado,' - ',titulo) as titulo_certi from certificados WHERE id_curso='".$data_producto["id_curso"]."' "; 
						?>
								<select name="id_certificado" id="id_certificado" class="form-control" >
									<option value="" >-- certificado. --</option>
									<?php 
											$listaprov=executesql($sql);
											foreach($listaprov as $data){ ?>
										<option value="<?php echo $data['id_certificado']; ?>" <?php echo ($data['id_certificado']==$data_producto["id_certificado"])?'selected':'';?> > <?php echo $data['titulo_certi']?></option>
											<?php } ?>
								</select>
							
							<?php }else{ ?>
							<select name="id_certificado" id="id_certificado" class="form-control" ><option value="" selected="selected">-- certificado. --</option></select>
							<?php } ?>
						</div>
					</div>   
					
                

				
			
			</div>
			<div class="box-footer">
        <div class="form-group">
          <div class="col-sm-10 pull-right">
            <input  type="submit"  class="btn bg-blue btn-flat" id="btnguardar" value="Guardar ">
				
            <button type="button" class="btn bg-red btn-flat" onclick="javascript:gotourl('<?php echo $link_lleva_suscrito; ?>');">Cancelar</button>
          </div>
        </div>
      </div>  


<script>	
function aceptar(){
	var nam1=document.getElementById("id_certificado").value;	
	var nam2=document.getElementById("id_suscrito").value;	
	
	if(nam1 !='' && nam2 !='' && nam2 >0 ){									
		alert("Asignando  .. Aceptar y espere unos segundos ..");							
		document.getElementById("btnguardar").disabled=true;			
	}else{		
		alert("Recomendación: Seleccione un certificado )");
		return false; //el formulario no se envia		
	}
	
}				
</script>	


			</form>    </div><!-- /.box -->
  </div></div><!--row / col12 -->
</section><!-- /.content -->



<?php 
}else if($_GET["task"]=='finder'){
  $array= array();
	$meses=array('Jan'=>'Enero','Feb'=>'Febrero','Mar'=>'Marzo','Apr'=>'Abril','May'=>'Mayo','Jun'=>'Junio','Jul'=>'Julio','Aug'=>'Agosto','Sep'=>'Septiembre','Oct'=>'Octubre','Nov'=>'Noviembre','Dec'=>'Diciembre');
	
  $sql= "SELECT pp.*,YEAR(pp.fecha_registro) as anho, MONTH(pp.fecha_registro) as mes, c.titulo as certificado 
	FROM suscritos_x_certificados pp 
  INNER JOIN certificados c ON pp.id_certificado=c.id_certificado  
  INNER JOIN suscritos s ON pp.id_suscrito=s.id_suscrito 
	WHERE s.id_suscrito='".$_GET["id_suscrito"]."' 
	 "; 
  
  if (isset($_GET['criterio_mostrar'])) $porPagina=$_GET['criterio_mostrar'];
  // if(isset($_GET['criterio_usu_per']) && !empty($_GET['criterio_usu_per'])){
    // $stringlike=fn_filtro(substr($_GET['criterio_usu_per'], 0, 16));
    // $sql.= " AND ( s.nombre LIKE '%".$stringlike."%' or s.email LIKE '%".$stringlike."%' or pp.ap_pa LIKE '%".$stringlike."%' or pp.ap_ma LIKE '%".$stringlike."%' )"; 
  // }
	
	if(!empty($_GET['estado']) ){
			$sql .= " AND pp.estado = '".$_GET['estado']."'";
	}

	if(!empty($_GET['fechabus'])) {
			$sql .= " AND pp.fecha_registro = '" . $_GET['fechabus'] . "'";
	}


	
  if(isset($_GET['criterio_ordenar_por'])) $sql.= sprintf(" order by %s %s", fn_filtro($_GET['criterio_ordenar_por']), fn_filtro($_GET['criterio_orden']));
 $sql.= " ORDER BY pp.orden DESC";
 
 // echo  $sql; 
 
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
  $paging->pagina_proceso="suscriptores_certificados.php";
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
					<th width="30">Día</th>  <!-- -->  
          <th class="sort cnone">CERTIFICADO</th>
          <th class="sort cnone">PAGO</th>
          <th class="sort cnone"  width="95">ENTREGA</th>
					<!--
					-->
          <th class="unafbe" width="70">OPC</th>
        </tr>
<?php }//if meses 

if( $detalles["estado"] == 2){ // por revisar 
	$fondo_entregar ="background:#F0A105; color:#fff !important; ";
}elseif( $detalles["estado"] == 1){  // aprobado
	$fondo_entregar ='';
}elseif( $detalles["estado"] == 3){ // rechazado 
	$fondo_entregar ='background:rgba(255,0,0,0.6); color:#fff !important;';
}


	// $sql_c="select titulo from cursos	WHERE id_curso IN (".$detalles["cursos"].") ";
	// $detallepro=executesql($sql_c); 
	// $i=0; 
	// $cursos='';
	// foreach($detallepro as $rowdetalle){  $i++; 
		// $cursos.= $i.'. '.$rowdetalle["titulo"].' </br>  ';
	// }

?>        
       <tr style="<?php echo $fondo_entregar; ?>">
        <td><?php echo !empty($detalles['fecha_registro']) ? date('d',strtotime($detalles['fecha_registro'])) : '...'; ?></td>
      
        <td><?php echo $detalles['certificado']; ?></td>
        <td><?php echo ($detalles['estado']==1)?'SI':'NO'; ?></td>
				<td class="cnone">
					<a  style="color:#333;font-weight:800;">
						<?php if($detalles["estado_entrega"]==2){ echo "Pendiente";
						// }elseif($detalles["estado_entrega"]==3){ echo "Rechazado";  
						}elseif($detalles["estado_entrega"]==1){ echo "Entregado";  
						
						} ?>
					</a>
				</td>
				<td>
					<div class="btn-eai btns btr">
						<a href="<?php echo $_SESSION["base_url"].'&task=edit&ide='.$detalles["ide"]; ?>" style="color:#fff;"><i class="fa fa-edit"></i> editar</a>
          </div>
        </td>
						
      </tr>
<?php endwhile; ?>
    </tbody>
  </table>
  <div class="pagination"><?php echo $paging->fetchNavegacion(); ?></div>
<script>
$(function(){
  // reordenar('suscriptores_certificados.php');
  // checked();
  // sorter();
});
</script>

<?php }else{ ?>
        <div class="box-body">
          <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
            <form action="javascript: fn_buscar();" id="frm_buscar" name="frm_buscar">
              <div class="bg-gray-light">
								<?php create_input('hidden','id_suscrito',$_GET['id_suscrito'],"form-control ",$table,''); ?>
                  <div class="col-sm-12 criterio_buscar">   
			<?php 
					$sql = "SELECT * FROM suscritos  WHERE id_suscrito='".$_GET['id_suscrito']."'	"; 
					$titu=executesql($sql);
					echo "<h3 style='padding:0 0 20px;margin-top:0;font-size:15px;'><b>Certificados del cliente:</b> ".$titu[0]['nombre'].' '.$titu[0]['ap_pa'].' '.$titu[0]['ap_ma']."</h3>";
					
				
					
			?>
					</div>
					
					<div class="col-sm-2 criterio_buscar">            
						<div class="btn-eai">
							<a href="<?php echo $link_lleva_suscrito."&task=new";?>" title="Asignar alumno" style="color:#fff;"><i class="fa fa-file" style="padding-right:5px;"></i> Asignar</a> 
						</div>
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
var link = "suscriptores_certificado";/*la s final se agrega en js fuctions*/
var us = "solicitud";/*sirve para mensaje en ventana eliminar*/
var l = "o";
var l2 = "e";/* est+ _ x {e,a,o ,etc}sirve para mensaje en ventana eliminar*/
var pr = "El";
var ar = "al";
var id = "ide";
var mypage = "suscriptores_certificados.php";
</script>
<?php } ?>