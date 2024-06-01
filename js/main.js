$(document).ready(function () {

    var customSlider = { item: 1, speed: 500, adaptiveHeight: true, slideMargin: 0, auto: true, loop: true, pager: true, controls: false, pause: 5000 };
    var customSlider = { pager: false };

    if ($('#carousel-1').length) {
        var s1 = $('#carousel-1');
        customSlider['item'] = 1;
        customSlider['onBeforeStart'] = function () { s1.removeClass('hide').closest('.banners').find('.esperando-slider').remove(); };
        s1.lightSlider(customSlider);
    }

    if ($('#carousel-1-movil').length) {
        var s1 = $('#carousel-1-movil');
        customSlider['item'] = 1;
        customSlider['onBeforeStart'] = function () { s1.removeClass('hide').closest('.banners').find('.esperando-slider').remove(); };
        s1.lightSlider(customSlider);
    }


    if ($('.carousel-1').length) {
        var s3_31 = $('.carousel-1'), control_s3_31 = $('.callout').find('.clientes a');//encontrando las flechas 
        customSlider['item'] = 1;
        customSlider['controls'] = true;
        customSlider['pager'] = false;
        customSlider['pause'] = 4000;
        customSlider['onBeforeStart'] = function () { s3_31.removeClass('hide'); };
        s3_31.lightSlider(customSlider);
        control_s3_31.on('click', function () { var el = $(this); if (el.hasClass('lSPrev')) { s3_31.goToPrevSlide(); } else { s3_31.goToNextSlide(); } });
    }


    if ($('.carousel-3').length) {
        var s3_3 = $('.carousel-3'), control_s3_3 = $('.callout').find('.clientes a');//encontrando las flechas 
        customSlider['item'] = 3;
        customSlider['slideMargin'] = 30;
        customSlider['pager'] = true;
        customSlider['pause'] = 8000;
        customSlider['onBeforeStart'] = function () { s3_3.removeClass('hide'); };
        customSlider['responsive'] = [
            // {breakpoint:1280,settings:{item:3,slideMargin:0}},
            { breakpoint: 1150, settings: { item: 2, slideMargin: 0 } },
            { breakpoint: 800, settings: { item: 1, slideMargin: 0 } }
        ];
        s3_3.lightSlider(customSlider);
        control_s3_3.on('click', function () { var el = $(this); if (el.hasClass('lSPrev')) { s3_3.goToPrevSlide(); } else { s3_3.goToNextSlide(); } });
    }

    if ($('.carousel-one').length) {
        var s3 = $('.carousel-one'), control_s3 = $('.callout').find('.clientes a');//encontrando las flechas 
        customSlider['item'] = 1;
        customSlider['pager'] = true;
        customSlider['pause'] = 8000;
        customSlider['onBeforeStart'] = function () { s3.removeClass('hide'); };
        customSlider['responsive'] = [
            { breakpoint: 1280, settings: { item: 1, slideMargin: 0 } },
            { breakpoint: 1150, settings: { item: 1, slideMargin: 0 } },
            { breakpoint: 800, settings: { item: 1, slideMargin: 0 } }
        ];
        s3.lightSlider(customSlider);
        control_s3.on('click', function () { var el = $(this); if (el.hasClass('lSPrev')) { s3.goToPrevSlide(); } else { s3.goToNextSlide(); } });
    }

    if ($('.carousel-docente-curso').length) {
        var s33 = $('.carousel-docente-curso'), control_s33 = $('.callout').find('.clientes a');//encontrando las flechas 
        customSlider['item'] = 1;
        customSlider['pager'] = true;
        customSlider['controls'] = true;

        customSlider['pause'] = 8000;
        customSlider['onBeforeStart'] = function () { s33.removeClass('hide'); };
        customSlider['responsive'] = [
            { breakpoint: 1280, settings: { item: 1, slideMargin: 0 } },
            { breakpoint: 1150, settings: { item: 1, slideMargin: 0 } },
            { breakpoint: 800, settings: { item: 1, slideMargin: 0 } }
        ];
        s33.lightSlider(customSlider);
        control_s33.on('click', function () { var el = $(this); if (el.hasClass('lSPrev')) { s33.goToPrevSlide(); } else { s33.goToNextSlide(); } });

    }

    if ($('.carousel_1_detalle_curso_tetsimonio').length) {
        var s3_31 = $('.carousel_1_detalle_curso_tetsimonio'), control_s3_31 = $('.callout').find('.clientes a');//encontrando las flechas 
        customSlider['item'] = 1;
        customSlider['controls'] = true;
        customSlider['pager'] = false;
        customSlider['pause'] = 4000;
        customSlider['onBeforeStart'] = function () { s3_31.removeClass('hide'); };
        s3_31.lightSlider(customSlider);
        control_s3_31.on('click', function () { var el = $(this); if (el.hasClass('lSPrev')) { s3_31.goToPrevSlide(); } else { s3_31.goToNextSlide(); } });
    }


    /* modal gracias compra */
    var customSlider = { pager: false };
    if ($('#carousel-2-1').length) {
        var s3_2 = $('#carousel-2-1'), control_s3_2 = $('.callout').find('.clientes a');//encontrando las flechas 
        customSlider['item'] = 2;
        customSlider['controls'] = false;
        customSlider['pause'] = 8000;
        customSlider['onBeforeStart'] = function () { s3_2.removeClass('hide'); };
        customSlider['responsive'] = [
            { breakpoint: 1280, settings: { item: 2, slideMargin: 0 } },
            { breakpoint: 1150, settings: { item: 1, slideMargin: 0 } },
            { breakpoint: 800, settings: { item: 1, slideMargin: 0 } }
        ];
        s3_2.lightSlider(customSlider);
        control_s3_2.on('click', function () { var el = $(this); if (el.hasClass('lSPrev')) { s3.goToPrevSlide(); } else { s3.goToNextSlide(); } });

    }

    // Contacto
    if ($('#ajax-contact-form').length) {
        var frm2 = $('#ajax-contact-form');
        frm2.customPlugin({
            rules: {
                nombre: { required: true, minlength: 3 },
                correo: { required: true, email: true },
                fono: { required: true, maxlength: 9, minlength: 9 },
                ciudad: { required: true, minlength: 3 },
                asunto: { required: true, minlength: 3 },
                mensaje: { required: true, minlength: 10 }
            },
            messages: {
                doc: { minlength: 'Formato inv&aacute;lido.' },
                correo: { remote: 'Ya existe este correo, por favor inicie sesión como <strong>Usuario registrado</strong>.' },
                clave1: { equalTo: 'Contrase&ntilde;as no coinciden' }
            },
            val_action: 'contacto',
            prex_msg: 'report'
        }).data('customPlugin').validate();
    }

    // Contacto
    if ($('#form-comen').length) {
        var frm2 = $('#form-comen');
        frm2.customPlugin({
            rules: {
                id_curso: { required: true, minlength: 3 },
                id_detalle: { required: true, email: true },
                id_sesion: { required: true, maxlength: 9, minlength: 9 },
                id_suscrito: { required: true, minlength: 3 },
                comen: { required: true, minlength: 10 }
            },
            messages: {
                comen: { required: '*Campo Requerido' }
            },
            val_action: 'comentario',
            prex_msg: 'comen'
        }).data('customPlugin').validate();
    }

    if ($('#form-recu').length) {
        var frm3 = $('#form-recu');
        frm3.customPlugin({
            rules: {
                correo: { required: true, email: true },
            },
            messages: {
            },
            gotourl: 'inicio',
            val_action: 'recuperar',
            prex_msg: 'report'
        }).data('customPlugin').validate();
    }

    if ($('#form-recu2').length) {
        var frm4 = $('#form-recu2');
        frm4.customPlugin({
            rules: {
                correo: { required: true, email: true },
                clave: { required: true, minlength: 6 },
                clave2: { required: true, minlength: 6, equalTo: '#clave' }
            },
            messages: {
                clave: { minlength: 'Min. 6 caracteres' },
                clave2: { minlength: 'Min. 6 caracteres', equalTo: 'Las claves no coinciden.' },
            },
            gotourl: 'inicio',
            val_action: 'actualizar',
            prex_msg: 'actua'
        }).data('customPlugin').validate();
    }

    if ($('#form-recu_v2').length) {
        var frm4 = $('#form-recu_v2');
        frm4.customPlugin({
            rules: {
                dni: { required: true },
                email: { required: true, email: true },
                clave: { required: true, minlength: 6 },
                clave2: { required: true, minlength: 6, equalTo: '#clave' }
            },
            messages: {
                clave: { minlength: 'Min. 8 caracteres' },
                clave2: { minlength: 'Min. 8 caracteres', equalTo: 'Las claves no coinciden.' },
            },
            gotourl: 'mis-cursos',
            val_action: 'actualizar_v2',
            prex_msg: 'report'
        }).data('customPlugin').validate();
    }

    // Magnific Popup
    if ($('.mpopup-01').length) { $('.mpopup-01').magnificPopup({ type: 'image', delegate: 'a', gallery: { enabled: true } }); }
    $('.mpopup-02').magnificPopup({ type: 'iframe' }); /* efecto ventana emergente ara video*/
    $('.mpopup-03').magnificPopup({ type: 'ajax' });//emergente

    $('.popup-vimeo').magnificPopup({ disableOn: 700, type: 'iframe', mainClass: 'mfp-fade', removalDelay: 160, preloader: false, fixedContentPos: false });

    // Listados
    fn_listar_items('load-content');//para listar prensa sin formnulario
    // Menú
    main();

    $(".scroll").click(function (event) {
        event.preventDefault();
        $('html,body').animate({ scrollTop: $(this.hash).offset().top - 35 }, 500);
    });


    //Llmando al menu en XL
    var vm = 1;
    $(document).on("click", ".llamar-menu-xl", function (e) {
        e.preventDefault();
        vm++;
        if (vm == 2) {
            $('header').find('#menu_perfil').removeClass('hide');
        } else { $('header').find('#menu_perfil').addClass('hide'); vm = 1; }
    });

    //Llmando al wsp 
    var wsp = 1;
    $(document).on("click", ".lleva_icono_wasap", function (e) {
        e.preventDefault();
        wsp++;
        if (wsp == 2) {
            $('.wasap_flota').find('.lleva_contenido_wasap').removeClass('hide');
        } else {
            $('.wasap_flota').find('.lleva_contenido_wasap').addClass('hide');
            wsp = 1;
        }
    });

    /* cierra cerrar_suscribete_blog  */
    $(document).on("click", ".cerrar_suscribete_blog", function (e) {
        $('.formulario_blog').addClass('hide');
    });


    /* cierra wspflota */
    $(document).on("click", ".cierra_wsp", function (e) {
        $('.wasap_flota').find('.lleva_contenido_wasap').addClass('hide');
    });



    var ancho_detalle_clase = $(window).width();
    if (ancho_detalle_clase > 600) { // no valido para movil 
        //enlaces internos con bd
        if ($('#perfil').find('.detalle_clase_aula').length) {//para al dar clik bajar al contenido en productos
            // $('body,html').animate({ scrollTop:$('.detalle_clase_aula').offset().top }, 300);
            $('body,html').animate({ scrollTop: $('.detalle_clase_aula').offset().top - 55 }, 300);
        }
    }





    // scroll hacia 
    $(".baja_hacia_a").click(function (e) {
        e.preventDefault();
        var href = $(this).attr('href');
        console.log(href);
        //$nroOffset = -35;
        $nroOffset = 0;
        if (href == '#registro_al_webinar_2') { $nroOffset = -90; }
        $('html,body').animate({ scrollTop: $(href).offset().top + $nroOffset }, 800);

    });

    // para video trailer en curso 
    $(".linea_trailer").on("click", function (e) {
        e.preventDefault();

        var el = $(this), div = el.attr('id').split('-'), id_video_trailer = div[1];//split divide separa por (-)
        console.log("click ver video trailer curso " + id_video_trailer);
        // alert(id_video_trailer);

        $('.linea_trailer').removeClass('activado');
        el.addClass("activado");
        /* video */
        $('.lleva_vimeo_listado').addClass('hide');
        $('.mostrar_traile_' + id_video_trailer).removeClass('hide');

    });


    // para temarios cursos detalle 
    $("._cerrar_mostrar_temario").on("click", function (e) {
        $('.mostrar_temario').removeClass("activado");
        $('.listado_temario').addClass('hide');
    });

    $(".mostrar_temario").on("click", function (e) {
        e.preventDefault();
        var el_elemento = $(this);
        console.log(el_elemento);

        var div = el_elemento.attr('id').split('-'),
            id_especialidad = div[1];
        console.log(div);
        console.log("click ver video trailer curso " + id_especialidad);

        $('.mostrar_temario').removeClass("activado");
        $('.listado_temario').addClass('hide');

        el_elemento.addClass("activado");
        $('.temario_' + id_especialidad).removeClass('hide');

    });



    // BACK TO TOP FUNCTION
    $(window).scroll(function () {
        if ($(this).scrollTop() > 900) {
            $('#back-top').fadeIn();
        } else {
            $('#back-top').fadeOut();
        }
    });
    // subir
    $('#back-top a').click(function () {
        $('body,html').animate({ scrollTop: 0 }, 500);
        return false;
    });
    // scroll body to 0px on click
    $('#goto a').click(function () {
        $('body,html').animate({ scrollTop: 600 }, 500);
        return false;
    });


    // scroll ventan opciones flotante ::: ::baja a curso dentro del mismo index
    $("._baja_a_index_cursos").click(function (e) {
        document.getElementById('ventana_emergente_opciones_acceso').style.display = "none";
        e.preventDefault();
        var href = $(this).attr('href');
        console.log(href);
        $nroOffset = -80;
        $('html,body').animate({ scrollTop: $(href).offset().top + $nroOffset }, 800);
    });


    // para temarios cursos detalle 
    $("._llamar_ventana_cargando").on("click", function (e) {
        $('._pantalla_cargando_inicio_al_examen').removeClass("hide");
    });



}); // en wins load

