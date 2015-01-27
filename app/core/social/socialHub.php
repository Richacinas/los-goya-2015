<?php

/** 
* socialHub.php
* --------------------------------
* Fichero que actua como router para llamar a las distintas funciones que realizaran las queries a las distintas APIs sociales
* 
* - @method processRequest -> hub de solicitudes
*/

setlocale(LC_ALL,"es_ES");


// Importaciones de ficheros
// -------------------------------

$socialTwitter    = SITE_ROOT . '/app/core/social/socialTwitter.php';     // -> herramientas de gestion de Twitter
$socialInstagram  = SITE_ROOT . '/app/core/social/socialInstagram.php';   // -> herramientas de gestion de Instagram
$socialVine       = SITE_ROOT . '/app/core/social/socialVine.php';        // -> herramientas de gestion de Vine
$socialFacebook   = SITE_ROOT . '/app/core/social/socialFacebook.php';    // -> herramientas de gestion de Facebook
$socialGPlus      = SITE_ROOT . '/app/core/social/socialGooglePlus.php';  // -> herramientas de gestion de GPlus

// -------------------------------

header('Content-Type: text/html; charset=utf-8');

ini_set("display_startup_errors ",1); 
ini_set("error_reporting",E_ALL); 
ini_set('display_errors', 1);

ob_start('ob_gzhandler');


/** 
* @method processRequest
* ---------------------------------------------
* hub que distribuye las solicitudes a las apis
* @prop $req -> string -> tipo de solicitud:
*   'tw', 'twlist', 'ig', 'vn', 'fb', 'gp'
* @prop $setts -> objeto -> objeto con información de la solicitud 
*   (ver características para cada tipo solicitud)
*/
function processRequest($req, $setts) {
    //initiate request
  switch ($req) {
    case 'tw':
      require_once $GLOBALS['socialTwitter'];
      $result = getTwitter($setts);
    break;
    case 'twlist':
      require_once $GLOBALS['socialTwitter'];
      $result = getTwitterList($setts);
    break;
    case 'twtl':
      require_once $GLOBALS['socialTwitter'];
      $result = getTwitterTimeline($setts);
    break;
    case 'twlikes':
      require_once $GLOBALS['socialTwitter'];
      $result = getTwitterLikes($setts);
    break;
    case 'ig':
      require_once $GLOBALS['socialInstagram'];
      $result = getInstagram($setts);
    break;
    case 'igtl':
      require_once $GLOBALS['socialInstagram'];
      $result = getInstagramTimeline($setts);
    break;
    case 'vn':
      require_once $GLOBALS['socialVine'];
      $result = getVine($setts['query']);
    break;
    case 'fb':
      require_once $GLOBALS['socialFacebook'];
      $result = getFacebook($setts['query']);
    break;
    case 'gp':
      require_once $GLOBALS['socialGPlus'];
      $result = getGPlus($setts['query']);
    break;
    
    default:
      echo 'request error';
      return '';
    break;
  }
  return $result;
}
