// Bind the possible Add to Cart btns with event to position top links
;(function($) {
  $(document).ready(function(){

		
  	// FORMULARIO ENTRAR
  	if ($('#entrar').length){ // inicio de sesion
  		$('#entrar').submit(function(e){
  		e.preventDefault();
  		formulario('entrar','validator');
  		return false;
  		});
  		//
  		$('#recuperar').submit(function(e){
  		e.preventDefault();
  		formulario('recuperar','recuperar');
  		return false;
  		});
  	};
  	if ($('#registrar').length){
  		$('#registrar').submit(function(e){
  		e.preventDefault();
  		formulario('registrar','registrar');
  		return false;
  		});
  	}

  	// RECUPERAR
  	$(".rcp").on("click", function() {
  		$('.login').hide(300);
  		$('#recuperar').show('slow');
  	 });

  	$(".exit").on("click", function() {
  		$('.login').show(300);
  		$('#recuperar').hide('slow');
  		//$("#recuperar input[type='email']").val("");
  		$('#recuperar').get(0).reset();
  		$('#recuperar .msg .verror').hide();
  	 });

  	// VIDEO
    $("#link").keyup(function(){
      var iframe = $('.lvideo'),
        mvalor = $(this).val(),
        dividir = mvalor.split('='); 
        iframe.hide();
        if(mvalor!=''){
          iframe.show().attr('src','https://www.youtube.com/embed/'+dividir[1]);
        }
				
    });
    $("#link").trigger('keyup');

		
  /* preview video vimeo 
		$(".lleva_link_vimeo").keyup(function(){
      var iframe = $('.video_vimeo'),
        mvalor = $(this).val();
        // dividir = mvalor.split('='); 
        iframe.hide();
        if(mvalor!=''){
          iframe.show().attr('src',mvalor);
        }else{
					console.log("vacio");
				}
				
    });
    $(".lleva_link_vimeo").trigger('keyup');
*/
    

		/* preview video vimeo */
		$(".lleva_link_vimeo").keyup(function(){
      var iframe = $('.video_vimeo'),
        mvalor = $(this).val();
        // dividir = mvalor.split('='); 
        iframe.hide();
        if(mvalor!=''){
          iframe.show().attr('src',mvalor);
        }else{
					console.log("vacio");
				}
				
    });
    $(".lleva_link_vimeo").trigger('keyup');
    
		
  	// LISTADO
 // LISTADO

		 // $("button").onclick(function () {
		 // });

		$('#frm_buscar').find("button").on("click", function() {
				fn_buscar();			
		});
		
  	$('#criterio_usu_per').keyup(function(){
			 
				
  		// fn_buscar();
  	});
		
  	$('#frm_buscar').find('select').change(function(){
  		fn_buscar();
  	});
		
    if($('#frm_buscar').length) fn_buscar();
		
		    // Color- Piker  
     $('.color-picker').ColorPicker({
        onSubmit: function(hsb, hex, rgb, el) {
          $(el).val('#'+hex);
          $(el).ColorPickerHide();
        },
        onBeforeShow: function () {
          $(this).ColorPickerSetColor(this.value);
        }
      })
      .bind('keyup', function(){
        $(this).ColorPickerSetColor(this.value);
      });
		
		
  });
})(jQuery);

function formulario (frm,task){
	var form = $('#'+frm), msg = form.find('.msg');
	msg.html('<span class="vload"></span>');
	$.ajax({
		type: 'POST',
		url: 'index?task='+task,
		data: form.serialize(),
		cache: false,
		success: function(rpta){
			var terror = '' , tsuccs ='';
			terror = (task=='validator') ? 'Datos errados.' : ((task=='registrar') ? 'No se pudo crear la cuenta.' : 'No se pudo enviar el mensaje.');
			tsuccs = (task=='validator') ? 'Redirigiendo...' : ((task=='registrar') ? 'Cuenta creada correctamente.' : 'Mensaje enviado correctamente. Por favor revise la <b>Bandeja de su correo</b>.');
			//randy_cancer_30@hotmail.com
			//var tiempo = (task=='validator') ? 800 : 500;
			rpta = parseInt(rpta);
			if(rpta==2){
				msg.html('<span class="verror">'+terror+'</span>')
			}else if(rpta==3){
				msg.html('<span class="verror">Contraseña errada.</span>')
			}else{
				msg.html('<span class="vgood">'+tsuccs+'</span>')
				if(task=='validator' || task=='registrar')
				{
					setTimeout(function(){ document.location.href=''},800);
				}
			}
		}
	});
}

