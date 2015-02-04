<?php 

/** 
* Funciones de consulta de datos
* ---------------------------------------------
* @method getVineSettings -> Devuelve los parametros de configuracion de la cuenta para Vine
* @method getVine -> hace consulta a api de vine basado en una query simple
*   @prop query string
*/


 // function getVineSettings(){

 //   $key = '1000114495814795264-6fcc4abf-440d-4228-9971-66ac1d154a2a';

 //   return $key;
 // }

function getVine($query) {

  // $key = getVineSettings();

      $urlarr = explode('/', $query);
      $id = rtrim(end($urlarr));
  $url = 'https://api.vineapp.com/timelines/posts/s/'.$id;

   $ch = curl_init();

   curl_setopt($ch, CURLOPT_URL, $url);
   curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
   // curl_setopt($ch, CURLOPT_USERAGENT, "com.vine.iphone/1.0.3 (unknown, iPhone OS 6.1.0, iPhone, Scale/2.000000)");
   // curl_setopt($ch, CURLOPT_HTTPHEADER, array('vine-session-id: '.$key));
   curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
   curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
  
   $result = curl_exec($ch);
   $result = json_decode($result);
    $data = array(
    'time' => $result->data ->records[0] ->comments ->records[0] ->created,
    'img' => $result->data ->records[0]->thumbnailUrl,
    'link' => $query,
    'id' => $id,
    'net' => 'vn',
    'video' => $result->data ->records[0] ->videoDashUrl);

  if(isset($result->data ->records[0] ->username)){
    $data['usr'] = $result->data ->records[0] ->username;
  }
  else
  {
    $data['usr'] = "";
  }
  if(isset($result->data ->records[0] ->description)){
    $data['text'] = $result->data ->records[0] ->description;
  }
  else
  {
    $data['text'] = "";
  }
  if(isset($result->data ->records[0] ->avatarUrl)){
    $data['usr_img'] = $result->data ->records[0] ->avatarUrl;
  }
  else
  {
    $data['usr_img'] = "";
  }
    return $data;

}

?>