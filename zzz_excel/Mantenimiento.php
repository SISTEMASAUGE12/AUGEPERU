<?php  header('Content-Type: text/html; charset=UTF-8');
error_reporting(E_ALL);
require("../class/Carrito.class.php");
// estos estan en class carrito 
// require("../tw7control/class/functions.php");
// require("../tw7control/class/class.bd.php"); 
require("../tw7control/class/class.upload.php");

$ReadSql = "SELECT count(*) as total FROM `excel_leads`";
// $res = mysqli_query($con, $ReadSql);
$res = executesql($ReadSql);

include("header.php");
?>
<div style="width: 100%; height: 10px; clear: both;"></div>
	<h2>Total registros:: <?php echo $res[0]['total']; ?></h2>

<?php /*	
		<table class="table"> 
		<thead> 
			<tr> 
				<th>#</th> 
				<th>Nombres</th> 
				<th>Apellidos</th> 
				<th>E-Mail</th> 
				<th>Genero</th> 
				<th>Edad</th> 
				<th>Carrera</th> 
			</tr> 
		</thead> 
		<tbody> 
		<?php 
		$i=0;
		foreach($res as $r){ 
				$i++;
		?>
			<tr> 
				<th scope="row"><?php echo $i; ?></th> 
				<td><?php echo $r['nombres']; ?></td> 
				<td><?php echo $r['apellidos']; ?></td> 
				<td><?php echo $r['genero']; ?></td> 
				<td><?php echo $r['edad']; ?></td> 
				<td><?php echo $r['carrera']; ?></td> 
                <td><?php echo $r['email']; ?></td> 

	
			</tr> 
		<?php } ?>
		</tbody> 
		</table>
	*/ ?>
	</div>
</div>

  


<?php include ("footer.php"); ?>