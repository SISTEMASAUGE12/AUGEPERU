<?php error_reporting(E_ALL ^ E_NOTICE);
include("auten.php");

if ($_GET["task"] == 'neworden') {
  $bd = new BD;
  $orden_actual = $_GET["orden"];
  $orden_nuevo = $_GET["nuevoorden"];
  $tipo = $_GET["tipo"];
  $id_del_registro_actual = $_GET["id_webinar"];
  $criterio_Orden = " ";
  nuevoorden($orden_actual, $orden_nuevo, $tipo, $id_del_registro_actual, "webinars", "id_webinar", $criterio_Orden);
  $bd->close();
} elseif ($_GET["task"] == 'insert' || $_GET["task"] == 'update') {
  $bd = new BD;
  $where = ($_GET["task"] == 'update') ? "and id_webinar!='" . $_POST["id_webinar"] . "'" : '';
  $urlrewrite = armarurlrewrite($_POST["titulo"]);
  $urlrewrite = armarurlrewrite($urlrewrite, 1, "webinars", "id_webinar", "titulo_rewrite", $where);

  $_POST['tipo'] = 2; /* registro desde facebook o gmail */

  $campos = array('id_curso', 'tipo', 'titulo_seo', 'titulo', array('titulo_rewrite', $urlrewrite), 'titulo_1', 'detalle_1', 'link_video', 'link_chat', 'link_externo', 'titulo_2', 'link_vimeo_formulario', 'detalle_2', 'estado_idestado', 'pdf_1_titulo', 'pdf_2_titulo', 'titulo_boton_link', 'link_boton_2', 'color_fondo_boton_link', 'color_boton_link', 'etiqueta_registro_1', 'etiqueta_registro_2', 'fecha_en_texto', 'hora_en_texto', 'encargado_webi', 'acabo_webinar_en_vivo', 'etiqueta_infusion', 'ante_titulo', 'texto_link_externo');



  $campos = array_merge($campos, array('titulo_boton_action', 'link_boton_action'));

  $campos = array_merge($campos, array('fecha_inicio', 'hora_inicio', 'titulo_gracias', 'link_gracias', 'titulo_carta', 'link_carta', 'titulo_carta_2', 'activar_carta_2', 'link_carta_larga'));


  if ($_GET["task"] == 'insert') {
    if (isset($_FILES['pdf_1']) && !empty($_FILES['pdf_1']['name'])) {
      $_POST['pdf_1'] = carga_imagen('files/images/webinars/', 'pdf_1', '', '', '');
      $campos = array_merge($campos, array('pdf_1'));
    }

    if (isset($_FILES['pdf_2']) && !empty($_FILES['pdf_2']['name'])) {
      $_POST['pdf_2'] = carga_imagen('files/images/webinars/', 'pdf_2', '', '', '');
      $campos = array_merge($campos, array('pdf_2'));
    }

    if (isset($_FILES['imagen_ponente']) && !empty($_FILES['imagen_ponente']['name'])) {
      $_POST['imagen_ponente'] = carga_imagen('files/images/webinars/', 'imagen_ponente', '', '400', '400');
      $campos = array_merge($campos, array('imagen_ponente'));
    }

    if (isset($_FILES['imagen']) && !empty($_FILES['imagen']['name'])) {
      $_POST['imagen'] = carga_imagen('files/images/webinars/', 'imagen', '', '400', '400');
      $campos = array_merge($campos, array('imagen'));
    }
    if (isset($_FILES['banner']) && !empty($_FILES['banner']['name'])) {
      $_POST['banner'] = carga_imagen('files/images/webinars/', 'banner', '', '1600', '650');
      $campos = array_merge($campos, array('banner'));
    }
    if (isset($_FILES['banner_2']) && !empty($_FILES['banner_2']['name'])) {
      $_POST['banner_2'] = carga_imagen('files/images/webinars/', 'banner_2', '', '1600', '650');
      $campos = array_merge($campos, array('banner_2'));
    }
    if (isset($_FILES['imagen_1']) && !empty($_FILES['imagen_1']['name'])) {
      $_POST['imagen_1'] = carga_imagen('files/images/webinars/', 'imagen_1', '', '370', '340');
      $campos = array_merge($campos, array('imagen_1'));
    }
    if (isset($_FILES['imagen_2']) && !empty($_FILES['imagen_2']['name'])) {
      $_POST['imagen_2'] = carga_imagen('files/images/webinars/', 'imagen_2', '', '700', '500');
      $campos = array_merge($campos, array('imagen_2'));
    }
    if (isset($_FILES['imagen_3']) && !empty($_FILES['imagen_3']['name'])) {
      $_POST['imagen_3'] = carga_imagen('files/images/webinars/', 'imagen_3', '', '520', '440');
      $campos = array_merge($campos, array('imagen_3'));
    }
    if (isset($_FILES['imagen_gracias']) && !empty($_FILES['imagen_gracias']['name'])) {
      $_POST['imagen_gracias'] = carga_imagen('files/images/webinars/', 'imagen_gracias', '', '700', '500');
      $campos = array_merge($campos, array('imagen_gracias'));
    }
    if (isset($_FILES['imagen_carta']) && !empty($_FILES['imagen_carta']['name'])) {
      $_POST['imagen_carta'] = carga_imagen('files/images/webinars/', 'imagen_carta', '', '700', '500');
      $campos = array_merge($campos, array('imagen_carta'));
    }
    if (isset($_FILES['imagen_carta_2']) && !empty($_FILES['imagen_carta_2']['name'])) {
      $_POST['imagen_carta_2'] = carga_imagen('files/images/webinars/', 'imagen_carta_2', '', '700', '500');
      $campos = array_merge($campos, array('imagen_carta_2'));
    }
    $_POST['orden'] = _orden_noticia("", "webinars", "");
    $_POST['fecha_registro'] = fecha_hora(2);

    // echo var_dump(arma_insert('webinars',array_merge($campos,array('codigo','fecha_registro','orden')),'POST'));
    // exit();

    $_POST["id_webinar"] = $bd->inserta_(arma_insert('webinars', array_merge($campos, array('fecha_registro', 'orden')), 'POST'));
  } else {

    if (isset($_FILES['pdf_1']) && !empty($_FILES['pdf_1']['name'])) {
      $path = 'files/images/webinars/' . $_POST['imagen_ant_pdf_1'];
      if (file_exists($path) && !empty($_POST['imagen_ant_pdf_1'])) unlink($path);
      $_POST['pdf_1'] = carga_imagen('files/images/webinars/', 'pdf_1', '', '', '');
      $campos = array_merge($campos, array('pdf_1'));
    }

    if (isset($_FILES['pdf_2']) && !empty($_FILES['pdf_2']['name'])) {
      $path = 'files/images/webinars/' . $_POST['imagen_ant_pdf_2'];
      if (file_exists($path) && !empty($_POST['imagen_ant_pdf_2'])) unlink($path);
      $_POST['pdf_2'] = carga_imagen('files/images/webinars/', 'pdf_2', '', '', '');
      $campos = array_merge($campos, array('pdf_2'));
    }

    if (isset($_FILES['imagen_ponente']) && !empty($_FILES['imagen_ponente']['name'])) {
      $path = 'files/images/webinars/' . $_POST['ant_imagen_ponente'];
      if (file_exists($path) && !empty($_POST['ant_imagen_ponente'])) unlink($path);
      $_POST['imagen_ponente'] = carga_imagen('files/images/webinars/', 'imagen_ponente', '', '400', '400');
      $campos = array_merge($campos, array('imagen_ponente'));
    }

    if (isset($_FILES['imagen']) && !empty($_FILES['imagen']['name'])) {
      $path = 'files/images/webinars/' . $_POST['imagen_ant'];
      if (file_exists($path) && !empty($_POST['imagen_ant'])) unlink($path);
      $_POST['imagen'] = carga_imagen('files/images/webinars/', 'imagen', '', '400', '400');
      $campos = array_merge($campos, array('imagen'));
    }
    if (isset($_FILES['banner']) && !empty($_FILES['banner']['name'])) {
      $path = 'files/images/webinars/' . $_POST['imagen_ant_banner'];
      if (file_exists($path) && !empty($_POST['imagen_ant_banner'])) unlink($path);
      $_POST['banner'] = carga_imagen('files/images/webinars/', 'banner', '', '1600', '650');
      $campos = array_merge($campos, array('banner'));
    }
    if (isset($_FILES['banner_2']) && !empty($_FILES['banner_2']['name'])) {
      $path = 'files/images/webinars/' . $_POST['imagen_ant_banner_2'];
      if (file_exists($path) && !empty($_POST['imagen_ant_banner_2'])) unlink($path);
      $_POST['banner_2'] = carga_imagen('files/images/webinars/', 'banner_2', '', '1600', '650');
      $campos = array_merge($campos, array('banner_2'));
    }
    if (isset($_FILES['imagen_1']) && !empty($_FILES['imagen_1']['name'])) {
      $path = 'files/images/webinars/' . $_POST['imagen_ant_1'];
      if (file_exists($path) && !empty($_POST['imagen_ant_1'])) unlink($path);
      $_POST['imagen_1'] = carga_imagen('files/images/webinars/', 'imagen_1', '', '370', '340');
      $campos = array_merge($campos, array('imagen_1'));
    }
    if (isset($_FILES['imagen_2']) && !empty($_FILES['imagen_2']['name'])) {
      $path = 'files/images/webinars/' . $_POST['imagen_ant_2'];
      if (file_exists($path) && !empty($_POST['imagen_ant_2'])) unlink($path);
      $_POST['imagen_2'] = carga_imagen('files/images/webinars/', 'imagen_2', '', '700', '500');
      $campos = array_merge($campos, array('imagen_2'));
    }

    if (isset($_FILES['imagen_3']) && !empty($_FILES['imagen_3']['name'])) {
      $path = 'files/images/webinars/' . $_POST['imagen_ant_3'];
      if (file_exists($path) && !empty($_POST['imagen_ant_3'])) unlink($path);
      $_POST['imagen_3'] = carga_imagen('files/images/webinars/', 'imagen_3', '', '520', '440');
      $campos = array_merge($campos, array('imagen_3'));
    }
    if (isset($_FILES['imagen_gracias']) && !empty($_FILES['imagen_gracias']['name'])) {
      $path = 'files/images/webinars/' . $_POST['imagen_ant_gracias'];
      if (file_exists($path) && !empty($_POST['imagen_ant_gracias'])) unlink($path);
      $_POST['imagen_gracias'] = carga_imagen('files/images/webinars/', 'imagen_gracias', '', '700', '500');
      $campos = array_merge($campos, array('imagen_gracias'));
    }
    if (isset($_FILES['imagen_carta']) && !empty($_FILES['imagen_carta']['name'])) {
      $path = 'files/images/webinars/' . $_POST['imagen_ant_carta'];
      if (file_exists($path) && !empty($_POST['imagen_ant_carta'])) unlink($path);
      $_POST['imagen_carta'] = carga_imagen('files/images/webinars/', 'imagen_carta', '', '700', '500');
      $campos = array_merge($campos, array('imagen_carta'));
    }
    if (isset($_FILES['imagen_carta_2']) && !empty($_FILES['imagen_carta_2']['name'])) {
      $path = 'files/images/webinars/' . $_POST['imagen_ant_carta_2'];
      if (file_exists($path) && !empty($_POST['imagen_ant_carta_2'])) unlink($path);
      $_POST['imagen_carta_2'] = carga_imagen('files/images/webinars/', 'imagen_carta_2', '', '700', '500');
      $campos = array_merge($campos, array('imagen_carta_2'));
    }

    // echo var_dump(armaupdate('webinars',$campos," id_webinar='".$_POST["id_webinar"]."'",'POST'));
    // exit();

    $bd->actualiza_(armaupdate('webinars', $campos, " id_webinar='" . $_POST["id_webinar"] . "'", 'POST'));/*actualizo*/
  }

  $bd->close();
  gotoUrl("index.php?page=" . $_POST["nompage"] . "&module=" . $_POST["nommodule"] . "&parenttab=" . $_POST["nomparenttab"]);
} elseif ($_GET["task"] == 'new' || $_GET["task"] == 'edit') {
  if ($_GET["task"] == 'edit') {
    $data_producto = executesql("select * from webinars where id_webinar='" . $_GET["id_webinar"] . "'", 0);
  }
?>
  <script src="ckeditor/sample.js"></script>
  <script src="ckeditor/ckeditor.js"></script>
  <script src="ckfinder/ckfinder.js"></script>

  <section class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="box box-info">
          <div class="box-header with-border">
            <h3 class="box-title">webinars </h3>
          </div>
          <?php $task_ = $_GET["task"]; ?>
          <form id="registro" action="webinars_forma_2s.php?task=<?php echo ($task_ == 'edit') ?  "update" : "insert"; ?>" class="form-horizontal" method="POST" enctype="multipart/form-data" onsubmit="return aceptar()">
            <?php
            if ($task_ == 'edit') create_input("hidden", "id_webinar", $data_producto["id_webinar"], "", $table, "");
            create_input("hidden", "urlfailed", basename($_SERVER['REQUEST_URI']), "", $table, "");
            create_input("hidden", "urlgo", $link2, "", $table, "");
            create_input("hidden", "nompage", $_GET["page"], "", $table, "");
            create_input("hidden", "nommodule", $_GET["module"], "", $table, "");
            create_input("hidden", "nomparenttab", $_GET["parenttab"], "", $table, "");
            ?>
            <div class="box-body   <?php echo !empty($_GET["id_webinar"]) ? 'detalle_editar' : ''; ?>  ">


              <h3 style="font-weight:800;"><small style="color:green;">PASO 1: Lo mas importante, Aquí DATOS DEL WEBINAR EN VIVO: </small></h3>


              <?php include('inc/data_webinar.php'); ?>



            </div>
            <div class="box-footer">
              <div class="form-group">
                <div class="col-sm-10 pull-right">
                  <input type="submit" class="btn bg-blue btn-flat" id="btnguardar" value="Guardar">
                  <button type="button" class="btn bg-red btn-flat" onclick="javascript:gotourl('<?php echo $link2; ?>');">Cancelar</button>
                </div>
              </div>
            </div>

            <script>
              function aceptar() {
                var nam1 = document.getElementById("titulo").value;

                if (nam1 != '') {
                  alert("Registrando ... Click en Aceptar & espere unos segundos. ");
                  document.getElementById("btnguardar").disabled = true;
                } else {
                  alert("Recomendación: Ingrese título)");
                  return false; //el formulario no se envia		
                }

              }
            </script>
          </form>
        </div><!-- /.box -->
      </div><!--/.col (right) -->
    </div>
  </section><!-- /.content -->
  <script type="text/javascript">
    var customValidate = {
      rules: {
        archivo: {
          required: false,
          accept: 'pdf,docs,doc,jpg,png'
        }
      }
    };
  </script>
<?php
} elseif ($_GET["task"] == 'drop' || $_GET["task"] == 'dropselect') {
  $bd = new BD;
  $bd->Begin();
  $id_webinar = !isset($_GET['id_webinar']) ? implode(',', $_GET['chkDel']) : $_GET['id_webinar'];
  $webinars = executesql("SELECT * FROM webinars WHERE id_webinar IN(" . $id_webinar . ")");
  if (!empty($webinars)) {
    foreach ($webinars as $row) {
      $pfile = 'files/images/webinars/' . $row['imagen'];
      if (file_exists($pfile) && !empty($row['imagen'])) {
        unlink($pfile);
      }
      $pfile = 'files/images/webinars/' . $row['banner'];
      if (file_exists($pfile) && !empty($row['banner'])) {
        unlink($pfile);
      }
      $pfile = 'files/images/webinars/' . $row['banner_2'];
      if (file_exists($pfile) && !empty($row['banner_2'])) {
        unlink($pfile);
      }
      $pfile = 'files/images/webinars/' . $row['imagen_1'];
      if (file_exists($pfile) && !empty($row['imagen_1'])) {
        unlink($pfile);
      }
      $pfile = 'files/images/webinars/' . $row['imagen_2'];
      if (file_exists($pfile) && !empty($row['imagen_2'])) {
        unlink($pfile);
      }
      $pfile = 'files/images/webinars/' . $row['imagen_3'];
      if (file_exists($pfile) && !empty($row['imagen_3'])) {
        unlink($pfile);
      }
      $pfile = 'files/images/webinars/' . $row['imagen_gracias'];
      if (file_exists($pfile) && !empty($row['imagen_gracias'])) {
        unlink($pfile);
      }
      $pfile = 'files/images/webinars/' . $row['imagen_carta'];
      if (file_exists($pfile) && !empty($row['imagen_carta'])) {
        unlink($pfile);
      }
      $pfile = 'files/images/webinars/' . $row['imagen_carta_2'];
      if (file_exists($pfile) && !empty($row['imagen_carta_2'])) {
        unlink($pfile);
      }
    }
  }

  $bd->actualiza_("DELETE FROM webinars WHERE id_webinar IN(" . $id_webinar . ")");
  $bd->Commit();
  $bd->close();
} elseif ($_GET["task"] == 'ordenar') {

  $bd = new BD;
  $_GET['order'] = array_reverse($_GET['order']);
  foreach ($_GET['order'] as $order => $item) {
    $orden = $orden + 1;
    $bd->actualiza_("UPDATE webinars SET orden= " . $orden . " WHERE id_webinar = " . $item . "");
  }
  $bd->Commit();
  $bd->close();
} elseif ($_GET["task"] == 'uestado') {

  $bd = new BD;
  $bd->Begin();

  $id_webinar = !isset($_GET['id_webinar']) ? $_GET['estado_idestado'] : $_GET['id_webinar'];
  $id_webinar = is_array($id_webinar) ? implode(',', $id_webinar) : $id_webinar;
  $webinars = executesql("SELECT * FROM webinars WHERE id_webinar IN (" . $id_webinar . ")");

  if (!empty($webinars))
    foreach ($webinars as $reg => $item)
      if ($item['estado_idestado'] == 1) {
        $state = 2;
      } elseif ($item['estado_idestado'] == 2) {
        $state = 1;
      }
  $bd->actualiza_("UPDATE webinars SET estado_idestado=" . $state . " WHERE id_webinar=" . $id_webinar . "");
  echo $state;
  $bd->Commit();
  $bd->close();
} elseif ($_GET["task"] == 'finder') {

  $array = array();
  $meses = array('Jan' => 'Enero', 'Feb' => 'Febrero', 'Mar' => 'Marzo', 'Apr' => 'Abril', 'May' => 'Mayo', 'Jun' => 'Junio', 'Jul' => 'Julio', 'Aug' => 'Agosto', 'Sep' => 'Septiembre', 'Oct' => 'Octubre', 'Nov' => 'Noviembre', 'Dec' => 'Diciembre');

  $sql = "SELECT  c.*, YEAR(c.fecha_registro) as anho, MONTH(c.fecha_registro) as mes, e.nombre as estado , cur.codigo as codigo_curso, cur.titulo as curso 
		FROM webinars c 
	 INNER JOIN cursos cur ON c.id_curso=cur.id_curso 
	 INNER JOIN estado e ON c.estado_idestado=e.idestado    
	 WHERE c.tipo=2 
	 ";

  if (isset($_GET['criterio_usu_per']) && !empty($_GET['criterio_usu_per'])) {
    $stringlike = fn_filtro(substr($_GET['criterio_usu_per'], 0, 16));
    $sql .= " and  ( c.titulo LIKE '%" . $stringlike . "%' and c.titulo_seo LIKE '%" . $stringlike . "%' and c.titulo_rewrite LIKE '%" . $stringlike . "%'  )  ";
  } else {
    if (empty($_GET['fechabus_1']) && empty($_GET['fechabus_2'])) {
      $sql .= " AND MONTH(c.fecha_registro) = MONTH('" . fecha_hora(1) . "') ";
    }
  }

  if (!empty($_GET['fechabus_1']) && !empty($_GET['fechabus_2'])) {
    $sql .= " AND DATE(c.fecha_registro)  BETWEEN  DATE('" . $_GET['fechabus_1'] . "')  and DATE('" . $_GET['fechabus_2'] . "')  ";
  }


  if (isset($_GET['criterio_ordenar_por'])) $sql .= sprintf(" order by %s %s", fn_filtro($_GET['criterio_ordenar_por']), fn_filtro($_GET['criterio_orden']));
  $sql .= "  ORDER BY c.orden DESC   ";

  // echo $sql; 

  $paging = new PHPPaging;
  $paging->agregarConsulta($sql);
  $paging->div('div_listar');
  $paging->modo('desarrollo');
  $numregistro = 1;
  if ($numregistro) $paging->porPagina(fn_filtro((int)$numregistro));
  $paging->verPost(true);
  $mantenerVar = array("criterio_mostrar", "task", "criterio_usu_per", "criterio_ordenar_por", "criterio_orden");

  $paging->mantenerVar($mantenerVar);
  $paging->porPagina(1000); // 1000 cargas por pagina 
  $paging->ejecutar();
  $paging->pagina_proceso = "webinars_forma_2s.php";
?>
  <table id="example1" class="table table-bordered table-striped">
    <tbody id="sort">
      <?php

      while ($detalles = $paging->fetchResultado()) :
        if (!in_array(array('mes' => $detalles['mes'], 'anho' => $detalles['anho']), $array)) {
          $array[] = array('mes' => $detalles['mes'], 'anho' => $detalles['anho']);
      ?>
          <tr class="lleva-mes">
            <td colspan="9">
              <h6><?php echo strtoupper(strtr(date('M Y', strtotime($detalles['fecha_registro'])), $meses)); ?></h6>
            </td>
          </tr>
          <tr role="row">
            <th class="sort cnone ">CODIGO </th>
            <th class="sort cnone ">DÍA </th>
            <th class="sort">WEBINAR </th>
            <th class="sort cnone ">INICIA </th>
            <th class="sort">URL </th>
            <th class="sort cnone " width="60">Vimeo </th>
            <th class="sort cnone " width="60">L.externo </th>
            <th class="sort cnone">CURSO </th>
            <th class="sort cnone" width="60">ESTADO</th>
            <th class="unafbe " style="width:370px;">Opciones</th>
          </tr>
        <?php } //if meses 
        ?>

        <tr>
          <td><?php echo $detalles["id_webinar"]; ?></td>
          <td class="sort cnone"><?php echo !empty($detalles['fecha_registro']) ? date('d', strtotime($detalles['fecha_registro'])) : '...'; ?></td>

          <td><?php echo $detalles["titulo"]; ?></td>
          <td class="sort cnone"><?php echo $detalles["fecha_inicio"]; ?></td>
          <td><a href='https://www.educaauge.com/webinar2/<?php echo $detalles["titulo_rewrite"]; ?>' target="_blank">ver enlace</a></td>
          <td class="sort cnone"> <a href="<?php echo $detalles["link_video"]; ?>" target="_blank"> enlace</a> </td>
          <td class="sort cnone"> <a href="<?php echo $detalles["link_externo"]; ?>" target="_blank"> enlace</a> </td>
          <td class="sort cnone"><?php echo $detalles["codigo_curso"] . '- <small>' . $detalles["curso"]; ?></small></td>
          <td class="cnone"><a href="javascript: fn_estado('<?php echo $detalles["id_webinar"]; ?>')"><?php echo $detalles["estado"]; ?></a></td>
          <td>
            <div class="btn-eai  text-center btns btr    " style="width:370px;">
              <a href="<?php echo $_SESSION["base_url"] . '&task=edit&id_webinar=' . $detalles["id_webinar"]; ?>" style="color:#fff;"><span>editar</span>
              </a>

              <?php if ($detalles["id_webinar"] != 31) { ?>
                <a href="index.php?page=pestanhas_webinars_inicios&id_webinar=<?php echo $detalles['id_webinar']; ?>&module=<?php echo $_GET['module']; ?>&parenttab=<?php echo $_GET['parenttab']; ?>" style="color:#fff;margin-left:6px;" title="Carta larga">
                  <!-- <i class="fa fa-eye"></i> --><span>+ info</span>
                </a>
                <a href="index.php?page=pestanhas_webinars_cortas&id_webinar=<?php echo $detalles['id_webinar']; ?>&module=<?php echo $_GET['module']; ?>&parenttab=<?php echo $_GET['parenttab']; ?>" style="color:#fff;margin-left:6px;" title="Carta larga">
                  <!-- <i class="fa fa-eye"></i> --><span>carta corta</span>
                </a>

                <a href="index.php?page=pestanhas_webinars&id_webinar=<?php echo $detalles['id_webinar']; ?>&module=<?php echo $_GET['module']; ?>&parenttab=<?php echo $_GET['parenttab']; ?>" style="color:#fff;margin-left:6px;" title="Carta larga">
                  <!-- <i class="fa fa-eye"></i> --><span>carta larga</span>
                </a>
              <?php } ?>

              <a href="index.php?page=webinars_x_leads&id_webinar=<?php echo $detalles['id_webinar']; ?>&module=<?php echo $_GET['module']; ?>&parenttab=<?php echo $_GET['parenttab']; ?>" style="color:#fff;margin-left:6px;" title="Ver leads">
                <i class="fa fa-eye"></i> <span> leads</span>
              </a>

              <?php if ($detalles["id_webinar"] != 31) {  /// id: webinar nombramiento 2024 - echa a medida  
              ?>

                <a href="javascript: fn_eliminar('<?php echo $detalles["id_webinar"]; ?>')" style="margin-left:6px;"><i class="fa fa-trash-o"></i></a>
              <?php } ?>

            </div>
          </td>
        </tr>
      <?php endwhile;  ?>
    </tbody>
  </table>
  <div class="pagination"><?php echo $paging->fetchNavegacion(); ?></div>
  <script>
    $(function() {
      // checked();
      // sorter();
      // reordenar('webinars_forma_2s.php');
    });
    var mypage = "webinars_forma_2s.php";
  </script>

<?php } else { ?>
  <div class="box-body">
    <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
      <form action="javascript: fn_buscar();" id="frm_buscar" name="frm_buscar">
        <input type="hidden" name="module" value="<?php echo $_GET["module"]; ?>">
        <input type="hidden" name="parenttab" value="<?php echo $_GET["parenttab"]; ?>">
        <div class="bg-gray-light">
          <div class="col-md-2">
            <div class="btn-eai">
              <a href="<?php echo $link2 . "&task=new"; ?>" style="color:#fff;"><i class="fa fa-file"></i> Agregar </a>
            </div>
          </div>
          <div class="col-sm-3 criterio_buscar">
            <?php create_input('text', 'criterio_usu_per', '', "form-control pull-right", $table, 'placeholder="Buscar .."'); ?>
          </div>
          <div class="col-sm-7 criterio_mostrar">
            <div class="lleva_flechas" style="position:relative;">
              <label>Desde:</label>
              <?php create_input('date', 'fechabus_1', '', "form-control pull-right", $table, ''); ?>
            </div>
            <div class="lleva_flechas" style="position:relative;">
              <label>Hasta:</label>
              <?php create_input('date', 'fechabus_2', '', "form-control pull-right", $table, ''); ?>
            </div>
            <button>Buscar</button>
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

  <script>
    var link = "webinars_forma_2";
    var us = "webinars";
    var ar = "la";
    var l = "a";
    var l2 = "a";
    var pr = "La";
    var id = "id_webinar";
    var mypage = "webinars_forma_2s.php";
  </script>

<?php } ?>