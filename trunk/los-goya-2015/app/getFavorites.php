<?php 

require_once "core/class/FavoritesHandler.php";

$favoritesHandle = new FavoritesHandler();
$favorites = $favoritesHandle->getFavorites();

$favoritesJson = "[";
foreach ($favorites as $i=>$favorite) {
	$favoritesJson .= "{";
	$favoriteId = $favorite->getId();
	$favoritesJson .= '"name":"'.utf8_encode($favorite->getName()).'",';
	if ($favorite->getImage() != '') {
		$favoritesJson .= '"image":"'.utf8_encode($favorite->getImage()).'"';
	} else {
		$favoritesJson .= '"image":"favorite-default.jpg"';
	}
	$favoriteTwitter = $favorite->getTwitter();
	if (sizeOf($favoriteTwitter) > 0) {
		$favoritesJson .= ',"twitterUrl":"'.utf8_encode($favoriteTwitter[0]).'"';	
	}
	$favoritesJson .= "}";
	if ($i < sizeOf($favorites)-1) {
		$favoritesJson .= ",";
	}
}
$favoritesJson .= "]";
print($favoritesJson);

?>