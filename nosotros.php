<?php
$pagina = 'noso';
include('auten.php');
$meta = array(
	'title' => 'Quienes somos | Auge Perú: ',
	'description' => ''
);
include('inc/header.php');



$nosotros = executesql("SELECT * FROM nosotros", 0);
?>



<main id="nosotros">


	<div class="section_nos_1">
		<img src="img/nosotros/Recurso 33.jpg" alt="" class="pc_image">
		<img src="img/nosotros/IMG_portada_600x800.jpg" alt="" class="mobil_image"> 
	</div>


	


	<div class="container">
		<div class="section_nos_2 ">
			<h1 class="text-center">NUESTRA HISTORIA</h1>
    <p class="sliding-text">Este texto se deslizará de izquierda a derecha</p>

			<p class="text-center">El Grupo AUGE se fundó el 6 de marzo de 2007 por estudiantes de la Universidad Nacional Pedro Ruiz Gallo en Lambayeque. Originalmente enfocados en ofrecer capacitaciones a funcionarios públicos y
				profesionales en diversos formatos, pronto se especializaron en la formación de docentes del magisterio peruano, encontrando ahí su verdadera vocación. A lo largo de casi dos décadas, han impactado la
				vida de 53 000 docentes, ayudándoles a progresar profesionalmente y a mejorar su calidad de vida.</p>
		</div>
	</div>

	<div class="container">
		<button class="arrow-left" onclick="prevSlide()"><img src="img/nosotros/icono volteao siqsi@72x.webp" alt=""></button>
		<div class="section_nos_3">
			<div class="timeline-container">
				<div class="timeline">
					<div class="slides">
						<div class="slide" id="slide-2005">
							<div class="_section_slide_img">
								<img src="img/nosotros/2005_600x370.jpg" alt="">
							</div>
							<div class="_section_slide_text ">
								<h2>2005</h2>
								<p>Fundación inicial centrada en educación, ofreciendo clases de reforzamiento escolar a estudiantes que lo requerían.</p>
							</div>
						</div>
						<div class="slide" id="slide-2006">
							<div class="_section_slide_img">
								<img src="img/nosotros/2006_600x370.jpg" alt="">
							</div>
							<div class="_section_slide_text">
								<h2>2006</h2>
								<p> Creación de la "Asociación de Universitarios de Gestión Emprendedora" por un grupo de 11 estudiantes universitarios. Esta asociación se enfocaba en el apoyo académico a universitarios.</p>
							</div>
						</div>
						<div class="slide" id="slide-2007">
							<div class="_section_slide_img">
								<img src="img/nosotros/2007_600x370.jpg" alt="">
							</div>
							<div class="_section_slide_text">
								<h2>2007</h2>
								<p>Establecimiento de AUGE como entidad dedicada a la capacitación docente.</p>
							</div>
						</div>
						<div class="slide" id="slide-2009">
							<div class="_section_slide_img">
								<img src="img/nosotros/2008_600x370.jpg" alt="">
							</div>
							<div class="_section_slide_text">
								<h2>2009</h2>
								<p>Transformación en una Asociación Civil sin fines de lucro, caracterizada por tener más egresos que ingresos, reafirmando nuestro compromiso con la educación sobre el beneficio económico.</p>
							</div>
						</div>

						<div class="slide" id="slide-2015">
							<div class="_section_slide_img ">
								<img src="img/nosotros/2009_600x370.jpg" alt="">
							</div>
							<div class="_section_slide_text">
								<h2>2015</h2>
								<p>Ronald Avellaneda toma la dirección de AUGE, reformándola como empresa privada para mejorar la gestión y la estructura organizacional.</p>
							</div>
						</div>
						<div class="slide" id="slide-2020">
							<div class="_section_slide_img">
								<img src="img/nosotros/2015_600x370.jpg" alt="">
							</div>
							<div class="_section_slide_text">
								<h2>2020</h2>
								<p>Durante la pandemia, Grupo Auge apoyó a docentes en su preparación para obtener nombramientos, viendo un aumento en su popularidad al ofrecer capacitación remota, facilitando así el aprendizaje y el progreso profesional desde casa.</p>
							</div>
						</div>
						<div class="slide" id="slide-2024">
							<div class="_section_slide_img">
								<img src="img/nosotros/2024_600x370.jpg" alt="">
							</div>
							<div class="_section_slide_text">
								<h2>2024</h2>
								<p>Con 17 años de experiencia capacitando profesionales, nos destacamos como líderes en el sector. Hemos sido el catalizador del éxito de numerosos docentes capacitados con nosotros, ayudándoles a alcanzar sus metas y hacer realidad sus sueños.</p>
							</div>
						</div>
					</div>
				</div>
				<div class="timeline-indicators">
					<div class="indicator" onclick="goToSlide(0)">
						<div class="dot"></div>
						<div class="label">2005</div>
					</div>
					<div class="indicator" onclick="goToSlide(1)">
						<div class="dot"></div>
						<div class="label">2006</div>
					</div>
					<div class="indicator" onclick="goToSlide(2)">
						<div class="dot"></div>
						<div class="label">2007</div>
					</div>
					<div class="indicator" onclick="goToSlide(3)">
						<div class="dot"></div>
						<div class="label">2009</div>
					</div>
					<div class="indicator" onclick="goToSlide(4)">
						<div class="dot"></div>
						<div class="label">2015</div>
					</div>
					<div class="indicator" onclick="goToSlide(5)">
						<div class="dot"></div>
						<div class="label">2020</div>
					</div>
					<div class="indicator" onclick="goToSlide(6)">
						<div class="dot"></div>
						<div class="label">2024</div>
					</div>

				</div>
			</div>
		</div>
		<button class="arrow-right" onclick="nextSlide()"><img src="img/nosotros/icono_50x50.webp" alt=""></button>
	</div>

	<div class="container">
		<div class="section_nos_4">
			<img src="img/nosotros/imgproposito_1400x444.jpg" alt="">
		</div>
	</div>

	<div class="container">
		<div class="section_nos_5">
			<div class="section_nos_51 medium-4">
				<h1>Nuestro propósito</h1>

			</div>
			<div class="section_nos_52 medium-8">
				<h5>Capacitar a docentes latinoamericanos en pedagogía y tecnología para transformar la
					educación, promoviendo entornos inclusivos y creativos. Fomentar la colaboración e
					innovación a través de programas de calidad para preparar líderes educativos capaces
					de enfrentar futuros desafíos.</h5>
			</div>
		</div>
	</div>

	<div class="container" style="background-image: url('img/nosotros/fondorojo_1920x495.webp');
            background-size: cover; 
            background-position: center;
            background-repeat: no-repeat; 
            width: 100%; ">
		<div class="section_nos_6">
			<div class="section_nos_61 medium-6">
				<h1> Nuestra <br> misión</h1>
				<h5>Liderar el cambio educativo en Latinoamérica, promoviendo la creatividad en el aula y apoyando a maestros para alcanzar altos estándares de enseñanza.</h5>
			</div>
			<div class="section_nos_62 medium-6">
				<img src="img/nosotros/imgmision_700x430.jpg" alt="">
			</div>
		</div>
	</div>

	<div class="container" style="background-color: #d3d3d3;">
		<div class="section_nos_7">
			<div class="section_nos_72 medium-6">
				<img src="img/nosotros/imgvision_700x430.jpg" alt="">
			</div>
			<div class="section_nos_71 medium-6">
				<h1> Nuestra <br> Visión</h1>
				<h5>Brindar educación de excelencia a docentes mediante
					prácticas innovadoras y desarrollo profesional. Ofrecer
					programas de capacitación, recursos actualizados y
					colaboración para mejorar la educación en Latinoamérica.</h5>
			</div>
		</div>
	</div>

	<div class="container">
		<div class="section_nos_8">
			<h1>GRUPO AUGE</h1>
			<h2>en cifras</h2>
		</div>
	</div>

	<div class="container">
		<div class="section_nos_9 ">
			<div class="section_nos_91">
				<img src="img/nosotros/icono1_90x90.webp" alt="">
				<div class="section_nos_91_text">
					<h1 class="counter" data-count="56000">0</h1>
					<h5>docentes eligieron capacitarse con nosotros</h5>
				</div>
			</div>
			<div class="section_nos_91">
				<img src="img/nosotros/icono2_90x90.webp" alt="">
				<div class="section_nos_91_text">
					<h1 class="counter" data-count="53000">0</h1>
					<h5>lograron su objetivo profesional</h5>
				</div>
			</div>
			<div class="section_nos_91">
				<img src="img/nosotros/icono3_90x90.webp" alt="">
				<div class="section_nos_91_text">
					<h1 class="counter percent-counter" data-count="95">0%</h1>
					<h5>de efectividad en nuestras capacitaciones</h5>
				</div>
			</div>
			<div class="section_nos_91">
				<img src="img/nosotros/icono4_90x90.webp" alt="">
				<div class="section_nos_91_text">
					<h1 class="counter" data-count="950">0</h1>
					<h5>cursos</h5>
				</div>
			</div>
			<div class="section_nos_91">
				<img src="img/nosotros/icono5_90x90.webp" alt="">
				<div class="section_nos_91_text">
					<h1 class="counter" data-count="304010">0</h1>
					<h5>seguidores en redes sociales</h5>
				</div>
			</div>
		</div>
	</div>


	<div class="container" style="background-color: #d3d3d3;">
		<div class="section_nos_10">
			<h1>Nuestros objetivos</h1>
		</div>
	</div>

	<div class="container" style="background-color: #d3d3d3;">
		<div class="section_nos_11">
			<div class="section_nos_111 medium-6">
				<ul class="accordion" data-accordion>
					<li class="accordion-item" data-accordion-item>
						<a href="#" class="accordion-title">Proporcionar diplomados y curso especializados</a>
						<div class="accordion-content" data-tab-content>
							<p>Ofrecemos programas diseñados para mejorar las habilidades pedagógicas, didácticas y tecnológicas de los docentes en Latinoamérica.</p>
						</div>
					</li>
					<li class="accordion-item" data-accordion-item>
						<a href="#" class="accordion-title">Establecer alianzas estratégicas</a>
						<div class="accordion-content" data-tab-content>
							<p>Creamos vínculos con instituciones educativas, organismos gubernamentales y empresas para ampliar nuestro impacto en la región.</p>
						</div>
					</li>
					<li class="accordion-item" data-accordion-item>
						<a href="#" class="accordion-title">Implementar plataformas de aprendizaje</a>
						<div class="accordion-content" data-tab-content>
							<p>Brindamos acceso flexible a nuestros programas a través de plataformas de aprendizaje en línea.</p>
						</div>
					</li>
					<li class="accordion-item" data-accordion-item>
						<a href="#" class="accordion-title">Evaluar continuamente la efectividad</a>
						<div class="accordion-content" data-tab-content>
							<p>Evaluamos constantemente nuestros programas y servicios para garantizar su eficacia, utilizando la retroalimentación de los participantes y los resultados académicos de los estudiantes.</p>
						</div>
					</li>
					<li class="accordion-item" data-accordion-item>
						<a href="#" class="accordion-title">Fomentar una comunidad de aprendizaje</a>
						<div class="accordion-content" data-tab-content>
							<p>Creamos un espacio colaborativo donde los docentes comparten recursos y experiencias para enriquecer su desarrollo profesional.</p>
						</div>
					</li>
				</ul>
			</div>
			<div class="section_nos_112 medium-6">
				<img src="img/nosotros/imgobjetivos_640x470.jpg" alt="">
			</div>
		</div>
	</div>

	<div class="container" style="background-color: #d3d3d3;">
		<div class="section_nos_10">
			<h1>Nuestros Valores</h1>
		</div>
	</div>

	<div class="container" style="background-color: #d3d3d3;">
		<div class="section_nos_12">
			<div class="section_nos_122 medium-6">
				<img src="img/nosotros/imgvalores_640x470.jpg" alt="">
			</div>
			<div class="section_nos_121 medium-6">
				<ul class="accordion" data-accordion>
					<li class="accordion-item" data-accordion-item>
						<a href="#" class="accordion-title">Empoderamiento</a>
						<div class="accordion-content" data-tab-content>
							<p>Capacitar a los docentes para que se conviertan en agentes de cambio en sus aulas y comunidades, proporcionándoles las herramientas y el conocimiento para liderar e innovar.</p>
						</div>
					</li>
					<li class="accordion-item" data-accordion-item>
						<a href="#" class="accordion-title">Excelencia</a>
						<div class="accordion-content" data-tab-content>
							<p>Compromiso con la calidad superior en la educación, buscando constantemente mejorar y alcanzar los más altos estándares en todas las actividades de formación docente.</p>
						</div>
					</li>
					<li class="accordion-item" data-accordion-item>
						<a href="#" class="accordion-title">Innovación</a>
						<div class="accordion-content" data-tab-content>
							<p>Fomentar la creatividad y la adopción de nuevas metodologías y tecnologías pedagógicas que enriquezcan el aprendizaje y enseñanza.</p>
						</div>
					</li>
					<li class="accordion-item" data-accordion-item>
						<a href="#" class="accordion-title">Responsabilidad</a>
						<div class="accordion-content" data-tab-content>
							<p>Mantener un compromiso firme con los objetivos educativos de mejorar la calidad de la educación en Latinoamérica, siendo responsables ante nuestros docentes, estudiantes y la sociedad.</p>
						</div>
					</li>
					<li class="accordion-item" data-accordion-item>
						<a href="#" class="accordion-title">Honestidad</a>
						<div class="accordion-content" data-tab-content>
							<p>Promovemos la transparencia y la integridad, asegurando que cada docente que adquiere nuestros cursos reciba información clara y precisa sobre los contenidos, objetivos y beneficios.</p>
						</div>
					</li>
				</ul>
			</div>
		</div>
	</div>

	<div class="container" style="background-color: #d3d3d3;">
		<div class="section_nos_13">
			<img src="img/nosotros/augito_295x265.webp" alt="" class="imagefinal">
			<button class="btn131">Conoce nuestra cultura organizacional</button>
			<button class="btn132"><img src="img/nosotros/flecha_50x50.webp" alt=""></button>
		</div>
	</div>










