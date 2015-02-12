<?php

//Se lee el fichero para obtener la parte de tagCount solamente. Lo demás llega en $_POST
$file_SearchTerms       = '../data/properties/searchTerms.json';
$jsonSearchTerms    = file_get_contents($file_SearchTerms);
$jsonSearchTerms_a  = json_decode($jsonSearchTerms, true);

$tags 		= $jsonSearchTerms_a['tags'];
$search 	= $jsonSearchTerms_a['search'];
$filter 	= $jsonSearchTerms_a['filter'];
$token          = $jsonSearchTerms_a['token'];
$tagCount       = $jsonSearchTerms_a['tagCount'];
$date           = time();


//CONTEO

$file_total     = 'final/total.json';
$jsonTotal      = file_get_contents($file_total);
$jsonTotal_a    = json_decode($jsonTotal, TRUE);

foreach($jsonTotal_a['data'] as $key=>$tweetElement){ 

    foreach ($tweetElement['tags'] as $index => $tag) {
        if ((array_search($tag, $search) != -1) && ($tag != "")) {
            $position = array_search($tag, $search);
            if ($tweetElement['type'] == 'img-small') {
                $tagCount[$position] += 0.25;
            } else {
                $tagCount[$position]++;
            }
        }
    }
}



//CONTEO



$array = array(
  'time'        => $date,
  'tags'        => $tags,
  'search'      => $search,
  'filter'      => $filter,
  'tagCount'    => $tagCount,
  'token'       => $token
);

// Codificamos el array en forma de JSON
$jsonSearchTerms = json_encode($array);


// Creamos el fichero JSON a partir de los datos del JSON
$fp = fopen('../data/properties/searchTerms.json', 'w');

fwrite($fp, $jsonSearchTerms);
fclose($fp);
//FIN

?>
