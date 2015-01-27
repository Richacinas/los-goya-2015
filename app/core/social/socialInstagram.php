<?php

/** 
* Funciones de consulta de datos
* ---------------------------------------------
* @method getInstagramSettings -> Devuelve el ID del cliente sobre el que se va a realizar la consulta
* @method getInstagram -> hace consulta a api de Instagram basado en una query simple
*   @prop query string
*/

function getInstagramSettings(){

  /** Set access tokens here - see: https://dev.twitter.com/apps/ **/
  $client_id = "677854b173814eda9d28c3b2b985ca8a";

  return $client_id;
}
function getInstagramToken(){

  /** Set access tokens here - see: https://dev.twitter.com/apps/ **/
  $access_token = "1008068780.677854b.b0002ed733a640ca9e5ebcfe9c04ca46";

  return $access_token;
}

function getIgUrl($url){

  $client_id = getInstagramSettings();

  $url = "http://api.instagram.com/oembed?url=".urlencode($url);
  
  $ch = curl_init();
  curl_setopt_array($ch, array(
      CURLOPT_URL => $url,
      CURLOPT_RETURNTRANSFER => true
  ));

  $result = curl_exec($ch);
  curl_close($ch);

  $data = json_decode($result);

  if(isset($data->media_id)){
    $url = "https://api.instagram.com/v1/media/".$data->media_id."?client_id=".$client_id;

    $ch = curl_init();
    curl_setopt_array($ch, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true
    ));
    $result = curl_exec($ch);
    curl_close($ch);

    $data = json_decode($result);

    if(!isset($data->meta) || $data->meta->code != '200'){
      return false;
    }

    return $data;
  }

  return false;

}

function getInstagramTimeline($query){
  $access_token = getInstagramToken();

  $url = "https://api.instagram.com/v1/users/self/feed/?access_token=".$access_token;
  
  if(isset($query['max_id'])) {
    $url .= '&count=200&min_id='.$query['max_id'];
  }

  $ch = curl_init();
  curl_setopt_array($ch, array(
      CURLOPT_URL => $url,
      CURLOPT_RETURNTRANSFER => true
  ));

  $result = curl_exec($ch);
  curl_close($ch);

  $data = json_decode($result);

  if(!isset($data->meta) || $data->meta->code != '200'){
    return false;
  }
  
  return $data;
}

function getInstagram($query){

  $client_id = getInstagramSettings();

  $url = "https://api.instagram.com/v1/tags/".urlencode($query['query'])."/media/recent?client_id=".$client_id;
  
  if(isset($query['max_id'])) {
    $getfield .= '&MAX_ID='.$query['max_id']+1;
  }

  $ch = curl_init();
  curl_setopt_array($ch, array(
      CURLOPT_URL => $url,
      CURLOPT_RETURNTRANSFER => true
  ));

  $result = curl_exec($ch);
  curl_close($ch);

  $data = json_decode($result);

  if(!isset($data->meta) || $data->meta->code != '200'){
    return false;
  }

  return $data;
}



/** 
* Funciones de procesado de datos
* ---------------------------------------------
* @method processIgUser -> formatea un usuario de instagram
*   @prop user -> objecto
* @method processIg -> formatea un instagram
*   @prop photo -> objecto
*/

function processIgUser($user) {
  
  return array (
    'user' => $user->username,
    'img' => $user->profile_picture,
    'full_name' => $user->full_name,
    'link' => 'http://instagram.com/'.$user->username,
    'id' => $user->id,
    'net' => 'ig'
  );
}

function processIg($photo) {

  $result = array (
    'id' => $photo->id,
    'created_time' => $photo->created_time,
    'link' => $photo->link,
    'likes' => $photo->likes->count,
    'image' => $photo->images->standard_resolution->url,
    'type' => $photo->type,
    'net' => 'ig',
    'user' => $photo->user->id,
    'user_name' => $photo->user->username
  );

  if(isset($photo->caption)) {
    $result['text'] = $photo->caption->text;
  } else {
    $result['text'] = '';
  }

  if($photo->type == 'video') {
    $result['video'] = $photo->videos->standard_resolution->url;
  }

  return $result;
}
?>