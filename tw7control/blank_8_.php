<?php 
$inicio = 'http://'.$_SERVER['SERVER_NAME'].''.'/tw7control/';

$_url = "";
if(isset($_GET["page"]) && $_GET["page"]!=""){ switch($_GET["page"]){
    case "novedades":
      $_url="publicaciones.php";
      break;
   
    case "suscriptores":
		case "preguntas_bancos":		
		case "categoria_examenes":
		case "examenes":
		case "examenes_cursos":

		case "reportes_voucher":

    case "usuarios":
        $_url=$_GET["page"].".php";
        break;  
    default:
        $_url="index.php";
        $section="0";           
        break;  
} }

$tab=array(
	"Examenes"=>array(
    "Categorías Examenes" => array(url=>"index.php?page=categoria_examenes"),     
    //"Banco de preguntas" => array(url=>"index.php?page=banco_preguntas"),
    "Banco de preguntas" => array(url=>"index.php?page=preguntas_bancos"),
    "Examenes" => array(url=>"index.php?page=examenes"),
    "Dar permisos" => array(url=>"index.php?page=examenes_cursos&id_tipo=1")
  )
);  

?>
<div class="wrapper">

  <!-- Main Header -->
  <header class="main-header">
    <a href="<?php echo $url; ?>" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>A</b>C</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg">Administrador</span>
    </a>
<?php
/* calculo recordatorios */
	$sql_recordatorio= "SELECT d.*,YEAR(d.fecha_registro) as anho, MONTH(d.fecha_registro) as mes, CONCAT(s.nombre,' ',s.ap_pa,' ',s.ap_ma) as suscrito , s.dni as dni, s.email as email, s.telefono as telefono, e.nombre AS estado , n.titulo as nivel, tr.titulo as recordatorio 
	FROM kardex_clientes d 
	INNER JOIN suscritos s ON s.id_suscrito=d.id_suscrito 
	INNER JOIN kardex_niveles_de_interes n ON d.id_nivel =n.id_nivel
	INNER JOIN tipo_recortadorios tr ON d.id_tipo_recordatorio =tr.id_tipo_recordatorio 
	INNER JOIN estado e ON d.estado_idestado=e.idestado 
	WHERE d.idusuario='".$_SESSION["visualiza"]["idusuario"]."' and fecha_recordatorio='".fecha_hora(1)."' 
	ORDER BY d.hora_recordatorio ASC ";
	
	$recordatorio=executesql($sql_recordatorio); 
	$n_recordatorios=count($recordatorio);
?>
	
    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation">
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">MENU</span>
      </a>
      <!-- Navbar Right Menu -->
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- boton recordatorio -->
          <li class="dropdown user user-menu">
            <button type="button" class="btn btn-primary" style="background-color: red;border-color: red;margin-top:8px;" data-toggle="modal" data-target="#modal_recordatorio">
							<i class="fa fa-bell " style="padding-right:5px;"></i> <?php echo $n_recordatorios; ?>
						</button>
          </li>
					<li class="dropdown user user-menu">

            <a href="<?php echo $url; ?>?task=salir">
              <?php echo $name."<br><small>("; echo ($tiu==1) ? 'Administrador' : 'Invitado'; echo ")</small>"; ?> | Salir</a>
          </li>
        </ul>
      </div>
    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

      <!-- Logo -->
      <div class="user-panel">
        <div class="pull-left image">
		<!--
          <img src="dist/img/logo.png" class="" alt="">
		  -->
        </div>
        <!-- <div class="pull-left info">
          <p><?php echo $name; ?></p>
          <small>(<?php echo ($tiu==1) ? 'Administrador' : 'Invitado'; ?>)</small>
        </div> -->
      </div>

      <!-- Sidebar Menu -->
      <ul class="sidebar-menu">
        <li class="header">SECCIONES</li>
			<!-- 
				-->
