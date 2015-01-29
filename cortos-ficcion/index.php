<!DOCTYPE html>
<html>
<head>
	<script type="text/javascript" src="//www.rtve.es/js/mushrooms/rtve_mushroom.js" ></script>

	<meta charset="utf-8">
	<meta itemprop="name" content="10 años del tsunami en el Índico - Lab RTVE.es">
	<meta itemprop="description" content="Especial interactivo de RTVE.es al cumplirse los 10 años del tsunami en el océano Índico, que acabó con la vida de más de 230.000 personas.">
	<meta itemprop="og:description" content="Especial interactivo de RTVE.es al cumplirse los 10 años del tsunami en el océano Índico, que acabó con la vida de más de 230.000 personas.">
	<meta name="description" content="Especial interactivo de RTVE.es al cumplirse los 10 años del tsunami en el océano Índico, que acabó con la vida de más de 230.000 personas.">
	<meta name="keywords" content="Tsunami, Terremoto, maremoto, 26 de diciembre de 2004, Indonesia, Océano Índico, Tailandia, Sri Lanka, India, Malasia, Maldivas, Somalia, muertos, vídeos, fotos, Almudena Ariza, Érika Reija">
	<meta name="twitter:title" content="10 años del tsunami en el Índico - Lab RTVE.es">
	<meta name="twitter:description" content="Especial interactivo de RTVE.es al cumplirse los 10 años del tsunami en el océano Índico, que acabó con la vida de más de 230.000 personas.">
	<meta name="twitter:image" content="http://lab.rtve.es/tsunami/images/aniversario-tsunami.jpg">
	<meta property="og:site_name" content="Labbie Awards 2014"/>
	<meta property="og:title" content="10 años del tsunami en el Índico - Lab RTVE.es" />
	<meta property="og:image" content="http://lab.rtve.es/tsunami/images/aniversario-tsunami.jpg" />
	<meta property="og:description" content="Especial interactivo de RTVE.es al cumplirse los 10 años del tsunami en el océano Índico, que acabó con la vida de más de 230.000 personas." />
	<meta property="og:url" content="http://lab.rtve.es/parallax" />
	
	<title>Cortometrajes de Ficción Goya 2015</title>

	<link rel="stylesheet" href="css/styles-general.css" />
	<link rel="stylesheet" href="css/home.css" />
	<link rel="stylesheet" href="css/fonts.css" />
	<link rel="stylesheet" href="//s3.amazonaws.com/cdn.knightlab.com/libs/juxtapose/latest/css/juxtapose.css">
	<link  href="http://cdnjs.cloudflare.com/ajax/libs/fotorama/4.6.2/fotorama.css" rel="stylesheet"> <!-- 3 KB -->

	<script type="text/javascript" src="js/jquery-2.1.3.min.js"></script>
	<script type="text/javascript" src="js/jquery-ui.min.js"></script>
	<script type="text/javascript" src="js/spin.min.js"></script>
	<script type="text/javascript" src="js/loading.js"></script>
	<script type="text/javascript" src="js/pop-director.js"></script>

	<script src="http://cdnjs.cloudflare.com/ajax/libs/fotorama/4.6.2/fotorama.js"></script> <!-- 16 KB -->
	<script type="text/javascript" src="js/Video.js"></script>
	<script type="text/javascript" src="js/Menu.js"></script>
	<script type="text/javascript" src="js/init.js"></script>

