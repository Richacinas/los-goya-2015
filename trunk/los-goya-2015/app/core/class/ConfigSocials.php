<?php

class ConfigSocials {
	private $config;
	private $log = array();

	public function __construct($saveData, $logFile) {
		// Config init
		if(file_exists($saveData)){
  			$this->config = MyConfig::read($saveData);
		} else {
  			$this->config = array('tw' => array(), 'ig' => array());
		}
		// Log init
		if(file_exists($logFile)){
  			$this->log = readJson($logFile);
		}
	}

	public function getConfig() {
		return $this->config;
	}
	public function setTwConfig($c) {
		$conf = $c->getConfig();
		$this->config['tw'] = $conf['tw'];
	}
	public function setIgConfig($c) {
		$conf = $c->getConfig();
		$this->config['ig'] = $conf['ig'];
	}

	public function getTweetsLastId() {
		if(isset($this->config['tw']['last'])) { 
			return $this->config['tw']['last'];
		}
		return;
	}
	public function getInstagramLastId() {
		if(isset($this->config['ig']['last'])) { 
			return $this->config['ig']['last'];
		}
		return;
	}
	public function setTweetsLastId($lastId) {
		$this->config['tw']['last'] = $lastId;
	}
	public function setInstagramLastId($lastId) {
		$this->config['ig']['last'] = $lastId;
	}
} // END of Config class

?>