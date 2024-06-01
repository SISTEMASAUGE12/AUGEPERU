$(document).ready(function(){
    var customSlider = {item:1,speed:500,adaptiveHeight:true,slideMargin:0,auto:true,loop:true,pager:true,controls:false,pause:5000};


		var customSlider = {pager:false};
    if($('#carousel-3').length){
        var s3 = $('#carousel-3'), control_s3 = $('.callout').find('.clientes a');//encontrando las flechas 
        customSlider['item']          = 1;
				customSlider['controls']      = false;
        customSlider['pause']         = 8000;
        customSlider['onBeforeStart'] = function(){ s3.removeClass('hide'); };
        customSlider['responsive']    = [
            {breakpoint:1280,settings:{item:1,slideMargin:0}},
            {breakpoint:1150,settings:{item:1,slideMargin:0}},
            {breakpoint:800,settings:{item:1,slideMargin:0}}
        ];
        s3.lightSlider(customSlider);
				control_s3.on('click',function(){  var el = $(this); if(el.hasClass('lSPrev')){ s3.goToPrevSlide(); }else{ s3.goToNextSlide(); } });

    }

		if($('.carousel-5').length){
        var s55 = $('.carousel-5'), control_s55 = $('.callout').find('.clientes a');//encontrando las flechas 
        customSlider['item']          = 4;
				customSlider['controls']      = false;
        customSlider['pause']         = 8000;
        customSlider['onBeforeStart'] = function(){ s55.removeClass('hide'); };
        customSlider['responsive']    = [
            {breakpoint:1280,settings:{item:4,slideMargin:0}},
            {breakpoint:1050,settings:{item:4,slideMargin:0}},
            {breakpoint:900,settings:{item:3,slideMargin:0}},
            {breakpoint:700,settings:{item:2,slideMargin:0}},
            {breakpoint:600,settings:{item:1,slideMargin:0}}
        ];
        s55.lightSlider(customSlider);
				control_s55.on('click',function(){  var el = $(this); if(el.hasClass('lSPrev')){ s55.goToPrevSlide(); }else{ s55.goToNextSlide(); } });

    }
		
		
		var customSlider = {pager:true,controls:false};
		if($('#carousel-2').length){
        var s2 = $('#carousel-2'), control_s2 = s2.closest('.clientes').find('.lSAction a');
        customSlider['item']          = 3;
        customSlider['pause']         = 8000;
        customSlider['onBeforeStart'] = function(){ s2.removeClass('hide'); };
        customSlider['responsive']    = [
            {breakpoint:1280,settings:{item:3,slideMargin:0}},
            {breakpoint:1150,settings:{item:2,slideMargin:0}},
            {breakpoint:800,settings:{item:1,slideMargin:0}}
        ];
        s2.lightSlider(customSlider);
    }
		
  if($('#carousel-4').length){
        var s4 = $('#carousel-4'), control_s4 = s4.closest('.clientes').find('.lSAction a');
        customSlider['item']          = 5;
        customSlider['pause']         = 8000;
        customSlider['pager']         = false;
        customSlider['onBeforeStart'] = function(){ s4.removeClass('hide'); };
        customSlider['responsive']    = [
            {breakpoint:1280,settings:{item:5,slideMargin:0}},
            {breakpoint:1000,settings:{item:4,slideMargin:0}},
            {breakpoint:800,settings:{item:3,slideMargin:10}},
            {breakpoint:650,settings:{item:2,slideMargin:10}}
        ];
        s4.lightSlider(customSlider);
    }
		
		
    var customSlider = {slideMargin:20,pager:true,controls:false};
		if($('#carousel-para-4').length){
        var s_para4 = $('#carousel-para-4'), control_para4 = s_para4.closest('.clientes').find('.lSAction a');
        customSlider['item']          = 4;
        customSlider['pause']         = 8000;
        customSlider['onBeforeStart'] = function(){ s_para4.removeClass('hide'); };
        customSlider['responsive']    = [
            {breakpoint:1280,settings:{item:4,slideMargin:20}},
            {breakpoint:1050,settings:{item:3,slideMargin:15}},
            {breakpoint:800,settings:{item:2,slideMargin:15}},
            {breakpoint:500,settings:{item:1,slideMargin:0}}
        ];
        s_para4.lightSlider(customSlider);
    }
		
  
});



