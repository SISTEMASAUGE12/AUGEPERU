						<!--  ** flotante -->
<!-- CK EDITOR -->
<script src="ckeditor/sample.js"></script>
<script src="ckeditor/ckeditor.js"></script>
<script src="ckfinder/ckfinder.js"></script>
<!-- 
<script src="js/buscar_reniec_sin_reniec.js"></script>
-->
										
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">

      <div class="modal-header" style="background:#0d4db4;color:#fff;">
        <h5  id="exampleModalLabel"><b style="padding-right:10px;">ATENDER CLIENTE:</b> <?php echo !empty($dato_apertura)?$dato_apertura:'<span class="modal-title" style="padding-left:20px;"></span>';?>  </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top:-30px;color:red;opacity:.5;">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

		 <form  class="form-horizontal" method="POST" enctype="multipart/form-data" autocomplete="OFF" onsubmit="return aceptar()">
			<?php create_input("hidden","nompage",$_GET["page"],"",$table,""); 
						create_input("hidden","nommodule",$_GET["module"],"",$table,"");
						create_input("hidden","nomparenttab",$_GET["parenttab"],"",$table,""); 
						create_input("hidden","id_cliente",'',"",$table,""); 
			?>
      <div class="modal-body">
				<div class="box-body">


	<fieldset id="field_client">
				<div class="form-group">
					<div class="col-sm-12 "  style="padding-bottom:10px;">
						<label for="inputassword3" class="col- control-label">Titulo:</label>
						<?php create_input("text","motivo",'',"form-control",$table,"  ",$agregado); ?>
					</div>
					<div class="col-sm-12 "  style="padding-bottom:10px;">
						<label for="inputPassword3" class="col- control-label">Tipo de atención:</label>
						<?php crearselect("id_tipo_atencion","select * from tipo_atenciones where estado_idestado=1 order by titulo asc",'class="form-control"',$data_producto["id_tipo_atencion"]," -- seleccione atencion --"); ?>
					</div>
					<div class="col-sm-12 "  style="padding-bottom:10px;">
						<label for="inputPassword3" class="col- control-label">Tipo de interacción:</label>
						<?php crearselect("id_tipo_intera","select * from tipo_interacciones where estado_idestado=1 order by titulo asc ",'class="form-control"',$data_producto["id_tipo_intera"]," -- seleccione interacción -- "); ?>
					</div>
					<div class="col-sm-12 "  style="padding-bottom:10px;">  
						<label for="inputPassword3" class="col- control-label">Comentario:</label>
						<?php create_input("textarea","descripcion",'',"form-control",$table," ",$agregado); ?>
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-12 "  style="padding-bottom:10px;">
						<label for="inputPassword3" class="col- control-label">Nivel de interes:</label>
						<?php crearselect("id_nivel","select * from kardex_niveles_de_interes where estado_idestado=1 order by titulo asc ",'class="form-control"',$data_producto["id_nivel"]," -- seleccione nivel interes -- "); ?>
					</div>
					<div class="col-sm-6 "  style="padding-bottom:10px;">
						<label for="inputassword3" class="col- control-label">Codigo de Curso interesado:</label>
						<?php create_input("text","curso",'',"form-control",$table,"  ",$agregado); ?>
					</div>
					<div class="col-sm-6 "  style="padding-bottom:10px;">
						<label for="inputPassword3" class="col- control-label">Precio curso<small>(ofrecido) </small>:</label>
						<?php create_input("text","precio",'',"form-control",$table," onkeypress='javascript:return soloNumeros_precio(event,2);' ",$agregado); ?>
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-12 "  style="padding-bottom:10px;">
						<label for="inputPassword3" class="col- control-label">Tipo de recordatorio:</label>
						<?php crearselect("id_tipo_recordatorio","select * from tipo_recortadorios where estado_idestado=1 order by id_tipo_recordatorio asc ",'class="form-control"',$data_producto["id_tipo_recordatorio"],""); ?>
					</div>
					
					<div class="col-sm-12">
						<label for="inputPassword3" class="col-md- control-label">Fecha recordatorio : </label>
						<?php create_input("date","fecha_recordatorio",$data_producto["fecha_recordatorio"],"form-control",$table,"",$agregado); ?>
					</div>
				
					<div class="col-sm-12 ">
						<label for="inputPassword3" class="col-md- control-label">Hora recordatorio: </label>
						<input type="time" name="hora_recordatorio" id="hora_recordatorio" value="<?php echo $data_producto["hora_inicio"]; ?>">
					</div>
				</div>
				
				</div>	<!-- tabs  global general -->
						

			</fieldset>

			</div>
          <!-- ... -->
      </div>
		<script>	
function aceptar(){
	var nam1=document.getElementById("motivo").value;	
	var nam2=document.getElementById("id_tipo_atencion").value;	 
	var nam3=document.getElementById("id_tipo_intera").value;	
	var nam4=document.getElementById("id_cliente").value;	
	var nam5=document.getElementById("id_tipo_recordatorio").value;	
	
	if(nam1 !='' && nam2 !='' && nam3 !='' && nam5 !='' && nam4 >0 ){									
		alert("Asignando  .. Aceptar y espere unos segundos ..");							
		document.getElementById("btnguardar").disabled=true;			
	}else{		
		alert("Recomendación: Ingresa un: cliente, titulo, atencion e interacción .. )");
		return false; //el formulario no se envia		
	}
	
}				
</script>	

      <div class="modal-footer" style="background:#fff;">
        <button type="button" class="btn btn-secondary"  style="background:#777;" data-dismiss="modal">cancelar</button>
				<a class="btn bg-blue btn-flat guardar_atencion_cliente_vendedor "  onclick="guardar_atencion_cliente_vendedor()" id="btnguardar" > "Guardar" </a>
				
				<div id="texto_procesando" class="hide"> procesando ..</div>
      </div>
			</form>

    </div>
  </div> 
</div>

<!--  ** flotante  -->
<!--  ** flotante  repuesta de opereacion venta  -->
<!--  ** flotante  repuesta de opereacion venta  -->
						
 <div class="modal fade" id="exampleModalCenter2" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document" style="max-width:500px;">
          <form autocomplete="off" method="post" enctype="multipart/form-data">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">Seguimiento de Cliente: </h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top:-20px;">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body text-center" id="modi" style="display:flow-root;"></div>
              </div>
          </form>
        </div>
      </div>						