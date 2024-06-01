<?php 
$inicio = 'https://'.$_SERVER['SERVER_NAME'].''.'/tw7control/';


$_url = "";
if(isset($_GET["page"]) && $_GET["page"]!=""){ switch($_GET["page"]){
    case "novedades":
      $_url="publicaciones.php";
      break;
    case "ajustes":
    case "banners":
    case "publicidades":
    case "horarios_imagenes":
    

    case "testimonios":
    case "face_testimonios":
    case "casos_de_exitos":
    case "grupos":
    case "nosotros":
    case "campos":
    case "miembros":
    case "preguntas_categorias":
    case "preguntas_frecuentes":
    case "flotantes":
    
    case "reportes_clientes_certificados":
		
    case "kardex_clientes":
    case "categorias_testimonios_v2_s":
    case "testimonios_v2_s":
		
    case "pedidos_manuales_certificados":
    case "pedidos_manuales_examenes":
      
    case "registro_emergente":
    case "canales":
    case "tipo_atenciones":
    case "tipo_interacciones":
    case "tipo_recortadorios":
		
    case "pedidos_vendedores":
    case "pedidos_vendedores_nuevos":
      
    case "suscritos_x_cursos_todos_especialidades":
    case "suscritos_x_cursos_todos_generales":
      

    case "vendedores_conectados":
    case "vendedores_por_atenciones":
    case "vendedores_por_efectividads":
		
		
    case "datos_contactos":
    case "devoluciones":
    case "otros_pagos":
    case "examene2s":
    case "examene3s":
    case "categoriablogs":
    case "tutoriales":
		
    case "contactos":
		
    case "paises":
    case "cupones":
		
    case "webinars":
    case "webinars_forma_2s":
    case "webinars_forma_3s":
    case "webinars_forma_5s":
    case "webinars_beca":
		
    case "pestanhas_webinars":  /* carta laga */
    case "pestanhas_webinars_cortas": /* carta corta */
    case "pestanhas_webinars_inicios":
    case "webinars_x_expositores":

    case "webinars_x_leads":
    
    case "landings":
    case "modulos_landings":
        
    case "landing_gratis":
    case "silabos_landing_gratis":
      
      

    case "landings_bigs":
    case "pestanhas_landings_bigs_inicios":
    case "silabos_landing_bigs":
    case "landing_big_x_expositores":
    case "landing_big_x_testimonios":
    case "landing_bigs_preguntas":
    case "pestanhas_landings_bigs_finales":



    case "clases_en_vivos":
		
    case "certificados":
    case "certificado_2formas":  // se listan los certificados y boton agregar cursos generales
    case "certificado_3formas":  // se listan los certificados y boton agregar cursos de especialidad

    case "certificados_configs":  // tabla paarametros 
    case "certificados_periodos":
    case "suscriptores_certificados_solicitados":
    case "agencias":
    case "agencias_sucursales":
        
    case "data_comisiones":  // se listan los certificados y boton agregar cursos 
    case "data_comisiones_rangos":  // se listan los certificados y boton agregar cursos 
		

    case "reporte_asistencias":
    case "reporte_asistencia2s":
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
    case "tipo_clientes":

    case "solicitudes":
    case "solicitudes_coautorias":
    case "solicitudes_libros":
    case "libros_vendidos":
    case "bancos":
    case "vouchers":
		
		
    case "pedidos":
    case "pedidos_manuales":
    case "pedidos_todos":
    case "pedidos_compartidos":
		
    case "clientes":
    case "suscriptores":
    case "comentario2s":
    case "vistas_videos":
		
    case "examenes":
    case "preguntas":
    case "respuestas":
    case "banco_preguntas_examenes":
    case "banco_preguntas":
            
    case "preguntas_bancos":
    case "respuestas_bancos":


    case "reportes_cursos_clientes":
    case "reportes_libros_clientes":
    case "reportes_coautorias_clientes":
    case "suscritos_lista_de_cursos":
    case "suscriptores_certificados":
    case "cursos_especialidades":
		
    case "revalidar_ventas": // revalidar_ventas:: para validar las compras de cursos mas registrados, asignados 

    case "reportes_ventas_onlines":

    case "reportes_clientes_cursos":
    case "reportes_compras_clientes":
    case "reportes_ventas_offlines":
    case "reportes_ventas_pago_efectivo":
    case "reportes_pedido_clientes":
    case "reportes_no_clientes":
    case "reportes_si_clientes":
    case "reportes_todos_clientes":
    case "reportes_certificados_comprados":
    case "reportes_certificados_mas_vendidos":
		case "reportes_certificados_por_clientes":
    case "reportes_solicitudes_certificados":
    case "reportes_solicitudes_coautorias":
    case "reportes_examenes_clientes":
    case "reportes_examenes_cliente2s":
		case "reportes_voucher":
    case "categoria_archivos":
    case "archivos_categoria_blogs":
    case "examenes_cursos":
    
    
    case "paginas_redes":

    //2024
    case "beneficios":
    case "pedidos_vendedores_2024_por_porcentajes_solo_jefa_ventas":
    case "reportes_todos_leads":
    case "reportes_examenes_vendidos":

      case "suscriptores_logins":


    case "usuarios":
        $_url=$_GET["page"].".php";
        break;  
    default:
        $_url="index.php";
        $section="0";           
        break;  
} }


	
	
	
$tab=array(
    "AulaVirtual"=>array(
      "Clientes" => array('url' =>"index.php?page=suscriptores"),
  ),
    
		"Ventas"=>array(
				"Transferencias" => array('url' =>"index.php?page=pedidos&tipo_pago=1"),
				"Pago_efectivo" => array('url' =>"index.php?page=pedidos&tipo_pago=3"),
				"Online" => array('url' =>"index.php?page=pedidos&tipo_pago=2"),
		),
		"Ventas Manuales"=>array(
				"venta de cursos" => array('url' =>"index.php?page=pedidos_manuales"),
				"venta de examenes" => array('url' =>"index.php?page=pedidos_manuales_examenes"),
				"ver compartidas" => array('url' =>"index.php?page=pedidos_compartidos"),
      ), 
		"Revalidar Ventas"=>array(
				"ejecutar" => array('url' =>"index.php?page=revalidar_ventas"),
      ),

    
		"Seguimiento Cliente"=>array(
      "seguimiento" => array('url' =>"index.php?page=kardex_clientes"),
		), 
		
  "OPORTUNIDAD_LABORAL"=>array(
      "Ver" => array('url' =>"index.php?page=contactos")
    ),
    "Testimonios_v2"=>array(
      "Categorías" => array('url' =>"index.php?page=categorias_testimonios_v2_s"),
      "testimonios" => array('url' =>"index.php?page=testimonios_v2_s")
  ), 

		"Libro de reclamaciones"=>array(
      "Ver" => array('url' =>"index.php?page=reclamos")
    ), 
  "Reportes"=>array(
      
    "Clientes por curso" => array('url' =>"index.php?page=reportes_clientes_cursos"),
      
    ),	
    "Reporte Vendedoras"=>array(
      "Nuevo_Comision_porcentaje_1.9" => array('url' =>'index.php?page=pedidos_vendedores_2024_por_porcentajes_solo_jefa_ventas'),     
      "Efectividad" => array('url' =>'index.php?page=vendedores_por_efectividads'),     
    ),
		
	);//array merge
  

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

    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
      <!-- Navbar Right Menu -->
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- User Account Menu -->
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
<?php
      if(empty($_url)){
					 include('reporte_inicio_generales.php');
			}
?>
    </section><!-- /.content -->
  </div><!-- /.content-wrapper -->

  
  <?php include('inc_feliz_cumple.php'); ?>

  <!-- Main Footer -->
  <footer class="main-footer">
    <!-- Default to the left -->
    <small>Copyright &copy; 2022 <a href="https://tuweb7.com/paginas-web" target="_blank">Tuweb7.com</a>. Todos los Derechos Reservados.</small>
  </footer>
</div><!-- ./wrapper -->
