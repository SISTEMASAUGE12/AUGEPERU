<?php session_start();error_reporting(E_ALL);
$unix_date = strtotime(date('Y-m-d H:i:s'));
$link = $_SERVER['HTTP_HOST'];
include("class/class.bd.php");
include("class/functions.php");

/** Para cierre de sesion por actividad y tiempo de veneddoras */
$minutos_en_segundos_permitidos_para_la_sesion_del_usuario=7200;   // VALOR EN SEGUNDOS :: VALOR ACTUAL 2HORA
$minutos_actividad_js= $minutos_en_segundos_permitidos_para_la_sesion_del_usuario*1000; // x 3 ceros para segundos en javascirp


$url = "https://$link/tw7control/";
// $url = "http://$link/mori/w2023/pasosefectivos/tw7control/";


$_GET['task'] = isset($_GET['task']) ? $_GET['task'] : '';
$titulo = isset($_SESSION["visualiza"]) ? 'Administrador' : 'Iniciar Sesión';


if( !empty($_SESSION["visualiza"]["idusuario"]) ){	
?>


  <script type="text/javascript">
    function e(q) {
      document.body.appendChild( document.createTextNode(q) );
      document.body.appendChild( document.createElement("BR") );
    }
    function inactividad() {
        // e("Inactivo!!");
        console.log('inactivo');    
        location.href='index?task=salir_por_inactividad&tipo_cierre=2';

    }
    var t=null;
    function contadorInactividad() {
        t=setTimeout("inactividad()",<?php echo $minutos_actividad_js; ?>); // 60 000 -> 1 minuto 
    }

    window.onblur=window.onmousemove=function() {
        console.log('mueve mouse ');
        if(t) clearTimeout(t);
        contadorInactividad();
    }
  </script>
<?php   // END SCRIPT arriba es por inactividad AUTOMATICO

} // end si existe sesion:: validamos tiempo de inactividad  


