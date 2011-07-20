<?php

//load files
session_start();
require_once('twitteroauth/twitteroauth.php');
require_once('config.php');
require_once('searchterm.php');
require_once('utilities.php');

$isSearching = false;

/* Create a TwitterOauth object with consumer/user tokens. */
$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, ACCESS_TOKEN, ACCESS_TOKEN_SECRET);
$content = $connection->get('account/verify_credentials');


//Should I search tweets for mentions?
if($isSearching)
{
	$term = getSearchTerm();
	$stuff = $connection->get('http://search.twitter.com/search.json', array('q' => "{$term}", 'rpp' => '100'))->results;
}
else
{
	$lastStatusId = getLastId();
	$screenNames = array();
	
	//just reply to status mentions
	$stuff = $connection->get('https://api.twitter.com/statuses/mentions.json', array('since_id' => $lastStatusId));

	for($i = 0; $i < count($stuff); $i++)
	{
	    if($stuff->id[$i] > $lastStatusId)
	    {
	      $lastID = fixLastId($stuff);
	      array_push($screenNames, $stuff[$i]->user->screen_name);

	    }
	}
	
	foreach($screenNames as $key)
	{

		$msg = "@$key " . getQuote();
		//$connection->post('statuses/update', array('status' => $msg));
		echo $msg . "ID = " . $lastID . "Thing = " . $test . "\n";
	}
	

      echo $lastID;
}

/* Include HTML to display on the page */
//include('html.inc');
