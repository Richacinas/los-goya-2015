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


$dataFolder3            = SITE_ROOT . '/../radar/final/';
$saveDataminute         = $dataFolder3 . 'minute.json'; // el json del último minuto
$saveDatatotal          = $dataFolder3 . 'total.json'; // el json definitiva
$saveDataphp            = $dataFolder3 . 'data.php'; // almacenando temporalmente
$dataFolder             = SITE_ROOT . '/../data/';
$totalsJson             = $dataFolder . 'totals.json'; // datos totales
$dataFolder2            = SITE_ROOT . '/../data/stream-favorites/';

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

if(isset($argv) && isset($argv[1])) {
  $method = $argv[1];
} elseif(isset($_GET['method'])){
  $method = $_GET['method'];
} else {
  die('no se indicó acción');
}

  // según el parámetro method haremos una cosa u otra;
switch ($method) {

    // fuerza a procesar 
  case 'refresh':

    initializaDatos();
    saveData();

    echo 'done';  
    break;

    // actualiza los terminos de busqueda
  case 'update':

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
    initializaDatos();

    $id = $_GET['id'];

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

    if(!isset($_GET['link']) || !isset($_GET['type']) || !isset($_GET['tag'])) die('error en los parámetros recibidos');

      // cargamos datos de tweets
    initializaDatos();

    $link = $_GET['link'];
    $type = $_GET['type'];
    $tag = $_GET['tag'];
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
    initializaDatos();

    $newOrderElems = $_GET['newOrderElems'];
    moveData(json_decode($newOrderElems));
    $done = esHoraDeActualizar();
    
    print($done);

    return true;
  break;
    // añade post de imagen grande
  case 'add-big':
    initializaDatos();
    if(isset($_GET['json'])){
    	$twt = json_decode($_GET['json'], true);
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
      	addData($twt);
      	esHoraDeActualizar();
      	echo 'done';
      	return true;
    }
  	break;

    // añade post de imagen grande
  case 'add-small':
	initializaDatos();
    if(isset($_GET['json'])){
    	$twt = json_decode($_GET['json'], true);
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
	initializaDatos();
    if(isset($_GET['json'])){
    	$twt = json_decode($_GET['json'], true);
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

    initializaDatos();

    if(isset($_GET['json'])){

      $twt = json_decode($_GET['json'], true);

      if(isset($twt['id'])) return deleteData($twt['id']);

    }
    esHoraDeActualizar();
    echo 'done';
    return false;

    break;
    // borra toda nuestra preciada información
  case 'wipeout':
    rrmdirContents($dataFolder);
    rrmdirContents($dataFolder2);
    rrmdirContents($dataFolder3);
    writeJson($dataFolder.'timeline.json', array());
    writeJson($dataFolder.'totals.json', array());
    writeJson($dataFolder2.'timeline.json', array());
    writeJson($dataFolder2.'timeline.json', array());
    writeJson($dataFolder3.'minute.json', array());
    writeJson($dataFolder3.'total.json', array());
    chmod ($dataFolder.'timeline.json', 0777);
    chmod ($dataFolder2.'timeline.json', 0777);
    chmod ($dataFolder3.'minute.json', 0777);
    chmod ($dataFolder3.'total.json', 0777);
    chmod ($dataFolder.'totals.json', 0777);

    initializaDatos();
    writeData();

    echo 'done';
    return true;
  break;
    // borra toda nuestra preciada información
  case 'cleanTime':
    writeJson($dataFolder.'totals.json', '');
    print_r('limpiuando');//totalsJson
  break;
  default:
    die('no se indicó acción valida'.PHP_EOL);
  break;
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

  foreach ($tl['searchs'] as $key=>$value) { 

    $count = 0;

    foreach ($tl['searchs'][$key] as $time) {


      $count+=$time;
    }

    $output[$key] = $count;
  }

  arsort($output);

  return $output;
}


  // juntamos todo lo que es guardar datos
function saveData(){

  $GLOBALS['data']['time'] = $GLOBALS['currTime'];

  $timeline = json_decode(file_get_contents($GLOBALS['totalsJson']),true);

  $countFinal = processTimeline($timeline);

  writeJson($GLOBALS['saveDataminute'], array(
    'data' => transformPosts($GLOBALS['data']['minute']), 
    'time' =>  $GLOBALS['currTime'], 
    'ended' => false,
    'timeline' => $timeline['global'],
    'search' => $GLOBALS['search'],
    'filter' => $GLOBALS['filter'],
    'supercount' => $countFinal
  ));


  writeJson($GLOBALS['saveDatatotal'], array(
    'data' => transformPosts($GLOBALS['data']['all']), 
    'time' =>  $GLOBALS['currTime'], 
    'ended' => false,
    'timeline' => $timeline['global'],
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
  $remote_file = $GLOBALS['ftp_remote_folder'] . str_replace($GLOBALS['dataFolder3'], "", $filename);

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