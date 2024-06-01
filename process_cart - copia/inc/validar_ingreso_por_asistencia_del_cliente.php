
<?php 
// desactivo las sesiones anteriores 
						$bd=new BD;
						$bd->Begin();
						$campo_actua=array( array("estado_idestado",2), array("fecha_cierre",fecha_hora(2)) ); // cerramos la sesion en tabla asistenmcias 

						$sql_val="select * from asistencia where id_suscrito='".$_SESSION["suscritos"]["id_suscrito"]."'";
						$val_asitencia= executesql($sql_val);
						if( !empty( $val_asitencia )){
							$bd->actualiza_(armaupdate('asistencia',$campo_actua," id_suscrito='".$_SESSION["suscritos"]["id_suscrito"]."'",'POST')); // fecha_cierre							
						}

						// registro la nueva asistencia 						
						$fecha = fecha_hora(2);
						$hora = fecha_hora(0);					
						$id_suscrito = $_SESSION['suscritos']["id_suscrito"];
						// $ip_add = get_public_ip(); // jo es fiable , lo reemplazamos por lineas abajo

						// fuente:: https://www.delftstack.com/es/howto/php/php-get-user-ip/#utilice-_serverremote_addr-para-encontrar-la-direcci%C3%B3n-ip-del-usuario-en-php
						
						if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
							$ip_add = 'A'.$_SERVER['HTTP_CLIENT_IP'];
						} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
							$ip_add = 'B'.$_SERVER['HTTP_X_FORWARDED_FOR'];
						} else {
							$ip_add = $_SERVER['REMOTE_ADDR'];
						}
						


						$_POST['agente']=$_SERVER['HTTP_USER_AGENT'];

						$_POST['comentario']='login_>web';					
						$campos_asistencia=array('comentario', array('id_suscrito',$id_suscrito),array('cap_ip',$ip_add),'agente',array('estado_idestado',1),array('fecha_registro',$fecha),array('hora_registro',$hora));
						// echo var_dump(arma_insert("asistencia",$campos_asistencia,"POST"));					
						$id_asistencia =$bd->inserta_(arma_insert("asistencia",$campos_asistencia,"POST"));
						$bd->close();
						/* END asistencia insert  */
						
						$_SESSION["suscritos"]["id_asistencia"]= $id_asistencia; // capturo el id se la sasistencia activa
						
						$_POST["logeado"]=$id_asistencia;
						$bd->actualiza_(armaupdate('suscritos',array('logeado')," id_suscrito='".$_SESSION["suscritos"]["id_suscrito"]."'",'POST')); // fecha_cierre							


						?>