function gotourl(url){
    document.location.href=url;
}

function fn_mostrar_frm_agregar(){
  $("#div_oculto").load(link+"s.php?task=new", function(){
    $.blockUI({
      message: $('#div_oculto'),
      css:{
        top: '20%'
      }
    }); 
  });
};

function fn_delete_all(ide_per){
  swal({
  title: "Quiere continuar?",
  text: "Eliminando est"+l+"s "+link+"s!",
  type: "warning",
  showCancelButton: true,
  confirmButtonColor: '#DD6B55',
  confirmButtonText: 'Aceptar',
  closeOnConfirm: false
  },function(){
    var arr = new Array();
    if($('input.chkDel:checked').length){
      $('input.chkDel:checked').each(function(){ 
        arr.push($(this).val());
      });
      compl = '&chkDel[]='+arr;
      $.ajax({
        type: 'GET',
        url: link+'s.php',
        data: 'task=dropselect'+compl,//pass the array to the ajax call
        cache: false,
        success: function(){ 
          fn_buscar();
        }
      })
      .done(function(data) {
        swal("Eliminad"+l+"s!", "L"+l+"s "+link+"s fueron eliminad"+l+"s satisfactoriamente!", "success");
      })
      .error(function(data) {
        swal("Oops", "No hemos podido conectar con el servidor!", "error");
      });
    }else{
      swal('Por favor selecciona los registros a eliminar.','',"error");
    }
  });
}

function fn_eliminar(ide_per){
  swal({
  title: "Quiere continuar?",
  text: "Eliminando est"+l2+" "+us+"!",
  type: "warning",
  showCancelButton: true,
  confirmButtonColor: '#DD6B55',
  confirmButtonText: 'Aceptar',
  closeOnConfirm: false
  },function(){
    $.ajax({
      url: link+'s.php',
      data: '&task=drop&'+id+'=' + ide_per,
      type: 'GET',
      success: function(data){
        fn_buscar();
      }
    })
    .done(function(data) {
    swal("Eliminad"+l+"!", pr+" "+us+" fue eliminad"+l+" satisfactoriamente!", "success");
  })
  .error(function(data) {
    swal("Oops", "No hemos podido conectar con el servidor!", "error");
  });
  });
}

$(".marcar_certificado_como_enviado").on("click", function() {
	var ide     =   $('input[name="ide"]').val();
	var estado     =   $('select[name="estado_rpta"]').val();
	var fecha_envio     =   $('input[name="fecha_envio"]').val();
	var fecha_entrega     =   $('input[name="fecha_entrega"]').val();

	var empresa_envio     =   $('input[name="empresa_envio"]').val();
	var comentario     =   $('textarea[name="comentario"]').val();

  $.ajax({
    url: 'solicitudes.php',
    data: '&task=marcar_enviado&ide='+ide+'&estado='+estado+'&fecha_envio='+fecha_envio+'&fecha_entrega='+fecha_entrega+'&empresa_envio='+empresa_envio+'&comentario='+comentario,
    type: 'POST',
    success: function(state){
      state = parseInt(state);
				if(state==1){
					swal('Ok! Solicitud Entregada!','','success');
				}else if(state==2){
					swal('Ok! Solicitud Marcado como pendiente!','','success');
				}else if(state==3){
					swal('Ok! Solicitud Rechazada!','','success');
				}else if(state==4){
					swal('Ok! Solicitud Procesando envio!','','success');
				}else if(state==5){
					swal('Ok! Solicitud enviada!','','success');
				}

			setTimeout(function () {
				 location.reload();
			}, 3000); //msj desparece en 5seg.
			
    }
  });
	
}); 


