<?php
include "inc/header.php"
?>
<div class="section1 grid-x">
    <div class="section11 cell small-12 medium-5">
        <h1 class="text-center"><b>¿Están listos para su <br> desarrollo docente?</b></h1>
        <!-- <h2 class="text-center">PARA PROFESIONALES DE ENFERMERIA</h2> -->
    </div>
    <div class="section11A cell small-12 medium-1">
        <!-- <img src="img/reloj conteo 50x50.png" alt="">
        <h2>FALTAN</h2> -->
        <img src="img/flechas encabezado_70x56.webp" alt="">
    </div>
    <div class="section11 cell small-12 medium-6">
        <h2 class="text-center"><b>Participa en nuestro examen gratuito de becas y</b></h2>
        <h2 class="text-center">lleva tus habilidades al siguiente nivel</h2>
    </div>
</div>

<div class="section2">
    <!-- Solo visible en dispositivos no móviles -->
    <div class="imagenSection21">
        <img src="img/fondo video_pc_1920x900.jpg" alt="Imagen de fondo">
    </div>
    <!-- Visible solo en móviles -->
    <div class="imagenSection22">
        <img src="img/fondo movil_600x1000.webp" alt="Imagen de fondo">
    </div>
    <div class="Section23 grid-x">
        <!-- División de Section23 en dos partes -->
        <div class="cell small-12 medium-6 ancho">
            <div class="section23A">
                
                <div class="section23A1">
                <h1 class="text-center">Regístrate y gana una de las 3 BECAS DISPONIBLES</h1>
                    <div style="padding:56.25% 0 0 0;position:relative; overflow:hidden; border-radius:20px;">
                        <iframe src="https://player.vimeo.com/video/947543182?badge=0&autopause=1&autoplay=1&muted=1&loop=1&player_id=0&app_id=58479" frameborder="0" allow="autoplay; fullscreen; picture-in-picture; clipboard-write" style="position:absolute;top:0;left:0;width:100%;height:100%;"></iframe>
                        <button id="soundButton" style="position:absolute; top:20px; right:20px; z-index:10; background-color: rgba(255, 255, 255, 0.7); color: #000; padding: 10px 20px; border: none; cursor: pointer; border-radius: 20px;">Encender sonido</button>
                    </div>
                    <!-- <h2>El arte de documentar con precisión y profesionalismo</h2> -->
                    <script src="https://player.vimeo.com/api/player.js"></script>
                </div>
            </div>
        </div>
        <div class="cell small-12 medium-6 ancho" style="display: flex; justify-content: center; align-items: center; flex-direction: column; ">
            <div class="section23B">
                <div class="section23B1" id="sectionregistro">
                    <!-- <h2>ADQUIERE TU LIBRO</h2> -->
                    <h1 class="text-center">¡ES TU MOMENTO DE BRILLAR!</h1>
                    <form action="../btn_registro_de_webinars_beca.php" class="form-1"  method="post">
                        <input type="text" id="nombre" name="nombre" placeholder="Nombre*" class="entrada">
                        <input type="tel" id="phone" name="phone" placeholder="Número*" class="entrada" maxlength="9" minlength="9" pattern="\d{9}">
                        <input type="email" id="email" name="email" placeholder="Email*" class="entrada">
                        <select id="tipo" name="tipo" class="entrada">
                            <option value="" disabled selected>Selecciona tu condición laboral*</option>
                            <option value="nombrado">Nombrado</option>
                            <option value="contratado">Contratado</option>
                        </select>

                        <input type="hidden" name="action" value="registro">

                        <button>REGÍSTRATE AHORA</button>

                    </form>
                    <img src="img/logo auge 352x120.webp" alt="">
                </div>
                <!-- <div class="section23B2">
                    
                </div> -->
            </div>
        </div>
    </div>
</div>


<div class="section3 text-center">
    <h1>Te mostramos por qué debes participar</h1>
</div>

