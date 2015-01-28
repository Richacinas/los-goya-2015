<?php

include '_partials/utils.php';

$footer = file_get_contents("http://www.rtve.es/comunes/pie/pie_portada.inc",0);
$header = utf8_encode(file_get_contents("http://wwww.rtve.es/comunes/cabecera/cabecera_portada.inc",0));
$modHeaderTags = file_get_contents("http://www.rtve.es/components/noticias/mod_cabecera_tags.inc",0);
$breakingNews = file_get_contents("http://www.rtve.es/components/noticias/breaking_news.inc",0);
$controllerHeader = file_get_contents("http://www.rtve.es/comunes/controlador/cabeceras_controlador.inc?cat=TE_SGOYA15&pag=portada&opcion=1",0);


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
    $carouselIndex = array_search($name."-goya-2015.jpg", array_values($aNameIndex));
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

    <title>La alfombra roja de Los Premios Goya - RTVE.es</title>
    <meta name="Title" content="La alfombra roja de Los Premios Goya - RTVE.es" />
    <meta name="Description" content="La alfombra roja de los Premios Goya 2015. Descubre los vestidos de las actrices , los mejores trajes de los actores y los famosos en la gala de los Goya 2015" />
    <meta name="Keywords" content="Alfombra roja, vestidos, fotos, premios Goya, premios goya, premios goya 2015, Premios Goya 2015, los Goya, los Goya 2015, Gala Premios Goya, Gala Premios Goya 2015, Gala los Goya, Gala los Goya 2015, noticias, ganadores, v&iacute;deos, videos, imagenes, fotos, fotograf&iacute;as" />
    <meta property="og:site_name" content="Lab RTVE.es Alfombra Roja"/>
    <meta property="og:title" content="<?php if ($ogTitle != "") { echo $ogTitle; ?>, en la <?php } else { ?>La <?php } ?> alfombra roja de Los Premios Goya - Premios Goya 2015"/>
    <meta property="og:description" content="La alfombra roja de los Premios Goya 2015. Descubre los vestidos de las actrices , los mejores trajes de los actores y los famosos en la gala de los Goya 2015"/>
    <meta property="og:url" content="http://<?php echo $baseUrl; ?>/los-goya-2015/alfombra-roja/<?php echo $name; ?>"/>
    <meta property="og:image" content="http://<?php echo $baseUrl; ?>/los-goya-2015/alfombra-roja/fotosPublished/zoom/<?php echo $aCarousel[$carouselIndex + 1][1]; ?>"/>
    
    
    <link rel="stylesheet" type="text/css" href="css/style.css"/>
    <link rel="stylesheet" type="text/css" href="css/zoom.css"/>
    <link rel="stylesheet" href="http://www.irtve.es/css/style2011/style.css" type="text/css" media="all"/>
    <link rel="stylesheet" href="http://www.irtve.es/css/tipografias.css" type="text/css"/>
    <link rel="stylesheet" href="http://www.irtve.es/css/rtve.cabeceras/css-dinamico.css?cat=TE_SGOYA15&plantilla=tplX_cab" type="text/css"/>
    <link rel="stylesheet" href="http://www.irtve.es/css/rtve.cabeceras/css-dinamico.css?cat=TE_SGOYA15&plantilla=tplX" type="text/css"/>
    <link rel="stylesheet" href="http://www.irtve.es/css/rtve.2015/rtve.transicion/portada.css" type="text/css"/>
    <link rel="stylesheet" href="http://www.irtve.es/css/rtve.noticias/rtve.noticias.cultura/goya2015/goya2015.css" type="text/css"/>
    



    <script type="text/javascript" src="http://www.rtve.es/js/rtve.pack.js"></script>
    <script language="javascript" type="text/javascript" src="js/jquery.easing.1.3.js" ></script>
    <script language="javascript" type="text/javascript" src="js/cufon-yui-1.09.js" ></script>
    <script language="javascript" type="text/javascript" src="js/jquery.jcarousel.min.js" ></script>
    <script language="javascript" type="text/javascript" src="js/script.js" ></script>
    <script language="javascript" type="text/javascript" src="//www.rtve.es/js/mushrooms/rtve_mushroom.js" ></script>
    
    <script language="javascript" type="text/javascript">
        var carouselIndex = <?php print($carouselIndex); ?>;
    </script>
    
