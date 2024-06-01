function inicio(min){
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
}

function finalizar(){
    var options = { frm:$('#form-finalizar').serialize(), url:'process_cart/finalizar_examen.php'};
    $.ajax({
        url:options.url,
        cache:false,
        type:'post',
        data:options.frm,
        success:function(data){
            var jotas = JSON.parse(data);
            $('#finalizar').html(jotas.result);
        }
    });
}



function sigue1(){
    if($('input:radio[name=preg1]:checked').val()===undefined){
        alert('Seleccionar Respuesta');
    }else{
        $('#pregunta1').css('display', 'none');
        $('#pregunta2').css('display', 'block');
    }
}
function sigue2(){
    if($('input:radio[name=preg2]:checked').val()===undefined){
        alert('Seleccionar Respuesta');
    }else{
        $('#pregunta2').css('display', 'none');
        $('#pregunta3').css('display', 'block');
    }
}
function sigue3(){
    if($('input:radio[name=preg3]:checked').val()===undefined){
        alert('Seleccionar Respuesta');
    }else{
        $('#pregunta3').css('display', 'none');
        $('#pregunta4').css('display', 'block');
    }
}
function sigue4(){
    if($('input:radio[name=preg4]:checked').val()===undefined){
        alert('Seleccionar Respuesta');
    }else{
        $('#pregunta4').css('display', 'none');
        $('#pregunta5').css('display', 'block');
    }
}
function sigue5(){
    if($('input:radio[name=preg5]:checked').val()===undefined){
        alert('Seleccionar Respuesta');
    }else{
        $('#pregunta5').css('display', 'none');
        $('#pregunta6').css('display', 'block');
    }
}
function sigue6(){
    if($('input:radio[name=preg6]:checked').val()===undefined){
        alert('Seleccionar Respuesta');
    }else{
        $('#pregunta6').css('display', 'none');
        $('#pregunta7').css('display', 'block');
    }
}
function sigue7(){
    if($('input:radio[name=preg7]:checked').val()===undefined){
        alert('Seleccionar Respuesta');
    }else{
        $('#pregunta7').css('display', 'none');
        $('#pregunta8').css('display', 'block');
    }
}
function sigue8(){
    if($('input:radio[name=preg8]:checked').val()===undefined){
        alert('Seleccionar Respuesta');
    }else{
        $('#pregunta8').css('display', 'none');
        $('#pregunta9').css('display', 'block');
    }
}
function sigue9(){
    if($('input:radio[name=preg9]:checked').val()===undefined){
        alert('Seleccionar Respuesta');
    }else{
        $('#pregunta9').css('display', 'none');
        $('#pregunta10').css('display', 'block');
    }
}
function sigue10(){
    if($('input:radio[name=preg10]:checked').val()===undefined){
        alert('Seleccionar Respuesta');
    }else{
        $('#pregunta10').css('display', 'none');
        $('#pregunta11').css('display', 'block');
    }
}
function sigue11(){
    if($('input:radio[name=preg11]:checked').val()===undefined){
        alert('Seleccionar Respuesta');
    }else{
        $('#pregunta11').css('display', 'none');
        $('#pregunta12').css('display', 'block');
    }
}
function sigue12(){
    if($('input:radio[name=preg12]:checked').val()===undefined){
        alert('Seleccionar Respuesta');
    }else{
        $('#pregunta12').css('display', 'none');
        $('#pregunta13').css('display', 'block');
    }
}
function sigue13(){
    if($('input:radio[name=preg13]:checked').val()===undefined){
        alert('Seleccionar Respuesta');
    }else{
        $('#pregunta13').css('display', 'none');
        $('#pregunta14').css('display', 'block');
    }
}
function sigue14(){
    if($('input:radio[name=preg14]:checked').val()===undefined){
        alert('Seleccionar Respuesta');
    }else{
        $('#pregunta14').css('display', 'none');
        $('#pregunta15').css('display', 'block');
    }
}
function sigue15(){
    if($('input:radio[name=preg15]:checked').val()===undefined){
        alert('Seleccionar Respuesta');
    }else{
        $('#pregunta15').css('display', 'none');
        $('#pregunta16').css('display', 'block');
    }
}
function sigue16(){
    if($('input:radio[name=preg16]:checked').val()===undefined){
        alert('Seleccionar Respuesta');
    }else{
        $('#pregunta16').css('display', 'none');
        $('#pregunta17').css('display', 'block');
    }
}
function sigue17(){
    if($('input:radio[name=preg17]:checked').val()===undefined){
        alert('Seleccionar Respuesta');
    }else{
        $('#pregunta17').css('display', 'none');
        $('#pregunta18').css('display', 'block');
    }
}
function sigue18(){
    if($('input:radio[name=preg18]:checked').val()===undefined){
        alert('Seleccionar Respuesta');
    }else{
        $('#pregunta18').css('display', 'none');
        $('#pregunta19').css('display', 'block');
    }
}
function sigue19(){
    if($('input:radio[name=preg19]:checked').val()===undefined){
        alert('Seleccionar Respuesta');
    }else{
        $('#pregunta19').css('display', 'none');
        $('#pregunta20').css('display', 'block');
    }
}
function sigue20(){
    if($('input:radio[name=preg20]:checked').val()===undefined){
        alert('Seleccionar Respuesta');
    }else{
        $('#pregunta20').css('display', 'none');
        $('#finalizar').css('display', 'block');
        $("#countdown").attr("id","pausa");
    }
}
function ante1(){
    $('#inicio').css('display', 'block');
    $('#pregunta1').css('display', 'none');
}
function ante2(){
    $('#pregunta1').css('display', 'block');
    $('#pregunta2').css('display', 'none');
}
function ante3(){
    $('#pregunta2').css('display', 'block');
    $('#pregunta3').css('display', 'none');
}
function ante4(){
    $('#pregunta3').css('display', 'block');
    $('#pregunta4').css('display', 'none');
}
function ante5(){
    $('#pregunta4').css('display', 'block');
    $('#pregunta5').css('display', 'none');
}
function ante6(){
    $('#pregunta5').css('display', 'block');
    $('#pregunta6').css('display', 'none');
}
function ante7(){
    $('#pregunta6').css('display', 'block');
    $('#pregunta7').css('display', 'none');
}
function ante8(){
    $('#pregunta7').css('display', 'block');
    $('#pregunta8').css('display', 'none');
}
function ante9(){
    $('#pregunta8').css('display', 'block');
    $('#pregunta9').css('display', 'none');
}
function ante10(){
    $('#pregunta9').css('display', 'block');
    $('#pregunta10').css('display', 'none');
}
function ante11(){
    $('#pregunta10').css('display', 'block');
    $('#pregunta11').css('display', 'none');
}
function ante12(){
    $('#pregunta11').css('display', 'block');
    $('#pregunta12').css('display', 'none');
}
function ante13(){
    $('#pregunta12').css('display', 'block');
    $('#pregunta13').css('display', 'none');
}
function ante14(){
    $('#pregunta13').css('display', 'block');
    $('#pregunta14').css('display', 'none');
}
function ante15(){
    $('#pregunta14').css('display', 'block');
    $('#pregunta15').css('display', 'none');
}
function ante16(){
    $('#pregunta15').css('display', 'block');
    $('#pregunta16').css('display', 'none');
}
function ante17(){
    $('#pregunta16').css('display', 'block');
    $('#pregunta17').css('display', 'none');
}
function ante18(){
    $('#pregunta17').css('display', 'block');
    $('#pregunta18').css('display', 'none');
}
function ante19(){
    $('#pregunta18').css('display', 'block');
    $('#pregunta19').css('display', 'none');
}
function ante20(){
    $('#pregunta19').css('display', 'block');
    $('#pregunta20').css('display', 'none');
}



