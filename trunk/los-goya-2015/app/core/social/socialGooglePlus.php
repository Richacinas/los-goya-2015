<?php

/** 
* funciones de consulta de datos
* ---------------------------------------------
* @method getGPlus -> hace consulta a api de google plus basado en una query simple
* @method getGPlus -> hace consulta a api de google plus basado en una query simple
*   @prop query string
*/


function getGPlusSettings() {

  /** Set access tokens here - see: https://dev.twitter.com/apps/ **/
  $key = "AIzaSyB4J7IBYD0FnBC6oV4qZikOZxdKYn-vyrI";

  return $key;
}


function getGPlus($query){

  $key = getGPlusSettings();

  $url = "https://www.googleapis.com/plus/v1/activities?query=".urlencode($query)."&maxResults=20&orderBy=recent&key=".$key;

  $ch = curl_init();
  curl_setopt_array($ch, array(
      CURLOPT_URL => $url,
      CURLOPT_RETURNTRANSFER => true
  ));

  $result = curl_exec($ch);
  curl_close($ch);

  $data = json_decode($result);

  if(isset($data->error)){
    return 'error gplus';
  }
  
  return $data;
}

?>