<?php
	/**
	* Class to define a favorite person to search in social posts
	* @param string name Person name to show
	* @param string image: Person image/photo to show
	* @param array(string) searchTerms : Array of terms to search in the posts
	* @param array(URL) twitter : Array of string twitter URLs related to the person
	* @param array(URL) instagram : Array of string instagram URLs related to the person
	*/
	class Person {
		private $name;
		private $image;
		private $searchTerms;
		private $twitter;
		private $instagram

		public function __construct($name, $image, $searchTerms, $twitter, $instagram) {
			$this->name = $name;
			$this->image = $image;
			$this->searchTerms = $searchTerms;
			$this->twitter = $twitter; // List of twitter urls
			$this->instagram = $instagram; // List of instagram urls
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
	}
?>