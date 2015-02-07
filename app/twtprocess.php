<?php 

/** 
* twtprocess.php
* --------------------------------
**/

  // inicializando
error_reporting(E_ALL ^ E_NOTICE);
setlocale(LC_ALL,"es_ES");

header('Content-Type: text/html; charset=utf-8');

ini_set("display_startup_errors ",1); 
ini_set("error_reporting",E_ALL); 
ini_set('display_errors', 1);
date_default_timezone_set('Europe/Madrid');

ob_start('ob_gzhandler');

define('SITE_ROOT', dirname(__FILE__));

// deshabilita limite de tiempo
set_time_limit(0);


// Ruta de los ficheros de funciones PHP que cargamos
$twitterFunctions       = SITE_ROOT . '/core/social/socialTwitter.php'; // -> herramientas de gestion de archivos de configuracion
$igFunctions            = SITE_ROOT . '/core/social/socialInstagram.php'; // -> herramientas de gestion de archivos de configuracion
$mTveFunctions          = SITE_ROOT . '/core/social/socialMtve.php'; // -> herramientas de gestion de archivos de configuracion
$vineFunctions          = SITE_ROOT . '/core/social/socialVine.php'; // -> herramientas de gestion de archivos de configuracion
$functions_properties   = SITE_ROOT . '/core/functions_properties.php'; // -> herramientas de gestion de archivos de configuracion


$radarDataFolder        = SITE_ROOT . '/../radar/final/';
$saveDataminute         = $radarDataFolder . 'minute.json'; // el json del último minuto
$saveDatatotal          = $radarDataFolder . 'total.json'; // el json definitiva
$saveDataphp            = $radarDataFolder . 'data.php'; // almacenando temporalmente
$dataFolder             = SITE_ROOT . '/../data/';
$totalsJson             = $dataFolder . 'totals.json'; // datos totales
$favoritesStreamFolder  = SITE_ROOT . '/../data/stream-favorites/';
$favoritesFolder  = SITE_ROOT . '/../data/favorites/';

$file_SearchTerms       = SITE_ROOT . '/../data/properties/searchTerms.json';
$pathProperties         = SITE_ROOT . '/../data/properties/entorno.properties';


require_once $functions_properties;
$properties   = filePropertiesToArray($pathProperties);

// Obtenemos los datos del properties
$ftp_server         = $properties['FTP_SERVER'];
$ftp_user_name      = $properties['FTP_USER_NAME'];
$ftp_user_pass      = $properties['FTP_USER_PASS'];
$ftp_remote_folder  = $properties['FTP_REMOTE_FOLDER'];

$currTime           = date("mdHi");

// Convertimos a array los datos del JSON de los terminos de busqueda

$jsonSearchTerms    = file_get_contents($file_SearchTerms);
$jsonSearchTerms_a  = json_decode($jsonSearchTerms, true);

$timeJSON           = $jsonSearchTerms_a["time"];         // Indica cuando se ha generado
$tags               = $jsonSearchTerms_a["tags"];         // Tags a procesar
$search             = $jsonSearchTerms_a["search"];       // Cadenas de busqueda a procesar
$filter             = $jsonSearchTerms_a["filter"];       // Indica si el Filtro esta activo

// Token de seguridad CSRF
if (isset($_POST['token'])) {
    $token['csrf_token'] = $_POST['token'];
} else if (isset($_GET['token'])) {
    $token['csrf_token'] = $_GET['token'];
} else {
    $token['csrf_token'] = $jsonSearchTerms_a["token"];       
}

session_start(); 
require_once('core/class/NoCsrf.php');


if(isset($argv) && isset($argv[1])) {
  $method = $argv[1];
} else if(isset($_GET['method'])){
  $method = $_GET['method'];
} else if (isset($_POST['method'])) {
  $method = $_POST['method'];
} else {
  die('no se indicó acción');
}

  // según el parámetro method haremos una cosa u otra;
