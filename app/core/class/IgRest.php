<?php

require_once './Config.php';

class IGREST {
	private $igData; // Tweets data result
	private $config;
	private $newIgPosts;

	public function __construct($saveData, $logFile) {
		$this->config = new Config($saveData, $logFile);
		$this->igData['search'] = array();
		$this->newIgPosts = true;
	}

	public function getTimeline() {
		// Buscamos archivo de configuraciones y si no lo iniciamos de 0
		$lastId = $this->config->getInstagramLastId();
		/* GET home_timeline tweets(200 tweets/retweets) since "max_id" tweet as the first one */
		return getInstagramTimeline($lastId);
	}

	public function saveLastInstagramPost($igTimeline) {
		// guardo el último para próximos envios
  		if(isset($igTimeline->pagination->next_max_id)){
    		$lastId = $igTimeline->pagination->next_max_id;
  		} elseif(count($response->data)){
    		$lastId = $igTimeline->data[0]->id;
  		}
		$this->config->setInstagramLastId($lastId);
	}

	public function filterPosts($igTimeline, $search) {
  		foreach ($igTimeline->data as $photo) {
    		$this->igAddUsr($photo->user);
    		$photoOK = processIg($photo); // function from socialInstagram
    		if(isset($photo->caption)) {
    			$result = $this->igPostContainsText($photo, $photoOK, $search);
		    	// guardamos el eleemento
      			array_push($this->igData['search'], $result['photoOk']);
    		} else {
    			// no tiene texto
      			array_push($this->igData['search'], $photoOK);
    		}
  		}
	}

	private function igPostContainsText($photo, $post, $search) {
    	$found = false;
    	// buscamos nuestras palabras en el post
   		for ($i=0; $i < count($search); $i++) {
        	// divide tags compuestos -> podemos hacerlo fuera una sola vez
        	$arrayTags = explode(',', $search[$i]);
            // busca cada cadena y procesa el post
        	for ($j=0; $j < count($arrayTags); $j++) {
          		if (isTagInTweet($photo->caption->text, $arrayTags[$j])) {
          			// encontrado!!
            		if(!isset($post['tags'])) $post['tags'] = array();
            		array_push($post['tags'], $arrayTags[$j]);
            		$found = true;
          		}
        	}
      	}
    	return array('found'=>$found, 'photoOk'=>$post);
	}

	public function processTimeline($igTimeline, $search) {
		$this->filterPosts($igTimeline, $search);
		if(count($igTimeline->data)) {
			$this->saveLastInstagramPost($igTimeline);
			print('Procesados '.count($igTimeline->data).' imagenes de Instagram.'.PHP_EOL);
		} else {
  			$this->newIgPosts = false;
  			print('Ninguna imagen nueva de Instagram.'.PHP_EOL);
		}
	}

	public function newIgPostsProcessed() {
		return $this->newIgPosts;
	}

	public function igAddUsr($user) {
  		if(!isset($GLOBALS["data"]['users'][$user->id])) {
    		$userOk = processIgUser($user);
    		$GLOBALS["data"]['users'][$user->id] = $userOk;
  		}
	}

	public function getIgData() {
		return $this->igData;
	}
	public function getConfig() {
		return $this->config;
	}
}// END IGREST class

?>