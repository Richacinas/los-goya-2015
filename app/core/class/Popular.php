<?php

require_once 'Person.php';

class FavoritesHandler {

	private favorites;

	public function __construct() {
		$this->favorites = $this->getPopularPeopleFromCSV();
	}

	/* Get CSV of favorite people file data */
	public function getPopularPeopleFromCSV ($filePath) {
		$csvData = file_get_contents($filePath);
		$popularPeopleCSVLines = explode(PHP_EOL, $csvData);
		$people = array();
		foreach ($popularPeopleCSVLines as $i=>$line) {
    		if ($i !== 0) { // CSV header is not including as person object
    			// Get CSV line data
    			$lineArray = explode(";", $line);
    			$name = trim($lineArray[0]);
    			$image = trim($lineArray[1]);
    			$search = explode(",", trim($lineArray[2]));
    			$twitter = array_merge(explode(",", trim($lineArray[3])), explode(",", trim($lineArray[4])) );
    			$instagram = explode(",", trim($lineArray[5]));
    			// Creat person object
    			$person = new Person($name, $image, $search, $twitter, $instagram);
    			// Saving person object
    			array_push($people, $person);
	    	}
		}
		return $people;
	}
}

?>