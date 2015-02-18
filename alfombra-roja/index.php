<?php

include 'partials/utils.php';

$footer = file_get_contents("http://www.rtve.es/comunes/pie/pie_portada.inc",0);
$header = utf8_encode(file_get_contents("http://wwww.rtve.es/comunes/cabecera/cabecera_portada.inc",0));
$modHeaderTags = file_get_contents("http://www.rtve.es/components/noticias/mod_cabecera_tags.inc",0);
$breakingNews = file_get_contents("http://www.rtve.es/components/noticias/breaking_news.inc",0);
$controllerHeader = file_get_contents("http://www.rtve.es/comunes/controlador/cabeceras_controlador.inc?cat=TE_SOSCA15&pag=portada&opcion=1",0);


$name = isset($_GET['nombre-famoso']) ? $_GET['nombre-famoso'] : '';

$data = getCarouselData(true);
$aCarousel = $data[0];
$aNameIndex = $data[1];

//La estructura aCarousel es la siguiente:   aCarousel[nombre_famoso]
//y cada elemento es un array[integer] con 6 elementos:
// posición, nombre_foto.jpg, nombre_famoso, nombre_fotógrafo, texto, identificador
// Vienen ya ordenados de acuerdo al valor de posición
$ogTitle = "";
if ($name != '') {
    $carouselIndex = array_search($name."-los-oscar-2015.jpg", array_values($aNameIndex));
    if (!(is_int($carouselIndex))) {
        $carouselIndex = 0;
    } else {
        $ogTitle = $aCarousel[$carouselIndex + 1][2];
    }
}
else {
    $carouselIndex = 0;
}



?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html" charset="UTF-8"/>
    <meta http-equiv="Content-Language" content="es" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta name="robots" content="all, index, follow" />
    <meta name="RTVE.template_version" content="V_30"/>

    <title>La alfombra roja de los Oscar - RTVE.es</title>
    <meta name="Title" content="La alfombra roja de la gala de los Oscar – Los Oscar 2015 – RTVE.es" />
    <meta name="Description" content="La alfombra roja de la gala de los Oscar. Descubre los mejores vestidos de los actores y actrices de los gala de los Oscar, aquí en RTVE. Entra ya." />
    <meta name="Keywords" content="Alfombra roja, vestidos, fotos, Oscar, oscar, Oscars, oscars, premios oscar 2015, Premios Oscar 2015, los Oscar, los Oscar 2015, Gala Premios Oscar, Gala Premios Oscar 2015, Gala los Oscar, Gala los Oscar 2015, noticias, ganadores, v&iacute;deos, videos, imagenes, fotos, fotograf&iacute;as" />
    <meta property="og:site_name" content="Lab RTVE.es Alfombra Roja"/>
    <meta property="og:title" content="<?php if ($ogTitle != "") { echo $ogTitle; ?>, en la <?php } else { ?>La <?php } ?> alfombra roja de los Oscar - Los Oscar 2015"/>
    <meta property="og:description" content="La alfombra roja de los Oscar 2015. Descubre los vestidos de las actrices , los mejores trajes de los actores y los famosos en la gala de los Oscar 2015"/>
    <meta property="og:url" content="<?php echo $shareUrl; echo $name; ?>"/>
    <meta property="og:image" content="<?php echo $baseUrl; ?>fotosPublished/zoom/<?php echo $aCarousel[$carouselIndex + 1][1]; ?>"/>

    <!-- no cache headers -->
    <meta http-equiv="Pragma" content="no-cache"/>
    <meta http-equiv="no-cache"/>
    <meta http-equiv="Expires" content="-1"/>
    <meta http-equiv="Cache-Control" content="no-cache"/>
    <!-- end no cache headers -->

    <link rel="stylesheet" type="text/css" href="css/style.css"/>
    <!--link rel="stylesheet" type="text/css" href="css/zoom.css"/-->
    <link rel="stylesheet" href="http://www.irtve.es/css/style2011/style.css" type="text/css" media="all"/>
    <link rel="stylesheet" href="http://www.irtve.es/css/tipografias.css" type="text/css"/>
    <link rel="stylesheet" href="http://www.irtve.es/css/rtve.cabeceras/css-dinamico.css?cat=TE_SOSCA15&plantilla=tplX_cab" type="text/css"/>
    <link rel="stylesheet" href="http://www.irtve.es/css/rtve.cabeceras/css-dinamico.css?cat=TE_SOSCA15&plantilla=tplX" type="text/css"/>
    <link rel="stylesheet" href="http://www.irtve.es/css/rtve.2015/rtve.transicion/portada.css" type="text/css"/>
    <link rel="stylesheet" href="http://www.irtve.es/css/rtve.noticias/rtve.noticias.cultura/oscar2015/oscar2015.css" type="text/css"/>




    <script type="text/javascript" src="http://www.rtve.es/js/rtve.pack.js"></script>
    <script language="javascript" type="text/javascript" src="js/jquery.easing.1.3.js" ></script>
    <script language="javascript" type="text/javascript" src="js/cufon-yui-1.09.js" ></script>
    <!--script language="javascript" type="text/javascript" src="js/jquery.jcarousel.min.js" ></script>
    <script language="javascript" type="text/javascript" src="js/script.js" ></script-->
    <script language="javascript" type="text/javascript" src="js/jcarouselHandler.js" ></script>
    <script language="javascript" type="text/javascript" src="//www.rtve.es/js/mushrooms/rtve_mushroom.js" ></script>
    <script type="text/javascript" src="js/jquery.elevatezoom.js"></script>
    

    <script language="javascript" type="text/javascript">
        var carouselIndex = <?php print($carouselIndex); ?>;
    </script>