$(".marcar_libro_como_enviado").on("click", function() {
  var ide     =   $('input[name="ide"]').val();
  var estado     =   $('select[name="estado_rpta"]').val();
  var fecha_envio     =   $('input[name="fecha_envio"]').val();
  var empresa_envio     =   $('input[name="empresa_envio"]').val();
  var tracking     =   $('input[name="tracking"]').val();
  var precio_envio     =   $('input[name="precio_envio"]').val();
  var comentario     =   $('textarea[name="comentario"]').val();

  $.ajax({
    url: 'solicitudes_libros.php',
    data: '&task=marcar_enviado&ide='+ ide+'&estado='+ estado+'&fecha_envio='+fecha_envio+'&empresa_envio='+empresa_envio+'&comentario='+comentario+'&tracking='+tracking+'&precio_envio='+precio_envio,
    type: 'POST',
    success: function(state){
      state = parseInt(state);
        if(state==1){
          swal('Ok! Solicitud Entregada!','','success');
        }else if(state==2){
          swal('Ok! Solicitud Marcado como pendiente!','','success');
        }else if(state==3){
          swal('Ok! Solicitud Rechazada!','','success');
        }else if(state==4){
          swal('Ok! Solicitud Procesando envio!','','success');
        }else if(state==5){
          swal('Ok! Solicitud enviada!','','success');
        }

      setTimeout(function () {
        location.reload();
      }, 3000); //msj desparece en 5seg.
      
    }
  });
  
}); 

function fn_estado_rechazar_solicitud(ide_tes){
  $.ajax({
    url: link+'s.php',
    data: '&task=uestado_rechazar_solicitud&estado_idestado=' + ide_tes,
    type: 'GET',
    success: function(state){
      state = parseInt(state);
      if(state==3){
        swal('Usted ha rechazado esta solicitud!','','error')
     
      }

			 // fn_buscar();
			setTimeout(function () {
				// location.reload();
			}, 3000); //msj desparece en 5seg.
			
    }
  });
}


function fn_estado(ide_tes){
  $.ajax({
    url: link+'s.php',
    data: '&task=uestado&estado_idestado=' + ide_tes,
    type: 'GET',
    success: function(state){
      state = parseInt(state);
      if(state==2){
        swal('Usted ha deshabilitado '+ar+' '+us+'.','','error')
      }else if(state==1){
        swal('Usted ha habilitado '+ar+' '+us+'.','','success')
      }
      fn_buscar();
    }
  });
}


function fn_estado_pago(ide_tes){
  $.ajax({
    url: 'pedidos.php',
    data: '&task=uestado_pago&id_pedido=' + ide_tes,
    type: 'GET',
    success: function(state){//coje el valor enviado desde le task
      state = parseInt(state);
      if(state==1){
        swal('Pedido pagado con éxito!','','success')
      }else{
        swal('Upps. algo fallo aprobando','','success')
			}
      // fn_buscar();
			setTimeout(function () {
				location.reload();
			}, 3000); //msj desparece en 5seg.

    }
  });
}


function fn_estado_rechazar_pago(ide_tes){
   let mypage= 'pedidos.php';
   var comentario=$('textarea[name="comentario"]').val();
   // alert(comentario);
  if( comentario !='' ){
    $.ajax({
      url: 'pedidos.php',
      data: '&task=uestado_pago_rechazar&id_pedido=' + ide_tes+'&comentario=' + comentario,
      type: 'GET',
      success: function(state){//coje el valor enviado desde le task
        state = parseInt(state);
        if(state==3){
          swal('Pago rechazado con éxito','','success');
          setTimeout(function () {
            location.reload();
          }, 3000); //msj desparece en 5seg.
  
        }else if(state==99){  // 99::sin_motivo_rechazo 
          swal('Ingresa el motivo del rechazado, para poder anular!','','error');
        }else{
          swal('Upps. algo fallo rechazando','','error')
        }
        
      }
    });
    
  }else{
    swal('Ingresa el motivo del rechazado, para poder anular!','','error');
  }
 
}


// rechzaar venta de certificados manuales 
function fn_estado_rechazar_pago_certificado(ide_tes){
   let mypage= 'pedidos_manuales_certificados.php';
   var comentario=$('textarea[name="comentario"]').val();
   // alert(comentario);
  if( comentario !='' ){
    $.ajax({
      url: 'pedidos_manuales_certificados.php',
      data: '&task=uestado_pago_rechazar_certificado&id_pedido=' + ide_tes+'&comentario=' + comentario,
      type: 'GET',
      success: function(state){//coje el valor enviado desde le task
        state = parseInt(state);
        if(state==3){
          swal('Pago rechazado con éxito','','success');
          setTimeout(function () {
            location.reload();
          }, 3000); //msj desparece en 5seg.
  
        }else if(state==99){  // 99::sin_motivo_rechazo 
          swal('Ingresa el motivo del rechazado, para poder anular!','','error');
        }else{
          swal('Upps. algo fallo rechazando','','error')
        }
        
      }
    });
    
  }else{
    swal('Ingresa el motivo del rechazado, para poder anular!','','error');
  }
 
}



