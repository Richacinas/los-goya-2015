<?php

/** 
* twitterStream.php
* --------------------------------
*   Generador de datos para timelines de tweets.
*
*   gracias a la api de streaming de Twitter (https://dev.twitter.com/docs/streaming-apis)
*   podemos hacer un rápido control de tweets sin gran proceso del servidor. El código
*   recibe todos los tweets para las búsquedas que demos y va contando los tweets por minuto
*   para cada tag. El resultado se escribe en un archivo json que se actualiza una vez cada
*   minuto, con los datos del minuto anterior.
*   
*   Igual que la api de streaming, este código se ejecuta asíncronamente, osea que la función
*   se ejecuta perpétuamente hasta que abortemos el hilo. Se programa un cron para esta tarea.
*   
* @prop $tags -> array con los tags a buscar. Cada elemento del array se contará por separado, y 
*     dentro del array se pueden separar elementos con comas para traquear varios tags juntos
* @prop $outputlog -> ruta del archivo json final
* @prop $log -> escupe todos los tweets
*/

//require_once 'cronLabSocial.php';
error_reporting(E_ALL ^ E_NOTICE);
setlocale(LC_ALL,"es_ES");

define('SITE_ROOT', dirname(__FILE__));

  // deshabilita limite de tiempo
set_time_limit(0);

  /* nuestra pequeña librería */
$functions_properties   = SITE_ROOT . '/../app/core/functions_properties.php'; // -> herramientas de gestion de archivos de configuracion
$functions_twitter      = SITE_ROOT . '/../app/core/social/socialTwitter.php'; // -> herramientas de gestion de archivos de configuracion
$functions_tmhOAuth     = SITE_ROOT . '/../app/core/social/api/twitter/tmhOAuth/tmhOAuth.php';
  /* Importacion de ficheros */
require_once $functions_properties;
require_once $functions_twitter;
require_once $functions_tmhOAuth;

  /* donde se ponen los archivos que generamos */
$dataFolder             = SITE_ROOT . '/../data/';
$outputFile             = $dataFolder . 'timeline.json';
$outputTotals           = $dataFolder . 'totals.json';

  /* archivo de settings */
$file_SearchTerms       = SITE_ROOT . '/../data/properties/searchTerms.json';              // -> Fichero JSON con los terminos de busqueda

  /* Definicion de variables */
$data                 = array();
$users                = array();

$log                  = array();
$data['users']        = array();
$colors               = array('red'=>"\033[31m", 'blue'=>"\033[36m", 'brown'=>"\033[33m", 'green'=>"\033[32m", 'end'=>"\033[0m");

  /* el timestamp que determina cuando pasa un minuto */
$currTime             = date("mdHi");

  /* Inicializacion de parametros */
$logging            = true;                                 // false para modo silencioso, true para que nos de feedback

  /* leemos términos de búsqueda */
$jsonSearchTerms_a  = json_decode(file_get_contents($file_SearchTerms), true);
  /* y descomponemos sus parámetros*/
$timeJSON           = $jsonSearchTerms_a["time"];         // Indica cuando se ha generado
$tags               = $jsonSearchTerms_a["tags"];         // Tags a procesar
$search             = $jsonSearchTerms_a["search"];       // Cadenas de busqueda a procesar
$filter             = $jsonSearchTerms_a["filter"];       // Indica si el Filtro esta activo

$tmhOAuth           = new tmhOAuthExample();

// leemos el timeline
$subtotals = json_decode(file_get_contents($GLOBALS['outputTotals']),true);

// Get popular people from Stored Files
require_once '../app/core/class/FavoritesHandler.php';
$GLOBALS['favoritesHandler'] = $favoritesHandle = new FavoritesHandler();

if(!$subtotals) { // si no hay subtotales generamos el array
  $subtotals = array('global' => array(), 'searchs' => array());
}

  // llamada al Stream!!
$code = $tmhOAuth->streaming_request(
  'GET',
  'https://stream.twitter.com/1.1/statuses/filter.json',
  array('track' => implode(',', $tags)),
  'my_streaming_callback'
);

$tmhOAuth->render_response();

    // busca cadena de texto en el texto del tweet
function isTagInTweet($tweet, $text) {
  if(stripos($tweet, $text) !== false) { return true; }
  return false;
}

  // callback que se ejecuta para cada tweet que nos llega
