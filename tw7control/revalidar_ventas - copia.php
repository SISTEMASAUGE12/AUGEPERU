<?php error_reporting(E_ALL ^ E_NOTICE);
include ("auten.php");

if($_GET["task"]=='finder'){
  
  if(isset($_GET['criterio_usu_per']) && !empty($_GET['criterio_usu_per']) && !empty($_GET['fechabus_1']) && !empty($_GET['fechabus_2']) ){ // si existe el codigo de curso y el rango de fechas inicio y fin 
    	$codigo_del_curso=fn_filtro(substr($_GET['criterio_usu_per'], 0, 16));
	
          $bd = new BD;
          $bd->Begin();
          
          /* Recorro los clientes que compraron el curso, en ese rango de fecha de compra  */
          $sql="select sc.*, c.cursos_especialidades 
              FROM suscritos_x_cursos sc
              inner join pedidos p ON sc.id_pedido=p.id_pedido 
              INNER JOIN cursos c ON sc.id_curso=c.id_curso 
              WHERE c.codigo='".$codigo_del_curso."' and  sc.estado_idestado=1 and  sc.estado != 3  
              "; 
          
          if( isset($_GET["tipo_pago"]) && !empty($_GET["tipo_pago"]) ){
              $sql.= " and p.tipo_pago='".$_GET["tipo_pago"]."' "; // para filtrar segun tipo de venta 
          }

          $sql.= " AND DATE(sc.fecha_registro)  BETWEEN  DATE('".$_GET['fechabus_1']."')  and DATE('".$_GET['fechabus_2']."')  
              ORDER by sc.ide asc ";


          $_POST["estado"]= 1; // curso afectado por mal registro en sistema - falta de especialidades - 
          $_POST["estado_idestado"]= 1; // curso afectado por mal registro en sistema - falta de especialidades - 
          $_POST["fecha_registro"]= fecha_hora(2); // curso afectado por mal registro en sistema - falta de especialidades - 

          $contador_ejecuciones=0;

          $revalidar_ventas=executesql($sql);
          if( !empty($revalidar_ventas) ){

            foreach($revalidar_ventas as $data){
                            
              $_POST["id_suscrito"]= $data["id_suscrito"]; // curso afectado por mal registro en sistema - falta de especialidades - 
              $_POST["id_pedido"]= $data["id_pedido"]; // curso afectado por mal registro en sistema - falta de especialidades - 
              $_POST["id_curso"]=892; // curso afectado por mal registro en sistema - falta de especialidades - 
              $especialidad=executesql(" select * from suscritos where id_suscrito='".$data["id_suscrito"]."' ",0);
                
              /* CURSOS ESPECIALIDADES  .. */
              if( !empty($data['cursos_especialidades']) && !empty($especialidad["id_especialidad"]) ){
                              
                $especialidad_del_cliente=$especialidad["id_especialidad"];
                              
                if( $especialidad_del_cliente == 13){ // si es DPCC esta es igua lq sociales pero no se crearn cursos para este entonces 
                  $especialidad_del_cliente=6; // tome el valor de sociales
                }

                $sql_especialidades=" select c.* from cursos c 
                      INNER JOIN especialidades esp ON c.id_especialidad=esp.id_especialidad 
                      WHERE c.estado_idestado=1 and c.id_curso IN (".$data['cursos_especialidades'].") and esp.id_especialidad='".$especialidad_del_cliente."' 
                      ORDER by c.titulo asc ";						
                // echo $sql_especialidades;
                // exit();

                $especialidades=executesql($sql_especialidades);
                if( !empty($especialidades) ){
                  foreach( $especialidades as $anexo ){

                    /** infusion tag  */
                    // $tag_id_campana_shop=$anexo['tag'];
                    /** infusion tag  */

                    if( empty($anexo['validez_meses']) ){								
                      $validez_meses_dependientes=  12; 
                    }else{
                      $validez_meses_dependientes=$anexo['validez_meses'];
                    }

                    $_POST['dependiente'] = 2; //NO 
                    $_POST['especialidades'] = 1; // SI 
                    $_POST['nota'] = 892; // SI 

                    /* VALIDAMOS SI YA TIENE ESTE CURSO ASIGNADO EL CLIENTE */
                    $validate_curso_existente_especialidades=executesql("select * from suscritos_x_cursos where id_curso='".$anexo['id_curso']."' and id_suscrito='".$_POST['id_suscrito']."' and estado_idestado=1  and estado!=3 ");
                    if(!empty($validate_curso_existente_especialidades)){ 
                      /* si ya existe este curso en la lista del cliente ya no lo volvemos a asignar.. */
                    }else{	
                    // ASIGNAMOS CURSOS especialidades ..	
                      $_POST['orden'] = 1;
                      $campos=array('id_suscrito',array('id_curso',$anexo["id_curso"]),'id_pedido','nota','dependiente','especialidades','orden','fecha_registro',array('validez_meses',$validez_meses_dependientes),'estado','estado_idestado');
                      $bd->inserta_(arma_insert('suscritos_x_cursos',$campos,'POST'));

                      // echo var_dump(arma_insert('suscritos_x_cursos',$campos,'POST'));
                      // exit();																
                                          
                      // asigno clases por curso del _ alumnos con estado pendiente: estado:2 pendiente, 1. finalizada ..
                      // asigno clases por curso del _ alumnos con estado pendiente: estado:2 pendiente, 1. finalizada ..
                        $_POST['orden'] = _orden_noticia("","avance_de_cursos_clases","");
                        $_POST['estado_idestado']='1';
                        $_POST['estado_fin']='2';
                        // recorremos las clases del curso ..
                        $sql_n_clase="select d.id_detalle,d.id_sesion from detalle_sesiones d 
                                            INNER JOIN sesiones s  ON s.id_sesion=d.id_sesion 
                                            INNER JOIN cursos c  ON c.id_curso=s.id_curso 
                                            WHERE d.estado_idestado=1 and c.id_curso='". $anexo['id_curso']."' ";
                        $n_clase_especial=executesql($sql_n_clase);
                        if( !empty($n_clase_especial)){
                          foreach($n_clase_especial as $rowe_clases_especialidd){
                          // recorremos y agregamos 
                            $_POST['id_detalle']=$rowe_clases_especialidd['id_detalle'];
                            $_POST['id_sesion']=$rowe_clases_especialidd['id_sesion'];
                            $campos=array('id_suscrito',array('id_curso',$anexo['id_curso']),'id_sesion','id_detalle','id_pedido','orden','fecha_registro','estado_fin','estado_idestado');
                            $bd->inserta_(arma_insert('avance_de_cursos_clases',$campos,'POST'));								
                          }
                        }
                      } /** end validacion si tiene el curso especialidad  */									
                    }  // for ESPECIALIDADES
                  } // if si existe curso ESPECIALIDADES
                      
                }	// END REGISTRANDO CURSOS ESPECIALIDADES ...
                
                $contador_ejecuciones++;
              } // end for array generarl de compras : for _sql principal origen

              if( $contador_ejecuciones > 0){
                $rpta=" Algoritmo ejecutado exitosamente, se revalidaron un total de <b>".$contador_ejecuciones." </b> ventas.";
                $_style=" color:blue;font-weight:800;";

              }

            }else{
              $rpta="No se encontraron ventas de este curso en este rango de fecha.";
              $_style=" color:red;font-weight:800;";

            }
            $bd->Commit();
            $bd->close();




	}else{
    $rpta="Seleccione un rango de fecha y agregue codigo de curso a revalidar las ventas.";
    $_style=" color:red;font-weight:800;";

  }// END si existe codigo de curso y rango de fechas ? 

	


?>
  <table id="example1" class="table text-center  table-bordered table-striped">   
    <tbody>
		    <p style="<?php echo  $_style; ?>"> <?php echo $rpta; ?> </p>
    </tbody>
  </table>


<?php }else{ ?>
        <div class="box-body">
          <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
            <form action="javascript: fn_buscar();" id="frm_buscar" name="frm_buscar">
              <div class="bg-gray-light">
									
					
                <div class="col-sm-12 " style="padding: 5px 0 20px;border-bottom:2px solid #ddd;">
                  <p style="padding-bottom:20px;">Este es un modulo de contingencia para corregir ventas de cursos mal registrados, que le faltaron definir especialidades u otros casos. </br>
                    <b> Deben insertar el codigo del curso vendido</b>, seleccionar el rango de fecha de ventas donde se realizara la correción y El algotirmo hara su trabajo. </p>
                </div>

                <div class="col-sm-2 criterio_buscar">
                  <?php create_input('text','criterio_usu_per','',"form-control pull-right",$table,'placeholder="Ingresa el codigo del curso: ejem: CU00021"'); ?>
                </div>
                <div class="col-sm-2 criterio_buscar">
										<select name="tipo_pago" id="tipo_pago" class="form-control" >
												<option value="" > -todas las ventas -</option>
												<option value="4" >manuales</option>
												<option value="2" >solo online</option>
												<option value="1" >solo transferencias</option>
										</select>
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
                  <button>Ejecutar</button>
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
var link = "revalidar_venta";/*la s final se agrega en js fuctions*/
var us = " revalidar_venta";/*sirve para mensaje en ventana eliminar*/
var l = "o";
var l2 = "e";/* est+ _ x {e,a,o ,etc}sirve para mensaje en ventana eliminar*/
var pr = "El";
var ar = "al";
var mypage = "revalidar_ventas.php";
</script>
<?php } ?>