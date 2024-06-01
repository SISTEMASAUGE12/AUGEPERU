<?php error_reporting(E_ALL ^ E_NOTICE);
include ("auten.php");

if($_GET["task"]=='agregando_especialidades'){  
  $bd = new BD;
  $bd->Begin();
  $ide =  implode(',', $_GET['chkDel']);
  
	$_POST['cursos_especialidades']=$ide;
	$campos=array('cursos_especialidades'); 
	
	// echo var_dump(armaupdate('cursos',$campos," id_curso='".$_GET["id_curso"]."'",'POST'));
	// exit();
	
	$hola=$bd->actualiza_(armaupdate('cursos',$campos," id_curso='".$_GET["id_curso"]."'",'POST'));/*actualizo*/
  $bd->Commit();
  $bd->close();


}elseif($_GET["task"]=='finder'){
	$array= array();
	$meses=array('Jan'=>'Enero','Feb'=>'Febrero','Mar'=>'Marzo','Apr'=>'Abril','May'=>'Mayo','Jun'=>'Junio','Jul'=>'Julio','Aug'=>'Agosto','Sep'=>'Septiembre','Oct'=>'Octubre','Nov'=>'Noviembre','Dec'=>'Diciembre');
	

	$sql = " SELECT YEAR(c.fecha_registro) as anho, MONTH(c.fecha_registro) as mes,  csc.id_sub, sub.titulo as subcateg, c.*, e.nombre as estado 
		FROM cursos c  
		INNER JOIN categoria_subcate_cursos csc ON csc.id_curso=c.id_curso 
		INNER JOIN subcategorias sub ON csc.id_sub=sub.id_sub  
		INNER JOIN estado e ON c.estado_idestado=e.idestado  
		WHERE  csc.id_sub='".$_GET["id_sub"]."' and c.id_tipo_curso=2 and c.estado_idestado=1  
	";
	 
  // if(isset($_GET['criterio_mostrar'])) $porPagina=$_GET['criterio_mostrar'];
   	if(isset($_GET['criterio_mostrar'])) $porPagina= 1000;

  	if(isset($_GET['criterio_usu_per']) && !empty($_GET['criterio_usu_per'])){
    	$stringlike=fn_filtro(substr($_GET['criterio_usu_per'], 0, 16));
    	$sql.= " and  ( c.id_curso LIKE '%".$stringlike."%' or c.titulo LIKE '%".$stringlike."%' or  c.codigo LIKE '%".$stringlike."%' )  ";
  	}
	
	
  	if(isset($_GET['criterio_ordenar_por'])) $sql.= sprintf(" order by %s %s", fn_filtro($_GET['criterio_ordenar_por']), fn_filtro($_GET['criterio_orden']));
  	//$sql.= " Group BY c.id_curso ORDER BY c.titulo asc   ";
  	$sql.= " ORDER BY c.orden DESC   ";
	
	 // echo $sql; 

	$paging = new PHPPaging;
	$paging->agregarConsulta($sql); 
	$paging->div('div_listar');
	$paging->modo('desarrollo'); 
	$numregistro=1; 

	if($numregistro) $paging->porPagina(fn_filtro((int)$numregistro));
	$paging->verPost(true);
	$mantenerVar=array("criterio_mostrar","task","criterio_usu_per",'id_curso','id_sub',"criterio_ordenar_por","criterio_orden");
	$paging->mantenerVar($mantenerVar);
	$paging->porPagina(fn_filtro((int)$porPagina));

  	$paging->ejecutar();
  	$paging->pagina_proceso="cursos_especialidades.php";  
?>    
			<table id="example1" class="table table-bordered table-striped">
              <thead>               
			  	<tr role="row">	
					<th class="unafbe" width="20"><input type="checkbox" id="chkDel" class="all"></th>			
					<th class="sort"  width="20">DíA </th>
					<th class="sort"  width="70">COD </th>
					<th class="sort">CURSO</th>
					<th class="sort cnone" width="80">MODALIDAD</th>
					<th class="sort cnone" width="50">DESTACA</th>
					<th class="sort cnone" width="60">VISIBLE</th>
					<th class="sort cnone" width="100">ACTUA</th>
					<th class="sort cnone" width="30">ESTADO</th>
			 
				</tr>
              </thead>
              <tbody id="sort">
<?php 
		
		$ya_existen=array();
		$sql_ya_existe= "SELECT cursos_especialidades FROM cursos  WHERE  id_curso='".$_GET["id_curso"]."' "; 
		$consultando=executesql($sql_ya_existe);
		if( !empty($consultando) ){
			$ya_existen=explode (',', $consultando[0]['cursos_especialidades'] ); // armamos el array 
	
		}
		  
		 // echo var_dump( $paging->fetchResultado() );

			$listado=executesql($sql);

		 // while ($detalles = $paging->fetchResultado() ): 			
			foreach ($listado as $detalles){ 
?>						
<?php 
	 // echo $detalles["id_curso"]; 

	if( in_array($detalles["id_curso"],$ya_existen)  ){
		$checked='checked';
	}else{
		$checked='';
		
	}
?>
				<tr>
					<td><input type="checkbox" name="chkDel[]" class="chkDel" value="<?php echo $detalles["id_curso"]; ?>"  <?php echo $checked; ?> ></td>		 
					<td><?php echo $detalles['fecha_registro']; ?></td>											
					<td><?php echo $detalles["codigo"]; ?></td>    
					<td><?php echo $detalles["titulo"]; ?></td>                                
					<td class="cnone"><?php echo ($detalles['modalidad']==1)?'GRABADO':'EN VIVO'; ?></td>
					<td class="cnone text-center"><?php echo ($detalles['tipo']==1)?'SI':'NO'; ?></td>
					<td class="cnone text-center"><?php echo ($detalles['visibilidad']==1)?'SI':'OCULTO'; ?></td>
					<td class="cnone"><?php echo fecha($detalles['fecha_actualizacion']); ?></td>
					<td class="cnone"><a href="javascript: fn_estado('<?php echo $detalles["id_curso"]; ?>')"><?php echo $detalles["estado"]; ?></a></td>								
				</tr>											
<?php  } // end foreach 

/*
	}else{
		echo "No se encontro resultados de cursos especialidades, en esta categoría del curso:";
		
	}
	*/
 ?>
              </tbody>
            </table>
            <div class="pagination"><?php echo $paging->fetchNavegacion(); ?></div>
<script>
$(function(){
  checked();
  sorter();
  //reordenar('cursos_especialidades.php');
	
});
var mypage = "cursos_especialidades.php";
</script>

<?php }else{ ?>
        <div class="box-body">
          <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
            <form action="javascript: fn_buscar();" id="frm_buscar" name="frm_buscar">
						
						
							<input type="hidden" name="id_curso" value="<?php echo $_GET["id_curso"];?>">
							<input type="hidden" name="id_sub" value="<?php echo $_GET["id_sub"];?>">
							<input type="hidden" name="module" value="<?php echo $_GET["module"];?>">
							<input type="hidden" name="parenttab" value="<?php echo $_GET["parenttab"];?>">
              <div class="bg-gray-light">
								<div class="col-md-12">
									<?php $curso=executesql("select * from cursos where id_curso='".$_GET["id_curso"]."' "); ?>
									<h3>Añadiendo especialidades del curso: <?php echo $curso[0]['titulo']; ?></h3>
								</div>
								<div class="col-md-2 criterio_mostrar" style="margin-bottom:10px;">
										<div class="btn-eai">
											<a href="javascript:fn_add_especialidades_a_curso(<?php echo $_GET["id_curso"];?>);" style="color:#fff;"><i class="fa fa-file"></i> Asignar </a>    
										</div>
								</div>
                
                <div class="col-sm-2 criterio_buscar">
					<?php select_sql("nregistros"); ?>

                </div>
                <div class="col-sm-4 criterio_buscar">
                  <?php create_input('text','criterio_usu_per','',"form-control pull-right",$table,'placeholder="Buscar .."'); ?>
                </div>
								
								<?php /*
								<div class="col-md-2 criterio_mostrar" style="margin-bottom:10px;">
									<select id="visibilidad" name="visibilidad" class="form-control" requerid >  <!-- saco valor desde la BD -->
											<option value="" >-- visibilidad --</option>  
											<option value="1" >SI</option>  
											<option value="2" >OCULTO</option>
										</select>
								</div> 
							*/ 	?>
								
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
var link = "curso";
var us = "curso";
var ar = "la";
var l = "a";
var l2 = "a";
var pr = "La";
var id = "id_curso";
var mypage = "cursos_especialidades.php";
</script>

<?php } ?>