</head>

<body id="noticias">
<?php echo $header; ?>
    
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/es_LA/sdk.js#xfbml=1&version=v2.0";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));
</script>

<div id="wrapper">
  <div class="wrapper top"></div>
        <div class="container overheader">
            <?php
                echo $modHeaderTags;
                echo $breakingNews;
            ?>
        </div>
        <?php echo $controllerHeader; ?>

        <div class="container bodier">
            <div class="unit c100 last">
                <div lass="unit c100 first">
                    <div class="unit c100 last">
                        <div class="unit c33 first">
                            <div class="mark sbt fbook">
                                <div class="fb-share-button" data-href="<?php echo $shareUrl; ?>" data-layout="button_count"></div>
                            </div>
                        </div>
                        <div class="unit c34 middle">
                            <!-- fragment start -->
                            <div class="mark sbt tweet">
                                <a href="https://twitter.com/share" class="twitter-share-button" data-url="<?php echo $shareUrl; ?>" data-text="La alfombra roja con lupa de los Oscar 2015" data-via="<?php echo $twitterAccount; ?>" data-lang="es">Twittear</a><script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
                            </div>
                        </div>
                        <div class="unit c33 last"><!-- fragment start -->
                            <div class="mark sbt gplus">
                                <div id="___plusone_0" style="text-indent: 0px; margin: 0px; padding: 0px; border-style: none; float: none; line-height: normal; font-size: 1px; vertical-align: baseline; display: inline-block; width: 90px; height: 20px; background: transparent;"><iframe frameborder="0" hspace="0" marginheight="0" marginwidth="0" scrolling="no" style="position: static; top: 0px; width: 90px; margin: 0px; border-style: none; left: 0px; visibility: visible; height: 20px;" tabindex="0" vspace="0" width="100%" id="I0_1422272958639" name="I0_1422272958639" src="https://apis.google.com/u/0/se/0/_/+1/fastbutton?usegapi=1&amp;size=medium&amp;count=true&amp;annotation=bubble&amp;origin=http%3A%2F%2Fwww.rtve.es&amp;url=http%3A%2F%2Fwww.rtve.es%2Fnoticias%2Flos-oscar-2015%2Falfombra-roja%2F&amp;gsrc=3p&amp;ic=1&amp;jsh=m%3B%2F_%2Fscs%2Fapps-static%2F_%2Fjs%2Fk%3Doz.gapi.es.lF-tgqCsjTA.O%2Fm%3D__features__%2Fam%3DAQ%2Frt%3Dj%2Fd%3D1%2Ft%3Dzcms%2Frs%3DAGLTcCOmiXRA7nq4keEqILuiIPlcD4ONZw#_methods=onPlusOne%2C_ready%2C_close%2C_open%2C_resizeMe%2C_renderstart%2Concircled%2Cdrefresh%2Cerefresh&amp;id=I0_1422272958639&amp;parent=http%3A%2F%2Fwww.rtve.es&amp;pfname=&amp;rpctoken=13854760" data-gapiattached="true" title="+1"></iframe></div>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-content">
						<ul class="slide-pager">
                            <?php for ($i = 1; $i <= count($aCarousel); $i++):
                                    if ($carouselIndex + 1 == $i) {
                                        echo "<li class='selected slide-pager-option'>". $i . "<a href=".formatImageName($aCarousel[$i][2])."></a></li>";
                                    } else {
                                        echo "<li class='slide-pager-option'>". $i . "<a href=".formatImageName($aCarousel[$i][2])."></a></li>";
                                    }
                                  endfor;
                            ?>
                        </ul>
                        <div class="content">
                            <div class="stage">
                                <div itemscope itemtype="http://schema.org/ImageObject">
                                    <div class="foto">
                                        <img id="carousel-image" title="<?php echo $aCarousel[$carouselIndex + 1][2]; ?> en los Oscar 2015 - RTVE.es" src="<?php echo $baseUrl; ?>fotosPublished/<?php echo $aCarousel[$carouselIndex + 1][1]; ?>" data-zoom-image="<?php echo $baseUrl; ?>fotosPublished/zoom/<?php echo $aCarousel[$carouselIndex + 1][1]; ?>" alt="<?php echo $aCarousel[$carouselIndex + 1][2]; ?> en los Oscar 2015" itemprop="image" />
                                    </div>
                                    <div class="txt">
                                      <h1 class="rtv03" itemprop="name"><?php echo $aCarousel[$carouselIndex + 1][2]; ?>, en la alfombra roja de los Oscar</h1>
                                      <span itemprop="provider"><?php echo $aCarousel[$carouselIndex + 1][3]; ?></span>
                                      <p itemprop="description"><?php echo str_replace("\"","'",targetBlank($aCarousel[$carouselIndex + 1][4])); ?></p>
                                      <meta itemprop="author" content="<?php echo count(explode("/", $aCarousel[$carouselIndex + 1][3])) > 1 ? array_pop(explode("/", $aCarousel[$carouselIndex + 1][3])) : ""; ?>" />
                                    </div>
                                </div>
                                <div class="socialshare">
                                <table width="100%" border="0">
                                  <tr>
                                    <td><div class="fb-share-button" data-href="<?php echo $shareUrl; echo formatImageName($aCarousel[$carouselIndex + 1][2]); ?>" data-layout="button_count"></div></td>
                                    <td><a href="https://twitter.com/share" class="twitter-share-button" data-url="<?php echo $shareUrl; echo formatImageName($aCarousel[$carouselIndex + 1][2]); ?>" data-text="<?php echo $aCarousel[$carouselIndex + 1][2]; ?>, en la alfombra roja de los Oscar 2015" data-via="<?php echo $twitterAccount; ?>" data-lang="es">Twittear</a><script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script></td>
                                  </tr>
                                </table>
                                </div>
                                <p class="zoom_info">
                                    Pasa el ratón sobre la foto para hacer zoom
                                </p>
                            </div>
                        </div>
                        <div class="slide-left">
                          <a id="photoprev" class="slide-link" href="<?php echo formatImageName($aCarousel[$carouselIndex == 0 ? count($aCarousel) : $carouselIndex][2]); ?>"></a>
                          <div class="overlay"></div>
                          <div class="button"></div>
                        </div>
                        <div class="slide-right">
                          <a id="photonext" class="slide-link" href="<?php echo formatImageName($aCarousel[$carouselIndex + 2 > count($aCarousel) ? 1 : $carouselIndex + 2][2]); ?>"></a>
                          <div class="overlay"></div>
                          <div class="button"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php echo $footer; ?>
<script type="text/javascript">
if ( (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) == false )  {
    $("#carousel-image").elevateZoom({ zoomType: "lens", lensShape: "round", lensSize: 300, containLensZoom: true, loadingIcon: "css/loader.gif" });
} else {
    document.write("\<script type='text\/javascript' src='js\/jquery.mobile.custom.min.js'\>\<\/script>");
    $(".zoom_info").hide();
}
</script>
</body>
</html>

