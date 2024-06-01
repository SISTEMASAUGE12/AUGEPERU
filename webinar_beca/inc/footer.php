<div class="section9">
    <!-- <h5 class="text-center">Conferencia "Importancia de las Anotaciones en Enfermería"</h5> -->
    <p>TODOS LOS DERECHOS RESERVADOS</p>
    <div class="footerLanding">
        <a href="https://www.educaauge.com/politicas-de-datos-y-seguridad">Aviso de privacidad</a>
        <a href="https://www.educaauge.com/politicas-de-privacidad">Términos y Condiciones</a>
    </div>

</div>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script>
    function updateCountdown() {
        const endDate = new Date("2024-04-01:20:00").getTime();
        const now = new Date().getTime();
        const difference = endDate - now;

        // Calculando días, horas, minutos y segundos
        const days = Math.floor(difference / (1000 * 60 * 60 * 24));
        const hours = Math.floor((difference % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const minutes = Math.floor((difference % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((difference % (1000 * 60)) / 1000);

        // Actualizando el HTML
        document.getElementById("days").innerText = days;
        document.getElementById("hours").innerText = hours;
        document.getElementById("minutes").innerText = minutes;
        document.getElementById("seconds").innerText = seconds;

        // Si la cuenta regresiva termina, puedes mostrar un mensaje
        if (difference < 0) {
            clearInterval(intervalId);
            document.getElementById("days").innerText = "00";
            document.getElementById("hours").innerText = "00";
            document.getElementById("minutes").innerText = "00";
            document.getElementById("seconds").innerText = "00";
            // Aquí puedes agregar cualquier acción o mensaje que quieras mostrar cuando la cuenta regresiva termine.
        }
    }

    // Actualizar la cuenta regresiva cada segundo
    const intervalId = setInterval(updateCountdown, 1000);

    var iframe = document.querySelector('iframe');
    var player = new Vimeo.Player(iframe);
    var soundButton = document.getElementById('soundButton');

    soundButton.addEventListener('click', function() {
        player.setVolume(1).then(function() {
            // El volumen se activó
            soundButton.style.display = 'none'; // Oculta el botón después de activar el sonido
        });
    });
</script>

<!-- <script src="./build/js/intlTelInput.js"></script>
<script>
    var input = document.querySelector("#phone");
    window.intlTelInput(input, {
        onlyCountries: ["pe", "ar", "bo", "br", "cl", "co", "cr", "cu", "ec", "gt", "hn", "mx", "ni", "pa", "py", "pr", "sv", "uy", "ve", "es"],
        preferredCountries: ['pe'], // Perú será el primero en la lista
        utilsScript: "./build/js/utils.js" // Opcional, para formato y validación de números
    });
</script> -->

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>