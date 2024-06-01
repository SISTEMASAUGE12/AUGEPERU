
<?php 
$inicio = 'http://'.$_SERVER['SERVER_NAME'].''.'/tw7control/';

$_url = "";
if(isset($_GET["page"]) && $_GET["page"]!=""){ switch($_GET["page"]){
    case "novedades":
      $_url="publicaciones.php";
      break;

      case "flotantes":
   
    case "suscriptores":
		case "pedidos_manuales":
		case "kardex_clientes":
		case "suscriptores_algoritmos":
		case "suscriptores_tokys":
		
		case "solicitudes":
		case "suscriptores_eventos":

		case "pedidos":
		case "pedidos_manuales_certificados":
		
    case "reportes_compras_clientes":
    case "reportes_compras_clientes_ventas":

    case "reportes_todos_clientes_ventas":
   
	 case "reportes_certificados_comprados":
    case "reportes_certificados_mas_vendidos":
		case "reportes_certificados_por_clientes":
    case "reportes_solicitudes_certificados":
    case "reportes_solicitudes_coautorias":
    case "reportes_examenes_clientes":
    case "reportes_examenes_cliente2s":
		case "reportes_voucher":


    case "examenes":
    case "preguntas":
    case "respuestas":
    case "banco_preguntas_examenes":
    case "banco_preguntas":
    case "examenes_cursos": 
    case "examene2s":
    case "examene3s":
    
    
    case "profesores":
    case "tipo_cursos":
    case "categorias":
    case "subcategorias":
    case "libros":
    case "libros_coautores":
    case "categoria_examenes":
    case "destacados":
    
    case "cursos":
    case "sesiones":
    case "detalle_sesiones":
    case "suscritos_x_cursos":
    case "archivos_detalle_sesion_virtuals":
    case "curso_trailers":
    
        
    case "reclamos":
    case "pestanhas":
    case "silabos":
    case "especialidades":
    case "escala_magisteriales":
    case "solicitudes":
    case "solicitudes_coautorias":
    case "solicitudes_libros":
    case "libros_vendidos":

    case "suscriptores":
    case "preguntas_bancos":		
    case "respuestas_bancos":		
    case "categoria_examenes":
    case "examenes":
    case "examenes_cursos":
          

    case "preguntas_bancos_por_corregirs":
    case "preguntas_bancos_corregidas":		
    case "preguntas_bancos_deshabilitados":		


    case "usuarios":
        $_url=$_GET["page"].".php";
        break;  
    default:
        $_url="index.php";
        $section="0";           
        break;  
} }



    $tab=array(
      // "Bienvenido"=>array(
      //   "Bienvenido" => array("url"=>"index.php?page=x"),
      // ), 
      "Web"=>array(
        
				"Ventana_emergente" => array('url' =>"index.php?page=flotantes"),
		),
      "Banco Depuracion"=>array(        
        "Por_depurar" => array("url"=>"index.php?page=preguntas_bancos_por_corregirs"),
        "Corregidas" => array("url"=>"index.php?page=preguntas_bancos_corregidas"),       
        "Deshabilitadas" => array("url"=>"index.php?page=preguntas_bancos_deshabilitados"),        
      ),
      "Examenes"=>array(
        "Categorías Examenes" => array("url"=>"index.php?page=categoria_examenes"),     
        //"Banco de preguntas" => array("url"=>"index.php?page=banco_preguntas"),
        "Banco de preguntas" => array("url"=>"index.php?page=preguntas_bancos"),
        "Examenes" => array("url"=>"index.php?page=examenes"),
        "Dar permisos" => array("url"=>"index.php?page=examenes_cursos&id_tipo=1")
      )
    );

    $array_tipo_cursos=array();	
    $tipo_cursos=executesql("select * from tipo_cursos where estado_idestado=1 ");	
    if( !empty($tipo_cursos) ){
    foreach($tipo_cursos as $row){
      $separcion_tipo='';

      if( $row["titulo"]=="Programas" ){
        $nombre_sub_menu='Cursos';
        $pagina_link='cursos';

        // $separcion_tipo=array( /*1. GENERAL; 2. EPSECIALIDADES */
          // "Especialidades" => array("url"=>"index.php?page=".$pagina_link."&id_tipo=".$row["id_tipo"]."&id_tipo_curso=2"),
          // "Cursos" => array("url"=>"index.php?page=".$pagina_link."&id_tipo=".$row["id_tipo"]."&id_tipo_curso=1")
        // );

      }else if($row["titulo"]=="Gratuitos"){
        $nombre_sub_menu='Cursos';
        $pagina_link='cursos';

      }else if($row["titulo"]=="Libros"){
        $nombre_sub_menu=$row["titulo"];
        $pagina_link='libros';

      }else if($row["titulo"]=="Libros Coautores"){
        $nombre_sub_menu="ver";			
        $pagina_link='libros_coautores';
      }


      // $nombre_sub_menu=($row["titulo"]=="Libros")?'Libros':'Cursos';
      // $pagina_link=($row["titulo"]=="Libros")?'libros':'cursos';

      $array_tipo_cursos=array_merge( 
          $array_tipo_cursos, array (
              $row["titulo"]=>array(
                "Categorías" => array("url"=>"index.php?page=categorias&id_tipo=".$row["id_tipo"]),
                "Subcategorías" => array("url"=>"index.php?page=subcategorias&id_tipo=".$row["id_tipo"]),
                "Destacados" => array("url"=>"index.php?page=destacados&tipo=1&id_tipo=".$row["id_tipo"]),
                $nombre_sub_menu => array("url"=>"index.php?page=".$pagina_link."&id_tipo=".$row["id_tipo"])
              )
        )
      ); // array_merge

    } // for tipo_cursos
  }

  $tab=array_merge(	$tab, $array_tipo_cursos);

    


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


<?php 

// MODALES EMERGENTES RECORTADORIOS 
include("inc_modales_flotantes_sistema_ventas.php");

?>


<?php include('inc_feliz_cumple.php'); ?>

	  <!-- Main Footer -->
  <footer class="main-footer">
    <!-- Default to the left -->
    <small>Copyright &copy; 2022 <a href="https://tuweb7.com/paginas-web" target="_blank">Tuweb7.com</a>. Todos los Derechos Reservados.</small>
  </footer>
</div><!-- ./wrapper -->