switch ($method) {
  case 'completeGlobals':
    $timeline = json_decode(file_get_contents($GLOBALS['totalsJson']),true);
    $timelineGlobal = $timeline['global'];
    completeTimelineWithEmptyMoments($timelineGlobal);
  break;
    // fuerza a procesar 
  case 'refresh':
    initializaDatos();
    saveData();
    echo 'done';  
    break;

    // actualiza los terminos de busqueda
  case 'update':
    //checkToken($token);      
    initializaDatos();

    // Actualizamos los valores
    $jsonSearchTerms    = file_get_contents($file_SearchTerms);
    $jsonSearchTerms_a  = json_decode($jsonSearchTerms, true);

    $GLOBALS['search']     = $jsonSearchTerms_a['search'];
    $GLOBALS['filter']     = $jsonSearchTerms_a['filter'];

    esHoraDeActualizar();

    echo 'done';
    break;

    // borra un elemento
  case 'delete':
    //checkToken($token);
    initializaDatos();

    $id = $_POST['id'];

    //$string = file_get_contents($saveDatatotal);
    //$json_a = json_decode($string, true);

    // Comprobamos que el objeto este definido
    if ($id) {
      deleteData($id);
      writeData();
      esHoraDeActualizar();
      print('deleted');
      /*$otroData = $json_a["data"];

      $i = 0;

      foreach( $otroData as $key => $value) {
        if ( strcmp($otroData[$key]["id"], $id) == 0 ) {
          unset($json_a["data"][$i]);
          print('//done//');
        } else {
          print('//no encontrado//');
        }

        $i++;
      }

      file_put_contents($saveDatatotal, json_encode($json_a));*/
    } else {
      print('error');
    }
    break;
    // checkea links
  case 'check':
    //checkToken($token);
    if(!isset($_POST['link']) || !isset($_POST['type']) || !isset($_POST['tag'])) die('error en los parámetros recibidos');

      // cargamos datos de tweets
    initializaDatos();

    $link = $_POST['link'];
    $type = $_POST['type'];
    $tag = $_POST['tag'];
    /*
    echo "\n\n----------\n\n";

    echo "link: " . $link . "\n";
    echo "type: " . $type . "\n";
    echo "tag: " . $tag . "\n";

    */

    if(strpos($link, 'twitter.com') != false && strpos($link, 'status') != false) {
      include_once($twitterFunctions);
      $twtFull = getTweetFullWithLink($link);
      if ( $twtFull ) {
        $twt = processTweet($twtFull);
        $usr = processTwUser($twtFull->user);
        if ( isset($tag)) {
          $twt['tags']  = array($tag);
        }
        if (isset($type) ) {
          $twt['type'] = $type;
        }
        if (isset($usr)) {
          $twt['userData'] = $usr;
        }

        if(is_array($twt) && !isset($twt['media'])) $twt['type'] = 'txt';

        sendTweet($twt['userData']);
          // guardamos
        addData($twt);

        // TWEET AL AUTOR AGRADECIMIENTO

        //echo json_encode($twt);
        echo 'done';
          esHoraDeActualizar();
        return true;

      } else {

        echo 'error';
        return false;

      }

          // procesado de fotos de instagram
    } elseif (strpos($link, 'instagram.com') != false || strpos($link, 'instagr.am') != false) {

      include_once($igFunctions);

      $url = urldecode(rtrim($link));

      $igFull = getIgUrl($url);

      if($igFull) {

        $ig = processIg($igFull->data);
        $ig['userData'] = processIgUser($igFull->data->user);

        if ( isset($tag)) {
          $ig['tags']  = array($tag);
        }

        if (isset($type) ) {
          $ig['type'] = $type;
        }

          // guardamos
        addData($ig);

        //echo json_encode($ig);

        echo 'done';

        esHoraDeActualizar();
        return true;

      } else {

        echo 'error';

        return false;
      }
          // procesado de momentos de rtve.es
    } elseif (strpos($link, 'www.rtve.es/mt') != false) {

      include_once($mTveFunctions);

      $url = urldecode(rtrim($link));
      $urlarr = explode('/', $url);
      $id = rtrim(end($urlarr));
      $momento = getMtveUrl($id);


      if(count($momento->page->items)) {
        $momentothemed = processMtve($momento->page->items[0]);

        if($momentothemed){ print_r($momentothemed);

          if ( isset($tag)) {
            $momentothemed['tags']  = array($tag);
          }
          if (isset($type) ) {
            $momentothemed['type'] = $type;
          }

            // guardamos
          addData($momentothemed);

          //echo json_encode($momentothemed);

          echo 'done';
          esHoraDeActualizar();
          return true;

        } else {
          echo 'error';
        }
      } else {
        echo 'error';
        return true;
      }

    } elseif (strpos($link, 'vine.co') != false) {

      include_once($vineFunctions);

      $url = urldecode(rtrim($link));
      // $urlarr = explode('/', $url);
      // $id = rtrim(end($urlarr));
      $dataVine = getVine($url);

          if ( isset($tag)) {
            $dataVine['tags']  = array($tag);
          }
          if (isset($type) ) {
            $dataVine['type'] = $type;
          }

            // guardamos
          addData($dataVine);

          //echo json_encode($momentothemed);

          echo 'done';
          esHoraDeActualizar();
          return true;
      }
     else {
      echo 'error';
    };
  break;
  // mueve un post de posicion
  case 'move':
    //checkToken($token);
    initializaDatos();

    $newOrderElems = $_POST['newOrderElems'];
    moveData(json_decode($newOrderElems));
    $done = esHoraDeActualizar();
    
    print($done);

    return true;
  break;
    // añade post de imagen grande
  case 'add-big':
    //checkToken($token);
    initializaDatos();
    
    if(isset($_POST['json'])){
    	$twt = json_decode($_POST['json'], true);
      	$link = $twt['link'];
      	$twtFull = getTweetFullWithLink($link);
      	if ( $twtFull ) {
      		include_once($twitterFunctions);
    		$usr = processTwUser($twtFull->user);
        	if (isset($usr)) {
          		$twt['userData'] = $usr;
        	}
      	}
      	$twt['type'] = 'img-big';
        var_dump($twt);
        echo "PRUEBA BUENAAAAAA \n \n \n";
      	addData($twt);
      	esHoraDeActualizar();
      	echo 'done';
      	return true;
    }
  	break;

    // añade post de imagen grande
  case 'add-small':
    //checkToken($token);
    initializaDatos();
    
    if(isset($_POST['json'])){
    	$twt = json_decode($_POST['json'], true);
      	$link = $twt['link'];
      	$twtFull = getTweetFullWithLink($link);
      	if ( $twtFull ) {
      		include_once($twitterFunctions);
    		$usr = processTwUser($twtFull->user);
        	if (isset($usr)) {
          		$twt['userData'] = $usr;
        	}
      	}
      	$twt['type'] = 'img-small';      
      	addData($twt);
      	esHoraDeActualizar();
      	echo 'done';
      	return true;
    }
  	break;

    // añade post de text
  case 'add-text':
    //checkToken($token);
    initializaDatos();
    
    if(isset($_POST['json'])){
    	$twt = json_decode($_POST['json'], true);
      	$link = $twt['link'];
      	$twtFull = getTweetFullWithLink($link);
      	if ( $twtFull ) {
      		include_once($twitterFunctions);
    		$usr = processTwUser($twtFull->user);
        	if (isset($usr)) {
          		$twt['userData'] = $usr;
        	}
      	}
      	$twt['type'] = 'txt';      
      	addData($twt);
      	esHoraDeActualizar();
      	echo 'done';
      	return true;
    }
  	break;

    // elimina un post
  case 'delete':
    //checkToken($token);
    initializaDatos();

    if(isset($_POST['json'])){

      $twt = json_decode($_POST['json'], true);

      if(isset($twt['id'])) return deleteData($twt['id']);

    }
    esHoraDeActualizar();
    echo 'done';
    return false;

    break;
  case 'cleanData':
    //checkToken($token);
      
    $rightClean = cleanData();
    if ($rightClean) {
      print("<div style='color:green;'>-- Clean DONE --</div><br/>");
      print("<a href='/los-goya-2015/radar/backoffice/?p=cbbabb7feaf39925552bb5690c64d16d'><button><< OK! Volver</button></a>");
    } else {
      print("<div style='color:red;'>-- Clean ERROR --</div><br/>");
      print("<a href='/los-goya-2015/radar/backoffice/?p=cbbabb7feaf39925552bb5690c64d16d'><button><< Volver</button></a>");
    }
    break;
  default:
    die('no se indicó acción valida'.PHP_EOL);
  break;
}

