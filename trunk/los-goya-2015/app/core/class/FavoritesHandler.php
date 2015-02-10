<?php
require_once 'Favorite.php';

/**
 * Class to handle the set of favorites people decided by the Lab to be followed
 * @var array(Favorite) $favorites : list of Favorite objects
 * @var boolean $favoritesModified : true if favorites changes his appearances values
 * @var stdClass $appearancesData : structure with a relationship between ID and number of appearances of a Favorite
 *
 */
class FavoritesHandler
{
    
    /* Favorites CSV file path to be accessed */
    const FAVORITES_CSV = "/data/favorites/popular.csv";
    const FAVORITES_APPEARANCES = "/data/favorites/favorites-appearances.json";
    const DATA_CONTENTS_DIR = "/../../../data/";
    
    private $favorites;
    private $favoritesModified;
    private $appearancesData;
    
    /* PUBLIC METHODS */
    
    /**
     * Create and init FavoritesHandler object
     * @constructor
     *
     */
    public function __construct() {
        $this->favorites = $this->fetchFavorites();
        $this->favoritesModified = false;
    }
    
    /**
     * Get favorites appearances from streaming files and write them
     * into self::FAVORITES_APPEARANCES
     *
     */
    public function handleAppearancesInStreamingFiles() {
        
        // Filter time json files from data folder and get only their names
        $timeJsonFiles = $this->getDataTimeJsonFiles();
        // Count appearances from time json files
        $this->countAppearancesFromTimeJsonFiles($timeJsonFiles);
    }
    
    /**
     * Controls the appearance of favorites in a specific tweet
     * @param string $tweetText : tweet text to be checked
     *
     */
    public function handleAppearancesInTweet($tweetText) {
        $favoritesInTweet = array();
        foreach ($this->favorites as $favorite) {
            if ($this->isFavoriteInTweet($favorite, $tweetText)) {
                $this->increaseFavoriteAppearances($favorite);
                $this->favoritesModified = true;
            }
        }
        
        // Store final favorites with new appearances
        if ($this->favoritesModified) {
            $this->storeFavorites();
        }
    }
    
    /**
     * Increase a favorite person counter of appearances in tweets
     * @param Favorite $favorite : favorite person whome appearances counter will be increased
     *
     */
    public function increaseFavoriteAppearances($favorite) {
        
        // Increase counter for favorite ID
        $favorite->increateAppearances();
        
        // Saving favorite in favorites param list
        $this->saveFavorite($favorite);
    }
    
    /* PRIVATE METHODS */
    
    private function checkAppearancesIntoFileTweets($fileTweets) {
        foreach ($fileTweets as $tweetIndex => $tweet) {
            $tweetText = $tweet->text;print("<pre>");
            $this->handleAppearancesInTweet(utf8_decode($tweetText));
        }
    }
    
    /**
     * Checks if some of search terms of a favorite appear in a tweet
     * @param array(string) $searchTerms : list of terms to search
     * @param string $tweetText : tweet text to be compared
     *
     */
    private function checkFavoriteSearchTermsInTweet($searchTerms, $tweetText) {
        foreach ($searchTerms as $term) {
            if (strpos($tweetText, $term) !== false) {
                return true;
            }
        }
        return false;
    }
    
    private function countAppearancesFromTimeJsonFiles($timeJsonFiles) {
        foreach ($timeJsonFiles as $fileIndex => $filename) {
            $baseDataRoot = dirname(__FILE__).self::DATA_CONTENTS_DIR;
            // Read time json file
            $fileStream = file_get_contents($baseDataRoot.$filename);
            $fileContents = json_decode($fileStream);
            // Get tweets from json file
            $fileTweets = $fileContents->search;
            // Check appearances into tweets
            $this->checkAppearancesIntoFileTweets($fileTweets);
        }
    }
    
    /**
     * Gets an array with the Favorite person data from a CSV line
     * @param string $line: line text from the CSV corresponding to a person
     * @return array : mixed array with the favorite data already ordered
     *
     */
    private function getCSVLineData($line) {
        $lineArray = explode(";", $line);
        $id = trim($lineArray[0]);
        $name = trim($lineArray[1]);
        $image = trim($lineArray[2]);
        $search = explode(",", trim($lineArray[3]));
        $twitterField1 = explode(",", trim($lineArray[4]));
        $twitterField2 = explode(",", trim($lineArray[5]));
        $twitter = array_merge($twitterField1, $twitterField2);
        $instagram = explode(",", trim($lineArray[6]));
        return array($id, $name, $image, $search, $twitter, $instagram);
    }