</main>


<script>
	let currentSlide = 0;
	const slides = document.querySelector('.slides');
	const indicators = document.querySelectorAll('.indicator');

	function showSlide(index) {
		const width = document.querySelector('.slide').clientWidth;
		slides.style.transform = `translateX(${-width * index}px)`;
		indicators.forEach((indicator, i) => {
			indicator.classList.toggle('active', i === index);
		});
		updateButtons();
	}

	function nextSlide() {
		if (currentSlide < indicators.length - 1) {
			currentSlide++;
			showSlide(currentSlide);
		}
	}

	function prevSlide() {
		if (currentSlide > 0) {
			currentSlide--;
			showSlide(currentSlide);
		}
	}

	function goToSlide(index) {
		currentSlide = index;
		showSlide(currentSlide);
	}

	function updateButtons() {
		const prevButton = document.querySelector('.arrow-left');
		const nextButton = document.querySelector('.arrow-right');

		if (currentSlide === 0) {
			prevButton.style.visibility = 'hidden';
		} else {
			prevButton.style.visibility = 'visible';
		}

		if (currentSlide === indicators.length - 1) {
			nextButton.style.visibility = 'hidden';
		} else {
			nextButton.style.visibility = 'visible';
		}
	}

	showSlide(currentSlide);

	window.addEventListener('resize', () => {
		showSlide(currentSlide);
	});
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  $(document).ready(function() {
    function isElementInViewport(el) {
      var rect = el.getBoundingClientRect();
      return (
        rect.top >= 0 &&
        rect.left >= 0 &&
        rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
        rect.right <= (window.innerWidth || document.documentElement.clientWidth)
      );
    }

	function animateCounter($el, endValue) {
        var isPercent = $el.hasClass('percent-counter');
        $el.prop('Counter', 0).animate({
          Counter: endValue
        }, {
          duration: 2000,
          easing: 'swing',
          step: function(now) {
            if (isPercent) {
              $el.text('+' + Math.ceil(now) + '%');
            } else {
              $el.text('+' + Math.ceil(now));
            }
          },
          complete: function() {
            if (isPercent) {
              $el.text('+'+endValue + '%');
            } else {
              $el.text('+' + endValue);
            }
          }
        });
      }

    function checkCounters() {
      $('.counter').each(function() {
        var $this = $(this);
        if (isElementInViewport(this) && !$this.hasClass('counted')) {
          $this.addClass('counted');
          var endValue = parseInt($this.attr('data-count'));
          animateCounter($this, endValue);
        }
      });
    }

    $(window).on('scroll', checkCounters);
    $(window).on('resize', checkCounters);
    checkCounters();
  });
</script>





<?php include('inc/footer.php'); ?>