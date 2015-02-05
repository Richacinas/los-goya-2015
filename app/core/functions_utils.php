<?php

/*

generateArrayFromColumm()
------------------------------------------------------------------------------------------------------------------------------ 

Método que genera un array a partir del contenido de otro array que contiene un campo 'url'

Parametros de entrada:

$array                  -> Array que vamos a recorrer
*/
function generateArrayFromColumm($array, $columm) {

  $url = array();

  for ($i=0; $i < count($array); $i++) { 
    
    array_push($url, $array[$i][$columm]);
  }

  return $url;
};

function isValidMd5($md5)
{
    return !empty($md5) && preg_match('/^[a-f0-9]{32}$/', $md5);
}

?>