if($_GET["task"]=="validator"){
    $consulta = "SELECT * FROM usuario WHERE codusuario='".$_POST["user"]."' and estado_idestado='1'";
    $correo_existe = executesql($consulta,1);
  
    $consulta = "SELECT * FROM usuario WHERE codusuario='".$_POST["user"]."' AND contrasena='".md5($_POST["password"])."' and estado_idestado='1'";
    $users = executesql($consulta,1);
    $rpta = 2;
    if(!empty($users)){
        $_SESSION["visualiza"]["idusuario"]=$users[0]["idusuario"];
        $_SESSION["visualiza"]["idtipo_usu"]=$users[0]["idtipo_usu"];
        $_SESSION["visualiza"]["nomusuario"]=$users[0]["nomusuario"];
        $_SESSION["visualiza"]["codusuario"]=$users[0]["codusuario"];
        $_SESSION["visualiza"]["contrasena"]=$users[0]["contrasena"];        
        $_SESSION["visualiza"]["tipo_asesora"]=$users[0]["tipo_asesora"];





        $_SESSION["visualiza"]["comision"]=$users[0]["comision"];


        $_SESSION["visualiza"]["cumple_imagen"]=$users[0]["cumple_imagen"];
        $_SESSION["visualiza"]["cumple_detalle"]=$users[0]["cumple_detalle"];
        $_SESSION["visualiza"]["fecha_cumple"]=$users[0]["fecha_cumple"];
        
        /* asistencias */
        $bd=new BD;
        // $_POST["cap_ip"] = get_public_ip();

      
        // fuente:: https://www.delftstack.com/es/howto/php/php-get-user-ip/#utilice-_serverremote_addr-para-encontrar-la-direcci%C3%B3n-ip-del-usuario-en-php						
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
           $_POST["cap_ip"] = 'A'.$_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
           $_POST["cap_ip"] = 'B'.$_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
           $_POST["cap_ip"] = $_SERVER['REMOTE_ADDR'];
        }

        $_POST['agente']=$_SERVER['HTTP_USER_AGENT'];




        $fecha_asistencia = fecha_hora(2);
        $hora_asistencia = fecha_hora(0);
        $tipo_asistencia = 1; // ingreso
        
        $_POST["controlador"] = time();

        $campos_asistencia=array('cap_ip', 'agente',array('fecha_registro',$fecha_asistencia),array('hora_registro',$hora_asistencia),array('idusuario',$_SESSION["visualiza"]["idusuario"]),array('tipo',$tipo_asistencia),array('estado_idestado','1'),'controlador'); 
        $idasistio=$bd->inserta_(arma_insert('asistencia_usuarios',$campos_asistencia,'POST'));

        $_SESSION["visualiza"]["id_asistencia"]=$idasistio;
        $_SESSION["visualiza"]["controlador"]=$_POST["controlador"];

        if( $idasistio > 0){   // marco como c0nectado 
          $campos_conectividad=array(array('conectividad',1));
          $bd->actualiza_(armaupdate('usuario',$campos_conectividad,"idusuario='".$_SESSION["visualiza"]["idusuario"]."'",'POST'));/*actualizo*/
        }
        // echo var_dump(arma_insert('asistencia_usuarios',$campos_asistencia,'POST'));
        // end asistencia 
        $bd ->close();

        $rpta = 1;

    }elseif (!empty($correo_existe)) {
        $rpta = 3;
    }
  
  echo $rpta;
  exit();


}elseif($_GET['task']=='recuperar'){
    include('inc/recuperar.php');
}elseif($_GET['task']=='registrar'){
    include('inc/registrar.php');


}elseif($_GET['task'] == 'exportar_excel'){
  if(isset($_SESSION['activate_protection'])){
    unset($_SESSION['activate_protection']);
  }
  $_SESSION['activate_protection'][0]   = true;
  if(isset($_POST['tipo_form']) && $_POST['tipo_form']>0){
    $_SESSION['activate_protection'][1] = $_POST['tipo_form'];
  }
	/* el campo enviado SQL */
	if(isset($_POST['sql']) && !empty($_POST['sql']) ){
    $_SESSION['activate_protection']['sql'] = $_POST['sql'];
  }
	
	/* el campo enviado */
	if(isset($_POST['ide_1']) && $_POST['ide_1']>0){
    $_SESSION['activate_protection'][2] = $_POST['ide_1'];
  }
	
	/* el FECHA FILTRO EXCEL INICIO  enviado */
	if(isset($_POST['fecha_filtro_inicio']) && !empty($_POST['fecha_filtro_inicio']) ){
    $_SESSION['activate_protection']['fecha_filtro_inicio'] = $_POST['fecha_filtro_inicio'];
  }
	
	/* el FECHA FILTRO EXCEL FIN  enviado */
	if(isset($_POST['fecha_filtro_fin']) && !empty($_POST['fecha_filtro_fin']) ){
    $_SESSION['activate_protection']['fecha_filtro_fin'] = $_POST['fecha_filtro_fin'];
  }

  exit();

	
}elseif($_GET['task']=='salir' || $_GET['task']=='salir_por_inactividad' ){
      /* asistencias */
      $bd=new BD;
      $fecha_cierra = fecha_hora(2);
      $hora_cierra = fecha_hora(0);

      if( isset($_GET["tipo_cierre"]) &&  !empty($_GET["tipo_cierre"]) ){
        $_POST["tipo_cierre"]=$_GET["tipo_cierre"];
      }else{
        // sino existe es tag es un cierre propio 
        $_POST["tipo_cierre"]=1;
      }
      
      /*
      echo $_SESSION['visualiza'];
      echo var_dump($_SESSION['visualiza']); 
      */


      /*
      $campos_asistencia=array( 'tipo_cierre',array('fecha_cierra',$fecha_cierra),array('hora_cierra',$hora_cierra)); 

      echo var_dump( armaupdate('asistencia_usuarios',$campos_asistencia,"id_asistencia='".$_SESSION["visualiza"]["id_asistencia"]."'",'POST') );
      exit();


      $bd->actualiza_(armaupdate('asistencia_usuarios',$campos_asistencia,"id_asistencia='".$_SESSION["visualiza"]["id_asistencia"]."'",'POST'));

      $campos_conectividad=array(array('conectividad',2));
      $bd->actualiza_(armaupdate('usuario',$campos_conectividad,"idusuario='".$_SESSION["visualiza"]["idusuario"]."'",'POST')); 
      
      */


      $bd ->close(); 


    unset($_SESSION['visualiza']);    
    header("Location: https://educaauge.com/tw7control/"); 


}




