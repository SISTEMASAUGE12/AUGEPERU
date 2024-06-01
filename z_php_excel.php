<?php

require_once('connect.php');
$ReadSql = "SELECT * FROM `excel`";
$res = mysqli_query($connection, $ReadSql);
include("header.php");
?>
<div style="width: 100%; height: 10px; clear: both;"></div>
    <h2>Mantenimiento de registros insertados con PHP Excel</h2>
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
        while($r = mysqli_fetch_assoc($res)){$i++;
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
    </div>
</div>

<?php include ("footer.php"); ?>