function cleanData() {
  /* Clean Radar home info */
    cleanRadarHomeTimelineInfo();
    /* Clean Backoffice Timeline STREAM twitter data 
    ("STREAM de Twitter" timeline section) */
    cleanBackofficeStreamTwitterData();
    /* Clean Backoffice STREAM twitter data posts 
    ("STREAM de Twitter" real posts when click in a time) */
    cleanBackofficeStreamTwitterPosts();
    /* Clean Backoffice Timeline FAVORITES STREAM twitter data 
    ("Tuits e Instagrams de FAVORITOS" timeline section) */
    cleanBackofficeFavoritesStreamTwitterData();
    /* Clean Backoffice FAVORITES STREAM twitter data posts 
    ("Tuits e Instagrams de FAVORITOS" real posts when click in a time) */
    cleanBackofficeFavoritesStreamTwitterPosts();
    /* Clean Popular/Favorites frontoffice tweets data */
    cleanPopularData();
    /* Clean saved data in GLOBALS/data.php data */
    cleanSavedPostsData();
    /* Clean Home Radar timeline and data */
    cleanRadarHomeInfo();
    /* Clean Home Radar posts */
    cleanRadarHomePosts();
    /* Set 0777 permissions to dynamic files*/
    setPermissionsToDataFiles();
    /* Init data files */
    initializaDatos();
    writeData();
    clearstatcache();
    return true;
}

