<?php 

include('auten.php');

$paises=executesql("select * from paises ");

?>
<select>
<?php 
foreach($paises as $row){
	?>
	<option><?php echo $row["nombre"];?><img src="tw7control/files/images/paises/<?php echo $row["imagen"];?>"></option>
	
<?php 
}
?>
</select>