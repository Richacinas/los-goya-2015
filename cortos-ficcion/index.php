<!DOCTYPE html>
<?php
	$url= "http://".$_SERVER['HTTP_HOST'];
?>
<html>
<head>
	<script type="text/javascript" src="//www.rtve.es/js/mushrooms/rtve_mushroom.js" ></script>

	<meta charset="utf-8">
	<meta itemprop="name" content="Entrevista interactiva a los nominados al Goya a mejor corto de ficción 2015 - Lab RTVE.es">
	<meta itemprop="description" content="Descubre cómo es el proceso de creación de un cortometraje de ficción de la mano de los nominados a los Goya 2015. Lab RTVE.es">
	<meta itemprop="og:description" content="Descubre cómo es el proceso de creación de un cortometraje de ficción de la mano de los nominados a los Goya 2015. Lab RTVE.es">
	<meta name="description" content="Descubre cómo es el proceso de creación de un cortometraje de ficción de la mano de los nominados a los Goya 2015. Lab RTVE.es">
	<meta name="keywords" content=" Goya, Goya 2015, Premios Goya, Premios Goya 2015, nominados Goya 2015, nominados Premios Goya 2015, nominados Premios Goya 2015 RTVE,  Goya 2015 RTVE, cortometrajes, nominados cortometrajes Premios Goya 2015, cortos Goya 2015, cortometrajes de ficción, cortos de ficción, cortometraje de ficción, mejores cortos 2015, mejores cortometrajes 2015, Kepa Sojo, Patricia Font, Gerardo Herrero, Carlos Polo, Pablo Remón, Café para llevar, Loco con ballesta, Todo un futuro juntos, Safari, Trato Preferente, cine, cine español, interactivo cine español, Karra Elejalde, Alexandra Jiménez, Daniel Grao, Julián Villagrán, Luis Bermejo, Leonard Proxauf, ECAM, ESCAC, Madrid en Corto, Lab RTVE, Lab RTVE Goya 2015, Lab RTVE Goya 2015 interactivo, entrevista Kepa Sojo, entrevista Patricia Font, entrevista Gerardo Herrero, entrevista Carlos Polo, entrevista Pablo Remón, parallax RTVE, parallax RTVE Goya 2015, Ganador cortometraje Goya 2015, Ganador corto Goya 2015">
	<meta name="twitter:title" content="Entrevista interactiva a los nominados al Goya a mejor corto de ficción 2015 - Lab RTVE.es ">
	<meta name="twitter:description" content="Descubre cómo es el proceso de creación de un cortometraje de ficción de la mano de los nominados a los Goya 2015. Lab RTVE.es">
	<meta name="twitter:image" content=<?php print($url); ?>"/los-goya-2015/cortos-ficcion/images/redessociales.png">
	<meta property="og:site_name" content="Cortos de Ficción - Los Goya 2015 - Lab RTVE.es"/>
	<meta property="og:title" content="Entrevista interactiva a los nominados al Goya a mejor corto de ficción 2015 - Lab RTVE.es " />
	<meta property="og:image" content=<?php print($url); ?>"/los-goya-2015/cortos-ficcion/images/redessociales.png" />
	<meta property="og:description" content="Descubre cómo es el proceso de creación de un cortometraje de ficción de la mano de los nominados a los Goya 2015. Lab RTVE.es" />
	<meta property="og:url" content=<?php print($url); ?>"/los-goya-2015/cortos-ficcion" />
	
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

	<script src="http://cdnjs.cloudflare.com/ajax/libs/fotorama/4.6.2/fotorama.js"></script> <!-- 16 KB -->
	<script type="text/javascript" src="js/Video.js"></script>
	<script type="text/javascript" src="js/Menu.js"></script>
	<script type="text/javascript" src="js/init.js"></script>
	<script type="text/javascript" src="js/pop-director.js"></script>

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
					<a href="https://plus.google.com/share?url=<?php print($url); ?>/los-goya-2015/cortos-ficcion" target="_blank" title="Google+"><button class="icon"><img src="images/gplus-icon.png"/></button></a>
					<a href="https://www.facebook.com/dialog/feed?app_id=597255927040700&picture=<?php print($url); ?>/los-goya-2015/cortos-ficcion/images/redessociales.png&link=<?php print($url); ?>/los-goya-2015/cortos-ficcion&description=Descubre cómo es el proceso de creación de un cortometraje de ficción de la mano de los nominados a los Goya 2015. Lab RTVE.es&redirect_uri=<?php print($url); ?>/los-goya-2015" target="_blank" title="Facebook"><button class="icon"><img src="images/facebook-icon.png"/></button></a>
					<a href="https://twitter.com/intent/tweet?button_hashtag=Goya2015&amp;via=lab_rtvees&amp;text=Entrevista a los nominados a mejor corto de ficción&amp;url=<?php print($url); ?>/los-goya-2015/cortos-ficcion" target="_blank" title="Twitter"><button class="icon"><img src="images/twitter-icon.png"/></button></a>
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
						<div class="column-center" style="witdh=80%; height: 100px; position:absolute; bottom:80px; display:block;">
							<p class="articulo19" style="font-size:23px;color:white; margin-top:10px; text-align:center;"><i>Así hice mi corto: De la idea al Goya en 4 pasos</i></p>
							<p class="articulo19" style="color:white; margin-top:60px; text-align:center;">Me llamo Juana y acabo de salir de la Universidad. Mi objetivo es conseguir una nominación a los Goya. Esta es la historia de cómo me he embarcado en esta aventura tras charlar con los nominados a Mejor Corto de Ficción de este año. Pincha en su foto para ver el tráiler de su cortometraje.</p>
						</div>
					</div>
				</section>
				<!-- Section 2 -->
				<section>
					<div class="text-section" style="height: 1480px;">
						<div class="article">
							<div class="column-left" style="height: 510px; margin-top:0px">
								<p class="articulo19" style="margin-left :25px; margin-bottom:0px; margin-top:60px; margin-right:70px;">Por extraño que parezca hace cuatro años, <strong>decidí que me iba a presentar a los Goya</strong>. Fue una mañana, volviendo de la universidad. Una de mis profesoras estaba nominada a mejor cortometraje de ficción y la emoción que transmitía era tan grande que me hizo plantearme esto como un objetivo real: no pensaba morirme sin vivir eso.</p>
								<p class="articulo16" style="margin-left :25px; margin-bottom:0px; margin-top:20px; margin-right:70px;">¿Pero cómo se llega a los Goya? Con mi profesora perdí el contacto, así que decidí preguntar a los <a href="http://www.rtve.es/noticias/los-goya/nominados/" target="_blank">nominados a Mejor Corto de Ficción de la 29ª</a> edición para que me orientasen.</p>
								<p class="articulo16" style="margin-left :25px; margin-bottom:0px; margin-top:20px; margin-right:70px;">En primer lugar necesitaba una idea. <strong>¿Pero de dónde vienen las ideas?</strong> Estuve días y noches dándole vueltas, escribiendo sinopsis una tras otra sin llegar a convencerme ninguno de los planteamientos a los que llegaba. Y me costó dar con el problema: <strong>la ficción no surge de la nada, sino de la propia experiencia</strong>. ¡Claro!  En realidad tiene sentido, no creo que pueda llegar a conectar con un espectador si mi historia no es sincera. Lo que me contaron Kepa, Gerardo, Pablo, Patricia y Carlos -los nominados a Mejor Cortometraje este año- no hizo más que confirmar esta teoría. Además, me ayudó mucho saber que no todos ellos habían contado con enormes presupuestos. Aumentó mis esperanzas, porque precisamente mi mayor limitación era la económica.</p>
								<p class="articulo16" style="margin-left :25px; margin-bottom:0px; margin-top:20px; margin-right:70px;">Para el rodaje conté con lo más básico: mi cámara de fotos tiene una calidad de grabación bastante decente y reuniendo a la gente adecuada que he conocido en la facultad, juntos seguro que podíamos llegar a algo bueno. Que se lo digan sino a Patricia que, gracias a sus compañeros de la  <a href="http://www.escac.es/" target="_blank"><i>ESCAC</i></a>, pudo rodar su corto en dos días. Mi intuición no fallaba, porque reuniéndonos todos, juntando nuestro dinerillo, conseguimos llegar a algo más que decente, ¡redondo! <strong>Un par de días de rodaje con la gente adecuada pueden dar mucho más de sí que lo que una se imagina en un principio.</strong></p>
							</div>
							<div class="column-text" style="height: 400px;">
								<div style="height:350px; width:540px; margin-top: 35px; display:none; text-align:center;"> 
									<img id="preview-video-texto-apple" src="images/preview_video_texto.png"/>
									<img id="play-icon1" src="images/play.png" style="display:none; margin:0 auto;"/>
								</div>
								<video id="video-texto" controls style="height:350px; width:540px; margin-top: 100px" data-video="" poster="images/preview_video_texto.png">
									<source src="videos/video-text-1.mp4" type="video/mp4" />
									<source src="videos/video-text-1.ogv" type="video/ogv" />
									<source src="videos/video-text-1.webm" type="video/webm" />
								</video>
								<p class="articulo16" style="margin-left :25px; margin-bottom:0px; margin-top:45px; margin-right:70px;">Hablemos de <strong>los actores</strong>. Todos pensábamos que ningún profesional de nombre iba a querer ayudarnos, pero no sabéis lo equivocados que estábamos. Sólo hay que echar un vistazo a los actores de los cortos nominados al Goya este año: <strong><a href="http://www.imdb.com/name/nm1411610/" target="_blank">Alexandra Jiménez</a>, <a href="http://www.danielgrao.com/" target="_blank">Daniel Grao</a>, <a href="https://twitter.com/julyanvillagran" target="_blank">Julián Villagrán</a>, <a href="http://www.imdb.com/name/nm1084399/" target="_blank">Luis Bermejo</a>, <a href="http://www.imdb.com/name/nm0253216/" target="_blank">Karra Elejalde</a>...</strong> Y es que la base de todo es una buena idea, una que permita a actores conocidos probar otro tipo de papeles a los que no están acostumbrados.</p>
							</div>
							<div class="fotorama column-center" style="height:750px; margin-top:280px;" data-nav="thumbs">
								<a href="images/slide/slide1.jpg" data-caption="Kepa Sojo, Karra Elejalde y Andrés Gertrudix preparándose para rodar."><img src="images/slide/slide1.jpg" id="sliders-1" /></a>
								<a href="images/slide/slide2.jpg" data-caption="3, 2, 1… ¡Acción!"><img src="images/slide/slide2.jpg" id="sliders-2" /></a>
								<a href="images/slide/slide3.jpg" data-caption="El alemán Leonard Proxauf, uno de los protagonistas de <i>Safari</i>."><img src="images/slide/slide3.jpg" id="sliders-3" /></a>
								<a href="images/slide/slide4.jpg" data-caption="Helen Kennedy y Tabitha Wells, pasando un mal rato en el instituto de <i>Safari</i>."><img src="images/slide/slide4.jpg" id="sliders-4" /></a>
								<a href="images/slide/slide5.jpg" data-caption="No cabreemos a Edna Fontana, Paquita en <i>Trato Preferente</i>."><img src="images/slide/slide5.jpg" id="sliders-5" /></a>
								<a href="images/slide/slide6.jpg" data-caption="Antonio Gómez, el sufrido banquero del corto de Carlos Polo."><img src="images/slide/slide6.jpg" id="sliders-6" /></a>
								<a href="images/slide/slide7.jpg" data-caption="Daniel Grao, intentando evitar que Alexandra Jiménez se lleve un <i>Café para llevar</i>."><img src="images/slide/slide7.jpg" id="sliders-7" /></a>
								<a href="images/slide/slide8.jpg" data-caption="Alexandra Jiménez, Alicia en <i>Café para llevar</i>, concentrada en los preparativos de su boda."><img src="images/slide/slide8.jpg" id="sliders-8" /></a>
								<a href="images/slide/slide9.jpg" data-caption="Julián Villagrán y Luis Bermejo, dos banqueros en apuros en <i>Todo un futuro juntos</i>."><img src="images/slide/slide9.jpg" id="sliders-9" /></a>
								<a href="images/slide/slide10.jpg" data-caption="Carlos, en pleno dilema emocional en el corto de Pablo Remón."><img src="images/slide/slide10.jpg" id="sliders-10" /></a>
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
					<div class="text-section" style="height: 200px;">
						<div class="article">
							<div class="column-center" style="height: 180px;">
								<p class="articulo19" style="margin-left:25px; margin-right:75px;margin-top:50px;">Pero, <strong><i>¿quién está detrás de Café para llevar, Loco con Ballesta, Safari, Trato Preferente y Todo un futuro juntos?</i></strong>  Pues el perfil de la mayoría de ellos no se asemeja mucho al mío: yo tengo solamente 22 años, soy mujer y mi experiencia en el mundo audiovisual es muy limitada. <strong>La mayoría de los nominados son hombres de entre 30 y 45 años que ya tienen su recorrido en el sector y han ganado algún que otro premio.</strong> Y yo con toda mi cara, recién salida de la universidad, planteándome hacer un corto capaz de llegar a ese nivel. Os voy a hablar un poco de ellos, para que os hagáis una idea de cómo es el panorama:</p>
							</div>
						</div>
					</div>
					<div class="text-section" style="height: 400px;">
						<div class="article">
							<div class="column-left" style="height: 510px; margin-top:0px">
								<p class="articulo16" style="margin-left :25px; margin-bottom:0px; margin-top:0px; margin-right:70px;"><strong>Patricia Font (<i>Café para llevar</i>)</strong> lleva desde que se graduó en la ESCAC encadenando rodajes de diferentes producciones de cine y TV. Incluso ha dirigido varios capítulos de <a href="http://www.ccma.cat/tv3/polseres-vermelles/" target="_blank"><i>Pulseras Rojas</i></a>(2011-...). Fue en una cafetería cuando me confesó que tan contento se quedó Pau Freixas -el creador de <i>Pulseras Rojas</i>- que actualmente Patricia y él están trabajando en una nueva serie juntos.</p>
								<p class="articulo16" style="margin-left :25px; margin-bottom:0px; margin-top:20px; margin-right:70px;">También <strong>Gerardo Herrero (<i>Safari</i>)</strong> y <strong>Pablo Remón (<i>Todo un futuro juntos</i>)</strong> estudiaron en otra prestigiosa escuela: la <a href="http://www.ecam.es/" target="_blank">ECAM</a>. Gerardo tiene su propia productora, <a href="http://gerardoherrero.com/" target="_blank">Dynamite Films</a>, con la que ha hecho cortos como <a href="http://festivaldemalaga.com/el-festival/ediciones" target="_blank"><i>Picnic</i></a> (2010) o <a href="http://vimeo.com/88310124" target="_blank"><i>The Acrobat</i></a> (2013); Pablo, además de director es guionista y dramaturgo - ha escrito una obra de teatro, <a href="http://pabloremon.com/LA-ABDUCCION-DE-LUIS-GUZMAN" target="_blank"><i>La abducción de Luis Guzmán</i></a> (2013). Entre sus guiones figuran, <a href="https://www.youtube.com/watch?v=G96ebnWVJk0" target="_blank"><i>Casual Day</i></a> (2007) o <a href="https://www.youtube.com/watch?v=wUYtX9Piris" target="_blank"><i>Cinco metros cuadrados</i></a> (2011)-. Cuando quedé con Pablo en su despacho, pude comprobar que actualmente tiene varios proyectos encima de la mesa.</p>
							</div>
							<div class="column-text" style="width:530px; height:400px;">
								<p class="articulo16" style="margin-left :0px; margin-bottom:0px; margin-top:0px; margin-right:70px;"><strong><a href="http://www.carlos-polo.com/" target="_blank">Carlos Polo</a> (<i>Trato preferente</i>)</strong> ha hecho prácticamente de todo en el mundo audiovisual: ficción, diseño web, campañas publicitarias para Internet... En la oficina donde trabaja me llegó a enseñar una de sus joyas: ¡un <a href="http://www.carlos-polo.com/tehas/indexsuecos.htm" target="_blank">spot interactivo!</a> Con su anterior corto, <a href="http://vimeo.com/11488967" target="_blank"><i>Paganini 2015</i></a>, consiguió ser finalista en el <a href="http://www.jamesonnotodofilmfest.com/" target="_blank"><strong>Festival NotodoFilmFest</strong><a> en 2010.</p>
								<p class="articulo16" style="margin-left :0px; margin-bottom:0px; margin-top:20px; margin-right:70px;">¡Qué decir de <strong>Kepa Sojo (<i>Loco con ballesta</i>)</strong>! Es profesor de Historia del Cine en la Universidad del País Vasco y se encarga de organizar el <a href="http://www.festivalcortada.com/" target="_blank">Festival de Cortos <i>Cortada</i> de Vitoria</a>. También ha dirigido una película, <a href="http://www.filmaffinity.com/es/film113148.html" target="_blank"><i>El síndrome Svensson</i></a> (2009), ¡y entre todo eso <strong>ha sacado tiempo para reclutar a Karra Elejalde</strong> para <i>Loco con Ballesta</i>!</p>
								<p class="articulo16" style="margin-left :0px; margin-bottom:0px; margin-top:20px; margin-right:70px;">Con este panorama, no me queda otro remedio que ponerme las pilas si de verdad quiero llegar algún día a donde están ellos.</p>
							</div>
						</div>
					</div>
				</section>
				<!-- Section 2 -->
				<section>
					<div class="img-fondo-datos-timeline">
						<img src="images/timeline_data.png" style="margin-top:-85px;"/>
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
					<div class="text-section" style="height: 300px;">
						<div class="article">
							<div class="column-center" style="height: 180px;">
								<p class="articulo19" style="margin-left:25px; margin-right:75px;margin-top:50px;"><strong>Los rodajes nunca son fáciles</strong>, hay que tener madera para ello. A mi me quedó claro, y eso que Gerardo y Kepa me lo advirtieron. Por ejemplo, <strong>Gerardo tuvo que utilizar un instituto de las afueras de Madrid en pleno verano</strong> para rodar <i>Safari</i> y por si fuera poco tuvieron un pequeño percance con la actriz protagonista, <a href="http://www.imdb.com/name/nm2993428/?ref_=fn_al_nm_1" target="_blank">Helen Kennedy</a>, en un tiroteo. Afortunadamente, el incidente se quedó en un susto. <strong>Kepa sufrió el calor de la montaña alavesa</strong> -¡esos mosquitos!-,  <strong>a Pablo</strong>, por exigencias de su historia, <strong>no le quedó más remedio que rodar en un bar abierto al público</strong> la conversación de sus banqueros protagonistas... Del rodaje de mi corto…¡Mejor no hablar!, lo importante es que gracias  a la buena voluntad de actores y equipo salió adelante.</p>
							</div>
						</div>
					</div>
				</section>
				<!-- Section 2 -->
				<section>
					<div class="img-fondo-datos-distribucion">
						<img src="images/distribucion_data.png" style="margin-top:60px;"/>
					</div>
					<div class="text-section" style="height: 300px;">
						<div class="article">
							<div class="column-center" style="height: 180px;">
								<p class="articulo19" style="margin-left:25px; margin-right:75px;margin-top:50px;">Ahora solo tenía que conseguir que llegase a la gente, que lo vieran. Pero…¿cómo conseguirlo? Este fue el momento que más me costó afrontar, pues <strong>si el mundo de la financiación ya me era poco familiar y el del rodaje no fue un camino de rosas, el de la distribución ni os cuento</strong>. Menos mal que tenía los consejos de Carlos, Pablo, Patricia, Kepa y Gerardo. En lo que todos coincidían era que resulta más sencillo contratar <a href="http://www.ocec.eu/pdf/distribuidoras.pdf" target="_blank">una empresa que nos ayudase a distribuirlo</a>.</p>
								<p class="articulo19" style="margin-left:25px; margin-right:75px;margin-top:50px;">Haciendo caso de los consejos de los expertos, eso fue lo que hicimos. Juntamos el dinero para pagar los gastos que esto implica y dejar que la agencia se encargase de <strong>moverlo por festivales de todo el mundo</strong>.</p>
							</div>
						</div>
					</div>
				</section>
				<!-- Section 3 -->
				<section>
					<div id="img-video-distribucion">
						<div class="video-preview-mask"></div>
						<div class="article-video">
							<div style="height:597px; width:1060px; margin-top: 65px; display:none; text-align:center;"> 
								<img id="preview-video-apple1" src="images/preview_video_distribucion.png"/>
								<img id="play-icon2" src="images/play.png" style="display:none; margin:0 auto;"/>
							</div>
							<video id="video-apple-1" controls style="width:1060px; height:597px; margin-top:65px;" data-video="" poster="images/preview_video_distribucion.png">
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
					<div class="text-section" style="height:350px;">
						<div class="article">
							<div class="column-text" style="height:730px;">
								<p class="articulo19" style="margin-left :25px; margin-bottom:0px; margin-top:60px; margin-right:70px;">Pues bien, <strong>aquí me encuentro, con mi cortometraje en distribución esperando ansiosa ser llamada de algún festival</strong>, algo que me confirme que mi corto ha llegado a buen puerto, que merece la pena ser visto y que tengo alguna <a href="http://premiosgoya.academiadecine.com/descargas/bases29goyas.pdf" target="_blank">posibilidad de ser nominada a los Goya</a>, por muy remota que sea.</p>
							</div>
							<div class="column-text" style="height:730px;">
								<p class="articulo19" style="margin-left :0px; margin-bottom:0px; margin-top:60px; margin-right:70px;">Aun así, muchas veces cuando muestro mi ilusión por poder estar entre los seleccionados, hay gente que me mira raro, como preguntándose <strong>para qué sirve ganar un Goya</strong>. Pues <a href="http://premiosgoya.academiadecine.com/ediciones_anteriores/index.php" target="_blank">desde 2008<a>, <strong>todos los ganadores, excepto uno, han conseguido seguir dedicándose al audiovisual</strong>, y no de cualquier manera, sino que la mayoría han realizado su propia película. ¡Un largo! En cuanto a los nominados que no se llevaron el cabezudo a casa tampoco les ha ido mucho peor.</p>
							</div>
						</div>
					</div>
				</section>
				<!-- Section 2 -->
				<section>
					<div id="img-video-goya">
						<div class="video-preview-mask"></div>
						<div class="article-video">
							<div style="height:597px; width:1060px; margin-top: 65px; display:none; text-align:center;"> 
								<img id="preview-video-apple2" src="images/preview_video_goya.png"/>
								<img id="play-icon3" src="images/play.png" style="display:none; margin:0 auto;"/>
							</div>
							<video id="video-apple-2" controls style="width:1060px; height:597px; margin-top:65px" data-video="" poster="images/preview_video_goya.png">
								<source src="videos/video-goya.mp4" type="video/mp4"/>
								<source src="videos/video-goya.ogv" type="video/ogv"/>
								<source src="videos/video-goya.webm" type="video/webm"/>
							</video>
						</div>
					</div>
					<div class="text-section" style="height: 400px;">
						<div class="article">
							<div class="column-center" style="height: 250px;">
								<p class="articulo19" style="margin-left:25px; margin-right:25px;">Ya no sólo por lo que pueda implicar ésto en la carrera laboral de uno, sino por <strong>el orgullo que supone ganarlo</strong>. Hablando con mis nuevos compañeros, con Patricia, con Gerardo, con Pablo, con Carlos y con Kepa también sentí su emoción a través de sus palabras: <strong>su expresión, sus gestos, la alegría y orgullo que transmitían fue lo que me impulsó a querer realmente vivir algo así yo también</strong>.</p>
								<p class="articulo16" style="font-size:25px;margin-left:25px; margin-right:25px;margin-top:50px;">Por eso, chicos, si sentís el impulso de aventuraros en la creación audiovisual, que nada os frene. Haced caso a vuestros impulsos, ya que como todos estos creadores a los que he tenido el placer de conocer me dijeron, <strong>si tienes las ganas y sientes la necesidad, tienes que hacerlo, no hay otra opción</strong>. Por muy desalentador que parezca el panorama audiovisual y el funcionamiento de la industria, <strong>siempre hay sitio para alguien que realmente pone todo su empeño en crear</strong>.</p>
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
			<li>Coordinación: César Vallejo</li>
			<li>Realización: Becarios en prácticas: Alba Montero, Laia Iborra y Pelayo Prieto</li>
			<li>Desarrollo: Equipo de tecnología de RTVE.es</li>
			<li>Agradecimientos: Patricia Font, Gerardo Herrero, Pablo Remón, Carlos Polo y Kepa Sojo</li>
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