<?php

$baseUrl = $_SERVER['HTTP_HOST'];
$twitterAccount = "raulevoluciona";

function getCarouselData()
{
    $aElement = array();
    $aCarousel = array();
    $aNameIndex = array();
    $aIdIndex = array();
    $dataPath = $_SERVER["DOCUMENT_ROOT"] .'/los-goya-2015/alfombra-roja/data.csv';
    $aLines = file( $dataPath );

    foreach( $aLines as $line ) {
        $aElement = str_getcsv($line, ",", '"');
        //$aElement[2] = utf8_encode($aElement[2]);
        //$aElement[4] = utf8_encode($aElement[4]);
        $aCarousel[$aElement[0]] = $aElement;
        $aNameIndex[$aElement[0]] = $aElement[1];
        $aIdIndex[$aElement[0]] = $aElement[5];
    }

    if (count($aCarousel) > 0) {
        ksort($aCarousel);
        ksort($aNameIndex);
        ksort($aIdIndex);
    }
    
    return array($aCarousel,$aNameIndex,$aIdIndex);
}


function formatImageName($imageName) {
    
    $result = preg_replace(array("/\sde\s/", "/\sla\s/", "/\sdel\s/", "/\s[A-Za-z]\s/"), array(" ", " ", " ", " "), stripAccents($imageName));
    $result = preg_replace("/\s+/", "-", $result);
    $result = strtolower($result);
    
    return $result;
}
function targetBlank($text) {
  if( strpos( $text, 'target' ) === false ) {
      return str_ireplace('<a', '<a target="_blank"', $text);
  }
  return $text;
}