$(window).scroll(function () {
    posicionarMenu();  // header 
    _flota_formualrio_de_compra();  // header 

});

/*para submenu*/
var contador = 1;
function main() {
    var menu_bar = $('.menu_bar'), submenu = $('.submenu');
    menu_bar.find('a').on('click', function (e) { /*va a*/
        var contentwidth = $(window).width(), miMenu = $(this).parent().next();
        if (contentwidth <= 1200) {
            contador = (contador == 1) ? 0 : 1;
            miMenu.slideToggle();
            e.preventDefault();
        }
    });

    submenu.find('> a').on('click', function (e) {/*en find va el q contene el submenu */
        var contentwidth = $(window).width();
        if (contentwidth <= 1200) {
            var mysubmenu = $(this).parent();
            mychildren = mysubmenu.find('> .children');
            mysubmenu.parent().find('> li > .children').not(mychildren).css('display', 'none');
            if (mychildren.is(':visible')) $(this).find('.flecha').css('background-position', '0 0');
            else $(this).find('.flecha').css('background-position', '0 -5px');

            mychildren.slideToggle();
            e.preventDefault();
        }
    });

    /*
    $(window).on('mouseleave',function(){
        var contentwidth = $(window).width();
        if(contentwidth > 1200){
            submenu.find('.children').removeAttr('style');
            contador = 1;
            $('nav').removeAttr('style');
        }
    });
    */
}


