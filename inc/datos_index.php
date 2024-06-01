
<?php 
$beneficios = executesql(" select * from beneficios where estado_idestado=1 order by orden desc "); 
foreach( $beneficios as $row ){ 
  ?>
<div class="large-3 medium-6 columns"><div class="pod">
  <figure class="rel"><img class="verticalalignmiddle" src="tw7control/files/images/beneficios/<?php  echo $row["imagen"]; ?>" alt="100% virtuales"></figure>
  <span class="titu texto poppi-sb"> <?php  echo $row["titulo"]; ?> </span>
  <p class="texto poppi">  <?php  echo $row["descripcion"]; ?></p>
</div></div>
<?php 
} 
?>