function cleanRadarHomeTimelineInfo() {
  global $dataFolder;
  // clean /data/totals.json with an empty array []
    writeJson($dataFolder.'totals.json', array());
    print('Limpiando '.$dataFolder.'totals.json ...<br/>');
}
function cleanBackofficeStreamTwitterData() {
  global $dataFolder;
  // clean /data/timeline.json with an empty array []
    writeJson($dataFolder.'timeline.json', array());
    print('Limpiando '.$dataFolder.'timeline.json ...<br/>');
}
function cleanBackofficeStreamTwitterPosts() {
  global $dataFolder;
  // remove /data/*.json : time JSON files
    removeTimeJsonFilesFromDirectory($dataFolder);
    print('Limpiando archivos /data/&lt;time&gt;.json ...<br/>');
}
function cleanBackofficeFavoritesStreamTwitterData() {
  global $favoritesStreamFolder;
  // clean /data/stream-favorites/timeline.json with an empty array []
    writeJson($favoritesStreamFolder.'timeline.json', array());
    print('Limpiando '.$favoritesStreamFolder.'timeline.json ...<br/>');
}
function cleanBackofficeFavoritesStreamTwitterPosts() {
  global $favoritesStreamFolder;
  // remove /data/stream-favorites/*.json : time JSON files
    removeTimeJsonFilesFromDirectory($favoritesStreamFolder);
    print('Limpiando archivos /data/stream-favorites/&lt;time&gt;.json ...<br/>');
}
function cleanRadarHomeInfo() {
  global $radarDataFolder;
  // clean /radar/final/total.json with an empty array []
  // clean /radar/final/minute.json copying a version of the "reset" file
    writeJson($radarDataFolder.'minute.json', array());
    print('Limpiando '.$radarDataFolder.'minute.json ...<br/>');
    copy($radarDataFolder.'total-reset.json', $radarDataFolder.'total.json');
    print('Limpiando '.$radarDataFolder.'total.json ...<br/>');
}
function cleanRadarHomePosts() {
  global $radarDataFolder;
  // remove /radar/final/*.json : time JSON files
    removeTimeJsonFilesFromDirectory($radarDataFolder);
    print('Limpiando archivos /radar/final/&lt;time&gt;.json ...<br/>');
}
function cleanSavedPostsData() {
  global $radarDataFolder;
  // remove /radar/final/*.json : time JSON files
    removeDataphp($radarDataFolder);
    print('Limpiando archivo /radar/final/data.php ...<br/>');
}
function cleanPopularData() {
  global $favoritesFolder;
  // clean /data/favorites/favorites-appearances.json copying a version of the "reset" file
    copy($favoritesFolder.'favorites-appearances-reset.json', $favoritesFolder.'favorites-appearances.json');
    print('Limpiando '.$favoritesFolder.'favorites-appearances.json ...<br/>');
}
function setPermissionsToDataFiles() {
  global $dataFolder, $favoritesFolder, $favoritesStreamFolder, $radarDataFolder;
    print("Dando permisos a ".$dataFolder.'totals.json<br/>');
    chmod($dataFolder.'totals.json', 0777);
    print("Dando permisos a ".$dataFolder.'timeline.json<br/>');
    chmod($dataFolder.'timeline.json', 0777);
    print("Dando permisos a ".$favoritesStreamFolder.'timeline.json<br/>');
    chmod($favoritesStreamFolder.'timeline.json', 0777);
    print("Dando permisos a ".$radarDataFolder.'minute.json<br/>');
    chmod($radarDataFolder.'minute.json', 0777);
    print("Dando permisos a ".$radarDataFolder.'total.json<br/>');
    chmod($radarDataFolder.'total.json', 0777);
    print("Dando permisos a ".$favoritesFolder.'favorites-appearances.json<br/>');
    chmod($favoritesFolder.'favorites-appearances.json', 0777);
}