<?php
foreach ($tab as $parenttab => $modules){
  $issue_parenttab = isset($_GET['parenttab']);
  $isset_array = is_array($modules);
?>
        <li class="treeview <?php if($issue_parenttab && $parenttab==$_GET["parenttab"]){ echo "active"; } ?>">
          <a href="<?php echo $isset_array ? 'javascript:void(0);' : $modules.'&module='.$parenttab.'&parenttab='.$parenttab; ?>">
            <i class="fa fa-link"></i> <span><?php echo $parenttab; ?></span>
            <?php if($isset_array){ ?>
            <i class="fa fa-angle-left pull-right"></i>
            <?php } ?>
          </a>
<?php
if(is_array($modules)){
?>
          <ul class="treeview-menu">
<?php
  foreach ($modules as $module => $array) {
    $issue_module = isset($_GET['module']);
?>
            <li class="<?php if($issue_module && $module==$_GET["module"]){ echo "active"; } ?>">
              <a href="<?php echo ($array["url"]=='principal') ? $url : $array["url"].'&module='.$module.'&parenttab='.$parenttab ?>" class="<?php if($issue_module && $module==$_GET["module"]){ echo "active"; } ?>">
                <i class="fa fa-files-o"></i><span><?php echo $module; ?></span>
              </a>
            </li>
<?php } ?>
          </ul>
<?php } ?>
        </li>
<?php } ?>
      </ul><!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
      <div class="box">
        <?php if(isset($_GET["module"])){ ?>
        <div class="box-header">
          <h3 class="box-title" ><small style="padding-left:15px;color:#333;"> Sección &raquo; <?php echo $_GET["parenttab"].' - '.$_GET["module"]; ?> </small></h3>
        </div><!-- /.box-header -->
        <?php } ?>
        <?php if($_url!="") include($_url); ?>
      </div><!-- /.box -->
<?php  /* pabtalla de inicio - reportes */
      if(empty($_url)){
				if( $_SESSION["visualiza"]["idtipo_usu"] !=4 ){
					// include('reporte_inicio_generales.php');
				}
			}
?>
    </section><!-- /.content -->
  </div><!-- /.content-wrapper -->
	
	<?php /* FLOTANTE ---  */
	
	?>



<!-- Modal -->
<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" id="modal_recordatorio" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><b>RECORDATORIOS DEL DÍA HOY <?php echo fecha_hora(1); ?></b></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
	<?php 
	// echo $sql_recordatorio; 
	if( !empty($recordatorio) ){
	?>
					<table id="example1" class="table table-bordered table-striped">
						<tbody id="sort">	
							<tr role="row">
								<th width="30">HORA</th>
								<th class="sort cnone">CLIENTE</th>
								<th class="sort cnone">DNI</th>
								<th class="sort ">CEL</th>
								<th class="sort cnone ">NIVEL</th>
								<th class="sort cnone">DETALLE</th>
								<th class="sort ">RECORDATORIO</th>                                    
								<th class="sort  unafbe">VER</th>                                      
							</tr>
		<?php foreach($recordatorio as $recorda){ ?>			
							<tr>
								<td><?php echo $recorda["hora_recordatorio"];?></td>				       
								<td class="cnone"><?php echo $recorda["suscrito"];?></td>
								<td class="cnone"><?php echo $recorda["dni"];?> </td>
								<td><?php echo $recorda["telefono"];?></td>
								<td class="cnone"><?php echo $recorda["nivel"];?></td>
								<td class="cnone"><?php echo $recorda["descripcion"];?></td>
								<td><?php echo $recorda["recordatorio"];?></td>                    
								<td>
									<a target="_blank" href="index.php?page=kardex_clientes&amp;task=edit&amp;&amp;id_kar_cli=<?php echo $recorda["id_kar_cli"];?>&amp;module=&amp;parenttab=" style="background:blue;padding:6px;color:#fff;border-radius:8px;" title="editar"><span> ver</span>
									</a> 
								</td>  
							</tr>
		<?php } /* end for */ ?>
						</tbody>
					</table>
	<?php 
	}else{
		echo "<h3 class='text-center '>No tienes recordatorios el dia de hoy.</h3>";
	} /* end si existe recordatorio */
	?>
							
				
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">CERRAR</button>
				<!--
        <button type="button" class="btn btn-primary">Save changes</button>
				-->
      </div>
    </div>
  </div>
</div>
<!-- END modal recordatorio -->

<?php include('inc_feliz_cumple.php'); ?>

	

  <!-- Main Footer -->
  <footer class="main-footer">
    <!-- Default to the left -->
    <small>Copyright &copy; 2022 <a href="https://tuweb7.com/paginas-web" target="_blank">Tuweb7.com</a>. Todos los Derechos Reservados.</small>
  </footer>
</div><!-- ./wrapper -->