</head>
    
<body id="noticias">
<?php echo $header; ?>
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
                                <div class="fb-share-button" data-href="http://www.rtve.es/noticias/los-goya-2015/alfombra-roja/" data-layout="button_count"></div>
                            </div>
                        </div>
                        <div class="unit c34 middle"> 
                            <!-- fragment start --> 
                            <div class="mark sbt tweet">
                                <a href="https://twitter.com/share" class="twitter-share-button" data-url="http://www.rtve.es/noticias/los-goya-2015/alfombra-roja/" data-text="La alfombra roja con lupa de los Premios Goya 2015" data-via="<?php echo $twitterAccount; ?>" data-lang="es">Twittear</a><script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
                            </div>
                        </div>
                        <div class="unit c33 last"><!-- fragment start --> 
                            <div class="mark sbt gplus">
                                <div id="___plusone_0" style="text-indent: 0px; margin: 0px; padding: 0px; border-style: none; float: none; line-height: normal; font-size: 1px; vertical-align: baseline; display: inline-block; width: 90px; height: 20px; background: transparent;"><iframe frameborder="0" hspace="0" marginheight="0" marginwidth="0" scrolling="no" style="position: static; top: 0px; width: 90px; margin: 0px; border-style: none; left: 0px; visibility: visible; height: 20px;" tabindex="0" vspace="0" width="100%" id="I0_1422272958639" name="I0_1422272958639" src="https://apis.google.com/u/0/se/0/_/+1/fastbutton?usegapi=1&amp;size=medium&amp;count=true&amp;annotation=bubble&amp;origin=http%3A%2F%2Fwww.rtve.es&amp;url=http%3A%2F%2Fwww.rtve.es%2Fnoticias%2Flos-goya-2015%2Falfombra-roja%2F&amp;gsrc=3p&amp;ic=1&amp;jsh=m%3B%2F_%2Fscs%2Fapps-static%2F_%2Fjs%2Fk%3Doz.gapi.es.lF-tgqCsjTA.O%2Fm%3D__features__%2Fam%3DAQ%2Frt%3Dj%2Fd%3D1%2Ft%3Dzcms%2Frs%3DAGLTcCOmiXRA7nq4keEqILuiIPlcD4ONZw#_methods=onPlusOne%2C_ready%2C_close%2C_open%2C_resizeMe%2C_renderstart%2Concircled%2Cdrefresh%2Cerefresh&amp;id=I0_1422272958639&amp;parent=http%3A%2F%2Fwww.rtve.es&amp;pfname=&amp;rpctoken=13854760" data-gapiattached="true" title="+1"></iframe></div>
                            </div>
                        </div>
                    </div>
                    <div class="scroll-panel">
                      <div class="scroll-inner-panel">
                        <div class="scroll-content">
                          <div class="content">
                            <div class="section-slider">
                              <div class="slider-container">
                                <ul class="image-carousel">
                                    <?php foreach($aCarousel as $key=>$aElement): ?>
                                        <li>
                                            <iframe src="item.php?foto=<?php print($aCarousel[$key][1]); ?>&nombre=<?php print($aCarousel[$key][2]); ?>&fotografo=<?php print($aCarousel[$key][3]); ?>&texto=<?php print(str_replace("\"","'",targetBlank($aCarousel[$key][4]))); ?>" title="" frameborder="0" scrolling="no" allowtransparency="true" name="menucontent" id="menucontent" height="900px" width="920"></iframe>
                                        </li>
                                      <?php endforeach; ?>
                                </ul>
                                <div class="slide-left">
                                  <div class="overlay"></div>
                                  <div class="button"></div>
                                </div>
                                <div class="slide-right">
                                  <div class="overlay"></div>
                                  <div class="button"></div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                </div>
            </div>
        </div>
</div>
<?php echo $footer; ?>
</body>
</html>