function getTweetFullWithLink($link) {
	include_once(SITE_ROOT . '/core/social/socialTwitter.php');
    $url = urldecode(rtrim($link));
    $urlarr = explode('/', $url);
    $q = rtrim(end($urlarr));
    $twtFull = getTweet($q);
    return $twtFull;
}

function moveData($newOrderElems) {
  // Post que queremos mover
  $dataAll = $GLOBALS['data']['all'];
  $newDataAll = array();
  foreach ($newOrderElems as $i=>$newOrderElem) {
    foreach ($dataAll as $j=>$dataElem) {
      if (strval($dataElem['id']) === strval($newOrderElem)) {
        $newDataAll[] = $dataElem;
        break;
      }
    }
  }

  $GLOBALS['data']['all'] = array_reverse($newDataAll);
  //$GLOBALS['data']['minute'] = $newDataAll;

  // Guardamos la informacion
  writeData();
}

/*function array_insert(&$array, $position, $insert)
{
    
    if (is_int($position)) {
        array_splice($array, $position, 0, $insert);
    } else {
        $pos   = array_search($position, array_keys($array));
        $array = array_merge(
            array_slice($array, 0, $pos),
            $insert,
            array_slice($array, $pos)
        );
    }
}*/

function writeData() {
  MyConfig::write($GLOBALS['saveDataphp'], $GLOBALS['data']);
}

function addData($post) {
  $GLOBALS['data']['all'][] = $post;
  $GLOBALS['data']['minute'][] = $post;

  writeData();
}

function deleteData($id) {
  $pos = positionForPostId($id, $GLOBALS['data']['all']);
  if ($pos >= 0) {
    unset($GLOBALS['data']['all'][$pos]); // Delete post from position
    $GLOBALS['data']['all'] = array_values($GLOBALS['data']['all']); // Reinit array indexes after 'delete'
  }
  $pos = positionForPostId($id, $GLOBALS['data']['minute']);
  if($pos >= 0) {
    unset($GLOBALS['data']['minute'][$pos]); // Delete post from position
    $GLOBALS['data']['minute'] = array_values($GLOBALS['data']['minute']); // Reinit array indexes after 'delete'
  }
  return true;
}

function positionForPostId($id, $dataArray) {
  foreach($dataArray as $pos=>$post) {
    if ($post['id'] === $id) {
      return $pos;
    }
  }
  return -1;
}

