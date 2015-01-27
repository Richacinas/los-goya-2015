<?php

// Importaciones de ficheros
// -------------------------------

require_once('api/facebook/src/facebook.php');








/** 
* Funciones de consulta de datos
* ---------------------------------------------
* @method getFacebookSettings -> Devuelve los parametros de configuracion para la conexion con Facebook
* @method getFacebook -> hace consulta a api de facebook basado en una query simple
*   @prop query string
*/



function getFacebookSettings() {

  /** Set access tokens here - see: https://dev.twitter.com/apps/ **/
  // Create our Application instance (replace this with your appId and secret).
  $facebook = new Facebook(array(
    'appId'  => '519461804813782',
    'secret' => '41658f57dcabbaf6fec8d65d33db6186',
  ));

  return $facebook;
}

function getFacebook($query){

  $facebook = getFacebookSettings();

  $access_token = $facebook->getAccessToken();

  $query = urlencode($query);
  $query = str_replace('.', '+', $query);
  $query = str_replace('-', '+', $query);
  
  $url = "https://graph.facebook.com/search?access_token=".$access_token."&q=".$query;//&center=40.26,3.41&distance=10000";

  $data = json_decode(callFb($url));

  if(count($data->data) == 0){
    return 'facebook error';
  }

  return $data;
}

function callFb($url) {

  $ch = curl_init();
  curl_setopt_array($ch, array(
      CURLOPT_URL => $url,
      CURLOPT_RETURNTRANSFER => true
  ));

  $result = curl_exec($ch);
  curl_close($ch);

  return $result;
}

?>