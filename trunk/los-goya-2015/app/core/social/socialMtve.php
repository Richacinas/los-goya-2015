<?php

/** 
* Funciones de consulta de datos para +rtve
* ---------------------------------------------
* @method getInstagram -> hace consulta a api de Instagram basado en una query simple
*   @prop query string
*/

function getMtveUrl($id){

  $url = "http://www.rtve.es/api/momentos/".$id.'.json';
  
  $ch = curl_init();
  curl_setopt_array($ch, array(
      CURLOPT_URL => $url,
      CURLOPT_RETURNTRANSFER => true
  ));

  $result = curl_exec($ch);
  curl_close($ch);

  $data = json_decode($result);
print_r($data);
  if(isset($data->page) && $data->page->number == 1){

    $data = json_decode($result);

    return $data;
  }

  return false;

}

/** 
* Funciones de limpiado de datos
* ---------------------------------------------
* @method processMtve -> formatea un momento
*   @prop momento -> momento a formatear
*/

function processMtve($momento) { 

  $outp = array(
    'time' => $momento->updateDate,
    'img' => $momento->imageUrl,
    'link' => 'http://www.rtve.es/mt/'.$momento->id,
    'id' => $momento->id,
    'net' => '+t'
  );
  //die ($outp["time"]);

  if(isset($momento->videoUrl)){
    $outp['video'] = $momento->videoUrl;
  }

  if(isset($momento->firstComment)){
    $outp['text'] = $momento->firstComment->comment;
    $outp['usr'] = $momento->firstComment->nick;
    $outp['text'] = $momento->firstComment->comment;
    $outp['usr_img'] = $momento->firstComment->avatarUrl;
  }

  return $outp;
}

?>