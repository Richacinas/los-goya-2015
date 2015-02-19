<?php

include 'partials/utils.php';

$name = isset($_POST['nombre-famoso']) ? $_POST['nombre-famoso'] : '';
$data = getCarouselData(true);
$aCarousel = $data[0];
$aCarousel = array_values($aCarousel);
$aNameIndex = $data[1];
$aNameIndex = array_values($aNameIndex);

unset($_POST);
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
        $ogTitle = $aCarousel[$carouselIndex ][2];
    }
}
else {
    $carouselIndex = 0;
}
$fecha = date_create();

?>
<ul class="slide-pager">
    <?php for ($i = 0; $i < count($aCarousel); $i++):
            if ($carouselIndex  == $i) {
                echo "<li class='selected slide-pager-option'>". ($i + 1) . "<a href=".formatImageName($aCarousel[$i][2])."></a></li>";
            } else {
                echo "<li class='slide-pager-option'>". ($i + 1) . "<a href=".formatImageName($aCarousel[$i][2])."></a></li>";
            }
          endfor;
    ?>
</ul>
<div class="content">
    <div class="stage">
      <div itemscope itemtype="http://schema.org/ImageObject">
        <div class="foto">
            <img id="carousel-image" title="<?php echo $aCarousel[$carouselIndex ][2]; ?> en los Oscar 2015 - RTVE.es" src="<?php echo $baseUrl; ?>fotosPublished/<?php echo $aCarousel[$carouselIndex ][1]; ?>?t=<?php echo date_timestamp_get($fecha); ?>" data-zoom-image="<?php echo $baseUrl; ?>fotosPublished/zoom/<?php echo $aCarousel[$carouselIndex ][1]; ?>?t=<?php echo date_timestamp_get($fecha); ?>" alt="<?php echo $aCarousel[$carouselIndex ][2]; ?> en los Oscar 2015" itemprop="image" />
        </div>
        <div class="txt">
          <h1 class="rtv03" itemprop="name"><?php echo $aCarousel[$carouselIndex ][2]; ?>, en la alfombra roja de los Oscar</h1>
          <span itemprop="provider"><?php echo $aCarousel[$carouselIndex ][3]; ?></span>
          <p itemprop="description"><?php echo str_replace("\"","'",targetBlank($aCarousel[$carouselIndex ][4])); ?></p>
          <meta itemprop="author" content="<?php echo count(explode("/", $aCarousel[$carouselIndex ][3])) > 1 ? array_pop(explode("/", $aCarousel[$carouselIndex ][3])) : ""; ?>" />
        </div>
      </div>
      <div class="socialshare">
      <table width="100%" border="0">
        <tr>
          <td><div class="fb-share-button" data-href="<?php echo $shareUrl; echo formatImageName($aCarousel[$carouselIndex ][2]); ?>" data-layout="button_count"></div></td>
          <td><a href="https://twitter.com/share" class="twitter-share-button" data-url="<?php echo $shareUrl; echo formatImageName($aCarousel[$carouselIndex ][2]); ?>" data-text="<?php echo $aCarousel[$carouselIndex ][2]; ?>, en la alfombra roja de los Oscar 2015" data-via="<?php echo $twitterAccount; ?>" data-lang="es">Twittear</a><script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script></td>
        </tr>
      </table>
      </div>
      <p class="zoom_info">
          Pasa el ratón sobre la foto para hacer zoom
      </p>
    </div>
</div>
<div class="slide-left">
	<a id="photoprev" class="slide-link" href="<?php echo formatImageName($aCarousel[$carouselIndex == 0 ? count($aCarousel) - 1 : $carouselIndex - 1][2]); ?>"></a>
    <div class="overlay"></div>
    <div class="button"></div>
</div>
<div class="slide-right">
    <a id="photonext" class="slide-link" href="<?php echo formatImageName($aCarousel[$carouselIndex + 1 >= count($aCarousel) ? 0 : $carouselIndex + 1][2]); ?>"></a>
    <div class="overlay"></div>
    <div class="button"></div>
</div>                          
<script>
if ( (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) == false )  {
    $("#carousel-image").elevateZoom({ zoomType: "lens", lensShape: "round", lensSize: 300, containLensZoom: true, loadingIcon: "css/loader.gif" });
} else {
    $(".zoom_info").hide();
}
</script>

