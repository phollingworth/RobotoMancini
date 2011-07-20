<?php

function getLastId()
{
	$id = file_get_contents('./status.txt', true);
	return $id;
}

function getQuote()
{
	$file = './quotes.txt';
	$fh = fopen($file, 'r');
	$lines = count(file($file));
	$randNum = rand(1, $lines);
	
	while ($line = fgets($fh)) 
	{
		$lineNum++;
		if ($lineNum == $randNum) 
		{
			return $line;
		}
	}
	
	fclose($fh);
}

function getUserNames($results)
{
	$users = array();
	$i = 0;
	
	foreach($results as $key)
	{
		$users[$i] = $results[$i]->user->screen_name;
		$i++;
	}
	
	return $users;
}

function fixLastId($results)
{
	$lastID = $results;
	$file = fopen("status.txt", 'w') or die("can't open file");
	fwrite($file, $lastID) or die("cant write");
	fclose($file);
	return $lastID;
}

?>