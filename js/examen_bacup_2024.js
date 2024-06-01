/*function inicio(min){
    $('#inicio').css('display', 'none');
    $('#pregunta1').css('display', 'block');
    var timer2 = min + ":01";
    var isPaused = false;
    var interval = setInterval(function(){
    if(!isPaused){
        var timer = timer2.split(':');
        //by parsing integer, I avoid all extra string processing
        var minutes = parseInt(timer[0], 10);
        var seconds = parseInt(timer[1], 10);
        --seconds;
        minutes = (seconds < 0) ? --minutes : minutes;
        if(minutes < 0) clearInterval(interval);
        seconds = (seconds < 0) ? 59 : seconds;
        seconds = (seconds < 10) ? '0' + seconds : seconds;
        //minutes = (minutes < 10) ?  minutes : minutes;
        $('#countdown').html('<img src="img/iconos/reloj2.png"><input type="hidden" name="minuto" value="' + minutes + '">' + minutes + ':' + seconds);
        timer2 = minutes + ':' + seconds;
    }
    }, 1000);
}*/


function finalizar2(){
    var options = { frm:$('#form-finalizar').serialize(), url:'process_cart/finalizar_examen.php'};
    $.ajax({
        url:options.url,
        cache:false,
        type:'post',
        data:options.frm,
        success:function(data){
            var jotas = JSON.parse(data);
            $(location).attr('href',jotas.result);
            //$('#finalizar').html(jotas.result);
        }
    });
}

			
function finalizar(tota){
    //comprobar si hay respuestas vacias
    //si tiene no se ejecuta
    for(var i=1; i<=tota; i++){
        //si al menos uno esta seleccionado se termina el buncle y se ejecuta la funcion
        if($("input[name='preg"+i+"']:radio").is(':checked')){
            i = tota + 1;
            console.log(i);
            swal({
                title: 'Mensaje Auge Peru',
                text: 'ESTAS SEGURO DE TERMINAR EL EXAMEN Y ENVIAR LOS DATOS',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Cancelar',
                confirmButtonText: 'Aceptar'
            }).then(function () {
                finalizar2();
            })
        }else{  
            if(tota == i){ 
                swal({
                title: 'Mensaje Auge Peru',
                html: "<p align='left' style='font-size:20px;line-height:26px'>Para terminar el examen debe seleccionar al menos una pregunta</p>",
                width: '600px',
                button: "Cerrar",
                });
            }else{ console.log(i); } 
        } 
    }
}