function my_streaming_callback($data, $length, $metrics) {

  $subtotals    = &$GLOBALS['subtotals'];
  $time         = date("mdHi");
  $search       = $GLOBALS['search'];
  $filter       = $GLOBALS['filter'];
  $datum        = &$GLOBALS['data'];
  $users        = &$GLOBALS['data']['users'];

  // código a ejecutar una si estamos en un MINUTO NUEVO (osea que por lo menos se ejecute una vez al minuto)
  if($time != $GLOBALS['currTime']) {

      // reiniciamos timestamp
    $GLOBALS['currTime'] = $time;

    // Volvemos a leer el archivo de búsquedas y vemos si ha cambiado
    $jsonSearchTerms_aux_a = json_decode(file_get_contents($GLOBALS['file_SearchTerms']), true);
    $timeJSON_aux = $jsonSearchTerms_aux_a["time"];

        // han cambiado los terminos de búsqueda? -> los reemplazamos
    if ( $timeJSON_aux != $GLOBALS['timeJSON'] ) {
        // guardamos para la próxima
      $GLOBALS['timeJSON'] = $timeJSON_aux;

      // Tienen un valor distinto -> Volver a cargar los terminos de busqueda
      $search = $GLOBALS['search'] = $jsonSearchTerms_aux_a["search"];
      $filter = $GLOBALS['filter'] = $jsonSearchTerms_aux_a["filter"];

      if($GLOBALS['logging']) echo PHP_EOL.'Se generaron nuevos terminos de busqueda '.PHP_EOL;
    }

    if(isset($datum['search'])) { // si no hay datos en $datum searh, no hay ningún post, por lo que no escribimos

        // log de archivos procesados (timeline.json)
      $log = &$GLOBALS['log'];
      array_push($log, $time);

      if($GLOBALS['logging']) echo PHP_EOL.'escrito '.$time.'.json'.PHP_EOL;

        // escribimos los archivos
      writeJson($GLOBALS['dataFolder'] . $time . '.json', $datum);
      writeJson($GLOBALS['outputFile'], $log);
      writeJson($GLOBALS['outputTotals'], $subtotals);

        // y vaciamos el superarray
      $datum = array();
    }
  }

  if($GLOBALS['logging']) echo ' t';

    // el tuit en cuestion
  $twt = json_decode($data);

        // si no hay texto no hay tweet -> error
  if(!isset($twt->text)) {
    if($GLOBALS['logging'] && isset($twt->limit) && isset($twt->limit->track)){ // si hay log mostramos los tweets perdidos
      echo $GLOBALS['colors']['red'].'+'.$twt->limit->track.$GLOBALS['colors']['end'];
    }
  } else {
    // el twitt está ok -> PROCEDAMOS

      // aumentamos contador global
    if(!isset($datum['total'])) {
      $datum['total'] = 0;
    }
    $datum['total'] ++;

      // aumentamos contador global
    if(!isset($subtotals['global'][$time])) {
      $subtotals['global'][$time] = 0;
    }
    $subtotals['global'][$time] ++;

    $found = false;
    $tags = array();


    /* Searching favorites in tweet and saving/increasing appeareances */
    $favoritesHandler = $GLOBALS['favoritesHandler'];
    $favoritesHandler->handleAppearancesInTweet($twt->text);

      // buscamos nuestras palabras en el tweet
    for ($i=0; $i < count($search); $i++) {

        // divide tags compuestos -> podemos hacerlo fuera una sola vez
      $arrayTags = explode(',', $search[$i]);

          // busca cada cadena y procesa el tweet
      for ($j=0; $j < count($arrayTags); $j++) {

            // encontrado!!
        //if (isTagInTweet($twt->text, $arrayTags[$j])) {
      	if (true) {

          $found = true;

          // aumentamos contador global
          if(!isset($subtotals['searchs'][$arrayTags[0]])) {
            $subtotals['searchs'][$arrayTags[0]] = array($time => 0);
          }
          if(!isset($subtotals['searchs'][$arrayTags[0]][$time])) {
            $subtotals['searchs'][$arrayTags[0]][$time] = 0;
          }
          $subtotals['searchs'][$arrayTags[0]][$time] ++;

          // salvo para contar ignoramos retuits
          if (!isset($twt->retweeted_status)) {

            if($GLOBALS['logging']) echo $GLOBALS['colors']['green'].'weet '.$GLOBALS['colors']['end'];

            // procesamos usuarios
            if(!isset($users[$twt->user->id])){
              $users[$twt->user->id] = processTwUser($twt->user);
            }

            // guardamos los tags encontrados
            array_push($tags, $arrayTags[0]);

          } else {

            if($GLOBALS['logging']) echo $GLOBALS['colors']['blue'].'r '.$GLOBALS['colors']['end'];

          }

        } 

      }

    }

    if(!$found){
          // no encontrado
      if($GLOBALS['logging']) echo $GLOBALS['colors']['brown'].'x '.$GLOBALS['colors']['end'];
    } else {
      $twetprocs = processTweet($twt);
      $twetprocs['tags'] = $tags;

        // guardamos el twet
      if(!isset($datum['search'])) $datum['search'] = array();
      array_push($datum['search'], $twetprocs);
    }

  }

}