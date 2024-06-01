function randomNumber(min,max){
    return Math.floor(Math.random() * (max - min + 1) + min);
}

function fn_listar_items(elemento,options2){
		var xxx="HOLA";
    if($('.'+elemento).length){
        var listado = $('.'+elemento).attr('id'), options1 = { str:'&task='+xxx, frm:'&'+$('#frm_listado').serialize(), url:listado+'.php',texto:''};
        $.extend(true, options1, options2);
        var carga_listado = function(){
            $('.'+elemento).html(options1.texto);//mostrar texto antes del proces del ajax
            $.ajax({ url:options1.url,cache:false,type:'post',data:'pagina=1&listado='+listado+options1.frm+options1.str,
                success:function(data){
                    $('.'+elemento).html(data);if('cback' in options1){ options1.cback(); }
                }
            });
        };
        carga_listado();
        if('intervalo' in options1){ setInterval(carga_listado,options1.intervalo); }
    }
}


function compi(){
    if($('#compi').is(":visible")){
        $('#compi').css('display', 'none');
    }else{
        $('#compi').css('display', 'block');
    }
}

function fn_paginar(var_div, url){
    var div = url.split('?'), div2 = $('#'+var_div);
    $.ajax({
        url:div[0],type:'POST',data:'&'+div[1],success:function(data){ div2.html(data); $('html, body').stop().animate({ scrollTop: div2.offset().top-50 }, 600); }
    });
}

// function display(variable,task,idfieldtocharge) {
    // $.ajax({
        // url:'index.php',
        // method:'get',
        // dataType:'json',
        // data:{
            // variable: variable,
            // task: task
        // },
        // success: function(json){
            // var html = '';
            // $.each(json,function(i,data){ html+= '<option value="'+data.id+'">'+data.value+'</option>'; });
            // $('#'+idfieldtocharge).empty().html(html).change();
        // }
    // });
// }

function display(variable,task,idfieldtocharge) {
  $.ajax({ url:'index.php', method:'get', dataType:'json', data:{ variable: variable, task: task },
    success: function(json) {
      var html = '';
      $.each(json,function(i,data){ html+= '<option value="'+data.id+'">'+data.value+'</option>'; });
      $('#'+idfieldtocharge).empty().html(html).change();
    }
  });
}


function desplegar(){
    var r_password = $('#recover-passwd');
    r_password.find('form').get(0).reset();
    if(r_password.hasClass('hide')) r_password.removeClass('hide');
    else r_password.addClass('hide').find('label').remove();
}

function soloNumeros(evt){
    evt = (evt) ? evt : event;
    var charCode = (evt.charCode) ? evt.charCode : ((evt.keyCode) ? evt.keyCode : ((evt.which) ? evt.which : 0));
    var respuesta = true;
    if(charCode > 31 && (charCode < 48 || charCode > 57)) respuesta = false;
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

function posicionarMenu(){
    var altura_T = 100;
    if($(window).scrollTop() >altura_T) $('header').addClass('flota');
    else $('header').removeClass('flota');
}

function asistencia(detalle,sesion,curso,suscrito,link,link2){

    var id_detalle=detalle;
    var id_sesion=sesion;
    var id_curso=curso;
    var id_suscrito=suscrito;
    var formData = new FormData();

    formData.append('action',"registro");
    formData.append('id_detalle',id_detalle);
    formData.append('id_sesion',id_sesion);
    formData.append('id_curso',id_curso);
    formData.append('id_suscrito',id_suscrito);

    var str=formData;

    $.ajax({
        url:'process_cart/insert_asistencia.php',
        data:str,
        type:'post',
        contentType: false,
        processData: false,
        success:function(datos){
            var resultados = JSON.parse(datos);
            if(resultados.res == 1){
                // alert('Hay otra persona conectada con este usuario');
                location.href = link2;
            }else{
                location.href = link;
            }
            
            console.log(resultados.rpta);
        }
    });
}

function examen_completo(){
    swal({
        title: "Mensaje Auge Peru",
        html: "<p align='left' style='font-size:16px;line-height:21px'>Lo Sentimos<br>Usted a <b>completado todo los intentos</b> para resolver este examen, póngase en contacto con nosotros para darle el acceso nuevamente a desarrollar el examen<br><br>Concactanos a travez de:<br>Correos: <b>capacitacion@augeperu.org / augeperu@gmail.com</b><br>Telefonos: <b>Fijo: (01) 7075755 / RPM: #959598316 Móvil: 957668571<br><br><br>Atte. Auge Peru</b></p>",
        width: '600px',
        button: "Cerrar"

    }).then(function () {
        $('._pantalla_cargando_inicio_al_examen').addClass("hide"); // muestro pantalla cargando 
    });
    
}


function cambio_boton(boton){
    if(boton == 'bt1'){
        if($('#bt1').hasClass('act')){
            $("#bt1").removeClass("act");
            $("#bt2").addClass("act");
            $("#cua1").removeClass("ale");
            $("#cua2").addClass("ale");
        }else{
            $("#bt2").removeClass("act");
            $("#bt1").addClass("act");
            $("#cua2").removeClass("ale");
            $("#cua1").addClass("ale");
        }
    }else if(boton == 'bt2'){
        if($('#bt2').hasClass('act')){
            $("#bt2").removeClass("act");
            $("#bt1").addClass("act");
            $("#cua2").removeClass("ale");
            $("#cua1").addClass("ale");
        }else{
            $("#bt1").removeClass("act");
            $("#bt2").addClass("act");
            $("#cua1").removeClass("ale");
            $("#cua2").addClass("ale");
        }
    }
}




function _flota_formualrio_de_compra(){
    var altura_T = 600;
    if($(window).scrollTop() >altura_T) $('.contiene_datos_compra ').addClass('_flota_formulario');
    else $('.contiene_datos_compra').removeClass('_flota_formulario');
}