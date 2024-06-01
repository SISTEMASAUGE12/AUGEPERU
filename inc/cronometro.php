
					 <?php
								/* fecha limite de la oferta */
								$fecha_actual = strtotime(date("d-m-Y"));
								$fecha_inicio = strtotime($webinars[0]["fecha_inicio"]);

                    if($fecha_actual <= $fecha_inicio){
											$existe_sesion=(isset($_SESSION["webinar"]["rewrite"]) && !empty($_SESSION["webinar"]["rewrite"]) )?$_SESSION["webinar"]["rewrite"]:'';
                ?>
							<div  class="callout poppi lleva_cronometro"><div  class="row "><div  class="large-12 columns  ">

                    <div  class="blanco  text-center ">
											<h4 class="poppi-sb ">El webinar empieza pronto en <?php  //echo $webinars[0]["fecha_inicio"].' -- '.$webinars[0]["hora_inicio"]; ?> </h4>
											<div id="countdown" ></div>
										</div>
										
                    <script>
                    // var end = new Date('<?php echo $webinars[0]["fecha_inicio"] ?> 11:59 PM');
                    var end = new Date('<?php echo $webinars[0]["fecha_inicio"] ?> <?php echo $webinars[0]["hora_inicio"] ?> ');
										
										var sesion= '<?php echo $existe_sesion ?>';
										
                    var _second = 1000;
                    var _minute = _second * 60;
                    var _hour = _minute * 60;
                    var _day = _hour * 24;
                    var timer;

                    function showRemaining() {
                        var now = new Date();
                        var distance = end - now;
                        if(distance < 0){
                            clearInterval(timer);
														
														// alert('www-> '+sesion);
														
														if( sesion != ''){ // si existe session rediregimos automaticamnte 
																document.getElementById('countdown').innerHTML = 'Empezamos el Webinar !';
																setTimeout(function () {
																	location.reload();
																}, 2200); //msj desparece en 5seg.																
															
														}else{ // si no existe alguna sesion
																document.getElementById('countdown').innerHTML = 'Hola ya estamos en directo, registrate ahora. Te esperamos!';																													
														}
														
													return;
                        }
                        var days = Math.floor(distance / _day);
                        var hours = Math.floor((distance % _day) / _hour);
                        var minutes = Math.floor((distance % _hour) / _minute);
                        var seconds = Math.floor((distance % _minute) / _second);
												
												// alert(days);
												
												let namedias=" xx ";
												if(days === 1){ // si termina en 1 día basta con mostrar solo las horas pendientes.
													 namedias=" Día ";
												}else{ // si es mayor a 1 día
													 namedias= " Días ";
												}
												
                        // document.getElementById('countdown').innerHTML = '<div class="dias">'+namedias+'</div>';
                        // document.getElementById('countdown').innerHTML += '<div class="dias">'hours + 'h :';
                        // document.getElementById('countdown').innerHTML += '<div class="dias">'minutes + 'm :';
                        // document.getElementById('countdown').innerHTML += '<div class="dias">'seconds + '';

												document.getElementById('countdown').innerHTML = '<div class="lleva_hora n_dias">'+ zfill(days,2)+' '+'<span>'+namedias+'</span></div>';
                        document.getElementById('countdown').innerHTML += '<div class="lleva_hora n_horas">'+ zfill(hours,2) + '<span>'+'Horas</span> </div>';
                        document.getElementById('countdown').innerHTML += '<div class="lleva_hora n_minus">'+ zfill(minutes,2) + '<span>'+'Minutos</span> </div>';
                        document.getElementById('countdown').innerHTML += '<div class="lleva_hora n_secon">'+ zfill(seconds,2) +'<span>'+ 'Segundos</span> </div> ';
                    }

                    timer = setInterval(showRemaining, 1000);
										
										
										
										
										function zfill(number, width) {
												var numberOutput = Math.abs(number); /* Valor absoluto del número */
												var length = number.toString().length; /* Largo del número */ 
												var zero = "0"; /* String de cero */  
												
												if (width <= length) {
														if (number < 0) {
																 return ("-" + numberOutput.toString()); 
														} else {
																 return numberOutput.toString(); 
														}
												} else {
														if (number < 0) {
																return ("-" + (zero.repeat(width - length)) + numberOutput.toString()); 
														} else {
																return ((zero.repeat(width - length)) + numberOutput.toString()); 
														}
												}
										}

										
                    </script>
                <?php
                    }
                ?>
					</div></div></div> <!-- END CALLOUT CREONOMETRO -->		