</head>
<body>
	<div id="loading"></div>
	<!-- Pop-up trailer de directores -->
		<mask id="fondo-trailers"></mask>
		<div id="trailers" class="trailer">
			<video id="video-trailer" controls style="height:100%; width:100%;" data-video="" poster="">
				<source id="trailer-mp4" src="" type="video/mp4" />
				<source id="trailer-ogv" src="" type="video/ogv" />
				<source id="trailer-webm" src="" type="video/webm" />
			</video>
		</div>
		<div id="wrapper">
		<header>
			<!-- Share -->
			<div class="div-cab">
				<div class="rtve-icon">
					<a href="http://lab.rtve.es/" target="_blank" title="lab.rtve.es"><img src="images/rtve-icon.png"/></a>
				</div>
				<div class="share-icon">
					<a href="https://plus.google.com/share?url=/index.html" target="_blank" title="Google+"><button class="icon"><img src="images/gplus-icon.png" /></button></a>
					<a href="https://www.facebook.com/dialog/feed?app_id=597255927040700&picture=http://lab.rtve.es/tsunami/images/aniversario-tsunami.jpg&link=http://lab.rtve.es/tsunami&description=Especial interactivo de RTVE.es al cumplirse los 10 años del tsunami en el oceano Indico, que acabo con la vida de mas de 230.000 personas.&redirect_uri=http://lab.rtve.es" target="_blank" title="Facebook"><button class="icon"><img src="images/facebook-icon.png" /></button></a>
					<a href="https://twitter.com/intent/tweet?button_hashtag=Tsunami&amp;via=lab_rtvees&amp;text=Aniversario Tsunami&amp;url=http://lab.rtve.es/tsunami" target="_blank" title="Twitter"><button class="icon"><img src="images/twitter-icon.png" /></button></a>
				</div>
			</div>
			<!-- Menu -->
			<menu>
				<div id="menu-title">MEN&Uacute;</div>
				<div id="menu-select"></div>
				<ul id="menu-items">					
					<li id="menu-creacion" data-section="creacion" class="menu-item">CREACI&Oacute;N</li>
					<li id="menu-perfiles" data-section="perfiles" class="menu-item">PERFILES</li>
					<li id="menu-distribucion" data-section="distribucion" class="menu-item">DISTRIBUCI&Oacute;N</li>
					<li id="menu-los-goya" data-section="los-goya" class="menu-item">LOS GOYA</li>
				</ul>
			</menu>
		</header>
		<main>
			<!-- Home -->
			<section id="home-section" class="main-section">
				<!-- Pre-carga de imagenes -->
				<div style="display: none" id="preload-hide-images">
