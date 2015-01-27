<?php

/*

getUrl(()
------------------------------------------------------------------------------------------------------------------------------ 

Método que limpia una cadena de caracteres no normalizados

Parametros de entrada:

$s                  -> String con la cadena de la url
*/
function getUrl($s) {

  $s = str_replace(",","",$s);
  $s = str_replace("Ñ","n",$s);
  $s = str_replace("Á","a",$s);
  $s = str_replace("É","e",$s);
  $s = str_replace("Í","i",$s);
  $s = str_replace("Ó","o",$s);
  $s = str_replace("Ú","u",$s);
  $s = str_replace("ñ","n",$s);
  $s = str_replace("á","a",$s);
  $s = str_replace("é","e",$s);
  $s = str_replace("í","i",$s);
  $s = str_replace("ó","o",$s);
  $s = str_replace("ú","u",$s);
  $s = str_replace(" ","-",$s);
  $s = strtolower($s);

  return $s;
};


/*

getCharFromUrl(()
------------------------------------------------------------------------------------------------------------------------------ 

Método que 

Parametros de entrada:

$url                  ->
$charfinal            ->
*/
function getCharFromUrl($url, $charfinal) {

  for ($i=0; $i < count($charfinal); $i++) { 

    if ( $url == getUrl($charfinal[$i]['url']) ) {
      return($charfinal[$i]);
    }
  }
};

function getSect($url, $extras){
  for ($i=0; $i < count($extras); $i++) { 
    if($url == $extras[$i]['url']) {
      return($extras[$i]);
    }
  }
};

/*

generateArrayURL(()
------------------------------------------------------------------------------------------------------------------------------ 

Método que genera un array a partir del contenido de otro array que contiene un campo 'url'

Parametros de entrada:

$array                  -> Array que vamos a recorrer
*/
function generateArrayURL($array) {

  $url = array();

  for ($i=0; $i < count($array); $i++) { 
    
    array_push($url, $array[$i]['url']);
  }

  return $url;
};


/* Funcion que normaliza las url, añade la / al final si no la tiene */
function normalizeUrl($url) {


  $ultimoCaracter = substr($url, -1);

  if ( strcmp($ultimoCaracter, "/") != 0 ) {
    $url = $url . "/";
  }
   
  return $url;   
};

/* Funcion que determina el numero de parametros de una url */

function getNumParamUrl($url) {

  // Normalizamos la url
  $url = normalizeUrl($url);

  // Creamos un array
  $urlArray = explode('/',$_SERVER['REQUEST_URI']);

  // Contamos el numero de elementos
  $numParam = count($urlArray);

  // Comprobamos si el ultimo elemento esta vacio
  if ( $urlArray[$numParam-1] == "" )
    $numParam = $numParam - 1;
       
  return $numParam;   
};

?>