
<?php 


// $valB = "979428614";
$valB = $cel_mensaje_texto;

//enviamos mensaje de texto al celular
   if(isset($valB) && !empty($valB)){
	$number_to_send = (int) preg_replace("/[^0-9]/","",$valB);
    if(is_numeric($number_to_send))
    {
      $fp = fsockopen('api.mensajesonline.pe', 80, $errno, $errstr, 30);
      if(!$fp)
      {
        // echo "$errstr ($errno)<br />\n";
      } 
      else
      {
        // $data_to_send = "app=webservices&u=ramjta125@hotmail.com&p=Aug32016&to=".$number_to_send.
        // "&msg=Grupo Auge,Te%20comunica%20que%20te%20acabamos%20de%20dar%20acceso%20al%20curso%20que%20te%20inscribistes.Para%20mas%20informacion:
        //   %20WhatsApp:957668571%20WWW.Educaauge.com";

          $data_to_send = "app=webservices&u=ramjta125@hotmail.com&p=Aug32016&to=".$number_to_send.
        "&msg=Grupo%20Auge%20te%20dio%20acceso%20al%20curso%20en%20el%20que%20te%20inscribiste.%20Únete%20al%20Zoom%20de%20atención%20al%20cliente%20para%20resolver%20tus%20dudas:%20 https://us06web.zoom.us/j/81706034568";
        $out  = "GET /sendsms?".$data_to_send." HTTP/1.1\r\n";
        $out .= "Host: api.mensajesonline.pe\r\n";
        $out .= "Connection: Close\r\n\r\n";
        fwrite($fp, $out);
        while(!feof($fp)) fgets($fp, 128);
        fclose($fp);
      }
    }
  }
   //fin enviamos mensaje de texto al celular

   ?>