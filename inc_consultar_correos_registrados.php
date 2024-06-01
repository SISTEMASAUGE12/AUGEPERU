<?php error_reporting(E_ALL); session_start();
include_once("tw7control/class/functions.php");
include_once("tw7control/class/class.bd.php");
include_once("tw7control/class/PHPPaging.lib.php");
$bd = new BD;
$bd->Begin();
$conteo=0;
$ides='';
?>
<div style="max-width:600px;margin:40px auto;padding:30px;text-align:center;">
	<img src="img/logo-rojo.png" style="padding-bottom:10px;">
	<h1 style="padding-bottom:40px;"> Resultados de DNI: <?php echo $_POST["dni"];?></h1>

<?php 	
if(!empty($_POST["dni"])){
	
				 $consulta_de_registros=executesql("  select * from suscritos WHERE dni='".$_POST["dni"]."' ");
				 
				if( !empty($consulta_de_registros) ){
						foreach($consulta_de_registros as $data){
					?>
					 <p style="margin-bottom:20px; padding-bottom:10px; border-bottom:1px solid #333;">
							<b>Fech.Registro: </b> <?php echo $data["fecha_registro"];?> </br> 
							<b>Registrado desde Red social :</b>
								<?php 
									if( !empty($data["registro_desde"]) ){
										if( $data["registro_desde"]==1 ){
											echo "Facebook";
										}else if( $data["registro_desde"]==2 ){
											echo "Google";
										}
										
									}else{
										echo " --";
									}
								?> 
									</br> 
							<b>Email:</b>  <?php echo $data["email"];?>  </br> 
							<b>Nombre:</b>  <?php echo $data["nombre"];?>  </br> 
							<b>Ape. Paterno:</b>  <?php echo $data["ap_pa"];?>  </br> 
							<b>Ape. Materno:</b>  <?php echo $data["ap_ma"];?>  </br> 
							<b>Teléfono:</b>  <?php echo $data["telefono"];?>  </br> 
					</p>
					
					<?php 
								$conteo++;
						} /* end for */
						
						echo "<p><b>Total de registros:</b> ".$conteo.'</p>';
					
				}else{
					  echo "<p><b>No existen registros con este DNI:</b> ".$_POST["dni"]." </p>";
				}
				
}else{
	 echo "<p><b>Ingresa un DNI válido :</b> ".$_POST["dni"]." </p>";
}				
?>		
	<a href="https://www.educaauge.com/" style="background:red;padding:10px 15px;margin-bottom:30px;display:inline-block;color:#fff;border-radius:8px;    text-decoration: none;"> Volver al inicio</a>
</div>