// soll mumeros en input pc y movil 
jQuery(document).ready(function () {
    // Listen for the input event.
    jQuery("#telefono").on('input', function (evt) {
        // Allow only numbers.
        jQuery(this).val(jQuery(this).val().replace(/[^0-9]/g, ''));
    });

    /*  lo pasae a registrate_v2.js en evento de selecionar la bandera dle pais  */
    jQuery("#dni").on('input', function (evt) {
        // Allow only numbers.
        jQuery(this).val(jQuery(this).val().replace(/[^0-9]/g, ''));
    });

});





/** PARA REGISTRO V2: con reniec en peru y paises libres  */


/* __hola__*/
/*hover selec pais: Pra pc  */
var contentwidth = $(window).width();
// if(contentwidth > 1024){

if ($('#select-color').length) {
    let test = document.getElementById("select-color");

    if (contentwidth > 890) { // solo para pc
        test.addEventListener("mouseover", function (event) {
            // alert(contentwidth);
            $("#select-color").removeClass("ocultar_listado_paises");
            console.log(" remove ocultar_listado_paises ");
            // console.log("abir menu para seleccionaste un pais.."); 
        }, false);
    }

}

/* $(document).on('click','.option',function(){ */
$(document).on('click', '._selecciona_pais', function () {
    $("#select-color").addClass("ocultar_listado_paises");
    console.log(" addClass ocultar_listado_paises ");

    $("#select-color").css({
        height: "30px" // Ajusta esto según la necesidad, podría ser también 'auto' si eso sirve mejor

    });

    // alert("ocultar");
    console.log("okey seleccionaste un pais..");

    // para validar longuitus dl dni segun pais escojido 
    let id_pais;
    const radioButtons = document.querySelectorAll('input[name="id_pais"]');
    for (const radioButton of radioButtons) {
        if (radioButton.checked) {
            id_pais = radioButton.value;


            // quitamos atributos para agrgarlos mas abajo nuevamente y evotar error
            document.getElementById("dni").removeAttribute('maxLength');
            document.getElementById("dni").removeAttribute('minLength');

            if (id_pais == 1) {
                console.log(" seleciono peru, filtramos por dni .. ");

                jQuery("#dni").on('input', function (evt) { // dni solo numeros                                                 
                    jQuery(this).val(jQuery(this).val().replace(/[^0-9]/g, ''));
                });

                $('.btn_buscar_dni').removeClass('hide');
                document.getElementById("dni").minLength = 8; // limitados a 8
                document.getElementById("dni").maxLength = 8; // limitados a 8
                document.getElementById("field_client").disabled = true;

                // si e speru muestro esta opcion 
                //document.getElementById('id_especialidad').value="";            
                document.getElementById("id_especialidad").style.display = "block";
                $('select[name="id_especialidad"]').val('');
                var id_especialidad = $('select[name="id_especialidad"]').val();
                console.log('peru_' + id_especialidad);

                if ($('#id_tipo_cliente').lenght) {
                    document.getElementById('id_tipo_cliente').value = "";
                    document.getElementById("id_tipo_cliente").style.display = "block";
                }

            } else {
                console.log(" seleciono otro pais , ..  es extranhjero ");
                jQuery("#dni").on('input', function (evt) { // dni solo numeros                                                 
                    console.log(" dni acepta caracteres letras ..");
                    jQuery(this).val(jQuery(this).val().replace(/[A-Z]/g, '')); // no funciona x ahora , pero quizas a futuro deberianos desactivarlo y activar para letras y numjeros
                });

                $('.btn_buscar_dni').addClass('hide');
                document.getElementById("dni").minLength = 13; // limitados a 8
                document.getElementById("dni").maxLength = 13; // limitados a 8
                // document.getElementById('fecha_inicio').value="";
                document.getElementById("field_client").disabled = false; // libero para registro manual 

                // defino valor de especialidad : 13 que significa: sin_especialidad
                // document.getElementById('id_especialidad').value="13";
                document.getElementById("id_especialidad").style.display = "none";
                $('select[name="id_especialidad"]').val('13');
                var id_especialidad = $('select[name="id_especialidad"]').val();
                console.log('otropais_' + id_especialidad);


                if ($('#id_tipo_cliente').lenght) {
                    document.getElementById("id_tipo_cliente").style.display = "none";
                }


            }



            break;
        }
    }



});


