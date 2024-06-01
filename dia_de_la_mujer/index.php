<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <title ><?php echo isset($meta) ? $meta ['title'] : 'Accede a los mejores Cursos online para docentes | GRUPO AUGE '; ?></title>
  <link rel="shortcut icon" href="../favicon.png">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">
<link rel="stylesheet" href="style.css">

</head>
<body>

<svg class="root">
  <defs>
      <filter id="f" width="200" height="200" x="-100"  y="-100" >
       <feGaussianBlur in="SourceAlpha" stdDeviation="3" result="blur"></feGaussianBlur>
       <feFlood flood-color="rgb(60,10,60)" result="color"/>
       <feComposite in="color" in2="blur" operator="in" result="shadow" />
       <feOffset in="shadow" dx="3" dy="3" result="offset"></feOffset>
       <feMerge>
          <feMergeNode in="offset" />
          <feMergeNode in="SourceGraphic" />
      </feMerge>  
    </filter>
  <symbol id="petal2" viewBox = "0 -100 200 200"  >

  <path transform="translate(0,-100)" d="M25.91,-15.12 Q0,0 25.91,15.12L94.09,54.889 Q120,70 142.58,50.24L177.42,19.76 Q200,0 177.42,-19.756L142.58,-50.24 Q120,-70 94.087,-54.88Z"></path>
  </symbol>
    
  <symbol id="petal3"  viewBox = "0 -100 200 200" >

  <path transform="translate(0,-100)" d="M27.69,-11.54  Q0,0 27.69,11.54  L92.3,38.46  Q120,50 145.44,34.1 L174.56,15.9  Q200,0 174.56,-15.9 L145.44,-34.1 Q120,-50 92.3,-38.46Z" ></path>
   </symbol>
    
    <symbol id="petal4"  viewBox = "0 -100 200 200" >

<path transform="translate(0,-100)"  d="M28.09,-10.53 Q0,0 28.09,10.53L91.91,34.47 Q120,45 146.147,30.29L173.85,14.7 Q200,0 173.85,-14.7L146.15,-30.29 Q120,-45 91.91,-34.467Z"></path>
   </symbol>
      <symbol id="petal5"  viewBox = "0 -100 200 200" >

  <path transform="translate(0,-100)"   d="M28.85,-8.24 Q0,0 28.85,8.24L111.15,31.76 Q140,40 164.96,23.36L175.04,16.64 Q200,0 175.038,-16.64L164.96,-23.36 Q140,-40 111.15,-31.76Z"></path>
  </symbol>
  </defs>
</svg>

<svg viewBox="0 0 10000 10000" id="svg" preserveAspectRatio="xMidYMid slice">

</svg>
<!-- Texto en el centro -->
<div id="texto1">Feliz Día de la Mujer
    <img src="img/Logotipo Auge (1).png" alt="">
</div>
<div id="texto2">"Dónde hay una mujer, hay magia" <br>
  Hoy celebramos la fuerza, el coraje y la belleza <br> 
  de todas las mujeres alrededor del mundo.
</div>



  <script  src="script.js"></script>

</body>
</html>