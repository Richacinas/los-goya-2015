<?php
set_time_limit(0);

/* Action to get and count Favorites appearances in the twitter Stream */
require_once "../app/core/class/FavoritesHandler.php";

/* Favorites manager/handler instance */
$favoritesHandler = new FavoritesHandler();
/* Get streaming JSON files one by one processing their tweets to find
   favorites appearances writing them into /data/favorites/favorites-appearances.json */
$favoritesHandler->handleAppearancesInStreamingFiles();

set_time_limit(30);
?>