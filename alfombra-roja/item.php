<?php

include '_partials/utils.php';

/*$foto = $_GET["foto"];
$nombre = $_GET["nombre"];
$fotografo = $_GET["fotografo"];
$texto = $_GET["texto"];

$nameIndex = formatImageName($nombre);*/

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

<div class="content">
    <div class="stage">
      <div class="foto">
          <a title="" href="fotosPublished/zoom/<?php echo $aCarousel[$carouselIndex + 1][1]; ?>" class="jqzoom">
              <span class="zoom"></span>
              <div itemscope itemtype="http://schema.org/ImageObject">
                  <img id="carrousel_image" title="<?php echo $aCarousel[$carouselIndex + 1][2]; ?> en Los Premios Goya 2015 - RTVE.es" src="fotosPublished/<?php echo $aCarousel[$carouselIndex + 1][1]; ?>" data-zoom-image="fotosPublished/zoom/<?php echo $aCarousel[$carouselIndex + 1][1]; ?>" alt="<?php echo $aCarousel[$carouselIndex + 1][2]; ?> en Los Premios Goya 2015" itemprop="image" />
              </div>
          </a>
      </div>
      <div class="txt">
        <h1 class="rtv03"><?php echo $aCarousel[$carouselIndex + 1][2]; ?> en los Goya 2015</h1>
        <span><?php echo $aCarousel[$carouselIndex + 1][3]; ?></span>
        <p><?php echo print(str_replace("\"","'",targetBlank($aCarousel[$carouselIndex + 1][4]))); ?></p>
      </div>
      <div class="socialshare">
      <table width="100%" border="0">
        <tr>
          <td><div class="fb-share-button" data-href="http://<?php echo $baseUrl; ?>/los-goya-2015/alfombra-roja/<?php echo formatImageName($aCarousel[$carouselIndex + 1][2]); ?>" data-layout="button_count"></div></td>
          <td><a href="https://twitter.com/share" class="twitter-share-button" data-url="http://<?php echo $baseUrl; ?>/los-goya-2015/alfombra-roja/<?php echo formatImageName($aCarousel[$carouselIndex + 1][2]); ?>" data-text="<?php echo $aCarousel[$carouselIndex + 1][2]; ?>, en la alfombra roja de los Goya 2015" data-via="<?php echo $twitterAccount; ?>" data-lang="es">Twittear</a><script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script></td>
        </tr>
      </table>
      </div>
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
<script>
$("#carrousel_image").elevateZoom({ zoomType: "lens", lensShape: "round", lensSize: 300, containLensZoom: true });
</script>

