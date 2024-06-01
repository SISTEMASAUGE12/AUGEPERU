
<?php 
/* 
echo $el_dia_de_hoy=date("d m");
echo $dia_cumple =date("d m",strtotime($_SESSION["visualiza"]["fecha_cumple"]));

if( $el_dia_de_hoy == $dia_cumple ){ 
  */
?>


<!-- Modal cumpleaños :: select fitlara por fecha mes y dia si conindi ce y mostra apra todos. -->
<?php 
// $usuario_data=executesql(" select * from usuario where idusuario='".$_SESSION["visualiza"]["idusuario"]."' ");  // solo le muestra al usuario 

/*  sale en el index al final
$sql_cumple=" select * from usuario where MONTH(`fecha_cumple`) = ".DATE('m')." AND DAY(`fecha_cumple`) = ".DATE('d')." ";
echo $sql_cumple;
$usuario_data=executesql($sql_cumple); 
// esta en index el final 
*/ 

 $url_solo_inicio= url_completa();
// echo $url_solo_inicio= url_completa();

$sql_cumple=" select * from usuario where estado_idestado=1 and  MONTH(`fecha_cumple`) = ".DATE('m')." AND DAY(`fecha_cumple`) = ".DATE('d')." ";
// echo $sql_cumple;
// $usuario_data=executesql($sql_cumple); 
$cumple=executesql($sql_cumple); 
if( !empty($cumple)  && $url_solo_inicio=='https://www.educaauge.com/tw7control/'  ){

?> 
<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" id="modal_cumple" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><b>FELIZ CUMPLEAÑOS: <?php echo fecha_hora(1); ?></b></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div   class=" lleva_detalle_cumple ">
            <figure class=" text-center "><img src="files/images/usuario/<?php echo $cumple[0]["cumple_imagen"];  ?>"></figure>
            <div   class=" detalle_cumple ">
                <?php  echo $cumple[0]["cumple_detalle"]; ?>
            </div>	
        </div>					
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">CERRAR</button>
				<!--
        <button type="button" class="btn btn-primary">Save changes</button>
				-->
      </div>
    </div>
  </div>
</div>
<!-- END modal recordatorio para abrie modal de cumole -->
<?php 
} // end cumple


/* 
}
 /* end si existe recordatorio */
?>