<!-- 					<img src="images/fondo1.png" />
					<img src="images/articulo1.png" />
					<img src="images/fotos-asi-fue/previews/1.jpg" />
					<img src="images/fotos-reconstruccion/previews/1.jpg" />
					<img src="images/fotos-generacion-tsunami/generacion-tsunami.jpg" />
					<img src="images/fondo2-1.jpg" />
					<img src="images/fondo2-3.jpg" />
					<img src="images/fondo2-4.jpg" />
					<img src="images/fondo1-4.jpg" />
					<img src="images/fondo1-4.png" />
					<img src="images/fondo-generacion.jpg" />
					<img src="images/fondo-generacion2.jpg" />
					<img src="images/fondo-espanola.jpg" />
					<img src="images/fondo-espanola2.jpg" />
					<img src="images/fondo-espanola3.jpg" />
					<img src="images/fondo-reconstruccion1.jpg" />
					<img src="images/fondo-reconstruccion2.jpg" /> -->
				</div>
			</section>
			<!-- CREACION -->
			<section id="creacion" class="main-section">
				<!-- Section 1 -->
				<section>
					<div id="img-cab-portada" class="img-section-cab img-main-section">
						<!-- <h2 class="main-section-title">CREACION</h2> -->
						<div id="contenedor-directores">
							<div id="director-1" class="director">
								<img width="100%" src="images/patricia.png"/>
								<span class="text-director">"Café para llevar"<br>Patricia Font</span>
							</div>
							<div id="director-2" class="director">
								<img width="100%" src="images/carlos.png"/>
								<span class="text-director">"Trato preferente"<br>Carlos Polo</span>
							</div>
							<div id="director-3" class="director">
								<img width="100%" src="images/kepa.png"/>
								<span class="text-director">"Loco con ballesta"<br>Kepa Sojo</span>
							</div>
							<div id="director-4" class="director">
								<img width="100%" src="images/gerardo.png"/>
								<span class="text-director">"Safari"<br>Gerardo Herrero</span>
							</div>
							<div id="director-5" class="director">
								<img width="100%" src="images/pablo.png"/>
								<span class="text-director">"Todo un futuro juntos"<br>Pablo Remón</span>
							</div>
						</div>
					</div>
				</section>
				<!-- Section 2 -->
				<section>
					<div class="text-section" style="height: 1300px;">
						<div class="article">
							<div class="column-left" style="height: 510px; margin-top:0px">
								<p class="articulo14" style="margin-left :0px; margin-bottom:0px; margin-top:40px;"><strong>Por Estefanía de Antonio</strong></p>
								<p class="articulo16" style="margin-left :0px; margin-bottom:0px; margin-top:20px; margin-right:70px;">Apenas quedaban dos minutos para los ocho de la mañana del 26 de diciembre de 2004 cuando <strong>la tierra tembló a 3.000 metros de profundidad en el Oceáno Índico</strong>, a 120 kilómetros al oeste de Sumatra. Fue el último amanecer para 230.000 personas.</p>
								<p class="articulo16" style="margin-left :0px; margin-bottom:0px; margin-top:20px; margin-right:70px;">El tsunami arrasó las paradisíacas costas de Tailandia, Indonesia, La India, Sri Lanka y otros archipiélagos del sureste asiático.</p>
								<p class="articulo19" style="margin-left :0px; margin-bottom:0px; margin-top:20px; margin-right:70px;"><strong>El terremoto de Sumatra-Andamán es el tercer seísmo más grande registrado en la historia y el más duradero, entre 8 y 10 minutos.</strong></p>
								<p class="articulo16" style="margin-left :0px; margin-bottom:0px; margin-top:20px; margin-right:70px;">De intensidad 9,3 en la escala Richter, <strong>liberó la  energía de 23.000 bombas atómicas como la de Hiroshima</strong>, una potencia suficiente como para hacer que el planeta vibrara un centímetro. Olas de hasta 20 metros viajaron por el océano a 700 kilómetros por hora, la velocidad de un avión a reacción.  Las más pequeñas llegaron a 5.000 kilómetros del epicentro, hasta Somalia.</p>
							</div>
							<div class="column-text" style="height: 400px;">
								<video controls style="height:350px; width:540px; margin-top: 35px" data-video="" poster="images/preview_video_texto.png">
									<source src="videos/video-text-1.mp4" type="video/mp4" />
									<source src="videos/video-text-1.ogv" type="video/ogv" />
									<source src="videos/video-text-1.webm" type="video/webm" />
								</video>
							</div>
							<div class="fotorama column-center" style="height:750px" data-nav="thumbs">
								<a href="images/slide/slide1.jpg" data-caption="Texto1"><img src="images/slide/slide1.jpg" id="sliders-1" /></a>
								<a href="images/slide/slide2.jpg" data-caption="Texto2"><img src="images/slide/slide2.jpg" id="sliders-2" /></a>
								<a href="images/slide/slide3.jpg" data-caption="Texto3"><img src="images/slide/slide3.jpg" id="sliders-3" /></a>
								<a href="images/slide/slide4.jpg" data-caption="Texto4"><img src="images/slide/slide4.jpg" id="sliders-4" /></a>
								<a href="images/slide/slide5.jpg" data-caption="Texto5"><img src="images/slide/slide5.jpg" id="sliders-5" /></a>
								<a href="images/slide/slide6.jpg" data-caption="Texto6"><img src="images/slide/slide6.jpg" id="sliders-6" /></a>
								<a href="images/slide/slide7.jpg" data-caption="Texto7"><img src="images/slide/slide7.jpg" id="sliders-7" /></a>
								<a href="images/slide/slide8.jpg" data-caption="Texto8"><img src="images/slide/slide8.jpg" id="sliders-8" /></a>
								<a href="images/slide/slide9.jpg" data-caption="Texto9"><img src="images/slide/slide9.jpg" id="sliders-9" /></a>
								<a href="images/slide/slide10.jpg" data-caption="Texto10"><img src="images/slide/slide10.jpg" id="sliders-10" /></a>
							</div>
						</div>
					</div>
				</section>
			</section>
			<!-- PERFILES -->
			<section id="perfiles" class="main-section">
				<!-- Section 1 -->
				<section>
					<div id="img-cab-perfiles" class="img-section-cab img-main-section">
						<h2 class="main-section-title">PERFILES</h2>
					</div>
					<div class="text-section" style="height: 900px;">
						<div class="article">
							<div class="column-left" style="height: 510px; margin-top:0px">
								<p class="articulo16" style="margin-left :25px; margin-bottom:0px; margin-top:89px; margin-right:70px;">Es el desgarrador testimonio de esta madre rota por el tsunami. La suya recuerda a la historia de María Belón, la española que inspiró la película "Lo imposible". Solo que en el caso de Harlina, como en el de la mayoría de las víctimas, <strong>no hay final feliz. Harlina sí perdió la pierna, a su marido y a sus tres hijos.</strong></p>
								<p class="articulo16" style="margin-left :25px; margin-bottom:0px; margin-top:20px; margin-right:70px;">A pesar de todo el sufrimiento, Harlina no se ha rendido. Es una mujer admirable, una luchadora. Ha sabido encontrar la fuerza de levantarse y aprender de nuevo a caminar.</p>
								<p class="articulo16" style="margin-left :25px; margin-bottom:0px; margin-top:20px; margin-right:70px;">Ahora, en el hospital de Abidín ayuda a otras personas que pasan por este duro proceso. Les entiende mejor que cualquier psicólogo.</p>
								<p class="articulo16" style="margin-left :25px; margin-bottom:0px; margin-top:20px; margin-right:70px;">Durante <strong>la entrevista que le hicimos para el documental "Generación Tsunami", nos sorprendió la entereza de esta mujer</strong>, que acaba de cumplir 44 años. No derramó ni una sola lágrima, a pesar de estar relatando una experiencia tan traumática.</p>
								<p class="articulo16" style="margin-left :25px; margin-bottom:0px; margin-top:20px; margin-right:70px;">No contenía el llanto por ella, si no por su anciana madre, sentada a su lado y enferma del corazón, a la que no quiere dar más disgustos. Es otro ejemplo de la generosidad de esta mujer, arrollada por la vida.</p>
							</div>
							<div class="column-text" style="width:530px; height:400px; margin-top:75px;">
								<p class="articulo16" style="margin-left :0px; margin-bottom:0px; margin-top:15px; margin-right:70px;">Como ella, muchos habitantes de las zonas devastadas perdieron a la mayor parte de su familia aquel 26 de diciembre. Roni Nourian es un huérfano del tsunami. <strong>En cuestión de segundos, el mar le arrebató su casa, sus padres, su infancia… Todo lo que creía sólido y seguro.</strong></p>
								<p class="articulo16" style="margin-left :0px; margin-bottom:0px; margin-top:20px; margin-right:70px;">Le hemos conocido junto al solar de su antigua casa, de la que solo quedó eso: el suelo. Nos cuenta que ha necesitado10 años para superar el trauma y volver a este lugar, donde está levantando con sus manos un nuevo hogar. Quiere vivir aquí otra vez, junto a su esposa y el hijo que están esperando.</p>
								<p class="articulo16" style="margin-left :0px; margin-bottom:0px; margin-top:20px; margin-right:70px;"><strong>Muchas cosas han cambiado en la región indonesia de Aceh desde el tsunami</strong> y, quizás, gracias a él. Ahora los niños estudian en la escuela cómo reaccionar y ponerse a salvo en caso de un maremoto. Para que una tragedia como la de 2004 jamás se repita. También estudian que aquel desastre puso fin a 30 años de una sangrienta guerra civil.</p>
								<p class="articulo16" style="margin-left :0px; margin-bottom:0px; margin-top:20px; margin-right:70px;">Conmocionados por casi 200 mil muertos en las calles, los guerrilleros separatistas del GAM (el Movimiento de Aceh Libre) y el gobierno indonesio decidieron sentarse a negociar. Pocos meses más tarde y con mediación internacional alcanzarían <strong>un acuerdo de paz, que se mantiene hasta hoy.</strong></p>
							</div>
						</div>
					</div>
				</section>
				<!-- Section 2 -->
				<section>
					<div class="img-fondo-datos-perfiles">
						<img src="images/perfiles_data.png" style="margin-top:70px;" id="text3-1"/>
					</div>
					<div class="text-section" style="height:1245px;">
						<div class="article">
							<div class="column-text" style="height:220px;">
								<p class="articulo16" style="margin-left:0px; margin-right:50px;">En "Generación Tsunami" escucharemos también la increíble historia de Irwandi Yousuf, jefe militar de los rebeldes "liberado por el tsunami". Así explica él mismo su salida de la cárcel, donde cumplía condena por participar en la lucha armada. El maremoto destruyó los muros de la prisión. Decenas de reclusos murieron ahogados, mientras Irwandi aprovechó la ocasión para escapar.</p>
							</div>
							<div class="column-text" style="height:220px;">
								<p class="articulo16" style="margin-left:0px; margin-right:0px;">Nadie podía imaginar entonces que este separatista se convertiría en el primer gobernador elegido democráticamente en Aceh. Desde entonces, <strong>antiguos guerrilleros dominan el panorama político en esta región</strong>, donde cuesta encontrar a simple vista huellas del tsunami.</p>
							</div>
						</div>
					</div>
				</section>
			</section>
			<!-- DISTRIBUCION -->
			<section  id="distribucion" class="main-section">
				<!-- Section 1 -->
				<section>
					<div id="img-cab-distribucion" class="img-section-cab img-main-section">
						<h2 class="main-section-title">DISTRIBUCI&Oacute;N</h2>
					</div>
					<div class="text-section2">
						<div class="article">
							<div class="column-center" style="height: 200px; margin-top: 60px;">
								<h3 style="font-family:Arial; margin-left :0px; margin-right:0px;margin-top: 0px;">"Mientras estaba ingresada, todavía tenía esperanza de verles de nuevo. Durante 40 noches soñé con ellos. Veía a mis niños volando, como mariposas. Sonreían y estaban felices. Un día, al despertar, me di cuenta de que debían de estar ya en el cielo. De que Dios los había llamado a su lado. Ahora sueño con el día en que nos encontraremos todos allí, en el cielo".</h3>
							</div>
						</div>
					</div>
				</section>
				<!-- Section 2 -->
				<section>
					<div id="img-video-distribucion">
						<div class="video-preview-mask"></div>
						<div class="article-video">
							<video controls style="width:1060px; height:597px; margin-top:65px;" data-video="" poster="images/preview_video_distribucion.png">
								<source src="videos/video-distribucion.mp4" type="video/mp4" />
								<source src="videos/video-distribucion.ogv" type="video/ogv" />
								<source src="videos/video-distribucion.webm" type="video/webm" />
							</video>
						</div>
					</div>
				</section>
			</section>
			<!-- LOS GOYA -->
			<section id="los-goya" class="main-section">
				<!-- Section 1 -->
				<section>
					<div id="img-cab-los-goya" class="img-section-cab img-main-section">
						<h2 class="main-section-title">LOS GOYA</h2>
					</div>
					<div class="text-section" style="height:800px;">
						<div class="article">
							<div class="column-text" style="height:730px;">
								<p class="articulo16" style="margin-left :0px; margin-bottom:0px; margin-top:68px; margin-right:70px;">Quienes nos recibieron en la nueva isla eran maldivos, familias humildes que vivían en casa muy pequeñitas y que se portaron muy bien, al igual que el personal del hotel, que siguió cuidando de nosotros hasta el final. Dormimos en el suelo de un colegio, que no tenía paredes, sólo los pilares y un techo chapado.</p>
								<p class="articulo16" style="margin-left :0px; margin-bottom:0px; margin-top:20px; margin-right:70px;">A algunos de nosotros los de la isla nos ofrecieron sus duchas para asearnos, pero <strong>todos estuvieron pendientes de nosotros…</strong> Tengo el recuerdo de la cara de la gente, sonrientes, muy preocupados mientras nos preparaban la cena. Como si nosotros que estábamos allí de paso hubiéramos perdido más que ellos.</p>
								<p class="articulo16" style="margin-left :0px; margin-bottom:0px; margin-top:20px; margin-right:70px;">Durante la noche, el personal del hotel se fue en los pequeños barquitos pesqueros a hacer señales de luz para pedir socorro. A la mañana siguiente <strong>supimos que una fragata militar paquistaní venía de camino</strong>. Tardamos horas en subir a bordo de la fragata.  Se nos hizo eterno. Recuerdo que un turista británico que esperaba con nosotros se quemó entero bajo el sol porque, obviamente, no había cremas solares. Para llegar hasta la fragata, teníamos que ir en barquitos pesqueros y la gente seguía teniendo mucho miedo.</p>
								<p class="articulo16" style="font-size:25px;margin-left :0px; margin-bottom:0px; margin-top:20px; margin-right:70px;">Tuvimos que cogerle de la mano a una señora durante todas esas horas esperando a subir a la fragata porque cada vez que pasaba una ola se ponía en tensión y murmuraba en inglés "Mierda, mierda, mierda". Darle la mano fue lo poco que pudimos hacer por ella.</p>
							</div>
							<div class="column-text" style="height:730px;">
								<p class="articulo16" style="margin-left:0px; margin-right:0px;">Ya en mar abierto conseguimos subir a la fragata con ayuda de los militares paquistaníes. Teníamos que saltar y confiar en que el soldado que te esperaba al otro lado te agarrara con fuerza para no caer al agua entre el barquito pesquero y la fragata.</p>
								<p class="articulo16" style="margin-left :0px; margin-bottom:0px; margin-top:50px; margin-right:70px;">Nosotros <strong>éramos los únicos españoles en aquella fragata y solo teníamos el bañador y una toalla</strong> por vestimenta. Habíamos logrado rescatar nuestra maleta y algo de nuestra ropa, mojada, dispersa por la isla, pero básicamente estaba vacía. Aún la tengo en casa, la sigo utilizando. Durante horas fuimos fondeando en distintas islas rescatando a más personas. Cada vez había más y más gente en el barco.</p>
								<p class="articulo16" style="margin-left :0px; margin-bottom:0px; margin-top:20px; margin-right:70px;">Cuando llegamos a Malé, <strong>conseguimos llamar a España y decir que estábamos bien. Habían pasado más de 36 horas desde el terremoto sin que nuestra familia tuviera noticias nuestras</strong> y pensaban que lo más probable era que estuviésemos muertos. Por lo que nos han contado después, esas horas fueron muy duras para ellos también.</p>
								<p class="articulo16" style="margin-left :0px; margin-bottom:0px; margin-top:20px; margin-right:70px;">Poco después de llegar a la capital, un encargado de nuestra agencia de viajes nos informó de que al menos <strong>deberíamos esperar una semana para poder volar de regreso a España</strong> porque no había ni una plaza en los vuelos y nos instaló en un hotel.</p>
								<p class="articulo16" style="margin-left :0px; margin-bottom:0px; margin-top:20px; margin-right:70px;">A la mañana siguiente fuimos a comprar algo de ropa en un mercadillo de Malé. Hasta ese momento no me había dado ni cuenta de lo pequeñita que era la gente de Maldivas porque todo nos quedaba pequeño. Al regresar al hotel, el tipo de la agencia de viajes nos paró en el hall y nos dijo: Corred, recoged todo deprisa porque hemos encontrado un vuelo para vosotros. Lo que iba a ser <strong>una semana de espera se convirtió en menos de un día.</strong></p>
							</div>
						</div>
					</div>
				</section>
				<!-- Section 2 -->
				<section>
					<div id="img-video-goya">
						<div class="video-preview-mask"></div>
						<div class="article-video">
							<video controls style="width:1060px; height:597px; margin-top:65px" data-video="" poster="images/preview_video_goya.png">
								<source src="" type="video/mp4"/>
								<source src="" type="video/ogv"/>
								<source src="" type="video/webm"/>
							</video>
						</div>
					</div>
					<div class="text-section" style="height: 300px;">
						<div class="article">
							<div class="column-center" style="height: 250px;">
								<p class="articulo19" style="margin-left:0px; margin-right:0px;"><strong>Después de vivir el tsunami, tengo sentimientos encontrados</strong>. Por una parte recuerdo la gente se encerró en sí misma aquellas horas, y por otra parte recuerdo todos aquellos que a pesar de que habían perdido todo, o de estar muertos de miedo, intentaron hacer la vida de los que les rodeaban mejor.</p>
								<p class="articulo16" style="font-size:25px;margin-left:0px; margin-right:0px;margin-top:50px;"><strong>Supongo que no se puede juzgar, yo no vi la ola y no sentí ese miedo, quizás hubiera reaccionado de otra manera de haberlo vivido como el resto. No he vuelto a bucear, no sé si volveré a hacerlo."</strong></p>
							</div>
						</div>
					</div>
				</section>
				<!-- Section 3 -->
				<section>
					<div id="img-fondo-datos-goya">
						<img src="images/goya_data.png" style="margin-top:25px;"/>
					</div>
				</section>
			</section>
		</main>
