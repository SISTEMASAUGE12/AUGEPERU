function TokyPopup(obj) {  
    console.log("init llamada toky..:  ");
    //this function only works for a elements, if you want to use another HTML element like button, you must change this code
    //change this code to get the proper atribute with the phone number.
    
    // var number=obj.innerText;
    var number=obj;
    console.log("init llamada toky..:  "+number);

        var title = 'Toky',w=300,h=500;
        var _options = 'scrollbars=no,resizable=no';
        url = 'https://app.toky.co/business/dialer#?call='+number;
        // Fixes dual-screen position Most browsers Firefox
        var dualScreenLeft = window.screenLeft != undefined ? window.screenLeft : screen.left;
        var dualScreenTop = window.screenTop != undefined ? window.screenTop : screen.top;
        width = window.innerWidth ? window.innerWidth : document.documentElement.clientWidth ? document.documentElement.clientWidth : screen.width;
        height = window.innerHeight ? window.innerHeight : document.documentElement.clientHeight ? document.documentElement.clientHeight : screen.height;

        var _left = ((width / 2) - (w / 2)) + dualScreenLeft;
        var _top = ((height / 2) - (h / 2)) + dualScreenTop;
        var newWindow = window.open(url, title, _options +', width=' + w + ', height=' + h + ', top=' + _top + ', left=' + _left);

        // Puts focus on the newWindow
        if (window.focus) newWindow.focus();
    return false;
    }


    