function fn_estado_pedido(ide_tes){
  $.ajax({
    url: link+'s.php',
    data: '&task=uestado_pedido&idpedido=' + ide_tes,
    type: 'GET',
    success: function(state){//coje el valor enviado desde le task
      state = parseInt(state);
      if(state==2){
        swal('Pedido pendiente por ser entregado .','','error')
      }else if(state==1){
        swal('Pedido entregado con exito.','','success')
      }
      fn_buscar();
    }
  });
}

function fn_estado_producto(ide_tes){
  $.ajax({
    url: link+'s.php',
    data: '&task=uestado&estado=' + ide_tes,
    type: 'GET',
    success: function(state){
      state = parseInt(state);
      if(state==2){
        swal('Usted ha deshabilitado '+ar+' '+us+'.','','error')
      }else if(state==1){
        swal('Usted ha habilitado '+ar+' '+us+'.','','success')
      }
      fn_buscar();
    }
  });
}



function fn_estado_eliminar_ocultar(ide_tes){
  $.ajax({
    url: link+'s.php',
    data: '&task=fn_estado_eliminar_ocultar&estado_idestado=' + ide_tes,
    type: 'GET',
    success: function(state){
      state = parseInt(state);
      if(state!=100){
        swal('Ocurrio un error en servidor, reportar al área de sistemas ','','error')
      }else if(state==100){
        swal('Usted ha eliminado esta clase!','','success')
      }
      fn_buscar();
    }
  });
}



function fn_paginar(var_div, url){
  var div = $("#" + var_div);
    $(div).load(url);
}
  
function repaginar(div,page,str){
  fn_paginar(div, page+'?'+str);  
}

function sorter(){
  $("#example1").tablesorter();
}

function checked(){
  $('.all').change(function (e) {
   if(this.className == 'all'){
       $('.chkDel').prop('checked', this.checked);
   }else{
        $('.all').prop('checked', $('.chkDel:checked').length == $('.chkDel').length);
    }
  });
}

function reordenar_con_post(page){
  $('#sort').sortable({
    opacity: 0.6,
    cursor: 'move',
    update: function() {
        var order = $('#sort').sortable("serialize");
        $.ajax({
          url: page, 
          type: 'post',
          data: 'task=reordenar_con_post&'+order,
          success: function(){
            swal('Orden Actualizado','','success');
            fn_buscar();
          }
        });
      }
  });
}


function reordenar(page){
  $('#sort').sortable({
    opacity: 0.6,
    cursor: 'move',
    update: function() {
        var order = $('#sort').sortable("serialize");
        $.ajax({
          url: page, 
          type: 'get',
          data: 'task=ordenar&'+order,
          success: function(){
            // swal('Orden Actualizado','','success');
            fn_buscar();
          }
        });
      }
  });
}

function reordenar_destacado(page){
  $('#sort').sortable({
    opacity: 0.6,
    cursor: 'move',
    update: function() {
        var order = $('#sort').sortable("serialize");
        $.ajax({
          url: page, 
          type: 'get',
          data: 'task=reordenar_destacado&'+order,
          success: function(){
            // swal('Orden Actualizado','','success');
            fn_buscar();
          }
        });
      }
  });
}