if( !empty($_SESSION["visualiza"]["idusuario"]) ){	// cierro sesion por inactividad 

  // 1. pero tbm forzamos cierre despues de 20min.  obligatorio 
  // echo time().' > '.$_SESSION["visualiza"]["controlador"];

  /** si el tiempo actual  - tiempo de sesion controlador cuando  se logeo ya paso los 20min, forzamos cierre de sesion  */
  if ( time() - $_SESSION["visualiza"]["controlador"] > $minutos_en_segundos_permitidos_para_la_sesion_del_usuario) {  // 40 segundos 
    echo " Cerrando sesión: tus 20minutos de conexión han expirado ... vuelve a ingresar! ";
    // Aquí redireccionas a la url especifica 
  ?>
      <script> location.href='index.php?task=salir_por_inactividad&tipo_cierre=3';  </script>
  <?php 
  }  // end cierre forzado desde php:: al pasar los 20min

}

?>
<!DOCTYPE html>
<html  class="no-js" lang="es-ES">
<head>
    <base href="<?php echo $url; ?>"> 
    <meta charset="utf-8">
    <title><?php echo "Administrador | ".$titulo; ?></title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="shortcut icon" href="favicon.png">
    <!-- ESTILOS -->
    <link rel="stylesheet" href="dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">	
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato">	
	
    <link rel="stylesheet" href="dist/css/AdminLTE.css">
    <link rel="stylesheet" href="dist/css/skin-blue.css">
    <link rel="stylesheet" href="dist/css/sweetalert.css">
    <link rel="stylesheet" href="dist/css/dropzone.css">
    <link href="dist/js/magnific-popup/magnific-popup.css" rel="stylesheet">
		    <link rel="stylesheet" href="dist/css/colorpicker.css">

    <link rel="stylesheet" href="dist/css/main.css?ud=<?php echo $unix_date ; ?>" >
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script> <!-- grafico -->