function isValidMd5($md5)
{
    return !empty($md5) && preg_match('/^[a-f0-9]{32}$/', $md5);
}
function stripAccents($str) {
  $a = array('À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Æ', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ð', 'Ñ', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ø', 'Ù', 'Ú', 'Û', 'Ü', 'Ý', 'ß', 'à', 'á', 'â', 'ã', 'ä', 'å', 'æ', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ñ', 'ò', 'ó', 'ô', 'õ', 'ö', 'ø', 'ù', 'ú', 'û', 'ü', 'ý', 'ÿ', 'Ā', 'ā', 'Ă', 'ă', 'Ą', 'ą', 'Ć', 'ć', 'Ĉ', 'ĉ', 'Ċ', 'ċ', 'Č', 'č', 'Ď', 'ď', 'Đ', 'đ', 'Ē', 'ē', 'Ĕ', 'ĕ', 'Ė', 'ė', 'Ę', 'ę', 'Ě', 'ě', 'Ĝ', 'ĝ', 'Ğ', 'ğ', 'Ġ', 'ġ', 'Ģ', 'ģ', 'Ĥ', 'ĥ', 'Ħ', 'ħ', 'Ĩ', 'ĩ', 'Ī', 'ī', 'Ĭ', 'ĭ', 'Į', 'į', 'İ', 'ı', 'Ĳ', 'ĳ', 'Ĵ', 'ĵ', 'Ķ', 'ķ', 'Ĺ', 'ĺ', 'Ļ', 'ļ', 'Ľ', 'ľ', 'Ŀ', 'ŀ', 'Ł', 'ł', 'Ń', 'ń', 'Ņ', 'ņ', 'Ň', 'ň', 'ŉ', 'Ō', 'ō', 'Ŏ', 'ŏ', 'Ő', 'ő', 'Œ', 'œ', 'Ŕ', 'ŕ', 'Ŗ', 'ŗ', 'Ř', 'ř', 'Ś', 'ś', 'Ŝ', 'ŝ', 'Ş', 'ş', 'Š', 'š', 'Ţ', 'ţ', 'Ť', 'ť', 'Ŧ', 'ŧ', 'Ũ', 'ũ', 'Ū', 'ū', 'Ŭ', 'ŭ', 'Ů', 'ů', 'Ű', 'ű', 'Ų', 'ų', 'Ŵ', 'ŵ', 'Ŷ', 'ŷ', 'Ÿ', 'Ź', 'ź', 'Ż', 'ż', 'Ž', 'ž', 'ſ', 'ƒ', 'Ơ', 'ơ', 'Ư', 'ư', 'Ǎ', 'ǎ', 'Ǐ', 'ǐ', 'Ǒ', 'ǒ', 'Ǔ', 'ǔ', 'Ǖ', 'ǖ', 'Ǘ', 'ǘ', 'Ǚ', 'ǚ', 'Ǜ', 'ǜ', 'Ǻ', 'ǻ', 'Ǽ', 'ǽ', 'Ǿ', 'ǿ', 'Ά', 'ά', 'Έ', 'έ', 'Ό', 'ό', 'Ώ', 'ώ', 'Ί', 'ί', 'ϊ', 'ΐ', 'Ύ', 'ύ', 'ϋ', 'ΰ', 'Ή', 'ή');
  $b = array('A', 'A', 'A', 'A', 'A', 'A', 'AE', 'C', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'D', 'N', 'O', 'O', 'O', 'O', 'O', 'O', 'U', 'U', 'U', 'U', 'Y', 's', 'a', 'a', 'a', 'a', 'a', 'a', 'ae', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'n', 'o', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'y', 'y', 'A', 'a', 'A', 'a', 'A', 'a', 'C', 'c', 'C', 'c', 'C', 'c', 'C', 'c', 'D', 'd', 'D', 'd', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'G', 'g', 'G', 'g', 'G', 'g', 'G', 'g', 'H', 'h', 'H', 'h', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'IJ', 'ij', 'J', 'j', 'K', 'k', 'L', 'l', 'L', 'l', 'L', 'l', 'L', 'l', 'l', 'l', 'N', 'n', 'N', 'n', 'N', 'n', 'n', 'O', 'o', 'O', 'o', 'O', 'o', 'OE', 'oe', 'R', 'r', 'R', 'r', 'R', 'r', 'S', 's', 'S', 's', 'S', 's', 'S', 's', 'T', 't', 'T', 't', 'T', 't', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'W', 'w', 'Y', 'y', 'Y', 'Z', 'z', 'Z', 'z', 'Z', 'z', 's', 'f', 'O', 'o', 'U', 'u', 'A', 'a', 'I', 'i', 'O', 'o', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'A', 'a', 'AE', 'ae', 'O', 'o', 'Α', 'α', 'Ε', 'ε', 'Ο', 'ο', 'Ω', 'ω', 'Ι', 'ι', 'ι', 'ι', 'Υ', 'υ', 'υ', 'υ', 'Η', 'η');
  return str_replace($a, $b, $str);
}

function getCarouselItemById($data, $id) {
    
    foreach ($data as $item) {
        if ($item[5] == $id) {
            return $item;
        }
    }
    return false;
}

function deleteImage($path) {
    unlink($path);
}
function renameImage($oldName, $newName) {
    //Si no se subió anteriormente la nueva foto, entonces se renombra la existente.
    if (!file_exists($newName)) {
        rename($oldName, $newName);
    } else {
        unlink($oldName);
    }
    
}
function cleanupFolder($folder, $aContent) {
    $openFolder = opendir($folder);
    // don't forget to stop while-loop also
    while (($file = readdir($openFolder)) !== false) {
       if($file!="." && $file!=".." && !in_array($file, $aContent)){
          deleteImage($folder."".$file);
       }    
    }
}


function unescapeArray($array){
    foreach($array as &$val){
        $val = htmlspecialchars_decode($val);
    }
    return $array;
}

function escapeArray($array){
    foreach($array as &$val){
        $val = htmlspecialchars($val);
    }
    return $array;
}

function addItemCsvArray(&$data, $i, $aNewValues, $aOldNames, $aOldIds) {
    $data[$i] = $aNewValues;
    //Se quitan acentos, se convierte a minúsculas y se sustituye el espacio en blanco por _
    $imageName = formatImageName($data[$i][1])."-goya-2015.jpg";
    array_splice( $data[$i], 1, 0, $imageName );
    
    //Además, hay que comprobar si hubo cambio de nombre pues de ser así hay que renombrar los ficheros de imagen
    $oldNameIndex = array_search($aNewValues[4],$aOldIds);
    if ($oldNameIndex != false) {
        $oldName = $aOldNames[$oldNameIndex];
        if ($oldName != $imageName) {
            renameImage("../fotos/".$oldName, "../fotos/".$imageName);
            renameImage("../fotos/zoom/".$oldName, "../fotos/zoom/".$imageName);
        }
    }
    return true;
}

function setCsvArray($data, $files) {
    $aOldData = getCarouselData();
    $aOldNames = $aOldData[1];
    $aOldIds = $aOldData[2];
    
    $aFormattedData = array();
    $aNewValues = array();
    $aNewNames = array("silueta.jpg");
    $auxPrevPosition = array_values($data);
    $prevPosition = (int)$auxPrevPosition[0];
    
    //Primeramente se organizan los datos que llegan con el formulario. Habrá que incluir el nombre de la imagen (si es que se ha seleccionado una nueva)
    foreach ($data as $key => $value) {
        if (preg_match_all('!position!', $key, $result) ) {
            $position = (int)$value;
        } elseif (preg_match_all('!name!', $key, $result)) {
            $aNewNames[] = formatImageName($value)."-goya-2015.jpg";
        }
        
        if ($position !== $prevPosition) {
            if (($aNewValues[4] !== "-1") && ($aNewValues[1] !== "")) { //Si no trae nombre o el id = -1, entonces no se añade
                    //Falta el nombre de la foto en el array, que se extrae del fichero
                    addItemCsvArray($aFormattedData, $prevPosition, $aNewValues, $aOldNames, $aOldIds);
            }
            
            $prevPosition = $position;
            unset($aNewValues);
            $aNewValues = array();
        }
        $aNewValues[] = $value;
    }
    if (($aNewValues[4] !== "-1") && ($aNewValues[1] !== "")) {
        //Falta el nombre de la foto en el array, que se extrae del fichero
        addItemCsvArray($aFormattedData, $prevPosition, $aNewValues, $aOldNames, $aOldIds);
    }
    //Se limpian las carpetas. Todo lo que no esté en aNewNames será eliminado.
    cleanupFolder("../fotos/zoom/", $aNewNames);
    cleanupFolder("../fotos/", $aNewNames);
    
    return $aFormattedData;
}

function generateCsv($data, $delimiter = ',', $enclosure = '"') {
    
       $dataPath = $_SERVER["DOCUMENT_ROOT"] .'/los-goya-2015/alfombra-roja/data.csv';
       $handle = fopen($dataPath, 'r+');
       @ftruncate($handle, 0);
       foreach ($data as $line) {
               fputcsv($handle, $line, $delimiter, $enclosure);
       }
       fclose($handle);
       
       return true;
}

?>