/*function searchData($id, $dataArray) {
  foreach($dataArray as $pos=>$post) {
    if ($post['id'] === $id) {
      return $post;
    }
  }
  return false;
}

function reinsertData($idPosition, $post) {
  if ( $GLOBALS['data']['all'] != null ) {
    array_splice($GLOBALS['data']['all'], $idPosition, 0, array($post));
  }

  if ( $GLOBALS['data']['minute'] != null ) {  
    array_splice($GLOBALS['data']['minute'], $idPosition, 0, array($post));
  }
}*/

    // cargamos los datos y, si ha pasado un minuto, guardamos los datos
function initializaDatos() {
    // si el archivo aún no existe, es la primera carga, por lo que solo hay que inicializar la variable con los datos
  if(!file_exists($GLOBALS['saveDataphp'])){

    $GLOBALS['data'] = array('time'=> date("mdHi"),'totals'=>array(), 'all' => array(), 'minute' => array()); 

    $jsonSearchTerms    = file_get_contents($GLOBALS['file_SearchTerms']);
    $jsonSearchTerms_a  = json_decode($jsonSearchTerms, true);

    $GLOBALS['search'] = $jsonSearchTerms_a['search'];
    $GLOBALS['filter'] = $jsonSearchTerms_a['filter']; 

  } else {
      // leemos el archivo
    $GLOBALS['data'] = MyConfig::read($GLOBALS['saveDataphp']);

    if(!is_array($GLOBALS['data'])){ // todavía no estamos
      $GLOBALS['data'] = array('time'=> date("mdHi"),'totals'=>array(), 'all' => array(), 'minute' => array());
        
    } 
  };
}

function esHoraDeActualizar() {

  //if($GLOBALS['data']['time'] != $GLOBALS['currTime']){

    //contarTerminos();
    saveData();

  //}

  writeData();
}


function processTimeline($tl) {

  $output = array();

  //print_r($tl);
  if (isset($tl['searchs']) && sizeOf($tl['searchs']) > 0) {
  foreach ($tl['searchs'] as $key=>$value) { 

    $count = 0;

    foreach ($tl['searchs'][$key] as $time) {


      $count+=$time;
    }

    $output[$key] = $count;
  }

  arsort($output);
  }

  return $output;
}


  // juntamos todo lo que es guardar datos
function saveData(){

  $GLOBALS['data']['time'] = $GLOBALS['currTime'];

  $timeline = json_decode(file_get_contents($GLOBALS['totalsJson']),true);

  $countFinal = processTimeline($timeline);
  if (!isset($timeline['global'])) {
    $timeline['global'] = array();
  }

  $timelineGlobal = completeTimelineWithEmptyMoments($timeline['global']);

  writeJson($GLOBALS['saveDataminute'], array(
    'data' => transformPosts($GLOBALS['data']['minute']), 
    'time' =>  $GLOBALS['currTime'], 
    'ended' => false,
    'timeline' => $timelineGlobal,
    'search' => $GLOBALS['search'],
    'filter' => $GLOBALS['filter'],
    'supercount' => $countFinal
  ));


  writeJson($GLOBALS['saveDatatotal'], array(
    'data' => transformPosts($GLOBALS['data']['all']), 
    'time' =>  $GLOBALS['currTime'], 
    'ended' => false,
    'timeline' => $timelineGlobal,
    'search' => $GLOBALS['search'],
    'filter' => $GLOBALS['filter'],
    'supercount' => $countFinal
  ));

  // Enviamos el fichero por FTP al servidor -> solo si estamos en pro!!!
  if( (isset($_SERVER) && $_SERVER['HTTP_HOST'] == '82.223.133.87') || php_uname('n') == 'ubuntu') {
    echo 'escrito en FTP';
    sendDataFTP($GLOBALS['saveDatatotal']);
    sendDataFTP($GLOBALS['saveDataminute']);
  }

  $GLOBALS['data']['minute'] = array();

}

