<?php
 /*    _______________________________________________ 
     _____/\/\____________/\/\______/\/\/\/\/\_______ 
    _____/\/\__________/\/\/\/\____/\/\____/\/\_____ 
   _____/\/\________/\/\____/\/\__/\/\/\/\/\_______ 
  _____/\/\________/\/\/\/\/\/\__/\/\____/\/\_____
 _____/\/\/\/\/\__/\/\____/\/\__/\/\/\/\/\_______
________________________________________________
          ________________________________________________________________ 
         _____/\/\/\/\/\____/\/\/\/\/\/\__/\/\____/\/\__/\/\/\/\/\/\_____ 
        _____/\/\____/\/\______/\/\______/\/\____/\/\__/\_______________ 
       _____/\/\/\/\/\________/\/\______/\/\____/\/\__/\/\/\/\/\_______ 
      _____/\/\__/\/\________/\/\________/\/\/\/\____/\/\_____________ 
     _____/\/\____/\/\______/\/\__________/\/\______/\/\/\/\/\/\_____ 
    ________________________________________________________________ 
____________ Diseño: Ismael Recio, Redacción: Alberto Fernández / Miriam Hernanz, Realización: César Vallejo / Miguel Campos 
Desarrollo: David Ruiz / Francisco Quintero / Carlos Jiménez Delgado @2013__________________________ */

/** 
* functions_properties.php
* --------------------------------
*   Functiones de ayuda para gestión de archivos de configuraciones
* 
* @method filePropertiesToArray -> lee archivo de texto y devuelve array
* @method filePropertiesToArrayMulti -> lee archivo de texto y devuelve array multidimensional
* @class MyConfig -> simple gestor de archivos de configuración de texto
*   @method MyConfig:read()
*   @method MyConfig:write()
*/

/** 
* filePropertiesToArray()
* --------------------------------
*   Procesa un archivo de configuraciones con la estructura
*     CLAVE: VALOR
*   y nos devuelve un array 
* 
* @method filePropertiesToArray
* @prop file_path -> ruta del archivo a procesar
* @return array con formato clave->valor
*/
function filePropertiesToArray($file_path) {

  $lines = explode("\n", trim(file_get_contents($file_path)));
  $properties = array();

  foreach ($lines as $line) {
      $line = trim($line);

      if (!$line || substr($line, 0, 1) == '#') // skip empty lines and comments
          continue;

      if (false !== ($pos = strpos($line, ':'))) {
          $properties[trim(substr($line, 0, $pos))] = trim(substr($line, $pos + 1));
      }
  }

  return $properties;
}

/** 
* filePropertiesToArrayMulti()
* --------------------------------
*   Como el anterior pero genera un array de dos dimensiones, permitiéndonos
*   tener claves repetidas
* 
* @method filePropertiesToArrayMulti
* @prop file_path -> ruta del archivo a procesar
* @return array con formato clave->aray(valor, valor....)
*/
function filePropertiesToArrayMulti($file_path) {

  $lines = explode("\n", trim(file_get_contents($file_path)));
  $properties = array();

  foreach ($lines as $line) {
      $line = trim($line);

      if (!$line || substr($line, 0, 1) == '#') // skip empty lines and comments
          continue;

      if (false !== ($pos = strpos($line, ':'))) {

        $elm = trim(substr($line, 0, $pos));
        $val = trim(substr($line, $pos + 1));

        if(isset($properties[$elm])) {
          array_push($properties[$elm], $val);
        } else {
          $properties[trim(substr($line, 0, $pos))] = array($val);
        }
      }
  }

  return $properties;
}

/** 
* class MyConfig
* --------------------------------
*   http://stackoverflow.com/questions/2237291/reading-and-writing-configuration-files
*
*   simple gestor de archivos de configuración de texto
* 
* @method read($filename)
* @method write($filename)
*/

class MyConfig
{
    public static function read($filename)
    {
        $config = include $filename;
        return $config;
    }
    public static function write($filename, array $config)
    {
    	define("FILE_PUT_CONTENTS_ATOMIC_MODE", 0777);
        $config = var_export($config, true);
        file_put_contents($filename, "<?php return $config ;");        
    }
}


function writeJson($file, $data) {
  $file = fopen($file, 'w');
  fwrite($file, json_encode($data));
  fclose($file);

  return true;   
}

function readJson($file) {
  $text = file_get_contents($file);
  return json_decode($text);
}

  /* borra un directorio y todos sus contenidos 
        copiado desde http://php.net/manual/en/function.rmdir.php */
function rrmdir($dir) {
  if (is_dir($dir)) {
    $objects = scandir($dir);
    foreach ($objects as $object) {
      if ($object != "." && $object != "..") {
        if (filetype($dir."/".$object) == "dir") rrmdir($dir."/".$object); 
        else unlink   ($dir."/".$object);
      }
    }
    reset($objects);
    rmdir($dir);
  }
  return true;   
}

  /* Borra el contenido de un directorio Como el anterior, pero deja la carpeta padre */
function rrmdirContents($dir) {
  if (is_dir($dir)) {
    $objects = scandir($dir);
    foreach ($objects as $object) {
      if ($object != "." && $object != "..") {
        if (filetype($dir."/".$object) == "dir") {/*Directory*/ /*rrmdir($dir."/".$object); */}
        else {/*File*/ unlink  ($dir.$object);}
      }
    }
  }
  return true;   
}

function removeTimeJsonFilesFromDirectory($dir) {
  if (is_dir($dir)) {
    $objects = scandir($dir);
    foreach ($objects as $object) {
      if ($object != "." && $object != ".." && (filetype($dir."/".$object) != "dir") ) {
        $fileparts = explode(".", $object);
        $filename = $fileparts[sizeof($fileparts)-2];
        $extension = $fileparts[sizeof($fileparts)-1];
        if ($extension === 'json' && $filename !== 'timeline' && $filename !== 'totals' && $filename !== 'total' && $filename !== 'minute') {
          unlink($dir.$object);
        }
      }
    }
  }
  return true; 
}

function removeDataphp($dir) {
  if (is_dir($dir)) {
    unlink($dir.'data.php');
  }
  return true; 
}