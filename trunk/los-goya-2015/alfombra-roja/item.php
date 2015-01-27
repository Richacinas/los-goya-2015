<?php

include '_partials/utils.php';

$foto = $_GET["foto"];
$nombre = $_GET["nombre"];
$fotografo = $_GET["fotografo"];
$texto = $_GET["texto"];

$nameIndex = formatImageName($nombre);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<title><?php echo $nombre; ?> en Los Premios Goya 2015 - RTVE.es</title>
<meta name="Title" content="<?php echo $nombre; ?> en Los Premios Goya 2015 - RTVE.es" />
<meta name="Description" content="Los Goya 2015 - <?php echo $texto; ?>" />
<meta name="Keywords" content="Alfombra roja, vestidos, fotos, premios Goya, premios goya, premios goya 2015, Premios Goya 2015, los Goya, los Goya 2015, Gala Premios Goya, Gala Premios Goya 2015, Gala los Goya, Gala los Goya 2015, noticias, ganadores, v&iacute;deos, videos, imagenes, fotos, fotograf&iacute;as" />
<meta property="og:site_name" content="Lab RTVE.es Alfombra Roja">
<meta property="og:title" content="La alfombra roja de Los Premios Goya - Premios Goya 2015 | Lab RTVE.es">
<meta property="og:description" content="La alfombra roja de los Premios Goya 2015. Descubre los vestidos de las actrices , los mejores trajes de los actores y los famosos en la gala de los Goya 2015">
<meta property="og:url" content="http://<?php echo $baseUrl; ?>/los-goya-2015/alfombra-roja/<?php echo $nameIndex; ?>">
<meta property="og:image" content="<?php echo $baseUrl; ?>/los-goya-2015/alfombra-roja/fotos/zoom/<?php echo $foto; ?>">

<link rel="stylesheet" type="text/css" href="css/zoom.css"/>

<script type="text/javascript" src="js/slider_jquery.js"></script>
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/zoom.js"></script>
<script type="text/javascript" src="//www.rtve.es/js/mushrooms/rtve_mushroom.js" ></script>

</head>
<body>

<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/es_LA/sdk.js#xfbml=1&version=v2.0";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

    <div class="content">
        <div class="stage">
          <div class="foto">
              <a title="" href="fotos/zoom/<?php echo $foto; ?>" class="jqzoom">
                  <span class="zoom"></span>
                  <div itemscope itemtype="http://schema.org/ImageObject">
                      <img class="carrousel_image" title="<?php echo $nombre; ?> en Los Premios Goya 2015 - RTVE.es" src="fotos/<?php echo $foto; ?>" alt="<?php echo $nombre; ?> en Los Premios Goya 2015" itemprop="image" />
                  </div>
              </a> 
          </div>
          <div class="txt">
            <h1 class="rtv03"><?php echo $nombre; ?> en los Goya 2015</h1>
            <span><?php echo $fotografo; ?></span>
            <p><?php echo $texto; ?></p>
          </div>
          <div class="socialshare">
          <table width="100%" border="0">
            <tr>
              <td><div class="fb-share-button" data-href="http://<?php echo $baseUrl; ?>/los-goya-2015/alfombra-roja/<?php echo $nameIndex; ?>" data-layout="button_count"></div></td>
              <td><a href="https://twitter.com/share" class="twitter-share-button" data-url="http://<?php echo $baseUrl; ?>/los-goya-2015/alfombra-roja/<?php echo $nameIndex; ?>" data-text="<?php echo $nombre; ?>, en la alfombra roja de los Goya 2015" data-via="<?php echo $twitterAccount; ?>" data-lang="es">Twittear</a><script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script></td>
            </tr>
          </table>
          </div>
        </div>
    </div>
<script type="text/javascript" src="//assets.pinterest.com/js/pinit.js"></script>
</body>
</html>