<div class="grid-container">
    <div class="section55">
        <div class="grid-x">
            <div class="section51 cell small-12 medium-6 ancho">
                <ul class="listaicon">
                    <li>Con nuestra capacitación, lograrás potenciar tus conocimientos y habilidades pedagógicas como docente.</li>
                    <li>Estarás más cerca de tu estabilidad laboral y financiera.</li>
                    <li>Y lo más importante: Tendrás un ahorro directo de s/. 1000 soles, el equivalente al costo de los 4 módulos de capacitación.</li>

                </ul>
            </div>
            <div class="section51 cell small-12 medium-6 section51img ancho">
                <img src="img/imagen maviel_700x391.png" alt="prueba">
            </div>
        </div>
    </div>
</div>

<div class="section3 text-center">
    <h1>¿Qué tan increíble es ganarme una beca con Grupo Auge? </h1>
</div>

<div class="Section233">
    <div class="grid-container">
        <div class="section4">
            <div class="section4titu">
                <h5 class="text-center">Como ganador de una de nuestras becas, tendrás acceso a una experiencia de aprendizaje única y enriquecedora. Disfrutarás de:</h5>
            </div>
            <div class="grid-x grid-margin-x section441">

                <div class="section41 cell small-12 medium-4 card" style="background-image: url('img/recuadro\ rojo_418x428.webp'); background-size: cover; background-position: center; background-color: transparent;">
                    <img src="img/icono1.webp" alt="">
                    <h5 class="text-center">4 módulos gratuitos:</h5>
                    <p class="text-center">Personaliza tu formación de acuerdo a tus intereses y necesidades.</p>
                </div>

                <div class="section41 cell small-12 medium-4 card" style="background-image: url('img/recuadro\ plomo_418x428.webp'); background-size: cover; background-position: center; background-color: transparent;">
                    <img src="img/icono2.webp" alt="">
                    <h5 class="text-center">Clases los 7 días de la semana:</h5>
                    <p class="text-center">Capacitación intensiva hasta un día antes del examen.</p>
                </div>
                <div class="section41 cell small-12 medium-4 card" style="background-image: url('img/recuadro\ rojo_418x428.webp'); background-size: cover; background-position: center; background-color: transparent;">
                    <img src="img/icono3.webp" alt="">
                    <h5 class="text-center">Plataforma innovadora:</h5>
                    <p class="text-center">Accede a clases en vivo y grabadas para capacitarte segun tu ritmo.</p>
                </div>

                <div class="section41 cell small-12 medium-4 card" style="background-image: url('img/recuadro\ plomo_418x428.webp'); background-size: cover; background-position: center; background-color: transparent;">
                    <img src="img/icono4.webp" alt="">
                    <h5 class="text-center">Profesores altamente capacitados:</h5>
                    <p class="text-center">Aprende de expertos en cada área de estudio.</p>
                </div>
                <div class="section41 cell small-12 medium-4 card" style="background-image: url('img/recuadro\ rojo_418x428.webp'); background-size: cover; background-position: center; background-color: transparent;">
                    <img src="img/icono5.webp" alt="">
                    <h5 class="text-center">3 días de especialidad:</h5>
                    <p class="text-center">Sumérgete en temas específicos para potenciar tu desarrollo profesional.</p>
                </div>

                <div class="section41 cell small-12 medium-4 card" style="background-image: url('img/recuadro\ plomo_418x428.webp'); background-size: cover; background-position: center; background-color: transparent;">
                    <img src="img/icono6.webp" alt="">
                    <h5 class="text-center">Material pedagógico de calidad:</h5>
                    <p class="text-center">Recibe recursos adicionales para enriquecer tu experiencia de aprendizaje.</p>
                </div>
            </div>
            <div class="section4titu">
                <img src="" alt="">
                <h2 class="text-center">Comienza el viaje hacia tu éxito educativo</h2>
            </div>
            <div class="section42 grid-x grid-padding-x text-center">
                <div class="cell small-12 medium-6 section42A">
                    <img src="img/logo auge 352x120.webp" alt="">
                </div>
                <div class="cell small-12 medium-6 section42A">
                    <button onclick="scrollToRegistro()">REGÍSTRATE AHORA</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function scrollToRegistro() {
    // Obtenemos la sección de registro por su ID
    var seccionRegistro = document.getElementById('sectionregistro');
    // Desplazamos la página hacia la sección de registro con un efecto suave
    seccionRegistro.scrollIntoView({ behavior: 'smooth', block: 'start' });
}
</script>

<?php
include "inc/footer.php"
?>


</body>

</html>