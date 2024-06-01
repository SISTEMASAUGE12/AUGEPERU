<?php error_reporting(E_ALL ^ E_NOTICE); include ("auten.php");

if($_GET["task"]=='insert'){
  $bd=new BD;
  $contrasena=md5($_POST["contrasena"]);
  $norden=_orden_noticia("","usuario","");
	if(empty($_POST['comision'])) $_POST['comision']='1'; 

  
  $campos=array('nombre_corto',"estado_idestado",'banco','cuenta_banco',"idtipo_usu","codusuario",'comision','toky','tipo_asesora',"nomusuario", "email",'cumple_detalle', array("contrasena",$contrasena), array("fecha_ingreso",fecha_hora(2)), array("orden",$norden));  

  if( !empty($_POST["fecha_ingreso_laboral"]) ){
    $campos=array_merge($campos,array('fecha_ingreso_laboral'));
  }

  if( !empty($_POST["fecha_culmino"]) ){
    $campos=array_merge($campos,array('fecha_culmino'));
  }

  if( !empty($_POST["fecha_cumple"]) ){
    $campos=array_merge($campos,array('fecha_cumple'));
  }

  if(isset($_FILES['imagen']) && !empty($_FILES['imagen']['name'])){
    $_POST['imagen'] = carga_imagen('files/images/usuario/','imagen','','200','200');
    $campos = array_merge($campos,array('imagen'));
  }


  if(isset($_FILES['cumple_imagen']) && !empty($_FILES['cumple_imagen']['name'])){
    $_POST['cumple_imagen'] = carga_imagen('files/images/usuario/','cumple_imagen','','400','400');
    $campos = array_merge($campos,array('cumple_imagen'));
  }

  $sql=arma_insert("usuario",$campos,"POST");       
  $ninsert=$bd->inserta_($sql);
  $bd->close();

  if($ninsert<=0){
    gotoUrl($_POST["urlfailed"]."&error");
  }else{
    gotoUrl("index.php?page=".$_POST["nompage"]."&module=".$_POST["nommodule"]."&parenttab=".$_POST["nomparenttab"]);
  }



}elseif($_GET["task"]=='update'){
  $bd=new BD;
	if(empty($_POST['comision'])) $_POST['comision']='1'; 
	
  if($_POST["contrasena"]=="") $contrasena=$_POST["contrasena_ant"];
  else $contrasena=md5($_POST["contrasena"]);
  $where.=" idusuario='".$_POST["idusuario"]."'";
  $campos=array("estado_idestado",'nombre_corto','banco','cuenta_banco','idtipo_usu',"codusuario",'comision','toky','tipo_asesora',"nomusuario", "email",'cumple_detalle', array("contrasena",$contrasena));
 

  if( !empty($_POST["fecha_ingreso_laboral"]) ){
    $campos=array_merge($campos,array('fecha_ingreso_laboral'));
  }
  
  if( !empty($_POST["fecha_culmino"]) ){
    $campos=array_merge($campos,array('fecha_culmino'));
  }

  if( !empty($_POST["fecha_cumple"]) ){
    $campos=array_merge($campos,array('fecha_cumple'));
  }


  if(isset($_FILES['imagen']) && !empty($_FILES['imagen']['name'])){
    $path = 'files/images/usuario/'.$_POST['imagen_ant'];
    if( file_exists($path) && !empty($_POST['imagen_ant']) ) unlink($path);    
    $_POST['imagen'] = carga_imagen('files/images/usuario/','imagen','','200','200');
    $campos = array_merge($campos,array('imagen'));  
  }
  
  if(isset($_FILES['cumple_imagen']) && !empty($_FILES['cumple_imagen']['name'])){
    $path = 'files/images/usuario/'.$_POST['imagen_ant_2'];
    if( file_exists($path) && !empty($_POST['imagen_ant_2']) ) unlink($path);    
    $_POST['cumple_imagen'] = carga_imagen('files/images/usuario/','cumple_imagen','','400','400');
    $campos = array_merge($campos,array('cumple_imagen'));  
  }
  



  $query=armaupdate("usuario",$campos,$where,"POST");
  $numupdates=$bd->actualiza_($query);
  $bd->close();
  
  gotoUrl("index.php?page=".$_POST["nompage"]."&module=".$_POST["nommodule"]."&parenttab=".$_POST["nomparenttab"]);
  
}elseif($_GET["task"]=='new' || $_GET["task"]=='edit'){
  if($_GET["task"]=='edit'){
     $usuario=executesql("select * from usuario where idusuario='".$_GET["idusuario"]."'",0);
  }
?>
<section class="content">
  <div class="row">
    <div class="col-md-12">
          <!-- Horizontal Form -->
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">
                <?php echo ($_GET["task"]=="edit") ? 'Editar' : 'Nuevo'; ?> Usuario</h3>
            </div><!-- /.box-header -->
<?php $task_=$_GET["task"]; ?>
            <!-- form start -->
            <form action="usuarios.php?task=<?php echo ($task_=='edit') ?  "update" : "insert"; ?>" class="form-horizontal" method="POST" method="POST" enctype="multipart/form-data" autocomplete="OFF">
            
<?php 
if($task_=='edit') create_input("hidden","idusuario",$usuario["idusuario"],"",$table,"");
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
                    <?php crearselect("estado_idestado","select * from estado",'class="form-control"',$usuario["estado_idestado"],""); ?>
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Tipo perfil</label>
                  <div class="col-sm-6">
                    <?php crearselect("idtipo_usu","select * from tipo_usuario order by nombre_tipousu desc",'class="form-control"',$usuario["idtipo_usu"],""); ?>
                  </div>
                </div>
								
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Nombre Completo</label>
                  <div class="col-sm-6">
                    <?php create_input("text","nomusuario",$usuario["nomusuario"],"form-control",$table,"required",$agregado); ?>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Nombre corto: 1 nombre + 1 apellido </label>
                  <div class="col-sm-6">
                    <?php create_input("text","nombre_corto",$usuario["nombre_corto"],"form-control",$table,"required",$agregado); ?>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">E-mail</label>
                  <div class="col-sm-6">
                    <input type="email" id="email" name="email" class="form-control" required value="<?php echo $usuario["email"]; ?>">
                  </div>
                </div>
								
                <div class="form-group">								
                 <label for="inputPassword3" class="col-md-2 col-sm-2 control-label">Tipo asesora:</label>
									<div class="col-sm-3">
										<select id="tipo_asesora" name="tipo_asesora" class="form-control" requerid >  <!-- saco valor desde la BD -->
											<option value="1" <?php echo ($usuario['tipo_asesora'] == 1) ? 'selected' : '' ;?>>OFICINA</option>  
											<option value="2"  <?php echo ($usuario['tipo_asesora'] == 2) ? 'selected' : '' ;?>>EXTERNO</option>
										</select>
									</div>																
                </div>
								

								<div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Comision (ejemplo x 10)</label>
                  <div class="col-sm-6">
											<?php create_input("text","comision",$usuario["comision"],"form-control",$table," "); /* el 2 permite poner  decmales */?> 
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Banco </label>
                  <div class="col-sm-6">
											<?php create_input("text","banco",$usuario["banco"],"form-control",$table," "); /* el 2 permite poner  decmales */?> 
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Cuenta Bancaria: </label>
                  <div class="col-sm-6">
											<?php create_input("text","cuenta_banco",$usuario["cuenta_banco"],"form-control",$table,"onkeypress='javascript:return soloNumeros_precio(event,2);'"); /* el 2 permite poner  decmales */?> 
                  </div>
                </div>

								<div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Link TOKY </label>
                  <div class="col-sm-6">
											<?php create_input("text","toky",$usuario["toky"],"form-control",$table,"onkeypress='javascript:return soloNumeros_precio(event,2);'"); /* el 2 permite poner  decmales */?> 
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Imágen :</label>
                  <div class="col-sm-6">
                    <input type="file" name="imagen" id="imagen" class="form-control">
                    <?php create_input("hidden","imagen_ant",$usuario["imagen"],"",$table,$agregado); 
                      if($usuario["imagen"]!=""){ 
                    ?>
                      <img src="<?php echo "files/images/usuario/".$usuario["imagen"]; ?>" width="200" class="mgt15">
                    <?php } ?>
                      <small style="color:red">Recomendado: 200 x 200</small>
                  </div>
                </div>
               
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Fecha Ingreso laboral:  </label>
                  <div class="col-sm-6">
											<?php create_input("date","fecha_ingreso_laboral",$usuario["fecha_ingreso_laboral"],"form-control",$table," "); /* el 2 permite poner  decmales */?> 
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Fecha Culmino trabajo </label>
                  <div class="col-sm-6">
											<?php create_input("date","fecha_culmino",$usuario["fecha_culmino"],"form-control",$table," "); /* el 2 permite poner  decmales */?> 
                  </div>
                </div>

                

                <h3>CUMPLEAÑOS</h3>
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Fecha Cumpleaños </label>
                  <div class="col-sm-6">
											<?php create_input("date","fecha_cumple",$usuario["fecha_cumple"],"form-control",$table," "); /* el 2 permite poner  decmales */?> 
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Felicitar cumpleaños </label>
                  <div class="col-sm-6">
											<?php create_input("textarea","cumple_detalle",$usuario["cumple_detalle"],"form-control",$table,""); /* el 2 permite poner  decmales */?> 
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Imágen cumpleaños:</label>
                  <div class="col-sm-6">
                    <input type="file" name="cumple_imagen" id="cumple_imagen" class="form-control">
                    <?php create_input("hidden","imagen_ant_2",$usuario["cumple_imagen"],"",$table,$agregado); 
                      if($usuario["cumple_imagen"]!=""){ 
                    ?>
                      <img src="<?php echo "files/images/usuario/".$usuario["cumple_imagen"]; ?>" width="200" class="mgt15">
                    <?php } ?>
                      <small style="color:red">Recomendado: 400 x 400</small>
                  </div>
                </div>

                <h3>CREDENCIALES ACCESO: </h3>

                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Usuario</label>
                  <div class="col-sm-6">
                    <?php create_input("text","codusuario",$usuario["codusuario"],"form-control",$table,"required",$agregado); ?>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Contraseña</label>
                  <div class="col-sm-6">
                    <?php 
                    create_input("password","contrasena","","form-control",$table,$agregado);
                    create_input("hidden","contrasena_ant",$usuario["contrasena"],"",$table,$agregado); ?>
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
}elseif($_GET["task"]=='dropselect'){
  $bd = new BD;
  $bd->Begin();
  $chkDel = implode(",",str_replace('chkDel','',$_GET["chkDel"])); $chkDel_ex = explode(",",$chkDel); $chkDel_ct = count(explode(",",$chkDel));
  
  for($i=0;$i<$chkDel_ct;$i++){
    $num_afect+=$bd->actualiza_("delete from usuario where idusuario='".$chkDel_ex[$i]."'");
  }
  
  $bd->Commit();
  $bd->close();
  
  if($numupdates<=0){echo "Error: eliminando registro"; exit;}
  
}elseif($_GET["task"]=='drop'){
  $bd = new BD;
  $bd->Begin();

  $num_afect=$bd->actualiza_("delete from usuario where idusuario='".$_GET["idusuario"]."'");
  
  $bd->Commit();
  $bd->close();
  
  if($num_afect<=0){echo "Error: eliminando registro"; exit;}


}elseif($_GET["task"]=='uestado'){
  $bd = new BD;
  $bd->Begin();
  $ide = !isset($_GET['idusuario']) ? $_GET['estado_idestado'] : $_GET['idusuario'];
  $ide = is_array($ide) ? implode(',',$ide) : $ide;
  $usuario = executesql("SELECT * FROM usuario WHERE idusuario IN (".$ide.")");
  if(!empty($usuario))
  foreach($usuario as $reg => $item)
  if ($item['estado_idestado']==1) {
    $state = 2;
  }elseif ($item['estado_idestado']==2) {
    $state = 1;
  }
  $num_afect=$bd->actualiza_("UPDATE usuario SET estado_idestado=".$state." WHERE idusuario=".$ide."");
  echo $state;
  $bd->Commit();
  $bd->close();

}elseif($_GET["task"]=='finder'){

  $sql.= "SELECT u.*, t.nombre_tipousu AS tipo_usuario, e.nombre AS estado 
						FROM usuario u 
					INNER JOIN 	tipo_usuario t ON u.idtipo_usu=t.idtipo_usu 
					INNER JOIN  estado e ON u.estado_idestado=e.idestado 
					WHERE u.estado_idestado=e.idestado   ";
					
  if(isset($_GET['idtipo_usu']) && !empty($_GET['idtipo_usu'])){
		$sql.= " AND u.idtipo_usu='".$_GET['idtipo_usu']."' ";
	}
	
  if (isset($_GET['criterio_mostrar'])) $porPagina=$_GET['criterio_mostrar'];
  if(isset($_GET['criterio_usu_per'])){
    $stringlike=fn_filtro(substr($_GET['criterio_usu_per'], 0, 16));
    $sql.= " AND (codusuario like '%".$stringlike."%' OR nomusuario LIKE '%".$stringlike."%')";
  }
  if(isset($_GET['criterio_ordenar_por'])) $sql.= sprintf(" order by %s %s", fn_filtro($_GET['criterio_ordenar_por']), fn_filtro($_GET['criterio_orden']));
  $sql.= " ORDER BY orden DESC";
	
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
  $paging->pagina_proceso="usuarios.php";
?>
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr role="row">
                  <th class="unafbe" width="20"><input type="checkbox" id="chkDel" class="all"></th>
                  <th class="sort cnone">TIPO USUARIO</th>
                  <th class="sort">NOMBRES COMPLETOS</th>
                  <th class="sort">NOMBRES corto</th>
                  <th class="sort cnone">E-MAIL</th>
                  <th class="sort cnone">USUARIO</th>
                  <th class="sort cnone">TIPO</th>
                  <th class="sort cnone">COMISION s/</th>
                  <th class="sort cnone">IMAGEN</th>
                  <th class="sort cnone">TOKY</th>
                  <th class="sort cnone">Fecha_cumple</th>
                  <th class="sort cnone">Fecha_ingreso</th>
                  <th class="sort cnone">Fecha_culmino</th>
                  <th class="sort cnone">ESTADO</th>
                  <th class="unafbe">Opciones</th>
                </tr>
              </thead>
              <tbody id="sort">
<?php while ($detalles = $paging->fetchResultado()): ?>
                <tr id="order_<?php echo $detalles["idusuario"]; ?>">
                  <td><input type="checkbox" name="chkDel[]" class="chkDel" value="<?php echo $detalles["idusuario"]; ?>" id="id"></td>
                  <td class="cnone"><?php echo $detalles["tipo_usuario"]; ?></td>
                  <td><?php echo $detalles["nomusuario"]; ?></td>
                  <td><?php echo $detalles["nombre_corto"]; ?></td>
                  <td class="cnone"><?php echo $detalles["email"]; ?></td>
                  <td class="cnone"><?php echo $detalles["codusuario"]; ?></td>
                  <td class="cnone"><?php echo ($detalles["tipo_asesora"]==1)?'OFICINA':'EXTERNO'; ?></td>
                  <td class="cnone"><?php echo $detalles["comision"]; ?></td>
                  <td class="cnone"><?php echo !empty($detalles["imagen"])?'SI':'NO'; ?></td>
                  <td class="cnone"><?php echo !empty($detalles["toky"])?'SI':'NO'; ?></td>
                  <td class="cnone"><?php echo $detalles["fecha_cumple"]; ?></td>
                  <td class="cnone"><?php echo $detalles["fecha_ingreso_laboral"]; ?></td>
                  <td class="cnone"><?php echo $detalles["fecha_culmino"]; ?></td>
                  <td class="cnone"><a href="javascript: fn_estado('<?php echo $detalles["idusuario"]; ?>')"><?php echo $detalles["estado"]; ?></a></td>
                  <td>
                    <div class="btn-eai btr">
                      <a href="<?php echo $_SESSION["base_url"].'&task=edit&idusuario='.$detalles["idusuario"]; ?>"><i class="fa fa-edit"></i></a>
                      <a href="javascript: fn_eliminar('<?php echo $detalles["idusuario"]; ?>')"><i class="fa fa-trash-o"></i></a>
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
});
</script>

