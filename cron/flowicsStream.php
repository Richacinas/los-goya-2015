<?php 
// Get total tweets in this minute
$xmlString = file_get_contents("http://live.flowics.com/api/1.1/widgets/7769/data/es.xml?api_token=B8HluJ5l90jeHEtImO5-rQ");
$xmlObject = simplexml_load_string($xmlString);
$totalTweets = $xmlObject->totalX;

// leemos el timeline
$timeline = json_decode(file_get_contents(dirname(__FILE__) . '/../data/totals.json'), true);
if(!$timeline) { // si no hay subtotales generamos el array
  $timeline = array('global' => array(), 'searchs' => array());
}

$beforeInitMinute = '02071929';
$initMinute = '02071930';

$time = date("mdHi");
if ($time === $beforeInitMinute) {
	$timeline['global'][$time] = $totalTweets;
} if ($time === $initMinute) {
	$beforeAlfombraTweets = $timeline['global'][$beforeInitMinute];
	$timeline['global'][$beforeInitMinute] = 0;
	$timeline['global'][$time] = $totalTweets - $beforeAlfombraTweets;
} else {
 	$diff = strtotime ( '-1 minute' , strtotime ( date("d/m/Y h:i:s") ));
	$lastTime = date('mdHi', $diff);

	$lastTweetsNumber = $timeline[$lastTime];
	$timeline['global'][$time] = $totalTweets - $lastTweetsNumber;
}
$timeline['global'][$time] = $totalTweets;

print(json_encode($timeline));
file_put_contents(dirname(__FILE__) . '/../data/totals.json', json_encode($timeline));
?>