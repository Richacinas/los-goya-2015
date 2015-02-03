<?php

require_once 'ConfigSocials.php';

class TWREST {
	private $config;
	private $newTweets;

	public function __construct($saveData, $logFile) {
		$this->config = new ConfigSocials($saveData, $logFile);
		$this->twData['search'] = array();
		$this->newTweets = true;
	}

	public function getTimeline() {
		// Buscamos archivo de configuraciones y si no lo iniciamos de 0
		$lastId = $this->config->getTweetsLastId();
		/* GET home_timeline tweets(200 tweets/retweets) since "max_id" tweet as the first one */
		return getTwitterTimeline($lastId);
	}

	public function saveLastTweet($twTimeline) {
		$this->config->setTweetsLastId($twTimeline[0]->id_str);
	}

	public function filterTweets($twTimeline, $search) {
  		foreach ($twTimeline as $num => $tweet) {
    		$this->twAddUsr($tweet->user);
    		$tweetOk = processTweet($tweet); // processTweet from socialTwitter.php
    		$result = $this->tweetContainsSearchTerms($tweetOk, $search);
    		if ($result['found']) {
    			array_push($this->twData['search'], $result['tweetOk']);
    		}
  		}
	}

	private function tweetContainsSearchTerms($tweet, $search) {
    	// buscamos nuestras palabras en el tweet
    	for ($i=0; $i < count($search); $i++) { 
        	// divide tags compuestos -> podemos hacerlo fuera una sola vez
      		$arrayTags = explode(',', $search[$i]);
        	// busca cada cadena y procesa el tweets
      		for ($j=0; $j < count($arrayTags); $j++) {
        		if ($this->isTagInTweet($tweet['text'], $arrayTags[$j])) {
        			// encontrado!!
        			if(!isset($tweet['tags'])) $tweet['tags'] = array();
        				array_push($tweet['tags'], $arrayTags[$j]);
          				return array('found'=>true, 'tweetOk'=>$tweet);
        		}
      		}
    	}
    	return array('found'=>false, 'tweetOk'=>$tweet);
	}

	public function processTimeline($twTimeline, $search) {
		$this->filterTweets($twTimeline, $search);
		if(count($twTimeline) > 0) {
			$this->saveLastTweet($twTimeline);
			print('Procesados '.count($twTimeline).' tweets.'.PHP_EOL);
		} else {
  			$this->newTweets = false;
  			print('Ningun tweet nuevo.'.PHP_EOL);
		}
	}

	public function newTweetsProcessed() {
		return $this->newTweets;
	}

	private function twAddUsr($user){
  		if(!isset($GLOBALS["data"]['users'][$user->id_str])) {
    		$userOk = processTwUser($user);
    		$GLOBALS["data"]['users'][$user->id_str] = $userOk;
  		}
	}

	private function isTagInTweet($tweet, $text) {
  		if(stripos($tweet, $text) !== false) { return true; }
  		return false;
	}

	public function getTwData() {
		return $this->twData;
	}
	public function getConfig() {
		return $this->config;
	}
}// END TWREST class

?>