<?php }else{ ?>

<?php  if($_SESSION["visualiza"]["idtipo_usu"] ==1){ ?>
        <div class="box-body">
          <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
            <form action="javascript: fn_buscar();" id="frm_buscar" name="frm_buscar">
              <div class="bg-gray-light">
                <div class="col-sm-3">
                  <div class="btn-eai">
                    <a href="<?php echo $link2."&task=new"; ?>" style="color:#fff;"><i class="fa fa-file"></i> agregar</a>
                    <a href="javascript:fn_delete_all();"><i class="fa fa-trash-o"></i></a>
                  </div>
                </div>
                <div class="col-sm-3 criterio_buscar">
                  <label for="">Criterio</label>
                  <?php create_input('text','criterio_usu_per','',"form-control pull-right",$table,$agregados); ?>
                </div>
								<div class="col-sm-3 criterio_buscar" style="padding-bottom:8px;">
											<?php crearselect("idtipo_usu", "select idtipo_usu, nombre_tipousu from tipo_usuario order by nombre_tipousu asc", 'class="form-control" ', '', "-- Tipo usuario -- "); ?>
										</div>
                <div class="col-sm-1 criterio_mostrar">
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
	<?php }else{
		 echo "<div style='padding:90px 0;text-align:center;'> <p>  No tienes permiso a este modulo. </p></div>";
	} 
	?>
	
<script>
var link = "usuario";
var us = "usuario";
var l = "o";
var l2 = "e";
var pr = "El";
var ar = "al";
var id = "idusuario";
var mypage = "usuarios.php";
</script>
<?php } ?>