<footer>
	<div id="copyright">
		&copy;2015 RTVE.es
	</div>
	<div id="credits">
		<ul>
			<li>Coordinación: Miriam Hernanz y Estefanía de Antonio</li>
			<li>Diseño: Ismael Recio</li>
			<li>Realización: Miguel Campos</li>
			<li>Desarrollo: Equipo de tecnología de RTVE.es</li>
			<li>Con la colaboración de Francisco Magallón, Olegario Marcos, Érika Reija, Almudena Ariza y el Fondo Documental de TVE. </li>
		</ul>
	</div>
</footer>
	<!-- Fin div wrapper -->
	</div>
</body>
<script type="text/javascript" >
<!--
function tag(id)	{
	return document.getElementById(id);
}
function hideLoading() {
	$("#loading").fadeOut("fast", function() {
		$("body").css("overflow-y", 'scroll');
		$("video").each(function(i, video) {
			var videoName = $(this).data("video");
			if (videoName !="")
			{
				$(this).children("source[type='video/mp4']").attr("src", 'videos/'+videoName+'.mp4');
				$(this).children("source[type='video/ogv']").attr("src", 'videos/'+videoName+'.ogv');
				$(this).children("source[type='video/webm']").attr("src", 'videos/'+videoName+'.webm');
				$(this).get(0).load();
			}
		});
	});
}

var cargadas = function()	{
	hideLoading();
};

var precargadas;
function precargar() {
	precargadas = precargar.arguments.length;
	for (var i = 0, datos = precargar.arguments, total = precargadas; i < total; i ++) {
		if (tag(datos[i]).complete)	{
			precargadas--;
			console.log("cargada");
		} else {
			tag(datos[i]).onload = function() {
				if (--precargadas == 0)	{cargadas();}
			};
		}
		if (precargadas == 0) {cargadas();}
	}
}
var sectionsImages = new Array();
$("section.main-section img").each(function(i, img) {
	var imgId = $(this).attr("id");
	if (imgId !== undefined) {
		sectionsImages.push(imgId);
	}

});
precargar.apply(this, sectionsImages);
setTimeout(function() {
	if ($("#loading").is(":visible")) {
		location.reload();
	}
},20000);
		//-->
		</script>
		<script type="text/javascript" src="//s3.amazonaws.com/cdn.knightlab.com/libs/juxtapose/latest/js/juxtapose.js"></script>
		</html>