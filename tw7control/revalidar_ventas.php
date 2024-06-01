<?php error_reporting(E_ALL ^ E_NOTICE);
include ("auten.php");

if($_GET["task"]=='finder'){
  
  if(isset($_GET['criterio_usu_per']) && !empty($_GET['criterio_usu_per']) && !empty($_GET['fechabus_1']) && !empty($_GET['fechabus_2']) ){ // si existe el codigo de curso y el rango de fechas inicio y fin 
    	$codigo_del_curso=fn_filtro(substr($_GET['criterio_usu_per'], 0, 16));
	
          $bd = new BD;
          $bd->Begin();
          
          /* Recorro los clientes que compraron el curso, en ese rango de fecha de compra  */
          $sql="select sc.*, c.cursos_especialidades , c.cursos_dependientes 
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
                // $_POST["id_curso"]=892; // curso afectado por mal registro en sistema - falta de especialidades - 
                
                $especialidad=executesql(" select * from suscritos where id_suscrito='".$data["id_suscrito"]."' ",0);
                  

                
                include('revalidar_cursos_especialidades.php'); // si CURSO TIENE Esécialidades 
                include('revalidar_cursos_pack.php'); // si el cyrso es un pack corro este scrip



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