function completeTimelineWithEmptyMoments($timelineGlobal) {
  $completedGlobals = array();
  $firstTime = 0;
  $lastTime = 0;
  $i=0;
  foreach ($timelineGlobal as $time=>$quantity) {
    if ($i === 0){
      $firstTime = $time;
    } else if ($i === sizeof($timelineGlobal)-1) {
      $lastTime = $time;
    }
    $i++;
  }

  $currentTime = $firstTime;
  
  $maxMinutes = 400;
  $minute = 0;
  while(strcmp($currentTime, $lastTime) !== 0) {
    if ($minute >= $maxMinutes) {
      break;
    }
    if (isset($timelineGlobal[$currentTime])) {
      // Insert current existing time
      $completedGlobals[$currentTime] = $timelineGlobal[$currentTime];
    } else {
      // Create current time if it does not exist
      $completedGlobals[$currentTime] = 0;
    }
    $currentTime = nextCurrentTime($currentTime);
    $minute++;
  }
  return $completedGlobals;
}

function nextCurrentTime($currentTime) {
  if (substr($currentTime, -4, 4) === "2359") {
    $month = substr($currentTime,0,2);
    $dayInt = (int)(substr($currentTime,2,2))+1;
    $day = numToString($dayInt);
    $hour = "00";
    $minute = "00";
  } else if (substr($currentTime, -2, 2) === "59") {
    $month = substr($currentTime,0,2);
    $day = substr($currentTime,2,2);
    $hourInt = (int)(substr($currentTime,4,2))+1;
    $hour = numToString($hourInt);
    $minute = "00";
  } else {
    $month = substr($currentTime,0,2);
    $day = substr($currentTime,2,2);
    $hour = substr($currentTime,4,2);
    $minuteInt = (int)(substr($currentTime,6,2))+1;
    $minute = numToString($minuteInt);
  }
  return $month.$day.$hour.$minute;
}

function numToString($num) {
  if ($num < 10) {
    return "0".$num;
  } else {
    return $num;
  }
}

  // cogemos el 
function transformPosts($postsObject) {
  $dataOK = array();
  foreach ($postsObject as $id => $object) {
    array_push($dataOK, $object);
  }
  return $dataOK;
}

function sendDataFTP($filename) {

  // Generamos la ruta del fichero en la carpeta de destino (FTP)
  $remote_file = $GLOBALS['ftp_remote_folder'] . str_replace($GLOBALS['radarDataFolder'], "", $filename);

  // Datos de la conexion al FTP
  $ftp_server = $GLOBALS['ftp_server'];
  $ftp_user_name = $GLOBALS['ftp_user_name'];
  $ftp_user_pass = $GLOBALS['ftp_user_pass'];

  // Establecemos la conexion
  $conn_id = ftp_connect($ftp_server);

  // Establecemos el login con el username y el password
  $login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);

  // Comprobamos si se establecio la conexion
  if ((!$conn_id) || (!$login_result)) {
      
    // Fallo en la conexion
    // ----------------------------------------------

    echo "Fallo en la conexion al FTP";
    echo "Intentando conectar al $ftp_server para el usuario $ftp_user_name";
      
    exit;

  } else {
  
    // Conexion establecida
    // ----------------------------------------------

    // Establecemos el timeout del FTP en 30 segundos
    ftp_set_option($conn_id, FTP_TIMEOUT_SEC, 30);

    // Activamos el modo pasivo para evitar que el servidor tarde en responder 
    // y se produzcan timeout 
    ftp_pasv($conn_id, true);

    //$upload = ftp_put($conn_id, $remote_file, $filename, FTP_ASCII);
    $upload = ftp_put($conn_id, $remote_file, $filename, FTP_BINARY);

    if ( !$upload ) {

      echo "Subida del fichero $filename al FTP ha fallado";
    } else {
      echo 'Uploaded';    
    }

    ftp_close($conn_id);
  }

} 

function returnJson($array){
  header('Content-type: text/json');
  echo json_encode($array);
  return;
}

function checkToken($token) {
    try
    {
        // CSRF check, sobre el POST, en modo excepción, nunca expira, y en modo "una vez".
        NoCSRF::check( 'csrf_token', $token, true, null, true );
        // Si se llega a este punto, significa que las validaciones han resultado correctas
    }
    catch ( Exception $e )
    {
        echo $e->getMessage();
        exit();
    }
}