<?php

/** 
* getTimelineData.php
* --------------------------------
*   PHP para ejecución en una tarea programada que hace peticiones a Twitter e Instagram del 
*   usuario configurado (@lab_rtvees) para recoger los posts del Timeline de ese usuario, tanto 
*   tweets y retweets como tweets de los usuarios a los que se sigue con estas cuentas. 
*
*	El resultado se almacena en:
*	/data/stream-favorites/data.php : resultado final de tweets/ig-posts.
*   /data/stream-favorites/timeline.json : Log
*	/data/stream-favorites/<current-timestamp>.json : tweets/posts de la petición en el timestamp actual.
*
* @prop /data/stream-favorites/data.php -> archivo donde almacenamos nuestros dato con la siguiente estructura:
*   - users: almacenando usuarios
*     - tipo: tipo de usuarios ('tw')
*       - usuarios
*   - reqs: los requests almacenados
*     - tipo de request ('tw', 'twlist....')
*       - texto del request
*         - elementos
*/

setlocale(LC_ALL,"es_ES");
define('SITE_ROOT', dirname(__FILE__));

  /* librerias */
$socialTwitter    = SITE_ROOT . '/../app/core/social/socialTwitter.php';     // -> herramientas de gestion de Twitter
$socialInstagram  = SITE_ROOT . '/../app/core/social/socialInstagram.php';   // -> herramientas de gestion de Instagram
require_once $socialTwitter;
require_once $socialInstagram;

// Ruta de los ficheros de funciones PHP que cargamos
$functions_properties   = SITE_ROOT . '/../app/core/functions_properties.php'; // -> herramientas de gestion de archivos de configuracion
$outputFolder           = SITE_ROOT . '/../data/stream-favorites/';                   // carpeta de datos
$saveData               = $outputFolder . 'data.php';                   // información general de las búsquedas
$logFile                = $outputFolder . 'timeline.json';              // timeline de archivos procesados

if (!file_exists($outputFolder)) { mkdir($outputFolder); }

$file_SearchTerms       = SITE_ROOT . '/../data/properties/searchTerms.json';              // -> Fichero JSON con los terminos de busqueda

$currTime              = date("mdHi");

require_once $functions_properties;

$jsonSearchTerms_a  = json_decode(file_get_contents($file_SearchTerms), true);

$tags               = $jsonSearchTerms_a["tags"];
$search             = $jsonSearchTerms_a["search"];

$data = array();
$data['search'] = array();

require_once SITE_ROOT . '/../app/core/class/Config.php';
require_once SITE_ROOT . '/../app/core/class/TwRest.php';
require_once SITE_ROOT . '/../app/core/class/IgRest.php';

$config = new Config($saveData, $logFile);
$log  = json_decode(file_get_contents($logFile), true);

/* BEGIN CRONJOB PROCESS HERE */
/* GET TWITTER TIMELINE */
$twrest = new TWREST($saveData, $logFile);
$myTwitterTimeline = $twrest->getTimeline();
if($myTwitterTimeline && count($myTwitterTimeline) && !isset($myTwitterTimeline->errors)) {
	$twrest->processTimeline($myTwitterTimeline, $search);
	$config->setTwConfig($twrest->getConfig());
}
/* GET INSTAGRAM TIMELINE */
$igrest = new IGREST($saveData, $logFile);
$myInstagramTimeline = $igrest->getTimeline();
if($myInstagramTimeline && count($myInstagramTimeline) && !isset($myInstagramTimeline->errors)) {
	$igrest->processTimeline($myInstagramTimeline, $search);
	$config->setIgConfig($igrest->getConfig());
}

/* SAVE/STORE Timelines DATA only if there are new TW or IG data */
if($twrest->newTweetsProcessed() || !$igrest->newIgPostsProcessed()) {
	// Store Config (with lastIds for Tweets and IgPosts) in /data/stream-favorites/data.php
	MyConfig::write($saveData, $config->getConfig());
	// Saving obtained data (posts/tweets)
	$twData = $twrest->getTwData();
	$igData = $igrest->getIgData();
	$data['search'] = array_merge($twData['search'], $igData['search']);
	if(isset($data) && $data != null){
		// Store <current-timestamp>.json
  		writeJson($outputFolder . $currTime . '.json', $data);
  		// Store timeline.json (logfile)
  		array_push($log, $currTime);
  		writeJson($logFile, $log);
  		print('Escrito '.$outputFolder . $currTime . '.json'.PHP_EOL);
	}
  	print('========================================'.PHP_EOL);
}
?>