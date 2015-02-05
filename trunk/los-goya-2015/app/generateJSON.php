<?php

$tags 		= $_POST["tags"];
$search 	= json_decode($_POST["search"]);
$filter 	= json_decode($_POST["filter"]);
$token          = $_POST["token"];

/*

// Visualizacion de los valores
// ---------------------------------------------------------

print_r("<br />Tags: " . $tags);
print_r("<br />Search: ");

foreach( $search as $value) { 

	print_r("<br />" . $value);
}

print_r("<br />Filter: ");

foreach( $filter as $value) { 

	print_r("<br />" . $value);
}

*/

// Obtenemos la fecha del sistema
$date = time();

// Creamos el array que sirve de base para generar el JSON con los datos con los siguientes datos
// + time: Fecha de creacion del fichero JSON (sirve para comprobar si hay nuevos datos)
// + tags: Listado de los tags/etiquetas
// + search: Listado de los diferentes terminos de busqueda (se filtran para eliminar los vacios)
// + filter: Listado de los diferentes terminos de busqueda que estan activos

$array = array(
  'time' => $date,
  'tags' => explode(", ", $tags),
  'search' => array_filter($search),
  'filter' => $filter,
  'token' => $token
);

// Codificamos el array en forma de JSON
$jsonSearchTerms = json_encode($array);


// Visualizacion de los valores
// ---------------------------------------------------------
print_r($jsonSearchTerms);


// Creamos el fichero JSON a partir de los datos del JSON
$fp = fopen('../data/properties/searchTerms.json', 'w');

fwrite($fp, $jsonSearchTerms);
fclose($fp);

/* Redirigir navegador */
header('Location:twtprocess.php?method=update');

exit;
?>