//}



$('.consentimiento_no').on('click', function (e) { /*va a*/
    //document.getElementById("finalizar_portada_leads").disabled=true;
    $('#finalizar_portada_leads').addClass("opacity_05");
    $('#finalizar_portada_leads').addClass("no_drop");
});

$('.consentimiento_si').on('click', function (e) { /*va a*/
    //document.getElementById("finalizar_portada_leads").disabled=true;
    $('#finalizar_portada_leads').removeClass("opacity_05");
    $('#finalizar_portada_leads').removeClass("no_drop");
});





$(".dropdown img.flag").addClass("flagvisibility");
$(".dropdown dt a").click(function () {
    $(".dropdown dd ul").toggle();
});

$(".dropdown dd ul li a").click(function () {
    var text = $(this).html();


    let xyz = $(this).attr('id'); // saco valor 
    $('input[name="id_pais"]').val(xyz);
    let id_pais = $('input[name="id_pais"]').val();
    console.log('idpais::: ' + id_pais);

    /** validacion de js segun pais / */

    // quitamos atributos para agrgarlos mas abajo nuevamente y evotar error
    document.getElementById("dni").removeAttribute('maxLength');
    document.getElementById("dni").removeAttribute('minLength');

    if (id_pais == 1) {
        console.log(" seleciono peru, filtramos por dni .. ");

        jQuery("#dni").on('input', function (evt) { // dni solo numeros                                                 
            jQuery(this).val(jQuery(this).val().replace(/[^0-9]/g, ''));
        });

        $('.btn_buscar_dni').removeClass('hide');
        document.getElementById("dni").minLength = 8; // limitados a 8
        document.getElementById("dni").maxLength = 8; // limitados a 8

        // si e speru muestro esta opcion 
        //document.getElementById('id_especialidad').value="";            
        document.getElementById("id_especialidad").style.display = "block";
        $('select[name="id_especialidad"]').val('');
        var id_especialidad = $('select[name="id_especialidad"]').val();
        console.log('peru_' + id_especialidad);

        if ($('#id_tipo_cliente').lenght) {
            document.getElementById('id_tipo_cliente').value = "";
            document.getElementById("id_tipo_cliente").style.display = "block";
        }

    } else {
        console.log(" seleciono otro pais , ..  es extranhjero ");
        jQuery("#dni").on('input', function (evt) { // dni solo numeros                                                 
            console.log(" dni acepta caracteres letras ..");
            jQuery(this).val(jQuery(this).val().replace(/[A-Z]/g, '')); // no funciona x ahora , pero quizas a futuro deberianos desactivarlo y activar para letras y numjeros
        });

        $('.btn_buscar_dni').addClass('hide');
        document.getElementById("dni").minLength = 13; // limitados a 8
        document.getElementById("dni").maxLength = 13; // limitados a 8
        // document.getElementById('fecha_inicio').value="";
        document.getElementById("field_client").disabled = false; // libero para registro manual 

        // defino valor de especialidad : 13 que significa: sin_especialidad
        // document.getElementById('id_especialidad').value="13";
        document.getElementById("id_especialidad").style.display = "none";
        $('select[name="id_especialidad"]').val('13');
        var id_especialidad = $('select[name="id_especialidad"]').val();
        console.log('otropais_' + id_especialidad);


        if ($('#id_tipo_cliente').lenght) {
            document.getElementById("id_tipo_cliente").style.display = "none";
        }

    }


    $(".dropdown dt a span").html(text);
    $(".dropdown dd ul").hide();
});
$(document).bind('click', function (e) {
    var $clicked = $(e.target);
    if (!$clicked.parents().hasClass("dropdown"))
        $(".dropdown dd ul").hide();
});
$(".dropdown img.flag").toggleClass("flagvisibility");