function fn_buscar(){  
  var xmlhttp;
  if (window.XMLHttpRequest){
  // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  }else{
  // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  var str = $("#frm_buscar").serialize();
  xmlhttp.onreadystatechange=function(){
    if (xmlhttp.readyState==4 && xmlhttp.status==200){
      document.getElementById("div_listar").innerHTML=xmlhttp.responseText;
      parseScript(xmlhttp.responseText);
    }
  }
  xmlhttp.open("GET",mypage+'?'+'task=finder&'+str,true);
  xmlhttp.send();
}


function parseScript(strcode) {
  var scripts = new Array(); // Array which will store the script's code
  // /* Strip out tags */
  while(strcode.indexOf('<script') > -1 || strcode.indexOf('</script') > -1) {
    var s = strcode.indexOf('<script');
    var s_e = strcode.indexOf('>',s);
    var e = strcode.indexOf('</script',s);
    var e_e = strcode.indexOf('>',e);
   // /*  Add to scripts array */
    scripts.push(strcode.substring(s_e+1,e));
   // /* Strip from strcode */
    strcode = strcode.substring(0,s)+strcode.substring(e_e+1);
  }
 // /*  Loop through every script collected and eval it */
  for(var i=0; i<scripts.length; i++) {
    try{ eval(scripts[i]); }
    catch(ex){
 // /*    do what you want here when a script fails */ 
    }
  }
}


function display(archivo,variable,task,idfieldtocharge) { //cargan datos  de un cmb a o tro cmb
  $.ajax({ url:archivo, method:'get', dataType:'json', data:{ variable: variable, task: task }, 
    success: function(json) { 
      console.log(json);
      var html = '';
      $.each(json,function(i,data){ html+= '<option value="'+data.id+'">'+data.value+'</option>'; });
      $('#'+idfieldtocharge).empty().html(html).change(); 
    }
  });
}

function display_x_dpto(archivo,variable,task,idfieldtocharge,variable_dpto) { //cargan datos  de un cmb a o tro cmb
  variable_dpto= $('#iddpto').val();
  
  if( variable_dpto != '' ){
    console.log('dpto marcado:: '+variable_dpto);
    $.ajax({ url:archivo, method:'get', dataType:'json', data:{ variable: variable,  variable_dpto: variable_dpto, task: task }, 
      success: function(json) { 
        console.log(json);
        var html = '';
        $.each(json,function(i,data){ html+= '<option value="'+data.id+'">'+data.value+'</option>'; });
        $('#'+idfieldtocharge).empty().html(html).change(); 
      }
    });
  }else{
    alert(" * seleccione primero el departamento!");
    $('#id_agencia').val('');
  }
 
}


function soloNumeros(evt,tipo){
  evt = (evt) ? evt : event;
  var charCode = (evt.charCode) ? evt.charCode : ((evt.keyCode) ? evt.keyCode : ((evt.which) ? evt.which : 0));
  var respuesta = true;
  if (charCode > 31 && (charCode < 48 || charCode > 57)) respuesta = false;
  if(tipo !== undefined && tipo == 2){//si envio el 2 permite decimimale
    if(charCode==46) respuesta = true;
  }
  return respuesta;
}



function soloNumeros_precio(evt){
  evt = (evt) ? evt : event;
  var charCode = (evt.charCode) ? evt.charCode : ((evt.keyCode) ? evt.keyCode : ((evt.which) ? evt.which : 0));
  var respuesta = true;
  if(charCode > 31 && (charCode < 48 || charCode > 57)) respuesta = false;
  if(charCode==46) respuesta = true;
  return respuesta;
}



function en_vivo(ides){	
	// alert("holas");
	var nam3=ides;		
	var nam1=document.getElementById('enlace_en_vivo_'+ides).value;		
	var nam2=document.getElementById('hora_en_vivo_'+ides).value;		
	var nam5=document.getElementById('en_vivo_'+ides).value;
	
	var horario_inicio=document.getElementById('horario_inicio_'+ides).value;		
	var horario_final=document.getElementById('horario_final_'+ides).value;
	var horario_hora=document.getElementById('horario_hora_'+ides).value;
	var horario_lunes=document.getElementById('horario_lunes_'+ides).value;
	var horario_martes=document.getElementById('horario_martes_'+ides).value;
	var horario_miercoles=document.getElementById('horario_miercoles_'+ides).value;
	var horario_jueves=document.getElementById('horario_jueves_'+ides).value;
	var horario_viernes=document.getElementById('horario_viernes_'+ides).value;
	var horario_sabado=document.getElementById('horario_sabado_'+ides).value;
	var horario_domingo=document.getElementById('horario_domingo_'+ides).value;
	
  var hora_inicio_lunes=document.getElementById('hora_inicio_lunes_'+ides).value;
	var hora_fin_lunes=document.getElementById('hora_fin_lunes_'+ides).value;
  
  var hora_inicio_martes=document.getElementById('hora_inicio_martes_'+ides).value;
	var hora_fin_martes=document.getElementById('hora_fin_martes_'+ides).value;
  var hora_inicio_miercoles=document.getElementById('hora_inicio_miercoles_'+ides).value;
	var hora_fin_miercoles=document.getElementById('hora_fin_miercoles_'+ides).value;
  var hora_inicio_jueves=document.getElementById('hora_inicio_jueves_'+ides).value;
	var hora_fin_jueves=document.getElementById('hora_fin_jueves_'+ides).value;
  var hora_inicio_viernes=document.getElementById('hora_inicio_viernes_'+ides).value;
	var hora_fin_viernes=document.getElementById('hora_fin_viernes_'+ides).value;

  var hora_inicio_sabado=document.getElementById('hora_inicio_sabado_'+ides).value;
	var hora_fin_sabado=document.getElementById('hora_fin_sabado_'+ides).value;

  var hora_inicio_domingo=document.getElementById('hora_inicio_domingo_'+ides).value;
	var hora_fin_domingo=document.getElementById('hora_fin_domingo_'+ides).value;

	
	let str='en_vivo='+nam5+'&enlace_en_vivo='+nam1+'&hora_en_vivo='+nam2+'&id_curso='+nam3+'&horario_inicio='+horario_inicio+'&horario_final='+horario_final+'&horario_hora='+horario_hora+'&horario_lunes='+horario_lunes+'&horario_martes='+horario_martes+'&horario_miercoles='+horario_miercoles+'&horario_jueves='+horario_jueves+'&horario_viernes='+horario_viernes+'&horario_sabado='+horario_sabado+'&horario_domingo='+horario_domingo+'&hora_inicio_lunes='+hora_inicio_lunes+'&hora_fin_lunes='+hora_fin_lunes+'&hora_inicio_martes='+hora_inicio_martes+'&hora_fin_martes='+hora_fin_martes+'&hora_inicio_miercoles='+hora_inicio_miercoles+'&hora_fin_miercoles='+hora_fin_miercoles
  +'&hora_inicio_jueves='+hora_inicio_jueves+'&hora_fin_jueves='+hora_fin_jueves
  +'&hora_inicio_viernes='+hora_inicio_viernes+'&hora_fin_viernes='+hora_fin_viernes
  +'&hora_inicio_sabado='+hora_inicio_sabado+'&hora_fin_sabado='+hora_fin_sabado
  +'&hora_inicio_domingo='+hora_inicio_domingo+'&hora_fin_domingo='+hora_fin_domingo;
	
	// if(nam1 !='' && nam2 !='' && nam3 !='' ){
		
		$.ajax({url:'cursos.php?task=curso_envivo',data:str,type:'post',success:function(rpta){
			if(rpta==1){ // Si pago es ON LINE
					$('.rpta_envivo').removeClass('hide');
					$('.rpta_envivo').html('Listo actualizado! .. ');					
						setTimeout(function () {
							$('.rpta_envivo').addClass('hide');
							$('.rpta_envivo').html('');
							location.reload();
						}, 2000); //msj desparece en 5seg.
				}
		}});
		
	// }else{
			// alert('* los datos son obligatorios!');
	// }
	
};	



function fn_add_examen_a_curso(id_curso){
  swal({
  title: "Quiere continuar?",
  text: "Agregando estos examenes ",
  type: "warning",
  showCancelButton: true,
  confirmButtonColor: 'green',
  confirmButtonText: 'Aceptar',
  closeOnConfirm: false
  },function(){
    var arr = new Array();
    if($('input.chkDel:checked').length){  
      $('input.chkDel:checked').each(function(){ 
        arr.push($(this).val());
      });
      compl = '&chkDel[]='+arr;
      $.ajax({
        type: 'GET',
        url: 'examene2s.php',
        data: 'task=agregando_examen&id_curso='+id_curso+compl,//pass the array to the ajax call
        cache: false,
        success: function(){ 
          fn_buscar();
        }
      })
      .done(function(data) {
        swal("Examenes agregados satisfactoriamente!", "success");
      })
      .error(function(data) {
        swal("Oops", "No hemos podido conectar con el servidor!", "error");
      });
    }else{
      swal('Por favor selecciona los examenes a agregar.','',"error");
    }
  });
}

function actualizar_puntaje_total(id_examen){
  swal({
    title: "¿Desea actualizar puntaje?",
    type: "input",
    showCancelButton: true,
    closeOnConfirm: false,
    inputPlaceholder: "Escriba el puntaje"
  }, function (inputValue){
    if(inputValue === false) return false;
    if(inputValue === ""){
      swal.showInputError("Llenar el campo");
      return false
    }
    $.ajax({
      type: 'GET',
      url: 'preguntas.php',
      data: 'task=actualizar_puntaje_total&id_examen='+id_examen+'&puntaje='+inputValue,//pass the array to the ajax call
      cache: false,
      success: function(){ fn_buscar(); }
    })
    .done(function(data) {
      swal("Puntaje actualizado satisfactoriamente!", "success");
    })
    .error(function(data) {
      swal("Oops", "No hemos podido conectar con el servidor!", "error");
    });
  });
}

function fn_add_especialidades_a_curso(id_curso){
  swal({
  title: "Quiere continuar?",
  text: "Agregando estas especialidades ",
  type: "warning",
  showCancelButton: true,
  confirmButtonColor: 'green',
  confirmButtonText: 'Aceptar',
  closeOnConfirm: false
  },function(){
    var arr = new Array();
    if($('input.chkDel:checked').length){  
      $('input.chkDel:checked').each(function(){ 
        arr.push($(this).val());
      });
      compl = '&chkDel[]='+arr;
      $.ajax({
        type: 'GET',
        url: 'cursos_especialidades.php',
        data: 'task=agregando_especialidades&id_curso='+id_curso+compl,//pass the array to the ajax call
        cache: false,
        success: function(){ 
          fn_buscar();
        }
      })
      .done(function(data) {
        swal("Especialidades agregadas satisfactoriamente!", "success");
      })
      .error(function(data) {
        swal("Oops", "No hemos podido conectar con el servidor!", "error");
      });
    }else{
      swal('Por favor selecciona los cursos a agregar.','',"error");
    }
  });
}


/* Banco de preguntas : agregar preguntas a examen */
function fn_add_banco_a_examenes(id_examen){
  swal({
  title: "Quiere continuar?",
  text: "Agregando estas preguntas ",
  type: "warning",
  showCancelButton: true,
  confirmButtonColor: 'green',
  confirmButtonText: 'Aceptar',
  showLoaderOnConfirm: true,
  closeOnConfirm: false
  },function(){
    var arr = new Array();
    if($('input.chkDel:checked').length){  
		
      $('input.chkDel:checked').each(function(){ 
        arr.push($(this).val());
      });
      compl = '&chkDel[]='+arr;
      $.ajax({
        type: 'POST',
        url: 'banco_preguntas_examenes.php',
        data: 'task=agregando_preguntas_desde_banco&id_examen='+id_examen+compl,//pass the array to the ajax call
        cache: false,
        success: function(datos){ 
					var resultados = JSON.parse(datos);
					if(resultados.res == "ok"){
						swal("Preguntas agregadas correctamente!", "success");						
						fn_buscar();
					}else{
						swal("Oops", "No hemos podido conectar con el servidor!", "error");
						
					}
					
        }
      })
      // .done(function(data) {
      // })
      // .error(function(data) {
      // });
			
    }else{
      swal('Por favor selecciona las preguntas a agregar.','',"error");
    }
  });
}


// function fn_exportar(str,name,data1,data2){
  // if(str === undefined) str = '';
  // $.ajax({
    // url:'index.php?task=exportar_excel',type:'POST',data:str,
    // success : function(data){ document.location.href = 'exportar.excel.'+name+'.php'; }
  // });
// }


/*
function fn_exportar(str,name,sql,data2){  PHP 7 DEPRECATEFD 
	var sql= $('input[name="sql_excel"]').val();	
  if(str === undefined) str = '';
  $.ajax({
    url:'index.php?task=exportar_excel',type:'POST',data:str+'&sql='+sql,
    success : function(data){ document.location.href = 'exportar.excel.'+name+'.php'; }
  });
}
*/
  

function fn_exportar(str_1,name,sql,sql_2_alterno,sql_3_alterno){  // para PHP8
  /*
	var sql= $('input[name="sql_excel"]').val();	
  if(str === undefined) str = '';
  $.ajax({
    url:'index.php?task=exportar_excel',type:'POST',data:str+'&sql='+sql,
    success : function(data){ document.location.href = 'exportar.excel.'+name+'.php'; }
  });
  */


  var sql= $('input[name="sql_excel"]').val();
  var sql_2_alterno= $('input[name="sql_2_alterno"]').val();
  var sql_3_alterno= $('input[name="sql_3_alterno"]').val();


  let data= "?"+str_1+'&sql='+sql;

  if( sql_2_alterno !='' ){
      data= data+'&sql_2_alterno='+sql_2_alterno;
  }


  // let data= "&"+str_1;
  console.log("okey descargado ");
  alert("OK Excel "+name+":: descargado!");
  document.location.href = 'exportar.excel.'+name+'.php'+data;


}




function fn_exportar_todo(name,sql,data2){
	var sql= $('input[name="sql_excel"]').val();
  let str='';			
  if(str === undefined) str = '';
  $.ajax({
    url:name,type:'GET',data:'sql='+sql,
    success : function(data){ 
        document.location.href = name+'?sql='+sql; 
        console.log("okey descargado ");
    }
  });
}



function _add_insertar_pregunta_desde_examen_a_banco(ides){	

	let str='id_pregunta='+ides;
  $('.rpta_envivo').removeClass('hide');
  $('.rpta_envivo').html(' Cargando, espere que el proceso termina  .. ');					
			
		$.ajax({url:'preguntas.php?task=_add_insertar_pregunta_desde_examen_a_banco',data:str,type:'post',success:function(rpta){


			if(rpta==1){ // Si pago es ON LINE
					$('.rpta_envivo').removeClass('hide');
					$('.rpta_envivo').html('Listo pregunta migrada al banco de preguntas! .. ');					
						setTimeout(function () {
							$('.rpta_envivo').addClass('hide');
							$('.rpta_envivo').html('');
							location.reload();
						}, 2000); //msj desparece en 5seg.
      
      }else if(rpta==3){ // Si ya existe la pregunata en el banco 
        $('.rpta_envivo').removeClass('hide');
        $('.rpta_envivo').html(' Ya existe en el banco de preguntas, ya fue agregada anterioremnte ! .. ');			
      }
      
		}});	
	
};	



function clonar_examen(id_examen_a_clonar, id_ultima_categoria){		 				
	var titulo_examen_nuevo=document.getElementById('titulo_'+id_examen_a_clonar).value;		
  var array_marcados=[];
  console.log(" ultima categoria:: "+id_ultima_categoria);

  for( let id_categoria=198 ;  id_categoria <= id_ultima_categoria;  id_categoria++  ){  // recorro todas las categorias en ese rango
    // si por aluna razon algua categoria se elimno o deshbaulito, hay validar que si existe el elemnto o no sino lo salteamos 
    var variable_id = "checkbox_"+id_examen_a_clonar+"-"+id_categoria;
    
    if ($('#'+variable_id).length){  // valido si existe el elemnto 
      var checkBox = document.getElementById(variable_id);
      if (checkBox.checked) {// El checkbox está seleccionado
        console.log("El checkbox está seleccionado"+id_categoria);
        //array_marcados= array_marcados+"-"+id_categoria;
        array_marcados.push(id_categoria);
      
      }else{ // El checkbox no está seleccionado
        console.log("El checkbox no está seleccionado");
      }

    }else{
      console.log("no_existe checkbox::: "+variable_id);
    }

  } // end for 

  console.log(array_marcados);
	let str='id_examen_clonado='+id_examen_a_clonar+'&titulo_clonacion='+titulo_examen_nuevo+'&categorias='+array_marcados;
	
	if(titulo_examen_nuevo !='' &&  array_marcados.length > 0 ){	 
    $('#btn_clonar_'+id_examen_a_clonar).disabled=true;
    $('#btn_clonar_'+id_examen_a_clonar).addClass('hide');

    $('.rpta_envivo').removeClass('hide');
    $('.rpta_envivo').html('espere, estamos clonando .. ');		
		$.ajax({url:'examenes.php?task=clonar_examen',data:str,type:'post',success:function(rpta){
			  if(rpta==1){ // Si pago es ON LINE					
					$('.rpta_envivo').html('Listo actualizado! .. ');					
						setTimeout(function () {
							$('.rpta_envivo').addClass('hide');
							$('.rpta_envivo').html('');
							location.reload();
						}, 8000); //msj desparece en 5seg.
				

        }else if(rpta==99){ // Si  se clono pero no teniap reguntas en las categorias seleccionadas 
          $('.rpta_envivo').html('** El Examen clonado, no tenia preguntas en las categorias seleccionadas ! .. ');				
          setTimeout(function () {
            $('.rpta_envivo').addClass('hide');
            $('.rpta_envivo').html('');
            location.reload();
          }, 10000); //msj desparece en 5seg.	

				}else{
          $('.rpta_envivo').html('Error clonando revisar functions_js ! .. ');					
        }
		}});
		
  }else{
    alert('* Titulo y al menos una especialidad los datos son obligatorios!');
	}
	
};	// end clonar _examen 




function fn_pdf_envio_libros(str,sql){
	// var sql=String.fromCharCode($('input[name="sql_excel"]').val());
	var sql= $('input[name="sql_excel"]').val();	
	
  if(str === undefined) str = '';
  document.location.href = 'pdf/examples/pdf_solicitudes_libros.php?sql='+sql; 
  alert("OK ARCHIVO DESCARGADO ");



}