    private function getDataTimeJsonFiles() {
        $dataContents = scandir(dirname(__FILE__).self::DATA_CONTENTS_DIR);
        $timeJsonFiles = array();
        foreach ($dataContents as $fileIndex => $file) {
            if ($this->isTimeJsonFile($file)) {
                $timeJsonFiles[] = $file;
            }
        }
        return $timeJsonFiles;
    }
    
    /**
     * Gets a favorite person from a CSV line given
     * @param string $line : line to be parsed to get the Favorite object
     * @return Favorite $person : Favorite object created from a CSV line
     *
     */
    private function getFavoriteFromLine($line) {
        
        // Get CSV line data
        $lineArray = $this->getCSVLineData($line);
        
        // Create person object
        $person = new Favorite($lineArray[0], $lineArray[1], $lineArray[2], $lineArray[3], $lineArray[4], $lineArray[5], 0);
        return $person;
    }
    
    /**
     * Gets the number of appearances of the favorite ID
     *
     */
    private function getNumberOfAppearancesOfFavorite($favoriteId) {
        foreach ($this->appearancesData as $i => $appearancesObject) {
            if ((int)$favoriteId === $appearancesObject->id) {
                return $appearancesObject->total;
            }
        }
        return 0;
         // no appearances of the favorite
        
    }
    
    /** 
     * Get favorites from stored data (CSV and JSON files)
     * @return array(Favorite) : list of favorites founded in the CSV
     *
     */
    private function fetchFavorites() {
        $csvData = file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/los-goya-2015" . self::FAVORITES_CSV);
        file_put_contents('myfamous.log',$csvData);
        
        $this->appearancesData = json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/los-goya-2015" . self::FAVORITES_APPEARANCES));
        $popularPeopleCSVLines = explode(PHP_EOL, $csvData);
        $people = array();
        foreach ($popularPeopleCSVLines as $i => $line) {
            if ($i !== 0) {
                 // CSV header is not including as person object
                $favorite = $this->getFavoriteFromLine($line);
                
                // Add appearances of favorite
                $appearances = $this->getNumberOfAppearancesOfFavorite($favorite->getId());
                $favorite->setAppearances($appearances);
                
                // Saving person object
                array_push($people, $favorite);
            }
        }
        return $people;
    }
    
    /**
     * Checks if a favorite person appears in a tweet text
     * @param: Favorite $favorite : favorite person object to check
     * @param: string $tweetText : text container in which the favorite person will be searched for
     *
     */
    private function isFavoriteInTweet($favorite, $tweetText) {
        
        // Gets favorite search terms
        $searchTerms = $favorite->getSearchTerms();
        
        // Checks if favorite search terms appear in the tweet
        return $this->checkFavoriteSearchTermsInTweet($searchTerms, $tweetText);
    }

    private function isTimeJsonFile($file) {
        $fileParts = explode(".", $file);
        $filename = $fileParts[0];
        $extension = $fileParts[sizeOf($fileParts) - 1];
        return ($extension === 'json' && $filename !== 'timeline' && $filename !== 'totals');
    }
    
    /**
     * Method to update appearances in class parameter for a favorite
     * @param Favorite $favorite : favorite person to update
     *
     */
    private function saveAppearances($favorite) {
        foreach ($this->appearancesData as $i => $appearancesElem) {
            if ($appearancesElem->id == $favorite->getId()) {
                $this->appearancesData[$i]->total = $favorite->getAppearances();
            }
        }
    }
    
    /**
     * Saves a favorite in the list of favorites
     * @param Favorite $favorite : favorite to be saved
     *
     */
    private function saveFavorite($favorite) {
        foreach ($this->favorites as $i => $savedFavorite) {
            if ($savedFavorite->getId() == $favorite->getId()) {
                $this->favorites[$i] = $favorite;
                $this->saveAppearances($favorite);
                return;
            }
        }
    }
    
    /**
     * Stores the favorites list to the favorites into the appearances json file
     *
     */
    private function storeFavorites() {
        $appearancesJson = json_encode($this->appearancesData);
        echo "APPEARANCES JSON WRITING.... \n\n\n";
        var_dump($appearancesJson);
        $fd = fopen($_SERVER['DOCUMENT_ROOT'] . "/los-goya-2015" . self::FAVORITES_APPEARANCES, 'w');
        fwrite($fd, $appearancesJson);
        fclose($fd);
    }
    
    /* GETTERS AND SETTERS */
    public function getFavorites() {
        return $this->favorites;
    }
}
?>