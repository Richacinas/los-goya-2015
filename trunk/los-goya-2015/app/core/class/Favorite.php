<?php
	/**
	* Class to define a favorite person to search in social posts
	* @var int $id : favorite identificator
	* @var string name Person name to show
	* @var string image: Person image/photo to show
	* @var array(string) searchTerms : Array of terms to search in the posts
	* @var array(URL) twitter : Array of string twitter URLs related to the person
	* @var array(URL) instagram : Array of string instagram URLs related to the person
	* @var int $appearances : number of appearances of favorite in tweets
	*/
	class Favorite {
		private $id;
		private $name;
		private $image;
		private $searchTerms;
		private $twitter;
		private $instagram;
		private $appearances;

		/**
		* Creates a Favorite object
		* @constructor
		* @param int $id : favorite identificator
		* @param string $name : favorite person name
		* @param string $image : favorite person image URL
		* @param array(string) $searchTerms : list of terms to search corresponding to the favorite person name/username
		* @param array(string) $twitter : list of twitter URLs
		* @param array(string) $instagram : list of instagram URLs
		* @param int $appearances : number of appearances of favorite in tweets
		**/
		public function __construct($id, $name, $image, $searchTerms, $twitter, $instagram, $appearances) {
			$this->id = $id;
			$this->name = $name;
			$this->image = $image;
			$this->searchTerms = $searchTerms;
			$this->twitter = $twitter; // List of twitter urls
			$this->instagram = $instagram; // List of instagram urls
			$this->appearances = $appearances;
			// Extra actions
			$this->cleanEmptySocialUrls();
			$this->cleanEmptySearchTerms();
		}

		/**
		* Increases the appearances of the favorite person in tweets checked
		**/
		public function increateAppearances() {
			$this->appearances++;
		}

		/**
		 * Method to clean empty social urls from social arrays (TW and IG)
		**/
		private function cleanEmptySocialUrls() {
			foreach($this->twitter as $i=>$twUrl) {
				if ($twUrl === "") {
					unset($this->twitter[$i]);
				}
			}
			foreach($this->instagram as $i=>$igUrl) {
				if ($igUrl === "") {
					unset($this->instagram[$i]);
				}
			}
		}

		/**
		 * Method to clean empty positions of the searth terms array
		**/
		private function cleanEmptySearchTerms() {
			foreach($this->searchTerms as $i=>$term) {
				if ($term === "") {
					unset($this->searchTerms[$i]);
				}
			}
			$this->addNameToSearchTerms();
			$this->addTwitterUsernameToSearchTerms();
		}

		/**
		 * Method to add person Name recovered to the search terms
		**/
		private function addNameToSearchTerms() {
			array_push($this->searchTerms, $this->name);
		}

		/**
		 * Method to add twitter username recovered from twitter urls to the search terms
		**/
		private function addTwitterUsernameToSearchTerms() {
			$twUsernames = $this->getTwitterUsername();
			foreach ($twUsernames as $username) {
				array_push($this->searchTerms, $username);
			}
		}

		/**
		* Gets the twitter username from twitter user URL
		**/
		private function getTwitterUsername() {
			$twUsernames = array();
			foreach($this->twitter as $twUrl) {
				$urlArray = explode("/", $twUrl);
				array_push($twUsernames,  $urlArray[sizeOf($urlArray)-1]);
			}
			return $twUsernames;
		}

		/**
		 * GETTERS AND SETTERS
		**/

		public function getId() {
			return $this->id;
		}
		public function setId($id) {
			$this->id = $id;
		}

		public function getName() {
			return $this->name;
		}
		public function setName($name) {
			$this->name = $name;
		}

		public function getImage() {
			return $this->image;
		}
		public function setImage($image) {
			$this->image = $image;
		}

		public function getSearchTerms() {
			return $this->searchTerms;
		}
		public function setSearchTerms($searchTerms) {
			$this->searchTerms = $searchTerms;
		}

		public function getTwitter() {
			return $this->twitter;
		}
		public function setTwittter($twitter) {
			$this->twitter = $twitter;
		}

		public function getInstagram() {
			return $this->instagram;
		}
		public function setInstagram($instagram) {
			$this->instagram = $instagram;
		}

		public function getAppearances() {
			return $this->appearances;
		}
		public function setAppearances($appearances) {
			$this->appearances = $appearances;
		}
	}
?>