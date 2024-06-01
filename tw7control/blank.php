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
    case "landin_libro":
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

    case "referidos";
    case "registrar_referido";

		
		
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
    case "pedidos_vendedores_2024_por_porcentajes":
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
    "Web"=>array(
        "Configuraciones" => array('url' =>"index.php?page=registro_emergente"),
        "Banners" => array('url' =>"index.php?page=banners"),
        "Portada" => array('url' =>"index.php?page=campos"),
        "Portada_beneficios" => array('url' =>"index.php?page=beneficios"),

        "Nosotros" => array('url' =>"index.php?page=nosotros"),
        "Contacto" => array('url' =>"index.php?page=ajustes"),
        "Testimonios" => array('url' =>"index.php?page=testimonios"),
        "Testimonios de Facebook" => array('url' =>"index.php?page=face_testimonios"),
        "Casos_de_éxito" => array('url' =>"index.php?page=casos_de_exitos"),
        "Redes sociales" => array('url' =>"index.php?page=grupos"),
        //"Area_de_Miembros" => array('url' =>"index.php?page=miembros"),
				"Video_Tutoriales_clientes" => array('url' =>"index.php?page=tutoriales&tipo=1"),
				"Video_Tutoriales_personal" => array('url' =>"index.php?page=tutoriales&tipo=2"),
				"Ventana_emergente" => array('url' =>"index.php?page=flotantes"),
				"Publicidad" => array('url' =>"index.php?page=publicidades"),
		),
		"AulaVirtual"=>array(
        // "Cupones" => array('url' =>"index.php?page=cupones"),
        "Horarios" => array('url' =>"index.php?page=horarios_imagenes"),
        "Tutores" => array('url' =>"index.php?page=profesores"),
        "Clientes" => array('url' =>"index.php?page=suscriptores"),
          
       // "Solicitudes Certificados" => array('url' =>"index.php?page=solicitudes"),     
        // "Examenes" => array('url' =>"index.php?page=examenes"),     
        "Comentarios Cursos" => array('url' =>"index.php?page=comentario2s"),
        "Asignar_Todo_especialidades" => array('url' =>"index.php?page=suscritos_x_cursos_todos_especialidades"),
        "Asignar_Todo_generales" => array('url' =>"index.php?page=suscritos_x_cursos_todos_generales")
		),
    "Examenes"=>array(
        "Categorías Examenes" => array('url' =>"index.php?page=categoria_examenes"),     
        //"Banco de preguntas OLD" => array('url' =>"index.php?page=banco_preguntas"),
        "Banco de preguntas" => array('url' =>"index.php?page=preguntas_bancos"),
        "Examenes" => array('url' =>"index.php?page=examenes"),
        "Dar permisos" => array('url' =>"index.php?page=examenes_cursos&id_tipo=1")
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
				// "Especialidades" => array('url' =>"index.php?page=".$pagina_link."&id_tipo=".$row["id_tipo"]."&id_tipo_curso=2"),
				// "Cursos" => array('url' =>"index.php?page=".$pagina_link."&id_tipo=".$row["id_tipo"]."&id_tipo_curso=1")
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
							"Categorías" => array('url' =>"index.php?page=categorias&id_tipo=".$row["id_tipo"]),
							"Subcategorías" => array('url' =>"index.php?page=subcategorias&id_tipo=".$row["id_tipo"]),
							"Destacados" => array('url' =>"index.php?page=destacados&tipo=1&id_tipo=".$row["id_tipo"]),
							$nombre_sub_menu => array('url' =>"index.php?page=".$pagina_link."&id_tipo=".$row["id_tipo"])
						)
			)
		); // array_merge
		
	} // for tipo_cursos
}
	
	
$tab=array_merge(	$tab, $array_tipo_cursos, 
	array(
    "Libros_seguimiento"=>array(
      "Libros" => array('url' =>"index.php?page=solicitudes_libros"),
      "Couatoria_libros" => array('url' =>"index.php?page=solicitudes_coautorias"), 
    ),  
		"Clases_vivo"=>array(
				"ver" => array('url' =>"index.php?page=clases_en_vivos&tipo_pago=1")				
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

    "Certificados"=>array(
        "Crear generales" => array('url' =>"index.php?page=certificado_2formas"),
        "Crear especialidades" => array('url' =>"index.php?page=certificado_3formas"),
        "venta de manual" => array('url' =>"index.php?page=pedidos_manuales_certificados"),
        "Seguimiento" => array('url' =>"index.php?page=solicitudes"),     		
        "Clientes_x_certificado" => array('url' =>"index.php?page=reportes_clientes_certificados"),     		
          		
        "Configuración_pdf" => array('url' =>"index.php?page=certificados_configs"),     		
        "Periodos" => array('url' =>"index.php?page=certificados_periodos"),     		
		), 
    "Campañas"=>array(
      "Referidos" => array('url' =>"index.php?page=referidos"),  		
  ), 

		"Seguimiento Cliente"=>array(
      "seguimiento" => array('url' =>"index.php?page=kardex_clientes"),
		), 
		"Agencias_de_envio"=>array(
      "Agencias" => array('url' =>"index.php?page=agencias"),     		
      "Sucursales" => array('url' =>"index.php?page=agencias_sucursales"),  
    ), 
    
		"Otras_operaciones"=>array(
				"Pagos" => array('url' =>"index.php?page=otros_pagos"),
				"Devoluciones" => array('url' =>"index.php?page=devoluciones"),
		), 
    "Preguntas_frecuentes"=>array(
				"Categorias_frecuentes" => array('url' =>"index.php?page=preguntas_categorias"),
				"Preguntas_frecuentes" => array('url' =>"index.php?page=preguntas_frecuentes")
		),
		
		
		"Blog"=>array(
				"Categorías" => array('url' =>"index.php?page=categoriablogs"),
				"Publicaciones" => array('url' =>"index.php?page=novedades")
		), 

		"Testimonios_v2"=>array(
				"Categorías" => array('url' =>"index.php?page=categorias_testimonios_v2_s"),
				"testimonios" => array('url' =>"index.php?page=testimonios_v2_s")
		), 
		
	"Paginas_redes"=>array(
      "ver" => array('url' =>"index.php?page=paginas_redes"),   
		), 

	"Webinars"=>array(
      "Webinars" => array('url' =>"index.php?page=webinars"), 
      "Webinars 2da" => array('url' =>"index.php?page=webinars_forma_2s"), 
      "Webinars 3da [luis_baron]" => array('url' =>"index.php?page=webinars_forma_3s"), 
      "Webinars 4 [cursos]" => array('url' =>"index.php?page=webinars_forma_5s"), 
      // "Landings" => array('url' =>"index.php?page=landings"),   
      "Webinars [beca]" => array('url' =>"index.php?page=webinars_beca"), 
      "Cursos_Gratis" => array('url' =>"index.php?page=landing_gratis")     
		),

	"Landing_Big"=>array(
      "ver" => array('url' =>"index.php?page=landings_bigs")  
		), 
  
    "Landing"=>array(
      "Libro" => array('url' =>"index.php?page=landin_libro")  
		), 

  "OPORTUNIDAD_LABORAL"=>array(
      "Ver" => array('url' =>"index.php?page=contactos")
    ),

		"Libro de reclamaciones"=>array(
      "Ver" => array('url' =>"index.php?page=reclamos")
    ), 
  "Reportes"=>array(
      "Inicio" => array('url' =>'principal'),     
      "Conectados ahora" => array('url' =>"index.php?page=reporte_asistencias"), 
      "Conexiones del cliente" => array('url' =>"index.php?page=reporte_asistencia2s"), 
      //"Contingencia LOGIN cliente" => array('url' =>"index.php?page=suscriptores_logins"),  //  no se termino de hacer 
      // "Cursos del cliente" => array('url' =>"index.php?page=reportes_pedido_clientes"),
      "Clientes por curso" => array('url' =>"index.php?page=reportes_clientes_cursos"),
      "Ventas todo contabilidad" => array('url' =>"index.php?page=pedidos_todos"),
      // "Ventas vendedores" => array('url' =>"index.php?page=pedidos_vendedores"),
      "Compras detalladas" => array('url' =>"index.php?page=reportes_compras_clientes"),
      // "Ventas Online" => array('url' =>"index.php?page=reportes_ventas_onlines"),
      // "Ventas Offline" => array('url' =>"index.php?page=reportes_ventas_offlines"),
      // "Ventas Pago Efectivo" => array('url' =>"index.php?page=reportes_ventas_pago_efectivo"),
      // "Cursos vendidos" => array('url' =>"index.php?page=reportes_cursos_clientes"),
      "Libros vendidos" => array('url' =>"index.php?page=reportes_libros_clientes"),
      "CoAutorías vendidos" => array('url' =>"index.php?page=reportes_coautorias_clientes"),
      "Certificados comprados" => array('url' =>"index.php?page=reportes_certificados_comprados"),
      "Examenes vendidos" => array('url' =>"index.php?page=reportes_examenes_vendidos"),
      "Certificados más vendidos" => array('url' =>"index.php?page=reportes_certificados_mas_vendidos"),
      "Certificados por cliente" => array('url' =>"index.php?page=reportes_certificados_por_clientes"),
      "Solicitudes Certificados" => array('url' =>"index.php?page=reportes_solicitudes_certificados"),
      "Solicitudes CoAutorías" => array('url' =>"index.php?page=reportes_solicitudes_coautorias"),
      "Cliente con compras" => array('url' =>"index.php?page=reportes_si_clientes"),
      "Cliente sin compras" => array('url' =>"index.php?page=reportes_no_clientes"),
      "Clientes en general" => array('url' =>"index.php?page=reportes_todos_clientes"),
      "Leads" => array('url' =>"index.php?page=reportes_todos_leads"),
      "Buscar Vouchers" => array('url' =>"index.php?page=vouchers"),
      "Examenes por clientes" => array('url' =>"index.php?page=reportes_examenes_clientes"),
      "Examenes mayor puntaje" => array('url' =>"index.php?page=reportes_examenes_cliente2s"),
      "Vistas de vídeo" => array('url' =>"index.php?page=vistas_videos"),
    ),	
    "Reporte Vendedoras"=>array(
      "Conectados" => array('url' =>'index.php?page=vendedores_conectados'),     
      // "Comision x" => array('url' =>'index.php?page=pedidos_vendedores'),     // anterior 
      // "Comision_por_rango_ventas" => array('url' =>'index.php?page=pedidos_vendedores_nuevos'),     // existe unrango de ventas, segu  la canridad ventas recibe un monto espeficifco   EXCEL - OCULTO 03-2024
      "Nuevo_Comision_porcentaje_1.9" => array('url' =>'index.php?page=pedidos_vendedores_2024_por_porcentajes'),     
      "Por Atenciones" => array('url' =>'index.php?page=vendedores_por_atenciones'),     
      "Efectividad" => array('url' =>'index.php?page=vendedores_por_efectividads'),     
    ),
		"Configuraciones"=>array(
				// "TipoCursos" => array('url' =>"index.php?page=tipo_cursos"), /* para agregar mas tipo de cursos */
				"Especialidades" => array('url' =>"index.php?page=especialidades"),
				"Tipo_clientes" => array('url' =>"index.php?page=tipo_clientes"),
				"Escala_Magisterial" => array('url' =>"index.php?page=escala_magisteriales"),
        "Canales" => array('url' =>"index.php?page=canales"),
        "tipo_atenciones" => array('url' =>"index.php?page=tipo_atenciones"),
        "tipo_interacciones" => array('url' =>"index.php?page=tipo_interacciones"),
        "tipo_recortadorios" => array('url' =>"index.php?page=tipo_recortadorios"),
				"Bancos" => array('url' =>"index.php?page=bancos"),
				"Comisiones" => array('url' =>"index.php?page=data_comisiones"),
				"Comisiones Propias Rango" => array('url' =>"index.php?page=data_comisiones_rangos"),
				"Paises" => array('url' =>"index.php?page=paises"),
		),
		"Sistema"=>array(
				"Usuarios"=>array('url' =>"index.php?page=usuarios")
		)
	) //array merge
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