</head>
<body class="hold-transition login-page skin-blue sidebar-mini fondo login-empresa">
<?php
$users = array();
if(isset($_SESSION['visualiza'])){
    $consulta = "SELECT * FROM usuario WHERE codusuario='".$_SESSION["visualiza"]["codusuario"]."' AND contrasena='".$_SESSION["visualiza"]["contrasena"]."' and estado_idestado='1'";
    $users = executesql($consulta,$tipo);
    if(!empty($users)){ $_SESSION['rpta'] = 1;}
}
if(!empty($users)){
    $_SESSION["base_url"]=$_SERVER['REQUEST_URI'];
    $name = ucwords($_SESSION['visualiza']['nomusuario']);
    $tiu = ucwords($_SESSION['visualiza']['idtipo_usu']);	

    

		if( $_SESSION["visualiza"]["idtipo_usu"] ==4 ){
      if( $_SESSION["visualiza"]["idusuario"] == 74 ){
        require 'blank_9.php';  // tipo sollo ver examenss  :: valeria 
      }else{
        require 'blank_2.php';  // tipo consulta compras     
      }
			
    }elseif( $_SESSION["visualiza"]["idtipo_usu"] ==5 ){
			require 'blank_3.php';  // tipo sollo ver ventas 

			
    }elseif( $_SESSION["visualiza"]["idtipo_usu"] ==5 ){
		require 'blank_3.php';  // tipo sollo ver ventas 
			
    }elseif( $_SESSION["visualiza"]["idtipo_usu"] == 6 ){
			require 'blank_4_ugel.php';  // UGEL: solo ve certificados 
			
    }elseif( $_SESSION["visualiza"]["idtipo_usu"] == 7 ){  
			require 'blank_5_editor.php';  // tipo sollo ver ventas *+ blog 

			
    }elseif( $_SESSION["visualiza"]["idtipo_usu"] == 8 ){  
			require 'blank_6_solo_blog.php';  // tipo sollo blog  + testimonios 
			
    }elseif( $_SESSION["visualiza"]["idtipo_usu"] == 9 ){  
			require 'blank_7_solo_cursos.php';  // tipo sollo ver cursos crear editar  

    }elseif( $_SESSION["visualiza"]["idtipo_usu"] == 11 ){  
			require 'blank_8.php';  // tipo sollo ver examenss  

    }else{
			require 'blank.php';			
		}


/*  solo para preguntas restringidos 
    if( $_SESSION["visualiza"]["idtipo_usu"] == 11 ){
			require 'blank_8.php';			
      
    }else if( $_SESSION["visualiza"]["idtipo_usu"] !=1 ){
        require 'blank_banco_depurar.php';		
  
		}else{    
      if( $_SESSION["visualiza"]["idusuario"] == 77 ){
        require 'blank_banco_depurar.php';			

      }else if( $_SESSION["visualiza"]["idusuario"] == 79 ){
        require 'blank_banco_depurar.php';			

      

      }else{
        require 'blank.php';			
      }

		}
		*/


}else{
?>
    <div class="login-box">
        <div class="login-logo"><b style="color:#fff!important;">Administrador</b></div>
        <div class="login-box-body">
            <p class="login-box-msg">Iniciar Sesión</p>
            <form id="entrar" action="javascript:void(0);" method="POST" autocomplete="OFF">
                <div class="form-group has-feedback">
                    <input type="text" name="user" class="form-control" placeholder="Usuario" required>
                    <span class="glyphicon glyphicon-user form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <input type="password" name="password" class="form-control" placeholder="Contraseña" required>
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>
                <div class="row">
                    <div class="col-xs-5"><!-- <a href="#">He olvidado mi contraseña</a> --></div>
                    <div class="col-xs-7">
                        <input type="submit" value="Iniciar" class="btn btn-primary btn-block btn-flat">
                        <div class="break"></div>
                        <span class="msg"></span>
                    </div><!-- /.col -->
                </div>
            </form>
        </div>
    </div>
<?php } ?>
    <!-- jQuery 2.1.4 -->
    <script src="dist/js/jQuery-2.1.4.min.js"></script>
    <!-- SCRIPTS -->
    <script src="dist/js/jquery-ui.js"></script>
    <script src="dist/js/jquery.ui.touch-punch.min.js"></script>
    <script src="dist/js/jquery.tablesorter.js"></script>
    <script src="dist/js/sweetalert.min.js"></script>
    <script src="dist/js/app.min.js"></script>
    <script src="dist/js/bootstrap.min.js"></script>
    <script src="dist/js/functions.js?ud=<?php echo $unix_date ?>"></script>
    <script src="dist/js/dropzone.js"></script>
    <script src="dist/js/magnific-popup/jquery.magnific-popup.min.js"></script>
		<script src="dist/js/colorpicker.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
        crossorigin="anonymous"></script>
		<script src="dist/js/toky.js"></script>

    <script src="dist/js/jquery.validate.min.js"></script>
    <?php if($_GET["task"]=='new' && $title=="Productos" || $_GET["task"]=='edit' && $title=="Productos"){  ?>
    <script src="../assets/js/autosize.js"></script>
    <script>autosize(document.querySelectorAll('textarea'));</script>
    <?php } ?>
    <script type="text/javascript">
    $(document).ready(function(){
      if($('#registro').length){ $('#registro').validate(customValidate); }
    });
    </script>
		
		
		<!-- * modal recordatorio  para vendedores *-->
		<!-- * END modal recordatorio  para vendedores *-->
		<?php if( !isset($_GET['module']) ){ ?>
		<script>
				$('#modal_recordatorio').modal('show')
		</script>
		<?php } ?> 



    <?php 
/* esto es si se muestra solo al personal, individual soloa  cumpleañero
echo $el_dia_de_hoy=date("d m");
echo $dia_cumple =date("d m",strtotime($_SESSION["visualiza"]["fecha_cumple"]));
*/


$sql_cumple=" select * from usuario where estado_idestado=1 and  MONTH(`fecha_cumple`) = ".DATE('m')." AND DAY(`fecha_cumple`) = ".DATE('d')." ";
// echo $sql_cumple;
// $usuario_data=executesql($sql_cumple); 
$cumple=executesql($sql_cumple); 

// echo $sql_recordatorio; 
if( !empty($cumple) ){
//if( $el_dia_de_hoy == $dia_cumple ){
?>
  <script>
  // alert("feliz cumple ");
    $('#modal_cumple').modal('show')
</script>
<?php } ?> 



</body>
</html>